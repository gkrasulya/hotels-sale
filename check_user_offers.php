<?

require_once 'blocks/db.php';
require_once 'blocks/functions.php';

$offers = get_records("
	SELECT *
	FROM hotels
	WHERE
		type = 'user'
		AND infinite = 0
		AND expiration < NOW()");

$deactive_offers_ids = array();
foreach ($offers as $offer) {
	$deactive_offers_ids []= $offer->id;
}

$deactive_offers_ids = implode(',', $deactive_offers_ids);
$deactive_sql = "
	UPDATE hotels
	SET active = 0
	WHERE id IN ($deactive_offers_ids)
";
mysql_query($deactive_sql);

?>