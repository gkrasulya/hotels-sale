<h2>�������� ������</h2>

<?
if (isset($do)) {
	$result = mysql_query("DELETE FROM countries WHERE id='$do'",$db);
	mysql_query("DELETE FROM regions WHERE country='$do'",$db);
	
	if ($result)  {
		echo "<h4>��� �������!</h4>";
	} else  {
		echo "<h4>�� ����������!</h4>";
	}
}
$result = mysql_query("SELECT * FROM countries");
$myrow = mysql_fetch_array($result);

?>

<p>
	<label>������� �� ������, ����� �� �������</label>
</p>
	
<ul class="choice-list">
	<? do { ?>
		<li><a href='#' onclick="if(confirm('are you sure?')) {location.href='?t=country&amp;a=delete&amp;do=<?= $myrow['id'] ?>'}" class='del'>
			<?= $myrow['title'] ?></a></li>
	<? } while ($myrow = mysql_fetch_array($result)); ?>
</ul>