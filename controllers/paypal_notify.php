<?

ob_start();

require_once 'payment_settings.php';

$email = 'gkrasulya@gmail.com';
mail($email, 'was', 'was');

$f = fopen('data.txt', 'w');
$s = '';

$s .= "GET:\n\n";

foreach ($_GET as $kw=>$val) {
	$s .= "$kw: $val\n";
}

$s .= "\n\nPOST:\n\n";

foreach ($_POST as $kw=>$val) {
	$s .= "$kw: $val\n";
}

mail($email, 'hello', $s);

fwrite($f, $s);
fclose($f);

$postdata = ''; 
foreach ($_POST as $key => $value) {
	$postdata .= $key . '=' . urlencode($value) . '&';
}
$postdata .= 'cmd=_notify-validate';

$curl = curl_init($paypal_pay_url);
curl_setopt($curl, CURLOPT_HEADER, 0);
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1);

$response = curl_exec($curl);
curl_close($curl);

if ($response != 'VERIFIED') {
	mail($email, 'not verified', "\$postdata: $postdata\n\$response: $response");
	error_log("response is not verified. it's --- $response ---");
	die('You should not do that...');
}

$data = '';
foreach ($_POST as $key => $value) {
	$data .= "$key: $value\n";
}

if (($_POST['receiver_email'] != $paypal_email && $_POST['business'] != $paypal_email ) || $_POST['txn_type'] != 'web_accept') {
	$body = sprintf("
		\$_POST['reciever_email'] (%s) != \$paypal_email (%s)\n
		OR !\n
		\$_POST['txn_type'] (%s) != 'web_accept'
	", $_POST['receiver_email'], $paypal_email, $_POST['txn_type']);
	mail($email, $body, 'Hacking Attemp');
	error_log('hacking attemp');
	die('You should not be here...');
}

$payment_id = addslashes($_POST['item_number']);
$payment = get_record("SELECT * FROM payments WHERE transaction_id=$payment_id LIMIT 1");

if (!$payment || $payment->done == 1) {
	mail($email, 'payment', 'No Such Payment');
	error_log('unable to restore payment');
	die('Unable to restore pro account info. Please, contact gkrasulya@gmail.com');
}

if ((float)$payment->summ_euro != (float)$_POST['mc_gross'] || $_POST['mc_currency'] != 'EUR') {
	$body = "payment amount mismatch\n\n";
	$body .= "{$payment->amount} != {$_POST[mc_gross]}\n";
	$body .= "{$_POST[mc_currency]} != " . CURRENCY;
	mail($email, 'Payment Amount Mismatch', $body);
	error_log('payment amount mismatch');
	die('Payment amount mismatch. Please, contact gkrasulya@gmail.com');
}

mysql_query("UPDATE payments SET done=1 WHERE transaction_id=$payment_id");
mail($email, 'a2', 'a2');

$user = get_record("SELECT * FROM users WHERE id={$payment->user_id} LIMIT 1");

$headers = "Content-type: text/plain; charset=windows-1251\r\n";
$headers .= "From: Hotels-sale.ru <info@hotels-sale.ru>";
mail($email, 'a1', 'a1');

error_log('no errors');

if ($user->type == 'agency') {
	mail($email, '1', '1');
	$sql = "
		UPDATE users
		SET expiration_date = DATE_ADD(
			if(expiration_date < now(), now(), expiration_date),
				INTERVAL {$payment->period} MONTH)
		WHERE
			id = {$user->id}";
	mail($email, '2', '2');

	$subject = 'Продление аккаунта';
	$body = "Пользователь $user->email продлил аккаунт на $payment->summ рублей";
	$user_body = "Вы продлили аккаунт на $payment->period месяц(ев). Теперь ваши предложения будут видны на сайте.";

	mysql_query("UPDATE hotels SET active=1 WHERE user_id={$user->id}");
} else {
	$amount = $user->amount + $payment->summ;
	$sql = "UPDATE users SET amount=$amount WHERE id={$user->id}";

	$subject = 'Пополнение счета';
	$body = "Пользователь $user->email пополнил свой счет на $payment->summ рублей";
	$user_body = "Вы пополнили счет на $payment->summ рублей. Теперь вы можете активировать или продлить ваши предложения.";
}

mysql_query($sql);
mail('alupichev@yandex.ru', $subject, $body, $headers);
mail($user->email, $subject, $user_body, $headers);

$debug = ob_get_contents();
mail($email, '2', $debug);

die();