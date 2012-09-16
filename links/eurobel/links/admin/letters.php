<?php
error_reporting(0);
session_start();
include "adminic.php";
include "functions/cut.php";
// ��������, ��� ���������
$place = "������";
// -----------------------------------------------------------------------------

// -----------------------------------------------------------------------------
// ���� ����������� ������
if($_POST['edit_letter'] AND $_POST['id_letter'] AND $_SESSION['owner_status']=="this_admin") {
$id = trim($_POST['id_letter']);
$title_message = Cut_All_All($_POST['title_message']);
$message = trim(stripslashes($_POST['message']));
$subject = Cut_All_All($_POST['subject']);
$onoff_letter = trim($_POST['onoff_letter']);

if(!$subject||!$message||!$title_message) {
$add_error_empty = "��� ���� ����� ����������� ��� ����������!";
unset($title_message);
unset($message);
unset($subject);
} else {
unset($add_error_empty);
}

if(!$add_error_empty) {
// ����������� ������
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {

$path_t = "letters/t"."$id".".txt";
$path_s = "letters/s"."$id".".txt";
$path_m = "letters/m"."$id".".txt";
$path_w = "letters/w"."$id".".txt";

$ft=fopen("$path_t","w");
$fs=fopen("$path_s","w");
$fm=fopen("$path_m","w");
$fw=fopen("$path_w","w");

fputs($ft, "$title_message\r\n");
fputs($fs, "$subject\r\n");
fputs($fm, "$message\r\n");
fputs($fw, "$onoff_letter\r\n");

fclose($ft);
fclose($fs);
fclose($fm);
fclose($fw);

flock($lock, LOCK_UN);
fclose($lock);
$_SESSION['ok_config'] = "������ ������� ���������������!";
header("Location: $_SERVER[PHP_SELF]");
exit();
} else {
$_SESSION['error'] = "�� ���� ������������� ��������� ���� data/base.lck !!!";
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=error.php'>
	  </HEAD></HTML>";
exit();
}
}
}
// ���� ����������� ������
// -----------------------------------------------------------------------------

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
	  
// ---------------------------------------------------------------------------------------------------------------------------------
// ���� ���� ������ - ����������
if($add_error_empty) {
echo "<table width=100% cellspacing=0 cellpadding=0>
      <tr><td align=right valign=top width=1px><img src=images/login_lu.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_ru.gif width=8 height=8 border=0></td></tr>
	  <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2><font color=red><b>������!</b><hr>"."$add_error_empty"."</font></td><td bgcolor=#8f95ac width=1px></td></tr>
	  <tr><td align=right valign=top width=1px><img src=images/login_ld.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_rd.gif width=8 height=8 border=0></td></tr>
      </table><br>";
}
// ---------------------------------------------------------------------------------------------------------------------------------
// ������ �� ������ ������, ����, �������� � ������� ��
echo "<table width=100% cellspacing=0 cellpadding=0>
      <tr><td align=right valign=top width=1px><img src=images/login_lu.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_ru.gif width=8 height=8 border=0></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td class=title bgcolor=#8f95ac align=left colspan=2>������� ����� �������������� [15]<br><br></td><td bgcolor=#8f95ac width=1px></td></tr>";

