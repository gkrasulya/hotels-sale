<?php
error_reporting(0);
@$old_abort = ignore_user_abort(true);
session_start();

// -------------------------------------------------------------------------------
include("admin/functions/cut.php");
include("admin/functions/check.php");
include("admin/functions/main.php");

// *******************************************************************************
// �������� ������ �� ������ �������� � �������, ����� ������� ��������� � ����
// *******************************************************************************
$lock = fopen("admin/data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$cnf_imp_array = file("admin/config/cnfimp.dat");
$cnf_visual_array = file("admin/config/cnfvisual.dat");
$cnf_checkinfo_array = file("admin/config/cnfcheckinfo.dat");
$cnf_adm_array = file("admin/config/cnfadm.dat");
$base_array = file("admin/data/base.dat");
$moder_array = file("admin/data/moder.dat");
$trash_array = file("admin/data/trash.dat");
$black_array = file("admin/data/black.dat");
$freehosting_array = file("admin/data/hosting.dat");
$categories_array = file("admin/data/categories.dat");
$codes_array = file("admin/data/myhtml.dat");
$rules_array = file("admin/data/rules.dat");
flock($lock, LOCK_UN);
fclose($lock);
} else {
$_SESSION['error'] = "Cannot block the user file admin/data/base.lck !!!";
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=error.php'>
	  </HEAD></HTML>";
exit();
}
// *******************************************************************************
// �������� ������ �� ������ �������� � �������, ����� ������� ��������� � ����
// *******************************************************************************
// *******************************************************************************
// ������ ��������� � ������
// *******************************************************************************
$row_cnf_visual = explode("|", $cnf_visual_array[0]);
$row_cnf_imp = explode("|", $cnf_imp_array[0]);
$row_cnf_checkinfo = explode("|", $cnf_checkinfo_array[0]);
$row_cnf_adm = explode("|", $cnf_adm_array[0]);

if(!isset($_SESSION['vis_show_form'])) { $_SESSION['vis_show_form'] = trim($row_cnf_visual[11]); }
if(!isset($_SESSION['vis_show_codes'])) { $_SESSION['vis_show_codes'] = trim($row_cnf_visual[12]); }
if(!isset($_SESSION['vis_show_rules'])) { $_SESSION['vis_show_rules'] = trim($row_cnf_visual[13]); }
if(!isset($_SESSION['vis_show_mailtoadmin'])) { $_SESSION['vis_show_mailtoadmin'] = trim($row_cnf_visual[14]); }
if(!isset($_SESSION['vis_shuffle_codes'])) { $_SESSION['vis_shuffle_codes'] = trim($row_cnf_visual[16]); }
if(!isset($_SESSION['vis_codes_qnt'])) { $_SESSION['vis_codes_qnt'] = trim($row_cnf_visual[18]); }
if(!isset($_SESSION['vis_show_guard'])) { $_SESSION['vis_show_guard'] = trim($row_cnf_visual[19]); }
if(!isset($_SESSION['vis_user_lang'])) { $_SESSION['vis_user_lang'] = trim($row_cnf_visual[21]); }

if(!isset($_SESSION['imp_myhome'])) { $_SESSION['imp_myhome'] = trim($row_cnf_imp[0]); }
if(!isset($_SESSION['imp_mode_url'])) { $_SESSION['imp_mode_url'] = trim($row_cnf_imp[1]); }
if(!isset($_SESSION['imp_links_page'])) { $_SESSION['imp_links_page'] = trim($row_cnf_imp[2]); }

if(!isset($_SESSION['adm_in_mail'])) { $_SESSION['adm_in_mail'] = trim($row_cnf_adm[1]); } // ��������� ����� �� ������� ������
if(!isset($_SESSION['adm_out_mail'])) { $_SESSION['adm_out_mail'] = trim($row_cnf_adm[2]); } // ��������� ����� �� ������� �������������
if(!isset($_SESSION['adm_e_mail'])) { $_SESSION['adm_e_mail'] = trim($row_cnf_adm[3]); } // ����� ������

if(!isset($_SESSION['chkinfo_urlink'])) { $_SESSION['chkinfo_urlink'] = trim($row_cnf_checkinfo[0]); } // ��������� ������� �������� ������
if(!isset($_SESSION['chkinfo_cy'])) { $_SESSION['chkinfo_cy'] = trim($row_cnf_checkinfo[1]); } // ��������� CY
if(!isset($_SESSION['chkinfo_pr'])) { $_SESSION['chkinfo_pr'] = trim($row_cnf_checkinfo[2]); } // ��������� PR
if(!isset($_SESSION['chkinfo_out_links'])) { $_SESSION['chkinfo_out_links'] = trim($row_cnf_checkinfo[3]); } // ���������� ������ �� ����������� ��������
if(!isset($_SESSION['chkinfo_tag_noindex'])) { $_SESSION['chkinfo_tag_noindex'] = trim($row_cnf_checkinfo[4]); } // ���� �������
if(!isset($_SESSION['chkinfo_meta_robots'])) { $_SESSION['chkinfo_meta_robots'] = trim($row_cnf_checkinfo[5]); } // ������� ������
if(!isset($_SESSION['chkinfo_file_robots'])) { $_SESSION['chkinfo_file_robots'] = trim($row_cnf_checkinfo[6]); } // ���� ������
if(!isset($_SESSION['chkinfo_links_code'])) { $_SESSION['chkinfo_links_code'] = trim($row_cnf_checkinfo[7]); } // ������ � �������������� ����
if(!isset($_SESSION['chkinfo_symbol_code'])) { $_SESSION['chkinfo_symbol_code'] = trim($row_cnf_checkinfo[8]); } // �������� � ����
if(!isset($_SESSION['chkinfo_domen_domen'])) { $_SESSION['chkinfo_domen_domen'] = trim($row_cnf_checkinfo[9]); } // ������ � �������������� ����
if(!isset($_SESSION['chkinfo_myhome_domen'])) { $_SESSION['chkinfo_myhome_domen'] = trim($row_cnf_checkinfo[10]); } // ����� ���� ���������=������ ������ ���������
if(!isset($_SESSION['chkinfo_free_hosting'])) { $_SESSION['chkinfo_free_hosting'] = trim($row_cnf_checkinfo[11]); } // ���������� ��������
if(!isset($_SESSION['chkinfo_moder'])) { $_SESSION['chkinfo_moder'] = trim($row_cnf_checkinfo[12]); } // �� ��������� ��� ����� � �������
if(!isset($_SESSION['chkinfo_tags_p'])) { $_SESSION['chkinfo_tags_p'] = trim($row_cnf_checkinfo[13]); } //
if(!isset($_SESSION['chkinfo_tags_br'])) { $_SESSION['chkinfo_tags_br'] = trim($row_cnf_checkinfo[14]); } //
if(!isset($_SESSION['chkinfo_tags_i'])) { $_SESSION['chkinfo_tags_i'] = trim($row_cnf_checkinfo[15]); } //
if(!isset($_SESSION['chkinfo_tags_u'])) { $_SESSION['chkinfo_tags_u'] = trim($row_cnf_checkinfo[16]); } //
if(!isset($_SESSION['chkinfo_tags_b'])) { $_SESSION['chkinfo_tags_b'] = trim($row_cnf_checkinfo[17]); } //
if(!isset($_SESSION['chkinfo_tags_strong'])) { $_SESSION['chkinfo_tags_strong'] = trim($row_cnf_checkinfo[18]); } //
if(!isset($_SESSION['chkinfo_tags_font'])) { $_SESSION['chkinfo_tags_font'] = trim($row_cnf_checkinfo[19]); } //
if(!isset($_SESSION['chkinfo_tags_flash'])) { $_SESSION['chkinfo_tags_flash'] = trim($row_cnf_checkinfo[20]); } //
if(!isset($_SESSION['chkinfo_count_links'])) { $_SESSION['chkinfo_count_links'] = trim($row_cnf_checkinfo[21]); } // ��� ������� ������
// *******************************************************************************
// ������ ��������� � ������
// *******************************************************************************

