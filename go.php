<?php
require_once("blocks/db.php");
$to = $_GET['to'];
$result = mysql_query("SELECT * FROM banners WHERE id='$to'",$db);
$banner = mysql_fetch_array($result);

$date = date("Y-m-d");
$time = date("H:i:s");

$result = mysql_query("INSERT INTO banner_clicks (banner_id,date,time) VALUES ('$to','$date','$time')",$db);

header('Location:'.$banner['href'].' ');
exit();
?>