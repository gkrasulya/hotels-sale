<?php 
require_once("blocks/db.php"); 
require_once("blocks/variables.php");
$result_meta = mysql_query("SELECT meta_k,meta_d FROM main",$db);
$myrow_meta = mysql_fetch_array($result_meta);
?><!--MMDW 1 -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta mmdw="0"  http-equiv="Content-Type" content="text/html; charset=windows-1251" >

<meta mmdw="1"  name="keywords" content="европа продажа недвижимости, коммерческая недвижимость европа, коммерческая недвижимость в Испании, коммерческая недвижимость в Бельгии, недвижимость в Болгарии, коммерческая недвижимость в Болгарии, коммерческая недвижимость в Германии, коммерческая недвижимость в Италии, коммерческая недвижимость в Швейцарии,коммерческая недвижимость во Франции,  недвижимость франции, продажа бизнеса европа, недвижимость в бельгии, недвижимость германия, недвижимость греция, недвижимость испании, недвижимость италия, гостиничный бизнес,  недвижимость, Продажа Гостиниц в Европе, Покупка Гостиниц в Европе, продажа недвижимости в за рубежом, продажа готового бизнеса Европе, зарубежная недвижимость, недвижимость в Европе, недвижимость за рубежом, Гостиничный бизнес в Европе, недвижимость в Австрии, недвжимость в Испании, недвижимость в Греции, недвижимость в Швейцарии, недвижимость в Германии, недвижимость в Бельгии, недвижимость во Франции, недвижимость в Италии, недвижимость в Англии, недвижимость в Париже"> 

<meta mmdw="2"  name="description" content="недвижимость в европе, готовый бизнес в Европе, продажа готового бизнеса за рубежом, покупка бизнеса в Европе, приобретение Европейского паспорта, вида на жительство, покупка недвижимости в Европе, открытие фирм и счетов в Европе, купить бизнес в Европе,">

<title>Hotels-sale.ru: <!--MMDW 2 --><?php echo $title; ?><!--MMDW 3 --> - Продажа Отелей и Гостиниц в Европе, Покупка Гостиниц в Европе </title>
		<!--MMDW 4 --><style type='text/css'>
		
		#search_form {
			color: #666;
			font-size:12px;
		}
		
		#search_form label {
		margin-bottom: 3px;
		display: block;
		}
		
		#search_form legend {
			font-size: 13px;
			color: #333;
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
		</style><!--MMDW 5 -->
        

<link mmdw="3"  href='css/styles.css' type='text/css' rel='stylesheet' />
<!--MMDW 6 --><script type='text/javascript' src='scripts/js.js'></script><!--MMDW 7 -->
<!--MMDW 8 --><script type='text/javascript' src='scripts/jquery.js'></script><!--MMDW 9 -->
<!--MMDW 10 --><script type="text/javascript">
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
</script><!--MMDW 11 -->


</head>

<body>
    <div mmdw="4"  id='overlay' onclick='closeImg()'>
    </div>
    
    <div mmdw="5"  id='img_div' onmouseover='showControl()' onmouseout='hideControl()'>
        <img mmdw="6"  src='' id='img' onload='loaded()'/>
        <img mmdw="7"  src='doc/loading.gif' id='loading'/>
        <div mmdw="8"  id='close' onclick='closeImg()'>X</div>
        <div mmdw="9"  id='control' style=' text-align: center; position: absolute; background:url('bg.gif'); height:25px; width:100%; left:0px; bottom:0px; display: none; '>
            <span mmdw="10"  id='prev' onclick="changeImg(first(next(current.parentNode)))"></span>
            <span mmdw="11"  id='prev' onclick="changeImg((first(prev(current.parentNode))) || first(prev(last(current.parentNode.parentNode))))">&laquo; назад</span>
            <span mmdw="12"  id='foto_title'><!--MMDW 12 --><?php echo $myrow['title']; ?><!--MMDW 13 --></span>
            <span mmdw="13"  id='next' onclick="changeImg((first(next(window.current.parentNode))) || first(first(current.parentNode.parentNode)))">вперед &raquo;</span>
        </div>
    </div>

<!--MMDW 14 --><?php require_once("blocks/header.php"); ?><!--MMDW 15 -->

<div mmdw="14"  id="wrapper">

<!--MMDW 16 --><?php require_once("blocks/navigation.php"); ?><!--MMDW 17 -->

<div mmdw="15"  id="content">

<div mmdw="16"  class="corner_lt">
<div mmdw="17"  class="corner_rt">
<div mmdw="18"  class="corner_rb">
<div mmdw="19"  class="corner_lb">

<br /><br />
<div mmdw="20"  id="main_cont">
<div mmdw="21"  id="cont_rt">
<div mmdw="22"  id="cont_rb">
<div mmdw="23"  id="cont_lb">
<br />

<!--MMDW 18 --><?php

