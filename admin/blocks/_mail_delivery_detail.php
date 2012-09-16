<?
$delivery_id = $_GET['delivery'];
$delivery = get_record("SELECT * FROM deliveries WHERE id = $delivery_id");

$objects = get_records("SELECT id, title FROM hotels WHERE id in ($delivery->object_ids)");
$emailers = get_records("SELECT * FROM emailers
	WHERE EXISTS (SELECT * FROM deliveries_emailers
		WHERE delivery_id = $delivery->id AND emailer_id = emailers.id)");
?>

<h2>�������� �� <?= $delivery->date_added ?></h2>

<p>
	������: <?= $delivery->done ? '���������' : '�� ���������' ?><br/>
	��������: <?= $delivery->test ? '��' : '���' ?><br/>
	���������� ��������: <?= count($objects) ?><br/>
	���������� ������������ �����: <?= count($emailers) ?>
</p>

<p><strong>�������</strong>:</p>

<ul>
	<? foreach ($objects as $object): ?>
		<li>
			<a href="/?h=<?= $object->id ?>"><?= $object->title ?></a>
		</li>
	<? endforeach; ?>
</ul>

<p><strong>����������</strong> (������ ����������):</p>

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
	<p>���� ����� �� ������� ������</p>
<? endif ?>