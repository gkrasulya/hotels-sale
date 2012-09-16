<?php
error_reporting(0);
@$old_abort = ignore_user_abort(true);

session_start();
include "adminic.php";
// подключаем функции
include "functions/cut.php";
include "functions/check.php";
include "functions/main.php";

// Обрисуем, где находимся
$place = "ДОБАВИТЬ ССЫЛКУ";
$flag_add_ok = "0"; // флаг успешного добавления сбрасываем

// читаем файлы модерации, корзины, блэк-листа, базы и freehosting в массивы
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$moder_array = file("data/moder.dat");
$base_array = file("data/base.dat");
$trash_array = file("data/trash.dat");
$black_array = file("data/black.dat");
$freehosting_array = file("data/hosting.dat");
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

// *****************************************************************************
// если окончательно все хорошо и мы добавляем ссылку
// *****************************************************************************
if($_POST['add_link_end'] AND $_SESSION['owner_status']=="this_admin" AND $_SESSION['end_post_admin'] != "sent_already") {

$_SESSION['end_post_admin'] = "sent_already"; // защитим от дублей-триблей
// -------------------------------------------------------------------------------
$id = time();
$nick = $_POST['nick'];
$urlink = $_POST['urlink'];
$mail = $_POST['mail'];
$category = $_POST['category'];
$htmltext = Cut_All_Exc($_POST['htmltext']);
$view_image = Cut_All_Exc($_POST['view_image']);
$check_date = "$id";
$check_result = $_POST['check_result'];
$check_out_links = $_POST['check_out_links'];
$check_cy = $_POST['check_cy'];
$check_pr = $_POST['check_pr'];
$check_pr_main = $_POST['check_pr_main'];
$check_tag_noindex = $_POST['check_tag_noindex'];
$check_meta_robots = $_POST['check_meta_robots'];
$check_file_robots = $_POST['check_file_robots'];
$status = "activ";
$ip_user = "0.0.0.0";
$admin_comment = Cut_All_All($_POST['admin_comment']);
// -------------------------------------------------------------------------------

// -------------------------------------------------------------------------------
// Начали писать данные в базу
$flag_record = 0;
$category_record = 0;
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$base_array=file("data/base.dat");
$tmp=fopen("data/tmp.dat","w");
$num = count($base_array);
for($i=0;$i<$num;$i++) {
$record=explode("|", $base_array[$i]);
// -------------------------------------------------------------------------------
if($record[4]==$category) {
$category_record = $category_record + 1;

if($record[16]=="hole" AND $flag_record==0) {
fputs($tmp, "$id|$nick|$urlink|$mail|$category|$htmltext|$view_image|$check_date|$check_result|$check_out_links|$check_cy|$check_pr|$check_pr_main|$check_tag_noindex|$check_meta_robots|$check_file_robots|$status|$ip_user|$admin_comment\r\n");
$flag_record = 1;
$row_in_category = "$category_record";
} else {
fwrite($tmp, "$base_array[$i]");
}

} else {
fwrite($tmp, "$base_array[$i]");
}
// -------------------------------------------------------------------------------
} // end for
fclose($tmp);
// если дырок не было
if($flag_record != 1) {
$tmp=fopen("data/tmp.dat","a");
fputs($tmp, "$id|$nick|$urlink|$mail|$category|$htmltext|$view_image|$check_date|$check_result|$check_out_links|$check_cy|$check_pr|$check_pr_main|$check_tag_noindex|$check_meta_robots|$check_file_robots|$status|$ip_user|$admin_comment\r\n");
$row_in_category = $category_record+1;
fclose($tmp);
}
// если дырок не было
unlink("data/base.dat");
rename("data/tmp.dat", "data/base.dat");
flock($lock, LOCK_UN);
fclose($lock);
} else {
$_SESSION['error'] = "Не могу заблокировать служебный файл data/base.lck !!!";
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=error.php'>
	  </HEAD></HTML>";
exit();
}
// Закончили запись данных в базу
// -------------------------------------------------------------------------------
// рассчитаем положение ссылки в каталоге
// найдем ID категории
$num = count($categories_array);
for($i=0;$i<$num;$i++) {
$categories_array_row = explode("|", $categories_array[$i]);
if($categories_array_row[1]==$category) {
$category_id = "$categories_array_row[0]";
break;
}
}
// на какой странице в категории
$page = ceil($row_in_category/$_SESSION['imp_links_page']);
// Определяем путь (где это вообще находится)
$pos=strpos("$_SERVER[REQUEST_URI]", "admin/add_link.php");
$string=substr("$_SERVER[REQUEST_URI]", 0, $pos);
// формируем полный адрес ссылки
if($_SESSION['imp_mode_url']=="Статический") {
$link_place = "http://"."$_SERVER[HTTP_HOST]"."$string"."links_"."$category_id"."_"."$page".".html";
} else {
$link_place = "http://"."$_SERVER[HTTP_HOST]"."$string"."index.php?category=$category_id"."&page=$page";
}
// -------------------------------------------------------------------------------
// читаем нужное письмо
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$subject = file("letters/s1.txt");
$message = file("letters/m1.txt");
$letter_swith = file("letters/w1.txt"); 
flock($lock, LOCK_UN);
fclose($lock);
} else {
$_SESSION['error'] = "Не могу заблокировать служебный файл data/base.lck !!!";
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=error.php'>
	  </HEAD></HTML>";
exit();
}

