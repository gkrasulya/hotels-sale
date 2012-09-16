<?

$countries = $_GET['countries'];
$min_price = $_GET['min_price'];
$max_price = $_GET['max_price'];
$min_rooms = $_GET['min_rooms'];
$max_rooms = $_GET['max_rooms'];

error_reporting(E_ALL);

$where_arr = array();

if (! $countries) {
} else {

	$where_arr []= "r.hotel_id = h.id";
	$where_arr []= "r.country_id IN (" . implode($countries, ',') . ")";
}

if ($min_price) $where_arr []= "h.price_s >= $min_price";
if ($max_price) $where_arr []= "h.price_s <= $max_price";

$where = $where_arr ?
	"WHERE (active=1 OR type='admin' OR type='') AND \n" . implode($where_arr, " AND \n") :
	'WHERE (active=1 OR type=\'admin\' OR type=\'\')';

if (! $countries) {
	$count_sql = "
		SELECT h.id
		FROM hotels h
		$where
	";
	$sql = "
		SELECT h.*
		FROM hotels h
		$where
		LIMIT $start, $x
	";
} else {
	$count_sql = "
		SELECT h.id
		FROM hotels h, hotels_countries r
		$where
	";
	$sql = "
		SELECT h.*
		FROM hotels h, hotels_countries r
		$where
		LIMIT $start, $x
	";
}

$result = mysql_query($sql);
echo mysql_error();	

if (mysql_num_rows($result) > 0) { ?>
	
	<h1>Результаты поиска</h1>
	
	<?
	$myrow = mysql_fetch_array($result);
		
	do 	{
		$result_img = mysql_query("SELECT img_pre FROM fotos WHERE id='$myrow[foto]'",$db);
		$myrow_img = mysql_fetch_array($result_img);
		$photo = get_record("SELECT * FROM fotos WHERE id='$myrow[foto]'");
		if ($myrow['rooms'] != 0) { $show_rooms = "<spa class='add'>номеров: <strong>".$myrow['rooms']."</strong></span>"; } else { $show_rooms = ''; } ?>
		
		<table class='offer'>
			<tr>
				<td valign='top' width='200'>
					<a href='/show/<?=$myrow['slug']?>.html' class='img'>
						<img src='<?= SITE_ADDR ?>image.php?image=<?= SITE_ADDR ?>fotos/<?=$photo->img_big?>&amp;width=<?= PRE_IMG_WIDTH ?>' alt='<?=$myrow['title']?>' /></a>
					</a>
				</td>
				<td>
					<p class='info'>
						<span class='number'><?=$myrow['number']?></span>
						<span class='title'><?=$myrow['title']?></span>
						<?/*<?=$show_rooms?>*/?>
						
						<span class='add'>цена: <strong><?=$myrow['price']?></strong></span>
					</p>
					<p class='text'><?=$myrow['descr']?></p>
					<span class='links'>
						<a href='/show/<?=$myrow['slug']?>.html'>подробнее</a> <span>/</span>
						<a href='/?form=new&amp;number=<?=$myrow['number']?>'>сделать заявку</a>
					</span>
				</td>
			</tr>
		</table>
		
		
<? } while ($myrow = mysql_fetch_array($result));
	require_once("blocks/pages.php");
	
} else { ?>
	<h2>Простите, но ничего не найдено</h2>
<? } ?>