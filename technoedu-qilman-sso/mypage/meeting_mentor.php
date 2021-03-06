<? include "../include/header_mentor.php"; ?>

<?
   $sipnumber= "";
   
   if ( isset($_POST['sipnumber']) ) 
   {
      $sipnumber= $_POST['sipnumber'];
        $mcuip= $_POST['mcuip'];
        $servername= $_POST['servername'];
   }
?>
<!-- 나의 회의 -->
<link rel="stylesheet" type="text/css" href="../css/conference.css">
<link rel="stylesheet" type="text/css" href="../css/mypage.css">
<link rel="stylesheet" type="text/css" href="../css/chatbubble.css">

<style>

body,html{
   margin:0;
   padding:0;
   width:100%;
   height:100%;
}
@media (min-width:1101px){
    div.pdf_btn > input[type=button] { min-width:40px; height:30px; border-radius:4px; cursor:pointer; border:1px solid #aeaeae; }
   div.pdf_btn > input[type=button]:nth-child(1) { background:url("../images/btn_start.png") 50% 50% no-repeat; }
   div.pdf_btn > input[type=button]:nth-child(2) { background:url("../images/btn_left.png") 50% 50% no-repeat; }
   div.pdf_btn > input[type=button]:nth-child(3) { background:url("../images/btn_right.png") 50% 50% no-repeat; }
   div.pdf_btn > input[type=button]:nth-child(4) { background:url("../images/btn_end.png") 50% 50% no-repeat; }

    #movie { min-width:320px; min-height:240px; border:1px solid #c8c7c7; box-shadow: 3px 3px 3px #888888;}
    #movie_option { min-height:50px; clear:both; width:820px; padding-top:3px;}
    #movie_option > img { display:block; float:left; width:35px; height:35px; margin-top:3px; margin-right:3px; cursor:pointer;}
    .msg_area { width:750px; min-width:250px; padding-left:0px; }
    .msg_area > #msg_content { min-width:252px; height:200px; padding:10px; overflow-y:scroll; border:1px solid #c8c7c7; }
    .msg_area > #msg_txt { width:750px; height:30px; } 
    .msg_area > #msg_txt > #chat_msg { float:left; width:702px; height:30px;  border:1px solid #d6d6d6; } 
    .msg_area > #msg_txt > .btn_send { float:left; width:46px; height:34px; background:#2577b8; border:1px solid #1a67a4; color:white; }
    .gray{ margin-top:3px;}

    #screen_kind > #text { text-align:center; font-weight:bold; }
    #screen_kind { margin-top:10px; margin-left:180px; text-align:right; width:500px; height:254px; }

    #loading {
        width: 100%;  
        height: 100%;  
        top: 0px;
        left: 0px;
        position: fixed;  
        display: block;  
        opacity: 0.7;  
        background-color: #fff;  
        z-index: 99;  
        text-align: center; } 

    #loading-image {  
        position: absolute;  
        top: 50%;  
        left: 50%; 
        z-index: 100; }
}
@media (min-width:769px) and (max-width:1100px){
    #header > #gnb > li.logo > a> img.mentor_sub_logo{width:150px; margin-left:15px;}
    div.pdf_btn > input[type=button] { min-width:40px; height:30px; border-radius:4px; cursor:pointer; border:1px solid #aeaeae; }
   div.pdf_btn > input[type=button]:nth-child(1) { background:url("../images/btn_start.png") 50% 50% no-repeat; }
   div.pdf_btn > input[type=button]:nth-child(2) { background:url("../images/btn_left.png") 50% 50% no-repeat; }
   div.pdf_btn > input[type=button]:nth-child(3) { background:url("../images/btn_right.png") 50% 50% no-repeat; }
   div.pdf_btn > input[type=button]:nth-child(4) { background:url("../images/btn_end.png") 50% 50% no-repeat; }

    #movie { min-width:320px; border:1px solid #c8c7c7; box-shadow: 3px 3px 3px #888888;}
    #movie_option { min-height:55px; clear:both; width:95%; padding-top:10px; padding-bottom:10px; margin:auto;}
    #movie_option > img { display:block; float:left; width:40px; height:40px; margin-top:5px; margin-right:3px; cursor:pointer;}
    .btn_small{float:right; margin-right:5px;  height: 30px;} 
    .gray{font-size:11px; margin-top:6px; font-size:13px;}
    .select{width:95%; margin:auto;}
    .select > #camera_select{width:300px; margin-top:15px;}

    .msg_area { width:95%; margin:auto; min-width:250px; padding-left:0px; }
    .msg_area > #msg_content { min-width:252px; height:200px; padding:10px; overflow-y:scroll; border:1px solid #c8c7c7; }
    .msg_area > #msg_txt {height:30px; margin-top:5px;} 
    .msg_area > #msg_txt > #chat_msg { float:left; width:86%; height:30px;  border:1px solid #d6d6d6; } 
    .msg_area > #msg_txt > .btn_send { float:right; width:13%; height:34px; background:#2577b8; border:1px solid #1a67a4; color:white; }

    #screen_kind > #text { text-align:center; font-weight:bold; margin-top:45px; }
    #screen_kind { margin-top:10px;  width:100%; height:350px;}
    #screen_kind > li{width:295px; margin:auto;}
    #screen_kind > li > img{width:95px;}

    #loading {
        width: 100%;  
        height: 100%;  
        top: 0px;
        left: 0px;
        position: fixed;  
        display: block;  
        opacity: 0.7;  
        background-color: #fff;  
        z-index: 99;  
        align-items: center;
        text-align: center; } 

    #loading-image {  
        /* position: relative;  
        top: 50%;  
        left: 50%;  */
        margin-top:60%;
        width:100px;
        z-index: 100; }
}

