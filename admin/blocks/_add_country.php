<h2>���������� ������</h2>

<?
if (isset($do)) {

	$title = isset($_POST['title']) ? $_POST['title'] : '';
	$flag = isset($_POST['flag']) ? $_POST['flag'] : '';

	require_once('flag.php');
	$result = mysql_query("INSERT INTO countries (title,flag) VALUES ('$title','$filename')");

	if ($result)  {
		echo "<h4>��� �������!</h4>";
	} else {
		echo "<h4>�� ����������!</h4>";
	}
	
}
?>
	
<form method='post' id='form' action='?t=country&a=add&do' enctype='multipart/form-data' >
	<p>
		<label>�������� ������</label>
		<input type='text' name='title'>
	</p>
	<p>
		<label>Flag</label>
		<input type='file' name='flag'>
	</p>
	<p><button type="submit">���������</button></p>
</form>