if (!isset($h) && !isset($r) && !isset($c) && !isset($about) && !isset($qwe) && !isset($form) && !isset($new) && !isset($getmail) && !isset($search))
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
							 \"".$myrow['title']."\", ".$myrow['town']." </div><br />
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
							 \"".$myrow['title']."\", ".$myrow['town']." </div><br />
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
							 \"".$myrow['title']."\", ".$myrow['town']." </div><br />
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
		$result = mysql_query("SELECT * FROM hotels WHERE CONCAT(title,text) LIKE '%".$search."%' ".$s." LIMIT ".$start.",".$x."",$db);
		$result_c = mysql_query("SELECT id FROM countries WHERE title LIKE '%".$search."%'",$db);
		$myrow_c = mysql_fetch_array($result_c);
		$result2 = mysql_query("SELECT * FROM hotels WHERE country = '$myrow_c[id]'",$db);
		$myrow2 = mysql_fetch_array($result2);
		
		if (mysql_num_rows($result) > 0 || mysql_num_rows($result2) > 0) {
			echo "
				<div id='sort_by'>Сортировать по: 
				<a href='?search=".$search."&amp;s=town&amp;page=".$page."' ".$sort_by_town.">городам</a>, 
				<a href='?search=".$search."&amp;s=price&amp;page=".$page."' ".$sort_by_price.">стоимости</a>
				</div>
				<br/>
				<h2>".$title."</h2>
				<br />
			";			
		}
		
		if (mysql_num_rows($result) > 0)
			{
				$myrow = mysql_fetch_array($result);
				
				do 
					{
						$title = str_replace($search, "<span style='font-style: italic; border-bottom: 2px dotted #6699ff;'>".$search."</span>", $myrow['title']);
						if ($myrow['town'] != '') {
							$town = ', '.$myrow['town'];
						}else{
							$town = '';
						}
						if (strpos($myrow['text'], $search) >= 0 || strpos($myrow['text'], ucfirst($search)) >= 0) {
							$pos = strpos($myrow['text'] , strtolower($search));
							if ($pos == '') { $pos = strpos($myrow['text'], ucfirst($search)); }
							$pos -= 150;
							if ($pos < 0) { $pos = 0; }
							$text = substr($myrow['text'], $pos, 300);
							$text = '...'.$text.'...';
							$text = eregi_replace($search, "<span style='font-style: italic; font-weight: bold;'>".$search."</span>", $text);
						} else {
							$text = $myrow['descr'];
						}
						$result_img = mysql_query("SELECT img_pre FROM fotos WHERE id='$myrow[foto]'",$db);
						$myrow_img = mysql_fetch_array($result_img);
						if ($myrow['rooms'] != 0) { $show_rooms = "<span>Номеров: </span> <strong>".$myrow['rooms']."</strong><br />"; } else { $show_rooms = ''; }
						
						echo ("
							<div class='hotelBox'>
							<div class='hotelBoxTitle'>
							<div class='hotelBoxNumber'>".$myrow['number']."</div>
							 \"".$title."\"".$town." </div><br />
								<a href='?h=".$myrow['id']."'><img src='fotos/".$myrow_img['img_pre']."' alt='".$myrow['title']."'/></a>
								<div class='hotelBoxDesc'><br />
								<p>".$text."</p><br /><br />
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
				
		if (mysql_num_rows($result2) > 0)
			{
				$myrow2 = mysql_fetch_array($result2);
				
				do 
					{
						$title = str_replace($search, "<span style='font-style: italic; border-bottom: 2px dotted #6699ff;'>".$search."</span>", $myrow2['title']);
						
						if ($myrow2['town'] != '') {
							$town = ', '.$myrow2['town'];
						}else{
							$town = '';
						}
						if (strpos($myrow2['text'], $search) >= 0 || strpos($myrow2['text'], ucfirst($search)) >= 0) {
							$pos = strpos($myrow2['text'] , strtolower($search));
							if ($pos == '') { $pos = strpos($myrow['text'], ucfirst($search)); }
							$pos -= 150;
							if ($pos < 0) { $pos = 0; }
							$text = substr($myrow2['text'], $pos, 300);
							$text = '...'.$text.'...';
							$text = eregi_replace($search, "<span style='font-style: italic; font-weight: bold;'>".$search."</span>", $text);
						} else {
							$text = $myrow2['descr'];
						}
						$result_img = mysql_query("SELECT img_pre FROM fotos WHERE id='$myrow2[foto]'",$db);
						$myrow_img = mysql_fetch_array($result_img);
						if ($myrow2['rooms'] != 0) { $show_rooms = "<span>Номеров: </span> <strong>".$myrow2['rooms']."</strong><br />"; } else { $show_rooms = ''; }
						
						echo ("
							<div class='hotelBox'>
							<div class='hotelBoxTitle'>
							<div class='hotelBoxNumber'>".$myrow2['number']."</div>
							 \"".$title."\"".$town." </div><br />
								<a href='?h=".$myrow2['id']."'><img src='fotos/".$myrow_img['img_pre']."' alt='".$myrow2['title']."'/></a>
								<div class='hotelBoxDesc'><br />
								<p>".$text."</p><br /><br />
								<div class='hotelBoxInfo'>
								".$show_rooms."
								<span>Цена: </span> <strong>".$myrow2['price']."</strong>
								<a href='?h=".$myrow2['id']."' class='hotelBoxMore'>Подробнее</a>
								</div>
								</div>
								<div style='clear:both;'></div>
								</div>
							");
						}
					while ($myrow2 = mysql_fetch_array($result2));
					require_once("blocks/pages.php");
				
				}				
				
			if (mysql_num_rows($result) == 0 && mysql_num_rows($result2) == 0)
				
				{
					echo "<h2>Простите, но по запросу \"".$search."\" ничего не найдено!</h2>";
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
						echo "<h2>Вы ввели неправильну сумму!</h2><p><a href='?main'>Вернуться на главную</a></p>";
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


?><!--MMDW 19 -->

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


<!--MMDW 20 --><?php require_once("blocks/footer.php"); ?><!--MMDW 21 -->

</body>
</html>
<!-- MMDW:success -->