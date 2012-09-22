<?php
error_reporting(0);
@$old_abort = ignore_user_abort(true);
session_start();
include "adminic.php";

// Получаем массивы с конфигурацией
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$cnf_imp_array = file("config/cnfimp.dat"); // важные настройки
$cnf_adm_array = file("config/cnfadm.dat"); // настройки администратора
$cnf_checkinfo_array = file("config/cnfcheckinfo.dat"); // настройки для проверки вводимой информации
$cnf_visual_array = file("config/cnfvisual.dat"); // визуальные настройки главной страницы и формы
$cnf_cron_array = file("config/cnfcron.dat"); // файл содержит полный путь для запуска крона
flock($lock, LOCK_UN);
fclose($lock);
} else {
$_SESSION['error'] = "Не могу заблокировать служебный файл data/base.lck !!!";
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=error.php'>
	  </HEAD></HTML>";
exit();
}

// Загоняем в сессию данные из важных настроек
$row_cnf_imp = explode("|", $cnf_imp_array[0]);
$_SESSION['imp_myhome'] = trim($row_cnf_imp[0]); // свой хост
$_SESSION['imp_mode_url'] = trim($row_cnf_imp[1]); // вид URL'а
$_SESSION['imp_links_page'] = trim($row_cnf_imp[2]); // ссылок на стр. юзера

// Загоняем в сессию данные из настроек администратора
$row_cnf_adm = explode("|", $cnf_adm_array[0]);
$_SESSION['adm_row_page'] = trim($row_cnf_adm[0]); // ссылок на стр. админа
$_SESSION['adm_in_mail'] = trim($row_cnf_adm[1]); // кодировка писем от скрипта админу
$_SESSION['adm_out_mail'] = trim($row_cnf_adm[2]); // кодировка писем от скрипта юзерам
$_SESSION['adm_e_mail'] = trim($row_cnf_adm[3]); // почта админа
$_SESSION['adm_sort'] = trim($row_cnf_adm[4]); // сортировка по добавлению
$_SESSION['adm_old_link'] = trim($row_cnf_adm[5]); // старые ссылки через сколько суток
$_SESSION['adm_cy'] = trim($row_cnf_adm[6]); // определять как плохую - по CY
$_SESSION['adm_pr'] = trim($row_cnf_adm[7]); // определять как плохую - по PR
$_SESSION['adm_out_links'] = trim($row_cnf_adm[8]); // определять как плохую - по кол-ву линков
$_SESSION['adm_backup_time'] = trim($row_cnf_adm[9]); // дата и время последнего BackUp'a
$_SESSION['adm_sort_select'] = trim($row_cnf_adm[10]); // переключение сортировок
$_SESSION['adm_sort_2'] = trim($row_cnf_adm[11]); // сортировка по проверке
$_SESSION['adm_new_link'] = trim($row_cnf_adm[12]); // новые ссылки через сколько суток
$_SESSION['adm_need_link'] = trim($row_cnf_adm[13]); // требовать ответную ссылку при проверке?

// Загоняем в сессию данные из блоке настроек проверки вводимой информации
$row_cnf_checkinfo = explode("|", $cnf_checkinfo_array[0]);
$_SESSION['chkinfo_urlink'] = trim($row_cnf_checkinfo[0]); // проверять наличие ответной ссылки
$_SESSION['chkinfo_cy'] = trim($row_cnf_checkinfo[1]); // проверять CY
$_SESSION['chkinfo_pr'] = trim($row_cnf_checkinfo[2]); // проверять PR
$_SESSION['chkinfo_out_links'] = trim($row_cnf_checkinfo[3]); // количество линков на проверяемой странице
$_SESSION['chkinfo_tag_noindex'] = trim($row_cnf_checkinfo[4]); // тэги ноиндех
$_SESSION['chkinfo_meta_robots'] = trim($row_cnf_checkinfo[5]); // метатэг роботс
$_SESSION['chkinfo_file_robots'] = trim($row_cnf_checkinfo[6]); // файл роботс
$_SESSION['chkinfo_links_code'] = trim($row_cnf_checkinfo[7]); // ссылок в многоссылочном коде
$_SESSION['chkinfo_symbol_code'] = trim($row_cnf_checkinfo[8]); // символов в коде
$_SESSION['chkinfo_domen_domen'] = trim($row_cnf_checkinfo[9]); // домены в многоссылочном коде
$_SESSION['chkinfo_myhome_domen'] = trim($row_cnf_checkinfo[10]); // домен куда ссылаться=домену откуда ссылаются
$_SESSION['chkinfo_free_hosting'] = trim($row_cnf_checkinfo[11]); // бесплатные хостинги
$_SESSION['chkinfo_moder'] = trim($row_cnf_checkinfo[12]); // на модерацию или сразу в каталог
$_SESSION['chkinfo_tags_p'] = trim($row_cnf_checkinfo[13]); //
$_SESSION['chkinfo_tags_br'] = trim($row_cnf_checkinfo[14]); //
$_SESSION['chkinfo_tags_i'] = trim($row_cnf_checkinfo[15]); //
$_SESSION['chkinfo_tags_u'] = trim($row_cnf_checkinfo[16]); //
$_SESSION['chkinfo_tags_b'] = trim($row_cnf_checkinfo[17]); //
$_SESSION['chkinfo_tags_strong'] = trim($row_cnf_checkinfo[18]); //
$_SESSION['chkinfo_tags_font'] = trim($row_cnf_checkinfo[19]); //
$_SESSION['chkinfo_tags_flash'] = trim($row_cnf_checkinfo[20]); //
$_SESSION['chkinfo_count_links'] = trim($row_cnf_checkinfo[21]); // как считать ссылки

// Обрисуем, где находимся
$place = "КОНФИГУРАЦИЯ";
// ---------------------------------------------------------------------------------------------------------------------------------

