<?

login_required();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	// print_r($_POST);
	$errors = array();

	$summ = trim(addslashes($_POST['summ']));
	$summ = preg_replace("/\s/", '', $summ);

	if ($summ == '') $errors []= 'Введите сумму';

	$summ = preg_replace('/\s*/', '', $summ);
	if (preg_match('/[^\d]/', $summ)) $errors []= 'Введена неверная суммы. Должны быть только цифры.';

	if (isset($_POST['system'])) {
		if (in_array($_POST['system'], array( 'paypal', 'interkassa' ))) $system = addslashes($_POST['system']);
		else $errors []= 'Неверная система оплаты';
	} else {
		$errors []= 'Выберите систему оплаты';
	}

	if (empty($errors)) {
		require_once 'payment_settings.php';

		$description_system = array(
			'paypal' => 'PayPal',
			'interkassa' => 'Interkassa'
		);

		$summ_euro = rub2euro($summ);

		$payment = array(
			'date' => date('Y-m-d H:i:s'),
			'summ' => $summ,
			'summ_euro' => $summ_euro,
			'type' => 'in',
			'description' => 'Пополнение счета через ' . $description_system[$system],
			'user_id' => $user->id,
			'amount_left' => $user->amount + $summ,
			'transaction_id' => mktime() . $user->id,
			'system' => $system
		);

		$payment_info = "Вы хотите пополнить счет на <strong>$summ рублей</strong> (&euro;$summ_euro) через <strong>$description_system[$system]</strong>";
		$payment_description = "Пополнение счета на " . SITE_ADDR . " на $summ рублей (&euro;$summ_euro)";

		# creating offer sql
		$sql = "INSERT INTO payments\n";
		$sql .= " (\n\t" . implode(array_keys($payment), ",\n\t") . "\n)\n";
		$sql .= " VALUES (\n\t'" . implode(array_values($payment), "',\n\t'") . "'\n)";

		// echo '<pre>';
		// echo $sql;
		// print_r($payment);

		mysql_query($sql);
		// echo mysql_error();

		if ($system == 'paypal') {
			$paypal = array(
				'form_action' => $paypal_pay_url,
				'email' => $paypal_email,
				'item_name' => "Updating account on hotels-sale.ru",
				'item_id' => $payment['transaction_id'],
				'amount' => $summ,
				'currency_code' => 'EUR',
			);

			// print_r($paypal);
		} elseif ($system == 'interkassa') {
			$sign_hash_string = "{$interkassa[shop_id]}:" .
				"{$payment->amount}:" .
				"{$payment->id}:" .
				"{$interkassa[paysystem_alias]}:" .
				":" .
				$interkassa['secret_key'];
				
			$sign_hash_string_card = "{$interkassa[shop_id]}:" .
				"{$payment->amount}:" .
				"{$payment->id}:" .
				"liqpaycarde:" .
				":" .
				$interkassa['secret_key'];

			$interkassa['sign_hash'] = strtoupper(md5($sign_hash_string));
			$interkassa['sign_hash_card'] = strtoupper(md5($sign_hash_string_card));
			$interkassa['item_name'] = $payment_description;
		}


		// echo '</pre>';
	}
}