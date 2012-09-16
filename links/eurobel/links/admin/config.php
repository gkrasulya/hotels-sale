<?php
error_reporting(0);
@$old_abort = ignore_user_abort(true);
session_start();
include "adminic.php";

// �������� ������� � �������������
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$cnf_imp_array = file("config/cnfimp.dat"); // ������ ���������
$cnf_adm_array = file("config/cnfadm.dat"); // ��������� ��������������
$cnf_checkinfo_array = file("config/cnfcheckinfo.dat"); // ��������� ��� �������� �������� ����������
$cnf_visual_array = file("config/cnfvisual.dat"); // ���������� ��������� ������� �������� � �����
$cnf_cron_array = file("config/cnfcron.dat"); // ���� �������� ������ ���� ��� ������� �����
flock($lock, LOCK_UN);
fclose($lock);
} else {
$_SESSION['error'] = "�� ���� ������������� ��������� ���� data/base.lck !!!";
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=error.php'>
	  </HEAD></HTML>";
exit();
}

// �������� � ������ ������ �� ������ ��������
$row_cnf_imp = explode("|", $cnf_imp_array[0]);
$_SESSION['imp_myhome'] = trim($row_cnf_imp[0]); // ���� ����
$_SESSION['imp_mode_url'] = trim($row_cnf_imp[1]); // ��� URL'�
$_SESSION['imp_links_page'] = trim($row_cnf_imp[2]); // ������ �� ���. �����

// �������� � ������ ������ �� �������� ��������������
$row_cnf_adm = explode("|", $cnf_adm_array[0]);
$_SESSION['adm_row_page'] = trim($row_cnf_adm[0]); // ������ �� ���. ������
$_SESSION['adm_in_mail'] = trim($row_cnf_adm[1]); // ��������� ����� �� ������� ������
$_SESSION['adm_out_mail'] = trim($row_cnf_adm[2]); // ��������� ����� �� ������� ������
$_SESSION['adm_e_mail'] = trim($row_cnf_adm[3]); // ����� ������
$_SESSION['adm_sort'] = trim($row_cnf_adm[4]); // ���������� �� ����������
$_SESSION['adm_old_link'] = trim($row_cnf_adm[5]); // ������ ������ ����� ������� �����
$_SESSION['adm_cy'] = trim($row_cnf_adm[6]); // ���������� ��� ������ - �� CY
$_SESSION['adm_pr'] = trim($row_cnf_adm[7]); // ���������� ��� ������ - �� PR
$_SESSION['adm_out_links'] = trim($row_cnf_adm[8]); // ���������� ��� ������ - �� ���-�� ������
$_SESSION['adm_backup_time'] = trim($row_cnf_adm[9]); // ���� � ����� ���������� BackUp'a
$_SESSION['adm_sort_select'] = trim($row_cnf_adm[10]); // ������������ ����������
$_SESSION['adm_sort_2'] = trim($row_cnf_adm[11]); // ���������� �� ��������
$_SESSION['adm_new_link'] = trim($row_cnf_adm[12]); // ����� ������ ����� ������� �����
$_SESSION['adm_need_link'] = trim($row_cnf_adm[13]); // ��������� �������� ������ ��� ��������?

// �������� � ������ ������ �� ����� �������� �������� �������� ����������
$row_cnf_checkinfo = explode("|", $cnf_checkinfo_array[0]);
$_SESSION['chkinfo_urlink'] = trim($row_cnf_checkinfo[0]); // ��������� ������� �������� ������
$_SESSION['chkinfo_cy'] = trim($row_cnf_checkinfo[1]); // ��������� CY
$_SESSION['chkinfo_pr'] = trim($row_cnf_checkinfo[2]); // ��������� PR
$_SESSION['chkinfo_out_links'] = trim($row_cnf_checkinfo[3]); // ���������� ������ �� ����������� ��������
$_SESSION['chkinfo_tag_noindex'] = trim($row_cnf_checkinfo[4]); // ���� �������
$_SESSION['chkinfo_meta_robots'] = trim($row_cnf_checkinfo[5]); // ������� ������
$_SESSION['chkinfo_file_robots'] = trim($row_cnf_checkinfo[6]); // ���� ������
$_SESSION['chkinfo_links_code'] = trim($row_cnf_checkinfo[7]); // ������ � �������������� ����
$_SESSION['chkinfo_symbol_code'] = trim($row_cnf_checkinfo[8]); // �������� � ����
$_SESSION['chkinfo_domen_domen'] = trim($row_cnf_checkinfo[9]); // ������ � �������������� ����
$_SESSION['chkinfo_myhome_domen'] = trim($row_cnf_checkinfo[10]); // ����� ���� ���������=������ ������ ���������
$_SESSION['chkinfo_free_hosting'] = trim($row_cnf_checkinfo[11]); // ���������� ��������
$_SESSION['chkinfo_moder'] = trim($row_cnf_checkinfo[12]); // �� ��������� ��� ����� � �������
$_SESSION['chkinfo_tags_p'] = trim($row_cnf_checkinfo[13]); //
$_SESSION['chkinfo_tags_br'] = trim($row_cnf_checkinfo[14]); //
$_SESSION['chkinfo_tags_i'] = trim($row_cnf_checkinfo[15]); //
$_SESSION['chkinfo_tags_u'] = trim($row_cnf_checkinfo[16]); //
$_SESSION['chkinfo_tags_b'] = trim($row_cnf_checkinfo[17]); //
$_SESSION['chkinfo_tags_strong'] = trim($row_cnf_checkinfo[18]); //
$_SESSION['chkinfo_tags_font'] = trim($row_cnf_checkinfo[19]); //
$_SESSION['chkinfo_tags_flash'] = trim($row_cnf_checkinfo[20]); //
$_SESSION['chkinfo_count_links'] = trim($row_cnf_checkinfo[21]); // ��� ������� ������

// ��������, ��� ���������
$place = "������������";
// ---------------------------------------------------------------------------------------------------------------------------------

