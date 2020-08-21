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
.bodywrapper
{
    margin-right: 32%;
    padding: 0.5em;
}
.right
{
    float:right;
    text-align: right;

}
.left
{
    float:left;
 
}
#chatmessage {
    border:1px solid #ccc;
    min-height:300px;
    max-height:300px;
    overflow: auto;
    font-size: 14px;      
    outline: none; 
    background-color:white;
}

.none {
	display: none;
}

.mwt_border{
    width:250px;
    height:90px;
    text-align:center;
    background:#fff;
    position:relative;
    border: solid 1px #333;
    margin:30px;
    padding:30px;
}

.mwt_border .arrow_r_int{
    width:0px;
    height:0px;
    border-width:15px;
    border-style:solid;
    border-color:transparent transparent transparent #333;
    position:absolute;
    top:20%;
    right:-30px;
}

</style>

<body>
<?php $this->load->view("layout/sidebar");?>

<div class="bodywrapper">
    <div class="centercontent">
        <div class="pageheader notab">
                <h1 class="pagetitle">聊天室：</h1>
                <span id="chat_name"></span>
        </div><!--pageheader-->

        <div id="contentwrapper" class="contentwrapper withrightpanel">

            <div class="subcontent chatcontent">
                <div id="hello" >
                    <span>歡迎來聊天室</span>
                </div>
                <div id="chatmessage" class="chatmessage radius2 none" contenteditable=true >
                </div>
                <br>
                <span id="welcome_str"></span>
                <div class="messagebox radius2">
                    <span class="inputbox" style="width:70%;float: left;">
                        <input type="text" class="form-control" id="msgbox" name="msgbox"  />
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
                    <!-- <div class="title"><h4>所有使用者</h4></div> -->
                    <div class="widgetcontent nopadding">
                            <!-- <div class="chatsearch">
                                <input type="text" name="" value="Search" />
                            </div> -->
                            <input type="hidden" id="to_message_id" value="0"/>
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
    var $div = $('#chatmessage');

    $(document).ready(function(){
        //create a new WebSocket object.(建立socket物件)
        var wsUri = "<?= $socket_url;?>";
        websocket = new WebSocket(wsUri);
        websocket.onopen = function(ev) { // connection is open (socket連接時觸發的事件)
            if(ev.isTrusted && ev.type=='open'){
                //確認socket連結是 open 狀態
                //取得名稱
                var name = '<?= $username;?>';
                var me_id = '<?= $me->id;?>';

                // console.log(name);
                    // $('#chatmessage').append("<div class=\"system_msg\">連結中......</div>"); //notify user
                    // $("#welcome_str").html('歡迎 <b>'+name+' </b>, 請於下方輸入留言:');
                    //prepare json data
                    var msg = {
                        type : 'join_name',
                        join_name: name,
                        me_id :'<?= $me->id;?>',
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
            var me_id = '<?= $me->id;?>';

            // console.log(to_message_id);
            var myname = '<?= $username;?>'; //get user name
            if(mymessage == ""){ //emtpy message?
                alert("未輸入留言");
                return false;
            }

            //prepare json data
            var msg = {
                type : 'usermsg',
                message: mymessage,
                name: myname,
                my_id: me_id,
                to_message_id: to_message_id,
            };
            websocket.send(JSON.stringify(msg));

            // if(me_id==my_id){
            //     $.ajax({
            //         url: '<?= base_url() ?>' + 'mgmt/message/insert',
            //         type: 'POST',
            //         data: {
            //             me_id:my_id,
            //             to_message_id:to_message_id,
            //             msg:mymessage
            //         },
            //         dataType: 'json',
            //         success: function(d) {
            //         },
            //         failure:function(){
            //             alert('faialure');
            //         }
            //     });
            // }
              
            $('#msgbox').val(''); //reset text
        }
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
                var to_message_id_ = $('#to_message_id').val(); //message text
                var me_id =$('#me_id').val(); //message text
                var my_id = msg.my_id; //message text
                var umsg=replace_em(umsg);//QQ表情 字串轉換

                if(uname && umsg){
                    if(me_id==my_id && to_message_id==to_message_id_){
                        $('#chatmessage').append('<div class="col-md-12" style="padding:0px 0px 15px 0px"><div class="col-md-4 right">'+uname+':<div>'+umsg+'</div></div></div></br>');
                    }

                    if(my_id==to_message_id_){
                        $('#chatmessage').append('<div class="col-md-12" style="padding:0px 0px 15px 0px"><div class="col-md-4 left">'+uname+':<div>'+umsg+'</div></div></div></br>');
                    }

                  
                }
                $div.scrollTop($div[0].scrollHeight);
            }
            if(type == 'system')
            {
                //更新名單
                if(msg.info == 'enter'){
                    var umsg = msg.message; //message text
                    //$('#chatmessage').append("<div class=\"system_msg\">"+umsg+"</div>");
                }
            }
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
            $('#hello').addClass('none');
            $('#chatmessage').removeClass('none');
            $('#to_message_id').val(id);
            var me_id=$('#me_id').val();
            var to_message_id = $('#to_message_id').val();
            var chatmessage_box = $('#chatmessage').empty();

            $.ajax({
                url: '<?= base_url() ?>' + 'mgmt/message/reload_message_record',
                type: 'POST',
                data: {
                    me_id:me_id,
                    to_message_id: to_message_id
                },
                dataType: 'json',
                success: function(d) {
                    if(d){
                        var msg_html = '';
                        $.each(d.msg_list, function(){
                            var me = this;
                            if(me.user_id==me_id){
                                msg_html += '<div class="col-md-12 " style="padding:0px 0px 15px 0px"><div class="col-md-4 right">'+me.user_name+':<div>'+me.msg+'</div></div></div></br>';
                            } else{
                                msg_html += '<div class="col-md-12 " style="padding:0px 0px 15px 0px"><div class="col-md-4 left">'+me.user_name+':<div>'+me.msg+'</div></div></div></br>';
                            }
                        });
                        chatmessage_box.append(msg_html);
                        $('#chat_name').text(d.to_user_name_list.user_name);

                    }

                    $div.scrollTop($div[0].scrollHeight);

                },
                failure:function(){
                    alert('faialure');
                }
            });
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
                  add_html += '<a id="user_'+me.id+'" class="list-group-item justify-content-between u_name" user_name="'+me.user_name+'" onclick="change('+me.id+');">'+' <span><i class="icon-home g-pos-rel g-top-1 g-mr-8"></i>'+me.user_name+'</span></a> ';
              });
              $('#user_sidebar').append(add_html);


          },
          failure:function(){
              alert('faialure');
          }
      });
  }      
  all_users(); 
</script>