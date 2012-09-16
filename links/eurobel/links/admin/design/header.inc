<?php
// *******************************************************************
// формируем данные для заголовка страницы
// *******************************************************************
// по умолчанию, если выключено отображение последних добавленных ссылок
$page_title = "Каталог LinkExchanger v2.0";
$page_keyword = "каталог, обмен ссылками";
$page_description = "Обмен ссылками. Каталог на основе скрипта LinkExchanger v2.0";


if($_SESSION['flag_search'] != 0) { // для результата поиска
$page_title = "Результат поиска по каталогу";
$page_keyword = "";
$page_description = "";
}
// -------------------------------------------------------------------------------
if($_SESSION['vis_last_links']!="Нет" AND !$_GET['category'] AND $_SESSION['flag_search']==0) { // для раздела последних добавленных ссылок
$page_title = "Последние добавленные в каталог ссылки";
$page_keyword = "";
$page_description = "";
}
// -------------------------------------------------------------------------------
if($_GET['category']) { // для ссылок в категориях
for($i=0;$i<count($categories_array);$i++) {
$row_categories = explode("|", $categories_array[$i]);
if($row_categories[0]==$_GET[category]) {
$page_title = "$row_categories[1]"." обмен ссылками";
$page_keyword = trim($row_categories[2]);
$page_description = trim($row_categories[3]);
break;
}
} // end for
} // end if
// -------------------------------------------------------------------------------
if(substr_count("$_SERVER[SCRIPT_NAME]", "submit.php")!=0) { // если это форма
$page_title = "Обмен ссылками. Заполните эту форму.";
$page_keyword = "форма";
$page_description = "описание формы";
}
// *********************************************************************
// закончили формировать данные для заголовка страницы
// *********************************************************************
// *********************************************************************
// выводим заголовок
// *********************************************************************
echo "<!DOCTYPE HTML PUBLIC \'-//W3C//DTD HTML 4.0 Transitional//EN\'>\n
<html><head><title>$page_title</title>
<meta http-equiv='Content-Type' content='text/html; charset=windows-1251'>
<meta name='keywords' content='$page_keyword'>
<meta name='description' content='$page_description'>
<meta name='robot' content='all'>
<link rel='stylesheet' type='text/css' href='admin/design/main.css'>
<link rel='stylesheet' type='text/css' href='admin/design/form.css'>
</head>\n";
// *********************************************************************
// выводим заголовок
// *********************************************************************
?>
<body>
<p><b><a href="http://www.hotels-sale.ru/links/" style="text-decoration: none">
<font color="#000000" size="6">КАТАЛОГ ССЫЛОК </font><font size="6">
<span lang="en-us"><font color="#000000"></font></span></font></a></b>
</p>
</p>
<table border="0" width="100%" id="table1" cellpadding="0" cellspacing="0" bgcolor="#428DFF">
	<tr>
		<td>&nbsp;</td>
	</tr>
</table>

