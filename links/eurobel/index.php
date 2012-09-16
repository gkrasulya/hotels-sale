<?php 
require_once("blocks/db.php"); 
require_once("blocks/variables.php");
$result_meta = mysql_query("SELECT meta_k,meta_d FROM main",$db);
$myrow_meta = mysql_fetch_array($result_meta);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" >

<meta name="keywords" content="Покупка, продажа недвижимости за 
рубежом, недвижимость в Европе, продажа бизнеса в Европе, покупка бизнеса за 
рубежом, Продажа бизнеса за рубежом, зарубежная недвижимость, коммерческая недвижимость, продажа гостиничного бизнеса, продажа готового бизнеса, продажа бизнеса в Испании, продажа бизнеса в Австрии, продажа бизнеса в Германии, продажа бизнеса в Бельгии, Продажа бизнеса во Франции, продажа бизнеса в Греции, гостиничный бизнес в Европе, продажа Отелей и Гостиниц в Европе, Франчайзинг,
недвижимость в Австрии, недвижимость в Бельгии, недвижимость в Греции, 
недвижимость во Франции, недвижимость в Италии, недвижимость в Германии, 
недвижимость в Швейцарии, недвижимость в Испании, недвижимость в Англии, 
недвижимость в Голландии, недвижимость в Чехии, недвижимость в Польше, недвижимость в Болгарии, недвижимость в Париже, продажа коммерческой недвижимости, приобретение 
Европейского паспорта и вида на жительство, открытие фирм и счетов в 
Европе, купить бизнес в Европе, купить недвижимость в 
Европе, открыть фирму в Европе , открыть счет в Европе , получить вид на 
жительство в Европе , получить Европейский паспорт, Бизнес эммиграция, инвестиции в Швейцарию, инвестиции во Францию, инвестиции в Германию, инвестиции в Бельгию,инвестиции в Автрию, инвестиции в Болгарию, инвестиции в Испанию,инвестиции в Италию, инвестиции в Грецию,
иммиграция в Европу, Францию, Грецию, Германию, Бельгию, Голландию, коммерческая недвижимость"> 

<meta name="description" content="недвижимость в европе, готовый бизнес в Европе, продажа готового бизнеса за рубежом, покупка бизнеса в Европе, приобретение Европейского паспорта, вида на жительство, покупка недвижимости в Европе, открытие фирм и счетов в Европе, купить бизнес в Европе,">

<title>Hotels-sale.ru: <?php echo $title; ?> - Продажа Отелей и Гостиниц в Европе, Покупка Гостиниц в Европе, Инвестиционная недвижимость за рубежом </title>
		<style type='text/css'>
		
		#search_form {
			color: #787878;
			font-size:12px;
		}
		
		#search_form input, #search_form select {
			color: #454;
		}
		
		#search_form label {
		margin-bottom: 3px;
		display: block;
		}
		
		#search_form legend {
			font-size: 16px;
			color: #454;
		}
		
		#gallery {
			display:block;
			width:80%;
		}
		#gallery li {
			float:left;
			list-style:none;
			padding:5px;
			margin:5px;
			border:1px solid #aaa;
		}
		#gallery img {
			width: 100px;
			border:none;
		}
		
		#overlay {
			position:fixed;
			top:0px;
			left:0px;
			width:100%;
			height:100%;
			background:#6699ff;
			z-index:100;
			display:none;
		}
		
		#img_div {
			position:absolute;
			display:none;
			padding: 10px;
			z-index:101;
			background:url('bg.gif') white;
			width:43px;
			height:12px;
		}
		
		#img {
			z-index:102;
			background: #fff;
			display:none;
			border:1px solid white;
		}
		
		#loading {
			display:block;
		}
		
		#foto_title {
			color:white;
			font-weight:bold;
			position:relative;
			top:3px;
		}
		
		#control {
			 text-align: center; 
			 position: absolute; 
			 background:url('bg.gif'); 
			 height:25px; 
			 width:100%; 
			 left:0px; 
			 bottom:0px;
			 display: none; 
		 }
		
		#prev, #next, #next2 {
			cursor: pointer;
			color: white;
			position: absolute;
			top: -23px;
			font-size:11px;
			width:35%;
			text-decoration:underline;
		}
		
		#prev:hover, #next:hover {
			color:#ddd;
		}
		
		#prev {
			left: 15px;
		}
		
		#next {
			right: 15px;
		}
		
		#next2 {
			right: 25px;
		}
		
		#foto_title {
			font-size:12px;
			padding:0 2%;
			top:-7px;
			float:left;
			display:block;
			overflow:hidden;
			width:100%;
			text-align:center;
		}
		
		#close {
			color: white; 
			font-weight: bold; 
			position: absolute; 
			top: -1px; 
			right: 1px;
			padding:0;
			margin:0;
			cursor: pointer;
			display: none;
			font-size:11px;
		}
		
		#close:hover {
			color:#ddd;
		}
		</style>
        

