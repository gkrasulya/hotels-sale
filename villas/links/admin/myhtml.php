<?php
error_reporting(0);
@$old_abort = ignore_user_abort(true);

session_start();
include "adminic.php";
// ���������� �������
include "functions/cut.php";
include "functions/check.php";

// ��������, ��� ���������
$place = "��� HTML-����";

// ----------------------------------------------------------------------------------
// ���� ��������� HTML-���
if($_POST['add_myhtml'] AND $_SESSION['owner_status']=="this_admin") {

// �������� - ��������
$myhtml_description = Cut_All_Exc($_POST['myhtml_description']); // ����� ��� ������, ����� �������
if($_SESSION['chkinfo_tags_b']=="���") { $myhtml_description = Cut_Tags_B($myhtml_description); }
if($_SESSION['chkinfo_tags_br']=="���") { $myhtml_description = Cut_Tags_Br($myhtml_description); }
if($_SESSION['chkinfo_tags_font']=="���") { $myhtml_description = Cut_Tags_Font($myhtml_description); }
if($_SESSION['chkinfo_tags_i']=="���") { $myhtml_description = Cut_Tags_I($myhtml_description); }
if($_SESSION['chkinfo_tags_p']=="���") { $myhtml_description = Cut_Tags_P($myhtml_description); }
if($_SESSION['chkinfo_tags_strong']=="���") { $myhtml_description = Cut_Tags_Strong($myhtml_description); }
if($_SESSION['chkinfo_tags_u']=="���") { $myhtml_description = Cut_Tags_U($myhtml_description); }
if($_SESSION['chkinfo_tags_flash']=="���") { $myhtml_description = Cut_Tags_Flash($myhtml_description); }

if(!$myhtml_description) { $_SESSION['error_config'] = "HTML-��� �� ������ ��� �����������!"; header("Location: $_SERVER[PHP_SELF]"); exit(); }

// ������ ���� � ������ � ������ (���������� ��� � ������ �� ������-������)
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$myhtml_array = file("data/myhtml.dat");
flock($lock, LOCK_UN);
fclose($lock);
} else {
$_SESSION['error'] = "�� ���� ������������� ��������� ���� data/base.lck !!!";
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=error.php'>
	  </HEAD></HTML>";
exit();
}

// ����������� � ����������� � ������ ���� �����
$add_err['check_a_eqv'] = Check_A_Eqv($myhtml_description);
if($add_err['check_a_eqv']=="OK") { unset($add_err['check_a_eqv']); }
// �������� ���������� �������� � ����
$add_err['check_symbol_code'] = Check_Symbol_Code($myhtml_description,$_SESSION['chkinfo_symbol_code']);
if($add_err['check_symbol_code']=="OK") { unset($add_err['check_symbol_code']); }
// �������� ���������� ������ � ����
$add_err['check_links_code'] = Check_Links_Code($myhtml_description,$_SESSION['chkinfo_links_code']);
if($add_err['check_links_code']=="OK") { unset($add_err['check_links_code']); }
// �������� �� �� ������ � ����, ������ ���� ��� ������ � �������������� ���� ������ ��������� �� ���� � ��� �� �����
// � ��������� ���������� �������������� �����
if($_SESSION['chkinfo_domen_domen']=="��" AND $_SESSION['chkinfo_links_code']>1) {
$add_err['check_domen_domen'] = Check_Domen_Domen($myhtml_description,$_SESSION['chkinfo_links_code']);
if($add_err['check_domen_domen']=="OK") { unset($add_err['check_domen_domen']); }
}
// �������� ��� �� ����� � ����, ������ ���� ��� ������ � ���� ������ ��������������� ������ ������
if($_SESSION['chkinfo_myhome_domen']=="��") {
$add_err['check_myhome_domen'] = Check_Myhome_Domen($myhtml_description,$_SESSION['imp_myhome']);
if($add_err['check_myhome_domen']=="OK") { unset($add_err['check_myhome_domen']); }
}
// �������� ���� ���� ��� �������� ��� ������
$add_err['check_img_flash'] = Check_Img_Flash($myhtml_description,$_SESSION['imp_myhome']);
if($add_err['check_img_flash']=="OK") { unset($add_err['check_img_flash']); }
// ���� ���� IMG - �� ������ ���� ������ �� ����� � ����� ������ a � img - �������� ������
$myhtml_description = Cut_Img_Notext($myhtml_description);
// ���� ���� IMG - �������� � ����� ������ ������� ��� ����, ������� ����� ���� ���������
$temp = strtolower($myhtml_description);
$count_img = substr_count($temp, "<img");
if($count_img > 0) {
$myhtml_description = Cut_Tags_B($myhtml_description);
$myhtml_description = Cut_Tags_Br($myhtml_description);
$myhtml_description = Cut_Tags_Font($myhtml_description);
$myhtml_description = Cut_Tags_I($myhtml_description);
$myhtml_description = Cut_Tags_P($myhtml_description);
$myhtml_description = Cut_Tags_Strong($myhtml_description);
$myhtml_description = Cut_Tags_U($myhtml_description);
$myhtml_description = Cut_Tags_Flash($myhtml_description);
}

