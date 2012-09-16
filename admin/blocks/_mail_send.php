<?

$test = isset($_GET['test']) ? '1' : '0';
$change_token = $_GET['change_token'];

$delivery = get_record("SELECT id from deliveries WHERE change_token = '$change_token'");
$object_tosend = get_record("SELECT id FROM hotels WHERE tosend = 1 LIMIT 1");

if ($delivery) {
	$message = 'Очередь на эту рассылку уже создана';
} elseif (! $object_tosend) {
	$message = 'Нет объектов для отправки';
} else {

	$objects = get_records("SELECT id FROM hotels WHERE tosend = 1");

	$object_ids = array();
	foreach ($objects as $obj) {
		$object_ids []= $obj->id;
	}
	$object_ids = implode(',', $object_ids);

	if (! $test) {
		mysql_query("UPDATE hotels SET tosend = 0 WHERE id IN ($object_ids)");
	}

	$date_added = date('Y-m-d H:i:s');

	$sql = "
		INSERT INTO deliveries
			(object_ids, test, change_token, date_added)
			VALUES ('$object_ids', $test, '$change_token', '$date_added')
	";

	$result = mysql_query($sql);

	$message = $result ? 'Создана очередь на отправку' : 'Произошла ошибка';
}

?>

<h2><?= $message ?></h2>

