<?
global $h;

$sql = isset($h) ?
	"SELECT * FROM hotels WHERE id='$h'" :
	"SELECT * FROM hotels WHERE slug='$slug'";
$result = mysql_query($sql);
$hotel = $myrow = mysql_fetch_array($result);
$page_title = $myrow['title'];

$user = get_record("SELECT * FROM users WHERE id = {$myrow['user_id']}");

// $from_country = isset($_GET['from_country']) ? $_GET['from_country'] : null;
// $from_region = isset($_GET['from_region']) ? $_GET['from_region'] : null;

$head_title = $hotel['head_title'];
$meta_description = $hotel['meta_description'];
$meta_keywords = $hotel['meta_keywords'];

$category_record = get_record("
	SELECT c.*
	FROM hotels_countries as hc, countries as c
	WHERE c.id = hc.country_id AND hc.hotel_id = {$hotel['id']}
	LIMIT 1");
$head_title = $head_title ? $head_title : $category_record->head_title;
$meta_keywords = $meta_keywords ? $meta_keywords : $category_record->meta_keywords;
$meta_description = $meta_description ? $meta_description : $category_record->meta_description;

$views = $myrow['views'] + 1;
mysql_query("UPDATE hotels SET views=$views WHERE id={$myrow['id']}");


?>