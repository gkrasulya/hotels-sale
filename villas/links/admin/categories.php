<?php
error_reporting(0);
@$old_abort = ignore_user_abort(true);
session_start();
include "adminic.php";
include "functions/cut.php";
// Обрисуем, где находимся
$place = "КАТЕГОРИИ";
// ----------------------------------------------------------------------------------
// Если добавляем новую категорию
if($_POST['add_category'] AND $_SESSION['owner_status']=="this_admin") {

// проверим - исправим
$category_name = Cut_All_All($_POST['category_name']);
if(!$category_name) { $_SESSION['error_config'] = "Не введено название категории!"; header("Location: $_SERVER[PHP_SELF]"); exit(); }
$category_keywords = Cut_All_All($_POST['category_keywords']);
$category_description = Cut_All_All($_POST['category_description']);

// читаем файл с названиями категорий в массив (блокировка все и всегда на чтение-запись)
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
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
// ищем, нет ли уже такой категории
for($i=0;$i<count($categories_array);$i++) {
$categories_array_row = explode("|", $categories_array[$i]);
if(trim($categories_array_row[1])=="$category_name") { $_SESSION['error_config'] = "Такая категория уже есть!"; }
}
if($_SESSION[error_config]) { header("Location: $_SERVER[PHP_SELF]"); exit();  } // если уже есть

// Добавляем новое название категории
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$id_category = time();
$fp=fopen("data/categories.dat","a");
fputs($fp, "$id_category|$category_name|$category_keywords|$category_description\r\n");
fclose($fp);
flock($lock, LOCK_UN);
fclose($lock);
$_SESSION['ok_config'] = "Новая категория успешно добавлена!";
header("Location: $_SERVER[PHP_SELF]");
exit();
} else {
$_SESSION['error'] = "Не могу заблокировать служебный файл data/base.lck !!!";
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=error.php'>
	  </HEAD></HTML>";
exit();
}

} // конец если добавляли название категории
// ------------------------------------------------------------------------------------
// Если удаляем категорию
if($_POST['delete_category'] AND $_SESSION['owner_status']=="this_admin") {
// блокируем
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$categories_array = file("data/categories.dat"); // получаем все что нужно в массивы
$base_array = file("data/base.dat");
$moder_array = file("data/moder.dat");
$trash_array = file("data/trash.dat");
$black_array = file("data/black.dat");
// найти название удаляемой категории
for ($i=0;$i<count($categories_array);$i++) {
$categories_array_row = explode("|", $categories_array[$i]);
if ($categories_array_row[0] == "$_POST[id_category]") { $deleting_category = "$categories_array_row[1]"; break; }
}
// -------------------------------------------------------------------------------
// из базы
$all_base = count($base_array);
$fp=fopen("data/temp.dat","w");
for ($i=0;$i<$all_base;$i++) {
$base_array_row = explode("|", $base_array[$i]);
if (trim($base_array_row[4])==trim($deleting_category)) { unset($base_array[$i]); }
}
fputs($fp,implode("",$base_array));
fclose($fp);
unlink("data/base.dat");
rename("data/temp.dat", "data/base.dat");
// -------------------------------------------------------------------------------
// из модерации
$all_moder = count($moder_array);
$fp=fopen("data/temp.dat","w");
for ($i=0;$i<$all_moder;$i++) {
$moder_array_row = explode("|", $moder_array[$i]);
if (trim($moder_array_row[4])==trim($deleting_category)) { unset($moder_array[$i]); }
}
fputs($fp,implode("",$moder_array));
fclose($fp);
unlink("data/moder.dat");
rename("data/temp.dat", "data/moder.dat");
// -------------------------------------------------------------------------------
// из корзины
$all_trash = count($trash_array);
$fp=fopen("data/temp.dat","w");
for ($i=0;$i<$all_trash;$i++) {
$trash_array_row = explode("|", $trash_array[$i]);
if (trim($trash_array_row[4])==trim($deleting_category)) { unset($trash_array[$i]); }
}
fputs($fp,implode("",$trash_array));
fclose($fp);
unlink("data/trash.dat");
rename("data/temp.dat", "data/trash.dat");
// -------------------------------------------------------------------------------
// из блэк-листа
$all_black = count($black_array);
$fp=fopen("data/temp.dat","w");
for ($i=0;$i<$all_black;$i++) {
$black_array_row = explode("|", $black_array[$i]);
if (trim($black_array_row[4])==trim($deleting_category)) { unset($black_array[$i]); }
}
fputs($fp,implode("",$black_array));
fclose($fp);
unlink("data/black.dat");
rename("data/temp.dat", "data/black.dat");
// -------------------------------------------------------------------------------
// из категорий
$all_categories = count($categories_array);
$fp=fopen("data/temp.dat","w");
for ($i=0;$i<$all_categories;$i++) {
$categories_array_row = explode("|", $categories_array[$i]);
if (trim($categories_array_row[0])==trim($_POST[id_category])) { unset($categories_array[$i]); }
}
fputs($fp,implode("",$categories_array));
fclose($fp);
unlink("data/categories.dat");
rename("data/temp.dat", "data/categories.dat");
// -------------------------------------------------------------------------------
flock($lock, LOCK_UN);
fclose($lock);
$_SESSION['ok_config'] = "Категория $_POST[category_name] удалена!";
header("Location: $_SERVER[PHP_SELF]");
exit();
} else {
$_SESSION['error'] = "Не могу заблокировать служебный файл data/base.lck !!!";
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=error.php'>
	  </HEAD></HTML>";
exit();
}
} // конец если удаляем категорию
// --------------------------------------------------------------------------------------
// Если редактируем категорию
if($_POST['edit_category'] AND $_SESSION['owner_status']=="this_admin") {
// проверим - исправим
$category_name = Cut_All_All($_POST['category_name']);
if(!$category_name) { $_SESSION['error_config'] = "Не введено название категории!"; header("Location: $_SERVER[PHP_SELF]"); exit(); }
$category_keywords = Cut_All_All($_POST['category_keywords']);
$category_description = Cut_All_All($_POST['category_description']);

// читаем файл с названиями категорий в массив (блокировка все и всегда на чтение-запись)
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
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
// ищем, нет ли уже такой категории
for($i=0;$i<count($categories_array);$i++) {
$categories_array_row = explode("|", $categories_array[$i]);
if(trim($categories_array_row[1])=="$category_name" AND $categories_array_row[0]!=$_POST['id_category']) { $_SESSION['error_config'] = "Такая категория уже есть!"; }
}
if($_SESSION['error_config']) { header("Location: $_SERVER[PHP_SELF]"); exit();  } // если уже есть

// блокируем
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$categories_array = file("data/categories.dat"); // получаем категории
$base_array = file("data/base.dat"); // получаем базу
$moder_array = file("data/moder.dat"); // получаем модерацию
$trash_array = file("data/trash.dat"); // получаем корзину
$black_array = file("data/black.dat"); // получаем блек-лист
// --------- категории ---------
$fcat=fopen("data/temp.dat","w");
$num = count($categories_array);
for ($i=0;$i<$num;$i++) {
$categories_array_row = explode("|", $categories_array[$i]);
if ($categories_array_row[0] != $_POST[id_category]) {
fwrite($fcat, $categories_array[$i]);
} else {
$rename_category = "$categories_array_row[1]";
fputs($fcat, "$_POST[id_category]|$category_name|$category_keywords|$category_description\r\n");
}
}
fclose($fcat);
unlink("data/categories.dat");
rename("data/temp.dat", "data/categories.dat");
// --------- категории ---------
// --------- базу ---------
$fbas=fopen("data/temp.dat","w");
$num = count($base_array);
for ($i=0;$i<$num;$i++) {
$base_array_row = explode("|", $base_array[$i]);
if ($base_array_row[4] != $rename_category) {
fwrite($fbas, $base_array[$i]);
} else {
$bar[0]=trim($base_array_row[0]);
$bar[1]=trim($base_array_row[1]);
$bar[2]=trim($base_array_row[2]);
$bar[3]=trim($base_array_row[3]);
$bar[4]=trim($category_name);
$bar[5]=trim($base_array_row[5]);
$bar[6]=trim($base_array_row[6]);
$bar[7]=trim($base_array_row[7]);
$bar[8]=trim($base_array_row[8]);
$bar[9]=trim($base_array_row[9]);
$bar[10]=trim($base_array_row[10]);
$bar[11]=trim($base_array_row[11]);
$bar[12]=trim($base_array_row[12]);
$bar[13]=trim($base_array_row[13]);
$bar[14]=trim($base_array_row[14]);
$bar[15]=trim($base_array_row[15]);
$bar[16]=trim($base_array_row[16]);
$bar[17]=trim($base_array_row[17]);
$bar[18]=trim($base_array_row[18]);
fputs($fbas, "$bar[0]|$bar[1]|$bar[2]|$bar[3]|$bar[4]|$bar[5]|$bar[6]|$bar[7]|$bar[8]|$bar[9]|$bar[10]|$bar[11]|$bar[12]|$bar[13]|$bar[14]|$bar[15]|$bar[16]|$bar[17]|$bar[18]\r\n");
}
}
fclose($fbas);
unlink("data/base.dat");
rename("data/temp.dat", "data/base.dat");
// --------- базу ---------
// --------- модерацию ---------
$fmod=fopen("data/temp.dat","w");
$num = count($moder_array);
for ($i=0;$i<$num;$i++) {
$moder_array_row = explode("|", $moder_array[$i]);
if ($moder_array_row[4] != $rename_category) {
fwrite($fmod, $moder_array[$i]);
} else {
$mar[0]=trim($moder_array_row[0]);
$mar[1]=trim($moder_array_row[1]);
$mar[2]=trim($moder_array_row[2]);
$mar[3]=trim($moder_array_row[3]);
$mar[4]=trim($category_name);
$mar[5]=trim($moder_array_row[5]);
$mar[6]=trim($moder_array_row[6]);
$mar[7]=trim($moder_array_row[7]);
$mar[8]=trim($moder_array_row[8]);
$mar[9]=trim($moder_array_row[9]);
$mar[10]=trim($moder_array_row[10]);
$mar[11]=trim($moder_array_row[11]);
$mar[12]=trim($moder_array_row[12]);
$mar[13]=trim($moder_array_row[13]);
$mar[14]=trim($moder_array_row[14]);
$mar[15]=trim($moder_array_row[15]);
$mar[16]=trim($moder_array_row[16]);
$mar[17]=trim($moder_array_row[17]);
$mar[18]=trim($moder_array_row[18]);
fputs($fmod, "$mar[0]|$mar[1]|$mar[2]|$mar[3]|$mar[4]|$mar[5]|$mar[6]|$mar[7]|$mar[8]|$mar[9]|$mar[10]|$mar[11]|$mar[12]|$mar[13]|$mar[14]|$mar[15]|$mar[16]|$mar[17]|$mar[18]\r\n");
}
}
fclose($fmod);
unlink("data/moder.dat");
rename("data/temp.dat", "data/moder.dat");
// --------- модерацию ---------
// --------- корзину ---------
$ftra=fopen("data/temp.dat","w");
$num = count($trash_array);
for ($i=0;$i<$num;$i++) {
$trash_array_row = explode("|", $trash_array[$i]);
if ($trash_array_row[4] != $rename_category) {
fwrite($ftra, $trash_array[$i]);
} else {
$trar[0]=trim($trash_array_row[0]);
$trar[1]=trim($trash_array_row[1]);
$trar[2]=trim($trash_array_row[2]);
$trar[3]=trim($trash_array_row[3]);
$trar[4]=trim($category_name);
$trar[5]=trim($trash_array_row[5]);
$trar[6]=trim($trash_array_row[6]);
$trar[7]=trim($trash_array_row[7]);
$trar[8]=trim($trash_array_row[8]);
$trar[9]=trim($trash_array_row[9]);
$trar[10]=trim($trash_array_row[10]);
$trar[11]=trim($trash_array_row[11]);
$trar[12]=trim($trash_array_row[12]);
$trar[13]=trim($trash_array_row[13]);
$trar[14]=trim($trash_array_row[14]);
$trar[15]=trim($trash_array_row[15]);
$trar[16]=trim($trash_array_row[16]);
$trar[17]=trim($trash_array_row[17]);
$trar[18]=trim($trash_array_row[18]);
fputs($ftra, "$trar[0]|$trar[1]|$trar[2]|$trar[3]|$trar[4]|$trar[5]|$trar[6]|$trar[7]|$trar[8]|$trar[9]|$trar[10]|$trar[11]|$trar[12]|$trar[13]|$trar[14]|$trar[15]|$trar[16]|$trar[17]|$trar[18]\r\n");
}
}
fclose($ftra);
unlink("data/trash.dat");
rename("data/temp.dat", "data/trash.dat");
// --------- корзину ---------
// --------- блек-лист ---------
$fbla=fopen("data/temp.dat","w");
$num = count($black_array);
for ($i=0;$i<$num;$i++) {
$black_array_row = explode("|", $black_array[$i]);
if ($black_array_row[4] != $rename_category) {
fwrite($fbla, $black_array[$i]);
} else {
$blar[0]=trim($black_array_row[0]);
$blar[1]=trim($black_array_row[1]);
$blar[2]=trim($black_array_row[2]);
$blar[3]=trim($black_array_row[3]);
$blar[4]=trim($category_name);
$blar[5]=trim($black_array_row[5]);
$blar[6]=trim($black_array_row[6]);
$blar[7]=trim($black_array_row[7]);
$blar[8]=trim($black_array_row[8]);
$blar[9]=trim($black_array_row[9]);
$blar[10]=trim($black_array_row[10]);
$blar[11]=trim($black_array_row[11]);
$blar[12]=trim($black_array_row[12]);
$blar[13]=trim($black_array_row[13]);
$blar[14]=trim($black_array_row[14]);
$blar[15]=trim($black_array_row[15]);
$blar[16]=trim($black_array_row[16]);
$blar[17]=trim($black_array_row[17]);
$blar[18]=trim($black_array_row[18]);
fputs($fbla, "$blar[0]|$blar[1]|$blar[2]|$blar[3]|$blar[4]|$blar[5]|$blar[6]|$blar[7]|$blar[8]|$blar[9]|$blar[10]|$blar[11]|$blar[12]|$blar[13]|$blar[14]|$blar[15]|$blar[16]|$blar[17]|$blar[18]\r\n");
}
}
fclose($fbla);
unlink("data/black.dat");
rename("data/temp.dat", "data/black.dat");
// --------- блек-лист ---------
flock($lock, LOCK_UN);
fclose($lock);
$_SESSION['ok_config'] = "Категория успешно отредактирована!";
header("Location: $_SERVER[PHP_SELF]");
exit();
} else {
$_SESSION['error'] = "Не могу заблокировать служебный файл data/base.lck !!!";
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=error.php'>
	  </HEAD></HTML>";
exit();
}
} // конец если редактируем категорию

