<?
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
header("Cache-Control: no-store, no-cache, must-revalidate"); 
header("Cache-Control: post-check=0, pre-check=0", false); 
header("Pragma: no-cache");

// 모바일 체크
$mobile_agent = array("Ipone","Ipod","Android","Blackberry","SymbianOS|SCH-M\d+","Opera Mini", "Windows ce", "Nokia", "sony" );
$check_mobile = false;
for($i=0; $i<sizeof($mobile_agent); $i++){
	if(stripos( $_SERVER['HTTP_USER_AGENT'], $mobile_agent[$i] )){
		$check_mobile = true;
		include "meeting_layout_mobile.php";
		exit;
	}
}
session_start();
include "../api/config/dbinfo.inc.php";

$room_id = $_POST['rid'];
//$user_id = $_GET['user_id'];

$updir = '../upload/contents/r'.$room_id;

// 방리스트에서 다큐먼트 리스트를 얻어온다.
$db = new mysqli($DBHOST, $DBUSER, $DBPASSWD, $DBNAME);
$db->set_charset("utf8");
if ($db->connect_error) {
	die("DB 에러");
}
$qry = "SELECT title, start_datetime, end_datetime, doclist, user_id, end_datetime > DATE_ADD(NOW(),INTERVAL 1 MINUTE), record FROM room_list WHERE id = ".$room_id;
$rt = $db->query($qry);
if ($rt->num_rows <= 0) {
	die("DB 에러:방을 찾을수 없음");
}

$row = $rt->fetch_row();
$conftitle = $row[0];
$confstarttime = $row[1];
$confendtime = $row[2];
$doclistraw = $row[3];
$room_maker = $row[4];
$is_room_time_ok  = $row[5];
$is_record = $row[6];

$rt->close();
$db->close();

$doclistcnt = 0;
if ( $doclistraw != NULL )
{
	$doclistjson = urldecode($doclistraw);
	$doclist = json_decode($doclistjson);		
	$doclistcnt = count($doclist);
}
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<link rel="chrome-webstore-item" href="https://chrome.google.com/webstore/detail/nnghkendnamekpehmjnphfkhkhnaochf">
<title>Mentorservice</title>

<!-- css -->
<link rel="stylesheet" type="text/css" href="../css/basic.css">
<link rel="stylesheet" type="text/css" href="../css/meeting_layout.css">
<link rel="stylesheet" type="text/css" href="../css/chatbubble.css">

<script src="../js/config.js?v=<?=uniqid()?>" type="text/javascript"></script>
<script src="../js/common.js" type="text/javascript"></script>

<script src="../js/html5shiv.js" type="text/javascript"></script>
<script src="../js/jquery/jquery-1.11.1.min.js" type="text/javascript"></script>
<script src="../js/underscore/underscore-min.js" type="text/javascript"></script>
<script src="../js/simple-slider.min.js"></script>
<script src='../js/spectrum.js'></script>
<script src='../js/shortcut.js'></script>
<!-- splitter -->
<script src="../js/jquery-ui.min.js"></script>
<link type="text/css" rel="stylesheet" href="../css/layout-default-latest.css" />
<script type="text/javascript" src="../js/jquery.layout-1.3.0.rc30.80.js"></script>

<link rel='stylesheet' href='../css/spectrum.css' />
<link href="../css/simple-slider.css" rel="stylesheet" type="text/css" />

<script src='../js/dscomm.js'></script>
<style>
input.pdf_img_button {
width: 45px;
height: 45px;
cursor: pointer;
border: none;
}

.div-video{
width: 100%; 
-webkit-transition-property: height;
-moz-transition-property: height;
-o-transition-property: height;
-webkit-transition-duration: 2s;
-moz-transition-duration: 2s;
-o-transition-duration: 2s;
}
.record_icon {
position: absolute;
margin-left: -23px;
margin-top: 2px;
}
</style>
<?
// 이미 시간이 지난 방이면 방으로 접근 하지 못하게 한다.
if ( $is_room_time_ok == 0 ) 
{
?>
<script type="text/javascript">
	alert('강의 시간이 지났습니다. 다시 확인해주세요.');
	setTimeout(function() {
		history.back(-1);
	}, 500);
	
</script>
<body>
</body>
</html>
<?
exit;
}
?>

<script type="text/javascript">
$.ajaxSetup({async:false});

checkLogin();

<?
if (!empty($_POST["rid"])) {
	echo "var g_rid = ".$_POST["rid"].";\n";
}

if (!empty($_POST["rpw"])) {
	echo "var g_rpw = '".$_POST["rpw"]."';\n";
}

if (!empty($_POST["control"]) && $_POST["control"] == 1) {
	echo "var g_control = true;\n";
} else {
	echo "var g_control = false;\n";
}

if (!empty($room_maker)) {
	echo "var g_roomMaker = '".$room_maker."';\n";
}
?>

if (g_rid.length <= 0) {
	alert('방 번호가 없습니다\n다시 확인해 주세요');
	
	if (connection != null) {
		//alert('{"cmd":"enter_exit", "roomidx": "<?=$room_id?>", "user_id":"'+g_user_id+'", "user_name":"'+g_user_name+'"}');
		connection.send('{"cmd":"exit_room", "roomidx": "<?=$room_id?>", "user_id":"'+g_user_id+'", "user_name":"'+g_user_name+'"}');
	}
	
	setTimeout(function() {
		history.back(-1);
	}, 500);
}

var g_did = getMcuDid(g_rid);
var g_uid = '';

var bIsAudioMute = false;
var bIsVideoMute = false;
var bIsSpeakerMute = false;
var mcuCompType = 1;
var mcuPosMax   = 1;

var mcuScreenSize = 6; // HD(Wide)
var mcuProfileId = 'HD'; 

var posImgFile = "screen1.png";

$(document).ready(function() {
	
	if (g_roomMaker != g_user_id) {
		// 방장이 아닐 경우
		$('.option5').hide();
		$('.option6').hide();
		$('.chodae').hide();
		$('.sip').hide();
		document.getElementById('btn_toggleinvite').disabled = true;
	}
	else {
		// 방장일 경우 초대를 위해 해당 그룹을 로딩
		var postJsonData = {
			user_id : g_user_id
		};
		$.post( g_apiUrlRoot+"group_list.php", postJsonData, function( dataJson) {
			if (dataJson.rt_code == 0) {
				_.each(dataJson.group, function(element, index) {
					$('#group_select').append('<option value="'+element.id+'">'+element.group_name+'</option>');
				});
			} 
		}, "json");
		
		// 참가자 선택을 위해 모든 친구 목록 불러오기
		setAllFriends();
	}
	
	window.onbeforeunload = function() {
		sipHangUp();
	};

	function exitRoom()
	{
		if ( confirm("강의를 종료합니다. 방을 나가시겠습니까?") != 0 )
		{
			if (connection != null) {
				//alert('{"cmd":"enter_exit", "roomidx": "<?=$room_id?>", "user_id":"'+g_user_id+'", "user_name":"'+g_user_name+'"}');
				connection.send('{"cmd":"exit_room", "roomidx": "<?=$room_id?>", "user_id":"'+g_user_id+'", "user_name":"'+g_user_name+'"}');
			}
			
			sipHangUp();
			
			if (g_roomMaker == g_user_id) {
				/*
				// 방장이 나가면 방을 닫음
				$.post('../mcutest/mcucomm.php', {
					cmd: 'RemoveConferenceByDID',
					did: g_did
					} 
				).done ( function ( data ) {
					val = eval('(' + data + ')');
					if ( val == null ) {
						alert("error:"+data);
						return;
					}
					location.href = "/";
				});
				*/
				location.href = "/";
			} else {
				location.href = "/";
			}
			return false;
		}
	}
	
	$('#homelogo').click(function(e) { return exitRoom() });

	$('#room_exit').click(function(e) { return exitRoom() });
	
	$('#btn_fullscreen').click(function(e) {
		var elem = document.getElementById("video_remote");
		if (elem.requestFullscreen) {
			elem.requestFullscreen();
		} else if (elem.mozRequestFullScreen) {
			elem.mozRequestFullScreen();
		} else if (elem.webkitRequestFullscreen) {
			elem.webkitRequestFullscreen();
		}
		return false;
    });
	
	$('#btn_mute_mic').click(function(e) {
		bIsAudioMute = !bIsAudioMute;
		muteLocalAudio(bIsAudioMute);

		if ( bIsAudioMute ) $('#img_mute_mic').attr("src", "../images/option2_off.png");
		else $('#img_mute_mic').attr("src", "../images/option2.png");
    });

	$('#btn_mute_sound').click(function(e) {
		var vid = document.getElementById("video_remote");
		bIsSpeakerMute = !bIsSpeakerMute;
		vid.muted = bIsSpeakerMute;	

		if ( bIsSpeakerMute) $('#img_mute_sound').attr("src", "../images/option3_off.png");
		else $('#img_mute_sound').attr("src", "../images/option3.png");
    });
	
	$('#btn_mute_video').click(function(e) {
		bIsVideoMute = !bIsVideoMute;
		muteLocalVideo(bIsVideoMute);

		if ( bIsVideoMute) $('#img_mute_video').attr("src", "../images/option4_off.png");
		else $('#img_mute_video').attr("src", "../images/option4.png");
    });

	$('.btn_chodae').click(function(e) {
		
		if (g_roomMaker != g_user_id) {
			alert('방장만 이용 가능합니다');
			return false;
		}
		
		if ($('#is_sip').is(':checked')) {
			//  SIP 초대
		} else {
			// 일반 사용자 초대
			var inviteUserID = $('#invite_user_id').val();
			
			if (inviteUserID == null || inviteUserID.length <= 4) {
				alert('초대할 사용자의 아이디를 정확히 입력해주세요');
				return false;
			}
			
			$.post( g_apiUrlRoot+"room_invite_user.php", {rid:g_rid, user_id:inviteUserID}, function(dataJson) {
				if (dataJson.rt_code == 0) {
					var postJsonData = {
						to_id : inviteUserID,
						from_id : g_user_id,
						msg : g_user_name+'님이 강의 방에 초대하셨습니다\nMy 페이지에서 확인해주세요'
					}
					$.post( g_apiUrlRoot+"msg_send.php", postJsonData, function(dataJson) {
						alert(inviteUserID+'님을 강의방에 초대했습니다');
					}, 'json');
				} else if (dataJson.rt_code == 3000) {
					alert('최대 참여자 수를 초과해 초대할 수 없습니다');
				} else if (dataJson.rt_code == 4000) {
					alert('이미 초대된 사용자입니다');
				} else {
					alert('사용자를 초대할 수 없습니다');
				}
			}, 'json');
		}
    });
	
	$('#is_sip').change(function(e) {
        if (!$(this).is(':checked')) {
			$('#invite_user_id').attr('placeholder', '사용자 아이디');
		} else {
			$('#invite_user_id').attr('placeholder', 'SIP 단말기 번호');
		}
    });

	$('#label_roomid').text(g_did);
});	

