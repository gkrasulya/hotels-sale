<h2>������</h2>

<p>
	<strong>������ �� ���������� ����������� �� �����:</strong>
</p>

<? foreach ($periods as $i => $period): ?>
	<p>
		<strong <?= $period['period'] == 'infinite' ? 'style="color: red;"' : '' ?>><?= $period['name'] ?></strong>
		(<a href="<?= SITE_ADDR ?>update_amount/?sum=<?= $period['price'] ?>">��������� ����</a>)
	</p>
<? endforeach ?>

<p>
	* ������������ �� ������ <a href="http://cbr.ru" target="_blank">cbr.ru</a>. ������� ���� ����� <?= $euro_rate ?> ������.
</p>
<p>
	** ���� ����������� ����� ��������� �� �����, ���� �� ���� �� ������� ���.
</p>
<br/>
<p>
	���� �� ������ �������� ����� ��������� ������� Webmoney, �� ������ �������� �� ��� �������� ������� R141042007100 � �������� ��� �� ������ � ������� <a href="<?= SITE_ADDR ?>support/">�������� �����</a>
</p>