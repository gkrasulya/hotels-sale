<?
global $hotel_cols;

echo "<h2>Добавление гостиницы</h2>";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	foreach ($_POST as $kw => $val) $$kw = $val;

	$title = $hotel_title = str_replace('€', '&euro;', $title);
	$descr = str_replace('€', '&euro;', $descr);
	$descr_html = text2html($descr);
	$text = str_replace('€', '&euro;', $text);
	$text_html = text2html($text);
	$price = str_replace('€', '&euro;', $price);
	
	$forward = isset($_POST['forward']) ? 1 : 0;
	$tosend = isset($_POST['tosend']) ? 0 : 1;

	$slug = create_slug($title) . '-' . mktime();

	require_once("blocks/foto.php");

	$hotel_data = array();

	foreach ($hotel_cols as $col) {
		$hotel_data[$col] = $$col;
	}
	$hotel_data['foto'] = $foto_id;
	$hotel_data['slug'] = $slug;
	$hotel_data['tosend'] = $tosend;
	$hotel_data['title'] = $hotel_title;
	$hotel_data['type'] = 'admin';

	$sql = "INSERT INTO hotels\n";
	$sql .= " (\n\t" . implode(array_keys($hotel_data), ",\n\t") . "\n)\n";
	$sql .= " VALUES (\n\t'" . implode(array_values($hotel_data), "',\n\t'") . "'\n)";

	$result = mysql_query($sql);

	if ($result) {
		if (! empty($countries)) {
			$hotel_id = mysql_insert_id();

			$sql_c_array = array();
			foreach ($countries as $c_id) {
				$sql_c_array []= "($hotel_id, $c_id)";
			}

			$sql_c = "INSERT INTO hotels_countries (hotel_id, country_id)\n";
			$sql_c .= " VALUES " . implode($sql_c_array, ",\n");

			mysql_query($sql_c);
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

	<label>Фотография</label>
	<input type='file' name='foto'>

	<label>Страна</label>
	<select name='countries[]' multiple style="height: 150px;">

<?
	$result = mysql_query("SELECT * FROM countries",$db);
	$myrow = mysql_fetch_array($result);
	do echo "<option value='{$myrow[id]}'>{$myrow[title]}</option>\n";
	while ($myrow = mysql_fetch_array($result));
?>

	</select>
	<label>Регион</label>
	<select name='region'>
	
<?
	$result = mysql_query("SELECT * FROM countries");
	$myrow = mysql_fetch_array($result);
	echo "<option value='0'> Без региона </option>";
	do {
		echo "<option disabled> --- ".$myrow['title']." --- </option>\n";
		$result2 = mysql_query("SELECT * FROM regions WHERE country='{$myrow[id]}'");

		if (mysql_num_rows($result2) > 0) {
			$myrow2 = mysql_fetch_array($result2);
			do echo "<option value='$myrow2[id]'>$myrow2[title]</option>\n";
			while ($myrow2 = mysql_fetch_array($result2));
		}
	} while ($myrow = mysql_fetch_array($result));

?>

	</select><br />

	<label for='forward'>Поместить впереди</label>
	<input id='forward' type='checkbox' name='forward' /><br/>

	<label for='tosend'>Убрать из рассылки</label>
	<input id='tosend' type='checkbox' name='tosend' /><br/>

	<label>Email клиента (можно ввести несколько через запятую)</label>
	<input type='text' name='client_email'><br/>

	<input type='submit' value='ok'>
</form>