// отправляем письмо, если надо
$subject = implode("",$subject);
$message = implode("",$message);
$letter_swith = implode("",$letter_swith);

if(trim($letter_swith)=="on") {
$message = str_replace(NICK_NAME, $nick, "$message");
$message = str_replace(LINK_PLACE, $link_place, "$message");
$message = str_replace(BACK_LINK, $urlink, "$message");
$message = str_replace(OUT_LINKS, $check_out_links, "$message");
$message = str_replace(SITE_CY, $check_cy, "$message");
$message = str_replace(PAGE_PR, $check_pr, "$message");
$message = str_replace(IMP_MYHOME, $_SESSION[imp_myhome], "$message");
$message = str_replace(ADM_E_MAIL, $_SESSION[adm_e_mail], "$message");
$message = str_replace(ADM_COMMENT, $admin_comment, "$message");

switch($_SESSION['adm_out_mail']) {
case "koi8-r":
$subject = convert_cyr_string($subject, "w", "k");
$message = convert_cyr_string($message, "w", "k");
$charset = "koi8-r";
break;
case "iso-8859":
$subject = convert_cyr_string($subject, "w", "i");
$message = convert_cyr_string($message, "w", "i");
$charset = "iso-8859-1";
break;
default:
$charset = "windows-1251";
break;
}

$headmail = "From:"."$_SESSION[adm_e_mail]"."\n";
$headmail .= "MIME-Version: 1.0\n";
$headmail .= "Content-Type: text/plain; charset="."$charset"."\n";
$headmail .= "Content-Transfer-Encoding: 8bit\n\n";
mail($mail, "$subject", "$message", "$headmail");
}
// отправляем письмо, если надо
// -------------------------------------------------------------------------------