function room_init() {
	$.post( g_apiUrlRoot+"room_info.php", {rid:g_rid}, function(dataJson) {
		
		//$('.title').text(dataJson.title);
		
		if (dataJson.user_id != g_user_id) {
			// 방장이 아닌 경우
			if (!(typeof g_rpw == "undefined") && dataJson.pw != g_rpw) {
				alert('강의방의 비밀번호가 맞지 않습니다\n확인 후 다시 입장해 주세요');
				
				if (connection != null) {
					//alert('{"cmd":"enter_exit", "roomidx": "<?=$room_id?>", "user_id":"'+g_user_id+'", "user_name":"'+g_user_name+'"}');
					connection.send('{"cmd":"exit_room", "roomidx": "<?=$room_id?>", "user_id":"'+g_user_id+'", "user_name":"'+g_user_name+'"}');
				}
				
				setTimeout(function() {
					history.back(-1);
				}, 500);
				return false;
			}
		}
		
		// get room uid
		$.post('../mcutest/mcucomm.php', {cmd: 'GetConfList'} )
		.done( 
			function ( data ) {
				val = eval('(' + data + ')');
				if ( val == null ) {
					alert("error:"+data);
					return;
				}
				
				for ( var i = 0; i < val.conflist.length; i++ ) {
					if (val.conflist[i].did == g_did) {
						g_uid = val.conflist[i].uid;
						break;
					}
				}
			}
		);

		if (g_user_id == dataJson.user_id) { // 방장
			mcuScreenSize = dataJson.resolution;
			mcuCompType = dataJson.layout_type;
			
			if ( mcuScreenSize == 6 ) { // HD
				setVideoRatioWide();
				mcuProfileId = 'HD';
			}
			else if ( mcuScreenSize == 14 ) mcuProfileId = 'XGA';
			else if ( mcuScreenSize == 2 ) mcuProfileId = 'SD';
			

			changePosSelData();

			if (g_uid.length <= 0) {
				var dtClose = new Date(dataJson.end_datetime);
				
				$.post('../mcutest/mcucomm.php', {
					cmd: 'CreateConference',
					name: g_rid,
					did: g_did,
					mixerId: 'mixer',
					profileId: mcuProfileId,
					compType: dataJson.layout_type,
					vad: 0,
					size: mcuScreenSize, // XGA
					closeTimerUse: true,
					closeTime: dtClose.format('yyyy-MM-dd hh:mm:ss'),
					recordUse: (dataJson.record == '1') ? true : false,
					autoCloseUse: false,
					} 
				).done ( function ( data ) {
					val = eval('(' + data + ')');
					if ( val == null ) {
						alert("error:"+data);
						return;
					}
					g_uid = val.confuid;
					
					$.post( g_apiUrlRoot+"room_set_record_url.php", {rid:g_rid, record_url:val.recordUrl}, function(dataJson) {});
				});
			}
		} else { // 참여자
			if (g_uid.length <= 0) {
				alert('강의방이 존재하지 않습니다\n방장이 아직 강의방을 생성하지 않았을 수도 있습니다\n확인 후 다시 참여해 주세요');
				history.back(-1);
				return false;
			}

			// 방정보를 얻어옴.
			$.post('../mcutest/mcucomm.php', {
				cmd: 'GetConfRoomInfo',
				uid: g_uid
			}
			).done ( function (data ) {
				val = eval('(' + data + ')');
				if ( val == null ) {
					alert("error:"+data);
					return;
				}
				if ( val.ret == 'true' ) {
					mcuScreenSize = val.size;
					mcuProfileId = val.profileid
					mcuCompType = val.comptype;

					if ( mcuScreenSize == 6 ) { // HD
						setVideoRatioWide();
					}
				}
			});
		}
		
		setTimeout( function() {
			setMCUInfo(g_did, g_user_id, g_user_id, dataJson.pw);
			
			// 방 제어만 할 경우 dipRegister는 하지 않음
			if (g_control == false) {
				sipRegister();
			} else {
			  	$('#movie').hide();
				updateConfRoomUserList(); //방정보 불러오기
				controlClick(); //함수실행
			}
		}, 500);

	},
	'json'
	);
}

</script>

<script src="../js/sip.min.js?v=1" type="text/javascript"> </script>
<script type='text/javascript' src="room_comm.js?v=5"></script>

<script type="text/javascript">
	function controlClick() {
		if(g_control == true)
		{
			updatePosSelData();
			setTimeout(function() {
			      controlClick();
				    }, 20000);
		} 
	} //20초마다 갱신
	function toggleLiveResizing () {
		$.each( $.layout.config.borderPanes, function (i, pane) {
			var o = myLayout.options[ pane ];
			o.livePaneResizing = !o.livePaneResizing;
		});
	};
	
	function toggleStateManagement ( skipAlert, mode ) {
		if (!$.layout.plugins.stateManagement) return;

		var options	= myLayout.options.stateManagement
		,	enabled	= options.enabled // current setting
		;
		if ($.type( mode ) === "boolean") {
			if (enabled === mode) return; // already correct
			enabled	= options.enabled = mode
		}
		else
			enabled	= options.enabled = !enabled; // toggle option

		if (!enabled) { // if disabling state management...
			myLayout.deleteCookie(); // ...clear cookie so will NOT be found on next refresh
			if (!skipAlert)
				alert( 'This layout will reload as the options specify \nwhen the page is refreshed.' );
		}
		else if (!skipAlert)
			alert( 'This layout will save & restore its last state \nwhen the page is refreshed.' );
	};

	// set EVERY 'state' here so will undo ALL layout changes
	// used by the 'Reset State' button: myLayout.loadState( stateResetSettings )
	var stateResetSettings = {
		north__size:		"auto"
	,	north__initClosed:	false
	,	north__initHidden:	false
	,	south__size:		"auto"
	,	south__initClosed:	false
	,	south__initHidden:	false
	,	west__size:			0.7
	,	west__initClosed:	false
	,	west__initHidden:	false
	,	east__size:			"auto"
	,	east__initClosed:	true
	,	east__initHidden:	true
	};

	var myLayout;

	$(document).ready(function () {

		// this layout could be created with NO OPTIONS - but showing some here just as a sample...
		// myLayout = $('body').layout(); -- syntax with No Options

		myLayout = $('body').layout({

		//	reference only - these options are NOT required because 'true' is the default
			closable:					true	// pane can open & close
		,	resizable:					true	// when open, pane can be resized 
		,	slidable:					true	// when closed, pane can 'slide' open over other panes - closes on mouse-out
		,	livePaneResizing:			true
		,   draggable:					true

		//	some resizing/toggling settings
		,	north__slidable:			false	// OVERRIDE the pane-default of 'slidable=true'
		,	north__togglerLength_closed: '100%'	// toggle-button is full-width of resizer-bar
		,	north__spacing_closed:		20		// big resizer-bar when open (zero height)
		,	north__resizable:			false	// OVERRIDE the pane-default of 'slidable=true'
		,   north__spacing_open:		0

		,	south__resizable:			false	// OVERRIDE the pane-default of 'resizable=true'
		,	south__spacing_open:		0		// no resizer-bar when open (zero height)
		,	south__spacing_closed:		20		// big resizer-bar when open (zero height)

		//	some pane-size settings
		,	west__minSize:				300
<?
	if ( $check_mobile == true )	{
?>
		,	west__size:					0.8
		,	center__size:				0.2
		,	west__spacing_open: 20
		,	west__spacing_closed: 20
		,	south__size:				0
		,	north__size:				0
<?
	}
	else {
?>
		,	west__size:					0.5
		,	center__size:				0.5
		,	west__spacing_open: 10
		,	west__spacing_closed: 10
<?
	}
?>
		,	west__onopen_end: function() { var video = document.getElementById("video_remote"); video.play();}

		,	east__size:					0
		,	east__minSize:				0	
		,	east__maxSize:				0 


		,	center__minWidth:			100
		
		//	some pane animation settings
		,	west__animatePaneSizing:	false
		,	west__fxSpeed_size:			"fast"	// 'fast' animation when resizing west-pane
		,	west__fxSpeed_open:			200	// 1-second animation when opening west-pane
		,	west__fxSettings_open:		{ easing: "easeOutBounce" } // 'bounce' effect when opening
		,	west__fxName_close:			"none"	// NO animation when closing west-pane

		//	enable showOverflow on west-pane so CSS popups will overlap north pane
		,	west__showOverflowOnHover:	false

		//	enable state management
		,	stateManagement__enabled:	false // automatic cookie load & save enabled by default

		,	showDebugMessages:			false // log and/or display messages from debugging & testing code
		});
		
<?
	if ( $check_mobile == true )	{
?>
		$('#btShowVideoScreen').click( function(e) { 
			myLayout.open('west');
		});

		$('#btShowDocScreen').click( function(e) { 
			myLayout.close('west');
		});
<?
}
?>
 	
	});
	</script>

<?
	$starttime = strtotime($confstarttime);
	$strstarttime = date("H:i", $starttime);

	$endtime = strtotime($confendtime);
	$strendtime = date("H:i", $endtime);
?>

<body id=main_body>
<div class="ui-layout-north">
<?
	if ( $check_mobile == false )	{
?>
<ul id="header">
	<li class="logo"><a href="#" id="homelogo"><img src="../images/logo.png" height=32></a></li>
	<li class="subject"><?=$conftitle?> (<?=$strstarttime?> ~ <?=$strendtime?>, 방번호:<span id=label_roomid></span>)
	<?
		if ( $is_record == 1 ) echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="../images/pointer.png" class="record_icon"><font color=red>녹화중</font>';
	?>
	</li>
	<li><img src="../images/w_close.png" height=30 id="room_exit" style="cursor: pointer;"></li>
</ul>
<?
}
?>
</div>

		<!-- 화면영상 -->
	<div class="ui-layout-west">

