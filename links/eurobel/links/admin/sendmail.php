<?php
error_reporting(0);
session_start();
include "adminic.php";
include "functions/cut.php";
// ��������, ��� ���������
$place = "�������� �����";
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


if($_POST['sendmail']=="���������" AND $_POST['choose_letter']!="none" AND count($_POST['id'])!=0 AND $_SESSION['owner_status']=="this_admin") {
$flg = "0"; // ������� ������ � ���������
// �������� ������ ����
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
if(substr_count($_SERVER[HTTP_REFERER], "links_moder.php")!=0) {
$base_array = file("data/moder.dat");
$flg = "mdr";
$link_place = "�� ���������. ��� ����������� ������!";
} else {
$base_array = file("data/base.dat");
}
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

// ����� ������
for($i=12;$i<=15;$i++) {
   $path_t[$i] = "letters/t"."$i".".txt";
   $letter_title[$i] = file("$path_t[$i]");
   $letter_title[$i] = implode("",$letter_title[$i]);
      if(trim($letter_title[$i])==trim($_POST['choose_letter'])) {
	     $path_m[$i] = "letters/m"."$i".".txt";
         $letter_message[$i] = file("$path_m[$i]");
         $message = implode("",$letter_message[$i]);
         $path_s[$i] = "letters/s"."$i".".txt";
         $letter_subject[$i] = file("$path_s[$i]");
         $subject = implode("",$letter_subject[$i]);
	     break;
	  }
} // end for

// ���� ���-�� ������� - ���� ������
echo "<table width=540px cellspacing=0 cellpadding=0>
      <tr><td align=right valign=top width=1px><img src=images/login_lu.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_ru.gif width=8 height=8 border=0></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td class=title bgcolor=#8f95ac align=left colspan=2>��� ������<br></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2><hr></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left nowrap width=1% valign=top>���� ������:</td><td bgcolor=#8f95ac align=right><input name=\"subject\" type=\"text\" maxlength=\"72\" style=\"width:400px;\" value=\""."$subject"."\"></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left nowrap width=1% valign=top>����� ������:</td><td bgcolor=#8f95ac align=right><textarea name=\"message\" rows=\"4\" cols=\"64\" style=\"width:400px;\">"."$message"."</textarea></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2><hr></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td class=title bgcolor=#8f95ac align=left colspan=2>���������� �� ��������� �������:<br><br></td><td bgcolor=#8f95ac width=1px></td></tr>";

// ���������� ������ id
$_POST[id] = array_values($_POST['id']);
// ����� ��������� � �������� �����
$num = count($base_array);
for($i=0;$i<$num;$i++) {
$row_base = explode("|", $base_array[$i]);
if(in_array($row_base[0], $_POST[id])) {

if($flg!="mdr") {
// ��������� LINK_PLACE
// *****************************************************************************
// ������� ID ��������� ��� ������� ������
for($k=0;$k<count($categories_array);$k++){
$row_categories=explode("|", $categories_array[$k]);
if($row_base[4]==$row_categories[1]) { $category = "$row_categories[0]"; break; }
}
// ���������� ���� (��� ��� ������ ���������)
$pos=strpos("$_SERVER[REQUEST_URI]", "/admin/sendmail.php");
$string=substr("$_SERVER[REQUEST_URI]", 0, $pos);
// �������� ��� ������ ���� ��������� �� ��������� ������
$total_in_category = 0;
for($m=0;$m<count($base_array);$m++) {
$link_in_base = explode("|", $base_array[$m]);
if($link_in_base[4] == $row_base[4]) { $tmp_category_array[$total_in_category] = "$base_array[$m]"; $total_in_category++; }
}
// ���� �� ����� ����� � ���� ��������� ������� ������
$row_in_category = 0;
for($n=0;$n<count($tmp_category_array);$n++) {
$link_in_page = explode("|", $tmp_category_array[$n]);
if($link_in_page[0] != $row_base[0]) { $row_in_category++; } else { $row_in_category++; break; }
}
// ���������� ��������, �� ������� ��������� ������� ������ � ���� ���������
$page = ceil($row_in_category/$_SESSION['imp_links_page']);
// ��������� ������ URL ������� ������ � ��������
if($_SESSION['imp_mode_url']=="�����������") {
$link_place="http://"."$_SERVER[HTTP_HOST]"."$string"."/links_"."$category"."_"."$page".".html";
} else {
$link_place="http://"."$_SERVER[HTTP_HOST]"."$string"."/index.php?category="."$category&page="."$page";
}
// *****************************************************************************
} // end flg

// ���������� ������
$msg = str_replace(NICK_NAME, $row_base[1], "$message");
$msg = str_replace(LINK_PLACE, $link_place, "$msg");
$msg = str_replace(BACK_LINK, $row_base[2], "$msg");
$msg = str_replace(OUT_LINKS, $row_base[9], "$msg");
$msg = str_replace(SITE_CY, $row_base[10], "$msg");
$msg = str_replace(PAGE_PR, $row_base[11], "$msg");
$msg = str_replace(IMP_MYHOME, $_SESSION[imp_myhome], "$msg");
$msg = str_replace(ADM_E_MAIL, $_SESSION[adm_e_mail], "$msg");
$msg = str_replace(ADM_COMMENT, $row_base[18], "$msg");

switch($_SESSION['adm_out_mail']) {
case "koi8-r":
$subject = convert_cyr_string($subject, "w", "k");
$msg = convert_cyr_string($msg, "w", "k");
$charset = "koi8-r";
break;
case "iso-8859":
$subject = convert_cyr_string($subject, "w", "i");
$msg = convert_cyr_string($msg, "w", "i");
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
mail($row_base[3], "$subject", "$msg", "$headmail");

// ������� ���������
$site = parse_url($row_base[2]);
$site = "$site[host]";
$site = "http://"."$site";
echo "<tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left nowrap width=1%>"."$row_base[3]"."&nbsp;&nbsp;&nbsp;</td><td bgcolor=#8f95ac align=left>���� <a href=\""."$site"."\" target=_blank>"."$site"."</a></td><td bgcolor=#8f95ac width=1px></td></tr>";

} // end if in_array
} // end for ������ ������� � �������� �����

echo "<tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2><hr></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=right colspan=2><a href=\""."$_POST[back]"."\">���������</a></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td align=right valign=top width=1px><img src=images/login_ld.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_rd.gif width=8 height=8 border=0></td></tr>
      </table><br>";
	  
} else { // ���� ����-�� �� �������

echo "<table width=540px cellspacing=0 cellpadding=0>
      <tr><td align=right valign=top width=1px><img src=images/login_lu.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_ru.gif width=8 height=8 border=0></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td class=title bgcolor=#8f95ac align=left colspan=2><font color=red>������!</font><br></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2><hr></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2>�� ������� �� ������ �������� ��� �� ������� ������!</td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2><hr></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=right colspan=2><a href=\""."$_POST[back]"."\">���������</a></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td align=right valign=top width=1px><img src=images/login_ld.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_rd.gif width=8 height=8 border=0></td></tr>
      </table><br>";
	  
}
// ---------------------------------------------------------------------------------------------------------------------------------
// ������ ������� ��� ������
echo "</td><td valign=top align=right>"; // ������ ������ � ������

echo "<table width=360 cellspacing=0 cellpadding=0>
      <tr><td align=right valign=top width=1px><img src=images/login_lu.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_ru.gif width=8 height=8 border=0></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td class=title bgcolor=#8f95ac align=right colspan=2>Help</td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left colspan=2>";
	  
echo "<div align=justify>
<font face=Verdana size=1 color=white><b>������ ����������</b></font><br>
�� ���� �������� ��������� ���� � ����� ������������ �����, � ����� ������ ������ � e-mail �������, ���� ��� ���� ����������. 
</div>";

echo "</td><td bgcolor=#8f95ac width=1px></td></tr>
	  <tr><td align=right valign=top width=1px><img src=images/login_ld.gif width=8 height=8 border=0></td><td colspan=2 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_rd.gif width=8 height=8 border=0></td></tr>
      </table>";

echo "</td></tr></table>";
?>
</body>
</html>