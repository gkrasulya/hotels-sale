<?php
error_reporting(0);
@$old_abort = ignore_user_abort(true);
session_start();
include "adminic.php";
include "functions/check.php";
include "functions/cut.php";
include "functions/main.php";
// ��������, ��� ���������
$place = "�����";
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
echo "</td></tr><tr><td colspan=2 valign=top align=left></td></tr>
      <tr><td valign=top align=left>";
// ---------------------------------------------------------------------------------------------------------------------------------
// ������� ��������� ������ ��� ������� ��������� �� �������� ��������� �� ������� ������
$total_rows = 0;

$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$base_array = file("data/base.dat");
$categories_array = file("data/categories.dat");
$trash_array = file("data/trash.dat");
$black_array = file("data/black.dat");
$moder_array = file("data/moder.dat");
flock($lock, LOCK_UN);
fclose($lock);
} else {
$_SESSION['error'] = "�� ���� ������������� ��������� ���� data/base.lck !!!";
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=error.php'>
	  </HEAD></HTML>";
exit();
}

$all_categories = count($categories_array);
// ���������� �� �������� ---------------------------------------
$tmp = array();
for($h=0;$h<$all_categories;$h++) { // ����� ���� ��� ����������
list($id_category,$category_name,$category_keywords,$category_description) = explode("|", $categories_array[$h]);
$tmp[$h] = array (field => $category_name, ext1 => $id_category, ext2 => "$category_keywords|$category_description");
}
sort($tmp, SORT_REGULAR); // ����������
for($h=0;$h<count($tmp);$h++) { // �������� ���������������� �������
$categories_array[$h] = ("{$tmp[$h][ext1]}"."|"."{$tmp[$h][field]}"."|"."{$tmp[$h][ext2]}");
}
unset($tmp);
// ���������� �� �������� ---------------------------------------

