<form action=".<?= ! isset($new_offer) ? "/?id=$acc_hotel->id" : '' ?>" method="POST" enctype="multipart/form-data">
	<div class="form-row">
		<label for="title">Название предложения (максимум 160 символов без пробелов)</label><br/>
		<input type="text" name="title" id="title" value="<?= $data['title'] ?>" />
	</div>

	<div class="form-row">
		<label for="price">Цена</label><br />
		<input type="text" name="price" id="price" value="<?= $data['price'] ?>" />
	</div>

	<div class="form-row">
		<label for="rooms">Количество номеров</label><br />
		<input type="text" name="rooms" id="rooms" value="<?= $data['rooms'] ?>" />
	</div>

	<div class="form-row">
		<label for="descr">Краткое описание (максимум 650 символов без пробелов)</label><br/>
		<textarea name="descr" id="descr"><?= $data['descr'] ?></textarea>

		<div class="help">
			Для описания и текста вы можете исользовать форматирование<br/><br/>

			* элемент маркированного списка<br/>
			* элемент маркированного списка<br/><br/>

			1. элемент нумерованного списка<br/>
			2. элемент нумерованного списка<br/><br/>

			*<em>курсив</em>*<br/>
			**<strong>полужирный</strong>**<br/>
			[Имя ссылки](http://адрес.ссылки)<br/>
		</div>
	</div>

	<div class="form-row">
		<label for="text">Текст</label><br/>
		<textarea name="text" id="text"><?= $data['text'] ?></textarea>
	</div>

	<div class="form-row">
		<label for="photo">Изображение</label><br />
		<input class="file" type="file" name="photo" id="photo" value="" />

		<div class="help closer">
			Возможные форматы:<br/> .jpg, .jpeg, .png и .gif
		</div>
	</div>

	<div class="form-row">
		<label for="countries_">Страны, к которомы относится предложение</label><br />
		<select name="countries[]" id="countries_" multiple="">
			<? foreach ($all_countries as $c): ?>
				<option value="<?= $c->id ?>"
					<? if (isset($countries_) && in_array($c->id, $countries_)) echo 'selected' ?>>
					<?= $c->title ?></option>	
			<? endforeach ?>
		</select>

		<div class="help closer">
			Чтобы выбрать несколько стран, зажмите "ctrl"
		</div>
	</div>

	<div class="form-row">
		<label for="region">Регион (необязательно)</label><br />
		<select name="region" id="region">
			<option value="">Не указан</option>
			<? foreach ($all_countries as $c):
				$regions = get_records("SELECT * FROM regions WHERE country=$c->id");
				if ($regions): ?>
					<optgroup label="<?= $c->title ?>">
						<? foreach ($regions as $region): ?>
							<option value="<?= $r->id ?>">
								<?= $region->title ?></option>	
						<? endforeach ?>
					</optgroup>	
			<?	endif;
			endforeach; ?>
		</select>
	</div>

	<?/*
	<div class="form-row">
		<label for="town">Город</label><br />
		<input type="text" name="town" id="town" value="<?= $data['town'] ?>" />
	</div>
	*/?>

	<div class="form-row">
		<button type="submit">Сохранить</button>
		<? if ($new_offer): ?>
			<button type="submit" name="_more">Сохранить и добавить еще</button>
		<? else: ?>
			<button type="submit" name="_continue">Сохранить и продолжить редактирование</button>
		<? endif ?>
		<a href="<?= SITE_ADDR ?>account/" title="Cancel" class="cancel">Отмена</a>
	</div>
</form>