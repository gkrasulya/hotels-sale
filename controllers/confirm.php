<?

if (! isset($_GET['code'])) redirect(SITE_ADDR);

$code = addslashes($_GET['code']);

$user = get_record("SELECT * FROM users WHERE confirmation_code='$code'");
if (! $user) redirect(SITE_ADDR);

mysql_query("UPDATE users SET active=1, confirmation_code='' WHERE id=$user->id");

$flash = array('����������� ���������! ������ �� ������ ��������� ������ ������������� ����� <a href="' . SITE_ADDR . 'account/">� ������ ��������.</a>');