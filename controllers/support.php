<?

login_required();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$errors = array();

	$from = $user->email;

	$subject = $_POST['subject'];
	$message = $_POST['message'];

	if (trim($subject) == '') $errors []= '������� ����';
	if (trim($message) == '') $errors []= '������� ���� ���������';

	if (empty($errors)) {
		$body = "$subject\n\n$message";
		$subject = SITE_ADDR . ' �������� ����� �� ������������';
		$headers = "Content-type: text/plain; charset=windows-1251\r\n";
		$headers .= "From: $from\r\n";

		mail('gkrasulya@gmail.com, alupichev@yandex.ru', $subject, $body, $headers);

		$flash = array('������� �� �������� �����. �� ������� � ��������� �����');
	}
}

?>