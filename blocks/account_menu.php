<small><?= $user->email ?></small>

<div class="account-menu">
	<a href="<?= SITE_ADDR ?>account/" title="������ �������">������ �������</a>
	<a href="<?= SITE_ADDR ?>add_offer/" title="�������� �����������">�������� �����������</a>
	<? if (! is_agency()): ?>
		<a href="<?= SITE_ADDR ?>update_amount/" title="��������� ����">��������� ����</a>
		<a href="<?= SITE_ADDR ?>accounthelp/" title="������">������</a>
	<? else: ?>
		<a href="<?= SITE_ADDR ?>update_account/" title="�������� �������">�������� �������</a>
	<? endif ?>
	<a href="<?= SITE_ADDR ?>support/">�������� �����</a>
	<a href="<?= SITE_ADDR ?>change_password/" title="�������� ������">�������� ������</a>
	<a href="<?= SITE_ADDR ?>logout/" title="�����">�����</a>
</div>

<?
if ($user->type == 'agency') {
	$day_in_seconds = 60 * 60 * 24;
	$expires_time = strtotime($user->expiration_date);
	$today_time = strtotime(date('Y-m-d'));

	$days_to_expiration = floor(($expires_time - $today_time) / $day_in_seconds);
}

if ($days_to_expiration < 6 && $days_to_expiration > -1) {
	$message = $days_to_expiration == 0 ? '������� �������� ��� �������. ���������� � �������������� ����� ��� ���������' :
		'��� ������� ��������. �������� ����: ' . $days_to_expiration;
	echo '<div class="flash errors">' . $message . '</div>';
}

if (is_agency() && ! $user->active) {
	echo '<div class="flash errors">��� ������� ���������. ���������� � �������������� ����� ��� ���������</div>';
}

?>
