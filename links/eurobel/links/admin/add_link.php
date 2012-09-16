<?php
error_reporting(0);
@$old_abort = ignore_user_abort(true);

session_start();
include "adminic.php";
// ���������� �������
include "functions/cut.php";
include "functions/check.php";
include "functions/main.php";

// ��������, ��� ���������
$place = "�������� ������";
$flag_add_ok = "0"; // ���� ��������� ���������� ����������

// ������ ����� ���������, �������, ����-�����, ���� � freehosting � �������
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
$_SESSION['error'] = "�� ���� ������������� ��������� ���� data/base.lck !!!";
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=error.php'>
	  </HEAD></HTML>";
exit();
}

// *****************************************************************************
// ���� ������������ ��� ������ � �� ��������� ������
// *****************************************************************************
if($_POST['add_link_end'] AND $_SESSION['owner_status']=="this_admin" AND $_SESSION['end_post_admin'] != "sent_already") {

$_SESSION['end_post_admin'] = "sent_already"; // ������� �� ������-�������
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
// ������ ������ ������ � ����
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
// ���� ����� �� ����
if($flag_record != 1) {
$tmp=fopen("data/tmp.dat","a");
fputs($tmp, "$id|$nick|$urlink|$mail|$category|$htmltext|$view_image|$check_date|$check_result|$check_out_links|$check_cy|$check_pr|$check_pr_main|$check_tag_noindex|$check_meta_robots|$check_file_robots|$status|$ip_user|$admin_comment\r\n");
$row_in_category = $category_record+1;
fclose($tmp);
}
// ���� ����� �� ����
unlink("data/base.dat");
rename("data/tmp.dat", "data/base.dat");
flock($lock, LOCK_UN);
fclose($lock);
} else {
$_SESSION['error'] = "�� ���� ������������� ��������� ���� data/base.lck !!!";
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=error.php'>
	  </HEAD></HTML>";
exit();
}
// ��������� ������ ������ � ����
// -------------------------------------------------------------------------------
// ���������� ��������� ������ � ��������
// ������ ID ���������
$num = count($categories_array);
for($i=0;$i<$num;$i++) {
$categories_array_row = explode("|", $categories_array[$i]);
if($categories_array_row[1]==$category) {
$category_id = "$categories_array_row[0]";
break;
}
}
// �� ����� �������� � ���������
$page = ceil($row_in_category/$_SESSION['imp_links_page']);
// ���������� ���� (��� ��� ������ ���������)
$pos=strpos("$_SERVER[REQUEST_URI]", "admin/add_link.php");
$string=substr("$_SERVER[REQUEST_URI]", 0, $pos);
// ��������� ������ ����� ������
if($_SESSION['imp_mode_url']=="�����������") {
$link_place = "http://"."$_SERVER[HTTP_HOST]"."$string"."links_"."$category_id"."_"."$page".".html";
} else {
$link_place = "http://"."$_SERVER[HTTP_HOST]"."$string"."index.php?category=$category_id"."&page=$page";
}
// -------------------------------------------------------------------------------
// ������ ������ ������
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$subject = file("letters/s1.txt");
$message = file("letters/m1.txt");
$letter_swith = file("letters/w1.txt"); 
flock($lock, LOCK_UN);
fclose($lock);
} else {
$_SESSION['error'] = "�� ���� ������������� ��������� ���� data/base.lck !!!";
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=error.php'>
	  </HEAD></HTML>";
exit();
}

// ���������� ������, ���� ����
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
// ���������� ������, ���� ����
// -------------------------------------------------------------------------------

