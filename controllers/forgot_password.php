<?

if (logged_in()) {
	redirect(SITE_ADDR . 'account/');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$user = login(addslashes($_POST['email']), md5(addslashes($_POST['password'])));

	$email = addslashes($_POST['email']);
	$user_by_email = get_record("SELECT * FROM users WHERE email = '$email'");

	if ($user_by_email) {
		$flash = array('На адрес ' . $email . ' отправлен новый пароль');
		$password = generate_password(8);
		$password_md5 = md5($password);
		mysql_query("UPDATE users SET password='$password_md5' WHERE id = $user_by_email->id");

		$headers = "Content-type: text/html; charset=windows-1251\r\n";
		$headers .= "From: Hotels-sale.ru <info@hotels-sale.ru>";
		$body = "Здравстсвуйте. Ваш новый пароль: $password.\n\nПоменять его вы можете в личном кабинете.";
		mail($email, 'Восстановление пароля', $body, $headers);
	} else {
		$errors = array('Пользователя с таким email нет');
	}
}