<?php
@$old_abort = ignore_user_abort(true);
error_reporting(0);

session_start();

function Script_Time_Out() {
$stus = connection_status();
if($stus!=0) {
include "config/cnfcron.dat";
mail("$adm_e_mail", "SCRIPT REPORT: ERROR NUMBER $stus", "ERROR NUMBER 1 - CONNECTION ABORTED\r\nERROR NUMBER 2 - CONNECTION TIMEOUT\r\n", "From:$adm_e_mail\n");
}
}
register_shutdown_function(Script_Time_Out); 

if($_GET['action']=="full_check" AND $_GET['id'] AND $_SESSION['owner_status']=="this_admin") {

// Подключаем файлы функций
include "functions/check.php";
include "functions/cut.php";
include "functions/main.php";

$start_time = gettime();

// Формируем строку URL куда вернуться
$backward="http://"."$_SERVER[HTTP_HOST]"."$_GET[back]"."?"."page="."$_GET[page]"."#"."$_GET[id]";
$back = "$_GET[back]";
$flag = 0;

// Ищем, что именно проверять
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$base=file("data/base.dat");
// ----------------------------
if(substr_count($back, "links_black.php")) { $base=file("data/black.dat"); }
if(substr_count($back, "links_trash.php")) { $base=file("data/trash.dat"); }
if(substr_count($back, "links_moder.php")) { $base=file("data/moder.dat"); }
// ----------------------------
flock($lock, LOCK_UN);
fclose($lock);
} else {
$_SESSION['error'] = "Не могу заблокировать служебный файл data/base.lck !!!";
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=error.php'>
	  </HEAD></HTML>";
exit();
}

for($i=0;$i<count($base);$i++) {
$search_row = explode("|", $base[$i]);
if ($search_row[0]==$_GET['id']) {
$id=trim($_GET['id']);
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

echo "<font face=Verdana color=blue size=4><b>Идет проверка данных...</b></font><HR>";

// сформируем header
$header = array();
$header[0] = "GET "."$urlink"." HTTP/1.1";
$header[1] = "Referer: -";
$header[2] = "User-Agent: LinkExchanger v2.0 checker";

// Получить ответ от проверяемой страницы, и если ошибка прервать выполнение
$ch = curl_init($urlink);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch,CURLOPT_TIMEOUT,7);
curl_setopt($ch,CURLOPT_HEADER,1);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
$result = curl_exec($ch);
curl_close($ch);

$num_error = substr("$result", 9, 3);
// **************************************************************************
// **************************************************************************
// **************************************************************************
if($num_error!=200||empty($result)) {
	
if($link_status=="hide") {
$_SESSION['error'] = "Запрашиваемый сервер "."$host_urlink"." ответил ошибкой "."$num_error"."!<br>Данные остались в разделе СКРЫТЫЕ ССЫЛКИ!";
} elseif ($link_status=="moder") {
$_SESSION['error'] = "Запрашиваемый сервер "."$host_urlink"." ответил ошибкой "."$num_error"."!<br>Данные остались в разделе МОДЕРАЦИЯ!";
} else {
$_SESSION['error'] = "Запрашиваемый сервер "."$host_urlink"." ответил ошибкой "."$num_error"."!<br>Данные помещены в раздел НЕДОСТУПНЫЕ ССЫЛКИ!";
}

// Начали писать данные в базу
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$tmp=fopen("data/tmp.dat","w");
$base=file("data/base.dat"); $flag = 1;
// ----------------------------
if(substr_count($back, "links_black.php")) { $base=file("data/black.dat"); $flag = 2; }
if(substr_count($back, "links_trash.php")) { $base=file("data/trash.dat"); $flag = 3; }
if(substr_count($back, "links_moder.php")) { $base=file("data/moder.dat"); $flag = 4; }
// ----------------------------
for($i=0;$i<count($base);$i++) {
$record=explode("|", $base[$i]);
if($record[0] != $_GET['id']) {
fwrite($tmp, $base[$i]);
} else {
if($link_status=="hide") { $link_status = "hide"; } else { $link_status = "noanswer"; }	
fputs($tmp, "$id|$nick|$urlink|$mail|$category|$htmltext|$htmlimage|$check_date|$check_result|$check_out_links|$check_cy|$check_pr|$check_pr_main|$check_tag_noindex|$check_meta_robots|$check_file_robots|$link_status|$ip_user|$admin_comment\r\n");
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

echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=error.php?id=$id&backward=$backward'>
	  </HEAD></HTML>";
exit();
}
// **************************************************************************
// **************************************************************************
// **************************************************************************

// Получаем имя хоста для проверки PR главной страницы
$url=parse_url($urlink);
$url="http://"."$url[host]";
// Получаем дату проверки
$check_date = time();
// Запускаем полную проверку
$check_pr_main = Get_PR_Google($url);

$check_cy = Get_CY_Yandex($urlink, $check_cy);

if($_SESSION['chkinfo_meta_robots']=="Да" AND $_SESSION['adm_need_link']=="Да") {
$check_meta_robots = Check_Meta_Tag($urlink);
} else { $check_meta_robots = "none"; }

if($_SESSION[chkinfo_count_links]=="Да") {
$check_out_links = Get_Out_Links($result);
} else {
$check_out_links = Get_Out_Links2($result, $urlink);
}

$check_pr = Get_PR_Google($urlink);

if($_SESSION['adm_need_link']=="Да") {
$check_result = Check_My_Link($result, $_SESSION['imp_myhome']);
} else { $check_result = "none"; }

if($_SESSION['chkinfo_file_robots']=="Да" AND $_SESSION['adm_need_link']=="Да") {
$check_robots_array = Check_File_Robots($urlink);
$check_file_robots = $check_robots_array[0];
} else { $check_file_robots = "none"; }

if($_SESSION['chkinfo_tag_noindex']=="Да" AND $_SESSION['adm_need_link']=="Да") {
$check_tag_noindex = Check_Tag_Noindex($result, $_SESSION['imp_myhome']);
} else { $check_tag_noindex = "none"; }


// Начали писать данные в базу
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$tmp=fopen("data/tmp.dat","w");
$base=file("data/base.dat");  $flag = 1;
// ----------------------------
if(substr_count($back, "links_black.php")) { $base=file("data/black.dat"); $flag = 2; }
if(substr_count($back, "links_trash.php")) { $base=file("data/trash.dat"); $flag = 3; }
if(substr_count($back, "links_moder.php")) { $base=file("data/moder.dat"); $flag = 4; }
// ----------------------------
for($i=0;$i<count($base);$i++) {
$record=explode("|", $base[$i]);
if($record[0] != $_GET['id']) {
fwrite($tmp, $base[$i]);
} else {
if($link_status=="hide") { $link_status = "hide"; } else { $link_status = "activ"; }
fputs($tmp, "$id|$nick|$urlink|$mail|$category|$htmltext|$htmlimage|$check_date|$check_result|$check_out_links|$check_cy|$check_pr|$check_pr_main|$check_tag_noindex|$check_meta_robots|$check_file_robots|$link_status|$ip_user|$admin_comment\r\n");
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

$stop_time = gettime();
$diff_time = $stop_time - $start_time;
$_SESSION['last_check_time'] = "$diff_time";

echo "<br><br><center>Если автоматического перенаправления не произошло<br><a href="."$backward".">нажмите сюда</a></center>";

echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=$backward'>
	  </HEAD></HTML>";
exit();

} // end if
@ignore_user_abort($old_abort);
?>