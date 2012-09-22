<?

require_once 'blocks/db.php';
require_once 'blocks/functions.php';

$emailers = get_records("SELECT * FROM emailers");

$addressees = array();
foreach ($emailers as $emailer) {
	$addressees []= $emailer->email;
}

$addressees = implode(', ', $addressees);

print_r($addressees);

$headers = "Content-type: text/plain; charset=windows-1251\r\n";
$headers .= "Received: by hotels-sale.ru\r\n";
$headers .= "Return-Path: news@hotels-sale.ru\r\n";
$headers .= "Message-Id: <news@hotels-sale.ru>\r\n";
$headers .= "From: hotels-sale.ru <news@hotels-sale.ru>";

$body = "
	Уважаемые Дамы и Господа!

	От Всей души поздравляем Вас с наступающим Новым Годом!
	Желаем крепкого здоровья, счастья и успехов во всем!
	Веселых праздников и хорошего отдыха!

	http://hotels-sale.ru
	http://business-gold.ru";

$test_addressees = 'gkrasulya@gmail.com, alupichev@yandex.ru';

mail($addressees, 'С наступающим новым годом!', $body, $headers);

?>