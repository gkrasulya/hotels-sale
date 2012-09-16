<?php
error_reporting(0);
@$old_abort = ignore_user_abort(true);
session_start();
include "adminic.php";
include "functions/check.php";
include "functions/cut.php";
include "functions/main.php";
// Обрисуем, где находимся
$place = "НЕДОСТУПНЫЕ ССЫЛКИ";
// ---------------------------------------------------------------------------------------------------------------------------------
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html><head><title>LinkExchanger Full 2.0 Admin Area</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<meta name="robots" content="noindex">
<link rel="stylesheet" type="text/css" href="admin.css">
<script language="javascript">function checkAll(){ for (var i=0;i<document.forms[2].elements.length;i++) { var e=document.forms[2].elements[i]; if ((e.name != 'allbox') && (e.type=='checkbox')) { e.checked=document.forms[2].allbox.checked; } } } </script>
</head>
<body>
<?php
echo "<table cellspacing=4 cellpadding=0 width=800>
      <tr><td colspan=2 valign=top align=left>";
// Подключаем меню
include "menu.php";
echo "</td></tr><tr><td colspan=2 valign=top align=left></td></tr>
      <tr><td valign=top align=left>";
// ---------------------------------------------------------------------------------------------------------------------------------
// Готовим временный массив для функции разбиения на страницы  из активных ссылок well и activ
$total_rows = 0;

$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$base_array = file("data/base.dat");
$categories_array = file("data/categories.dat");
flock($lock, LOCK_UN);
fclose($lock);
} else {
$_SESSION['error'] = "Не могу заблокировать служебный файл data/base.lck !!!";
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=error.php'>
	  </HEAD></HTML>";
exit();
}

$all_categories = count($categories_array);
// сортировка по алфавиту ---------------------------------------
for($h=0;$h<$all_categories;$h++) { // выбор поля для сортировки
list($id_category,$category_name,$category_keywords,$category_description) = explode("|", $categories_array[$h]);
$tmp[$h] = array (field => $category_name, ext1 => $id_category, ext2 => "$category_keywords|$category_description");
}
sort($tmp, SORT_REGULAR); // сортировка
for($h=0;$h<count($tmp);$h++) { // создание отсортированного массива
$categories_array[$h] = ("{$tmp[$h][ext1]}"."|"."{$tmp[$h][field]}"."|"."{$tmp[$h][ext2]}");
}
unset($tmp);
// сортировка по алфавиту ---------------------------------------

// отбираем noanswer
for($i=0;$i<count($base_array);$i++) {
$row_base = explode("|", $base_array[$i]);
if ($row_base[16]=="noanswer" AND strlen($row_base[2])>7) { $tmp_array[$total_rows] = "$base_array[$i]"; $total_rows++; }
}

if($_SESSION['adm_sort_select']=="Да") {
// сортировка базы по дате проверки---------------------------------------
for($h=0;$h<count($tmp_array);$h++) { // выбор поля для сортировки
list($id,$nick,$urlink,$mail,$category,$htmltext,$htmlimage,$check_date,$check_result,$check_out_links,$check_cy,$check_pr,$check_pr_main,$check_tag_noindex,$check_meta_robots,$check_file_robots,$status,$ip_user,$admin_comment) = explode("|", $tmp_array[$h]);
$tmp[$h] = array (field => $check_date, ext1 => "$id|$nick|$urlink|$mail|$category|$htmltext|$htmlimage", ext2 => "$check_result|$check_out_links|$check_cy|$check_pr|$check_pr_main|$check_tag_noindex|$check_meta_robots|$check_file_robots|$status|$ip_user|$admin_comment");
}
sort($tmp, SORT_REGULAR); // сортировка
for($h=0;$h<count($tmp);$h++) { // создание отсортированного массива
$tmp_array[$h] = ("{$tmp[$h][ext1]}"."|"."{$tmp[$h][field]}"."|"."{$tmp[$h][ext2]}");
}
// сортировка базы по дате проверки ---------------------------------------
if($_SESSION['adm_sort_2']=="Убывание") { $tmp_array = array_reverse($tmp_array); } // перевернем сортированный
} else {
$tmp = array();
// сортировка базы по дате добавления---------------------------------------
for($h=0;$h<count($tmp_array);$h++) { // выбор поля для сортировки
list($id,$nick,$urlink,$mail,$category,$htmltext,$htmlimage,$check_date,$check_result,$check_out_links,$check_cy,$check_pr,$check_pr_main,$check_tag_noindex,$check_meta_robots,$check_file_robots,$status,$ip_user,$admin_comment) = explode("|", $tmp_array[$h]);
$tmp[$h] = array (field => $id, ext1 => "$nick|$urlink|$mail|$category|$htmltext|$htmlimage|$check_date|$check_result|$check_out_links|$check_cy|$check_pr|$check_pr_main|$check_tag_noindex|$check_meta_robots|$check_file_robots|$status|$ip_user|$admin_comment");
}
sort($tmp, SORT_REGULAR); // сортировка
for($h=0;$h<count($tmp);$h++) { // создание отсортированного массива
$tmp_array[$h] = ("{$tmp[$h][field]}"."|"."{$tmp[$h][ext1]}");
}
// сортировка базы  по дате добавления---------------------------------------
if($_SESSION['adm_sort']=="Убывание") { $tmp_array = array_reverse($tmp_array); } // перевернем несортированный
}

// Подключаем шкалу разбиения на страницы
include "scale.php";

echo "</td><td align=right valign=top>";
// Подключаем меню для работы с группой
include "group.php";

echo "</td></tr><tr><td valign=top align=left colspan=2>";
// Выводим данные постранично
for($j=$from_row;$j<=$to_row;$j++) {

$row_base = explode("|", $tmp_array[$j]);
if ($tmp_array[$j]) { include "card.php"; echo "<br>";}
}
echo "<br>";
// Подключаем конец формы работы с группой
include "groupend.php";

// Подключаем шкалу разбиения на страницы
include "scale.php";
// ---------------------------------------------------------------------------------------------------------------------------------
echo "</td></tr></table>";
@ignore_user_abort($old_abort);
?>
</body>
</html>