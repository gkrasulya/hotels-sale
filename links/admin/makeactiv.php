<?php
@$old_abort = ignore_user_abort(true);
session_start();
if($_GET['action']=="make_activ" AND $_GET['id'] AND $_SESSION['owner_status']=="this_admin") {
// Ищем, что именно активизировать
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$base=file("data/base.dat");
$moder=file("data/moder.dat");
$categories=file("data/categories.dat");
flock($lock, LOCK_UN);
fclose($lock);
} else {
$_SESSION['error'] = "Не могу заблокировать служебный файл data/base.lck !!!";
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=error.php'>
	  </HEAD></HTML>";
exit();
}

// Формируем строку URL куда вернуться
$backward="http://"."$_SERVER[HTTP_HOST]"."$_GET[back]"."?"."page="."$_GET[page]"."#"."$_GET[id]";
$back = "$_GET[back]";

// Из базы или с модерации?
if(substr_count("$back", "links_moder.php") != 0) {
$num = count($moder);
$arr = $moder;
} else {
$num = count($base);
$arr = $base;
}

for($i=0;$i<$num;$i++) {
$search_row = explode("|", $arr[$i]);
if ($search_row[0]==$_GET['id']) {
$id=trim($_GET[id]);
$nick=trim($search_row[1]);
$urlink=trim($search_row[2]);
$mail=trim($search_row[3]);
$category=trim($search_row[4]);
$htmltext=trim($search_row[5]);
$htmlimage=trim($search_row[6]);
$check_date=trim($search_row[7]);
$check_result=trim($search_row[8]);
$check_out_links=trim($search_row[9]);
$check_cy=trim($search_row[10]);
$check_pr=trim($search_row[11]);
$check_pr_main=trim($search_row[12]);
$check_tag_noindex=trim($search_row[13]);
$check_meta_robots=trim($search_row[14]);
$check_file_robots=trim($search_row[15]);
$link_status=trim($search_row[16]);
$ip_user=trim($search_row[17]);
$admin_comment=trim($search_row[18]);
break;
}
}




