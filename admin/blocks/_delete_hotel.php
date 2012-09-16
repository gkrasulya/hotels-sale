<h2>Удаление Гостиницы</h2>

<?
if (isset($do)) {
	$result = mysql_query("SELECT foto FROM hotels WHERE id='$do'",$db);
	$myrow = mysql_fetch_array($result);
	$id = $myrow['foto'];
	$result_foto = mysql_query("SELECT * FROM fotos WHERE id='$id'",$db);
	$myrow_foto = mysql_fetch_array($result_foto);

	if (file_exists("../fotos/".$myrow_foto['img_pre']) && file_exists("../fotos/".$myrow_foto['img_big'])) {
		$a = @unlink("../fotos/".$myrow_foto['img_pre']);
		$b = @unlink("../fotos/".$myrow_foto['img_big']);
	}
	mysql_query("DELETE FROM fotos WHERE id='$id'");

	mysql_query("DELETE FROM hotels_countries WHERE hotel_id='$do'");
	$result = mysql_query("DELETE FROM hotels WHERE id='$do'");
	
	if ($result)  {
		echo "<h4>Все сделано!</h4>";
	} else {
		echo "<h4>Не получилось!</h4>";
	}
}

$result = mysql_query("SELECT id, title, number FROM hotels ORDER BY id DESC");
$myrow = mysql_fetch_array($result);

echo "<br>
	<label>Нажмите на гостиницу, чтобы ее удалить</label><br><br>";
	
do {
	echo "<a href='?t=hotel&a=delete&do=$myrow[id]' onClick=\"return (confirm('Вы уверены?'))\" class='del'>
		$myrow[number] - $myrow[title]</a><br>";
		
} while ($myrow = mysql_fetch_array($result));