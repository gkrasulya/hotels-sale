<?

$sql = isset($h) ?
	"SELECT * FROM hotels WHERE id='$h'" :
	"SELECT * FROM hotels WHERE slug='$slug'";
$result = mysql_query($sql);

$myrow = mysql_fetch_array($result);
$text = str_replace("\n","</p><p>",$myrow['text']);

$result_img = mysql_query("SELECT img_big FROM fotos WHERE id='$myrow[foto]'",$db);
$myrow_img = mysql_fetch_array($result_img);

$result_mail = mysql_query("SELECT email FROM admin",$db);
$myrow_mail = mysql_fetch_array($result_mail);

$hotel_user = get_record("SELECT * FROM users WHERE id = {$myrow[user_id]}");
?>

<h1>
	<?=$myrow['title']?>
</h1>
<p style="color: #666; font-size: 11px;">
	короткий адрес страницы: <a href="/?h=<?=$myrow['id']?>"><?= SITE_ADDR ?>?h=<?=$myrow['id']?></a>
</p>
<span id='sorting' style='width: 50px; float: right; position: relative; text-align: right;'>
	<a href='#' id="printLink">
		<img src='/print.png' />
	</a>
	<div style="clear: both">&nbsp;</div> 
</span>
<div style="clear: both">&nbsp;</div>
<script type="text/javascript">
	(function() {
		document.getElementById('printLink').onclick = function() {
			setTimeout(function() {
				window.print();
			}, 10);
		};
	})();
</script>

<img src='<?= SITE_ADDR ?>img.php?src=fotos/<?=$myrow_img['img_big']?>' style="width: 50%" alt='<?=$myrow['title']?>' id='hotelImage' />

<div style='width: 100%;'>
	<?=$myrow['text_html'] ? $myrow['text_html'] :	'<p>' . nl2br($myrow['text']) . '</p>'; ?>

	<? if ($myrow['type'] == 'user' || $myrow['type'] == 'agency'): ?>
		<p>Стоимость: <strong><?= $myrow['price'] ?></strong></p>
	<? endif ?>
</div>

<?		
$photos = get_records("SELECT * FROM add_fotos WHERE hotel_id=$myrow[id]");		
if ($photos) { ?>
	<ul class='gallery' title='<?=$myrow['title']?>' id='gallery'>
		<?php foreach ($photos as $photo): ?>
			<li>
				<a href='<?= SITE_ADDR ?>add_fotos/<?= $myrow['id'] ?>/<?= $photo->big ?>' onclick='showImg(this); return false;'>
					<img src='<?= SITE_ADDR ?>image.php?image=<?= SITE_ADDR ?>add_fotos/<?= $myrow['id'] ?>/<?= $photo->big ?>&amp;width=100&amp;height=100&amp;cropration=1:1'/>
				</a>
				<div style='width:110px;height:5px;position:absolute;bottom:0px;left:0px;background:white;'>&nbsp;</div>
			</li>
		<?php endforeach ?>
		<div style='clear:both;'>&nbsp;</div>
	</ul>
<? } ?>

<p id='contact_mail'>
	<a href='/?form=new&amp;number=<?=$myrow['number']?>' id='formButton'
		onclick="jQuery('#form_div').slideToggle(); return false;">Отправить заявку
	</a>
</p>

<div>
	<div class='hotelBoxTitle'></div>
	<div style='clear:both;'></div>
</div>

<? require_once "blocks/form.php" ?>