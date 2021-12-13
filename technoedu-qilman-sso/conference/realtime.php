<? include "../include/header.php"; ?> <!-- 실시간 회의방 신청 -->
<link rel="stylesheet" type="text/css" href="../css/conference.css">

<!--<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">-->
<link rel="stylesheet" type="text/css" href="../upload/css/jquery.fileupload.css">
<link rel="stylesheet" type="text/css" href="../upload/css/jquery.fileupload-ui.css">

<style>
#realtime { display:inline-block; *zoom:1; width:100%; }
#realtime > ul { width:100%; margin:0px; padding:0px; }
#realtime > ul > li { padding:10px 0px; color:#404141; line-height:30px; }
#realtime > ul > li > span { display:inline-block; font-size:1.1em; padding-right:30px; font-weight:bold; vertical-align:top; }

#realtime > ul > li div.room_layout { display:inline-block; width: 98px; height: 71px; }
#realtime > ul > li div.room_layout1 > span { float:left; width:100px; height:70px; line-height:70px; text-align:center; color:#ffffff; font-weight:bold; }
#realtime > ul > li div.room_layout1 > span:nth-child(1) { border-right:1px solid #b7b6b6; border-bottom:1px solid #b7b6b6; }
#realtime > ul > li div.room_layout1 > span:nth-child(2) { border-bottom:1px solid #b7b6b6; }
#realtime > ul > li div.room_layout1 > span:nth-child(3) { clear:both; border-right:1px solid #b7b6b6; }

#realtime > ul > li div.room_layout2 { display:inline-block; }
#realtime > ul > li div.room_layout2 > span { float:left; width:70px; height:70px; line-height:70px; text-align:center; color:#ffffff; font-weight:bold; }
#realtime > ul > li div.room_layout2 > span:nth-child(1) { width:210px; border-bottom:1px solid #b7b6b6; }
#realtime > ul > li div.room_layout2 > span:nth-child(2) { clear:both; border-right:1px solid #b7b6b6; }
#realtime > ul > li div.room_layout2 > span:nth-child(3) { border-right:1px solid #b7b6b6; }

#realtime > ul > li input[type=radio] { vertical-align:top; }
#realtime > ul > li input[type=text] { height:30px; }
#realtime > ul > li input[type=password] { height:30px; width:100px; }
#realtime > ul > li select { min-width:120px; border:1px solid #d3d3d3; height:30px; }
#realtime > ul > li fieldset { width:250px; height:200px; padding:0px; border:1px solid #d3d3d3; border-radius:5px; font-size:12px; font-weight:normal; overflow-x:hidden; overflow-y:scroll;}
#realtime > ul > li fieldset > span { display:block; height:30px; width:100%; font-size:14px; font-weight:bold; color:#5b5a5a; text-align:center; border-bottom:1px solid #d3d3d3; background:#f5f5f5; }
#realtime > ul > li fieldset > p > input[type=checkbox]{ margin-left:20px; }

#realtime > ul > li .name { width:470px; }
#realtime > ul > li .pwdbox{ width:100px; }
#realtime > ul > li .user_select { width:300px; height:34px; margin-right:10px; }

#realtime > ul > li .LRbtn { width:78px; vertical-align:middle; }
#realtime > ul > li .LRbtn > input[type=button]{ width:78px; height:50px; margin-top:30px; cursor:pointer; }
#realtime > ul > li .btn_right { border:0px; background:url("../images/Rarrow.png") 0 50% no-repeat; }
#realtime > ul > li .btn_left { border:0px; background:url("../images/Larrow.png") 0 50% no-repeat; }
#realtime > ul > li .msg { width:960px; }

#realtime > ul > li input[type=file] { width:400px; border:1px solid #d3d3d3; height:30px; }
#realtime > ul > li .btn_file { width:100px; height:30px; background:#3388c9; border-radius:5px; border:1px solid #2479ba; margin-left:10px; color:#ffffff; }
#realtime > ul > li .btn_cash { width:100px; height:30px; background:#f7f7f7; border-radius:5px; border:1px solid #d2d2d2; margin-left:30px; color:#9b9b9b; }

#realtime > ul > li .invite_msg { width:600px; height:80px; border:1px solid #d3d3d3; /*resize: none;*/ }

/* 재정의 */
#common_btn_area { width:370px; }

