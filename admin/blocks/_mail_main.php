<?
$deliveries = get_records("SELECT * FROM deliveries ORDER BY id DESC");
?>

<h2>��������</h2>

<p>
	<a href='?t=mail&amp;act&amp;change_token=<?=mktime()?>'>���������</a>,
	<a href='?t=mail&amp;act&amp;test&amp;change_token=<?=mktime()?>'>����</a>
</p>

<? if ($deliveries): ?>
	<p>������ ��������:</p>

	<table>
		<thead>
			<th>����� ��������</th>
			<th>������</th>
			<th>���������� ��������</th>
			<th>�������� ��������?</th>
		</thead>
		<tbody>
			<? foreach ($deliveries as $delivery): ?>
				<tr>
					<td><a href="?t=mail&amp;delivery=<?= $delivery->id ?>"><?= $delivery->date_added ?></a></td>
					<!-- <td><?= $delivery->date_added ?></td> -->
					<td><?= $delivery->done ? '���������' : '�� ���������' ?></td>
					<td><?= count(explode(',', $delivery->object_ids)) ?></td>
					<td><?= $delivery->test ? '��' : '���' ?></td>
				</tr>	
			<? endforeach ?>
		</tbody>
	</table>
<? else: ?>
	<p>
		���� ��� ��������� ��������
	</p>
<? endif ?>