<?
	if ( $check_mobile == true )	{
?>
<ul id="header" style="min-width:500px">
	<li class="logo"><a href="#" id="homelogo"><img src="../images/logo.png" height=32></a></li>
	<li class="subject"><?=$conftitle?> (<?=$strstarttime?> ~ <?=$strendtime?>, 방번호:<span id=label_roomid></span>)
	<?
		if ( $is_record == 1 ) echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="../images/pointer.png" class="record_icon"><font color=red>녹화중</font>';
	?>
	</li>
	<li><img src="../images/w_close.png" height=30 id="room_exit" style="cursor: pointer;"></li>
</ul>

<?
}
?>
		<div class="left_area">
			<div id="movie">
					<div id="divVideo" class='div-video'>
						<div id="divVideoRemote" style='height:auto; width:100%'>
							<video class="video" width="100%" height="auto" id="video_remote" autoplay style="opacity: 100; 
								background-color: #FFFFFF; -webkit-transition-property: opacity; -webkit-transition-duration: 2s;">
							</video>
						</div>
						<div id="divVideoLocal" style='border:0px solid #000; display:none;'>
							<video class="video" width="88px" height="72px" id="video_local" autoplay muted style="opacity: 0;
								margin-top: -80px; margin-left: 5px; background-color: #000000; -webkit-transition-property: opacity;
								-webkit-transition-duration: 2s;">
							</video>
						</div>
					</div>	
					<!-- Creates all ATL/COM objects right now 
						Will open confirmation dialogs if not already done
					-->
					<div style="display:none">
						<object id="fakeVideoDisplay" classid="clsid:5C2C407B-09D9-449B-BB83-C39B7802A684" style="visibility:hidden;"> </object>
						<object id="fakeLooper" classid="clsid:7082C446-54A8-4280-A18D-54143846211A" style="visibility:visible; width:0px; height:0px"> </object>
						<object id="fakeSessionDescription" classid="clsid:DBA9F8E2-F9FB-47CF-8797-986A69A1CA9C" style="visibility:hidden;"> </object>
						<object id="fakeNetTransport" classid="clsid:5A7D84EC-382C-4844-AB3A-9825DBE30DAE" style="visibility:hidden;"> </object>
						<object id="fakePeerConnection" classid="clsid:56D10AD3-8F52-4AA4-854B-41F4D6F9CEA3" style="visibility:hidden;"> </object>
					</div>
			</div>
			<div id="movie_option">
				<a href="#" id="btn_fullscreen"><img src="../images/option1.png"></a>
				<a href="#" id="btn_mute_sound"><img src="../images/option3.png" id="img_mute_sound"></a>
				<a href="#" id="btn_mute_mic"><img src="../images/option2.png" id="img_mute_mic"></a>
				<a href="#" id="btn_mute_video"><img src="../images/option4.png" id="img_mute_video"></a>
				<a href="#" class="option5"><img src="../images/option5.png"></a>
				<a href="#" class="option6"><img src="../images/option6.png"></a>
				<a href="#" id="btn_screenshare" class="option7"><img src="../images/option7.png" id="img_screenshare" ></a>

				<ul id="screen_kind">
					<li>화면 레이아웃 변경(단축키 : Shift+F1 ~ F12)</li>
					<li>
						<img id="vid_layout_sel_1" style="cursor: pointer;" src="../images/screen1.png">
						<img id="vid_layout_sel_2" style="cursor: pointer;" src="../images/screen2.png">
						<img id="vid_layout_sel_1_1" style="cursor: pointer;" src="../images/screen1-1.png">
						<img id="vid_layout_sel_4" style="cursor: pointer;" src="../images/screen4.png">
						<img id="vid_layout_sel_1_3" style="cursor: pointer;" src="../images/screen1-3.png">
						<img id="vid_layout_sel_1_3r" style="cursor: pointer;" src="../images/screen1-3r.png">
						<img id="vid_layout_sel_1_4r" style="cursor: pointer;" src="../images/screen1-4r.png">
						<img id="vid_layout_sel_6" style="cursor: pointer;" src="../images/screen6.png">
						<img id="vid_layout_sel_7" style="cursor: pointer;" src="../images/screen7.png">
						<img id="vid_layout_sel_8" style="cursor: pointer;" src="../images/screen8.png">
						<img id="vid_layout_sel_9" style="cursor: pointer;" src="../images/screen9.png">
						<img id="vid_layout_sel_16" style="cursor: pointer;" src="../images/screen16.png">
					</li>
				</ul>

				<ul id="screen_select">
					<li>위치<br>변경<li>
					<li><img id="img_pos_sel" src="../images/screen8.png"></li>
					<li> 01:<select><option>자동</option></select> </li>
					<li> 02:<select><option>자동</option></select> </li>
					<li> 03:<select><option>자동</option></select> </li>
					<li> 04:<select><option>자동</option></select> </li>
					<li> 05:<select><option>자동</option></select> </li>
					<li> 06:<select><option>자동</option></select> </li>
					<li> 07:<select><option>자동</option></select> </li>
					<li> 08:<select><option>자동</option></select> </li>
					<li> 09:<select><option>자동</option></select> </li>
					<li> 10:<select><option>자동</option></select> </li>
					<li> 11:<select><option>자동</option></select> </li>
					<li> 12:<select><option>자동</option></select> </li>
					<li> 13:<select><option>자동</option></select> </li>
					<li> 14:<select><option>자동</option></select> </li>
					<li> 15:<select><option>자동</option></select> </li>
					<li> 16:<select><option>자동</option></select> </li>
				</ul>
			</div>

			<ul id="movie_chat">
				<!-- 음성 및 영상 제어 -->
				<li class="chat_list">
					<p class="title">참여자 리스트</p>
						<div class="list">
						</div>
					<input type="submit" id="btn_toggleinvite" value="사용자 초대 보기 / 접기">
				</li>

				<li class="msg_area">
					<div id="msg_content"></div>
					<div id="msg_txt"><input type="text" id="chat_msg" maxlength="500"><input type="submit" class="btn_send" value="전송" id="chat_send"></div>
				</li>
			</ul>
		
			<li id="invite_area">
				<section id="tab">
					<input type="radio" id="tab1" name="tb" checked />
					<input type="radio" id="tab3" name="tb" />
					<input type="radio" id="tab2" name="tb" />
					<label for="tab1" id="lab1">친구초대</label>
					<label for="tab2" id="lab2">E-MAIL 초대</label>
					<label for="tab3" id="lab3">SIP단말초대</label>
					<section id="sub1">
						<div id="invite_friend_area">
							<select id="group_select" class="user_select">
								<option value="">그룹 전체</option>
							</select>
							<span id="common_realtime_search">
								<input id="search_val" type="text" class="input_search">
								<input type="button" class="btn_search" value="검색">
							</span>
							<span>
								<fieldset id="friends_list">
								</fieldset>
							</span>
							<span class="invite_frend_msg">초대메시지 : <br>
								<textarea class="invite_msg" name="invite_msg" id="invite_msg">강의방으로 초대합니다.</textarea>
								<br><br>
								<input type="submit" id="btn_friend_invite" value="초대하기">
							</span>	
						</div>
					</section>
					<section id="sub2">
					<form name="emailSubmit" id="emailSubmit" action="mail.php">					            				
						<div id="invite_mail_area">
							<span class="invite_mail_label">E-MAIL 주소:</span>
								<input id="invite_mail_addr" name="emailValue" type="text" placeholder="">
								<input type="hidden" name="fromEmail">
								<input type="hidden" name="roomName">
								<input type="hidden" name="roomPassword">
								<input type="hidden" name="roomNumber">
								<input type="button" id="btn_mail_invite" value="초대하기">
								<br>
							<span class="invite_mail_label">* E-MAIL 주소를 입력하세요.</span>
						</div>
					</form>
																																																									</section>
					<section id="sub3">
						<div id="invite_sip_area"><span class="invite_sip_label">SIP 주소:</span> <input id="invite_sip_addr" type="text" placeholder="">
						<input type="submit" id="btn_sip_invite" value="초대하기">
						<br> <span class="invite_sip_label">* SIP 단말의 주소를 입력하세요.</span>
						</div>
					</section>
				</section>
			</li>

<?
	if ( $check_mobile == true )	{
?>
			<li class="folddocmsg" id="folddocmsg">
				<img src="../images/btsharedoc.png" width=80 height=80 id="btShowDocScreen" style="cursor: pointer;">
			</li>
<?
}
?>

		</div>
	</div>
		<!-- 문서 및 화이트보드 -->
	<div class="ui-layout-center">
		<div class="right_area">
			<!-- PDF 옵션 - PDF화면, 화이트보드, 펜, 레이저포인터, 클리어, 색상표  -->
			<div id="pdf_option">
				<a style="width:190px;">
				<select id="pdf_sel" type="text" class="pdf_file_sel" title="파일선택">
<?
	if ( $doclistcnt == 0 ) echo "<option>문서없음</option>";
	else {
		for ( $i=0; $i<$doclistcnt; $i++)
		{
			echo '<option value="'.$i.'">'.$doclist[$i]->{"name"}.'</option>';
		}
	}
?>
				</select>
				</a>
				<a><input id="btPdf" title="PDF 문서보기" type=button class="pdf_img_button" style="background: url(../images/pdf_option1.png) no-repeat;background-size: 45px;"></a>
				<a><input id="btWhiteBoard" title="화이트보드" type=button class="pdf_img_button" style="background: url(../images/pdf_option2.png) no-repeat;background-size: 45px;"></a>
				<a><input id="btPan" title="펜선택" type=button class="pdf_img_button" style="background: url(../images/pdf_option3.png) no-repeat;background-size: 45px;"></a>
				<a><input id="btLayserPT" title="레이저포인터" type=button class="pdf_img_button" style="background: url(../images/pdf_option4.png) no-repeat;background-size: 45px;"></a>
				<a><input id="btClear" title="지우기" type=button class="pdf_img_button" style="background: url(../images/pdf_option5.png) no-repeat;background-size: 45px;"></a>
				<a><input id='colorpicker' /></a>
				<a><canvas id="canvas_brush" width=40 height=40 title="펜굵기"></canvas></a>
				<a style="width:70px;margin-top:15px"><input id="brush_size" type="text" data-slider="true" data-slider-range="1,20" data-slider-step="1" title="펜굵기조정"></a>
			</div>
			<div id="pdf">
				<canvas id="canvas_share" width=800 height=700 style="margin-top:-10px;"></canvas>
			</div>
			<!-- PDF 페이지 -->
			<ul id="pdf_page">
				<li>
					<p class="btn_group">
						<a href="#" id="btStartPage"><img src="../images/btn_start.png"></a>
						<a href="#" id="btPrevPage"><img src="../images/btn_left.png"></a>
						<a><span id="pagelabel">페이지</span></a>
						<a href="#" id="btNextPage"><img src="../images/btn_right.png"></a>
						<a href="#" id="btEndPage"><img src="../images/btn_end.png"></a>
					</p>
				</li>
				<li><input id="pageMove_val" type="text"><input id="btPageMove" type="submit" value="이동"></li>					
			</ul>

<?
	if ( $check_mobile == true )	{
?>
			<ul id="foldvideo">
				<img src="../images/btvideo.png" width=80 height=80 id="btShowVideoScreen" style="cursor: pointer;">
			</ul>
<?
}
?>
			<!-- PDF 파일공유 -->
			<!--
			<ul id="pdf_file">
				<li class="file_list"><br><font size=8>+</font></li>
				<li><input type="button" value="파일업로드"></li>
			</ul>
			-->
		</div>
	</div>

<div class="ui-layout-south">
<div id="footer">COPYRIGHT(C) WOOKSUNG MEDIA CO., LTD. ALL RIGHTS RESERVED.</div>
</div>

<script type="text/javascript"> 
var pointerSize = 13; // pointer image size is 25
//-----------------------------------------------------------------------
// Websocket Part
//-----------------------------------------------------------------------
"use strict";

// if user is running mozilla then use it's built-in WebSocket
window.WebSocket = window.WebSocket || window.MozWebSocket;

