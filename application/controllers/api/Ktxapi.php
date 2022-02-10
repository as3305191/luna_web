<?php
class Ktxapi extends MY_Base_Controller {

	function __construct() {
		parent::__construct();
		
	}

	public function test() {
		header("Content-Type:text/html;charset=utf-8");
		$link=@mysqli_connect(
		'192.168.1.248\MSSQL104EHRMS','pony','!pony','97238228');
		if(!$link){echo"Mysql連錯<br/>";
		echo mysqli_connect_error();
		exit();
		}

		mysqli_query($link,"set names utf8");
		$sql="SELECT * FROM `dbo.HRMST_NOTIFY_MANUAL` ";

		$list=mysqli_query($link,$sql);
		while($r = mysqli_fetch_assoc($list)) {
			$rows[] = $r;
		}
		
		$now_all_online_user = json_encode($rows[0]);
		echo($now_all_online_user);
	}
}
?>
