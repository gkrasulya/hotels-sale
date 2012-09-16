<?php
@$old_abort = ignore_user_abort(true);
session_start();
if($_GET['action']=="move_black" AND $_GET['id'] AND $_SESSION['owner_status']=="this_admin") {

// Формируем строку URL куда вернуться
$backward="http://"."$_SERVER[HTTP_HOST]"."$_GET[back]"."?"."page="."$_GET[page]"."#"."$_GET[id]";
$back = "$_GET[back]";
$flag = 0; // установим флаг в 0

// Определяем откуда именно переложить в корзину
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
if(substr_count($back, "links_black.php")) { $base=file("data/black.dat"); $flag = 2; }
elseif(substr_count($back, "links_trash.php")) { $base=file("data/trash.dat"); $flag = 3; }
elseif(substr_count($back, "links_moder.php")) { $base=file("data/moder.dat"); $flag = 4; }
else { $base=file("data/base.dat"); $flag = 1; }
$categories=file("data/categories.dat"); // категории для рассчета адреса ссылки
flock($lock, LOCK_UN);
fclose($lock);
} else {
$_SESSION['error'] = "Не могу заблокировать служебный файл data/base.lck !!!";
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=error.php'>
	  </HEAD></HTML>";
exit();
}

if($sub_flag==1) { $base = array($base); }
if($sub_flag==2) { $base = array($black); }
if($sub_flag==3) { $base = array($trash); }
if($sub_flag==4) { $base = array($moder); }

// Начали писать данные в базу
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$tmp=fopen("data/tmp.dat","w");
if($flag==1) { $base=file("data/base.dat"); } // выбираем один из файлов
if($flag==2) { $base=file("data/black.dat"); }
if($flag==3) { $base=file("data/trash.dat"); }
if($flag==4) { $base=file("data/moder.dat"); }

for($i=0;$i<=count($base);$i++) {
$rec=explode("|", $base[$i]);
if($rec[0] != $_GET[id]) {
fwrite($tmp, $base[$i]); // если ID не тот - оставляем как есть
if($record[4]==$category) { $category_record = $category_record + 1; }
} else {
$mail = $rec[3]; // берем e-mail для отправки  письма
$urlink = $rec[2];
$nick = $rec[1];
$check_out_links = $rec[9];
$check_cy = $rec[10];
$check_pr = $rec[11];
$admin_comment = $rec[18];
$black=fopen("data/black.dat","a");
fwrite($black, "$base[$i]"); // иначе пишем данные в блэк-лист
fclose($black);
if($flag==1) { fputs($tmp, "$rec[0]|-|-|-|$rec[4]|-|-|-|-|-|-|-|-|-|-|-|hole|-|-\r\n"); } // если из основной базу то сделаем дыру
if($flag==2||$flag==3||$flag==4) { unset($base[$i]); } // если из других файлов - просто сбросим
$row_in_category = $category_record+1;
}
}
fclose($tmp);
if($flag==1) { unlink("data/base.dat"); rename("data/tmp.dat", "data/base.dat"); }
if($flag==2) { unlink("data/black.dat"); rename("data/tmp.dat", "data/black.dat"); }
if($flag==3) { unlink("data/trash.dat"); rename("data/tmp.dat", "data/trash.dat"); }
if($flag==4) { unlink("data/moder.dat"); rename("data/tmp.dat", "data/moder.dat"); }
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
$pos=strpos("$_SERVER[REQUEST_URI]", "admin/movetrash.php");
$string=substr("$_SERVER[REQUEST_URI]", 0, $pos);
// формируем полный адрес ссылки
if($_SESSION['imp_mode_url']=="Статический") {
$link_place = "http://"."$_SERVER[HTTP_HOST]"."$string"."links_"."$category_id"."_"."$page".".html";
} else {
$link_place = "http://"."$_SERVER[HTTP_HOST]"."$string"."index.php?category="."$category_id"."&page="."$page";
}
// -----------------------------------------------------------------------------

// Если нужно, отправим письмо, что ссылка помещена в блэк-лист
// -----------------------------------------------------------------------------

// читаем нужное письмо
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$subject_10 = file("letters/s10.txt");
$message_10 = file("letters/m10.txt");
$letter_swith_10 = file("letters/w10.txt");
flock($lock, LOCK_UN);
fclose($lock);
} else {
$_SESSION['error'] = "Не могу заблокировать служебный файл data/base.lck !!!";
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=error.php'>
	  </HEAD></HTML>";
exit();
}
$subject_10 = implode("",$subject_10);
$message_10 = implode("",$message_10);
$letter_swith_10 = implode("",$letter_swith_10);

if(trim($letter_swith_10)=="on") {
$message_10 = str_replace(NICK_NAME, $nick, "$message_10");
$message_10 = str_replace(LINK_PLACE, $link_place, "$message_10");
$message_10 = str_replace(BACK_LINK, $urlink, "$message_10");
$message_10 = str_replace(OUT_LINKS, $check_out_links, "$message_10");
$message_10 = str_replace(SITE_CY, $check_cy, "$message_10");
$message_10 = str_replace(PAGE_PR, $check_pr, "$message_10");
$message_10 = str_replace(IMP_MYHOME, $_SESSION[imp_myhome], "$message_10");
$message_10 = str_replace(ADM_E_MAIL, $_SESSION[adm_e_mail], "$message_10");
$message_10 = str_replace(ADM_COMMENT, $admin_comment, "$message_10");

switch($_SESSION['adm_out_mail']) {
case "koi8-r":
$subject_10 = convert_cyr_string($subject_10, "w", "k");
$message_10 = convert_cyr_string($message_10, "w", "k");
$charset = "koi8-r";
break;
case "iso-8859":
$subject_10 = convert_cyr_string($subject_10, "w", "i");
$message_10 = convert_cyr_string($message_10, "w", "i");
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
mail($mail, "$subject_10", "$message_10", "$headmail");
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