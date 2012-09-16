<?php
error_reporting(0);
@$old_abort = ignore_user_abort(true);
session_start();
include "adminic.php";
include "functions/check.php";
include "functions/cut.php";
include "functions/main.php";
// Обрисуем, где находимся
$place = "ПОИСК";
// ---------------------------------------------------------------------------------------------------------------------------------
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html><head><title>LinkExchanger Full 2.0 Admin Area</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<meta name="robots" content="noindex">
<link rel="stylesheet" type="text/css" href="admin.css">
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
// Готовим временный массив для функции разбиения на страницы найденных по запросу ссылок
$total_rows = 0;

$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$base_array = file("data/base.dat");
$categories_array = file("data/categories.dat");
$trash_array = file("data/trash.dat");
$black_array = file("data/black.dat");
$moder_array = file("data/moder.dat");
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
$tmp = array();
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

// -----------------------------------------------------------------------------
if($_SESSION['adm_sort_select']=="Да") { // если вкл. по дате проверки

// сортировка базы по дате проверки---------------------------------------
$tmp = array();
for($h=0;$h<count($base_array);$h++) { // выбор поля для сортировки
list($id,$nick,$urlink,$mail,$category,$htmltext,$htmlimage,$check_date,$check_result,$check_out_links,$check_cy,$check_pr,$check_pr_main,$check_tag_noindex,$check_meta_robots,$check_file_robots,$status,$ip_user,$admin_comment) = explode("|", $base_array[$h]);
$tmp[$h] = array (field => $check_date, ext1 => "$id|$nick|$urlink|$mail|$category|$htmltext|$htmlimage", ext2 => "$check_result|$check_out_links|$check_cy|$check_pr|$check_pr_main|$check_tag_noindex|$check_meta_robots|$check_file_robots|$status|$ip_user|$admin_comment");
}
sort($tmp, SORT_REGULAR); // сортировка
for($h=0;$h<count($tmp);$h++) { // создание отсортированного массива
$base_array[$h] = ("{$tmp[$h][ext1]}"."|"."{$tmp[$h][field]}"."|"."{$tmp[$h][ext2]}");
}
unset($tmp);
// сортировка базы по дате проверки ---------------------------------------
// сортировка корзины по дате проверки---------------------------------------
$tmp = array();
for($h=0;$h<count($trash_array);$h++) { // выбор поля для сортировки
list($id,$nick,$urlink,$mail,$category,$htmltext,$htmlimage,$check_date,$check_result,$check_out_links,$check_cy,$check_pr,$check_pr_main,$check_tag_noindex,$check_meta_robots,$check_file_robots,$status,$ip_user,$admin_comment) = explode("|", $trash_array[$h]);
$tmp[$h] = array (field => $check_date, ext1 => "$id|$nick|$urlink|$mail|$category|$htmltext|$htmlimage", ext2 => "$check_result|$check_out_links|$check_cy|$check_pr|$check_pr_main|$check_tag_noindex|$check_meta_robots|$check_file_robots|$status|$ip_user|$admin_comment");
}
sort($tmp, SORT_REGULAR); // сортировка
for($h=0;$h<count($tmp);$h++) { // создание отсортированного массива
$trash_array[$h] = ("{$tmp[$h][ext1]}"."|"."{$tmp[$h][field]}"."|"."{$tmp[$h][ext2]}");
}
unset($tmp);
// сортировка корзины по дате проверки ---------------------------------------
// сортировка блэк-листа по дате проверки---------------------------------------
$tmp = array();
for($h=0;$h<count($black_array);$h++) { // выбор поля для сортировки
list($id,$nick,$urlink,$mail,$category,$htmltext,$htmlimage,$check_date,$check_result,$check_out_links,$check_cy,$check_pr,$check_pr_main,$check_tag_noindex,$check_meta_robots,$check_file_robots,$status,$ip_user,$admin_comment) = explode("|", $black_array[$h]);
$tmp[$h] = array (field => $check_date, ext1 => "$id|$nick|$urlink|$mail|$category|$htmltext|$htmlimage", ext2 => "$check_result|$check_out_links|$check_cy|$check_pr|$check_pr_main|$check_tag_noindex|$check_meta_robots|$check_file_robots|$status|$ip_user|$admin_comment");
}
sort($tmp, SORT_REGULAR); // сортировка
for($h=0;$h<count($tmp);$h++) { // создание отсортированного массива
$black_array[$h] = ("{$tmp[$h][ext1]}"."|"."{$tmp[$h][field]}"."|"."{$tmp[$h][ext2]}");
}
unset($tmp);
// сортировка блэк-листа по дате проверки ---------------------------------------
// сортировка модерации по дате проверки---------------------------------------
$tmp = array();
for($h=0;$h<count($moder_array);$h++) { // выбор поля для сортировки
list($id,$nick,$urlink,$mail,$category,$htmltext,$htmlimage,$check_date,$check_result,$check_out_links,$check_cy,$check_pr,$check_pr_main,$check_tag_noindex,$check_meta_robots,$check_file_robots,$status,$ip_user,$admin_comment) = explode("|", $moder_array[$h]);
$tmp[$h] = array (field => $check_date, ext1 => "$id|$nick|$urlink|$mail|$category|$htmltext|$htmlimage", ext2 => "$check_result|$check_out_links|$check_cy|$check_pr|$check_pr_main|$check_tag_noindex|$check_meta_robots|$check_file_robots|$status|$ip_user|$admin_comment");
}
sort($tmp, SORT_REGULAR); // сортировка
for($h=0;$h<count($tmp);$h++) { // создание отсортированного массива
$moder_array[$h] = ("{$tmp[$h][ext1]}"."|"."{$tmp[$h][field]}"."|"."{$tmp[$h][ext2]}");
}
unset($tmp);
// сортировка модерации по дате проверки ---------------------------------------
if($_SESSION['adm_sort_2']=="Убывание") { // перевернем сортированные
$base_array = array_reverse($base_array);
$trash_array = array_reverse($trash_array);
$black_array = array_reverse($black_array);
$moder_array = array_reverse($moder_array);
}

} else { // иначе, если выкл. по дате проверки

// сортировка базы по дате добавления---------------------------------------
$tmp = array();
for($h=0;$h<count($base_array);$h++) { // выбор поля для сортировки
list($id,$nick,$urlink,$mail,$category,$htmltext,$htmlimage,$check_date,$check_result,$check_out_links,$check_cy,$check_pr,$check_pr_main,$check_tag_noindex,$check_meta_robots,$check_file_robots,$status,$ip_user,$admin_comment) = explode("|", $base_array[$h]);
$tmp[$h] = array (field => $id, ext1 => "$nick|$urlink|$mail|$category|$htmltext|$htmlimage|$check_date|$check_result|$check_out_links|$check_cy|$check_pr|$check_pr_main|$check_tag_noindex|$check_meta_robots|$check_file_robots|$status|$ip_user|$admin_comment");
}
sort($tmp, SORT_REGULAR); // сортировка
for($h=0;$h<count($tmp);$h++) { // создание отсортированного массива
$base_array[$h] = ("{$tmp[$h][field]}"."|"."{$tmp[$h][ext1]}");
}
unset($tmp);
// сортировка базы  по дате добавления---------------------------------------
// сортировка корзины по дате добавления---------------------------------------
$tmp = array();
for($h=0;$h<count($trash_array);$h++) { // выбор поля для сортировки
list($id,$nick,$urlink,$mail,$category,$htmltext,$htmlimage,$check_date,$check_result,$check_out_links,$check_cy,$check_pr,$check_pr_main,$check_tag_noindex,$check_meta_robots,$check_file_robots,$status,$ip_user,$admin_comment) = explode("|", $trash_array[$h]);
$tmp[$h] = array (field => $id, ext1 => "$nick|$urlink|$mail|$category|$htmltext|$htmlimage|$check_date|$check_result|$check_out_links|$check_cy|$check_pr|$check_pr_main|$check_tag_noindex|$check_meta_robots|$check_file_robots|$status|$ip_user|$admin_comment");
}
sort($tmp, SORT_REGULAR); // сортировка
for($h=0;$h<count($tmp);$h++) { // создание отсортированного массива
$trash_array[$h] = ("{$tmp[$h][field]}"."|"."{$tmp[$h][ext1]}");
}
unset($tmp);
// сортировка корзины  по дате добавления---------------------------------------
// сортировка блэк-листа по дате добавления---------------------------------------
$tmp = array();
for($h=0;$h<count($black_array);$h++) { // выбор поля для сортировки
list($id,$nick,$urlink,$mail,$category,$htmltext,$htmlimage,$check_date,$check_result,$check_out_links,$check_cy,$check_pr,$check_pr_main,$check_tag_noindex,$check_meta_robots,$check_file_robots,$status,$ip_user,$admin_comment) = explode("|", $black_array[$h]);
$tmp[$h] = array (field => $id, ext1 => "$nick|$urlink|$mail|$category|$htmltext|$htmlimage|$check_date|$check_result|$check_out_links|$check_cy|$check_pr|$check_pr_main|$check_tag_noindex|$check_meta_robots|$check_file_robots|$status|$ip_user|$admin_comment");
}
sort($tmp, SORT_REGULAR); // сортировка
for($h=0;$h<count($tmp);$h++) { // создание отсортированного массива
$black_array[$h] = ("{$tmp[$h][field]}"."|"."{$tmp[$h][ext1]}");
}
unset($tmp);
// сортировка блэк-листа  по дате добавления---------------------------------------
// сортировка модерации по дате добавления---------------------------------------
$tmp = array();
for($h=0;$h<count($moder_array);$h++) { // выбор поля для сортировки
list($id,$nick,$urlink,$mail,$category,$htmltext,$htmlimage,$check_date,$check_result,$check_out_links,$check_cy,$check_pr,$check_pr_main,$check_tag_noindex,$check_meta_robots,$check_file_robots,$status,$ip_user,$admin_comment) = explode("|", $moder_array[$h]);
$tmp[$h] = array (field => $id, ext1 => "$nick|$urlink|$mail|$category|$htmltext|$htmlimage|$check_date|$check_result|$check_out_links|$check_cy|$check_pr|$check_pr_main|$check_tag_noindex|$check_meta_robots|$check_file_robots|$status|$ip_user|$admin_comment");
}
sort($tmp, SORT_REGULAR); // сортировка
for($h=0;$h<count($tmp);$h++) { // создание отсортированного массива
$moder_array[$h] = ("{$tmp[$h][field]}"."|"."{$tmp[$h][ext1]}");
}
unset($tmp);
// сортировка модерации  по дате добавления---------------------------------------
if($_SESSION['adm_sort']=="Убывание") { // перевернем несортированные
$base_array = array_reverse($base_array);
$trash_array = array_reverse($trash_array);
$black_array = array_reverse($black_array);
$moder_array = array_reverse($moder_array);
}

} // конец если вкл./выкл. по дате проверки

