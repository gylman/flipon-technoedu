tsip_transac_ist.prototype=Object.create(tsip_transac.prototype);tsip_transac_ist.prototype.__b_debug_state_machine=true;var tsip_transac_ist_actions_e={CANCEL:tsip_action_type_e.CANCEL,RECV_INVITE:10001,RECV_ACK:10002,SEND_1XX:10003,SEND_2XX:10004,SEND_300_to_699:10005,SEND_NON1XX:10006,TIMER_H:10007,TIMER_I:10008,TIMER_G:10009,TIMER_L:10010,TIMER_X:10011,TRANSPORT_ERROR:10012,ERROR:10013};var tsip_transac_ist_states_e={STARTED:0,PROCEEDING:1,COMPLETED:2,ACCEPTED:3,CONFIRMED:4,TERMINATED:5};function tsip_transac_ist(b,e,c,d){var a;if(!d||!(a=d.get_stack())){tsk_utils_log_error("Invalid argument");return null}tsip_transac.call(this);this.o_lastResponse=null;this.init(tsip_transac_type_e.IST,b,e,"INVITE",c,d,tsip_transac_ist_states_e.STARTED,tsip_transac_ist_states_e.TERMINATED);this.set_callback(__tsip_transac_ist_event_callback);this.o_fsm.set_debug_enabled(tsip_transac_ist.prototype.__b_debug_state_machine);this.o_fsm.set_onterm_callback(__tsip_transac_ist_onterm,this);this.o_timerH=null;this.o_timerI=null;this.o_timerG=null;this.o_timerL=null;this.o_timerX=null;this.i_timerH=a.o_timers.getH();this.i_timerI=b?0:a.o_timers.getI();this.i_timerG=a.o_timers.getG();this.i_timerL=a.o_timers.getL();this.i_timerX=a.o_timers.getG();this.o_fsm.set(tsk_fsm_entry.prototype.CreateAlways(tsip_transac_ist_states_e.STARTED,tsip_transac_ist_actions_e.RECV_INVITE,tsip_transac_ist_states_e.PROCEEDING,__tsip_transac_ist_Started_2_Proceeding_X_INVITE,"tsip_transac_ist_Started_2_Proceeding_X_INVITE"),tsk_fsm_entry.prototype.CreateAlwaysNothing(tsip_transac_ist_states_e.STARTED,"tsip_transac_ist_Started_2_Started_X_any"),tsk_fsm_entry.prototype.CreateAlways(tsip_transac_ist_states_e.PROCEEDING,tsip_transac_ist_actions_e.RECV_INVITE,tsip_transac_ist_states_e.PROCEEDING,__tsip_transac_ist_Proceeding_2_Proceeding_X_INVITE,"tsip_transac_ist_Proceeding_2_Proceeding_X_INVITE"),tsk_fsm_entry.prototype.Create(tsip_transac_ist_states_e.PROCEEDING,tsip_transac_ist_actions_e.SEND_1XX,__tsip_transac_ist_cond_is_resp2invite,tsip_transac_ist_states_e.PROCEEDING,__tsip_transac_ist_Proceeding_2_Proceeding_X_1xx,"tsip_transac_ist_Proceeding_2_Proceeding_X_1xx"),tsk_fsm_entry.prototype.Create(tsip_transac_ist_states_e.PROCEEDING,tsip_transac_ist_actions_e.SEND_300_to_699,__tsip_transac_ist_cond_is_resp2invite,tsip_transac_ist_states_e.COMPLETED,__tsip_transac_ist_Proceeding_2_Completed_X_300_to_699,"tsip_transac_ist_Proceeding_2_Completed_X_300_to_699"),tsk_fsm_entry.prototype.Create(tsip_transac_ist_states_e.PROCEEDING,tsip_transac_ist_actions_e.SEND_2XX,__tsip_transac_ist_cond_is_resp2invite,tsip_transac_ist_states_e.ACCEPTED,__tsip_transac_ist_Proceeding_2_Accepted_X_2xx,"tsip_transac_ist_Proceeding_2_Accepted_X_2xx"),tsk_fsm_entry.prototype.CreateAlways(tsip_transac_ist_states_e.COMPLETED,tsip_transac_ist_actions_e.RECV_INVITE,tsip_transac_ist_states_e.COMPLETED,__tsip_transac_ist_Completed_2_Completed_INVITE,"tsip_transac_ist_Completed_2_Completed_INVITE"),tsk_fsm_entry.prototype.CreateAlways(tsip_transac_ist_states_e.COMPLETED,tsip_transac_ist_actions_e.TIMER_G,tsip_transac_ist_states_e.COMPLETED,__tsip_transac_ist_Completed_2_Completed_timerG,"tsip_transac_ist_Completed_2_Completed_timerG"),tsk_fsm_entry.prototype.CreateAlways(tsip_transac_ist_states_e.COMPLETED,tsip_transac_ist_actions_e.TIMER_H,tsip_transac_ist_states_e.TERMINATED,__tsip_transac_ist_Completed_2_Terminated_timerH,"tsip_transac_ist_Completed_2_Terminated_timerH"),tsk_fsm_entry.prototype.CreateAlways(tsip_transac_ist_states_e.COMPLETED,tsip_transac_ist_actions_e.RECV_ACK,tsip_transac_ist_states_e.CONFIRMED,__tsip_transac_ist_Completed_2_Confirmed_ACK,"tsip_transac_ist_Completed_2_Confirmed_ACK"),tsk_fsm_entry.prototype.CreateAlways(tsip_transac_ist_states_e.ACCEPTED,tsip_transac_ist_actions_e.RECV_INVITE,tsip_transac_ist_states_e.ACCEPTED,__tsip_transac_ist_Accepted_2_Accepted_INVITE,"tsip_transac_ist_Accepted_2_Accepted_INVITE"),tsk_fsm_entry.prototype.Create(tsip_transac_ist_states_e.ACCEPTED,tsip_transac_ist_actions_e.SEND_2XX,__tsip_transac_ist_cond_is_resp2invite,tsip_transac_ist_states_e.ACCEPTED,__tsip_transac_ist_Accepted_2_Accepted_2xx,"tsip_transac_ist_Accepted_2_Accepted_2xx"),tsk_fsm_entry.prototype.CreateAlways(tsip_transac_ist_states_e.ACCEPTED,tsip_transac_ist_actions_e.TIMER_X,tsip_transac_ist_states_e.ACCEPTED,__tsip_transac_ist_Accepted_2_Accepted_timerX,"tsip_transac_ist_Accepted_2_Accepted_timerX"),tsk_fsm_entry.prototype.CreateAlways(tsip_transac_ist_states_e.ACCEPTED,tsip_transac_ist_actions_e.RECV_ACK,tsip_transac_ist_states_e.ACCEPTED,__tsip_transac_ist_Accepted_2_Accepted_iACK,"tsip_transac_ist_Accepted_2_Accepted_iACK"),tsk_fsm_entry.prototype.CreateAlways(tsip_transac_ist_states_e.ACCEPTED,tsip_transac_ist_actions_e.TIMER_L,tsip_transac_ist_states_e.TERMINATED,__tsip_transac_ist_Accepted_2_Terminated_timerL,"tsip_transac_ist_Accepted_2_Terminated_timerL"),tsk_fsm_entry.prototype.CreateAlways(tsip_transac_ist_states_e.CONFIRMED,tsip_transac_ist_actions_e.TIMER_I,tsip_transac_ist_states_e.TERMINATED,__tsip_transac_ist_Confirmed_2_Terminated_timerI,"tsip_transac_ist_Confirmed_2_Terminated_timerI"),tsk_fsm_entry.prototype.CreateAlways(tsk_fsm.prototype.__i_state_any,tsip_transac_ist_actions_e.TRANSPORT_ERROR,tsip_transac_ist_states_e.TERMINATED,__tsip_transac_ist_Any_2_Terminated_X_transportError,"tsip_transac_ist_Any_2_Terminated_X_transportError"),tsk_fsm_entry.prototype.CreateAlways(tsk_fsm.prototype.__i_state_any,tsip_transac_ist_actions_e.ERROR,tsip_transac_ist_states_e.TERMINATED,__tsip_transac_ist_Any_2_Terminated_X_Error,"tsip_transac_ist_Any_2_Terminated_X_Error"),tsk_fsm_entry.prototype.CreateAlways(tsk_fsm.prototype.__i_state_any,tsip_transac_ist_actions_e.CANCEL,tsip_transac_ist_states_e.TERMINATED,__tsip_transac_ist_Any_2_Terminated_X_cancel,"tsip_transac_ist_Any_2_Terminated_X_cancel"))}tsip_transac_ist.prototype.start=function(a){var b=-1;if(a&&!this.b_running){this.b_running=true;b=this.fsm_act(tsip_transac_ist_actions_e.RECV_INVITE,a)}return b};tsip_transac_ist.prototype.set_last_response=function(a){this.o_lastResponse=a};function __tsip_transac_ist_cond_is_resp2invite(a,b){return b.is_response_to_invite()}function __tsip_transac_ist_Started_2_Proceeding_X_INVITE(a){var b=a[0];var c=a[1];var e=-1;if(c){var d;if((d=new tsip_response(100,"Trying (sent from the Transaction Layer)",c))){e=(b.send(b.s_branch,d)>0?0:-1);b.set_last_response(d)}}if(e==0){e=b.get_dialog().callback(tsip_dialog_event_type_e.I_MSG,c)}return e}function __tsip_transac_ist_Proceeding_2_Proceeding_X_INVITE(a){var b=a[0];var c=-1;if(b.o_lastResponse){c=(b.send(b.s_branch,b.o_lastResponse)>0?0:-1)}return c}function __tsip_transac_ist_Proceeding_2_Proceeding_X_1xx(a){var b=a[0];var c=a[1];var d;d=(b.send(b.s_branch,c)>0?0:-1);b.set_last_response(c);return d}function __tsip_transac_ist_Proceeding_2_Completed_X_300_to_699(a){var b=a[0];var c=a[1];var d;if(!b.b_reliable){b.timer_schedule("ist","G")}d=(b.send(b.s_branch,c)>0?0:-1);b.set_last_response(c);b.timer_schedule("ist","H");return d}function __tsip_transac_ist_Proceeding_2_Accepted_X_2xx(a){var b=a[0];var c=a[1];var d;d=(b.send(b.s_branch,c)>0?0:-1);b.set_last_response(c);b.timer_schedule("ist","X");b.i_timerX<<=1;b.timer_schedule("ist","L");return d}function __tsip_transac_ist_Completed_2_Completed_INVITE(a){var b=a[0];var c;if(b.o_lastResponse){c=(b.send(b.s_branch,b.o_lastResponse)>0?0:-1)}return c}function __tsip_transac_ist_Completed_2_Completed_timerG(a){var b=a[0];var c;if(b.o_lastResponse){c=(b.send(b.s_branch,b.o_lastResponse)>0?0:-1)}b.i_timerG=Math.min(b.i_timerG<<1,b.get_stack().o_timers.getT2());b.timer_schedule("ist","G");return c}function __tsip_transac_ist_Completed_2_Terminated_timerH(a){var b=a[0];return b.get_dialog().callback(tsip_dialog_event_type_e.TRANSPORT_ERROR,null)}function __tsip_transac_ist_Completed_2_Confirmed_ACK(a){var b=a[0];b.timer_cancel("G");b.timer_schedule("ist","I");return 0}function __tsip_transac_ist_Accepted_2_Accepted_INVITE(a){var b=a[0];if(b.o_lastResponse){return(b.send(b.s_branch,b.o_lastResponse)>0?0:-1)}return 0}function __tsip_transac_ist_Accepted_2_Accepted_2xx(a){var b=a[0];var c=a[1];var d;d=(b.send(b.s_branch,c)>0?0:-1);b.set_last_response(c);return d}function __tsip_transac_ist_Accepted_2_Accepted_timerX(a){var b=a[0];if(b.o_lastResponse){var c=(b.send(b.s_branch,b.o_lastResponse)>0?0:-1);if(c==0){b.i_timerX<<=1;b.timer_schedule("ist","X")}return c}return 0}function __tsip_transac_ist_Accepted_2_Accepted_iACK(a){var b=a[0];var c=a[1];b.timer_cancel("X");return b.get_dialog().callback(tsip_dialog_event_type_e.I_MSG,c)}function __tsip_transac_ist_Accepted_2_Terminated_timerL(a){return 0}function __tsip_transac_ist_Confirmed_2_Terminated_timerI(a){return 0}function __tsip_transac_ist_Any_2_Terminated_X_transportError(a){var b=a[0];return b.get_dialog().callback(tsip_dialog_event_type_e.TRANSPORT_ERROR,null)}function __tsip_transac_ist_Any_2_Terminated_X_Error(a){var b=a[0];return b.get_dialog().callback(tsip_dialog_event_type_e.ERROR,null)}function __tsip_transac_ist_Any_2_Terminated_X_cancel(a){return 0}function __tsip_transac_ist_onterm(a){a.timer_cancel("H");a.timer_cancel("I");a.timer_cancel("G");a.timer_cancel("L");a.timer_cancel("X");return a.deinit()}function __tsip_transac_ist_event_callback(a,c,b){if(!a){tsk_utils_log_error("Invalid argument");return -1}var d=-1;switch(c){case tsip_transac_event_type_e.INCOMING_MSG:if(b&&b.is_request()){if(b.is_invite()){d=a.fsm_act(tsip_transac_ist_actions_e.RECV_INVITE,b)}else{if(b.is_ack()){d=a.fsm_act(tsip_transac_ist_actions_e.RECV_ACK,b)}}}break;case tsip_transac_event_type_e.OUTGOING_MSG:if(b&&b.is_response()){if(b.is_1xx()){d=a.fsm_act(tsip_transac_ist_actions_e.SEND_1XX,b)}else{if(b.is_2xx()){d=a.fsm_act(tsip_transac_ist_actions_e.SEND_2XX,b)}else{if(b.is_3456()){d=a.fsm_act(tsip_transac_ist_actions_e.SEND_300_to_699,b)}}}}break;case tsip_transac_event_type_e.CANCELED:case tsip_transac_event_type_e.TERMINATED:case tsip_transac_event_type_e.TIMEDOUT:break;case tsip_transac_event_type_e.ERROR:d=a.fsm_act(tsip_transac_ist_actions_e.ERROR,b);break;case tsip_transac_event_type_e.TRANSPORT_ERROR:d=a.fsm_act(tsip_transac_ist_actions_e.TRANSPORT_ERROR,b);break}return d}function __tsip_transac_ist_timer_callback(b,a){if(b){if(a==b.o_timerH){b.fsm_act(tsip_transac_ist_actions_e.TIMER_H,null)}else{if(a==b.o_timerI){b.fsm_act(tsip_transac_ist_actions_e.TIMER_I,null)}else{if(a==b.o_timerG){b.fsm_act(tsip_transac_ist_actions_e.TIMER_G,null)}else{if(a==b.o_timerL){b.fsm_act(tsip_transac_ist_actions_e.TIMER_L,null)}else{if(a==b.o_timerX){b.fsm_act(tsip_transac_ist_actions_e.TIMER_X,null)}}}}}}};