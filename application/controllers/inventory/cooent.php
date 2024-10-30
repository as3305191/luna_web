<?php
header("Content-Type:text/html;charset=utf-8");
$link=@mysqli_connect(
'sql204.infinityfree.com','if0_35460407','P59b4OyaJk','if0_35460407_pony');
if(!$link){echo"Mysql連錯<br/>";
echo mysqli_connect_error();
exit();
}

mysqli_query($link,"set names utf8");
?>
