<?php
error_reporting(0);
session_start();
include "adminic.php";
include "functions/cut.php";
// Обрисуем, где находимся
$place = "ПИСЬМА";
// -----------------------------------------------------------------------------

// -----------------------------------------------------------------------------
// Если редактируем письма
if($_POST['edit_letter'] AND $_POST['id_letter'] AND $_SESSION['owner_status']=="this_admin") {
$id = trim($_POST['id_letter']);
$title_message = Cut_All_All($_POST['title_message']);
$message = trim(stripslashes($_POST['message']));
$subject = Cut_All_All($_POST['subject']);
$onoff_letter = trim($_POST['onoff_letter']);

if(!$subject||!$message||!$title_message) {
$add_error_empty = "Все поля формы обязательны для заполнения!";
unset($title_message);
unset($message);
unset($subject);
} else {
unset($add_error_empty);
}

if(!$add_error_empty) {
// Редактируем письмо
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {

$path_t = "letters/t"."$id".".txt";
$path_s = "letters/s"."$id".".txt";
$path_m = "letters/m"."$id".".txt";
$path_w = "letters/w"."$id".".txt";

$ft=fopen("$path_t","w");
$fs=fopen("$path_s","w");
$fm=fopen("$path_m","w");
$fw=fopen("$path_w","w");

fputs($ft, "$title_message\r\n");
fputs($fs, "$subject\r\n");
fputs($fm, "$message\r\n");
fputs($fw, "$onoff_letter\r\n");

fclose($ft);
fclose($fs);
fclose($fm);
fclose($fw);

flock($lock, LOCK_UN);
fclose($lock);
$_SESSION['ok_config'] = "Письмо успешно отредактировано!";
header("Location: $_SERVER[PHP_SELF]");
exit();
} else {
$_SESSION['error'] = "Не могу заблокировать служебный файл data/base.lck !!!";
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=error.php'>
	  </HEAD></HTML>";
exit();
}
}
}
// Если редактируем письма
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
// если есть ошибки - показываем
if($add_error_empty) {
echo "<table width=100% cellspacing=0 cellpadding=0>
      <tr><td align=right valign=top width=1px><img src=images/login_lu.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_ru.gif width=8 height=8 border=0></td></tr>
	  <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2><font color=red><b>Ошибка!</b><hr>"."$add_error_empty"."</font></td><td bgcolor=#8f95ac width=1px></td></tr>
	  <tr><td align=right valign=top width=1px><img src=images/login_ld.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_rd.gif width=8 height=8 border=0></td></tr>
      </table><br>";
}
// ---------------------------------------------------------------------------------------------------------------------------------
// Читаем из файлов письма, темы, названия и выводим их
echo "<table width=100% cellspacing=0 cellpadding=0>
      <tr><td align=right valign=top width=1px><img src=images/login_lu.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_ru.gif width=8 height=8 border=0></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td class=title bgcolor=#8f95ac align=left colspan=2>Шаблоны писем администратора [15]<br><br></td><td bgcolor=#8f95ac width=1px></td></tr>";