// -------------------------------------------------------------------------------
// собственно, весь поиск надо написать здесь!!!!

if($_POST['search']) { // если есть новый поиск скидываем старую сессию поиска
unset($_SESSION['what_search']);
unset($_SESSION['where_search']);
unset($_SESSION['categories_search']);
// объединяем массивы
$tmp_array = array_merge($base_array, $moder_array, $trash_array, $black_array);
$tmp_array = array_values($tmp_array);
if(!$_POST['what_search'] AND !$_POST['where_search'] AND !$_POST['categories_search']) { unset($tmp_array); }
}

if($_SESSION['what_search']||$_SESSION['where_search']||$_SESSION['categories_search']) {
// объединяем массивы
$tmp_array = array_merge($base_array, $moder_array, $trash_array, $black_array);
$tmp_array = array_values($tmp_array);
}

// начинаем если есть где искать, т.е. разделы

// --------- если Модерация ищем только в Модерации ------------------------------
if($_POST['where_search']=="Модерация"||$_SESSION['where_search']=="Модерация") {
unset($tmp_array); // сбрасываем временный массив, потому что он будет формироваться из другого файла
for($i=0;$i<count($moder_array);$i++) {
$row_base = explode("|", $moder_array[$i]);
if ($row_base[0]) { $tmp_array[$total_rows] = "$moder_array[$i]"; $total_rows++; }
}
$tmp_array = array_values($tmp_array); $_SESSION[where_search] = "Модерация";
}
// --------- если Модерация ищем только в Модерации ------------------------------
// --------- если Корзина ищем только в Корзине-----------------------------------
if($_POST['where_search']=="Корзина"||$_SESSION['where_search']=="Корзина") {
unset($tmp_array); // сбрасываем временный массив, потому что он будет формироваться из другого файла
for($i=0;$i<count($trash_array);$i++) {
$row_base = explode("|", $trash_array[$i]);
if ($row_base[0]) { $tmp_array[$total_rows] = "$trash_array[$i]"; $total_rows++; }
}
$tmp_array = array_values($tmp_array); $_SESSION[where_search] = "Корзина";
}
// --------- если Корзина ищем только в Корзине-----------------------------------
// --------- если Блэк-лист ищем только в Блэк-листе------------------------------
if($_POST['where_search']=="Блэк-лист"||$_SESSION['where_search']=="Блэк-лист") {
unset($tmp_array); // сбрасываем временный массив, потому что он будет формироваться из другого файла
for($i=0;$i<count($black_array);$i++) {
$row_base = explode("|", $black_array[$i]);
if ($row_base[0]) { $tmp_array[$total_rows] = "$black_array[$i]"; $total_rows++; }
}
$tmp_array = array_values($tmp_array); $_SESSION[where_search] = "Блэк-лист";
}
// --------- если Блэк-лист ищем только в Блэк-листе------------------------------
// --------- если Старые ищем только в основной базе -----------------------------
if($_POST['where_search']=="Старые"||$_SESSION['where_search']=="Старые") {
unset($tmp_array); // сбрасываем временный массив, потому что он будет формироваться из другого файла
$untime = time(); // текущее время
for($i=0;$i<count($base_array);$i++) {
$row_base = explode("|", $base_array[$i]);
$unstamp = $untime - $_SESSION['adm_old_link']*84600; // метка старых
if ($row_base[16]==activ&&$row_base[7]<$unstamp) { $tmp_array[$total_rows] = "$base_array[$i]"; $total_rows++; }
}
$tmp_array = array_values($tmp_array); $_SESSION[where_search] = "Старые";
}
// --------- если Старые ищем только в основной базе -----------------------------
// --------- если Новые ищем только в основной базе -----------------------------
if($_POST['where_search']=="Новые"||$_SESSION['where_search']=="Новые") {
unset($tmp_array); // сбрасываем временный массив, потому что он будет формироваться из другого файла
$untime = time(); // текущее время
for($i=0;$i<count($base_array);$i++) {
$row_base = explode("|", $base_array[$i]);
$unstamp = $untime - $_SESSION['adm_new_link']*84600; // метка новых
if ($row_base[16]==activ&&$row_base[0]>$unstamp&&strlen($row_base[2])>7) { $tmp_array[$total_rows] = "$base_array[$i]"; $total_rows++; }
}
$tmp_array = array_values($tmp_array); $_SESSION[where_search] = "Новые";
}
// --------- если Новые ищем только в основной базе -----------------------------
// --------- если Недоступные ищем только в основной базе ------------------------
if($_POST['where_search']=="Недоступные"||$_SESSION['where_search']=="Недоступные") {
unset($tmp_array); // сбрасываем временный массив, потому что он будет формироваться из другого файла
for($i=0;$i<count($base_array);$i++) {
$row_base = explode("|", $base_array[$i]);
if ($row_base[16]=="noanswer") { $tmp_array[$total_rows] = "$base_array[$i]"; $total_rows++; }
}
$tmp_array = array_values($tmp_array); $_SESSION[where_search] = "Недоступные";
}
// --------- если Недоступные ищем только в основной базе ------------------------
// --------- если Хорошие ищем только в основной базе ----------------------------
if($_POST['where_search']=="Хорошие"||$_SESSION['where_search']=="Хорошие") {
unset($tmp_array); // сбрасываем временный массив, потому что он будет формироваться из другого файла
for($i=0;$i<count($base_array);$i++) {
$row_base = explode("|", $base_array[$i]);
if ($row_base[16]=="activ"&&$row_base[8]=="well"&&$row_base[13]=="well"&&$row_base[14]=="well"&&$row_base[15]=="well"&&$row_base[10]>=$_SESSION['adm_cy']&&$row_base[11]>=$_SESSION['adm_pr']&&$row_base[9]<=$_SESSION['adm_out_links']) { $tmp_array[$total_rows] = "$base_array[$i]"; $total_rows++; }
}
$tmp_array = array_values($tmp_array); $_SESSION[where_search] = "Хорошие";
}
// --------- если Хорошие ищем только в основной базе ----------------------------
// --------- если Плохие ищем только в основной базе -----------------------------
if($_POST['where_search']=="Плохие"||$_SESSION['where_search']=="Плохие") {
unset($tmp_array); // сбрасываем временный массив, потому что он будет формироваться из другого файла
for($i=0;$i<count($base_array);$i++) {
$row_base = explode("|", $base_array[$i]);
if ($row_base[16]=="activ") {
if($row_base[8]=="badly"||$row_base[13]=="badly"||$row_base[14]=="badly"||$row_base[15]=="badly"||$row_base[10]<$_SESSION['adm_cy']||$row_base[11]<$_SESSION['adm_pr']||$row_base[9]>$_SESSION['adm_out_links']) { $tmp_array[$total_rows] = "$base_array[$i]"; $total_rows++; }
}
}
$tmp_array = array_values($tmp_array); $_SESSION[where_search] = "Плохие";
}
// --------- если Плохие ищем только в основной базе -----------------------------
// --------- если Скрытые ищем только в основной базе ----------------------------
if($_POST['where_search']=="Скрытые"||$_SESSION['where_search']=="Скрытые") {
unset($tmp_array); // сбрасываем временный массив, потому что он будет формироваться из другого файла
for($i=0;$i<count($base_array);$i++) {
$row_base = explode("|", $base_array[$i]);
if ($row_base[16]=="hide") { $tmp_array[$total_rows] = "$base_array[$i]"; $total_rows++; }
}
$tmp_array = array_values($tmp_array); $_SESSION[where_search] = "Скрытые";
}
// --------- если Скрытые ищем только в основной базе ----------------------------
// кончаем если есть где искать, т.е. разделы