// ---------------------------------------------------------------------------------------------------------------------------------
// ���� ������ ������ � ����� �����-������
if($_POST['change_login'] AND $_SESSION['owner_status']=="this_admin") {
if(!$_POST['lgn']||!$_POST['psw']||!$_POST['psw2']) { $_SESSION['error_config'] = "�� ������� ����� �/��� ������!"; header("Location: $_SERVER[PHP_SELF]"); exit(); }
if($_POST['psw'] != $_POST['psw2']) { $_SESSION['error_config'] = "��������� ������ �� ���������!"; header("Location: $_SERVER[PHP_SELF]"); exit(); }
$password = md5($_POST['psw']);
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$tmp=fopen("config/tmp.dat","w");
fputs($tmp, "$_POST[lgn]|$password\r\n");
fclose($tmp);
unlink("config/password.dat");
rename("config/tmp.dat", "config/password.dat");
flock($lock, LOCK_UN);
fclose($lock);
} else {
$_SESSION['error_config'] = "�� ���� ������������� ��������� ���� data/base.lck !!!";
header("Location: error.php");
exit();
}
$_SESSION['ok_config'] = "����� �/��� ������ ������� ��������!";
header("Location: $_SERVER[PHP_SELF]");
exit();
}
// ---------------------------------------------------------------------------------------------------------------------------------
// ���� ������ ������ � ����� ���������� �������� ������� ��������
if($_POST['change_visual'] AND $_SESSION['owner_status']=="this_admin") {
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$tmp=fopen("config/tmp.dat","w");
fputs($tmp, "$_POST[vis_show_category]|$_POST[vis_col_num]|$_POST[vis_sort_cat]|$_POST[vis_last_links]|$_POST[vis_show_cat]|$_POST[vis_show_date]|$_POST[vis_show_pr]|$_POST[vis_show_cy]|$_POST[vis_none_or_cy]|$_POST[vis_show_search]|$_POST[vis_show_button]|$_POST[vis_show_form]|$_POST[vis_show_codes]|$_POST[vis_show_rules]|$_POST[vis_show_mailtoadmin]|$_POST[vis_show_qntlinks]|$_POST[vis_shuffle_codes]|$_POST[vis_show_hh]|$_POST[vis_codes_qnt]|$_POST[vis_show_guard]|$_POST[vis_all_links]|$_POST[vis_user_lang]\r\n");
fclose($tmp);
unlink("config/cnfvisual.dat");
rename("config/tmp.dat", "config/cnfvisual.dat");
flock($lock, LOCK_UN);
fclose($lock);
} else {
$_SESSION['error_config'] = "�� ���� ������������� ��������� ���� data/base.lck !!!";
header("Location: error.php");
exit();
}
$_SESSION['ok_config'] = "������������ ���������� �������� ��� ������� �������� ������� ��������!";
header("Location: $_SERVER[PHP_SELF]");
exit();
}
// ---------------------------------------------------------------------------------------------------------------------------------
// ���� ������ ������ � ����� �������� �������� �������� ����������
if($_POST['change_checkinfo'] AND $_SESSION['owner_status']=="this_admin") {
if(!preg_match("/\d/", $_POST['chkinfo_cy'])) { $_SESSION['error_config'] = "������� ������������ ������ ��� CY �������!"; header("Location: $_SERVER[PHP_SELF]"); exit(); }
if(!preg_match("/\d/", $_POST['chkinfo_pr'])) { $_SESSION['error_config'] = "������� ������������ ������ ��� PR Google!"; header("Location: $_SERVER[PHP_SELF]"); exit(); }
if(!preg_match("/\d/", $_POST['chkinfo_out_links'])) { $_SESSION['error_config'] = "������� ������������ ������ ��� ���������� ��������� ������!"; header("Location: $_SERVER[PHP_SELF]"); exit(); }
if(!preg_match("/\d/", $_POST['chkinfo_links_code'])) { $_SESSION['error_config'] = "������� ������������ ������ ��� ���������� ������ � ����!"; header("Location: $_SERVER[PHP_SELF]"); exit(); }
if(!preg_match("/\d/", $_POST['chkinfo_symbol_code'])) { $_SESSION['error_config'] = "������� ������������ ������ ��� ���������� �������� � ����!"; header("Location: $_SERVER[PHP_SELF]"); exit(); }
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$tmp=fopen("config/tmp.dat","w");
fputs($tmp, "$_POST[chkinfo_urlink]|$_POST[chkinfo_cy]|$_POST[chkinfo_pr]|$_POST[chkinfo_out_links]|$_POST[chkinfo_tag_noindex]|$_POST[chkinfo_meta_robots]|$_POST[chkinfo_file_robots]|$_POST[chkinfo_links_code]|$_POST[chkinfo_symbol_code]|$_POST[chkinfo_domen_domen]|$_POST[chkinfo_myhome_domen]|$_POST[chkinfo_free_hosting]|$_POST[chkinfo_moder]|$_POST[chkinfo_tags_p]|$_POST[chkinfo_tags_br]|$_POST[chkinfo_tags_i]|$_POST[chkinfo_tags_u]|$_POST[chkinfo_tags_b]|$_POST[chkinfo_tags_strong]|$_POST[chkinfo_tags_font]|$_POST[chkinfo_tags_flash]|$_POST[chkinfo_count_links]\r\n");
fclose($tmp);
unlink("config/cnfcheckinfo.dat");
rename("config/tmp.dat", "config/cnfcheckinfo.dat");
flock($lock, LOCK_UN);
fclose($lock);
} else {
$_SESSION['error_config'] = "�� ���� ������������� ��������� ���� data/base.lck !!!";
header("Location: error.php");
exit();
}
$_SESSION['ok_config'] = "������������ �������� ��� �������� �������� ���������� ������� ��������!";
header("Location: $_SERVER[PHP_SELF]");
exit();
}
// ---------------------------------------------------------------------------------------------------------------------------------
// ���� ������ ������ � ������ ����������. �������, �����, ���� ��� �������� ���� ���, ��� ��������� �������, �� ��� ��...
if($_POST['change_imp'] AND $_SESSION['owner_status']=="this_admin") {
if(!preg_match("/\d/", $_POST['imp_links_page'])) { $_SESSION['error_config'] = "������� ������������ ������ ��� ���������� ������ �� ��������!"; header("Location: $_SERVER[PHP_SELF]"); exit(); }
if(!preg_match("/^(http:\/\/){1}[a-z0-9-\.]+\.[a-z]{2,4}$/i", $_POST['imp_myhome'])) { $_SESSION['error_config'] = "������� ������������ ������ ��� ������ ������ �������!"; header("Location: $_SERVER[PHP_SELF]"); exit(); }
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$tmp=fopen("config/tmp.dat","w");
fputs($tmp, "$_POST[imp_myhome]|$_POST[imp_mode_url]|$_POST[imp_links_page]\r\n");
fclose($tmp);
unlink("config/cnfimp.dat");
rename("config/tmp.dat", "config/cnfimp.dat");
if($_POST['imp_mode_url']=="�����������") {
// ���������� RewriteBase
$pos=strpos("$_SERVER[REQUEST_URI]", "admin");
$rb=substr("$_SERVER[REQUEST_URI]", 0, $pos);
$htas_content = "RewriteEngine on\r\nRewriteBase "."$rb"."\r\nRewriteRule ^(.*)(links_)([0-9]{10})_([0-9]{1,})\.html$ index.php?category=$3&page=$4\r\nRewriteRule ^(.*)(links_)([0-9]{1,})_([0-1]{1})\.html$ index.php?category=&page=$3&search=$4\r\n";
$ht = fopen("../.htaccess","w"); // �����
fputs($ht, "$htas_content");
fclose($ht);
}
if($_POST['imp_mode_url']=="������������") {
$ht = fopen("../.htaccess","w");
fputs($ht, "");
fclose($ht);
}
flock($lock, LOCK_UN);
fclose($lock);
} else {
$_SESSION['error_config'] = "�� ���� ������������� ��������� ���� data/base.lck !!!";
header("Location: error.php");
exit();
}
$_SESSION['ok_config'] = "������������ ��������� �������� ������� ��������!";
header("Location: $_SERVER[PHP_SELF]");
exit();
}
// ---------------------------------------------------------------------------------------------------------------------------------
// ���� ������ ������ � ���������� �������������� ��������
if($_POST['change_adm'] AND $_SESSION['owner_status']=="this_admin") {
if(!eregi("^([_a-z0-9-])+(\.)*([_a-z0-9-])*@([_a-z0-9-])+(\.)*([_a-z0-9-])*\.([a-z]){2,4}$", "$_POST[adm_e_mail]")) { $_SESSION['error_config'] = "����������� ������ e-mail ��������������!"; header("Location: $_SERVER[PHP_SELF]"); exit(); }
if(!preg_match("/\d/", $_POST['adm_row_page'])) { $_SESSION['error_config'] = "����������� ������� ���������� ������� �� ��������!"; header("Location: $_SERVER[PHP_SELF]"); exit(); }
if($_POST['adm_row_page'] > 10) { $_SESSION['error_config'] = "�� ���� ������ ����� 10 ������� �� ��������!"; header("Location: $_SERVER[PHP_SELF]"); exit(); }
if(!preg_match("/\d/", $_POST['adm_new_link'])) { $_SESSION['error_config'] = "����������� ������� ���������� ����!"; header("Location: $_SERVER[PHP_SELF]"); exit(); }
if(!preg_match("/\d/", $_POST['adm_old_link'])) { $_SESSION['error_config'] = "����������� ������� ���������� ����!"; header("Location: $_SERVER[PHP_SELF]"); exit(); }
if(!preg_match("/\d/", $_POST['adm_cy'])) { $_SESSION['error_config'] = "����������� ������� �������� CY!"; header("Location: $_SERVER[PHP_SELF]"); exit(); }
if(!preg_match("/\d/", $_POST['adm_pr'])) { $_SESSION['error_config'] = "����������� ������� �������� PR!"; header("Location: $_SERVER[PHP_SELF]"); exit(); }
if(!preg_match("/\d/", $_POST['adm_out_links'])) { $_SESSION['error_config'] = "����������� ������� ���-�� ������ �� ����������� ��������!"; header("Location: $_SERVER[PHP_SELF]"); exit(); }
$adm_cron_path = trim(stripslashes($_POST[adm_cron_path]));
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$tmp=fopen("config/tmp.dat","w");
fputs($tmp, "$_POST[adm_row_page]|$_POST[adm_in_mail]|$_POST[adm_out_mail]|$_POST[adm_e_mail]|$_POST[adm_sort]|$_POST[adm_old_link]|$_POST[adm_cy]|$_POST[adm_pr]|$_POST[adm_out_links]|$_SESSION[adm_backup_time]|$_POST[adm_sort_select]|$_POST[adm_sort_2]|$_POST[adm_new_link]|$_POST[adm_need_link]\r\n");
fclose($tmp);
unlink("config/cnfadm.dat");
rename("config/tmp.dat", "config/cnfadm.dat");

$crn = fopen("config/tmp.dat","w");
fputs($crn, "$adm_cron_path\r\n");
fclose($crn);
unlink("config/cnfcron.dat");
rename("config/tmp.dat", "config/cnfcron.dat");

flock($lock, LOCK_UN);
fclose($lock);
} else {
$_SESSION['error_config'] = "�� ���� ������������� ��������� ���� data/base.lck !!!";
header("Location: error.php");
exit();
}
$_SESSION['ok_config'] = "������������ �������� �������������� ������� ��������!";
header("Location: $_SERVER[PHP_SELF]");
exit();
}
// ---------------------------------------------------------------------------------------------------------------------------------
// ������� ������ ��� ��, ���� ��� ������������
if($_SESSION['error_config']) { echo "<span id=warningMess>������! $_SESSION[error_config]</span>"; unset($_SESSION['error_config']); }
if($_SESSION['ok_config']) { echo "<span id=okMess>��! $_SESSION[ok_config]</span>";  unset($_SESSION['ok_config']); }
// ---------------------------------------------------------------------------------------------------------------------------------
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
      <tr><td colspan=3 valign=top align=left>";
