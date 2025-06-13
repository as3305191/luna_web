<?php
error_reporting(E_ALL ^ E_NOTICE);
ob_implicit_flush();
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS, post, get');
header('Access-Control-Max-Age: 3600');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
header('Access-Control-Allow-Credentials: true');
//地址與接口，即創建socket時需要服務器的IP和端口
// $sk=new Sock('127.0.0.1',8081);
$sk=new Sock('192.168.1.205',8081);
$sk->run();

 
//下面是sock類
class Sock{
    public $sockets; //socket的連接池，即client連接進來的socket標誌
    public $users;   //所有client連接進來的信息，包括socket、client名字等
    public $master;  //socket的resource，即前期初始化socket時返回的socket
    public $online_user;

    private $sda=array();   //已接收的數據
    private $slen=array();  //數據的總長
    private $sjen=array();  //接收的數據總長
    private $ar=array();    //加密key
    private $n=array();


    public function __construct($address, $port){
 
        //建socket並把保存socket資源在$this->master
        $this->master=$this->WebSocket($address, $port);
 
        //創建socket的連接池
        $this->sockets=array($this->master);
    }
     
    //對創建的socket循環進行監聽，處理數據
    function run(){
        //死循环，直到socket断开
        while(true){
            $changes=$this->sockets;
            $write=NULL;
            $except=NULL;
            socket_select($changes,$write,$except,NULL);
            foreach($changes as $sock){
                 
                //如果有新的client連接近來，則
                if($sock==$this->master){
 
                    //接受一个socket連接
                    $client=socket_accept($this->master);
 
                    //给新連接近來的socket一个唯一的ID
                    $key=uniqid();
                    $this->sockets[]=$client;  //將新連接近來的socket存近連接池
                    $this->users[$key]=array(
                        'socket'=>$client,  //紀錄新連接近來client的socket信息
                        'shou'=>false       //標誌该socket资源没有完成握手
                    );
                //否則1.为client断开socket連接，2.client发送信息
                }else{
                    $len=0;
                    $buffer='';
                    //读取该socket的信息，注意：第二个参数是引用传参即接收数据，第三个参数是接收数据的长度
                    do{
                        $l=socket_recv($sock,$buf,1000,0);
                        $len+=$l;
                        $buffer.=$buf;
                    }while($l==1000);
 
                    //根据socket在user池里面查找相应的$k,即健ID
                    $k=$this->search($sock);
 
                    //如果接收的信息长度小于7，則该client的socket为断开連接
                    if($len<7){
                        //给该client的socket近行断开操作，并在$this->sockets和$this->users里面近行删除
                        $this->send2($k);
                        continue;
                    }
                    //判断该socket是否已经握手
                    if(!$this->users[$k]['shou']){
                        //如果没有握手，則近行握手处理
                        $this->woshou($k,$buffer);
                    }else{
                        //走到这里就是该client发送信息了，对接受到的信息近行uncode处理
                        $buffer = $this->uncode($buffer,$k);
                        if($buffer==false){
                            continue;
                        }
                        //如果不为空，則近行消息推送操作
                        $this->send($k,$buffer);
                    }
                }
            }
             
        }
         
    }
     
    //指定关闭$k对应的socket
    function close($k){
        //断开相应socket
        socket_close($this->users[$k]['socket']);
        //删除相应的user信息
        unset($this->users[$k]);
        //重新定义sockets連接池
        $this->sockets=array($this->master);
        foreach($this->users as $v){
            $this->sockets[]=$v['socket'];
        }
        //输出日志
        $this->e("key:".$k." c1ose");
    }
     
    //根据sock在users里面查找相应的$k
    function search($sock){
        foreach ($this->users as $k=>$v){
            if($sock==$v['socket'])
            return $k;
        }
        return false;
    }
     
