<?php
error_reporting(0);
@$old_abort = ignore_user_abort(true);
session_start();
include "adminic.php";

// Обрисуем, где находимся
$place = "ДИЗАЙН";
// ---------------------------------------------------------------------------------------------------------------------------------
// Если изменяем файл main.css
if($_POST['maincss'] AND $_SESSION['owner_status']=="this_admin") {
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$fp=fopen("design/main.css","w");
fputs($fp, "$_POST[maincss]");
fclose($fp);
flock($lock, LOCK_UN);
fclose($lock);
} else {
$_SESSION['error'] = "Не могу заблокировать служебный файл data/base.lck !!!";
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=error.php'>
	  </HEAD></HTML>";
exit();
}
} // конец если меняем файл main.css
// ---------------------------------------------------------------------------------------------------------------------------------
// Если изменяем файл form.css
if($_POST['formcss'] AND $_SESSION['owner_status']=="this_admin") {
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$fp=fopen("design/form.css","w");
fputs($fp, "$_POST[formcss]");
fclose($fp);
flock($lock, LOCK_UN);
fclose($lock);
} else {
$_SESSION['error'] = "Не могу заблокировать служебный файл data/base.lck !!!";
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=error.php'>
	  </HEAD></HTML>";
exit();
}
} // конец если меняем файл form.css
// ---------------------------------------------------------------------------------------------------------------------------------
// Если изменяем файл header.inc
if($_POST['headerinc'] AND $_SESSION['owner_status']=="this_admin") {
$_POST['headerinc'] = stripslashes($_POST['headerinc']);
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$fp=fopen("design/header.inc","w");
fputs($fp, "$_POST[headerinc]");
fclose($fp);
flock($lock, LOCK_UN);
fclose($lock);
} else {
$_SESSION['error'] = "Не могу заблокировать служебный файл data/base.lck !!!";
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=error.php'>
	  </HEAD></HTML>";
exit();
}
} // конец если меняем файл header.inc
// ---------------------------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------------------
// Если изменяем файл footer.inc
if($_POST['footerinc'] AND $_SESSION['owner_status']=="this_admin") {
$_POST['footerinc'] = stripslashes($_POST['footerinc']);
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$fp=fopen("design/footer.inc","w");
fputs($fp, "$_POST[footerinc]");
fclose($fp);
flock($lock, LOCK_UN);
fclose($lock);
} else {
$_SESSION['error'] = "Не могу заблокировать служебный файл data/base.lck !!!";
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=error.php'>
	  </HEAD></HTML>";
exit();
}
} // конец если меняем файл footer.inc
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
// ---------------------------------------------------------------------------------------------------------------------------------
// Читаем файл main.css
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$maincss = file("design/main.css");
flock($lock, LOCK_UN);
fclose($lock);
} else {
$_SESSION['error'] = "Не могу заблокировать служебный файл data/base.lck !!!";
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=error.php'>
	  </HEAD></HTML>";
exit();
}
$maincss = implode("",$maincss);
// Выводим для редактирования файл main.css
echo "<form action=\""."$_SERVER[PHP_SELF]"."\" method=\"POST\"><table width=560px cellspacing=0 cellpadding=0>
      <tr><td align=right valign=top width=1px><img src=images/login_lu.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_ru.gif width=8 height=8 border=0></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td class=title bgcolor=#8f95ac align=left colspan=2>Файл main.css</td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=center colspan=2 valign=top><textarea name=maincss rows=10 cols=84>"."$maincss"."</textarea><br></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=center colspan=2 valign=top><input name=submit type=submit value=\"Сохранить изменения в main.css\"></td><td bgcolor=#8f95ac width=1px></td></tr>
	  <tr><td align=right valign=top width=1px><img src=images/login_ld.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_rd.gif width=8 height=8 border=0></td></tr>
      </table></form>";
// ---------------------------------------------------------------------------------------------------------------------------------
// Читаем файл form.css
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$formcss = file("design/form.css");
flock($lock, LOCK_UN);
fclose($lock);
} else {
$_SESSION['error'] = "Не могу заблокировать служебный файл data/base.lck !!!";
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=error.php'>
	  </HEAD></HTML>";
exit();
}
$formcss = implode("",$formcss);
// Выводим для редактирования файл form.css
echo "<form action=\""."$_SERVER[PHP_SELF]"."\" method=\"POST\"><table width=560px cellspacing=0 cellpadding=0>
      <tr><td align=right valign=top width=1px><img src=images/login_lu.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_ru.gif width=8 height=8 border=0></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td class=title bgcolor=#8f95ac align=left colspan=2>Файл form.css</td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=center colspan=2 valign=top><textarea name=formcss rows=10 cols=84>"."$formcss"."</textarea><br></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=center colspan=2 valign=top><input name=submit type=submit value=\"Сохранить изменения в form.css\"></td><td bgcolor=#8f95ac width=1px></td></tr>
	  <tr><td align=right valign=top width=1px><img src=images/login_ld.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_rd.gif width=8 height=8 border=0></td></tr>
      </table></form>";
