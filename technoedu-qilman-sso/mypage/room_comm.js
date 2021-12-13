var URL = window.URL || window.webkitURL;

var g_displayName = '2000';
var g_privateIdentity = '2000';
var g_publicIdentity = 'sip:2000@'+g_sipSvrUrl;
var g_password = null;
var g_realm = g_sipSvrUrl;
var g_callControl = '0901000@'+g_sipSvrUrl;
var g_webSocketServerURL = g_webrtc2sipSvrUrl;

var videoRemote, videoLocal, audioRemote, noVideoCanvas;
var bFullScreen = false;
var bDisableVideo = false;
var oReadyStateTimer;

var uaMain = null;
var sessionMain = null;
var sessionMainStateus = 'none';
var cameraList = new Array(); 
var curCameraSel = 0;

var saveAudioId = window.localStorage.getItem('wsmedia.audio_src_id');
var saveVideoId = window.localStorage.getItem('wsmedia.video_src_id');

function createMainUA(callerURI, displayName) {
    // https://stackoverflow.com/questions/7944460/detect-safari-browser
    var browserUa = navigator.userAgent.toLowerCase();
    var isSafari = false;
    var isFirefox = false;
    if (browserUa.indexOf("safari") > -1 && browserUa.indexOf("chrome") < 0) {
        isSafari = true;
    }
    else if (browserUa.indexOf("firefox") > -1 && browserUa.indexOf("chrome") < 0) {
        isFirefox = true;
    }

    // add by scchoi
    wsModifier = function(description) {
        if ( description.type == "offer" )
        {
            /*
            var bundles = sdp.match(/a=group:BUNDLE (.*)?\r\n/);
            if(bundles){
                if(bundles[1]){
                    bundles = bundles[1].split(" ");
                }
            }
            */

            description.sdp = description.sdp.replace("a=group:BUNDLE 0 1", "a=group:BUNDLE audio video");
            description.sdp = description.sdp.replace("a=mid:0", "a=mid:audio");
            description.sdp = description.sdp.replace("a=mid:1", "a=mid:video");
            //description.sdp = description.sdp.replace(/^.*abs-send-time\r\n/m,"");

        }
        else {
            //description.sdp = description.sdp.replace("m=audio","a=group:BUNDLE audio video\r\nm=audio");
            description.sdp = description.sdp.replace("profile-level-id=4d 032","profile-level-id=4d0032");
            //description.sdp = description.sdp.replace(/^.*abs-send-time\r\n/m,"");
        }
        
        return Promise.resolve(description);
    }


    var sessionDescriptionHandlerFactoryOptions = {};
    sessionDescriptionHandlerFactoryOptions.modifiers = [wsModifier];

    if (isFirefox) {
        sessionDescriptionHandlerFactoryOptions.alwaysAcquireMediaFirst = true;
    }

    var configuration = {
        uri: callerURI,
        authorizationUser: g_privateIdentity,
        password: g_privateIdentity,
        displayName: displayName,
        // Undocumented "Advanced" Options
        userAgentString: "Mentorservice",
        register: true,
        contactName: g_privateIdentity,
        sessionDescriptionHandlerFactoryOptions: sessionDescriptionHandlerFactoryOptions,
        transportOptions: {
            traceSip: true,
            wsServers: g_webSocketServerURL
        }
    };
    var userAgent = new SIP.UA(configuration);
    return userAgent;
}

function setupRemoteMedia() {
    // If there is a video track, it will attach the video and audio to the same element
    var pc = sessionMain.sessionDescriptionHandler.peerConnection;
    var remoteStream;
    if (pc.getReceivers) {
        remoteStream = new MediaStream();
        pc.getReceivers().forEach(function (receiver) {
            var track = receiver.track;
            if (track) {
                remoteStream.addTrack(track);
            }
        });
    }
    else {
        remoteStream = pc.getRemoteStreams()[0];
    }

    videoRemote.srcObject = remoteStream;

    videoRemote.play().catch(function () {
        console.log("play was rejected");
        alert("play was rejected");
    });
};

