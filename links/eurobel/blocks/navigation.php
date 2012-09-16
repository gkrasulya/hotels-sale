
<div id="navigation">

<div id="basicLinks" style="margin:0 10px;">
        <?php
		if ($vis == 1)
			{
        		echo "<div class='about'><a href='?about' ".$about_link.">О компании</a></div>";
			}
            
        echo "<div class='about'><a href='?new' ".$new_link.">Новые предложения</a></div>";
            
		if ($mai == 1)
			{
				echo "<div class='about'><a href='http://www.hotels-sale.ru' ".$main_link.">Главная</a></div>";
			}
            
            
            ?>
</div>

<div id="nav_links">

<div class="corner_lt">
<div class="corner_rt">
<div class="corner_rb">
<div class="corner_lb">
<br />
<ul>

<?php
$result = mysql_query("SELECT * FROM countries",$db);
$myrow = mysql_fetch_array($result);
do
	{
		$result2 = mysql_query("SELECT * FROM regions WHERE country='$myrow[id]'",$db);
		if (mysql_num_rows($result2) == 0)
			{
				echo "<li>
					  <div class='nav_link'><a href='?qwe=".$myrow['id']."'>".$myrow['title']."</a></div>
					  </li>
					  ";
			}
		else
			{
				$myrow2 = mysql_fetch_array($result2);
				echo "<li>
					  <div class='nav_link'><a href='?qwe=".$myrow['id']."'>".$myrow['title']."</a></div>
					  <div class='sub_nav'>
					  ";
					  
				do 
					{
						echo "<a href='?r=".$myrow2['id']."'>".$myrow2['title']."</a>";
					}
				while ($myrow2 = mysql_fetch_array($result2));
					  
				echo "</div>
					  </li>
					  ";
				
				
			}
	}
while ($myrow = mysql_fetch_array($result));
?>

</ul>
<br />

</div>
</div>
</div>
</div>

</div>

<form action='' method='get' class='getmail_form' id='search_form' name='search_form' style='width:100%; margin:20px 0 0 0%; 
background:#eaeaff url("../img/hotel_box_top.jpg") top left repeat-x;'>
	<input type='hidden' name='search' />
	<fieldset style='border:1px solid #ddf; padding-left: 5%;'>
    <legend style='font-style: italic;'>Поиск</legend>
	<p>
	<label for='country'>Страна:</label>
	<select name='country' id='country'>
    	<option value='all'>Все страны</option>
        <?php
        $result_countries = mysql_query("SELECT * FROM countries",$db);
		$countries = mysql_fetch_array($result_countries);
		do {
			echo "<option value='".$countries['id']."'>".$countries['title']."</option>\n";
		} while($countries = mysql_fetch_array($result_countries));
		?>
    </select><br/>
    </p>
    <p>
    <label for='max_price'>Цена (в евро):</label>
    От&nbsp; <input type='text' name='min_price' id='min_price' size='7' />
    &nbsp;&nbsp;&nbsp; до&nbsp; <input type='text' name='max_price' id='max_price' size='7' />
    </p>
    <p>
    <label for='max_rooms'>Количество номеров:</label>
    От&nbsp; <input type='text' name='min_rooms' id='min_rooms' size='7'  />
    &nbsp;&nbsp;&nbsp; до&nbsp; <input type='text' name='max_rooms' id='max_rooms' size='7'  />
    </p>
    <p>
    <input type='submit' value='Искать' style='margin: 5px 0pt 0pt; color:#333;' />
    </p>
    </fieldset>
</form>

<?php

require_once('blocks/getmail_form.php');

$result_rand = mysql_query("SELECT * FROM random",$db);
$myrow_rand = mysql_fetch_array($result_rand);

if ($myrow_rand['random'] == 1)

	{
		
		$result_rand = mysql_query("SELECT * FROM hotels ORDER BY RAND() LIMIT 2",$db);
		$myrow_rand = mysql_fetch_array($result_rand);
		
		do
			{
				$result_img = mysql_query("SELECT img_pre FROM fotos WHERE id='$myrow_rand[foto]'",$db);
				$myrow_img = mysql_fetch_array($result_img);
				if ($myrow_rand['rooms'] != '0') { $show_rooms = "<p>Номеров: <strong>".$myrow_rand['rooms']."</strong><br />"; } else { $show_rooms = '<p>'; }
			
				echo "
					<div class='randomBox'>
					<br />
					<p><span>".$myrow_rand['number']." </span>\"".$myrow_rand['title']."\"</p>
					<a href='?h=".$myrow_rand['id']."'><img src='fotos/".$myrow_img['img_pre']."' alt='".$myrow_rand['title']."' /></a>
					".$show_rooms."
					Цена: <strong>".$myrow_rand['price']."</strong></p>
					<p><a href='?h=".$myrow_rand['id']."'>Подробнее</a></p>
					<br />
					</div>
				";
			}
		while ($myrow_rand = mysql_fetch_array($result_rand));
	}
	
else
	{
		$random_hotels = $myrow_rand['hotels'];
		$random_hotels = explode(",",$random_hotels);
		
		$how_much = count($random_hotels);
		
		for ($i=0; $i < $how_much; $i++)
			{
				$result_rand = mysql_query("SELECT * FROM hotels WHERE id='$random_hotels[$i]'",$db);
				$myrow_rand = mysql_fetch_array($result_rand);
				
				$result_img = mysql_query("SELECT img_pre FROM fotos WHERE id='$myrow_rand[foto]'",$db);
				$myrow_img = mysql_fetch_array($result_img);
				if ($myrow_rand['rooms'] != '0') { $show_rooms = "<p>Номеров: <strong>".$myrow_rand['rooms']."</strong><br />"; } else { $show_rooms = '<p>'; }
				
				echo "
					<div class='randomBox'>
					<br />
					<p><span>".$myrow_rand['number']." </span>\"".$myrow_rand['title']."\"</p>
					<a href='?h=".$myrow_rand['id']."'><img src='fotos/".$myrow_img['img_pre']."' alt='".$myrow_rand['title']."' /></a>
					".$show_rooms."
					Цена: <strong>".$myrow_rand['price']."</strong></p>
					<p><a href='?h=".$myrow_rand['id']."'>Подробнее</a></p>
					<br />
					</div>
				";				
			}
	}
?>

</div>