@media (min-width:427px) and (max-width:768px){
    #header > #gnb > li.logo > a> img.mentor_sub_logo{width:120px; margin-top:-5px; margin-left:10px;}
    div.pdf_btn > input[type=button] { min-width:40px; height:30px; border-radius:4px; cursor:pointer; border:1px solid #aeaeae; }
   div.pdf_btn > input[type=button]:nth-child(1) { background:url("../images/btn_start.png") 50% 50% no-repeat; }
   div.pdf_btn > input[type=button]:nth-child(2) { background:url("../images/btn_left.png") 50% 50% no-repeat; }
   div.pdf_btn > input[type=button]:nth-child(3) { background:url("../images/btn_right.png") 50% 50% no-repeat; }
   div.pdf_btn > input[type=button]:nth-child(4) { background:url("../images/btn_end.png") 50% 50% no-repeat; }

    #movie { min-width:320px; border:1px solid #c8c7c7; box-shadow: 3px 3px 3px #888888;}
    #movie_option { min-height:55px; clear:both; width:95%; padding-top:10px; padding-bottom:10px; margin:auto;}
    #movie_option > img { display:block; float:left; width:35px; height:35px; margin-top:3px; margin-right:3px; cursor:pointer;}
    .btn_small{float:right; margin-right:5px;} 
    .gray{font-size:11px; margin-top:6px; font-size:13px; height: 25px;}
    .select{width:95%; margin:auto;}
    .select > #camera_select{width:250px; margin-top:5px;}

    .msg_area { width:95%; margin:auto; min-width:250px; padding-left:0px; }
    .msg_area > #msg_content { min-width:252px; height:200px; padding:10px; overflow-y:scroll; border:1px solid #c8c7c7; }
    .msg_area > #msg_txt {height:30px; margin-top:5px;} 
    .msg_area > #msg_txt > #chat_msg { float:left; width:83%; height:30px;  border:1px solid #d6d6d6; } 
    .msg_area > #msg_txt > .btn_send { float:right; width:15%; height:34px; background:#2577b8; border:1px solid #1a67a4; color:white; }

    #screen_kind > #text { text-align:center; font-weight:bold; margin-top:45px; }
    #screen_kind { margin-top:10px;  width:100%; height:350px;}
    #screen_kind > li{width:295px; margin:auto;}
    #screen_kind > li > img{width:95px;}

    #loading {
        width: 100%;  
        height: 100%;  
        top: 0px;
        left: 0px;
        position: fixed;  
        display: block;  
        opacity: 0.7;  
        background-color: #fff;  
        z-index: 99;  
        align-items: center;
        text-align: center; } 

    #loading-image {  
        /* position: relative;  
        top: 50%;  
        left: 50%;  */
        margin-top:60%;
        width:100px;
        z-index: 100; }
}