function setupLocalMedia() {
    if (videoLocal) {
        var pc = sessionMain.sessionDescriptionHandler.peerConnection;
        var localStream_1;
        if (pc.getSenders) {
            localStream_1 = new MediaStream();
            pc.getSenders().forEach(function (sender) {
                var track = sender.track;
                if (track && track.kind === "video") {
                    localStream_1.addTrack(track);

                    const parameters = sender.getParameters();
                    if ( !parameters.encodings) {
                        parameters.encodings = [{}];
                    }
                    parameters.encodings[0].maxBitrate = 1024 * 1000; // 1Mbps
                    parameters.encodings[0].networkPriority = "high";
                    parameters.encodings[0].priority = "high";
                    sender.setParameters(parameters)
                    .then(() => {
                        console.log(parameters);
                    })
                    .catch( function(e) {
                            console.error(e);
                            alert('SetupLocalMedia Err: ' + e);
                    });
                }
            });
        }
        else {
            localStream_1 = pc.getLocalStreams()[0];
        }
        videoLocal.srcObject = localStream_1;
        videoLocal.volume = 0;
        videoLocal.play();
    }
};

function makeCall(userAgent, target, remoteRender, localRender, devices, canvasNoVideo) {
    var videoDeviceFind = false;
    var audioDeviceFind = false;
    var canvasSteram, audioStream;
    var audioOption = true;
    var videoInputCnt = 0;

    devices.forEach(function(device) {
        console.log(device.kind + ": " + device.label + " id = " + device.deviceId);
        if ( device.kind === "videoinput" ) {
            if ( saveVideoId && saveVideoId === device.deviceId) {
                curCameraSel = videoInputCnt;
            }

            cameraList.push(device);
            videoDeviceFind = true;
            videoInputCnt++;
        }
        if ( device.kind === "audioinput" ) {
            audioDeviceFind = true;
            if ( saveAudioId && saveAudioId === device.deviceId) {
                audioOption = { deviceId: {exact: device.deviceId }}; 
            }
        }
    });

    console.log("VideoInput:"+videoDeviceFind+", AudioDevice:"+audioDeviceFind);
    
    if ( videoDeviceFind == false ) {
        canvasSteram = canvasNoVideo.captureStream();
    }

    if ( audioDeviceFind == false ) {
        const aCtx = new AudioContext();
        audioStream = aCtx.createMediaStreamDestination().stream;
    }

    console.log("test");
    
    var videoOption = videoDeviceFind ? {
                        width: 640,
                        height: 480,
                        frameRate: 30,
                        deviceId: {exact: cameraList[curCameraSel].deviceId} 
                    } : false;

/*
    var videoOption = videoDeviceFind ? {
                        width: { min: 640, ideal: 640, max:1280 },
                        height: { min: 360, ideal: 360, max:720 },
                        frameRate: { ideal: 24, max:30 },
                        deviceId: {exact: cameraList[curCameraSel].deviceId} 
                    } : false;
*/
    // makes the call
    var options = { 
        sessionDescriptionHandlerOptions: {
            constraints: {
                audio: audioOption,
                video: videoOption,
                videoCanvas: {
                    canvasAsVideo: !videoDeviceFind,
                    canvasStream: canvasSteram 
                },
                audioFileStream: {
                    audioAsFileStream: !audioDeviceFind,
                    audioStream: audioStream
                }
            },
            RTCOfferOptions: {
                offerToReceiveAudio: true,
                offerToReceiveVideo: true,
            },
        }
    };

    console.log("invite.option:");
    console.log(options);

    var modifierArray = [];
    sessionMain = userAgent.invite('sip:' + target, options, modifierArray );

    sessionMainStateus = 'inviting';
    sessionMain.on('accepted', function () {
        if (remoteRender) {
            remoteRender.autoplay = true;
        }

        setupLocalMedia();
        setupRemoteMedia();

        sessionMainStateus = 'accepted';
        console.log("Accept!\n");

        $('#loading').hide();

        // Accept 이후에 약간의 시간 타임 이후에 보냄(너무 빨리 refresh되면 화면에 표시가 안되는 경우가 있음)

        // sykim 2021.7.15 - canvas 테스트 중
        setTimeout(function() {
                var ctx = canvasNoVideo.getContext("2d");
//                ctx.beginPath();
//                ctx.rect(0, 0, 320, 180);
//                ctx.fillStyle = "black";
//                ctx.fill();

               
                var nocamImg = new Image();
                //nocamImg.src = "/images/nocamera.png";
                nocamImg.onload = function() {

                // normal image
                ctx.drawImage(nocamImg, 0,0);

                // image rotation
                //ctx.translate(canvasNoVideo.width/2, canvasNoVideo.height/2);
                //ctx.rotate(Math.PI);
                //ctx.drawImage(nocamImg, -nocamImg.width/2, -nocamImg.height/2);
                //ctx.rotate(-Math.PI);
                //ctx.translate(-canvasNoVideo.width/2, -canvasNoVideo.height/2);

            };
                nocamImg.src = "nocamera.png";
        }, 1500);
    });

    sessionMain.on('bye', function () {
        sessionMain = null;
        sessionMainStateus = 'none';	
            console.log("Main:Bye Receive!\n");

            $('#loading').hide();

            onSipDisconnectFunc();  // endfunc
   });

    // JEONG 20200612 for error message
    //sessionMain.on('failed', function (request) {
    sessionMain.on('failed', function (response, cause) {
            
            $('#loading').hide();

            if ( cause == SIP.C.causes.NOT_FOUND )
            {
            /*
            $.post('../mcutest/mcucomm.php', {
                    cmd: 'CreateConference' ,
                    name: '',
                    did: '',
                    mixerId: 'mixer',
                    profileId: 'HD',
                    compType: '4',
                    vad: '0',
                    size: 
                    
                    }
                ).done{
                    function( data ) {
                        alert(data);
            */
                alert("방을 찾을 수 없습니다 (404 Not Found)");
                
            }
            else if ( cause == SIP.C.causes.REJECTED )
            {
                alert("접속 거절 (403 Rejected)");
            }
            else if ( cause == SIP.C.causes.BUSY )
            {
                alert("통화중 (486 Busy)");
            }
            else if ( cause == SIP.C.causes.UNAVAILABLE )
            {
                alert("접속 불가 (408 Unavailable)");
            }
            else if ( cause == SIP.C.causes.INCOMPATIBLE_SDP )
            {
                alert("SDP 오류 (488 Incompatible SDP)");
            }
            else if ( cause == SIP.C.causes.AUTHENTICATION_ERROR )
            {
                alert("인증 실패 (401 Authentication Error)");
            }
            else
            {
                alert('접속 실패 (Connection Failed) Code: ' + cause);
            }
   });
}