// сбрасываем все переменные
unset($id);
unset($nick);
unset($urlink);
unset($mail);
unset($category);
unset($htmltext);
unset($view_image);
unset($check_date);
unset($check_result);
unset($check_out_links);
unset($check_cy);
unset($check_pr);
unset($check_pr_main);
unset($check_tag_noindex);
unset($check_meta_robots);
unset($check_file_robots);
unset($status);
unset($ip_user);
unset($admin_comment);
$flag_add_ok = "ok"; 
} // конец главного if если окончательно все хорошо и мы добавляем ссылку
// *****************************************************************************
// если окончательно все хорошо и мы добавляем ссылку
// *****************************************************************************
// -----------------------------------------------------------------------------
// Если добавляем ссылку
if($_POST['add_link'] AND $_SESSION['owner_status']=="this_admin") {
// *****************************************************************************
unset($_SESSION['end_post_admin']); // сбросим из сессии предыдущий пост

// проверим - исправим ответную ссылку
if(!empty($_POST['urlink'])) {
$urlink = Cut_All_Exc($_POST['urlink']); // режем вообще все
// проверим правильность введенного URL
$urlink = Check_In_Url($urlink);

if($urlink == "badly") {
$add_err['check_in_url'] = "Некорректно заполнено поле ответной ссылки!";
} else {
unset($add_err['check_in_url']);
// и получим имя хоста
$host = @parse_url($urlink);
$host = "http://"."$host[host]";
}

} else {
$add_err['empty_urlink'] = "Не заполнено поле ответной ссылки! Если Вы не знаете точного URL, введите адрес сервера.";
}
// проверим - исправим ответную ссылку
// *****************************************************************************
// *****************************************************************************
// обработаем поле NickName
$nick = Cut_All_All($_POST['nick']); // режем вообще все
if(empty($nick)) { $nick = "script"; }
// *****************************************************************************
// *****************************************************************************
// проверим - исправим e-mail партнера
if(!empty($_POST['mail'])) {
$mail = Cut_All_Exc($_POST['mail']); // режем вообще все
// проверим правильность введенного e-mail
$mail = Check_User_Mail($mail);
if($mail == "badly") { $add_err['check_user_mail'] = "Некорректно заполнено поле электронной почты!"; } else { unset($add_err['check_user_mail']); }

} else {
$mail = $_SESSION['adm_e_mail'];
}
// проверим - исправим e-mail партнера
// *****************************************************************************
// *****************************************************************************
// проверим выбор категории
if(empty($_POST['category'])) {
$add_err['empty_category'] = "Не выбрана категория!";
} else { unset($add_err['empty_category']); }
// проверим выбор категории
// *****************************************************************************
// *****************************************************************************
// проверим - исправим графическую ссылку
if(!empty($_POST['view_image'])) {

$view_image = Cut_All_Exc($_POST['view_image']); // режем все лишнее, кроме нужного

// проверим если флеш или картинка без ссылки
$add_err['check_img_flash'] = Check_Img_Flash($view_image,$host);
if($add_err['check_img_flash']=="OK") { unset($add_err['check_img_flash']); }

// открывающие и закрывающие А должны быть равны
$add_err['check_a_eqv_img'] = Check_A_Eqv($view_image);
if($add_err['check_a_eqv_img']=="OK") { unset($add_err['check_a_eqv_img']); }

// если есть тэг А - он должен ссылаться туда же, где стоит ответная ссылка
if($_SESSION['chkinfo_myhome_domen']=="Да" AND $urlink!="badly") {
$add_err['check_img_a'] = Check_Img_A($view_image,$host);
if($add_err['check_img_a']=="OK") { unset($add_err['check_img_a']); }
}

// проверить ширину и высоту графической ссылки, здесь если надо
if($_POST['check_size']=="on") {
$add_err['check_img_size'] = Check_Img_Size($view_image);
if($add_err['check_img_size']=="OK") { unset($add_err['check_img_size']); }
}

// если есть IMG - не должно быть текста по краям и между тэгами a и img - вырезаем лишнее
$view_image = Cut_Img_Notext($view_image);
// если есть IMG - придется в любом случае убирать все тэги, которые могут быть разрешены
$temp = strtolower($view_image);
$count_img = substr_count($temp, "<img");

if($count_img > 0) {
$view_image = Cut_Tags_B($view_image);
$view_image = Cut_Tags_Br($view_image);
$view_image = Cut_Tags_Font($view_image);
$view_image = Cut_Tags_I($view_image);
$view_image = Cut_Tags_P($view_image);
$view_image = Cut_Tags_Strong($view_image);
$view_image = Cut_Tags_U($view_image);
$view_image = Cut_Tags_Flash($view_image);
} else {
unset($view_image);
}

}
// проверим - исправим графическую ссылку
// *****************************************************************************
// *****************************************************************************
// проверим - исправим текстовую ссылку
if(!empty($_POST['htmltext'])) {
$htmltext = Cut_All_Exc($_POST['htmltext']); // режем все лишнее, кроме нужного
$htmltext = Cut_Tags_Img($htmltext);
$htmltext = Cut_Tags_Flash($htmltext);
if($_SESSION['chkinfo_tags_b']=="Нет") { $htmltext = Cut_Tags_B($htmltext); }
if($_SESSION['chkinfo_tags_br']=="Нет") { $htmltext = Cut_Tags_Br($htmltext); }
if($_SESSION['chkinfo_tags_font']=="Нет") { $htmltext = Cut_Tags_Font($htmltext); }
if($_SESSION['chkinfo_tags_i']=="Нет") { $htmltext = Cut_Tags_I($htmltext); }
if($_SESSION['chkinfo_tags_p']=="Нет") { $htmltext = Cut_Tags_P($htmltext); }
if($_SESSION['chkinfo_tags_strong']=="Нет") { $htmltext = Cut_Tags_Strong($htmltext); }
if($_SESSION['chkinfo_tags_u']=="Нет") { $htmltext = Cut_Tags_U($htmltext); }

// открывающие и закрывающие А должны быть равны
$add_err['check_a_eqv_text'] = Check_A_Eqv($htmltext);
if($add_err['check_a_eqv_text']=="OK") { unset($add_err['check_a_eqv_text']); }
// проверим количество символов в коде
$add_err['check_symbol_code'] = Check_Symbol_Code($htmltext,$_SESSION['chkinfo_symbol_code']);
if($add_err['check_symbol_code']=="OK") { unset($add_err['check_symbol_code']); }
// проверим количество ссылок в коде
$add_err['check_links_code'] = Check_Links_Code($htmltext,$_SESSION['chkinfo_links_code']);
if($add_err['check_links_code']=="OK") { unset($add_err['check_links_code']); }

// проверим те ли домены в коде, только если Все ссылки в многоссылочном коде должны указывать на один и тот же домен
// и разрешено добавление многоссылочных кодов
if($_SESSION['chkinfo_domen_domen']=="Да" AND $_SESSION['chkinfo_links_code']>1) {
$add_err['check_domen_domen'] = Check_Domen_Domen($htmltext,$_SESSION['chkinfo_links_code']);
if($add_err['check_domen_domen']=="OK") { unset($add_err['check_domen_domen']); }
}
// проверим тот ли домен в коде, только если все ссылки в коде должны соответствовать Вашему домену
if($_SESSION['chkinfo_myhome_domen']=="Да" AND $urlink!="badly") {
$add_err['check_myhome_domen'] = Check_Myhome_Domen($htmltext,$host);
if($add_err['check_myhome_domen']=="OK") { unset($add_err['check_myhome_domen']); }
}

} else {
$add_err['empty_htmltext'] = "Не заполнено поле текстовой ссылки!";
}
// проверим - исправим текстовую ссылку
// ****************************************************************************
// ****************************************************************************
// проверим нет ли такого домена в базе, на модерации, в корзине или блэк-листе
$urlink_short_host = Short_Domen_Name($urlink); // имя хоста
$flag_exists_link = "0"; // сбросим флаг существования ссылки

// ищем, нет ли уже такого домена на модерации
if($flag_exists_link==0 AND empty($add_err['empty_urlink'])) {
for($i=0;$i<count($moder_array);$i++) {
$moder_array_row = explode("|", $moder_array[$i]);
if(substr_count("$moder_array_row[2]", "http://www.") != 0) {$short_host = "http://www."."$urlink_short_host";} else {$short_host = "http://"."$urlink_short_host";}
if(preg_match ("'$short_host'si", $moder_array_row[2])) {
$add_err['domen_in_moder'] = "Ссылка с домена <b>"."$urlink_short_host"."</b> находится на модерации.";
$flag_exists_link = 1;
break;
} else {
unset($add_err['domen_in_moder']);
}
}
}
// ищем, нет ли уже такого домена в корзине
if($flag_exists_link==0 AND empty($add_err['empty_urlink'])) {
for($i=0;$i<count($trash_array);$i++) {
$trash_array_row = explode("|", $trash_array[$i]);
if(substr_count("$trash_array_row[2]", "http://www.") != 0) {$short_host = "http://www."."$urlink_short_host";} else {$short_host = "http://"."$urlink_short_host";}
if(preg_match ("'$short_host'si", $trash_array_row[2])) {
$add_err['domen_in_trash'] = "Ссылка с домена <b>"."$urlink_short_host"."</b> находится в корзине.";
$flag_exists_link = 1;
break;
} else {
unset($add_err['domen_in_trash']);
}
}
}
// ищем, нет ли уже такого домена в блэк-листе
if($flag_exists_link==0 AND empty($add_err['empty_urlink'])) {
for($i=0;$i<count($black_array);$i++) {
$black_array_row = explode("|", $black_array[$i]);
if(substr_count("$black_array_row[2]", "http://www.") != 0) {$short_host = "http://www."."$urlink_short_host";} else {$short_host = "http://"."$urlink_short_host";}
if(preg_match ("'$short_host'si", $black_array_row[2])) {
$add_err['domen_in_black'] = "Ссылка с домена <b>"."$urlink_short_host"."</b> находится в блэк-листе.";
$flag_exists_link = 1;
break;
} else {
unset($add_err['domen_in_black']);
}
}
}
// ищем, нет ли уже такого домена в базе
if($flag_exists_link==0 AND empty($add_err['empty_urlink'])) {
$base = count($base_array);
for($i=0;$i<$base;$i++) {
$base_array_row = explode("|", $base_array[$i]);
if(substr_count("$base_array_row[2]", "http://www.") != 0) {$short_host = "http://www."."$urlink_short_host";} else {$short_host = "http://"."$urlink_short_host";}
if(preg_match ("'$short_host'si", $base_array_row[2])) {
$add_err['domen_in_base'] = "Ссылка с домена <b>"."$urlink_short_host"."</b> уже есть в базе!";
$flag_exists_link = 1;
break;
} else {
unset($add_err['domen_in_base']);
}
}
}
// проверим нет ли такого домена в базе, на модерации, в корзине или блэк-листе
// ****************************************************************************
// ****************************************************************************
// проверим на free-hosting если надо
if($_SESSION['chkinfo_free_hosting']=="Нет") {

// переменная urlink_short_host у нас получена раньше
// запускаем собственно проверку
for($i=0;$i<count($freehosting_array);$i++) {
$freehosting_array_row = explode("|", $freehosting_array[$i]);
$search_row = trim($freehosting_array_row[1]);
$row = "."."$search_row";
if(substr_count("$urlink_short_host", "$row") != 0) {
$add_err['domen_in_freehosting'] = "Домен <b>"."$urlink_short_host"."</b> находится на бесплатном/запрещенном хостинге.";
break;
} else {
unset($add_err['domen_in_freehosting']);
}
}

}
// проверим на free-hosting если надо
// ****************************************************************************
// ****************************************************************************
// если ошибок заполнения формы нет, проверяем остальные параметры
if(count($add_err)==0) {
$old_cy = 0; // зададим ноль, поскольку это только добавление
// Запускаем полную проверку
$get_row_urlink = Get_Row_Urlink($urlink);
$check_pr_main = Get_PR_Google($host);
$check_result = Check_My_Link($get_row_urlink, $_SESSION['imp_myhome']);
$check_cy = Get_CY_Yandex($urlink, $old_cy);
$check_robots_array = Check_File_Robots($urlink);
$check_file_robots = $check_robots_array[0];
$check_meta_robots = Check_Meta_Tag($urlink);
$check_tag_noindex = Check_Tag_Noindex($get_row_urlink, $_SESSION['imp_myhome']);

if($_SESSION['chkinfo_count_links']=="Да") {
$check_out_links = Get_Out_Links($get_row_urlink);
} else {
$check_out_links = Get_Out_Links2($get_row_urlink, $urlink);
}

$check_pr = Get_PR_Google($urlink);
}
// если ошибок заполнения формы нет, проверяем остальные параметры
// *****************************************************************************

} // конец если добавляли ссылку
// -----------------------------------------------------------------------------
// Выводим ошибки или ОК, если они присутствуют
if($_SESSION['error_config']) { echo "<span id=warningMess>Ошибка! $_SESSION[error_config]</span>"; unset($_SESSION['error_config']); }
if($_SESSION['ok_config']) { echo "<span id=okMess>ОК! $_SESSION[ok_config]</span>";  unset($_SESSION['ok_config']); }
// -----------------------------------------------------------------------------
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

