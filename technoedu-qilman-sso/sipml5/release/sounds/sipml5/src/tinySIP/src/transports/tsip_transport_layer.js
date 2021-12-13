function tsip_transport_layer(a){if(!a){tsk_utils_log_error("Invalid argument");return null}this.o_stack=a;this.b_running=false;this.ao_transports=new Array()}function tsip_transport_layer_find_result(){this.o_transport=null;this.s_dest_ip=null;this.i_dest_port=0}tsip_transport_layer.prototype.get_layer_transac=function(){if(this.o_stack){return this.o_stack.o_layer_transac}return null};tsip_transport_layer.prototype.get_layer_dialog=function(){if(this.o_stack){return this.o_stack.o_layer_dialog}return null};tsip_transport_layer.prototype.stop=function(){while(this.b_locked){}this.b_locked=true;for(var a=0;a<this.ao_transports.length;++a){this.ao_transports[a].stop()}this.b_locked=false;return 0};tsip_transport_layer.prototype.send=function(c,a){var b=this.transport_find(a);if(!b||!b.o_transport){tsk_utils_log_error("Failed to find transport");return 0}return b.o_transport.send(c,a,b.s_dest_ip,b.i_dest_port)};tsip_transport_layer.prototype.transport_new=function(c,b,f,e,a){var d=null;while(this.b_locked){}this.b_locked=true;d=new tsip_transport(c,this.o_stack,b,f,e,a);if(d){this.ao_transports.push(d)}this.b_locked=false;return d};tsip_transport_layer.prototype.transport_remove=function(b){if(b){while(this.b_locked){}this.b_locked=true;for(var a=0;a<this.ao_transports.length;++a){if(this.ao_transports[a]==b){this.ao_transports.splice(a,1);break}}this.b_locked=false}};tsip_transport_layer.prototype.transport_find=function(b){if(!b){tsk_utils_log_error("Invalid argument");return null}var c=new tsip_transport_layer_find_result();c.s_dest_ip=this.o_stack.network.s_proxy_cscf_host;c.i_dest_port=this.o_stack.network.i_proxy_cscf_port;if(b.is_request()){for(var a=0;a<this.ao_transports.length;++a){if(this.ao_transports[a].e_type==this.o_stack.network.e_proxy_cscf_type){c.o_transport=this.ao_transports[a];break}}}else{if(b.o_hdr_firstVia){if(b.o_hdr_firstVia.is_transport_reliable()){}else{if(b.o_hdr_firstVia.s_maddr){}else{if(b.o_hdr_firstVia.s_received){if(b.o_hdr_firstVia.i_rport>0){c.s_dest_ip=b.o_hdr_firstVia.s_received;c.i_dest_port=b.o_hdr_firstVia.i_rport}else{c.s_dest_ip=b.o_hdr_firstVia.s_received;c.i_dest_port=b.o_hdr_firstVia.i_port?b.o_hdr_firstVia.i_port:5060}}else{if(!b.o_hdr_firstVia.s_received){c.s_dest_ip=b.o_hdr_firstVia.s_host;if(b.o_hdr_firstVia.i_port>0){c.i_dest_port=b.o_hdr_firstVia.i_port}}}}}while(this.b_locked){}this.b_locked=true;for(a=0;a<this.ao_transports.length;++a){if(this.ao_transports[a].have_socket(b.o_socket)){c.o_transport=this.ao_transports[a];break}}this.b_locked=false}}return c};tsip_transport_layer.prototype.handle_incoming_message=function(b){if(b){var a=this.get_layer_transac();if(!a){tsk_utils_log_error("Invalid transaction layer");return -1}var c;if((c=a.handle_incoming_message(b))!=0){o_layer_dialog=this.get_layer_dialog();if(!o_layer_dialog){tsk_utils_log_error("Invalid dialog layer");return -1}c=o_layer_dialog.handle_incoming_message(b)}return c}return 0};