// ---------------------------------------------------------------------------------------------------------------------------------
// Если меняем данные в блоке логин-пароль
if($_POST['change_login'] AND $_SESSION['owner_status']=="this_admin") {
if(!$_POST['lgn']||!$_POST['psw']||!$_POST['psw2']) { $_SESSION['error_config'] = "Не введены логин и/или пароли!"; header("Location: $_SERVER[PHP_SELF]"); exit(); }
if($_POST['psw'] != $_POST['psw2']) { $_SESSION['error_config'] = "Введенные пароли не совпадают!"; header("Location: $_SERVER[PHP_SELF]"); exit(); }
$password = md5($_POST['psw']);
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$tmp=fopen("config/tmp.dat","w");
fputs($tmp, "$_POST[lgn]|$password\r\n");
fclose($tmp);
unlink("config/password.dat");
rename("config/tmp.dat", "config/password.dat");
flock($lock, LOCK_UN);
fclose($lock);
} else {
$_SESSION['error_config'] = "Не могу заблокировать служебный файл data/base.lck !!!";
header("Location: error.php");
exit();
}
$_SESSION['ok_config'] = "Логин и/или пароль успешно изменены!";
header("Location: $_SERVER[PHP_SELF]");
exit();
}
// ---------------------------------------------------------------------------------------------------------------------------------
// Если меняем данные в блоке визуальных настроек главной страницы
if($_POST['change_visual'] AND $_SESSION['owner_status']=="this_admin") {
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$tmp=fopen("config/tmp.dat","w");
fputs($tmp, "$_POST[vis_show_category]|$_POST[vis_col_num]|$_POST[vis_sort_cat]|$_POST[vis_last_links]|$_POST[vis_show_cat]|$_POST[vis_show_date]|$_POST[vis_show_pr]|$_POST[vis_show_cy]|$_POST[vis_none_or_cy]|$_POST[vis_show_search]|$_POST[vis_show_button]|$_POST[vis_show_form]|$_POST[vis_show_codes]|$_POST[vis_show_rules]|$_POST[vis_show_mailtoadmin]|$_POST[vis_show_qntlinks]|$_POST[vis_shuffle_codes]|$_POST[vis_show_hh]|$_POST[vis_codes_qnt]|$_POST[vis_show_guard]|$_POST[vis_all_links]|$_POST[vis_user_lang]\r\n");
fclose($tmp);
unlink("config/cnfvisual.dat");
rename("config/tmp.dat", "config/cnfvisual.dat");
flock($lock, LOCK_UN);
fclose($lock);
} else {
$_SESSION['error_config'] = "Не могу заблокировать служебный файл data/base.lck !!!";
header("Location: error.php");
exit();
}
$_SESSION['ok_config'] = "Конфигурация визуальных настроек для главной страницы успешно изменена!";
header("Location: $_SERVER[PHP_SELF]");
exit();
}
// ---------------------------------------------------------------------------------------------------------------------------------
// Если меняем данные в блоке настроек проверки вводимой информации
if($_POST['change_checkinfo'] AND $_SESSION['owner_status']=="this_admin") {
if(!preg_match("/\d/", $_POST['chkinfo_cy'])) { $_SESSION['error_config'] = "Введены некорректные данные для CY Яндекса!"; header("Location: $_SERVER[PHP_SELF]"); exit(); }
if(!preg_match("/\d/", $_POST['chkinfo_pr'])) { $_SESSION['error_config'] = "Введены некорректные данные для PR Google!"; header("Location: $_SERVER[PHP_SELF]"); exit(); }
if(!preg_match("/\d/", $_POST['chkinfo_out_links'])) { $_SESSION['error_config'] = "Введены некорректные данные для количества исходящих ссылок!"; header("Location: $_SERVER[PHP_SELF]"); exit(); }
if(!preg_match("/\d/", $_POST['chkinfo_links_code'])) { $_SESSION['error_config'] = "Введены некорректные данные для количества ссылок в коде!"; header("Location: $_SERVER[PHP_SELF]"); exit(); }
if(!preg_match("/\d/", $_POST['chkinfo_symbol_code'])) { $_SESSION['error_config'] = "Введены некорректные данные для количества символов в коде!"; header("Location: $_SERVER[PHP_SELF]"); exit(); }
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$tmp=fopen("config/tmp.dat","w");
fputs($tmp, "$_POST[chkinfo_urlink]|$_POST[chkinfo_cy]|$_POST[chkinfo_pr]|$_POST[chkinfo_out_links]|$_POST[chkinfo_tag_noindex]|$_POST[chkinfo_meta_robots]|$_POST[chkinfo_file_robots]|$_POST[chkinfo_links_code]|$_POST[chkinfo_symbol_code]|$_POST[chkinfo_domen_domen]|$_POST[chkinfo_myhome_domen]|$_POST[chkinfo_free_hosting]|$_POST[chkinfo_moder]|$_POST[chkinfo_tags_p]|$_POST[chkinfo_tags_br]|$_POST[chkinfo_tags_i]|$_POST[chkinfo_tags_u]|$_POST[chkinfo_tags_b]|$_POST[chkinfo_tags_strong]|$_POST[chkinfo_tags_font]|$_POST[chkinfo_tags_flash]|$_POST[chkinfo_count_links]\r\n");
fclose($tmp);
unlink("config/cnfcheckinfo.dat");
rename("config/tmp.dat", "config/cnfcheckinfo.dat");
flock($lock, LOCK_UN);
fclose($lock);
} else {
$_SESSION['error_config'] = "Не могу заблокировать служебный файл data/base.lck !!!";
header("Location: error.php");
exit();
}
$_SESSION['ok_config'] = "Конфигурация настроек для проверки вводимой информации успешно изменена!";
header("Location: $_SERVER[PHP_SELF]");
exit();
}
// ---------------------------------------------------------------------------------------------------------------------------------
// Если меняем данные в важных настройках. Конечно, лучше, если это делается один раз, при установке скрипта, но все же...
if($_POST['change_imp'] AND $_SESSION['owner_status']=="this_admin") {
if(!preg_match("/\d/", $_POST['imp_links_page'])) { $_SESSION['error_config'] = "Введены некорректные данные для количества ссылок на страницу!"; header("Location: $_SERVER[PHP_SELF]"); exit(); }
if(!preg_match("/^(http:\/\/){1}[a-z0-9-\.]+\.[a-z]{2,4}$/i", $_POST['imp_myhome'])) { $_SESSION['error_config'] = "Введены некорректные данные для адреса Вашего сервера!"; header("Location: $_SERVER[PHP_SELF]"); exit(); }
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$tmp=fopen("config/tmp.dat","w");
fputs($tmp, "$_POST[imp_myhome]|$_POST[imp_mode_url]|$_POST[imp_links_page]\r\n");
fclose($tmp);
unlink("config/cnfimp.dat");
rename("config/tmp.dat", "config/cnfimp.dat");
if($_POST['imp_mode_url']=="Статический") {
// Определяем RewriteBase
$pos=strpos("$_SERVER[REQUEST_URI]", "admin");
$rb=substr("$_SERVER[REQUEST_URI]", 0, $pos);
$htas_content = "RewriteEngine on\r\nRewriteBase "."$rb"."\r\nRewriteRule ^(.*)(links_)([0-9]{10})_([0-9]{1,})\.html$ index.php?category=$3&page=$4\r\nRewriteRule ^(.*)(links_)([0-9]{1,})_([0-1]{1})\.html$ index.php?category=&page=$3&search=$4\r\n";
$ht = fopen("../.htaccess","w"); // пишем
fputs($ht, "$htas_content");
fclose($ht);
}
if($_POST['imp_mode_url']=="Динамический") {
$ht = fopen("../.htaccess","w");
fputs($ht, "");
fclose($ht);
}
flock($lock, LOCK_UN);
fclose($lock);
} else {
$_SESSION['error_config'] = "Не могу заблокировать служебный файл data/base.lck !!!";
header("Location: error.php");
exit();
}
$_SESSION['ok_config'] = "Конфигурация важнейших настроек успешно изменена!";
header("Location: $_SERVER[PHP_SELF]");
exit();
}
// ---------------------------------------------------------------------------------------------------------------------------------
// Если меняем данные в настройках администратора каталога
if($_POST['change_adm'] AND $_SESSION['owner_status']=="this_admin") {
if(!eregi("^([_a-z0-9-])+(\.)*([_a-z0-9-])*@([_a-z0-9-])+(\.)*([_a-z0-9-])*\.([a-z]){2,4}$", "$_POST[adm_e_mail]")) { $_SESSION['error_config'] = "Некорректно введен e-mail администратора!"; header("Location: $_SERVER[PHP_SELF]"); exit(); }
if(!preg_match("/\d/", $_POST['adm_row_page'])) { $_SESSION['error_config'] = "Некорректно введено количество записей на страницу!"; header("Location: $_SERVER[PHP_SELF]"); exit(); }
if($_POST['adm_row_page'] > 10) { $_SESSION['error_config'] = "Не надо делать более 10 записей на страницу!"; header("Location: $_SERVER[PHP_SELF]"); exit(); }
if(!preg_match("/\d/", $_POST['adm_new_link'])) { $_SESSION['error_config'] = "Некорректно введено количество дней!"; header("Location: $_SERVER[PHP_SELF]"); exit(); }
if(!preg_match("/\d/", $_POST['adm_old_link'])) { $_SESSION['error_config'] = "Некорректно введено количество дней!"; header("Location: $_SERVER[PHP_SELF]"); exit(); }
if(!preg_match("/\d/", $_POST['adm_cy'])) { $_SESSION['error_config'] = "Некорректно введена величина CY!"; header("Location: $_SERVER[PHP_SELF]"); exit(); }
if(!preg_match("/\d/", $_POST['adm_pr'])) { $_SESSION['error_config'] = "Некорректно введена величина PR!"; header("Location: $_SERVER[PHP_SELF]"); exit(); }
if(!preg_match("/\d/", $_POST['adm_out_links'])) { $_SESSION['error_config'] = "Некорректно введено кол-во ссылок на проверяемой странице!"; header("Location: $_SERVER[PHP_SELF]"); exit(); }
$adm_cron_path = trim(stripslashes($_POST[adm_cron_path]));
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$tmp=fopen("config/tmp.dat","w");
fputs($tmp, "$_POST[adm_row_page]|$_POST[adm_in_mail]|$_POST[adm_out_mail]|$_POST[adm_e_mail]|$_POST[adm_sort]|$_POST[adm_old_link]|$_POST[adm_cy]|$_POST[adm_pr]|$_POST[adm_out_links]|$_SESSION[adm_backup_time]|$_POST[adm_sort_select]|$_POST[adm_sort_2]|$_POST[adm_new_link]|$_POST[adm_need_link]\r\n");
fclose($tmp);
unlink("config/cnfadm.dat");
rename("config/tmp.dat", "config/cnfadm.dat");

$crn = fopen("config/tmp.dat","w");
fputs($crn, "$adm_cron_path\r\n");
fclose($crn);
unlink("config/cnfcron.dat");
rename("config/tmp.dat", "config/cnfcron.dat");

flock($lock, LOCK_UN);
fclose($lock);
} else {
$_SESSION['error_config'] = "Не могу заблокировать служебный файл data/base.lck !!!";
header("Location: error.php");
exit();
}
$_SESSION['ok_config'] = "Конфигурация настроек администратора успешно изменена!";
header("Location: $_SERVER[PHP_SELF]");
exit();
}
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
      <tr><td colspan=3 valign=top align=left>";
