<?

if (logged_in()) {
	redirect(SITE_ADDR . 'account/');
}

$email_rex = '/^[-a-z0-9~!$%^&*_=+}{\'?]+(\.[-a-z0-9~!$%^&*_=+}{\'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+)*\.(aero|arpa|biz|com|coop|edu|gov|info|int|mil|museum|name|net|org|pro|travel|mobi|��|[a-z][a-z])|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/i';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$errors = array();

	$email = addslashes($_POST['email']);
	$password = addslashes($_POST['password']);
	$password_md5 = md5($password);

	if (empty($email)) $errors []= '������� email';
	if (! preg_match($email_rex, $email)) $errors []= '�������� ������ email\'a';
	if (empty($password)) $errors []= '������� ������';
	elseif (strlen($password) < 6) $errors []= '������ ������� �������� (������� 6 ��������)';

	$old_user = get_record("SELECT id FROM users WHERE email='$email'");
	if ($old_user) $errors []= '������� � ����� e-mail\'�� ��� ���������������';

	if (empty($errors)) {
		$code = md5($email);

		$sql = "INSERT INTO users (email, password, confirmation_code)
			VALUES ('$email', '$password_md5', '$code')";
		$registration_result = mysql_query($sql);

		if ($registration_result) {
			$flash = array("�������! �� $email ���� ���������� ������. ����� ��������� �����������, �������� �� ������ � ������.<br/><br/>
			���� �� �� �������� ������, ��������� ��� � �����. ��������, ��� ������ ����.<br/><br/>
			���� ������ �� ��������, �������� �� <a href=\"mailto:info@hotels-sale.ru\">info@hotels-sale.ru</a>");

			$headers = "Content-type: text/html; charset=windows-1251\r\n";
			$headers .= "From: Hotels-sale.ru <info@hotels-sale.ru>";

			$subject = "����������, ����������� �����������";
			$body = "������������.<br/><br/>
			�� ������������������ �� ����� <a href=\"" . SITE_ADDR . "\">Hotels-sale.ru</a>.<br/><br/>
			��� �����: $email<br/>
			������: $password<br/><br/>
			����� ����������� �����������, �������� <a href=\"" . SITE_ADDR . "confirm?code=$code\">�� ������</a>. �������!";

			mail($email, $subject, $body, $headers);
			mail('alupichev@yandex.ru', '����� �����������', 'Email ������ ������������: ' . $email, $headers);
		}
	}
}