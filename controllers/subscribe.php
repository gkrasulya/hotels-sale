<?

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (isset($_POST['email'])) { $to = addslashes(trim($_POST['email'])); }
	if (isset($_POST['name'])) { $name = addslashes(trim($_POST['name'])); }

	$email_rex = '/^[-a-z0-9~!$%^&*_=+}{\'?]+(\.[-a-z0-9~!$%^&*_=+}{\'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+)*\.(aero|arpa|biz|com|coop|edu|gov|info|int|mil|museum|name|net|org|pro|travel|mobi|рф|[a-z][a-z])|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/i';

	$errors = array();

	if ($name == '') $errors []= 'Введите ваше имя';
	if ($to == '') $errors []= 'Введите email';
	elseif (! preg_match($email_rex, $to)) $errors []= 'Неверный формат email\'a';

	$result = false;
	if (empty($errors)) {
		$sql = "INSERT INTO emailers (email, name) VALUES ('$to','$name')";
		$result = mysql_query($sql);
	}
}