<?php
error_reporting(0);
putenv("TZ=Europe/Moscow");
@$old_abort = ignore_user_abort(true);
session_start();

if(!$_POST['search']&&!$_GET['search']) { $_SESSION['flag_search'] = 0; } // ���� ������

// *******************************************************************************
// �������� ������ �� ������ �������� � �������, ����� ������� ��������� � ����
// *******************************************************************************
$lock = fopen("admin/data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$cnf_imp_array = file("admin/config/cnfimp.dat");
$cnf_visual_array = file("admin/config/cnfvisual.dat");
$base_array = file("admin/data/base.dat");
$categories_array = file("admin/data/categories.dat");
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
// �������� ��������� � ������
// *******************************************************************************
if(!isset($_SESSION['imp_mode_url'])) { $row_cnf_imp = explode("|", $cnf_imp_array[0]); $_SESSION['imp_mode_url'] = trim($row_cnf_imp[1]); } // ���. ��� ����. ��� URL'a � ��������
if(!isset($_SESSION['imp_links_page'])) { $row_cnf_imp = explode("|", $cnf_imp_array[0]); $_SESSION['imp_links_page'] = trim($row_cnf_imp[2]); } // ����� ������ �� �������� �����
if(!isset($_SESSION['vis_show_category'])) { $row_cnf_visual = explode("|", $cnf_visual_array[0]); $_SESSION['vis_show_category'] = trim($row_cnf_visual[0]); } // ��������� ���������� ��� ���
if(!isset($_SESSION['vis_col_num'])) { $row_cnf_visual = explode("|", $cnf_visual_array[0]); $_SESSION['vis_col_num'] = trim($row_cnf_visual[1]); } // ��������� ���������� ��� ���
if(!isset($_SESSION['vis_sort_cat'])) { $row_cnf_visual = explode("|", $cnf_visual_array[0]); $_SESSION['vis_sort_cat'] = trim($row_cnf_visual[2]); } // ��������� ����������� �� �������� ��� ���
if(!isset($_SESSION['vis_last_links'])) { $row_cnf_visual = explode("|", $cnf_visual_array[0]); $_SESSION['vis_last_links'] = trim($row_cnf_visual[3]); } // ��������� ����������� ������
if(!isset($_SESSION['vis_show_cat'])) { $row_cnf_visual = explode("|", $cnf_visual_array[0]); $_SESSION['vis_show_cat'] = trim($row_cnf_visual[4]); } // ��������� ��� ���������� ������
if(!isset($_SESSION['vis_show_date'])) { $row_cnf_visual = explode("|", $cnf_visual_array[0]); $_SESSION['vis_show_date'] = trim($row_cnf_visual[5]); } // ���� ���������� ���������� ������
if(!isset($_SESSION['vis_show_pr'])) { $row_cnf_visual = explode("|", $cnf_visual_array[0]); $_SESSION['vis_show_pr'] = trim($row_cnf_visual[6]); } // PR ���������� ������
if(!isset($_SESSION['vis_show_cy'])) { $row_cnf_visual = explode("|", $cnf_visual_array[0]); $_SESSION['vis_show_cy'] = trim($row_cnf_visual[7]); } // CY ���������� ������
if(!isset($_SESSION['vis_none_or_cy'])) { $row_cnf_visual = explode("|", $cnf_visual_array[0]); $_SESSION['vis_none_or_cy'] = trim($row_cnf_visual[8]); } // ������-�������� ��� ������ �������
if(!isset($_SESSION['vis_show_search'])) { $row_cnf_visual = explode("|", $cnf_visual_array[0]); $_SESSION['vis_show_search'] = trim($row_cnf_visual[9]); } // ���������� ����� ������?
if(!isset($_SESSION['vis_show_button'])) { $row_cnf_visual = explode("|", $cnf_visual_array[0]); $_SESSION['vis_show_button'] = trim($row_cnf_visual[10]); } // ����������-�� ������ ������?
if(!isset($_SESSION['vis_show_qntlinks'])) { $row_cnf_visual = explode("|", $cnf_visual_array[0]); $_SESSION['vis_show_qntlinks'] = trim($row_cnf_visual[15]); } // ���������� ���������� ������ � ����������?
if(!isset($_SESSION['vis_show_hh'])) { $row_cnf_visual = explode("|", $cnf_visual_array[0]); $_SESSION['vis_show_hh'] = trim($row_cnf_visual[17]); } // ���������� �������/���������?
if(!isset($_SESSION['vis_all_links'])) { $row_cnf_visual = explode("|", $cnf_visual_array[0]); $_SESSION['vis_all_links'] = trim($row_cnf_visual[20]); } // ���������� ����� ���-�� ������ � ��������?
if(!isset($_SESSION['vis_user_lang'])) { $row_cnf_visual = explode("|", $cnf_visual_array[0]); $_SESSION['vis_user_lang'] = trim($row_cnf_visual[21]); } // ���� ���������� �����
// *******************************************************************************
// �������� ��������� � ������
// *******************************************************************************

// *******************************************************************************
// ��������� ������ �������
// *******************************************************************************
include "fscale.php";
// *******************************************************************************
// ��������� ������ �������
// *******************************************************************************

// *******************************************************************************
// ����� ���-�� ������ ��������� 08-06-2006
// *******************************************************************************
$all_links = 0; // �������� ����� ������
$num_links = count($base_array);
for($al=0;$al<$num_links;$al++) { // ������� ���-�� ������
$row_base = explode("|", $base_array[$al]);
if($row_base[16]!=hide&&$row_base[16]!=hole) { $all_links++; }
}
// *******************************************************************************
// ����� ���-�� ������ ��������� 08-06-2006
// *******************************************************************************

// *******************************************************************************
// ��������� ���������� �������, ���� �� �����
// *******************************************************************************
if($_POST['search']||$_GET['search']) { // ���� ���� ����� ����� ��������� ������ ������ ������

if(!$_GET['search']) { // ���������� ������, ���� ����� �����
unset($_SESSION['what_search']);
unset($_SESSION['categories_search']);
unset($_SESSION['result_search']); // �������� ������ ���������� �����������
}

$tmp_array = array_values($base_array); // �� ���� ������ ������������
$total_rows = 0; // ������� ��������� ������� � 0

// �������� ���� ���� ���������
if($_POST['categories_search']||$_SESSION['categories_search']) {
for($i=0;$i<count($tmp_array);$i++) {
$row_base = explode("|", $tmp_array[$i]);
if($row_base[16]!=hide&&$row_base[16]!=hole&&strlen($row_base[2])>7) { // � ������ ������ ������ activ, noanswer (�� ������)
if($row_base[4]==$_POST['categories_search']||$row_base[4]==$_SESSION['categories_search']) { $tmp_array_cat[$total_rows] = "$tmp_array[$i]"; $total_rows++; $_SESSION['categories_search'] = "$row_base[4]"; }
}
} // end for
$tmp_array = array_values($tmp_array_cat);
if(!isset($_SESSION['categories_search'])) { $_SESSION['categories_search'] = "$_POST[categories_search]"; }
}


// �������� ���� ���� ������ �� �����
if($_POST['what_search']||$_SESSION['what_search']) {

$_POST['what_search'] = strtolower(trim(stripslashes(htmlspecialchars($_POST['what_search'])))); // ��������/�������� $_POST[what_search]
if(!isset($_SESSION['what_search'])) {  $_SESSION['what_search'] = "$_POST[what_search]"; } // ���� ��� ������, ������� ���� ������ ������
$_SESSION['what_search'] = strtr("$_SESSION[what_search]", "���������������������������������", "���������������������������������");
$total_rows = 0; // ��������� �������, �.�. ����� ������������� ����� ��������� ������
for($i=0;$i<count($tmp_array);$i++) {
$row_base = explode("|", $tmp_array[$i]);
if($row_base[16]!=hide&&$row_base[16]!=hole&&strlen($row_base[2])>7) { // � ������ ������ ������ activ, noanswer (�� ������)
$search_string = "$row_base[2]"."$row_base[5]";
$search_string = strtolower($search_string);
$search_string = strtr("$search_string", "���������������������������������", "���������������������������������");
if (substr_count($search_string, "$_SESSION[what_search]")) { $tmp_array_search[$total_rows] = "$tmp_array[$i]"; $total_rows++; }
}
} // end for
$tmp_array = array_values($tmp_array_search);
}

$_SESSION['flag_search'] = 1;
} // end if ���� ����� �����
// *******************************************************************************
// ��������� ���������� �������, ���� �� �����
// *******************************************************************************

include "admin/design/header.inc"; // ���������� ���������
echo "<div id=LinkExchangerMain>";


// *******************************************************************************
// $base_array = array_reverse($base_array); // ���� ����� ����������� ����������� ����
// *******************************************************************************

// *******************************************************************************
// ����� �������� ���������
// *******************************************************************************
if($_SESSION['vis_show_category']=="��") {

// ���������� ������� ��������� �� ��������---------------------
if($_SESSION['vis_sort_cat']=="��������") {

$tmp = array();
// ���������� �� ��������
for($h=0;$h<count($categories_array);$h++) { // ����� ���� ��� ����������
list($id,$category,$date) = explode("|", $categories_array[$h]);
$tmp[$h] = array (field => $category, ext1 => $id, ext2 => $date);
}

sort($tmp, SORT_REGULAR); // ����������

for($h=0;$h<count($tmp);$h++) { // �������� ���������������� �������
$categories_array[$h] = ("{$tmp[$h][ext1]}"."|"."{$tmp[$h][field]}"."|"."{$tmp[$h][ext2]}");
}

} // end if �� ��������------------------------------------------

switch($_SESSION['vis_col_num']) { // ������������� �� ���-�� �������

case "1": // ��������� � ���� �������
echo "<table id=TableCategories>";
for($k=0;$k<count($categories_array);$k++) {
$links_in_category = 0; // ������� ���-�� ������ � ����������
$row_categories = explode("|", $categories_array[$k]);
if($row_categories[0]) {
for($cb=0;$cb<count($base_array);$cb++) { // ������� ���-�� ������
$row_base = explode("|", $base_array[$cb]);
if($row_base[4]==$row_categories[1]&&$row_base[16]!=hide&&$row_base[16]!=hole) { $links_in_category++; }
}
// ����������� ��� ������������ ����� �����������--------------
if($_SESSION[imp_mode_url]=="�����������") {
$link_mode_url = "<a href=links_"."$row_categories[0]"."_1.html>";
} else {
$link_mode_url = "<a href=index.php?category="."$row_categories[0]"."&page=1>";
}
echo "<tr id=TrTableCategories><td id=TdTableCategories_1>"."$link_mode_url"."$row_categories[1]"."</a>"; if($_SESSION['vis_show_qntlinks']=="��") { echo "&nbsp;["."$links_in_category"."]</td></tr>"; } else { echo "</td></tr>"; }
}
}
echo "</table>";
break;

case "2": // ��������� � ��� �������
echo "<table id=TableCategories>";
for($k=0;$k<count($categories_array);$k++) {
$links_in_category = 0; // ������� ���-�� ������ � ����������
$row_categories = explode("|", $categories_array[$k]);
if($row_categories[0]) {
for($cb=0;$cb<count($base_array);$cb++) { // ������� ���-�� ������
$row_base = explode("|", $base_array[$cb]);
if($row_base[4]==$row_categories[1]&&$row_base[16]!=hide&&$row_base[16]!=hole) { $links_in_category++; }
}
// ����������� ��� ������������ ����� �����������--------------
if($_SESSION['imp_mode_url']=="�����������") {
$link_mode_url = "<a href=links_"."$row_categories[0]"."_1.html>";
} else {
$link_mode_url = "<a href=index.php?category="."$row_categories[0]"."&page=1>";
}
if(($k%2) == "0") { echo "<tr id=TrTableCategories><td id=TdTableCategories_1>"."$link_mode_url"."$row_categories[1]"."</a>"; if($_SESSION['vis_show_qntlinks']=="��") { echo "&nbsp;["."$links_in_category"."]</td>"; } else { echo "</td>"; } }
if(($k%2) != "0") { echo "<td id=TdTableCategories_2>"."$link_mode_url"."$row_categories[1]"."</a>"; if($_SESSION['vis_show_qntlinks']=="��") { echo "&nbsp;["."$links_in_category"."]</td></tr>"; } else { echo "</td></tr>"; }  }
}
}
echo "</table>";
break;

case "3": // ��������� � ��� �������
echo "<table id=TableCategories>";
for($k=0;$k<count($categories_array);$k++) {
$links_in_category = 0; // ������� ���-�� ������ � ����������
$row_categories = explode("|", $categories_array[$k]);
if($row_categories[0]) {
for($cb=0;$cb<count($base_array);$cb++) { // ������� ���-�� ������
$row_base = explode("|", $base_array[$cb]);
if($row_base[4]==$row_categories[1]&&$row_base[16]!=hide&&$row_base[16]!=hole) { $links_in_category++; }
}
// ����������� ��� ������������ ����� �����������--------------
if($_SESSION['imp_mode_url']=="�����������") {
$link_mode_url = "<a href=links_"."$row_categories[0]"."_1.html>";
} else {
$link_mode_url = "<a href=index.php?category="."$row_categories[0]"."&page=1>";
}
if(($k%3) == "0") { echo "<tr id=TrTableCategories><td id=TdTableCategories_1>"."$link_mode_url"."$row_categories[1]"."</a>"; if($_SESSION['vis_show_qntlinks']=="��") { echo "&nbsp;["."$links_in_category"."]</td>"; } else { echo "</td>"; } }
if(($k%3) == "1") { echo "<td id=TdTableCategories_2>"."$link_mode_url"."$row_categories[1]"."</a>"; if($_SESSION['vis_show_qntlinks']=="��") { echo "&nbsp;["."$links_in_category"."]</td>"; } else { echo "</td>"; } }
if(($k%3) == "2") { echo "<td id=TdTableCategories_3>"."$link_mode_url"."$row_categories[1]"."</a>"; if($_SESSION['vis_show_qntlinks']=="��") { echo "&nbsp;["."$links_in_category"."]</td></tr>"; } else { echo "</td></tr>"; } }
}
}
echo "</table>";
break;

case "4": // ��������� � ������ �������
echo "<table id=TableCategories>";
for($k=0;$k<count($categories_array);$k++) {
$links_in_category = 0; // ������� ���-�� ������ � ����������
$row_categories = explode("|", $categories_array[$k]);
if($row_categories[0]) {
for($cb=0;$cb<count($base_array);$cb++) { // ������� ���-�� ������
$row_base = explode("|", $base_array[$cb]);
if($row_base[4]==$row_categories[1]&&$row_base[16]!=hide&&$row_base[16]!=hole) { $links_in_category++; }
}
// ����������� ��� ������������ ����� �����������--------------
if($_SESSION['imp_mode_url']=="�����������") {
$link_mode_url = "<a href=links_"."$row_categories[0]"."_1.html>";
} else {
$link_mode_url = "<a href=index.php?category="."$row_categories[0]"."&page=1>";
}
if(($k%4) == "0") { echo "<tr id=TrTableCategories><td id=TdTableCategories_1>"."$link_mode_url"."$row_categories[1]"."</a>"; if($_SESSION['vis_show_qntlinks']=="��") { echo "&nbsp;["."$links_in_category"."]</td>"; } else { echo "</td>"; } }
if(($k%4) == "1") { echo "<td id=TdTableCategories_2>"."$link_mode_url"."$row_categories[1]"."</a>"; if($_SESSION['vis_show_qntlinks']=="��") { echo "&nbsp;["."$links_in_category"."]</td>"; } else { echo "</td>"; } }
if(($k%4) == "2") { echo "<td id=TdTableCategories_3>"."$link_mode_url"."$row_categories[1]"."</a>"; if($_SESSION['vis_show_qntlinks']=="��") { echo "&nbsp;["."$links_in_category"."]</td>"; } else { echo "</td>"; } }
if(($k%4) == "3") { echo "<td id=TdTableCategories_4>"."$link_mode_url"."$row_categories[1]"."</a>"; if($_SESSION['vis_show_qntlinks']=="��") { echo "&nbsp;["."$links_in_category"."]</td></tr>"; } else { echo "</td></tr>"; } }
}
}
echo "</table>";
break;

} // end switch

} // end if ���� �������� �������� ��������� �� ���������
// *******************************************************************************
// ����� �������� ���������
// *******************************************************************************

// *******************************************************************************
// ����� ������ �� ����
// *******************************************************************************
if($_SESSION['vis_show_search']=="��") {
$tmp = array();
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
echo "<form action=\"$_SERVER[PHP_SELF]\" method=\"POST\">
      <div id=SearchForm>
      <div id=SearchLinksHeader>";
	  if($_SESSION['vis_user_lang']=="eng") {echo "Search catalogue";} else {echo "����� �� ��������";}
echo "</div>
      <div id=WhatSearchFont>";
	  if($_SESSION['vis_user_lang']=="eng") {echo "What to search?";} else {echo "��� ������?";}
echo "</div>
      <input id=WhatSearchInput name=\"what_search\" type=\"text\" maxlength=\"255\" value=\"$_SESSION[what_search]\">
      <div id=CategorySearchFont>";
	  if($_SESSION['vis_user_lang']=="eng") {echo "Consider category";} else {echo "��������� ���������";}
echo "</div>
      <select id=CategorySearchSelect name=\"categories_search\"><option value=\"$_SESSION[categories_search]\">$_SESSION[categories_search]</option><option value=\"\">";
	  if($_SESSION['vis_user_lang']=="eng") {echo "All categories";} else {echo "��� ���������";}
echo "</option>";
      for($i=0;$i<count($categories_array);$i++) { $row = explode("|", $categories_array[$i]); echo "<option>$row[1]</option>"; }
echo "</select>
      <input id=SearchButton type=\"submit\" name=\"search\" ";
	  if($_SESSION['vis_user_lang']=="eng") {echo "value=\"Find\">";} else {echo "value=\"�����\">";}
echo "</div>
	  </form>";
}
// *******************************************************************************
// ����� ������ �� ����
// *******************************************************************************

// *******************************************************************************
// ��������� ����������� ������
// *******************************************************************************
if($_SESSION['vis_last_links']!="���" AND !$_GET['category'] AND $_SESSION['flag_search']==0) { // ���� �� � ���� ��� �� ���� � ��������� � ���� ��� �� �����
$total_rows = 0;
$base_array_sort = array();
$tmp_last = array();
$last_array = array();
// ���������� ��������������� �� ID ������ ����
$num = count($base_array);
for($h=0;$h<$num;$h++) { // ����� ���� ��� ����������
list($id,$nick,$urlink,$mail,$category,$htmltext,$view_image,$check_date,$check_result,$check_out_links,$check_cy,$check_pr,$check_pr_main,$check_tag_noindex,$check_meta_robots,$check_file_robots,$status,$ip_user,$admin_comment) = explode("|", $base_array[$h]);
$tmp_last[$h] = array (field => $id, ext => "$nick|$urlink|$mail|$category|$htmltext|$view_image|$check_date|$check_result|$check_out_links|$check_cy|$check_pr|$check_pr_main|$check_tag_noindex|$check_meta_robots|$check_file_robots|$status|$ip_user|$admin_comment");
}
sort($tmp_last, SORT_REGULAR); // ����������

for($h=0;$h<count($tmp_last);$h++) { // �������� ���������������� �������
$base_array_sort[$h] = ("{$tmp_last[$h][field]}"."|"."{$tmp_last[$h][ext]}");
}

$base_array_sort = array_reverse($base_array_sort); // �����������

for($i=0;$i<count($base_array_sort);$i++) {
if($total_rows==$_SESSION['vis_last_links']) { break; }
$row_base = explode("|", $base_array_sort[$i]);
if($row_base[16]!=hole&&$row_base[16]!=hide&&strlen($row_base[2])>7) { $last_array[$total_rows] = "$base_array_sort[$i]"; $total_rows++; }
}
echo "<div id=LastLinks>";
echo "<div id=LastLinksHeader>";
if($_SESSION['vis_user_lang']=="eng") {echo "Last added links";} else {echo "��������� ����������� ������";}
echo "</div>";
// ���������� ����� ��������� �� ��������
echo "<div id=Scale>"; include "uscale.php"; echo "</div>";
// ������� ������ �����������
for($j=$from_row;$j<=$to_row;$j++) {
$row_base = explode("|", $last_array[$j]);
if (!empty($last_array[$j])) { include "ucard.php"; }
}
// ���������� ����� ��������� �� ��������
echo "<div id=Scale>"; include "uscale.php"; echo "</div>";
echo "</div>";
}
// *******************************************************************************
// ��������� ����������� ������
// *******************************************************************************

// *******************************************************************************
// ����� ������ � ����������
// *******************************************************************************
if($_GET['category']) {
$_SESSION['flag_search'] = 0; // ���� ������ � 0
$total_rows = 0; // ����� ����� � ����
$hole_rows = 0; // �����-����� � ����
// ���������� ��������� ������ ��� ������� ��������� �� �������� ��
// �������� ������ well � activ � ������ ������ ���������

for($k=0;$k<count($categories_array);$k++) { // ���� �������� ���������
$row_categories = explode("|", $categories_array[$k]);
if($row_categories[0]==$_GET['category']) { $category_name = "$row_categories[1]"; break; }
}

for($i=0;$i<count($base_array);$i++) {
$row_base = explode("|", $base_array[$i]);
if($row_base[4]==$category_name) { // ��������� �� ��������� ������ ������ ���� �������� ��������� �������������
$tmp_array[$total_rows] = "$base_array[$i]"; $total_rows++; // ������ ������ ���� ������, ������� �����
if ($row_base[16]==hole||$row_base[16]==hide) { $hole_rows++; } // ������������ ����, ����� ������� ��.
}
}
echo "<div id=CategoryLinks>";
echo "<div id=CategoryLinksHeader><H1>"."$category_name"."</H1></div>";
// ���������� ����� ��������� �� ��������
echo "<div id=Scale>"; include "uscale.php"; echo "</div>";

// ������� ������ �����������
for($j=$from_row;$j<=$to_row;$j++) {
$row_base = explode("|", $tmp_array[$j]);
if ($tmp_array[$j]) { include "ucard.php"; }
}

// ���������� ����� ��������� �� ��������
echo "<div id=Scale>"; include "uscale.php"; echo "</div>";
echo "</div>";
}
// *******************************************************************************
// ����� ������ � ����������
// *******************************************************************************

// *******************************************************************************
// ���������� ������
// *******************************************************************************
if($_SESSION['flag_search']!=0) {
$total_rows = 0; // ����� ����� � ����
for($i=0;$i<count($tmp_array);$i++) {
$row_base = explode("|", $tmp_array[$i]);
if ($row_base[16]!=hide&&$row_base[16]!=hole&&strlen($row_base[2])>7) { $tmp_array_search[$total_rows] = "$tmp_array[$i]"; $total_rows++; } // ������ ������ ������� ������, ������� �����
}
echo "<div id=Search>";
echo "<div id=SearchHeader>";
if($_SESSION['vis_user_lang']=="eng") {echo "Search results";} else {echo "���������� ������";}
echo "</div>";
// ���������� ����� ��������� �� ��������
echo "<div id=Scale>"; include "uscale.php"; echo "</div>";

// ������� ������ �����������
for($j=$from_row;$j<=$to_row;$j++) {
$row_base = explode("|", $tmp_array[$j]);
if ($tmp_array[$j]) { include "ucard.php"; }
}

// ���������� ����� ��������� �� ��������
echo "<div id=Scale>"; include "uscale.php"; echo "</div>";
echo "</div>";
}
// *******************************************************************************
// ���������� ������
// *******************************************************************************

// *******************************************************************************
// �������� ������
// *******************************************************************************
if($_SESSION['vis_user_lang']=="eng") {echo "<div id=AddLink><a href=submit.php>Submit link</a></div>";} else {echo "<div id=AddLink><a href=submit.php>�������� ������</a></div>";}
echo "<div id=CopyRightM><a href=http://www.linkexchanger.ru target=_blank>";
if($_SESSION['vis_user_lang']=="eng") {echo "Script of link catalogue LinkExchanger v2.0";} else {echo "������ �������� ������ LinkExchanger v2.0";}
echo "</a></div>";
// *******************************************************************************
// �������� ������
// *******************************************************************************
echo "</div>";
@ignore_user_abort($old_abort);
include "admin/design/footer.inc";
?>
</body>
</html>