<link href='css/styles.css' type='text/css' rel='stylesheet' />
<script type='text/javascript' src='scripts/js.js'></script>
<script type='text/javascript' src='scripts/jquery.js'></script>
<script type="text/javascript">
	<!-- hide from old browsers
	var name = navigator.appName;
	if (name == "Microsoft Internet Explorer")
	{
	var brow = true;
	var style = "stylesIE.css";;
	}
	else
	{
	var brow = false;
	var style = "styles.css";
	}
	
	document.write("<link href='css/" + style + "' type='text/css' rel='stylesheet' />");
	
	<?php
	
	if (isset($h))
		{
			echo "
	
			window.onload = function () {
				id('formButton').onclick = function () {
					toggleSlideFade(id('form_div'));
					return false;
				}
			}
			
			function showControl () {
				id('control').style.display = 'block';
				id('close').style.display = 'block';
			}
			
			function hideControl () {
				id('control').style.display = 'none';
				id('close').style.display = 'none';
			}
			";
			
			$result = mysql_query("SELECT title FROM hotels WHERE id='$h'",$db);
			$myrow = mysql_fetch_array($result);
		}
	
	?>
	// --> 
</script>


</head>

<body>
    <div id='overlay' onclick='closeImg()'>
    </div>
    
    <div id='img_div' onmouseover='showControl()' onmouseout='hideControl()'>
        <img src='' id='img' onload='loaded()'/>
        <img src='doc/loading.gif' id='loading'/>
        <div id='close' onclick='closeImg()'>X</div>
        <div id='control' style=' text-align: center; position: absolute; background:url('bg.gif'); height:25px; width:100%; left:0px; bottom:0px; display: none; '>
            <span id='prev' onclick="changeImg(first(next(current.parentNode)))"></span>
            <span id='prev' onclick="changeImg((first(prev(current.parentNode))) || first(prev(last(current.parentNode.parentNode))))">&laquo; назад</span>
            <span id='foto_title'><?php echo $myrow['title']; ?></span>
            <span id='next' onclick="changeImg((first(next(window.current.parentNode))) || first(first(current.parentNode.parentNode)))">вперед &raquo;</span>
        </div>
    </div>

<?php require_once("blocks/header.php"); ?>

<div id="wrapper">

<?php require_once("blocks/navigation.php"); ?>

<div id="content">

<div class="corner_lt">
<div class="corner_rt">
<div class="corner_rb">
<div class="corner_lb">

<br /><br />
<div id="main_cont">
<div id="cont_rt">
<div id="cont_rb">
<div id="cont_lb">
<br />

<?php

if (!isset($h) && !isset($r) && !isset($c) && !isset($about) && !isset($qwe) && !isset($form) && !isset($new) && !isset($getmail) && !isset($search) && !isset($test) && !isset($demand))
	{
		$result = mysql_query("SELECT * FROM main",$db);
		$myrow = mysql_fetch_array($result);
		$text = str_replace("\n","</p><p>",$myrow['text']);
		
		echo "
			<h2>".$myrow['title']."</h2>
			<p>
				".$text."
			</p>
		";
	}
	
if (isset($getmail))
	{
		if (isset($_POST['email'])) { $to = $_POST['email']; }
		if (isset($_POST['name'])) { $name = $_POST['name']; }
		if (trim($to) != '' && trim($email) != '')
			{
				$result = mysql_query("INSERT INTO emailers (email,name) VALUES ('$to','$name')",$db);
			}
											
		if ($result) 
			{
				echo "<h4 style='margin-left:50px;'>Все сделано!</h4>";
				echo "<p><a href='?main'>Вернуться на главную</a></p>";
			}
		else 
			{
				echo "<h4 style='margin-left:50px;'>Не получилось!</h4>";
				echo "<p><a href='?main'>Вернуться на главную</a></p>";
			}
	}
	
