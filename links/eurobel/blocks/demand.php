<?php
$random = rand(0,4);
$arr = array('Пять плюс два','Три плюс семь','Девять плюс шесть','Один плюс восемь','Четыре плюс четыре');
?>

<div id='form_div'>
<form action='?demand=send' method="post" class="form" name="form" id="form"  >
<p>
<label title="name" for="name">Ф.И.О.*:</label><br />
<input type="text" name="name" id="name" />
</p>
<p>
<label title="email" for="email">E-mail*:</label><br />
<input type="text" name="email" id="email" />
</p>
<p>
<label title="email" for="email">Интересующий Вас объект* <br/> (Гостиница, отель, земля, бизнес, прочая недвижимость):</label><br />
<input type="text" name="country" id="country" />
</p>
<p>
<label title="email" for="email">Интересующая Вас страна*:</label><br />
<input type="text" name="country" id="country" />
</p>
<p>
<label title="email" for="email">Цена (в евро):</label><br />
От <input type="text" name="min_pprice" id="min_price" style='width: 100px'/>
до <input type="text" name="max_pprice" id="max_price" style='width: 100px' />
</p>
<p>
<label title="info" for="info">Дополнительная информация <br/>(максимально подробно опишите то, что Вас интересует):</label><br />
<textarea rows="5" cols="50" name="text" id="text"></textarea>
</p>
<p>
<label title="info" for="info"><?php echo $arr[$random]; ?> равно*:</label><br />
<input type='text' name="sum" id="sum" />
</p>
<p>
<input type="submit" value="Отправить" class='submit' />
<input type='hidden' value='<?php echo $random; ?>' name='capa' id='capa'  />
</p>
<p>
<span>Поля, отмеченные *, обязательны для заполнения.</span>
</p>
</form>
</div>
<br />
<br />