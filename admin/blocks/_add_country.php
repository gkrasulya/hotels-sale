<h2>Добавление страны</h2>

<?
if (isset($do)) {

	$title = isset($_POST['title']) ? $_POST['title'] : '';
	$flag = isset($_POST['flag']) ? $_POST['flag'] : '';

	require_once('flag.php');
	$result = mysql_query("INSERT INTO countries (title,flag) VALUES ('$title','$filename')");

	if ($result)  {
		echo "<h4>Все сделано!</h4>";
	} else {
		echo "<h4>Не получилось!</h4>";
	}
	
}
?>
	
<form method='post' id='form' action='?t=country&a=add&do' enctype='multipart/form-data' >
	<p>
		<label>Название страны</label>
		<input type='text' name='title'>
	</p>
	<p>
		<label>Flag</label>
		<input type='file' name='flag'>
	</p>
	<p><button type="submit">Сохранить</button></p>
</form>