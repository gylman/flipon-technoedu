if(typeof(wbos)=="undefined"){wbos={}}if(typeof(wbos.CssTools)=="undefined"){wbos.CssTools={}}wbos.CssTools.MediaQueryFallBack=(function(){var config={cssScreen:"/css/screen.css",cssHandheld:"/css/handheld.css",mobileMaxWidth:660,testDivClass:"cssLoadCheck",dynamicCssLinkId:"DynCssLink",resizeDelay:30};var noMediaQuery=false;var delay;var currentCssMediaType;function addEvent(element,newFunction,eventType){var oldEvent=eval("element."+eventType);var eventContentType=eval("typeof element."+eventType);if(eventContentType!="function"){eval("element."+eventType+" = newFunction")}else{eval("element."+eventType+" = function(e) { oldEvent(e); newFunction(e); }")}}function getWindowWidth(){if(window.innerWidth){return window.innerWidth}else{if(document.documentElement.clientWidth){return document.documentElement.clientWidth}else{if(document.body.clientWidth){return document.body.clientWidth}else{return 0}}}}function addCssLink(cssHref){var cssNode=document.createElement("link");var windowWidth;cssNode.type="text/css";cssNode.rel="stylesheet";cssNode.media="screen, handheld, fallback";cssNode.href=cssHref;document.getElementsByTagName("head")[0].appendChild(cssNode)}return{LoadCss:function(cssScreen,cssHandheld,mobileMaxWidth){if(typeof(cssScreen)!="undefined"){config.cssScreen=cssScreen}if(typeof(cssHandheld)!="undefined"){config.cssHandheld=cssHandheld}if(typeof(mobileMaxWidth)!="undefined"){config.mobileMaxWidth=mobileMaxWidth}var cssloadCheckNode=document.createElement("div");cssloadCheckNode.className=config.testDivClass;document.getElementsByTagName("body")[0].appendChild(cssloadCheckNode);if(cssloadCheckNode.offsetWidth!=100&&noMediaQuery==false){noMediaQuery=true}cssloadCheckNode.parentNode.removeChild(cssloadCheckNode);if(noMediaQuery==true){var cssHref="";if(getWindowWidth()<=config.mobileMaxWidth){cssHref=config.cssHandheld;newCssMediaType="handheld"}else{cssHref=config.cssScreen;newCssMediaType="screen"}if(cssHref!=""&&currentCssMediaType!=newCssMediaType){var currentCssLinks=document.styleSheets;for(var i=0;i<currentCssLinks.length;i++){for(var ii=0;ii<currentCssLinks[i].media.length;ii++){if(typeof(currentCssLinks[i].media)=="object"){if(currentCssLinks[i].media.item(ii)=="fallback"){currentCssLinks[i].ownerNode.parentNode.removeChild(currentCssLinks[i].ownerNode);i--;break}}else{if(currentCssLinks[i].media.indexOf("fallback")>=0){currentCssLinks[i].owningElement.parentNode.removeChild(currentCssLinks[i].owningElement);i--;break}}}}if(typeof(cssHref)=="object"){for(var i=0;i<cssHref.length;i++){addCssLink(cssHref[i])}}else{addCssLink(cssHref)}currentCssMediaType=newCssMediaType}addEvent(window,wbos.CssTools.MediaQueryFallBack.LoadCssDelayed,"onresize")}},LoadCssDelayed:function(){clearTimeout(delay);delay=setTimeout("wbos.CssTools.MediaQueryFallBack.LoadCss()",config.resizeDelay)}}})();wbos.Events=(function(){return{AddEvent:function(element,newFunction,eventType){var oldEvent=eval("element."+eventType);var eventContentType=eval("typeof element."+eventType);if(eventContentType!="function"){eval("element."+eventType+" = newFunction")}else{eval("element."+eventType+" = function(e) { oldEvent(e); newFunction(e); }")}}}})();if(typeof(codeview)=="undefined"){codeview={}}codeview.classFilter=(function(){function b(){var h;var g=document.getElementById("ClassFilter").value;g=g.toLowerCase();if(document.getElementById("ClassList")){h=document.getElementById("ClassList").getElementsByTagName("li");c(h,g)}if(document.getElementById("ClassList2")){h=document.getElementById("ClassList2").getElementsByTagName("li");c(h,g)}if(document.getElementById("FileList")){h=document.getElementById("FileList").getElementsByTagName("li");c(h,g)}if(document.getElementById("MethodsListInherited")){var e=document.getElementById("MethodsListInherited").getElementsByTagName("a");var d=new Array();for(var f=0;f<e.length;f++){if(e[f].parentNode.parentNode.tagName=="DD"){d.push(e[f])}}c(d,g)}if(document.getElementById("MethodsList")){h=document.getElementById("MethodsList").getElementsByTagName("tbody")[0].getElementsByTagName("tr");c(h,g,document.getElementById("MethodDetail").getElementsByTagName("li"))}}function c(f,e,h){var g="";for(var d=0;d<f.length;d++){g=f[d].textContent||f[d].innerText;if(g!=undefined){g=g.toLowerCase();g=g.replace(/\s/g,"");if(g.indexOf(e)>=0||g==""){f[d].style.display=""}else{f[d].style.display="none"}if(h!=null){a(f[d],e,h)}}}}function a(f,d,g){var e=parseInt(f.className.replace("item",""));if(e<=g.length){if(g[e].className=="item"+e){g[e].style.display=f.style.display}}}return{Init:function(){wbos.Events.AddEvent(document.getElementById("ClassFilter"),b,"onkeyup")}}})();