// ���������� ��� ����������
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
} // ����� �������� if ���� ������������ ��� ������ � �� ��������� ������
// *****************************************************************************
// ���� ������������ ��� ������ � �� ��������� ������
// *****************************************************************************
// -----------------------------------------------------------------------------
// ���� ��������� ������
if($_POST['add_link'] AND $_SESSION['owner_status']=="this_admin") {
// *****************************************************************************
unset($_SESSION['end_post_admin']); // ������� �� ������ ���������� ����

// �������� - �������� �������� ������
if(!empty($_POST['urlink'])) {
$urlink = Cut_All_Exc($_POST['urlink']); // ����� ������ ���
// �������� ������������ ���������� URL
$urlink = Check_In_Url($urlink);

if($urlink == "badly") {
$add_err['check_in_url'] = "����������� ��������� ���� �������� ������!";
} else {
unset($add_err['check_in_url']);
// � ������� ��� �����
$host = @parse_url($urlink);
$host = "http://"."$host[host]";
}

} else {
$add_err['empty_urlink'] = "�� ��������� ���� �������� ������! ���� �� �� ������ ������� URL, ������� ����� �������.";
}
// �������� - �������� �������� ������
// *****************************************************************************
// *****************************************************************************
// ���������� ���� NickName
$nick = Cut_All_All($_POST['nick']); // ����� ������ ���
if(empty($nick)) { $nick = "script"; }
// *****************************************************************************
// *****************************************************************************
// �������� - �������� e-mail ��������
if(!empty($_POST['mail'])) {
$mail = Cut_All_Exc($_POST['mail']); // ����� ������ ���
// �������� ������������ ���������� e-mail
$mail = Check_User_Mail($mail);
if($mail == "badly") { $add_err['check_user_mail'] = "����������� ��������� ���� ����������� �����!"; } else { unset($add_err['check_user_mail']); }

} else {
$mail = $_SESSION['adm_e_mail'];
}
// �������� - �������� e-mail ��������
// *****************************************************************************
// *****************************************************************************
// �������� ����� ���������
if(empty($_POST['category'])) {
$add_err['empty_category'] = "�� ������� ���������!";
} else { unset($add_err['empty_category']); }
// �������� ����� ���������
// *****************************************************************************
// *****************************************************************************
// �������� - �������� ����������� ������
if(!empty($_POST['view_image'])) {

$view_image = Cut_All_Exc($_POST['view_image']); // ����� ��� ������, ����� �������

// �������� ���� ���� ��� �������� ��� ������
$add_err['check_img_flash'] = Check_Img_Flash($view_image,$host);
if($add_err['check_img_flash']=="OK") { unset($add_err['check_img_flash']); }

// ����������� � ����������� � ������ ���� �����
$add_err['check_a_eqv_img'] = Check_A_Eqv($view_image);
if($add_err['check_a_eqv_img']=="OK") { unset($add_err['check_a_eqv_img']); }

// ���� ���� ��� � - �� ������ ��������� ���� ��, ��� ����� �������� ������
if($_SESSION['chkinfo_myhome_domen']=="��" AND $urlink!="badly") {
$add_err['check_img_a'] = Check_Img_A($view_image,$host);
if($add_err['check_img_a']=="OK") { unset($add_err['check_img_a']); }
}

// ��������� ������ � ������ ����������� ������, ����� ���� ����
if($_POST['check_size']=="on") {
$add_err['check_img_size'] = Check_Img_Size($view_image);
if($add_err['check_img_size']=="OK") { unset($add_err['check_img_size']); }
}

// ���� ���� IMG - �� ������ ���� ������ �� ����� � ����� ������ a � img - �������� ������
$view_image = Cut_Img_Notext($view_image);
// ���� ���� IMG - �������� � ����� ������ ������� ��� ����, ������� ����� ���� ���������
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
// �������� - �������� ����������� ������
// *****************************************************************************
// *****************************************************************************
// �������� - �������� ��������� ������
if(!empty($_POST['htmltext'])) {
$htmltext = Cut_All_Exc($_POST['htmltext']); // ����� ��� ������, ����� �������
$htmltext = Cut_Tags_Img($htmltext);
$htmltext = Cut_Tags_Flash($htmltext);
if($_SESSION['chkinfo_tags_b']=="���") { $htmltext = Cut_Tags_B($htmltext); }
if($_SESSION['chkinfo_tags_br']=="���") { $htmltext = Cut_Tags_Br($htmltext); }
if($_SESSION['chkinfo_tags_font']=="���") { $htmltext = Cut_Tags_Font($htmltext); }
if($_SESSION['chkinfo_tags_i']=="���") { $htmltext = Cut_Tags_I($htmltext); }
if($_SESSION['chkinfo_tags_p']=="���") { $htmltext = Cut_Tags_P($htmltext); }
if($_SESSION['chkinfo_tags_strong']=="���") { $htmltext = Cut_Tags_Strong($htmltext); }
if($_SESSION['chkinfo_tags_u']=="���") { $htmltext = Cut_Tags_U($htmltext); }

// ����������� � ����������� � ������ ���� �����
$add_err['check_a_eqv_text'] = Check_A_Eqv($htmltext);
if($add_err['check_a_eqv_text']=="OK") { unset($add_err['check_a_eqv_text']); }
// �������� ���������� �������� � ����
$add_err['check_symbol_code'] = Check_Symbol_Code($htmltext,$_SESSION['chkinfo_symbol_code']);
if($add_err['check_symbol_code']=="OK") { unset($add_err['check_symbol_code']); }
// �������� ���������� ������ � ����
$add_err['check_links_code'] = Check_Links_Code($htmltext,$_SESSION['chkinfo_links_code']);
if($add_err['check_links_code']=="OK") { unset($add_err['check_links_code']); }

// �������� �� �� ������ � ����, ������ ���� ��� ������ � �������������� ���� ������ ��������� �� ���� � ��� �� �����
// � ��������� ���������� �������������� �����
if($_SESSION['chkinfo_domen_domen']=="��" AND $_SESSION['chkinfo_links_code']>1) {
$add_err['check_domen_domen'] = Check_Domen_Domen($htmltext,$_SESSION['chkinfo_links_code']);
if($add_err['check_domen_domen']=="OK") { unset($add_err['check_domen_domen']); }
}
// �������� ��� �� ����� � ����, ������ ���� ��� ������ � ���� ������ ��������������� ������ ������
if($_SESSION['chkinfo_myhome_domen']=="��" AND $urlink!="badly") {
$add_err['check_myhome_domen'] = Check_Myhome_Domen($htmltext,$host);
if($add_err['check_myhome_domen']=="OK") { unset($add_err['check_myhome_domen']); }
}

} else {
$add_err['empty_htmltext'] = "�� ��������� ���� ��������� ������!";
}
// �������� - �������� ��������� ������
// ****************************************************************************
// ****************************************************************************
// �������� ��� �� ������ ������ � ����, �� ���������, � ������� ��� ����-�����
$urlink_short_host = Short_Domen_Name($urlink); // ��� �����
$flag_exists_link = "0"; // ������� ���� ������������� ������

// ����, ��� �� ��� ������ ������ �� ���������
if($flag_exists_link==0 AND empty($add_err['empty_urlink'])) {
for($i=0;$i<count($moder_array);$i++) {
$moder_array_row = explode("|", $moder_array[$i]);
if(substr_count("$moder_array_row[2]", "http://www.") != 0) {$short_host = "http://www."."$urlink_short_host";} else {$short_host = "http://"."$urlink_short_host";}
if(preg_match ("'$short_host'si", $moder_array_row[2])) {
$add_err['domen_in_moder'] = "������ � ������ <b>"."$urlink_short_host"."</b> ��������� �� ���������.";
$flag_exists_link = 1;
break;
} else {
unset($add_err['domen_in_moder']);
}
}
}
// ����, ��� �� ��� ������ ������ � �������
if($flag_exists_link==0 AND empty($add_err['empty_urlink'])) {
for($i=0;$i<count($trash_array);$i++) {
$trash_array_row = explode("|", $trash_array[$i]);
if(substr_count("$trash_array_row[2]", "http://www.") != 0) {$short_host = "http://www."."$urlink_short_host";} else {$short_host = "http://"."$urlink_short_host";}
if(preg_match ("'$short_host'si", $trash_array_row[2])) {
$add_err['domen_in_trash'] = "������ � ������ <b>"."$urlink_short_host"."</b> ��������� � �������.";
$flag_exists_link = 1;
break;
} else {
unset($add_err['domen_in_trash']);
}
}
}
// ����, ��� �� ��� ������ ������ � ����-�����
if($flag_exists_link==0 AND empty($add_err['empty_urlink'])) {
for($i=0;$i<count($black_array);$i++) {
$black_array_row = explode("|", $black_array[$i]);
if(substr_count("$black_array_row[2]", "http://www.") != 0) {$short_host = "http://www."."$urlink_short_host";} else {$short_host = "http://"."$urlink_short_host";}
if(preg_match ("'$short_host'si", $black_array_row[2])) {
$add_err['domen_in_black'] = "������ � ������ <b>"."$urlink_short_host"."</b> ��������� � ����-�����.";
$flag_exists_link = 1;
break;
} else {
unset($add_err['domen_in_black']);
}
}
}
// ����, ��� �� ��� ������ ������ � ����
if($flag_exists_link==0 AND empty($add_err['empty_urlink'])) {
$base = count($base_array);
for($i=0;$i<$base;$i++) {
$base_array_row = explode("|", $base_array[$i]);
if(substr_count("$base_array_row[2]", "http://www.") != 0) {$short_host = "http://www."."$urlink_short_host";} else {$short_host = "http://"."$urlink_short_host";}
if(preg_match ("'$short_host'si", $base_array_row[2])) {
$add_err['domen_in_base'] = "������ � ������ <b>"."$urlink_short_host"."</b> ��� ���� � ����!";
$flag_exists_link = 1;
break;
} else {
unset($add_err['domen_in_base']);
}
}
}
// �������� ��� �� ������ ������ � ����, �� ���������, � ������� ��� ����-�����
// ****************************************************************************
// ****************************************************************************
// �������� �� free-hosting ���� ����
if($_SESSION['chkinfo_free_hosting']=="���") {

// ���������� urlink_short_host � ��� �������� ������
// ��������� ���������� ��������
for($i=0;$i<count($freehosting_array);$i++) {
$freehosting_array_row = explode("|", $freehosting_array[$i]);
$search_row = trim($freehosting_array_row[1]);
$row = "."."$search_row";
if(substr_count("$urlink_short_host", "$row") != 0) {
$add_err['domen_in_freehosting'] = "����� <b>"."$urlink_short_host"."</b> ��������� �� ����������/����������� ��������.";
break;
} else {
unset($add_err['domen_in_freehosting']);
}
}

}
// �������� �� free-hosting ���� ����
// ****************************************************************************
// ****************************************************************************
// ���� ������ ���������� ����� ���, ��������� ��������� ���������
if(count($add_err)==0) {
$old_cy = 0; // ������� ����, ��������� ��� ������ ����������
// ��������� ������ ��������
$get_row_urlink = Get_Row_Urlink($urlink);
$check_pr_main = Get_PR_Google($host);
$check_result = Check_My_Link($get_row_urlink, $_SESSION['imp_myhome']);
$check_cy = Get_CY_Yandex($urlink, $old_cy);
$check_robots_array = Check_File_Robots($urlink);
$check_file_robots = $check_robots_array[0];
$check_meta_robots = Check_Meta_Tag($urlink);
$check_tag_noindex = Check_Tag_Noindex($get_row_urlink, $_SESSION['imp_myhome']);

if($_SESSION['chkinfo_count_links']=="��") {
$check_out_links = Get_Out_Links($get_row_urlink);
} else {
$check_out_links = Get_Out_Links2($get_row_urlink, $urlink);
}

$check_pr = Get_PR_Google($urlink);
}
// ���� ������ ���������� ����� ���, ��������� ��������� ���������
// *****************************************************************************

} // ����� ���� ��������� ������
// -----------------------------------------------------------------------------
// ������� ������ ��� ��, ���� ��� ������������
if($_SESSION['error_config']) { echo "<span id=warningMess>������! $_SESSION[error_config]</span>"; unset($_SESSION['error_config']); }
if($_SESSION['ok_config']) { echo "<span id=okMess>��! $_SESSION[ok_config]</span>";  unset($_SESSION['ok_config']); }
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
// ���������� ����
include "menu.php";
echo "</td></tr><tr><td colspan=2 valign=top align=left></td></tr>";
// ---------------------------------------------------------------------------------------------------------------------------------
echo "<tr><td valign=top align=left>"; // ������ ������ � ������

if($flag_add_ok=="ok") { // ���� ��������� - ������� ����� ������
echo "<table width=100% cellspacing=0 cellpadding=0>
	  <tr><td align=right valign=top width=1px><img src=images/login_lu.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_ru.gif width=8 height=8 border=0></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td class=title bgcolor=#8f95ac align=center colspan=2>������ ������� ��������� � �������! �� ���������� �����:<br><br></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td class=title bgcolor=#8f95ac align=center colspan=2><input type=text style=\"width: 420px;\" value=\""."$link_place"."\" onClick=select()>&nbsp;&nbsp;&nbsp;<a href=\""."$link_place"."\" target=\"_blank\"> >> </a><br><br></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=center colspan=2><a href=add_link.php>�������� ���</a><br></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td align=right valign=top width=1px><img src=images/login_ld.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_rd.gif width=8 height=8 border=0></td></tr>
      </table><br>";
} else { // ���� ��� - ���������� ���� �����

// ������ ���� � ���������� ��������� � ������ (���������� ��� � ������ �� ������-������)
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$categories_array = file("data/categories.dat");
flock($lock, LOCK_UN);
fclose($lock);
} else {
$_SESSION['error'] = "�� ���� ������������� ��������� ���� data/base.lck !!!";
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=error.php'>
	  </HEAD></HTML>";
exit();
}

// ����� ��� ����� ����� ������
echo "<form action=\""."$_SERVER[PHP_SELF]"."\" method=\"POST\"><table width=100% cellspacing=0 cellpadding=0>
      <tr><td align=right valign=top width=1px><img src=images/login_lu.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_ru.gif width=8 height=8 border=0></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td class=title bgcolor=#8f95ac align=left colspan=2>����� ��� ����� ����� ������<br><br></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left nowrap width=1% valign=top>��������� ������*:</td><td bgcolor=#8f95ac align=right valign=top><textarea name=\"htmltext\" rows=\"3\" cols=\"36\" style=\"width: 420px;\">"."$htmltext"."</textarea></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left nowrap width=1% valign=top>����������� ������:</td><td bgcolor=#8f95ac align=right valign=top><textarea name=\"view_image\" rows=\"3\" cols=\"36\" style=\"width: 420px;\">"."$view_image"."</textarea></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left nowrap width=1%>���������*:</td><td bgcolor=#8f95ac align=right valign=top>";
$all_categories = count($categories_array);
// ���������� �� �������� ---------------------------------------
for($h=0;$h<$all_categories;$h++) { // ����� ���� ��� ����������
list($id_category,$category_name,$category_keywords,$category_description) = explode("|", $categories_array[$h]);
$tmp[$h] = array (field => $category_name, ext1 => $id_category, ext2 => "$category_keywords|$category_description");
}
sort($tmp, SORT_REGULAR); // ����������
for($h=0;$h<count($tmp);$h++) { // �������� ���������������� �������
$categories_array[$h] = ("{$tmp[$h][ext1]}"."|"."{$tmp[$h][field]}"."|"."{$tmp[$h][ext2]}");
}
// ���������� �� �������� ---------------------------------------
// ������ ���������
$cat_sort = count($categories_array);
echo "<select name=category style=\"width: 420px;\"><option>"."$_POST[category]"."</option>";
for($i=0; $i<$cat_sort; $i++) {
$row = explode("|", $categories_array[$i]);
echo "<option>"."$row[1]"."</option>";
}
echo "</select>";	
echo "</td><td bgcolor=#8f95ac width=1px></td></tr>
	  <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left nowrap width=1%>E-mail ��������:</td><td bgcolor=#8f95ac align=right valign=top><input type=text name=\"mail\" style=\"width: 420px;\" value=\""."$mail"."\"></td><td bgcolor=#8f95ac width=1px></td></tr>
	  <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left nowrap width=1%>NickName ��������:</td><td bgcolor=#8f95ac align=right valign=top><input type=text name=\"nick\" style=\"width: 420px;\" value=\""."$nick"."\"></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left nowrap width=1%>�������� ������*:</td><td bgcolor=#8f95ac align=right valign=top><input type=text name=\"urlink\" style=\"width: 420px;\" value=\""."$urlink"."\"></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=right valign=top colspan=2>��������� ������� ����������� ������? <input type=checkbox name=\"check_size\" checked></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=center colspan=2 valign=top><input name=\"add_link\" type=\"submit\" value=\"��������� / ���������\"></td><td bgcolor=#8f95ac width=1px></td></tr>
	  <tr><td align=right valign=top width=1px><img src=images/login_ld.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_rd.gif width=8 height=8 border=0></td></tr>
      </table></form><br>";
// ---------------------------------------------------------------------------------------------------------------------------------
} // end ���� ��������� (���������� ����� ������)

