<?

if ($demand == 'send') {

	$name = trim($_POST['name']);
	$phone = trim($_POST['phone']);
	$email = trim($_POST['email']);
	$object = trim($_POST['object']);
	$country = trim($_POST['country']);
	$min_price = $_POST['min_price'];
	$max_price = $_POST['max_price'];
	$text = trim($_POST['text']);
	$capa = $_POST['capa'];
	$sum = $_POST['sum'];
	$date = date("Y-m-d H:i");
	$arr = array('7','10','15','9','8');

	$email_rex = '/^[-a-z0-9~!$%^&*_=+}{\'?]+(\.[-a-z0-9~!$%^&*_=+}{\'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+)*\.(aero|arpa|biz|com|coop|edu|gov|info|int|mil|museum|name|net|org|pro|travel|mobi|��|[a-z][a-z])|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/i';

	$error = array();
	if (! preg_match($email_rex, $email)) $errors []= '�������� ������ email\'a';

	if ($sum != $arr[$capa]) {
		$error []= '������������ ��� � ��������';	
	}

	if (! trim($phone)) {
		$error []= '����� ��������� �������';
	}

	if (empty($error)) {
		$not_all_fields = (trim($title) == "" || trim($text) == "" || trim($email) == ""
			|| ! isset($title) || ! isset($text) || ! isset($phone));
		
		if ($not_all_fields) $error []= '�� ��� ���� ���������';
	}

	if (empty($error)) {		
		$ra = mysql_query("SELECT email FROM admin WHERE id='1'",$db);
		$rama = mysql_fetch_array($ra);
		$to = "{$rama[email]}, alupichev@yandex.ru"; //$myrow['email'];
		$subject = "����� ������";
		$body = "����� ������ \n\n
		��: ".$name." \n
		Email: ".$email." \n
		�������: ".$phone." \n
		������: ".$object." \n
		������: ".$country." \n
		����: �� ".$min_price." �� ".$max_price." ���� \n
		".$text." \n\n
		".$date."";

		$mail = mail($to,$subject,$body,"Content-type:text/plain; Charset=windows-1251 \r\n"."From: ".$email." \r\n");
	}
}