var onMainRegistered = function () {
	console.log("Main UA Regiseterd Content!!");
    videoLocal = document.getElementById("video_local");
    videoRemote = document.getElementById("video_remote");
    noVideoCanvas = document.getElementById("video_canvas");

    if ( sessionMainStateus == 'none' ) {
        if (!navigator.mediaDevices || !navigator.mediaDevices.enumerateDevices) {
            alert("미디어 디바이스를 브라우저가 지원하지 않습니다.");
            return;
        }
        navigator.mediaDevices.enumerateDevices()
            .then(function(devices) {
                makeCall(uaMain, g_callControl, videoRemote, videoLocal, devices, noVideoCanvas);
            })
    }
};

function setMCUInfo(did, userName, userID, pw) {
//function setMCUInfo(did, userName, userID, pw, mcuip) {

    //g_sipSvrUrl = mcuip;    // JEONG 20210209 direct connect to mcu server
    //g_webrtc2sipSvrUrl = "wss://121.159.74.222:9090";
    //g_webSocketServerURL = "wss://121.159.74.222:9090";

    g_displayName = userName;
    g_privateIdentity = userID;
    g_password = pw;
    g_publicIdentity = 'sip:'+userID+'@'+g_sipSvrUrl;
    g_callControl = did+'@'+g_sipSvrUrl;
    //g_publicIdentity = 'sip:'+userID+'@'+mcuip;
    //g_callControl = did+'@'+mcuip;
}

function setVideoRatioWide()
{
	//window.localStorage.setItem('com.wooksung.expert.video_size','{ minWidth:640, minHeight:360, maxWidth:640, maxHeight:360}');
}

// 초기화 후 방에 참석함
function sipRegister() {
    uaMain = createMainUA(g_publicIdentity, g_displayName);
    uaMain.on('registered', onMainRegistered);
}

// terminates the call (SIP BYE or CANCEL)
function sipHangUp() {
    if ( sessionMain != null ) {
        sessionMain.bye();
    }
}

