<?php
error_reporting(0);
@$old_abort = ignore_user_abort(true);
session_start();
include "adminic.php";
include "functions/cut.php";
include "functions/check.php";
include "functions/main.php";
// ��������, ��� ���������
$place = "��������������";

// ����, ��� ������ �������������, � ��� ������ ��������
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$base=file("data/base.dat");
$moder=file("data/moder.dat");
$categories=file("data/categories.dat");
flock($lock, LOCK_UN);
fclose($lock);
} else {
$_SESSION['error'] = "�� ���� ������������� ��������� ���� data/base.lck !!!";
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=error.php'>
	  </HEAD></HTML>";
exit();
}

// *******************************************************************************
// �������� ������, ������� ���� ���������������
// *******************************************************************************
if($_GET['action']=="edit_data" AND $_GET['id'] AND $_SESSION['owner_status']=="this_admin") {

// ��������� ������ URL ���� ���������
$backward="http://"."$_SERVER[HTTP_HOST]"."$_GET[back]"."?"."page="."$_GET[page]"."#"."$_GET[id]";
$back = "$_GET[back]";

// �� ���� ��� � ���������?
if(substr_count("$back", "links_moder.php") != 0) {
$num = count($moder);
$arr = $moder;
} else {
$num = count($base);
$arr = $base;
$flag = "b";
}

// ��� ������?
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
$status=trim($search_row[16]);
$ip_user=trim($search_row[17]);
$admin_comment=trim($search_row[18]);
break;
}
}
// ��� ������?

} // end if GET[action] - edit_data
// *******************************************************************************
// �������� ������, ������� ���� ���������������
// *******************************************************************************

// *******************************************************************************
// ������ �������������� - ������� �����
// *******************************************************************************
if($_POST['edit_no']=="���������" AND $_SESSION['owner_status']=="this_admin") {
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=$_POST[backward]'>
	  </HEAD></HTML>";
exit();
}
// *******************************************************************************
// ������ �������������� - ������� �����
// *******************************************************************************

// *******************************************************************************
// ����������� ������, ������� �������
// *******************************************************************************