for($i=1;$i<=15;$i++) {
$path_m[$i] = "letters/m"."$i".".txt";
$letter_message[$i] = file("$path_m[$i]");
$letter_message[$i] = implode("",$letter_message[$i]);
$path_s[$i] = "letters/s"."$i".".txt";
$letter_subject[$i] = file("$path_s[$i]");
$letter_subject[$i] = implode("",$letter_subject[$i]);
$path_t[$i] = "letters/t"."$i".".txt";
$letter_title[$i] = file("$path_t[$i]");
$letter_title[$i] = implode("",$letter_title[$i]);
$path_w[$i] = "letters/w"."$i".".txt";
$letter_swith[$i] = file("$path_w[$i]");
$letter_swith[$i] = implode("",$letter_swith[$i]);
if(trim($letter_swith[$i])=="on") { $checked = "checked"; } else { $checked = ""; }


echo "<form action=\""."$_SERVER[PHP_SELF]"."\" method=\"POST\">
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2><hr></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=right nowrap width=1% valign=top colspan=2><b>ID: "."$i"."</b></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left nowrap width=1% valign=top>Название письма:<br>(для администратора)</td><td bgcolor=#8f95ac align=right><input name=\"title_message\" type=\"text\" maxlength=\"36\" style=\"width:400px; font-weight:bold;\" value=\""."$letter_title[$i]"."\"></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left nowrap width=1% valign=top>Тема письма:</td><td bgcolor=#8f95ac align=right><input name=\"subject\" type=\"text\" maxlength=\"72\" style=\"width:285px;\" value=\""."$letter_subject[$i]"."\"><input name=\"edit_letter\" type=\"submit\" style=\"width:50px;\" value=\"Edit\">&nbsp;On/Off&nbsp;<input name=\"onoff_letter\" type=\"checkbox\" style=\"width:20px;\" "."$checked"."></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left nowrap width=1% valign=top>Текст письма:</td><td bgcolor=#8f95ac align=right><textarea name=\"message\" rows=\"4\" cols=\"64\" style=\"width:400px;\">"."$letter_message[$i]"."</textarea><input name=\"id_letter\" type=\"hidden\" value=\""."$i"."\"></td><td bgcolor=#8f95ac width=1px></td></tr>
	  </form>";

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
<font face=Verdana size=1 color=white><b>Шаблоны писем администратора</b></font><br>
Предусмотрено 15 шаблонов писем отправляемых скриптом от имени администратора.
Все шаблоны отключаемые. Для того, чтобы соответствующее письмо отправлялось - необходимо, чтобы \"галочкой\" был отмечен его checkbox.<br><br>
Шаблоны с 1 по 11 служебные, которые отправляются в заранее определенных случаях. Шаблоны с 12 по 15 администратор каталога может использовать по своему усмотрению для отправки писем пользователям.<br><br>
Для того чтобы отредактировать шаблон, внесите в него изменения и нажмите \"Edit\".
</div>";
echo "<div align=justify>
<font face=Verdana size=1 color=red><br><b>< обратите книмание ></b></font><br>
Шаблоны с 1 по 11 \"закреплены\" за определенным событием. Не изменяйте это соответствие во избежание недоразумений! Список соответствия событий с номерами писем Вы найдете ниже.<br><font color=red>Внимание! Тексты писем даны только для примера. Для использования их необходимо отредактировать как нужно Вам! Чтобы нужное письмо отправлялось автоматически, его необходимо включить!</font><br><br>
</div>";
echo "<div align=justify>
<font face=Verdana size=1 color=white><b>Соответствия шаблона письма событию</b></font><br>
<b>ID1</b> - администратор каталога самостоятельно добавил ссылку - письмо будет отправлено на почтовый адрес пользователя, если он известен администратору;<br>
<b>ID2</b> - администратор каталога удалил ссылку в корзину - письмо будет отправлено на почтовый адрес пользователя, если он присутствует в базе;<br>
<b>ID3</b> - администратор каталога временно скрыл ссылку - письмо будет отправлено на почтовый адрес пользователя, если он присутствует в базе;<br>
<b>ID4</b> - в каталог добавлена ссылка (при условии, если настройки подразумевают добавление сразу в каталог) - письмо будет отправлено администратору каталога;<br>
<b>ID5</b> - на модерацию добавлена ссылка (при условии, если настройки подразумевают добавление на модерацию) - письмо будет отправлено администратору каталога;<br>
<b>ID6</b> - в каталог добавлена ссылка (при условии, если настройки подразумевают добавление сразу в каталог) - письмо будет отправлено на почтовый адрес пользователя, указанный при добавлении в каталог;<br>
<b>ID7</b> - ссылка добавлена на модерацию (при условии, если настройки подразумевают добавление на модерацию) - письмо будет отправлено на почтовый адрес пользователя, указанный при добавлении в каталог;<br>
<b>ID8</b> - ссылка успешно прошла модерацию (при условии, если настройки подразумевают добавление на модерацию) - письмо будет отправлено на почтовый адрес пользователя, указанный при добавлении в каталог;<br>
<b>ID9</b> - ссылка активизирована (если она была ранее по какой-либо причине скрыта администратором) - письмо будет отправлено на почтовый адрес пользователя, указанный при добавлении в каталог;<br>
<b>ID10</b> - ссылка помещена администратором в блэк-лист каталога - письмо будет отправлено на почтовый адрес пользователя, указанный при добавлении в каталог;<br>
<b>ID11</b> - изменена категория ссылки в каталоге - письмо будет отправлено на почтовый адрес пользователя, указанный при добавлении в каталог;<br><br>
</div>";
echo "<div align=justify>
<font face=Verdana size=1 color=white><b>Использование данных в шаблонах</b></font><br>
В шаблоне любого письма, включая свободные шаблоны администратора, Вы можете использовать для автоматической подстановки в тело письма следующие замены:<br><br>
<b>IMP_MYHOME</b> - адрес Вашего сайта;<br>
<b>ADM_E_MAIL</b> - e-mail администратора каталога;<br>
<b>LINK_PLACE</b> - адрес ссылки партнера в Вашем каталоге;<br>
<b>BACK_LINK</b> - адрес ответной ссылки на Ваш сайт;<br>
<b>NICK_NAME</b> - имя или никнейм партнера по обмену;<br>
<b>OUT_LINKS</b> - кол-во ссылок на проверенной странице;<br>
<b>PAGE_PR</b> - PR Google для проверенной страницы;<br>
<b>SITE_CY</b> - CY Yandex для сайта партнера по обмену;<br>
<b>ADM_COMMENT</b> - комментарий администратора каталога;<br>
</div>";

echo "</td><td bgcolor=#8f95ac width=1px></td></tr>
	  <tr><td align=right valign=top width=1px><img src=images/login_ld.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_rd.gif width=8 height=8 border=0></td></tr>
      </table>";

echo "</td></tr></table>";

?>
</body>
</html>