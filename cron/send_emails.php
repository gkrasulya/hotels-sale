<?
error_reporting(E_ALL);

require_once("../blocks/db.php");
require_once("../blocks/variables.php");
require_once("../blocks/functions.php");
header('Content-Type: text/plain');

$delivery = get_record("SELECT * FROM deliveries WHERE done = 0 LIMIT 1");

if (! $delivery) {
	echo "All deliveries are done\n";
	die();
}

$sql = "
	SELECT
		h.*,
		f.img_pre as img_pre,
		f.img_big as img
	FROM
		hotels as h,
		fotos as f
	WHERE
		h.foto = f.id AND
		h.id IN ($delivery->object_ids)";

$hotels = get_records($sql);
$new = "";

foreach ($hotels as $hotel) {
	$new .= "\n
	<table width='70%'>
		<tr>
			<td width='100px' style='width: 100px'>
				<a href='http://hotels-sale.ru/?h={$hotel->id}'>
					<img width='100px' style='width: 100px;' src='" . SITE_ADDR . "image.php?image=" . SITE_ADDR. "fotos/{$hotel->img}&width=100' alt='' />
				</a>
			</td>
			<td width='20px' style='width: 20px'>&nbsp;</td>
			<td valign='top'>
				<a href='http://hotels-sale.ru/?h={$hotel->id}'>{$hotel->title}</a>
				<p style='font-style: italic;'>цена: {$hotel->price}</p>";

	if ($hotel->rooms) {
		$new .= "<p style='font-style: italic;'>
			номеров: {$hotel->rooms}</p>";
	}
	
	$new .= "
			</td>
		</tr>
		<tr>
			<td colspan='3'><br/>
				<p>{$hotel->descr}</p>
				<p style='text-align: right'>
					<a href='http://hotels-sale.ru/?h={$hotel->id}'>Подробнее</a>
				</p>
			</td>
		</tr>
	</table><br/><br/>";
}

$addressees = array();

if ($delivery->test) {
	echo "Testing mode...\n";
	$deliveries_emailers = array();
	$deliveries_emailers_res = mysql_query("SELECT * FROM deliveries_emailers
		WHERE delivery_id = $delivery->id");
	while ($de = mysql_fetch_array($deliveries_emailers_res)) {
		$deliveries_emailers []= $de['emailer_id'];
	}
	$deliveries_emailers = implode(',', $deliveries_emailers);
	$emailers = get_records("SELECT * FROM emailers
		WHERE test = 1 AND NOT EXISTS (SELECT * FROM deliveries_emailers
			WHERE delivery_id = $delivery->id AND emailer_id = emailers.id)");

	if (! $emailers) {
		echo "No emailers => all emails were sent\n";
		echo "Updating delivery. Done => true";
		mysql_query("UPDATE deliveries SET done = 1 WHERE id = $delivery->id");
		die();
	}
} else {
	echo "Real mode...\n";
	$deliveries_emailers = array();
	$deliveries_emailers_res = mysql_query("SELECT * FROM deliveries_emailers
		WHERE delivery_id = $delivery->id");
	while ($de = mysql_fetch_array($deliveries_emailers_res)) {
		$deliveries_emailers []= $de['emailer_id'];
	}
	$deliveries_emailers = implode(',', $deliveries_emailers);
	if ($deliveries_emailers) {
		$emailers_query = "SELECT * FROM emailers
			WHERE id NOT IN ($deliveries_emailers)
			LIMIT " . EMAILERS_PER_DELIVERY;
	} else {
		$emailers_query = "SELECT * FROM emailers
			LIMIT " . EMAILERS_PER_DELIVERY;
	}
	$emailers = get_records($emailers_query);

	if (! $emailers) {
		echo "No emailers => all emails were sent\n";
		echo "Updating delivery. Done => true";
		mysql_query("UPDATE deliveries SET done = 1 WHERE id = $delivery->id");
		die();
	}
}

foreach ($emailers as $emailer) {
	$addressees []= array(
		'name'=>$emailer->name, 'email'=>$emailer->email, 'id'=>$emailer->id
	);
}

$done_emailers_ids = array();
	
foreach ($addressees as $a) {
	$to = $a['email'];
	$subject = "hotels-sale.ru: Новые предложения";
	$body = "Добрый день, $a[name]! Новые предложения:<br/><br/><br/>\n\n
".$new."Посмотреть новые предложения Вы можете здесь: http://hotels-sale.ru<br/><br/>
<a href='http://hotels-sale.ru/?adv'>Разместить объявление о продаже</a> | <a href='http://hotels-sale.ru/foragencies/'>Предложение для агентств</a><br/><br/>
<small>Вы получаете рассылку сайта www.hotels-sale.ru, если Вы хотите отписаться, вышлите письмо нам с просьбой удалить Ваш адрес из рассылки</small>";
	

	$headers = "Content-type: text/html; charset=windows-1251\r\n";
	$headers .= "Received: by hotels-sale.ru\r\n";
	$headers .= "Return-Path: news@hotels-sale.ru\r\n";
	$headers .= "Message-Id: <news@hotels-sale.ru>\r\n";
	$headers .= "From: hotels-sale.ru <news@hotels-sale.ru>";
	
	if (mail($to, $subject, $body, $headers)) {
		$done_emailers_ids []= $a['id'];
	}
};

echo "Emails sent: " . count($done_emailers_ids);

$done_emailers_values = array();

foreach ($done_emailers_ids as $id) {
	$done_emailers_values []= "($delivery->id, $id)";
}

$sql = "INSERT INTO deliveries_emailers (delivery_id, emailer_id) VALUES " . implode(', ', $done_emailers_values);

mysql_query($sql);

?>