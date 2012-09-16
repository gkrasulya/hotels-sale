<?php
set_time_limit(120); // если у Вас запрещена эта функция - закомментируйте строку
include "functions/main.php"; // Подключаем файлы функций
$check_time = time(); // Берем время проверки
$start_time = gettime(); // Время начальной точки;

register_shutdown_function('Script_Time_Out');

include "config/cnfcron.dat";
$lock_path = "$adm_cron_path"."data/base.lck";
$base_path = "$adm_cron_path"."data/base.dat";
$tmp_path = "$adm_cron_path"."data/tmp.dat";

function Script_Time_Out() {
$stus = connection_status();
if($stus!=0) {
include "config/cnfcron.dat";
mail("$adm_e_mail", "CRON REPORT: ERROR NUMBER $stus", "NIK = $nick\r\nLINK = $urlink\r\nERROR NUMBER 1 - CONNECTION ABORTED\r\nERROR NUMBER 2 - CONNECTION TIMEOUT\r\n", "From:$adm_e_mail\n");
}
}
 

// получаем базу
$lock = fopen("$lock_path","a");
if(flock($lock, LOCK_EX)) {
$base=file("$base_path"); // база
flock($lock, LOCK_UN);
fclose($lock);
} else {
exit();
}

// ищем самую древнюю дату проверки
$num = count($base);
for($i=0;$i<$num;$i++) {
$search_row = explode("|", $base[$i]);
if ($search_row[7]<$check_time AND $search_row[16]!="hole" AND $search_row[16]!="hide") {
$id=trim($search_row[0]);
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
$status=trim($search_row[16]);
$ip_user=trim($search_row[17]);
$admin_comment=trim($search_row[18]);
$check_time = "$search_row[7]"; // в итоге - минимальное значение (самая древняя дата)
}
}

// сформируем header
$header = array();
$header[0] = "GET "."$urlink"." HTTP/1.1";
$header[1] = "Referer: -";
$header[2] = "User-Agent: LinkExchanger v2.0 checker(cron)";

// Получить ответ от проверяемой страницы, и если ошибка прервать выполнение
$ch = curl_init($urlink);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch,CURLOPT_TIMEOUT,7);
curl_setopt($ch,CURLOPT_HEADER,1);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
$result = curl_exec($ch);
curl_close($ch);

$num_error = substr("$result", 9, 3);