// Начали писать данные в базу
$category_record = 0;
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {

if(substr_count("$back", "links_moder.php") != 0) { // если данные с модерации
// -----------------------------------------------------------------------------
// записываем в базу
$base=file("data/base.dat");
$tmp=fopen("data/tmp.dat","w");
$num = count($base);
for($i=0;$i<$num;$i++) {
$record=explode("|", $base[$i]);
// если были дырки в базе
if($record[4]==$category) {
$category_record = $category_record + 1;

if($record[16]=="hole" AND $flag_record==0) {
fputs($tmp, "$id|$nick|$urlink|$mail|$category|$htmltext|$htmlimage|$check_date|$check_result|$check_out_links|$check_cy|$check_pr|$check_pr_main|$check_tag_noindex|$check_meta_robots|$check_file_robots|activ|$ip_user|$admin_comment\r\n");
$flag_record = 1;
$row_in_category = $category_record;
} else {
fwrite($tmp, "$base[$i]");
}

} else {
fwrite($tmp, "$base[$i]");
}
// если были дырки в базе
} // end for
fclose($tmp);
// если дырок не было
if($flag_record != 1) {
$tmp=fopen("data/tmp.dat","a");
fputs($tmp, "$id|$nick|$urlink|$mail|$category|$htmltext|$htmlimage|$check_date|$check_result|$check_out_links|$check_cy|$check_pr|$check_pr_main|$check_tag_noindex|$check_meta_robots|$check_file_robots|activ|$ip_user|$admin_comment\r\n");
$row_in_category = $category_record + 1;
fclose($tmp);
}
// если дырок не было
unlink("data/base.dat");
rename("data/tmp.dat", "data/base.dat");
// -----------------------------------------------------------------------------
// удаляем с модерации
$moder = file("data/moder.dat"); // получаем в массив
$fp=fopen("data/temp.dat","w");
for ($i=0;$i<count($moder);$i++) {
$moder_row = explode("|", $moder[$i]);
if ($moder_row[0] == $id) unset($moder[$i]);
}
fputs($fp,implode("",$moder));
fclose($fp);
unlink("data/moder.dat");
rename("data/temp.dat", "data/moder.dat");
// -----------------------------------------------------------------------------
} else { // если данные из базы
// -----------------------------------------------------------------------------
$tmp=fopen("data/tmp.dat","w");
$base=file("data/base.dat");
for($i=0;$i<count($base);$i++) {
$record=explode("|", $base[$i]);
if($record[0] != $id) {
fwrite($tmp, $base[$i]);
if($record[4]==$category) { $category_record = $category_record + 1; }
} else {
fputs($tmp, "$id|$nick|$urlink|$mail|$category|$htmltext|$htmlimage|$check_date|$check_result|$check_out_links|$check_cy|$check_pr|$check_pr_main|$check_tag_noindex|$check_meta_robots|$check_file_robots|activ|$ip_user|$admin_comment\r\n");
$row_in_category = $category_record+1;
}
}
fclose($tmp);
unlink("data/base.dat");
rename("data/tmp.dat", "data/base.dat");
// -----------------------------------------------------------------------------
} // end if-else с модерации - из базы


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

// рассчитаем положение ссылки (адрес в каталоге) для отправки в письме.
// найдем ID категории
$num = count($categories);
for($i=0;$i<$num;$i++) {
$categories_row = explode("|", $categories[$i]);
if($categories_row[1]==$category) {
$category_id = $categories_row[0];
break;
}
}
// на какой странице в категории
$page = ceil($row_in_category/$_SESSION['imp_links_page']);
// Определяем путь (где это вообще находится)
$pos=strpos("$_SERVER[REQUEST_URI]", "admin/makeactiv.php");
$string=substr("$_SERVER[REQUEST_URI]", 0, $pos);
// формируем полный адрес ссылки
if($_SESSION['imp_mode_url']=="Статический") {
$link_place = "http://"."$_SERVER[HTTP_HOST]"."$string"."links_"."$category_id"."_"."$page".".html";
} else {
$link_place = "http://"."$_SERVER[HTTP_HOST]"."$string"."index.php?category="."$category_id"."&page="."$page";
}
// -----------------------------------------------------------------------------


if(substr_count("$back", "links_moder.php") != 0) { // если данные с модерации
// -----------------------------------------------------------------------------
// отправим письмо, что ссылка активизирована из модерации

// читаем нужное письмо
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$subject_8 = file("letters/s8.txt");
$message_8 = file("letters/m8.txt");
$letter_swith_8 = file("letters/w8.txt");
flock($lock, LOCK_UN);
fclose($lock);
} else {
$_SESSION['error'] = "Не могу заблокировать служебный файл data/base.lck !!!";
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=error.php'>
	  </HEAD></HTML>";
exit();
}
$subject_8 = implode("",$subject_8);
$message_8 = implode("",$message_8);
$letter_swith_8 = implode("",$letter_swith_8);

if(trim($letter_swith_8)=="on") {
$message_8 = str_replace(NICK_NAME, $nick, "$message_8");
$message_8 = str_replace(LINK_PLACE, $link_place, "$message_8");
$message_8 = str_replace(BACK_LINK, $urlink, "$message_8");
$message_8 = str_replace(OUT_LINKS, $check_out_links, "$message_8");
$message_8 = str_replace(SITE_CY, $check_cy, "$message_8");
$message_8 = str_replace(PAGE_PR, $check_pr, "$message_8");
$message_8 = str_replace(IMP_MYHOME, $_SESSION[imp_myhome], "$message_8");
$message_8 = str_replace(ADM_E_MAIL, $_SESSION[adm_e_mail], "$message_8");
$message_8 = str_replace(ADM_COMMENT, $admin_comment, "$message_8");

switch($_SESSION['adm_out_mail']) {
case "koi8-r":
$subject_8 = convert_cyr_string($subject_8, "w", "k");
$message_8 = convert_cyr_string($message_8, "w", "k");
$charset = "koi8-r";
break;
case "iso-8859":
$subject_8 = convert_cyr_string($subject_8, "w", "i");
$message_8 = convert_cyr_string($message_8, "w", "i");
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
mail($mail, "$subject_8", "$message_8", "$headmail");
}

} else {
// -----------------------------------------------------------------------------
// отправим письмо, что ссылка активизирована из скрытых в базе
if($link_status!="noanswer") { // если она не из неотвечающих
// читаем нужное письмо
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$subject_9 = file("letters/s9.txt");
$message_9 = file("letters/m9.txt");
$letter_swith_9 = file("letters/w9.txt");
flock($lock, LOCK_UN);
fclose($lock);
} else {
$_SESSION['error'] = "Не могу заблокировать служебный файл data/base.lck !!!";
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=error.php'>
	  </HEAD></HTML>";
exit();
}
$subject_9 = implode("",$subject_9);
$message_9 = implode("",$message_9);
$letter_swith_9 = implode("",$letter_swith_9);

if(trim($letter_swith_9)=="on") {
$message_9 = str_replace(NICK_NAME, $nick, "$message_9");
$message_9 = str_replace(LINK_PLACE, $link_place, "$message_9");
$message_9 = str_replace(BACK_LINK, $urlink, "$message_9");
$message_9 = str_replace(OUT_LINKS, $check_out_links, "$message_9");
$message_9 = str_replace(SITE_CY, $check_cy, "$message_9");
$message_9 = str_replace(PAGE_PR, $check_pr, "$message_9");
$message_9 = str_replace(IMP_MYHOME, $_SESSION[imp_myhome], "$message_9");
$message_9 = str_replace(ADM_E_MAIL, $_SESSION[adm_e_mail], "$message_9");
$message_9 = str_replace(ADM_COMMENT, $admin_comment, "$message_9");

switch($_SESSION['adm_out_mail']) {
case "koi8-r":
$subject_9 = convert_cyr_string($subject_9, "w", "k");
$message_9 = convert_cyr_string($message_9, "w", "k");
$charset = "koi8-r";
break;
case "iso-8859":
$subject_9 = convert_cyr_string($subject_9, "w", "i");
$message_9 = convert_cyr_string($message_9, "w", "i");
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
mail($mail, "$subject_9", "$message_9", "$headmail");
}
} // конец если она из неотвечающих

} // закончили отправку писем

echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=$backward'>
	  </HEAD></HTML>";
exit();
} // end if
@ignore_user_abort($old_abort);
?>