// *******************************************************************************
// ���� �������� ������ - �������� ��������
// *******************************************************************************
if($_POST['submit_link']) {
	
unset($_SESSION['end_post']); // ������� �� ������ ���������� ����

$_SESSION['nick'] = Cut_All_All($_POST['nick']); 
if(empty($_SESSION['nick'])) {
if($_SESSION['vis_user_lang']=="eng") {$form_err['nick'] = "You did not identify yourself!";} else {$form_err['nick'] = "�� �� �������������!";}
}

if($_SESSION['chkinfo_urlink']=="��") {
$_SESSION['urlink'] = Check_In_Url($_POST['urlink']);
if($_SESSION['urlink']=="badly") {
if($_SESSION['vis_user_lang']=="eng") {$form_err['urlink'] = "Error in the RECIPROCAL LINK field!";} else {$form_err['urlink'] = "������ ��� ���������� ���� �������� ������!";}
} else {
$url = parse_url($_SESSION['urlink']);
$url = $url[host];
}
} else {
$_SESSION['urlink'] = Check_In_Url($_POST['urlink']);
if($_SESSION['urlink']=="badly") {
if($_SESSION['vis_user_lang']=="eng") {$form_err['urlink'] = "Simply add the <b>address of your server</b> (starting with http://)";} else {$form_err['urlink'] = "������ ������� <b>����� ������ �������</b>, ������� � http://";}
} else {
$url = parse_url($_SESSION['urlink']);
$url = $url[host];
}
}

$_SESSION['mail'] = Check_User_Mail($_POST['mail']);
if($_SESSION['mail']=="badly") {
if($_SESSION['vis_user_lang']=="eng") {$form_err['mail'] = "Error in the EMAIL field!";} else {$form_err['mail'] = "������ ��� ���������� ���� ����������� �����!";}
}
if(empty($_POST['category'])) {
if($_SESSION['vis_user_lang']=="eng") {$form_err['category'] = "Please chose category!";} else {$form_err['category'] = "�� ������� ���������!";}
}
// �������� �� ������������ ����������
$chk_ctg = "0";
for($ctg=0;$ctg<count($categories_array);$ctg++) {
$row_ctg = explode("|", $categories_array[$ctg]);
if($row_ctg[1]==$_POST['category']) { $_SESSION['category'] = "$row_ctg[1]"; $chk_ctg = "1"; break;}
}
if($chk_ctg!=1) {
if($_SESSION['vis_user_lang']=="eng") {$form_err['category'] = "Please chose category!";} else {$form_err['category'] = "�� ������� ���������!";}
}

// -------------- �������� ��� �����-1 -------------------------------------------
if($_SESSION['vis_show_form']=="�����-1") {
$host = "http://"."$url"; //  ���������� url �������� ������
// �������� - �������� ��������� ������
if(!empty($_POST['htmltext'])) {
$_SESSION['htmltext'] = Cut_All_Exc($_POST['htmltext']); // ����� ��� ������, ����� �������
$_SESSION['htmltext'] = Cut_Tags_Img($_SESSION['htmltext']);
$_SESSION['htmltext'] = Cut_Tags_Flash($_SESSION['htmltext']);
if($_SESSION['chkinfo_tags_b']=="���") { $_SESSION['htmltext'] = Cut_Tags_B($_SESSION['htmltext']); }
if($_SESSION['chkinfo_tags_br']=="���") { $_SESSION['htmltext'] = Cut_Tags_Br($_SESSION['htmltext']); }
if($_SESSION['chkinfo_tags_font']=="���") { $_SESSION['htmltext'] = Cut_Tags_Font($_SESSION['htmltext']); }
if($_SESSION['chkinfo_tags_i']=="���") { $_SESSION['htmltext'] = Cut_Tags_I($_SESSION['htmltext']); }
if($_SESSION['chkinfo_tags_p']=="���") { $_SESSION['htmltext'] = Cut_Tags_P($_SESSION['htmltext']); }
if($_SESSION['chkinfo_tags_strong']=="���") { $_SESSION['htmltext'] = Cut_Tags_Strong($_SESSION['htmltext']); }
if($_SESSION['chkinfo_tags_u']=="���") { $_SESSION['htmltext'] = Cut_Tags_U($_SESSION['htmltext']); }

// ����������� � ����������� � ������ ���� �����
$form_err['check_a_eqv_text'] = Check_A_Eqv($_SESSION['htmltext']);
if($form_err['check_a_eqv_text']=="OK") { unset($form_err['check_a_eqv_text']); }
// �������� ���������� �������� � ����
$form_err['check_symbol_code'] = Check_Symbol_Code($_SESSION['htmltext'],$_SESSION['chkinfo_symbol_code']);
if($form_err['check_symbol_code']=="OK") { unset($form_err['check_symbol_code']); }
// �������� ���������� ������ � ����
$form_err['check_links_code'] = Check_Links_Code($_SESSION['htmltext'],$_SESSION['chkinfo_links_code']);
if($form_err['check_links_code']=="OK") { unset($form_err['check_links_code']); }

// �������� �� �� ������ � ����, ������ ���� ��� ������ � �������������� ���� ������ ��������� �� ���� � ��� �� �����
// � ��������� ���������� �������������� �����
if($_SESSION['chkinfo_domen_domen']=="��" AND $_SESSION['chkinfo_links_code']>1) {
$form_err['check_domen_domen'] = Check_Domen_Domen($_SESSION['htmltext'],$_SESSION['chkinfo_links_code']);
if($form_err['check_domen_domen']=="OK") { unset($form_err['check_domen_domen']); }
}
// �������� ��� �� ����� � ����, ������ ���� ��� ������ � ���� ������ ��������������� ������ ������
if($_SESSION['chkinfo_myhome_domen']=="��" AND $_SESSION['urlink']!="badly") {
$form_err['check_myhome_domen'] = Check_Myhome_Domen($_SESSION['htmltext'],$host);
if($form_err['check_myhome_domen']=="OK") { unset($form_err['check_myhome_domen']); }
}

} else {
if($_SESSION['vis_user_lang']=="eng") {$form_err['empty_htmltext'] = "Text link field is not filled in<br>Please fill in the TEXT LINK field!";} else {$form_err['empty_htmltext'] = "�� ��������� ���� ��������� ������!";}
}
// �������� - �������� ��������� ������
// �������� - �������� ����������� ������
if(!empty($_POST['htmlimage'])) {

$_SESSION['htmlimage'] = Cut_All_Exc($_POST['htmlimage']); // ����� ��� ������, ����� �������

// �������� ���� ���� ��� �������� ��� ������
$form_err['check_img_flash'] = Check_Img_Flash($_SESSION['htmlimage'],$host);
if($form_err['check_img_flash']=="OK") { unset($form_err['check_img_flash']); }

// ����������� � ����������� � ������ ���� �����
$form_err['check_a_eqv_img'] = Check_A_Eqv($_SESSION['htmlimage']);
if($form_err['check_a_eqv_img']=="OK") { unset($form_err['check_a_eqv_img']); }

// ���� ���� ��� � - �� ������ ��������� ���� ��, ��� ����� �������� ������
if($_SESSION['chkinfo_myhome_domen']=="��" AND $_SESSION['urlink']!="badly") { // ������ ���� �� ��������� ������ ������
$form_err['check_img_a'] = Check_Img_A($_SESSION['htmlimage'],$host);
if($form_err['check_img_a']=="OK") { unset($form_err['check_img_a']); }
}

// ��������� ������ � ������ ����������� ������
$form_err['check_img_size'] = Check_Img_Size($_SESSION['htmlimage']);
if($form_err['check_img_size']=="OK") { unset($form_err['check_img_size']); }

// ���� ���� IMG - �� ������ ���� ������ �� ����� � ����� ������ a � img - �������� ������
$_SESSION['htmlimage'] = Cut_Img_Notext($_SESSION['htmlimage']);
// ���� ���� IMG - �������� � ����� ������ ������� ��� ����, ������� ����� ���� ���������
$temp = strtolower($_SESSION['htmlimage']);
$count_img = substr_count($temp, "<img");

if($count_img > 0) {
$_SESSION['htmlimage'] = Cut_Tags_B($_SESSION['htmlimage']);
$_SESSION['htmlimage'] = Cut_Tags_Br($_SESSION['htmlimage']);
$_SESSION['htmlimage'] = Cut_Tags_Font($_SESSION['htmlimage']);
$_SESSION['htmlimage'] = Cut_Tags_I($_SESSION['htmlimage']);
$_SESSION['htmlimage'] = Cut_Tags_P($_SESSION['htmlimage']);
$_SESSION['htmlimage'] = Cut_Tags_Strong($_SESSION['htmlimage']);
$_SESSION['htmlimage'] = Cut_Tags_U($_SESSION['htmlimage']);
$_SESSION['htmlimage'] = Cut_Tags_Flash($_SESSION['htmlimage']);
} else {
unset($_SESSION['htmlimage']);
}

}
// �������� - �������� ����������� ������
}
// -------------- �������� ��� �����-1 -------------------------------------------
// -------------- �������� ��� �����-2 -------------------------------------------
if($_SESSION['vis_show_form']=="�����-2") {

$_SESSION['htmltext'] = Cut_All_All($_POST['htmltext']);
if(empty($_SESSION['htmltext'])) {
if($_SESSION['vis_user_lang']=="eng") {$form_err['htmltext'] = "TEXT LINK field is empty!";} else {$form_err['htmltext'] = "������ ���� �������� ��������� ������!";}
} else {
$alt = $_SESSION['htmltext'];
$_SESSION['htmltext_pre'] = "<a href=http://"."$url"." target=_blank>"."$_SESSION[htmltext]"."</a>";
unset($form_err['htmltext']);
}
if(!empty($_POST['htmlimage'])) {
$_SESSION['htmlimage'] = Check_In_Url($_POST['htmlimage']);
if($_SESSION['htmlimage']=="badly") {
if($_SESSION['vis_user_lang']=="eng") {$form_err['htmlimage'] = "Error in GRAPHIC LINK field!";} else {$form_err['htmlimage'] = "������ ���������� ���� ������ ����������� ������!";}
} else {
$_SESSION['htmlimage_pre'] = "<a href=http://"."$url"." target=_blank>"."<img src="."$_SESSION[htmlimage]"." width=88 height=31 border=0 alt=\""."$alt"."\"></a>";
unset($form_err['htmlimage']);
}
} else { unset($_SESSION['htmlimage']); unset($_SESSION['banner']); unset($_SESSION['htmlimage_pre']); }

}
// -------------- �������� ��� �����-2 -------------------------------------------
$count_form_err = count($form_err);

// -------------- ��������� ������, ���� ������ ���������� ����� ��� -------------
if($count_form_err==0) {

// �������� ��� �� ������ ������ � ����, �� ���������, � ������� ��� ����-�����
$urlink_short_host = Short_Domen_Name($_SESSION['urlink']);
$flag_exists_link = "0"; // ������� ���� ������������� ������

// ����, ��� �� ��� ������ ������ �� ���������
if($flag_exists_link == 0) {
for($i=0;$i<count($moder_array);$i++) {
$moder_array_row = explode("|", $moder_array[$i]);
if(substr_count("$moder_array_row[2]", "http://www.") != 0) {$short_host = "http://www."."$urlink_short_host";} else {$short_host = "http://"."$urlink_short_host";}
if(preg_match ("'$short_host'si", $moder_array_row[2])) {
if($_SESSION['vis_user_lang']=="eng") {$other_err['domen_in_moder'] = "Link from domain <b>"."$urlink_short_host"."</b> is currently moderated.";} else {$other_err['domen_in_moder'] = "������ � ������ <b>"."$urlink_short_host"."</b> ��������� �� ���������.";}
break;
} else {
unset($other_err['domen_in_moder']);
}
}
}
// ����, ��� �� ��� ������ ������ � �������
if($flag_exists_link == 0) {
for($i=0;$i<count($trash_array);$i++) {
$trash_array_row = explode("|", $trash_array[$i]);
if(substr_count("$trash_array_row[2]", "http://www.") != 0) {$short_host = "http://www."."$urlink_short_host";} else {$short_host = "http://"."$urlink_short_host";}
if(preg_match ("'$short_host'si", $trash_array_row[2])) {
if($_SESSION['vis_user_lang']=="eng") {$other_err['domen_in_trash'] = "Link from domain <b>"."$urlink_short_host"."</b> is in the basket.";} else {$other_err['domen_in_trash'] = "������ � ������ <b>"."$urlink_short_host"."</b> ��������� � �������.";}
break;
} else {
unset($other_err['domen_in_trash']);
}
}
}
// ����, ��� �� ��� ������ ������ � ����-�����
if($flag_exists_link == 0) {
for($i=0;$i<count($black_array);$i++) {
$black_array_row = explode("|", $black_array[$i]);
if(substr_count("$black_array_row[2]", "http://www.") != 0) {$short_host = "http://www."."$urlink_short_host";} else {$short_host = "http://"."$urlink_short_host";}
if(preg_match ("'$short_host'si", $black_array_row[2])) {
if($_SESSION['vis_user_lang']=="eng") {$other_err['domen_in_black'] = "Link from domain <b>"."$urlink_short_host"."</b> is in the balack list.";} else {$other_err['domen_in_black'] = "������ � ������ <b>"."$urlink_short_host"."</b> ��������� � ����-�����.";}
break;
} else {
unset($other_err['domen_in_black']);
}
}
}
// ����, ��� �� ��� ������ ������ � ����
if($flag_exists_link == 0) {
$base = count($base_array);
for($i=0;$i<$base;$i++) {
$base_array_row = explode("|", $base_array[$i]);
if(substr_count("$base_array_row[2]", "http://www.") != 0) {$short_host = "http://www."."$urlink_short_host";} else {$short_host = "http://"."$urlink_short_host";}
if(preg_match ("'$short_host'si", $base_array_row[2])) {
if($_SESSION['vis_user_lang']=="eng") {$other_err['domen_in_base'] = "Link from domain <b>"."$urlink_short_host"."</b> already exists in the database!";} else {$other_err['domen_in_base'] = "������ � ������ <b>"."$urlink_short_host"."</b> ��� ���� � ����!";}
break;
} else {
unset($other_err['domen_in_base']);
}
}
}
// �������� ��� �� ������ ������ � ����, �� ���������, � ������� ��� ����-�����

// �������� �� free-hosting ���� ����
if($_SESSION['chkinfo_free_hosting']=="���") {
// ���������� urlink_short_host � ��� �������� ������
// ��������� ���������� ��������
for($i=0;$i<count($freehosting_array);$i++) {
$freehosting_array_row = explode("|", $freehosting_array[$i]);
$search_row = trim($freehosting_array_row[1]);
$row = "."."$search_row";
if(substr_count("$urlink_short_host", "$row") != 0) {
if($_SESSION['vis_user_lang']=="eng") {$other_err['domen_in_freehosting'] = "<b>"."$urlink_short_host"."</b> domain is free/forbidden hosting.";} else {$other_err['domen_in_freehosting'] = "����� <b>"."$urlink_short_host"."</b> ��������� �� ����������/����������� ��������.";}
break;
} else {
unset($other_err['domen_in_freehosting']);
}
}

} // end �������� �� free-hosting ���� ����

// �������� ������ �� ������ ���� �� ���� �� ������
$myserver = "http://"."$_SERVER[SERVER_NAME]";
$case_1 = Short_Domen_Name($myserver);
$case_2 = Short_Domen_Name($_SESSION['imp_myhome']);
if($urlink_short_host=="$case_1" || $urlink_short_host=="$case_2") {
if($_SESSION['vis_user_lang']=="eng") {$other_err['fuck'] = "This can result in black list!";} else {$other_err['fuck'] = "�� ��� ����� �������� � ����-���� �������!";}
}

}
// -------------- ��������� ������, ���� ������ ���������� ����� ��� -------------
$count_other_err = count($other_err);


// -------------- ��������� ������, ���� ��� ������ ���������� ����� � ������ ----
if($count_form_err==0 AND $count_other_err==0) {

// ������ CY
$cy_ind = "http://bar-navig.yandex.ru/u?ver=2&lang=1049&url=http://"."$url"."&target=_No__Name:5&show=1&thc=0";

// ��������� ������ �������� � ������������ � ����������� ������
$get_row_urlink = Get_Row_Urlink($_SESSION['urlink']); // �������� ������ � ����� ������

$host = "http://"."$url"; //  ���������� url �������� ������
$_SESSION['check_pr_main'] = Get_PR_Google($host); // PR Google ��� ������� �������� � ����� ������

if($_SESSION['chkinfo_urlink']=="��") { // ������� �������� ������ ���������, ���� ��� �����
$_SESSION['check_result'] = Check_My_Link($get_row_urlink, $_SESSION['imp_myhome']); // �������� ������� �������� ������
if($_SESSION['check_result']=="badly") {
if($_SESSION['vis_user_lang']=="eng") {$check_err['check_result'] = "Reciprocal link is incorrect<br>or not found at specified address!";} else {$check_err['check_result'] = "�������� ������ �� ���������� �� ���������� ������<br>��� �������� ������ �����������!";}
} else { $_SESSION['check_result'] = "well"; unset($check_err['check_result']); }
} else { $_SESSION['check_result'] = "none"; unset($check_err['check_result']); }

$old_cy = 0; // ������ 0, �.�. ��� ������ ���� ����������
$_SESSION['check_cy'] = Get_CY_Yandex($_SESSION['urlink'], $old_cy); // �������� CY Yandex
if($_SESSION['chkinfo_cy'] > 0 AND $_SESSION['chkinfo_urlink']=="��") { // ��������� ������ ���� ����� CY ������ 0
if($_SESSION['check_cy'] < $_SESSION['chkinfo_cy']) {
if($_SESSION['vis_user_lang']=="eng") {$check_err['check_cy'] = "Yandex CY of no less than <b>"."$_SESSION[chkinfo_cy]"."</b> is needed to add,<br>Yandex CY of your site is defined as <b>"."$_SESSION[check_cy]"."</b>!<br><i><a href=\""."$cy_ind"."\" target=\"_blank\">You can check CY here</a>";} else {$check_err['check_cy'] = "��� ���������� ��������� CY ������� �� ����� <b>"."$_SESSION[chkinfo_cy]"."</b>,<br>CY ������� ������ ����� ��������� ��� <b>"."$_SESSION[check_cy]"."</b>!<br><i><a href=\""."$cy_ind"."\" target=\"_blank\">�� ������ ��������� CY �����.</a></i><br>";}
} else { unset($check_err['check_cy']); }
}


$check_robots_array = Check_File_Robots($_SESSION['urlink']); // ��������� ���� robots.txt
$_SESSION['check_file_robots'] = "$check_robots_array[0]";
if($_SESSION['chkinfo_file_robots']=="��" AND $_SESSION['chkinfo_urlink']=="��") {
if($_SESSION['check_file_robots']=="badly") {
if($_SESSION['vis_user_lang']=="eng") {$check_err['check_file_robots'] = "You placed our link on the page<br>forbidden for indexation by the robots.txt file!";} else {$check_err['check_file_robots'] = "�� ���������� ���� ������ �� ��������,<br>����������� � ���������� ������ robots.txt!";}
} else { $_SESSION['check_file_robots'] = "well"; unset($check_err['check_file_robots']); }
} else { $_SESSION['check_file_robots'] = "none"; unset($check_err['check_file_robots']); }

$_SESSION['check_meta_robots'] = Check_Meta_Tag($_SESSION['urlink']); // ��������� �������� robots
if($_SESSION['chkinfo_meta_robots']=="��" AND $_SESSION['chkinfo_urlink']=="��") {
if($_SESSION['check_meta_robots']=="badly") {
if($_SESSION['vis_user_lang']=="eng") {$check_err['check_meta_robots'] = "You placed our link on the page<br>forbidden for indexation by the robots meta-tag!";} else {$check_err['check_meta_robots'] = "�� ���������� ���� ������ �� ��������,<br>����������� � ���������� ��������� robots!";}
} else { $_SESSION['check_meta_robots'] = "well"; unset($check_err['check_meta_robots']); }
} else { $_SESSION['check_meta_robots'] = "none"; unset($check_err['check_meta_robots']); }

$_SESSION['check_tag_noindex'] = Check_Tag_Noindex($get_row_urlink, $_SESSION['imp_myhome']); // ��������� ���� noindex
if($_SESSION['chkinfo_tag_noindex']=="��" AND $_SESSION['chkinfo_urlink']=="��") {
if($_SESSION['check_tag_noindex']=="badly") {
if($_SESSION['vis_user_lang']=="eng") {$check_err['check_tag_noindex'] = "You placed our link on the page<br>but placed it into noindex tags!";} else {$check_err['check_tag_noindex'] = "�� ���������� ���� ������ �� ��������,<br>�� ��������� �� � ���� noindex!";}
} else { $_SESSION['check_tag_noindex'] = "well"; unset($check_err['check_tag_noindex']); }
} else { $_SESSION['check_tag_noindex'] = "none"; unset($check_err['check_tag_noindex']); }

if($_SESSION['chkinfo_count_links']=="��") { // ������� ��� �������
$_SESSION['check_out_links'] = Get_Out_Links($get_row_urlink); // �������� ���������� ������
} else {
$_SESSION['check_out_links'] = Get_Out_Links2($get_row_urlink, $_SESSION['urlink']); // �������� ���������� ������
}

if($_SESSION['chkinfo_out_links'] > 0 AND $_SESSION['chkinfo_urlink']=="��") {
if($_SESSION['chkinfo_out_links'] < $_SESSION['check_out_links']) {
if($_SESSION['vis_user_lang']=="eng") {$check_err['check_out_links'] = "To add, no more than "."$_SESSION[chkinfo_out_links]"." links on the page are needed.<br>On your page "."$_SESSION[check_out_links]"." links are found!";} else {$check_err['check_out_links'] = "��� ���������� ��������� �� ����� "."$_SESSION[chkinfo_out_links]"." ������ �� ��������,<br>�� ������������ ���� �������� ���������� "."$_SESSION[check_out_links]"." ������!";}
} else { unset($check_err['check_out_links']); }
}

$_SESSION['check_pr'] = Get_PR_Google($_SESSION['urlink']); // ����� PR Google ��� �������� ������
if($_SESSION['chkinfo_pr'] > 0 AND $_SESSION['chkinfo_urlink']=="��") {
if($_SESSION['check_pr'] < $_SESSION['chkinfo_pr']) {
if($_SESSION['vis_user_lang']=="eng") {$check_err['check_pr'] = "To add, PR Google page of links no less than "."$_SESSION[chkinfo_pr]".",<br>PR Google of your links page is defined as "."$_SESSION[check_pr]"."!";} else {$check_err['check_pr'] = "��� ���������� ��������� PR Google �������� ������ �� ����� "."$_SESSION[chkinfo_pr]".",<br>PR Google ����� �������� ������ ��������� ��� "."$_SESSION[check_pr]"."!";}
} else { unset($check_err['check_pr']); }
}

} // ����� �������� ������
// -------------- ��������� ������, ���� ��� ������ ���������� ����� � ������ ----

$count_check_err = count($check_err); // � ������� ���������� ������ �������� ������

} // end POST submit_link
// *******************************************************************************
// ���� �������� ������ - �������� ��������
// *******************************************************************************

