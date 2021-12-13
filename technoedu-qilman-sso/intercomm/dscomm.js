"use strict";

var ds_server_addr = "";
var ds_callback_func = null;

function DSCommInit(addr , callback_func) { 
	ds_server_addr = addr; 
	ds_callback_func = callback_func; 
}

function DSCommClient(msg)
{
	window.WebSocket = window.WebSocket || window.MozWebSocket;

	var connection = new WebSocket(ds_server_addr);
	connection.onopen = function () {
		console.log("Connect to DSServer Success\n");
	
		connection.send(msg);
		console.log("sendDS:"+msg);
	};

	connection.onerror = function (error) {
		alert('상호 연동 서버 접속에 실패했습니다.' );
	};

	// most important part - incoming messages
	connection.onmessage = function (message) {
		try {
			var json = JSON.parse(message.data);
		} catch (e) {
			alert('This doesn\'t look like a valid JSON:', message.data);
			return;
		}

		if (ds_callback_func )ds_callback_func(json);
		connection.close();
	}
}

function DSSendGetASPList()
{
	DSCommClient('{"cmd":"ASPListReq"}');
}

function DSSendSearchUser(val)
{
	var msg = '{"cmd":"SearchUserReq", "data": { '; 
	if ( val.search("@") != -1 )
		msg += '"email":"'+val+'"}}';
	else
		msg += '"name":"'+val+'"}}';
	DSCommClient(msg);
}

function DSSendInviteUser(callerName, callerEmail, callerOrg, callerDept, userinfo, conf_title, sip_uri, invite_msg)
{
	var sip_from = userinfo.email.substring(0,userinfo.email.indexOf("@"))+"@61.252.54.66";
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

