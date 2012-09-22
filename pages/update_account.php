<h2>���������� �����</h2>

<? require_once '_form_errors.php' ?>

<? if ($_SERVER['REQUEST_METHOD'] == 'GET' or ! empty($errors)): ?>

	<form action="." method="POST" class="login-form">
		<div class="form-row">
			<select name="period" id="period">
				<? foreach ($agency_periods as $period): ?>
					<?
					if ($user->month_cost_cur == 'euro') {
						$option_text = $period['name'] . ' �� &euro;' . ($month_cost * $period['period']) .
							' (' . euro2rub($month_cost * $period['period']) . ' ���. *)';
					} else {
						$option_text = $period['name'] . ' �� ' . ($month_cost * $period['period']) .
							'���. (&euro;' . rub2euro($month_cost * $period['period']) . '*)';
					}
					?>
					<option value="<?= $period['period'] ?>"><?= $option_text ?></option>	
				<? endforeach ?>
			</select>
		</div>

		<p>
			* ������������ �� ������ <a href="http://cbr.ru" target="_blank">cbr.ru</a>. ������� ���� ����� <?= $euro_rate ?> ������.
		</p>

		<div class="form-row c">
			<label>�������� �����:</label>

			<div class="c"></div>

			<div class="l payment-system">
				<input type="radio" class="radio" name="system" id="system1" value="interkassa" />
				<label for="system1">Interkassa</label>

				<p>
					� ������� ���������� �� ������ �������� ����� ������ ��������� �������: <a target="_blank" href="https://liqpay.com/">LiqPay</a>, <a target="_blank" href="https://www.moneymail.ru/">MoneyMail</a>, <a target="_blank" href="https://rbkmoney.ru/">RBK Money</a>, <a target="_blank" href="http://money.yandex.ru/">������.������</a> � <a target="_blank" href="http://www.interkassa.com/" title="Interkassa">������</a>
				</p>
			</div>

			<div class="l payment-system">
				<input type="radio" class="radio" name="system" id="system2" value="paypal" />
				<label for="system2">Paypal</label>

				<p>
					���������� ����������� ��������� �������. ���� ����������� ������ ������ <a href="http://visa.com" target="_blank" title="Visa">Visa</a> � <a href="http://www.mastercard.com/" target="_blank" title="MasterCard">MasterCard</a>. <a href="https://www.paypal.com/ru" title="PayPal" target="_blank">���� Paypal</a>
				</p>
			</div>
		</div>
		<div class="form-row">
			<button type="submit" disabled>����������</button>
		</div>

		<br/>
		<p>
			���� �� ������ �������� ����� ��������� ������� Webmoney, �� ������ �������� �� ��� �������� ������� R141042007100 � �������� ��� �� ������ � ������� <a href="<?= SITE_ADDR ?>support/">�������� �����</a>
		</p>
	</form>

	<script type="text/javascript">
		(function() {
			var $f = $('form'),
				$paymentSystems = $f.find('div.payment-system'),
				$submit = $f.find('button[type=submit]'),
				paymentSelected = false;

			$paymentSystems.each(function() {
				var $self = $(this),
					$radio = $self.find('input');

				$self.click(function() {
					$paymentSystems.removeClass('selected');
					$self.addClass('selected');

					if (! paymentSelected) {
						paymentSelected = true;
						$submit.attr('disabled', false);
					}

					$radio.attr('checked', true);
				});
			});
		})();
	</script>

<? else: ?>

	<? if ($system == 'paypal'): ?>
		<form action="<?= $paypal_pay_url ?>" method="POST" enctype="multipart/form-data">
			<input name="rm" type="hidden" value="2" />
			<input name="cmd" type="hidden" value="_xclick" />
			<input name="business" type="hidden" value="<?= $paypal['email'] ?>" />
			<input name="item_name" type="hidden" value="<?= utf8_encode($paypal['item_name']) ?>" />
			<input name="item_number" type="hidden" value="<?= $payment['transaction_id'] ?>" />
			<input name="amount" type="hidden" value="<?php echo $summ_euro ?>" />
			<input name="invoice" type="hidden" value="<?php echo mktime() ?>" />
			<input name="currency_code" type="hidden" value="<?= $paypal['currency_code'] ?>" />
			<input name="return" type="hidden" value="<?php echo $success_payment_url ?>" />
			<input name="cancel_return" type="hidden" value="<?php echo $cancel_payment_url ?>" />
			<input name="notify_url" type="hidden" value="<?php echo $paypal_notify_url ?>" />
			<p class="payment-info">
				<?= $payment_info ?>
			</p>
			<p>
				<button type="submit">����������</button>
				<a href="<?= SITE_ADDR ?>update_amount/" title="Cancel" class="cancel">������</a>
			</p>
		</form>
	<? else: ?>
		<form action="<?php echo $interkassa['pay_url'] ?>" method="post" id="form">
			<input type="hidden" name="ik_shop_id" value="<?php echo $interkassa['shop_id'] ?>" />
			<input type="hidden" name="ik_payment_amount" value="<?php echo $payment['summ'] ?>" />
			<input type="hidden" name="ik_payment_id" value="<?php echo $payment['transaction_id'] ?>" />
			<input type="hidden" name="ik_payment_desc" value="<?php echo $interkassa['item_name'] ?>" />
			<input type="hidden" name="ik_paysystem_alias" value="<?php echo $interkassa['paysystem_alias'] ?>" />
			<?/*<input type="text" name="ik_sign_hash" value="<?php echo $interkassa['sign_hash'] ?>" />*/?>
			<p class="payment-info">
				<?= $payment_info ?>
			</p>
			<p>
				<button type="submit">����������</button>
				<a href="<?= SITE_ADDR ?>update_amount/" title="Cancel" class="cancel">������</a>
			</p>
		</form>
	<? endif ?>

<? endif ?>