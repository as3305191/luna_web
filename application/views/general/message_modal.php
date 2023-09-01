<link rel="stylesheet" href="<?= base_url() ?>coach_1/assets/css/unify-core.css">
<link rel="stylesheet" href="<?= base_url() ?>coach_1/assets/css/unify-components.css">
<link rel="stylesheet" href="<?= base_url() ?>coach_1/assets/css/unify-globals.css">
<link rel="stylesheet" href="<?= base_url() ?>coach_1/assets/css/custom.css">
<style>
    body,p{margin:0px; padding:0px; font-size:14px; color:#333; font-family:Arial, Helvetica, sans-serif;}
    #ltian,.rin{width:98%; margin:5px auto;}
    #ltian{border:1px #ccc solid;overflow-y:auto; overflow-x:hidden; position:relative;}
    #ct{margin-right:111px; height:100%;overflow-y:auto;overflow-x: hidden;/* background-color:#FFB7DD;*/} 
    #us{width:125px; overflow-y:auto; overflow-x:hidden; float:right; border-left:1px #ccc solid; height:100%; background-color:#F1F1F1;}
    #us #us_online p{padding:3px 5px; color:#08C; line-height:20px; height:20px; cursor:pointer; overflow:hidden; white-space:nowrap; text-overflow:ellipsis;}
    #us #us_offline p{padding:3px 5px; color:#878787;line-height:20px; height:20px; cursor:pointer; overflow:hidden; white-space:nowrap; text-overflow:ellipsis;}
    #us p:hover,#us p:active,#us p.ck{background-color:#069; color:#FFF;}
    #us p.my:hover,#us p.my:active,#us p.my{color:#333;background-color:transparent;}
    button{float:right; width:80px; height:80px; font-size:18px; line-height:20px;}
    textarea{width:103%; height:80px; padding:2px; line-height:20px; outline:none; border:solid 1px #CCC;}
    .rin p{margin-right:160px;}
    .rin span{float:right; padding:6px 5px 0px 5px; position:relative;}
    .rin span img{margin:50px 3px; cursor:pointer;}
    .rin span form{position:absolute; width:25px; height:25px; overflow:hidden; opacity:0; top:5px; right:5px;}
    .rin span input{width:180px; height:25px; margin-left:-160px; cursor:pointer}

    #ct p{padding:5px; line-height:20px;}
    #ct a{color:#069; cursor:pointer;}
    #ct span{color:#999; margin-right:10px;}
    .c2{color:#999;}
    .c3{background-color:#DBE9EC; padding:5px;}
    .qp{position:absolute; font-size:12px; color:#666; top:5px; right:130px; text-decoration:none; color:#069;}
    #ems{position:absolute; z-index:5; display:none; top:0px; left:0px; max-width:230px; background-color:#F1F1F1; border:solid 1px #CCC; padding:5px;}
    #ems img{width:44px; height:44px; border:solid 1px #FFF; cursor:pointer;}
    #ems img:hover,#ems img:active{border-color:#A4B7E3;}
    #ems a{color:#069; border-radius:2px; display:inline-block; margin:2px 5px; padding:1px 8px; text-decoration:none; background-color:#D5DFFD;}
    #ems a:hover,#ems a:active,#ems a.ck{color:#FFF; background-color:#069;}
    .tc{text-align:center; margin-top:5px;}
    .c_red{background-color: #FF5151 !important;}
    .none {display: none;}
    #menu{background-color: #fff; border:solid 2px;border-color:000000 !important;}
</style>

<body>
<input type="hidden" id="me_id" value="<?= isset($me_id) ? $me_id : ''?>">
<input type="hidden" id="f_chat_id" value="0">
<input type="hidden" id="is_online"  value="2">
<input type="hidden" id="to_chat_name"  value="">
<div id="chat_with_name" style="padding:0px 0px;"></div>

<div id="ltian">
    <div id="us" class="jb">
        <div id="us_online" class="jb"></div>
        <div id="us_offline" class="jb"></div>
    </div>
    <div id="ct">
    </div>
    <a style="display:none" href="javascript:;" class="qp" onClick="this.parentNode.children[1].innerHTML=''">清屏</a>
</div>
<div id="rin_send" class="rin none">
    <button id="sd">發送</button>
    <span><img src="../img/face/1.gif" title="表情" id="imgbq"><img src="../img/face/1.gif" title="上傳圖片" style="display:none"><form style="display:none"><input type="file" title="上傳圖片" id="upimg"></form></span>
    <p><textarea type="text" id="nrong" rows="20"  ></textarea></p>
</div>
<div id="ems"><p></p><p class="tc"></p></div>
<div id="menu" style="display: none;">
    <p id="recycle">收回訊息</p>
    <!-- <p id="update">修改</p>
    <p id="send">傳送資料</p> -->
</div>
</body>
<?php $this -> load -> view('mgmt/message/message_script'); ?>
<script>
// if(location.href.indexOf('#reloaded')==-1){
//     location.href=location.href+"#reloaded";
//     location.reload(); 
// }


</script>
