	
	<h1>
		<?=$myrow_c['title']?>
	</h1>
	
	<span id='sorting'>
		<span>����������� ��: </span>
		<a href='/?qwe=<?=$qwe?>&amp;s=town&amp;page=<?=$page?>'>�������</a> <span>/</span>
		<a href='/?qwe=<?=$qwe?>&amp;s=price&amp;page=<?=$page?>'>���������</a>
	</span>
	
	<?
	$myrow = mysql_fetch_array($result);
	
	do {
		$result_img = mysql_query("SELECT img_pre FROM fotos WHERE id='$myrow[foto]'",$db);
		$myrow_img = mysql_fetch_array($result_img);
		$photo = get_record("SELECT * FROM fotos WHERE id='$myrow[foto]'");
		if ($myrow['rooms'] != 0) { $show_rooms = "<span class='add'>�������: <strong>".$myrow['rooms']."</strong></span>"; } else { $show_rooms = ''; } ?>
		
		<table class='offer'>
			<tr>
				<td valign='top' width='200'>
					<a href='<?= SITE_ADDR ?>show/<?=$myrow['slug']?>.html' class='img'>
						<img src='<?= SITE_ADDR ?>image.php?image=<?= SITE_ADDR ?>fotos/<?=$photo->img_big?>&amp;width=<?= PRE_IMG_WIDTH ?>' alt='<?=$myrow['title']?>' /></a>
				</td>
				<td>
					<p class='info'>
						<span class='number'><?=$myrow['number']?></span>
						<span class='title'><?=$myrow['title']?></span>
						<?=$show_rooms?>
						
						<span class='add'>����: <strong><?=$myrow['price']?></strong></span>
					</p>
					<div class='text'><?=$myrow['descr_html'] ? $myrow['descr_html'] : $myrow['descr']?></div>
					<span class='links'>
						<a href='/show/<?=$myrow['slug']?>.html'>���������</a> <span>/</span>
						<a href='/?form=new&amp;number=<?=$myrow['number']?>'>������� ������</a>
					</span>
				</td>
			</tr>
		</table>
		
		
		<? } while ($myrow = mysql_fetch_array($result));
		require_once("blocks/pages.php");
		
} else { ?>
	<h2>��������, �� � ���� ������� ��� �����������</h2>
<? } ?>