<?
if ($form == 'new') {
	require_once "blocks/form.php";
}
	
if ($form == 'send') {
	$result = mysql_query("SELECT email FROM admin",$db);
	$myrow = mysql_fetch_array($result);
	
	$title = $_POST['title'];
	$name = $_POST['name'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$info = $_POST['info'];
	$date = date("Y-m-d H:i");
	$number = $_POST['number'];
	$sum = $_POST['sum'];
	$capa = $_POST['capa'];
	$arr = array(
		'G9W911',
		'Y14DHF',
		'1387GH',
		'HS199H',
		'KJD148'
	);
	
	$result_villa = mysql_query('SELECT * FROM hotels WHERE number="' . $number . '"');
	$villa = mysql_fetch_array($result_villa);

	$errors = array();

	$email_rex = '/^[-a-z0-9~!$%^&*_=+}{\'?]+(\.[-a-z0-9~!$%^&*_=+}{\'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+)*\.(aero|arpa|biz|com|coop|edu|gov|info|int|mil|museum|name|net|org|pro|travel|mobi|��|[a-z][a-z])|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/i';
	
	if (trim(strtoupper($sum)) != $arr[$capa]) $errors []= '������������ ��� � ��������';
	if (trim($title) == "" || trim($name) == "" || trim($email) == "") $errors []= '�� ��� ���� ���������';
	if (! preg_match($email_rex, $email)) $errors []= '�������� ������ email\'a';
	if (trim($phone) == '') $errors []= '������� �������';
	
	if (empty($errors)) {
	
		$to = "{$myrow[email]},no-thx@mail.ru,alupichev@yandex.ru";
		$subject = "����� ������ �� hotels-sale.ru";
		$body = "����� ������ \n\n
			��: ".$name." \n
			Email: ".$email." \n
			�������: ".$phone." \n
			��������: ".$title." \n
			�����: ".$number." \n
			".$info." \n\n
			".$date."";
		
		$mail = mail($to,$subject,$body,"Content-type:text/plain; Charset=windows-1251 \r\n"."From: ".$email." \r\n");
		mail($villa['client_email'], $subject, $body, "Content-type:text/plain; Charset=windows-1251 \r\n"."From: ".$email." \r\n");
		
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
			<a href='<?= SITE_ADDR ?>/?main'>��������� �� �������</a> ��� 
			<a href='<?= SITE_ADDR ?>/?form=new&amp;number=<?=$number?>'>�� �������� ������</a>
		</p>

		<p>
			&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
		</p>
<? }
} ?>