    //传相应的IP与端口近行创建socket操作
    function WebSocket($address,$port){
        $server = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        socket_set_option($server, SOL_SOCKET, SO_REUSEADDR, 1);//1表示接受所有的数据包
        socket_bind($server, $address, $port);
        socket_listen($server);
        $this->e('Server Started : '.date('Y-m-d H:i:s'));
        $this->e('Listening on   : '.$address.' port '.$port);
        return $server;
    }
     
     
    /*
    * 函数说明：对client的请求近行回应，即握手操作
    * @$k clien的socket对应的健，即每个用户有唯一$k并对应socket
    * @$buffer 接收client请求的所有信息
    */
    function woshou($k,$buffer){
 
        //截取Sec-WebSocket-Key的值并加密，其中$key后面的一部分258EAFA5-E914-47DA-95CA-C5AB0DC85B11字符串应该是固定的
        $buf  = substr($buffer,strpos($buffer,'Sec-WebSocket-Key:')+18);
        $key  = trim(substr($buf,0,strpos($buf,"\r\n")));
        $new_key = base64_encode(sha1($key."258EAFA5-E914-47DA-95CA-C5AB0DC85B11",true));
         
        //按照协议组合信息近行返回
        $new_message = "HTTP/1.1 101 Switching Protocols\r\n";
        $new_message .= "Upgrade: websocket\r\n";
        $new_message .= "Sec-WebSocket-Version: 13\r\n";
        $new_message .= "Connection: Upgrade\r\n";
        $new_message .= "Sec-WebSocket-Accept: " . $new_key . "\r\n\r\n";
        socket_write($this->users[$k]['socket'],$new_message,strlen($new_message));
 
        //对已经握手的client做標誌
        $this->users[$k]['shou']=true;
        return true;
    }
     
    //解码函数
    function uncode($str,$key){
        $mask = array(); 
        $data = ''; 
        $msg = unpack('H*',$str);
        $head = substr($msg[1],0,2); 
        if ($head == '81' && !isset($this->slen[$key])) { 
            $len=substr($msg[1],2,2);
            $len=hexdec($len);//把十六近制的轉換十近制
            if(substr($msg[1],2,2)=='fe'){
                $len=substr($msg[1],4,4);
                $len=hexdec($len);
                $msg[1]=substr($msg[1],4);
            }else if(substr($msg[1],2,2)=='ff'){
                $len=substr($msg[1],4,16);
                $len=hexdec($len);
                $msg[1]=substr($msg[1],16);
            }
            $mask[] = hexdec(substr($msg[1],4,2)); 
            $mask[] = hexdec(substr($msg[1],6,2)); 
            $mask[] = hexdec(substr($msg[1],8,2)); 
            $mask[] = hexdec(substr($msg[1],10,2));
            $s = 12;
            $n=0;
        }else if($this->slen[$key] > 0){
            $len=$this->slen[$key];
            $mask=$this->ar[$key];
            $n=$this->n[$key];
            $s = 0;
        }
         
        $e = strlen($msg[1])-2;
        for ($i=$s; $i<= $e; $i+= 2) { 
            $data .= chr($mask[$n%4]^hexdec(substr($msg[1],$i,2))); 
            $n++; 
        } 
        $dlen=strlen($data);
         
        if($len > 255 && $len > $dlen+intval($this->sjen[$key])){
            $this->ar[$key]=$mask;
            $this->slen[$key]=$len;
            $this->sjen[$key]=$dlen+intval($this->sjen[$key]);
            $this->sda[$key]=$this->sda[$key].$data;
            $this->n[$key]=$n;
            return false;
        }else{
            unset($this->ar[$key],$this->slen[$key],$this->sjen[$key],$this->n[$key]);
            $data=$this->sda[$key].$data;
            unset($this->sda[$key]);
            return $data;
        }
         
    }
     
    //与uncode相对
    function code($msg){
        $frame = array(); 
        $frame[0] = '81'; 
        $len = strlen($msg);
        if($len < 126){
            $frame[1] = $len<16?'0'.dechex($len):dechex($len);
        }else if($len < 65025){
            $s=dechex($len);
            $frame[1]='7e'.str_repeat('0',4-strlen($s)).$s;
        }else{
            $s=dechex($len);
            $frame[1]='7f'.str_repeat('0',16-strlen($s)).$s;
        }
        $frame[2] = $this->ord_hex($msg);
        $data = implode('',$frame); 
        return pack("H*", $data); 
    }
     
