<?php
error_reporting(0);
@$old_abort = ignore_user_abort(true);
session_start();
include "adminic.php";
include "functions/cut.php";
// Обрисуем, где находимся
$place = "БЕСПЛАТНЫЕ ХОСТИНГИ";
// ---------------------------------------------------------------------------------------------------------------------------------
// Если добавляем новый хостинг
if($_POST['add_freehosting'] AND $_SESSION['owner_status']=="this_admin") {

// проверим - исправим
$name_freehosting = Cut_All_All($_POST['freehosting']);
if(!$name_freehosting) { $_SESSION['error_config'] = "Не введено название хостинга!"; header("Location: $_SERVER[PHP_SELF]"); exit(); }
if(!eregi("^([-a-z0-9]){1,}(\.[a-z]{3})?\.([a-z]){2,4}$", "$name_freehosting")) { $_SESSION['error_config'] = "Только цифры, латинские буквы, точка, тире без http:// и www!"; header("Location: $_SERVER[PHP_SELF]"); exit(); }

// читаем файл с названиями хостингов в массив (блокировка все и всегда на чтение-запись)
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$freehosting = file("data/hosting.dat");
flock($lock, LOCK_UN);
fclose($lock);
} else {
$_SESSION['error'] = "Не могу заблокировать служебный файл data/base.lck !!!";
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=error.php'>
	  </HEAD></HTML>";
exit();
}
// ищем, нет ли уже такого названия хостинга
for($i=0;$i<count($freehosting);$i++) {
$freehosting_row = explode("|", $freehosting[$i]);
if(trim($freehosting_row[1])=="$name_freehosting") { $_SESSION['error_config'] = "Такое название хостинга уже есть!"; }
}

if($_SESSION['error_config']) { header("Location: $_SERVER[PHP_SELF]"); exit();  } // если уже есть

// Добавляем новое название хостинга
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$id_freehosting = time();
$fp=fopen("data/hosting.dat","a");
fputs($fp, "$id_freehosting|$name_freehosting\r\n");
fclose($fp);
flock($lock, LOCK_UN);
fclose($lock);
$_SESSION['ok_config'] = "Название нового хостинга успешно добавлено!";
header("Location: $_SERVER[PHP_SELF]");
exit();
} else {
$_SESSION['error'] = "Не могу заблокировать служебный файл data/base.lck !!!";
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=error.php'>
	  </HEAD></HTML>";
exit();
}

} // конец если добавляли название бесплатного хостинга
// ---------------------------------------------------------------------------------------------------------------------------------
// Если удаляем название хостинга
if($_GET['delete_freehosting'] AND $_SESSION['owner_status']=="this_admin") {
// блокируем
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$freehosting = file("data/hosting.dat"); // получаем в массив
$fp=fopen("data/temp.dat","w");
for ($i=0;$i<count($freehosting);$i++) {
$freehosting_row = explode("|", $freehosting[$i]);
if ($freehosting_row[0] == $_GET['delete_freehosting']) unset($freehosting[$i]);
}
fputs($fp,implode("",$freehosting));
fclose($fp);
unlink("data/hosting.dat");
rename("data/temp.dat", "data/hosting.dat");
flock($lock, LOCK_UN);
fclose($lock);
} else {
$_SESSION['error'] = "Не могу заблокировать служебный файл data/base.lck !!!";
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=error.php'>
	  </HEAD></HTML>";
exit();
}
} // конец если удаляем название хостинга
// ---------------------------------------------------------------------------------------------------------------------------------

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
// Форма для ввода новых бесплатных хостингов
echo "<form action=\""."$_SERVER[PHP_SELF]"."\" method=\"POST\"><table width=100% cellspacing=0 cellpadding=0>
      <tr><td align=right valign=top width=1px><img src=images/login_lu.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_ru.gif width=8 height=8 border=0></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td class=title bgcolor=#8f95ac align=left colspan=2>Форма для ввода новых бесплатных хостингов<br><br></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left nowrap width=1% valign=top>Название хостинга:<br>(пример - narod.ru)</td><td bgcolor=#8f95ac align=right><input name=\"freehosting\" type=\"text\" size=\"36\" maxlength=\"72\">&nbsp;&nbsp;&nbsp;&nbsp;<input name=\"add_freehosting\" type=\"submit\" value=\"Добавить\"></td><td bgcolor=#8f95ac width=1px></td></tr>
	  <tr><td align=right valign=top width=1px><img src=images/login_ld.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_rd.gif width=8 height=8 border=0></td></tr>
      </table></form><br>";