// ���������� ����
include "menu.php";
echo "</td></tr><tr><td colspan=3 valign=top align=left></td></tr>";
// ---------------------------------------------------------------------------------------------------------------------------------
echo "<tr><td valign=top align=left>"; // ������ ������ � ������
// ����� ��� ����� ����� �������-�������
echo "<form action=\""."$_SERVER[PHP_SELF]"."\" method=\"POST\"><table width=180 cellspacing=0 cellpadding=0>
      <tr><td align=right valign=top width=1px><img src=images/login_lu.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_ru.gif width=8 height=8 border=0></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td class=title bgcolor=#8f95ac align=left colspan=2>�������� �����/������</td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2>����� �����:<br><input name=\"lgn\" type=\"text\" size=\"24\" maxlength=\"255\" value=\""."$lgn"."\"></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2>����� ������:<br><input name=\"psw\" type=\"password\" size=\"24\" maxlength=\"255\"></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2>��� ��� ������:<br><input name=\"psw2\" type=\"password\" size=\"24\" maxlength=\"255\"></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2><center><input name=\"change_login\" type=\"submit\" value=\"��������\"></center></td><td bgcolor=#8f95ac width=1px></td></tr>
	  <tr><td align=right valign=top width=1px><img src=images/login_ld.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_rd.gif width=8 height=8 border=0></td></tr>
      </table></form><br>";