if(count($add_err)!=0) {
// ���� ���� ������
echo "<table width=100% cellspacing=0 cellpadding=0>
      <tr><td align=right valign=top width=1px><img src=images/login_lu.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_ru.gif width=8 height=8 border=0></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td class=title bgcolor=#8f95ac align=left colspan=2>������ ���������� �����:<br><br></td><td bgcolor=#8f95ac width=1px></td></tr>";
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
// ���� ���� ������
}
if(count($add_err)==0 AND $_POST['add_link']) {
// ���� ������ ���
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
      <tr><td bgcolor=#8f95ac width=1px></td><td class=title bgcolor=#8f95ac align=left colspan=2>��������������� �������� ����������� ��������:</td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td class=title bgcolor=#8f95ac align=left colspan=2><hr></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left><?php echo $htmltext ?></td><td bgcolor=#8f95ac align=right width=120px><?php echo $view_image ?></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=right colspan=2><b><i>���������: <?php echo $_POST[category] ?></i></b></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2><hr></td><td bgcolor=#8f95ac width=1px></td></tr>
	  
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=center colspan=2>
	  <table width=100% cellspacing=1 cellpadding=1>
	  <tr><td bgcolor=#8f95ac width=49% align=left><a href=$urlink target=_blank>��������� ��������:</a></td><td bgcolor=#8f95ac width=1% nowrap align=right><b><?php if($check_result=="badly") { echo "<font color=red>"."$check_result"."</font>"; } else { echo "$check_result"; } ?></b>&nbsp;&nbsp;</td><td bgcolor=#8f95ac width=49% align=left>&nbsp;&nbsp;���������� ������ �� ��������:</td><td bgcolor=#8f95ac width=1% nowrap align=right><b><?php if($check_out_links>$_SESSION['adm_out_links']) { echo "<font color=red>"."$check_out_links"."</font>"; } else { echo "$check_out_links"; } ?></b></td></tr>
	  <tr><td bgcolor=#8f95ac width=49% align=left><a href=<?php echo "$robtxt"; ?> target=_blank>�������� ����� robots.txt:</a></td><td bgcolor=#8f95ac width=1% nowrap align=right><b><?php if($check_file_robots=="badly") { echo "<font color=red>"."$check_file_robots"."</font>"; } else { echo "$check_file_robots"; } ?></b>&nbsp;&nbsp;</td><td bgcolor=#8f95ac width=49% align=left>&nbsp;&nbsp;CY �������:</td><td bgcolor=#8f95ac width=1% nowrap align=right><b><?php if($check_cy<$_SESSION['adm_cy']) { echo "<font color=red>"."$check_cy"."</font>"; } else { echo "$check_cy"; } ?></b></td></tr>
	  <tr><td bgcolor=#8f95ac width=49% align=left>�������� ��������� ROBOTS:</td><td bgcolor=#8f95ac width=1% nowrap align=right><b><?php if($check_meta_robots=="badly") { echo "<font color=red>"."$check_meta_robots"."</font>"; } else { echo "$check_meta_robots"; } ?></b>&nbsp;&nbsp;</td><td bgcolor=#8f95ac width=49% align=left>&nbsp;&nbsp;PR ������� ��������:</td><td bgcolor=#8f95ac width=1% nowrap align=right><b><?php echo "$check_pr_main"; ?></b></td></tr>
	  <tr><td bgcolor=#8f95ac width=49% align=left>�������� ����� noindex:</td><td bgcolor=#8f95ac width=1% nowrap align=right><b><?php if($check_tag_noindex=="badly") { echo "<font color=red>"."$check_tag_noindex"."</font>"; } else { echo "$check_tag_noindex"; } ?></b>&nbsp;&nbsp;</td><td bgcolor=#8f95ac width=49% align=left>&nbsp;&nbsp;PR �������� ������:</td><td bgcolor=#8f95ac width=1% nowrap align=right><b><?php if($check_pr<$_SESSION['adm_pr']) { echo "<font color=red>"."$check_pr"."</font>"; } else { echo "$check_pr"; } ?></b></td></tr>
	  </table>
<?php
	  echo "</td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=center colspan=2><HR></td><td bgcolor=#8f95ac width=1px></td></tr>
	  <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=right colspan=2>�������� ����������� ��������������:<br><textarea name=admin_comment rows=\"3\" cols=\"36\" style=\"width: 540px;\"></textarea></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=center colspan=2 valign=top><input name=\"add_link_end\" type=\"submit\" value=\"�������� ������\"></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td align=right valign=top width=1px><img src=images/login_ld.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_rd.gif width=8 height=8 border=0></td></tr>
      </table></form>";

// ���� ������ ���
}
// ---------------------------------------------------------------------------------------------------------------------------------
// ������ ������� ��� ������
echo "</td><td valign=top align=right>"; // ������ ������ � ������

