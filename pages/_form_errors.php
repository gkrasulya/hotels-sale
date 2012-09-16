<?
global $errors;
if (isset($errors) && ! empty($errors)): ?>
	<div class="flash errors">
		<h3>Ошибки при заполнении формы:</h3>

		<ul>
			<? foreach ($errors as $e): ?>
				<li><?= $e ?></li>
			<? endforeach ?>
		</ul>
	</div>
<? endif ?>