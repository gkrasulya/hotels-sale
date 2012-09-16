<?
$ra = mysql_query("SELECT email FROM admin WHERE id='1'",$db);
$rama = mysql_fetch_array($ra);
$to = $rama['email']; //$myrow['email'];
?>

<style type="text/css">
	.sitemap {
		line-height: 125%;
		margin: 20px; }
		
		.sitemap ul {
			line-height: 125%;
			margin-left: 10px; }
</style>

<h1>
	Карта сайта
</h1>

<ul class="sitemap">
	<li>
		<a href="/" title="Главная">Главная</a>
	</li>
	<li>
		<a href="/?about" title="О компании">О компании</a>
	</li>
	<li>
		<a href="/?new" title="Новые предложения">Новые предложения</a>
	</li>
	<li>
		Предложения по странам:
		
		<ul>
			<? while ($country = mysql_fetch_array($sm_countries_result)): ?>
				<li>
					<a href="<?= SITE_ADDR ?>?qwe=<?= $country['id'] ?>" title="<?= $country['title'] ?>">
						<?= $country['title'] ?></a>
				</li>
			<? endwhile ?>
		</ul>
	</li>
	<li>
		<a href="/?qwe=52" title="Продажа островов">Продажа островов</a>
	</li>
	<li>
		<a href="/?qwe=48" title="Гражданство, вид на жительство">Гражданство, вид на жительство</a>
	</li>
	<li>
		<a href="/?qwe=50" title="Пожизненная рента">Пожизненная рента</a>
	</li>
	<li>
		<a href="/?demand" title="Сделать заявку">Сделать заявку</a>
	</li>
	<li>
		<a href="/?adv" title="Разместить объявление о продаже">Разместить объявление о продаже</a>
	</li>
</ul>
<p style="margin-top: 20px;">
	Если Вы хотите дать объявление о продаже объекта на нашем сайте, также по вопросам размещения рекламы пишите на <a href="mailto:<?= $to ?>" title="<?= $to ?>"><?= $to ?></a>
</p>