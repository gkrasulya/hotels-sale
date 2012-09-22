<h2>Обратная связь</h2>

<?
require_once '_form_errors.php';
require_once '_flash.php';
?>

<form action="" action="." method="POST">
	<div class="form-row">
		<label for="subject">Тема вашего сообщения*</label><br/>
		<input type="text" name="subject" id="subject" value="<?= $_POST['subject'] ?>" />
	</div>

	<div class="form-row">
		<label for="message">Сообщение</label><br/>
		<textarea name="message" id="message"><?= $_POST['message'] ?></textarea>
	</div>

	<div class="form-row">
		<button type="submit">Отправить</button>
	</div>
</form>