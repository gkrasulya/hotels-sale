<h2>Тарифы</h2>

<p>
	<strong>Тарифы на размещение предложений на сайте:</strong>
</p>

<? foreach ($periods as $i => $period): ?>
	<p>
		<strong <?= $period['period'] == 'infinite' ? 'style="color: red;"' : '' ?>><?= $period['name'] ?></strong>
		(<a href="<?= SITE_ADDR ?>update_amount/?sum=<?= $period['price'] ?>">пополнить счет</a>)
	</p>
<? endforeach ?>

<p>
	* Определяется по данным <a href="http://cbr.ru" target="_blank">cbr.ru</a>. Сегодня евро стоит <?= $euro_rate ?> рублей.
</p>
<p>
	** Ваше предложение будет размещено на сайте, пока Вы сами не удалите его.
</p>
<br/>
<p>
	Если Вы хотите оплатить через платежную систему Webmoney, Вы можете оплатить на наш рублевый кошелек R141042007100 и сообщить нам об оплате в разделе <a href="<?= SITE_ADDR ?>support/">Обратная связь</a>
</p>