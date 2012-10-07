<?

if ($demand != 'send'): ?>

	<h1>Заявка на поиск гостиницы, отеля, бизнеса, недвижимости за рубежом</h1>
	<p>
		Если Вы не найдете необходимого Вам объекта по Вашим критериям, мы с радостью получим от Вас запрос и в короткий срок постараемся подобрать для Вас нужный Вам объект.
	</p>
	
	<? require_once('blocks/demand.php'); ?>
	
<? else: ?>
	 <? if (! empty($error)): ?>
		<h4 style='margin-left:50px;'>Исправьте следующие ошибки:</h4>
		<ul class="errors">
			<li><?= implode($error, "</li>\n<li>") ?></li>
		</ul>
		<p>
			<? require_once('blocks/demand.php'); ?>
		</p>
	<? else: ?>
		<? if (isset($mail) && $mail): ?>
			<h2>Письмо отправлено!</h2>
			<p>
				<a href='<?= SITE_ADDR ?>'>Вернуться на главную</a>
			</p>
		<? else: ?>
			<h2>Что-то пошло не так!</h2>
			<p>
				<a href='/?main'>Вернуться на главную</a>	
			</p>
		<? endif ?>
	<? endif ?>
<? endif ?>