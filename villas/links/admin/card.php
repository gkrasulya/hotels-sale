<?php
putenv("TZ=Europe/Moscow");
// ����� ������ ��������, ���� �� � ������
if($place=="�����") {

// �������� ����� ������ ������
$link_search_flag = 0;

// ���� � ���������
if($link_search_flag==0) {
$all_moder = count($moder_array);
for($w=0;$w<$all_moder;$w++){
$row = explode("|", $moder_array[$w]);
if($row_base[0]==$row[0]) { $link_search_flag = 1; break; }
}
}
// ���� � �������
if($link_search_flag==0) {
$all_trash = count($trash_array);
for($w=0;$w<$all_trash;$w++){
$row = explode("|", $trash_array[$w]);
if($row_base[0]==$row[0]) { $link_search_flag = 2; break; }
}
}
// ���� � ����-�����
if($link_search_flag==0) {
$all_black = count($black_array);
for($w=0;$w<$all_black;$w++){
$row = explode("|", $black_array[$w]);
if($row_base[0]==$row[0]) { $link_search_flag = 3; break; }
}
}
// ���� � ����
if($link_search_flag==0) {
$all_base = count($base_array);
for($w=0;$w<$all_base;$w++){ // �������� ���� �� �������, ������... (����� ������)
$rows = explode("|", $base_array[$w]);
if ($rows[16]=="activ"&&$rows[8]!="badly"&&$rows[13]!="badly"&&$rows[14]!="badly"&&$rows[15]!="badly"&&$rows[10]>=$_SESSION['adm_cy']&&$rows[11]>=$_SESSION['adm_pr']&&$rows[9]<=$_SESSION['adm_out_links'] AND strlen($rows[2])>7) { $array_well[$w] = "$base_array[$w]"; }
if ($rows[16]=="activ" AND strlen($rows[2])>7) {
if($rows[8]=="badly"||$rows[13]=="badly"||$rows[14]=="badly"||$rows[15]=="badly"||$rows[10]<$_SESSION['adm_cy']||$rows[11]<$_SESSION['adm_pr']||$rows[9]>$_SESSION['adm_out_links']) { $array_badly[$w] = "$base_array[$w]"; }
}
if ($rows[16]=="hide" AND strlen($rows[2])>7) { $array_hide[$w] = "$base_array[$w]"; }
if ($rows[16]=="noanswer" AND strlen($rows[2])>7) { $array_noanswer[$w] = "$base_array[$w]"; }
}
}
// ���������� �������
$array_well = array_values($array_well);
$array_badly = array_values($array_badly);
$array_hide = array_values($array_hide);
$array_noanswer = array_values($array_noanswer);

if($link_search_flag==0) { // � �������
for($w=0;$w<count($array_well);$w++){
$row = explode("|", $array_well[$w]);
if($row_base[0]==$row[0]) { $link_search_flag = 5; break; }
}
}
if($link_search_flag==0) { // � ������
for($w=0;$w<count($array_badly);$w++){
$row = explode("|", $array_badly[$w]);
if($row_base[0]==$row[0]) { $link_search_flag = 6; break; }
}
}
if($link_search_flag==0) { // � �������
for($w=0;$w<count($array_hide);$w++){
$row = explode("|", $array_hide[$w]);
if($row_base[0]==$row[0]) { $link_search_flag = 7; break; }
}
}
if($link_search_flag==0) { // � ������������
for($w=0;$w<count($array_noanswer);$w++){
$row = explode("|", $array_noanswer[$w]);
if($row_base[0]==$row[0]) { $link_search_flag = 8; break; }
}
}

// ���������� ���� (��� ��� ������ ���������)
$pos=strpos("$_SERVER[REQUEST_URI]", "links_");
$string=substr("$_SERVER[REQUEST_URI]", 0, $pos);

// ��������� ������
if($link_search_flag==1) { $link_search = "$_SERVER[HTTP_HOST]"."$string"."links_moder.php"; }
if($link_search_flag==2) { $link_search = "$_SERVER[HTTP_HOST]"."$string"."links_trash.php"; }
if($link_search_flag==3) { $link_search = "$_SERVER[HTTP_HOST]"."$string"."links_black.php"; }
// if($link_search_flag==4) { $link_search = "$_SERVER[HTTP_HOST]"."$string"."links_older.php"; } // ����� �� ����
if($link_search_flag==5) { $link_search = "$_SERVER[HTTP_HOST]"."$string"."links_well.php"; }
if($link_search_flag==6) { $link_search = "$_SERVER[HTTP_HOST]"."$string"."links_badly.php"; }
if($link_search_flag==7) { $link_search = "$_SERVER[HTTP_HOST]"."$string"."links_hide.php"; }
if($link_search_flag==8) { $link_search = "$_SERVER[HTTP_HOST]"."$string"."links_noanswer.php"; }

// ������� ��������
$qnt = $w+1;
$page_from_search = ceil($qnt/$_SESSION['adm_row_page']);
$link_search = "http://"."$link_search"."?page="."$page_from_search"."#"."$row_base[0]";

// ������� ��������� ������� ����� ��������� ������, �.�. ����������� ����� ���� ����� ������
unset($array_well);
unset($array_badly);
unset($array_hide);
unset($array_noanswer);

} // ����� ���� ��� �����
// ****************************************************************************************
// ������������ URL ������ � ����� ��������
//------------------------------------------------------------------------------
$tmp_row=explode("|", "$tmp_array[$j]"); // ����� ��������� ��� ������� ������

// ������� ID ��������� ��� ������� ������
for($k=0; $k<count($categories_array); $k++){
$row = explode("|", $categories_array[$k]);
if($tmp_row[4]==$row[1]) { $category="$row[0]"; break; }
}

// ���������� ���� (��� ��� ������ ���������)
$pos=strpos("$_SERVER[REQUEST_URI]", "/admin/links_");
$string=substr("$_SERVER[REQUEST_URI]", 0, $pos);

// �������� ��� ������ ���� ��������� �� ��������� ������
$total_in_category = 0;
for($m=0;$m<count($base_array);$m++) {
$link_in_base = explode("|", $base_array[$m]);
if($link_in_base[4]=="$row_base[4]") { $tmp_category_array[$total_in_category] = "$base_array[$m]"; $total_in_category++; }
}

// ���� �� ����� ����� � ���� ��������� ������� ������
$row_in_category = 0;
for($n=0;$n<count($tmp_category_array);$n++) {
$link_in_page = explode("|", $tmp_category_array[$n]);
if($link_in_page[0]!="$row_base[0]") { $row_in_category++; } else { $row_in_category++; break; }
}

// ���������� ��������, �� ������� ��������� ������� ������ � ���� ���������
$page = ceil($row_in_category/$_SESSION['imp_links_page']);

// ��������� ������ URL ������� ������ � ��������
if($_SESSION['imp_mode_url']=="�����������") {
$url_in_script="http://"."$_SERVER[HTTP_HOST]"."$string"."/links_"."$category"."_"."$page".".html";
} else {
$url_in_script="http://"."$_SERVER[HTTP_HOST]"."$string"."/index.php?category="."$category&page="."$page";
}
// ������� ��, ���� ��� ���������, �������, ����� ��� ����-����
if($place=="�������"||$place=="����-����"||$place=="���������") { $url_in_script="��� ����������� ������ � ��������"; }
if($place=="�����") { $url_in_script="������� ������� � ������ � ���� ��������"; }

//------------------------------------------------------------------------------
$checked = date("Y-m-d H:i:s", $row_base[7]); // ���������
$added = date("Y-m-d H:i:s", $row_base[0]); // ���������
// ���������� new ��� ����� ������
$this_new_link = $untime - $_SESSION['adm_new_link']*84600; // ����� �����
if ($row_base[0]>$this_new_link AND strlen($row_base[2])>7) { $label_new_link = " [new]"; } else { unset($label_new_link); }

echo "<a name="."$row_base[0]"."><table cellspacing=0 cellpadding=0 width=940>
      <tr><td align=right valign=top width=1px><img src=images/login_lu.gif width=8 height=8 border=0></td><td colspan=3 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_ru.gif width=8 height=8 border=0></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac colspan=3><table cellspacing=3 cellpadding=0 width=100%><tr><td align=left width=1% nowrap><input type=checkbox name="."id[$j]"." value="."$row_base[0]"."></td><td class=title align=right width=99% nowrap><a href="."$row_base[2]"." target=_blank>"."$row_base[2]"."</a>"."$label_new_link"."<hr></td></tr></table></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac colspan=3><table cellspacing=0 cellpadding=5 width=100%><tr><td align=left valign=top width=1% nowrap>"."$row_base[6]"."</td><td align=left valign=top width=98%>"."$row_base[5]"."</td><td class=title align=right valign=top width=1% nowrap>���������: "."$added"."<br>���������: "."$checked"."</td></tr></table></td><td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td>
      <td bgcolor=#8f95ac align=left valign=top>";