// *******************************************************************************
// � ������ ���� ��� ������ ������!
// *******************************************************************************
if($_POST['ok'] AND $_SESSION['end_post']!="sent_already") {

$_SESSION['end_post'] = "sent_already"; // ������� �� ������-�������
	
if($_SESSION['vis_show_guard']=="��") { 
$referer = getenv('HTTP_REFERER');
$site = "http://"."$_SERVER[HTTP_HOST]";
if (!ereg("^$site", $referer)) {exit();}
if($_SESSION['code']!=$_POST['code2'] || empty($_POST['code2']) || !preg_match("/\d{7}/", $_POST['code2'])) {
echo "<div><center><font color=red face=Verdana size=4><b>";
if($_SESSION['vis_user_lang']=="eng") {echo "CODE REJECTED!";} else {echo "��� �� ������!";}
echo "</b></font><br><font color=black face=Verdana size=1><a href=index.php>";
if($_SESSION['vis_user_lang']=="eng") {echo "In directory";} else {echo "� �������";}
echo "</a></font></center></div>";
unset($_SESSION['end_post']);
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='1 URL=index.php'>
	  </HEAD></HTML>";
exit();
}
}

// ������ ������ ������ �� ���������
// ���� ����������� ����� ���������� �� ���������
if($_SESSION['chkinfo_moder']=="���������") {

$lock = fopen("admin/data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$tmp=fopen("admin/data/moder.dat","a");
fputs($tmp, "$_SESSION[id]|$_SESSION[nick]|$_SESSION[urlink]|$_SESSION[mail]|$_SESSION[category]|$_SESSION[text]|$_SESSION[banner]|$_SESSION[id]|$_SESSION[check_result]|$_SESSION[check_out_links]|$_SESSION[check_cy]|$_SESSION[check_pr]|$_SESSION[check_pr_main]|$_SESSION[check_tag_noindex]|$_SESSION[check_meta_robots]|$_SESSION[check_file_robots]|moder|$_SERVER[REMOTE_ADDR]|not\r\n");
fclose($tmp);
flock($lock, LOCK_UN);
fclose($lock);
} else {
$_SESSION['error'] = "Cannot block the user file admin/data/base.lck !!!";
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=error.php'>
	  </HEAD></HTML>";
exit();
}

} // end if ���������
// -------------------------------------------------------------------------------
// ������ ������ ������ � ����
// ���� ����������� ����� ���������� � ����
if($_SESSION['chkinfo_moder']=="����������") {
$flag_record = 0;
$category_record = 0;
$lock = fopen("admin/data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$base_array=file("admin/data/base.dat");
$tmp=fopen("admin/data/tmp.dat","w");
$num = count($base_array);
for($i=0;$i<$num;$i++) {
$record=explode("|", $base_array[$i]);
// -------------------------------------------------------------------------------
if($record[4]==$_SESSION['category']) {
$category_record = $category_record + 1;

if($record[16]=="hole" AND $flag_record==0) {
fputs($tmp, "$_SESSION[id]|$_SESSION[nick]|$_SESSION[urlink]|$_SESSION[mail]|$_SESSION[category]|$_SESSION[text]|$_SESSION[banner]|$_SESSION[id]|$_SESSION[check_result]|$_SESSION[check_out_links]|$_SESSION[check_cy]|$_SESSION[check_pr]|$_SESSION[check_pr_main]|$_SESSION[check_tag_noindex]|$_SESSION[check_meta_robots]|$_SESSION[check_file_robots]|activ|$_SERVER[REMOTE_ADDR]|not\r\n");
$flag_record = 1;
$row_in_category = $category_record;
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
$tmp=fopen("admin/data/tmp.dat","a");
fputs($tmp, "$_SESSION[id]|$_SESSION[nick]|$_SESSION[urlink]|$_SESSION[mail]|$_SESSION[category]|$_SESSION[text]|$_SESSION[banner]|$_SESSION[id]|$_SESSION[check_result]|$_SESSION[check_out_links]|$_SESSION[check_cy]|$_SESSION[check_pr]|$_SESSION[check_pr_main]|$_SESSION[check_tag_noindex]|$_SESSION[check_meta_robots]|$_SESSION[check_file_robots]|activ|$_SERVER[REMOTE_ADDR]|not\r\n");
$row_in_category = $category_record + 1;
fclose($tmp);
}
// ���� ����� �� ����
unlink("admin/data/base.dat");
rename("admin/data/tmp.dat", "admin/data/base.dat");
flock($lock, LOCK_UN);
fclose($lock);
} else {
$_SESSION['error'] = "Cannot block the user file admin/data/base.lck !!!";
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=error.php'>
	  </HEAD></HTML>";
exit();
}

} // end if status = activ
// ��������� ������ ������ � ����
// -------------------------------------------------------------------------------
// ���������� ��������� ������ � ��������, ���� ����� ����� � ����
if($_SESSION['chkinfo_moder']=="����������") {
// ������ ID ���������
$num = count($categories_array);
for($i=0;$i<$num;$i++) {
$categories_array_row = explode("|", $categories_array[$i]);
if($categories_array_row[1]==$_SESSION['category']) {
$category_id = "$categories_array_row[0]";
break;
}
}
// �� ����� �������� � ���������
$page = ceil($row_in_category/$_SESSION['imp_links_page']);
// ���������� ���� (��� ��� ������ ���������)
$pos=strpos("$_SERVER[REQUEST_URI]", "submit.php");
$string=substr("$_SERVER[REQUEST_URI]", 0, $pos);
// ��������� ������ ����� ������
if($_SESSION['imp_mode_url']=="�����������") {
$link_place = "http://"."$_SERVER[HTTP_HOST]"."$string"."links_"."$category_id"."_"."$page".".html";
} else {
$link_place = "http://"."$_SERVER[HTTP_HOST]"."$string"."index.php?category="."$category_id"."&page="."$page";
}

} // -----end if status - activ----------
// -------------------------------------------------------------------------------

// ���������� ������ ������ � ������������ ���� ���������� � ���� � ������ ��������
// -------------------------------------------------------------------------------
if($_SESSION['chkinfo_moder']=="����������") {

// ������ ������ ������
$lock = fopen("admin/data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$subject_6 = file("admin/letters/s6.txt");
$message_6 = file("admin/letters/m6.txt");
$letter_swith_6 = file("admin/letters/w6.txt");
$subject_4 = file("admin/letters/s4.txt");
$message_4 = file("admin/letters/m4.txt");
$letter_swith_4 = file("admin/letters/w4.txt");
flock($lock, LOCK_UN);
fclose($lock);
} else {
$_SESSION['error'] = "Cannot block the user file admin/data/base.lck !!!";
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=error.php'>
	  </HEAD></HTML>";
exit();
}
$subject_6 = implode("",$subject_6);
$message_6 = implode("",$message_6);
$letter_swith_6 = implode("",$letter_swith_6);
$subject_4 = implode("",$subject_4);
$message_4 = implode("",$message_4);
$letter_swith_4 = implode("",$letter_swith_4);

if(trim($letter_swith_6)=="on") { // ������������ ���� � ���� - ID=6
$message_6 = str_replace(NICK_NAME, $_SESSION['nick'], "$message_6");
$message_6 = str_replace(LINK_PLACE, $link_place, "$message_6");
$message_6 = str_replace(BACK_LINK, $_SESSION['urlink'], "$message_6");
$message_6 = str_replace(OUT_LINKS, $_SESSION['check_out_links'], "$message_6");
$message_6 = str_replace(SITE_CY, $_SESSION['check_cy'], "$message_6");
$message_6 = str_replace(PAGE_PR, $_SESSION['check_pr'], "$message_6");
$message_6 = str_replace(IMP_MYHOME, $_SESSION['imp_myhome'], "$message_6");
$message_6 = str_replace(ADM_E_MAIL, $_SESSION['adm_e_mail'], "$message_6");

switch($_SESSION['adm_out_mail']) {
case "koi8-r":
$subject_6 = convert_cyr_string($subject_6, "w", "k");
$message_6 = convert_cyr_string($message_6, "w", "k");
$charset = "koi8-r";
break;
case "iso-8859":
$subject_6 = convert_cyr_string($subject_6, "w", "i");
$message_6 = convert_cyr_string($message_6, "w", "i");
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
mail($_SESSION['mail'], "$subject_6", "$message_6", "$headmail");
}
if(trim($letter_swith_4)=="on") { // ������ ���� � ���� - ID=4
$message_4 = str_replace(NICK_NAME, $_SESSION['nick'], "$message_4");
$message_4 = str_replace(LINK_PLACE, $link_place, "$message_4");
$message_4 = str_replace(BACK_LINK, $_SESSION['urlink'], "$message_4");
$message_4 = str_replace(OUT_LINKS, $_SESSION['check_out_links'], "$message_4");
$message_4 = str_replace(SITE_CY, $_SESSION['check_cy'], "$message_4");
$message_4 = str_replace(PAGE_PR, $_SESSION['check_pr'], "$message_4");
$message_4 = str_replace(IMP_MYHOME, $_SESSION['imp_myhome'], "$message_4");
$message_4 = str_replace(ADM_E_MAIL, $_SESSION['adm_e_mail'], "$message_4");

switch($_SESSION['adm_in_mail']) {
case "koi8-r":
$subject_4 = convert_cyr_string($subject_4, "w", "k");
$message_4 = convert_cyr_string($message_4, "w", "k");
$charset = "koi8-r";
break;
case "iso-8859":
$subject_4 = convert_cyr_string($subject_4, "w", "i");
$message_4 = convert_cyr_string($message_4, "w", "i");
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
mail($_SESSION['adm_e_mail'], "$subject_4", "$message_4", "$headmail");
}

} // ---end if status activ---
// -------------------------------------------------------------------------------

// ���������� ������ ������ � ������������ ���� ���������� �� ��������� � ������ ��������
// -------------------------------------------------------------------------------
if($_SESSION['chkinfo_moder']=="���������") {

// ������ ������ ������
$lock = fopen("admin/data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$subject_7 = file("admin/letters/s7.txt");
$message_7 = file("admin/letters/m7.txt");
$letter_swith_7 = file("admin/letters/w7.txt");
$subject_5 = file("admin/letters/s5.txt");
$message_5 = file("admin/letters/m5.txt");
$letter_swith_5 = file("admin/letters/w5.txt");
flock($lock, LOCK_UN);
fclose($lock);
} else {
$_SESSION['error'] = "Cannot block the user file admin/data/base.lck !!!";
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=error.php'>
	  </HEAD></HTML>";
exit();
}
$subject_7 = implode("",$subject_7);
$message_7 = implode("",$message_7);
$letter_swith_7 = implode("",$letter_swith_7);
$subject_5 = implode("",$subject_5);
$message_5 = implode("",$message_5);
$letter_swith_5 = implode("",$letter_swith_5);

if(trim($letter_swith_7)=="on") { // ������������ ���� �� ��������� - ID=7
$message_7 = str_replace(NICK_NAME, $_SESSION['nick'], "$message_7");
$message_7 = str_replace(LINK_PLACE, $link_place, "$message_7");
$message_7 = str_replace(BACK_LINK, $_SESSION['urlink'], "$message_7");
$message_7 = str_replace(OUT_LINKS, $_SESSION['check_out_links'], "$message_7");
$message_7 = str_replace(SITE_CY, $_SESSION['check_cy'], "$message_7");
$message_7 = str_replace(PAGE_PR, $_SESSION['check_pr'], "$message_7");
$message_7 = str_replace(IMP_MYHOME, $_SESSION['imp_myhome'], "$message_7");
$message_7 = str_replace(ADM_E_MAIL, $_SESSION['adm_e_mail'], "$message_7");

switch($_SESSION['adm_out_mail']) {
case "koi8-r":
$subject_7 = convert_cyr_string($subject_7, "w", "k");
$message_7 = convert_cyr_string($message_7, "w", "k");
$charset = "koi8-r";
break;
case "iso-8859":
$subject_7 = convert_cyr_string($subject_7, "w", "i");
$message_7 = convert_cyr_string($message_7, "w", "i");
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
mail($_SESSION['mail'], "$subject_7", "$message_7", "$headmail");
}
if(trim($letter_swith_5)=="on") { // ������ ���� �� ��������� - ID=5
$message_5 = str_replace(NICK_NAME, $_SESSION['nick'], "$message_5");
$message_5 = str_replace(LINK_PLACE, $link_place, "$message_5");
$message_5 = str_replace(BACK_LINK, $_SESSION['urlink'], "$message_5");
$message_5 = str_replace(OUT_LINKS, $_SESSION['check_out_links'], "$message_5");
$message_5 = str_replace(SITE_CY, $_SESSION['check_cy'], "$message_5");
$message_5 = str_replace(PAGE_PR, $_SESSION['check_pr'], "$message_5");
$message_5 = str_replace(IMP_MYHOME, $_SESSION['imp_myhome'], "$message_5");
$message_5 = str_replace(ADM_E_MAIL, $_SESSION['adm_e_mail'], "$message_5");

switch($_SESSION['adm_in_mail']) {
case "koi8-r":
$subject_5 = convert_cyr_string($subject_5, "w", "k");
$message_5 = convert_cyr_string($message_5, "w", "k");
$charset = "koi8-r";
break;
case "iso-8859":
$subject_5 = convert_cyr_string($subject_5, "w", "i");
$message_5 = convert_cyr_string($message_5, "w", "i");
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
mail($_SESSION['adm_e_mail'], "$subject_5", "$message_5", "$headmail");
}

} // ---end if status moder---
// -------------------------------------------------------------------------------

// --------- ���������� ����������� ----------------------------------------------
unset($_SESSION['id']);
unset($_SESSION['nick']);
unset($_SESSION['urlink']);
unset($_SESSION['mail']);
unset($_SESSION['category']);
unset($_SESSION['htmltext']);
unset($_SESSION['htmlimage']);
unset($_SESSION['htmltext_pre']);
unset($_SESSION['htmlimage_pre']);
unset($_SESSION['text']);
unset($_SESSION['banner']);
unset($_SESSION['check_result']);
unset($_SESSION['check_out_links']);
unset($_SESSION['check_cy']);
unset($_SESSION['check_pr']);
unset($_SESSION['check_pr_main']);
unset($_SESSION['check_tag_noindex']);
unset($_SESSION['check_meta_robots']);
unset($_SESSION['check_file_robots']);
} // end ���� ��� ������ ������
// *******************************************************************************
// � ������ ���� ��� ������ ������!
// *******************************************************************************

include "admin/design/header.inc"; // ���������� ���������
echo "<div id=LinkExchangerForm>";

// *******************************************************************************
// ���� �������� ������ ������ �� �����
// *******************************************************************************
if($_POST['submit_mailtoadmin'] AND !empty($_POST['mailtoadmin_message']) AND !empty($_POST['mailtoadmin_mail'])) {

if($_SESSION['vis_user_lang']=="eng") {$mailtoadmin_subject = "LE2: Email Administrator";} else {$mailtoadmin_subject = "LE2: ������ ��� ��������������";}
$mailtoadmin_mail = Cut_All_All($_POST['mailtoadmin_mail']);
$mailtoadmin_message = Cut_Submit_Admin_Letter($_POST['mailtoadmin_message']);

$mailtoadmin_mail = Check_User_Mail($mailtoadmin_mail);
if($mailtoadmin_mail!="badly") { // ���� e-mail ���������� - ����������

$mailtoadmin_message = "
From: "."$mailtoadmin_mail"."
-------------------------------------------------
"."$mailtoadmin_message";

if($_SESSION['adm_out_mail']=="koi8-r") { $mailtoadmin_subject = convert_cyr_string($mailtoadmin_subject, "w", "k"); $mailtoadmin_message = convert_cyr_string($mailtoadmin_message, "w", "k"); }
mail($_SESSION['adm_e_mail'], "$mailtoadmin_subject", "$mailtoadmin_message", "From:$mailtoadmin_mail\n");

echo "<div id=CardMessageUser>";
if($_SESSION['vis_user_lang']=="eng") {echo "Your email is sent to the directory administrator!<br>Thank you!<br><br><a href=index.php>In directory</a>";} else {echo "���� ������ ���������� �� e-mail �������������� ��������!<br>�������!<br><br><a href=index.php>� �������</a>";}
echo "</div>";

} else { // �� ����������
echo "<div id=CardMessageUser>";
if($_SESSION['vis_user_lang']=="eng") {echo "Your email could not be sent!<br>Error in the email address field!<br><br><a href=index.php>In directory</a>";} else {echo "���� ������ �� ���� ����������!<br>������ � ���������� ���� e-mail!<br><br><a href=index.php>� �������</a>";}
echo "</div>";
}

echo "</div>"; // �nd LinkExchanger container 
include "admin/design/footer.inc";
@ignore_user_abort($old_abort);
echo "</body></html>";
exit();
}
// *******************************************************************************
// ���� �������� ������ ������ �� �����
// *******************************************************************************

// *******************************************************************************
// ��������� � ���������� ������
// *******************************************************************************
// ������� ��������� � ����������, ���� ������ ����������� �����
if($_SESSION['chkinfo_moder']=="����������" AND $_POST['ok']) {
echo "<div id=CardMessageUser>";
if($_SESSION['vis_user_lang']=="eng") {echo "Your link is successfully added! You can find your link at:<br><a href="."$link_place".">"."$link_place"."</a><br>Thank you!<br><br><a href=index.php>In directory</a>";} else {echo "���� ������ ������� ���������! �� ���������� ����� � ��������:<br><a href="."$link_place".">"."$link_place"."</a><br>�������!<br><br><a href=index.php>� �������</a>";}
echo "</div>";
echo "</div>"; // �nd LinkExchanger container 
include "admin/design/footer.inc";
@ignore_user_abort($old_abort);
echo "</body></html>";
exit();
} // end if status = activ
// -------------------------------------------------------------------------------
// ������� ��������� � ����������, ���� ������ ����������� �� ���������
if($_SESSION['chkinfo_moder']=="���������" AND $_POST['ok']) {
echo "<div id=CardMessageUser>";
if($_SESSION['vis_user_lang']=="eng") {echo "Your link is currently moderated.<br>Permanet address will be allocated once it's added to directory<br>Thank you!<br><br><a href=index.php>In directory</a>";} else {echo "���� ������ ��������� �� ���������.<br>�� ���������� ����� ����� �������� � ������ �� ���������� � �������.<br>�������!<br><br><a href=index.php>� �������</a>";}
echo "</div>";
echo "</div>"; // �nd LinkExchanger container 
include "admin/design/footer.inc";
@ignore_user_abort($old_abort);
echo "</body></html>";
exit();
} // end if status = moder
// *******************************************************************************
// ��������� � ���������� ������
// *******************************************************************************

// *******************************************************************************
// ����� ���������������� ��������� ����, ��� ����������, ���� ��� ������
// *******************************************************************************
if($count_form_err==0 AND $count_check_err==0 AND $count_other_err==0 AND $_POST['submit_link']) {
echo "<div id=FormPreviewTitle>";
if($_SESSION['vis_user_lang']=="eng") {echo "Check your data:";} else {echo "��������� ���� ������:";}
echo "</div>";

if($_SESSION['vis_show_form']=="�����-1") { $_SESSION['banner'] = "$_SESSION[htmlimage]"; $_SESSION['text'] = "$_SESSION[htmltext]"; }
if($_SESSION['vis_show_form']=="�����-2") { $_SESSION['banner'] = "$_SESSION[htmlimage_pre]"; $_SESSION['text'] = "$_SESSION[htmltext_pre]"; }
$_SESSION['id'] = time();
$submit_date = date("Y-m-d H:i:s", "$_SESSION[id]");

if($_SESSION['vis_none_or_cy']=="������ CY �������") {
$yandex = "<a href=http://www.yandex.ru/cy?base=0&host="."$url"." target=_blank><img src=http://www.yandex.ru/cycounter?"."$url"." width=88 height=31 border=0></a>";
}

echo "<div id=CardUser><form action="."$_SERVER[PHP_SELF]"." method=\"POST\"><div id=CardTextUser>";
if($_SESSION['vis_show_button']=="��") {
if(empty($_SESSION['banner'])) {
if($_SESSION['vis_none_or_cy']=="������-��������") { echo "<img src=admin/images/notimage.gif>"."$_SESSION[text]"."</div>"; }
if($_SESSION['vis_none_or_cy']=="������ CY �������") { echo "$yandex"."$_SESSION[text]"."</div>"; }
} else { echo "$_SESSION[banner]"."$_SESSION[text]"."</div>"; }
} else { echo "$_SESSION[text]"."</div>"; }
if($_SESSION['vis_show_cy']=="��"||$_SESSION['vis_show_pr']=="��"||$_SESSION['vis_show_date']=="��") { echo "<div id=CardDataUser>"; }
if($_SESSION['vis_show_cy']=="��") { echo "<div id=CardCyUser>CY: "."$_SESSION[check_cy]"."</div>"; }
if($_SESSION['vis_show_pr']=="��") { echo "<div id=CardPrUser>PR: "."$_SESSION[check_pr_main]"."</div>"; }
if($_SESSION['vis_show_date']=="��") {
if($_SESSION['vis_user_lang']=="eng") {echo "<div id=CardTimeUser>Added: "."$submit_date"."</div>";} else {echo "<div id=CardTimeUser>���������: "."$submit_date"."</div>";}
}
if($_SESSION['vis_show_cy']=="��"||$_SESSION['vis_show_pr']=="��"||$_SESSION['vis_show_date']=="��") { echo "</div>"; }
if($_SESSION['vis_show_cat']=="��") {
if($_SESSION['vis_user_lang']=="eng") {echo "<div id=CardCategoryUser>Category: "."$_SESSION[category]"."</div>";} else {echo "<div id=CardCategoryUser>���������: "."$_SESSION[category]"."</div>";}
}

// ***********************************************************************************************
if($_SESSION['vis_show_guard']=="��") { 
echo "<div id=CardGuardUser><b>";
if($_SESSION['vis_user_lang']=="eng") {echo "Enter the code shown";} else {echo "������� ����������� �����";}
echo "</b><br><img src=\"admin/code.php\" width=\"100\" height=\"20\" border=\"1\"><input type=\"text\" name=\"code2\" value=\"\"></div>";
}
// ***********************************************************************************************

if($_SESSION['vis_user_lang']=="eng") {echo "<input id=FormButton name=\"ok\" type=\"submit\" value=\"OK - save!\">";} else {echo "<input id=FormButton name=\"ok\" type=\"submit\" value=\"�� - ��������!\">";}
echo "</form><div id=CardMessageUser>";
if($_SESSION['vis_user_lang']=="eng") {echo "If some data are incorrect, please amend them and click [Add/Change] at the end of the form. If OK, please enter control number and click [OK - save!]";} else {echo "���� �����-�� ������ ��������� ������������� - ��������� �� � ����� ������� ������ [��������/���������] ����� �����. ���� ��� ����� - ������� ����������� ����� � ������� [�� - ��������!]";}
echo "</div></div>";

}
// *******************************************************************************
// ����� ���������������� ��������� ����, ��� ����������, ���� ��� ������
// *******************************************************************************

// *******************************************************************************
// -------- ����� �� ����� ������ ���������� ��� ��������, ���� ��� ���� ---------
// *******************************************************************************
if($count_form_err!=0||$count_check_err!=0||$count_other_err!=0) {
echo "<div id=FormErrorTitle>";
if($_SESSION['vis_user_lang']=="eng") {echo "Errors found";} else {echo "���������� ������:";}
echo "</div>";

// ������ ���������� �����
if(!empty($form_err['nick'])) { echo "<div id=FormErrorText>"."$form_err[nick]"."</div>"; }
if(!empty($form_err['urlink'])) { echo "<div id=FormErrorText>"."$form_err[urlink]"."</div>"; }
if(!empty($form_err['mail'])) { echo "<div id=FormErrorText>"."$form_err[mail]"."</div>"; }
if(!empty($form_err['category'])) { echo "<div id=FormErrorText>"."$form_err[category]"."</div>"; }
if(!empty($form_err['htmltext'])) { echo "<div id=FormErrorText>"."$form_err[htmltext]"."</div>"; }
if(!empty($form_err['htmlimage'])) { echo "<div id=FormErrorText>"."$form_err[htmlimage]"."</div>"; }

// ������ ��� �������� other
if(!empty($other_err['domen_in_moder'])) { echo "<div id=FormErrorText>"."$other_err[domen_in_moder]"."</div>"; }
if(!empty($other_err['domen_in_trash'])) { echo "<div id=FormErrorText>"."$other_err[domen_in_trash]"."</div>"; }
if(!empty($other_err['domen_in_black'])) { echo "<div id=FormErrorText>"."$other_err[domen_in_black]"."</div>"; }
if(!empty($other_err['domen_in_base'])) { echo "<div id=FormErrorText>"."$other_err[domen_in_base]"."</div>"; }
if(!empty($other_err['domen_in_freehosting'])) { echo "<div id=FormErrorText>"."$other_err[domen_in_freehosting]"."</div>"; }
if(!empty($other_err['fuck'])) { echo "<div id=FormErrorText>"."$other_err[fuck]"."</div>"; }

// ������ ��� �������� ��������� ������ �����-1
if(!empty($form_err['check_a_eqv_text'])) { echo "<div id=FormErrorText>"."$form_err[check_a_eqv_text]"."</div>"; }
if(!empty($form_err['check_symbol_code'])) { echo "<div id=FormErrorText>"."$form_err[check_symbol_code]"."</div>"; }
if(!empty($form_err['check_links_code'])) { echo "<div id=FormErrorText>"."$form_err[check_links_code]"."</div>"; }
if(!empty($form_err['check_domen_domen'])) { echo "<div id=FormErrorText>"."$form_err[check_domen_domen]"."</div>"; }
if(!empty($form_err['check_myhome_domen'])) { echo "<div id=FormErrorText>"."$form_err[check_myhome_domen]"."</div>"; }
if(!empty($form_err['empty_htmltext'])) { echo "<div id=FormErrorText>"."$form_err[empty_htmltext]"."</div>"; }

// ������ ��� �������� ����������� ������ �����-1
if(!empty($form_err['check_img_flash'])) { echo "<div id=FormErrorText>"."$form_err[check_img_flash]"."</div>"; }
if(!empty($form_err['check_a_eqv_img'])) { echo "<div id=FormErrorText>"."$form_err[check_a_eqv_img]"."</div>"; }
if(!empty($form_err['check_img_a'])) { echo "<div id=FormErrorText>"."$form_err[check_img_a]"."</div>"; }
if(!empty($form_err['check_img_size'])) { echo "<div id=FormErrorText>"."$form_err[check_img_size]"."</div>"; }

// ������ ��� �������� ������
if(!empty($check_err['check_result'])) { echo "<div id=FormErrorText>"."$check_err[check_result]"."</div>"; }
if(!empty($check_err['check_cy'])) { echo "<div id=FormErrorText>"."$check_err[check_cy]"."</div>"; }
if(!empty($check_err['check_pr'])) { echo "<div id=FormErrorText>"."$check_err[check_pr]"."</div>"; }
if(!empty($check_err['check_out_links'])) { echo "<div id=FormErrorText>"."$check_err[check_out_links]"."</div>"; }
if(!empty($check_err['check_tag_noindex'])) { echo "<div id=FormErrorText>"."$check_err[check_tag_noindex]"."</div>"; }
if(!empty($check_err['check_meta_robots'])) { echo "<div id=FormErrorText>"."$check_err[check_meta_robots]"."</div>"; }
if(!empty($check_err['check_file_robots'])) { echo "<div id=FormErrorText>"."$check_err[check_file_robots]"."</div>"; }

}
// *******************************************************************************
// -------- ����� �� ����� ������ ���������� ��� ��������, ���� ��� ���� ---------
// *******************************************************************************

if($_SESSION['vis_show_form']!="���������") { // ����������, ���� �� ���������
// *******************************************************************************
// ����� ������ ������
// *******************************************************************************
echo "<form action=\"$_SERVER[PHP_SELF]\" method=\"POST\">";
// ------- ��������� ����� ���������� ������ -------------------------------------
echo "<div id=\"FormTitle\">";
if($_SESSION['vis_user_lang']=="eng") {echo "Submit link:";} else {echo "���������� ������:";}
echo "</div>";
// ------- ��������� ����� ���������� ������ -------------------------------------

// ------- ���� ����� �������� --------------------------------------------
echo "<div id=\"FormNickText\">";
if($_SESSION['vis_user_lang']=="eng") {echo "Your name or nick:";} else {echo "���� ��� ��� ���:";}
echo "<br><input id=\"FormNickInput\" name=\"nick\" type=\"text\" maxlength=\"16\" value=\""."$_SESSION[nick]"."\">";
echo "</div>";
// ------- ���� ����� �������� --------------------------------------------

// ------- ���� ����� �������� ������ --------------------------------------------
echo "<div id=\"FormReturnText\">";
if($_SESSION['chkinfo_urlink']=="��") {
if($_SESSION['vis_user_lang']=="eng") {echo "Reciprocal Link URL:";} else {echo "����� ��������, ��� ����������� �������� ������:";}
} else {
if($_SESSION['vis_user_lang']=="eng") {echo "Address of your server:";} else {echo "����� ������ �������:";}
}
echo "<br><input id=\"FormReturnInput\" name=\"urlink\" type=\"text\" maxlength=\"255\" value=\""."$_SESSION[urlink]"."\">";
echo "</div>";
// ------- ���� ����� �������� ������ --------------------------------------------

// ------- ���� ����� ������ ����������� ����� -----------------------------------
echo "<div id=\"FormMailText\">";
if($_SESSION['vis_user_lang']=="eng") {echo "Your E-mail:";} else {echo "��� ����� ����������� �����:";}
echo "<br><input id=\"FormMailInput\" name=\"mail\" type=\"text\" maxlength=\"255\" value=\""."$_SESSION[mail]"."\">";
echo "</div>";
// ------- ���� ����� ������ ����������� ����� -----------------------------------

// ------- ���������� ������ ������ ��������� ------------------------------------
$all_categories = count($categories_array);
$tmp = array();
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
echo "<div id=\"FormCategoryText\">";
if($_SESSION['vis_user_lang']=="eng") {echo "Chose your category:";} else {echo "�������� ���������� ���������:";}
echo "<br><select id=\"FormCategorySelect\" name=\"category\"><option value=\""."$_SESSION[category]"."\">"."$_SESSION[category]"."</option>";
for($i=0;$i<count($categories_array);$i++) { $row = explode("|", $categories_array[$i]); echo "<option>"."$row[1]"."</option>"; }
echo "</select>";
echo "</div>";
// ------- ���������� ������ ������ ��������� ------------------------------------

if($_SESSION['vis_show_form']=="�����-1") {
// ------- ���� ����� HTML-���� ��������� ������ ---------------------------------
echo "<div id=\"FormHtmlText\">";
if($_SESSION['vis_user_lang']=="eng") {echo "HTML code of your text link:";} else {echo "HTML-��� ����� ��������� ������:";}
echo "<br><textarea id=\"FormHtmlTextarea\" name=\"htmltext\">"."$_SESSION[htmltext]"."</textarea>";
echo "</div>";
// ------- ���� ����� HTML-���� ��������� ������ ---------------------------------

// ------- ���� ����� HTML-���� �������� -----------------------------------------
echo "<div id=\"FormImageText\">";
if($_SESSION['vis_user_lang']=="eng") {echo "HTML code of your graphic link (banner):";} else {echo "HTML-��� ������ ������������ �������:";}
echo "<br><textarea id=\"FormImageTextarea\" name=\"htmlimage\">"."$_SESSION[htmlimage]"."</textarea>";
echo "</div>";
// ------- ���� ����� HTML-���� �������� -----------------------------------------
}

if($_SESSION['vis_show_form']=="�����-2") {
// ------- ���� ����� ���������� �������� ������ ---------------------------------
echo "<div id=\"FormLinkText\">";
if($_SESSION['vis_user_lang']=="eng") {echo "Site description:";} else {echo "��������� �������� ����� ������:";}
echo "<br><textarea id=\"FormLinkTextarea\" name=\"htmltext\">"."$_SESSION[htmltext]"."</textarea>";
echo "</div>";
// ------- ���� ����� ���������� �������� ������ ---------------------------------

// ------- ���� ����� ����������� ���� � ����������� ������ ----------------------
echo "<div id=\"FormBannerText\">";
if($_SESSION['vis_user_lang']=="eng") {echo "URL of your banner:";} else {echo "���� � ������ �������:";}
echo "<br><input id=\"FormBannerInput\" name=\"htmlimage\" type=\"text\" maxlength=\"255\" value=\""."$_SESSION[htmlimage]"."\">";
echo "</div>";
// ------- ���� ����� ����������� ���� � ����������� ������ ----------------------
}

// ------- ������� ---------------------------------------------------------------
if($_SESSION['vis_user_lang']=="eng") {echo "<input id=\"FormButton\" name=\"submit_link\" type=\"submit\" value=\"Add / Edit\">";} else {echo "<input id=FormButton name=\"submit_link\" type=\"submit\" value=\"�������� / ���������\">";}
// ------- ������� ---------------------------------------------------------------
echo "</form>";
// *******************************************************************************
// ����� ������ ������
// *******************************************************************************
} // ����� if ����������, ���� �� ���������

// *******************************************************************************
// ���������� ������� ���������� � �������
// *******************************************************************************
if($_SESSION['vis_show_rules']=="��") {
$rules = implode("",$rules_array);
$rules = trim($rules);
if(!empty($rules)) {
echo "<div id=\"RulesTitle\">";
if($_SESSION['vis_user_lang']=="eng") {echo "Rules";} else {echo "������� ����������";}
echo "</div>";
echo "<div id=\"RulesShow\">"."$rules"."</div>";
}
}
// *******************************************************************************
// ���������� ������� ���������� � �������
// *******************************************************************************

// *******************************************************************************
// ���������� ���� HTML-����
// *******************************************************************************
if($_SESSION['vis_show_codes']=="��") {

if($_SESSION['vis_shuffle_codes']=="��") { // ����������, ���� ����
$numbers = range (1,20);
srand ((float)microtime()*1000000);
shuffle ($codes_array);
}

if($_SESSION['vis_codes_qnt']!="���") {
$img_array = array();
$txt_array = array();
$txt_array_cut = array();
for($i=0;$i<count($codes_array);$i++) {
$codes_array_row = explode("|", $codes_array[$i]);
if(trim($codes_array_row[2])=="IMG") {$img_array[] = "$codes_array[$i]";} else {$txt_array[] = "$codes_array[$i]";}
}

$img_num = count($img_array);
$txt_num = $_SESSION['vis_codes_qnt'] - $img_num;

for($i=0;$i<$txt_num;$i++) {$txt_array_cut[] = "$txt_array[$i]";}
unset($codes_array);
$codes_array = array_merge($img_array, $txt_array_cut);

} // end if �� ���

// �������
for($i=0;$i<count($codes_array);$i++) {
$codes_array_row = explode("|", $codes_array[$i]);
if($codes_array_row[0]) {
$codes_array_row[1] = trim($codes_array_row[1]);
echo "<div id=\"CodesShow\"><textarea>"."$codes_array_row[1]"."</textarea>"."$codes_array_row[1]"."</div>";
}
}

}
// *******************************************************************************
// ���������� ���� HTML-����
// *******************************************************************************

// *******************************************************************************
// ����� �������� ������ ������
// *******************************************************************************
if($_SESSION['vis_show_mailtoadmin']=="��") {
echo "<form action=\"$_SERVER[PHP_SELF]\" method=\"POST\">";
// -------------------------------------------------------------------------------
if($_SESSION['vis_user_lang']=="eng") {echo "<div id=\"MailToAdminTitle\">Write to administrator</div>";} else {echo "<div id=\"MailToAdminTitle\">�������� ��������������</div>";}
// -------------------------------------------------------------------------------
echo "<div id=\"MailToAdminText\">";
if($_SESSION['vis_user_lang']=="eng") {echo "Your e-mail:";} else {echo "��� e-mail:";}
echo "<br><input id=\"MailToAdminMail\" name=\"mailtoadmin_mail\" type=\"text\">";
echo "</div>";

echo "<div id=\"MailToAdminText\">";
if($_SESSION['vis_user_lang']=="eng") {echo "Message:";} else {echo "����� ������ ������:";}
echo "<br><textarea id=\"MailToAdminTextarea\" name=\"mailtoadmin_message\"></textarea>";
echo "</div>";
// -------------------------------------------------------------------------------
if($_SESSION['vis_user_lang']=="eng") {echo "<input id=\"MailToAdminButton\" name=\"submit_mailtoadmin\" type=\"submit\" value=\"Send message\">";} else {echo "<input id=\"MailToAdminButton\" name=\"submit_mailtoadmin\" type=\"submit\" value=\"��������� ������\">";}
// -------------------------------------------------------------------------------
echo "</form>";
}
// *******************************************************************************
// ����� �������� ������ ������
// *******************************************************************************
// *******************************************************************************
// ��������� � �������
// *******************************************************************************
echo "<div id=\"BackToIndex\"><a href=index.php>";
if($_SESSION['vis_user_lang']=="eng") {echo "Back to directory";} else {echo "��������� � �������";}
echo "</a></div>";
echo "<div id=\"CopyRightS\"><a href=http://www.linkexchanger.ru target=_blank>";
if($_SESSION['vis_user_lang']=="eng") {echo "Script of link catalogue LinkExchanger v2.0";} else {echo "������ �������� ������ LinkExchanger v2.0";}
echo "</a></div>";
// *******************************************************************************
// ��������� � �������
// *******************************************************************************

echo "</div><br>"; // �nd LinkExchanger container 
include "admin/design/footer.inc";
@ignore_user_abort($old_abort);
?>
</body>
</html>