<?


$sql = "
	SELECT DISTINCT(h.id), h.*
	FROM hotels h, hotels_regions as hr
	WHERE
		h.id = hr.hotel_id
		AND hr.region_id = {$r}
		AND (active=1 OR type='admin')
		$s
		LIMIT $start, $x";

$result = mysql_query($sql);

if (mysql_num_rows($result) > 0) {	
	$result_c = mysql_query("SELECT title FROM countries WHERE id='$region[country]'",$db);
	$myrow_c = mysql_fetch_array($result_c); ?>
	
	<h1>
		<?=$myrow_c['title']?>, <?=$region['title']?>
	</h1>
	
	<span id='sorting'>
		<span>����������� ��: </span>
		<a href='/?r=<?=$r?>&amp;s=town&amp;page=<?=$page?>'>�������</a> <span>/</span>
		<a href='/?r=<?=$r?>&amp;s=price&amp;page=<?=$page?>'>���������</a>
	</span>
	
	<?
	$myrow = mysql_fetch_array($result);
	
	do {
		$result_img = mysql_query("SELECT img_pre FROM fotos WHERE id='$myrow[foto]'",$db);
		$myrow_img = mysql_fetch_array($result_img);
		if ($myrow['rooms'] != 0) { $show_rooms = "<span class='add'>�������: <strong>".$myrow['rooms']."</strong></span>"; } else { $show_rooms = ''; }
		?>
		
		<table class='offer'>
			<tr>
				<td valign='top' width='200'>
					<a href='<?= SITE_ADDR ?>/show/<?=$myrow['slug']?>.html?from_region=<?= $region['id'] ?>' class='img'>
						<img src='/fotos/<?=$myrow_img['img_pre']?>' alt='<?=$myrow['title']?>' />
					</a>
				</td>
				<td>
					<p class='info'>
						<span class='number'><?=$myrow['number']?></span>
						<span class='title'><?=$myrow['title']?></span>
						<?=$show_rooms?>
						
						<span class='add'>����: <strong><?=$myrow['price']?></strong></span>
					</p>
					<div class='text'><?=nl2br($myrow['descr'])?></div>
					<span class='links'>
						<a href='<?= SITE_ADDR ?>/show/<?=$myrow['slug']?>.html?from_region=<?= $region['id'] ?>'>���������</a> <span>/</span>
						<a href='/?form=new&amp;number=<?=$myrow['number']?>'>������� ������</a>
					</span>
				</td>
			</tr>
		</table>
				
		<? } while ($myrow = mysql_fetch_array($result));
		require_once("blocks/pages.php");
		
} else { ?>
	<h2>��������, �� � ���� ������� ��������  ���!</h2>
<? } ?>
