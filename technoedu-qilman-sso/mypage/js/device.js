/*
 *  Copyright (c) 2015 The WebRTC project authors. All Rights Reserved.
 *
 *  Use of this source code is governed by a BSD-style license
 *  that can be found in the LICENSE file in the root of the source
 *  tree.
 */

'use strict';

var videoElement = document.querySelector('video');
var audioInputSelect = $('#audioSource');
var videoSelect =  $('#videoSource');


//var saveAudioId = window.localStorage.getItem('org.doubango.media.audio_src_id');
//var saveVideoId = window.localStorage.getItem('org.doubango.media.video_src_id');
var saveAudioId = window.localStorage.getItem('wsmedia.audio_src_id');
var saveVideoId = window.localStorage.getItem('wsmedia.video_src_id');

var curAudioDev = "";
var curVideoDev = "";

var loadSaveValue = false;

function gotDevices(deviceInfos) {
    console.log(deviceInfos);
	audioInputSelect.find('option').remove();
	videoSelect.find('option').remove();

    /*
    saveAudioId = window.localStorage.getItem('wsmedia.audio_src_id');
    saveVideoId = window.localStorage.getItem('wsmedia.video_src_id');
    */
    $('#audioSource').val(saveAudioId);
    $('#videoSource').val(saveVideoId);

	for (var i = 0; i !== deviceInfos.length; ++i) {
		var deviceInfo = deviceInfos[i];
		var option = document.createElement('option');
		option.value = deviceInfo.deviceId;
		if (deviceInfo.kind === 'audioinput') {
			option.text = deviceInfo.label || 'microphone ' + (audioInputSelect.length + 1);
			
			if ( loadSaveValue == false ) {
				console.log("load:"+saveAudioId);
				if ( deviceInfo.deviceId == saveAudioId ) audioInputSelect.append('<option value="'+option.value+'" selected>'+option.text+'</option>');
				else audioInputSelect.append('<option value="'+option.value+'">'+option.text+'</option>');
			}
			else if ( deviceInfo.label == curAudioDev ) audioInputSelect.append('<option value="'+option.value+'" selected>'+option.text+'</option>');
			else audioInputSelect.append('<option value="'+option.value+'">'+option.text+'</option>');

		} else if (deviceInfo.kind === 'audiooutput') {
			option.text = deviceInfo.label || 'speaker ' + (audioOutputSelect.length + 1);
			// To.Do.
		} else if (deviceInfo.kind === 'videoinput') {
			option.text = deviceInfo.label || 'camera ' + (videoSelect.length + 1);

			if ( loadSaveValue == false ) {
				if ( deviceInfo.deviceId == saveVideoId ) videoSelect.append('<option value="'+option.value+'" selected>'+option.text+'</option>');
				else videoSelect.append('<option value="'+option.value+'">'+option.text+'</option>');
			}
			else if ( deviceInfo.label == curVideoDev ) videoSelect.append('<option value="'+option.value+'" selected>'+option.text+'</option>');
			else videoSelect.append('<option value="'+option.value+'">'+option.text+'</option>');
		} else {
			console.log('Some other kind of source/device: ', deviceInfo);
		}
	}
	loadSaveValue= true;
}

function errorCallback(error) {
	console.log('navigator.getUserMedia error: ', error);
}

// Attach audio output device to video element using device/sink ID.
function attachSinkId(element, sinkId) {
	if (typeof element.sinkId !== 'undefined') {
		element.setSinkId(sinkId)
			.then(function() {
					console.log('Success, audio output device attached: ' + sinkId);
					})
		.catch(function(error) {
				var errorMessage = error;
				if (error.name === 'SecurityError') {
				errorMessage = 'You need to use HTTPS for selecting audio output ' +
				'device: ' + error;
				}
				console.error(errorMessage);
				// Jump back to first output device in the list as it's the default.
				audioOutputSelect.selectedIndex = 0;
				});
	} else {
		console.warn('Browser does not support output device selection.');
	}
}

