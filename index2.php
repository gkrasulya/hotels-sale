<?php 
require_once("blocks/db.php"); 
require_once("blocks/variables.php");
$result_meta = mysql_query("SELECT meta_k,meta_d FROM main",$db);
$myrow_meta = mysql_fetch_array($result_meta);
 if (!isset($h) && !isset($r) && !isset($c) && !isset($about) && !isset($qwe) && !isset($form) && !isset($new) && !isset($getmail) && !isset($search) && !isset($test) && !isset($demand)) { 
 $bg = "style='background: white url(/img/map6.gif) top left'";
} elseif (isset($about) || isset($demand)) {
 $bg = "style='background: white url(/img/map6.gif) top left'";
} else {
 $bg = "style='background: white url(/img/map6.gif) top left'";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" >

<meta name="keywords" content="�������, ������� ������������ �� 
�������, ������������ � ������, ������� ������� � ������, ������� ������� �� 
�������, ������� ������� �� �������, ���������� ������������, ������������ ������������, ������� ������������ �������, ������� �������� �������, ������� ������� � �������, ������� ������� � �������, ������� ������� � ��������, ������� ������� � �������, ������� ������� �� �������, ������� ������� � ������, ����������� ������ � ������, ������� ������ � �������� � ������, �����������,������������ � ������, ������� ������ ������, ������� ������� � ������, ��� � ������, �������� � ������, ������������ ������������ ������, ����� ������������ ������, ���������� � ������,
������������ � �������, ������������ � �������, ������������ � ������, 
������������ �� �������, ������������ � ������, ������������ � ��������, 
������������ � ���������, ������������ � �������, ������������ � ������, 
������������ � ���������, ������������ � �����, ������������ � ������, ������������ � ��������, ������������ � ������, ������� ������������ ������������, ������������ 
������������ �������� � ���� �� ����������, �������� ���� � ������ � 
������, ������ ������ � ������, ������ ������������ � 
������, ������� ����� � ������ , ������� ���� � ������ , �������� ��� �� 
���������� � ������ , �������� ����������� �������, ������ ����������, ���������� � ���������, ���������� �� �������, ���������� � ��������, ���������� � �������,���������� � ������, ���������� � ��������, ���������� � �������,���������� � ������, ���������� � ������,
���������� � ������, �������, ������, ��������, �������, ���������, ������������ ������������"> 

<meta name="description" content="������������ � ������, ������� ������ � ������, ������� �������� ������� �� �������, ������� ������� � ������, ������������ ������������ ��������, ���� �� ����������, ������� ������������ � ������, �������� ���� � ������ � ������, ������ ������ � ������,">

<title>Hotels-sale.ru: - ������� ������ � �������� � ������, ������� �������� � ������, ���������� ������������ </title>

        
<link href='/styles.css' type='text/css' rel='stylesheet' />
<!--[if IE 6]>
	<link href="ie6.css" media="screen" rel="stylesheet" type="text/css" />
<![endif]--> 

<link href='/print.css' type='text/css' rel='stylesheet' media="print" />

<script type='text/javascript' src='/scripts/js.js'></script>
<script type='text/javascript' src='/scripts/jquery.js'></script>
</head>

<body>
    <div id='overlay' onclick='closeImg()' style='display: none;'>
    </div>
    
    <div id='img_div' onmouseover='showControl()' onmouseout='hideControl()' style='display: none;'>
        <img src='/' id='img' onload='loaded()'/>
        <img src='/doc/loading.gif' id='loading'/>
        <div id='close' onclick='closeImg()'>X</div>
        <div id='control' style=' text-align: center; position: absolute; background:url(/'bg.gif'); height:25px; width:100%; left:0px; bottom:0px; display: none; '>
            <span id='prev' onclick="changeImg(first(next(current.parentNode)))"></span>
            <span id='prev' onclick="changeImg((first(prev(current.parentNode))) || first(prev(last(current.parentNode.parentNode))))">&laquo; �����</span>
            <span id='foto_title'><?php echo $myrow['title']; ?></span>
            <span id='next' onclick="changeImg((first(next(window.current.parentNode))) || first(first(current.parentNode.parentNode)))">������ &raquo;</span>
        </div>
    </div>

<div id="wrapper">
	<div id="header">
		<? require_once "blocks/header2.php" ?>
    </div>
    
    <div style="clear: both">&nbsp;</div>
    
    <ul id="navigation">
    	<? require_once "blocks/navigation.php" ?>
    	
  	  <div style="clear: both">&nbsp;</div>
    </ul>
    
	<? require_once "blocks/big_banner.php" ?>
    
    <table id="content" cellpadding="0" cellspacing="0">
    <tr>
    
    <td id="sideBar" valign="top">
    	
    	<? require_once "blocks/medium_banner.php" ?>
        
        <div id="countries">
        	<? require_once "blocks/countries.php" ?>
        </div>
        
        <div id="search">
        	<? require_once "blocks/search.php" ?>
        </div>
        
        <div id="subscribe">
        	<? require_once "blocks/subscribe.php" ?>
        </div>
        
        <? require_once "blocks/subscribe_banner.php" ?>
            
        <? require_once "blocks/random.php" ?>
    
    </td>
    
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
    
    <td id="mainBar" valign="top">
    
    <table cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="40" width="40" style="background: url(/new_images/table_lt.gif) top left no-repeat"></td>
            	<td style="background: url(/new_images/table_t_bg.gif) top left repeat-x"></td>
            	<td width="40" style="background: url(/new_images/table_rt.gif) top left no-repeat"></td>
            </tr>
        	<tr>
            	<td style="background: url(/new_images/table_l_bg.gif) top left repeat-y"></td>
            	<td id="contentTD" valign="top" <?php echo $bg; ?>>
            		
				<?php
                if (!isset($h)
                	&& ! isset($r)
                	&& ! isset($c)
                	&& ! isset($about)
                	&& ! isset($qwe)
                	&& ! isset($form)
                	&& ! isset($new)
                	&& ! isset($getmail)
                	&& ! isset($search)
                	&& ! isset($test)
                	&& ! isset($demand)
                	&& ! isset($slug)
                	&& ! isset($adv)
                	&& ! isset($page_name)
                	&& ! isset($sitemap)
                	&& ! isset($text_name))	{
                		require_once "pages/index.php"; // INDEX PAGE
                }
                
        #### common
        
        if (isset($page_name)) {
        	require_once "pages/$page_name.php";
        }
				
				##############################################
				
				if (isset($sitemap)) {
					require_once 'pages/sitemap.php';
				}
				
				##############################################
				
				if (isset($adv)) {
					require_once "pages/adv.php";
				}
				
				if (isset($getmail)) {
					require_once "pages/getmail.php"; // GET MAIL
				}
				
				##############################################
		
				if (isset($about)) {
					require_once "pages/about.php"; // ABOUT PAGE
				}
				
				##############################################
				
		        if (isset($h) || isset($_GET['slug'])) {
		        	require_once "pages/hotel.php"; // SHOW HOTEL
		        }
		        
				##############################################
				
				if (isset($new)) {
					require_once "pages/new_hotels.php"; // NEW HOTELS
				}
				
				##############################################
				
				if (isset($r)) {
					require_once "pages/region.php"; // HOTELS OF REGION
				}
				
				##############################################
					

				if (isset($qwe)) {
					require_once "pages/country.php"; // HOTELS OF COUNTRY
				}
				
				##############################################
				
				if (isset($search)) {
					require_once "pages/search.php"; // SEARCH HOTELS
				}
			
				###############################################
				
				if (isset($form)) {
					require_once "pages/form.php";
				}
	
				###############################################
	
				if (isset($demand)) {
					require_once "pages/demand.php";
				}
	
				###############################################
	
				if (isset($text_name)) {
					$text_path = "texts/{$text_name}.php";
					require_once $text_path;
				}
				
?>

<p align="center">
	<br><br><br>&nbsp;
</p>

<p align="center">
	<script type="text/javascript"><!--
		google_ad_client = "pub-4721279717108882";
		/* 468x60, ??????? 04.04.10 */
		google_ad_slot = "9591060253";
		google_ad_width = 468;
		google_ad_height = 60;
		//-->
		</script>
		<script type="text/javascript"
		src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
	</script>
</td>

<td style="background: url(/new_images/table_r_bg.gif) top left repeat-y"></td>
</tr>

<tr>
	<td height="40" style="background: url(/new_images/table_lb.gif) top left no-repeat"></td>
	<td style="background: url(/new_images/table_b_bg.gif) top left repeat-x"></td>
	<td style="background: url(/new_images/table_rb.gif) top left no-repeat"></td>
</tr>

</table>
    
</td>

</tr>
</table>

   
    <div style='width: 100%; background: white; height: 50px; float: left; position: relative; text-align: right;'><font size="1">
<p>
  
    </div>

    <?php include('ireklama.php'); ?>
     
    <div id="footer">

    	<div id='counters' style='float: right; position: relative; margin-right: 20px; margin-top: 10px;'>
        	<p>
				<? require_once "blocks/counters.php" ?>
            </p> 
      </div>
    	<span style='color: white; margin-top: 10px; float: left; margin-left: 20px; position: relative;'>
    		copyright &copy; 2008-2009 <a style='color: white; text-decoration: underline' href="">hotels-sale.ru</a>.
    		&nbsp;&nbsp;<a style='color: white; text-decoration: underline' href="/sitemap" title="����� �����">����� �����</a>.
    	</span>
    </div>
    
    <div style="clear: both;"></div>

</div>

</body>
</html>