// ---------------------------------------------------------------------------------------------------------------------------------
// ������ �� ����� ������ ��������� � ������� ����� � ����
$row_cnf_imp = explode("|", $cnf_imp_array[0]);
$imp_myhome = trim($row_cnf_imp[0]);
if(!$imp_myhome) {$imp_myhome = "http://"."$_SERVER[HTTP_HOST]";}
$imp_mode_url = trim($row_cnf_imp[1]);
$imp_links_page = trim($row_cnf_imp[2]);
echo "<form action="."$_SERVER[PHP_SELF]"." method=POST><table width=180 cellspacing=0 cellpadding=0>
      <tr><td align=right valign=top width=1px><img src=images/login_lu.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_ru.gif width=8 height=8 border=0></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td class=title bgcolor=#8f95ac align=left colspan=2>������ ���������</td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2><br>����� ����� �������:<br><input name=imp_myhome type=text size=24 maxlength=255 value="."$imp_myhome"."></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2><br>��� URL ��� ����������� � �������� ����� ��������: <font color=red>(��. help)</font><br><select name=imp_mode_url><option>"."$imp_mode_url"."</option><option value=������������>������������</option><option value=�����������>�����������</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2><br>���������� ������ �� ����� �������� ��������:<br><input name=imp_links_page type=text size=4 maxlength=2 value="."$imp_links_page".">  <font color=red>(��. help)</font></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2><br><center><input name=change_imp type=submit value=\"��������\"></center></td><td bgcolor=#8f95ac width=1px></td></tr>
	  <tr><td align=right valign=top width=1px><img src=images/login_ld.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_rd.gif width=8 height=8 border=0></td></tr>
      </table></form>";
echo "</td><td valign=top align=center>"; // ������ ������ � ������
// ---------------------------------------------------------------------------------------------------------------------------------
// ������ �� ����� ���������� ��������� ������� �������� � ������� ����� � ����
$row_cnf_visual = explode("|", $cnf_visual_array[0]);
$vis_show_category = trim($row_cnf_visual[0]);
$vis_col_num = trim($row_cnf_visual[1]);
$vis_sort_cat = trim($row_cnf_visual[2]);
$vis_last_links = trim($row_cnf_visual[3]);
$vis_show_cat = trim($row_cnf_visual[4]);
$vis_show_date = trim($row_cnf_visual[5]);
$vis_show_pr = trim($row_cnf_visual[6]);
$vis_show_cy = trim($row_cnf_visual[7]);
$vis_none_or_cy = trim($row_cnf_visual[8]);
$vis_show_search = trim($row_cnf_visual[9]);
$vis_show_button = trim($row_cnf_visual[10]);
$vis_show_form = trim($row_cnf_visual[11]);
$vis_show_codes = trim($row_cnf_visual[12]);
$vis_show_rules = trim($row_cnf_visual[13]);
$vis_show_mailtoadmin = trim($row_cnf_visual[14]);
$vis_show_qntlinks = trim($row_cnf_visual[15]);
$vis_shuffle_codes = trim($row_cnf_visual[16]);
$vis_show_hh = trim($row_cnf_visual[17]);
$vis_codes_qnt = trim($row_cnf_visual[18]);
$vis_show_guard = trim($row_cnf_visual[19]);
$vis_all_links = trim($row_cnf_visual[20]);
$vis_user_lang = trim($row_cnf_visual[21]);
echo "<form action="."$_SERVER[PHP_SELF]"." method=POST><table width=100% cellspacing=0 cellpadding=0>
      <tr><td align=right valign=top width=1px><img src=images/login_lu.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_ru.gif width=8 height=8 border=0></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td class=title bgcolor=#8f95ac align=left colspan=2>��������� ����������� ������ ��� ������� ��������</td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>���������� ������ ��������� �� ������� ��������?</td><td bgcolor=#8f95ac align=right><select name=vis_show_category><option>"."$vis_show_category"."</option><option value=��>��</option><option value=���>���</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>���������� ���������� ������ � ����������?</td><td bgcolor=#8f95ac align=right><select name=vis_show_qntlinks><option>"."$vis_show_qntlinks"."</option><option value=��>��</option><option value=���>���</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>������� ������� ����� ��� ����������� ���������?</td><td bgcolor=#8f95ac align=right><select name=vis_col_num><option>"."$vis_col_num"."</option><option value=1>1</option><option value=2>2</option><option value=3>3</option><option value=4>4</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>���������� ����� ���������� ������ � ��������?</td><td bgcolor=#8f95ac align=right><select name=vis_all_links><option>"."$vis_all_links"."</option><option value=��>��</option><option value=���>���</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>����������� ��������� �� ������� �������� ��:</td><td bgcolor=#8f95ac align=right><select name=vis_sort_cat><option>"."$vis_sort_cat"."</option><option value=��������>��������</option><option value=����>����</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>���������� �� ������� �������� ��������� ����������� ������?</td><td bgcolor=#8f95ac align=right><select name=vis_last_links><option>"."$vis_last_links"."</option><option value=���>���</option><option value=1>1</option><option value=3>3</option><option value=5>5</option><option value=10>10</option><option value=20>20</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>���������� ���������, � ������� ��������� ������?</td><td bgcolor=#8f95ac align=right><select name=vis_show_cat><option>"."$vis_show_cat"."</option><option value=��>��</option><option value=���>���</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>���������� ���� ���������� ������?</td><td bgcolor=#8f95ac align=right><select name=vis_show_date><option>"."$vis_show_date"."</option><option value=��>��</option><option value=���>���</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>���������� Page Rank ������� ������� ������� ��� ���� ������?</td><td bgcolor=#8f95ac align=right><select name=vis_show_pr><option>"."$vis_show_pr"."</option><option value=��>��</option><option value=���>���</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>���������� CY ������� ������� ��� ���� ������?</td><td bgcolor=#8f95ac align=right><select name=vis_show_cy><option>"."$vis_show_cy"."</option><option value=��>��</option><option value=���>���</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>���������� � �������� ������ 88�31?</td><td bgcolor=#8f95ac align=right><select name=vis_show_button><option>"."$vis_show_button"."</option><option value=��>��</option><option value=���>���</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>��� ���������� ������ ����������</td><td bgcolor=#8f95ac align=right><select name=vis_none_or_cy><option>"."$vis_none_or_cy"."</option><option value=\"������-��������\">������-��������</option><option value=\"������ CY �������\">������ CY �������</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>���������� �� ������� �������� ����� ������ �� ��������?</td><td bgcolor=#8f95ac align=right><select name=vis_show_search><option>"."$vis_show_search"."</option><option value=��>��</option><option value=���>���</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>���������� ����� �������/��������� ������?</td><td bgcolor=#8f95ac align=right><select name=vis_show_hh><option>"."$vis_show_hh"."</option><option value=��>��</option><option value=���>���</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>���� ���������� �������� �����</td><td bgcolor=#8f95ac align=right><select name=vis_user_lang><option>"."$vis_user_lang"."</option><option value=rus>rus</option><option value=eng>eng</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td class=title bgcolor=#8f95ac align=left colspan=2>��������� ����� ����������<td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>����� ���������� ������ (��. help)</td><td bgcolor=#8f95ac align=right><select name=vis_show_form><option>"."$vis_show_form"."</option><option value=\"�����-1\">�����-1</option><option value=\"�����-2\">�����-2</option><option value=\"���������\">���������</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>���������� ���� HTML-����?</td><td bgcolor=#8f95ac align=right><select name=vis_show_codes><option>"."$vis_show_codes"."</option><option value=\"��\">��</option><option value=\"���\">���</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>�������� ��������� ������� ������ ����� HTML-�����?</td><td bgcolor=#8f95ac align=right><select name=vis_shuffle_codes><option>"."$vis_shuffle_codes"."</option><option value=\"��\">��</option><option value=\"���\">���</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>������� HTML-����� ����������?</td><td bgcolor=#8f95ac align=right><select name=vis_codes_qnt><option>"."$vis_codes_qnt"."</option><option value=���>���</option><option value=1>1</option><option value=2>2</option><option value=3>3</option><option value=4>4</option><option value=5>5</option><option value=6>6</option><option value=7>7</option><option value=8>8</option><option value=9>9</option><option value=10>10</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>���������� ������� ����������?</td><td bgcolor=#8f95ac align=right><select name=vis_show_rules><option>"."$vis_show_rules"."</option><option value=\"��\">��</option><option value=\"���\">���</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>���������� ����� �������� ������ ��������������?</td><td bgcolor=#8f95ac align=right><select name=vis_show_mailtoadmin><option>"."$vis_show_mailtoadmin"."</option><option value=\"��\">��</option><option value=\"���\">���</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>�������� ������ �� ��������������?</td><td bgcolor=#8f95ac align=right><select name=vis_show_guard><option>"."$vis_show_guard"."</option><option value=\"��\">��</option><option value=\"���\">���</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=center colspan=2><br><input name=change_visual type=submit value=\"��������\"></td><td bgcolor=#8f95ac width=1px></td></tr>
	  <tr><td align=right valign=top width=1px><img src=images/login_ld.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_rd.gif width=8 height=8 border=0></td></tr>
      </table></form><br>";