// if browser doesn't support WebSocket, just show some notification and exit
if (!window.WebSocket) {
	alert('브라우져가 WebSocket 기술을 제공하지 않습니다.' );
}

var g_userInfoList = new Array();

// open connection
//var connection = new WebSocket('ws://127.0.0.1:1337');
var connection = new WebSocket(g_presenceServerUrl);

connection.onopen = function () {
	connection.send('{"cmd":"enter_room", "roomidx": "<?=$room_id?>", "user_id":"'+g_user_id+'", "user_name":"'+g_user_name+'", "user_email": "'+g_user_email+'", "roomaddr":"'+g_did+'@'+g_outboundSipSvrUrl.substring(6)+'"}');
	
	if (g_roomMaker == g_user_id) {
		// 방장
		$('.chat_list .list').append('<ul>\
							<li><b>'+g_user_name+'('+g_user_id+')</b></li>\
						</ul>');
	} else {
		// 일반
		$('.chat_list .list').append('<ul>\
							<li>'+g_user_name+'('+g_user_id+')'+'</li>\
						</ul>');
	}
	
	g_userInfoList.push({id:g_user_id, name:g_user_name, partId:"0", amute:"false", vmute:"false", is_external:"false"});
	
	chat_msg_add( g_user_name+'('+g_user_id+')', '님이 방에 참여하셨습니다.', false, 'pink');
};

connection.onerror = function (error) {
	alert('문서 공유 서버 접속에 실패했습니다.' );
};

// most important part - incoming messages
connection.onmessage = function (message) {

	// try to parse JSON message. Because we know that the server always returns
	// JSON this should work without any problem but we should make sure that
	// the massage is not chunked or otherwise damaged.
	try {
		var json = JSON.parse(message.data);
	} catch (e) {
		alert('This doesn\'t look like a valid JSON:', message.data);
		return;
	}

	if ( json.cmd == "enter_room" )
	{
		chat_msg_add( json.user_name+'('+json.user_id+')', '님이 방에 참여하셨습니다.', false, 'pink');
		$('#msg_content').scrollTop($('#msg_content').prop('scrollHeight'));
			
		addUserInfo(json.user_id, json.user_name, "0", "false", "false", "false");
		setTimeout( updateConfRoomUserList, 3000 );
	}
	
	if ( json.cmd == "add_user" )
	{
		addUserInfo(json.user_id, json.user_name, "0", "false", "false", "false");
	}

	if ( json.cmd == "exit_room" )
	{
		if (typeof json.user_id != "undefined") {
			/*
			if (json.user_id == g_roomMaker) {
				// 방장이 나갔을 경우 모든 참여자를 강퇴시킴
				alert('방장이 퇴실했습니다');
				location.href = "/";
			} else 
			*/

			{
				// 일반 참여자가 나갔을 경우 해당 참여자만 제거함
				//$('#msg_content').append('<b>'+json.user_name+'('+json.user_id+')님이 방에서 나가셨습니다.</b><br>');
				chat_msg_add( json.user_name+'('+json.user_id+')', '님이 방에서 나가셨습니다.', false, 'pink');
				$('#msg_content').scrollTop($('#msg_content').prop('scrollHeight'));
				
				$('ul[data-user-id="'+json.user_id+'"]').remove();
				
				var idx = -1;
				for(var i = 0; i < g_userInfoList.length; i++) {
					if (g_userInfoList[i].id == json.user_id) {
						idx = i;
						break;
					}
				}
				
				if (idx >= 0) {
					g_userInfoList.remove(idx);
				}
			}
		}
	}
	
	// 강퇴
	if ( json.cmd == "exit_force" )
	{
		if (typeof json.user_id != "undefined") {
			if (json.user_id == g_user_id) {
				
				if (connection != null) {
					//alert('{"cmd":"enter_exit", "roomidx": "<?=$room_id?>", "user_id":"'+g_user_id+'", "user_name":"'+g_user_name+'"}');
					connection.send('{"cmd":"exit_room", "roomidx": "<?=$room_id?>", "user_id":"'+g_user_id+'", "user_name":"'+g_user_name+'"}');
				}

				alert('방장에 의해 퇴장당하셨습니다');
				
				setTimeout(function() {
					location.href = "/";
				}, 500);
			}
		}
	}

	if ( json.cmd == "change_page" )
	{
		ChangeDocPage(json.page);
	}
	if ( json.cmd == "change_doc" )
	{
		ChangeDoc(json.docidx);
	}
	else if ( json.cmd == "draw_log" )
	{
		OnDrawLog(json.color, json.w, json.x, json.y);
	}
	else if ( json.cmd == "pointer_move" )
	{
		PointerMove(json.ox, json.oy, json.x, json.y, pointerSize);
	}
	else if ( json.cmd == "pointer_release" )
	{
		PointerRelease(json.ox, json.oy, pointerSize);
	}
	else if ( json.cmd == "chat" )
	{
		if (json.content.length <= 0) {
			return false;
		}
		
		//$('#msg_content').append('<b>'+json.user_name+ ':</b> ' + json.content+ '<br>'); 
		chat_msg_add( json.user_name, json.content, false, 'blue');

		 $('#msg_content').scrollTop($('#msg_content').prop('scrollHeight'));
	}
}

onSipConnectFunc = function() 
{
	setTimeout( updateConfRoomUserList, 1000 );
}

onSipDisconnectFunc = function()
{
	alert("시간이 종료되었거나 다른 이유로 방을 닫습니다.");

	setTimeout(function() {
		location.href = "/";
	}, 500);
}

var oldRoomUserListData = "none";

function updateConfRoomUserList()
{
	// get room uid
	$.post('../mcutest/mcucomm.php', {cmd: 'GetConfPartList', uid: g_uid} )
	.done( 
		function ( data ) {

			if ( oldRoomUserListData == data ) {
				console.log("mcuList no changed");
				return;
			}
			oldRoomUserListData = data;

			val = eval('(' + data + ')');
			if ( val == null ) 
			{
				alert("error:"+data);
				return;
			}
			
			for ( var i = 0; i < val.partlist.length; i++ ) 
			{
				var findUser = false;
				var user_id = val.partlist[i].name.match(/^(.+)@/)[1];
				var devName = val.partlist[i].devName.replace(/@.*/,""); //add by scchoi for DevName from MCU device_list.xml
				console.log("part:"+user_id);
				for (var j = 0; j < g_userInfoList.length; j++) 
				{
					if ( user_id == g_userInfoList[j].id )
					{
						findUser = true;
						console.log("find User:"+user_id+", partid:"+val.partlist[i].partid+"a:"+val.partlist[i].amute+", v:"+val.partlist[i].vmute);
						g_userInfoList[j].partId = val.partlist[i].partid;
						g_userInfoList[j].amute = val.partlist[i].amute;
						g_userInfoList[j].vmute = val.partlist[i].vmute;
						
						if ( g_userInfoList[j].amute == "true" )
							$('#uctl_amute_'+user_id).attr("src", "../images/v_off.png");
						else
							$('#uctl_amute_'+user_id).attr("src", "../images/v_on.png");

						if ( g_userInfoList[j].vmute == "true" )
							$('#uctl_vmute_'+user_id).attr("src", "../images/m_off.png");
						else
							$('#uctl_vmute_'+user_id).attr("src", "../images/m_on.png");
					}
				}
				if ( findUser == false )
				{	
					// Not Internal User
					addUserInfo(user_id, devName, val.partlist[i].partid, val.partlist[i].amute, val.partlist[i].vmute, "true");
				}
			}
			
			// Reverse Find miss user
			for (var j = 0; j < g_userInfoList.length; j++) 
			{
				findUser = false;
				if ( g_userInfoList[j].is_external == "false" ) continue;

				for ( var i = 0; i < val.partlist.length; i++ ) 
				{
					var user_id = val.partlist[i].name.match(/^(.+)@/)[1];
					if ( user_id == g_userInfoList[j].id ) findUser = true;
				}
				
				if ( findUser == false )
				{
					$('ul[data-user-id="'+g_userInfoList[j].id +'"]').remove();
					g_userInfoList.remove(j);
					j--;
				}
			}
			
			updatePosSelData();
		}
	);

	setTimeout( updateConfRoomUserList, 10*1000 ); // every 10 sec
}

function findPartIdAsUserId(user_id)
{
	for (var i = 0; i < g_userInfoList.length; i++) 
	{
		if ( user_id == g_userInfoList[i].id )
		{
			return g_userInfoList[i].partId;
		}
	}
	return null;
}

function addUserInfo(user_id, user_name, partId, amute, vmute, is_external)
{
	// Check Self ID
	if (user_id == g_user_id) {
		return;
	}
	
	// Check Already Exist in List
	for (var i = 0; i < g_userInfoList.length; i++) {
		if (g_userInfoList[i].id == user_id) {
			if ( g_userInfoList[i].is_external != is_external )
			{
				$('ul[data-user-id="'+g_userInfoList[i].id +'"]').remove();
				g_userInfoList.remove(i);
			}
			else return;
		}
	}

	appendUserList(user_id, user_name, amute, vmute, is_external);
	g_userInfoList.push({id:user_id, name:user_name, partId:partId, amute:amute, vmute:vmute, is_external:is_external});
}

function appendUserList(id, name, amute, vmute, is_external) {
	if (g_roomMaker == g_user_id) {
		// 내가 방장일 경우 컨트롤러를 보여줌
		$('.chat_list .list').append('<ul style="position: relative;" data-user-id="'+id+'" data-mute-audio='+ (amute=='false' ? '0' : '1') +' data-mute-video='+(vmute=='false' ? '0' : '1')+'>\
							<li style="width: 100%; float: left;">'+name+'('+(is_external == 'true' ? '<img src="../images/terminal.png" style="margin-bottem:-5px;">' : id) +')'+'</li>\
							<li style="float: right; padding-top: 6px; position: absolute; right: 0;">\
								<a class="joiner_mute_audio"><img style="cursor: pointer;" id="uctl_amute_' + id + '" src="../images/v_on.png"></a> <!-- 음소거 -->\
								<a class="joiner_mute_video"><img style="cursor: pointer;" id="uctl_vmute_' + id + '" src="../images/m_on.png"></a>	<!-- 영상소거 -->\
								<a class="joiner_exit"><img style="cursor: pointer;" src="../images/del.png"></a>	<!-- 퇴장 -->\
							</li>\
						</ul>');
	} else {
		if (g_roomMaker == id) {
			// 입장한 사람이 방장인 경우
			$('.chat_list .list').append('<ul style="position: relative;" data-user-id="'+id+'">\
								<li style="width: 100%; float: left;"><b>'+name+'('+id+')</b></li>\
							</ul>');
		} else {
			// 입장한 사람이 일반인 경우
			$('.chat_list .list').append('<ul style="position: relative;" data-user-id="'+id+'">\
								<li style="width: 100%; float: left;">'+name+'('+ (is_external == 'true' ? '<img src="../images/terminal.png" style="margin-bottem:-5px;">' : id)+')'+'</li>\
							</ul>');
		}
	}
}

