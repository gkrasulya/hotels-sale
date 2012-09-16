<?
login_required();

$id = $_GET['id'];

if (preg_match('/[^\d]+/', $id)) redirect(SITE_ADDR . 'account/');

$sql = "SELECT * FROM hotels WHERE id=$id AND user_id=$user->id";
$acc_hotel = get_record($sql);
if (! $acc_hotel) redirect(SITE_ADDR . 'account/');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$period_id = $_POST['period'];

	if (! in_array($period_id, array_keys($periods)))
		redirect(SITE_ADDR . 'account/');

	$period = $periods[$period_id];

	if ($user->amount < $period['price']) {
		$flash_message = "У вас недостаточно средств на счету. <br />
			Нужно <strong>\${$period[price]}</strong>, а у вас всего <strong>\$$user->amount</strong>";
		$cancels = array($flash_message);
	} else {
		$activate_sql = "
			UPDATE hotels
			SET active=1, expiration=DATE_ADD(CURRENT_DATE(), INTERVAL {$period[period]} MONTH)
			WHERE id=$id
		";

		$new_amount = $user->amount - $period['price'];
		$user_sql = "
			UPDATE users
			SET amount=$new_amount
			WHERE id=$user->id
		";

		if (mysql_query($activate_sql) && mysql_query($user_sql)) {
			flash("Предложение \"$acc_hotel->number\" было активировано.");
			redirect(SITE_ADDR . 'account/');
		}

		$cancels = array('Произошла ошибка. Попробуйте еще раз.');
	}
}