<?

require_once 'blocks/db.php';

$res_h = mysql_query("SELECT id, country FROM hotels ORDER BY country");

$sql_c_array = array();
$sql_c = "INSERT INTO hotels_countries (hotel_id, country_id) VALUES ";

while ($h = mysql_fetch_array($res_h)) {
	$sql_c_array []= "($h[id], $h[country])";
}

$sql_c .= implode($sql_c_array, ', ');

mysql_query($sql_c);
echo mysql_error();

echo "<pre>$sql_c</pre>";