// �������� ������� IMG-TXT
unset($add_err['radio_myhtml']);
if($_POST['radio_myhtml'] == "IMG" AND $count_img == 0) {$add_err['radio_myhtml'] = "���� ��������� �������� ��� ����!";}
if($_POST['radio_myhtml'] == "TXT" AND $count_img > 0) {$add_err['radio_myhtml'] = "���� ��������� �������� ��� ����!";}

// ����, ��� �� ��� ��������� ����� ������ �� ����
$temp = strtolower($myhtml_description);
$temp = str_replace ("\"", "", $temp);
$temp = str_replace (" ", "", $temp);
$temp = strtr("$temp", "���������������������������������", "���������������������������������");
for($i=0;$i<count($myhtml_array);$i++) {
$myhtml_array_row = explode("|", $myhtml_array[$i]);
$myhtml_array_row[1] = strtolower($myhtml_array_row[1]);
$myhtml_array_row[1] = str_replace ("\"", "", $myhtml_array_row[1]);
$myhtml_array_row[1] = str_replace (" ", "", $myhtml_array_row[1]);
$myhtml_array_row[1] = strtr("$myhtml_array_row[1]", "���������������������������������", "���������������������������������");
if(trim($myhtml_array_row[1]) == trim($temp)) { $_SESSION['error_config'] = "����� ����� �� HTML-��� ��� ����!"; }
}

if($_SESSION['error_config']) { header("Location: $_SERVER[PHP_SELF]"); exit();  } // ���� ��� ����

//--------------------------------------------------------------------------------
if(count($add_err) == 0) { // ���� ������ ��� - ���������
// ��������� ����� HTML-���
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$id_myhtml = time();
$fp=fopen("data/myhtml.dat","a");
fputs($fp, "$id_myhtml|$myhtml_description|$_POST[radio_myhtml]\r\n");
fclose($fp);
flock($lock, LOCK_UN);
fclose($lock);
$_SESSION['ok_config'] = "����� HTML-��� ������� ��������!";
header("Location: $_SERVER[PHP_SELF]");
exit();
} else {
$_SESSION['error'] = "�� ���� ������������� ��������� ���� data/base.lck !!!";
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=error.php'>
	  </HEAD></HTML>";
exit();
}
} // ����� ���� ��� ������. ���������.

} // ����� ���� ��������� HTML-���
// ------------------------------------------------------------------------------------
// ���� ������� HTML-���
if($_POST['delete_myhtml'] AND $_SESSION['owner_status']=="this_admin") {
// ���������
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$myhtml_array = file("data/myhtml.dat"); // �������� � ������
$fp=fopen("data/temp.dat","w");
for ($i=0;$i<count($myhtml_array);$i++) {
$myhtml_array_row = explode("|", $myhtml_array[$i]);
if ($myhtml_array_row[0] == $_POST['id_myhtml']) unset($myhtml_array[$i]);
}
fputs($fp,implode("",$myhtml_array));
fclose($fp);
unlink("data/myhtml.dat");
rename("data/temp.dat", "data/myhtml.dat");
flock($lock, LOCK_UN);
fclose($lock);
$_SESSION['ok_config'] = "HTML-��� ������!";
header("Location: $_SERVER[PHP_SELF]");
exit();
} else {
$_SESSION['error'] = "�� ���� ������������� ��������� ���� data/base.lck !!!";
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=error.php'>
	  </HEAD></HTML>";
exit();
}
} // ����� ���� ������� HTML-���

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
      <tr><td colspan=2 valign=top align=left>";
