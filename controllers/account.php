<?
login_required();

if (isset($_GET['order'])) {
	$o = $_GET['order'];

	switch ($o) {
		case 'title':
			$order = 'ORDER BY title';
			break;
		case 'number':
			$order = 'ORDER BY number';
			break;
		case 'price':
			$order = 'ORDER BY price_s DESC';
			break;
		case 'status':
			$order = 'ORDER BY active DESC';
			break;
		case 'expiration':
			$order = 'ORDER BY expiration DESC';
			break;
	}
} else {
	$o = 'title';
	$order = 'ORDER BY title';
}

$acc_hotels = get_records("SELECT * FROM hotels WHERE user_id=$user->id $order");

if (is_agency()) {
	$payments = get_records("SELECT * FROM payments WHERE user_id=$user->id AND done=1 ORDER BY `date` DESC");
}