if($_POST['edit_yes']=="�������������" AND $_SESSION['owner_status']=="this_admin") {

$backward=$_POST['backward'];
	
// ��������� � �������� ����������������� ������
// -----------------------------------------------------------------------------
// ****************************************************************************
// ************** ���� ���� ���������� ����� � ����� add_link.php ************
// ****************************************************************************
// *****************************************************************************
// �������� - �������� �������� ������
if(!empty($_POST['urlink'])) {
$urlink = Cut_All_Exc($_POST['urlink']); // ����� ������ ���
// �������� ������������ ���������� URL
$urlink = Check_In_Url($urlink);

if($urlink=="badly") {
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
// �������� - �������� e-mail ��������
if(!empty($_POST['mail'])) {
$mail = Cut_All_Exc($_POST['mail']); // ����� ������ ���
// �������� ������������ ���������� e-mail
$mail = Check_User_Mail($mail);
if($mail=="badly") { $add_err['check_user_mail'] = "����������� ��������� ���� ����������� �����!"; } else { unset($add_err['check_user_mail']); }

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
if(!empty($_POST['htmlimage'])) {

$htmlimage = Cut_All_Exc($_POST['htmlimage']); // ����� ��� ������, ����� �������

// �������� ���� ���� ��� �������� ��� ������
$add_err['check_img_flash'] = Check_Img_Flash($htmlimage,$host);
if($add_err['check_img_flash']=="OK") { unset($add_err['check_img_flash']); }

// ����������� � ����������� � ������ ���� �����
$add_err['check_a_eqv_img'] = Check_A_Eqv($htmlimage);
if($add_err['check_a_eqv_img']=="OK") { unset($add_err['check_a_eqv_img']); }

// ���� ���� ��� � - �� ������ ��������� ���� ��, ��� ����� �������� ������
if($_SESSION['chkinfo_myhome_domen']=="��" AND $urlink!="badly") {
$add_err['check_img_a'] = Check_Img_A($htmlimage,$host);
if($add_err['check_img_a']=="OK") { unset($add_err['check_img_a']); }
}

// ��������� ������ � ������ ����������� ������, ����� ���� ����
if($_POST['check_size']=="on") {
$add_err['check_img_size'] = Check_Img_Size($htmlimage);
if($add_err['check_img_size']=="OK") { unset($add_err['check_img_size']); }
}

// ���� ���� IMG - �� ������ ���� ������ �� ����� � ����� ������ a � img - �������� ������
$htmlimage = Cut_Img_Notext($htmlimage);
// ���� ���� IMG - �������� � ����� ������ ������� ��� ����, ������� ����� ���� ���������
$temp = strtolower($htmlimage);
$count_img = substr_count($temp, "<img");

if($count_img > 0) {
$htmlimage = Cut_Tags_B($htmlimage);
$htmlimage = Cut_Tags_Br($htmlimage);
$htmlimage = Cut_Tags_Font($htmlimage);
$htmlimage = Cut_Tags_I($htmlimage);
$htmlimage = Cut_Tags_P($htmlimage);
$htmlimage = Cut_Tags_Strong($htmlimage);
$htmlimage = Cut_Tags_U($htmlimage);
$htmlimage = Cut_Tags_Flash($htmlimage);
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
if($_SESSION[chkinfo_tags_b]=="���") { $htmltext = Cut_Tags_B($htmltext); }
if($_SESSION[chkinfo_tags_br]=="���") { $htmltext = Cut_Tags_Br($htmltext); }
if($_SESSION[chkinfo_tags_font]=="���") { $htmltext = Cut_Tags_Font($htmltext); }
if($_SESSION[chkinfo_tags_i]=="���") { $htmltext = Cut_Tags_I($htmltext); }
if($_SESSION[chkinfo_tags_p]=="���") { $htmltext = Cut_Tags_P($htmltext); }
if($_SESSION[chkinfo_tags_strong]=="���") { $htmltext = Cut_Tags_Strong($htmltext); }
if($_SESSION[chkinfo_tags_u]=="���") { $htmltext = Cut_Tags_U($htmltext); }

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
if($_SESSION['chkinfo_domen_domen']=="��" AND $_SESSION[chkinfo_links_code]>1) {
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
// ************** ���� ���� ���������� ����� � ����� add_link.php ************
// ****************************************************************************

// �� ���� ��� ������ ������� ���� ���������� ��� ������:
// id, nick, ......
// -----------------------------------------------------------------------------
$id = $_POST['id'];
$nick = $_POST['nick'];
$category = $_POST['category'];
$old_category = $_POST['old_category'];
$check_result = $_POST['check_result'];
$check_out_links = $_POST['check_out_links'];
$check_cy = $_POST['check_cy'];
$check_pr = $_POST['check_pr'];
$check_pr_main = $_POST['check_pr_main'];
$check_tag_noindex = $_POST['check_tag_noindex'];
$check_meta_robots = $_POST['check_meta_robots'];
$check_file_robots = $_POST['check_file_robots'];
$status = $_POST['status'];
$ip_user = $_POST['ip_user'];
$admin_comment = Cut_All_All($_POST['admin_comment']);
// -----------------------------------------------------------------------------

// -----------------------------------------------------------------------------
// ��������� � �������� ����������������� ������


// ���� ������ ���
if(count($add_err)==0) {

if(substr_count("$_POST[backward]", "links_moder.php") != 0) {
// ���� ������ �� ���������
// -----------------------------------------------------------------------------
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$tmp=fopen("data/tmp.dat","w");
$moder=file("data/moder.dat");
for($i=0;$i<count($moder);$i++) {
$record=explode("|", $moder[$i]);
if($record[0] != $id) {
fwrite($tmp, $moder[$i]);
} else {
fputs($tmp, "$id|$nick|$urlink|$mail|$category|$htmltext|$htmlimage|$check_date|$check_result|$check_out_links|$check_cy|$check_pr|$check_pr_main|$check_tag_noindex|$check_meta_robots|$check_file_robots|$status|$ip_user|$admin_comment\r\n");
}
}
fclose($tmp);
unlink("data/moder.dat");
rename("data/tmp.dat", "data/moder.dat");
flock($lock, LOCK_UN);
fclose($lock);
} else {
$_SESSION['error'] = "�� ���� ������������� ��������� ���� data/base.lck !!!";
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=error.php'>
	  </HEAD></HTML>";
exit();
}
// -----------------------------------------------------------------------------
// ���� ������ �� ���������
} else {
// ���� ������ �� ���� (2 ��������: �������� ��� ��� ���������)
// -----------------------------------------------------------------------------
if($category==$old_category) { // ��������� �� ����������, ������ � ���� �� ���� �����
// -----------------------------------------------------------------------------
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$tmp=fopen("data/tmp.dat","w");
$base=file("data/base.dat");
for($i=0;$i<count($base);$i++) {
$record=explode("|", $base[$i]);
if($record[0] != "$id") {
fwrite($tmp, $base[$i]);
} else {
fputs($tmp, "$id|$nick|$urlink|$mail|$category|$htmltext|$htmlimage|$check_date|$check_result|$check_out_links|$check_cy|$check_pr|$check_pr_main|$check_tag_noindex|$check_meta_robots|$check_file_robots|$status|$ip_user|$admin_comment\r\n");
}
}
fclose($tmp);
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
// -----------------------------------------------------------------------------
} else { // ��������� ����������, ������ � ���� ��� ���������� ����� ������ + ������� ����� �� ������ �����
// -----------------------------------------------------------------------------
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
$new_id = time();
fputs($tmp, "$new_id|$nick|$urlink|$mail|$category|$htmltext|$htmlimage|$check_date|$check_result|$check_out_links|$check_cy|$check_pr|$check_pr_main|$check_tag_noindex|$check_meta_robots|$check_file_robots|$status|$ip_user|$admin_comment\r\n");
$flag_record = 1;
$row_in_category = $category_record;
} else {
fwrite($tmp, "$base_array[$i]");
}

} else { if($record[0]==$id) { fputs($tmp, "$record[0]|-|-|-|$record[4]|-|-|-|-|-|-|-|-|-|-|-|hole|-|-\r\n"); } else { fwrite($tmp, "$base_array[$i]"); } }
// ���� �� ������� ����� ��������� �� ������ ID ���� ������ �����
// -------------------------------------------------------------------------------
} // end for
fclose($tmp);
// ���� ����� �� ����
if($flag_record != 1) {
$tmp=fopen("data/tmp.dat","a");
$new_id = time();
fputs($tmp, "$new_id|$nick|$urlink|$mail|$category|$htmltext|$htmlimage|$check_date|$check_result|$check_out_links|$check_cy|$check_pr|$check_pr_main|$check_tag_noindex|$check_meta_robots|$check_file_robots|$status|$ip_user|$admin_comment\r\n");
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
// -----------------------------------------------------------------------------

// ���������� ��������� ������ � ��������
// ������ ID ��������� (��� ����� ���������!!!)
$num = count($categories);
for($i=0;$i<$num;$i++) {
$categories_row = explode("|", $categories[$i]);
if($categories_row[1]==$category) {
$category_id = $categories_row[0];
break;
}
}

// �� ����� �������� � ���������
$page = ceil($row_in_category/$_SESSION['imp_links_page']);
// ���������� ���� (��� ��� ������ ���������)
$pos=strpos("$_SERVER[REQUEST_URI]", "admin/editdata.php");
$string=substr("$_SERVER[REQUEST_URI]", 0, $pos);
// ��������� ������ ����� ������
if($_SESSION['imp_mode_url']=="�����������") {
$link_place = "http://"."$_SERVER[HTTP_HOST]"."$string"."links_"."$category_id"."_"."$page".".html";
} else {
$link_place = "http://"."$_SERVER[HTTP_HOST]"."$string"."index.php?category=$category_id"."&page=$page";
}

// ������ ������ ������ (�11)
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$subject = file("letters/s11.txt");
$message = file("letters/m11.txt");
$letter_swith = file("letters/w11.txt"); 
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
$message = str_replace(ADM_COMMENT, $admin_comment, "$message");
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

$headmail = "From:$_SESSION[adm_e_mail]\n";
$headmail .= "MIME-Version: 1.0\n";
$headmail .= "Content-Type: text/plain; charset=$charset\n";
$headmail .= "Content-Transfer-Encoding: 8bit\n\n";
mail($mail, "$subject", "$message", "$headmail");
}
// ���������� ������, ���� ����

}
// -----------------------------------------------------------------------------
// ���� ������ �� ���� (2 ��������: �������� ��� ��� ���������)

} // end if ������ ���������/����

echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=$_POST[backward]'>
	  </HEAD></HTML>";
exit();


} // ����� ���� ������ ���

} // ����� ���������  IF
// *******************************************************************************
// ����������� ������, ������� �������
// *******************************************************************************
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

if(count($add_err)!=0) { 
echo "<table width=100% cellspacing=0 cellpadding=0>
      <tr><td align=right valign=top width=1px><img src=images/login_lu.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_ru.gif width=8 height=8 border=0></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td class=title bgcolor=#8f95ac align=left colspan=2><font color=red>������ �������������� ������:</font><br><br></td><td bgcolor=#8f95ac width=1px></td></tr>";

if ($add_err['check_in_url']) { echo "<tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left valign=top colspan=2><font color=red>"."$add_err[check_in_url]"."</font></td><td bgcolor=#8f95ac width=1px></td></tr>"; }
if ($add_err['check_user_mail']) { echo "<tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left valign=top colspan=2><font color=red>"."$add_err[check_user_mail]"."</font></td><td bgcolor=#8f95ac width=1px></td></tr>"; }
if ($add_err['empty_category']) { echo "<tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left valign=top colspan=2><font color=red>"."$add_err[empty_category]"."</font></td><td bgcolor=#8f95ac width=1px></td></tr>"; }
if ($add_err['check_img_flash']) { echo "<tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left valign=top colspan=2><font color=red>"."$add_err[check_img_flash]"."</font></td><td bgcolor=#8f95ac width=1px></td></tr>"; }
if ($add_err['check_a_eqv_img']) { echo "<tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left valign=top colspan=2><font color=red>"."$add_err[check_a_eqv_img]"."</font></td><td bgcolor=#8f95ac width=1px></td></tr>"; }
if ($add_err['check_img_a']) { echo "<tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left valign=top colspan=2><font color=red>"."$add_err[check_img_a]"."</font></td><td bgcolor=#8f95ac width=1px></td></tr>"; }
if ($add_err['check_img_size']) { echo "<tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left valign=top colspan=2><font color=red>"."$add_err[check_img_size]"."</font></td><td bgcolor=#8f95ac width=1px></td></tr>"; }
if ($add_err['check_a_eqv_text']) { echo "<tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left valign=top colspan=2><font color=red>"."$add_err[check_a_eqv_text]"."</font></td><td bgcolor=#8f95ac width=1px></td></tr>"; }
if ($add_err['check_symbol_code']) { echo "<tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left valign=top colspan=2><font color=red>"."$add_err[check_symbol_code]"."</font></td><td bgcolor=#8f95ac width=1px></td></tr>"; }
if ($add_err['check_links_code']) { echo "<tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left valign=top colspan=2><font color=red>"."$add_err[check_links_code]"."</font></td><td bgcolor=#8f95ac width=1px></td></tr>"; }
if ($add_err['check_domen_domen']) { echo "<tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left valign=top colspan=2><font color=red>"."$add_err[check_domen_domen]"."</font></td><td bgcolor=#8f95ac width=1px></td></tr>"; }
if ($add_err['check_myhome_domen']) { echo "<tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left valign=top colspan=2><font color=red>"."$add_err[check_myhome_domen]"."</font></td><td bgcolor=#8f95ac width=1px></td></tr>"; }
if ($add_err['empty_htmltext']) { echo "<tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left valign=top colspan=2><font color=red>"."$add_err[empty_htmltext]"."</font></td><td bgcolor=#8f95ac width=1px></td></tr>"; }

echo "<tr><td align=right valign=top width=1px><img src=images/login_ld.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_rd.gif width=8 height=8 border=0></td></tr>
      </table><br>";
         }

echo "<form action="."$_SERVER[PHP_SELF]"." method=POST><table width=100% cellspacing=0 cellpadding=0>
      <tr><td align=right valign=top width=1px><img src=images/login_lu.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_ru.gif width=8 height=8 border=0></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td class=title bgcolor=#8f95ac align=left colspan=2>�������������� ������<br><br></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left nowrap width=1% valign=top>URL ������</td><td bgcolor=#8f95ac align=right><input name=urlink type=text size=24 maxlength=255 value=\""."$urlink"."\" style=\"width: 450px;\"></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left nowrap width=1% valign=top>Nick name</td><td bgcolor=#8f95ac align=right><input name=nick type=text size=24 maxlength=255 value=\""."$nick"."\" style=\"width: 450px;\"></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left nowrap width=1% valign=top>E-mail</td><td bgcolor=#8f95ac align=right><input name=mail type=text size=24 maxlength=255 value=\""."$mail"."\" style=\"width: 450px;\"></td><td bgcolor=#8f95ac width=1px></td></tr>";
if($flag=="b") { echo "<tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left valign=top colspan=2><font color=red><b>��������! ��� ������ ����� ���������� ����� � ����. ��� ��������� ��������� ���� ����� ���������. ���������, �������� �� �������������� �������� ������ ��� ����� ������ ��� �� �������� ��������� ������ �������� �� ��������� ������ ������ � ����� ��������.</b></font></td><td bgcolor=#8f95ac width=1px></td></tr>"; }
echo "<tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left nowrap width=1% valign=top>���������</td><td bgcolor=#8f95ac align=right>";

$all_categories = count($categories);
// ���������� �� �������� ---------------------------------------
for($h=0;$h<$all_categories;$h++) { // ����� ���� ��� ����������
list($id_category,$category_name,$category_keywords,$category_description) = explode("|", $categories[$h]);
$tmp[$h] = array (field => $category_name, ext1 => $id_category, ext2 => "$category_keywords|$category_description");
}
sort($tmp, SORT_REGULAR); // ����������
for($h=0;$h<count($tmp);$h++) { // �������� ���������������� �������
$categories[$h] = ("{$tmp[$h][ext1]}"."|"."{$tmp[$h][field]}"."|"."{$tmp[$h][ext2]}");
}
// ���������� �� �������� ---------------------------------------

         echo "<select name=category style=\"width: 450px;\"><option>$category</option>";
	     // ������ ���������
         for($k=0; $k<count($categories); $k++){
         $row = explode("|", $categories[$k]);
         echo "<option>"."$row[1]"."</option>";
         }
         echo "</select></td><td bgcolor=#8f95ac width=1px></td></tr>";	  

echo "<input name=id type=hidden value='$id'>
      <input name=check_date type=hidden value='$check_date'>
      <input name=check_result type=hidden value='$check_result'>
      <input name=check_out_links type=hidden value='$check_out_links'>
      <input name=check_cy type=hidden value='$check_cy'>
      <input name=check_pr type=hidden value='$check_pr'>
      <input name=check_pr_main type=hidden value='$check_pr_main'>
      <input name=check_tag_noindex type=hidden value='$check_tag_noindex'>
      <input name=check_meta_robots type=hidden value='$check_meta_robots'>
      <input name=check_file_robots type=hidden value='$check_file_robots'>
      <input name=status type=hidden value='$status'>
      <input name=ip_user type=hidden value='$ip_user'>
      <input name=old_category type=hidden value='$category'>
      <input name=backward type=hidden value='$backward'>";
	  
echo "<tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left nowrap width=1% valign=top>����� ������</td><td bgcolor=#8f95ac align=right><textarea name=htmltext rows=4 cols=48 style=\"width: 450px;\">"."$htmltext"."</textarea></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left nowrap width=1% valign=top>��������</td><td bgcolor=#8f95ac align=right><textarea name=htmlimage rows=4 cols=48 style=\"width: 450px;\">"."$htmlimage"."</textarea></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left nowrap width=1% valign=top>�����������</td><td bgcolor=#8f95ac align=right><textarea name=admin_comment rows=4 cols=48 style=\"width: 450px;\">"."$admin_comment"."</textarea></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=right valign=top colspan=2>��������� ������� ����������� ������? <input type=checkbox name=\"check_size\" checked></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=center colspan=2 valign=top><input name=\"edit_yes\" type=\"submit\" value=\"�������������\" style=\"width: 150px;\"><input name=\"edit_no\" type=\"submit\" value=\"���������\" style=\"width: 150px;\"></td><td bgcolor=#8f95ac width=1px></td></tr>
	  <tr><td align=right valign=top width=1px><img src=images/login_ld.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_rd.gif width=8 height=8 border=0></td></tr>
      </table></form><br>";
// ---------------------------------------------------------------------------------------------------------------------------------
// ������ ������� ��� ������
echo "</td><td valign=top align=right>"; // ������ ������ � ������

echo "<table width=360 cellspacing=0 cellpadding=0>
      <tr><td align=right valign=top width=1px><img src=images/login_lu.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_ru.gif width=8 height=8 border=0></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td class=title bgcolor=#8f95ac align=right colspan=2>Help</td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2>";
	  
echo "<div align=justify>
<font face=Verdana size=1 color=white><b>�������������� ������</b></font><br>
�� ������ ������������� ����� ������ � ������, ������������ � ����� �����. �������� ���������� ������ �������������� �� ���� �� ���������, ��� � ��� ���������� ������.
</div>";
echo "<div align=justify>
<font face=Verdana size=1 color=red><br><b>< �������� �������� ></b></font><br>
���� ������ ��������� � ���� � ��� ����� ���������� �����, �� ��� ��������� �� ���������, ���������� ����� ����������� ������ ������ � ����� ��������. �� �������� ��������� ������ �������� �� ������! ���������, �������� �� �������������� �������� ������ �� ���� ������ � ������� \"������� �����\"!<br><br>
</div>";

echo "</td><td bgcolor=#8f95ac width=1px></td></tr>
	  <tr><td align=right valign=top width=1px><img src=images/login_ld.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_rd.gif width=8 height=8 border=0></td></tr>
      </table>";

echo "</td></tr></table>";


@ignore_user_abort($old_abort);
?>
</body>
</html>