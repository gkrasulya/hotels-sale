<?

$region_result = mysql_query("SELECT * FROM regions WHERE id = $r");
$region = mysql_fetch_array($region_result);

$head_title = $region['head_title'];
$meta_description = $region['meta_description'];
$meta_keywords = $region['meta_keywords'];

?>