if (isset($about))
	{
		$result = mysql_query("SELECT * FROM about",$db);
		$myrow = mysql_fetch_array($result);
		$text = str_replace("\n","</p><p>",$myrow['text']);
		
		echo "
			<h2>".$myrow['title']."</h2>
			<p>
				".$text."
			</p>
		";
	}
	
if (isset($h))
	{
		$result = mysql_query("SELECT id,text,foto,title,number FROM hotels WHERE id='$h'",$db);
		$myrow = mysql_fetch_array($result);
		$text = str_replace("\n","</p><p>",$myrow['text']);
		
		$result_img = mysql_query("SELECT img_big FROM fotos WHERE id='$myrow[foto]'",$db);
		$myrow_img = mysql_fetch_array($result_img);
		
		$result_mail = mysql_query("SELECT email FROM admin",$db);
		$myrow_mail = mysql_fetch_array($result_mail);
		
		echo "
			<h2>".$myrow['title']."</h2>
			<div id='hotelImg'><img src='fotos/".$myrow_img['img_big']."' alt='".$myrow['title']."' /></div>
			<p>
				".$text."
			</p>

			";
	
	$result_fotos = mysql_query("SELECT * FROM add_fotos WHERE hotel_id = '$myrow[id]'",$db);
	if (mysql_num_rows($result_fotos) > 0)
		{
		
			$fotos = mysql_fetch_array($result_fotos);
			
			echo "<ul class='gallery' title='".$myrow['title']."' id='gallery'>";
			do 
				{
					echo "
						<li>
							<a href='add_fotos/".$myrow['id']."/".$fotos['big']."' onclick='showImg(this); return false;'>
								<img src='add_fotos/".$myrow['id']."/".$fotos['small']."'/>
							</a>
						</li>
					";
				}
			while ($fotos = mysql_fetch_array($result_fotos));
			echo "
			<div style='clear:both;'>&nbsp;</div>
			</ul>
			
			

			";
		}
		
		echo "<p id='contact_mail'><a href='?form=new&number=".$myrow['number']."' id='formButton' onclick=\"toggleSlide(form); return false;\">Отправить заявку</a></p>
							<div>
							<div class='hotelBoxTitle'></div>
								<div style='clear:both;'></div>
								</div>";

		require_once "blocks/form.php";
	}
	
