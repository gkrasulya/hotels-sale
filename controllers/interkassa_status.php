<?

require_once 'payment_settings.php';

$email = 'gkrasulya@gmail.com';

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

mail($email, 'hello', $s); # sending GET and POST to email for debug
fwrite($f, $s); # and writing to `data.txt`
fclose($f);

# request method must be `POST`
if ($_SERVER['REQUEST_METHOD'] != 'POST') die('You should not do that...');
# post `ik_payment_state` must be 'success'
if ($_POST['ik_payment_state'] != 'success') die();

$payment_id = $_POST['ik_payment_id'];
$payment = get_record("SELECT * FROM payments WHERE transaction_id=$payment_id LIMIT 1");

if (!$payment || $payment->done == 1) {
	mail($email, 'payment', 'No Such Payment');
	die('Unable to restore pro account info. Please, contact parademodels@gmail.com');
}

if ($payment->summ != $_POST['ik_payment_amount']) {
	mail($email, 'Payment Amount Mismatch', $body);
	die('Payment amount mismatch. Please, contact parademodels@gmail.com');
}

$sign_hash_str = $_POST['ik_shop_id'].':'.
	$_POST['ik_payment_amount'].':'.
	$_POST['ik_payment_id'].':'.
	$_POST['ik_paysystem_alias'].':'.
	$_POST['ik_baggage_fields'].':'.
	$_POST['ik_payment_state'].':'.
	$_POST['ik_trans_id'].':'.
	$_POST['ik_currency_exch'].':'.
	$_POST['ik_fees_payer'].':'.
	$interkassa['secret_key'];
$sign_hash = strtoupper(md5($sign_hash_str));

if ($sign_hash != $_POST['ik_sign_hash']) {
	mail($email, 'payment', 'Hacking Attemp');
	die('You should not be here...');
}

mysql_query("UPDATE payments SET done=1 WHERE transaction_id=$payment_id");

$user = get_record("SELECT * FROM users WHERE id={$payment->user_id} LIMIT 1");

$headers = "Content-type: text/plain; charset=windows-1251\r\n";
$headers .= "From: Hotels-sale.ru <info@hotels-sale.ru>";

if ($user->type == 'agency') {
	$sql = "
		UPDATE users
		SET expiration_date = DATE_ADD(
			if(expiration_date < now(), now(), expiration_date),
				INTERVAL {$payment->period} MONTH)
		WHERE
			id = {$user->id}";

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

die();