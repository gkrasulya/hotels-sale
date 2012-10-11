<?

// $s variable - is for sorting
$sql = "
	SELECT DISTINCT(h.id), h.*
	FROM hotels h, hotels_countries as r
	WHERE
		h.id = r.hotel_id
		AND r.country_id = {$qwe}
		AND (active=1 OR type='admin')
	$s LIMIT $start, $x";
// $s - ordering

$result = mysql_query($sql); ?>