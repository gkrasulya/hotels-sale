
<div id="navigation">

<div id="basicLinks" style="margin:0 15px;">
        <?php
		if ($vis == 1)
			{
        		echo "<div class='about'><a href='?about' ".$about_link.">О компании</a></div>";
			}
            
        echo "<div class='about'><a href='?new' ".$new_link.">Новые предложения</a></div>";
		if ($mai == 1)
			{
				echo "<div class='about'><a href='http://www.hotels-sale.ru/villas/' ".$main_link.">Главная</a></div>";
			}
				echo "<div class='about'><a href='http://www.hotels-sale.ru/villas/links' ".$links_link.">Ссылки</a></div>";
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

<form action='' method='get' class='getmail_form' id='search_form' name='search_form' style='width:70%; margin:20px 0 0 10%;'>
    	<input type='text' name='search' style='width:70%; color:#333;' value='Поиск...' onclick='this.value=""' />
        <input type='submit'value='Ок' style='margin: 5px 0pt 0pt; color:#333;' />
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
			
				echo "
					<div class='randomBox'>
					<br />
					<p><span>".$myrow_rand['number']." </span>".$myrow_rand['title']."</p>
					<a href='?h=".$myrow_rand['id']."'><img src='fotos/".$myrow_img['img_pre']."' alt='".$myrow_rand['title']."' /></a>
					<p>
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
				
				echo "
					<div class='randomBox'>
					<br />
					<p><span>".$myrow_rand['number']." </span>".$myrow_rand['title']."</p>
					<a href='?h=".$myrow_rand['id']."'><img src='fotos/".$myrow_img['img_pre']."' alt='".$myrow_rand['title']."' /></a>
					<p>
					Цена: <strong>".$myrow_rand['price']."</strong></p>
					<p><a href='?h=".$myrow_rand['id']."'>Подробнее</a></p>
					<br />
					</div>
				";				
			}
	}
?>

</div>


