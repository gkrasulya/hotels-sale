<h2>Добавление региона</h2>

<?

if (isset($do)) {

	$title = isset($_POST['title']) ? $_POST['title'] : '';
	$country = isset($_POST['country']) ? $_POST['country'] : '';
			
	$result = mysql_query("INSERT INTO regions (title,country) VALUES ('$title','$country')");

	if ($result) {
		echo "<h4>Все сделано!</h4>";
	} else  {
		echo "<h4>Не получилось!</h4>";
	}
			
}

?>

<form method='POST' id='form' action='?t=region&a=add&do'>
	<p>
		<label>Название региона</label>
		<input type='text' name='title'>
	</p>
	<p>
		<label>Страна</label>
		<select name='country'>
			<?
			$result = mysql_query("SELECT * FROM countries",$db);
			$myrow = mysql_fetch_array($result);
			
			do { ?>
				<option value='<?= $myrow['id'] ?>'><?= $myrow['title'] ?></option>
			<? } while ($myrow = mysql_fetch_array($result)); ?>
		</select>
	</p>
	<p>
		<button type="submit">Сохранить</button>
	</p>
</form>