// ---------------------------------------------------------------------------------------------------------------------------------
// Читаем из файла названия хостингов и выводим их
$freehosting_array = file("data/hosting.dat");
$all_freehosting = count($freehosting_array);

// сортировка по алфавиту ---------------------------------------
for($h=0;$h<$all_freehosting;$h++) { // выбор поля для сортировки
list($id_freehosting,$name_freehosting) = explode("|", $freehosting_array[$h]);
$tmp[$h] = array (field => $name_freehosting, ext1 => $id_freehosting);
}
sort($tmp, SORT_REGULAR); // сортировка
for($h=0;$h<count($tmp);$h++) { // создание отсортированного массива
$freehosting_array[$h] = ("{$tmp[$h][ext1]}"."|"."{$tmp[$h][field]}");
}
// сортировка по алфавиту ---------------------------------------

echo "<table width=100% cellspacing=0 cellpadding=0>
      <tr><td align=right valign=top width=1px><img src=images/login_lu.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_ru.gif width=8 height=8 border=0></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td class=title bgcolor=#8f95ac align=left colspan=2>Бесплатные хостинги ["."$all_freehosting"."]<br><br></td><td bgcolor=#8f95ac width=1px></td></tr>";

if($all_freehosting == 0) { echo "<tr><td bgcolor=#8f95ac width=1px></td><td class=title bgcolor=#8f95ac align=left colspan=2><hr>Не введено ни одного названия бесплатного хостинга!</td><td bgcolor=#8f95ac width=1px></td></tr>"; }

for($i=0;$i<$all_freehosting;$i++) {
$row_freehosting_array = explode("|", $freehosting_array[$i]);

if($row_freehosting_array) {
$id_freehosting = trim($row_freehosting_array[0]);
$name_freehosting = trim($row_freehosting_array[1]);

echo "<form action=\""."$_SERVER[PHP_SELF]"."\" method=\"POST\">
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2><hr></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left nowrap valign=top>"."$row_freehosting_array[1]"."</td><td bgcolor=#8f95ac align=center valign=top><a href="."$_SERVER[PHP_SELF]"."?delete_freehosting="."$row_freehosting_array[0]".">Удалить</a></td><td bgcolor=#8f95ac width=1px></td></tr>";

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
<font face=Verdana size=1 color=white><b>Бесплатные хостинги</b></font><br>Вы можете запретить добавление в Ваш каталог сайтов, 
расположенных на бесплатных хостингах (пример: narod.ru, h15.ru).<br><br>
Для этого необходимо добавить название хостинга в этом разделе, 
а в разделе \"Конфигурация\" - \"Настройки для проверки входящей информации\", выбрать \"Нет\" при ответе на вопрос: 
\"Разрешить добавление сайтов с бесплатных хостингов?\".<br><br>
Если Вы допустили ошибку в написании имени хоста, просто удалите соответствующую запись и введите снова правильную.<br><br>
Собственно можно запретить добавление и не бесплатных хостингов. Пример:<br>
На домене domen.ru есть несколько доменов третьего уровня созданных специально для \"нечестного\" обмена ссылками. Скажем link1.domen.ru, link2.domen.ru и т.д. 
Если Вы внесете в этот список название домена domen.ru - добавление в каталог домена третьего уровня с любым именем, расположенного на domen.ru будет невозможным 
(при услловии, что Вы включили этот запрет в \"Конфигурации\".
</div>";

echo "</td><td bgcolor=#8f95ac width=1px></td></tr>
	  <tr><td align=right valign=top width=1px><img src=images/login_ld.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_rd.gif width=8 height=8 border=0></td></tr>
      </table>";

echo "</td></tr></table>";
@ignore_user_abort($old_abort);
?>
</body>
</html>