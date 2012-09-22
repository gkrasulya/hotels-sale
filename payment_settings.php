<?php

$success_payment_url = SITE_ADDR . 'success_payment/';
$cancel_payment_url = SITE_ADDR . 'cancel_payment/';

# FOR PAYPAL

$paypal_email = 'aheliport@gmail.com';
$paypal_notify_url = SITE_ADDR . 'pro/p/ipn';
$paypal_pay_url = 'https://www.paypal.com/cgi-bin/webscr';

// if ($_SERVER['REMOTE_ADDR'] == '77.39.91.124') {
	// $paypal_pay_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
// }
	

# FOR INTERKASSA

$interkassa = array(
	'secret_key' => 'UWJj5QRhwSmDe9hN',
	'shop_id' => '142460FB-9D70-C3A0-BE51-031AE764EA36___',
	'paysystem_alias' => '',
	'pay_url' => 'http://www.interkassa.com/lib/payment.php'
);

?>