<?

if ($demand != 'send') { ?>

	<h1>������ �� ����� ���������, �����, �������, ������������ �� �������</h1>
	<p>
		���� �� �� ������� ������������ ��� ������� �� ����� ���������, �� � �������� ������� �� ��� ������ � � �������� ���� ����������� ��������� ��� ��� ������ ��� ������.
	</p>
	
	<? require_once('blocks/demand.php');
	
} else {

	$name = trim($_POST['name']);
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

	$errors = array();
	if (! preg_match($email_rex, $email)) $errors []= '�������� ������ email\'a';

	if ($sum != $arr[$capa]) {
		$errors []= '������������ ��� � ��������';	
	}

	if (trim($name) == '') $errors []= '������� ���';
	if (trim($email) == '') $errors []= '������� email';
	if (trim($object) == '') $errors []= '������� ������, ������� ��� ����������';
	if (trim($country) == '') $errors []= '������� ������';

	if (empty($errors)) {
		$not_all_fields = (trim($title) == "" || trim($text) == "" || trim($email) == ""
			|| ! isset($title) || ! isset($text));
		
		if ($not_all_fields) $errors []= '�� ��� ���� ���������';
		
		$ra = mysql_query("SELECT email FROM admin WHERE id='1'",$db);
		$rama = mysql_fetch_array($ra);
		$to = "{$rama[email]}, alupichev@yandex.ru"; //$myrow['email'];
		$subject = "����� ������";
		$body = "����� ������ �� <a href=\"http://hotels-sale.ru\">hotels-sale.ru</a> <br/><br/>
		��: ".$name." <br/>
		Email: ".$email." <br/>
		������: ".$object." <br/>
		������: ".$country." <br/>
		����: �� ".$min_price." �� ".$max_price." ���� <br/>
		".$text." <br/><br/>
		".$date."";

		$to_arr = explode(',', $to);



		foreach ($to_arr as $to) {
			$mail = mail($to,$subject,$body,"Content-type:text/html; Charset=windows-1251 \r\n"."From: ".$email." \r\n");
		}
		$mail = true;
		
	
		if ($mail) { ?>
			<h2>������ ����������!</h2>
			<p>
				<a href='/?main'>��������� �� �������</a>
			</p>
		<? } else { ?>
			<h2>���-�� ����� �� ���!</h2>
			<p>
				<a href='/?main'>��������� �� �������</a>	
			</p>
		<? }
	} else { ?>
		<h4 style='margin-left:50px;'>��������� ��������� ������:</h4>
		<ul class="errors">
			<li><?= implode($errors, "</li>\n<li>") ?></li>
		</ul>
		<p>
			<a href='/?main'>��������� �� �������</a>
			&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
		</p>
<? }
} ?>
