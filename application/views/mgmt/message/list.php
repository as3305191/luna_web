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

(function(){
    var key='all',mkey;
    var users={};
    var url='<?= $socket_url?>';
    var so=false,n=false,me_id=false,socket=false;
    var lus=A.$('us_online'),lct=A.$('ct');
    // console.log(users);
    function st(){
      
        // n=prompt('取個名子');
        n='<?= $username?>';
        me_id='<?= $me_id?>';
        socket='<?= $old_socket?>';        
        if(!n){
            return ;   
        }

        //創socket，注意URL的格式：ws://ip:端口
        so=new WebSocket(url);
        //握手监听函数
        so.onopen=function(){
            //狀態1證明握手成功，然後把client自訂的名字發出去
            if(so.readyState==1){
                if(socket=='0'){
                    so.send('type=add&ming='+n+'&me_id='+me_id);
                    // so.send('type=old_remove&socket='+socket+'&me_id='+me_id);
                } else{
                    so.send('type=old_remove&socket='+socket+'&me_id='+me_id);
                    // so=new WebSocket(url);
                    window.location.reload();
                    // so=new WebSocket(url);
                    // so.send('type=add&ming='+n+'&me_id='+me_id);
                    // location.reload();
                }
            }
        }
        // window.onbeforeunload=function(){
        //     so.close();
        // }
        window.addEventListener("hashchange", e=> {
            var url=e.oldURL;
            var old_URL=url.substring(url.indexOf('#', 0) + 1);
            var oldURL = old_URL.split('#')[0].split("/").slice(0,2).join("/");
          
            if(oldURL == 'mgmt/message'){
                so.close();
            }
            // console.log(oldURL);

        });
        //握手失敗或者其他原因連接socket失敗，清除so的對象
        so.onclose=function(){
            so=false;
        }

        so.onmessage=function(msg){
            eval('var da='+msg.data);
            var obj=false,c=false;
            if(da.type=='add'){
                if(da.me_id>0){
                    var obj=A.$$('<p me_id="'+da.me_id+'">'+da.name+'</p>');
                   
                }             
                lus.appendChild(obj);
                cuser(obj,da.code);
                // obj=A.$$('<p"><span>['+da.time+']</span>歡迎<a>'+da.name+'</a>加入</p>');
                c=da.code;
                var url = '<?= base_url() ?>' + 'mgmt/message/find_offline_users';
                var each_offline_user = '';
                var us_offline = $('#us_offline').empty();
                $.ajax({
                    url : url,
                    type: 'POST',
                    data: {
                        id_array: da.offline_user,
                        online_id_array:da.online_user,
                    },
                    dataType: 'json',
                    success: function(d) {
                        // console.log(d);
                        if(d.offline_users){
                            $.each(d.offline_users, function(){
                                var me = this;
                                var notread='<span class="u-label g-font-size-11 g-bg-white g-color-main g-rounded-20 g-px-10 c_red" style="float:right;padding: .20rem .25rem;">'+me[0].no_read+'</span>';
                                if(me[0].no_read>0){
                                    each_offline_user += '<p me_id="'+me[0].id+'" offline_name="'+me[0].user_name+'" onclick="change_f_chat('+me[0].id+',\''+me[0].user_name+'\');">'+me[0].user_name+notread+'</p>';
                                } else{
                                    each_offline_user += '<p me_id="'+me[0].id+'" offline_name="'+me[0].user_name+'" onclick="change_f_chat('+me[0].id+',\''+me[0].user_name+'\');">'+me[0].user_name+'</p>';
                                } 
                            })
                            var html='<div><p class="my">離線人員...</p>'+each_offline_user+'</div>';
                            us_offline.append(html);
                            if(da.me_id==$('#f_chat_id').val()){
                                var f_chat_id = $('#f_chat_id').val();
                                $('#us_online').find('p[me_id="'+f_chat_id+'"]').click();
                            }
                        }
                     
                        if(d.online_users!=false){
                            $.each(d.online_users, function(){
                                var me = this;
                                var online_user_sidebar = $('#us_online').find('p[me_id="'+me[0].id+'"]');
                                if(me[0].no_read>0){
                                    var notread='<span class="u-label g-font-size-11 g-bg-white g-color-main g-rounded-20 g-px-10 c_red" style="float:right;padding: .20rem .25rem;">'+me[0].no_read+'</span>';
                                } else{
                                    var notread='';
                                }
                                online_user_sidebar.append(notread);
                            })
                        }

                    },
                    failure:function(){
                        alert('faialure');
                    }
                });
            }else if(da.type=='madd'){
                mkey=da.code;
                if($('#me_id').val()=='307'){
                //  da.users.unshift({'code':'all','name':'大家'});
                }
                for(var i=0;i<da.users.length;i++){
                    if(da.users[i].me_id>0){
                        if(da.users[i].me_id!==$('#me_id').val()){
                            var obj=A.$$('<p me_id="'+da.users[i].me_id+'">'+da.users[i].name+'</p>');
                            lus.appendChild(obj);
                        }   
                    } else{
                        var obj=A.$$('<p me_id="0">'+da.users[i].name+'</p>');
                        lus.appendChild(obj);
                    }
                    
                    if(mkey!=da.users[i].code){
                        cuser(obj,da.users[i].code);
                    }else{
                        // obj.className='my';
                        document.title=da.users[i].name;
                    }
                }
                // obj=A.$$('<p><span>['+da.time+']</span>歡迎'+da.name+'加入</p>');
                // users.all.className='ck';
                var url = '<?= base_url() ?>' + 'mgmt/message/find_offline_users';
                var each_offline_user = '';
                var us_offline = $('#us_offline').empty();
                $.ajax({
                    url : url,
                    type: 'POST',
                    data: {
                        id_array: da.offline_user,
                        online_id_array:da.online_user,
                    },
                    dataType: 'json',
                    success: function(d) {
                        // console.log(d);
                        if(d.offline_users){
                            $.each(d.offline_users, function(){
                                var me = this;
                                var notread='<span class="u-label g-font-size-11 g-bg-white g-color-main g-rounded-20 g-px-10 c_red" style="float:right;padding: .20rem .25rem;">'+me.no_read+'</span>';
                                if(me.no_read>0){
                                    each_offline_user += '<p me_id="'+me.id+'" offline_name="'+me.user_name+'" onclick="change_f_chat('+me.id+',\''+me.user_name+'\');">'+me.user_name+notread+'</p>';
                                } else{
                                    each_offline_user += '<p me_id="'+me.id+'" offline_name="'+me.user_name+'" onclick="change_f_chat('+me.id+',\''+me.user_name+'\');">'+me.user_name+'</p>';
                                } 
                            })
                           
                            // us_offline.append(html);
                        }
                        if(d.offline_users_no_noread){
                            $.each(d.offline_users_no_noread, function(){
                                var me = this;
                                var notread='<span class="u-label g-font-size-11 g-bg-white g-color-main g-rounded-20 g-px-10 c_red" style="float:right;padding: .20rem .25rem;">'+me.no_read+'</span>';
                                if(me.no_read>0){
                                    each_offline_user += '<p me_id="'+me.id+'" offline_name="'+me.user_name+'" onclick="change_f_chat('+me.id+',\''+me.user_name+'\');">'+me.user_name+notread+'</p>';
                                } else{
                                    each_offline_user += '<p me_id="'+me.id+'" offline_name="'+me.user_name+'" onclick="change_f_chat('+me.id+',\''+me.user_name+'\');">'+me.user_name+'</p>';
                                } 
                            })
                            // var html='<div>'+each_offline_user_no_noread+'</div>';
                           
                        }
                        var html='<div><p class="my">離線人員...</p>'+each_offline_user+'</div>';
                        us_offline.append(html);

                        if(d.online_users!=false){
                            $.each(d.online_users, function(){
                                var me = this;
                                var online_user_sidebar = $('#us_online').find('p[me_id="'+me[0].id+'"]');
                                if(me[0].no_read>0){
                                    var notread='<span class="u-label g-font-size-11 g-bg-white g-color-main g-rounded-20 g-px-10 c_red" style="float:right;padding: .20rem .25rem;">'+me[0].no_read+'</span>';
                                } else{
                                    var notread='';
                                }
                                online_user_sidebar.append(notread);
                            })
                        }

                    },

                    failure:function(){
                        alert('faialure');
                    }
                });
            }
             
            if(obj==false){
                if(da.type=='rmove'){

                    users[da.nrong].del();
                    delete users[da.nrong];
                    var url = '<?= base_url() ?>' + 'mgmt/message/find_offline_users';
                    var each_offline_user = '';
                    var us_offline = $('#us_offline').empty();
                    $.ajax({
                        url : url,
                        type: 'POST',
                        data: {
                            id_array: da.offline_user,
                        },
                        dataType: 'json',
                        success: function(d) {
                            // console.log(d);
                            if(d.offline_users){
                                $.each(d.offline_users, function(){
                                    var me = this;
                                    var notread='<span class="u-label g-font-size-11 g-bg-white g-color-main g-rounded-20 g-px-10 c_red" style="float:right;padding: .20rem .25rem;">'+me[0].no_read+'</span>';
                                    if(me[0].no_read>0){
                                        each_offline_user += '<p me_id="'+me[0].id+'" offline_name="'+me[0].user_name+'" onclick="change_f_chat('+me[0].id+',\''+me[0].user_name+'\');">'+me[0].user_name+notread+'</p>';
                                    } else{
                                        each_offline_user += '<p me_id="'+me[0].id+'" offline_name="'+me[0].user_name+'" onclick="change_f_chat('+me[0].id+',\''+me[0].user_name+'\');">'+me[0].user_name+'</p>';
                                    }
                                })
                                var html='<div><p class="my">離線人員...</p>'+each_offline_user+'</div>';
                                us_offline.append(html);
                                if(da.r_id==$('#f_chat_id').val()){
                                    $('#us_offline').find('p[me_id="'+da.r_id+'"]').click();
                                }
                            }
                        },
                        failure:function(){
                            alert('faialure');
                        }
                    });
                    // location.reload(); 
                }else if(da.type=='now_rmove'){

                    var url = '<?= base_url() ?>' + 'mgmt/message/find_offline_users';
                    var each_offline_user = '';
                    var us_offline = $('#us_offline').empty();
                    $.ajax({
                        url : url,
                        type: 'POST',
                        data: {
                            id_array: da.offline_user,
                        },
                        dataType: 'json',
                        success: function(d) {
                            // console.log(d);
                            if(d.offline_users){
                                $.each(d.offline_users, function(){
                                    var me = this;
                                    var notread='<span class="u-label g-font-size-11 g-bg-white g-color-main g-rounded-20 g-px-10 c_red" style="float:right;padding: .20rem .25rem;">'+me[0].no_read+'</span>';
                                    if(me[0].no_read>0){
                                        each_offline_user += '<p me_id="'+me[0].id+'" offline_name="'+me[0].user_name+'" onclick="change_f_chat('+me[0].id+',\''+me[0].user_name+'\');">'+me[0].user_name+notread+'</p>';
                                    } else{
                                        each_offline_user += '<p me_id="'+me[0].id+'" offline_name="'+me[0].user_name+'" onclick="change_f_chat('+me[0].id+',\''+me[0].user_name+'\');">'+me[0].user_name+'</p>';
                                    }
                                })
                                var html='<div><p class="my">離線人員...</p>'+each_offline_user+'</div>';
                                us_offline.append(html);
                            }
                        },
                        failure:function(){
                            alert('faialure');
                        }
                    });

                } else{
                    if(da.nrong!=null){
                        da.nrong=da.nrong.replace(/{\\(\d+)}/g,function(a,b){
                            return '<img src="../img/face/'+b+'.gif">';
                        });
                        //da.code 發消息人的code
                    }
     
                    if(da.code1==mkey){
                        if(da.sender==$('#f_chat_id').val()){
                            // obj=A.$$('<div  class="row c3"><p class="c3" style="float:right;padding:3px 15px;"><span>['+da.time+']</span><a>'+users[da.code].innerHTML+'</a>對我說：'+da.nrong+'</p></div></br>');
                            obj=A.$$('<div class="row c3"><div class="col-lg-6" ><p style="padding:3px 15px;float:right;"><div style="word-wrap:break-word;word-break:normal;padding:0px 20px 0px 0px;"><span style="white-space:nowrap;">['+da.time+']</span><a style="white-space:nowrap;">'+users[da.code].innerHTML+':</a><span class="message_row" style="color:#000000;">'+da.nrong+'</span></div></p></div></div></br>');
                            c=da.code;
                            var url = baseUrl + 'mgmt/message/insert';
                            $.ajax({
                                type : "POST",
                                url : url,
                                data : {
                                    me: da.sender,
                                    f_chat_id: da.message_recipient,
                                    message:da.nrong,
                                    status: 1//已讀
                                },
                                success : function(data) {
                                }
                            });
                        } else{
                            var num_span = $('#us_online').find('p[me_id="'+da.sender+'"]');
                            if(num_span.children('span').length>0){
                                $('#us_online').find('p[me_id="'+da.sender+'"]').children('span').text(parseInt($('#us_online').find('p[me_id="'+da.sender+'"]').children('span').text())+1);
                            } else{
                                $('#us_online').find('p[me_id="'+da.sender+'"]').append('<span class="u-label g-font-size-11 g-bg-white g-color-main g-rounded-20 g-px-10 c_red" style="float:right;padding: .20rem .25rem;">1</span>');
                            }
                            // console.log(num_span);
                            var url = baseUrl + 'mgmt/message/insert';
                            $.ajax({
                                type : "POST",
                                url : url,
                                data : {
                                    me: da.sender,
                                    f_chat_id: da.message_recipient,
                                    message:da.nrong,
                                    status: 0//未讀
                                },
                                
                                success : function(data) {
                                    
                                }
                            });
                        }
                    }else if(da.code==mkey){

                        if(da.code1!='all'){
                            obj=A.$$('<div class="row c3"><div class="col-lg-6" style="float:right;text-align:right"><p style="padding:3px 15px;float:right;"><div style="word-wrap:break-word;word-break:normal;padding:0px 20px 0px 0px;"><span style="white-space:nowrap;">['+da.time+']</span><span style="color:#000000;">'+da.nrong+'</span></div></p></div></div></br>');

                        } else{
                            if(users[da.code1]!=null){
                                obj=A.$$('<div class="row c3"><div class="col-lg-6" style="float:right;text-align:right"><p style="padding:3px 15px;float:right;"><div style="word-wrap:break-word;word-break:normal;padding:0px 20px 0px 0px;"><span style="white-space:nowrap;">['+da.time+']</span><span style="color:#000000;">'+da.nrong+'</span></div></p></div></div></br>');
                            }
                        }
                        c=da.code1;
                    }else if(da.code==false){
                        obj=A.$$('<p><span>['+da.time+']</span>'+da.nrong+'</p>');
                    }else if(da.code1){
                        obj=A.$$('<p><span>['+da.time+']</span><a style="white-space:nowrap;">'+users[da.code].innerHTML+'</a>對'+users[da.code1].innerHTML+'說：'+da.nrong+'</p>');
                        c=da.code;
                    }
                }
            }
            if(c){
                if(obj!=false){
                    if(da.type!=='add'){
                        if(obj.children[1]){
                            console.log(obj.children[1]);

                            obj.children[1].onclick=function(){
                                users[c].onclick();
                            }
                        }
                    lct.appendChild(obj);
                    lct.scrollTop=Math.max(0,lct.scrollHeight-lct.offsetHeight);
                    }
                }
            }
        }
    }
    A.$('sd').onclick=function(){
        if(!so){
             return st();
        }
        var da=A.$('nrong').value.trim();
        if(da==''){
            // alert('内容不能空');
            return false;  
        }
        A.$('nrong').value='';
        me_id='<?= $me_id?>';
        var to_chat_id = $('#f_chat_id').val();
        var is_online=$('#is_online').val();
        var to_chat_name=$('#to_chat_name').val();
        var today=new Date();
        if(today.getMonth()+1<10){
            var Month = '0'+(today.getMonth()+1);
        } else{
            var Month = (today.getMonth()+1);
        }
        if(today.getDate()<10){
            var now_Date = '0'+today.getDate();
        } else{
            var now_Date = today.getDate();
        }
        if(today.getHours()<10){
            var Hours = '0'+today.getHours();
        } else{
            var Hours = today.getHours();
        }
        if(today.getMinutes()<10){
            var Minutes = '0'+today.getMinutes();
        } else{
            var Minutes = today.getMinutes();
        }
        if(today.getSeconds()<10){
            var Seconds = '0'+today.getSeconds();
        } else{
            var Seconds = today.getSeconds();
        }
        var currentDateTime = (Month)+ '-'+now_Date+' '+Hours+':'+Minutes+':'+Seconds;
        
        if(is_online==0){
                var url = baseUrl + 'mgmt/message/insert';
                $.ajax({
                    type : "POST",
                    url : url,
                    data : {
                        me: me_id,
                        f_chat_id: to_chat_id,
                        message:da,
                        status: 0//未讀
                    },
                    success : function(data) {
                        message=da.replace(/{\\(\d+)}/g,function(a,b){
                            return '<img src="../img/face/'+b+'.gif">';
                        });
                        // obj=A.$$('<div class="row c3"><div class="col-lg-6" style="float:right;"><p style="padding:3px 15px;float:right;"><div class="col-lg-2" style="padding:6px 10px 10px 0px"><span style="white-space:nowrap;">['+currentDateTime+']</span></div><div class="col-lg-10" style="word-wrap:break-word;word-break:normal;padding:0px 20px 0px 0px;"><span style="color:#000000">'+message+'</div></span></p></div></div></br>');
                        obj=A.$$('<div class="row c3"><div class="col-lg-6" style="float:right;text-align:right"><p style="padding:3px 15px;float:right;"><div style="word-wrap:break-word;word-break:normal;padding:0px 20px 0px 0px;"><span style="white-space:nowrap;">['+currentDateTime+']</span><span class="message_row" msg_id="'+data.last_id+'" style="color:#000000;">'+message+'</span></div></p></div></div></br>');

                        //append
                        lct.appendChild(obj);
                        lct.scrollTop=Math.max(0,lct.scrollHeight-lct.offsetHeight);
                    }
                });
        }
        else{
            so.send('nr='+esc(da)+'&key='+key+'&me_id='+me_id+'&to_chat_id='+to_chat_id+'&is_online='+is_online);
        }
    }
    A.$('nrong').onkeydown=function(e){
        var e=e||event;
        if(e.keyCode == 13 && !e.shiftKey){
            A.$('sd').onclick();
        }
        
        if (e.keyCode == 13 && e.shiftKey) { 
            //$('＜/br＞').appendTo(A.$('nrong'));
            var str = $("#nrong").value;
            str = str.replace(/\n|\r\n/g,"");
             // content = content.replace();
        } 
    }
  
    
    function esc(da){
        da=da.replace(/</g,'<').replace(/>/g,'>').replace(/\"/g,'"');
        return encodeURIComponent(da);
    }
    function cuser(t,code){
        users[code]=t;
        t.onclick=function(){
            // t.parentNode.children.rcss('ck','');
            // t.rcss('','ck');
            $('#ct').empty();
            $('#nrong').val('');
            key=code;
            if($('#f_chat_id').val()!==t.getAttribute('me_id')){
                document.getElementById("ct").innerHTML='';
            }
            $('#rin_send').removeClass('none');
            $('#f_chat_id').val(t.getAttribute('me_id'));
            if(t.getAttribute('me_id')>0){
                $('#is_online').val(1);
            }
            var online_sidebar = $('#us_online').find('p[me_id="'+t.getAttribute('me_id')+'"]');
            var span = online_sidebar.find('span');
            span.remove();
            var chat_with_name =  $('#chat_with_name').empty();
            chat_with_name.append(online_sidebar.text());
            // $('#is_online').val(0);
            var me_id=$('#me_id').val();
            var url = baseUrl + 'mgmt/message/reload_message_record';
        
            $.ajax({
                type : "POST",
                url : url,
                data : {
                    me_id: me_id,
                    to_message_id:  $('#f_chat_id').val(),
                    f_chat_id:  $('#f_chat_id').val(),

                },
                success : function(d) {
                    if(d.msg_list){
                        var message = '';
                    
                        $.each(d.msg_list, function(){
                            var me = this;
                            message=me.content.replace(/{\\(\d+)}/g,function(a,b){
                                return '<img src="../img/face/'+b+'.gif">';
                            });
                            if(me.from_user_id==me_id){
                                obj=A.$$('<div class="row "><div class="col-lg-6" style="float:right;text-align:right"><p style="padding:3px 15px;float:right;"><div style="word-wrap:break-word;word-break:normal;padding:0px 20px 0px 0px;"><span style="white-space:nowrap;">['+me.create_time.substr(5)+']</span><span class="message_row" msg_id="'+me.id+'" style="color:#000000;">'+message+'</span></div></p></div></div></br>');

                                // obj=A.$$('<div class="row"><p style="float:right;padding:3px 15px;"><span>['+me.create_time.substr(5)+']</span>我對<a>'+d.to_user_name_list.user_name+'</a>說：'+message+'</p></div></br>');
                                lct.appendChild(obj);
                                lct.scrollTop=Math.max(0,lct.scrollHeight-lct.offsetHeight);
                            } else{
                                // obj=A.$$('<div><p><span>['+me.create_time.substr(5)+']</span><a>'+d.to_user_name_list.user_name+'</a>對我說：'+message+'</p></div></br>');
                                obj=A.$$('<div class="row "><div class="col-lg-6" ><p style="padding:3px 15px;float:right;"><div style="word-wrap:break-word;word-break:normal;padding:0px 20px 0px 0px;"><span style="white-space:nowrap;">['+me.create_time.substr(5)+']</span><a style="white-space:nowrap;">'+d.to_user_name_list.user_name+':</a><span class="message_row" msg_id="'+me.id+'" style="color:#000000;">'+message+'</span></div></p></div></div></br>');
                                lct.appendChild(obj);
                                lct.scrollTop=Math.max(0,lct.scrollHeight-lct.offsetHeight);
                            }
                        })
                    }
                    $('#nrong').focus();
                }
            });
        }
    }
    A.$('ltian').style.height=(document.documentElement.clientHeight - 250)+'px';
    st();
     
    var bq=A.$('imgbq'),ems=A.$('ems');
    var l=80,r=4,c=5,s=0,p=Math.ceil(l/(r*c));
    var pt='../img/face/';
    bq.onclick=function(e){
        var e=e||event;
        if(!so){
             return st();
        }
        ems.style.display='block';
        document.onclick=function(){
            gb();  
        }
        ct();
        try{e.stopPropagation();}catch(o){}
    }
     
    for(var i=0;i<p;i++){
        var a=A.$$('<a href="javascript:;">'+(i+1)+'</a>');
        ems.children[1].appendChild(a);
        ef(a,i);
    }
    // ems.children[1].children[0].className='ck';
     
    function ct(){
        var wz=bq.weiz();
        with(ems.style){
            top=wz.y-242+'px';
            left=wz.x+bq.offsetWidth-235+'px';
        }
    }
         
    function ef(t,i){
        t.onclick=function(e){
            var e=e||event;
            s=i*r*c;
            ems.children[0].innerHTML='';
            hh();
            // this.parentNode.children.rcss('ck','');
            // this.rcss('','ck');
            try{e.stopPropagation();}catch(o){}
        }
    }
     
    function hh(){
        var z=Math.min(l,s+r*c);
        for(var i=s;i<z;i++){
            var a=A.$$('<img src="'+pt+i+'.gif">');
            hh1(a,i);
            ems.children[0].appendChild(a);
        }
        ct();
    }
     
    function hh1(t,i){
        t.onclick=function(e){
            var e=e||event;
            A.$('nrong').value+='{\\'+i+'}';
            if(!e.ctrlKey){
                gb();
            }
            try{e.stopPropagation();}catch(o){}
        }
    }
     
    // function reload_st(){
    //     st();
    // }

    function gb(){
        ems.style.display='';
        A.$('nrong').focus();
        document.onclick='';
    }
    hh();
    A.on(window,'resize',function(){
        A.$('ltian').style.height=(document.documentElement.clientHeight - 70)+'px';
        ct();
    }) 
 
    var fimg=A.$('upimg');
    var img=new Image();
    var dw=400,dh=300;
    A.on(fimg,'change',function(ev){
        if(!so){
            st();
            return false;
        }
        if(key=='all'){
            alert('發圖僅限制私聊');
            return false;  
        }
        var f=ev.target.files[0];
        if(f.type.match('image.*')){
            var r = new FileReader();
            r.onload = function(e){
                img.setAttribute('src',e.target.result);
            };
            r.readAsDataURL(f);
        }
    });

    img.onload=function(){
        ih=img.height,iw=img.width;
        if(iw/ih > dw/dh && iw > dw){
            ih=ih/iw*dw;
            iw=dw;
        }else if(ih > dh){
            iw=iw/ih*dh;
            ih=dh;
        }
        var rc = A.$$('canvas');
        var ct = rc.getContext('2d');
        rc.width=iw;
        rc.height=ih;
        ct.drawImage(img,0,0,iw,ih);
        var da=rc.toDataURL();
        so.send('nr='+esc(da)+'&key='+key);
    }

 
    // if(location.href.indexOf('#reloaded')==-1){
    //     location.href=location.href+"#reloaded";
    //     location.reload(); 
    //     // st();
    // } 
})();

function change_f_chat(id,name){
        var lus=A.$('us_online'),lct=A.$('ct');
        $('#rin_send').removeClass('none');
        $('#f_chat_id').val(id);
        $('#is_online').val(0);
        $('#to_chat_name').val(name);
        var chat_with_name =  $('#chat_with_name').empty();
        chat_with_name.append(name);
        var me_id=$('#me_id').val();
        var url = baseUrl + 'mgmt/message/reload_message_record';
        $('#ct').empty();
        $('#nrong').val('');

        var offline_sidebar = $('#us_offline').find('p[me_id="'+id+'"]');
        var span = offline_sidebar.find('span');
        span.remove();
        // lct.empty();
        $.ajax({
            type : "POST",
            url : url,
            data : {
                me_id: me_id,
                to_message_id: id,
                f_chat_id:  $('#f_chat_id').val(),
            },
            success : function(d) {
                if(d.msg_list){
                    var message = '';
                    $.each(d.msg_list, function(){
                        var me = this;
                        message=me.content.replace(/{\\(\d+)}/g,function(a,b){
                            return '<img src="../img/face/'+b+'.gif">';
                        });
                        if(me.from_user_id==me_id){
                            obj=A.$$('<div class="row "><div class="col-lg-6" style="float:right;text-align:right"><p style="padding:3px 15px;float:right;"><div style="word-wrap:break-word;word-break:normal;padding:0px 20px 0px 0px;"><span style="white-space:nowrap;">['+me.create_time.substr(5)+']</span><span class="message_row" msg_id="'+me.id+'" style="color:#000000;">'+message+'</span></div></p></div></div></br>');

                            lct.appendChild(obj);
                            lct.scrollTop=Math.max(0,lct.scrollHeight-lct.offsetHeight);
                        } else{
                            // obj=A.$$('<div><p><span>['+me.create_time.substr(5)+']</span><a>'+d.to_user_name_list.user_name+'</a>對我說：'+message+'</p></div></br>');
                            obj=A.$$('<div class="row"><div class="col-lg-6" ><p style="padding:3px 15px;float:right;"><div style="word-wrap:break-word;word-break:normal;padding:0px 20px 0px 0px;"><span style="white-space:nowrap;">['+me.create_time.substr(5)+']</span><a style="white-space:nowrap;">'+d.to_user_name_list.user_name+':</a><span class="message_row" msg_id="'+me.id+'" style="color:#000000;">'+message+'</span></div></p></div></div></br>');
                            lct.appendChild(obj);
                            lct.scrollTop=Math.max(0,lct.scrollHeight-lct.offsetHeight);
                        }
                    })
                }
                $('#nrong').focus();
            }
        });

    }

</script>
