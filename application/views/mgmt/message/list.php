<style>
.u_name:hover {
  background-color: yellow;
}
#sidebar{
		position: absolute;
		top: 3em;
		width: 32%;
		margin-left: 68%;
		padding: 0.5em 0;
		background-color: #933;
	}
/* #content
{
    margin-right: 32%;
    padding: 0.5em;
} */
</style>

<body>
<?php $this->load->view("layout/sidebar");?>

<div class="bodywrapper">
    <div class="centercontent">
        <div class="pageheader notab">
                <h1 class="pagetitle">聊天室</h1>
        </div><!--pageheader-->

        <div id="contentwrapper" class="contentwrapper withrightpanel">

            <div class="subcontent chatcontent">

                <div id="chatmessage" class="chatmessage radius2">
                    <div id="chatmessageinner"></div><!--chatmessageinner-->
                </div><!--chatmessage-->
                <br>
                <span id="welcome_str"></span>
                <div class="messagebox radius2">
                    <span class="inputbox" style="width:70%;float: left;">
                        <input type="text" id="msgbox" name="msgbox"  />
                    </span>
                    <button id="emotion" class="btn btn-success" style="float: left;">插入表情</button>
                    <button id="send-btn" class="btn btn-warning" style="float: left;margin-left: 20px;">送出</button>
                    <!-- <button class="btn btn-danger" id="leave-btn" style="float: left;margin-left: 20px;">登出/離開</button> -->
                </div>

            </div><!--subcontent-->

        </div><!--contentwrapper-->

        <div class="rightpanel">
            <div class="rightpanelinner">
                <div class="widgetbox uncollapsible">
                    <div class="title"><h4>所有使用者</h4></div>
                    <div class="widgetcontent nopadding">
                            <!-- <div class="chatsearch">
                                <input type="text" name="" value="Search" />
                            </div> -->
                            <input type="hidden" id="to_message_id"/>
                            <input type="hidden" id="me_id" value="<?= isset($me) ? $me -> id : '' ?>"/>
                        <ul class="contactlist" id="all_users">
                        </ul>
                    </div><!--widgetcontent-->
                </div><!--widgetbox-->
            </div><!--rightpanelinner-->
        </div><!--rightpanel-->
    </div><!-- centercontent -->
