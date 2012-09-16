<?

login_required();

$month_cost = $user->month_cost;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	// print_r($_POST);
	$errors = array();

	$period = trim(addslashes($_POST['period']));
	if (preg_match('/[^\d]/', $period)) {
		$errors []= 'Введен неверный период. Должны быть только цифры.';
	}

	if ($user->month_cost_cur == 'euro') {
		$summ_euro = $month_cost * $period;
		if ($summ_euro == '') $errors []= 'Введите сумму';
		$summ = euro2rub($summ_euro);
	} else {
		$summ = $month_cost * $period;
		if ($summ == '') $errors []= 'Введите сумму';
		$summ_euro = rub2euro($summ);
	}

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

		$payment = array(
			'date' => date('Y-m-d H:i:s'),
			'summ' => $summ,
			'summ_euro' => $summ_euro,
			'type' => 'in',
			'period' => $period,
			'description' => 'Продление аккаунта через ' . $description_system[$system],
			'user_id' => $user->id,
			'transaction_id' => mktime() . $user->id,
			'system' => $system
		);

		$payment_info = "Вы хотите продлить аккаунт на $period месяц(ев) через <strong>$description_system[$system]</strong>";
		$payment_description = "Продление аккаунта на " . SITE_ADDR . " на $period месяц(ев)";

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

		// echo '<pre>';
		// print_r($interkassa);
		// print_r($payment);
		// echo '</pre>';


		// echo '</pre>';
	}
}