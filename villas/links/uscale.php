<?php
if(!$_GET['page']) {$_GET['page'] = 1;}
// ���������� ������� ��������� �� ��������
$pages_scale = Get_Pages_Scale($total_rows, $_GET['category'], $_GET['page'], $_SERVER['PHP_SELF'], $_SESSION['imp_links_page'], $_SESSION['flag_search'], $_SESSION['imp_mode_url']);
// ������� ������� �������� � ����
$activ_rows = $total_rows - $hole_rows;
// ������� ��
if($_SESSION['vis_all_links']=="��") {
if($_SESSION['vis_user_lang']=="eng") {echo "Links in catalogue: <b>"."$all_links"."</b><br>";} else{echo "������ � ��������: <b>"."$all_links"."</b><br>";}
}
if($_SESSION['vis_user_lang']=="eng") {echo "Links in section: <b>"."$activ_rows"."</b> || Pages: "."$pages_scale";} else {echo "� �������: <b>"."$activ_rows"."</b> || ��������: "."$pages_scale";}
// ������� from_row � to_row ��� ����� ������������� ������
$from_row = $_GET['page']*$_SESSION['imp_links_page']-$_SESSION['imp_links_page'];
$to_row = $from_row+$_SESSION['imp_links_page']-1;
?>