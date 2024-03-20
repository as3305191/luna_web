<?php
error_reporting(E_ALL ^ E_NOTICE);
ob_implicit_flush();
 
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

            /*
            //
            socket_select ($sockets, $write = NULL, $except = NULL, NULL);
            $write是監聽是否有客户端寫數據，傳入NULL是不理是否有寫變化。
            $except是$sockets里面要被排除的元素，傳入NULL是”監聽”全部。
            最后一个參數超時
            如果0：立刻結束
            如果n>1: 則最多在n秒后结束，如遇某一个連接有新動態，則提前返回
            如果null：如遇某一个連接有新動態，則返回
            */
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
            // error_log(print_r($now_all_online_user_json->now_online,true));
            // error_log(print_r($this->online_user,true));

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

            $sql="SELECT id FROM `users` WHERE status='0'";
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
            // $now_off_user = array();
            // foreach($select as $each){
            //     $now_off_user[]=$each['id'];
            // }
            mysqli_query($link,$sql);
            foreach($select as $each){
                $map_all_user[]=$each['id'];
            }
            $now_online=array_diff($this->online_user,$map_all_user);
            $this->online_user=$now_online;
            $ar['now_online']=$this->online_user;
            $sql1="SELECT id FROM `users` WHERE status='0'";
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
    
    //对新加入的client推送已经在线的client
    function getusers(){
        $ar=array();
        foreach($this->users as $k=>$v){
            $ar[]=array('code'=>$k,'name'=>$v['name'],'me_id'=>$v['me_id']);
        }
        return $ar;
    }
     
    //$k 发信息人的socketID $key接受人的 socketID ，根据这个socketID可以查找相应的client近行消息推送，即指定client近行发送
    function send1($k,$ar,$key='all'){
        $ar['code1']=$key;
        $ar['code']=$k;
        date_default_timezone_set('Asia/Taipei');
        $ar['time']=date('m-d H:i:s');
        $me_id=$ar['me_id'];
        
        //对发送信息近行编码处理
        $str = $this->code(json_encode($ar));
        //面对大家即所有在线者发送信息
        
        if($key=='all'){
            $users=$this->users;
            //如果是add表示新加的client
            if($ar['type']=='add'){
                $link=@mysqli_connect('127.0.0.1','pony','!pony','ktx');
                if(!$link){
                    echo"Mysql連錯<br/>";
                    echo mysqli_connect_error();
                    exit();
                }
                $socket = $ar['code'];
                $sql="UPDATE users SET code='$socket' WHERE id='$me_id'";
                mysqli_query($link,$sql);
                $ar['type']='madd';
                $ar['users']=$this->getusers();        //取出所有在线者，用于显示在在线用户列表中
                $str1 = $this->code(json_encode($ar)); //单独对新client近行编码处理，数据不一样
                //对新client自己单独发送，因为有些数据是不一样的
                socket_write($users[$k]['socket'],$str1,strlen($str1));
                //上面已经对client自己单独发送的，后面就无需再次发送，故unset
                unset($users[$k]);
            }
            //除了新client外，对其他client近行发送信息。数据量大时，就要考虑延时等问题了
            foreach($users as $v){
                socket_write($v['socket'],$str,strlen($str));
            }
          
        }else{
            //单独对个人发送信息，即双方聊天  
            if( $ar['is_online']==0){//未上限所以未讀
         
            } else{
                if( $ar['status']==0){
                    socket_write($this->users[$k]['socket'],$str,strlen($str));
                } else{
                    socket_write($this->users[$k]['socket'],$str,strlen($str));
                    socket_write($this->users[$key]['socket'],$str,strlen($str));
                }
            }       
        }
    }
     
    function insert_to_user_is_offline_content($ar){
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
        // error_log(print_r($sql,true));
        $insert=mysqli_query($link,$sql);
        // error_log(print_r($insert,true));
        $ar['last_id']=$insert;
    }

    //用户退出向所用client推送信息
    function send2($k){
        $this->close($k);
        $ar['type']='rmove';
        $ar['nrong']=$k;
        $link=@mysqli_connect('127.0.0.1','pony','!pony','ktx');
        if(!$link){
            echo"Mysql連錯<br/>";
            echo mysqli_connect_error();
            exit();
        }
        $sql="SELECT id FROM `users` WHERE code='$k'";
        $select=mysqli_query($link,$sql);
        while ($r = mysqli_fetch_assoc($select)) {
            $rows[] = $r;
        }
        $off_user= json_encode($rows[0]);
        $off_user_list= json_decode($off_user);
        $ar['r_id']=$off_user_list->id;
        // $now_off_user = array();
        // foreach($select as $each){
        //     $now_off_user[]=$each['id'];
        // }
        foreach($select as $each){
            $id = $each['id'];
            $sql5="UPDATE users SET code= '0' WHERE id='$id'";
            mysqli_query($link,$sql5);
            $map_all_user[]=$id;
        }
        $now_online=array_diff($this->online_user,$map_all_user);
        $this->online_user=$now_online;
        $ar['now_online']=$this->online_user;
        $sql1="SELECT id FROM `users` WHERE status='0'";
        $select1=mysqli_query($link,$sql1);
        foreach($select1 as $each){
            $map_all_user1[]=$each['id'];
        }
        $offline_user[]=array_diff($map_all_user1,$this->online_user);
        $ar['offline_user']=$offline_user;
        $this->send1(false,$ar,'all');

        $now_online_user = implode(',',$ar['now_online']) ;
        $sql4="UPDATE user_online SET now_online='$now_online_user' WHERE id='1'";
        mysqli_query($link,$sql4);
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
