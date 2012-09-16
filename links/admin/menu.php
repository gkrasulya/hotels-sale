<?php
error_reporting(0);
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$base_array = file("data/base.dat");
$trash_array = file("data/trash.dat");
$black_array = file("data/black.dat");
$moder_array = file("data/moder.dat");
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
$tmp = array();
// сортировка по алфавиту ---------------------------------------
for($h=0;$h<$all_categories;$h++) { // выбор поля для сортировки
list($id_category,$category_name,$category_keywords,$category_description) = explode("|", $categories_array[$h]);
$tmp[$h] = array (field => $category_name, ext1 => $id_category, ext2 => "$category_keywords|$category_description");
}
sort($tmp, SORT_REGULAR); // сортировка
for($h=0;$h<count($tmp);$h++) { // создание отсортированного массива
$categories_array[$h] = ("{$tmp[$h][ext1]}"."|"."{$tmp[$h][field]}"."|"."{$tmp[$h][ext2]}");
}
// сортировка по алфавиту ---------------------------------------

// ссылки на модерации
$tmp_array = array();
for($i=0;$i<count($moder_array);$i++) {
$row_base = explode("|", $moder_array[$i]);
if ($row_base[0]) { $tmp_array[$total_rows] = "$moder_array[$i]"; $total_rows++; }
}
$tmp_array = array_values($tmp_array);
$moder_links = count($tmp_array);
unset($total_rows);
unset($tmp_array);

// скрытые ссылки
$tmp_array = array();
for($i=0;$i<count($base_array);$i++) {
$row_base = explode("|", $base_array[$i]);
if ($row_base[16]=="hide" AND strlen($row_base[2])>7) { $tmp_array[$total_rows] = "$base_array[$i]"; $total_rows++; }
}
$tmp_array = array_values($tmp_array);
$hide_links = count($tmp_array);
unset($total_rows);
unset($tmp_array);

// ссылки без ответа
$tmp_array = array();
for($i=0;$i<count($base_array);$i++) {
$row_base = explode("|", $base_array[$i]);
if ($row_base[16]=="noanswer" AND strlen($row_base[2])>7) { $tmp_array[$total_rows] = "$base_array[$i]"; $total_rows++; }
}
$tmp_array = array_values($tmp_array);
$noanswer_links = count($tmp_array);
unset($total_rows);
unset($tmp_array);

// плохие ссылки
$tmp_array = array();
for($i=0;$i<count($base_array);$i++) {
$row_base = explode("|", $base_array[$i]);
if ($row_base[16]=="activ" AND strlen($row_base[2])>7) {
if($row_base[8]=="badly"||$row_base[13]=="badly"||$row_base[14]=="badly"||$row_base[15]=="badly"||$row_base[10]<$_SESSION['adm_cy']||$row_base[11]<$_SESSION['adm_pr']||$row_base[9]>$_SESSION['adm_out_links']) { $tmp_array[$total_rows] = "$base_array[$i]"; $total_rows++; }
}
}
$tmp_array = array_values($tmp_array);
$badly_links = count($tmp_array);
unset($total_rows);
unset($tmp_array);

// нет ответной ссылки
$tmp_array = array();
for($i=0;$i<count($base_array);$i++) {
$row_base = explode("|", $base_array[$i]);
if ($row_base[16]=="activ" AND strlen($row_base[2])>7) {
if($row_base[8]=="badly") { $tmp_array[$total_rows] = "$base_array[$i]"; $total_rows++; }
}
}
$tmp_array = array_values($tmp_array);
$nolink_links = count($tmp_array);
unset($total_rows);
unset($tmp_array);

// запреты индексации
$tmp_array = array();
for($i=0;$i<count($base_array);$i++) {
$row_base = explode("|", $base_array[$i]);
if ($row_base[16]=="activ" AND strlen($row_base[2])>7) {
if($row_base[13]=="badly"||$row_base[14]=="badly"||$row_base[15]=="badly") { $tmp_array[$total_rows] = "$base_array[$i]"; $total_rows++; }
}
}
$tmp_array = array_values($tmp_array);
$noindex_links = count($tmp_array);
unset($total_rows);
unset($tmp_array);

