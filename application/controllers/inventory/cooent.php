<?php
header("Content-Type:text/html;charset=utf-8");
$link=@mysqli_connect(
'127.0.0.1','pony','!pony','ktx');
if(!$link){echo"Mysql連錯<br/>";
echo mysqli_connect_error();
exit();
}

mysqli_query($link,"set names utf8");
?>
