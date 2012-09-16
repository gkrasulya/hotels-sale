<?php
set_time_limit(120); // ���� � ��� ��������� ��� ������� - ��������������� ������
include "functions/main.php"; // ���������� ����� �������
$check_time = time(); // ����� ����� ��������
$start_time = gettime(); // ����� ��������� �����;

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
 

// �������� ����
$lock = fopen("$lock_path","a");
if(flock($lock, LOCK_EX)) {
$base=file("$base_path"); // ����
flock($lock, LOCK_UN);
fclose($lock);
} else {
exit();
}

// ���� ����� ������� ���� ��������
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
$check_time = "$search_row[7]"; // � ����� - ����������� �������� (����� ������� ����)
}
}

// ���������� header
$header = array();
$header[0] = "GET "."$urlink"." HTTP/1.1";
$header[1] = "Referer: -";
$header[2] = "User-Agent: LinkExchanger v2.0 checker(cron)";

// �������� ����� �� ����������� ��������, � ���� ������ �������� ����������
$ch = curl_init($urlink);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch,CURLOPT_TIMEOUT,7);
curl_setopt($ch,CURLOPT_HEADER,1);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
$result = curl_exec($ch);
curl_close($ch);

$num_error = substr("$result", 9, 3);

if($num_error!=200||empty($result)) {
// ���� �������� ������� ���� � ������ ������������� ������
$check_date = time();
// ������ ������ ������ � ����
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
// ����� ������� ������ - ������ ����������
// ***************************************************
if(trim($letter_noanswer)=="on"&&strlen($urlink)>7) { // ������, ���� ������ ����������
$stop_time = gettime();
$diff_time = $stop_time - $start_time;
$check_date = date("Y-m-d H:i:s", "$check_date");
$subject = "CRON: �� ������� ��������� ������";
$message .= "�������� ���� �����������: "."$check_date"."\n����������� ��������: $urlink";
$message .= "\n��������� ��������: �� ������� �������� ����� �� ����������� ��������";
$message .= "\n������ ������� ������� "."$num_error"."\n����� ��������: "."$diff_time"." ������";
$message .= "\n-----------------------------------------------------";
$message .= "\n�������� ������: "."$check_result"." / ��������� well";
$message .= "\n���������� ������: "."$check_out_links"." / ��������� �� ����� "."$adm_out_links";
$message .= "\n�� Yandex: "."$check_cy"." / ��������� �� ����� "."$adm_cy";
$message .= "\n�� Google: "."$check_pr"." / ��������� �� ����� "."$adm_pr";
$message .= "\n���� noindex: "."$check_tag_noindex"." / ��������� well";
$message .= "\n������� robots: "."$check_meta_robots"." / ��������� well";
$message .= "\n���� robots.txt: "."$check_file_robots"." / ��������� well";
$message .= "\n-----------------------------------------------------\n����������: ������ ������������ �� ��������� ��������";
$message .= "\n-----------------------------------------------------\n��������: ������ ���������� � ������ [����������� ������]";
$message .= "\n������������: ������ �������� ��������������� ��������\n------------------------------------------------------";
$message .= "\n�����������: LE2 from "."$imp_myhome";
if($adm_in_mail=="koi8-r") { $subject = convert_cyr_string($subject, "w", "k"); $message = convert_cyr_string($message, "w", "k"); }
mail($adm_e_mail, $subject, $message, "From:$adm_e_mail\n");
}
// ***************************************************
// ����� ������� ������ - ������ ����������
// ***************************************************
} else {
exit();
}
// ��������� ������ ������ � ����
exit();
}
// ��������� ���� �������� ��������� �����������

// �������� ��� ����� ��� �������� PR ������� ��������
$url=parse_url($urlink);
$url="http://"."$url[host]";
// �������� ���� ��������
$check_date = time();

// ��������� ������ ��������
$check_pr_main = Get_PR_Google($url);
$check_cy = Get_CY_Yandex($urlink, $check_cy);
$check_meta_robots = Check_Meta_Tag($urlink);
if($adm_count_links=="��") {
$check_out_links = Get_Out_Links($result);
} else {
$check_out_links = Get_Out_Links2($result, $urlink);
}
$check_pr = Get_PR_Google($urlink);
$check_result = Check_My_Link($result, $imp_myhome);
$check_robots_array = Check_File_Robots($urlink);
$check_file_robots = $check_robots_array[0];
$check_tag_noindex = Check_Tag_Noindex($result, $imp_myhome);

