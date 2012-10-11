<?

$sql = "
	SELECT DISTINCT(h.id), h.*
	FROM hotels h, hotels_regions as hr
	WHERE
		h.id = hr.hotel_id
		AND hr.region_id = {$r} $s
		AND (active=1 OR type='admin')
	LIMIT $start, $x
";

$result = mysql_query($sql);

if (mysql_num_rows($result) > 0) {
	$result_r = mysql_query("SELECT title,country FROM regions WHERE id='$r'",$db);
	$myrow_r = mysql_fetch_array($result_r);
	
	$result_c = mysql_query("SELECT title FROM countries WHERE id='$myrow_r[country]'",$db);
	$myrow_c = mysql_fetch_array($result_c); ?>