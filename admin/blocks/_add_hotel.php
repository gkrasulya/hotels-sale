<?
global $hotel_cols;

echo "<h2>���������� ���������</h2>";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	foreach ($_POST as $kw => $val) $$kw = $val;

	$title = str_replace('�', '&euro;', $title);
	$descr = str_replace('�', '&euro;', $descr);
	$text = str_replace('�', '&euro;', $text);
	$price = str_replace('�', '&euro;', $price);
	
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

			$sql_r_array = array();
			foreach ($regions as $r_id) {
				$sql_r_array []= "($hotel_id, $r_id)";
			}

			$sql_r = "INSERT INTO hotels_regions (hotel_id, region_id)\n";
			$sql_r .= " VALUES " . implode($sql_r_array, ",\n");

			mysql_query($sql_c);
			mysql_query($sql_r);
		}

		echo "<h4>��� �������!</h4>";
	} else  {
		echo mysql_error();
		echo "<h4>�� ����������!</h4>";
	}
		
}
	
?>

<br />

<form method='POST' id='form' enctype='multipart/form-data' action='?t=hotel&amp;a=add'>
	<label>�������� ���������</label>
	<input type='text' name='title'>

	<label>�����</label>
	<input type='text' name='number'>

	<label>�����</label>
	<input type='text' name='town'>

	<label>����</label>
	<input type='text' name='price'>

	<label>���� (��� ��������)</label>
	<input type='text' name='price_s'>

	<label>���������� �������</label>
	<input type='text' name='rooms'>

	<label>������� ��������</label>
	<textarea name='descr'></textarea>

	<label>��������� ��������</label>
	<textarea name='text'></textarea>

	<label>����������</label>
	<input type='file' name='foto'>

	<label>������</label>
	<select name='countries[]' multiple style="height: 150px;">

<?
	$result = mysql_query("SELECT * FROM countries",$db);
	$myrow = mysql_fetch_array($result);
	do echo "<option value=\'{$myrow['id']}\'>{$myrow['title']}</option>\n";
	while ($myrow = mysql_fetch_array($result));
?>

	</select>
	<label>������</label>
	<select name='regions[]' multiple style="width: 220px; height: 150px;">
	
<?
	$result = mysql_query("SELECT * FROM countries");
	$myrow = mysql_fetch_array($result);
	echo "<option value='0'> ��� ������� </option>";
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

	<label for='forward'>��������� �������</label>
	<input id='forward' type='checkbox' name='forward' /><br/>

	<label for='tosend'>������ �� ��������</label>
	<input id='tosend' type='checkbox' name='tosend' /><br/>

	<label>Email ������� (����� ������ ��������� ����� �������)</label>
	<input type='text' name='client_email'><br/>

	<input type='submit' value='ok'>
</form>