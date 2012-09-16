<?

if (logged_in()) {
	redirect(SITE_ADDR . 'account/');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$users = get_records("SELECT * FROM users");

	$user = login(addslashes($_POST['email']), md5(addslashes($_POST['password'])));

	if ($user) {
		if ($_POST['remember_me']) {
			setcookie('email', addslashes($_POST['email']), (time() + 86400 * 7), '/');
			setcookie('password', md5(addslashes($_POST['password'])), time() + 86400 * 7, '/');
			setcookie('TEST', 'TEST', (time() + 86400 * 7), '/');
		} else {
			unset($_COOKIE['email']);
			unset($_COOKIE['password']);
		}
		redirect(SITE_ADDR . 'account/');
	} else {
		$errors = array('Неправильная комбинация email и пароля');
	}
}