<?
$result = mysql_query("SELECT * FROM main",$db);
$myrow = mysql_fetch_array($result);
$text = str_replace("\n","</p><p>",$myrow['text']);
?>

<h1>
	<?=$myrow['title']?>
</h1>

<p style='margin-top: 20px;'>
	<?=$text?>
</p>