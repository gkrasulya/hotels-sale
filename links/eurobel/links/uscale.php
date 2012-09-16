<?php
if(!$_GET['page']) {$_GET['page'] = 1;}
// Подключаем функцию разбиения на страницы
$pages_scale = Get_Pages_Scale($total_rows, $_GET['category'], $_GET['page'], $_SERVER['PHP_SELF'], $_SESSION['imp_links_page'], $_SESSION['flag_search'], $_SESSION['imp_mode_url']);
// подсчет сколько непустых в базе
$activ_rows = $total_rows - $hole_rows;
// Выводим ее
if($_SESSION['vis_all_links']=="Да") {
if($_SESSION['vis_user_lang']=="eng") {echo "Links in catalogue: <b>"."$all_links"."</b><br>";} else{echo "Ссылок в каталоге: <b>"."$all_links"."</b><br>";}
}
if($_SESSION['vis_user_lang']=="eng") {echo "Links in section: <b>"."$activ_rows"."</b> || Pages: "."$pages_scale";} else {echo "В разделе: <b>"."$activ_rows"."</b> || Страницы: "."$pages_scale";}
// Готовим from_row и to_row для цикла постраничного вывода
$from_row = $_GET['page']*$_SESSION['imp_links_page']-$_SESSION['imp_links_page'];
$to_row = $from_row+$_SESSION['imp_links_page']-1;
?>