// ���������� ����
include "menu.php";
echo "</td></tr><tr><td colspan=2 valign=top align=left></td></tr>";
// ---------------------------------------------------------------------------------------------------------------------------------
echo "<tr><td valign=top align=left>"; // ������ ������ � ������
// ����� ��� ����� ����� HTML-�����
echo "<form action=\""."$_SERVER[PHP_SELF]"."\" method=\"POST\"><table width=100% cellspacing=0 cellpadding=0>
      <tr><td align=right valign=top width=1px><img src=images/login_lu.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_ru.gif width=8 height=8 border=0></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td class=title bgcolor=#8f95ac align=left colspan=2>����� ��� ����� ����� HTML-�����<br><br></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left nowrap width=1% valign=top>������� HTML-���:</td><td bgcolor=#8f95ac align=right valign=top><textarea name=\"myhtml_description\" rows=\"5\" cols=\"36\" style=\"width: 350px;\">"."$myhtml_description"."</textarea></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2 valign=top>��� �������� <input name=\"radio_myhtml\" type=\"radio\" value=\"IMG\"> ��� ����� <input name=\"radio_myhtml\" type=\"radio\" value=\"TXT\" checked>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name=\"add_myhtml\" type=\"submit\" value=\"��������\"><br></td><td bgcolor=#8f95ac width=1px></td></tr>";
if($add_err['check_a_eqv']) { echo "<tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2 valign=top><font color=red>"."$add_err[check_a_eqv]"."</font></td><td bgcolor=#8f95ac width=1px></td></tr>"; }
if($add_err['check_symbol_code']) { echo "<tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2 valign=top><font color=red>"."$add_err[check_symbol_code]"."</font></td><td bgcolor=#8f95ac width=1px></td></tr>"; }
if($add_err['check_links_code']) { echo "<tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2 valign=top><font color=red>"."$add_err[check_links_code]"."</font></td><td bgcolor=#8f95ac width=1px></td></tr>"; }
if($add_err['check_domen_domen']) { echo "<tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2 valign=top><font color=red>"."$add_err[check_domen_domen]"."</font></td><td bgcolor=#8f95ac width=1px></td></tr>"; }
if($add_err['check_myhome_domen']) { echo "<tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2 valign=top><font color=red>"."$add_err[check_myhome_domen]"."</font></td><td bgcolor=#8f95ac width=1px></td></tr>"; }
if($add_err['check_img_flash']) { echo "<tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2 valign=top><font color=red>"."$add_err[check_img_flash]"."</font></td><td bgcolor=#8f95ac width=1px></td></tr>"; }
if($add_err['radio_myhtml']) { echo "<tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2 valign=top><font color=red>"."$add_err[radio_myhtml]"."</font></td><td bgcolor=#8f95ac width=1px></td></tr>"; }
echo "<tr><td align=right valign=top width=1px><img src=images/login_ld.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_rd.gif width=8 height=8 border=0></td></tr>
      </table></form><br>";
// ---------------------------------------------------------------------------------------------------------------------------------
// ������ �� ����� HTML-���� � ������� ��
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$myhtml_array = file("data/myhtml.dat");
flock($lock, LOCK_UN);
fclose($lock);
} else {
$_SESSION['error'] = "�� ���� ������������� ��������� ���� data/base.lck !!!";
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=error.php'>
	  </HEAD></HTML>";
exit();
}

$all_myhtml = count($myhtml_array);

echo "<table width=100% cellspacing=0 cellpadding=0>
      <tr><td align=right valign=top width=1px><img src=images/login_lu.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_ru.gif width=8 height=8 border=0></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td class=title bgcolor=#8f95ac align=left colspan=2>��� HTML-���� ["."$all_myhtml"."]<br><br></td><td bgcolor=#8f95ac width=1px></td></tr>";