if($num_error!=200||empty($result)) {
// дату проверки обновим даже в случае недоступности ссылки
$check_date = time();
// Начали писать данные в базу
$lock = fopen("$lock_path","a");
if(flock($lock, LOCK_EX)) {
$tmp=fopen("$tmp_path","w");
$base=file("$base_path");
$num = count($base);
for($i=0;$i<$num;$i++) {
$record=explode("|", $base[$i]);
if($record[0] != $id) {
fwrite($tmp, $base[$i]);
} else {
fputs($tmp, "$id|$nick|$urlink|$mail|$category|$htmltext|$htmlimage|$check_date|$check_result|$check_out_links|$check_cy|$check_pr|$check_pr_main|$check_tag_noindex|$check_meta_robots|$check_file_robots|noanswer|$ip_user|$admin_comment\r\n");
}
}
fclose($tmp);
unlink("$base_path");
rename("$tmp_path", "$base_path");
flock($lock, LOCK_UN);
fclose($lock);
// ***************************************************
// здесь письмом админу - ссылка недоступна
// ***************************************************
if(trim($letter_noanswer)=="on"&&strlen($urlink)>7) { // админу, если ссылка недоступна
$stop_time = gettime();
$diff_time = $stop_time - $start_time;
$check_date = date("Y-m-d H:i:s", "$check_date");
$subject = "CRON: НЕ УДАЛОСЬ ПРОВЕРИТЬ ССЫЛКУ";
$message .= "Проверка была произведена: "."$check_date"."\nПроверяемая страница: $urlink";
$message .= "\nРезультат проверки: не удалось получить ответ от проверяемой страницы";
$message .= "\nСервер ответил ошибкой "."$num_error"."\nВремя проверки: "."$diff_time"." секунд";
$message .= "\n-----------------------------------------------------";
$message .= "\nпроверка ссылки: "."$check_result"." / требуется well";
$message .= "\nколичество ссылок: "."$check_out_links"." / требуется не более "."$adm_out_links";
$message .= "\nпо Yandex: "."$check_cy"." / требуется не менее "."$adm_cy";
$message .= "\nпо Google: "."$check_pr"." / требуется не менее "."$adm_pr";
$message .= "\nтэги noindex: "."$check_tag_noindex"." / требуется well";
$message .= "\nметатэг robots: "."$check_meta_robots"." / требуется well";
$message .= "\nфайл robots.txt: "."$check_file_robots"." / требуется well";
$message .= "\n-----------------------------------------------------\nпримечание: данные представлены по последней проверке";
$message .= "\n-----------------------------------------------------\nДействия: данные перемещены в раздел [недоступные ссылки]";
$message .= "\nРекомендации: личная проверка администратором каталога\n------------------------------------------------------";
$message .= "\nОтправитель: LE2 from "."$imp_myhome";
if($adm_in_mail=="koi8-r") { $subject = convert_cyr_string($subject, "w", "k"); $message = convert_cyr_string($message, "w", "k"); }
mail($adm_e_mail, $subject, $message, "From:$adm_e_mail\n");
}
// ***************************************************
// здесь письмом админу - ссылка недоступна
// ***************************************************
} else {
exit();
}
// Закончили запись данных в базу
exit();
}
// кончается если страница оказалась недоступной

// Получаем имя хоста для проверки PR главной страницы
$url=parse_url($urlink);
$url="http://"."$url[host]";
// Получаем дату проверки
$check_date = time();

// Запускаем полную проверку
$check_pr_main = Get_PR_Google($url);
$check_cy = Get_CY_Yandex($urlink, $check_cy);
$check_meta_robots = Check_Meta_Tag($urlink);
if($adm_count_links=="Да") {
$check_out_links = Get_Out_Links($result);
} else {
$check_out_links = Get_Out_Links2($result, $urlink);
}
$check_pr = Get_PR_Google($urlink);
$check_result = Check_My_Link($result, $imp_myhome);
$check_robots_array = Check_File_Robots($urlink);
$check_file_robots = $check_robots_array[0];
$check_tag_noindex = Check_Tag_Noindex($result, $imp_myhome);

