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
	����� �����
</h1>

<ul class="sitemap">
	<li>
		<a href="/" title="�������">�������</a>
	</li>
	<li>
		<a href="/?about" title="� ��������">� ��������</a>
	</li>
	<li>
		<a href="/?new" title="����� �����������">����� �����������</a>
	</li>
	<li>
		����������� �� �������:
		
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
		<a href="/?qwe=52" title="������� ��������">������� ��������</a>
	</li>
	<li>
		<a href="/?qwe=48" title="�����������, ��� �� ����������">�����������, ��� �� ����������</a>
	</li>
	<li>
		<a href="/?qwe=50" title="����������� �����">����������� �����</a>
	</li>
	<li>
		<a href="/?demand" title="������� ������">������� ������</a>
	</li>
	<li>
		<a href="/?adv" title="���������� ���������� � �������">���������� ���������� � �������</a>
	</li>
</ul>
<p style="margin-top: 20px;">
	���� �� ������ ���� ���������� � ������� ������� �� ����� �����, ����� �� �������� ���������� ������� ������ �� <a href="mailto:<?= $to ?>" title="<?= $to ?>"><?= $to ?></a>
</p>