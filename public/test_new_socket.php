<?php
phpinfo();
  if(extension_loaded('sockets')) echo "WebSockets OK";
  else echo "WebSockets UNAVAILABLE";

/*
$new_key="";
require("classes/classes.php");
require("functions/functions.php");


$server = new swoole_server("0.0.0.0", 8090);
$server->on('connect', function ($server, $fd){
    echo "connection open: {$fd}\n";
	file_put_contents("input_data.txt","connection open: ".$fd."\r\n",FILE_APPEND);
});
$server->on('receive', function ($server, $fd, $from_id, $data) {
	
	$udp_client = $server->connection_info($fd, $from_id);
	
	echo $data;
	
	file_put_contents("input_data.txt",$data."\r\n",FILE_APPEND);
	
	$server->send($fd, "<000L;OK;Code;CRC16\n");
	
	/*
		///////////////////////////подключаем базу данных
		$db=new connect_db();
		if($db->state=="connected") {
		$sql="SET SESSION sql_mode = 'ONLY_FULL_GROUP_BY,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION'";
		$db->dbo->exec($sql);
		
		$_SESSION["id_selected_$fd"]=$id;
	
	//////echo $data;
   /// $server->send($fd, "Swoole: {$data}");
	/// ini_set("display_errors","Off");
	
	//// list($header, $body) = explode("\r\n\r\n", $data, 2);
	 

	
	////unset($db);
	
    ////////$server->close($fd);
	*
});
$server->on('close', function ($server, $fd) {
	
	file_put_contents("input_data.txt","Client disconnected: ".$fd."\r\n",FILE_APPEND);
	
	/*
    echo "connection close: {$fd}\n";
	$_SESSION["current_burn_key_request_$fd"]="";
	$_SESSION["change_key_$fd"]="";
	$_SESSION["current_change_key_sid_$fd"]="";
	////перезапуск прошивки
	$db=new connect_db();
		if($db->state=="connected") {
		$sql="SET SESSION sql_mode = 'ONLY_FULL_GROUP_BY,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION'";
		$db->dbo->exec($sql);
		
		$id=$_SESSION["id_selected_$fd"];
		
		$sql="UPDATE controllers set block_id='',current_burn_key='' where id='$id'";
					$db->dbo->exec($sql);
		
	}
	
	*
});
$server->start();

?>
