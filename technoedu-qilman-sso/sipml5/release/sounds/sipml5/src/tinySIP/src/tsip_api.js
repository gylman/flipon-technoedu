function tsip_api_add_js_scripts(a){var c=document.getElementsByTagName(a)[0];for(var b=1;b<arguments.length;++b){var d=document.createElement("script");d.setAttribute("type","text/javascript");d.setAttribute("src",arguments[b]+"?svn=224");c.appendChild(d)}}tsip_api_add_js_scripts("head","src/tinySAK/src/tsk_api.js");tsip_api_add_js_scripts("head","src/tinyMEDIA/src/tmedia_api.js");tsip_api_add_js_scripts("head","src/tinySDP/src/tsdp_api.js");tsip_api_add_js_scripts("head","src/tinySIP/src/tsip_action.js","src/tinySIP/src/tsip_event.js","src/tinySIP/src/tsip_message.js","src/tinySIP/src/tsip_session.js","src/tinySIP/src/tsip_stack.js","src/tinySIP/src/tsip_timers.js","src/tinySIP/src/tsip_uri.js");tsip_api_add_js_scripts("head");tsip_api_add_js_scripts("head","src/tinySIP/src/authentication/tsip_auth.js","src/tinySIP/src/authentication/tsip_challenge.js");tsip_api_add_js_scripts("head","src/tinySIP/src/dialogs/tsip_dialog.js","src/tinySIP/src/dialogs/tsip_dialog_layer.js");tsip_api_add_js_scripts("head","src/tinySIP/src/headers/tsip_header.js");tsip_api_add_js_scripts("head","src/tinySIP/src/parsers/tsip_parser_header.js");tsip_api_add_js_scripts("head","src/tinySIP/src/transactions/tsip_transac.js");tsip_api_add_js_scripts("head","src/tinySIP/src/transports/tsip_transport.js","src/tinySIP/src/transports/tsip_transport_layer.js");