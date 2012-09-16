<?php
error_reporting(0);
session_start();
include "adminic.php";

// Обрисуем, где находимся
$place = "ПРАВИЛА";
// -----------------------------------------------------------------------------

// -----------------------------------------------------------------------------
// Если редактируем правила
if($_POST['edit_rules'] AND $_SESSION['owner_status']=="this_admin") {

$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$fp=fopen("data/rules.dat","w");
fputs($fp, "$_POST[rules]");
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


} // Если редактируем правила
// -----------------------------------------------------------------------------

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
// Читаем из файла правила и выводим их
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$rules_array = file("data/rules.dat");
flock($lock, LOCK_UN);
fclose($lock);
} else {
$_SESSION['error'] = "Не могу заблокировать служебный файл data/base.lck !!!";
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=error.php'>
	  </HEAD></HTML>";
exit();
}

$rules = implode("",$rules_array);
echo "<table width=100% cellspacing=0 cellpadding=0>
      <tr><td align=right valign=top width=1px><img src=images/login_lu.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_ru.gif width=8 height=8 border=0></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td class=title bgcolor=#8f95ac align=left colspan=2>Правила добавления в каталог<br><br></td><td bgcolor=#8f95ac width=1px></td></tr>";

echo "<form action=\""."$_SERVER[PHP_SELF]"."\" method=\"POST\">
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2><textarea name=\"rules\" rows=\"17\" cols=\"64\" style=\"width:550px;\">"."$rules"."</textarea></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=center colspan=2><input name=\"edit_rules\" type=\"submit\" value=\"Изменить\"></td><td bgcolor=#8f95ac width=1px></td></tr>
	  </form>";
	  
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
<font face=Verdana size=1 color=white><b>Правила добавления в каталог</b></font><br>
Используйте форму в этом разделе для создания Правил добавления ссылок в свой каталог.<br><br>
Вы можете использовать HTML-тэги при написании правил. Никаких проверок вводимой информации для администратора каталога в этом разделе не предусмотрено.<br><br>
При написании правил, учитывайте те настройки, которые Вы определили в разделе \"Конфигурация\" - \"Настройки для проверки входящей информации\".
</div>";

echo "</td><td bgcolor=#8f95ac width=1px></td></tr>
	  <tr><td align=right valign=top width=1px><img src=images/login_ld.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_rd.gif width=8 height=8 border=0></td></tr>
      </table>";

echo "</td></tr></table>";

?>
</body>
</html>