@media (max-width:427px){
    #header > #gnb > li.logo > a> img.mentor_sub_logo{width:100px;}
    div.pdf_btn > input[type=button] { min-width:40px; height:30px; border-radius:4px; cursor:pointer; border:1px solid #aeaeae; }
   div.pdf_btn > input[type=button]:nth-child(1) { background:url("../images/btn_start.png") 50% 50% no-repeat; }
   div.pdf_btn > input[type=button]:nth-child(2) { background:url("../images/btn_left.png") 50% 50% no-repeat; }
   div.pdf_btn > input[type=button]:nth-child(3) { background:url("../images/btn_right.png") 50% 50% no-repeat; }
   div.pdf_btn > input[type=button]:nth-child(4) { background:url("../images/btn_end.png") 50% 50% no-repeat; }

    #movie { min-width:320px; border:1px solid #c8c7c7; box-shadow: 3px 3px 3px #888888;}
    #movie_option { min-height:55px; clear:both; width:95%; padding-top:10px; padding-bottom:10px; margin:auto;}
    #movie_option > img { display:block; float:left; width:30px; height:30px; margin-top:3px; margin-right:3px; cursor:pointer;}
    .btn_small{float:right; margin-right:5px;} 
    .gray{font-size:11px; margin-top:6px;}
    .select{width:95%; margin:auto;}
    .select > #camera_select{width:150px; margin-top:5px;}

    .msg_area { width:95%; margin:auto; min-width:250px; padding-left:0px; }
    .msg_area > #msg_content { min-width:252px; height:200px; padding:10px; overflow-y:scroll; border:1px solid #c8c7c7; }
    .msg_area > #msg_txt {height:30px; margin-top:5px;} 
    .msg_area > #msg_txt > #chat_msg { float:left; width:83%; height:30px;  border:1px solid #d6d6d6; } 
    .msg_area > #msg_txt > .btn_send { float:right; width:15%; height:34px; background:#2577b8; border:1px solid #1a67a4; color:white; }

    #screen_kind > #text { text-align:center; font-weight:bold; margin-top:45px; }
    #screen_kind { margin-top:10px;  width:100%; height:350px;}
    #screen_kind > li{width:295px; margin:auto;}
    #screen_kind > li > img{width:95px;}

    #loading {
        width: 100%;  
        height: 100%;  
        top: 0px;
        left: 0px;
        position: fixed;  
        display: block;  
        opacity: 0.7;  
        background-color: #fff;  
        z-index: 99;  
        align-items: center;
        text-align: center; } 

    #loading-image {  
        /* position: relative;  
        top: 50%;  
        left: 50%;  */
        margin-top:60%;
        width:100px;
        z-index: 100; }
}

</style>
<script src="../sipjs/sip.js?v=1" type="text/javascript"> </script>
<script type='text/javascript' src=room_comm.js?v=1.021"></script>

<script type="text/javascript">
window.onbeforeunload = function() {
   sipHangUp();
};

var g_uid = "";
var g_test = "";

var mcuScreenSize = 5;
var mcuProfiledId = 'HD';
var mcuCompType = 1;

var confRoomListVal = null;

function updateUID(){
    $.post('../mcutest/mcucomm.php',{mcuip:"<?=$mcuip?>", cmd: 'GetConfList' } )
    .done(
        function ( data ) {
            val = eval('('+data+')');
            
            for(var i = 0; i < val.conflist.length; i++) {
                console.log(val.conflist[i].uid);
                if(val.conflist[i].did == "<?=$sipnumber?>") {
                    g_uid = val.conflist[i].uid;
                    console.log(g_uid);
                    break;
                }
            }
         });
}

function createRoom(num){
    console.log(num);
    $.post('../mcutest/mcucomm.php', {
        mcuip:"<?=$mcuip?>", 
        cmd: 'CreateConference',
        did: num,
        name: num,
//        mixerId: 'mixer',
        mixerId:"<?=$servername?>",
        profileId:'HD',
        compType: '1',
        vad: '0',
        size: '6',
        closeTimerUse: false,
        recordUse: false,
        autoCloseUse: true
        }
    ).done (
        function ( data ) {  
            //val = eval('('+data+')');
            //console.log(data);
    });

   setTimeout( updateUID, 1000); 
}