// ---------------------------------------------------------------------------------------------------------------------------------
// ������ �� ����� ��������� �������� �������� ���������� � ������� ����� � ����
$row_cnf_checkinfo = explode("|", $cnf_checkinfo_array[0]);
$chkinfo_urlink = trim($row_cnf_checkinfo[0]);
$chkinfo_cy = trim($row_cnf_checkinfo[1]);
$chkinfo_pr = trim($row_cnf_checkinfo[2]);
$chkinfo_out_links = trim($row_cnf_checkinfo[3]);
$chkinfo_tag_noindex = trim($row_cnf_checkinfo[4]);
$chkinfo_meta_robots = trim($row_cnf_checkinfo[5]);
$chkinfo_file_robots = trim($row_cnf_checkinfo[6]);
$chkinfo_links_code = trim($row_cnf_checkinfo[7]);
$chkinfo_symbol_code = trim($row_cnf_checkinfo[8]);
$chkinfo_domen_domen = trim($row_cnf_checkinfo[9]);
$chkinfo_myhome_domen = trim($row_cnf_checkinfo[10]);
$chkinfo_free_hosting = trim($row_cnf_checkinfo[11]);
$chkinfo_moder = trim($row_cnf_checkinfo[12]);
$chkinfo_tags_p = trim($row_cnf_checkinfo[13]);
$chkinfo_tags_br = trim($row_cnf_checkinfo[14]);
$chkinfo_tags_i = trim($row_cnf_checkinfo[15]);
$chkinfo_tags_u = trim($row_cnf_checkinfo[16]);
$chkinfo_tags_b = trim($row_cnf_checkinfo[17]);
$chkinfo_tags_strong = trim($row_cnf_checkinfo[18]);
$chkinfo_tags_font = trim($row_cnf_checkinfo[19]);
$chkinfo_tags_flash = trim($row_cnf_checkinfo[20]);
$chkinfo_count_links = trim($row_cnf_checkinfo[21]);
echo "<form action="."$_SERVER[PHP_SELF]"." method=POST><table width=100% cellspacing=0 cellpadding=0>
      <tr><td align=right valign=top width=1px><img src=images/login_lu.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_ru.gif width=8 height=8 border=0></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td class=title bgcolor=#8f95ac align=left colspan=2>��������� ��� �������� �������� ����������</td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>��������� ������������ ������� �������� ������ <b>��� ����������</b>?</td><td bgcolor=#8f95ac align=right><select name=chkinfo_urlink><option>"."$chkinfo_urlink"."</option><option value=��>��</option><option value=���>���</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>��������� ����������� CY ������ ����� �������� �� ����� (����. ��� 0)</td><td bgcolor=#8f95ac align=right><input name=chkinfo_cy type=text size=4 maxlength=5 value="."$chkinfo_cy"."></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>��������� ����������� PR Google �������� ������ �������� �� ����� (����. ��� 0)</td><td bgcolor=#8f95ac align=right><input name=chkinfo_pr type=text size=4 maxlength=2 value="."$chkinfo_pr"."></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>��������� ����������� ���������� ������ �� �������� ������ �� ����� (����. ��� 0)</td><td bgcolor=#8f95ac align=right><input name=chkinfo_out_links type=text size=4 maxlength=5 value="."$chkinfo_out_links"."></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>��� �������� ��������� ������ �� ���������� ��������?</td><td bgcolor=#8f95ac align=right><select name=chkinfo_count_links><option>"."$chkinfo_count_links"."</option><option value=��>��</option><option value=���>���</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>��������� �� ������� ������� ���������� ������ noindex?</td><td bgcolor=#8f95ac align=right><select name=chkinfo_tag_noindex><option>"."$chkinfo_tag_noindex"."</option><option value=��>��</option><option value=���>���</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>��������� �� ������� ������� ���������� ��������� robots?</td><td bgcolor=#8f95ac align=right><select name=chkinfo_meta_robots><option>"."$chkinfo_meta_robots"."</option><option value=��>��</option><option value=���>���</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>��������� �� ������� ������� ���������� � ����� robots.txt?</td><td bgcolor=#8f95ac align=right><select name=chkinfo_file_robots><option>"."$chkinfo_file_robots"."</option><option value=��>��</option><option value=���>���</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>���������� ������ � �������������� ��������� ���� �� �����</td><td bgcolor=#8f95ac align=right><input name=chkinfo_links_code type=text size=4 maxlength=3 value="."$chkinfo_links_code"."></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>���������� �������� � ��������� ���� (� ������ �����) �� �����</td><td bgcolor=#8f95ac align=right><input name=chkinfo_symbol_code type=text size=4 maxlength=5 value="."$chkinfo_symbol_code"."></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>��� ������ � �������������� ���� ������ ��������� �� ���� � ��� �� �����?</td><td bgcolor=#8f95ac align=right><select name=chkinfo_domen_domen><option>"."$chkinfo_domen_domen"."</option><option value=��>��</option><option value=���>���</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>����������� �� ��� ����� � �����, ��� ��������� ���� ������ ������ ���� ���������?</td><td bgcolor=#8f95ac align=right><select name=chkinfo_myhome_domen><option>"."$chkinfo_myhome_domen"."</option><option value=��>��</option><option value=���>���</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>��������� ���������� ������ � ���������� ���������? (��. ������ Free hosting)</td><td bgcolor=#8f95ac align=right><select name=chkinfo_free_hosting><option>"."$chkinfo_free_hosting"."</option><option value=��>��</option><option value=���>���</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>��������� ������ ����� ��� ���������� �� ���������?</td><td bgcolor=#8f95ac align=right><select name=chkinfo_moder><option>"."$chkinfo_moder"."</option><option value=����������>����������</option><option value=���������>���������</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>��������� ���� &lt;P&gt; � ��������� ����?</td><td bgcolor=#8f95ac align=right><select name=chkinfo_tags_p><option>"."$chkinfo_tags_p"."</option><option value=��>��</option><option value=���>���</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>��������� ���� &lt;BR&gt; � ��������� ����?</td><td bgcolor=#8f95ac align=right><select name=chkinfo_tags_br><option>"."$chkinfo_tags_br"."</option><option value=��>��</option><option value=���>���</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>��������� ���� &lt;U&gt; � ��������� ����?</td><td bgcolor=#8f95ac align=right><select name=chkinfo_tags_u><option>"."$chkinfo_tags_u"."</option><option value=��>��</option><option value=���>���</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>��������� ���� &lt;I&gt; � ��������� ����?</td><td bgcolor=#8f95ac align=right><select name=chkinfo_tags_i><option>"."$chkinfo_tags_i"."</option><option value=��>��</option><option value=���>���</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>��������� ���� &lt;B&gt; � ��������� ����?</td><td bgcolor=#8f95ac align=right><select name=chkinfo_tags_b><option>"."$chkinfo_tags_b"."</option><option value=��>��</option><option value=���>���</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>��������� ���� &lt;STRONG&gt; � ��������� ����?</td><td bgcolor=#8f95ac align=right><select name=chkinfo_tags_strong><option>"."$chkinfo_tags_strong"."</option><option value=��>��</option><option value=���>���</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>��������� ���� &lt;FONT&gt; � ��������� ����?</td><td bgcolor=#8f95ac align=right><select name=chkinfo_tags_font><option>"."$chkinfo_tags_font"."</option><option value=��>��</option><option value=���>���</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>��������� ���������� flash-��������?</td><td bgcolor=#8f95ac align=right><select name=chkinfo_tags_flash><option>"."$chkinfo_tags_flash"."</option><option value=��>��</option><option value=���>���</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=center colspan=2><br><input name=change_checkinfo type=submit value=\"��������\"></td><td bgcolor=#8f95ac width=1px></td></tr>
	  <tr><td align=right valign=top width=1px><img src=images/login_ld.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_rd.gif width=8 height=8 border=0></td></tr>
      </table></form><br>";
