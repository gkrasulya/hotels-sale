<?
$ra = mysql_query("SELECT email FROM admin WHERE id='1'",$db);
$rama = mysql_fetch_array($ra);
$to = $rama['email']; //$myrow['email'];

$text_result = mysql_query("SELECT * FROM main WHERE slug='partners'");
$text = mysql_fetch_array($text_result);
?>

<h1>
	<?= $text['title'] ?>
</h1>

<p style="margin-top: 20px;">
	<?= $text['text'] ?>
</p>

<p style="margin-top: 20px;">
	<a href="/accounthelp">Тарифы на размещение предложений</a>
</p>

<p style="margin-top: 20px;">
	<img src="<?= SITE_ADDR ?>/img/adv.jpg" alt="Разместить объявление о продаже" />
</p>
