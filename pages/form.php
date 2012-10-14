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

	$email_rex = '/^[-a-z0-9~!$%^&*_=+}{\'?]+(\.[-a-z0-9~!$%^&*_=+}{\'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+)*\.(aero|arpa|biz|com|coop|edu|gov|info|int|mil|museum|name|net|org|pro|travel|mobi|рф|[a-z][a-z])|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/i';
	
	if (trim(strtoupper($sum)) != $arr[$capa]) $errors []= 'Неправильный код с картинки';
	if (trim($title) == "" || trim($name) == "" || trim($email) == "") $errors []= 'Не все поля заполнены';
	if (! preg_match($email_rex, $email)) $errors []= 'Неверный формат email\'a';
	if (trim($phone) == '') $errors []= 'Введите телефон';
	
	if (empty($errors)) {
	
		$to = "{$myrow[email]},no-thx@mail.ru,alupichev@yandex.ru";
		$subject = "Новая заявка от hotels-sale.ru";
		$body = "Новая заявка \n\n
			От: ".$name." \n
			Email: ".$email." \n
			Телефон: ".$phone." \n
			Название: ".$title." \n
			Номер: ".$number." \n
			".$info." \n\n
			".$date."";
		
		$mail = mail($to,$subject,$body,"Content-type:text/plain; Charset=windows-1251 \r\n"."From: ".$email." \r\n");
		mail($villa['client_email'], $subject, $body, "Content-type:text/plain; Charset=windows-1251 \r\n"."From: ".$email." \r\n");
		
		if ($mail) { ?>
			<h2>Письмо отправлено!</h2>
			<p>
				<a href='/?main'>Вернуться на главную</a>
			</p>
		<? } else { ?>
			<h2>Что-то пошло не так!</h2>
			<p>
				<a href='/?main'>Вернуться на главную</a>	
			</p>
		<? }
		
	} else { ?>
		<h4 style='margin-left:50px;'>Исправьте следующие ошибки:</h4>
		<ul class="errors">
			<li><?= implode($errors, "</li>\n<li>") ?></li>
		</ul>
		<p>
			<a href='<?= SITE_ADDR ?>/?main'>Вернуться на главную</a> или 
			<a href='<?= SITE_ADDR ?>/?form=new&amp;number=<?=$number?>'>на страницу заказа</a>
		</p>

		<p>
			&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
		</p>
<? }
} ?>