// ������� ������ start
echo "<table cellspacing=0 cellpadding=0 width=500>
      <tr><td align=right valign=top width=1px><img src=images/login_lug.gif width=8 height=8 border=0></td><td valign=top bgcolor=#afb5cc colspan=2></td><td align=left valign=top width=1px><img src=images/login_rug.gif width=8 height=8 border=0></td></tr>
      <tr><td bgcolor=#afb5cc width=1px><td align=right class=title bgcolor=#afb5cc colspan=2>������<hr></td><td bgcolor=#afb5cc width=1px></tr>
      <tr><td bgcolor=#afb5cc width=1px><td align=left valign=top bgcolor=#afb5cc>URL ������<br><input name="."urlink[$j]"." type=text size=24 maxlength=255 value=\""."$row_base[2]"."\" onClick=select()></td><td align=right bgcolor=#afb5cc>HTML-��� ��������� ������<br><textarea name="."htmltext[$j]"." rows=2 cols=48 onClick=select()>"."$row_base[5]"."</textarea></td><td bgcolor=#afb5cc width=1px></tr>
      <tr><td bgcolor=#afb5cc width=1px><td align=left valign=top bgcolor=#afb5cc>Nick name<br><input name="."nick[$j]"." type=text size=24 maxlength=255 value=\""."$row_base[1]"."\" onClick=select()></td><td align=right bgcolor=#afb5cc>HTML-��� ��������<br><textarea name="."htmlimage[$j]"." rows=2 cols=48 onClick=select()>"."$row_base[6]"."</textarea></td><td bgcolor=#afb5cc width=1px></tr>
      <tr><td bgcolor=#afb5cc width=1px><td align=left valign=top bgcolor=#afb5cc>E-mail<br><input name="."mail[$j]"." type=text size=24 maxlength=255 value=\""."$row_base[3]"."\" onClick=select()></td><td align=right bgcolor=#afb5cc>����������� ��������������<br><textarea name="."admin_comment[$j]"." rows=2 cols=48 onClick=select()>"."$row_base[18]"."</textarea></td><td bgcolor=#afb5cc width=1px></tr>
      <tr><td bgcolor=#afb5cc width=1px><td align=left valign=top bgcolor=#afb5cc colspan=2>���������<br><select name="."category[$j]"."><option>"."$row_base[4]"."</option>";
	     // ������ ���������
         for($k=0; $k<count($categories_array); $k++){
         $row = explode("|", $categories_array[$k]);
         echo "<option>"."$row[1]"."</option>";
         }
         echo "</select>";	  
echo "</td><td bgcolor=#afb5cc width=1px></tr>
      <tr><td bgcolor=#afb5cc width=1px><td align=left valign=top bgcolor=#afb5cc colspan=2><input type=text size=68 maxlength=255 value=\""."$url_in_script"."\" onClick=select()><b><a href=\""."$url_in_script"."\" target=_blank>>></a></b></td><td bgcolor=#afb5cc width=1px></tr>
      <tr><td align=right valign=top width=1px><img src=images/login_ldg.gif width=8 height=8 border=0></td><td valign=top bgcolor=#afb5cc colspan=2></td><td align=left valign=top width=1px><img src=images/login_rdg.gif width=8 height=8 border=0></td></tr>
      </table>";
// ������� ������ stop
echo "</td>
      <td bgcolor=#8f95ac align=left valign=top>";