function room_init()
{
<?
   if ( strlen($sipnumber) <= 2 )
   {
?>
        alert("번호가 잘못되었습니다.");
        history.back(-1);
<?
    }
    else if ( substr($sipnumber, 0, 3) == "090" )
   {
?>
        alert("사용할 수 없는 번호입니다.");
        history.back(-1);
<?
   }
   else {
?>
    g_uid = "";

    $.post('../mcutest/mcucomm.php',{mcuip:"<?=$mcuip?>", cmd: 'GetConfList' } )
    .done(
        function ( data ) {
            val = eval('('+data+')');
            
            for(var i = 0; i < val.conflist.length; i++) {
                console.log(val.conflist[i].uid);
                if(val.conflist[i].did == "<?=$sipnumber?>") {
                    g_uid = val.conflist[i].uid;
                    console.log(g_uid);
                    break;
                }
            }

            if (g_uid.length == 0)
            {
                console.log("test1111");
                createRoom("<?=$sipnumber?>");
            }
         });

    $("#screen_kind").hide();

    setTimeout( function() {
        setMCUInfo("<?=$sipnumber?>", g_user_id, g_user_id, g_user_id); // org
        //setMCUInfo("<?=$sipnumber?>", g_user_id, g_user_id, g_user_id, "<?=$mcuip?>");
        sipRegister();
   }, 500);

   setTimeout( updateCameraSelData, 2000); 
   //setTimeout( removeLoading, 7000); 
<?
   }
?>
}

</script>
   <!-- 상단 [ css : ../include/css/sub.css 참고]-->

   <!-- 본문 [ css : ../include/css/conference.css 참고] -->
   <section id="sub_section">
    <div id="loading"><img id="loading-image" src="/images/loading.gif" alt="Loading..." /></div>
      <div id="mypage" >
         <ul id="chat">
            <li id="movie">
               <div id="divVideo" class='div-video'>
                  <div id="divVideoRemote" style='height:auto; width:100%'>
                     <video class="video" width="100%" height="auto" id="video_remote" autoplay playsinline="true" style="opacity: 100; 
                        background-color: #FFFFFF; -webkit-transition-property: opacity; -webkit-transition-duration: 2s; margin-bottom:-6px;">
                     </video>
                  </div>
                  <div id="divVideoLocal" style='border:0px solid #000; display:none;'>
                     <video class="video" width="88px" height="72px" id="video_local" autoplay playsinline="true" muted style="opacity: 0;
                        margin-top: -80px; margin-left: 5px; background-color: #000000; -webkit-transition-property: opacity;
                        -webkit-transition-duration: 2s;">
                     </video>
                            <canvas id="video_canvas" width="320" height="180"></canvas>
                  </div>
               </div>
            </li>
         <div id="movie_option">
            <!--
                <a href="#" id="btn_fullscreen"<img src="../images/option1.png"></a>
            <a href="#" id="btn_mute_souund"<img src="../images/option3.png"></a>
            <a href="#" id="btn_mute_mic"<img src="../images/option2.png"></a>
            <a href="#" id="btn_mute_video"<img src="../images/option4.png"></a>
            <a href="#" class="option5"<img src="../images/option5.png"></a>
            <a href="#" id="btn_camswitch"<img src="../images/switch_cam.png"></a>
            <a href="#" id="btn_n"<img src="../images/option7.png"></a>
                -->
                <img src="../images/option1.png" id="btn_fullscreen">
            <img src="../images/option3.png" id="img_mute_sound">
            <img src="../images/option2.png" id="img_mute_mic">
            <img src="../images/option4.png" id="img_mute_video">
            <img src="../images/option7.png" id="img_screenshare">
            <img src="../images/switch_cam.png" id="btn_camswitch">
                <img src="../images/option5.png" class="option5">

            <button style="float:right;" class="btn_small gray" onclick="onEndFunc()">끝내기</button>
                <ul id="screen_kind">
                    <li id="text">화면 레이아웃 변경</li>
                    <li>
                        <img id="vid_layout_sel_1" style="cursor:pointer;" src="../images/screen1.png">
                        <img id="vid_layout_sel_2" style="cursor:pointer;" src="../images/screen2.png">
                        <img id="vid_layout_sel_1_1" style="cursor:pointer;" src="../images/screen1-1.png">
                        <img id="vid_layout_sel_4" style="cursor:pointer;" src="../images/screen4.png">
                        <img id="vid_layout_sel_1_3" style="cursor:pointer;" src="../images/screen1-3.png">
                        <img id="vid_layout_sel_1_3r" style="cursor:pointer;" src="../images/screen1-3r.png">
                        <img id="vid_layout_sel_1_4r" style="cursor:pointer;" src="../images/screen1-4r.png">
                        <img id="vid_layout_sel_6" style="cursor:pointer;" src="../images/screen6.png">
                        <img id="vid_layout_sel_7" style="cursor:pointer;" src="../images/screen7.png">
                        <img id="vid_layout_sel_8" style="cursor:pointer;" src="../images/screen8.png">
                        <img id="vid_layout_sel_9" style="cursor:pointer;" src="../images/screen9.png">
                        <img id="vid_layout_sel_16" style="cursor:pointer;" src="../images/screen16.png">
                    </li>
                </ul>
                <!--
                <div class="select">
                    <label for="videoSource">카메라: </label>
                        <select id="camera_select">
                            <option value=""> USB Camera</option>
                        </select>
                    <input id="cameraSelect" type="button" value="카메라변경" class="btn_small blue" style="margin-left:110px;">
                </div>
                -->

                <!--
            <button style="float:right;margin-top:3px;" class="btn_small gray" onclick="onEndFunc()">끝내기</button>
                -->
         </div>


                <div class="select">
                    <label for="videoSource">카메라: </label>
                        <select id="camera_select">
                            <option value=""> USB Camera</option>
                        </select>
                    <input id="cameraSelect" type="button" value="카메라변경" class="btn_small blue" style="margin-left:10px;">
                </div>


         <br>
         </ul>

         <ul id="movie_chat">
            <!-- 음성 및 영상 제어 -->
            <li class="msg_area">
               <div id="msg_content"></div>
               <div id="msg_txt"><input type="text" id="chat_msg" maxlength="500"><input type="submit" class="btn_send" value="전송" id="chat_send"></div>
            </li>
         </ul>



            <!--
            <table border=0><tr><td>
            <video width=320 height=240 muted autoplay></video>
            </td>
            <td>&nbsp;</td>
            <td>
            <canvas id="meter" width="50" height="240"></canvas>
            </td></tr></table>

    o            <div class="select">
                    <label for="videoSource">카메라: </label><select id="videoSource" style="width:250px;"></select>
                </div>
                <input id="cameraSelect" type="button" value="카메라변경" class="btn_small blue" style="margin-left:110px;">
            -->




      </div>
   </section>

