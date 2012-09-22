<h4 class="title">Страны</h4>

<ul class="side-nav">
	<?
	
	$result = mysql_query("SELECT * FROM countries ORDER BY position",$db);
	$myrow = mysql_fetch_array($result);
	
	$i = 0;
	
	do {
		$result2 = mysql_query("SELECT * FROM regions WHERE country='$myrow[id]'",$db);
		if (mysql_num_rows($result2) == 0) { ?>
			<li>
				<img src="<?= SITE_ADDR ?>new_images/flags/<?=$myrow['flag']?>" alt="<?=$myrow['title']?>" />
				<a href='<?= SITE_ADDR ?>?qwe=<?=$myrow['id']?>'><?=$myrow['title']?></a>
			</li>
		<? } else {
			$myrow2 = mysql_fetch_array($result2); ?>
			<li>
				<img src='<?= SITE_ADDR ?>new_images/flags/<?=$myrow['flag']?>'
					alt='<?=$myrow['title']?>' />
				<a href='<?= SITE_ADDR ?>?qwe=<?=$myrow['id']?>'><?=$myrow['title']?></a>
				
				<div>
				  	
					<?
					do { ?>
						<a href='<?= SITE_ADDR ?>?r=<?= $myrow2['id'] ?>'>- <?= $myrow2['title'] ?></a>
					<? } while ($myrow2 = mysql_fetch_array($result2));
					?>
				  
				</div>
			</li>
			
			<? }
		$i++;
	} while ($myrow = mysql_fetch_array($result));
	?>
</ul>