// ������� ���������� start
echo "<table cellspacing=0 cellpadding=0 width=210>
      <tr><td align=right valign=top width=1px><img src=images/login_lug.gif width=8 height=8 border=0></td><td valign=top bgcolor=#afb5cc colspan=2></td><td align=left valign=top width=1px><img src=images/login_rug.gif width=8 height=8 border=0></td></tr>
      <tr><td bgcolor=#afb5cc width=1px><td align=right class=title bgcolor=#afb5cc colspan=2>����������<hr></td><td bgcolor=#afb5cc width=1px></tr>
      <tr><td bgcolor=#afb5cc width=1px><td bgcolor=#afb5cc align=left height=21>��������� ��������</td><td bgcolor=#afb5cc align=right>";
	     if($row_base[8]=="badly") {
	     echo "<img src=images/red.gif width=16 height=16 border=0 title=\"������������� ���������\">";
	     } elseif($row_base[8]=="well") {
	     echo "<img src=images/green.gif width=16 height=16 border=0 title=\"������������� ���������\">";
	     } else {
	     echo "<img src=images/yellow.gif width=16 height=16 border=0 title=\"�������� �� ����������\">";
	     }
echo "</td><td bgcolor=#afb5cc width=1px></tr>
      <tr><td bgcolor=#afb5cc width=1px><td bgcolor=#afb5cc align=left height=21>���� noindex</td><td bgcolor=#afb5cc align=right>";
	     if($row_base[13]=="badly") {
	     echo "<img src=images/red.gif width=16 height=16 border=0 title=\"������������� ���������\">";
	     } elseif($row_base[13]=="well") {
	     echo "<img src=images/green.gif width=16 height=16 border=0 title=\"������������� ���������\">";
	     } else {
	     echo "<img src=images/yellow.gif width=16 height=16 border=0 title=\"�������� �� ����������\">";
	     }
echo "</td><td bgcolor=#afb5cc width=1px></tr>
      <tr><td bgcolor=#afb5cc width=1px><td bgcolor=#afb5cc align=left height=21>������� robots</td><td bgcolor=#afb5cc align=right>";
	     if($row_base[14]=="badly") {
	     echo "<img src=images/red.gif width=16 height=16 border=0 title=\"������������� ���������\">";
	     } elseif($row_base[14]=="well") {
	     echo "<img src=images/green.gif width=16 height=16 border=0 title=\"������������� ���������\">";
	     } else {
	     echo "<img src=images/yellow.gif width=16 height=16 border=0 title=\"�������� �� ����������\">";
	     }
		 
// ���������� URL ����� robots.txt		 
$url_robots = parse_url($row_base[2]);
$url_robots = "http://"."$url_robots[host]"."/robots.txt";
echo "</td><td bgcolor=#afb5cc width=1px></tr>
      <tr><td bgcolor=#afb5cc width=1px><td bgcolor=#afb5cc align=left height=21><a href="."$url_robots"." target=_blank>���� robots.txt</a></td><td bgcolor=#afb5cc align=right>";
	     if($row_base[15]=="badly") {
	     echo "<img src=images/red.gif width=16 height=16 border=0 title=\"������������� ���������\">";
	     } elseif($row_base[15]=="well") {
	     echo "<img src=images/green.gif width=16 height=16 border=0 title=\"������������� ���������\">";
	     } else {
	     echo "<img src=images/yellow.gif width=16 height=16 border=0 title=\"�������� �� ����������\">";
	     }
echo "</td><td bgcolor=#afb5cc width=1px></tr>
      <tr><td bgcolor=#afb5cc width=1px><td bgcolor=#afb5cc align=left height=21>���������� ������</td><td bgcolor=#afb5cc align=right class=title>";
	     if($row_base[9] > $_SESSION['adm_out_links']) {
	     echo "<font color=red><b>"."$row_base[9]"."</b></font>";
	     } else {
	     echo "<font color=white><b>"."$row_base[9]"."</b></font>";
	     }
		 
