<?
if (!isset($n)) {
	$result = mysql_query("SELECT * FROM countries",$db);
	$myrow = mysql_fetch_array($result);

	?>
	
	<h2>�������������� ������</h2>
	
	<p><label>�������� ������:</label></p>
	
	<ul class="choice-list">
		<? do { ?>
			<li><a href="?t=country&amp;a=update&amp;n=<?= $myrow['id'] ?>" class="del"><?= $myrow['title'] ?></a></li>
		<? } while ($myrow = mysql_fetch_array($result)); ?>
	</ul>

<? } else {
	

	if (isset($do)) {

		$title = isset($_POST['title']) ? $_POST['title'] : '';
		$flag = isset($_POST['flag']) ? $_POST['flag'] : '';
		$head_title = isset($_POST['head_title']) ? $_POST['head_title'] : '';
		$meta_keywords = isset($_POST['meta_keywords']) ? $_POST['meta_keywords'] : '';
		$meta_description = isset($_POST['meta_description']) ? $_POST['meta_description'] : '';

		if ($flag != '') {
			require_once 'flag.php';
			$result = mysql_query("UPDATE countries SET head_title='$head_title', meta_description='$meta_description', meta_keywords='$meta_keywords', title = '$title', flag='$filename' WHERE id='$n'");
		} else {
			$result = mysql_query("UPDATE countries SET head_title='$head_title', meta_description='$meta_description', meta_keywords='$meta_keywords', title = '$title' WHERE id='$n'");
		}
		
		if ($result)  {
			echo "<h4>��� �������!</h4>";
		} else  {
			echo "<h4 class='error'>�� ����������!</h4>";
		}
		
	}
	
	$result = mysql_query("SELECT * FROM countries WHERE id='$n'");
	$myrow = mysql_fetch_array($result);

	?>
	
	<h2>�������������� ������</h2>
	
	<p>
		<a href="?t=country&amp;a=update">&larr; � ������</a>
	</p>
	
	<form enctype='multipart/form-data' method='post' id='form' action='?t=country&amp;a=update&amp;n=<?= $myrow['id'] ?>&amp;do'>
		<p>
			<label>�������� ������</label>
			<input type='text' name='title' value='<?= $myrow['title'] ?>'>
		</p>
		
		<p>
			<label for="">��������� ��� �����������</label>
			<input type="text" name="head_title" value="<?= $myrow['head_title'] ?>">
		</p>
		
		<p>
			<label for="">�������� ����� ��� ����������� (meta keywords)</label>
			<input type="text" name="meta_keywords" value="<?= $myrow['meta_keywords'] ?>">
		</p>
		
		<p>
			<label for="">�������� ��� ����������� (meta description)</label>
			<input type="text" name="meta_description" value="<?= $myrow['meta_description'] ?>">
		</p>
		
		<p>
			<label><img src="<?= SITE_ADDR ?>new_images/flags/<?=$myrow['flag']?>" alt="<?=$myrow['title']?>" />&nbsp; Flag</label>
			<input type='file' name='flag'>
		</p>
		<p><button type="submit">���������</button></p>
	</form>

	<?
}