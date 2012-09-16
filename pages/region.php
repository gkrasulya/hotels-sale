<?
$sql = "
	SELECT h.*
	FROM hotels h
	WHERE
		region='$r'
		AND (active=1 OR type='admin' OR type='')
	$s LIMIT $start, $x";
// $s - ordering

$result = mysql_query($sql);


	// WHERE 
if (! $result) {
	echo mysql_error();
}
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
		$photo = get_record("SELECT * FROM fotos WHERE id='$myrow[foto]'");
		if ($myrow['rooms'] != 0) { $show_rooms = "<span class='add'>номеров: <strong>".$myrow['rooms']."</strong></span>"; } else { $show_rooms = ''; }
		?>
		
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
						<?=$show_rooms?>
						
						<span class='add'>цена: <strong><?=$myrow['price']?></strong></span>
					</p>
					<div class='text'><?=$myrow['descr_html'] ? $myrow['descr_html'] : $myrow['descr']?></div>
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