// ���������� URL CY Yandex		 
$url_cy = parse_url($row_base[2]);
$url_cy = "$url_cy[host]";
$home_host = parse_url($_SESSION['imp_myhome']);
$home_host = "$home_host[host]";
$info_ind = "http://yandex.ru/yandsearch?ras=1&lang=all&to_day="."$day"."&to_month="."$mon"."&to_year="."$year"."&mime=all&Link="."$home_host"."&numdoc=10&site="."$url_cy";
$cy_ind = "http://bar-navig.yandex.ru/u?ver=2&lang=1049&url=http://"."$url_cy"."&target=_No__Name:5&show=1&thc=0";
echo "</td><td bgcolor=#afb5cc width=1px></tr>
      <tr><td bgcolor=#afb5cc width=1px><td bgcolor=#afb5cc align=left height=21><a href=\""."$cy_ind"."\" target=\"_blank\">CY Yandex</a>&nbsp;<a href=\""."$info_ind"."\" target=\"_blank\"><b>[ i ]</b></a>&nbsp;&nbsp;&nbsp;<a href=\"http://webmaster.yandex.ru/?url="."$row_base[2]"."\" target=\"add-to-yandex\" target=\"_blank\"><b>[+]</b></a></td><td bgcolor=#afb5cc align=right class=title>";
	     if($row_base[10] < $_SESSION['adm_cy']) {
	     echo "<font color=red><b>"."$row_base[10]"."</b></font>";
	     } else {
	     echo "<font color=white><b>"."$row_base[10]"."</b></font>";
	     }
echo "</td><td bgcolor=#afb5cc width=1px></tr>
      <tr><td bgcolor=#afb5cc width=1px><td bgcolor=#afb5cc align=left height=21>PR Google (������)</td><td bgcolor=#afb5cc align=right class=title>";
	     if($row_base[11] < $_SESSION['adm_pr']) {
	     echo "<font color=red><b>"."$row_base[11]"."</b></font>";
	     } else {
	     echo "<font color=white><b>"."$row_base[11]"."</b></font>";
	     }
echo "</td><td bgcolor=#afb5cc width=1px></tr>
      <tr><td bgcolor=#afb5cc width=1px><td bgcolor=#afb5cc align=left height=21>PR Google (�������)</td><td bgcolor=#afb5cc align=right class=title>";
	     if($row_base[12]>=0) {
	     echo "<font color=white><b>"."$row_base[12]"."</b></font>";
	     }
echo "</td><td bgcolor=#afb5cc width=1px></tr>
      <tr><td align=right valign=top width=1px><img src=images/login_ldg.gif width=8 height=8 border=0></td><td valign=top bgcolor=#afb5cc colspan=2></td><td align=left valign=top width=1px><img src=images/login_rdg.gif width=8 height=8 border=0></td></tr>
      </table>";
// ������� ���������� stop
echo "</td>
      <td bgcolor=#8f95ac align=right valign=top>";
// ������� �������� start
echo "<table cellspacing=0 cellpadding=0 width=190>
      <tr><td align=right valign=top width=1px><img src=images/login_lug.gif width=8 height=8 border=0></td><td valign=top bgcolor=#afb5cc></td><td align=left valign=top width=1px><img src=images/login_rug.gif width=8 height=8 border=0></td></tr>
      <tr><td bgcolor=#afb5cc width=1px><td align=right class=title bgcolor=#afb5cc>��������<hr></td><td bgcolor=#afb5cc width=1px></tr>";