// 참석자 오디오 뮤트
$(document).on('click', '.joiner_mute_audio', function() {
	var joinerID = $(this).parents('ul').data('user-id');
	
	if (joinerID.length <= 0) {
		return false;
	}
	
	var partId = findPartIdAsUserId(joinerID);
	if ( !partId ) return false;
	
	if (parseInt($(this).parents('ul').data('mute-audio'), 10) == 0) {
		$.post('../mcutest/mcucomm.php', {cmd: 'setAudioMute', uid: g_uid, partId: partId, flag: "true"} );
		$(this).parents('ul').data('mute-audio', '1');
	} else {
		$.post('../mcutest/mcucomm.php', {cmd: 'setAudioMute', uid: g_uid, partId: partId, flag: "false"} );
		$(this).parents('ul').data('mute-audio', '0');
	}

	setTimeout( updateConfRoomUserList, 100); 
});

// 참석자 비디오 뮤트
$(document).on('click', '.joiner_mute_video', function() {
	var joinerID = $(this).parents('ul').data('user-id');
	
	if (joinerID.length <= 0) {
		return false;
	}
	
	var partId = findPartIdAsUserId(joinerID);
	if ( !partId ) return false;
	
	if (parseInt($(this).parents('ul').data('mute-video'), 10) == 0) {
		$.post('../mcutest/mcucomm.php', {cmd: 'setVideoMute', uid: g_uid, partId: partId, flag: "true"} );
		$(this).parents('ul').data('mute-video', '1');
	} else {
		$.post('../mcutest/mcucomm.php', {cmd: 'setVideoMute', uid: g_uid, partId: partId, flag: "false"} );
		$(this).parents('ul').data('mute-video', '0');
	}
	setTimeout( updateConfRoomUserList, 100); // every 10 sec
});

// 참석자 강제 퇴장
$(document).on('click', '.joiner_exit', function() {
	var joinerID = $(this).parents('ul').data('user-id');

	if ( confirm(joinerID+"님을 퇴장시키시겠습니까?") != 0 )
	{
		if (joinerID.length <= 0) {
			return false;
		}
			
		connection.send('{"cmd":"exit_force", "roomidx": "<?=$room_id?>", "user_id":"'+joinerID+'"}');

		var partId = findPartIdAsUserId(joinerID);
		if ( partId ) 
		{
			$.post('../mcutest/mcucomm.php', {cmd: 'RemovePart', uid: g_uid, partId: partId} );

		}
		setTimeout( updateConfRoomUserList, 300); 
	}
});

function updatePosSelData()
{
	$.post('../mcutest/mcucomm.php', {cmd: 'GetConfSlotInfo', uid: g_uid} )
	.done( 
		function ( data ) 
		{
			val = eval('(' + data + ')');
			if ( val == null ) 
			{
				alert("error:"+data);
				return;
			}
			if ( val.ret == "false" ) return;

			mcuCompType = parseInt(val.comptype);
			changePosImgFile();
			$('#screen_select li').remove();
			$('#screen_select').append('<li>위치<br>변경<li><li><img id="img_pos_sel" src="../images/'+posImgFile+'"></li>');
				
			for ( var i = 0; i < val.slotlist.length; i++ ) 
			{
				var idx = i+1;
				var strNum = idx >= 10 ? ""+idx : "0"+idx;
				var appendStr = '<li>'+strNum+'<select onchange="setChangePos('+i+',this.value);">';

				if ( val.slotlist[i].partid == "0" )
					appendStr += '<option value="0" selected>[자동]</option>';
				else 
					appendStr += '<option value="0">[자동]</option>';

				if ( val.slotlist[i].partid == "-1" )
					appendStr += '<option value="-1" selected>[잠금]</option>';
				else
					appendStr += '<option value="-1">[잠금]</option>';

				for (var j = 0; j < g_userInfoList.length; j++) 
				{
					if ( g_userInfoList[j].partId == "0") //방제어시 방장이름이 추가되는걸 막기위함
					{
						continue;
					}

					if ( val.slotlist[i].partid == g_userInfoList[j].partId )
					{
						appendStr += '<option value="'+g_userInfoList[j].partId+'" selected>'+g_userInfoList[j].name+'</option>';
					}
					else
					{
						appendStr += '<option value="'+g_userInfoList[j].partId+'">'+g_userInfoList[j].name+'</option>';
					}
				}
				appendStr += '</select></li>';

				$('#screen_select').append(appendStr);
			}
		}
	);
	//var user_id = val.slotlist[i].devName.match(/^(.+)@/)[1];
}

function setChangePos(num, val)
{
 	$.post('../mcutest/mcucomm.php', {cmd: 'setMosaicSlot', uid: g_uid, num: num, id:val} );
}
function changePosImgFile()
{
	switch ( mcuCompType )
	{
		case 0: posImgFile = "screen1.png"; mcuPosMax = 1; break;
		case 1: posImgFile = "screen4.png"; mcuPosMax = 4; break;
		case 2: posImgFile = "screen9.png"; mcuPosMax = 9; break;
		case 3: posImgFile = "screen7.png"; mcuPosMax = 7; break;
		case 4: posImgFile = "screen8.png"; mcuPosMax = 8; break;
		case 5: posImgFile = "screen6.png"; mcuPosMax = 6; break;
		case 6: posImgFile = "screen2.png"; mcuPosMax = 2; break;
		case 7: posImgFile = "screen1-1.png"; mcuPosMax = 2; break;
		case 8: posImgFile = "screen1-3.png"; mcuPosMax = 4; break;
		case 9: posImgFile = "screen16.png"; mcuPosMax = 16; break;
		case 10: posImgFile = "screen1-4r.png"; mcuPosMax = 16; break;
		case 22: posImgFile = "screen1-3r.png"; mcuPosMax = 16; break;
	}
}

function changePosSelData()
{
	changePosImgFile();

	$('#screen_select li').remove();
	$('#screen_select').append('<li>위치<br>변경<li><li><img id="img_pos_sel" src="../images/'+posImgFile+'"></li>');
	$('#screen_select').append('<li>정보를 불러오는 중입니다.</li>');
	
	updatePosSelData();
}

function compTypeChange(compType)
{
	mcuCompType = compType;
 	$.post('../mcutest/mcucomm.php', {cmd: 'setCompositionType', uid: g_uid, compType: compType, size:mcuScreenSize, profileId:mcuProfileId} );
	changePosSelData();
}

$('#vid_layout_sel_1').click(function(e) { compTypeChange(0); });
$('#vid_layout_sel_2').click(function(e) { compTypeChange(6); });
$('#vid_layout_sel_1_1').click(function(e) { compTypeChange(7); });
$('#vid_layout_sel_4').click(function(e) { compTypeChange(1); });
$('#vid_layout_sel_1_3').click(function(e) { compTypeChange(8); });
$('#vid_layout_sel_1_3r').click(function(e) { compTypeChange(22); });
$('#vid_layout_sel_1_4r').click(function(e) { compTypeChange(10); });
$('#vid_layout_sel_6').click(function(e) { compTypeChange(5); });
$('#vid_layout_sel_7').click(function(e) { compTypeChange(3); });
$('#vid_layout_sel_8').click(function(e) { compTypeChange(4); });
$('#vid_layout_sel_9').click(function(e) { compTypeChange(2); });
$('#vid_layout_sel_16').click(function(e) { compTypeChange(9); });

if (g_roomMaker == g_user_id) {
	shortcut.add("Shift+F1",function() { compTypeChange(0); });
	shortcut.add("Shift+F2",function() { compTypeChange(6); });
	shortcut.add("Shift+F3",function() { compTypeChange(7); });
	shortcut.add("Shift+F4",function() { compTypeChange(1); });
	shortcut.add("Shift+F5",function() { compTypeChange(8); });
	shortcut.add("Shift+F6",function() { compTypeChange(22); });
	shortcut.add("Shift+F7",function() { compTypeChange(10); });
	shortcut.add("Shift+F8",function() { compTypeChange(5); });
	shortcut.add("Shift+F9",function() { compTypeChange(3); });
	shortcut.add("Shift+F10",function() { compTypeChange(4); });
	shortcut.add("Shift+F11",function() { compTypeChange(2); });
	shortcut.add("Shift+F12",function() { compTypeChange(9); });
}

//-----------------초대 관련 기능-----------------
 $(this).keypress(function(e){
         if(e.keyCode==13) {
				  return false; //자동 submit 방지
				  }
	  });
$('#btn_sip_invite').click(function() {
	sipuri = 'sip:'+$('#invite_sip_addr').val();
	if ( sipuri.length < 8 ) {
		alert('주소값이 알맞지 않습니다. 확인후 다시 시도해주세요');
		return;
	}
 	$.post('../mcutest/mcucomm.php', {cmd: 'InviteSIPAgent', uid: g_uid, dest: sipuri } );
	setTimeout( updateConfRoomUserList, 100); 
	alert('해당 단말으로 초대했습니다.');
});

$('.btn_search').click(function(e) {
	$(this).blur();
	
    if ($('#search_val').val().length <= 0) {
		alert('검색어가없어서 리스트를 초기화 합니다.');
	}
	
	if ($('#group_select').val() == null || $('#group_select').val() == '') {
		setAllFriends();
	} else {
		setGroupFriends($('#group_select').val())
	}
	
	return false;
});

$('#btn_mail_invite').click(function () {
		document.emailSubmit.fromEmail.value=g_roomMaker;
		document.emailSubmit.roomNumber.value=<?= htmlspecialchars($room_id)?>;
		
        var params = jQuery("#emailSubmit").serialize();
		             $.ajax({
					             type:"GET",
							     url:"./mail.php",
							     data:params,
							     success:function(data) {
							     	 alert("메일 전송이 완료되었습니다.");
							     }
							    })
						$.ajax({
							type:"GET",
							url:'../conference/landomjoin.php',
							data: params,
							success:function(data) {
							}
						})
							 });

function setAllFriends() {
	var postJsonData = {
		user_id : g_user_id,
		search_val : $('#search_val').val()
	};
	$.post( g_apiUrlRoot+"friend_list.php", postJsonData, function( dataJson) {
		if (dataJson.rt_code == 0) {
			
			$('#friends_list').empty();
			
			_.each(dataJson.friend, function(element, index) {
				if (element.status == 'done') {
					$('#friends_list').append('<p style="height:20px;"><input type="checkbox" data-user-id="'+element.id+'"> '+element.name+'</p>');
				}
			});
		} else {
			alert('죄송합니다\n서버 정보를 가져오지 못했습니다\n잠시 후 다시 접속해 주세요');
		}
	}, "json");
}

