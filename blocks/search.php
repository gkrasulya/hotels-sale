<h4>����� �����������</h4>

<form action='<?= SITE_ADDR ?>'>
	<p>
		<input type='hidden' name='search' />
	    <label>������:</label>
    	<span>������� CTRL, ����� �������� ��������� �����</span>
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
	    <label>���� (� ����):</label>
	    <span>��&nbsp;&nbsp;</span>
	    <input name='min_price' type='text' class='small' />
	    <span>&nbsp;&nbsp;��&nbsp;&nbsp;</span>
	    <input name='max_price' type='text' class='small' />
	</p>
    
    <?/*<p>
	    <label>������� �������?:</label>
	    <span>��&nbsp;&nbsp;</span>
	    <input name='min_price' type='text' class='small' />
	    <span>&nbsp;&nbsp;��&nbsp;&nbsp;</span>
	    <input name='max_price' type='text' class='small' />
	</p>*/?>

	<p>
		<input type="submit" value="������" />
	</p>
</form>