// Подключаем меню
include "menu.php";
echo "</td></tr><tr><td colspan=3 valign=top align=left></td></tr>";
// ---------------------------------------------------------------------------------------------------------------------------------
echo "<tr><td valign=top align=left>"; // первая ячейка в строке
// Форма для ввода новых логинов-паролей
echo "<form action=\""."$_SERVER[PHP_SELF]"."\" method=\"POST\"><table width=180 cellspacing=0 cellpadding=0>
      <tr><td align=right valign=top width=1px><img src=images/login_lu.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_ru.gif width=8 height=8 border=0></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td class=title bgcolor=#8f95ac align=left colspan=2>Поменять логин/пароль</td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2>Новый логин:<br><input name=\"lgn\" type=\"text\" size=\"24\" maxlength=\"255\" value=\""."$lgn"."\"></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2>Новый пароль:<br><input name=\"psw\" type=\"password\" size=\"24\" maxlength=\"255\"></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2>Еще раз пароль:<br><input name=\"psw2\" type=\"password\" size=\"24\" maxlength=\"255\"></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2><center><input name=\"change_login\" type=\"submit\" value=\"Изменить\"></center></td><td bgcolor=#8f95ac width=1px></td></tr>
	  <tr><td align=right valign=top width=1px><img src=images/login_ld.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_rd.gif width=8 height=8 border=0></td></tr>
      </table></form><br>";