// ---------------------------------------------------------------------------------------------------------------------------------
// Читаем файл header.inc
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$headerinc = file("design/header.inc");
flock($lock, LOCK_UN);
fclose($lock);
} else {
$_SESSION['error'] = "Не могу заблокировать служебный файл data/base.lck !!!";
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=error.php'>
	  </HEAD></HTML>";
exit();
}
$headerinc = implode("",$headerinc);
// Выводим для редактирования файл form.css
echo "<form action=\""."$_SERVER[PHP_SELF]"."\" method=\"POST\"><table width=560px cellspacing=0 cellpadding=0>
      <tr><td align=right valign=top width=1px><img src=images/login_lu.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_ru.gif width=8 height=8 border=0></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td class=title bgcolor=#8f95ac align=left colspan=2>Файл header.inc</td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=center colspan=2 valign=top><textarea name=headerinc rows=10 cols=84>"."$headerinc"."</textarea><br></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=center colspan=2 valign=top><input name=submit type=submit value=\"Сохранить изменения в header.inc\"></td><td bgcolor=#8f95ac width=1px></td></tr>
	  <tr><td align=right valign=top width=1px><img src=images/login_ld.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_rd.gif width=8 height=8 border=0></td></tr>
      </table></form>";
// ---------------------------------------------------------------------------------------------------------------------------------
// Просто покажем, что здесь сам скрипт
echo "<table width=560px cellspacing=0 cellpadding=0>
      <tr><td align=right valign=top width=1px><img src=images/login_lu.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_ru.gif width=8 height=8 border=0></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2>В этом месте, получившейся итоговой странички и будет подключаться на выполнение сам скрипт. Этот комментарий дан всего лишь для наглядности.</td><td bgcolor=#8f95ac width=1px></td></tr>
	  <tr><td align=right valign=top width=1px><img src=images/login_ld.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_rd.gif width=8 height=8 border=0></td></tr>
      </table>";
// ---------------------------------------------------------------------------------------------------------------------------------
// Читаем файл footer.inc
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$footerinc = file("design/footer.inc");
flock($lock, LOCK_UN);
fclose($lock);
} else {
$_SESSION['error'] = "Не могу заблокировать служебный файл data/base.lck !!!";
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=error.php'>
	  </HEAD></HTML>";
exit();
}
$footerinc = implode("",$footerinc);
// Выводим для редактирования файл form.css
echo "<form action=\""."$_SERVER[PHP_SELF]"."\" method=\"POST\"><table width=560px cellspacing=0 cellpadding=0>
      <tr><td align=right valign=top width=1px><img src=images/login_lu.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_ru.gif width=8 height=8 border=0></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td class=title bgcolor=#8f95ac align=left colspan=2>Файл footer.inc</td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=center colspan=2 valign=top><textarea name=footerinc rows=10 cols=84>"."$footerinc"."</textarea><br></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=center colspan=2 valign=top><input name=submit type=submit value=\"Сохранить изменения в footer.inc\"></td><td bgcolor=#8f95ac width=1px></td></tr>
	  <tr><td align=right valign=top width=1px><img src=images/login_ld.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_rd.gif width=8 height=8 border=0></td></tr>
      </table></form>";
// ---------------------------------------------------------------------------------------------------------------------------------
echo "</td><td valign=top align=right>"; // вторая ячейка в строке
// ---------------------------------------------------------------------------------------------------------------------------------
// Начало таблицы для хелпов
echo "<table width=360 cellspacing=0 cellpadding=0>
      <tr><td align=right valign=top width=1px><img src=images/login_lu.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_ru.gif width=8 height=8 border=0></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td class=title bgcolor=#8f95ac align=right colspan=2>Help</td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2>";
	  
echo "<div align=justify>
<font face=Verdana size=1 color=white><b>Настройка дизайна</b></font><br>Вы можете без особых проблем настроить дизайн скрипта под дизайн своего сайта. 
Для этого Вам дается возможность редактирования файлов стилей main.css (дизайн главной страницы скрипта) и form.css (дизайн формы добавления ссылок), 
а также файлов header.inc (верхняя и левая части для главной страницы и страницы формы) и footer.inc (правая и нижняя части для главной страницы и страницы формы).<br><br>

Файл <b>main.css</b> подключается в качестве файла таблиц каскадных стилей к основному файлу скрипта index.php и определяет дизайн этого файла;<br><br>
Файл <b>form.css</b> подключается в качестве файла таблиц каскадных стилей к файлу формы добавления данных submit.php и соответственно, определяет дизайн формы;<br><br>

В файлах таблиц каскадных стилей <b>main.css</b> и <b>form.css</b> практически каждый элемент описывается отдельно. Каждый элемент подробно откомментирован.<br><br>

Файлы <b>header.inc</b> и <b>footer.inc</b> подключаются к файлам index.php и submit.php и могут содержать Ваши собственные HTML-коды, отвечающие за оригинальное оформление Вашей страницы (Ваши меню, рекламные блоки, блоки статистики и т.д.).<br><br>
<b><font color=red><обратите внимание></font></b> В файл <b>header.inc</b> Вы можете сформировать заголовки, ключевые слова и описания для разных страниц скрипта. Здесь же, в заголовке, Вы можете подключить дополнительные файлы стилей. Тэг &lt;BODY&gt; открывается здесь же.<br><br>
<b><font color=red><обратите внимание></font></b> Файл <b>footer.inc</b> не должен содержать закрывающих тэгов &lt;/BODY&gt; и &lt;/HTML&gt;. Они будут закрыты позже, в тексте самого скрипта.

</div>";


echo "</td><td bgcolor=#8f95ac width=1px></td></tr>
	  <tr><td align=right valign=top width=1px><img src=images/login_ld.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_rd.gif width=8 height=8 border=0></td></tr>
      </table>";

echo "</td></tr></table>";
@ignore_user_abort($old_abort);
?>
</body>
</html>