// -------------------- начинаем если есть категории -----------------------------
if($_POST['categories_search']||$_SESSION['categories_search']) {

$total_rows = 0; // скидываем счетчик, т.к. будет формироваться новый временный массив
for($i=0;$i<count($tmp_array);$i++) {
$row_base = explode("|", $tmp_array[$i]);
if ($row_base[4]==$_POST['categories_search']||$row_base[4]==$_SESSION['categories_search']) { $tmp_array2[$total_rows] = "$tmp_array[$i]"; $total_rows++; $_SESSION[categories_search] = "$row_base[4]"; }
}
unset($tmp_array);
$tmp_array = array_values($tmp_array2);
if(!isset($_SESSION['categories_search'])) { $_SESSION[categories_search] = "$_POST[categories_search]"; }
}
// --------------------- кончаем если есть категории -----------------------------


// -------------------- начинаем если есть запрос на поиск -----------------------
if($_POST['what_search']||$_SESSION['what_search']) {

$_POST[what_search] = strtolower(trim(stripslashes(htmlspecialchars($_POST['what_search'])))); // проверим/исправим $_POST[what_search]
if(!isset($_SESSION['what_search'])) {  $_SESSION[what_search] = $_POST[what_search]; } // если нет сессии, загоним туда строку поиска
$_SESSION[what_search] = strtr("$_SESSION[what_search]", "ЁЙЦУКЕНГШЩЗХЪФЫВАПРОЛДЖЭЯЧСМИТЬБЮ", "ёйцукенгшщзхъфывапролджэячсмитьбю");
$total_rows = 0; // скидываем счетчик, т.к. будет формироваться новый временный массив
for($i=0;$i<count($tmp_array);$i++) {
$row_base = explode("|", $tmp_array[$i]);
$search_string = "$row_base[1]"."$row_base[2]"."$row_base[3]"."$row_base[5]"."$row_base[6]"."$row_base[17]"."$row_base[18]";
$search_string = strtolower($search_string);
$search_string = strtr("$search_string", "ЁЙЦУКЕНГШЩЗХЪФЫВАПРОЛДЖЭЯЧСМИТЬБЮ", "ёйцукенгшщзхъфывапролджэячсмитьбю");
if (substr_count($search_string, "$_SESSION[what_search]")) { $tmp_array3[$total_rows] = "$tmp_array[$i]"; $total_rows++; }
}
unset($tmp_array);
$tmp_array = array_values($tmp_array3);
}
// -------------------- кончаем если есть запрос на поиск -----------------------

