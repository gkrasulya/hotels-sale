<h2>�������� ������</h2>

<? require_once '_form_errors.php' ?>

<form action="." method="POST" class="login-form">
	<div class="form-row">
		<label>������ ������</label><br />
		<input type="password" name="old_password" id="old_password" value="" />
	</div>
	<div class="form-row">
		<label>����� ������:</label><br />
		<input type="password" name="password" id="password" value="" />

		<div class="help closer">������� 6 ��������</div>
	</div>
	<div class="form-row">
		<label>������������� ������:</label><br />
		<input type="password" name="password_confirmation" id="password_confirmation" value="" />
	</div>
	<div class="form-row">
		<button type="submit">��������</button>
		<a href="<?= SITE_ADDR ?>account/" title="Cancel" class="cancel">������</a>
	</div>
</form>