// ---------------------------------------------------------------------------------------------------------------------------------
// ������ �� ����� ��������� �������������� �������� � ������� ����� � ����
$row_cnf_adm = explode("|", $cnf_adm_array[0]);
$adm_row_page = trim($row_cnf_adm[0]);
$adm_in_mail = trim($row_cnf_adm[1]);
$adm_out_mail = trim($row_cnf_adm[2]);
$adm_e_mail = trim($row_cnf_adm[3]);
$adm_sort = trim($row_cnf_adm[4]);
$adm_old_link = trim($row_cnf_adm[5]);
$adm_cy = trim($row_cnf_adm[6]);
$adm_pr = trim($row_cnf_adm[7]);
$adm_out_links = trim($row_cnf_adm[8]);
$adm_backup_time = trim($row_cnf_adm[9]);
$adm_sort_select = trim($row_cnf_adm[10]);
$adm_sort_2 = trim($row_cnf_adm[11]);
$adm_new_link = trim($row_cnf_adm[12]);
$adm_need_link = trim($row_cnf_adm[13]);
$adm_cron_path = implode("",$cnf_cron_array);
$adm_cron_path = trim($adm_cron_path);
echo "<form action="."$_SERVER[PHP_SELF]"." method=POST><table width=100% cellspacing=0 cellpadding=0>
      <tr><td align=right valign=top width=1px><img src=images/login_lu.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_ru.gif width=8 height=8 border=0></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td class=title bgcolor=#8f95ac align=left colspan=2>��������� �������������� ��������</td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>��������� ������������ ������� �������� ������ <b>��� ��������</b>? (*)</td><td bgcolor=#8f95ac align=right><select name=adm_need_link><option>"."$adm_need_link"."</option><option value=��>��</option><option value=���>���</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>���������� �������, ��������� �� ���� ��������</td><td bgcolor=#8f95ac align=right><input name=adm_row_page type=text size=4 maxlength=2 value="."$adm_row_page"."></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>��������� �������� ��������� �� ������� ��������������</td><td bgcolor=#8f95ac align=right><select name=adm_in_mail><option>"."$adm_in_mail"."</option><option value=win-1251>win-1251</option><option value=koi8-r>koi8-r</option><option value=iso-8859>iso-8859</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>��������� �������� ��������� �� ������� �������������</td><td bgcolor=#8f95ac align=right><select name=adm_out_mail><option>"."$adm_out_mail"."</option><option value=win-1251>win-1251</option><option value=koi8-r>koi8-r</option><option value=iso-8859>iso-8859</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>E-mail ����� �������������� ��������</td><td bgcolor=#8f95ac align=right><input name=adm_e_mail type=text size=16 maxlength=255 value="."$adm_e_mail"."></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>���������� �� ���� ����������:</td><td bgcolor=#8f95ac align=right><select name=adm_sort><option>"."$adm_sort"."</option><option value=�����������>�����������</option><option value=��������>��������</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>�������� ���������� �� ���� ��������?<br>(����. ���������� �� ���� ����������)</td><td bgcolor=#8f95ac align=right><select name=adm_sort_select><option>"."$adm_sort_select"."</option><option value=��>��</option><option value=���>���</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>���������� �� ���� ��������:</td><td bgcolor=#8f95ac align=right><select name=adm_sort_2><option>"."$adm_sort_2"."</option><option value=�����������>�����������</option><option value=��������>��������</option></select></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>������� ������ ����� �� ��������� ����:</td><td bgcolor=#8f95ac align=right><input name=adm_new_link type=text size=4 maxlength=3 value="."$adm_new_link"."></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>������� ������ ����������� ����� �� ��������� ����:</td><td bgcolor=#8f95ac align=right><input name=adm_old_link type=text size=4 maxlength=3 value="."$adm_old_link"."></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>������� ������ ������ ��� CY ������, ���:</td><td bgcolor=#8f95ac align=right><input name=adm_cy type=text size=4 maxlength=5 value="."$adm_cy"."></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>������� ������ ������ ��� PR (�������� ������) ������, ���:</td><td bgcolor=#8f95ac align=right><input name=adm_pr type=text size=4 maxlength=2 value="."$adm_pr"."></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>������� ������ ������ ��� ���������� ������ �� �������� ������, ���:</td><td bgcolor=#8f95ac align=right><input name=adm_out_links type=text size=4 maxlength=5 value="."$adm_out_links"."></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2><HR></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2>��������� ������������ ��� ����� �������� �� ���������� (��. help)<br><textarea style=\"width:375px; height:70px;\" name=adm_cron_path>"."$adm_cron_path"."</textarea></td><td bgcolor=#8f95ac width=1px></td></tr>
	  <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=center colspan=2><br><input name=change_adm type=submit value=\"��������\"></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2><HR></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>��������� ��� ��������� ����������� �����������:</td><td bgcolor=#8f95ac align=right><input style=\"background-color: #afb5cc;\" name=adm_backup_time type=text size=19 value=\""."$adm_backup_time"."\"></td><td bgcolor=#8f95ac width=1px></td></tr>
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
<font face=Verdana size=1 color=white><b>�������� �����/������</b></font><br>
�������� ����� �/��� ������ �� ������ � ����� �����. ����� ����� ������ ��������� ������� ����������� ������� ����������� ����� � ������ �� ����!
</div>";
echo "<div align=justify>
<font face=Verdana size=1 color=red><br><b>< �������� �������� ></b></font><br>
������ ���������� �������� ������, ������� ����� ����� �����-���� ���������� ������������, ��� ����, ����� ������� ��������� � �������� ����� �������, ��� ���������� ����� ��������� ����� ���� ������ ��������!<br><br>
</div>";
echo "<div align=justify>
<font face=Verdana size=1 color=white><b>������ ��������� �������</b></font><br>
<b>* ����� ������ �������</b> ���������� ������ � ��� ����, � ������� �� ���������� � ����� HTML-����� ��� ������, �.�. ���� �� ���������� � ����� ���� ����� � ���� http://mysite.ru, �� � � ���� ��������� �� ������ �������������� ������ � ����� �� ����, � �� http://www.mysite.ru<br>
<b>* ��� URL</b> ��� ����������� � �������� ����� ��������. ����� �� ������ ������� ����� ������������ � ����������� ����� URL'��. ��� ����, ����� ������������ ����������� ��� URL �� ����� ������� ������ ���� ��������� ������ mode_rewrite. <font color=red>��������! ��� ����, ����� ��������� �������� ���� �����, ���������� �� �������� ����� ������� �������� ��������� ����� ������� 777, ����� ����� ������ ����� ���������� ����� ������� 755.</font><br>������ ������������ URL:<br>http://site.ru/link_159_7.html<br>������ ������������� URL:<br>http://site.ru/link/index.php?category=159&page=7<br>
<b>* ���������� ������</b>, ��������� �� ����� �������� ��������. <font face=Verdana size=1 color=red><b>��� ��������� ����� ������� ������ ���� ���, ��� ������ ��������� �������!</b></font> ������ �������� ���������� ����� ��� ������ ������ ������ � ��� ������, ���� ���� �������� �� ����� ������� ������������.
<br><br>
</div>";
echo "<div align=justify>
<font face=Verdana size=1 color=white><b>��������� ����������� ������ ��� ������� ��������</b></font><br>
��� ���������� ���������. �� ������ � ����� ����� �������� ��� � ����� ���� ������, ������� ������������ �� ���� �������� ���������.
</div>";
echo "<div align=justify>
<font face=Verdana size=1 color=red><br><b>< �������� �������� ></b></font><br>
��� ����, ����� ����������� ������� ���������, ���� ������� � ��. - �������������� �������� \"������\"<br><br>
</div>";
echo "<div align=justify>
<font face=Verdana size=1 color=white><b>��������� ����������� � ����� ����������</b></font><br>
����� ���������� ������. ����� �� ������ �������� �� ���� ���������. ��� ����� �������� ��������� ���������� ���� �����: ���, ����� �������� ������, ����� ����������� �����, ����� ���������. �����-1 �������� ���� ����� HTML-���� � ��������� ������ � ��������, � �����-2 ���� ����������� ������ ������ ��������� �������� ������ � ������� ���� � ������������ �������.
�����-2 ����� ������� ��� ���, ��� �������� ������ ������������� ��������. ��� ������ ����� \"���������\" - ����� ������ ������������ �� �����. �� �������� � ���� ������ �������� ����� ��� �������� ������ ��������������, � �������� ��������������� ������� ���������� ������ � �������.<br>
��������� ����� ����� ������� ��������/��������� ����� ����������� ����� HTML-����� ��� ������, ������ ���������� � ������� � ����� ��� �������� ������ �������������� ��������. ����������� �������� e-mail �� ����� ������� ��� ��� �������������, ������� ���������� ����������� � ����������� ����� ������ ��� ����� ���������� ������ �������� ������. �� ������ ������������ ����� ����� ������ ����� HTML-����� � ��������� �������.<br><br>
</div>";
echo "<div align=justify>
<font face=Verdana size=1 color=white><b>��������� ��� �������� �������� ����������</b></font><br>
���������� � ���� ���������� �������� �����������. ��������� ����� �����������, �� ������ ������� �������� �������� ���������� ��� ����������� �������, ��� � ������ ���������� �� �����-���� ��������.
 � ���� �� ������� �� ������� ������� ������ ���������� ������ � ���� �������: ��������� ������ ������� �� ��������� ��� ��������������� � ���� ��������.<br>
