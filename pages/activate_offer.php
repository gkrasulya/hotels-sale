<h2>������������ ����������� "<?= $acc_hotel->number ?>"</h2>

<?
require_once '_form_errors.php';
require_once '_flash.php';
?>

<p>
	�������������� ���������� � �����, � ��, ��� ��� �������� � �.�.
</p>

<form action="./?id=<?= $acc_hotel->id ?>" method="POST">
	<div class="form-row">
		<label for="">������</label>
		<select name="period" id="period">
			<? foreach ($periods as $i => $period): ?>
				<option value="<?= $i ?>" <?= $period['period'] == 'infinite' ? 'style="color: red;"' : '' ?>><?= $period['name'] ?></option>
			<? endforeach ?>
		</select>

		<p>
			* ������������ �� ������ <a href="http://cbr.ru" target="_blank">cbr.ru</a>. ������� ���� ����� <?= $euro_rate ?> ������.
		</p>

		<p>
			** ���� ����������� ����� ��������� �� �����, ���� �� ���� �� ������� ���.
		</p>
	</div>

	<div class="form-row">
		<button type="submit">������������</button>
	</div>
</form>