<script src="../sipjs/sip.js?v=20" type="text/javascript"> </script>
<script type='text/javascript'>
var bIsAudioMute = false;
var bIsVideoMute = false;
var bIsSpeakerMute = false;
var bIsEndBtnPress = false;


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

$('#img_mute_mic').click(function(e) {
    bIsAudioMute = !bIsAudioMute;
    muteLocalAudio(bIsAudioMute);

    if ( bIsAudioMute ) $('#img_mute_mic').attr("src", "../images/option2_off.png");
    else $('#img_mute_mic').attr("src", "../images/option2.png");
});

$('#img_mute_sound').click(function(e) {
    var vid = document.getElementById("video_remote");
    bIsSpeakerMute = !bIsSpeakerMute;
    vid.muted = bIsSpeakerMute;   


    if ( bIsSpeakerMute) $('#img_mute_sound').attr("src", "../images/option3_off.png");
    else $('#img_mute_sound').attr("src", "../images/option3.png");
});

$('#img_mute_video').click(function(e) {
   bIsVideoMute = !bIsVideoMute;
   muteLocalVideo(bIsVideoMute);

   if ( bIsVideoMute) $('#img_mute_video').attr("src", "../images/option4_off.png");
   else $('#img_mute_video').attr("src", "../images/option4.png");
});

$('#btn_camswitch').click(function(e) {
    switchCamera();
});

$('#cameraSelect').click( function() {
    selectCamera($('#camera_select').val())
    //alert("디바이스 설정이 저장되었습니다.");
});