// ������ ������ ������ � ����
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
// ����� ������� ������ - ������ ���� ������ ������
// ***************************************************
if($check_result=="badly"||$check_tag_noindex=="badly"||$check_meta_robots=="badly"||$check_file_robots=="badly"||$check_out_links>$adm_out_links||$check_cy<$adm_cy||$check_pr<$adm_pr) {
if(trim($letter_badly)=="on") { // ������, ���� ������ ������
$check_date = date("Y-m-d H:i:s", "$check_date");
$subject = "CRON: ������ ������";
$message .= "�������� ���� �����������: "."$check_date"."\n����������� ��������: "."$urlink";
$message .= "\n��������� ��������: ���� ��� ����� ���������� �� ������������� ���������� �������������� ��������";
$message .= "\n����� ��������: "."$diff_time"." ������\n-----------------------------------------------------";
$message .= "\n�������� ������: "."$check_result"." / ��������� well";
$message .= "\n���������� ������: "."$check_out_links"." / ��������� �� ����� "."$adm_out_links";
$message .= "\n�� Yandex: "."$check_cy"." / ��������� �� ����� "."$adm_cy";
$message .= "\n�� Google: "."$check_pr"." / ��������� �� ����� "."$adm_pr";
$message .= "\n���� noindex: "."$check_tag_noindex"." / ��������� well";
$message .= "\n������� robots: "."$check_meta_robots"." / ��������� well";
$message .= "\n���� robots.txt: "."$check_file_robots"." / ��������� well";
$message .= "\n-----------------------------------------------------";
$message .= "\n��������: ������ ���������� � ������ [������ ������]";
$message .= "\n������������: ������ �������� ��������������� ��������";
$message .= "\n------------------------------------------------------\n�����������: LE2 from "."$imp_myhome";
if($adm_in_mail=="koi8-r") { $subject = convert_cyr_string($subject, "w", "k"); $message = convert_cyr_string($message, "w", "k"); }
mail($adm_e_mail, $subject, $message, "From:$adm_e_mail\n");
}
}
// ***************************************************
// ����� ������� ������ - ������ ���� ������ ������
// ***************************************************
// ***************************************************
// ����� ������� ������ - ������ ���� ������ �������
// ***************************************************
if($check_result=="well"&&$check_tag_noindex=="well"&&$check_meta_robots=="well"&&$check_file_robots=="well"&&$check_out_links<=$adm_out_links&&$check_cy>=$adm_cy&&$check_pr>=$adm_pr) {
if(trim($letter_well)=="on") { // ������, ���� ������ �������
$check_date = date("Y-m-d H:i:s", "$check_date");
$subject = "CRON: ������ �������";
$message .= "�������� ���� �����������: "."$check_date"."\n����������� ��������: "."$urlink"."\n��������� ��������: ��!";
$message .= "\n����� ��������: "."$diff_time"." ������\n-----------------------------------------------------";
$message .= "\n�������� ������: "."$check_result"." / ��������� well";
$message .= "\n���������� ������: "."$check_out_links"." / ��������� �� ����� "."$adm_out_links";
$message .= "\n�� Yandex: "."$check_cy"." / ��������� �� ����� "."$adm_cy";
$message .= "\n�� Google: "."$check_pr"." / ��������� �� ����� "."$adm_pr";
$message .= "\n���� noindex: "."$check_tag_noindex"." / ��������� well";
$message .= "\n������� robots: "."$check_meta_robots"." / ��������� well";
$message .= "\n���� robots.txt: "."$check_file_robots"." / ��������� well";
$message .= "\n-----------------------------------------------------\n��������: �� ����\n������������: ���";
$message .= "\n------------------------------------------------------\n�����������: LE2 from "."$imp_myhome";
if($adm_in_mail=="koi8-r") { $subject = convert_cyr_string($subject, "w", "k"); $message = convert_cyr_string($message, "w", "k"); }
mail($adm_e_mail, $subject, $message, "From:$adm_e_mail\n");
}
}
// ***************************************************
// ����� ������� ������ - ������ ���� ������ �������
// ***************************************************
} else {
exit();
}
// ��������� ������ ������ � ����
exit();
?>