for($i=1;$i<=15;$i++) {
$path_m[$i] = "letters/m"."$i".".txt";
$letter_message[$i] = file("$path_m[$i]");
$letter_message[$i] = implode("",$letter_message[$i]);
$path_s[$i] = "letters/s"."$i".".txt";
$letter_subject[$i] = file("$path_s[$i]");
$letter_subject[$i] = implode("",$letter_subject[$i]);
$path_t[$i] = "letters/t"."$i".".txt";
$letter_title[$i] = file("$path_t[$i]");
$letter_title[$i] = implode("",$letter_title[$i]);
$path_w[$i] = "letters/w"."$i".".txt";
$letter_swith[$i] = file("$path_w[$i]");
$letter_swith[$i] = implode("",$letter_swith[$i]);
if(trim($letter_swith[$i])=="on") { $checked = "checked"; } else { $checked = ""; }


echo "<form action=\""."$_SERVER[PHP_SELF]"."\" method=\"POST\">
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2><hr></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=right nowrap width=1% valign=top colspan=2><b>ID: "."$i"."</b></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left nowrap width=1% valign=top>�������� ������:<br>(��� ��������������)</td><td bgcolor=#8f95ac align=right><input name=\"title_message\" type=\"text\" maxlength=\"36\" style=\"width:400px; font-weight:bold;\" value=\""."$letter_title[$i]"."\"></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left nowrap width=1% valign=top>���� ������:</td><td bgcolor=#8f95ac align=right><input name=\"subject\" type=\"text\" maxlength=\"72\" style=\"width:285px;\" value=\""."$letter_subject[$i]"."\"><input name=\"edit_letter\" type=\"submit\" style=\"width:50px;\" value=\"Edit\">&nbsp;On/Off&nbsp;<input name=\"onoff_letter\" type=\"checkbox\" style=\"width:20px;\" "."$checked"."></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left nowrap width=1% valign=top>����� ������:</td><td bgcolor=#8f95ac align=right><textarea name=\"message\" rows=\"4\" cols=\"64\" style=\"width:400px;\">"."$letter_message[$i]"."</textarea><input name=\"id_letter\" type=\"hidden\" value=\""."$i"."\"></td><td bgcolor=#8f95ac width=1px></td></tr>
	  </form>";

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
<font face=Verdana size=1 color=white><b>������� ����� ��������������</b></font><br>
������������� 15 �������� ����� ������������ �������� �� ����� ��������������.
��� ������� �����������. ��� ����, ����� ��������������� ������ ������������ - ����������, ����� \"��������\" ��� ������� ��� checkbox.<br><br>
������� � 1 �� 11 ���������, ������� ������������ � ������� ������������ �������. ������� � 12 �� 15 ������������� �������� ����� ������������ �� ������ ���������� ��� �������� ����� �������������.<br><br>
��� ���� ����� ��������������� ������, ������� � ���� ��������� � ������� \"Edit\".
</div>";
echo "<div align=justify>
<font face=Verdana size=1 color=red><br><b>< �������� �������� ></b></font><br>
������� � 1 �� 11 \"����������\" �� ������������ ��������. �� ��������� ��� ������������ �� ��������� �������������! ������ ������������ ������� � �������� ����� �� ������� ����.<br><font color=red>��������! ������ ����� ���� ������ ��� �������. ��� ������������� �� ���������� ��������������� ��� ����� ���! ����� ������ ������ ������������ �������������, ��� ���������� ��������!</font><br><br>
</div>";
echo "<div align=justify>
<font face=Verdana size=1 color=white><b>������������ ������� ������ �������</b></font><br>
<b>ID1</b> - ������������� �������� �������������� ������� ������ - ������ ����� ���������� �� �������� ����� ������������, ���� �� �������� ��������������;<br>
<b>ID2</b> - ������������� �������� ������ ������ � ������� - ������ ����� ���������� �� �������� ����� ������������, ���� �� ������������ � ����;<br>
<b>ID3</b> - ������������� �������� �������� ����� ������ - ������ ����� ���������� �� �������� ����� ������������, ���� �� ������������ � ����;<br>
<b>ID4</b> - � ������� ��������� ������ (��� �������, ���� ��������� ������������� ���������� ����� � �������) - ������ ����� ���������� �������������� ��������;<br>
<b>ID5</b> - �� ��������� ��������� ������ (��� �������, ���� ��������� ������������� ���������� �� ���������) - ������ ����� ���������� �������������� ��������;<br>
<b>ID6</b> - � ������� ��������� ������ (��� �������, ���� ��������� ������������� ���������� ����� � �������) - ������ ����� ���������� �� �������� ����� ������������, ��������� ��� ���������� � �������;<br>
<b>ID7</b> - ������ ��������� �� ��������� (��� �������, ���� ��������� ������������� ���������� �� ���������) - ������ ����� ���������� �� �������� ����� ������������, ��������� ��� ���������� � �������;<br>
<b>ID8</b> - ������ ������� ������ ��������� (��� �������, ���� ��������� ������������� ���������� �� ���������) - ������ ����� ���������� �� �������� ����� ������������, ��������� ��� ���������� � �������;<br>
<b>ID9</b> - ������ �������������� (���� ��� ���� ����� �� �����-���� ������� ������ ���������������) - ������ ����� ���������� �� �������� ����� ������������, ��������� ��� ���������� � �������;<br>
<b>ID10</b> - ������ �������� ��������������� � ����-���� �������� - ������ ����� ���������� �� �������� ����� ������������, ��������� ��� ���������� � �������;<br>
<b>ID11</b> - �������� ��������� ������ � �������� - ������ ����� ���������� �� �������� ����� ������������, ��������� ��� ���������� � �������;<br><br>
</div>";
echo "<div align=justify>
<font face=Verdana size=1 color=white><b>������������� ������ � ��������</b></font><br>
� ������� ������ ������, ������� ��������� ������� ��������������, �� ������ ������������ ��� �������������� ����������� � ���� ������ ��������� ������:<br><br>
<b>IMP_MYHOME</b> - ����� ������ �����;<br>
<b>ADM_E_MAIL</b> - e-mail �������������� ��������;<br>
<b>LINK_PLACE</b> - ����� ������ �������� � ����� ��������;<br>
<b>BACK_LINK</b> - ����� �������� ������ �� ��� ����;<br>
<b>NICK_NAME</b> - ��� ��� ������� �������� �� ������;<br>
<b>OUT_LINKS</b> - ���-�� ������ �� ����������� ��������;<br>
<b>PAGE_PR</b> - PR Google ��� ����������� ��������;<br>
<b>SITE_CY</b> - CY Yandex ��� ����� �������� �� ������;<br>
<b>ADM_COMMENT</b> - ����������� �������������� ��������;<br>
</div>";

echo "</td><td bgcolor=#8f95ac width=1px></td></tr>
	  <tr><td align=right valign=top width=1px><img src=images/login_ld.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_rd.gif width=8 height=8 border=0></td></tr>
      </table>";

echo "</td></tr></table>";

?>
</body>
</html>