// ---------------------------------------------------------------------------------------------------------------------------------
// Читаем из файла важные настройки и выводим форму с ними
$row_cnf_imp = explode("|", $cnf_imp_array[0]);
$imp_myhome = trim($row_cnf_imp[0]);
if(!$imp_myhome) {$imp_myhome = "http://"."$_SERVER[HTTP_HOST]";}
$imp_mode_url = trim($row_cnf_imp[1]);
$imp_links_page = trim($row_cnf_imp[2]);
echo "<form action="."$_SERVER[PHP_SELF]"." method=POST><table width=180 cellspacing=0 cellpadding=0>
      <tr><td align=right valign=top width=1px><img src=images/login_lu.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_ru.gif width=8 height=8 border=0></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td class=title bgcolor=#8f95ac align=left colspan=2>Важные настройки</td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2><br>Адрес моего сервера:<br><input name=imp_myhome type=text size=24 maxlength=255 value="."$imp_myhome"."></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2><br>Вид URL для отображения в юзерской части каталога: <font color=red>(см. help)</font><br><select name=imp_mode_url><option>"."$imp_mode_url"."</option><option value=Динамический>Динамический</option><option value=Статический>Статический</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2><br>Количество ссылок на одной странице каталога:<br><input name=imp_links_page type=text size=4 maxlength=2 value="."$imp_links_page".">  <font color=red>(см. help)</font></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2><br><center><input name=change_imp type=submit value=\"Изменить\"></center></td><td bgcolor=#8f95ac width=1px></td></tr>
	  <tr><td align=right valign=top width=1px><img src=images/login_ld.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_rd.gif width=8 height=8 border=0></td></tr>
      </table></form>";
echo "</td><td valign=top align=center>"; // вторая ячейка в строке
// ---------------------------------------------------------------------------------------------------------------------------------
// Читаем из файла визуальные настройки главной страницы и выводим форму с ними
$row_cnf_visual = explode("|", $cnf_visual_array[0]);
$vis_show_category = trim($row_cnf_visual[0]);
$vis_col_num = trim($row_cnf_visual[1]);
$vis_sort_cat = trim($row_cnf_visual[2]);
$vis_last_links = trim($row_cnf_visual[3]);
$vis_show_cat = trim($row_cnf_visual[4]);
$vis_show_date = trim($row_cnf_visual[5]);
$vis_show_pr = trim($row_cnf_visual[6]);
$vis_show_cy = trim($row_cnf_visual[7]);
$vis_none_or_cy = trim($row_cnf_visual[8]);
$vis_show_search = trim($row_cnf_visual[9]);
$vis_show_button = trim($row_cnf_visual[10]);
$vis_show_form = trim($row_cnf_visual[11]);
$vis_show_codes = trim($row_cnf_visual[12]);
$vis_show_rules = trim($row_cnf_visual[13]);
$vis_show_mailtoadmin = trim($row_cnf_visual[14]);
$vis_show_qntlinks = trim($row_cnf_visual[15]);
$vis_shuffle_codes = trim($row_cnf_visual[16]);
$vis_show_hh = trim($row_cnf_visual[17]);
$vis_codes_qnt = trim($row_cnf_visual[18]);
$vis_show_guard = trim($row_cnf_visual[19]);
$vis_all_links = trim($row_cnf_visual[20]);
$vis_user_lang = trim($row_cnf_visual[21]);
echo "<form action="."$_SERVER[PHP_SELF]"." method=POST><table width=100% cellspacing=0 cellpadding=0>
      <tr><td align=right valign=top width=1px><img src=images/login_lu.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_ru.gif width=8 height=8 border=0></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td class=title bgcolor=#8f95ac align=left colspan=2>Настройки отображения данных для главной страницы</td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>Показывать список категорий на главной странице?</td><td bgcolor=#8f95ac align=right><select name=vis_show_category><option>"."$vis_show_category"."</option><option value=Да>Да</option><option value=Нет>Нет</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>Показывать количество ссылок в категориях?</td><td bgcolor=#8f95ac align=right><select name=vis_show_qntlinks><option>"."$vis_show_qntlinks"."</option><option value=Да>Да</option><option value=Нет>Нет</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>Сколько колонок нужно для отображения категорий?</td><td bgcolor=#8f95ac align=right><select name=vis_col_num><option>"."$vis_col_num"."</option><option value=1>1</option><option value=2>2</option><option value=3>3</option><option value=4>4</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>Показывать общее количество ссылок в каталоге?</td><td bgcolor=#8f95ac align=right><select name=vis_all_links><option>"."$vis_all_links"."</option><option value=Да>Да</option><option value=Нет>Нет</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>Сортировать категории на главной странице по:</td><td bgcolor=#8f95ac align=right><select name=vis_sort_cat><option>"."$vis_sort_cat"."</option><option value=Алфавиту>Алфавиту</option><option value=Дате>Дате</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>Показывать на главной странице последние добавленные ссылки?</td><td bgcolor=#8f95ac align=right><select name=vis_last_links><option>"."$vis_last_links"."</option><option value=Нет>Нет</option><option value=1>1</option><option value=3>3</option><option value=5>5</option><option value=10>10</option><option value=20>20</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>Показывать категорию, к которой относится ссылка?</td><td bgcolor=#8f95ac align=right><select name=vis_show_cat><option>"."$vis_show_cat"."</option><option value=Да>Да</option><option value=Нет>Нет</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>Показывать дату добавления ссылок?</td><td bgcolor=#8f95ac align=right><select name=vis_show_date><option>"."$vis_show_date"."</option><option value=Да>Да</option><option value=Нет>Нет</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>Показывать Page Rank главных страниц доменов для этих ссылок?</td><td bgcolor=#8f95ac align=right><select name=vis_show_pr><option>"."$vis_show_pr"."</option><option value=Да>Да</option><option value=Нет>Нет</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>Показывать CY Яндекса доменов для этих ссылок?</td><td bgcolor=#8f95ac align=right><select name=vis_show_cy><option>"."$vis_show_cy"."</option><option value=Да>Да</option><option value=Нет>Нет</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>Показывать в каталоге кнопку 88х31?</td><td bgcolor=#8f95ac align=right><select name=vis_show_button><option>"."$vis_show_button"."</option><option value=Да>Да</option><option value=Нет>Нет</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>При отсутствии кнопки отображать</td><td bgcolor=#8f95ac align=right><select name=vis_none_or_cy><option>"."$vis_none_or_cy"."</option><option value=\"Кнопку-заглушку\">Кнопку-заглушку</option><option value=\"Кнопку CY Яндекса\">Кнопку CY Яндекса</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>Показывать на главной странице форму поиска по каталогу?</td><td bgcolor=#8f95ac align=right><select name=vis_show_search><option>"."$vis_show_search"."</option><option value=Да>Да</option><option value=Нет>Нет</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>Показывать места скрытых/удаленных ссылок?</td><td bgcolor=#8f95ac align=right><select name=vis_show_hh><option>"."$vis_show_hh"."</option><option value=Да>Да</option><option value=Нет>Нет</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>Язык интерфейса юзерской части</td><td bgcolor=#8f95ac align=right><select name=vis_user_lang><option>"."$vis_user_lang"."</option><option value=rus>rus</option><option value=eng>eng</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td class=title bgcolor=#8f95ac align=left colspan=2>Настройки формы добавления<td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>Форма добавления ссылок (см. help)</td><td bgcolor=#8f95ac align=right><select name=vis_show_form><option>"."$vis_show_form"."</option><option value=\"Форма-1\">Форма-1</option><option value=\"Форма-2\">Форма-2</option><option value=\"Выключить\">Выключить</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>Показывать свои HTML-коды?</td><td bgcolor=#8f95ac align=right><select name=vis_show_codes><option>"."$vis_show_codes"."</option><option value=\"Да\">Да</option><option value=\"Нет\">Нет</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>Включить случайный порядок вывода своих HTML-кодов?</td><td bgcolor=#8f95ac align=right><select name=vis_shuffle_codes><option>"."$vis_shuffle_codes"."</option><option value=\"Да\">Да</option><option value=\"Нет\">Нет</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>Сколько HTML-кодов показывать?</td><td bgcolor=#8f95ac align=right><select name=vis_codes_qnt><option>"."$vis_codes_qnt"."</option><option value=Все>Все</option><option value=1>1</option><option value=2>2</option><option value=3>3</option><option value=4>4</option><option value=5>5</option><option value=6>6</option><option value=7>7</option><option value=8>8</option><option value=9>9</option><option value=10>10</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>Показывать правила добавления?</td><td bgcolor=#8f95ac align=right><select name=vis_show_rules><option>"."$vis_show_rules"."</option><option value=\"Да\">Да</option><option value=\"Нет\">Нет</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>Показывать форму отправки письма администратору?</td><td bgcolor=#8f95ac align=right><select name=vis_show_mailtoadmin><option>"."$vis_show_mailtoadmin"."</option><option value=\"Да\">Да</option><option value=\"Нет\">Нет</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>Включить защиту от автодобавления?</td><td bgcolor=#8f95ac align=right><select name=vis_show_guard><option>"."$vis_show_guard"."</option><option value=\"Да\">Да</option><option value=\"Нет\">Нет</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=center colspan=2><br><input name=change_visual type=submit value=\"Изменить\"></td><td bgcolor=#8f95ac width=1px></td></tr>
	  <tr><td align=right valign=top width=1px><img src=images/login_ld.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_rd.gif width=8 height=8 border=0></td></tr>
      </table></form><br>";