    function ord_hex($data)  { 
        $msg = ''; 
        $l = strlen($data); 
        for ($i= 0; $i<$l; $i++) { 
            $msg .= dechex(ord($data[$i])); 
        } 
        return $msg; 
    }
     
    //用户加入或client发送信息
    function send($k,$msg){
        //將查询字符串解析到第二个参数变量中，以数组的形式保存如：parse_str("name=Bill&age=60",$arr)
        parse_str($msg,$g);
        $ar=array();
 
        if($g['type']=='add'){
            //第一次近入添加聊天名字，把姓名保存在相应的users里面
            $this->users[$k]['name']=$g['ming'];
            $this->users[$k]['me_id']=$g['me_id'];
            $ar['type']='add';
            $ar['name']=$g['ming'];
            $ar['me_id']=$g['me_id'];
            $me_id=$g['me_id'];
         
            $map_all_user = array();
            $key='all';
            $link=@mysqli_connect('127.0.0.1','pony','!pony','ktx');
            if(!$link){
                echo"Mysql連錯<br/>";
                echo mysqli_connect_error();
                exit();
            }
            $sql2="SELECT now_online FROM `user_online` WHERE id='1'";

            $all_online_user=mysqli_query($link,$sql2);
            // $row=mysqli_fetch_assoc($all_online_user);
            while($r = mysqli_fetch_assoc($all_online_user)) {
                $rows[] = $r;
            }
            
            $now_all_online_user = json_encode($rows[0]);
            // $this->online_user=mb_split(",",$now_all_online_user->now_online);
            $now_all_online_user_json = json_decode($now_all_online_user);
            if($now_all_online_user_json->now_online==''){
                $this->online_user=array();
            } else{
                $this->online_user=mb_split(",",$now_all_online_user_json->now_online);
            }
            if($me_id>0){
                if(count($this->online_user)>0){
                    if(!in_array($me_id,$this->online_user)){
                        array_push($this->online_user,$me_id);
                        $now_online_user = implode(",",$this->online_user);
                        $sql3="UPDATE user_online SET now_online='$now_online_user' WHERE id='1'";
                        mysqli_query($link,$sql3);
                    }
                } else{
                    $this->online_user = [];
                    $this->online_user[] = $me_id;
                    $now_online_user = $this->online_user;
                    $sql4="UPDATE user_online SET now_online='$now_online_user[0]' WHERE id='1'";
                    mysqli_query($link,$sql4);
                }
            }

            $sql="SELECT id FROM `users` WHERE status='0' ";
            $select=mysqli_query($link,$sql);
            foreach($select as $each){
                $map_all_user[]=$each['id'];
            }
            $offline_user[]=array_diff($map_all_user,$this->online_user);
            $ar['online_user']=$this->online_user;
            $ar['offline_user']=$offline_user;

        }else if($g['type']=='old_remove'){
            $socket=$g['socket'];
            $me_id=$g['me_id'];
            $this->close($socket);
            $link=@mysqli_connect('127.0.0.1','pony','!pony','ktx');
            if(!$link){
                echo"Mysql連錯<br/>";
                echo mysqli_connect_error();
                exit();
            }
            $sql="SELECT id FROM `users` WHERE code='$socket'";
            $select=mysqli_query($link,$sql);
            mysqli_query($link,$sql);
            foreach($select as $each){
                $map_all_user[]=$each['id'];
            }
            $now_online=array_diff($this->online_user,$map_all_user);
            $this->online_user=$now_online;
            $ar['now_online']=$this->online_user;
            $sql1="SELECT id FROM `users` WHERE status='0' ";
            $select1=mysqli_query($link,$sql1);
            foreach($select1 as $each){
                $map_all_user1[]=$each['id'];
            }
            $offline_user[]=array_diff($map_all_user1,$this->online_user);
            $ar['offline_user']=$offline_user;
    
            $now_online_user = implode(',',$ar['now_online']) ;
            $sql4="UPDATE user_online SET now_online='$now_online_user' WHERE id='1'";
            mysqli_query($link,$sql4);

            $sql="UPDATE users SET code='0' WHERE id='$me_id'";
            mysqli_query($link,$sql);
            $ar['type']='now_rmove';
            $ar['nrong']=$socket;
            $this->send1(false,$ar,'all');

        }  else{
            //发送信息行为，其中$g['key']表示面对大家还是个人，是前段传过来的信息
            $ar['nrong']=$g['nr'];
            $ar['sender']=$g['me_id'];
            $ar['message_recipient']=$g['to_chat_id'];
            $is_online=$g['is_online'];//0沒上限1上限2公開群組
            $ar['is_online']= $is_online;
            $key=$g['key'];
            if( $ar['is_online']==0){//未上限所以未讀
                $link=@mysqli_connect('127.0.0.1','pony','!pony','ktx');
                if(!$link){
                    echo"Mysql連錯<br/>";
                    echo mysqli_connect_error();
                    exit();
                }
                $content=$ar['nrong'];
                $from_user_id=$ar['sender'];
                $to_user_id=$ar['message_recipient'];
                $sql="INSERT INTO user_msg('from_user_id','to_user_id','content','status')VALUES('$from_user_id','$to_user_id','$content','0')";
                $last_id = mysqli_query($link,$sql);
                $ar['last_id']=$last_id;
            } else{
               
                $link=@mysqli_connect('127.0.0.1', 'pony', '!pony', 'ktx');
                if (!$link) {
                    echo"Mysql連錯<br/>";
                    echo mysqli_connect_error();
                    exit();
                }
                $to_user_id = $ar['message_recipient'];
                $content=$ar['nrong'];
                $from_user_id=$ar['sender'];
                $sql="SELECT code FROM `users` WHERE id='$to_user_id'";
                $select=mysqli_query($link, $sql);
                while ($r = mysqli_fetch_assoc($select)) {
                    $rows[] = $r;
                }
                $to_message_user= json_encode($rows[0]);
                // $this->online_user=mb_split(",",$now_all_online_user->now_online);
                $to_message_user_list= json_decode($to_message_user);
                if ($to_message_user_list->code==0) {//對方沒上線
                   
                    $ar['status']='0';
                    $this->insert_to_user_is_offline_content($ar);
                } else{
                    $ar['status']='1';
                }
            }
        }
           
        //推送信息
        $this->send1($k,$ar,$key);
    }
    
