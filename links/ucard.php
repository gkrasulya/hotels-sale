<?php
// *******************************************************************************
// находим дату добавления ссылки в каталог
// *******************************************************************************
$submit_date = date("Y-m-d H:i:s", $row_base[0]);
// *******************************************************************************
// находим дату добавления ссылки в каталог
// *******************************************************************************
// *******************************************************************************
// находим абсолютный адрес данной ссылки в каталоге, только если был поиск
// *******************************************************************************
if($_SESSION['flag_search']==1) {
	
// Находим ID категории для текущей ссылки
for($k=0; $k<count($categories_array); $k++){
$row_category = explode("|", $categories_array[$k]);
if($row_category[1] == $row_base[4]) { $category = "$row_category[0]"; break; }
}

// Ссылки из нужной категории во временный массив
$qnt_links = 0; // счетчик кол-ва ссылок в категориях в 0
for($k=0; $k<count($base_array); $k++){
$row_link = explode("|", $base_array[$k]);
if($row_link[4] == $row_base[4]) { $tmp_links_array[$qnt_links] = "$base_array[$k]"; $qnt_links++; }
}

// На каком месте в категории текущая ссылка
$row_in_category = 0;
for($n=0;$n<count($tmp_links_array);$n++) {
$link_in_page = explode("|", $tmp_links_array[$n]);
if($link_in_page[0] != $row_base[0]) { $row_in_category++; } else { $row_in_category++; break; }
}

// на какой странице
$page = ceil($row_in_category/$_SESSION['imp_links_page']);

// Определяем путь до ссылки
if($_SESSION['imp_mode_url']=="Статический") {
$link_place = "links_"."$category"."_"."$page".".html#"."$row_base[0]";
} else {
$link_place = "http://"."$_SERVER[HTTP_HOST]"."$_SERVER[PHP_SELF]"."?category="."$category"."&page="."$page"."#"."$row_base[0]";
}
if($_SESSION['vis_user_lang']=="eng") {$link_place_w = "View";} else {$link_place_w = "Смотреть";}


} // end if флаг поиска
// *******************************************************************************
// находим абсолютный адрес данной ссылки в каталоге, только если был поиск
// *******************************************************************************

// *******************************************************************************
// выводим карточку ссылки, только если она активна
// *******************************************************************************
if($row_base[16]!="hide" AND $row_base[16]!="hole" AND strlen($row_base[2])>7) {
for($k=0;$k<count($categories_array);$k++) { // ищем ID категории
$row_categories = explode("|", $categories_array[$k]);
if($row_categories[1]==$row_base[4]) { $category_id = "$row_categories[0]"; break; }
}

// статический или динамический режим отображения--------------
if($_SESSION['imp_mode_url']=="Статический") {
$link_mode_url = "<a href=links_"."$category_id"."_1.html>";
} else {
$link_mode_url = "<a href=index.php?category="."$category_id"."&page=1>";
}

if($_SESSION['vis_none_or_cy']=="Кнопку CY Яндекса") { 

$yandex = parse_url($row_base[2]);
$yandex = "$yandex[host]";
$yandex = "<a href=http://www.yandex.ru/cy?base=0&host="."$yandex"." target=_blank><img src=http://www.yandex.ru/cycounter?"."$yandex"." width=88 height=31 border=0></a>";
}

echo "<a name="."$row_base[0]".">&nbsp;</a><div id=Card>";
echo "<div id=CardText>";
if($_SESSION['vis_show_button']=="Да") {
if($row_base[6]=="") {
if($_SESSION['vis_none_or_cy']=="Кнопку-заглушку") { echo "<img src=admin/images/notimage.gif>"."$row_base[5]"."</div>"; }
if($_SESSION['vis_none_or_cy']=="Кнопку CY Яндекса") { echo "$yandex"."$row_base[5]"."</div>"; }
} else { echo "$row_base[6]"."$row_base[5]"."</div>"; }
} else { echo "$row_base[5]"."</div>"; }
if($_SESSION['vis_show_cy']=="Да"||$_SESSION['vis_show_pr']=="Да"||$_SESSION['vis_show_date']=="Да") { echo "<div id=CardData>"; }
if($_SESSION['vis_show_cy']=="Да") { echo "<div id=CardCy>CY: "."$row_base[10]"."</div>"; }
if($_SESSION['vis_show_pr']=="Да") { echo "<div id=CardPr>PR: "."$row_base[12]"."</div>"; }
if($_SESSION['vis_show_date']=="Да") {
if($_SESSION['vis_user_lang']=="eng") {echo "<div id=CardTime>Added: "."$submit_date"."</div>";} else {echo "<div id=CardTime>Добавлена: "."$submit_date"."</div>";}
}
if($_SESSION['vis_show_cy']=="Да"||$_SESSION['vis_show_pr']=="Да"||$_SESSION['vis_show_date']=="Да") { echo "</div>"; }
if($_SESSION['vis_show_cat']=="Да") {
if($_SESSION['vis_user_lang']=="eng") {echo "<div id=CardCategory>Category: "."$link_mode_url"."$row_base[4]"."</a></div>";} else {echo "<div id=CardCategory>Категория: "."$link_mode_url"."$row_base[4]"."</a></div>";}
}
if($_SESSION['flag_search']==1) { echo "<div id=CardLinkPlace><a href="."$link_place"."><i>"."$link_place_w"."</i></a></div>"; }
echo "</div>";

}
// *******************************************************************************
// выводим карточку ссылки, только если она активна
// *******************************************************************************

if($_SESSION['vis_show_hh']=="Да") {

if($row_base[16]=="hole") {
echo "<div id=Card>";
echo "<div id=CardText>";
if($_SESSION['vis_show_button']=="Да") {
echo "<img src=admin/images/notimage.gif>";
if($_SESSION['vis_user_lang']=="eng") {echo "The link which had been placed here, removed from the directory.";} else {echo "Ссылка, которая была размещена здесь, удалена из каталога.";}
echo "</div>";
} else {
if($_SESSION['vis_user_lang']=="eng") {echo "The link which had been placed here, removed from the directory.";} else {echo "Ссылка, которая была размещена здесь, удалена из каталога.</div>";}
}
echo "</div>";
}

if($row_base[16]=="hide") {
echo "<div id=Card>";
echo "<div id=CardText>";
if($_SESSION['vis_show_button']=="Да") {
echo "<img src=admin/images/notimage.gif>";
if($_SESSION['vis_user_lang']=="eng") {echo "The link which had been placed here, is temporarily hidden.";} else {echo "Ссылка, которая была размещена здесь, временно скрыта.";}
echo "</div>";
} else {
if($_SESSION['vis_user_lang']=="eng") {echo "The link which had been placed here, is temporarily hidden.";} else {echo "Ссылка, которая была размещена здесь, временно скрыта.</div>";}
}
echo "</div>";
}

}
?>