.btn {
  display: inline-block;
  padding: 6px 12px;
  margin-bottom: 0;
  font-size: 14px;
  font-weight: normal;
  line-height: 1.42857143;
  text-align: center;
  white-space: nowrap;
  vertical-align: middle;
  -ms-touch-action: manipulation;
      touch-action: manipulation;
  cursor: pointer;
  -webkit-user-select: none;
     -moz-user-select: none;
      -ms-user-select: none;
          user-select: none;
  background-image: none;
  border: 1px solid transparent;
  border-radius: 4px;
}
.btn:focus,
.btn:active:focus,
.btn.active:focus,
.btn.focus,
.btn:active.focus,
.btn.active.focus {
  outline: thin dotted;
  outline: 5px auto -webkit-focus-ring-color;
  outline-offset: -2px;
}
.btn:hover,
.btn:focus,
.btn.focus {
  color: #333;
  text-decoration: none;
}
.btn:active,
.btn.active {
  background-image: none;
  outline: 0;
  -webkit-box-shadow: inset 0 3px 5px rgba(0, 0, 0, .125);
          box-shadow: inset 0 3px 5px rgba(0, 0, 0, .125);
}
.btn.disabled,
.btn[disabled],
fieldset[disabled] .btn {
  pointer-events: none;
  cursor: not-allowed;
  filter: alpha(opacity=65);
  -webkit-box-shadow: none;
          box-shadow: none;
  opacity: .65;
}
.btn-default {
  color: #333;
  background-color: #fff;
  border-color: #ccc;
}
.btn-default:hover,
.btn-default:focus,
.btn-default.focus,
.btn-default:active,
.btn-default.active,
.open > .dropdown-toggle.btn-default {
  color: #333;
  background-color: #e6e6e6;
  border-color: #adadad;
}
.btn-default:active,
.btn-default.active,
.open > .dropdown-toggle.btn-default {
  background-image: none;
}
.btn-default.disabled,
.btn-default[disabled],
fieldset[disabled] .btn-default,
.btn-default.disabled:hover,
.btn-default[disabled]:hover,
fieldset[disabled] .btn-default:hover,
.btn-default.disabled:focus,
.btn-default[disabled]:focus,
fieldset[disabled] .btn-default:focus,
.btn-default.disabled.focus,
.btn-default[disabled].focus,
fieldset[disabled] .btn-default.focus,
.btn-default.disabled:active,
.btn-default[disabled]:active,
fieldset[disabled] .btn-default:active,
.btn-default.disabled.active,
.btn-default[disabled].active,
fieldset[disabled] .btn-default.active {
  background-color: #fff;
  border-color: #ccc;
}
.btn-default .badge {
  color: #fff;
  background-color: #333;
}
.btn-primary {
  color: #fff;
  background-color: #337ab7;
  border-color: #2e6da4;
}
.btn-primary:hover,
.btn-primary:focus,
.btn-primary.focus,
.btn-primary:active,
.btn-primary.active,
.open > .dropdown-toggle.btn-primary {
  color: #fff;
  background-color: #286090;
  border-color: #204d74;
}
.btn-primary:active,
.btn-primary.active,
.open > .dropdown-toggle.btn-primary {
  background-image: none;
}
.btn-primary.disabled,
.btn-primary[disabled],
fieldset[disabled] .btn-primary,
.btn-primary.disabled:hover,
.btn-primary[disabled]:hover,
fieldset[disabled] .btn-primary:hover,
.btn-primary.disabled:focus,
.btn-primary[disabled]:focus,
fieldset[disabled] .btn-primary:focus,
.btn-primary.disabled.focus,
.btn-primary[disabled].focus,
fieldset[disabled] .btn-primary.focus,
.btn-primary.disabled:active,
.btn-primary[disabled]:active,
fieldset[disabled] .btn-primary:active,
.btn-primary.disabled.active,
.btn-primary[disabled].active,
fieldset[disabled] .btn-primary.active {
  background-color: #337ab7;
  border-color: #2e6da4;
}
.btn-primary .badge {
  color: #337ab7;
  background-color: #fff;
}
.btn-success {
  color: #fff;
  background-color: #5cb85c;
  border-color: #4cae4c;
}
.btn-success:hover,
.btn-success:focus,
.btn-success.focus,
.btn-success:active,
.btn-success.active,
.open > .dropdown-toggle.btn-success {
  color: #fff;
  background-color: #449d44;
  border-color: #398439;
}
.btn-success:active,
.btn-success.active,
.open > .dropdown-toggle.btn-success {
  background-image: none;
}
.btn-success.disabled,
.btn-success[disabled],
fieldset[disabled] .btn-success,
.btn-success.disabled:hover,
.btn-success[disabled]:hover,
fieldset[disabled] .btn-success:hover,
.btn-success.disabled:focus,
.btn-success[disabled]:focus,
fieldset[disabled] .btn-success:focus,
.btn-success.disabled.focus,
.btn-success[disabled].focus,
fieldset[disabled] .btn-success.focus,
.btn-success.disabled:active,
.btn-success[disabled]:active,
fieldset[disabled] .btn-success:active,
.btn-success.disabled.active,
.btn-success[disabled].active,
fieldset[disabled] .btn-success.active {
  background-color: #5cb85c;
  border-color: #4cae4c;
}
.btn-success .badge {
  color: #5cb85c;
  background-color: #fff;
}
.btn-info {
  color: #fff;
  background-color: #5bc0de;
  border-color: #46b8da;
}
.btn-info:hover,
.btn-info:focus,
.btn-info.focus,
.btn-info:active,
.btn-info.active,
.open > .dropdown-toggle.btn-info {
  color: #fff;
  background-color: #31b0d5;
  border-color: #269abc;
}
.btn-info:active,
.btn-info.active,
.open > .dropdown-toggle.btn-info {
  background-image: none;
}
.btn-info.disabled,
.btn-info[disabled],
fieldset[disabled] .btn-info,
.btn-info.disabled:hover,
.btn-info[disabled]:hover,
fieldset[disabled] .btn-info:hover,
.btn-info.disabled:focus,
.btn-info[disabled]:focus,
fieldset[disabled] .btn-info:focus,
.btn-info.disabled.focus,
.btn-info[disabled].focus,
fieldset[disabled] .btn-info.focus,
.btn-info.disabled:active,
.btn-info[disabled]:active,
fieldset[disabled] .btn-info:active,
.btn-info.disabled.active,
.btn-info[disabled].active,
fieldset[disabled] .btn-info.active {
  background-color: #5bc0de;
  border-color: #46b8da;
}
.btn-info .badge {
  color: #5bc0de;
  background-color: #fff;
}
.btn-warning {
  color: #fff;
  background-color: #f0ad4e;
  border-color: #eea236;
}
.btn-warning:hover,
.btn-warning:focus,
.btn-warning.focus,
.btn-warning:active,
.btn-warning.active,
.open > .dropdown-toggle.btn-warning {
  color: #fff;
  background-color: #ec971f;
  border-color: #d58512;
}
.btn-warning:active,
.btn-warning.active,
.open > .dropdown-toggle.btn-warning {
  background-image: none;
}
.btn-warning.disabled,
.btn-warning[disabled],
fieldset[disabled] .btn-warning,
.btn-warning.disabled:hover,
.btn-warning[disabled]:hover,
fieldset[disabled] .btn-warning:hover,
.btn-warning.disabled:focus,
.btn-warning[disabled]:focus,
fieldset[disabled] .btn-warning:focus,
.btn-warning.disabled.focus,
.btn-warning[disabled].focus,
fieldset[disabled] .btn-warning.focus,
.btn-warning.disabled:active,
.btn-warning[disabled]:active,
fieldset[disabled] .btn-warning:active,
.btn-warning.disabled.active,
.btn-warning[disabled].active,
fieldset[disabled] .btn-warning.active {
  background-color: #f0ad4e;
  border-color: #eea236;
}
.btn-warning .badge {
  color: #f0ad4e;
  background-color: #fff;
}
.btn-danger {
  color: #fff;
  background-color: #d9534f;
  border-color: #d43f3a;
}
.btn-danger:hover,
.btn-danger:focus,
.btn-danger.focus,
.btn-danger:active,
.btn-danger.active,
.open > .dropdown-toggle.btn-danger {
  color: #fff;
  background-color: #c9302c;
  border-color: #ac2925;
}
.btn-danger:active,
.btn-danger.active,
.open > .dropdown-toggle.btn-danger {
  background-image: none;
}
.btn-danger.disabled,
.btn-danger[disabled],
fieldset[disabled] .btn-danger,
.btn-danger.disabled:hover,
.btn-danger[disabled]:hover,
fieldset[disabled] .btn-danger:hover,
.btn-danger.disabled:focus,
.btn-danger[disabled]:focus,
fieldset[disabled] .btn-danger:focus,
.btn-danger.disabled.focus,
.btn-danger[disabled].focus,
fieldset[disabled] .btn-danger.focus,
.btn-danger.disabled:active,
.btn-danger[disabled]:active,
fieldset[disabled] .btn-danger:active,
.btn-danger.disabled.active,
.btn-danger[disabled].active,
fieldset[disabled] .btn-danger.active {
  background-color: #d9534f;
  border-color: #d43f3a;
}
.btn-danger .badge {
  color: #d9534f;
  background-color: #fff;
}
.btn-link {
  font-weight: normal;
  color: #337ab7;
  border-radius: 0;
}
.btn-link,
.btn-link:active,
.btn-link.active,
.btn-link[disabled],
fieldset[disabled] .btn-link {
  background-color: transparent;
  -webkit-box-shadow: none;
          box-shadow: none;
}
.btn-link,
.btn-link:hover,
.btn-link:focus,
.btn-link:active {
  border-color: transparent;
}
.btn-link:hover,
.btn-link:focus {
  color: #23527c;
  text-decoration: underline;
  background-color: transparent;
}
.btn-link[disabled]:hover,
fieldset[disabled] .btn-link:hover,
.btn-link[disabled]:focus,
fieldset[disabled] .btn-link:focus {
  color: #777;
  text-decoration: none;
}
.btn-lg,
.btn-group-lg > .btn {
  padding: 10px 16px;
  font-size: 18px;
  line-height: 1.33;
  border-radius: 6px;
}
.btn-sm,
.btn-group-sm > .btn {
  padding: 5px 10px;
  font-size: 12px;
  line-height: 1.5;
  border-radius: 3px;
}
.btn-xs,
.btn-group-xs > .btn {
  padding: 1px 5px;
  font-size: 12px;
  line-height: 1.5;
  border-radius: 3px;
}
.btn-block {
  display: block;
  width: 100%;
}
.btn-block + .btn-block {
  margin-top: 5px;
}
.progress {
  height: 20px;
  margin-bottom: 20px;
  overflow: hidden;
  background-color: #f5f5f5;
  border-radius: 4px;
  -webkit-box-shadow: inset 0 1px 2px rgba(0, 0, 0, .1);
          box-shadow: inset 0 1px 2px rgba(0, 0, 0, .1);
}
.progress-bar {
  float: left;
  width: 0;
  height: 100%;
  font-size: 12px;
  line-height: 20px;
  color: #fff;
  text-align: center;
  background-color: #337ab7;
  -webkit-box-shadow: inset 0 -1px 0 rgba(0, 0, 0, .15);
          box-shadow: inset 0 -1px 0 rgba(0, 0, 0, .15);
  -webkit-transition: width .6s ease;
       -o-transition: width .6s ease;
          transition: width .6s ease;
}
.progress-striped .progress-bar,
.progress-bar-striped {
  background-image: -webkit-linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
  background-image:      -o-linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
  background-image:         linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
  -webkit-background-size: 40px 40px;
          background-size: 40px 40px;
}
.progress.active .progress-bar,
.progress-bar.active {
  -webkit-animation: progress-bar-stripes 2s linear infinite;
       -o-animation: progress-bar-stripes 2s linear infinite;
          animation: progress-bar-stripes 2s linear infinite;
}
.progress-bar-success {
  background-color: #5cb85c;
}
.progress-striped .progress-bar-success {
  background-image: -webkit-linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
  background-image:      -o-linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
  background-image:         linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
}
.progress-bar-info {
  background-color: #5bc0de;
}
.progress-striped .progress-bar-info {
  background-image: -webkit-linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
  background-image:      -o-linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
  background-image:         linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
}
.progress-bar-warning {
  background-color: #f0ad4e;
}
.progress-striped .progress-bar-warning {
  background-image: -webkit-linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
  background-image:      -o-linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
  background-image:         linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
}
.progress-bar-danger {
  background-color: #d9534f;
}
.progress-striped .progress-bar-danger {
  background-image: -webkit-linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
  background-image:      -o-linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
  background-image:         linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
}
</style>