// ---------------------------------------------------------------------------------------------------------------------------------
// Выводим ошибки или ОК, если они присутствуют
if($_SESSION['error_config']) { echo "<span id=warningMess>Ошибка! $_SESSION[error_config]</span>"; unset($_SESSION['error_config']); }
if($_SESSION['ok_config']) { echo "<span id=okMess>ОК! $_SESSION[ok_config]</span>";  unset($_SESSION['ok_config']); }
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
echo "</td></tr><tr><td colspan=2 valign=top align=left></td></tr>";
// ---------------------------------------------------------------------------------------------------------------------------------
echo "<tr><td valign=top align=left>"; // первая ячейка в строке
// Форма для ввода новых категорий
echo "<form action=\""."$_SERVER[PHP_SELF]"."\" method=\"POST\"><table width=100% cellspacing=0 cellpadding=0>
      <tr><td align=right valign=top width=1px><img src=images/login_lu.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_ru.gif width=8 height=8 border=0></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td class=title bgcolor=#8f95ac align=left colspan=2>Форма для ввода новых категорий<br><br></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left nowrap width=1% valign=top>Название категории:(*)</td><td bgcolor=#8f95ac align=right><input name=\"category_name\" type=\"text\" size=\"36\" maxlength=\"255\" style=\"width: 350px; font-weight: bold;\"></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left nowrap width=1% valign=top>Ключевые слова для категории:<br>(через запятую и пробел)</td><td bgcolor=#8f95ac align=right><input name=\"category_keywords\" type=\"text\" size=\"36\" maxlength=\"255\" style=\"width: 350px;\"></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left nowrap width=1% valign=top>Описание для категории:</td><td bgcolor=#8f95ac align=right><textarea name=\"category_description\" row=\"3\" cols=\"36\" style=\"width: 350px;\"></textarea></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td class=title bgcolor=#8f95ac align=left colspan=2><b><font color=red>Внимание!</font> В названии категории не ставьте двух пробелов подряд!<br><br></b></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=center colspan=2 valign=top><input name=\"add_category\" type=\"submit\" value=\"Добавить\"></td><td bgcolor=#8f95ac width=1px></td></tr>
	  <tr><td align=right valign=top width=1px><img src=images/login_ld.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_rd.gif width=8 height=8 border=0></td></tr>
      </table></form><br>";