// -----------------------------------------------------------------------------
if($_SESSION['adm_sort_select']=="��") { // ���� ���. �� ���� ��������

// ���������� ���� �� ���� ��������---------------------------------------
$tmp = array();
for($h=0;$h<count($base_array);$h++) { // ����� ���� ��� ����������
list($id,$nick,$urlink,$mail,$category,$htmltext,$htmlimage,$check_date,$check_result,$check_out_links,$check_cy,$check_pr,$check_pr_main,$check_tag_noindex,$check_meta_robots,$check_file_robots,$status,$ip_user,$admin_comment) = explode("|", $base_array[$h]);
$tmp[$h] = array (field => $check_date, ext1 => "$id|$nick|$urlink|$mail|$category|$htmltext|$htmlimage", ext2 => "$check_result|$check_out_links|$check_cy|$check_pr|$check_pr_main|$check_tag_noindex|$check_meta_robots|$check_file_robots|$status|$ip_user|$admin_comment");
}
sort($tmp, SORT_REGULAR); // ����������
for($h=0;$h<count($tmp);$h++) { // �������� ���������������� �������
$base_array[$h] = ("{$tmp[$h][ext1]}"."|"."{$tmp[$h][field]}"."|"."{$tmp[$h][ext2]}");
}
unset($tmp);
// ���������� ���� �� ���� �������� ---------------------------------------
// ���������� ������� �� ���� ��������---------------------------------------
$tmp = array();
for($h=0;$h<count($trash_array);$h++) { // ����� ���� ��� ����������
list($id,$nick,$urlink,$mail,$category,$htmltext,$htmlimage,$check_date,$check_result,$check_out_links,$check_cy,$check_pr,$check_pr_main,$check_tag_noindex,$check_meta_robots,$check_file_robots,$status,$ip_user,$admin_comment) = explode("|", $trash_array[$h]);
$tmp[$h] = array (field => $check_date, ext1 => "$id|$nick|$urlink|$mail|$category|$htmltext|$htmlimage", ext2 => "$check_result|$check_out_links|$check_cy|$check_pr|$check_pr_main|$check_tag_noindex|$check_meta_robots|$check_file_robots|$status|$ip_user|$admin_comment");
}
sort($tmp, SORT_REGULAR); // ����������
for($h=0;$h<count($tmp);$h++) { // �������� ���������������� �������
$trash_array[$h] = ("{$tmp[$h][ext1]}"."|"."{$tmp[$h][field]}"."|"."{$tmp[$h][ext2]}");
}
unset($tmp);
// ���������� ������� �� ���� �������� ---------------------------------------
// ���������� ����-����� �� ���� ��������---------------------------------------
$tmp = array();
for($h=0;$h<count($black_array);$h++) { // ����� ���� ��� ����������
list($id,$nick,$urlink,$mail,$category,$htmltext,$htmlimage,$check_date,$check_result,$check_out_links,$check_cy,$check_pr,$check_pr_main,$check_tag_noindex,$check_meta_robots,$check_file_robots,$status,$ip_user,$admin_comment) = explode("|", $black_array[$h]);
$tmp[$h] = array (field => $check_date, ext1 => "$id|$nick|$urlink|$mail|$category|$htmltext|$htmlimage", ext2 => "$check_result|$check_out_links|$check_cy|$check_pr|$check_pr_main|$check_tag_noindex|$check_meta_robots|$check_file_robots|$status|$ip_user|$admin_comment");
}
sort($tmp, SORT_REGULAR); // ����������
for($h=0;$h<count($tmp);$h++) { // �������� ���������������� �������
$black_array[$h] = ("{$tmp[$h][ext1]}"."|"."{$tmp[$h][field]}"."|"."{$tmp[$h][ext2]}");
}
unset($tmp);
// ���������� ����-����� �� ���� �������� ---------------------------------------
// ���������� ��������� �� ���� ��������---------------------------------------
$tmp = array();
for($h=0;$h<count($moder_array);$h++) { // ����� ���� ��� ����������
list($id,$nick,$urlink,$mail,$category,$htmltext,$htmlimage,$check_date,$check_result,$check_out_links,$check_cy,$check_pr,$check_pr_main,$check_tag_noindex,$check_meta_robots,$check_file_robots,$status,$ip_user,$admin_comment) = explode("|", $moder_array[$h]);
$tmp[$h] = array (field => $check_date, ext1 => "$id|$nick|$urlink|$mail|$category|$htmltext|$htmlimage", ext2 => "$check_result|$check_out_links|$check_cy|$check_pr|$check_pr_main|$check_tag_noindex|$check_meta_robots|$check_file_robots|$status|$ip_user|$admin_comment");
}
sort($tmp, SORT_REGULAR); // ����������
for($h=0;$h<count($tmp);$h++) { // �������� ���������������� �������
$moder_array[$h] = ("{$tmp[$h][ext1]}"."|"."{$tmp[$h][field]}"."|"."{$tmp[$h][ext2]}");
}
unset($tmp);
// ���������� ��������� �� ���� �������� ---------------------------------------
if($_SESSION['adm_sort_2']=="��������") { // ���������� �������������
$base_array = array_reverse($base_array);
$trash_array = array_reverse($trash_array);
$black_array = array_reverse($black_array);
$moder_array = array_reverse($moder_array);
}

} else { // �����, ���� ����. �� ���� ��������

// ���������� ���� �� ���� ����������---------------------------------------
$tmp = array();
for($h=0;$h<count($base_array);$h++) { // ����� ���� ��� ����������
list($id,$nick,$urlink,$mail,$category,$htmltext,$htmlimage,$check_date,$check_result,$check_out_links,$check_cy,$check_pr,$check_pr_main,$check_tag_noindex,$check_meta_robots,$check_file_robots,$status,$ip_user,$admin_comment) = explode("|", $base_array[$h]);
$tmp[$h] = array (field => $id, ext1 => "$nick|$urlink|$mail|$category|$htmltext|$htmlimage|$check_date|$check_result|$check_out_links|$check_cy|$check_pr|$check_pr_main|$check_tag_noindex|$check_meta_robots|$check_file_robots|$status|$ip_user|$admin_comment");
}
sort($tmp, SORT_REGULAR); // ����������
for($h=0;$h<count($tmp);$h++) { // �������� ���������������� �������
$base_array[$h] = ("{$tmp[$h][field]}"."|"."{$tmp[$h][ext1]}");
}
unset($tmp);
// ���������� ����  �� ���� ����������---------------------------------------
// ���������� ������� �� ���� ����������---------------------------------------
$tmp = array();
for($h=0;$h<count($trash_array);$h++) { // ����� ���� ��� ����������
list($id,$nick,$urlink,$mail,$category,$htmltext,$htmlimage,$check_date,$check_result,$check_out_links,$check_cy,$check_pr,$check_pr_main,$check_tag_noindex,$check_meta_robots,$check_file_robots,$status,$ip_user,$admin_comment) = explode("|", $trash_array[$h]);
$tmp[$h] = array (field => $id, ext1 => "$nick|$urlink|$mail|$category|$htmltext|$htmlimage|$check_date|$check_result|$check_out_links|$check_cy|$check_pr|$check_pr_main|$check_tag_noindex|$check_meta_robots|$check_file_robots|$status|$ip_user|$admin_comment");
}
sort($tmp, SORT_REGULAR); // ����������
for($h=0;$h<count($tmp);$h++) { // �������� ���������������� �������
$trash_array[$h] = ("{$tmp[$h][field]}"."|"."{$tmp[$h][ext1]}");
}
unset($tmp);
// ���������� �������  �� ���� ����������---------------------------------------
// ���������� ����-����� �� ���� ����������---------------------------------------
$tmp = array();
for($h=0;$h<count($black_array);$h++) { // ����� ���� ��� ����������
list($id,$nick,$urlink,$mail,$category,$htmltext,$htmlimage,$check_date,$check_result,$check_out_links,$check_cy,$check_pr,$check_pr_main,$check_tag_noindex,$check_meta_robots,$check_file_robots,$status,$ip_user,$admin_comment) = explode("|", $black_array[$h]);
$tmp[$h] = array (field => $id, ext1 => "$nick|$urlink|$mail|$category|$htmltext|$htmlimage|$check_date|$check_result|$check_out_links|$check_cy|$check_pr|$check_pr_main|$check_tag_noindex|$check_meta_robots|$check_file_robots|$status|$ip_user|$admin_comment");
}
sort($tmp, SORT_REGULAR); // ����������
for($h=0;$h<count($tmp);$h++) { // �������� ���������������� �������
$black_array[$h] = ("{$tmp[$h][field]}"."|"."{$tmp[$h][ext1]}");
}
unset($tmp);
// ���������� ����-�����  �� ���� ����������---------------------------------------
// ���������� ��������� �� ���� ����������---------------------------------------
$tmp = array();
for($h=0;$h<count($moder_array);$h++) { // ����� ���� ��� ����������
list($id,$nick,$urlink,$mail,$category,$htmltext,$htmlimage,$check_date,$check_result,$check_out_links,$check_cy,$check_pr,$check_pr_main,$check_tag_noindex,$check_meta_robots,$check_file_robots,$status,$ip_user,$admin_comment) = explode("|", $moder_array[$h]);
$tmp[$h] = array (field => $id, ext1 => "$nick|$urlink|$mail|$category|$htmltext|$htmlimage|$check_date|$check_result|$check_out_links|$check_cy|$check_pr|$check_pr_main|$check_tag_noindex|$check_meta_robots|$check_file_robots|$status|$ip_user|$admin_comment");
}
sort($tmp, SORT_REGULAR); // ����������
for($h=0;$h<count($tmp);$h++) { // �������� ���������������� �������
$moder_array[$h] = ("{$tmp[$h][field]}"."|"."{$tmp[$h][ext1]}");
}
unset($tmp);
// ���������� ���������  �� ���� ����������---------------------------------------
if($_SESSION['adm_sort']=="��������") { // ���������� ���������������
$base_array = array_reverse($base_array);
$trash_array = array_reverse($trash_array);
$black_array = array_reverse($black_array);
$moder_array = array_reverse($moder_array);
}

} // ����� ���� ���./����. �� ���� ��������

// -------------------------------------------------------------------------------
// ����������, ���� ����� ���� �������� �����!!!!

if($_POST['search']) { // ���� ���� ����� ����� ��������� ������ ������ ������
unset($_SESSION['what_search']);
unset($_SESSION['where_search']);
unset($_SESSION['categories_search']);
// ���������� �������
$tmp_array = array_merge($base_array, $moder_array, $trash_array, $black_array);
$tmp_array = array_values($tmp_array);
if(!$_POST['what_search'] AND !$_POST['where_search'] AND !$_POST['categories_search']) { unset($tmp_array); }
}

if($_SESSION['what_search']||$_SESSION['where_search']||$_SESSION['categories_search']) {
// ���������� �������
$tmp_array = array_merge($base_array, $moder_array, $trash_array, $black_array);
$tmp_array = array_values($tmp_array);
}

// �������� ���� ���� ��� ������, �.�. �������

// --------- ���� ��������� ���� ������ � ��������� ------------------------------
if($_POST['where_search']=="���������"||$_SESSION['where_search']=="���������") {
unset($tmp_array); // ���������� ��������� ������, ������ ��� �� ����� ������������� �� ������� �����
for($i=0;$i<count($moder_array);$i++) {
$row_base = explode("|", $moder_array[$i]);
if ($row_base[0]) { $tmp_array[$total_rows] = "$moder_array[$i]"; $total_rows++; }
}
$tmp_array = array_values($tmp_array); $_SESSION[where_search] = "���������";
}
// --------- ���� ��������� ���� ������ � ��������� ------------------------------
// --------- ���� ������� ���� ������ � �������-----------------------------------
if($_POST['where_search']=="�������"||$_SESSION['where_search']=="�������") {
unset($tmp_array); // ���������� ��������� ������, ������ ��� �� ����� ������������� �� ������� �����
for($i=0;$i<count($trash_array);$i++) {
$row_base = explode("|", $trash_array[$i]);
if ($row_base[0]) { $tmp_array[$total_rows] = "$trash_array[$i]"; $total_rows++; }
}
$tmp_array = array_values($tmp_array); $_SESSION[where_search] = "�������";
}
// --------- ���� ������� ���� ������ � �������-----------------------------------
// --------- ���� ����-���� ���� ������ � ����-�����------------------------------
if($_POST['where_search']=="����-����"||$_SESSION['where_search']=="����-����") {
unset($tmp_array); // ���������� ��������� ������, ������ ��� �� ����� ������������� �� ������� �����
for($i=0;$i<count($black_array);$i++) {
$row_base = explode("|", $black_array[$i]);
if ($row_base[0]) { $tmp_array[$total_rows] = "$black_array[$i]"; $total_rows++; }
}
$tmp_array = array_values($tmp_array); $_SESSION[where_search] = "����-����";
}
// --------- ���� ����-���� ���� ������ � ����-�����------------------------------
// --------- ���� ������ ���� ������ � �������� ���� -----------------------------
if($_POST['where_search']=="������"||$_SESSION['where_search']=="������") {
unset($tmp_array); // ���������� ��������� ������, ������ ��� �� ����� ������������� �� ������� �����
$untime = time(); // ������� �����
for($i=0;$i<count($base_array);$i++) {
$row_base = explode("|", $base_array[$i]);
$unstamp = $untime - $_SESSION['adm_old_link']*84600; // ����� ������
if ($row_base[16]==activ&&$row_base[7]<$unstamp) { $tmp_array[$total_rows] = "$base_array[$i]"; $total_rows++; }
}
$tmp_array = array_values($tmp_array); $_SESSION[where_search] = "������";
}
// --------- ���� ������ ���� ������ � �������� ���� -----------------------------
// --------- ���� ����� ���� ������ � �������� ���� -----------------------------
if($_POST['where_search']=="�����"||$_SESSION['where_search']=="�����") {
unset($tmp_array); // ���������� ��������� ������, ������ ��� �� ����� ������������� �� ������� �����
$untime = time(); // ������� �����
for($i=0;$i<count($base_array);$i++) {
$row_base = explode("|", $base_array[$i]);
$unstamp = $untime - $_SESSION['adm_new_link']*84600; // ����� �����
if ($row_base[16]==activ&&$row_base[0]>$unstamp&&strlen($row_base[2])>7) { $tmp_array[$total_rows] = "$base_array[$i]"; $total_rows++; }
}
$tmp_array = array_values($tmp_array); $_SESSION[where_search] = "�����";
}
// --------- ���� ����� ���� ������ � �������� ���� -----------------------------
// --------- ���� ����������� ���� ������ � �������� ���� ------------------------
if($_POST['where_search']=="�����������"||$_SESSION['where_search']=="�����������") {
unset($tmp_array); // ���������� ��������� ������, ������ ��� �� ����� ������������� �� ������� �����
for($i=0;$i<count($base_array);$i++) {
$row_base = explode("|", $base_array[$i]);
if ($row_base[16]=="noanswer") { $tmp_array[$total_rows] = "$base_array[$i]"; $total_rows++; }
}
$tmp_array = array_values($tmp_array); $_SESSION[where_search] = "�����������";
}
// --------- ���� ����������� ���� ������ � �������� ���� ------------------------
// --------- ���� ������� ���� ������ � �������� ���� ----------------------------
if($_POST['where_search']=="�������"||$_SESSION['where_search']=="�������") {
unset($tmp_array); // ���������� ��������� ������, ������ ��� �� ����� ������������� �� ������� �����
for($i=0;$i<count($base_array);$i++) {
$row_base = explode("|", $base_array[$i]);
if ($row_base[16]=="activ"&&$row_base[8]=="well"&&$row_base[13]=="well"&&$row_base[14]=="well"&&$row_base[15]=="well"&&$row_base[10]>=$_SESSION['adm_cy']&&$row_base[11]>=$_SESSION['adm_pr']&&$row_base[9]<=$_SESSION['adm_out_links']) { $tmp_array[$total_rows] = "$base_array[$i]"; $total_rows++; }
}
$tmp_array = array_values($tmp_array); $_SESSION[where_search] = "�������";
}
// --------- ���� ������� ���� ������ � �������� ���� ----------------------------
// --------- ���� ������ ���� ������ � �������� ���� -----------------------------
if($_POST['where_search']=="������"||$_SESSION['where_search']=="������") {
unset($tmp_array); // ���������� ��������� ������, ������ ��� �� ����� ������������� �� ������� �����
for($i=0;$i<count($base_array);$i++) {
$row_base = explode("|", $base_array[$i]);
if ($row_base[16]=="activ") {
if($row_base[8]=="badly"||$row_base[13]=="badly"||$row_base[14]=="badly"||$row_base[15]=="badly"||$row_base[10]<$_SESSION['adm_cy']||$row_base[11]<$_SESSION['adm_pr']||$row_base[9]>$_SESSION['adm_out_links']) { $tmp_array[$total_rows] = "$base_array[$i]"; $total_rows++; }
}
}
$tmp_array = array_values($tmp_array); $_SESSION[where_search] = "������";
}
// --------- ���� ������ ���� ������ � �������� ���� -----------------------------
// --------- ���� ������� ���� ������ � �������� ���� ----------------------------
if($_POST['where_search']=="�������"||$_SESSION['where_search']=="�������") {
unset($tmp_array); // ���������� ��������� ������, ������ ��� �� ����� ������������� �� ������� �����
for($i=0;$i<count($base_array);$i++) {
$row_base = explode("|", $base_array[$i]);
if ($row_base[16]=="hide") { $tmp_array[$total_rows] = "$base_array[$i]"; $total_rows++; }
}
$tmp_array = array_values($tmp_array); $_SESSION[where_search] = "�������";
}
// --------- ���� ������� ���� ������ � �������� ���� ----------------------------
// ������� ���� ���� ��� ������, �.�. �������


// -------------------- �������� ���� ���� ��������� -----------------------------
if($_POST['categories_search']||$_SESSION['categories_search']) {

$total_rows = 0; // ��������� �������, �.�. ����� ������������� ����� ��������� ������
for($i=0;$i<count($tmp_array);$i++) {
$row_base = explode("|", $tmp_array[$i]);
if ($row_base[4]==$_POST['categories_search']||$row_base[4]==$_SESSION['categories_search']) { $tmp_array2[$total_rows] = "$tmp_array[$i]"; $total_rows++; $_SESSION[categories_search] = "$row_base[4]"; }
}
unset($tmp_array);
$tmp_array = array_values($tmp_array2);
if(!isset($_SESSION['categories_search'])) { $_SESSION[categories_search] = "$_POST[categories_search]"; }
}
// --------------------- ������� ���� ���� ��������� -----------------------------


// -------------------- �������� ���� ���� ������ �� ����� -----------------------
if($_POST['what_search']||$_SESSION['what_search']) {

$_POST[what_search] = strtolower(trim(stripslashes(htmlspecialchars($_POST['what_search'])))); // ��������/�������� $_POST[what_search]
if(!isset($_SESSION['what_search'])) {  $_SESSION[what_search] = $_POST[what_search]; } // ���� ��� ������, ������� ���� ������ ������
$_SESSION[what_search] = strtr("$_SESSION[what_search]", "���������������������������������", "���������������������������������");
$total_rows = 0; // ��������� �������, �.�. ����� ������������� ����� ��������� ������
for($i=0;$i<count($tmp_array);$i++) {
$row_base = explode("|", $tmp_array[$i]);
$search_string = "$row_base[1]"."$row_base[2]"."$row_base[3]"."$row_base[5]"."$row_base[6]"."$row_base[17]"."$row_base[18]";
$search_string = strtolower($search_string);
$search_string = strtr("$search_string", "���������������������������������", "���������������������������������");
if (substr_count($search_string, "$_SESSION[what_search]")) { $tmp_array3[$total_rows] = "$tmp_array[$i]"; $total_rows++; }
}
unset($tmp_array);
$tmp_array = array_values($tmp_array3);
}
// -------------------- ������� ���� ���� ������ �� ����� -----------------------