// ---------------------------------------------------------------------------------------------------------------------------------
// Читаем из файла настройки проверки вводимой информации и выводим форму с ними
$row_cnf_checkinfo = explode("|", $cnf_checkinfo_array[0]);
$chkinfo_urlink = trim($row_cnf_checkinfo[0]);
$chkinfo_cy = trim($row_cnf_checkinfo[1]);
$chkinfo_pr = trim($row_cnf_checkinfo[2]);
$chkinfo_out_links = trim($row_cnf_checkinfo[3]);
$chkinfo_tag_noindex = trim($row_cnf_checkinfo[4]);
$chkinfo_meta_robots = trim($row_cnf_checkinfo[5]);
$chkinfo_file_robots = trim($row_cnf_checkinfo[6]);
$chkinfo_links_code = trim($row_cnf_checkinfo[7]);
$chkinfo_symbol_code = trim($row_cnf_checkinfo[8]);
$chkinfo_domen_domen = trim($row_cnf_checkinfo[9]);
$chkinfo_myhome_domen = trim($row_cnf_checkinfo[10]);
$chkinfo_free_hosting = trim($row_cnf_checkinfo[11]);
$chkinfo_moder = trim($row_cnf_checkinfo[12]);
$chkinfo_tags_p = trim($row_cnf_checkinfo[13]);
$chkinfo_tags_br = trim($row_cnf_checkinfo[14]);
$chkinfo_tags_i = trim($row_cnf_checkinfo[15]);
$chkinfo_tags_u = trim($row_cnf_checkinfo[16]);
$chkinfo_tags_b = trim($row_cnf_checkinfo[17]);
$chkinfo_tags_strong = trim($row_cnf_checkinfo[18]);
$chkinfo_tags_font = trim($row_cnf_checkinfo[19]);
$chkinfo_tags_flash = trim($row_cnf_checkinfo[20]);
$chkinfo_count_links = trim($row_cnf_checkinfo[21]);
echo "<form action="."$_SERVER[PHP_SELF]"." method=POST><table width=100% cellspacing=0 cellpadding=0>
      <tr><td align=right valign=top width=1px><img src=images/login_lu.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_ru.gif width=8 height=8 border=0></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td class=title bgcolor=#8f95ac align=left colspan=2>Настройки для проверки входящей информации</td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>Требовать обязательное наличие ответной ссылки <b>при добавлении</b>?</td><td bgcolor=#8f95ac align=right><select name=chkinfo_urlink><option>"."$chkinfo_urlink"."</option><option value=Да>Да</option><option value=Нет>Нет</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>Требовать обязательно CY Яндекс сайта партнера не менее (откл. при 0)</td><td bgcolor=#8f95ac align=right><input name=chkinfo_cy type=text size=4 maxlength=5 value="."$chkinfo_cy"."></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>Требовать обязательно PR Google страницы ссылок партнера не менее (откл. при 0)</td><td bgcolor=#8f95ac align=right><input name=chkinfo_pr type=text size=4 maxlength=2 value="."$chkinfo_pr"."></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>Требовать обязательно количество ссылок на странице обмена не более (откл. при 0)</td><td bgcolor=#8f95ac align=right><input name=chkinfo_out_links type=text size=4 maxlength=5 value="."$chkinfo_out_links"."></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>При подсчете учитывать ссылки на внутренние страницы?</td><td bgcolor=#8f95ac align=right><select name=chkinfo_count_links><option>"."$chkinfo_count_links"."</option><option value=Да>Да</option><option value=Нет>Нет</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>Проверять на наличие запрета индексации тэгами noindex?</td><td bgcolor=#8f95ac align=right><select name=chkinfo_tag_noindex><option>"."$chkinfo_tag_noindex"."</option><option value=Да>Да</option><option value=Нет>Нет</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>Проверять на наличие запрета индексации метатэгом robots?</td><td bgcolor=#8f95ac align=right><select name=chkinfo_meta_robots><option>"."$chkinfo_meta_robots"."</option><option value=Да>Да</option><option value=Нет>Нет</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>Проверять на наличие запрета индексации в файле robots.txt?</td><td bgcolor=#8f95ac align=right><select name=chkinfo_file_robots><option>"."$chkinfo_file_robots"."</option><option value=Да>Да</option><option value=Нет>Нет</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>Количество ссылок в многоссылочном текстовом коде не более</td><td bgcolor=#8f95ac align=right><input name=chkinfo_links_code type=text size=4 maxlength=3 value="."$chkinfo_links_code"."></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>Количество символов в текстовом коде (с учетом тэгов) не более</td><td bgcolor=#8f95ac align=right><input name=chkinfo_symbol_code type=text size=4 maxlength=5 value="."$chkinfo_symbol_code"."></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>Все ссылки в многоссылочном коде должны указывать на один и тот же домен?</td><td bgcolor=#8f95ac align=right><select name=chkinfo_domen_domen><option>"."$chkinfo_domen_domen"."</option><option value=Да>Да</option><option value=Нет>Нет</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>Ссылающийся на Вас домен и домен, где размещена Ваша ссылка должны быть идентичны?</td><td bgcolor=#8f95ac align=right><select name=chkinfo_myhome_domen><option>"."$chkinfo_myhome_domen"."</option><option value=Да>Да</option><option value=Нет>Нет</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>Разрешить добавление сайтов с бесплатных хостингов? (См. раздел Free hosting)</td><td bgcolor=#8f95ac align=right><select name=chkinfo_free_hosting><option>"."$chkinfo_free_hosting"."</option><option value=Да>Да</option><option value=Нет>Нет</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>Добавлять ссылки сразу или направлять на модерацию?</td><td bgcolor=#8f95ac align=right><select name=chkinfo_moder><option>"."$chkinfo_moder"."</option><option value=Добавление>Добавление</option><option value=Модерация>Модерация</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>Разрешить тэги &lt;P&gt; в текстовом коде?</td><td bgcolor=#8f95ac align=right><select name=chkinfo_tags_p><option>"."$chkinfo_tags_p"."</option><option value=Да>Да</option><option value=Нет>Нет</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>Разрешить тэги &lt;BR&gt; в текстовом коде?</td><td bgcolor=#8f95ac align=right><select name=chkinfo_tags_br><option>"."$chkinfo_tags_br"."</option><option value=Да>Да</option><option value=Нет>Нет</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>Разрешить тэги &lt;U&gt; в текстовом коде?</td><td bgcolor=#8f95ac align=right><select name=chkinfo_tags_u><option>"."$chkinfo_tags_u"."</option><option value=Да>Да</option><option value=Нет>Нет</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>Разрешить тэги &lt;I&gt; в текстовом коде?</td><td bgcolor=#8f95ac align=right><select name=chkinfo_tags_i><option>"."$chkinfo_tags_i"."</option><option value=Да>Да</option><option value=Нет>Нет</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>Разрешить тэги &lt;B&gt; в текстовом коде?</td><td bgcolor=#8f95ac align=right><select name=chkinfo_tags_b><option>"."$chkinfo_tags_b"."</option><option value=Да>Да</option><option value=Нет>Нет</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>Разрешить тэги &lt;STRONG&gt; в текстовом коде?</td><td bgcolor=#8f95ac align=right><select name=chkinfo_tags_strong><option>"."$chkinfo_tags_strong"."</option><option value=Да>Да</option><option value=Нет>Нет</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>Разрешить тэги &lt;FONT&gt; в текстовом коде?</td><td bgcolor=#8f95ac align=right><select name=chkinfo_tags_font><option>"."$chkinfo_tags_font"."</option><option value=Да>Да</option><option value=Нет>Нет</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>Разрешить добавление flash-баннеров?</td><td bgcolor=#8f95ac align=right><select name=chkinfo_tags_flash><option>"."$chkinfo_tags_flash"."</option><option value=Да>Да</option><option value=Нет>Нет</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=center colspan=2><br><input name=change_checkinfo type=submit value=\"Изменить\"></td><td bgcolor=#8f95ac width=1px></td></tr>
	  <tr><td align=right valign=top width=1px><img src=images/login_ld.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_rd.gif width=8 height=8 border=0></td></tr>
      </table></form><br>";
