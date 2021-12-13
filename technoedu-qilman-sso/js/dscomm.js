"use strict";

var ds_server_addr = "";
var ds_callback_func = null;
var ds_auto_close_use = true;
var ds_connection = null;

function DSCommInit(addr , callback_func) { 
	ds_server_addr = addr; 
	ds_callback_func = callback_func; 
}

function DSCommClient(msg)
{
	window.WebSocket = window.WebSocket || window.MozWebSocket;

	if ( ds_connection == null ) ds_connection = new WebSocket(ds_server_addr);

	ds_connection.onopen = function () {
		console.log("Connect to DSServer Success\n");
	
		ds_connection.send(msg);
		console.log("sendDS:"+msg);
	};

	ds_connection.onerror = function (error) {
		alert('상호 연동 서버 접속에 실패했습니다.' );
	};

	// most important part - incoming messages
	ds_connection.onmessage = function (message) {
		try {
			var json = JSON.parse(message.data);
		} catch (e) {
			alert('This doesn\'t look like a valid JSON:', message.data);
			return;
		}

		if (ds_callback_func) ds_callback_func(json);

		if ( ds_auto_close_use ) {
			ds_connection.close();
			ds_connection = null;
		}
	}
}

function DSSendGetASPList()
{
	DSCommClient('{"cmd":"ASPListReq"}');
}

function DSSendSearchUser(val)
{
	var msg = '{"cmd":"SearchUserReq", "data": { '; 
	if ( val.search("@") != -1 ) {
		msg += '"name":"", "email":"'+val+'"}}';
	}
	else {
		msg += '"name":"'+val+'", "email":""}}';
	}
	DSCommClient(msg);
}

function DSSendInviteUser(callerName, callerEmail, callerOrg, callerDept, userinfo, conf_title, sip_uri, invite_msg)
{
	var sip_from = userinfo.email.substring(0,userinfo.email.indexOf("@"));

	if ( userinfo.service_id.trim() == "saeha" ) {
		sip_from += "@saeha.com";
	}
	else if ( userinfo.service_id.trim() == "m2soft" ) {
		sip_from += "@m2soft.co.kr";
	}
	else if ( userinfo.service_id.trim() == "uprism" ) {
		sip_from += "@61.252.54.50";
	}
	else if ( userinfo.service_id.trim() == "nablecomm" ) {
		sip_from += "@nable.com";
	}
	else if ( userinfo.service_id.trim() == "wescan" ) {
		sip_from += "@nable.com";
	}
	else {
		sip_from += "@61.252.54.66";
	}

	//var sip_from = "";
	var msg = { cmd : "InviteUserReq",
				data : { service_id : userinfo.service_id,
						 org_id: userinfo.org_id,
						 email: userinfo.email,
						 conf_title:conf_title,
						 sip_to_uri:sip_uri,
						 sip_from_uri:sip_from,
						 invite_msg: invite_msg,
						 caller: { 
						 		name: callerName, 
						 		email: callerEmail, 
								org_name: callerOrg, 
								dept_name:callerDept
							 }
						}	
				};
	DSCommClient(JSON.stringify(msg));
}

function DSSendChatInit(sip_uri, name, email)
{
	ds_auto_close_use = false;

	var msg = { cmd : "ChatMsgInit",
				name: name,
				email: email,
				sipuri: sip_uri
				}
	DSCommClient(JSON.stringify(msg));
}

function DSSendChatMsg(sip_uri, sip_from, name, email, content)
{
	var msg = { cmd : "ChatMsgReq",
				data: 
				{ 
					sip_to_uri : sip_uri,
					sip_from_uri : sip_from,
					custom_id : "",
					msg: { text: content },
					sender : { name : name , email : email }
					}
				};

	ds_connection.send(JSON.stringify(msg));
}
