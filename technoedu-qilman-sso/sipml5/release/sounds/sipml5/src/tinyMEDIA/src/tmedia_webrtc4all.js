w4aPeerConnection.prototype.s_configuration=null;w4aPeerConnection.prototype.f_IceCallback=null;w4aPeerConnection.prototype.f_Rfc5168Callback;w4aPeerConnection.prototype.o_peer=null;w4aPeerConnection.prototype.localDescription=null;w4aPeerConnection.prototype.remoteDescription=null;w4aSessionDescription.prototype.o_sdp=null;w4aIceCandidate.prototype.media=null;w4aIceCandidate.prototype.label=null;var __o_roap_stream=null;var __o_jsep_stream_audio=null;var __o_jsep_stream_audiovideo=null;var WebRtcType_e={NONE:-1,NATIVE:0,IE:1,NPAPI:2,W4A:3,ERICSSON:4};var __webrtc_type=WebRtcType_e.NONE;var __b_webrtc4all_initialized=false;var __b_webrtc4ie_peerconn=undefined;function WebRtc4all_Init(){if(!__b_webrtc4all_initialized){try{var b=document.createElement("embed");b.id="WebRtc4npapi";b.type="application/w4a";b.width=b.height="1px";b.stype="visibility:hidden;";document.body.appendChild(b)}catch(a){}try{if(__webrtc_type==WebRtcType_e.NONE){window.nativeRTCPeerConnection=(window.webkitPeerConnection00||window.webkitRTCPeerConnection||window.mozRTCPeerConnection);window.nativeRTCSessionDescription=(window.mozRTCSessionDescription||window.RTCSessionDescription);window.nativeRTCIceCandidate=(window.mozRTCIceCandidate||window.RTCIceCandidate);window.nativeURL=(window.webkitURL||window.URL);navigator.nativeGetUserMedia=(navigator.webkitGetUserMedia||navigator.mozGetUserMedia);if((navigator.nativeGetUserMedia&&window.nativeRTCPeerConnection)){__webrtc_type=WebRtcType_e.NATIVE}else{if(navigator.nativeGetUserMedia&&window.webkitPeerConnection){__webrtc_type=WebRtcType_e.ERICSSON}}}}catch(a){}if(__webrtc_type==WebRtcType_e.NONE||__webrtc_type==WebRtcType_e.W4A){try{if((__b_webrtc4ie_peerconn=new ActiveXObject("webrtc4ie.PeerConnection"))){__webrtc_type=WebRtcType_e.IE}}catch(a){if(WebRtc4npapi.supportsPeerConnection){__webrtc_type=WebRtcType_e.NPAPI}}}__b_webrtc4all_initialized=true;if(navigator.nativeGetUserMedia&&WebRtc4all_GetType()==WebRtcType_e.ERICSSON){navigator.nativeGetUserMedia("audio, video",function(c){tsk_utils_log_info("Got stream :)");__o_roap_stream=c},function(c){tsk_utils_log_error(c)})}}}function WebRtc4all_GetVersion(){try{if(__webrtc_type==WebRtcType_e.IE){return __b_webrtc4ie_peerconn.version}else{if(__webrtc_type==WebRtcType_e.NPAPI){return WebRtc4npapi.version}}}catch(a){}return"0.0.0.0"}function WebRtc4all_SetType(a){if(__webrtc_type!=WebRtcType_e.NONE){tsk_utils_log_error("Trying not set default webrtc type after init() is not allowed");return false}switch(a){case"w4a":__webrtc_type=WebRtcType_e.W4A;break;case"ericsson":__webrtc_type=WebRtcType_e.ERICSSON;break;case"native":__webrtc_type=WebRtcType_e.NATIVE;break;default:tsk_utils_log_error("["+a+"] not valid as default webrtc type");return false}return true}function WebRtc4all_GetType(){return __webrtc_type}var __looper=undefined;function WebRtc4all_GetLooper(){if(__looper==undefined&&tsk_utils_have_webrtc4ie()){try{if(fakeLooper&&fakeLooper.hWnd){__looper=fakeLooper.hWnd}else{if((__o_display_local&&__o_display_local.hWnd)||(__o_display_remote&&__o_display_remote.hWnd)){__looper=(__o_display_local&&__o_display_local.hWnd)?__o_display_local.hWnd:__o_display_remote.hWnd}else{var a=document.createElement("object");a.classid="clsid:7082C446-54A8-4280-A18D-54143846211A";a.width=a.height="1px";document.body.appendChild(a);__looper=a.hWnd}}if(!__looper){tsk_utils_log_error("Failed to create looper. Your app may crash on IE11")}}catch(b){tsk_utils_log_error(b);__looper=null}}return __looper}function WebRtc4all_SetDisplays(a,b){if(__webrtc_type==WebRtcType_e.IE){if(a){a.innerHTML='<object id="__o_display_local" classid="clsid:5C2C407B-09D9-449B-BB83-C39B7802A684" class="video" width="88px" height="72px" style="margin-top: -80px; margin-left: 5px; background-color: #000000; visibility:visible"> </object>';__o_display_local.style.visibility="hidden"}if(b){b.innerHTML='<object id="__o_display_remote" classid="clsid:5C2C407B-09D9-449B-BB83-C39B7802A684" width="100%" height="100%" style="visibility:visible;"> </object>';__o_display_remote.style.visibility="hidden"}}else{if(__webrtc_type==WebRtcType_e.NPAPI){if(a){a.innerHTML='<embed id="__o_display_local" type="application/w4a-display" class="video" width="88px" height="72px" style="margin-top: -80px; margin-left: 5px; background-color: #000000; visibility:visible"> </embed>';__o_display_local.style.visibility="hidden"}if(b){b.innerHTML='<embed id="__o_display_remote" type="application/w4a-display" width="100%" height="100%" style="visibility:visible;"> </embed>';__o_display_remote.style.visibility="hidden"}}}}function w4aSessionDescription(b){if(!__b_webrtc4all_initialized){WebRtc4all_Init()}var a=(__webrtc_type==WebRtcType_e.IE);this.o_sdp=a?new ActiveXObject("webrtc4ie.SessionDescription"):WebRtc4npapi.createSessionDescription();this.o_sdp.Init(b?(b+""):null)}w4aSessionDescription.prototype.toSdp=function(){return this.o_sdp.toSdp()};w4aSessionDescription.prototype.toString=w4aSessionDescription.prototype.toSdp;w4aSessionDescription.prototype.addCandidate=function(a){if(a&&a.media&&a.label){this.o_sdp.addCandidate(a.media,a.label)}};function w4aIceCandidate(b,a){this.media=b;this.label=a}w4aIceCandidate.prototype.toSdp=function(){return this.label};function w4aPeerConnection(s_configuration,f_IceCallback){if(!__b_webrtc4all_initialized){WebRtc4all_Init()}var This=this;var b_isInternetExplorer=(__webrtc_type==WebRtcType_e.IE);this.s_configuration=s_configuration;this.f_IceCallback=f_IceCallback;this.o_peer=b_isInternetExplorer?new ActiveXObject("webrtc4ie.PeerConnection"):WebRtc4npapi.createPeerConnection();this.o_peer.Init(s_configuration);try{this.o_peer.localVideo=(window.__o_display_local?window.__o_display_local.hWnd:0)}catch(e){}try{this.o_peer.remoteVideo=(window.__o_display_remote?window.__o_display_remote.hWnd:0)}catch(e){}if(b_isInternetExplorer){eval("function This.o_peer::IceCallback(media, label, bMoreToFollow) { return This.onIceCallback (media, label, bMoreToFollow); }");eval("function This.o_peer::Rfc5168Callback(command) { return This.onRfc5168Callback(command); }")}else{this.o_peer.opaque=This;this.o_peer.setCallbackFuncName("w4aPeerConnection_NPAPI_OnEvent");if(this.o_peer.setRfc5168CallbackFuncName){this.o_peer.setRfc5168CallbackFuncName("w4aPeerConnection_NPAPI_OnRfc5168Event")}}}w4aPeerConnection.SDP_OFFER=256;w4aPeerConnection.SDP_PRANSWER=512;w4aPeerConnection.SDP_ANSWER=768;w4aPeerConnection.NEW=0;w4aPeerConnection.OPENING=1;w4aPeerConnection.ACTIVE=2;w4aPeerConnection.CLOSED=3;w4aPeerConnection.ICE_GATHERING=256;w4aPeerConnection.ICE_WAITING=512;w4aPeerConnection.ICE_CHECKING=768;w4aPeerConnection.ICE_CONNECTED=1024;w4aPeerConnection.ICE_COMPLETED=1280;w4aPeerConnection.ICE_FAILED=1536;w4aPeerConnection.ICE_CLOSED=1792;w4aPeerConnection.prototype.createOffer=function(b){if((__webrtc_type==WebRtcType_e.IE)){return new w4aSessionDescription(this.o_peer.createOffer(b.has_audio,b.has_video))}else{var a=this.o_peer.createOffer(b.has_audio,b.has_video);if(a){return new w4aSessionDescription(a.toSdp())}return null}};w4aPeerConnection.prototype.createAnswer=function(b,c){if((__webrtc_type==WebRtcType_e.IE)){return new w4aSessionDescription(this.o_peer.createAnswer(c.has_audio,c.has_video))}else{var a=this.o_peer.createAnswer(c.has_audio,c.has_video);if(a){return new w4aSessionDescription(a.toSdp())}return null}};w4aPeerConnection.prototype.setLocalDescription=function(a,b){this.o_peer.setLocalDescription(a,(__webrtc_type==WebRtcType_e.IE)?b.toSdp():b.o_sdp);this.localDescription=new w4aSessionDescription(this.o_peer.localDescription)};w4aPeerConnection.prototype.setRemoteDescription=function(a,b){this.o_peer.setRemoteDescription(a,(__webrtc_type==WebRtcType_e.IE)?b.toSdp():b.o_sdp);this.remoteDescription=new w4aSessionDescription(this.o_peer.remoteDescription)};w4aPeerConnection.prototype.startIce=function(a){this.o_peer.startIce(0,WebRtc4all_GetLooper())};w4aPeerConnection.prototype.startMedia=function(a){if(this.o_peer){try{this.o_peer.startMedia()}catch(b){}}};w4aPeerConnection.prototype.processIceMessage=function(a){tsk_utils_log_error("Not implemented")};w4aPeerConnection.prototype.addStream=function(a,b){};w4aPeerConnection.prototype.removeStream=function(a){};w4aPeerConnection.prototype.processContent=function(d,a,b,f){if(this.o_peer){try{this.o_peer.processContent(d,a,b,f)}catch(c){}}};w4aPeerConnection.prototype.close=function(){if(this.o_peer){this.o_peer.close()}};w4aPeerConnection.prototype.onIceCallback=function(b,a,c){tsk_utils_log_info("w4aPeerConnection::onIceCallback("+b+","+a+","+c+")");this.iceState=this.o_peer.iceState;if(this.f_IceCallback){this.f_IceCallback(new w4aIceCandidate(b,a),c)}};function w4aPeerConnection_NPAPI_OnEvent(c,a,b,d){c.onIceCallback(a,b,d)}w4aPeerConnection.prototype.onRfc5168Callback=function(a){tsk_utils_log_info("w4aPeerConnection::onRfc5168Callback("+a+")");if(this.o_mgr&&this.o_mgr.callback){if(a==="picture_fast_update"){this.o_mgr.callback(tmedia_session_events_e.RFC5168_REQUEST_IDR,this.o_mgr.e_type)}}else{tsk_utils_log_error("No manager associated to this peerconnection")}};function w4aPeerConnection_NPAPI_OnRfc5168Event(a,b){a.onRfc5168Callback(b)};