// ---------------------------------------------------------------------------------------------------------------------------------
// Читаем из файла настройки администратора каталога и выводим форму с ними
$row_cnf_adm = explode("|", $cnf_adm_array[0]);
$adm_row_page = trim($row_cnf_adm[0]);
$adm_in_mail = trim($row_cnf_adm[1]);
$adm_out_mail = trim($row_cnf_adm[2]);
$adm_e_mail = trim($row_cnf_adm[3]);
$adm_sort = trim($row_cnf_adm[4]);
$adm_old_link = trim($row_cnf_adm[5]);
$adm_cy = trim($row_cnf_adm[6]);
$adm_pr = trim($row_cnf_adm[7]);
$adm_out_links = trim($row_cnf_adm[8]);
$adm_backup_time = trim($row_cnf_adm[9]);
$adm_sort_select = trim($row_cnf_adm[10]);
$adm_sort_2 = trim($row_cnf_adm[11]);
$adm_new_link = trim($row_cnf_adm[12]);
$adm_need_link = trim($row_cnf_adm[13]);
$adm_cron_path = implode("",$cnf_cron_array);
$adm_cron_path = trim($adm_cron_path);
echo "<form action="."$_SERVER[PHP_SELF]"." method=POST><table width=100% cellspacing=0 cellpadding=0>
      <tr><td align=right valign=top width=1px><img src=images/login_lu.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_ru.gif width=8 height=8 border=0></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td class=title bgcolor=#8f95ac align=left colspan=2>Настройки администратора каталога</td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>Требовать обязательное наличие ответной ссылки <b>при проверке</b>? (*)</td><td bgcolor=#8f95ac align=right><select name=adm_need_link><option>"."$adm_need_link"."</option><option value=Да>Да</option><option value=Нет>Нет</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>Количество записей, выводимых на одну страницу</td><td bgcolor=#8f95ac align=right><input name=adm_row_page type=text size=4 maxlength=2 value="."$adm_row_page"."></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>Кодировка почтовых сообщений от скрипта администратору</td><td bgcolor=#8f95ac align=right><select name=adm_in_mail><option>"."$adm_in_mail"."</option><option value=win-1251>win-1251</option><option value=koi8-r>koi8-r</option><option value=iso-8859>iso-8859</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>Кодировка почтовых сообщений от скрипта пользователям</td><td bgcolor=#8f95ac align=right><select name=adm_out_mail><option>"."$adm_out_mail"."</option><option value=win-1251>win-1251</option><option value=koi8-r>koi8-r</option><option value=iso-8859>iso-8859</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>E-mail адрес администратора каталога</td><td bgcolor=#8f95ac align=right><input name=adm_e_mail type=text size=16 maxlength=255 value="."$adm_e_mail"."></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>Сортировка по дате добавления:</td><td bgcolor=#8f95ac align=right><select name=adm_sort><option>"."$adm_sort"."</option><option value=Возрастание>Возрастание</option><option value=Убывание>Убывание</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>Включить сортировку по дате проверки?<br>(откл. сортировка по дате добавления)</td><td bgcolor=#8f95ac align=right><select name=adm_sort_select><option>"."$adm_sort_select"."</option><option value=Да>Да</option><option value=Нет>Нет</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>Сортировка по дате проверки:</td><td bgcolor=#8f95ac align=right><select name=adm_sort_2><option>"."$adm_sort_2"."</option><option value=Возрастание>Возрастание</option><option value=Убывание>Убывание</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>Считать ссылку новой до истечения дней:</td><td bgcolor=#8f95ac align=right><input name=adm_new_link type=text size=4 maxlength=3 value="."$adm_new_link"."></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>Считать ссылку проверенной давно по истечение дней:</td><td bgcolor=#8f95ac align=right><input name=adm_old_link type=text size=4 maxlength=3 value="."$adm_old_link"."></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>Считать ссылку плохой при CY меньше, чем:</td><td bgcolor=#8f95ac align=right><input name=adm_cy type=text size=4 maxlength=5 value="."$adm_cy"."></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>Считать ссылку плохой при PR (страницы ссылок) меньше, чем:</td><td bgcolor=#8f95ac align=right><input name=adm_pr type=text size=4 maxlength=2 value="."$adm_pr"."></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>Считать ссылку плохой при количестве линков на странице больше, чем:</td><td bgcolor=#8f95ac align=right><input name=adm_out_links type=text size=4 maxlength=5 value="."$adm_out_links"."></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2><HR></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2>Настройка конфигурации для файла проверки по расписанию (см. help)<br><textarea style=\"width:375px; height:70px;\" name=adm_cron_path>"."$adm_cron_path"."</textarea></td><td bgcolor=#8f95ac width=1px></td></tr>
	  <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=center colspan=2><br><input name=change_adm type=submit value=\"Изменить\"></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2><HR></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>Последний раз резервное копирование выполнялось:</td><td bgcolor=#8f95ac align=right><input style=\"background-color: #afb5cc;\" name=adm_backup_time type=text size=19 value=\""."$adm_backup_time"."\"></td><td bgcolor=#8f95ac width=1px></td></tr>
	  <tr><td align=right valign=top width=1px><img src=images/login_ld.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_rd.gif width=8 height=8 border=0></td></tr>
      </table></form><br>";