function setGroupFriends(gid) {
	var postJsonData = {
		group_id : gid,
		search_val : $('#search_val').val()
	};
	$.post( g_apiUrlRoot+"group_friend_list.php", postJsonData, function( dataJson) {
		if (dataJson.rt_code == 0) {
			
			$('#friends_list').empty();
			
			_.each(dataJson.friend, function(friend, index) {
				if (friend.status == 'done') {
					$('#friends_list').append('<p style="height:20px;"><input type="checkbox" data-user-id="'+friend.id+'"> '+friend.name+'<BR></p>');
				}
			});
		} else {
			alert('죄송합니다\n서버 정보를 가져오지 못했습니다\n잠시 후 다시 접속해 주세요');
		}
	}, "json");
}

$('#group_select').change(function(e) {
	
	$('#search_val').val('');
    
	if ($(this).val() == null || $(this).val() == '') {
		setAllFriends();
		return;
	}
	
	setGroupFriends($(this).val());
});

$('#btn_friend_invite').click( function () {
	var memberIDs = new Array();
	$('#friends_list input:checked').each(function(index, element) {
        memberIDs[index] = $(element).data('user-id');
    });

	if ( memberIDs.length <= 0 ) {
		alert("선택된 사용자가 없습니다.");
		return;
	}
	
	var msgInvite = "";
	if ($('#invite_msg').val() == null || $('#invite_msg').val().length <= 0) {
		msgInvite = "";
	} else {
		msgInvite = $('#invite_msg').val();
	}
	//console.log(memberIDs);

	document.getElementById('btn_friend_invite').disabled = true;
	document.getElementById('btn_friend_invite').value = '초대중...';
	
	var postJsonData = {
		room_id: <?=$room_id?>,
		member: memberIDs,
		user_id: g_user_id,
		start_datetime: '<?=$confstarttime?>',
		end_datetime: '<?=$confendtime?>',
		title: '<?=$conftitle?>',
		invite_msg: msgInvite
	};
	setTimeout(function () {
		$.post( g_apiUrlRoot+"invite_friend.php", postJsonData, function( dataJson) {
			if (dataJson.rt_code == 0) {
				alert('성공적으로 초대했습니다.');
			} else {
				alert('서버에러로 초대에 실패하였습니다.');
			}

			document.getElementById('btn_friend_invite').disabled = false;
			$('#btn_friend_invite').val('초대하기');
		}, "json");
	}, 100);
});

//------------------ 타사 사용자 검색/초청 ---------------------
var searchUserList = null;
var inviteUserIdx = -1;
var searchExtTimer = null;

function OnDSCommMsg( msg )
{
	console.log(msg);
	if ( msg.cmd == "ASPListResp" )
	{
	}
	else if ( msg.cmd == "SearchUserResp" )
	{
		searchUserList = msg.data.user_list;
		
		if ( msg.data.user_list.length == 0 ) {
			$('#extsite_search_alarm').html('<center><font color=red>해당하는 사용자를 찾지 못했습니다.</font></center>');
		}
		else {
			$('#extsite_search_alarm').html('<center>총 '+msg.data.user_list.length+'건의 사용자를 검색했습니다.</center>');
			$('#extsite_search_list').empty();
			for (var i=0; i<msg.data.user_list.length; i++)
			{
				var strUserInfo = '<tr><td>' + msg.data.user_list[i].service_name + '</td>' +
								  '<td>' + msg.data.user_list[i].name + '</td>' +
								  '<td>' + msg.data.user_list[i].email + '</td>' +
								  '<td>' + msg.data.user_list[i].org_name + '</td>' +
								  '<td>' + msg.data.user_list[i].dept_name + '</td>' +
								  '<td><input type=submit class="btn_extsite_invite" value="초대" onclick="InviteExtSite('+i+')"></td>' +
								  '</tr>';
				$('#extsite_search_list').append(strUserInfo);
			}
		}
		document.getElementById('btn_extsite_search').disabled = false;
		$('#btn_extsite_search').val("검색");

		if ( searchExtTimer != null ) clearTimeout(searchExtTimer);
	}
	else if ( msg.cmd == "InviteUserResp" )
	{
		if ( msg.result == "success") {
			$('#extsite_search_alarm').html('<center><font color=blue>'+searchUserList[inviteUserIdx].name+'님을 성공적으로 초대했습니다.</font></center>');
		}
		else {
			$('#extsite_search_alarm').html('<center><font color=red>'+searchUserList[inviteUserIdx].name+'님을 초청하는데 실패했습니다.</font></center>');
		}
	}
}

DSCommInit(g_dsCommSvr, OnDSCommMsg);

$('#btn_extsite_search').click( function () {
	var searchVal = $('#search_extsite_val').val();

	if ( searchVal.length < 1 ) {
		alert("입력값이 없습니다.");
		return;
	}
	$('#extsite_search_list').empty();

	document.getElementById('btn_extsite_search').disabled = true;
	$('#btn_extsite_search').val("검색중");

	$('#extsite_search_alarm').html('<center>검색중입니다...</center>');
	
	DSSendSearchUser(searchVal);
	
	searchExtTimer = setTimeout( function() { 
		document.getElementById('btn_extsite_search').disabled = false;
		$('#btn_extsite_search').val("검색");
		$('#extsite_search_alarm').html('<center><font color=red> 검색 시간이 초과하였습니다. 잠시후에 다시 시도해 주세요.</font></center>');
		}, 25*1000);
});

$("#search_extsite_val").keyup( function (e) {
	if (event.keyCode == 13 ) {
			$('#btn_extsite_search').click();
	}
	
	return false;
});


function InviteExtSite( idx )
{
	var message = prompt("초대 메시지를 입력해 주세요.", "강의에 초대합니다.");

	if ( message != null )
	{
		DSSendInviteUser(g_user_name, g_user_email, g_user_part, 
						 g_user_dept, searchUserList[idx], 
						 '<?=$conftitle?>' , g_did+'@'+g_outboundSipSvrUrl.substring(6), message);
		inviteUserIdx  = idx;
	}
}

//------------------ CANVAS Share WhiteBoard ---------------------
var docfileidx = 0;
<?
	if ($doclistcnt == 0 ) echo "var curPage = 0;";
	else echo "var curPage = 1;";
?>
var saveCurPage = curPage;
var fileBase;
var canvas=document.getElementById("canvas_share");
var ctx=canvas.getContext("2d");
var canvas_brush=document.getElementById("canvas_brush");
var ctxBrush=canvas_brush.getContext("2d");
var lastX;
var lastY;
var strokeColor="red";
var strokeWidth=2;
var canMouseX;
var canMouseY;
var isMouseDown=false;
var pancolor = "#000000";

var posLogCnt = 0;
var backImage = new Image();

var posLogX = "";
var posLogY = "";

var is_save_pointer_area = false;
var save_pointer_area;
var share_mode = "draw";

var pointerImg = new Image();
pointerImg.src = "../images/pointer.png";
pointerImg.onload = function () {
	//console.log("pointer.png loaded");
};

var maxPageList = new Array();
<?
	if ( $doclistcnt == 0 ) echo "maxPageList.push(0);";
	else {
		for ( $i=0; $i<$doclistcnt; $i++)
		{
			echo 'maxPageList.push('.$doclist[$i]->{"pagecnt"}.');';
		}
	}
?>	

function getImgFilebase(rid, idx, page)
{
	return '../upload/viewimage.php?rid='+rid+'&idx='+idx+'&page='+page;
}

canvas.addEventListener("touchstart", touchHandler, true);
canvas.addEventListener("touchmove", touchHandler, true);
canvas.addEventListener("touchend", touchHandler, true);
canvas.addEventListener("touchcancel", touchHandler, true);    

function PointerMove(ox, oy, x, y, size)
{
	if ( is_save_pointer_area == true )
	{
		ctx.putImageData(save_pointer_area, ox-size, oy-size);
	}
	save_pointer_area = ctx.getImageData(x-size, y-size, size*2, size*2);
	DrawPointer(x, y, size);
	is_save_pointer_area = true;
}

function PointerRelease(ox, oy, size)
{
	ctx.putImageData(save_pointer_area, ox-size, oy-size);
	is_save_pointer_area = false;
}

function DrawPointer(x, y, size)
{
	ctx.drawImage(pointerImg, x-size, y-size, 25, 25);
}

function handleMouseDown(e){
	var rect = canvas.getBoundingClientRect();
	canMouseX = parseInt(e.clientX-rect.left);
	canMouseY = parseInt(e.clientY-rect.top);

	//$("#downlog").html("Down: "+ canMouseX + " / " + canMouseY);

	// Put your mousedown stuff here
	lastX=canMouseX;
	lastY=canMouseY;
	isMouseDown=true;

	if ( share_mode == "pointer" )
	{
		PointerMove(canMouseX, canMouseY, canMouseX, canMouseY, pointerSize);
		sendPointerInfo("pointer_move", canMouseX, canMouseY, canMouseX, canMouseY);
		return;
	}
	
	posLogX = '["'+lastX+'"';
	posLogY = '["'+lastY+'"';
	posLogCnt++;
}

function handleMouseUp(e){
	var rect = canvas.getBoundingClientRect();
	canMouseX = parseInt(e.clientX-rect.left);
	canMouseY = parseInt(e.clientY-rect.top);

	//$("#uplog").html("Up: "+ canMouseX + " / " + canMouseY);

	// Put your mouseup stuff here
	isMouseDown=false;

	if ( share_mode == "pointer" )
	{
		PointerRelease(lastX, lastY, pointerSize);
		sendPointerInfo("pointer_release", lastX, lastY, canMouseX, canMouseY);
		return;
	}

	posLogX += "]";
	posLogY += "]";
	sendDrawingLog();
	//$("#xpos").html( "len:"+posLogX.length+", "+posLogX);
	//$("#ypos").html( "len:"+posLogY.length+", "+posLogY);
	posLogX = "";
	posLogY = "";
	posLogCnt=0;
}

function handleMouseOut(e){
	var rect = canvas.getBoundingClientRect();
	canMouseX = parseInt(e.clientX-rect.left);
	canMouseY = parseInt(e.clientY-rect.top);

	//$("#outlog").html("Out: "+ canMouseX + " / " + canMouseY);

	// Put your mouseOut stuff here
	isMouseDown=false;

	if ( share_mode == "pointer" )
	{
		PointerRelease(lastX, lastY, pointerSize);
		sendPointerInfo("pointer_release", lastX, lastY, canMouseX, canMouseY);
		return;
	}

	posLogX += "]";
	posLogY += "]";
	//$("#xpos").html( "len:"+posLogX.length+", "+posLogX);
	//$("#ypos").html( "len:"+posLogY.length+", "+posLogY);
	sendDrawingLog();
	posLogX = "";
	posLogY = "";
	posLogCnt=0;
}

