<?php
@$old_abort = ignore_user_abort(true);
session_start();
if($_GET['action']=="temp_hide" AND $_GET['id'] AND $_SESSION['owner_status']=="this_admin") {
// »щем, что именно скрыть
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$base=file("data/base.dat");
$categories_array=file("data/categories.dat"); // категории дл€ рассчета адреса ссылки
flock($lock, LOCK_UN);
fclose($lock);
} else {
$_SESSION['error'] = "Ќе могу заблокировать служебный файл data/base.lck !!!";
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=error.php'>
	  </HEAD></HTML>";
exit();
}

for($i=0;$i<count($base);$i++) {
$search_row = explode("|", $base[$i]);
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


// ‘ормируем строку URL куда вернутьс€
$backward="http://"."$_SERVER[HTTP_HOST]"."$_GET[back]"."?"."page="."$_GET[page]"."#"."$_GET[id]";

// Ќачали писать данные в базу
$category_record = 0;
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$tmp=fopen("data/tmp.dat","w");
$base=file("data/base.dat");
for($i=0;$i<count($base);$i++) {
$record=explode("|", $base[$i]);
if($record[0] != $_GET[id]) {
fwrite($tmp, $base[$i]);
if($record[4]==$category) { $category_record = $category_record + 1; }
} else {
fputs($tmp, "$id|$nick|$urlink|$mail|$category|$htmltext|$htmlimage|$check_date|$check_result|$check_out_links|$check_cy|$check_pr|$check_pr_main|$check_tag_noindex|$check_meta_robots|$check_file_robots|hide|$ip_user|$admin_comment\r\n");
$row_in_category = $category_record+1;
}
}
fclose($tmp);
unlink("data/base.dat");
rename("data/tmp.dat", "data/base.dat");
flock($lock, LOCK_UN);
fclose($lock);
} else {
$_SESSION['error'] = "Ќе могу заблокировать служебный файл data/base.lck !!!";
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=error.php'>
	  </HEAD></HTML>";
exit();
}
// «акончили запись данных в базу
// -------------------------------------------------------------------------------
// рассчитаем положение ссылки в каталоге
// найдем ID категории
$num = count($categories_array);
for($i=0;$i<$num;$i++) {
$categories_array_row = explode("|", $categories_array[$i]);
if($categories_array_row[1]==$category) {
$category_id = $categories_array_row[0];
break;
}
}
// на какой странице в категории
$page = ceil($row_in_category/$_SESSION['imp_links_page']);
// ќпредел€ем путь (где это вообще находитс€)
$pos=strpos("$_SERVER[REQUEST_URI]", "admin/temphide.php");
$string=substr("$_SERVER[REQUEST_URI]", 0, $pos);
// формируем полный адрес ссылки
if($_SESSION['imp_mode_url']=="—татический") {
$link_place = "http://"."$_SERVER[HTTP_HOST]"."$string"."links_"."$category_id"."_"."$page".".html";
} else {
$link_place = "http://"."$_SERVER[HTTP_HOST]"."$string"."index.php?category="."$category_id"."&page="."$page";
}
// -------------------------------------------------------------------------------
// ≈сли нужно, отправим письмо, что ссылка временно скрыта
// -----------------------------------------------------------------------------

// читаем нужное письмо
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$subject_3 = file("letters/s3.txt");
$message_3 = file("letters/m3.txt");
$letter_swith_3 = file("letters/w3.txt");
flock($lock, LOCK_UN);
fclose($lock);
} else {
$_SESSION['error'] = "Ќе могу заблокировать служебный файл data/base.lck !!!";
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=error.php'>
	  </HEAD></HTML>";
exit();
}
$subject_3 = implode("",$subject_3);
$message_3 = implode("",$message_3);
$letter_swith_3 = implode("",$letter_swith_3);

if(trim($letter_swith_3)=="on") {
$message_3 = str_replace(NICK_NAME, $nick, "$message_3");
$message_3 = str_replace(LINK_PLACE, $link_place, "$message_3");
$message_3 = str_replace(BACK_LINK, $urlink, "$message_3");
$message_3 = str_replace(OUT_LINKS, $check_out_links, "$message_3");
$message_3 = str_replace(SITE_CY, $check_cy, "$message_3");
$message_3 = str_replace(PAGE_PR, $check_pr, "$message_3");
$message_3 = str_replace(IMP_MYHOME, $_SESSION[imp_myhome], "$message_3");
$message_3 = str_replace(ADM_E_MAIL, $_SESSION[adm_e_mail], "$message_3");
$message_3 = str_replace(ADM_COMMENT, $admin_comment, "$message_3");

switch($_SESSION['adm_out_mail']) {
case "koi8-r":
$subject_3 = convert_cyr_string($subject_3, "w", "k");
$message_3 = convert_cyr_string($message_3, "w", "k");
$charset = "koi8-r";
break;
case "iso-8859":
$subject_3 = convert_cyr_string($subject_3, "w", "i");
$message_3 = convert_cyr_string($message_3, "w", "i");
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
mail($mail, "$subject_3", "$message_3", "$headmail");
}

// -----------------------------------------------------------------------------
// закончили отправку письма

echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=$backward'>
	  </HEAD></HTML>";
exit();
} // end if
@ignore_user_abort($old_abort);
?>