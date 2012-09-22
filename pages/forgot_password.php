<h2>Вспомнить пароль</h2>

<? require_once '_form_errors.php' ?>
<? require_once '_flash.php' ?>

<form action="." method="POST" class="login-form">
	<div class="form-row">
		<label>Ваш email</label><br />
		<input type="text" name="email" id="email" value="<?= $_POST['email'] ?>" />
	</div>
	<div class="form-row">
		<button type="submit">Отправить</button>
	</div>
</form>