if($flag_add_ok=="ok") { // если добавлено - покажем адрес ссылки
echo "<table width=100% cellspacing=0 cellpadding=0>
	  <tr><td align=right valign=top width=1px><img src=images/login_lu.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_ru.gif width=8 height=8 border=0></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td class=title bgcolor=#8f95ac align=center colspan=2>Ссылка успешно добавлена в каталог! Ее постоянный адрес:<br><br></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td class=title bgcolor=#8f95ac align=center colspan=2><input type=text style=\"width: 420px;\" value=\""."$link_place"."\" onClick=select()>&nbsp;&nbsp;&nbsp;<a href=\""."$link_place"."\" target=\"_blank\"> >> </a><br><br></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=center colspan=2><a href=add_link.php>Добавить еще</a><br></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td align=right valign=top width=1px><img src=images/login_ld.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_rd.gif width=8 height=8 border=0></td></tr>
      </table><br>";
} else { // если нет - показываем саму форму

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

// Форма для ввода новых ссылок
echo "<form action=\""."$_SERVER[PHP_SELF]"."\" method=\"POST\"><table width=100% cellspacing=0 cellpadding=0>
      <tr><td align=right valign=top width=1px><img src=images/login_lu.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_ru.gif width=8 height=8 border=0></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td class=title bgcolor=#8f95ac align=left colspan=2>Форма для ввода новых ссылок<br><br></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left nowrap width=1% valign=top>Текстовая ссылка*:</td><td bgcolor=#8f95ac align=right valign=top><textarea name=\"htmltext\" rows=\"3\" cols=\"36\" style=\"width: 420px;\">"."$htmltext"."</textarea></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left nowrap width=1% valign=top>Графическая ссылка:</td><td bgcolor=#8f95ac align=right valign=top><textarea name=\"view_image\" rows=\"3\" cols=\"36\" style=\"width: 420px;\">"."$view_image"."</textarea></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left nowrap width=1%>Категория*:</td><td bgcolor=#8f95ac align=right valign=top>";
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
// Читаем категории
$cat_sort = count($categories_array);
echo "<select name=category style=\"width: 420px;\"><option>"."$_POST[category]"."</option>";
for($i=0; $i<$cat_sort; $i++) {
$row = explode("|", $categories_array[$i]);
echo "<option>"."$row[1]"."</option>";
}
echo "</select>";	
echo "</td><td bgcolor=#8f95ac width=1px></td></tr>
	  <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left nowrap width=1%>E-mail партнера:</td><td bgcolor=#8f95ac align=right valign=top><input type=text name=\"mail\" style=\"width: 420px;\" value=\""."$mail"."\"></td><td bgcolor=#8f95ac width=1px></td></tr>
	  <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left nowrap width=1%>NickName партнера:</td><td bgcolor=#8f95ac align=right valign=top><input type=text name=\"nick\" style=\"width: 420px;\" value=\""."$nick"."\"></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left nowrap width=1%>Ответная ссылка*:</td><td bgcolor=#8f95ac align=right valign=top><input type=text name=\"urlink\" style=\"width: 420px;\" value=\""."$urlink"."\"></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=right valign=top colspan=2>Проверять размеры графической ссылки? <input type=checkbox name=\"check_size\" checked></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=center colspan=2 valign=top><input name=\"add_link\" type=\"submit\" value=\"Проверить / Исправить\"></td><td bgcolor=#8f95ac width=1px></td></tr>
	  <tr><td align=right valign=top width=1px><img src=images/login_ld.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_rd.gif width=8 height=8 border=0></td></tr>
      </table></form><br>";
// ---------------------------------------------------------------------------------------------------------------------------------
} // end если добавлено (показывали адрес ссылки)

