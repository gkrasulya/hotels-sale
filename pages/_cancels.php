<?
global $cancels;
if (! empty($cancels)): ?>
	<div class="flash cancel">
		<? foreach ($cancels as $f): ?>
			<?= $f ?><br />
		<? endforeach ?>
	</div>
<? endif ?>