// -------------------- убираем пустые карточки (дырки) ----------
$clear_array = array();
$total_rows = 0;
$qnt = count($tmp_array);
for($i=0;$i<$qnt;$i++) {
$tmp_row = explode("|", $tmp_array[$i]);
if ($tmp_row[16]!="hole") { $clear_array[$i] = "$tmp_array[$i]"; $total_rows++; }
}
unset($tmp_array);
$tmp_array = array_values($clear_array);
// -------------------- убираем пустые карточки (дырки) ----------

// -------------------------------------------------------------------------------
// if($_SESSION[adm_sort] == Возрастание) { $tmp_array = array_reverse($tmp_array); } // перевернем, если надо

// Подключаем шкалу разбиения на страницы
include "scale.php";

echo "</td><td align=right valign=top>";

// Подключаем форму поиска
// include "search.php";

echo "</td></tr><tr><td valign=top align=left colspan=2>";
// Выводим данные постранично
for($j=$from_row;$j<=$to_row;$j++) {

$row_base = explode("|", $tmp_array[$j]);
if ($tmp_array[$j]) { include "card.php"; echo "<br>";}
}
echo "<br>";
// Подключаем конец формы поиска
// include "searchend.php";

// Подключаем шкалу разбиения на страницы
include "scale.php";
// ---------------------------------------------------------------------------------------------------------------------------------
echo "</td></tr></table>";
@ignore_user_abort($old_abort);
?>
</body>
</html>