function handleMouseMove(e){
	var rect = canvas.getBoundingClientRect();
	canMouseX = parseInt(e.clientX-rect.left);
	canMouseY = parseInt(e.clientY-rect.top);

	//$("#movelog").html("Move: "+ canMouseX + " / " + canMouseY);

	// Put your mousemove stuff here
	if(isMouseDown){

		if ( share_mode == "pointer" )
		{
			PointerMove(lastX, lastY, canMouseX, canMouseY, pointerSize);
			sendPointerInfo("pointer_move", lastX, lastY, canMouseX, canMouseY);
			lastX=canMouseX;
			lastY=canMouseY;
			return;
		}

		ctx.beginPath();
		ctx.moveTo(lastX,lastY);
		ctx.lineTo(canMouseX,canMouseY);
		ctx.lineWidth = strokeWidth;
		ctx.strokeStyle = pancolor;
		ctx.lineCap = "round";
		ctx.stroke();     

		lastX=canMouseX;
		lastY=canMouseY;

		posLogX += ',"'+lastX+'"';
		posLogY += ',"'+lastY+'"';
		posLogCnt++;

		if ( posLogCnt > 200 )
		{
			posLogX += "]";
			posLogY += "]";
			sendDrawingLog();
			posLogX = '["'+lastX+'"';
			posLogY = '["'+lastY+'"';
			posLogCnt = 1;
		}
	}
}

$("#canvas_share").mousedown(function(e){handleMouseDown(e);});
$("#canvas_share").mousemove(function(e){handleMouseMove(e);});
$("#canvas_share").mouseup(function(e){handleMouseUp(e);});
$("#canvas_share").mouseout(function(e){handleMouseOut(e);});

function touchHandler(event)
{
	var touches = event.changedTouches,
		first = touches[0],
		type = "";
	switch(event.type)
	{
		case "touchstart": type = "mousedown"; break;
		case "touchmove":  type="mousemove"; break;        
		case "touchend":   type="mouseup"; break;
		default: return;
	}

	//initMouseEvent(type, canBubble, cancelable, view, clickCount, 
	//           screenX, screenY, clientX, clientY, ctrlKey, 
	//           altKey, shiftKey, metaKey, button, relatedTarget);

	var simulatedEvent = document.createEvent("MouseEvent");
	simulatedEvent.initMouseEvent(type, true, true, window, 1, 
					first.screenX, first.screenY, 
					first.clientX, first.clientY, false, 
					false, false, false, 0/*left*/, null);

	first.target.dispatchEvent(simulatedEvent);
	event.preventDefault();
}

function setBackgroundCanvas(imageurl)
{
	//ctx.clearRect(0,0, canvas.width, canvas.height);
	//$("#dispContent").attr("src",imageurl);
	backImage.src=imageurl;	 
	backImage.onload = function () {
		clearCanvas();
	};
	clearCanvas();
}

function clearCanvas()
{
	var newwidth = canvas.width;
	var newheight = (canvas.width / backImage.width)*backImage.height;
	if (newheight > canvas.height ) {
		newheight = canvas.height;
		newwidth = 	(canvas.height / backImage.height)*backImage.width;
	}

	ctx.clearRect(0,0, canvas.width, canvas.height);
	if ( curPage > 0 ) 
	{
		ctx.drawImage(backImage, 0, 0, newwidth, newheight);
		$('#pagelabel').text(""+curPage+" / "+maxPageList[docfileidx]+" 페이지");
	}
	else {
		$('#pagelabel').text("화이트보드");
	}

	//console.log("w:"+backImage.width+", h:"+backImage.height+", cw:"+newwidth+", cy:"+newheight);
}

function sendDrawingLog()
{
	if ( posLogCnt < 2 ) return;
	var msg = '{"cmd":"draw_log", "roomidx": "<?=$room_id?>", "color": "'+pancolor+'", "w":"'+strokeWidth+'", "x":'+posLogX+', "y":'+posLogY+'}';
	connection.send(msg);
	//console.log("send:"+msg);
}

function sendPointerInfo(cmd, ox, oy, x, y)
{
	var msg = '{"cmd":"'+cmd+'", "roomidx": "<?=$room_id?>", "ox": "'+ox+'", "oy":"'+oy+'", "x":'+x+', "y":'+y+'}';
	connection.send(msg);
	//console.log("send:"+msg);
}

function OnDrawLog(color, lineWidth, xlog, ylog)
{
	ctx.beginPath();
	ctx.moveTo(xlog[0],ylog[0]);
	for (var i=1; i<xlog.length; i++)
	{
		ctx.lineTo(xlog[i],ylog[i]);
	}
	ctx.strokeStyle = color;
	ctx.lineWidth = lineWidth;
	ctx.lineCap = "round";
	ctx.stroke();     
}

function prevPage()
{
	if ( curPage == 1 ) return;
	curPage--;
	setBackgroundCanvas(getImgFilebase(<?=$room_id?>, docfileidx, curPage));

	SendChangePage(curPage);
}

function nextPage()
{
	if ( curPage == maxPageList[docfileidx]) return;
	curPage++;
	setBackgroundCanvas(getImgFilebase(<?=$room_id?>, docfileidx, curPage));

	SendChangePage(curPage);
}

function clearPage()
{
	clearCanvas();

	SendChangePage(curPage);
}

function ChangeDocPage(page)
{
	if ( page < 0 || page > maxPageList[docfileidx]) return;
	curPage = page;
	//$("#dispContent").attr("src",fileBase + curPage + ".png");
	
	if ( curPage == 0 ) {
		clearCanvas();
	}
	else {
		setBackgroundCanvas(getImgFilebase(<?=$room_id?>, docfileidx, curPage));
	}
	console.log("OnChangeDocPage:"+page);
}

function SendChangePage(page)
{
	var msg = '{"cmd":"change_page", "roomidx": "<?=$room_id?>", "page":"'+curPage+'"}';

	connection.send(msg);
	console.log("send:"+msg);
}

function SendChangeDoc(idx)
{
	var msg = '{"cmd":"change_doc", "roomidx": "<?=$room_id?>", "docidx":"'+idx+'"}';

	connection.send(msg);
	console.log("send:"+msg);
}

//------------- Component Event Process -------------

// resize the canvas to fill browser window dynamically
window.addEventListener('resize', resizeCanvas, false);
function resizeCanvas() {
//		canvas.width = window.innerWidth;
//		canvas.height = window.innerHeight;
//		drawStuff(); 
	//console.log("win w:"+window.innerWidth+", h:"+window.innerHeight);

	var left_area = $(".left_area");
	var screen = $("#movie");
	var screen_width = left_area.width();
	var screen_height = 3*screen_width / 4;

	//console.log("width"+ screen_width+"px"+", height"+ screen_height+"px");
	
}
resizeCanvas();

$(".option5").click(function(){
	$("#screen_kind").slideToggle("fast");
});

$('#btn_toggleinvite').click(function(){
	if (g_roomMaker == g_user_id) {
		$("#invite_area").slideToggle("fast");
		
	}
});

$(".option6").click(function(){
	$("#screen_select").slideToggle("fast");
	updatePosSelData();
});

$("#btStartPage").click( function (e) {
	if ( curPage == 0 ) return;		

	curPage = 1;
	setBackgroundCanvas(getImgFilebase(<?=$room_id?>, docfileidx, curPage));
	SendChangePage(curPage);
});

$("#btPrevPage").click( function (e) {
	if ( curPage == 0 ) return;		
	prevPage();
});

$("#btNextPage").click( function (e) {
	if ( curPage == 0 ) return;		
	nextPage();
});

$("#btEndPage").click( function (e) {
	if ( curPage == 0 ) return;		
	curPage = maxPageList[docfileidx];
	setBackgroundCanvas(getImgFilebase(<?=$room_id?>, docfileidx, curPage));
	SendChangePage(curPage);
});

$("#btClear").click( function (e) {
	clearPage();
});

$("#btPdf").click( function (e) {
	curPage = saveCurPage;
	clearCanvas();
	SendChangePage(curPage);
});

$("#btWhiteBoard").click( function (e) {
	if ( curPage != 0 ) saveCurPage  = curPage;
	curPage = 0;		
	clearCanvas();
	SendChangePage(curPage);
});

$("#btPan").click( function (e) {
	share_mode = "draw";
});

$("#btLayserPT").click( function (e) {
	share_mode = "pointer";
});

$('#chat_send').click( function (e) {
	var content = $("#chat_msg").val();
	
	if (content.length <= 0) {
		return false;
	}
	
	var msg = '{"cmd":"chat", "roomidx": "<?=$room_id?>", "user_id": "'+g_user_id+'", "user_name":"'+g_user_name+'", "content":"'+ content +'"}';
	connection.send(msg);
	//$('#msg_content').append('<b>'+g_user_name+':</b> ' + content + '<br>'); 
	chat_msg_add(g_user_name, content, true, 'yellow');

	$("#chat_msg").val("");

	$('#msg_content').scrollTop($('#msg_content').prop('scrollHeight'));
	
	return false;
});

function chat_msg_add( name, content, isRight, color )
{
	if ( isRight ) { 
		$('#msg_content').append('<div class="bubble bubble-alt '+color+'"><p>' +content + ': <b>'+name+'</b></p></div>'); 
 	}
	else {
		if ( color == 'pink' ) // system message
			$('#msg_content').append('<div class="bubble '+color+'"><p><b>'+name+'</b> ' +content + '</p></div>'); 
		else
			$('#msg_content').append('<div class="bubble '+color+'"><p><b>'+name+'</b> : ' +content + '</p></div>'); 
	}
}

$("#chat_msg").keyup( function (e) {
	if (event.keyCode == 13 ) {
			$('#chat_send').click();
	}
	
	return false;
});

$("#btPageMove").click( function (e) {
	if ( curPage == 0 ) return;
	var movepage = parseInt($('#pageMove_val').val());
	if ( movepage > maxPageList[docfileidx] || movepage < 1 ) return;
	curPage = movepage;
	setBackgroundCanvas(getImgFilebase(<?=$room_id?>, docfileidx, curPage));
	SendChangePage(curPage);
});

function ChangeDoc(idx)
{
	docfileidx = idx;
	curPage = 1;
	setBackgroundCanvas(getImgFilebase(<?=$room_id?>, docfileidx, curPage));

	//console.log("changeDoc:"+idx);
}

$("#pdf_sel").change( function () {
	ChangeDoc( parseInt($("#pdf_sel option:selected").val()) );

	SendChangeDoc(docfileidx);
});

$("#colorpicker").spectrum({
    showPaletteOnly: true,
	showPalette: true,
	clickoutFiresChange: true,
    color: '#000',
    palette: [
        ["#000","#444","#666","#999","#ccc","#eee","#f3f3f3","#fff"],
        ["#f00","#f90","#ff0","#0f0","#0ff","#00f","#90f","#f0f"],
        ["#e06666","#f6b26b","#ffd966","#93c47d","#76a5af","#6fa8dc","#8e7cc3","#c27ba0"],
        ["#c00","#e69138","#f1c232","#6aa84f","#45818e","#3d85c6","#674ea7","#a64d79"],
        ["#900","#b45f06","#bf9000","#38761d","#134f5c","#0b5394","#351c75","#741b47"],
        ["#600","#783f04","#7f6000","#274e13","#0c343d","#073763","#20124d","#4c1130"]
    ],
	change: function (color) {
	pancolor= color.toHexString();
	share_mode = "draw";
	}
});

