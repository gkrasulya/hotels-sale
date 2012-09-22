<h2>Активировать предложение "<?= $acc_hotel->number ?>"</h2>

<?
require_once '_form_errors.php';
require_once '_flash.php';
?>

<p>
	Дополнительная информация о ценах, о то, как все работает и т.п.
</p>

<form action="./?id=<?= $acc_hotel->id ?>" method="POST">
	<div class="form-row">
		<label for="">Период</label>
		<select name="period" id="period">
			<? foreach ($periods as $i => $period): ?>
				<option value="<?= $i ?>" <?= $period['period'] == 'infinite' ? 'style="color: red;"' : '' ?>><?= $period['name'] ?></option>
			<? endforeach ?>
		</select>

		<p>
			* Определяется по данным <a href="http://cbr.ru" target="_blank">cbr.ru</a>. Сегодня евро стоит <?= $euro_rate ?> рублей.
		</p>

		<p>
			** Ваше предложение будет размещено на сайте, пока Вы сами не удалите его.
		</p>
	</div>

	<div class="form-row">
		<button type="submit">Активировать</button>
	</div>
</form>