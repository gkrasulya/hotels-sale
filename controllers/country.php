<?

$country_result = mysql_query("SELECT * FROM countries WHERE id = $qwe");
$country = mysql_fetch_array($country_result);

$head_title = $country['head_title'];
$meta_description = $country['meta_description'];
$meta_keywords = $country['meta_keywords'];