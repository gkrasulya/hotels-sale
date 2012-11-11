<?
global $hotel_cols;
echo "<h2>Добавление гостиницы</h2>";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	foreach ($_POST as $kw => $val) $$kw = $val;

	$title = $hotel_title = str_replace('€', '&euro;', $title);
	$descr = str_replace('€', '&euro;', $descr);
	$text = str_replace('€', '&euro;', $text);
	$price = str_replace('€', '&euro;', $price);
	
	$forward = isset($_POST['forward']) ? 1 : 0;
	$tosend = isset($_POST['tosend']) ? 0 : 1;
	$active = isset($_POST['active']) ? 1 : 0;
	$open_stats = isset($_POST['open_stats']) ? 1 : 0;

	$countries = $_POST['countries'];

	$slug = create_slug($title) . '-' . mktime();

	require_once("blocks/foto.php");

	$hotel_data = array();

	foreach ($hotel_cols as $col) {
		if (isset($$col)) {
			$hotel_data[$col] = $$col;
		}
	}
	$hotel_data['title'] = $hotel_title;
	$hotel_data['priority'] = $priority;
	$hotel_data['foto'] = $foto_id;
	$hotel_data['slug'] = $slug;
	$hotel_data['tosend'] = $tosend;

	$hotel_data['head_title'] = $_POST['head_title'];
	$hotel_data['meta_keywords'] = $_POST['meta_keywords'];
	$hotel_data['meta_description'] = $_POST['meta_description'];

	$country = get_record('SELECT * FROM countries WHERE id IN (' . implode($countries, ', ') . ') LIMIT 1');

	if (! $hotel_data['meta_description']) {
		$hotel_data['meta_description'] = $country->meta_description;
	}
	if (! $hotel_data['meta_keywords']) {
		$hotel_data['meta_keywords'] = $country->meta_keywords;
	}

	$hotel_data['expiration'] = $_POST['expiration'];
	$hotel_data['active'] = $active;

	$sql = "INSERT INTO hotels\n";
	$sql .= " (\n\t" . implode(array_keys($hotel_data), ",\n\t") . "\n)\n";
	$sql .= " VALUES (\n\t'" . implode(array_values($hotel_data), "',\n\t'") . "'\n)";

	$result = mysql_query($sql);

	if ($result) {
		$hotel_id = mysql_insert_id();
		if (! empty($countries)) {

		if (isset($countries)) {
			$sql_c_array = array();
			foreach ($countries as $c_id) {
				$sql_c_array []= "($hotel_id, $c_id)";
			}

			$sql_c = "INSERT INTO hotels_countries (hotel_id, country_id)\n";
			$sql_c .= " VALUES " . implode($sql_c_array, ",\n");

			mysql_query($sql_c);
			// die(mysql_error());
		}

		if (isset($regions)) {

			$sql_r_array = array();
			foreach ($regions as $r_id) {
				$sql_r_array []= "($hotel_id, $r_id)";
			}

			$sql_r = "INSERT INTO hotels_regions (hotel_id, region_id)\n";
			$sql_r .= " VALUES " . implode($sql_r_array, ",\n");

			mysql_query($sql_r);
		}
	}

		echo "<h4>Все сделано!</h4>";
	} else  {
		echo mysql_error();
		echo "<h4>Не получилось!</h4>";
	}
		
}
	
?>

<br />

<form method='POST' id='form' enctype='multipart/form-data' action='?t=hotel&amp;a=add'>
	<label>Название гостиницы</label>
	<input type='text' name='title'>

	<label>Номер</label>
	<input type='text' name='number'>

	<label>Город</label>
	<input type='text' name='town'>

	<label>Цена</label>
	<input type='text' name='price'>

	<label>Цена (без пробелов)</label>
	<input type='text' name='price_s'>

	<label>Количество номеров</label>
	<input type='text' name='rooms'>

	<label>Краткое описание</label>
	<textarea name='descr'></textarea>

	<label>Подробное описание</label>
	<textarea name='text'></textarea>
	
	<p>
		<label for="">Заголовок для поисковиков</label>
		<textarea class="small" name="head_title"></textarea>
	</p>
	<p>
		<label for="">Ключевые слова для поисковиков (meta keywords)</label>
		<textarea class="small" name="meta_keywords"></textarea>
	</p>
	<p>
		<label for="">Описание для поисковиков (meta description)</label>
		<textarea class="small" name="meta_description"></textarea>
	</p>

	<label>Фотография</label>
	<input type='file' name='foto'>

	<label>Страна</label>
	<select name='countries[]' multiple style="height: 150px;">

<?
	$result = mysql_query("SELECT * FROM countries",$db);
	$myrow = mysql_fetch_array($result);
	do echo "<option value='{$myrow['id']}'>{$myrow['title']}</option>\n";
	while ($myrow = mysql_fetch_array($result));
?>

	</select>
	<label>Регион</label>
	<select name='regions[]' multiple style="width: 220px; height: 150px;">
	
<?
	$result = mysql_query("SELECT * FROM countries");
	$myrow = mysql_fetch_array($result);
	echo "<option value='0'> Без региона </option>";
	do {
		$result2 = mysql_query("SELECT * FROM regions WHERE country={$myrow['id']}");
		if (mysql_num_rows($result2) > 0): ?>
			<optgroup label="<?= $myrow['title'] ?>">
				<?
				$myrow2 = mysql_fetch_array($result2);
				do echo "<option value='$myrow2[id]'>$myrow2[title]</option>\n";
				while ($myrow2 = mysql_fetch_array($result2));	
				?>
			</optgroup>
		<? endif;
	} while ($myrow = mysql_fetch_array($result));

?>

	
<?
	$result = mysql_query("SELECT * FROM countries");
	$myrow = mysql_fetch_array($result);

	$result2 = mysql_query("SELECT * FROM regions WHERE country={$myrow['id']}");
	if (mysql_num_rows($result2) > 0): ?>
		<optgroup label="<?= $myrow['title'] ?>">
			<?
			$myrow2 = mysql_fetch_array($result2);
			do echo "<option value='$myrow2[id]'>$myrow2[title]</option>\n";
			while ($myrow2 = mysql_fetch_array($result2));	
			?>
		</optgroup>
	<? endif ?>

?>

	</select><br />

	<label for='forward'>Поместить впереди</label>
	<input id='forward' type='checkbox' name='forward' /><br/>
	
	<label for="priority">Приоритет (чем ниже, тем выше предложение)</label>
	<input type="text" value="1000" name="priority"><br>

	<label>Активно</label>
	<input checked type='checkbox' name='active' /><br/>

	<label for="expiration">Активно до (например, 2012-06-15)</label>
	<input type="text" name="expiration" value="" /><br>

	<label for='tosend'>Убрать из рассылки</label>
	<input id='tosend' type='checkbox' name='tosend' /><br/>

	<label>Email клиента (можно ввести несколько через запятую)</label>
	<input type='text' name='client_email'><br/>
		
	<p>
		<button type="submit">Сохранить</button>
	</p>
</form>