<?php
if(!$_GET['page']) {$_GET['page'] = 1;}
// ���������� ������� ��������� �� ��������
$pages_scale = Get_Pages_Scale($total_rows, $_GET['page'], $_SERVER['PHP_SELF'], $_SESSION['adm_row_page']);
// ������� ��
echo "<table cellspacing=0 cellpadding=0 width=520>
      <tr><td align=right valign=top width=1px><img src=images/login_lu.gif width=8 height=8 border=0></td><td valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_ru.gif width=8 height=8 border=0></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=left>����� ������ � �������: <font color=white><b>"."$total_rows"."</b></font><br>��������: "."$pages_scale"."</td><td bgcolor=#8f95ac width=1px></tr>
	  <tr><td align=right valign=top width=1px><img src=images/login_ld.gif width=8 height=8 border=0></td><td valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_rd.gif width=8 height=8 border=0></td></tr>
      </table><br>";
// ������� from_row � to_row ��� ����� ������������� ������
$from_row = $_GET['page']*$_SESSION['adm_row_page']-$_SESSION['adm_row_page'];
$to_row = $from_row+$_SESSION['adm_row_page']-1;
?>