$('#vid_layout_sel_1').click(function(e) { compTypeChange(0); }); 
$('#vid_layout_sel_2').click(function(e) { compTypeChange(6); }); 
$('#vid_layout_sel_1_1').click(function(e) { compTypeChange(7); }); 
$('#vid_layout_sel_4').click(function(e) { compTypeChange(1); }); 
$('#vid_layout_sel_1_3').click(function(e) { compTypeChange(8); }); 
$('#vid_layout_sel_1_3r').click(function(e) { compTypeChange(22); }); 
$('#vid_layout_sel_1_4r').click(function(e) { compTypeChange(10); }); 
$('#vid_layout_sel_1_4r').click(function(e) { compTypeChange(23); }); 
$('#vid_layout_sel_1_4r').click(function(e) { compTypeChange(24); }); 
$('#vid_layout_sel_6').click(function(e) { compTypeChange(5); }); 
$('#vid_layout_sel_7').click(function(e) { compTypeChange(3); }); 
$('#vid_layout_sel_8').click(function(e) { compTypeChange(4); }); 
$('#vid_layout_sel_9').click(function(e) { compTypeChange(2); }); 
$('#vid_layout_sel_16').click(function(e) { compTypeChange(9); }); 

$(".option5").click(function(){
    $("#screen_kind").slideToggle("fast");
    getMCURoomInfo();
});

function onEndFunc() {
   if ( confirm("회의를 종료합니다. 회의방을 나가시겠습니까?") != 0 )
   {
        bIsEndBtnPress = true;
        try {
          sipHangUp();
        } catch (e) {
            console.log("Hang Up Error");
        }
      //location.href = "/";
        window.history.back();
   }
}
onSipDisconnectFunc = function()
{
    if ( bIsEndBtnPress == false )
    {
        alert("회의 시간이 종료되었거나 다른 이유로 회의방을 닫습니다.");
    }

   setTimeout(function() {
      //location.href = "/";
        window.history.back();
   }, 500);
}
/*
function createRoom(num)
    console.log(num);
    $.post('../mcutest/mcucomm.php', {
        cmd: 'CreateConference',
        name: num,
        mixerId: 'mixer',
        profileId:'HD',
        compType: '1',
        vad: '0',
        size: '6',
        closeTimerUse: false,
        recordUse: false
        }
    ).done (
        function ( data ) {  
            val = eval('('+data+')');
            console.log(data);
    });
}
*/
function updateCameraSelData()
{
    $('#camera_select').empty();

    /*
    for (var count=0; count < cameraList.length; count++) {
        option = $("<option value="+count+">"+cameraList[count].label+"</option>");
        $('#camera_select').append(option);
    }
    */
    for (var count=0; count < cameraList.length; count++) {
        if ( curCameraSel == count )
        {
            option = $("<option value="+count+" selected>"+cameraList[count].label+"</option>");
        }
        else
        {
            option = $("<option value="+count+">"+cameraList[count].label+"</option>");
        }

        $('#camera_select').append(option);
    }
}

function removeLoading()
{
     $('#loading').hide();   
}

// Chat Function JEONG 20200423 moved from meeting_layout.php
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
   //connection.send('{"cmd":"enter_room", "roomidx": "<?=$room_id?>", "user_id":"'+g_user_id+'", "user_name":"'+g_user_name+'", "user_email": "'+g_user_email+'", "roomaddr":"'+"<?=$sipnumber?>"+'@'+g_outboundSipSvrUrl.substring(6)+'"}');
   connection.send('{"cmd":"enter_room", "roomidx": "<?=$sipnumber?>", "user_id":"'+g_user_id+'", "user_name":"'+g_user_name+'", "user_email": "'+g_user_email+'", "roomaddr":"'+"<?=$sipnumber?>"+'@'+g_outboundSipSvrUrl.substring(6)+'"}');
   
    // 일반
    $('.chat_list .list').append('<ul>\
            <li>'+g_user_name+'('+g_user_id+')'+'</li>\
        </ul>');

   g_userInfoList.push({id:g_user_id, name:g_user_name, partId:"0", amute:"false", vmute:"false", is_external:"false"});
   
   chat_msg_add( g_user_name+'('+g_user_id+')', '님이 방에 참여하셨습니다.', false, 'pink');
};

