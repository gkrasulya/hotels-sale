<h2>����</h2>

<? require_once '_form_errors.php' ?>

<form action="." method="POST" class="login-form">
	<div class="form-row">
		<label>Email</label><br />
		<input type="text" name="email" id="email" value="<?= $_POST['email'] ?>" />
	</div>
	<div class="form-row">
		<label>������:</label><br />
		<input type="password" name="password" id="password" value="<?= $_POST['password'] ?>" />
	</div>
	<div class="form-row">
		<input type="checkbox" checked name="remember_me" id="remember_me" style="width: auto" />
		<label for="remember_me">��������� ����</label>
	</div>
	<div class="form-row">
		<button type="submit">�����</button>
	</div>
	<div class="form-row">
		<p>
			<a href="<?= SITE_ADDR ?>register/" title="�����������">�����������</a>
			<a href="<?= SITE_ADDR ?>forgot_password/" title="������ ������?">������ ������?</a>
			<?/*<a href="<?= SITE_ADDR ?>for-what/" title="��� ����?">��� ����?</a>*/?>
		</p>
	</div>
</form>