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

$result = mysql_query($sql); ?>