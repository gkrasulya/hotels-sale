<?

if (logged_in()) {
	redirect(SITE_ADDR . 'account/');
}

$email_rex = '/^[-a-z0-9~!$%^&*_=+}{\'?]+(\.[-a-z0-9~!$%^&*_=+}{\'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+)*\.(aero|arpa|biz|com|coop|edu|gov|info|int|mil|museum|name|net|org|pro|travel|mobi|рф|[a-z][a-z])|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/i';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$errors = array();

	$email = addslashes($_POST['email']);
	$password = addslashes($_POST['password']);
	$password_md5 = md5($password);

	if (empty($email)) $errors []= 'Введите email';
	if (! preg_match($email_rex, $email)) $errors []= 'Неверный формат email\'a';
	if (empty($password)) $errors []= 'Введите пароль';
	elseif (strlen($password) < 6) $errors []= 'Пароль слишком короткий (минимум 6 символов)';

	$old_user = get_record("SELECT id FROM users WHERE email='$email'");
	if ($old_user) $errors []= 'Аккаунт с таким e-mail\'ом уже зарегистрирован';

	if (empty($errors)) {
		$code = md5($email);

		$sql = "INSERT INTO users (email, password, confirmation_code)
			VALUES ('$email', '$password_md5', '$code')";
		$registration_result = mysql_query($sql);

		if ($registration_result) {
			$flash = array("Спасибо! На $email было отправлено письмо. Чтобы закончить регистрацию, пройдите по ссылке в письме.<br/><br/>
			Если вы не получили письмо, проверьте его в спаме. Возможно, оно попало туда.<br/><br/>
			Если письмо не приходит, напишите на <a href=\"mailto:info@hotels-sale.ru\">info@hotels-sale.ru</a>");

			$headers = "Content-type: text/html; charset=windows-1251\r\n";
			$headers .= "From: Hotels-sale.ru <info@hotels-sale.ru>";

			$subject = "Пожалуйста, подтвердите регистрацию";
			$body = "Здравствуйте.<br/><br/>
			Вы зарегистрировались на сайте <a href=\"" . SITE_ADDR . "\">Hotels-sale.ru</a>.<br/><br/>
			Ваш логин: $email<br/>
			Пароль: $password<br/><br/>
			Чтобы подтвердить регистрацию, пройдите <a href=\"" . SITE_ADDR . "confirm?code=$code\">по ссылке</a>. Спасибо!";

			mail($email, $subject, $body, $headers);
			mail('alupichev@yandex.ru', 'Новая регистрация', 'Email нового пользователя: ' . $email, $headers);
		}
	}
}