function toggleFullScreen() {
    if (videoRemote.webkitSupportsFullscreen) {
        fullScreen(!videoRemote.webkitDisplayingFullscreen);
    }
    else {
        fullScreen(!bFullScreen);
    }
}

function switchCamera() {
    if ( cameraList.length <= 1 ) return; // 카메라가 한개이하인 경우 무시

    curCameraSel = (curCameraSel + 1) % cameraList.length;

    console.log("curCameraSet: "+curCameraSel);

    var videoOption = {
                        width: { min: 640, ideal: 640, max:1280 },
                        height: { min: 360, ideal: 360, max:720 },
                        frameRate: { ideal: 24, max:30 },
                        deviceId: {exact: cameraList[curCameraSel].deviceId} 
                    };

    var constraints = {
                audio: false,
                video: videoOption,
            };

    var pc = sessionMain.sessionDescriptionHandler.peerConnection;
    console.log(constraints);

    navigator.mediaDevices.getUserMedia(constraints)
    .then(function(stream){
            videoLocal.srcObject = stream;
            let videoTrack = stream.getVideoTracks()[0];
            var sender = pc.getSenders().find(function(s) {
                return s.track.kind == videoTrack.kind;
            });
            console.log("replaceTrack!!");
            console.log(videoTrack);
            sender.replaceTrack(videoTrack);
     })
    .catch(function(e) { 
        console.log("SwitchCamera Err: "+e);
        alert('SwitchCamera Err: ' + e);
    });

}

function selectCamera(index) {
    if ( cameraList.length <= 1 ) return; // 카메라가 한개이하인 경우 무시

    var videoOption = {
                        width: { min: 640, ideal: 640, max:1280 },
                        height: { min: 360, ideal: 360, max:720 },
                        frameRate: { ideal: 24, max:30 },
                        deviceId: {exact: cameraList[index].deviceId} 
                    };

    var constraints = {
                audio: false,
                video: videoOption,
            };

    var pc = sessionMain.sessionDescriptionHandler.peerConnection;
    console.log(constraints);

    navigator.mediaDevices.getUserMedia(constraints)
    .then(function(stream){
            videoLocal.srcObject = stream;
            let videoTrack = stream.getVideoTracks()[0];
            var sender = pc.getSenders().find(function(s) {
                return s.track.kind == videoTrack.kind;
            });
            console.log("replaceTrack!!");
            console.log(videoTrack);
            sender.replaceTrack(videoTrack);
     })
    .catch(function(e) { 
        console.log("SelectCamera Err: "+e);
        alert('SelectCamera Err: ' + e);
    });
}

function muteMedia( isAudio, isMute ) {
    if ( sessionMain ) {
        var pc = sessionMain.sessionDescriptionHandler.peerConnection;
        if (pc.getSenders) {
            pc.getSenders().forEach(function (sender) {
                if (sender.track) {
                    if (sender.track.kind === "video" && (isAudio == false)) {
                        sender.track.enabled = !isMute;
                    }
                    else if (sender.track.kind === "audio" && (isAudio == true)) {
                        sender.track.enabled = !isMute;
                    }
                }
            });
        }
        else {
            pc.getLocalStreams().forEach(function (stream) {
                if ( isAudio == true ) {
                    stream.getAudioTracks().forEach(function (track) {
                        track.enabled = !isMute;
                    });
                }
                else if ( isAudio == false ) {
                    stream.getVideoTracks().forEach(function (track) {
                        track.enabled = !isMute;
                    });
                }
            });
        }
    }
}

function muteLocalAudio( isMute ) {
    muteMedia(true, isMute);
}

function muteLocalVideo( isMute ) {
    muteMedia(false, isMute);
}

function fullScreen(b_fs) {
    bFullScreen = b_fs;
    divVideo.setAttribute("class", b_fs ? "full-screen" : "normal-screen");
}

// 윈도우 로딩 후 초기화
window.onload = function () {
    if(window.console) {
        window.console.info("location=" + window.location);
    }

    /*
    oReadyStateTimer = setInterval(function () {
        if (document.readyState === "complete") {
                clearInterval(oReadyStateTimer);
            }
        },
    500);
    */

    room_init();
};
