<?
login_required();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$errors = array();

	$old_password = addslashes($_POST['old_password']);
	$password = addslashes($_POST['password']);
	$password_confirmation = addslashes($_POST['password_confirmation']);

	if ($user->password != md5($old_password)) $errors []= '������������ ������ ������';
	if (strlen(trim($password)) < 6) $errors []= '����� ������ ������� ��������';
	if ($password != $password_confirmation) $errors []= '������ � ������������� ������ �� ���������';

	if (empty($errors)) {
		$password_md5 = md5($password);
		$result = mysql_query("UPDATE users SET password='$password_md5' WHERE id=$user->id");

		if ($result) {
			logout();
			login($user->email, $password);

			flash('������ �������');
			redirect(SITE_ADDR . 'account/');
		}
	}
}