// ---------------------------------------------------------------------------------------------------------------------------------
// Начало таблицы для хелпов
echo "</td><td valign=top align=right>"; // третья ячейка в строке

echo "<table width=360 cellspacing=0 cellpadding=0>
      <tr><td align=right valign=top width=1px><img src=images/login_lu.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_ru.gif width=8 height=8 border=0></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td class=title bgcolor=#8f95ac align=right colspan=2>Help</td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2>";
	  
echo "<div align=justify>
<font face=Verdana size=1 color=white><b>Поменять логин/пароль</b></font><br>
Изменить логин и/или пароль Вы можете в любое время. Сразу после первой установки скрипта ОБЯЗАТЕЛЬНО смените стандартные логин и пароль на свои!
</div>";
echo "<div align=justify>
<font face=Verdana size=1 color=red><br><b>< обратите книмание ></b></font><br>
Скрипт использует механизм сессий, поэтому после смены каких-либо параметров конфигурации, для того, чтобы увидеть изменения в юзерской части скрипта, Вам необходимо будет запустить новое окно своего браузера!<br><br>
</div>";
echo "<div align=justify>
<font face=Verdana size=1 color=white><b>Важные настройки скрипта</b></font><br>
<b>* Адрес Вашего сервера</b> необходимо ввести в том виде, в котором он содержится в Ваших HTML-кодах для обмена, т.е. если Вы указываете в своем коде адрес в виде http://mysite.ru, то и в этой настройке он должен присутствовать именно в таком же виде, а не http://www.mysite.ru<br>
<b>* Вид URL</b> для отображения в юзерской части каталога. Здесь Вы можете выбрать между динамическим и статическим видом URL'ов. Для того, чтобы использовать статический вид URL на Вашем сервере должен быть подключен модуль mode_rewrite. <font color=red>Внимание! Для того, чтобы корректно изменить этот режим, необходимо на основную папку скрипта временно поставить права доступа 777, после смены режима вновь установить права доступа 755.</font><br>Пример статического URL:<br>http://site.ru/link_159_7.html<br>Пример динамического URL:<br>http://site.ru/link/index.php?category=159&page=7<br>
<b>* Количество ссылок</b>, выводимых на одной странице каталога. <font face=Verdana size=1 color=red><b>Эту настройку лучше сделать только один раз, при первой установке скрипта!</b></font> Скрипт сохранит постоянный адрес для каждой ссылки только в том случае, если этот параметр не будет изменен впоследствии.
<br><br>
</div>";
echo "<div align=justify>
<font face=Verdana size=1 color=white><b>Настройки отображения данных для главной страницы</b></font><br>
Это визуальные настройки. Вы можете в любое время изменить вид и набор всех данных, которые отображаются на всех юзерских страницах.
</div>";
echo "<div align=justify>
<font face=Verdana size=1 color=red><br><b>< обратите книмание ></b></font><br>
Для того, чтобы настраивать размеры элементов, цвет шрифтов и др. - воспользуйтесь разделом \"Дизайн\"<br><br>
</div>";
echo "<div align=justify>
<font face=Verdana size=1 color=white><b>Настройки отображения в форме добавления</b></font><br>
Форма добавления ссылок. Здесь Вы можете выбирать из трех вариантов. Две формы содержат следующие одинаковые поля ввода: имя, адрес ответной ссылки, адрес электронной почты, выбор категории. Форма-1 содержит поля ввода HTML-кода и текстовой ссылки и картинки, а Форма-2 даст возможность ввести только текстовое описание ссылки и указать путь к графическому баннеру.
Форма-2 будет удобнее для тех, кто меняется только однолинковыми ссылками. При выборе опции \"Выключить\" - формы вообще отображаться не будут. Не забудьте в этом случае включить форму для отправки письма администратору, и написать соответствующие Правила добавления ссылок в каталог.<br>
Остальные опции этого раздела включают/отключают блоки отображения своих HTML-кодов для обмена, правил добавления в каталог и формы для отправки письма администратору каталога. Возможность отправки e-mail из формы сделана для тех пользователей, которые испытывают затруднения с заполнением формы обмена или хотят предложить другие варианты обмена. Вы можете использовать также опцию вывода своих HTML-кодов в случайном порядке.<br><br>
</div>";
echo "<div align=justify>
<font face=Verdana size=1 color=white><b>Настройки для проверки входящей информации</b></font><br>
Отнеситесь к этим настройкам особенно внимательно. Пользуясь этими настройками, Вы можете сделать проверку входящей информации как максимально жесткой, так и вообще отказаться от какой-либо проверки.
 В этом же разделе Вы сможете выбрать способ добавления ссылок в свой каталог: добавлять ссылки сначала на модерацию или непосредственно в базу каталога.<br>
