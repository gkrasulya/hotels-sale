<h4>Поиск предложений</h4>

<form action='<?= SITE_ADDR ?>'>
	<p>
		<input type='hidden' name='search' />
	    <label>страна:</label>
    	<span>зажмите CTRL, чтобы выделить несколько стран</span>
	    <select name='countries[]' multiple>
			<?
	        $result_countries = mysql_query("SELECT * FROM countries",$db);
	        $countries = mysql_fetch_array($result_countries);
	        do { ?>
	        	<option value='<?=$countries['id']?>'><?=$countries['title']?></option>
		    <? } while($countries = mysql_fetch_array($result_countries)) ?>
	    </select>
    </p>
    
    <p>
	    <label>цена (в евро):</label>
	    <span>от&nbsp;&nbsp;</span>
	    <input name='min_price' type='text' class='small' />
	    <span>&nbsp;&nbsp;до&nbsp;&nbsp;</span>
	    <input name='max_price' type='text' class='small' />
	</p>
    
    <?/*<p>
	    <label>сколько номеров?:</label>
	    <span>от&nbsp;&nbsp;</span>
	    <input name='min_price' type='text' class='small' />
	    <span>&nbsp;&nbsp;до&nbsp;&nbsp;</span>
	    <input name='max_price' type='text' class='small' />
	</p>*/?>

	<p>
		<input type="submit" value="Искать" />
	</p>
</form>