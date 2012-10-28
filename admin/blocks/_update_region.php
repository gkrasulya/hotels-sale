<?
if (! isset($n)) {
	$result = mysql_query("SELECT * FROM regions");
	$myrow = mysql_fetch_array($result);
	?>
	
	<h2>Редактирование региона</h2>
	
	<form method='post' id='form'>
		<p>
			<label>Выберите регион:</label>
		</p>
		
		<ul class="choice-list">
			<? do { ?>
				<li><a href='?t=region&amp;a=update&amp;n=<?= $myrow['id'] ?>' class='del'><?= $myrow['title'] ?></a></li>
			<? } while ($myrow = mysql_fetch_array($result)); ?>
		</ul>
	</form>	
	
<? } else { ?>
	
	<h2>Редактирование региона</h2>

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
			echo "<h4>Все сделано!</h4>";
		} else {
			echo "<h4 class='error'>Не получилось!</h4>";
			}	
		}
		
	$result = mysql_query("SELECT * FROM regions WHERE id='$n'");
	$myrow = mysql_fetch_array($result);

	?>
	
	<form method='post' id='form' action='?t=region&amp;a=update&amp;n=<?= $n ?>&do'>
		<p>
			<label>Название региона</label>
			<input type='text' name='title' value='<?= $myrow['title'] ?>'>
		</p>
		<p>
			<label for="">Заголовок для поисковиков</label>
			<input type="text" name="head_title" value="<?= $myrow['head_title'] ?>">
		</p>
		<p>
			<label for="">Ключевые слова для поисковиков (meta keywords)</label>
			<input type="text" name="meta_keywords" value="<?= $myrow['meta_keywords'] ?>">
		</p>
		<p>
			<label for="">Описание для поисковиков (meta description)</label>
			<input type="text" name="meta_description" value="<?= $myrow['meta_description'] ?>">
		</p>
		<p>
			<label>Страна</label>
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
			<button type="submit">Сохранить</button>
		</p>
	</form>

<? }