if(count($add_err)!=0) {
// ЕСЛИ ЕСТЬ ОШИБКИ
echo "<table width=100% cellspacing=0 cellpadding=0>
      <tr><td align=right valign=top width=1px><img src=images/login_lu.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_ru.gif width=8 height=8 border=0></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td class=title bgcolor=#8f95ac align=left colspan=2>Ошибки заполнения формы:<br><br></td><td bgcolor=#8f95ac width=1px></td></tr>";
if($add_err['domen_in_base']) { echo "<tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2><font color=red>"."$add_err[domen_in_base]"."</font></td><td bgcolor=#8f95ac width=1px></td></tr>"; }
if($add_err['domen_in_black']) { echo "<tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2><font color=red>"."$add_err[domen_in_black]"."</font></td><td bgcolor=#8f95ac width=1px></td></tr>"; }
if($add_err['domen_in_trash']) { echo "<tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2><font color=red>"."$add_err[domen_in_trash]"."</font></td><td bgcolor=#8f95ac width=1px></td></tr>"; }
if($add_err['domen_in_moder']) { echo "<tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2><font color=red>"."$add_err[domen_in_moder]"."</font></td><td bgcolor=#8f95ac width=1px></td></tr>"; }
if($add_err['domen_in_freehosting']) { echo "<tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2><font color=red>"."$add_err[domen_in_freehosting]"."</font></td><td bgcolor=#8f95ac width=1px></td></tr>"; }
if($add_err['check_in_url']) { echo "<tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2><font color=red>"."$add_err[check_in_url]"."</font></td><td bgcolor=#8f95ac width=1px></td></tr>"; }
if($add_err['empty_urlink']) { echo "<tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2><font color=red>"."$add_err[empty_urlink]"."</font></td><td bgcolor=#8f95ac width=1px></td></tr>"; }
if($add_err['check_user_mail']) { echo "<tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2><font color=red>"."$add_err[check_user_mail]"."</font></td><td bgcolor=#8f95ac width=1px></td></tr>"; }
if($add_err['empty_category']) { echo "<tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2><font color=red>"."$add_err[empty_category]"."</font></td><td bgcolor=#8f95ac width=1px></td></tr>"; }
if($add_err['check_img_flash']) { echo "<tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2><font color=red>"."$add_err[check_img_flash]"."</font></td><td bgcolor=#8f95ac width=1px></td></tr>"; }
if($add_err['check_img_a']) { echo "<tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2><font color=red>"."$add_err[check_img_a]"."</font></td><td bgcolor=#8f95ac width=1px></td></tr>"; }
if($add_err['check_img_size']) { echo "<tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2><font color=red>"."$add_err[check_img_size]"."</font></td><td bgcolor=#8f95ac width=1px></td></tr>"; }
if($add_err['check_a_eqv_img']) { echo "<tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2><font color=red>"."$add_err[check_a_eqv_img]"."</font></td><td bgcolor=#8f95ac width=1px></td></tr>"; }
if($add_err['empty_htmltext']) { echo "<tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2><font color=red>"."$add_err[empty_htmltext]"."</font></td><td bgcolor=#8f95ac width=1px></td></tr>"; }
if($add_err['check_a_eqv_text']) { echo "<tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2><font color=red>"."$add_err[check_a_eqv_text]"."</font></td><td bgcolor=#8f95ac width=1px></td></tr>"; }
if($add_err['check_symbol_code']) { echo "<tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2><font color=red>"."$add_err[check_symbol_code]"."</font></td><td bgcolor=#8f95ac width=1px></td></tr>"; }
if($add_err['check_links_code']) { echo "<tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2><font color=red>"."$add_err[check_links_code]"."</font></td><td bgcolor=#8f95ac width=1px></td></tr>"; }
if($add_err['check_domen_domen']) { echo "<tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2><font color=red>"."$add_err[check_domen_domen]"."</font></td><td bgcolor=#8f95ac width=1px></td></tr>"; }
if($add_err['check_myhome_domen']) { echo "<tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2><font color=red>"."$add_err[check_myhome_domen]"."</font></td><td bgcolor=#8f95ac width=1px></td></tr>"; }
echo "<tr><td align=right valign=top width=1px><img src=images/login_ld.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_rd.gif width=8 height=8 border=0></td></tr>
      </table>";
// ЕСЛИ ЕСТЬ ОШИБКИ
}
if(count($add_err)==0 AND $_POST['add_link']) {
// ЕСЛИ ОШИБОК НЕТ
echo "<form action=\""."$_SERVER[PHP_SELF]"."\" method=\"POST\">
      <input type=hidden name=check_result value='$check_result'>
      <input type=hidden name=check_out_links value='$check_out_links'>
      <input type=hidden name=check_cy value='$check_cy'>
      <input type=hidden name=check_pr value='$check_pr'>
      <input type=hidden name=check_pr_main value='$check_pr_main'>
      <input type=hidden name=check_tag_noindex value='$check_tag_noindex'>
      <input type=hidden name=check_meta_robots value='$check_meta_robots'>
      <input type=hidden name=check_file_robots value='$check_file_robots'>
      <input type=hidden name=urlink value='$urlink'>
      <input type=hidden name=mail value='$mail'>
      <input type=hidden name=nick value='$nick'>
      <input type=hidden name=category value='$_POST[category]'>
      <input type=hidden name=htmltext value='$htmltext'>
      <input type=hidden name=view_image value='$view_image'>";
	  
	  $robtxt = @parse_url($urlink); $robtxt = "http://"."$robtxt[host]"."/robots.txt";
?>
      <table width=100% cellspacing=0 cellpadding=0>
      <tr><td align=right valign=top width=1px><img src=images/login_lu.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_ru.gif width=8 height=8 border=0></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td class=title bgcolor=#8f95ac align=left colspan=2>Предварительный просмотр результатов проверки:</td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td class=title bgcolor=#8f95ac align=left colspan=2><hr></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left><?php echo $htmltext ?></td><td bgcolor=#8f95ac align=right width=120px><?php echo $view_image ?></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=right colspan=2><b><i>Категория: <?php echo $_POST[category] ?></i></b></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2><hr></td><td bgcolor=#8f95ac width=1px></td></tr>
	  
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=center colspan=2>
	  <table width=100% cellspacing=1 cellpadding=1>
	  <tr><td bgcolor=#8f95ac width=49% align=left><a href=$urlink target=_blank>Результат проверки:</a></td><td bgcolor=#8f95ac width=1% nowrap align=right><b><?php if($check_result=="badly") { echo "<font color=red>"."$check_result"."</font>"; } else { echo "$check_result"; } ?></b>&nbsp;&nbsp;</td><td bgcolor=#8f95ac width=49% align=left>&nbsp;&nbsp;Количество ссылок на странице:</td><td bgcolor=#8f95ac width=1% nowrap align=right><b><?php if($check_out_links>$_SESSION['adm_out_links']) { echo "<font color=red>"."$check_out_links"."</font>"; } else { echo "$check_out_links"; } ?></b></td></tr>
	  <tr><td bgcolor=#8f95ac width=49% align=left><a href=<?php echo "$robtxt"; ?> target=_blank>Проверка файла robots.txt:</a></td><td bgcolor=#8f95ac width=1% nowrap align=right><b><?php if($check_file_robots=="badly") { echo "<font color=red>"."$check_file_robots"."</font>"; } else { echo "$check_file_robots"; } ?></b>&nbsp;&nbsp;</td><td bgcolor=#8f95ac width=49% align=left>&nbsp;&nbsp;CY Яндекса:</td><td bgcolor=#8f95ac width=1% nowrap align=right><b><?php if($check_cy<$_SESSION['adm_cy']) { echo "<font color=red>"."$check_cy"."</font>"; } else { echo "$check_cy"; } ?></b></td></tr>
	  <tr><td bgcolor=#8f95ac width=49% align=left>Проверка метатэгов ROBOTS:</td><td bgcolor=#8f95ac width=1% nowrap align=right><b><?php if($check_meta_robots=="badly") { echo "<font color=red>"."$check_meta_robots"."</font>"; } else { echo "$check_meta_robots"; } ?></b>&nbsp;&nbsp;</td><td bgcolor=#8f95ac width=49% align=left>&nbsp;&nbsp;PR главной страницы:</td><td bgcolor=#8f95ac width=1% nowrap align=right><b><?php echo "$check_pr_main"; ?></b></td></tr>
	  <tr><td bgcolor=#8f95ac width=49% align=left>Проверка тэгов noindex:</td><td bgcolor=#8f95ac width=1% nowrap align=right><b><?php if($check_tag_noindex=="badly") { echo "<font color=red>"."$check_tag_noindex"."</font>"; } else { echo "$check_tag_noindex"; } ?></b>&nbsp;&nbsp;</td><td bgcolor=#8f95ac width=49% align=left>&nbsp;&nbsp;PR страницы ссылок:</td><td bgcolor=#8f95ac width=1% nowrap align=right><b><?php if($check_pr<$_SESSION['adm_pr']) { echo "<font color=red>"."$check_pr"."</font>"; } else { echo "$check_pr"; } ?></b></td></tr>
	  </table>
<?php
	  echo "</td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=center colspan=2><HR></td><td bgcolor=#8f95ac width=1px></td></tr>
	  <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=right colspan=2>Добавить комментарий администратора:<br><textarea name=admin_comment rows=\"3\" cols=\"36\" style=\"width: 540px;\"></textarea></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=center colspan=2 valign=top><input name=\"add_link_end\" type=\"submit\" value=\"Добавить ссылку\"></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td align=right valign=top width=1px><img src=images/login_ld.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_rd.gif width=8 height=8 border=0></td></tr>
      </table></form>";

// ЕСЛИ ОШИБОК НЕТ
}
// ---------------------------------------------------------------------------------------------------------------------------------
// Начало таблицы для хелпов
echo "</td><td valign=top align=right>"; // вторая ячейка в строке

