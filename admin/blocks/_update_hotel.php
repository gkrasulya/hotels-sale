<?
global $hotel_cols;

if (! isset($n)) {
	$sort = null;
	$query = null;
	$desc = '';
	if (isset($_GET['sort'])) {
		$sort = addslashes($_GET['sort']);
	}
	if (isset($_POST['query'])) {
		$query = addslashes($_POST['query']);
	}

	if ($sort) {
		if ($sort == 'views') {
			$desc = 'DESC';
		}
		$sql = "SELECT id, `number`, title, views FROM hotels ORDER BY $sort $desc";
	} else if ($query) {
		$sql = "SELECT id, `number`, title, views FROM hotels WHERE id = $query";
	} else {
		$sql = "SELECT id, `number`, title, views FROM hotels ORDER BY id DESC";
	}
	// die($sql);
	$result = mysql_query($sql, $db);
	$myrow = mysql_fetch_array($result);
?>

<style type="text/css">
	th {
		white-space: nowrap;
	}
</style>

<h2>�������������� ���������</h2>
<p>
	<a href="?t=hotel&amp;a=update">�������� ���</a>
</p>

<form action="?t=hotel&amp;a=update" method="POST" style="margin-top: 15px;">
	ID �������: <input type="text" name="query">
</form>

<form method='post' id='form'>

<table style="width: 670px" width="100%">
	<thead>
		<tr>
			<th>
				<a href="?t=hotel&amp;a=update&amp;sort=id">#</a>
				<? if ($sort == 'id') echo '&darr;' ?>
			</th>
			<th>
				<a href="?t=hotel&amp;a=update&amp;sort=number">�����</a>
				<? if ($sort == 'number') echo '&darr;' ?>
			</th>
			<th>
				<a href="?t=hotel&amp;a=update&amp;sort=title">��������</a>
				<? if ($sort == 'title') echo '&darr;' ?>
			</th>
			<th>
				<a href="?t=hotel&amp;a=update&amp;sort=views">��������</a>
				<? if ($sort == 'views') echo '&darr;' ?>
			</th>
		</tr>
	</thead>
<? 
	do { ?>
		<tr>
			<td><?= $myrow['id'] ?></td>
			<td><?= $myrow['number'] ? "<strong>{$myrow['number']}</strong>" : '' ?></td>
			<td>
				<a href='?t=hotel&amp;a=update&amp;n=<?= $myrow["id"] ?>' class='del'>
					<?= $myrow["title"] ?></a>
			</td>
			<td><strong><?= $myrow['views'] ?></strong></td>
		</tr>
	<? } while ($myrow = mysql_fetch_array($result)); ?>

</table>

<!-- <p><input type='submit' value='ok'></p> -->

<?
} else {

	echo "<h2>�������������� ���������</h2>";

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		foreach ($_POST as $kw => $val) $$kw = $val;

		$title = $hotel_title = str_replace('�', '&euro;', $title);
		$descr = str_replace('�', '&euro;', $descr);
		$descr_html = text2html($descr);
		$text = str_replace('�', '&euro;', $text);
		$text_html = text2html($text);
		$price = str_replace('�', '&euro;', $price);

		$forward = isset($_POST['forward']) ? 1 : 0;
		$active = isset($_POST['active']) ? 1 : 0;
		$tosend = isset($_POST['tosend']) ? 0 : 1;
		$open_stats = isset($_POST['open_stats']) ? 1 : 0;

		$slug = create_slug($title) . '-' . mktime();

		if ($_FILES['foto']['name'] != '') {
			require_once("blocks/foto.php");
		}

		$hotel_data = array();

		foreach ($hotel_cols as $col) {
			$hotel_data[$col] = $$col;
		}
		$hotel_data['foto'] = $foto_id;
		$hotel_data['slug'] = $slug;
		$hotel_data['tosend'] = $tosend;
		$hotel_data['open_stats'] = $open_stats;
		$hotel_data['title'] = $hotel_title;

		$hotel_data['expiration'] = $_POST['expiration'];
		$hotel_data['active'] = $active;

		// echo "<pre>";
		// print_r($hotel_data);
		// echo "</pre>";
		
		if (! $foto_id) unset($hotel_data['foto']);

		unset($hotel_data['slug']);
		foreach ($hotel_data as $kw => $val) {
			$values []= "$kw = '{$val}'";
		}

		$sql = "UPDATE hotels SET\n";
		$sql .= "\t" . implode($values, ",\n\t") . "\n\n";
		$sql .= " WHERE id = {$n}";

		$result = mysql_query($sql);

		#echo "<pre>$sql</pre>";
	
		if ($result)  {
			if (! empty($countries)) {
				$hotel_id = $n;
				mysql_query("DELETE FROM hotels_countries WHERE hotel_id = '$hotel_id'");

				$sql_c_array = array();
				foreach ($countries as $c_id) {
					$sql_c_array []= "($hotel_id, $c_id)";
				}

				$sql_c = "INSERT INTO hotels_countries (hotel_id, country_id)\n";
				$sql_c .= " VALUES " . implode($sql_c_array, ",\n");

				mysql_query($sql_c);
			}

			echo "<h4>��� �������!</h4>";
		} else  {
			echo "<h4>�� ����������!</h4>";
		}
	} else {
		$c_sql = "
			SELECT DISTINCT(c.id)
			FROM countries c, hotels h, hotels_countries r
			WHERE c.id = r.country_id AND r.hotel_id = $n
		";
		$c_res = mysql_query($c_sql);

		$countries = array();

		while ($c_row = mysql_fetch_array($c_res)) {
			$countries []= $c_row['id'];
		}
	}
		
	$result = mysql_query("SELECT * FROM hotels WHERE id='$n'",$db);
	$myrow = $hotel_row = mysql_fetch_array($result);
	
	$forward_selected = $myrow['forward'] == 1 ? "checked" : "";
	$tosend_selected = $myrow['tosend'] != 1 ? "checked" : "";
	$open_stats_selected = $myrow['open_stats'] == 1 ? "checked" : "";
	$active_selected = $myrow['active'] == 1 ? "checked" : "";
	$forward_email = $myrow['client_email'];
		
	?>

	<br>
	<form method='post' id='form' enctype='multipart/form-data' action='?t=hotel&amp;a=update&amp;n=<?= $myrow['id'] ?>'>
		<label>�������� ���������</label>
		<input type='text' name='title' value='<?= $myrow['title'] ?>'>

		<label>�����</label>
		<input type='text' name='number' value='<?= $myrow['number'] ?>'>

		<label>�����</label>
		<input type='text' name='town' value='<?= $myrow['town'] ?>'>

		<label>����</label>
		<input type='text' name='price' value='<?= $myrow['price'] ?>'>

		<label>���� (��� ��������)</label>
		<input type='text' name='price_s' value='<?= $myrow['price_s'] ?>'>

		<label>���������� �������</label>
		<input type='text' name='rooms' value='<?= $myrow['rooms'] ?>'>

		<label>������� ��������</label>
		<textarea name='descr'><?= $myrow['descr'] ?></textarea>

		<label>��������� ��������</label>
		<textarea name='text'><?= $myrow['text'] ?></textarea>

		<label>����������</label>
		<input type='file' name='foto'>

		<label>������</label>
		<select name='countries[]' multiple style="height: 150px">
		
		<?
		$result = mysql_query("SELECT * FROM countries");
		$myrow = mysql_fetch_array($result);
			do {
				$result_abc = mysql_query("SELECT country FROM hotels WHERE id='$n'");
				$myrow_abc = mysql_fetch_array($result_abc);
				echo "<option value='{$myrow['id']}'";

				if (in_array($myrow['id'], $countries)) echo "selected";

				echo ">{$myrow['title']}</option>\n";
			} while ($myrow = mysql_fetch_array($result));
		?>
		
		</select>
		<label>���������������</label>
		<select name='region'>
		
		<?
		$result = mysql_query("SELECT * FROM countries",$db);
		$myrow = mysql_fetch_array($result);
		echo "<option value='0'> ��� ������� </option>";
		$result_abc = mysql_query("SELECT region FROM hotels WHERE id='$n'",$db);
		$myrow_abc = mysql_fetch_array($result_abc);
		do {
			echo "<option disabled> --- ".$myrow['title']." --- </option>\n";
			$result2 = mysql_query("SELECT * FROM regions WHERE country='$myrow[id]'",$db);
			if (mysql_num_rows($result2) > 0) {
				$myrow2 = mysql_fetch_array($result2);
				do {
					echo "<option value=".$myrow2['id']."";
					if ($myrow2['id'] == $myrow_abc['region']) {
						echo " selected";
					}
					echo ">".$myrow2['title']."</option>\n";
				} while ($myrow2 = mysql_fetch_array($result2));
			}
		} while ($myrow = mysql_fetch_array($result));
		
	?>

		</select><br>

		<label>��������� �������</label>
		<input type='checkbox' name='forward' <?= $forward_selected ?>/><br/>

		<label>�������</label>
		<input type='checkbox' name='active' <?= $active_selected ?>/><br/>

		<label for="expiration">������� �� (��������, 2012-06-15)</label>
		<input type="text" name="expiration" value="<?= $hotel_row['expiration'] ?>" /><br>

		<label for='tosend'>������ �� ��������</label>
		<input id='tosend' type='checkbox' name='tosend' <?= $tosend_selected ?> /><br/>

		<label for="open_stats" for="open_stats">������� ����������</label>
		<input type="checkbox" name="open_stats" id="open_stats" <?= $open_stats_selected ?>>

		<label>Email ������� (����� ������ ��������� ����� �������)</label>
		<input type='text' name='client_email' value='<?= $forward_email ?>'><br/>
		<input type='submit' value='ok'>
	</form>
<? } ?>