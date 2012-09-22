<h2>Список подписчиков</h2>

<ul style='margin-left:30px; list-style: decimal;'>

	<? foreach ($emailers as $emailer): ?>
		<li>
			<?= $emailer->name ?>
			<a href="mailto:<?= $emailer->email ?>"><?= $emailer->email ?></a>
		</li>
	<? endforeach; ?>

</ul>