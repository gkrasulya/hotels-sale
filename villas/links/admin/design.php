<?php
error_reporting(0);
@$old_abort = ignore_user_abort(true);
session_start();
include "adminic.php";

// ��������, ��� ���������
$place = "������";
// ---------------------------------------------------------------------------------------------------------------------------------
// ���� �������� ���� main.css
if($_POST['maincss'] AND $_SESSION['owner_status']=="this_admin") {
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$fp=fopen("design/main.css","w");
fputs($fp, "$_POST[maincss]");
fclose($fp);
flock($lock, LOCK_UN);
fclose($lock);
} else {
$_SESSION['error'] = "�� ���� ������������� ��������� ���� data/base.lck !!!";
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=error.php'>
	  </HEAD></HTML>";
exit();
}
} // ����� ���� ������ ���� main.css
// ---------------------------------------------------------------------------------------------------------------------------------
// ���� �������� ���� form.css
if($_POST['formcss'] AND $_SESSION['owner_status']=="this_admin") {
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$fp=fopen("design/form.css","w");
fputs($fp, "$_POST[formcss]");
fclose($fp);
flock($lock, LOCK_UN);
fclose($lock);
} else {
$_SESSION['error'] = "�� ���� ������������� ��������� ���� data/base.lck !!!";
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=error.php'>
	  </HEAD></HTML>";
exit();
}
} // ����� ���� ������ ���� form.css
// ---------------------------------------------------------------------------------------------------------------------------------
// ���� �������� ���� header.inc
if($_POST['headerinc'] AND $_SESSION['owner_status']=="this_admin") {
$_POST['headerinc'] = stripslashes($_POST['headerinc']);
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$fp=fopen("design/header.inc","w");
fputs($fp, "$_POST[headerinc]");
fclose($fp);
flock($lock, LOCK_UN);
fclose($lock);
} else {
$_SESSION['error'] = "�� ���� ������������� ��������� ���� data/base.lck !!!";
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=error.php'>
	  </HEAD></HTML>";
exit();
}
} // ����� ���� ������ ���� header.inc
// ---------------------------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------------------------
// ���� �������� ���� footer.inc
if($_POST['footerinc'] AND $_SESSION['owner_status']=="this_admin") {
$_POST['footerinc'] = stripslashes($_POST['footerinc']);
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$fp=fopen("design/footer.inc","w");
fputs($fp, "$_POST[footerinc]");
fclose($fp);
flock($lock, LOCK_UN);
fclose($lock);
} else {
$_SESSION['error'] = "�� ���� ������������� ��������� ���� data/base.lck !!!";
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=error.php'>
	  </HEAD></HTML>";
exit();
}
} // ����� ���� ������ ���� footer.inc
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
// ������ ���� main.css
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$maincss = file("design/main.css");
flock($lock, LOCK_UN);
fclose($lock);
} else {
$_SESSION['error'] = "�� ���� ������������� ��������� ���� data/base.lck !!!";
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=error.php'>
	  </HEAD></HTML>";
exit();
}
$maincss = implode("",$maincss);
// ������� ��� �������������� ���� main.css
echo "<form action=\""."$_SERVER[PHP_SELF]"."\" method=\"POST\"><table width=560px cellspacing=0 cellpadding=0>
      <tr><td align=right valign=top width=1px><img src=images/login_lu.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_ru.gif width=8 height=8 border=0></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td class=title bgcolor=#8f95ac align=left colspan=2>���� main.css</td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=center colspan=2 valign=top><textarea name=maincss rows=10 cols=84>"."$maincss"."</textarea><br></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=center colspan=2 valign=top><input name=submit type=submit value=\"��������� ��������� � main.css\"></td><td bgcolor=#8f95ac width=1px></td></tr>
	  <tr><td align=right valign=top width=1px><img src=images/login_ld.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_rd.gif width=8 height=8 border=0></td></tr>
      </table></form>";
// ---------------------------------------------------------------------------------------------------------------------------------
// ������ ���� form.css
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$formcss = file("design/form.css");
flock($lock, LOCK_UN);
fclose($lock);
} else {
$_SESSION['error'] = "�� ���� ������������� ��������� ���� data/base.lck !!!";
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=error.php'>
	  </HEAD></HTML>";
exit();
}
$formcss = implode("",$formcss);
// ������� ��� �������������� ���� form.css
echo "<form action=\""."$_SERVER[PHP_SELF]"."\" method=\"POST\"><table width=560px cellspacing=0 cellpadding=0>
      <tr><td align=right valign=top width=1px><img src=images/login_lu.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_ru.gif width=8 height=8 border=0></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td class=title bgcolor=#8f95ac align=left colspan=2>���� form.css</td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=center colspan=2 valign=top><textarea name=formcss rows=10 cols=84>"."$formcss"."</textarea><br></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=center colspan=2 valign=top><input name=submit type=submit value=\"��������� ��������� � form.css\"></td><td bgcolor=#8f95ac width=1px></td></tr>
	  <tr><td align=right valign=top width=1px><img src=images/login_ld.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_rd.gif width=8 height=8 border=0></td></tr>
      </table></form>";
