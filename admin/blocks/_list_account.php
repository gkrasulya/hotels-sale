<?

if (isset($a)) {
	$id = addslashes($_GET['id']);
	if ($a == 'delete') {
		$deleted = mysql_query("DELETE FROM users where id=$id");
	} elseif ($a == 'update') {
		$months = isset($_POST['months']) ? $_POST['moths'] : 0;

		$data = array(
			'type' => isset($_POST['type']) ? $_POST['type'] : '',
			'info' => isset($_POST['info']) ? $_POST['info'] : '',
			'open_stats' => isset($_POST['open_stats']) ? 1 : 0,
			'change_token' => isset($_POST['change_token']) ? $_POST['change_token'] : ''
		);

		if (isset($_POST['month_cost'])) {
			$data['month_cost'] = $_POST['month_cost'];
			$data['month_cost_cur'] = $_POST['month_cost_cur'];
			$data['expiration_date'] = str_replace('.', '-', $_POST['date']);
		}

		$data = array_map('addslashes', $data);

		$data_values = array();
		foreach ($data as $kw => $val) {
			$data_values []= "$kw = '$val'";
		}
		$data_values = implode(', ', $data_values);

/*
		echo '<pre>';
		print_r($data);
		echo '</pre>';
		*/

		$sql = "
			UPDATE users
			SET
				$data_values
			WHERE
				id = $id
				AND change_token != \"{$data['change_token']}\"";

		// echo $sql;

		$updated = mysql_query($sql);

		if (! $updated) {
			echo "<pre>$sql</pre><br/><br/>";
			die(mysql_error());
		}

		//mysql_query("UPDATE hotels SET active = 1 WHERE user_id = $id");
	}
}

$result = mysql_query("SELECT * FROM users ORDER BY id DESC");

$agency_periods = array(
	1 => '1 месяц',
	2 => '2 месяца',
	3 => '3 месяца',
	4 => '4 месяца',
	6 => '6 месяцев',
	12 => '1 год',
	18 => '1 год 6 месяцев',
	24 => '2 года'
);
?>

<h2>Аккаунты</h2>

<?php if (isset($deleted) && $deleted): ?>
	<h4 class="flash">Аккаунт удален</h4>
<?php endif ?>

<?php if (isset($info_edited) && $info_edited): ?>
	<h4 class="flash">Дополнительная информация обновлена</h4>
<?php endif ?>

<?php if (isset($updated) && $updated): ?>
	<h4 class="flash">Аккаунт обновлен</h4>
<?php endif ?>

<style>
	.table-list {
		margin-top: 20px;
		width: 100%;
	}
	.table-list td {
		padding: 5px 8px;
		vertical-align: top;
	}
	.table-list th {
		color: #999;
		font-weight: normal;
		padding: 0 5px 10px;
		text-align: left;
	}
	.table-list tr.odd {
		background: #def;
	}

	textarea.info {
		height: 100px;
	}

	a.action {
		border-bottom: 1px dotted #036;
		text-decoration: none;
	}

	.update-form {
		background: #fff;
		background-color: rgba(255, 255, 255, 0.9);
		border: 2px solid #ddf;
		display: none;
		padding: 15px 25px;
		position: absolute;
		top: -50px;
		right: 20px;
		z-index: 111;
		width: 200px;
	}
	.update-form p {
		margin-top: 10px;
	}
	.update-form label {
		display: block;
	}
	.update-form input, .update-form select, .update-form textarea {
		margin-top: 3px;
		width: 195px;
	}
	.update-form input.small, .update-form select.small {
		width: 95px !important;
	}
	button {
		cursor: pointer;
	}
	.cancel {
		color: #f00;
		margin-left: 10px;
	}
	.update-form .title {
		color: #999;
	}

</style>

<p>
	<a href="<?= SITE_ADDR ?>admin/?t=accounts&amp;a=add">Добавить новый аккаунт</a>
</p>

<table class="table-list" cellpadding="0" cellspacing="0" id="tableList">
	<tr>
		<th width="40%">Email</th>
		<th width="40%">Тип</th>
		<th width="20%">Действия</th>
	</tr>
	<? $i = 0; while ($user = mysql_fetch_array($result)): $i++; ?>
		<tr <?= $i % 2 == 1 ? 'style="background: #efe"' : '' ?>>
			<td>
				<strong><?= $user['email'] ?></strong>
			</td>
			<td><?= $user['type'] == 'agency' ? 'Агенство' : 'Пользователь' ?></td>

			<td style="position: relative;">
				<a href="<?= SITE_ADDR ?>admin/?t=accounts&amp;a=delete&amp;id=<?= $user['id'] ?>"
					onclick="return confirm('Вы уверены?')">удалить [x]</a><br/>

				<a href="#" class="edit-link action">редактировать</a>

				<form class="update-form" method="POST" action="?t=accounts&amp;a=update&amp;id=<?= $user['id'] ?>">
					<div class="title"><?= $user['email'] ?></div>
					<input type="hidden" value="<?= mktime() ?>" name="change_token" />

					<? if ($user['type'] == 'agency'): ?>
						<p>
							<label for="">Активен до</label>
							<input type="text" style="width: 100px;" name="date"
								value="<?= str_replace('-', '.', $user['expiration_date']) ?>" />
						</p>

						<p>
							<label>Оплата в месяц</label>

							<input class="small" type="text" name="month_cost" value="<?= $user['month_cost'] ?>" />
							<select class="small"  name="month_cost_cur">
								<option value="rub">руб.</option>
								<option value="euro" <?= $user['month_cost_cur'] == 'euro' ? 'selected' : '' ?>>евро</option>
							</select>
						</p>
					<? endif ?>

					<p>
						<label for="type">Тип аккаунта</label>

						<select name="type" id="type">
							<option value="user">Пользователь</option>
							<option value="agency" <? if ($user['type'] == 'agency') echo 'selected' ?>>Агентсво</option>
						</select>
					</p>

					<p>
						<label for="info">Доп. информация</label>
						<textarea name="info" id="info" class="info"><?= $user['info'] ?></textarea>
					</p>

					<p>
						<input type="checkbox" name="open_stats" id="open_stats" style="width: auto" <?= $user['open_stats'] ? 'checked' : '' ?>>&nbsp;
						<label style="display: inline" for="open_stats">Показывать статистику</label>
					</p>

					<p>
						<button type="submit">Сохранить</button>
						<a href="#" class="action cancel">Отмена</a>
					</p>
				</form>
			</td>
		</tr>
	<? endwhile ?>

</table>

<script>

	var $tableList = $('#tableList'),
		$editInfoLinks = $tableList.find('a.info-link'),
		$editLinks = $tableList.find('a.edit-link'),
		$updateForms = $tableList.find('form.update-form'),
		$cancel = $updateForms.find('a.cancel'),
		$b = $('body');

	$cancel.click(function() {
		$(this).parents('form').eq(0).hide();

		return false;
	});

	$updateForms.submit(function() {
		return confirm('Вы уверены?');
	});

	$editLinks.each(function() {
		var $link = $(this),
			$form = $link.parent().find('form');

		$link.click(function() {
			$updateForms.hide();
			$form.toggle();

			return false;
		});
	});

</script>