function changeAudioDestination() {
	var audioDestination = audioOutputSelect.value;
	attachSinkId(videoElement, audioDestination);
}

function start() {
	if (window.stream) {
		window.stream.getTracks().forEach(function(track) {
				track.stop();
				});
	}
	var audioSource = $('#audioSource').val();
	var videoSource = $('#videoSource').val();

    //alert('1 Audio Stream: ' + audioSource );

    if ( audioSource == null )
    {
        audioSource = window.localStorage.getItem('wsmedia.audio_src_id');
    }

    //alert('2 Audio Stream: ' + audioSource );

	var constraints = {
	audio: {deviceId: audioSource ? {exact: audioSource} : undefined},
       video: {deviceId: videoSource ? {exact: videoSource} : undefined}
	};
	navigator.mediaDevices.getUserMedia(constraints)
		.then(function(stream) {
                console.log("getUserMedia Streams:");
                console.log(stream);
				window.stream = stream; // make stream available to console
				videoElement.srcObject = stream;

				var audioTrack = stream.getAudioTracks();
				var videoTrack = stream.getVideoTracks();
				curAudioDev = audioTrack[0].label;
				curVideoDev = videoTrack[0].label;
				console.log('curA:'+ curAudioDev +' curV:'+curVideoDev);
				// Refresh button list in case labels have become available
				return navigator.mediaDevices.enumerateDevices();
				})
	.then(gotDevices)
		.catch(errorCallback);

    // grab our canvas
    canvasContext = document.getElementById( "meter" ).getContext("2d");
    // monkeypatch Web Audio
    window.AudioContext = window.AudioContext || window.webkitAudioContext;
    // grab an audio context
    audioContext = new AudioContext();
    // Attempt to get audio input
    try {
        // monkeypatch getUserMedia
        navigator.getUserMedia = 
        	navigator.getUserMedia ||
        	navigator.webkitGetUserMedia ||
        	navigator.mozGetUserMedia;

        // ask for an audio input
        navigator.getUserMedia(
        {
            "audio": {
                "mandatory": {
                    "googEchoCancellation": "false",
                    "googAutoGainControl": "false",
                    "googNoiseSuppression": "false",
                    "googHighpassFilter": "false"
                },
                "optional": [{sourceId: audioSource }]
            },
        }, gotStreamAudio, didntGetStream);
    } catch (e) {
        alert('getUserMedia threw exception :' + e);
    }
}

var audioContext = null;
var meter = null;
var canvasContext = null;
var WIDTH = 50;
var HEIGHT = 240;
var rafID = null;

function didntGetStream() {
    alert('Stream generation failed.');
}

var mediaStreamSource = null;

function gotStreamAudio(stream) {
    // Create an AudioNode from the stream.
    mediaStreamSource = audioContext.createMediaStreamSource(stream);

    //console.log("Audio Stream: " + $('#audioSource').val() );
    //alert('Audio Stream Meter: ' + stream.id );

    // Create a new volume meter and connect it.
    meter = createAudioMeter(audioContext);
    mediaStreamSource.connect(meter);
    
    // kick off the visual updating
    drawLoop();
}

function drawLoop( time ) {
    // clear the background
    canvasContext.clearRect(0,0,WIDTH,HEIGHT);

    // check if we're currently clipping
    if (meter.checkClipping())
        canvasContext.fillStyle = "red";
    else
        canvasContext.fillStyle = "green";

    // draw a bar based on the current volume
    canvasContext.fillRect(0, HEIGHT-meter.volume*HEIGHT*1.4 , WIDTH,  HEIGHT );

    // set up the next visual callback
    rafID = window.requestAnimationFrame( drawLoop );
}

$('#audioSource').change(start);
$('#videoSource').change(start);

	navigator.mediaDevices.enumerateDevices()
.then(gotDevices)
	.catch(errorCallback);

setTimeout(start, 200);
