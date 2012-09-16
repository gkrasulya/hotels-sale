<?php
	$resultR = mysql_query("SELECT * FROM random",$db);
	$myrowR = mysql_fetch_array($resultR);
	if ($myrowR['levoe'] == '1') { ?>
		<div id='offers'><h4>Интересные предложения</h4>
		<? if ($myrowR['random'] == 1) {
			$nnn = $myrowR['number'];
			$result = mysql_query("SELECT * FROM hotels ORDER BY RAND() LIMIT ".$nnn." ",$db);
			$myrow = mysql_fetch_array($result);
			
			do {
				$result_img = mysql_query("SELECT img_pre FROM fotos WHERE id='$myrow[foto]'",$db);
				$myrow_img = mysql_fetch_array($result_img);
				$photo = get_record("SELECT * FROM fotos WHERE id='$myrow[foto]'");
				
				if ($myrow['rooms'] != '0') { $show_rooms = "<span class='info'>номеров: ".$myrow['rooms']."</span>"; } else { $show_rooms = ''; } 
				?>
				
				<div>
					<a href='/show/<?=$myrow['slug']?>.html' class='img'>
						<img src='<?= SITE_ADDR ?>image.php?image=<?= SITE_ADDR ?>fotos/<?=$photo->img_big?>&amp;width=<?= PRE_IMG_WIDTH ?>' alt='<?=$myrow['title']?>' />
					</a>
					
					<span class='title'><?=$myrow['title']?></span>
					<?=$show_rooms?>
					
					<span class='info'>цена: <?=$myrow['price']?></span>
					<p>
						<a href='/show/<?=$myrow['slug']?>.html'>подробнее</a> /
						<a href='/?form=new&amp;number=<?=$myrow['number']?>'>сделать заявку</a>
					</p>
				</div>
				
		<?	} while ($myrow = mysql_fetch_array($result));
		} else {
			$arr = explode(',',$myrowR['hotels']);
			shuffle($arr);
			if ($myrowR['third'] == 1) { $o = "ORDER BY RAND()"; } else { $o = "";}
			
			for ($i=0; $i<count($arr); $i++) {
				$aaa = rand(3);
				echo $aaa;
				$result = mysql_query("SELECT * FROM hotels WHERE id='$arr[$i]' ORDER BY RAND() ",$db);
				$myrow = mysql_fetch_array($result);
				$result_img = mysql_query("SELECT img_pre FROM fotos WHERE id='$myrow[foto]'",$db);
				$myrow_img = mysql_fetch_array($result_img);	
				if ($myrow['rooms'] != '0') {
					$show_rooms = "<span class='info'>номеров: ".$myrow['rooms']."</span>";
				} else {
					$show_rooms = '';
				} ?>
				
				<div>
					<a href='/show/<?=$myrow['slug']?>.html' class='img'>
						<img src='/fotos/<?=$myrow_img['img_pre']?>' alt='<?=$myrow['title']?>' />
					</a>
					<span class='title'><?=$myrow['title']?></span>
					<?=$show_rooms?>
					
					<span class='info'>цена: <?=$myrow['price']?></span>
					<p>
						<a href='/show/<?=$myrow['slug']?>.html'>подробнее</a> /
						<a href='/?form=new&amp;number=<?=$myrow['number']?>'>сделать заявку</a>
					</p>
				</div>
				
			<? }
		}
		echo "</div>";
	}
?>