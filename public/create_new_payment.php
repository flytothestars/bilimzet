<?php
ini_set("display_errors","On");
require("classes/classes.php");
require("functions/functions.php");

$user_id = clear($_REQUEST['user_id']);
$user_email = clear($_REQUEST['user_email']);
$amount = clear($_REQUEST['amount']);
$amount_real = clear($_REQUEST['amount']);

$db = new connect_db();
if ($db->state == "connected") {
	$sql="SET SESSION sql_mode = 'ONLY_FULL_GROUP_BY,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION'";
	$db->dbo->exec($sql);

	$user_id = $db->dbo->quote($user_id);
	$user_email = $db->dbo->quote($user_email);
	$amount=$db->dbo->quote($amount);

	///добавляем в базу данных
	$sql="INSERT INTO payment_orders(user_id,amount,data_add,processed) values($user_id,$amount,'".time()."',0)";
	$db->dbo->exec($sql);

	///получаем ид заказа
	$pg_order_id = $db->dbo->lastInsertId();;

	$secret_key="oYhRW2DCMYnz5CbD";

	$request = [
		 'pg_merchant_id'=> 524685,
		 'pg_amount' => $amount_real * 1,
		 'pg_salt' => md5(time()),
		 'pg_order_id'=> $pg_order_id,
		 'pg_description' => 'Пополнение баланса',
		 'pg_testing_mode' => '0',
		 'pg_result_url' => 'https://kcppk.kz/pay_result.php'
	];

	ksort($request);
	array_unshift($request, 'payment.php');
	array_push($request, $secret_key);

	$pg_sig = md5(implode(';', $request));
?>
	<form method="POST" action="https://api.paybox.money/payment.php" id="goto_paybox">
		<input type="hidden" name="pg_merchant_id" value="<?=$request["pg_merchant_id"]?>">
		<input type="hidden" name="pg_order_id" value="<?=$request["pg_order_id"]?>">
		<input type="hidden" name="pg_amount" value="<?=$request["pg_amount"]?>">
		<input type="hidden" name="pg_description" value="<?=$request["pg_description"]?>">
		<input type="hidden" name="pg_salt" value="<?=$request["pg_salt"];?>">
		<input type="hidden" name="pg_sig" value="<?=$pg_sig;?>">
		<input type="hidden" name="pg_testing_mode" value="0">
		<input type="hidden" name="pg_result_url" value="<?=$request["pg_result_url"];?>">
	</form>
	Перенаправление на платежный шлюз paybox.money...
	<script>
		document.getElementById('goto_paybox').submit();
	</script>

<?php
}
