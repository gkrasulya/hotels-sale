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
	��������� ���� � �������!

	�� ���� ���� ����������� ��� � ����������� ����� �����!
	������ �������� ��������, ������� � ������� �� ����!
	������� ���������� � �������� ������!

	http://hotels-sale.ru
	http://business-gold.ru";

$test_addressees = 'gkrasulya@gmail.com, alupichev@yandex.ru';

mail($addressees, '� ����������� ����� �����!', $body, $headers);

?>