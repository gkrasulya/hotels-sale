<h2>Личный кабинет</h2>

<?
require_once '_form_errors.php';
require_once '_flash.php';
?>

<h3>Предложения</h3>

<? if ($acc_hotels): ?>
	<table class="list" cellpadding="0" cellspacing="0" style="display: block; float: none;">
		<tr>
			</th>
			<th>
				<a href="<?= SITE_ADDR ?>account/?order=number"
					<?= $o == 'number' ? 'class="active"' : '' ?>>Номер</a>
					<?= $o == 'number' ? '&darr;' : '' ?>
			</th>
			<th>
				<a href="<?= SITE_ADDR ?>account/?order=title"
					<?= $o == 'title' ? 'class="active"' : '' ?>>Название</a>
					<?= $o == 'title' ? '&darr;' : '' ?>
			<th>
				<a href="<?= SITE_ADDR ?>account/?order=price"
					<?= $o == 'price' ? 'class="active"' : '' ?>>Цена</a>
					<?= $o == 'price' ? '&darr;' : '' ?>
			</th>
			<th>
				<a href="<?= SITE_ADDR ?>account/?order=status"
					<?= $o == 'status' ? 'class="active"' : '' ?>>Статус</a>
					<?= $o == 'status' ? '&darr;' : '' ?>
			</th>
			<? if (! is_agency()): ?>
				<th>
					<a href="<?= SITE_ADDR ?>account/?order=expiration"
						<?= $o == 'expiration' ? 'class="active"' : '' ?>>Дата окончания</a>
						<?= $o == 'expiration' ? '&darr;' : '' ?>
				</th>
			<? endif ?>
			<? if ($user->open_stats): ?>
				<th>Просмотры</th>
			<? endif ?>
			<th></th>
		</tr>
		<? foreach ($acc_hotels as $i => $hotel): ?>
			<tr class="<?= $hotel->active ? 'active' : 'deactive' ?> <?= $i % 2 == 0 ? 'even' : '' ?>">
				<td><?= $hotel->number ?></td>
				<td class="title">
					<a href="<?= SITE_ADDR ?>?h=<?= $hotel->id ?>" target="_blank" title="Edit">
						<?= $hotel->title ?></a>
				</td>
				<td><?= $hotel->price ?></td>
				<td><?= $hotel->active ?
					'<span class="active">активно</span>' : '<span class="deactive">неактивно</span>' ?></td>
				<? if (! is_agency()): ?>
					<? if ($hotel->infinite): ?>
						<td>неограничено</td>
					<? else: ?>
						<td><?= $hotel->expiration ? str_replace('-', '.', $hotel->expiration) : '' ?></td>
					<? endif ?>
				<? endif ?>
				<? if ($user->open_stats): ?>
					<td><strong><?= $hotel->views ?></strong></td>
				<? endif ?>
				<td class="actions">
					<? if (! is_agency() && $hotel->infinite != 1): ?>
						<a href="<?= SITE_ADDR ?>activate_offer/?id=<?= $hotel->id ?>" title="продлить" class="activate">
							<?= $hotel->active ? 'продлить' : 'активировать' ?></a><br/>
					<? endif ?>
					<a href="<?= SITE_ADDR ?>edit_offer/?id=<?= $hotel->id ?>" title="редактировать">редактировать</a><br/>
					<a href="<?= SITE_ADDR ?>edit_offer_photos/?id=<?= $hotel->id ?>" title="фотографии">фотографии</a><br/>
					<a href="<?= SITE_ADDR ?>delete_offer/?id=<?= $hotel->id ?>" title="удалить" class="delete">удалить [x]</a>
				</td>
			</tr>	
		<? endforeach ?>
	</table>

	<p>
		<a href="<?= SITE_ADDR ?>add_offer/">Добавить предложение</a>
	</p>
<? else: ?>
	<p>
		У вас пока нет предложений. <a href="<?= SITE_ADDR ?>add_offer/">Добавить сейчас?</a>
	</p>
<? endif ?>

<? if (! is_agency()): ?>

	<h3>Информация о балансе</h3>

	<p>

		На вашем счете: <strong><?= $user->amount ?> рублей</strong><br/>
		<a href="<?= SITE_ADDR ?>update_amount/" title="Пополнить">Пополнить</a>
	</p>

	<? if (isset($payments) && $payments): ?>
		<h3>Операции со счетом</h3>

		<table class="list" cellpadding="0" cellspacing="0" id="list" style="display: block; float: none;">
			<tr>
				<th>Сумма</th>
				<th>Остаток на счете</th>
				<th>Описание</th>
				<th>Дата и время</th>
				<th>Действия</th>
			</tr>
			<? foreach ($payments as $payment): ?>
				<tr class="<?= $payment->type == 'in' ? 'in' : 'out' ?>">
					<td>
						<strong><?= $payment->type == 'in' ? '+' : '-' ?> <?= $payment->summ ?> рублей</strong>
					</td>
					<td><?= $payment->amount_left ?> рублей</td>
					<td><?= $payment->type == 'in' ? 'Пополнение счета' : 'Активация (продление) предложения' ?></td>
					<td><?= str_replace('-', '.', $payment->date) ?></td>
					<td class="actions">
						<a href="<?= SITE_ADDR ?>delete_payment/?id=<?= $payment->id ?>" class="delete">Удалить [x]</a>
					</td>
				</tr>	
			<? endforeach ?>
		</table>
	<? else: ?>
	<? endif ?>
<? endif ?>

<script type="text/javascript">
	;(function($) {
		var $list = $('table.list'),
			$rows = $list.find('tr'),
			$deleteLinks = $list.find('a.delete'),
			$deactivateLinks = $list.find('a.deactivate');

		$rows.hover(function() {
			$(this).addClass('hover');
		}, function() {
			$(this).removeClass('hover');
		});

		$deleteLinks.click(function() {
			var $self = $(this),
				$row = $self.parents('tr').eq(0);

			var confirmText = $row.hasClass('active') ?
				'Вы уверены? Предложение все еще активно.' :
				'Вы уверены?';
			return confirm(confirmText);
		});

		$deactivateLinks.click(function() {
			var $self = $(this);

			return confirm('Вы уверены? Деньги, потраченные на это предложение нельзя будет вернуть.');
		});
	})(jQuery);
</script>