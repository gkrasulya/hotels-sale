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
		if (in_array($kw, $fields)) {
			$data [$kw]= addslashes(htmlspecialchars($val));
		}
	}

	# validating
	if (trim($data['title']) == '') $errors []= 'Введите название';
	if (trim($data['price']) == '') $errors []= 'Введите цену';
	if (trim($data['descr']) == '') $errors []= 'Введите описание';
	if (trim($data['text']) == '') $errors []= 'Введите текст';
	// if (trim($data['town']) == '') $errors []= 'Введите город';
	if (empty($_FILES['photo']['name'])) $errors []= 'Загрузите изображение';
	elseif (! in_array(get_ext($_FILES['photo']['name']), $allowed_exts)) $errors []= 'Неверный формат изображения';

	if (strlen(preg_replace('/\s+/', '', $data['title'])) > 160) $errors []= 'Название слишком длинное (максимум 160 символов)';
	if (strlen(preg_replace('/\s+/', '', $data['descr'])) > 650) $errors []= 'Описание слишком длинное (максимум 650 символов)';

	if (isset($_POST['countries']) && is_array($_POST['countries'])) {
		$countries = $_POST['countries'];
	} else {
		$countries = array();
		$errors []= 'Выберите страны, к которым относится предложение';
	}

	if (empty($errors)) {

		$data['price'] = str_replace('€', '&euro;', $data['price']);
		$data['text'] = str_replace('€', '&euro;', $data['text']);
		$data['descr'] = str_replace('€', '&euro;', $data['descr']);

		# data for offer
		$data['user_id'] = $user->id;
		$data['price_s'] = preg_replace("/[^\d]+/", '', $data['price']);
		$data['slug'] = create_slug($data['title']);
		$data['tosend'] = 1;
		$data['forward'] = $user->type == 'user' ? 1 : 0; // i think paid offers should go forward
		$data['text_html'] = text2html($data['text']);
		$data['descr_html'] = text2html($data['descr']);

		# generating number for offer
		$chars = range('a', 'z'); # range of latin letter for number
		$data['number'] = '10' . rand(10, 99) . '-' . $chars[rand(0, count($chars)-1)];
		$data['date_added'] = date('Y-m-d H:i:s');
		$data['client_email'] = $user->email;

		if (is_agency() && $user->active) {
			$data['active'] = 1;
		}

		$data['type'] = is_agency() ? 'agency' : 'user';

		# photo
		$filename = copy_file($_FILES['photo']); # saving photo file
		mysql_query("INSERT INTO fotos (img_big) VALUES ('$filename')"); # creating db record of photo
		$data['foto'] = mysql_insert_id(); # adding id of photo to offer data

		# creating offer sql
		$sql = "INSERT INTO hotels\n";
		$sql .= " (\n\t" . implode(array_keys($data), ",\n\t") . "\n)\n";
		$sql .= " VALUES (\n\t'" . implode(array_values($data), "',\n\t'") . "'\n)";

		// print_r($sql);
		// die();

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

			$headers = "Content-type: text/html; charset=windows-1251\r\n";
			$headers .= "From: Hotels-sale.ru <info@hotels-sale.ru>";

			$body = "Пользователь $user->email добавил новое предложение <a href=\"http://hotels-sale.ru/?h=$offer_id\">\"$data[title]\"</a>";

			mail('alupichev@yandex.ru', 'Добавлено предложение', $body, $headers);
		}
	}

	$countries_ = $countries;

}

$all_countries = get_records("
	SELECT id, title
	FROM countries
	WHERE id NOT IN (48, 50, 52)
");
?>