</div>";
echo "<div align=justify>
<font face=Verdana size=1 color=red><br><b>< обратите книмание ></b></font><br>
Если Вы выбрали ответ \"Нет\" в настройке: \"Ссылающийся на Вас домен и домен, где размещена Ваша ссылка должны быть идентичны?\", то учитывайте то обстоятельство, что CY (PR) будут определяться для того домена (страницы), где установлена ответная ссылка!<br><br>
</div>";
echo "<div align=justify>
<font face=Verdana size=1 color=white><b>Настройки администратора каталога</b></font><br>
Настройки администратора каталога, относящиеся к оценке качества ссылок, <font color=red><b>не зависимы</b></font> от настроек проверки входящей информации. Администратор может пользоваться этими настройками по своему усмотрению. 
</div>";
echo "<div align=justify>
<font face=Verdana size=1 color=red><br><b>(*)</b></font> 
Скрипт не будет проверять наличие ответной ссылки и запретов индексации при выборе ответа \"Нет\" на первый вопрос, но 
получит значения CY, PR и количества ссылок на проверяемой странице. Скрипт оценит полученные данные на основании настроек, 
сделанных Вами и поместит ссылку в соответствующий раздел.<br>
</div>";
echo "<div align=justify>
<font face=Verdana size=1 color=red><br><b>< обратите книмание ></b></font><br>
Особенно важной  настройкой является настройка конфигурации для файла проверки Ваших данных по расписанию.<br><br>
</div>";
echo "<div align=justify>
<font face=Verdana size=1 color=white><b>Настройки проверки по расписанию</b></font><br>
Если Вы имеете возможность использовать на своем сервере запуск скриптов по расписанию (Cron), то Вам необходимо очень внимательно произвести настройку конфигурации для файла, который и будет запускаться по установленному Вами расписанию.<br>
<font color=red>* См. Help чтобы подробнее узнать о технических требованиях, необходимых для корректной работы с помощью cron.</font><br><br>
Переменная <b>\$adm_cron_path</b> содержит полный путь к папке admin скрипта. Узнать путь достаточно просто. Если Вы пользуетесь каким-либо FTP-клиентом, то путь Вы можете просто скопировать из его адресной строки, перейдя перед этим конечно в папку admin. Если Вы пользуетесь какой-либо панелью управления своим сайтом, то можно поступить аналогично. Т.е. войти в папку admin и Вы увидите полный путь к этой папке (как правило внизу страницы).<br>
<font color=red>Будьте внимательны: на разных серверах может потребоваться указать путь с или без начального слеша, а вот слеш после папки admin должен присутствовать!</font><br>
Переменная <b>\$imp_myhome</b> - адрес Вашего сервера. Такой же как и в разделе важных настроек скрипта.<br>
Переменная <b>\$adm_e_mail</b> - адрес электронной почты администратора каталога, на который скрипт будет отсылать результаты проверок.<br>
Переменная <b>\$adm_in_mail</b> - кодировка для писем, отправляемых скрипом администратору. Выбор между win-1251 и koi8-r.<br>
Переменная <b>\$adm_count_links</b> - установите \"Нет\", если не хотите подсчитывать ссылки на внутренние страницы проверяемого сайта.<br><br>
Следующие три переменные задают для файла проверки по расписанию критерии оценки качества ссылок:<br>
Переменная <b>\$adm_out_links</b> - количество ссылок на проверяемой странице при превышении числа которых скрипт должен отправить сообщение администратору (если включено).<br>
Переменная <b>\$adm_cy</b> - величина тИЦ Яндекса при которой скрипт должен будет расценить проверяемый сайт как плохой и отправить сообщение администратору (если включено).<br>
Переменная <b>\$adm_pr</b> - величина PR Google при которой скрипт  должен будет расценить проверяемый сайт как плохой и отправить сообщение администратору (если включено).<br>
Переменная <b>\$letter_noanswer</b> - в случае установки в 'on' скрипт будет посылать сообщение администратору, если не удалось получить ответ от проверяемого сайта. Для выключения - off.<br>
Переменная <b>\$letter_badly</b> - в случае установки в 'on' скрипт будет посылать сообщение администратору, если получен отрицательный результат при проверке хотя бы одного параметра. Для выключения - off.<br>
Переменная <b>\$letter_well</b> - также устанавливается в on/off. Рекомендуется включать только при отладке процесса проверки по расписанию. Посылает письмо администратору, если проверяемая страница соответствуем всем требованиям администратора каталога.<br><br>
Для запуска CRON воспользуйтесь следующей командой:<br>
<font color=red>/usr/local/bin/php -q /полный/путь/admin/croncheck.php</font><br>или<br>
<font color=red>/usr/bin/php -q /полный/путь/admin/croncheck.php</font><br>
где /usr/local/bin/php (/usr/bin/php) - путь к PHP-интерпретатору Вашего сервера. Узнавайте этот путь в технической поддержке Вашего хостера.<br>А полный путь можно узнать, <a href=info.php target=_blank><b><font color=white>посмотрев здесь</font></b></a> содержимое переменных окружения, например SCRIPT_FILENAME или PATH_TRANSLATED, только вместо info.php, естественно должен быть croncheck.php
</div>";
echo "</td><td bgcolor=#8f95ac width=1px></td></tr>
	  <tr><td align=right valign=top width=1px><img src=images/login_ld.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_rd.gif width=8 height=8 border=0></td></tr>
      </table>";
	  
echo "</td></tr></table>";
@ignore_user_abort($old_abort);
?>
</body>
</html>