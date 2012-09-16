<?
global $h;

$sql = isset($h) ?
	"SELECT id, slug, title FROM hotels WHERE id='$h'" :
	"SELECT id, slug, title FROM hotels WHERE slug='$slug'";
$result = mysql_query($sql);

$myrow = mysql_fetch_array($result);
$page_title = $myrow['title'];

$user = get_record("SELECT * FROM users WHERE id = {$myrow[user_id]}");