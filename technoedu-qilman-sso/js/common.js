// JavaScript Document

var g_user_id = '';
var g_user_name = '';
var g_user_email= '';
var g_user_part= '';
var g_user_dept= '';
var g_is_guest = false;
var g_timer_login_update = null;

// login check
function checkLogin(isGoLogin, canGuestAccess) {
	$.ajax({
		type: 'POST',
		url: g_apiUrlRoot+"check_login.php",
		success: function( dataJson) {
					
					if (dataJson.rt_code == 0) {
						$('.login').hide();
						$('.join').hide();
						$('.logout').show();
						$('.mypage').show();
						
						g_user_id = dataJson.user_id;
						g_user_name = dataJson.user_name;
						g_user_email= dataJson.user_email;
						g_user_part = dataJson.user_part;
						g_user_dept = dataJson.user_dept;
						g_user_level = dataJson.user_level;
						
						if (typeof canGuestAccess != 'undefined' && canGuestAccess == true) {
							if (g_user_id.indexOf('guest') == 0) {
								// guest일 경우 현재 페이지에 접속할 수 없음
								if (g_timer_login_update != null) {
									clearInterval(g_timer_login_update);
									g_timer_login_update = null;
								}

								g_is_guest = true;
																
								alert('Guest는 접속할 수 없는 페이지입니다');
								history.back(-1);
							}
						}
						
						if (g_timer_login_update == null) {
							g_timer_login_update = setInterval( function() {
								updateUserLogin();
								checkUserNote();
							}, 10000);
						}
					} else {
						$('.login').show();
						$('.join').show();
						$('.logout').hide();
						$('.mypage').hide();
						
						g_user_id = '';
						g_user_name = '';
						
						if (g_timer_login_update != null) {
							clearInterval(g_timer_login_update);
							g_timer_login_update = null;
						}
						
						if (typeof isGoLogin != 'undefined' && isGoLogin == true) {
							location.href = '/join/login.php?go='+location.href;
						}
					}
				},
		dataType: 'json',
		async:false
	});
}

// logout
function logout() {
	$.get( g_apiUrlRoot+"logout.php", function( dataJson) {
		
		if (dataJson.rt_code == 0) {
			g_user_id = '';
			
			if (g_timer_login_update != null) {
				clearInterval(g_timer_login_update);
				g_timer_login_update = null;
			}
			
			alert('정상적으로 로그아웃되었습니다');
			location.href = "/";
		}
	}, "json");
}

function updateUserLogin() {
	$.post( g_apiUrlRoot+"login_update.php", {user_id:g_user_id}, function(dataJson) {console.log(JSON.stringify(dataJson));}, 'json');
}

function checkUserNote() {
	$.post( g_apiUrlRoot+"check_note.php", {user_id:g_user_id}, function(dataJson) {
		if (dataJson.rt_code == 0) {
			if (location.href.indexOf('meeting_layout.php') <= -1) {
				var g_note_noti = confirm('새로운 쪽지가 있습니다\n지금 확인하시겠습니까?');
				if (g_note_noti == true) {
					location.href = '/mypage/note.php';
				}
			}
		}
	}, 'json');
}

/**
 * You first need to create a formatting function to pad numbers to two digits…
 **/
function twoDigits(d) {
    if(0 <= d && d < 10) return "0" + d.toString();
    if(-10 < d && d < 0) return "-0" + (-1*d).toString();
    return d.toString();
}

/**
 * …and then create the method to output the date string as desired.
 * Some people hate using prototypes this way, but if you are going
 * to apply this to more than one Date object, having it as a prototype
 * makes sense.
 **/
Date.prototype.toMysqlFormat = function() {
    return this.getUTCFullYear() + "-" + twoDigits(1 + this.getMonth()) + "-" + twoDigits(this.getDate()) + " " + twoDigits(this.getHours()) + ":" + twoDigits(this.getMinutes()) + ":" + twoDigits(this.getSeconds());
};


function getParameter(strParamName) {
	var strURL = location.search;
	var tmpParam = strURL.substring(1).split("&");
	if(strURL.substring(1).length > 0){
		var Params = new Array;
		for(var i=0;i<tmpParam.length;i++){
			Params = tmpParam[i].split("=");
			if(strParamName == Params[0]){
				return Params[1];
			}
		}
	 }
	 return "";
}

function formatNumberLength(num, length) {
    var r = "" + num;
    while (r.length < length) {
        r = "0" + r;
    }
    return r;
}

function getMcuDid(rid) {
	return '090'+formatNumberLength(rid, 4);
}

/* Enable scrolling */
function enableScroll() {
	document.ontouchmove = function(e) {
		return true;
	}
	
	document.onmousewheel = function(e) {
		return true;
	}
}

/* Prevent scrolling */	
function disableScroll() {
	document.ontouchmove = function(e){
		e.preventDefault();
	}
	
	document.onmousewheel = function(e){
		e.preventDefault();
	}
}

/* date functions */
Date.prototype.format = function(f) {
    if (!this.valueOf()) return " ";
 
    var weekName = ["일요일", "월요일", "화요일", "수요일", "목요일", "금요일", "토요일"];
	var weekShortName = ["일", "월", "화", "수", "목", "금", "토"];
    var d = this;
     
    return f.replace(/(yyyy|yy|MM|dd|E|e|hh|mm|ss|a\/p)/gi, function($1) {
        switch ($1) {
            case "yyyy": return d.getFullYear();
            case "yy": return (d.getFullYear() % 1000).zf(2);
            case "MM": return (d.getMonth() + 1).zf(2);
            case "dd": return d.getDate().zf(2);
            case "E": return weekName[d.getDay()];
			case "e": return weekShortName[d.getDay()];
            case "HH": return d.getHours().zf(2);
            //case "hh": return ((h = d.getHours() % 12) ? h : 12).zf(2);
			case "hh": return d.getHours().zf(2);
            case "mm": return d.getMinutes().zf(2);
            case "ss": return d.getSeconds().zf(2);
            case "a/p": return d.getHours() < 12 ? "오전" : "오후";
            default: return $1;
        }
    });
};
 
String.prototype.string = function(len){var s = '', i = 0; while (i++ < len) { s += this; } return s;};
String.prototype.zf = function(len){return "0".string(len - this.length) + this;};
Number.prototype.zf = function(len){return this.toString().zf(len);};
/* date functions */

// Array Remove - By John Resig (MIT Licensed)
Array.prototype.remove = function(from, to) {
	var rest = this.slice((to || from) + 1 || this.length);
	this.length = from < 0 ? this.length + from : from;
	return this.push.apply(this, rest);
};

String.prototype.replaceAll = function(search, replace)
{
    //if replace is null, return original string otherwise it will
    //replace search string with 'undefined'.
    if(!replace) 
        return this;

    return this.replace(new RegExp('[' + search + ']', 'g'), replace);
};
