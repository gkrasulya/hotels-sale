<?

if ($demand != 'send') { ?>

	<h1>Заявка на поиск гостиницы, отеля, бизнеса, недвижимости за рубежом</h1>
	<p>
		Если Вы не найдете необходимого Вам объекта по Вашим критериям, мы с радостью получим от Вас запрос и в короткий срок постараемся подобрать для Вас нужный Вам объект.
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

	$email_rex = '/^[-a-z0-9~!$%^&*_=+}{\'?]+(\.[-a-z0-9~!$%^&*_=+}{\'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+)*\.(aero|arpa|biz|com|coop|edu|gov|info|int|mil|museum|name|net|org|pro|travel|mobi|рф|[a-z][a-z])|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/i';

	$errors = array();
	if (! preg_match($email_rex, $email)) $errors []= 'Неверный формат email\'a';

	if ($sum != $arr[$capa]) {
		$errors []= 'Неправильный код с картинки';	
	}

	if (trim($name) == '') $errors []= 'Введите имя';
	if (trim($email) == '') $errors []= 'Введите email';
	if (trim($object) == '') $errors []= 'Введите объект, которые вас интересует';
	if (trim($country) == '') $errors []= 'Введите страну';

	if (empty($errors)) {
		$not_all_fields = (trim($title) == "" || trim($text) == "" || trim($email) == ""
			|| ! isset($title) || ! isset($text));
		
		if ($not_all_fields) $errors []= 'Не все поля заполнены';
		
		$ra = mysql_query("SELECT email FROM admin WHERE id='1'",$db);
		$rama = mysql_fetch_array($ra);
		$to = "{$rama[email]}, alupichev@yandex.ru"; //$myrow['email'];
		$subject = "Новая заявка";
		$body = "Новая заявка от <a href=\"http://hotels-sale.ru\">hotels-sale.ru</a> <br/><br/>
		От: ".$name." <br/>
		Email: ".$email." <br/>
		Объект: ".$object." <br/>
		Страна: ".$country." <br/>
		Цена: от ".$min_price." до ".$max_price." евро <br/>
		".$text." <br/><br/>
		".$date."";

		$to_arr = explode(',', $to);



		foreach ($to_arr as $to) {
			$mail = mail($to,$subject,$body,"Content-type:text/html; Charset=windows-1251 \r\n"."From: ".$email." \r\n");
		}
		$mail = true;
		
	
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
			<a href='/?main'>Вернуться на главную</a>
			&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
		</p>
<? }
} ?>
