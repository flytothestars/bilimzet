<?php
ini_set("display_errors","On");
require("classes/classes.php");
require("functions/functions.php");

//////Ð¿ÐµÑ€ÐµÐ¼ÐµÐ½Ð½Ñ‹Ðµ
$pg_order_id=clear($_REQUEST['pg_order_id']);
$pg_amount=clear($_REQUEST['pg_amount']);

////обработка результатов платежа

$db = new connect_db();
if ($db->state=="connected") {
	$sql = "SET SESSION sql_mode = 'ONLY_FULL_GROUP_BY,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION'";
	$db->dbo->exec($sql);

	////получаем ид пользователя, который создал этот платеж
	$sql="SELECT user_id, processed from payment_orders where id='$pg_order_id'";
	foreach ($db->dbo->query($sql) as $row){
		$user_id=$row[0];
		$processed = $row[1];
		if ($processed) {
			exit();
		}
	}

	///Обновляем пользователю баланс
	$sql="UPDATE users set money_amount_kzt=money_amount_kzt+$pg_amount where id='$user_id'";
	$db->dbo->exec($sql);

	$sql="UPDATE payment_orders set processed=1 where id='$pg_order_id'";
	$db->dbo->exec($sql);
}