// слишком много ссылок
$tmp_array = array();
for($i=0;$i<count($base_array);$i++) {
$row_base = explode("|", $base_array[$i]);
if ($row_base[16]=="activ" AND strlen($row_base[2])>7) {
if($row_base[9]>$_SESSION['adm_out_links']) { $tmp_array[$total_rows] = "$base_array[$i]"; $total_rows++; }
}
}
$tmp_array = array_values($tmp_array);
$overlink_links = count($tmp_array);
unset($total_rows);
unset($tmp_array);

// низкий тиц/pr
$tmp_array = array();
for($i=0;$i<count($base_array);$i++) {
$row_base = explode("|", $base_array[$i]);
if ($row_base[16]=="activ" AND strlen($row_base[2])>7) {
if($row_base[10]<$_SESSION['adm_cy']||$row_base[11]<$_SESSION['adm_pr']) { $tmp_array[$total_rows] = "$base_array[$i]"; $total_rows++; }
}
}
$tmp_array = array_values($tmp_array);
$lowindex_links = count($tmp_array);
unset($total_rows);
unset($tmp_array);

// хорошие ссылки
$tmp_array = array();
for($i=0;$i<count($base_array);$i++) {
$row_base = explode("|", $base_array[$i]);
if ($row_base[16]=="activ"&&$row_base[8]!="badly"&&$row_base[13]!="badly"&&$row_base[14]!="badly"&&$row_base[15]!="badly"&&$row_base[10]>=$_SESSION['adm_cy']&&$row_base[11]>=$_SESSION['adm_pr']&&$row_base[9]<=$_SESSION['adm_out_links'] AND strlen($row_base[2])>7) { $tmp_array[$total_rows] = "$base_array[$i]"; $total_rows++; }
}
$tmp_array = array_values($tmp_array);
$well_links = count($tmp_array);
unset($total_rows);
unset($tmp_array);

// старые ссылки
$tmp_array = array();
$untime = time(); // текущее время
for($i=0;$i<count($base_array);$i++) {
$row_base = explode("|", $base_array[$i]);
$unstamp = $untime - $_SESSION['adm_old_link']*84600; // метка старых
if ($row_base[16]=="activ"&&$row_base[7]<$unstamp AND strlen($row_base[2])>7) { $tmp_array[$total_rows] = "$base_array[$i]"; $total_rows++; }
}
$tmp_array = array_values($tmp_array);
$older_links = count($tmp_array);
unset($total_rows);
unset($tmp_array);

// новые ссылки
$tmp_array = array();
$untime = time(); // текущее время
for($i=0;$i<count($base_array);$i++) {
$row_base = explode("|", $base_array[$i]);
$unstamp = $untime - $_SESSION['adm_new_link']*84600; // метка старых
if ($row_base[16]=="activ"&&$row_base[0]>$unstamp AND strlen($row_base[2])>7) { $tmp_array[$total_rows] = "$base_array[$i]"; $total_rows++; }
}
$tmp_array = array_values($tmp_array);
$new_links = count($tmp_array);
unset($total_rows);
unset($tmp_array);

// ссылки в корзине
$tmp_array = array();
for($i=0;$i<count($trash_array);$i++) {
$row_base = explode("|", $trash_array[$i]);
if ($row_base[0]) { $tmp_array[$total_rows] = "$trash_array[$i]"; $total_rows++; }
}
$tmp_array = array_values($tmp_array);
$trash_links = count($tmp_array);
unset($total_rows);
unset($tmp_array);

