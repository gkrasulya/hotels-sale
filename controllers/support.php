<?

login_required();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$errors = array();

	$from = $user->email;

	$subject = $_POST['subject'];
	$message = $_POST['message'];

	if (trim($subject) == '') $errors []= 'Введите тему';
	if (trim($message) == '') $errors []= 'Введите ваше сообщение';

	if (empty($errors)) {
		$body = "$subject\n\n$message";
		$subject = SITE_ADDR . ' Обратная связь от пользователя';
		$headers = "Content-type: text/plain; charset=windows-1251\r\n";
		$headers .= "From: $from\r\n";

		mail('gkrasulya@gmail.com, alupichev@yandex.ru', $subject, $body, $headers);

		$flash = array('Спасибо за обратную связь. Мы ответим в ближайшее время');
	}
}

?>