<script type="text/javascript">
checkLogin(true, true);

$(document).ready(function() {
	if ( g_user_level <= 1 )
	{
		alert("회의 개설 권한이 있지 않습니다.\n관리자에게 연락하세요");
        	history.back(-1);
		return false;
	}
	
	$('#btn_cancel').click(function(e) {
        history.back(-1);
		return false;
    });
	
	$('#btn_create').click(function(e) {
		
		if (g_user_id == null || g_user_id == '') {
			alert('회의를 생성하시려면 로그인해 주세요');
			return false;
		}
		
		if (g_is_guest == true) {
			alert('Guest는 회의를 생성할 수 없습니다');
			return false;
		}
		
		// data check
		if ($('#max_member').val() <= 0) {
			alert('인원을 선택해 주세요');
			return false;
		}
		
		if ($('#duration').val() <= 0) {
			alert('시간을 선택해 주세요');
			return false;
		}
		
		if ($('#title').val().length <= 0) {
			alert('회의 이름을 입력해 주세요');
			return false;
		}
		
		var dtStart = new Date();
		var dtEnd = new Date(dtStart.getTime() + $('#duration').val()*60000);
		
		var memberIDs = new Array();
		$('#realtime_mem_list input').each(function(index, element) {
            memberIDs[index] = $(element).data('user-id');
        });
		
		var msgInvite = "";
		if ($('#invite_msg').val() == null || $('#invite_msg').val().length <= 0) {
			msgInvite = "";
		} else {
			msgInvite = $('#invite_msg').val();
		}

		$('html,body').scrollTop(0);
		disableScroll();
		$('#inviting_dlg').show();
		
		var postJsonData = {
			pw : $('#pw').val(),
			user_id : g_user_id,
			title : $('#title').val(),
			max_member : $('#max_member').val(),
			layout_type : $('[name="room_layout"]:checked').val(),
			resolution : $('#resolution_select').val(),
			record :  $('#record_select').val(),
			broadcast:  $('#broadcast_select').val(),
			invite_msg : $('#invite_msg').val(),
			start_datetime : dtStart.toMysqlFormat(),
			end_datetime : dtEnd.toMysqlFormat(),
			member : memberIDs,
			invite_msg : $('#invite_msg').val()
		};
		
		$.post( g_apiUrlRoot+"room_create.php", postJsonData, function( dataJson) {
			$('#inviting_dlg').hide();
			if (dataJson.rt_code == 0) {
				if ( processConvertPDF(dataJson.room_id) == false )
				{
					submitMettingRoom(dataJson.room_id);
				}
			} else {
				alert('죄송합니다\n방을 생성하지 못했습니다\n잠시 후 다시 생성해 주세요');
			}
		}, "json");
		
		return false;
    });
	
	$('.btn_search').click(function(e) {
		$(this).blur();
		
        if ($('#search_val').val().length <= 0) {
			alert('검색어가없어서 리스트를 초기화 합니다.');
		//	return false;
		}
		
		if ($('#group_select').val() == null || $('#group_select').val() == '') {
			setAllFriends();
		} else {
			setGroupFriends($('#group_select').val())
		}
		
		return false;
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
						$('#friends_list').append('<p><input type="checkbox" data-user-id="'+element.id+'"> '+element.name+'<BR></p>');
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
						$('#friends_list').append('<p><input type="checkbox" data-user-id="'+friend.id+'"> '+friend.name+'<BR></p>');
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
	
	$('.btn_right').click(function(e) {
        if ($('#friends_list input:checked').length <= 0) {
			alert('회의에 추가할 친구를 먼저 선택해 주세요');
			return;
		} else if ($('#realtime_mem_list input').length >= ($('#max_member').val()-1)) {
			alert('회의에는 자신을 포함해 최대 '+$('#max_member').val()+'명까지만 참여할 수 있습니다');
			return false;
		}
		
		$('#friends_list input:checked').each(function(index, element) {
            if ($('#realtime_mem_list input[data-user-id="'+$(element).data('user-id')+'"]').length <= 0) {
				$('#realtime_mem_list').append($(element).parent().clone());
			}
        });
    });
	
	$('.btn_left').click(function(e) {
		$('#realtime_mem_list input:checked').parent('p').remove();
	});
	
	var postJsonData = {
		user_id : g_user_id
	};
	$.post( g_apiUrlRoot+"group_list.php", postJsonData, function( dataJson) {
		if (dataJson.rt_code == 0) {
			_.each(dataJson.group, function(element, index) {
				$('#group_select').append('<option value="'+element.id+'">'+element.group_name+'</option>');
			});
		} else {
			alert('죄송합니다\n서버 정보를 가져오지 못했습니다\n잠시 후 다시 접속해 주세요');
		}
	}, "json");
	
	// 참가자 선택을 위해 모든 친구 목록 불러오기
	setAllFriends();

});	
</script>
	<!-- 상단 [ css : ../include/css/sub.css 참고]-->
	<div id="sub_top">
		<ul>
			<li class="r1">회의 등록/정보</li>
			<li class="r2">
			<a href="./reserve.php">회의 등록/정보</a>
			<a href="./realtime.php" class="sub_select">실시간 회의 등록</a>
			<a href="./room_list.php">공개 회의 목록</a>
			<span class="path">HOME > 회의 등록/정보 > 실시간 회의 등록</span></li>
			<li class="r3"><span>실시간 회의 등록</span></li>
		</ul>		
	</div>

	<!-- 본문 [ css : ../include/css/conference.css 참고] -->
	<section id="sub_section">
		<div id="realtime">
			<ul>
				<li><span>인원선택</span>
					<select id="max_member">
						<option value="0">인원선택</option>
                        <option value="1">1명</option>
                        <option value="2">2명</option>
                        <option value="3">3명</option>
                        <option value="4">4명</option>
                        <option value="5">5명</option>
                        <option value="6">6명</option>
                        <option value="7">7명</option>
                        <option value="8">8명</option>
                        <option value="9">9명</option>
                        <option value="10">10명</option>
                        <option value="11">11명</option>
                        <option value="12">12명</option>
                        <option value="13">13명</option>
                        <option value="14">14명</option>
                        <option value="15">15명</option>
                        <option value="16">16명</option>
					</select>
					<span style="padding-left:120px;">시간 선택</span>
					<select id="duration">
						<option value="0">시간선택</option>
                        <option value="30">30분</option>
                        <option value="60">1시간</option>
                        <option value="90">1시간 30분</option>
                        <option value="120">2시간</option>
                        <!--
                        <option value="1440">1일</option>
                        <option value="2880">2일</option>
                        -->
					</select>
				</li>
				<li><span>방 제목 &nbsp;&nbsp;</span><input id="title" type="text" class="name" maxlength="150"></li>
                <li><span>비밀번호</span><input id="pw" type="password" class="pwdbox" maxlength="20"> &nbsp;&nbsp; * 비밀번호 입력시 공개방으로 생성되어 초대되지 않은 사람도 입장가능합니다.</li>
				<li>
					<span>레이아웃</span>
					<!--span>
						<input type="radio" name="room_layout" value="1" checked>
						<div class="room_layout1">
							<span>1</span>
							<span>2</span>
							<span>3</span>
							<span>4</span>
						</div>
					</span>
					<span>
						<input type="radio" name="room_layout" value="8">
						<div class="room_layout2">
							<span>1</span>
							<span>2</span>
							<span>3</span>
							<span>4</span>
						</div>
					</span-->
                    <div style="width: 45%; margin-left: 80px;">
                        <span style="display: inline-block;" data-max-member="1">
                            <input type="radio" name="room_layout" value="1">
                            <div class="room_layout" style="background-image:url(../images/screen1.png); background-size:contain;"></div>
                        </span>
                        <span style="display: inline-block;" data-max-member="2">
                            <input type="radio" name="room_layout" value="6">
                            <div class="room_layout" style="background-image:url(../images/screen2.png); background-size:contain;"></div>
                        </span>
                        <span style="display: inline-block;" data-max-member="4">
                            <input type="radio" name="room_layout" value="1">
                            <div class="room_layout" style="background-image:url(../images/screen4.png); background-size:contain;"></div>
                        </span>
                        <span style="display: inline-block;" data-max-member="6">
                            <input type="radio" name="room_layout" value="5">
                            <div class="room_layout" style="background-image:url(../images/screen6.png); background-size:contain;"></div>
                        </span>
                        <span style="display: inline-block;" data-max-member="7">
                            <input type="radio" name="room_layout" value="3">
                            <div class="room_layout" style="background-image:url(../images/screen7.png); background-size:contain;"></div>
                        </span>
                        <span style="display: inline-block;" data-max-member="8">
                            <input type="radio" name="room_layout" value="4">
                            <div class="room_layout" style="background-image:url(../images/screen8.png); background-size:contain;"></div>
                        </span>
                        <span style="display: inline-block;" data-max-member="9">
                            <input type="radio" name="room_layout" value="2">
                            <div class="room_layout" style="background-image:url(../images/screen9.png); background-size:contain;"></div>
                        </span>
                        <span style="display: inline-block;" data-max-member="16">
                            <input type="radio" name="room_layout" value="9">
                            <div class="room_layout" style="background-image:url(../images/screen16.png); background-size:contain;"></div>
                        </span>
                        <span style="display: inline-block;" data-max-member="2">
                            <input type="radio" name="room_layout" value="7">
                            <div class="room_layout" style="background-image:url(../images/screen1-1.png); background-size:contain;"></div>
                        </span>
                        <span style="display: inline-block;" data-max-member="4">
                            <input type="radio" name="room_layout" value="8">
                            <div class="room_layout" style="background-image:url(../images/screen1-3.png); background-size:contain;"></div>
                        </span>

                        <span style="display: inline-block;" data-max-member="4">
                            <input type="radio" name="room_layout" value="22">
                            <div class="room_layout" style="background-image:url(../images/screen1-3r.png); background-size:contain;"></div>
                        </span>
                        <span style="display: inline-block;" data-max-member="5">
                            <input type="radio" name="room_layout" value="10">
                            <div class="room_layout" style="background-image:url(../images/screen1-4r.png); background-size:contain;"></div>
                        </span>
                    </div>
				</li>
                <li>
					<span style="width: 56px;">해상도</span>
					<select id="resolution_select" class="user_select">
                        <option value="6" selected>HD(16:9)</option>
                        <option value="14">HD(XGA)</option>
                        <option value="2">SD(VGA)</option>
					</select>
				</li>
<?
	if ( $_SESSION['user_level'] >= 20 ) {
?>
                		<li>
					<span>녹화여부</span>
					<select id="record_select" class="user_select">
						<option value="0">녹화안함</option>
						<option value="1">녹화함</option>
					</select>
				</li>
                		<li>
					<span>방송여부</span>
					<select id="broadcast_select" class="user_select">
						<option value="0">방송안함</option>
						<option value="1">방송함</option>
					</select>
				</li>
<?
	}
?>
				<li>
					<span>참가자 선택</span><BR>
					<select id="group_select" class="user_select">
                        <option value="">그룹 전체</option>
					</select>
					<span id="common_reserve_search"><input id="search_val" type="text" class="input_search"><input type="button" class="btn_search"></span>
				</li>
				<li>
					<span>
						<fieldset id="friends_list">
						</fieldset>
					</span>
					<span class="LRbtn"><input type="button" class="btn_right"><input type="button" class="btn_left"></span>
					<span>
						<fieldset id="realtime_mem_list">
							<span class="add_user">참여자 목록</span>
						</fieldset>
					</span>
				</li>
				<li>
					<span>초대메시지</span> (초대 메시지는 쪽지와 이메일로 발송됩니다)<br>
                    <textarea class="invite_msg" name="invite_msg" id="invite_msg">회의방으로 초대합니다.</textarea>
				</li>
				<li>
					<span>자료공유(PDF 문서, 이미지파일 끌어다 놓기)</span>
				<!-- The fileinput-button span is used to style the file input field as button -->
				<span class="btn btn-success fileinput-button">
				<i class="glyphicon glyphicon-plus"></i>
				<span>파일 추가</span>
				<!-- The file input field used as target for the file upload widget -->
				<input id="fileupload" type="file" name="files[]" multiple>
				</span>
				<br>
				<br>
				<!-- The global progress bar -->
				<div id="progress" class="progress">
				<div class="progress-bar progress-bar-success"></div>
				</div>
				<!-- The container for the uploaded files -->
				<div id="files" class="files"></div>
				</li>

				<li id="common_btn_area">
					<input id="btn_cancel" type="button" value="취소" class="btn_small blue">
					<input id="btn_create" type="submit" value="회의 생성 및 입장" class="btn_small blue">
				</li>
			</ul>
		</div>
	</section>

<!-- File Upload -->
<!-- upload css -->
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="../upload/js/vendor/jquery.ui.widget.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="../js/load-image.all.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="../js/canvas-to-blob.min.js"></script>
<!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
<script src="../js/bootstrap.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="../upload/js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="../upload/js/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="../upload/js/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="../upload/js/jquery.fileupload-image.js"></script>
<!-- The File Upload audio preview plugin -->
<script src="../upload/js/jquery.fileupload-audio.js"></script>
<!-- The File Upload video preview plugin -->
<script src="../upload/js/jquery.fileupload-video.js"></script>
<!-- The File Upload validation plugin -->
<script src="../upload/js/jquery.fileupload-validate.js"></script>
<script>
/*jslint unparam: true, regexp: true */
/*global window, $ */
//$(function () {
 //   'use strict';
    // Change this to the location of your server-side upload handler:
    var url = '../upload/',
        uploadButton = $('<button/>')
            .addClass('btn btn-primary')
            .prop('disabled', true)
            .text('업로드')
            .on('click', function () {
				$('#progress .progress-bar').css(
					'width',
					 '0'
				);
                var $this = $(this),
                    data = $this.data();
                $this
                    .off('click')
                    .text('중지')
                    .on('click', function () {
                        $this.remove();
                        data.abort();
                    });
                data.submit().always(function () {
                    $this.remove();
                });
            });

	var filelist = [];

    $('#fileupload').fileupload({
        url: url,
        dataType: 'json',
        autoUpload: false,
        acceptFileTypes: /(\.|\/)(pdf|gif|jpe?g|png)$/i,
        maxFileSize: 20000000, // 20 MB
        // Enable image resizing, except for Android and Opera,
        // which actually support image resizing, but fail to
        // send Blob objects via XHR requests:
        disableImageResize: /Android(?!.*Chrome)|Opera/
            .test(window.navigator.userAgent),
        previewMaxWidth: 100,
        previewMaxHeight: 100,
        previewCrop: true
    }).on('fileuploadadd', function (e, data) {
        data.context = $('<div/>').appendTo('#files');
        $.each(data.files, function (index, file) {
            var node = $('<span/>').text(file.name);
            if (!index) {
            	node.append("&nbsp;&nbsp;");
                node.append(uploadButton.clone(true).data(data));
            }
            node.appendTo(data.context);
        });
    }).on('fileuploadprocessalways', function (e, data) {
        var index = data.index,
            file = data.files[index],
            node = $(data.context.children()[index]);
        if (file.preview) {
            node
                .prepend('<br>')
                .prepend(file.preview);
        }
        if (file.error) {
            node
                .append('<br>')
                .append($('<span class="text-danger"/>').text(file.error));
        }
        if (index + 1 === data.files.length) {
            data.context.find('button')
                .text('업로드')
                .prop('disabled', !!data.files.error);
        }
        $('#progress .progress-bar').css(
            'transition',
             'width .0s ease'
        );
    }).on('fileuploadprogressall', function (e, data) {
        var progress = parseInt(data.loaded / data.total * 100, 10);
        $('#progress .progress-bar').css(
            'width',
            progress + '%'
        );
    }).on('fileuploaddone', function (e, data) {
        $.each(data.result.files, function (index, file) {
            if (file.url) {
                var link = $('<a>')
                    .attr('target', '_blank')
                    .prop('href', file.url);
                $(data.context.children()[index])
                    .wrap(link);
                $(data.context.children()[index])
                    .wrap("<div></div>");

				var doneButton = $('<button/>')
					.addClass('btn btn-danger delete')
					.prop('disabled', true)
					.text('완료')

                $(data.context.children()[index]).append(doneButton.clone(true).data(data));
				
				filelist.push(file.url); 
				//console.log(filelist);

            } else if (file.error) {
                var error = $('<span class="text-danger"/>').text(file.error);
                $(data.context.children()[index])
                    .append('<br>')
                    .append(error);
            }
        });
    }).on('fileuploadfail', function (e, data) {
        $.each(data.files, function (index) {
            var error = $('<span class="text-danger"/>').text('File upload failed.');
            $(data.context.children()[index])
                .append('<br>')
                .append(error);
        });
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');

	function processConvertPDF(room_id)
	{
		if ( filelist.length == 0 ) return false;

        $('#cvt_prog_file .progress-bar').css(
            'transition',
             'width .0s ease'
        );
        $('#cvt_prog_page .progress-bar').css(
            'transition',
             'width .0s ease'
        );

		$('html,body').scrollTop(0);
		disableScroll();
		$('#convert_dlg').show();

		var postJsonData = {
			room_id: room_id,
			filelist: JSON.stringify(filelist)
		};
        
		var last_response_len = false;

        $.ajax({
			type:"POST",
			url:'/upload/convert_pdf.php',
			data: postJsonData,
			datatype: "json",
            xhrFields: {
                onprogress: function(e)
                {
                    var this_response, response = e.currentTarget.response;
                    if(last_response_len === false)
                    {
                        this_response = response;
                        last_response_len = response.length;
                    }
                    else
                    {
                        this_response = response.substring(last_response_len);
                        last_response_len = response.length;
                    }
                    //console.log(this_response);
					var jsonlist = this_response.split('}');
					
					for ( var i=0; i<(jsonlist.length-1); i++)
					{
						var ret = eval("("+jsonlist[i]+"})");

						//console.log("file:"+ret.fileidx+"/"+ret.totalfile+", page:"+ret.pageidx+"/"+ret.totalpage);

						var progress = parseInt(ret.fileidx / ret.totalfile * 100, 10);
						$('#cvt_prog_file .progress-bar').css( 'width', progress + '%');

						progress = parseInt(ret.pageidx / ret.totalpage * 100, 10);
						$('#cvt_prog_page .progress-bar').css( 'width', progress + '%');

						if ( progress == 0 )
						{
							$('#cvt_prog_page .progress-bar').css( 'width', '0');
						}	
						$('#cvt_file_info').text("전체 파일 진행("+ret.fileidx+"/"+ret.totalfile+")");
						$('#cvt_page_info').text("현재 파일 변환("+progress+"%)");
					}

                }
            }
        })
        .done(function(data)
        {
			$('#cvt_prog_file .progress-bar').css( 'width', '100%');
			$('#convert_content').html('<center>문서 변환 완료! 회의방으로 이동합니다.</center>');
			
			setTimeout(function() { submitMettingRoom(room_id)}, 1000);
        })
        .fail(function(data)
        {
            console.log('Error: ', data);
        });
        console.log('Request Sent');
		
		return true;
	}

	function submitMettingRoom(room_id)
	{
		//var url = '../mypage/meeting_room.php';
		var url = '../mypage/meeting_layout.php';
		if ( g_user_level >= 10 ) url = '../mypage/meeting_layout.php';
		var form = $('<form action="' + url + '" method="post">' +
					'<input type="text" name="rid" value="' + room_id + '" />' +
					'<input type="text" name="rpw" value="' + $('#pw').val() + '" />' +
					'</form>');
		$('body').append(form);
		form.submit();
	}
//});
</script>

<div id="convert_dlg" style="position:absolute; top:0; left:0; width:100%; height:100%;background-color: lightgray;z-index: 1000;opacity: 0.97;padding-top: 200px; display:none;">
    <div id="wrap_convert" style="margin: 0 auto; padding:0px; border:1px solid #000000;background-color: white;width: 350px;">
        <p style="height:40px; padding:0px 10px; font-size:16px; line-height:40px; background:#454545; color:white;">문서변환중입니다. 잠시만 기다려 주세요.</p>
        <div id="convert_content" style="padding:10px;">		
		<span id="cvt_file_info"> 전체 파일 진행</span>
		<div id="cvt_prog_file" class="progress"> <div class="progress-bar progress-bar-success"></div></div>
		<span id="cvt_page_info">현제 파일 변환</span>
		<div id="cvt_prog_page" class="progress"> <div class="progress-bar progress-bar-success"></div></div>
        </div>
    </div>
</div>

<div id="inviting_dlg" style="position:absolute; top:0; left:0; width:100%; height:100%;background-color: lightgray;z-index: 1000;opacity: 0.97;padding-top: 200px; display:none;">
    <div id="wrap_convert" style="margin: 0 auto; padding:0px; border:1px solid #000000;background-color: white;width:380px;">
        <p style="height:40px; padding:0px 10px; font-size:16px; line-height:40px; background:#454545; color:white;">회의방 개설 및 초청중입니다. 잠시만 기다려 주세요.</p>
    </div>
</div>

	<!-- 하단 -->
<? include "../include/footer.php"; ?>
