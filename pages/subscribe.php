<h2>Подписаться на рассылку</h2>

<? require_once '_form_errors.php' ?>

<? if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($errors)): ?>
	<p><strong>Все сделано!</strong></p>
	<p><a href='/?main'>На главную</a></p>
<? else: ?>
	<form action="." method="POST" class="login-form">
		<div class="form-row">
			<label>Email</label><br />
			<input type="text" name="email" id="email" value="<?= isset($_POST['email']) ? $_POST['email'] : ''; ?>" />
		</div>
		<div class="form-row">
			<label>Ваше имя</label><br />
			<input type="text" name="name" id="name" value="<?= isset($_POST['name']) ? $_POST['name'] : ''; ?>" />
		</div>
		<div class="form-row">
			<button type="submit">Подписаться</button>
		</div>
	</form>
<? endif ?>