<?


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (isset($_POST['s'])) {
		list($email, $password) = explode('|', $_POST['s']);
		$user = login($email, $password);
		if (! $user || ! $_FILES['photo']) die('error');

		$id = $_POST['id'];
		if (preg_match('/[^\d]+/', $id)) die('error');

		$sql = "SELECT * FROM hotels WHERE id=$id AND user_id=$user->id";
		$acc_hotel = get_record($sql);
		if (! $acc_hotel) die('error');
		

		$filename = copy_file($_FILES['photo'], 'add_fotos/');
		$add_photo_sql = "INSERT INTO add_fotos (big, hotel_id) VALUES ('$filename', $acc_hotel->id)";
		if (! mysql_query($add_photo_sql)) {
			@unlink("add_fotos/$filename");
			die('error');
		}
		$add_photo_id = mysql_insert_id();
		die("$filename|$add_photo_id");
	} else {
		die('error');
	}
	
} else {
	login_required();

	$id = $_GET['id'];
	if (preg_match('/[^\d]+/', $id)) redirect(SITE_ADDR . 'account/');

	$sql = "SELECT * FROM hotels WHERE id=$id AND user_id=$user->id";
	$acc_hotel = get_record($sql);
	if (! $acc_hotel) redirect(SITE_ADDR . 'account/');

	$photos = get_records("SELECT * FROM add_fotos WHERE hotel_id=$acc_hotel->id");	
}
