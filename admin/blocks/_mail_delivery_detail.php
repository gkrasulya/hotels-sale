<?
$delivery_id = $_GET['delivery'];
$delivery = get_record("SELECT * FROM deliveries WHERE id = $delivery_id");

$objects = get_records("SELECT id, title FROM hotels WHERE id in ($delivery->object_ids)");
$emailers = get_records("SELECT * FROM emailers
	WHERE EXISTS (SELECT * FROM deliveries_emailers
		WHERE delivery_id = $delivery->id AND emailer_id = emailers.id)");
?>

<h2>Рассылка от <?= $delivery->date_added ?></h2>

<p>
	Статус: <?= $delivery->done ? 'Завершена' : 'Не завершена' ?><br/>
	Тестовая: <?= $delivery->test ? 'Да' : 'Нет' ?><br/>
	Количество объектов: <?= count($objects) ?><br/>
	Количество отправленных писем: <?= count($emailers) ?>
</p>

<p><strong>Объекты</strong>:</p>

<ul>
	<? foreach ($objects as $object): ?>
		<li>
			<a href="/?h=<?= $object->id ?>"><?= $object->title ?></a>
		</li>
	<? endforeach; ?>
</ul>

<p><strong>Получатели</strong> (письма отправлены):</p>

<? if ($emailers): ?>
	<ul>
		<? foreach ($emailers as $emailer): ?>
			<li>
				<a href="mailto:<?= $emailer->email ?>"><?= $emailer->email ?></a>,
				<?= $emailer->name ?>
			</li>
		<? endforeach; ?>
	</ul>
<? else: ?>
	<p>Пока никто не получил письмо</p>
<? endif ?>