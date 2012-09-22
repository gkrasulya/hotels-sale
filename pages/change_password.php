<h2>Изменить пароль</h2>

<? require_once '_form_errors.php' ?>

<form action="." method="POST" class="login-form">
	<div class="form-row">
		<label>Старый пароль</label><br />
		<input type="password" name="old_password" id="old_password" value="" />
	</div>
	<div class="form-row">
		<label>Новый пароль:</label><br />
		<input type="password" name="password" id="password" value="" />

		<div class="help closer">Минимум 6 символов</div>
	</div>
	<div class="form-row">
		<label>Подтверждение пароля:</label><br />
		<input type="password" name="password_confirmation" id="password_confirmation" value="" />
	</div>
	<div class="form-row">
		<button type="submit">Изменить</button>
		<a href="<?= SITE_ADDR ?>account/" title="Cancel" class="cancel">Отмена</a>
	</div>
</form>