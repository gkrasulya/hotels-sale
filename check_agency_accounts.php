<?

require_once 'blocks/db.php';
require_once 'blocks/functions.php';

$users = get_records("
	SELECT *
	FROM users
	WHERE
		type='agency'
		AND expiration_date < DATE_ADD(NOW(), INTERVAL 5 DAY)");

$expired_account_ids = array();
foreach ($users as $user) {
	$expired_account_ids []= $user->id;

	$day_in_seconds = 60 * 60 * 24;
	$expires_time = strtotime($user->expiration_date);
	$today_time = strtotime(date('Y-m-d'));

	$days_to_expiration = floor(($expires_time - $today_time) / $day_in_seconds);

	$headers = "Content-type: text/html; charset=windows-1251\r\n";
	$headers .= "From: Hotels-sale.ru <info@hotels-sale.ru>";

	if ($days_to_expiration == 5) {
		$user_body = 'Здравствуйте. Ваш аккаунт истекает через 5 дней. Для продления необходимо произвести оплату в "<a href="http://hotels-sale.ru/account">личном кабинете</a>"';
		$admin_body = 'Через 5 дней истекает аккаунт пользователя ' . $user->email;

		mail($user->email, 'Hotels-sale.ru: ваш аккаунт истекает', $user_body, $headers);
		mail('alupichev@yandex.ru', 'Hotels-sale.ru: истекает аккаунт пользователя', $admin_body, $headers);
	} elseif ($days_to_expiration == 0) {
		$user_body = 'Здравствуйте. Ваш аккаунт истекает сегодня. Для продления необходимо произвести оплату в "<a href="http://hotels-sale.ru/account">личном кабинете</a>"';
		$admin_body = 'Сегодня истекает аккаунт пользователя ' . $user->email;

		mail($user->email, 'Hotels-sale.ru: ваш аккаунт истекает', $user_body, $headers);
		mail('alupichev@yandex.ru', 'Hotels-sale.ru: истекает аккаунт пользователя', $admin_body, $headers);
	} elseif ($days_to_expiration < 0) {
		// mysql_query("UPDATE users SET active = 0 WHERE id = $user->id");
		mysql_query("UPDATE hotels SET active = 0 WHERE user_id = $user->id");
	}
}

$expired_users = get_records("
	SELECT *
	FROM users
	WHERE
		type='agency'
		AND expiration_date < NOW()");

$expired_account_ids = array();
foreach ($expired_users as $user) {
	$expired_account_ids []= $user->id;
}
$expired_account_ids_string = implode($expired_account_ids, ',');

$offer_sql = "
	UPDATE hotels
	SET active = 0
	WHERE user_id IN ($expired_account_ids_string)
";
mysql_query($offer_sql);
die(mysql_error());

?>