if (isset($new))
	{
		$result = mysql_query("SELECT * FROM hotels ORDER BY id DESC LIMIT ".$start.",".$x."",$db);
		if (mysql_num_rows($result) > 0)
			{
				
				$myrow = mysql_fetch_array($result);
				
				do 
					{
						$result_img = mysql_query("SELECT img_pre FROM fotos WHERE id='$myrow[foto]'",$db);
						$myrow_img = mysql_fetch_array($result_img);
						if ($myrow['rooms'] != 0) { $show_rooms = "<span>Номеров: </span> <strong>".$myrow['rooms']."</strong><br />"; } else { $show_rooms = ''; }
						
						echo ("
							<div class='hotelBox'>
							<div class='hotelBoxTitle'>
							<div class='hotelBoxNumber'>".$myrow['number']."</div>
							 \"".$myrow['title']."\" </div><br />
								<a href='?h=".$myrow['id']."'><img src='fotos/".$myrow_img['img_pre']."' alt='".$myrow['title']."'/></a>
								<div class='hotelBoxDesc'><br />
								<p>".$myrow['descr']."</p><br /><br />
								<div class='hotelBoxInfo'>".
								$show_rooms."
								<span>Цена: </span> <strong>".$myrow['price']."</strong>
								<a href='?h=".$myrow['id']."' class='hotelBoxMore'>Подробнее</a>
								</div>
								</div>
								<div style='clear:both;'></div>
								</div>
							");
						}
					while ($myrow = mysql_fetch_array($result));
					require_once("blocks/pages.php");
				
				}
				
			else
				
				{
					echo "<h2>Простите, но в этом разделе гостиниц  нет!</h2>";
				}
	}


if (isset($r)) 
	{
		$result = mysql_query("SELECT * FROM hotels WHERE region='$r'".$s." LIMIT ".$start.",".$x."",$db);
		if (mysql_num_rows($result) > 0)
			{
				$result_r = mysql_query("SELECT title,country FROM regions WHERE id='$r'",$db);
				$myrow_r = mysql_fetch_array($result_r);
				
				$result_c = mysql_query("SELECT title FROM countries WHERE id='$myrow_r[country]'",$db);
				$myrow_c = mysql_fetch_array($result_c);
				echo "
					<div id='sort_by'>Сортировать по: 
					<a href='?r=".$r."&amp;s=town&amp;page=".$page."' ".$sort_by_town.">городам</a>, 
					<a href='?r=".$r."&amp;s=price&amp;page=".$page."' ".$sort_by_price.">стоимости</a>
					</div>
					<h2>".$myrow_c['title'].", ".$myrow_r['title']."</h2>
					<br />
				";
				$myrow = mysql_fetch_array($result);
				
				do 
					{
						$result_img = mysql_query("SELECT img_pre FROM fotos WHERE id='$myrow[foto]'",$db);
						$myrow_img = mysql_fetch_array($result_img);
						if ($myrow['rooms'] != 0) { $show_rooms = "<span>Номеров: </span> <strong>".$myrow['rooms']."</strong><br />"; } else { $show_rooms = ''; }
						
						echo ("
							<div class='hotelBox'>
							<div class='hotelBoxTitle'>
							<div class='hotelBoxNumber'>".$myrow['number']."</div>
							 \"".$myrow['title']."\" </div><br />
								<a href='?h=".$myrow['id']."'><img src='fotos/".$myrow_img['img_pre']."' alt='".$myrow['title']."'/></a>
								<div class='hotelBoxDesc'><br />
								<p>".$myrow['descr']."</p><br /><br />
								<div class='hotelBoxInfo'>
								".$show_rooms."
								<span>Цена: </span> <strong>".$myrow['price']."</strong>
								<a href='?h=".$myrow['id']."' class='hotelBoxMore'>Подробнее</a>
								</div>
								</div>
								<div style='clear:both;'></div>
								</div>
							");
						}
					while ($myrow = mysql_fetch_array($result));
					require_once("blocks/pages.php");
				
				}
				
			else
				
				{
					echo "<h2>Простите, но в этом разделе гостиниц  нет!</h2>";
				}
	}

if (isset($qwe))
	{
		$result = mysql_query("SELECT * FROM hotels WHERE country='$qwe' ".$s." LIMIT ".$start.",".$x."",$db);
		if (mysql_num_rows($result) > 0)
			{
				
				$result_c = mysql_query("SELECT title FROM countries WHERE id='$qwe'",$db);
				$myrow_c = mysql_fetch_array($result_c);
				echo "
					<div id='sort_by'>Сортировать по: 
					<a href='?qwe=".$qwe."&amp;s=town&amp;page=".$page."' ".$sort_by_town.">городам</a>, 
					<a href='?qwe=".$qwe."&amp;s=price&amp;page=".$page."' ".$sort_by_price.">стоимости</a>
					</div>
					<h2>".$myrow_c['title']."</h2>
					<br />
				";
				$myrow = mysql_fetch_array($result);
				
				do 
					{
						$result_img = mysql_query("SELECT img_pre FROM fotos WHERE id='$myrow[foto]'",$db);
						$myrow_img = mysql_fetch_array($result_img);
						if ($myrow['rooms'] != 0) { $show_rooms = "<span>Номеров: </span> <strong>".$myrow['rooms']."</strong><br />"; } else { $show_rooms = ''; }
		
						echo ("
							<div class='hotelBox'>
							<div class='hotelBoxTitle'>
							<div class='hotelBoxNumber'>".$myrow['number']."</div>
							 \"".$myrow['title']."\" </div><br />
								<a href='?h=".$myrow['id']."'><img src='fotos/".$myrow_img['img_pre']."' alt='".$myrow['title']."'/></a>
								<div class='hotelBoxDesc'><br />
								<p>".$myrow['descr']."</p><br /><br />
								<div class='hotelBoxInfo'>
								".$show_rooms."
								<span>Цена: </span> <strong>".$myrow['price']."</strong>
								<a href='?h=".$myrow['id']."' class='hotelBoxMore'>Подробнее</a>
								</div>
								</div>
								<div style='clear:both;'></div>
								</div>
							");
					}
				while ($myrow = mysql_fetch_array($result));
				require_once("blocks/pages.php");
			}
				
		else
				
			{
					echo "<h2>Простите, но в этом разделе гостиниц  нет!</h2>";
			}
			
						echo ("
							<div>
							<div class='hotelBoxTitle'></div>
								<div style='clear:both;'></div>
								</div>
							");
	}
	
if (isset($search)) 
	{
		
		$country = $_GET['country'];
		$min_price = $_GET['min_price'];
		$max_price = $_GET['max_price'];
		$min_rooms = $_GET['min_rooms'];
		$max_rooms = $_GET['max_rooms'];
		
		if ($country == 'all') {
			$c = 'all';
			$country = '';
		}else{
			$c = $country;
			$country = "AND country='$country'";
		}
		
		if ($min_price == '') { $min_p = '0'; } else { $min_p = $min_price; }
		if ($min_rooms == '') { $min_rooms = ''; } else { $min_r = "AND rooms > '$min_rooms'"; }
		if ($max_price == '') { $max_price = ''; } else { $max_p = "AND price_s < '$max_price'"; }
		if ($max_rooms == '') { $max_rooms = ''; } else { $max_r = "AND rooms < '$max_rooms'"; }
		
		$result = mysql_query("SELECT * FROM hotels WHERE price_s > '".$min_p."' ".$max_p." ".$min_r." ".$max_r." ".$country." LIMIT ".$start.",".$x." ",$db);
		
		if (mysql_num_rows($result) > 0)
			{
				echo "
					<h2>Результаты поиска</h2>
					<br />
				";
				$myrow = mysql_fetch_array($result);
				
				do 
					{
						$result_img = mysql_query("SELECT img_pre FROM fotos WHERE id='$myrow[foto]'",$db);
						$myrow_img = mysql_fetch_array($result_img);
						if ($myrow['rooms'] != 0) { $show_rooms = "<span>Номеров: </span> <strong>".$myrow['rooms']."</strong><br />"; } else { $show_rooms = ''; }
		
						echo ("
							<div class='hotelBox'>
							<div class='hotelBoxTitle'>
							<div class='hotelBoxNumber'>".$myrow['number']."</div>
							 \"".$myrow['title']."\" </div><br />
								<a href='?h=".$myrow['id']."'><img src='fotos/".$myrow_img['img_pre']."' alt='".$myrow['title']."'/></a>
								<div class='hotelBoxDesc'><br />
								<p>".$myrow['descr']."</p><br /><br />
								<div class='hotelBoxInfo'>
								".$show_rooms."
								<span>Цена: </span> <strong>".$myrow['price']."</strong>
								<a href='?h=".$myrow['id']."' class='hotelBoxMore'>Подробнее</a>
								</div>
								</div>
								<div style='clear:both;'></div>
								</div>
							");
					}
				while ($myrow = mysql_fetch_array($result));
				require_once("blocks/pages.php");
			}
				
		else
				
			{
					echo "<h2>Простите, но ничего не найдено!</h2>";
			}
		
	}
	
if (isset($form))

	{
	
		if ($form == 'new')
			{
				require_once "blocks/form.php";
			}
			
		if ($form == 'send')
			{
				$result = mysql_query("SELECT email FROM admin",$db);
				$myrow = mysql_fetch_array($result);
				
				$title = $_POST['title'];
				$name = $_POST['name'];
				$email = $_POST['email'];
				$info = $_POST['info'];
				$date = date("Y-m-d H:i");
				$number = $_POST['number'];
				$sum = $_POST['sum'];
				$capa = $_POST['capa'];
				$arr = array('7','10','15','9','8');
				
				$result_villa = mysql_query('SELECT id FROM hotels WHERE number="$number"',$db);
				$villa = mysql_fetch_array($result_villa);
				
				if ($sum != $arr[$capa])
					{
						echo "<h2>Вы ввели неправильную сумму!</h2><p><a href='?main'>Вернуться на главную</a></p>";
						echo "<p><a href='?form=new&number=".$number.">или на страницу заказа</a></p>";
						exit('<br /><br /><br /></div></div></div></div><br /><br /></div></div></div></div></div></div></body></html>');
					}
				
				if (trim($title) == "" || trim($name) == "" || trim($email) == "")
					{
						echo "<h2>Не все поля заполнены!</h2><p><a href='?main'>Вернуться на главную</a></p>";
						echo "<p><a href='?form=new&number=".$number.">или на страницу заказа</a></p>";
						exit('<br /><br /><br /></div></div></div></div><br /><br /></div></div></div></div></div></div></body></html>');
					}
				
				$to = $myrow['email'];
				$subject = "Новая заявка (".$number.")";
				$body = "Новая заявка \n\n
				От: ".$name." \n
				Email: ".$email." \n
				Название: ".$title." \n
				Номер: ".$number." \n
				".$info." \n\n
				".$date."";
				
				$mail = mail($to,$subject,$body,"Content-type:text/plain; Charset=windows-1251 \r\n"."From: ".$email." \r\n");
				
				if ($mail)
					{
						echo "<h2>Письмо отправлено!</h2>";
						echo "<p><a href='?main'>Вернуться на главную</a></p>";
					}
				else
					{
						echo "<h2>Что-то пошло не так!</h2>";
						echo "<p><a href='?main'>Вернуться на главную</a></p>";
					}
				
			}
	
	
	}
	
if (isset($demand)) {
	if ($demand != 'send') {
	
		echo "<h2>Заявка на поиск гостиницы, отеля, бизнеса, недвижимости за рубежом</h2>";
		echo "<p>Если Вы не найдете необходимого Вам объекта по Вашим критериям, мы с радостью получим от Вас запрос и в короткий срок постараемся подобрать для Вас нужный Вам объект.</p>";
		require_once('blocks/demand.php');
		
	}else{
	
		$name = $_POST['name'];
		$email = $_POST['email'];
		$object = $_POST['object'];
		$country = $_POST['country'];
		$min_price = $_POST['min_price'];
		$max_price = $_POST['max_price'];
		$text = $_POST['text'];
		$capa = $_POST['capa'];
		$sum = $_POST['sum'];
		$date = date("Y-m-d H:i");
		$arr = array('7','10','15','9','8');
				
		if ($sum != $arr[$capa])
			{
				echo "<h2>Вы ввели неправильную сумму!</h2><p><a href='?main'>Вернуться на главную</a></p>";
				echo "<p><a href='?demand'>или на страницу заявки</a></p>";
				exit('<br /><br /><br /></div></div></div></div><br /><br /></div></div></div></div></div></div></body></html>');
			}
				
		if (trim($name) == "" || trim($email) == "" || trim($country) == "")
			{
				echo "<h2>Не все поля заполнены!</h2><p><a href='?main'>Вернуться на главную</a></p>";
				echo "<p><a href='?demand'>или на страницу заявки</a></p>";
				exit('<br /><br /><br /></div></div></div></div><br /><br /></div></div></div></div></div></div></body></html>');
			}
			
		$to = 'no-thx@mail.ru'; //$myrow['email'];
		$subject = "Новая заявка";
		$body = "Новая заявка \n\n
		От: ".$name." \n
		Email: ".$email." \n
		Объект: ".$object." \n
		Страна: ".$country." \n
		Цена: от ".$min_price." до ".$max_price." евро \n
		".$text." \n\n
		".$date."";
		
		$mail = mail($to,$subject,$body,"Content-type:text/plain; Charset=windows-1251 \r\n"."From: ".$email." \r\n");
				
		if ($mail)
			{
				echo "<h2>Письмо отправлено!</h2>";
				echo "<p><a href='?main'>Вернуться на главную</a></p>";
			}
		else
			{
				echo "<h2>Что-то пошло не так!</h2>";
				echo "<p><a href='?main'>Вернуться на главную</a></p>";
			}
		
	}
	
}
	
if (isset($test)) {
	
	$result = mysql_query("SELECT * FROM hotels WHERE price_s > '100000' AND price_s < '99999999' AND rooms > '3' AND rooms < '30' ",$db);
	if (mysql_num_rows($result) > 0) { echo mysql_num_rows($result); }

}


?>

<br /><br />

</div>
</div>
</div>
</div>
<br /><br />

</div>
</div>
</div>
</div>

</div>

</div>


<?php require_once("blocks/footer.php"); ?>

</body>
</html>