connection.onerror = function (error) {
   //alert('문서 공유 서버 접속에 실패했습니다.' );
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
   }
   
   if ( json.cmd == "exit_room" )
   {
      if (typeof json.user_id != "undefined") {

         {
            // 일반 참여자가 나갔을 경우 해당 참여자만 제거함
            //$('#msg_content').append('<b>'+json.user_name+'('+json.user_id+')님이 방에서 나가셨습니다.</b><br>');
            chat_msg_add( json.user_name+'('+json.user_id+')', '님이 방에서 나가셨습니다.', false, 'pink');
            $('#msg_content').scrollTop($('#msg_content').prop('scrollHeight'));
            
            $('ul[data-user-id="'+json.user_id+'"]').remove();
            
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
               //connection.send('{"cmd":"exit_room", "roomidx": "<?=$room_id?>", "user_id":"'+g_user_id+'", "user_name":"'+g_user_name+'"}');
               connection.send('{"cmd":"exit_room", "roomidx": "<?=$sipnumber?>", "user_id":"'+g_user_id+'", "user_name":"'+g_user_name+'"}');
            }

            alert('방장에 의해 퇴장당하셨습니다');
            
            setTimeout(function() {
               location.href = "/";
            }, 500);
         }
      }
   }

   if ( json.cmd == "chat" )
   {
      if (json.content.length <= 0) {
         return false;
      }
      
      //$('#msg_content').append('<b>'+json.user_name+ ':</b> ' + json.content+ '<br>'); 
      chat_msg_add( json.user_name, json.content, false, 'blue');

       $('#msg_content').scrollTop($('#msg_content').prop('scrollHeight'));
   }
}

$('#chat_send').click( function (e) {
   var content = $("#chat_msg").val();
   
   if (content.length <= 0) {
      return false;
   }
   
   //var msg = '{"cmd":"chat", "roomidx": "<?=$room_id?>", "user_id": "'+g_user_id+'", "user_name":"'+g_user_name+'", "content":"'+ content +'"}';
   var msg = '{"cmd":"chat", "roomidx": "<?=$sipnumber?>", "user_id": "'+g_user_id+'", "user_name":"'+g_user_name+'", "content":"'+ content +'"}';
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

var oldRoomUserListData = "none";

function getMCURoomInfo(){
    $.post('../mcutest/mcucomm.php', {
        mcuip:"<?=$mcuip?>", 
        cmd: 'GetConfRoomInfo',
        uid: g_uid
        }
    ).done (
        function ( data ) {  
            val = eval('('+data+')');
            console.log(data);
            
            if ( val.ret == 'true' ) { 
                mcuScreenSize = val.size;
                mcuProfileId = val.profileid
                mcuCompType = val.comptype;
            }
    });   
}

function updatePosSelData()
{
   // get room uid
   $.post('../mcutest/mcucomm.php', {mcuip:"<?=$mcuip?>", cmd: 'GetConfSlotInfo', uid: g_uid})
   .done(
        function ( data ) {
            val = eval( '('+data+')');
         
            if ( val == null ){
            alert("error:"+data);
             return;
         }
         
            if(val.ret == "false") return;

            mcuCompType = parseInt(val.comptype);

            confRoomListVal = val;
      }
   );
}

function setChangePos(num, val)
{
    console.log("setChangePos:"+ num + " = " + val);
    $.post('../mcutest/mcucomm.php', {mcuip:"<?=$mcuip?>", cmd: 'setMosaicSlot', uid: g_uid, num: num, id:val} );
}

function compTypeChange(compType)
{
    console.log("enter");
    //alert(compType);
    mcuCompType = compType;
    $.post('../mcutest/mcucomm.php', { 
        mcuip:"<?=$mcuip?>", 
        cmd: 'setCompositionType',
        uid: g_uid,
        compType: mcuCompType,
        size:mcuScreenSize,
        profileId:mcuProfileId})
    .done(
        function(data){
        //alert(data);
        }
    );
}
</script>

<script src='mousedown.js?v=4'></script>
<script src='mouseup.js?v=5'></script>

<script>
// ----------- SIP.JS Contents Share Code ------- Modify by spbrain 20200406
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

    // add by scchoi
    wsModifier = function(description) {
        //console.log("SCCHOI> Modifier:");
        //console.log(description);
        if ( description.type == "offer" )
        {
            description.sdp = description.sdp.replace("a=group:BUNDLE 0", "a=group:BUNDLE video");
            description.sdp = description.sdp.replace("a=mid:0", "a=mid:video");

        }
        else {
            description.sdp = description.sdp.replace("profile-level-id=4d 032","profile-level-id=4d0032");
        }
        return Promise.resolve(description);
    }


    var sessionDescriptionHandlerFactoryOptions = {};
    sessionDescriptionHandlerFactoryOptions.modifiers = [wsModifier];

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
            traceSip: true,
            wsServers: g_webSocketServerURL
        }
    };
    var userAgent = new SIP.UA(configuration);
    return userAgent;
}