// Начали писать данные в базу
$lock = fopen("$lock_path","a");
if(flock($lock, LOCK_EX)) {
$tmp=fopen("$tmp_path","w");
$base=file("$base_path");
$num = count($base);
for($i=0;$i<$num;$i++) {
$record=explode("|", $base[$i]);
if($record[0] != $id) {
fwrite($tmp, $base[$i]);
} else {
if($status=="hide") { $status = "hide"; } else { $status = "activ"; }
fputs($tmp, "$id|$nick|$urlink|$mail|$category|$htmltext|$htmlimage|$check_date|$check_result|$check_out_links|$check_cy|$check_pr|$check_pr_main|$check_tag_noindex|$check_meta_robots|$check_file_robots|$status|$ip_user|$admin_comment\r\n");
}
}
fclose($tmp);
unlink("$base_path");
rename("$tmp_path", "$base_path");
flock($lock, LOCK_UN);
fclose($lock);

$stop_time = gettime();
$diff_time = $stop_time - $start_time;
// ***************************************************
// здесь письмом админу - только если ссылка плохая
// ***************************************************
if($check_result=="badly"||$check_tag_noindex=="badly"||$check_meta_robots=="badly"||$check_file_robots=="badly"||$check_out_links>$adm_out_links||$check_cy<$adm_cy||$check_pr<$adm_pr) {
if(trim($letter_badly)=="on") { // админу, если ссылка плохая
$check_date = date("Y-m-d H:i:s", "$check_date");
$subject = "CRON: ССЫЛКА ПЛОХАЯ";
$message .= "Проверка была произведена: "."$check_date"."\nПроверяемая страница: "."$urlink";
$message .= "\nРезультат проверки: один или более параметров не удовлетворяют настройкам администратора каталога";
$message .= "\nВремя проверки: "."$diff_time"." секунд\n-----------------------------------------------------";
$message .= "\nпроверка ссылки: "."$check_result"." / требуется well";
$message .= "\nколичество ссылок: "."$check_out_links"." / требуется не более "."$adm_out_links";
$message .= "\nпо Yandex: "."$check_cy"." / требуется не менее "."$adm_cy";
$message .= "\nпо Google: "."$check_pr"." / требуется не менее "."$adm_pr";
$message .= "\nтэги noindex: "."$check_tag_noindex"." / требуется well";
$message .= "\nметатэг robots: "."$check_meta_robots"." / требуется well";
$message .= "\nфайл robots.txt: "."$check_file_robots"." / требуется well";
$message .= "\n-----------------------------------------------------";
$message .= "\nДействия: данные перемещены в раздел [плохие ссылки]";
$message .= "\nРекомендации: личная проверка администратором каталога";
$message .= "\n------------------------------------------------------\nОтправитель: LE2 from "."$imp_myhome";
if($adm_in_mail=="koi8-r") { $subject = convert_cyr_string($subject, "w", "k"); $message = convert_cyr_string($message, "w", "k"); }
mail($adm_e_mail, $subject, $message, "From:$adm_e_mail\n");
}
}
// ***************************************************
// здесь письмом админу - только если ссылка плохая
// ***************************************************
// ***************************************************
// здесь письмом админу - только если ссылка хорошая
// ***************************************************
if($check_result=="well"&&$check_tag_noindex=="well"&&$check_meta_robots=="well"&&$check_file_robots=="well"&&$check_out_links<=$adm_out_links&&$check_cy>=$adm_cy&&$check_pr>=$adm_pr) {
if(trim($letter_well)=="on") { // админу, если ссылка хорошая
$check_date = date("Y-m-d H:i:s", "$check_date");
$subject = "CRON: ССЫЛКА ХОРОШАЯ";
$message .= "Проверка была произведена: "."$check_date"."\nПроверяемая страница: "."$urlink"."\nРезультат проверки: ОК!";
$message .= "\nВремя проверки: "."$diff_time"." секунд\n-----------------------------------------------------";
$message .= "\nпроверка ссылки: "."$check_result"." / требуется well";
$message .= "\nколичество ссылок: "."$check_out_links"." / требуется не более "."$adm_out_links";
$message .= "\nпо Yandex: "."$check_cy"." / требуется не менее "."$adm_cy";
$message .= "\nпо Google: "."$check_pr"." / требуется не менее "."$adm_pr";
$message .= "\nтэги noindex: "."$check_tag_noindex"." / требуется well";
$message .= "\nметатэг robots: "."$check_meta_robots"." / требуется well";
$message .= "\nфайл robots.txt: "."$check_file_robots"." / требуется well";
$message .= "\n-----------------------------------------------------\nДействия: не было\nРекомендации: нет";
$message .= "\n------------------------------------------------------\nОтправитель: LE2 from "."$imp_myhome";
if($adm_in_mail=="koi8-r") { $subject = convert_cyr_string($subject, "w", "k"); $message = convert_cyr_string($message, "w", "k"); }
mail($adm_e_mail, $subject, $message, "From:$adm_e_mail\n");
}
}
// ***************************************************
// здесь письмом админу - только если ссылка хорошая
// ***************************************************
} else {
exit();
}
// Закончили запись данных в базу
exit();
?>