// -------------------- ������� ������ �������� (�����) ----------
$clear_array = array();
$total_rows = 0;
$qnt = count($tmp_array);
for($i=0;$i<$qnt;$i++) {
$tmp_row = explode("|", $tmp_array[$i]);
if ($tmp_row[16]!="hole") { $clear_array[$i] = "$tmp_array[$i]"; $total_rows++; }
}
unset($tmp_array);
$tmp_array = array_values($clear_array);
// -------------------- ������� ������ �������� (�����) ----------

// -------------------------------------------------------------------------------
// if($_SESSION[adm_sort] == �����������) { $tmp_array = array_reverse($tmp_array); } // ����������, ���� ����

// ���������� ����� ��������� �� ��������
include "scale.php";

echo "</td><td align=right valign=top>";

// ���������� ����� ������
// include "search.php";

echo "</td></tr><tr><td valign=top align=left colspan=2>";
// ������� ������ �����������
for($j=$from_row;$j<=$to_row;$j++) {

$row_base = explode("|", $tmp_array[$j]);
if ($tmp_array[$j]) { include "card.php"; echo "<br>";}
}
echo "<br>";
// ���������� ����� ����� ������
// include "searchend.php";

// ���������� ����� ��������� �� ��������
include "scale.php";
// ---------------------------------------------------------------------------------------------------------------------------------
echo "</td></tr></table>";
@ignore_user_abort($old_abort);
?>
</body>
</html>