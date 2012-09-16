<small><?= $user->email ?></small>

<div class="account-menu">
	<a href="<?= SITE_ADDR ?>account/" title="Личный кабинет">Личный кабинет</a>
	<a href="<?= SITE_ADDR ?>add_offer/" title="Добавить предложение">Добавить предложение</a>
	<? if (! is_agency()): ?>
		<a href="<?= SITE_ADDR ?>update_amount/" title="Пополнить счет">Пополнить счет</a>
		<a href="<?= SITE_ADDR ?>accounthelp/" title="Тарифы">Тарифы</a>
	<? else: ?>
		<a href="<?= SITE_ADDR ?>update_account/" title="Продлить аккаунт">Продлить аккаунт</a>
	<? endif ?>
	<a href="<?= SITE_ADDR ?>support/">Обратная связь</a>
	<a href="<?= SITE_ADDR ?>change_password/" title="Изменить пароль">Изменить пароль</a>
	<a href="<?= SITE_ADDR ?>logout/" title="Выйти">Выйти</a>
</div>

<?
if ($user->type == 'agency') {
	$day_in_seconds = 60 * 60 * 24;
	$expires_time = strtotime($user->expiration_date);
	$today_time = strtotime(date('Y-m-d'));

	$days_to_expiration = floor(($expires_time - $today_time) / $day_in_seconds);
}

if ($days_to_expiration < 6 && $days_to_expiration > -1) {
	$message = $days_to_expiration == 0 ? 'Сегодня истекает ваш аккаунт. Обратитесь к администратору сайта для продления' :
		'Ваш аккаунт истекает. Осталось дней: ' . $days_to_expiration;
	echo '<div class="flash errors">' . $message . '</div>';
}

if (is_agency() && ! $user->active) {
	echo '<div class="flash errors">Ваш аккаунт неактивен. Обратитесь к администратору сайта для продления</div>';
}

?>
