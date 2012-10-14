<form action=".<?= ! isset($new_offer) ? "/?id=$acc_hotel->id" : '' ?>" method="POST" enctype="multipart/form-data">
	<div class="form-row">
		<label for="title">Название предложения</label><br/>
		<input type="text" name="title" id="title" value="<?= isset($data['title']) ? $data['title'] : '' ?>" />
	</div>

	<div class="form-row">
		<label for="price">Цена</label><br />
		<input type="text" name="price" id="price" value="<?= isset($data['price']) ? $data['price'] : '' ?>" />
	</div>

	<div class="form-row">
		<label for="descr">Краткое описание</label><br/>
		<textarea name="descr" id="descr"><?= isset($data['descr']) ? $data['descr'] : '' ?></textarea>

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
		<textarea name="text" id="text"><?= isset($data['text']) ? $data['text'] : '' ?></textarea>
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
		<select name="countries[]" id="countries_" multiple style="height: 120px">
			<? foreach ($all_countries as $c): ?>
				<option value="<?= $c->id ?>"
					<? if (isset($countries_) && in_array($c->id, $countries_)) echo 'selected' ?>>
					<?= $c->title ?></option>	
			<? endforeach ?>
		</select>

		<div class="help closer">
			Чтобы выбрать несколько предложений, зажмите "ctrl"
		</div>
	</div>

	<div class="form-row">
		<label for="region">Регион (необязательно)</label><br />
		<select name="regions[]" id="regions" multiple style="height: 120px">
			<? foreach ($all_countries as $c):
				$regions = get_records("SELECT * FROM regions WHERE country=$c->id");
				if ($regions): ?>
					<optgroup label="<?= $c->title ?>">
						<? foreach ($regions as $r): ?>
							<option value="<?= $r->id ?>"
								<? if (isset($regions_) && in_array($r->id, $regions_)) echo 'selected' ?>>
									<?= $r->title ?></option>
						<? endforeach ?>
					</optgroup>	
			<?	endif;
			endforeach; ?>
		</select>

		<div class="help closer">
			Чтобы выбрать несколько предложений, зажмите "ctrl"
		</div>
	</div>

	<div class="form-row">
		<label for="town">Город</label><br />
		<input type="text" name="town" id="town" value="<?= isset($data['town']) ? $data['town'] : '' ?>" />
	</div>

	<div class="form-row">
		<button type="submit">Сохранить</button>
		<? if (isset($new_offer) && $new_offer): ?>
			<button type="submit" name="_more">Сохранить и добавить еще</button>
		<? else: ?>
			<button type="submit" name="_continue">Сохранить и продолжить редактирование</button>
		<? endif ?>
		<a href="<?= SITE_ADDR ?>account/" title="Cancel" class="cancel">Отмена</a>
	</div>
</form>