// ссылки в блэк-листе
$tmp_array = array();
for($i=0;$i<count($black_array);$i++) {
$row_base = explode("|", $black_array[$i]);
if ($row_base[0]) { $tmp_array[$total_rows] = "$trash_array[$i]"; $total_rows++; }
}
$tmp_array = array_values($tmp_array);
$black_links = count($tmp_array);
unset($total_rows);
unset($tmp_array);

// всего ссылок
$all_links = $noanswer_links+$well_links+$badly_links+$hide_links;

echo "<table cellspacing=0 cellpadding=0 width=940>
      <tr><td align=right valign=top width=1px><img src=images/login_lu.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_ru.gif width=8 height=8 border=0></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td class=menutitle bgcolor=#8f95ac align=left colspan=2><font size=1><b>Версия: 20060822</b></font><br>LINKEXCHANGER 2.0 ADMIN AREA : "."$place";
	  
if($_SESSION['last_check_time']) { echo "<br><font size=1>Проверка данных заняла "."$_SESSION[last_check_time]"." секунд</font>"; unset($_SESSION['last_check_time']); }
	  
echo "</td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2 nowrap><br><a href=config.php>Конфигурация</a> | <a href=design.php>Дизайн</a> | <a href=myhtml.php>HTML-коды</a> | <a href=rules.php>Правила</a> | <a href=categories.php>Категории</a> | <a href=letters.php>Шаблоны писем</a> | <a href=freehosting.php>Free hosting</a> | <a href=add_link.php>Добавить</a> | <a href=links_search.php>Поиск</a> | <a href=backup.php>BackUp</a> | <a href=help.php>Help</a> | <a href=info.php target=_blank>Info</a> | <a href=exit.php>Выход</a></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left nowrap>
      <b>Ссылок в базе <font color=white>"."$all_links"."</font></b>
      <form name=switcher action=switcher.php method=\"POST\" style=\"margin: 0px;\">
      <select name=switch_page style=\"width: 180px;\" onChange=switcher.submit()>
      <option>---- выбор раздела ----</option>      
      <option value=\"links_moder.php\">&nbsp;модерация ("."$moder_links".")</option>
      <option>-----------------------</option>
      <option value=\"links_older.php\">&nbsp;проверенные давно ("."$older_links".")</option>
      <option value=\"links_new.php\">&nbsp;добавленные недавно ("."$new_links".")</option>
      <option value=\"links_well.php\">&nbsp;хорошие ("."$well_links".")</option>
      <option value=\"links_badly.php\">&nbsp;плохие ("."$badly_links".")</option>      
      <option value=\"links_nolink.php\">&nbsp;&nbsp;- нет обратной ("."$nolink_links".")</option>
      <option value=\"links_noindex.php\">&nbsp;&nbsp;- запрет индексации ("."$noindex_links".")</option>
      <option value=\"links_overlink.php\">&nbsp;&nbsp;- много линков ("."$overlink_links".")</option>
      <option value=\"links_lowindex.php\">&nbsp;&nbsp;- низкий CY/PR ("."$lowindex_links".")</option>
      <option value=\"links_noanswer.php\">&nbsp;недоступные ("."$noanswer_links".")</option>
      <option value=\"links_hide.php\">&nbsp;скрытые ("."$hide_links".")</option>
      <option>-----------------------</option>
      <option value=\"links_trash.php\">&nbsp;корзина ("."$trash_links".")</option>
      <option value=\"links_black.php\">&nbsp;блэк-лист ("."$black_links".")</option>
      </select>
      </form></td><td bgcolor=#8f95ac align=left nowrap>";
      
include("search.php");      
      
      
echo "</td><td bgcolor=#8f95ac width=1px></td></tr>
	  <tr><td align=right valign=top width=1px><img src=images/login_ld.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_rd.gif width=8 height=8 border=0></td></tr>
      </table>";
// число, месяц, год для запроса в Яндекс
$queryand = getdate($untime);
$day = "$queryand[mday]";
$mon = "$queryand[mon]";
$year = "$queryand[year]";
?>