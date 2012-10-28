<h2>Удаление региона</h2>

<?
if (isset($do)) {
	$result = mysql_query("DELETE FROM regions WHERE id='$do'");
	
	if ($result)  {
		echo "<h4>Все сделано!</h4>";
	} else {
		echo "<h4 class='error'>Не получилось!</h4>";
	}
}
$result = mysql_query("SELECT * FROM regions",$db);
$myrow = mysql_fetch_array($result);

?>

<p>
	<label>Нажмите на регион, чтобы его удалить:</label>
</p>
	
<ul class="choice-list">
	<? do { ?>
		<li><a href='#' onclick="if(confirm('are you sure?')) {location.href='?t=region&amp;a=delete&amp;do=<?= $myrow['id'] ?>'}" class='del'>
			<?= $myrow['title'] ?></a></li>
	<? } while ($myrow = mysql_fetch_array($result)); ?>
</ul>