</div>";
echo "<div align=justify>
<font face=Verdana size=1 color=red><br><b>< �������� �������� ></b></font><br>
���� �� ������� ����� \"���\" � ���������: \"����������� �� ��� ����� � �����, ��� ��������� ���� ������ ������ ���� ���������?\", �� ���������� �� ��������������, ��� CY (PR) ����� ������������ ��� ���� ������ (��������), ��� ����������� �������� ������!<br><br>
</div>";
echo "<div align=justify>
<font face=Verdana size=1 color=white><b>��������� �������������� ��������</b></font><br>
��������� �������������� ��������, ����������� � ������ �������� ������, <font color=red><b>�� ��������</b></font> �� �������� �������� �������� ����������. ������������� ����� ������������ ����� ����������� �� ������ ����������. 
</div>";
echo "<div align=justify>
<font face=Verdana size=1 color=red><br><b>(*)</b></font> 
������ �� ����� ��������� ������� �������� ������ � �������� ���������� ��� ������ ������ \"���\" �� ������ ������, �� 
������� �������� CY, PR � ���������� ������ �� ����������� ��������. ������ ������ ���������� ������ �� ��������� ��������, 
��������� ���� � �������� ������ � ��������������� ������.<br>
</div>";
echo "<div align=justify>
<font face=Verdana size=1 color=red><br><b>< �������� �������� ></b></font><br>
�������� ������  ���������� �������� ��������� ������������ ��� ����� �������� ����� ������ �� ����������.<br><br>
</div>";
echo "<div align=justify>
<font face=Verdana size=1 color=white><b>��������� �������� �� ����������</b></font><br>
���� �� ������ ����������� ������������ �� ����� ������� ������ �������� �� ���������� (Cron), �� ��� ���������� ����� ����������� ���������� ��������� ������������ ��� �����, ������� � ����� ����������� �� �������������� ���� ����������.<br>
<font color=red>* ��. Help ����� ��������� ������ � ����������� �����������, ����������� ��� ���������� ������ � ������� cron.</font><br><br>
���������� <b>\$adm_cron_path</b> �������� ������ ���� � ����� admin �������. ������ ���� ���������� ������. ���� �� ����������� �����-���� FTP-��������, �� ���� �� ������ ������ ����������� �� ��� �������� ������, ������� ����� ���� ������� � ����� admin. ���� �� ����������� �����-���� ������� ���������� ����� ������, �� ����� ��������� ����������. �.�. ����� � ����� admin � �� ������� ������ ���� � ���� ����� (��� ������� ����� ��������).<br>
<font color=red>������ �����������: �� ������ �������� ����� ������������� ������� ���� � ��� ��� ���������� �����, � ��� ���� ����� ����� admin ������ ��������������!</font><br>
���������� <b>\$imp_myhome</b> - ����� ������ �������. ����� �� ��� � � ������� ������ �������� �������.<br>
���������� <b>\$adm_e_mail</b> - ����� ����������� ����� �������������� ��������, �� ������� ������ ����� �������� ���������� ��������.<br>
���������� <b>\$adm_in_mail</b> - ��������� ��� �����, ������������ ������� ��������������. ����� ����� win-1251 � koi8-r.<br>
���������� <b>\$adm_count_links</b> - ���������� \"���\", ���� �� ������ ������������ ������ �� ���������� �������� ������������ �����.<br><br>
��������� ��� ���������� ������ ��� ����� �������� �� ���������� �������� ������ �������� ������:<br>
���������� <b>\$adm_out_links</b> - ���������� ������ �� ����������� �������� ��� ���������� ����� ������� ������ ������ ��������� ��������� �������������� (���� ��������).<br>
���������� <b>\$adm_cy</b> - �������� ��� ������� ��� ������� ������ ������ ����� ��������� ����������� ���� ��� ������ � ��������� ��������� �������������� (���� ��������).<br>
���������� <b>\$adm_pr</b> - �������� PR Google ��� ������� ������  ������ ����� ��������� ����������� ���� ��� ������ � ��������� ��������� �������������� (���� ��������).<br>
���������� <b>\$letter_noanswer</b> - � ������ ��������� � 'on' ������ ����� �������� ��������� ��������������, ���� �� ������� �������� ����� �� ������������ �����. ��� ���������� - off.<br>
���������� <b>\$letter_badly</b> - � ������ ��������� � 'on' ������ ����� �������� ��������� ��������������, ���� ������� ������������� ��������� ��� �������� ���� �� ������ ���������. ��� ���������� - off.<br>
���������� <b>\$letter_well</b> - ����� ��������������� � on/off. ������������� �������� ������ ��� ������� �������� �������� �� ����������. �������� ������ ��������������, ���� ����������� �������� ������������� ���� ����������� �������������� ��������.<br><br>
��� ������� CRON �������������� ��������� ��������:<br>
<font color=red>/usr/local/bin/php -q /������/����/admin/croncheck.php</font><br>���<br>
<font color=red>/usr/bin/php -q /������/����/admin/croncheck.php</font><br>
��� /usr/local/bin/php (/usr/bin/php) - ���� � PHP-�������������� ������ �������. ��������� ���� ���� � ����������� ��������� ������ �������.<br>� ������ ���� ����� ������, <a href=info.php target=_blank><b><font color=white>��������� �����</font></b></a> ���������� ���������� ���������, �������� SCRIPT_FILENAME ��� PATH_TRANSLATED, ������ ������ info.php, ����������� ������ ���� croncheck.php
</div>";
echo "</td><td bgcolor=#8f95ac width=1px></td></tr>
	  <tr><td align=right valign=top width=1px><img src=images/login_ld.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_rd.gif width=8 height=8 border=0></td></tr>
      </table>";
	  
echo "</td></tr></table>";
@ignore_user_abort($old_abort);
?>
</body>
</html>