if($place!="�����") { echo "<tr><td bgcolor=#afb5cc width=1px><td bgcolor=#afb5cc height=21><a href=fullcheck.php?id="."$row_base[0]"."&action=full_check&back="."$_SERVER[PHP_SELF]"."&page="."$_GET[page]".">������ ��������</a></td><td bgcolor=#afb5cc width=1px></tr>"; } else { echo "<tr><td bgcolor=#afb5cc width=1px><td bgcolor=#afb5cc height=21><font color=#CCCCCC><i>������ ��������</i></font></td><td bgcolor=#afb5cc width=1px></tr>"; }
if($place=="������� ������"||$place=="���������") { echo "<tr><td bgcolor=#afb5cc width=1px><td bgcolor=#afb5cc height=21><a href=makeactiv.php?id="."$row_base[0]"."&action=make_activ&back="."$_SERVER[PHP_SELF]"."&page="."$_GET[page]".">��������������</a></td><td bgcolor=#afb5cc width=1px></tr>"; } else { echo "<tr><td bgcolor=#afb5cc width=1px><td bgcolor=#afb5cc height=21><font color=#CCCCCC><i>��������������</i></font></td><td bgcolor=#afb5cc width=1px></tr>"; }
if($place=="������ ������"||$place=="����������� ������"||$place=="������� ������"||$place=="������ ������"||$place=="��� �������� ������"||$place=="����� ������"||$place=="������ ���/PR"||$place=="������� ����������"||$place=="����� ������") { echo "<tr><td bgcolor=#afb5cc width=1px><td bgcolor=#afb5cc height=21><a href=temphide.php?id="."$row_base[0]"."&action=temp_hide&back="."$_SERVER[PHP_SELF]"."&page="."$_GET[page]".">�������� ������</a></td><td bgcolor=#afb5cc width=1px></tr>"; } else { echo "<tr><td bgcolor=#afb5cc width=1px><td bgcolor=#afb5cc height=21><font color=#CCCCCC><i>�������� ������</i></font></td><td bgcolor=#afb5cc width=1px></tr>"; }
if($place!="����-����" AND $place!="�����") { echo "<tr><td bgcolor=#afb5cc width=1px><td bgcolor=#afb5cc height=21><a href=moveblack.php?id="."$row_base[0]"."&action=move_black&back="."$_SERVER[PHP_SELF]"."&page="."$_GET[page]".">� ����-����</a></td><td bgcolor=#afb5cc width=1px></tr>"; } else { echo "<tr><td bgcolor=#afb5cc width=1px><td bgcolor=#afb5cc height=21><font color=#CCCCCC><i>� ����-����</i></font></td><td bgcolor=#afb5cc width=1px></tr>"; }
if($place!="�������" AND $place!="�����") { echo "<tr><td bgcolor=#afb5cc width=1px><td bgcolor=#afb5cc height=21><a href=movetrash.php?id="."$row_base[0]"."&action=move_trash&back="."$_SERVER[PHP_SELF]"."&page="."$_GET[page]".">� �������</a></td><td bgcolor=#afb5cc width=1px></tr>"; } else { echo "<tr><td bgcolor=#afb5cc width=1px><td bgcolor=#afb5cc height=21><font color=#CCCCCC><i>� �������</i></font></td><td bgcolor=#afb5cc width=1px></tr>"; }
if($place=="�������") { echo "<tr><td bgcolor=#afb5cc width=1px><td bgcolor=#afb5cc height=21><a href=removecertainly.php?id=$row_base[0]&action=remove_certainly&back=$_SERVER[PHP_SELF]&page=$_GET[page]>������� �������</a></td><td bgcolor=#afb5cc width=1px></tr>"; } else { echo "<tr><td bgcolor=#afb5cc width=1px><td bgcolor=#afb5cc height=21><font color=#CCCCCC><i>������� �������</i></font></td><td bgcolor=#afb5cc width=1px></tr>"; }
if($place!="�����" AND $place!="�������" AND $place!="����-����") { echo "<tr><td bgcolor=#afb5cc width=1px><td bgcolor=#afb5cc height=21><a href=editdata.php?id="."$row_base[0]"."&action=edit_data&back="."$_SERVER[PHP_SELF]"."&page="."$_GET[page]".">������������� ������</a></td><td bgcolor=#afb5cc width=1px></tr>"; } else { echo "<tr><td bgcolor=#afb5cc width=1px><td bgcolor=#afb5cc height=21><font color=#CCCCCC><i>������������� ������</i></font></td><td bgcolor=#afb5cc width=1px></tr>"; }
if($place=="�����") { echo "<tr><td bgcolor=#afb5cc width=1px><td bgcolor=#afb5cc height=21><a href="."$link_search".">������� � ������</a></td><td bgcolor=#afb5cc width=1px></tr>"; } else { echo "<tr><td bgcolor=#afb5cc width=1px><td bgcolor=#afb5cc height=21><font color=#CCCCCC><i>������� � ������</i></font></td><td bgcolor=#afb5cc width=1px></tr>"; }
echo "<tr><td align=right valign=top width=1px><img src=images/login_ldg.gif width=8 height=8 border=0></td><td valign=top bgcolor=#afb5cc></td><td align=left valign=top width=1px><img src=images/login_rdg.gif width=8 height=8 border=0></td></tr>
      </table>";
// ������� �������� stop
echo "</td>
      <td bgcolor=#8f95ac width=1px></td></tr>
      <tr><td align=right valign=top width=1px><img src=images/login_ld.gif width=8 height=8 border=0></td><td colspan=3 valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_rd.gif width=8 height=8 border=0></td></tr>
      </table></a>";
?>