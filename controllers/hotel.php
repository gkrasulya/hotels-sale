<?
global $h;

$sql = isset($h) ?
	"SELECT id, slug, title, user_id, views FROM hotels WHERE id='$h'" :
	"SELECT id, slug, title, user_id, views FROM hotels WHERE slug='$slug'";
$result = mysql_query($sql);

$myrow = mysql_fetch_array($result);
$page_title = $myrow['title'];

$user = get_record("SELECT * FROM users WHERE id = {$myrow['user_id']}");

$views = $myrow['views'] + 1;
mysql_query("UPDATE hotels SET views=$views WHERE id={$myrow['id']}");
?>