echo "<table width=360 cellspacing=0 cellpadding=0>
      <tr><td align=right valign=top width=1px><img src=images/login_lu.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_ru.gif width=8 height=8 border=0></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td class=title bgcolor=#8f95ac align=right colspan=2>Help</td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2>";
	  
echo "<div align=justify>
<font face=Verdana size=1 color=white><b>Добавление ссылок</b></font><br>В форме ввода новых ссылок три обязательных поля: текстовая ссылка, категория и ответная ссылка.<br><br>
Если по каким-то причинам Вы пока не знаете точного адреса ответной ссылки, просто введите в это поле адрес сервера Вашего партнера по обмену.<br><br>
Если также неизвестен адрес электронной почты - оставьте его пустым, скрипт подставит туда Ваш собственный адрес по которому Вы сможете определить, 
что ссылка была добавлена Вами. Впоследствии Вы сможете отредактировать e-mail для этой ссылки.<br><br>
Если Вы оставите пустым поле никнейма скрипт проставит в базе слово \"script\". Никнейм также можно будет отредактировать впоследствии.<br><br>
Скрипт проверит вводимые Вами данные так же серьезно, как и данные вводимые пользователями каталога при добавлении ссылок. 
Все, что можно скрипт постарается исправить сам. Об остальных \"претензиях\" он выдаст соответствующие сообщения. 
При получении сообщений об ошибках заполнения формы, прежде всего проверьте настройки конфигурации, ведь при проверке скрипт руководствуется именно ими.<br><br>
Если форма заполнена корректно, скрипт проверит данные и выдаст администратору результаты для принятия решения. Также будет доступно поле для комментария администратора.<br><br>
Скрипт позволит добавить данные в каталог даже несмотря на то, что один или более проверенных параметров не будут удовлетворять установленным Вами требованиям.
</div>";

echo "</td><td bgcolor=#8f95ac width=1px></td></tr>
	  <tr><td align=right valign=top width=1px><img src=images/login_ld.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_rd.gif width=8 height=8 border=0></td></tr>
      </table>";

echo "</td></tr></table>";
@ignore_user_abort($old_abort);
?>
</body>
</html>