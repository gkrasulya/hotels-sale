<?php
error_reporting(0);
@$old_abort = ignore_user_abort(true);
session_start();
include "adminic.php";
// ��������, ��� ���������
$place = "BACKUP";

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
// ����� ��� ����� ����� �����
if(!$_POST['backup']) { // ���� ��� ������� ������ - ������� ������ �����

echo "<form action=\""."$_SERVER[PHP_SELF]"."\" method=\"POST\"><table width=560 cellspacing=0 cellpadding=0>
      <tr><td align=right valign=top width=1px><img src=images/login_lu.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_ru.gif width=8 height=8 border=0></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td class=title bgcolor=#8f95ac align=left colspan=2>��������� ����������� ������ ������<br><br></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>��������� ��� ��������� ����������� �����������:</td><td bgcolor=#8f95ac align=right><input style=\"background-color: #afb5cc;\" type=text size=19 value=\""."$_SESSION[adm_backup_time]"."\"></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2><HR></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2><br>LinkExchanger 2.0 ������� ��� ��� ��������� ����� ���� ������ ������<br><br></td><td bgcolor=#8f95ac width=1px></td></tr>
	  <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2><HR></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=center colspan=2><input name=backup type=submit value=���������></td><td bgcolor=#8f95ac width=1px></td></tr>
	  <tr><td align=right valign=top width=1px><img src=images/login_ld.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_rd.gif width=8 height=8 border=0></td></tr>
      </table></form><br>";
} else { // ���� ��� ������ ������ �� ���������� �����������

$backup_time = time();
$backup_time = date("Y-m-d H:i:s", "$backup_time"); // ����� �������� ��������� �����
$lock = fopen("data/lock.dat","a"); // ���������
if(flock($lock, LOCK_EX)) {
copy("data/base.dat", "backup/base.dat"); // ������� ��������� ����� ������ data
copy("data/black.dat", "backup/black.dat");
copy("data/categories.dat", "backup/categories.dat");
copy("data/hosting.dat", "backup/hosting.dat");
copy("data/moder.dat", "backup/moder.dat");
copy("data/myhtml.dat", "backup/myhtml.dat");
copy("data/rules.dat", "backup/rules.dat");
copy("data/trash.dat", "backup/trash.dat");

copy("design/footer.inc", "backup/footer.inc"); // ������� ��������� ����� ������ design
copy("design/header.inc", "backup/header.inc");
copy("design/form.css", "backup/form.css");
copy("design/main.css", "backup/main.css");

copy("letters/m1.txt", "backup/m1.txt"); // ������� ��������� ����� ������ letters
copy("letters/s1.txt", "backup/s1.txt");
copy("letters/t1.txt", "backup/t1.txt");
copy("letters/w1.txt", "backup/w1.txt");

copy("letters/m2.txt", "backup/m2.txt");
copy("letters/s2.txt", "backup/s2.txt");
copy("letters/t2.txt", "backup/t2.txt");
copy("letters/w2.txt", "backup/w2.txt");

copy("letters/m3.txt", "backup/m3.txt");
copy("letters/s3.txt", "backup/s3.txt");
copy("letters/t3.txt", "backup/t3.txt");
copy("letters/w3.txt", "backup/w3.txt");

copy("letters/m4.txt", "backup/m4.txt");
copy("letters/s4.txt", "backup/s4.txt");
copy("letters/t4.txt", "backup/t4.txt");
copy("letters/w4.txt", "backup/w4.txt");

copy("letters/m5.txt", "backup/m5.txt");
copy("letters/s5.txt", "backup/s5.txt");
copy("letters/t5.txt", "backup/t5.txt");
copy("letters/w5.txt", "backup/w5.txt");

copy("letters/m6.txt", "backup/m6.txt");
copy("letters/s6.txt", "backup/s6.txt");
copy("letters/t6.txt", "backup/t6.txt");
copy("letters/w6.txt", "backup/w6.txt");

copy("letters/m7.txt", "backup/m7.txt");
copy("letters/s7.txt", "backup/s7.txt");
copy("letters/t7.txt", "backup/t7.txt");
copy("letters/w7.txt", "backup/w7.txt");

copy("letters/m8.txt", "backup/m8.txt");
copy("letters/s8.txt", "backup/s8.txt");
copy("letters/t8.txt", "backup/t8.txt");
copy("letters/w8.txt", "backup/w8.txt");

copy("letters/m9.txt", "backup/m9.txt");
copy("letters/s9.txt", "backup/s9.txt");
copy("letters/t9.txt", "backup/t9.txt");
copy("letters/w9.txt", "backup/w9.txt");

copy("letters/m10.txt", "backup/m10.txt");
copy("letters/s10.txt", "backup/s10.txt");
copy("letters/t10.txt", "backup/t10.txt");
copy("letters/w10.txt", "backup/w10.txt");

copy("letters/m11.txt", "backup/m11.txt");
copy("letters/s11.txt", "backup/s11.txt");
copy("letters/t11.txt", "backup/t11.txt");
copy("letters/w11.txt", "backup/w11.txt");

copy("letters/m12.txt", "backup/m12.txt");
copy("letters/s12.txt", "backup/s12.txt");
copy("letters/t12.txt", "backup/t12.txt");
copy("letters/w12.txt", "backup/w12.txt");

copy("letters/m13.txt", "backup/m13.txt");
copy("letters/s13.txt", "backup/s13.txt");
copy("letters/t13.txt", "backup/t13.txt");
copy("letters/w13.txt", "backup/w13.txt");

copy("letters/m14.txt", "backup/m14.txt");
copy("letters/s14.txt", "backup/s14.txt");
copy("letters/t14.txt", "backup/t14.txt");
copy("letters/w14.txt", "backup/w14.txt");

copy("letters/m15.txt", "backup/m15.txt");
copy("letters/s15.txt", "backup/s15.txt");
copy("letters/t15.txt", "backup/t15.txt");
copy("letters/w15.txt", "backup/w15.txt");

copy("config/cnfcheckinfo.dat", "backup/cnfcheckinfo.dat"); // ������� ��������� ����� ������ config
copy("config/cnfcron.dat", "backup/cnfcron.dat");
copy("config/cnfimp.dat", "backup/cnfimp.dat");
copy("config/cnfvisual.dat", "backup/cnfvisual.dat");
copy("config/password.dat", "backup/password.dat");

$tmp=fopen("config/tmp.dat","w"); // ������������ ���� �������� ��������������
fputs($tmp, "$_SESSION[adm_row_page]|$_SESSION[adm_in_mail]|$_SESSION[adm_out_mail]|$_SESSION[adm_e_mail]|$_SESSION[adm_sort]|$_SESSION[adm_old_link]|$_SESSION[adm_cy]|$_SESSION[adm_pr]|$_SESSION[adm_out_links]|$backup_time|$_SESSION[adm_sort_select]|$_SESSION[adm_sort_2]|$_SESSION[adm_new_link]|$_SESSION[adm_need_link]\r\n");
fclose($tmp);
unlink("config/cnfadm.dat");
rename("config/tmp.dat", "config/cnfadm.dat");

copy("config/cnfadm.dat", "backup/cnfadm.dat");

flock($lock, LOCK_UN);
fclose($lock); // ������� ����������

$_SESSION['adm_backup_time'] = "$backup_time"; // ��������� ����� ����� �������� ����� � ������
} else { $err = "�� ���� ������������� ��������� ���� lock.dat!!!";}

// � ������ ������� �����������
echo "<table width=560 cellspacing=0 cellpadding=0>
      <tr><td align=right valign=top width=1px><img src=images/login_lu.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_ru.gif width=8 height=8 border=0></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td class=title bgcolor=#8f95ac align=left colspan=2>��������� ����������� ������ ������ ������� ���������!<br><br></td><td bgcolor=#8f95ac width=1px></td></tr>";
	  
if(!empty($err)) {
echo "<tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2><font color=red>������! "."$err"."</font></td><td bgcolor=#8f95ac width=1px></td></tr>";
} else {
echo "<tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2>������� ��������� ����� ������ ������:</td><td bgcolor=#8f95ac width=1px></td></tr>
          <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2><HR></td><td bgcolor=#8f95ac width=1px></td></tr>
          <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left nowrap width=40%>backup/base.dat</td><td bgcolor=#8f95ac align=left>�������� ���� ���� ������</td><td bgcolor=#8f95ac width=1px></td></tr>
          <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left nowrap width=40%>backup/black.dat</td><td bgcolor=#8f95ac align=left>���� ����-�����</td><td bgcolor=#8f95ac width=1px></td></tr>
          <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left nowrap width=40%>backup/categories.dat</td><td bgcolor=#8f95ac align=left>���� �������� � ����������</td><td bgcolor=#8f95ac width=1px></td></tr>
          <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left nowrap width=40%>backup/hosting.dat</td><td bgcolor=#8f95ac align=left>���� �������� � ���������� ���������</td><td bgcolor=#8f95ac width=1px></td></tr>
          <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left nowrap width=40%>backup/moder.dat</td><td bgcolor=#8f95ac align=left>���� ������, ����������� �� ���������</td><td bgcolor=#8f95ac width=1px></td></tr>
          <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left nowrap width=40%>backup/myhtml.dat</td><td bgcolor=#8f95ac align=left>���� HTML-�����</td><td bgcolor=#8f95ac width=1px></td></tr>
          <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left nowrap width=40%>backup/rules.dat</td><td bgcolor=#8f95ac align=left>���� - ������� ���������� � �������</td><td bgcolor=#8f95ac width=1px></td></tr>
          <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left nowrap width=40%>backup/trash.dat</td><td bgcolor=#8f95ac align=left>���� �������</td><td bgcolor=#8f95ac width=1px></td></tr>
          <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left nowrap width=40%>backup/footer.inc</td><td bgcolor=#8f95ac align=left>���� ������� ������� ����� ��������</td><td bgcolor=#8f95ac width=1px></td></tr>
          <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left nowrap width=40%>backup/header.inc</td><td bgcolor=#8f95ac align=left>���� ������� ������ ����� ��������</td><td bgcolor=#8f95ac width=1px></td></tr>
          <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left nowrap width=40%>backup/form.css</td><td bgcolor=#8f95ac align=left>���� ������ ����� ���������� ������</td><td bgcolor=#8f95ac width=1px></td></tr>
          <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left nowrap width=40%>backup/main.css</td><td bgcolor=#8f95ac align=left>���� ������ ������� ��������</td><td bgcolor=#8f95ac width=1px></td></tr>
          <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left nowrap width=40%>backup/cnfcheckinfo.dat</td><td bgcolor=#8f95ac align=left>���� �������� �������� ����������</td><td bgcolor=#8f95ac width=1px></td></tr>
          <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left nowrap width=40%>backup/cnfcron.dat</td><td bgcolor=#8f95ac align=left>���� �������� Cron'a</td><td bgcolor=#8f95ac width=1px></td></tr>
          <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left nowrap width=40%>backup/cnfimp.dat</td><td bgcolor=#8f95ac align=left>���� ��������� ��������</td><td bgcolor=#8f95ac width=1px></td></tr>
          <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left nowrap width=40%>backup/cnfvisual.dat</td><td bgcolor=#8f95ac align=left>���� ���������� ��������</td><td bgcolor=#8f95ac width=1px></td></tr>
          <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left nowrap width=40%>backup/password.dat</td><td bgcolor=#8f95ac align=left>���� ������/������</td><td bgcolor=#8f95ac width=1px></td></tr>
          <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left nowrap width=40%>backup/cnfadm.dat</td><td bgcolor=#8f95ac align=left>���� �������� ��������������</td><td bgcolor=#8f95ac width=1px></td></tr>
          <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left nowrap width=40%>backup/m1.txt - m15.txt</td><td bgcolor=#8f95ac align=left valign=top rowspan=4>����� �������� �����</td><td bgcolor=#8f95ac width=1px rowspan=4></td></tr>
          <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left nowrap width=40%>backup/s1.txt - s15.txt</td>
          <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left nowrap width=40%>backup/t1.txt - t15.txt</td>
          <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left nowrap width=40%>backup/w1.txt - w15.txt</td>
          <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2><HR></td><td bgcolor=#8f95ac width=1px></td></tr>
          <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=right colspan=2>���� � ����� ��������: $backup_time</td><td bgcolor=#8f95ac width=1px></td></tr>";
}
	  

echo "<tr><td align=right valign=top width=1px><img src=images/login_ld.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_rd.gif width=8 height=8 border=0></td></tr>
      </table><br>";
unset($err);
}
// ---------------------------------------------------------------------------------------------------------------------------------

