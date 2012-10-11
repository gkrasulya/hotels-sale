<?

$sql = "
	SELECT DISTINCT(h.id), h.*
	FROM hotels h, hotels_regions as hr
	WHERE
		h.id = hr.hotel_id AND hr.region_id = {$r}
		AND (active=1 OR type='admin')
		$s
	LIMIT $start, $x
";

$result = mysql_query($sql);

if (mysql_num_rows($result) > 0) {
	$result_r = mysql_query("SELECT title,country FROM regions WHERE id='$r'",$db);
	$myrow_r = mysql_fetch_array($result_r);
	
	$result_c = mysql_query("SELECT title FROM countries WHERE id='$myrow_r[country]'",$db);
	$myrow_c = mysql_fetch_array($result_c); ?>
	
	<h1>
		<?=$myrow_c['title']?>, <?=$myrow_r['title']?>
	</h1>
	
	<span id='sorting'>
		<span>сортировать по: </span>
		<a href='/?r=<?=$r?>&amp;s=town&amp;page=<?=$page?>'>городам</a> <span>/</span>
		<a href='/?r=<?=$r?>&amp;s=price&amp;page=<?=$page?>'>стоимости</a>
	</span>
	
	<?
	$myrow = mysql_fetch_array($result);
	
	do {
		$result_img = mysql_query("SELECT img_pre FROM fotos WHERE id='$myrow[foto]'",$db);
		$myrow_img = mysql_fetch_array($result_img);
		if ($myrow['rooms'] != 0) { $show_rooms = "<span class='add'>номеров: <strong>".$myrow['rooms']."</strong></span>"; } else { $show_rooms = ''; }
		?>
		
		<table class='offer'>
			<tr>
				<td valign='top' width='200'>
					<a href='/show/<?=$myrow['slug']?>.html' class='img'>
						<img src='/fotos/<?=$myrow_img['img_pre']?>' alt='<?=$myrow['title']?>' />
					</a>
				</td>
				<td>
					<p class='info'>
						<span class='number'><?=$myrow['number']?></span>
						<span class='title'><?=$myrow['title']?></span>
						<?=$show_rooms?>
						
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
	<h2>Простите, но в этом разделе гостиниц  нет!</h2>
<? } ?>
