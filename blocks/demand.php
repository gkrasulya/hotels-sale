<?php
$random = rand(0,4);
$arr = array('Пять плюс два','Три плюс семь','Девять плюс шесть','Один плюс восемь','Четыре плюс четыре');
?>

<div id='form_div'>
<form action='?demand=send' method="post" class="form" name="form" id="form"  >
<p>
	<label title="name" for="name">Ф.И.О.*:</label><br />
	<input type="text" name="name" id="name" value="<?= isset($name) ? $name : '' ?>" />
</p>
<p>
	<label title="phone" for="phone">Телефон*:</label><br />
	<input type="text" name="phone" id="phone" value="<?= isset($phone) ? $phone : '' ?>" />
</p>
<p>
	<label title="email" for="email">E-mail*:</label><br />
	<input type="text" name="email" id="email" value="<?= isset($email) ? $email : '' ?>" />
</p>
<p>
	<label title="email" for="email">Интересующий Вас объект* <br/> <span style='font-size:11px; font-style:italic;'>(Гостиница, отель, земля, бизнес, прочая недвижимость):</label><br />
	<input type="text" name="object" id="object" value="<?= isset($object) ? $object : '' ?>" />
</p>
<p>
	<label title="email" for="email">Интересующая Вас страна*:</label><br />
	<input type="text" name="country" id="country" value="<?= isset($country) ? $country : '' ?>" />
</p>
<p>
	<label title="email" for="email">Цена <span style='font-size:11px; font-style:italic; margin-left: 0px;'>(в евро):</label><br />
	<span class='little'>От</span> <input class='little' type="text" value="<?= isset($min_price) ? $min_price : '' ?>" name="min_price" id="min_price" style='width: 100px'/>
	<span class='little'>до</span> <input class='little' type="text" value="<?= isset($max_price) ? $max_price : '' ?>" name="max_price" id="max_price" style='width: 100px' />
</p>
<p>
	<label title="info" for="info">Дополнительная информация <br/><span style='font-size:11px; font-style:italic;'>(максимально подробно опишите то, что Вас интересует):</label><br />
	<textarea rows="5" cols="50" name="text" id="text"><?= isset($text) ? $text : '' ?></textarea>
</p>
<p>
	<label title="info" for="info"><?php echo $arr[$random]; ?> равно*:</label><br />
	<input type='text' name="sum" id="sum" />
</p>
<p>
	<input type="submit" value="" class='submit' id='fDSubmit' />
	<input type='hidden' value='<?php echo $random; ?>' name='capa' id='capa'  />
</p>
<p>
	<span>Поля, отмеченные *, обязательны для заполнения.
</p>
</form>
</div>
<br />
<br />