// ---------------------------------------------------------------------------------------------------------------------------------
// ������ ������� ��� ������
echo "</td><td valign=top align=right>"; // ������ ������ � ������

echo "<table width=360 cellspacing=0 cellpadding=0>
      <tr><td align=right valign=top width=1px><img src=images/login_lu.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_ru.gif width=8 height=8 border=0></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td class=title bgcolor=#8f95ac align=right colspan=2>Help</td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2>";
	  
echo "<div align=justify>
<font face=Verdana size=1 color=white><b>������� Back-Up</b></font><br>�� ������ ��������� ��������� ����������� ������, ���������� ���� ������. ������ ������� ��������� ����� ������ ������, ������� ����� �������� � ����� <b>backup</b>. �������������� ����� FTP-��������, ����� ��������� ��������� ����� ������ �� ���� ��������� � � ������ ������������� �� ������ ������� ��� ������ ������� ������������ ������ �� ��������� ����� ������.
</div>";
echo "<div align=justify>
<font face=Verdana size=1 color=white><b>��� ������������ ����� �� ��������� �����</b></font><br>������� ������� �� ������ ������� �� �����, ������� �� ������ ��������. �����, ��������� ������ ��������� ����� ������ � ��������������� ����� � ���������� �� ��� ����� ������� - 666.
</div>";

echo "</td><td bgcolor=#8f95ac width=1px></td></tr>
	  <tr><td align=right valign=top width=1px><img src=images/login_ld.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_rd.gif width=8 height=8 border=0></td></tr>
      </table>";

echo "</td></tr></table>";
@ignore_user_abort($old_abort);
?>
</body>
</html>