// ---------------------------------------------------------------------------------------------------------------------------------
// Читаем из файла категории и выводим их
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
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
// сортировка по алфавиту ---------------------------------------

echo "<table width=100% cellspacing=0 cellpadding=0>
      <tr><td align=right valign=top width=1px><img src=images/login_lu.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_ru.gif width=8 height=8 border=0></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td class=title bgcolor=#8f95ac align=left colspan=2>Категории ["."$all_categories"."]<br><br></td><td bgcolor=#8f95ac width=1px></td></tr>";

if($all_categories == 0) { echo "<tr><td bgcolor=#8f95ac width=1px></td><td class=title bgcolor=#8f95ac align=left colspan=2><hr>Не введено ни одного названия категории!</td><td bgcolor=#8f95ac width=1px></td></tr>"; }

for($i=0;$i<$all_categories;$i++) {
$row_categories_array = explode("|", $categories_array[$i]);

if($row_categories_array) {
$id_category = trim($row_categories_array[0]);
$category_name = trim($row_categories_array[1]);
$category_keywords = trim($row_categories_array[2]);
$category_description = trim($row_categories_array[3]);

echo "<form action=\""."$_SERVER[PHP_SELF]"."\" method=\"POST\"><input name=\"id_category\" type=\"hidden\" value=\""."$id_category"."\">
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2><hr></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left nowrap valign=top><input name=\"category_name\" type=\"text\" size=\"36\" maxlength=\"255\" style=\"width: 350px; font-weight: bold;\" value=\""."$category_name"."\"></td><td bgcolor=#8f95ac align=center valign=top><input name=\"edit_category\" type=\"submit\" value=\"Изменить\" style=\"width: 120px;\"></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left nowrap valign=top><input name=\"category_keywords\" type=\"text\" size=\"36\" maxlength=\"255\" style=\"width: 350px;\" value=\""."$category_keywords"."\"></td><td bgcolor=#8f95ac align=center valign=top><input name=\"delete_category\" type=\"submit\" value=\"Удалить\" style=\"width: 120px;\"></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left nowrap valign=top><textarea name=\"category_description\" row=\"3\" cols=\"36\" style=\"width: 350px;\">"."$category_description"."</textarea></td><td bgcolor=#8f95ac align=center valign=top></td><td bgcolor=#8f95ac width=1px></td></tr>
	  </form>";

} // end if

} // end for
echo "<tr><td align=right valign=top width=1px><img src=images/login_ld.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_rd.gif width=8 height=8 border=0></td></tr>
      </table><br>";