    function getusers(){
        $users_list = [];
        foreach($this->users as $socketID => $user){
            $users_list[] = [
                'code' => $socketID,
                'name' => $user['name'],
                'me_id' => $user['me_id']
            ];
        }
        return $users_list;
    }
     
    function send1($fromSocketID, $messageArr, $toSocketID = 'all'){
        $messageArr['code1'] = $toSocketID;
        $messageArr['code'] = $fromSocketID;
        date_default_timezone_set('Asia/Taipei');
        $messageArr['time'] = date('m-d H:i:s');
    
        $me_id = $messageArr['me_id'] ?? null;
    
        $encodedMsg = $this->code(json_encode($messageArr));
    
        if ($toSocketID === 'all') {
            $users = $this->users;
    
            // 新增用戶特別處理
            if ($messageArr['type'] === 'add') {
                $link = $this->getDbConnection();
                if (!$link) return;
    
                $sql = "UPDATE users SET code = ? WHERE id = ?";
                $stmt = $link->prepare($sql);
                $stmt->bind_param('si', $fromSocketID, $me_id);
                $stmt->execute();
    
                $messageArr['type'] = 'madd';
                $messageArr['users'] = $this->getusers();
    
                $encodedNewClientMsg = $this->code(json_encode($messageArr));
    
                // 只發送給新加入用戶自己
                socket_write($users[$fromSocketID]['socket'], $encodedNewClientMsg, strlen($encodedNewClientMsg));
    
                // 移除新用戶，避免後面再次廣播
                unset($users[$fromSocketID]);
            }
    
            // 廣播給其他在線用戶
            foreach ($users as $user) {
                socket_write($user['socket'], $encodedMsg, strlen($encodedMsg));
            }
        } else {
            // 單獨對某個用戶發送訊息（雙向聊天）
            if ($messageArr['is_online'] == 0) {
                // 如果對方不在線，可考慮呼叫存離線訊息的函式
                $this->insert_to_user_is_offline_content($messageArr);
            } else {
                if ($messageArr['status'] == 0) {
                    // 只發送給發送者自己（例如系統回覆）
                    socket_write($this->users[$fromSocketID]['socket'], $encodedMsg, strlen($encodedMsg));
                } else {
                    // 雙方都發送訊息
                    socket_write($this->users[$fromSocketID]['socket'], $encodedMsg, strlen($encodedMsg));
                    if (isset($this->users[$toSocketID])) {
                        socket_write($this->users[$toSocketID]['socket'], $encodedMsg, strlen($encodedMsg));
                    }
                }
            }
        }
    }
     
