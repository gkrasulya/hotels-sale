<?php
error_reporting(0);
session_start();
setcookie("linkexchanger", "1");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html><head><title>LinkExchanger 2.0 :: Admin Area</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<meta name="robots" content="noindex">
<link rel="stylesheet" type="text/css" href="auth.css">
</head>
<body>
<?php
if(!isset($_POST['enter']) || !isset($_POST['lgn']) || !isset($_POST['psw'])) {
echo "<center><table width=600 cellspacing=2 cellpadding=0>
      <tr><td colspan=2>&nbsp;</td></tr>
      <tr><td colspan=2 align=left><a href=\"http://samkov.msk.ru\"><img src=images/logo.gif width=400 height=70 border=0></a></td></tr>
      <tr><td colspan=2><hr size=1></td></tr>";
	 
echo "<td valign=top>";

echo "<center><form action=\""."$_SERVER[PHP_SELF]"."\" method=\"POST\"><table width=200 cellspacing=0 cellpadding=0>
      <tr><td align=right valign=top width=1px><img src=images/login_lu.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_ru.gif width=8 height=8 border=0></td></tr>
      <td bgcolor=#8f95ac width=1px></td><td colspan=2 valign=top bgcolor=#8f95ac><b>Центр администрирования</b><br><br></td><td bgcolor=#8f95ac width=1px></td></tr>
      <td bgcolor=#8f95ac width=1px></td><td colspan=2 valign=top bgcolor=#8f95ac>Введите логин:<br><input name=\"lgn\" type=\"text\" size=\"24\" maxlength=\"255\" value=\""."$_POST[lgn]"."\"></td><td bgcolor=#8f95ac width=1px></td></tr>
      <td bgcolor=#8f95ac width=1px></td><td colspan=2 valign=top bgcolor=#8f95ac>Введите пароль:<br><input name=\"psw\" type=\"password\" size=\"24\" maxlength=\"255\" value=\""."$_POST[psw]"."\"></td><td bgcolor=#8f95ac width=1px></td></tr>";
if($HTTP_COOKIE_VARS['linkexchanger']==1) {
echo "<td bgcolor=#8f95ac width=1px></td><td colspan=2 valign=top bgcolor=#8f95ac><input name=\"enter\" type=\"submit\" value=\"Войти\"></td><td bgcolor=#8f95ac width=1px></td></tr>";
} else {
echo "<td bgcolor=#8f95ac width=1px></td><td colspan=2 valign=top bgcolor=#8f95ac><b>Для корректной работы в центре администрирования cookie должны быть включены с этого места!<br><br>Если поддержка cookie включена, просто нажмите F5 или \"Обновить\" в Вашем браузере.</b></td><td bgcolor=#8f95ac width=1px></td></tr>";
}
echo "<tr><td align=right valign=top width=1px><img src=images/login_ld.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_rd.gif width=8 height=8 border=0></td></tr>
      </table></form></center>";

echo "</td><td valign=top>";

echo "<center><table width=400 cellspacing=0 cellpadding=0>
      <tr><td align=right valign=top width=1px><img src=images/login_lu.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_ru.gif width=8 height=8 border=0></td></tr>
      <td bgcolor=#8f95ac width=1px></td><td colspan=2 valign=top bgcolor=#8f95ac><b>Новости LinkExchanger'a</b><br><br>";
      include "http://samkov.msk.ru/news.php";
echo "</td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td align=right valign=top width=1px><img src=images/login_ld.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_rd.gif width=8 height=8 border=0></td></tr>
      </table></center>";

echo "</td></tr>";

echo "<tr><td colspan=2><hr size=1></td></tr>
      </table></center></body></html>";

exit();
} else {
$auth_array = file("config/password.dat");
$auth_count = count($auth_array);
if($auth_count != 1 || !is_writable("config/password.dat")) {
echo "<center><table width=400 cellspacing=0 cellpadding=0>
      <tr><td align=right valign=top width=1px><img src=images/login_lu.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_ru.gif width=8 height=8 border=0></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=center colspan=2><b>Не выставлены права на запись или некорректное содержимое файла password.dat</b></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=center colspan=2><a href=auth.php>LinkExchanger 2.0</a></td><td bgcolor=#8f95ac width=1px></td></tr>
	  <tr><td align=right valign=top width=1px><img src=images/login_ld.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_rd.gif width=8 height=8 border=0></td></tr>
      </table></center></body></html>";
exit();
} else {
$row_auth = explode("|", $auth_array[0]);
$base_login = trim($row_auth[0]);
$base_password = trim($row_auth[1]);
}
}

if($base_password != md5($_POST['psw']) || $base_login != $_POST['lgn']) {
echo "<center><table width=400 cellspacing=0 cellpadding=0>
      <tr><td align=right valign=top width=1px><img src=images/login_lu.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_ru.gif width=8 height=8 border=0></td></tr>
      <td bgcolor=#8f95ac width=1px></td><td colspan=2 valign=top align=center bgcolor=#8f95ac><b>Неверно введены логин и/или пароль!</b><br><br></td><td bgcolor=#8f95ac width=1px></td></tr>
      <td bgcolor=#8f95ac width=1px></td><td colspan=2 valign=top align=center bgcolor=#8f95ac>| <a href=../index.php>на главную</a> || <a href=auth.php>попробовать еще</a> |</td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td align=right valign=top width=1px><img src=images/login_ld.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_rd.gif width=8 height=8 border=0></td></tr>
      </table></center></body></html>";
exit();
} else {
$_SESSION['owner_status'] = "this_admin";
echo "<center><table width=400 cellspacing=0 cellpadding=0>
      <tr><td align=right valign=top width=1px><img src=images/login_lu.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_ru.gif width=8 height=8 border=0></td></tr>
      <td bgcolor=#8f95ac width=1px></td><td colspan=2 valign=top align=center bgcolor=#8f95ac><b>Проверка логина и пароля прошла успешно!</b><br><br></td><td bgcolor=#8f95ac width=1px></td></tr>
      <td bgcolor=#8f95ac width=1px></td><td colspan=2 valign=top align=center bgcolor=#8f95ac><a href=config.php>Вход</a></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td align=right valign=top width=1px><img src=images/login_ld.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_rd.gif width=8 height=8 border=0></td></tr>
      </table></center></body></html>";
exit();
}
?>