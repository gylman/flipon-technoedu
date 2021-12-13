tsip_transac_ict.prototype=Object.create(tsip_transac.prototype);tsip_transac_ict.prototype.__b_debug_state_machine=false;var tsip_transac_ict_actions_e={CANCEL:tsip_action_type_e.CANCEL,SEND:10001,TIMER_A:10002,TIMER_B:10003,TIMER_D:10004,TIMER_M:10005,I_1XX:10006,I_2XX:10007,I_300_to_699:10008,TRANSPOR_TERROR:10009,ERROR:10010};var tsip_transac_ict_states_e={STARTED:0,CALLING:1,PROCEEDING:2,COMPLETED:3,ACCEPTED:4,TERMINATED:5};function tsip_transac_ict(b,e,c,d){var a;if(!d||!(a=d.get_stack())){tsk_utils_log_error("Invalid argument");return null}tsip_transac.call(this);this.init(tsip_transac_type_e.ICT,b,e,"INVITE",c,d,tsip_transac_ict_states_e.STARTED,tsip_transac_ict_states_e.TERMINATED);this.set_callback(__tsip_transac_ict_event_callback);this.o_fsm.set_debug_enabled(tsip_transac_ict.prototype.__b_debug_state_machine);this.o_fsm.set_onterm_callback(__tsip_transac_ict_onterm,this);this.o_timerA=null;this.o_timerB=null;this.o_timerD=null;this.o_timerM=null;this.i_timerA=a.o_timers.getA();this.i_timerB=a.o_timers.getB();this.i_timerD=b?0:a.o_timers.getD();this.i_timerM=a.o_timers.getM();this.o_fsm.set(tsk_fsm_entry.prototype.CreateAlways(tsip_transac_ict_states_e.STARTED,tsip_transac_ict_actions_e.SEND,tsip_transac_ict_states_e.CALLING,__tsip_transac_ict_Started_2_Calling_X_send,"tsip_transac_ict_Started_2_Calling_X_send"),tsk_fsm_entry.prototype.CreateAlwaysNothing(tsip_transac_ict_states_e.STARTED,"tsip_transac_ict_Started_2_Started_X_any"),tsk_fsm_entry.prototype.CreateAlways(tsip_transac_ict_states_e.CALLING,tsip_transac_ict_actions_e.TIMER_A,tsip_transac_ict_states_e.CALLING,__tsip_transac_ict_Calling_2_Calling_X_timerA,"tsip_transac_ict_Calling_2_Calling_X_timerA"),tsk_fsm_entry.prototype.CreateAlways(tsip_transac_ict_states_e.CALLING,tsip_transac_ict_actions_e.TIMER_B,tsip_transac_ict_states_e.TERMINATED,__tsip_transac_ict_Calling_2_Terminated_X_timerB,"tsip_transac_ict_Calling_2_Terminated_X_timerB"),tsk_fsm_entry.prototype.CreateAlways(tsip_transac_ict_states_e.CALLING,tsip_transac_ict_actions_e.I_300_to_699,tsip_transac_ict_states_e.COMPLETED,__tsip_transac_ict_Calling_2_Completed_X_300_to_699,"tsip_transac_ict_Calling_2_Completed_X_300_to_699"),tsk_fsm_entry.prototype.CreateAlways(tsip_transac_ict_states_e.CALLING,tsip_transac_ict_actions_e.I_1XX,tsip_transac_ict_states_e.PROCEEDING,__tsip_transac_ict_Calling_2_Proceeding_X_1xx,"tsip_transac_ict_Calling_2_Proceeding_X_1xx"),tsk_fsm_entry.prototype.CreateAlways(tsip_transac_ict_states_e.CALLING,tsip_transac_ict_actions_e.I_2XX,tsip_transac_ict_states_e.ACCEPTED,__tsip_transac_ict_Calling_2_Accepted_X_2xx,"tsip_transac_ict_Calling_2_Accepted_X_2xx"),tsk_fsm_entry.prototype.CreateAlways(tsip_transac_ict_states_e.PROCEEDING,tsip_transac_ict_actions_e.I_1XX,tsip_transac_ict_states_e.PROCEEDING,__tsip_transac_ict_Proceeding_2_Proceeding_X_1xx,"tsip_transac_ict_Proceeding_2_Proceeding_X_1xx"),tsk_fsm_entry.prototype.CreateAlways(tsip_transac_ict_states_e.PROCEEDING,tsip_transac_ict_actions_e.I_300_to_699,tsip_transac_ict_states_e.COMPLETED,__tsip_transac_ict_Proceeding_2_Completed_X_300_to_699,"tsip_transac_ict_Proceeding_2_Completed_X_300_to_699"),tsk_fsm_entry.prototype.CreateAlways(tsip_transac_ict_states_e.PROCEEDING,tsip_transac_ict_actions_e.I_2XX,tsip_transac_ict_states_e.ACCEPTED,__tsip_transac_ict_Proceeding_2_Accepted_X_2xx,"tsip_transac_ict_Proceeding_2_Accepted_X_2xx"),tsk_fsm_entry.prototype.CreateAlways(tsip_transac_ict_states_e.COMPLETED,tsip_transac_ict_actions_e.I_300_to_699,tsip_transac_ict_states_e.COMPLETED,__tsip_transac_ict_Completed_2_Completed_X_300_to_699,"tsip_transac_ict_Completed_2_Completed_X_300_to_699"),tsk_fsm_entry.prototype.CreateAlways(tsip_transac_ict_states_e.COMPLETED,tsip_transac_ict_actions_e.TIMER_D,tsip_transac_ict_states_e.TERMINATED,__tsip_transac_ict_Completed_2_Terminated_X_timerD,"tsip_transac_ict_Completed_2_Terminated_X_timerD"),tsk_fsm_entry.prototype.CreateAlways(tsip_transac_ict_states_e.ACCEPTED,tsip_transac_ict_actions_e.I_2XX,tsip_transac_ict_states_e.ACCEPTED,__tsip_transac_ict_Accepted_2_Accepted_X_2xx,"tsip_transac_ict_Accepted_2_Accepted_X_2xx"),tsk_fsm_entry.prototype.CreateAlways(tsip_transac_ict_states_e.ACCEPTED,tsip_transac_ict_actions_e.TIMER_M,tsip_transac_ict_states_e.TERMINATED,__tsip_transac_ict_Accepted_2_Terminated_X_timerM,"tsip_transac_ict_Accepted_2_Terminated_X_timerM"),tsk_fsm_entry.prototype.CreateAlways(tsk_fsm.prototype.__i_state_any,tsip_transac_ict_actions_e.TRANSPORT_ERROR,tsip_transac_ict_states_e.TERMINATED,__tsip_transac_ict_Any_2_Terminated_X_transportError,"tsip_transac_ict_Any_2_Terminated_X_transportError"),tsk_fsm_entry.prototype.CreateAlways(tsk_fsm.prototype.__i_state_any,tsip_transac_ict_actions_e.ERROR,tsip_transac_ict_states_e.TERMINATED,__tsip_transac_ict_Any_2_Terminated_X_Error,"tsip_transac_ict_Any_2_Terminated_X_Error"),tsk_fsm_entry.prototype.CreateAlways(tsk_fsm.prototype.__i_state_any,tsip_transac_ict_actions_e.CANCEL,tsip_transac_ict_states_e.TERMINATED,__tsip_transac_ict_Any_2_Terminated_X_cancel,"tsip_transac_ict_Any_2_Terminated_X_cancel"))}tsip_transac_ict.prototype.start=function(a){var b=-1;if(a&&!this.b_running){this.s_branch=tsk_string_format("{0}{1}",tsip_transac.prototype.__magic_cookie,tsk_string_random(32));this.b_running=true;this.o_request=a;b=this.fsm_act(tsip_transac_ict_actions_e.SEND,a)}return b};tsip_transac_ict.prototype.send_ack=function(c){if(!this.o_request||!c){tsk_utils_log_error("Invalid state");return -1}if(!this.o_request.o_hdr_firstVia||!this.o_request.o_hdr_From||!this.o_request.line.request.o_uri||!this.o_request.o_hdr_Call_ID||!this.o_request.o_hdr_CSeq){tsk_utils_log_error("Invalid INVITE message");return -2}if(!c.o_hdr_To){tsk_utils_log_error("Invalid response message");return -3}var d=-1;var b=null;if((b=new tsip_request("ACK",this.o_request.line.request.o_uri,this.o_request.o_hdr_From.o_uri,c.o_hdr_To.o_uri,this.o_request.o_hdr_Call_ID.s_value,this.o_request.o_hdr_CSeq.i_seq))){b.o_hdr_firstVia=this.o_request.o_hdr_firstVia;if(b.o_hdr_From){b.o_hdr_From.s_tag=this.o_request.o_hdr_From.s_tag}if(b.o_hdr_To){b.o_hdr_To.s_tag=c.o_hdr_To.s_tag}if(this.get_stack().network.e_proxy_cscf_type==tsip_transport_type_e.WS||this.get_stack().network.e_proxy_cscf_type==tsip_transport_type_e.WSS){var e=this.get_stack().__get_proxy_outbound_uri_string();if(e){b.add_header(new tsip_header_Dummy("Route",e),true)}}for(var a=0;a<this.o_request.ao_headers.length;++a){if(this.o_request.ao_headers[a].e_type==tsip_header_type_e.Route){b.add_header(this.o_request.ao_headers[a])}}b.s_sigcomp_id=this.get_session().s_sigcomp_id;d=this.send(b.o_hdr_firstVia.s_branch,b)}return d};function __tsip_transac_ict_Started_2_Calling_X_send(a){var b=a[0];b.send(b.s_branch,b.o_request);if(!b.b_reliable){b.timer_schedule("ict","A")}b.timer_schedule("ict","B");return 0}function __tsip_transac_ict_Calling_2_Calling_X_timerA(a){var b=a[0];b.send(b.s_branch,b.o_request);b.i_timerA<<=1;b.timer_schedule("ict","A");return 0}function __tsip_transac_ict_Calling_2_Terminated_X_timerB(a){var b=a[0];b.get_dialog().callback(tsip_dialog_event_type_e.TIMEDOUT,null);return 0}function __tsip_transac_ict_Calling_2_Completed_X_300_to_699(a){var b=a[0];var c=a[1];var d;if(!b.b_reliable){b.timer_cancel("A")}b.timer_cancel("B");b.timer_schedule("ict","D");if((d=b.send_ack(c))<=0){return d}return b.get_dialog().callback(tsip_dialog_event_type_e.I_MSG,c)}function __tsip_transac_ict_Calling_2_Proceeding_X_1xx(a){var b=a[0];var c=a[1];if(!b.b_reliable){b.timer_cancel("A")}b.timer_cancel("B");return b.get_dialog().callback(tsip_dialog_event_type_e.I_MSG,c)}function __tsip_transac_ict_Calling_2_Accepted_X_2xx(a){var b=a[0];var c=a[1];b.timer_schedule("ict","M");if(!b.b_reliable){b.timer_schedule("ict","A")}b.timer_schedule("ict","B");return b.get_dialog().callback(tsip_dialog_event_type_e.I_MSG,c)}function __tsip_transac_ict_Proceeding_2_Proceeding_X_1xx(a){var b=a[0];var c=a[1];return b.get_dialog().callback(tsip_dialog_event_type_e.I_MSG,c)}function __tsip_transac_ict_Proceeding_2_Completed_X_300_to_699(a){var b=a[0];var c=a[1];var d;if(!b.b_reliable){b.timer_cancel("A")}b.timer_cancel("B");b.timer_schedule("ict","D");if((d=b.send_ack(c))<=0){return d}return b.get_dialog().callback(tsip_dialog_event_type_e.I_MSG,c)}function __tsip_transac_ict_Proceeding_2_Accepted_X_2xx(a){var b=a[0];var c=a[1];b.timer_schedule("ict","M");if(!b.b_reliable){b.timer_schedule("ict","A")}b.timer_schedule("ict","B");return b.get_dialog().callback(tsip_dialog_event_type_e.I_MSG,c)}function __tsip_transac_ict_Completed_2_Completed_X_300_to_699(a){var b=a[0];var c=a[1];return(b.send_ack(c)<=0?-1:0)}function __tsip_transac_ict_Completed_2_Terminated_X_timerD(a){return 0}function __tsip_transac_ict_Accepted_2_Accepted_X_2xx(a){var b=a[0];var c=a[1];return b.get_dialog().callback(tsip_dialog_event_type_e.I_MSG,c)}function __tsip_transac_ict_Accepted_2_Terminated_X_timerM(a){return 0}function __tsip_transac_ict_Any_2_Terminated_X_transportError(a){var b=a[0];return b.get_dialog().callback(tsip_dialog_event_type_e.TRANSPORT_ERROR,null)}function __tsip_transac_ict_Any_2_Terminated_X_Error(a){var b=a[0];return b.get_dialog().callback(tsip_dialog_event_type_e.ERROR,null)}function __tsip_transac_ict_Any_2_Terminated_X_cancel(a){return 0}function __tsip_transac_ict_onterm(a){a.timer_cancel("A");a.timer_cancel("B");a.timer_cancel("D");a.timer_cancel("M");return a.deinit()}function __tsip_transac_ict_event_callback(a,c,b){if(!a){tsk_utils_log_error("Invalid argument");return -1}var d=0;switch(c){case tsip_transac_event_type_e.INCOMING_MSG:if(b&&b.is_response()){if(b.is_1xx()){d=a.fsm_act(tsip_transac_ict_actions_e.I_1XX,b)}else{if(b.is_2xx()){d=a.fsm_act(tsip_transac_ict_actions_e.I_2XX,b)}else{if(b.is_3456()){d=a.fsm_act(tsip_transac_ict_actions_e.I_300_to_699,b)}else{tsk_utils_log_warn("Not supported status code: "+b.get_response_code())}}}}break;case tsip_transac_event_type_e.CANCELED:case tsip_transac_event_type_e.TERMINATED:case tsip_transac_event_type_e.TIMEDOUT:break;case tsip_transac_event_type_e.ERROR:d=a.fsm_act(tsip_transac_ict_actions_e.ERROR,b);break;case tsip_transac_event_type_e.TRANSPORT_ERROR:d=a.fsm_act(tsip_transac_ict_actions_e.TRANSPORT_ERROR,b);break}return d}function __tsip_transac_ict_timer_callback(b,a){if(b){if(a==b.o_timerA){b.fsm_act(tsip_transac_ict_actions_e.TIMER_A,null)}else{if(a==b.o_timerB){b.fsm_act(tsip_transac_ict_actions_e.TIMER_B,null)}else{if(a==b.o_timerD){b.fsm_act(tsip_transac_ict_actions_e.TIMER_D,null)}else{if(a==b.o_timerM){b.fsm_act(tsip_transac_ict_actions_e.TIMER_M,null)}}}}}};