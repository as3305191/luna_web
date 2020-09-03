<?php
$server = new swoole_websocket_server("192.168.3.251", 8082);
$redis = new Redis();
$redis->connect('127.0.0.1', 3306);
$db = new mysqli('127.0.0.1', 'pony', '!pony', 'ktx');

$server->on('open', function (swoole_websocket_server $server, $request) {
 echo "server: handshake success with fd{$request->fd}\n";//$request->fd 是客户端id
});

$server->on('message', function (swoole_websocket_server $server, $frame) {
 $data = json_decode($frame->data,true); 
 if($data['flag'] == 'init'){
  //用户刚连接的时候初始化，每个用户登录时记录该用户对应的fd
  $GLOBALS['redis']->set($data['from_user_id'], $frame->fd);
  //处理发给该用户的离线消息
  $sql = "SELECT `from_user_id`,content FROM ktx.msg_test WHERE `to_user_id`='{$data['from_user_id']}' AND `from_user_id`='{$data['to_user_id']}' AND `status`='0' ORDER BY create_time ASC;";
  if ($result = $GLOBALS['db']->query($sql)) {
   $re = array();
   while ($row = $result->fetch_assoc()) {
    array_push($re, $row);
   }
   $result->free();
   foreach($re as $content){
    $content = json_encode($content);
    $server->push($frame->fd , $content);
   }
   //设置消息池中的消息为已发送
   $sql = "UPDATE ktx.msg_test SET `status`=1 WHERE `to_user_id`='{$data['from_user_id']}' AND `from`='{$data['to_user_id']}';";
   $GLOBALS['db']->query($sql);
  }
 }else if($data['flag'] == 'msg'){
  //非初始化的信息发送，一对一聊天，根据每个用户对应的fd发给特定用户
  $tofd = $GLOBALS['redis']->get($data['to_user_id']); //消息要发给谁
  $fds = []; //所有在线的用户(打开聊天窗口的用户)
  foreach($server->connections as $fd){
   array_push($fds, $fd);
  }
  if(in_array($tofd,$fds)){
   $tmp['from_user_id'] = $data['from_user_id']; //消息来自于谁
   $tmp['content'] = $data['content']; //消息内容
   $re = json_encode($tmp);
   $server->push($tofd , $re);
  }else{
   //该玩家不在线(不在聊天室内)，将信息发送到离线消息池
   $time = time();
   $sql = "INSERT INTO ktx.msg_test (`to_user_id`,`from_user_id`,`content`,`status`,`create_time`) VALUES ('{$data['to_user_id']}','{$data['from_user_id']}','{$data['content']}','0','{$time}');";
   $GLOBALS['db']->query($sql);
  }
 }else if($data['flag'] == 'group'){
  //todo 群聊
  
 }else if($data['flag'] == 'all'){
  //全站广播
  foreach($server->connections as $fd){
   $server->push($fd , $data);
  }
 } 
});

$server->on('close', function ($ser, $fd) {
 echo "client {$fd} closed\n";
});

$server->start();

