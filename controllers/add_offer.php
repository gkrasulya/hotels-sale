<?
login_required();

$new_offer = true; # for form template

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	require_once '_offers_config.php'; # file with offer properties, which we'll take from $_POST

	# empty arrays for offer data and errors
	$errors = array();
	$data = array();

	# filling $data with $_POST kw/vals
	foreach ($_POST as $kw => $val) {
		if (in_array($kw, $fields))
			$data [$kw]= addslashes(htmlspecialchars($val));
	}

	# validating
	if (trim($data['title']) == '') $errors []= 'Введите название';
	if (trim($data['price']) == '') $errors []= 'Введите цену';
	if (trim($data['descr']) == '') $errors []= 'Введите описание';
	if (trim($data['text']) == '') $errors []= 'Введите текст';
	if (trim($data['town']) == '') $errors []= 'Введите город';
	if (empty($_FILES['photo']['name'])) $errors []= 'Загрузите изображение';
	elseif (! in_array(get_ext($_FILES['photo']['name']), $allowed_exts)) $errors []= 'Неверный формат изображения';

	if (isset($_POST['countries']) && is_array($_POST['countries'])) {
		$countries = $_POST['countries'];
	} else {
		$countries = array();
		$errors []= 'Выберите страны, к которым относится предложение';
	}

	if (empty($errors)) {

		# data for offer
		$data['user_id'] = $user->id;
		$data['price_s'] = preg_replace("/[^\d]+/", '', $data['price']);
		$data['slug'] = create_slug($data['title']);
		$data['tosend'] = 1;
		$data['forward'] = 1; // i think paid offers should go forward
		$data['text_html'] = text2html($data['text']);
		$data['descr_html'] = text2html($data['descr']);

		# generating number for offer
		$chars = range('a', 'z'); # range of latin letter for number
		$data['number'] = '10' . rand(10, 99) . '-' . $chars[rand(0, count($chars)-1)];

		# photo
		$filename = copy_file($_FILES['photo']); # saving photo file
		mysql_query("INSERT INTO fotos (img_big) VALUES ('$filename')"); # creating db record of photo
		$data['foto'] = mysql_insert_id(); # adding id of photo to offer data

		# creating offer sql
		$sql = "INSERT INTO hotels\n";
		$sql .= " (\n\t" . implode(array_keys($data), ",\n\t") . "\n)\n";
		$sql .= " VALUES (\n\t'" . implode(array_values($data), "',\n\t'") . "'\n)";

		if (mysql_query($sql)) {
			$offer_id = mysql_insert_id(); # for creating offer-country relations

			$sql_c_array = array();
			foreach ($_POST['countries'] as $c_id) {
				$sql_c_array []= "($offer_id, $c_id)";
			}

			$sql_c = "INSERT INTO hotels_countries (hotel_id, country_id)\n";
			$sql_c .= " VALUES " . implode($sql_c_array, ",\n");

			mysql_query($sql_c);

			if (! isset($_POST['_more'])) {
				flash("Предложение \"${data[title]}\" создано");
				redirect(SITE_ADDR . 'account/');
			}

			$flash = array('Предложение создано');
		}
	}

	$countries_ = $countries;

}

$all_countries = get_records("SELECT id, title FROM countries");
?>