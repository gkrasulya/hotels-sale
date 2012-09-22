<small><?= $user->email ?></small>

<div class="account-menu">
	<a href="<?= SITE_ADDR ?>account/" title="Личный кабинет">Личный кабинет</a>
	<a href="<?= SITE_ADDR ?>add_offer/" title="Добавить предложение">Добавить предложение</a>
	<? if (! is_agency): ?>
		<a href="<?= SITE_ADDR ?>update_amount/" title="Пополнить счет">Пополнить счет</a>
		<a href="<?= SITE_ADDR ?>accounthelp/" title="Тарифы">Тарифы</a>
	<? endif ?>
	<a href="<?= SITE_ADDR ?>support/">Обратная связь</a>
	<a href="<?= SITE_ADDR ?>change_password/" title="Изменить пароль">Изменить пароль</a>
	<a href="<?= SITE_ADDR ?>logout/" title="Выйти">Выйти</a>
</div>