<?php
function Get_Pages_Scale($total_rows, $category, $page, $build_link, $row_per_page, $search, $mode_url)
{
$tmp_row_per_page = "$row_per_page";
$prev_page = $page - 1;
$next_page = $page + 1;
if($total_rows <= $tmp_row_per_page) { $pages = 1; }
elseif($total_rows % $tmp_row_per_page == 0) { $pages = $total_rows/$tmp_row_per_page; }
else { $pages = $total_rows/$tmp_row_per_page + 1; }
$pages = (int)$pages;
if($page < 7) { $start_page = 1; } else { $start_page = floor($page/7)*7; }
$end_page = $page + 6;
if($end_page > $pages) { $end_page = $pages; }
$pages_scale = "";

if($mode_url=="Статический") {
// -------------------------------------------------------------------------------
if($pages > 6) {
if($prev_page != 0) { if($category=="") { $pages_scale = "[<a href=links_1_"."$search".".html> &lt;&lt; </a>]"; } else { $pages_scale = "[<a href=links_"."$category"."_1.html> &lt;&lt; </a>]"; } }
if($prev_page) { if($category=="") { $pages_scale .= "[<a href=links_"."$prev_page"."_"."$search".".html> &lt; </a>]"; } else { $pages_scale .= "[<a href=links_"."$category"."_"."$prev_page".".html> &lt; </a>]"; } }
}
// -------------------------------------------------------------------------------
} else {
// -------------------------------------------------------------------------------
if($pages > 6) {
if($prev_page != 0) { $pages_scale = "[<a href="."$build_link"."?category="."$category"."&page=1&search="."$search"."> &lt;&lt; </a>]"; }
if($prev_page) { $pages_scale .= "[<a href="."$build_link"."?category="."$category"."&page="."$prev_page"."&search="."$search"."> &lt; </a>]"; }
}
// -------------------------------------------------------------------------------
}
// *******************************************************************************
if($mode_url=="Статический") {
// -------------------------------------------------------------------------------
for($i=$start_page;$i<=$end_page;$i++) {
if($i != $page) { if($category=="") { $pages_scale .= "[<a href=links_"."$i"."_"."$search".".html>"."$i"."</a>]"; } else { $pages_scale .= "[<a href=links_"."$category"."_"."$i".".html>"."$i"."</a>]"; } }
elseif($i != 1) { $pages_scale .= "<b> "."$i"." </b>"; }
elseif($page != $pages) { $pages_scale .= "<b> 1 </b>"; }
}
// -------------------------------------------------------------------------------
} else {
// -------------------------------------------------------------------------------
for($i=$start_page;$i<=$end_page;$i++) {
if($i != $page) { $pages_scale .= "[<a href="."$build_link"."?category="."$category"."&page="."$i"."&search="."$search".">"."$i"."</a>]"; }
elseif($i != 1) { $pages_scale .= "<b> "."$i"." </b>"; }
elseif($page != $pages) { $pages_scale .= "<b> 1 </b>"; }
}
// -------------------------------------------------------------------------------
}
// *******************************************************************************

if($mode_url=="Статический") {
// -------------------------------------------------------------------------------
if($page != $pages&&$pages > 6) { if($category=="") { $pages_scale .= "[<a href=links_"."$next_page"."_"."$search".".html> &gt; </a>][<a href=links_"."$pages"."_"."$search".".html> &gt;&gt; </a>]"; } else { $pages_scale .= "[<a href=links_"."$category"."_"."$next_page".".html> &gt; </a>][<a href=links_"."$category"."_"."$pages".".html> &gt;&gt; </a>]"; } }
// -------------------------------------------------------------------------------
} else {
// -------------------------------------------------------------------------------
if($page != $pages&&$pages > 6) { $pages_scale .= "[<a href="."$build_link"."?category="."$category"."&page="."$next_page"."&search="."$search"."> &gt; </a>][<a href="."$build_link"."?category="."$category"."&page="."$pages"."&search="."$search"."> &gt;&gt; </a>]"; }
// -------------------------------------------------------------------------------
}
// *******************************************************************************
if(!isset($pages_scale)||$pages_scale == "") { $pages_scale = "<b> 1 </b>"; }
return $pages_scale;
}
?>