<small><?= $user->email ?></small>

<div class="account-menu">
	<a href="<?= SITE_ADDR ?>account/" title="������ �������">������ �������</a>
	<a href="<?= SITE_ADDR ?>add_offer/" title="�������� �����������">�������� �����������</a>
	<? if (! is_agency): ?>
		<a href="<?= SITE_ADDR ?>update_amount/" title="��������� ����">��������� ����</a>
		<a href="<?= SITE_ADDR ?>accounthelp/" title="������">������</a>
	<? endif ?>
	<a href="<?= SITE_ADDR ?>support/">�������� �����</a>
	<a href="<?= SITE_ADDR ?>change_password/" title="�������� ������">�������� ������</a>
	<a href="<?= SITE_ADDR ?>logout/" title="�����">�����</a>
</div>