function changeBrushSize(size)
{
	ctxBrush.clearRect(0,0, canvas_brush.width, canvas_brush.height);
	ctxBrush.beginPath();
	ctxBrush.arc(canvas_brush.width/2, canvas_brush.height/2, size/2, 0, 2*Math.PI, false);
	ctxBrush.fillStyle = 'black';
	ctxBrush.fill();
	ctxBrush.lineWidth = 0;
	ctxBrush.strokeStyle = '#000000';
	ctxBrush.stroke();
	strokeWidth = size;
}

$("#brush_size").bind("slider:changed", function (event, data) {
	//console.log("brush_size:"+data.value);
	changeBrushSize(data.value);
	share_mode = "draw";
});

setBackgroundCanvas(getImgFilebase(<?=$room_id?>, docfileidx, 1));
changeBrushSize(1);

</script>
<script src='mousedown.js'></script>
<script src='mouseup.js'></script>

<script>
//============================ SIP.JS ================================

// todo: need to check exact chrome browser because opera also uses chromium framework
var isChrome = !!navigator.webkitGetUserMedia;

var DetectRTC = {};

(function () {
	var screenCallback;
	DetectRTC.screen = {
		chromeMediaSource: 'screen',
		isExtensionInstalled : false,
		getSourceId: function(callback) {
			if(!callback) throw '"callback" parameter is mandatory.';
			screenCallback = callback;
			window.postMessage('get-sourceId', '*');
		},
		isChromeExtensionAvailable: function(callback) {
			if(!callback) return;

			if(DetectRTC.screen.chromeMediaSource == 'desktop') return callback(true);

			// ask extension if it is available
			window.postMessage('are-you-there', '*');

			setTimeout(function() {
				if(DetectRTC.screen.chromeMediaSource == 'screen') {
					callback(false);
				}
				else callback(true);
			}, 2000);
		},
		onMessageCallback: function(data) {
			if (!(typeof data == 'string' || !!data.sourceId)) return;

			console.log('chrome message', data);

			// "cancel" button is clicked
			if(data == 'PermissionDeniedError') {
				DetectRTC.screen.chromeMediaSource = 'PermissionDeniedError';
				if(screenCallback) return screenCallback('PermissionDeniedError');
				else throw new Error('PermissionDeniedError');
			}

			// extension notified his presence
			if(data == 'rtcmulticonnection-extension-loaded') {
				DetectRTC.screen.chromeMediaSource = 'desktop';
				DetectRTC.screen.isExtensionInstalled = true;
			}

			// extension shared temp sourceId
			if(data.sourceId) {
				DetectRTC.screen.sourceId = data.sourceId;
				if(screenCallback) screenCallback( DetectRTC.screen.sourceId );
			}
		},
		getChromeExtensionStatus: function (callback) {
			if (!!navigator.mozGetUserMedia) return callback('not-chrome');

			var extensionid = 'nnghkendnamekpehmjnphfkhkhnaochf';

			var image = document.createElement('img');
			image.src = 'chrome-extension://' + extensionid + '/icon.png';
			image.onload = function () {
				DetectRTC.screen.chromeMediaSource = 'screen';
				DetectRTC.screen.isExtensionInstalled = true;
				window.postMessage('are-you-there', '*');
				setTimeout(function () {
					if (!DetectRTC.screen.notInstalled) {
						callback('installed-enabled');
					}
				}, 2000);
			};
			image.onerror = function () {
				DetectRTC.screen.notInstalled = true;
				callback('not-installed');
			};
		}
	};

	// check if desktop-capture extension installed.
	if(window.postMessage && isChrome) {
		DetectRTC.screen.isChromeExtensionAvailable();
	}
})();


DetectRTC.screen.getChromeExtensionStatus(function(status) {
if(status == 'installed-enabled') {
	DetectRTC.screen.chromeMediaSource = 'desktop';
	DetectRTC.screen.isExtensionInstalled = true;
}
});

window.addEventListener('message', function (event) {
if (event.origin != window.location.origin) {
	return;
}

DetectRTC.screen.onMessageCallback(event.data);
});

console.log('current chromeMediaSource', DetectRTC.screen.chromeMediaSource);
</script>

<script>
var screen_constraints;

function captureUserMedia(callback, extensionAvailable) {
	console.log('captureUserMedia chromeMediaSource', DetectRTC.screen.chromeMediaSource);
	var content_width = 1024;
	var content_height = 768;

	screen_constraints = {
		mandatory: {
			chromeMediaSource: DetectRTC.screen.chromeMediaSource,
			maxWidth: screen.width < content_width ? screen.width : content_width,
			maxHeight: screen.height < content_height? screen.height :content_height,
			minAspectRatio: 1.33
		},
		optional: [{ // non-official Google-only optional constraints
			googTemporalLayeredScreencast: true
		}, {
			googLeakyBucket: true
		}]
	};

	// try to check if extension is installed.
	if(isChrome && typeof extensionAvailable == 'undefined' && DetectRTC.screen.chromeMediaSource != 'desktop') {
		DetectRTC.screen.isChromeExtensionAvailable(function(available) {
			captureUserMedia(callback, available);
		});
		return;
	}

	if(isChrome &&  DetectRTC.screen.chromeMediaSource == 'desktop' && !DetectRTC.screen.sourceId) {
		DetectRTC.screen.getSourceId(function(error) {
			if(error && error == 'PermissionDeniedError') {
				alert('PermissionDeniedError: User denied to share content of his screen.');
			}

			captureUserMedia(callback);
		});
		return;
	}

	if(isChrome && DetectRTC.screen.chromeMediaSource == 'desktop') {
		screen_constraints.mandatory.chromeMediaSourceId = DetectRTC.screen.sourceId;
		
		console.log('get sourceID', DetectRTC.screen.sourceId);
	}
	callback();
}

function mediaOptions(audio, video, remoteRender, localRender) {
    return {
        media: {
            constraints: {
                audio: audio,
                video: screen_constraints 
            },
            render: {
                remote: remoteRender,
                local: localRender
            }
        }
    };
}

function createUA(callerURI, displayName) {
    // https://stackoverflow.com/questions/7944460/detect-safari-browser
    var browserUa = navigator.userAgent.toLowerCase();
    var isSafari = false;
    var isFirefox = false;
    if (browserUa.indexOf("safari") > -1 && browserUa.indexOf("chrome") < 0) {
        isSafari = true;
    }
    else if (browserUa.indexOf("firefox") > -1 && browserUa.indexOf("chrome") < 0) {
        isFirefox = true;
    }

    var stripG722 = function (description) {
        description.sdp = stripPayload(description.sdp || "", "G722");
        return Promise.resolve(description);
    }

    var sessionDescriptionHandlerFactoryOptions = {};
    if (isSafari) {
        sessionDescriptionHandlerFactoryOptions.modifiers = [stripG722];
    }
    if (isFirefox) {
        sessionDescriptionHandlerFactoryOptions.alwaysAcquireMediaFirst = true;
    }

    var configuration = {
        uri: callerURI,
        authorizationUser: displayName,
        password: displayName,
        displayName: displayName,
        // Undocumented "Advanced" Options
        userAgentString: "Mentorservice",
        register: true,
        contactName: displayName,
        sessionDescriptionHandlerFactoryOptions: sessionDescriptionHandlerFactoryOptions,
        transportOptions: {
            traceSip: false,
            wsServers: g_webSocketServerURL
        }
    };
    var userAgent = new SIP.UA(configuration);
    return userAgent;
}

var sessionContent;
var sessionContentStateus = 'none';

function makeCall(userAgent, target, audio, video, remoteRender, localRender) {
	
	//initDetectRTC();
	//console.log(DetectRTC);

	if ( DetectRTC.screen.isExtensionInstalled == false )
	{
		try {
		chrome.webstore.install(
			'https://chrome.google.com/webstore/detail/nnghkendnamekpehmjnphfkhkhnaochf', 
			function() {
				location.reload();
			}, 
			function() {
				alert("본 기능을 사용하기 위해서는 크롬 확장 프로그램설치가 필요합니다.\n확장프로그램 설치후에 다시 접속해 주시기 바랍니다.\n팝업이 나타나지 않는다면 팝업윈도우를 활성화시켜주세요.");
				window.open("https://chrome.google.com/webstore/detail/mentorservice-screen-shar/nnghkendnamekpehmjnphfkhkhnaochf?hl=ko", "_blank" );
			});
		} catch(err) {
			console.log(err);
				alert("본 기능을 사용하기 위해서는 크롬 확장 프로그램설치가 필요합니다.\n확장프로그램 설치후에 다시 접속해 주시기 바랍니다.\n팝업이 나타나지 않는다면 팝업윈도우를 활성화시켜주세요.");
				window.open("https://chrome.google.com/webstore/detail/mentorservice-screen-shar/nnghkendnamekpehmjnphfkhkhnaochf?hl=ko", "_blank" );
		}
		return;
	}
		
    // makes the call
	captureUserMedia(function() {
    	var options = mediaOptions(audio, video, remoteRender, localRender);
		console.log("invite.option:");
		console.log(options);
    	sessionContent = userAgent.invite('sip:' + target, options);
		sessionContentStateus = 'inviting';
		sessionContent.on('accepted', function () {
				sessionContentStateus = 'accepted';
				console.log("Accept!\n");
            });
		sessionContent.on('bye', function () {
            sessionContent = null;
			DetectRTC.screen.chromeMediaSource = null;
			DetectRTC.screen.sourceId = null;
			sessionContentStateus = 'none';	
				console.log("Content:Bye Receive!\n");
            });
	});
}

var uaContents = createUA(g_user_id + "_content@mentorservice.co.kr", g_user_id + "_content");
var markAsRegistered = function () {
	console.log("SharedContent UA Regiseterd Content!!");
};
uaContents.on('registered', markAsRegistered);

$("#btn_screenshare").click(function(){
	if ( sessionContentStateus == 'waiting' )
	{
		//Nothing
		console.log("Waiting connect..\n");
	}
	else if ( sessionContentStateus == 'accepted')
	{
        sessionContent.bye();
        sessionContent = null;
		DetectRTC.screen.chromeMediaSource = null;
		DetectRTC.screen.sourceId = null;
		sessionContentStateus = 'none';	
		$('#img_screenshare').attr("src", "../images/option7.png");
	}
	else if ( sessionContentStateus == 'inviting' )
	{
        sessionContent.cancel();
        sessionContent = null;
		DetectRTC.screen.chromeMediaSource = null;
		DetectRTC.screen.sourceId = null;
		sessionContentStateus = 'none';	
		$('#img_screenshare').attr("src", "../images/option7.png");
	}
	else {
		sessionContentStateus = 'waiting';	
		var target = g_did + '@' + g_sipSvrUrl;
		makeCall(uaContents, target, false, true, null, null);
		$('#img_screenshare').attr("src", "../images/option7_off.png");
	}
});
</script>
</body>
<?
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
header("Cache-Control: no-store, no-cache, must-revalidate"); ?>
