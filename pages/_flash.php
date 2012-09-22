<?
global $flash, $cancels;

if (! empty($flash)): ?>
	<div class="flash">
		<? foreach ($flash as $f): ?>
			<?= $f ?><br />
		<? endforeach ?>
	</div>
<? endif ?>

<? if (! empty($cancels)): ?>
	<div class="flash cancel">
		<? foreach ($cancels as $f): ?>
			<?= $f ?><br />
		<? endforeach ?>
	</div>
<? endif ?>