    // 插入離線訊息到資料庫
function insert_to_user_is_offline_content($messageArr){
    $link = $this->getDbConnection();
    if (!$link) return;

    $content = $messageArr['nrong'] ?? '';
    $from_user_id = $messageArr['sender'] ?? 0;
    $to_user_id = $messageArr['message_recipient'] ?? 0;

    $sql = "INSERT INTO user_msg (from_user_id, to_user_id, content, status) VALUES (?, ?, ?, 0)";
    $stmt = $link->prepare($sql);
    if ($stmt) {
        $stmt->bind_param('iis', $from_user_id, $to_user_id, $content);
        $stmt->execute();
        $messageArr['last_id'] = $stmt->insert_id;
        $stmt->close();
    }
}

// 取得資料庫連線，封裝成函式方便維護
function getDbConnection(){
    $link = @mysqli_connect('127.0.0.1', 'pony', '!pony', 'ktx');
    if (!$link) {
        error_log("MySQL 連線錯誤: " . mysqli_connect_error());
        return false;
    }
    return $link;
}

   // 用戶退出通知
function send2($socketID){
    $this->close($socketID);
    $ar = [
        'type' => 'rmove',
        'nrong' => $socketID,
    ];

    $link = $this->getDbConnection();
    if (!$link) return;

    // 取得該用戶 ID
    $sql = "SELECT id FROM users WHERE code = ?";
    $stmt = $link->prepare($sql);
    $stmt->bind_param('s', $socketID);
    $stmt->execute();
    $result = $stmt->get_result();
    $off_user_id = null;
    if ($row = $result->fetch_assoc()) {
        $off_user_id = $row['id'];
    }
    $stmt->close();

    $ar['r_id'] = $off_user_id;

    // 更新該用戶 code 為 0（表示離線）
    $sql_update = "UPDATE users SET code = '0' WHERE code = ?";
    $stmt_update = $link->prepare($sql_update);
    $stmt_update->bind_param('s', $socketID);
    $stmt_update->execute();
    $stmt_update->close();

    // 更新線上用戶列表
    $this->online_user = array_filter($this->online_user, function($val) use ($off_user_id) {
        return $val != $off_user_id;
    });

    $ar['now_online'] = $this->online_user;

    // 取得所有離線用戶
    $offline_sql = "SELECT id FROM users WHERE status = 0";
    $offline_result = $link->query($offline_sql);
    $offline_users = [];
    while ($row = $offline_result->fetch_assoc()) {
        $offline_users[] = $row['id'];
    }
    $ar['offline_user'] = array_diff($offline_users, $this->online_user);

    // 廣播通知所有在線用戶
    $this->send1(false, $ar, 'all');

    // 更新 user_online 表
    $now_online_str = implode(',', $this->online_user);
    $sql_update_online = "UPDATE user_online SET now_online = ? WHERE id = 1";
    $stmt_online = $link->prepare($sql_update_online);
    $stmt_online->bind_param('s', $now_online_str);
    $stmt_online->execute();
    $stmt_online->close();
}
    //紀錄日志
    function e($str){
        //$path=dirname(__FILE__).'/log.txt';
        $str=$str."\n";
        //error_log($str,3,$path);
        //编码处理
        echo iconv('utf-8','gbk//IGNORE',$str);
    }
}
