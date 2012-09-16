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
		$flash_message = "� ��� ������������ ������� �� �����. <br />
			����� <strong>{$period[price]} ���.</strong>, � � ��� ����� <strong>$user->amount ���.</strong>";
		$cancels = array($flash_message);
	} else {
		$activate = $acc_hotel->expiration < date('Y-m-d') || ! $acc_hotel->expiration;

		if ($period['period'] == 'infinite') {

			$activate_sql = "
				UPDATE hotels h
				SET h.active=1, h.infinite=1
				WHERE h.id=$id
			";
		} else {
			$from_date =  $activate ?
				'CURRENT_DATE()' : 'h.expiration';

			$activate_sql = "
				UPDATE hotels h
				SET h.active=1, expiration=DATE_ADD($from_date, INTERVAL {$period[period]} MONTH)
				WHERE h.id=$id
			";
		}

		$new_amount = $user->amount - $period['price'];
		$user_sql = "
			UPDATE users
			SET amount=$new_amount
			WHERE id=$user->id
		";

		$payment_date = date('Y-m-d- H:i:s');
		$payment_description = "������ ����������� $acc_hotel->number (\"$acc_hotel->title\") �� $period[period] ���.";
		$payment_sql = "
			INSERT INTO payments (date, summ, done, type, description, user_id, amount_left)
			VALUES ('$payment_date', '$period[price]', 1, 'out', '$payment_description', $user->id, $new_amount)
		";

		if (mysql_query($activate_sql) && mysql_query($user_sql)) {
			mysql_query($payment_sql);
			$activate ?
				flash("����������� \"$acc_hotel->number\" ���� ������������.") :
				flash("����������� \"$acc_hotel->number\" ���� ��������.");
			redirect(SITE_ADDR . 'account/');
		}

		$cancels = array('��������� ������. ���������� ��� ���.');
	}
}