// ---------------------------------------------------------------------------------------------------------------------------------
// ������ ���� header.inc
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$headerinc = file("design/header.inc");
flock($lock, LOCK_UN);
fclose($lock);
} else {
$_SESSION['error'] = "�� ���� ������������� ��������� ���� data/base.lck !!!";
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=error.php'>
	  </HEAD></HTML>";
exit();
}
$headerinc = implode("",$headerinc);
// ������� ��� �������������� ���� form.css
echo "<form action=\""."$_SERVER[PHP_SELF]"."\" method=\"POST\"><table width=560px cellspacing=0 cellpadding=0>
      <tr><td align=right valign=top width=1px><img src=images/login_lu.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_ru.gif width=8 height=8 border=0></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td class=title bgcolor=#8f95ac align=left colspan=2>���� header.inc</td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=center colspan=2 valign=top><textarea name=headerinc rows=10 cols=84>"."$headerinc"."</textarea><br></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=center colspan=2 valign=top><input name=submit type=submit value=\"��������� ��������� � header.inc\"></td><td bgcolor=#8f95ac width=1px></td></tr>
	  <tr><td align=right valign=top width=1px><img src=images/login_ld.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_rd.gif width=8 height=8 border=0></td></tr>
      </table></form>";
// ---------------------------------------------------------------------------------------------------------------------------------
// ������ �������, ��� ����� ��� ������
echo "<table width=560px cellspacing=0 cellpadding=0>
      <tr><td align=right valign=top width=1px><img src=images/login_lu.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_ru.gif width=8 height=8 border=0></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2>� ���� �����, ������������ �������� ��������� � ����� ������������ �� ���������� ��� ������. ���� ����������� ��� ����� ���� ��� �����������.</td><td bgcolor=#8f95ac width=1px></td></tr>
	  <tr><td align=right valign=top width=1px><img src=images/login_ld.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_rd.gif width=8 height=8 border=0></td></tr>
      </table>";
// ---------------------------------------------------------------------------------------------------------------------------------
// ������ ���� footer.inc
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$footerinc = file("design/footer.inc");
flock($lock, LOCK_UN);
fclose($lock);
} else {
$_SESSION['error'] = "�� ���� ������������� ��������� ���� data/base.lck !!!";
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=error.php'>
	  </HEAD></HTML>";
exit();
}
$footerinc = implode("",$footerinc);
// ������� ��� �������������� ���� form.css
echo "<form action=\""."$_SERVER[PHP_SELF]"."\" method=\"POST\"><table width=560px cellspacing=0 cellpadding=0>
      <tr><td align=right valign=top width=1px><img src=images/login_lu.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_ru.gif width=8 height=8 border=0></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td class=title bgcolor=#8f95ac align=left colspan=2>���� footer.inc</td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=center colspan=2 valign=top><textarea name=footerinc rows=10 cols=84>"."$footerinc"."</textarea><br></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=center colspan=2 valign=top><input name=submit type=submit value=\"��������� ��������� � footer.inc\"></td><td bgcolor=#8f95ac width=1px></td></tr>
	  <tr><td align=right valign=top width=1px><img src=images/login_ld.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_rd.gif width=8 height=8 border=0></td></tr>
      </table></form>";
// ---------------------------------------------------------------------------------------------------------------------------------
echo "</td><td valign=top align=right>"; // ������ ������ � ������
// ---------------------------------------------------------------------------------------------------------------------------------
// ������ ������� ��� ������
echo "<table width=360 cellspacing=0 cellpadding=0>
      <tr><td align=right valign=top width=1px><img src=images/login_lu.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_ru.gif width=8 height=8 border=0></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td class=title bgcolor=#8f95ac align=right colspan=2>Help</td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2>";
	  
echo "<div align=justify>
<font face=Verdana size=1 color=white><b>��������� �������</b></font><br>�� ������ ��� ������ ������� ��������� ������ ������� ��� ������ ������ �����. 
��� ����� ��� ������ ����������� �������������� ������ ������ main.css (������ ������� �������� �������) � form.css (������ ����� ���������� ������), 
� ����� ������ header.inc (������� � ����� ����� ��� ������� �������� � �������� �����) � footer.inc (������ � ������ ����� ��� ������� �������� � �������� �����).<br><br>

���� <b>main.css</b> ������������ � �������� ����� ������ ��������� ������ � ��������� ����� ������� index.php � ���������� ������ ����� �����;<br><br>
���� <b>form.css</b> ������������ � �������� ����� ������ ��������� ������ � ����� ����� ���������� ������ submit.php � ��������������, ���������� ������ �����;<br><br>

� ������ ������ ��������� ������ <b>main.css</b> � <b>form.css</b> ����������� ������ ������� ����������� ��������. ������ ������� �������� ���������������.<br><br>

����� <b>header.inc</b> � <b>footer.inc</b> ������������ � ������ index.php � submit.php � ����� ��������� ���� ����������� HTML-����, ���������� �� ������������ ���������� ����� �������� (���� ����, ��������� �����, ����� ���������� � �.�.).<br><br>
<b><font color=red><�������� ��������></font></b> � ���� <b>header.inc</b> �� ������ ������������ ���������, �������� ����� � �������� ��� ������ ������� �������. ����� ��, � ���������, �� ������ ���������� �������������� ����� ������. ��� &lt;BODY&gt; ����������� ����� ��.<br><br>
<b><font color=red><�������� ��������></font></b> ���� <b>footer.inc</b> �� ������ ��������� ����������� ����� &lt;/BODY&gt; � &lt;/HTML&gt;. ��� ����� ������� �����, � ������ ������ �������.

</div>";


echo "</td><td bgcolor=#8f95ac width=1px></td></tr>
	  <tr><td align=right valign=top width=1px><img src=images/login_ld.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_rd.gif width=8 height=8 border=0></td></tr>
      </table>";

echo "</td></tr></table>";
@ignore_user_abort($old_abort);
?>
</body>
</html>