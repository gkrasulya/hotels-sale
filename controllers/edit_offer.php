<?
login_required();

$id = $offer_id = $_GET['id'];

if (preg_match('/[^\d]+/', $id)) redirect(SITE_ADDR . 'account/');

$sql = "SELECT * FROM hotels WHERE id=$id AND user_id=$user->id";
$acc_hotel = get_record($sql);
if (! $acc_hotel) redirect(SITE_ADDR . 'account/');
$data = $acc_hotel->get_array();

$hotel_countries_sql = "
	SELECT c.*
	FROM countries c, hotels_countries hc
	WHERE hc.country_id = c.id AND hc.hotel_id = $id
";

$hotel_countries = get_records($hotel_countries_sql);
$countries_ = array();
foreach ($hotel_countries as $hc) {
	$countries_ []= $hc->id;
}


$hotel_regions_sql = "
	SELECT c.*
	FROM regions c, hotels_regions hc
	WHERE hc.region_id = c.id AND hc.hotel_id = $id
";

$hotel_regions = get_records($hotel_regions_sql);
$regions_ = array();
foreach ($hotel_regions as $hc) {
	$regions_ []= $hc->id;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	require_once '_offers_config.php';

	$data = array();
	$errors = array();
	foreach ($_POST as $kw => $val) {
		if (in_array($kw, $fields))
			$data [$kw]= addslashes(htmlspecialchars($val));
	}

	if (trim($data['title']) == '') $errors []= 'Введите название';
	if (trim($data['price']) == '') $errors []= 'Введите цену';
	if (trim($data['descr']) == '') $errors []= 'Введите описание';
	if (trim($data['text']) == '') $errors []= 'Введите текст';
	if (trim($data['town']) == '') $errors []= 'Введите город';
	if (! empty($_FILES['photo']['name']) &&
		! in_array(get_ext($_FILES['photo']['name']), $allowed_exts)) $errors []= 'Неверный формат изображения';

	if (isset($_POST['countries']) && is_array($_POST['countries'])) {
		$countries = $_POST['countries'];
	} else {
		$countries = array();
		$errors []= 'Выберите страны, к которым относится предложение';
	}

	if (empty($errors)) {
		# photo
		if (! empty($_FILES['photo']['name'])) {
			$photo_sql = "SELECT * FROM fotos WHERE id=$acc_hotel->foto";
			$photo = get_record($photo_sql);
			@unlink("fotos/$photo->img_big");

			$filename = copy_file($_FILES['photo']); # saving photo file
			mysql_query("UPDATE fotos SET img_big='$filename' WHERE id=$acc_hotel->foto"); # updating db record of photo	
		}

		$chars = range('a', 'z');

		$data['user_id'] = $user->id;
		$data['expiration'] = date('Y-m-d H:i:s');
		$data['price_s'] = preg_replace("/[^\d]+/", '', $data['price']);
		$data['slug'] = create_slug($data['title']);
		$data['tosend'] = 1;
		$data['forward'] = 1; // i think paid offers should go forward
		$data['text_html'] = text2html($data['text']);
		$data['descr_html'] = text2html($data['descr']);

		$count_record = get_record("SELECT count(id) as count FROM hotels WHERE user_id='$user->id'");
		$data['number'] = '10' . rand(10, 99) . '-' . $chars[5];

		$data_sql = array();
		foreach ($data as $kw => $val) {
			$data_sql []= "$kw = '$val'";
		}

		$sql = "UPDATE hotels SET \n";
		$sql .= implode($data_sql, ",\n");
		$sql .= " WHERE user_id=$user->id AND id=$id";

		if (mysql_query($sql)) {
			# deleting all offer-country relations 
			mysql_query("DELETE * FROM hotels_countries WHERE hotel_id=$id");

			# sql array for offer-country relations
			$sql_c_array = array();
			foreach ($_POST['countries'] as $c_id) {
				$sql_c_array []= "($offer_id, $c_id)";
			}

			$sql_c = "INSERT INTO hotels_countries (hotel_id, country_id)\n";
			$sql_c .= " VALUES " . implode($sql_c_array, ",\n");

			# creating offer-country relations
			mysql_query($sql_c);

			# deleting all offer-country relations 
			mysql_query("DELETE * FROM hotels_regions WHERE hotel_id=$id");

			# sql array for offer-country relations
			if (isset($_POST['regions'])) {
				$sql_r_array = array();
				foreach ($_POST['regions'] as $r_id) {
					$sql_r_array []= "($offer_id, $r_id)";
				}

				$sql_r = "INSERT INTO hotels_regions (hotel_id, region_id)\n";
				$sql_r .= " VALUES " . implode($sql_r_array, ",\n");

				# creating offer-country relations
				mysql_query($sql_r);
			}

			if (! isset($_POST['_continue'])) {
				flash("Изменения \"${data['title']}\" сохранены");
				redirect(SITE_ADDR . 'account/');
			}

			$flash = array('Изменения сохранены');
			
			$email_body = "Пользователь: {$user->email} отредактировал продложение (ID: {$offer_id})";
			mail('alupichev@yandex.ru', 'Изменение предложения пользователя', $email_body,
				"Content-type:text/plain; Charset=windows-1251 \r\nFrom: {$email}\r\n");
		}
	}

	$countries_ = $countries;

}

$all_countries = get_records("SELECT id, title FROM countries WHERE id NOT IN (50, 48, 59)");
?>