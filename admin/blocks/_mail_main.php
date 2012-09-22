<?
$deliveries = get_records("SELECT * FROM deliveries ORDER BY id DESC");
?>

<h2>Рассылка</h2>

<p>
	<a href='?t=mail&amp;act&amp;change_token=<?=mktime()?>'>Разослать</a>,
	<a href='?t=mail&amp;act&amp;test&amp;change_token=<?=mktime()?>'>Тест</a>
</p>

<? if ($deliveries): ?>
	<p>Список рассылок:</p>

	<table>
		<thead>
			<th>Время создания</th>
			<th>Статус</th>
			<th>Количество объектов</th>
			<th>Тестовая рассылка?</th>
		</thead>
		<tbody>
			<? foreach ($deliveries as $delivery): ?>
				<tr>
					<td><a href="?t=mail&amp;delivery=<?= $delivery->id ?>"><?= $delivery->date_added ?></a></td>
					<!-- <td><?= $delivery->date_added ?></td> -->
					<td><?= $delivery->done ? 'Завершена' : 'Не завершена' ?></td>
					<td><?= count(explode(',', $delivery->object_ids)) ?></td>
					<td><?= $delivery->test ? 'Да' : 'Нет' ?></td>
				</tr>	
			<? endforeach ?>
		</tbody>
	</table>
<? else: ?>
	<p>
		Пока нет созданных рассылок
	</p>
<? endif ?>