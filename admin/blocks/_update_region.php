<?
if (! isset($n)) {
	$result = mysql_query("SELECT * FROM regions ORDER BY title");
	$myrow = mysql_fetch_array($result);
	?>
	
	<h2>�������������� �������</h2>
	
	<form method='post' id='form'>
		<p>
			<label>�������� ������:</label>
		</p>
		
		<ul class="choice-list">
			<? do { ?>
				<li><a href='?t=region&amp;a=update&amp;n=<?= $myrow['id'] ?>' class='del'><?= $myrow['title'] ?></a></li>
			<? } while ($myrow = mysql_fetch_array($result)); ?>
		</ul>
	</form>	
	
<? } else { ?>
	
	<h2>�������������� �������</h2>

	<?
	if (isset($do)) {

		$title = isset($_POST['title']) ? $_POST['title'] : '';
		$country = isset($_POST['country']) ? $_POST['country'] : '';
		$head_title = isset($_POST['head_title']) ? $_POST['head_title'] : '';
		$meta_keywords = isset($_POST['meta_keywords']) ? $_POST['meta_keywords'] : '';
		$meta_description = isset($_POST['meta_description']) ? $_POST['meta_description'] : '';
			
		$result = mysql_query("
			UPDATE regions
			SET
				title='$title',
				head_title='$head_title',
				meta_description='$meta_description',
				meta_keywords='$meta_keywords',
				country='$country'
			 WHERE id='$n'");

		if ($result)  {
			echo "<h4>��� �������!</h4>";
		} else {
			echo "<h4 class='error'>�� ����������!</h4>";
			}	
		}
		
	$result = mysql_query("SELECT * FROM regions WHERE id='$n'");
	$myrow = mysql_fetch_array($result);

	?>
	
	<p>
		<a href="?t=region&amp;a=update">&larr; � ������</a>
	</p>
	
	<form method='post' id='form' action='?t=region&amp;a=update&amp;n=<?= $n ?>&do'>
		<p>
			<label>�������� �������</label>
			<input type='text' name='title' value='<?= $myrow['title'] ?>'>
		</p>
		<p>
			<label for="">��������� ��� �����������</label>
			<textarea class="small" name="head_title"><?= $myrow['head_title'] ?></textarea>
		</p>
		<p>
			<label for="">�������� ����� ��� ����������� (meta keywords)</label>
			<textarea class="small" name="meta_keywords"><?= $myrow['meta_keywords'] ?></textarea>
		</p>
		<p>
			<label for="">�������� ��� ����������� (meta description)</label>
			<textarea class="small" name="meta_description"><?= $myrow['meta_description'] ?></textarea>
		</p>
		<p>
			<label>������</label>
			<select name='country'>
				<?
				$result2 = mysql_query("SELECT * FROM countries");
				$myrow2 = mysql_fetch_array($result2);
				do { ?>
					<option value='<?= $myrow2['id'] ?>'
						<?= $myrow['country'] == $myrow2['id'] ? 'selected' : '' ?> ><?= $myrow2['title'] ?></option>
				<? } while ($myrow2 = mysql_fetch_array($result2)); ?>
			</select>
		</p>
		<p>
			<button type="submit">���������</button>
		</p>
	</form>

<? }
