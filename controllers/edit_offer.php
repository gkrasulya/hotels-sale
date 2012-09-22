<?
login_required();

$id = $_GET['id'];

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

#echo "<pre>$hotel_countries_sql</pre>";
$hotel_countries = get_records($hotel_countries_sql);
$countries_ = array();
foreach ($hotel_countries as $hc) {
	$countries_ []= $hc->id;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	require_once '_offers_config.php';

	$data = array();
	$errors = array();
	foreach ($_POST as $kw => $val) {
		if (in_array($kw, $fields))
			$data [$kw]= addslashes(htmlspecialchars($val));
	}

	if (trim($data['title']) == '') $errors []= '¬ведите название';
	if (trim($data['price']) == '') $errors []= '¬ведите цену';
	if (trim($data['descr']) == '') $errors []= '¬ведите описание';
	if (trim($data['text']) == '') $errors []= '¬ведите текст';
	// if (trim($data['town']) == '') $errors []= '¬ведите город';
	if (! empty($_FILES['photo']['name']) &&
		! in_array(get_ext($_FILES['photo']['name']), $allowed_exts)) $errors []= 'Ќеверный формат изображени€';

	if (strlen(preg_replace('/\s+/', '', $data['title'])) > 160) $errors []= 'Ќазвание слишком длинное (максимум 160 символов)';
	if (strlen(preg_replace('/\s+/', '', $data['descr'])) > 650) $errors []= 'ќписание слишком длинное (максимум 650 символов)';

	if (isset($_POST['countries']) && is_array($_POST['countries'])) {
		$countries = $_POST['countries'];
	} else {
		$countries = array();
		$errors []= '¬ыберите страны, к которым относитс€ предложение';
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

		$data['price'] = str_replace('И', '&euro;', $data['price']);
		$data['text'] = str_replace('И', '&euro;', $data['text']);
		$data['descr'] = str_replace('И', '&euro;', $data['descr']);

		$data['user_id'] = $user->id;
		// $data['expiration'] = date('Y-m-d H:i:s');
		$data['price_s'] = preg_replace("/[^\d]+/", '', $data['price']);
		// $data['slug'] = create_slug($data['title']);
		$data['tosend'] = 1;
		$data['text_html'] = text2html($data['text']);
		$data['descr_html'] = text2html($data['descr']);
		$data['client_email'] = $user->email;

		$data['price'] = str_replace('И', '&euro;', $data['price']);

		$count_record = get_record("SELECT count(id) as count FROM hotels WHERE user_id='$user->id'");
		// $data['number'] = '10' . rand(10, 99) . '-' . $chars[5];

		$data_sql = array();
		foreach ($data as $kw => $val) {
			$data_sql []= "$kw = '$val'";
		}

		$sql = "UPDATE hotels SET \n";
		$sql .= implode($data_sql, ",\n");
		$sql .= " WHERE user_id=$user->id AND id=$id";

		// print_r($sql);
		// die();

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

			if (! isset($_POST['_continue'])) {
				flash("»зменени€ \"${data[title]}\" сохранены");
				redirect(SITE_ADDR . 'account/');
			}

			$flash = array('»зменени€ сохранены');
		} else {
			$errors []= mysql_error();
		}
	}

	$countries_ = $countries;

}

$all_countries = get_records("SELECT id, title FROM countries");
?>