echo "<table width=360 cellspacing=0 cellpadding=0>
      <tr><td align=right valign=top width=1px><img src=images/login_lu.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_ru.gif width=8 height=8 border=0></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td class=title bgcolor=#8f95ac align=right colspan=2>Help</td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2>";
	  
echo "<div align=justify>
<font face=Verdana size=1 color=white><b>���������� ������</b></font><br>� ����� ����� ����� ������ ��� ������������ ����: ��������� ������, ��������� � �������� ������.<br><br>
���� �� �����-�� �������� �� ���� �� ������ ������� ������ �������� ������, ������ ������� � ��� ���� ����� ������� ������ �������� �� ������.<br><br>
���� ����� ���������� ����� ����������� ����� - �������� ��� ������, ������ ��������� ���� ��� ����������� ����� �� �������� �� ������� ����������, 
��� ������ ���� ��������� ����. ������������ �� ������� ��������������� e-mail ��� ���� ������.<br><br>
���� �� �������� ������ ���� �������� ������ ��������� � ���� ����� \"script\". ������� ����� ����� ����� ��������������� ������������.<br><br>
������ �������� �������� ���� ������ ��� �� ��������, ��� � ������ �������� �������������� �������� ��� ���������� ������. 
���, ��� ����� ������ ����������� ��������� ���. �� ��������� \"����������\" �� ������ ��������������� ���������. 
��� ��������� ��������� �� ������� ���������� �����, ������ ����� ��������� ��������� ������������, ���� ��� �������� ������ ��������������� ������ ���.<br><br>
���� ����� ��������� ���������, ������ �������� ������ � ������ �������������� ���������� ��� �������� �������. ����� ����� �������� ���� ��� ����������� ��������������.<br><br>
������ �������� �������� ������ � ������� ���� �������� �� ��, ��� ���� ��� ����� ����������� ���������� �� ����� ������������� ������������� ���� �����������.
</div>";

echo "</td><td bgcolor=#8f95ac width=1px></td></tr>
	  <tr><td align=right valign=top width=1px><img src=images/login_ld.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_rd.gif width=8 height=8 border=0></td></tr>
      </table>";

echo "</td></tr></table>";
@ignore_user_abort($old_abort);
?>
</body>
</html>