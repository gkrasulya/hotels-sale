<?

if ($demand != 'send'): ?>

	<h1>������ �� ����� ���������, �����, �������, ������������ �� �������</h1>
	<p>
		���� �� �� ������� ������������ ��� ������� �� ����� ���������, �� � �������� ������� �� ��� ������ � � �������� ���� ����������� ��������� ��� ��� ������ ��� ������.
	</p>
	
	<? require_once('blocks/demand.php'); ?>
	
<? else: ?>
	 <? if (! empty($error)): ?>
		<h4 style='margin-left:50px;'>��������� ��������� ������:</h4>
		<ul class="errors">
			<li><?= implode($error, "</li>\n<li>") ?></li>
		</ul>
		<p>
			<? require_once('blocks/demand.php'); ?>
		</p>
	<? else: ?>
		<? if (isset($mail) && $mail): ?>
			<h2>������ ����������!</h2>
			<p>
				<a href='<?= SITE_ADDR ?>'>��������� �� �������</a>
			</p>
		<? else: ?>
			<h2>���-�� ����� �� ���!</h2>
			<p>
				<a href='/?main'>��������� �� �������</a>	
			</p>
		<? endif ?>
	<? endif ?>
<? endif ?>