// ---------------------------------------------------------------------------------------------------------------------------------
// Начало таблицы для хелпов
echo "</td><td valign=top align=right>"; // вторая ячейка в строке

echo "<table width=360 cellspacing=0 cellpadding=0>
      <tr><td align=right valign=top width=1px><img src=images/login_lu.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_ru.gif width=8 height=8 border=0></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td class=title bgcolor=#8f95ac align=right colspan=2>Help</td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2>";
	  
echo "<div align=justify>
<font face=Verdana size=1 color=white><b>Категории каталога</b></font><br>
Вы можете добавить, любое количество категорий для своего каталога. Просто введите название категории, а также ключевые слова (через запятую и пробел) и описание категории. Все эти данные будут подставлены скриптом в метатэги TITLE, KEYWORDS и DESCRIPTION при вызове соответствующей страницы посетителем каталога или посещении ее поисковыми роботами.<br><br>
Чтобы добавить новую категорию - воспользуйтесь формой добавления.<br><br>
Чтобы редактировать данные - просто внесите соответствующие изменения в нужную категорию и нажмите кнопку \"Изменить\".<br><br>
Чтобы удалить категорию - нажмите кнопку \"Удалить\" рядом с нужной категорией.<br>
</div>";
echo "<div align=justify>
<font face=Verdana size=1 color=red><br><b>< обратите книмание ></b><br>
При удалении категории будет удалена вся информация о ссылках, которые принадлежали к этой категории!<br>
При нажатии на кнопку \"Удалить\" удаление происходит сразу, без требования подтверждения операции!</font>
</div>";

echo "</td><td bgcolor=#8f95ac width=1px></td></tr>
	  <tr><td align=right valign=top width=1px><img src=images/login_ld.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_rd.gif width=8 height=8 border=0></td></tr>
      </table>";

echo "</td></tr></table>";
@ignore_user_abort($old_abort);
?>
</body>
</html>