</div>
</body>
</html>
<!--  使用 QQFace 表情符號 JS-->
<script type="text/javascript" src="<?= base_url('js/jquery.qqFace.js');?>"></script>
<script language="javascript" type="text/javascript">
    $(document).ready(function(){
        //create a new WebSocket object.(建立socket物件)
        var wsUri = "<?= $socket_url;?>";
        websocket = new WebSocket(wsUri);
        websocket.onopen = function(ev) { // connection is open (socket連接時觸發的事件)
            if(ev.isTrusted && ev.type=='open'){
                //確認socket連結是 open 狀態
                //取得名稱
                var name = '<?= $username;?>';
                console.log(name);
                    // $('#chatmessage').append("<div class=\"system_msg\">連結中......</div>"); //notify user
                    // $("#welcome_str").html('歡迎 <b>'+name+' </b>, 請於下方輸入留言:');
                    //prepare json data
                    var msg = {
                        type : 'join_name',
                        join_name: name,
                        color : '<?= $user_colour; ?>',
                        head : '<?= $head;?>',
                    };
                    //convert and send data to server (連接傳送數據)
                    websocket.send(JSON.stringify(msg));
            }
        }

        $('#send-btn').click(function(){ //use clicks message send button
            message_send();
        });

        $('#msgbox').keypress(function(event){ //按下Enter 自動送出訊息
            if(event.keyCode==13){
                message_send();
            }
        });

        function message_send(){
            var mymessage = $('#msgbox').val(); //get message text
            var to_message_id = $('#to_message_id').val(); 
            var my_id = $('#me_id').val(); 

            console.log(to_message_id);
            var myname = '<?= $username;?>'; //get user name

            if(myname == ""){ //empty name?
                alert('尚未登入');
                window.location = "<?=site_url('/login')?>";
                return false;
            }
            if(mymessage == ""){ //emtpy message?
                alert("未輸入留言");
                return false;
            }

            //prepare json data
            var msg = {
                type : 'usermsg',
                message: mymessage,
                name: myname,
                my_id: my_id,
                to_message_id: to_message_id,
                color : '<?= $user_colour; ?>'
            };
            //convert and send data to server (連接傳送數據)
            websocket.send(JSON.stringify(msg));
        }

        $('#leave-btn').click(function(){
            websocket.close();
            $('#chatmessage').append("<div class=\"system_msg\">您已離線...</div>");

            window.location = "<?= site_url().'/login/logout'?>";
        });

        //#### Message received from server? (view端接收server數據時觸發事件)
        websocket.onmessage = function(ev) {
            var msg = JSON.parse(ev.data); //PHP sends Json data
            var type = msg.type; //message type
            var ucolor = msg.color; //color

            if(type == 'usermsg')
            {
                var uname = msg.name; //user name
                var umsg = msg.message; //message text
                var to_message_id = msg.to_message_id; //message text
                var me_id =$('#me_id').val(); //message text
                var my_id = msg.my_id; //message text

                var umsg=replace_em(umsg);//QQ表情 字串轉換
                if(uname && umsg){
                    if(me_id==my_id){
                        $('#chatmessage').append("<div><span class=\"user_name\" style='color:#"+ucolor+"'>"+uname+"</span> : <span class=\"user_message\">"+umsg+"</span></div>");
                    }

                    if(me_id==to_message_id){
                        $('#chatmessage').append("<div><span class=\"user_name\" style='color:#"+ucolor+"'>"+uname+"</span> : <span class=\"user_message\">"+umsg+"</span></div>");
                    }
                   
                }
            }
            if(type == 'system')
            {
                //更新名單
                if(msg.info == 'enter'){
                    var umsg = msg.message; //message text
                    //$('#chatmessage').append("<div class=\"system_msg\">"+umsg+"</div>");
                }

                //更新名單
                // if(msg.info == 'leave'){
                //     var umsg = msg.message; //message text
                //     $('#chatmessage').append("<div class=\"system_msg\">"+umsg+"</div>");

                //     var join_list = msg.join_list; //join list
                //     $('.contactlist').empty();
                //     for(var index in join_list) {
                //         if(join_list[index].join_name){
                //             if(join_list[index].head == ''){
                //                 var img_path = '<?= base_url()."images/thumbs/head/unknown.png"; ?>';
                //             }else{
                //                 var img_path = '<?= base_url()."images/thumbs/head/"; ?>'+join_list[index].head+'.jpg';
                //             }
                //             var add_html = "<li class='online new'><a href=''><img src='"+img_path+"' alt=''><span style='color:#"+join_list[index].color+"'>"+join_list[index].join_name+"</span></a></li>";
                //             $('.contactlist').append(add_html);
                //         }
                //     }
                // }
            }

            // if(type == 'join_name'){
            //     var join_name = msg.join_name; //join name
            //     var join_list = msg.join_list; //join list
            //     // $('#chatmessage').append("<div class=\"system_msg\">"+join_name+"連線成功</div>");
            //     //更新名單
            //     $('.contactlist').empty();
            //     for(var index in join_list) {
            //         if(join_list[index].join_name){
            //             if(join_list[index].head == ''){
            //                 var img_path = '<?= base_url()."images/thumbs/head/unknown.png"; ?>';
            //             }else{
            //                 var img_path = '<?= base_url()."images/thumbs/head/"; ?>'+join_list[index].head+'.jpg';
            //             }
            //             var add_html = "<li class='online new'><a href=''><img src='"+img_path+"' alt=''><span style='color:#"+join_list[index].color+"'>"+join_list[index].join_name+"</span></a></li>";
            //             $('.contactlist').append(add_html);
            //         }
            //     }
            // }


            $('#msgbox').val(''); //reset text
            // $('.contactlist').empty();

         
        };

        websocket.onerror	= function(ev){$('#chatmessage').append("<div class=\"system_error\">Error Occurred - "+ev.data+"</div>");}; //與server連接發生錯誤時
        websocket.onclose 	= function(ev){$('#chatmessage').append("<div class=\"system_msg\">Connection Closed</div>");};  //server被關閉時


		// QQFace 表情符號
		// 設定qqFace  參數
        $('#emotion').qqFace({
            id : 'facebox', //表情盒子的ID
            assign:'msgbox', //對話輸入input控件ID
            path:'<?= base_url().'img/face/';?>'	//表情存放的路径
        });

        //查看结果(表情符號轉換)
        function replace_em(str){
            str = str.replace(/\</g,'&lt;');
            str = str.replace(/\>/g,'&gt;');
            str = str.replace(/\n/g,'<br/>');
            str = str.replace(/\[em_([0-9]*)\]/g,'<img src="<?= base_url().'img/face';?>/$1.gif" border="0" />');
            return str;
        }

    });



    function change(id){
        $('#to_message_id').val(id);
    }  

  function all_users(){//所有人名單
      $.ajax({
          url: '<?= base_url() ?>' + 'mgmt/message/find_all_user',
          type: 'POST',
          data: {},
          dataType: 'json',
          success: function(d) {
              var add_html='';
              $.each(d.all_users, function(){
                  var me = this;
                  add_html += '<a href="" class="list-group-item justify-content-between" onclick="change('+me.id+');">'+
                           ' <span><i class="icon-home g-pos-rel g-top-1 g-mr-8"></i>'+me.user_name+'</span></a> ';
              });
              $('#user_sidebar').append(add_html);

              console.log(d);

          },
          failure:function(){
              alert('faialure');
          }
      });
  }      
  all_users(); 
</script>