<form action=".<?= ! isset($new_offer) ? "/?id=$acc_hotel->id" : '' ?>" method="POST" enctype="multipart/form-data">
	<div class="form-row">
		<label for="title">�������� �����������</label><br/>
		<input type="text" name="title" id="title" value="<?= isset($data['title']) ? $data['title'] : '' ?>" />
	</div>

	<div class="form-row">
		<label for="price">����</label><br />
		<input type="text" name="price" id="price" value="<?= isset($data['price']) ? $data['price'] : '' ?>" />
	</div>

	<div class="form-row">
		<label for="descr">������� ��������</label><br/>
		<textarea name="descr" id="descr"><?= isset($data['descr']) ? $data['descr'] : '' ?></textarea>

		<div class="help">
			��� �������� � ������ �� ������ ����������� ��������������<br/><br/>

			* ������� �������������� ������<br/>
			* ������� �������������� ������<br/><br/>

			1. ������� ������������� ������<br/>
			2. ������� ������������� ������<br/><br/>

			*<em>������</em>*<br/>
			**<strong>����������</strong>**<br/>
			[��� ������](http://�����.������)<br/>
		</div>
	</div>

	<div class="form-row">
		<label for="text">�����</label><br/>
		<textarea name="text" id="text"><?= isset($data['text']) ? $data['text'] : '' ?></textarea>
	</div>

	<div class="form-row">
		<label for="photo">�����������</label><br />
		<input class="file" type="file" name="photo" id="photo" value="" />

		<div class="help closer">
			��������� �������:<br/> .jpg, .jpeg, .png � .gif
		</div>
	</div>

	<div class="form-row">
		<label for="countries_">������, � �������� ��������� �����������</label><br />
		<select name="countries[]" id="countries_" multiple style="height: 120px">
			<? foreach ($all_countries as $c): ?>
				<option value="<?= $c->id ?>"
					<? if (isset($countries_) && in_array($c->id, $countries_)) echo 'selected' ?>>
					<?= $c->title ?></option>	
			<? endforeach ?>
		</select>

		<div class="help closer">
			����� ������� ��������� �����������, ������� "ctrl"
		</div>
	</div>

	<div class="form-row">
		<label for="region">������ (�������������)</label><br />
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
			����� ������� ��������� �����������, ������� "ctrl"
		</div>
	</div>

	<div class="form-row">
		<label for="town">�����</label><br />
		<input type="text" name="town" id="town" value="<?= isset($data['town']) ? $data['town'] : '' ?>" />
	</div>

	<div class="form-row">
		<button type="submit">���������</button>
		<? if (isset($new_offer) && $new_offer): ?>
			<button type="submit" name="_more">��������� � �������� ���</button>
		<? else: ?>
			<button type="submit" name="_continue">��������� � ���������� ��������������</button>
		<? endif ?>
		<a href="<?= SITE_ADDR ?>account/" title="Cancel" class="cancel">������</a>
	</div>
</form>