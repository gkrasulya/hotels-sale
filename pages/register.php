<h2>�����������</h2>

<?
require_once '_form_errors.php';
require_once '_flash.php';
?>

<? if (! isset($registration_result) || ! $registration_result): ?>
	<form action="." method="POST" class="login-form">
		<div class="form-row">
			<label>Email</label><br />
			<input type="text" name="email" id="email" value="<?= $_POST['email'] ?>" />
		</div>
		<div class="form-row">
			<label>������:</label><br />
			<input type="password" name="password" id="password" value="" />

			<div class="help closer">������� 6 ��������</div>
		</div>
		<div class="form-row">
			<button type="submit">������������������</button>
		</div>
	</form>
<? endif ?>