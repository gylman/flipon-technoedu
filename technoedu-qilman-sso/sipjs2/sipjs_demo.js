// sipjs_demos.js
//
// Even though both "Alice" and "Bob" are running on the same computer,
// this demo behaves as if the dialog was an SIP call over a network.

var URL = window.URL || window.webkitURL;

// So, you still might run into a user besides yourself.
// Each session gets a token that expires 1 day later. This is so we minimize
// the number of users we register for the SIP domain, because SIP hosts
// generally have limits on the number of registered users you may have in total
// or over a period of time.
var domain = 'mentorservice.co.kr';
var aliceURI      = '9061@' + domain;
var aliceName     = '9061';

var bobURI        = '0382000@' + domain;
var bobName       = '0382000';

// Function: createSimple
//   creates a SIP.js Simple instance with the given arguments plugged into the
//   configuration. This is a standard Simple instance for WebRTC calls.
//
// Arguments:
//   callerURI: the URI of the caller, aka, the URI that belongs to this user.
//   displayName: what name we should display the user as
//   remoteVideo: the DOM element id of the video for the remote
//   buttonId: the DOM element id of the button for that user
function createSimple(callerURI, displayName, target, remoteVideo, buttonId) {
    var remoteVideoElement = document.getElementById(remoteVideo);
    var button = document.getElementById(buttonId);

    var configuration = {
        media: {
            local: {
                video: document.getElementById('localVideo')
           },
            remote: {
                video: remoteVideoElement,
                // Need audio to be not null to do audio & video instead of just video
                audio: remoteVideoElement
                    }
             },
        ua: {
            traceSip: true,
            uri: callerURI,
            //wsServers: "wss://mentorservice.co.kr:8089/asterisk/ws",
            wsServers: "wss://mentorservice.co.kr:10062",
            displayName: displayName,
            userAgentString: SIP.C.USER_AGENT + " mentorservice.co.kr",
            authorizationUser: "9061",
            password: '9061'
        }
    };
    var simple = new SIP.Web.Simple(configuration);

    // Adjust the style of the demo based on what is happening
    simple.on('ended', function() {
            remoteVideoElement.style.visibility = 'hidden';
            button.firstChild.nodeValue = 'video';
            });

    simple.on('connected', function() {
            remoteVideoElement.style.visibility = 'visible';
            button.firstChild.nodeValue = 'hang up';
            });

    simple.on('ringing', function() {
            simple.answer();
            });

    button.addEventListener('click', function() {
            // No current call up
            if (simple.state === SIP.Web.Simple.C.STATUS_NULL ||
                    simple.state === SIP.Web.Simple.C.STATUS_COMPLETED) {
            simple.call(target);
            } else {
            simple.hangup();
            }
            });

    return simple;
}

(function () {
 if (window.RTCPeerConnection) {
 // Now we do SIP.js stuff
 var aliceSimple = createSimple(aliceURI, aliceName, bobURI, 'video-of-bob', 'alice-video-button');

 // We want to only run the demo if all users for the demo can register
 var numToRegister = 1;
 var numRegistered = 0;
 var registrationFailed = false;
 var markAsRegistered = function () {
 numRegistered += 1;
 if (numRegistered >= numToRegister && !registrationFailed) {
 }
 };
 var failRegistration = function () {
 registrationFailed = true;
 failInterfaceSetup();
 };
 // We don't want to proceed until we've registered all users.
 // For each registered user, increase the counter.
 aliceSimple.on('registered', markAsRegistered);
 // If any registration fails, then we need to disable the app and tell the
 // user that we could not register them.
 aliceSimple.on('registrationFailed', failRegistration);

 // Only run the demo if we could register every user agent
 function setupInterfaces() {
 }
 function failInterfaceSetup() {
     alert('Max registration limit hit. Could not register all user agents, so they cannot communicate. The app is disabled.');
 }
 }
})();