if($all_myhtml == 0) { echo "<tr><td bgcolor=#8f95ac width=1px></td><td class=title bgcolor=#8f95ac align=left colspan=2><hr>�� ������� �� ������ HTML-����!</td><td bgcolor=#8f95ac width=1px></td></tr>"; }

for($i=0;$i<$all_myhtml;$i++) {
$row_myhtml_array = explode("|", $myhtml_array[$i]);
unset($but_text);
if($row_myhtml_array) {
$id_myhtml = trim($row_myhtml_array[0]);
$myhtml_description = trim($row_myhtml_array[1]);
$radio_myhtml = trim($row_myhtml_array[2]);
if($radio_myhtml=="IMG") {$but_text = "��������";} else {$but_text = "�����";}
echo "<form action=\""."$_SERVER[PHP_SELF]"."\" method=\"POST\"><input name=\"id_myhtml\" type=\"hidden\" value=\""."$id_myhtml"."\">
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2><hr></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left nowrap valign=top><textarea name=\"myhtml_description\" rows=\"3\" cols=\"36\" style=\"width: 250px;\">"."$myhtml_description"."</textarea></td><td bgcolor=#8f95ac align=right valign=top>"."$myhtml_description"."</td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=center><input name=\"delete_myhtml\" type=\"submit\" value=\"������� "."$but_text"."\" style=\"width: 150px;\"></td><td bgcolor=#8f95ac align=center></td><td bgcolor=#8f95ac width=1px></td></tr>
	  </form>";
} // end if

} // end for
echo "<tr><td align=right valign=top width=1px><img src=images/login_ld.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_rd.gif width=8 height=8 border=0></td></tr>
      </table><br>";
// ---------------------------------------------------------------------------------------------------------------------------------
// ������ ������� ��� ������
echo "</td><td valign=top align=right>"; // ������ ������ � ������

echo "<table width=360 cellspacing=0 cellpadding=0>
      <tr><td align=right valign=top width=1px><img src=images/login_lu.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_ru.gif width=8 height=8 border=0></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td class=title bgcolor=#8f95ac align=right colspan=2>Help</td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2>";
	  
echo "<div align=justify>
<font face=Verdana size=1 color=white><b>HTML-����</b></font><br>
�� ������ �������� ����� ���������� ����� HTML-�����, ������� ������ ������������ ��� ������. 
��������� �������� � ���� ������� �� �������������, �� ��� �� ����� ������ ����� ����������� <font color=red><b>� ������������ � �����������</b></font>, 
������������� ���� ��� �������� �������� ���������� � ������� \"������������\" � ��������� �������:<br><br>
- �������� ������������ ������ ���� �� ���������� ��������, ������������� ����;<br>
- �������� ��� ��� �� ���������� ������ ������������ � ���;<br>
- �������� ������, ���������� � ���� �� ������������ ������ ������;<br>
- ��������, ��� ��� ������ ������������ � ���� ��������� �� ���� �����;<br>
- �������� ������������ ����������� � ����������� ����� � � ����� ����;<br><br>
�����������, ���� ������������� ����� ����� � ����� ���� ������� ���������� ������ (������, �������), ��� ����� ��������� ��������� ������������� � ��� �������, �� ����� �������� �������� �������� �� ������� ������ ��������� ����������� �����.
</div>";
echo "<br><br><div align=justify>
<font face=Verdana size=1 color=red><b>�������� ��������</b></font><br>
� ���������� ������������ �� ������ �������� ������� ����� ����� �� ������ ����������. ����� ����� ���������� ��������� ������� ������ �����. 
���� �������� <b>�����������</b> ������ � ����� ����� ������������ �����. ���������� ��� ��� ��������� ������������ �������.
</div>";
echo "</td><td bgcolor=#8f95ac width=1px></td></tr>
	  <tr><td align=right valign=top width=1px><img src=images/login_ld.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_rd.gif width=8 height=8 border=0></td></tr>
      </table>";

echo "</td></tr></table>";
@ignore_user_abort($old_abort);
?>
</body>
</html>