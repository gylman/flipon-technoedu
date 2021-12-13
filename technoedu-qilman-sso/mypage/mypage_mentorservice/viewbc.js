function viewBroadcast(url, stream) { 
        var flashvars = {
            source: stream,
            type: "video",
            streamtype: "rtmp",
            server: url,
            autostart: "true",
            logoposition: "top left",
            hardwarescaling: "false",
            darkcolor: "000000",
            brightcolor: "4c4c4c",
            controlcolor: "FFFFFF",
            hovercolor: "67A8C1",
            controltype: 1
        };

        var params = {
            menu: "false",
            scale: "noScale",
            allowFullscreen: "true",
            allowScriptAccess: "always",
            bgcolor: "#000000",
            quality: "high",
            wmode: "opaque"
        };
        var attributes = {
            id:"JarisFLVPlayer"
        };

	swfobject.embedSWF("videoPlayer.swf", "movieContainer", "720px", "405px", "10.0.0","expressInstall.swf", flashvars, params, attributes, function(result){
			player = result.ref;
			});
}