var sessionContent;
var sessionContentStateus = 'none';

function setupShareMediaBandwidth() {
    if (sessionContent) {
        var pc = sessionContent.sessionDescriptionHandler.peerConnection;
        if (pc.getSenders) {
            pc.getSenders().forEach(function (sender) {
                var track = sender.track;
                if (track && track.kind === "video") {
                    const parameters = sender.getParameters();
                    if ( !parameters.encodings) {
                        parameters.encodings = [{}];
                    }
                    parameters.encodings[0].maxBitrate = 2048 * 1000; // 2Mbps
                    parameters.encodings[0].networkPriority = "high";
                    parameters.encodings[0].priority = "high";
                    sender.setParameters(parameters)
                    .then(() => {
                        console.log("Set Shared Bandwidth Completed");
                        console.log(parameters);
                    })
                    .catch(e => console.error(e));
                }
            });
        }
    }
};

function makeShareCall(userAgent, target, audio, video, remoteRender, localRender) {
    // makes the call
    var options = { 
        sessionDescriptionHandlerOptions: {
            constraints: {
                sharescreen: true,
                audio: false,
                video: {width:1280, height:720}
            }
        }
    };

    console.log("invite.option:");
    console.log(options);

    var modifierArray = [];
    try {
        sessionContent = userAgent.invite('sip:' + target, options, modifierArray );
    }
    catch (error) {
        alert("해당 브라우져가 공유기능을 지원하지 않습니다.\n브라우져를 최신버전으로 업그레이드 해주세요.");
        return;
    }

    sessionContentStateus = 'inviting';
    sessionContent.on('accepted', function () {
            sessionContentStateus = 'accepted';
            console.log("Accept!\n");

           setTimeout( setupShareMediaBandwidth, 1000); 
           //setTimeout( updateConfRoomUserList, 100); 
            });
    sessionContent.on('bye', function () {
            sessionContent = null;
            sessionContentStateus = 'none';   
            console.log("Content:Bye Receive!\n");
            });

}

// sykim 2021.7.9
//var uaContents = createUA(g_user_id + "_content@mentorservice.co.kr", g_user_id + "_content");
var uaContents = createUA(g_user_id + "_content@technoedu.co.kr", g_user_id + "_content");
var markAsRegistered = function () {
   console.log("SharedContent UA Regiseterd Content!!");
};
uaContents.on('registered', markAsRegistered);

$("#img_screenshare").click(function(){
    //updateConfRoomUserList();
    
   if ( sessionContentStateus == 'waiting' )
   {
      //Nothing
      console.log("Waiting connect..\n");
   }
   else if ( sessionContentStateus == 'accepted')
   {
        sessionContent.bye();
        sessionContent = null;
      sessionContentStateus = 'none';   
      $('#img_screenshare').attr("src", "../images/option7.png");
       //setTimeout( updateConfRoomUserList, 100); 
   }
   else if ( sessionContentStateus == 'inviting' )
   {
        //sessionContent.cancel();
        sessionContent.bye(); //20201230 mklim
        sessionContent = null;
      sessionContentStateus = 'none';   
      $('#img_screenshare').attr("src", "../images/option7.png");
   }
   else {
      sessionContentStateus = 'waiting';   
      //var target = g_did + '@' + g_sipSvrUrl;
      var target = "<?=$sipnumber?>" + '@' + g_sipSvrUrl;
      makeShareCall(uaContents, target, false, true, null, null);

      $('#img_screenshare').attr("src", "../images/option7_off.png");
   }
    
});



var canvas = document.getElementById("canvas_share");


function touchHandler(event)
{
    var touches = event.changedTouches,
        first = touches[0],
        type = "";
    switch(event.type)
    {
        case "touchstart": type = "mousedown"; break;
        case "touchmove": type = "mousemove"; break;
        case "touchend": type = "mouseup"; break;
        default: return;
    }
        
    var simulatedEvent = document.createEvent("MouseEvent");
    simulatedEvent.initMouseEvent(type, true, true, window, 1,
                    first.screenZ, first.screenY,
                    first.clientX, first.clientY, false.
                    false, false, false, 0/*left*/, null);
    first.target.dispatchEvent(simulatedEvent);
    event.preventDefault();
}

</script>

   <!-- 하단 -->
