<?php
$x = 7; // Number of hotels on page
$title = ""; // ???
$new_link = '';
$s = '';
$test = isset($_GET['test']) ? $_GET['test'] : null;
if (isset($_GET['search'])) {
	$search = $_GET['search'];
	$title = 'Ïîèñê ïî ñëîâó "'.$search.'" ';
}
if (isset($_GET['demand'])) {
		$demand = $_GET['demand'];
		$title = "- Çàÿâêà íà ïîêóïêó";
		$demand_link = " style='text-decoration:none;background-color:#dadaee;color:#6ec6cd;border-right:5px solid #cbcbff;cursor:default;'";
}
if (isset($_GET['r'])) // Region title, country title, this region's hotels
	{
		$r = $_GET['r'];
		$result_title = mysql_query("SELECT title,country FROM regions WHERE id='$r'",$db);
		$myrow_title = mysql_fetch_array($result_title);
		$result_country = mysql_query("SELECT title FROM countries WHERE id='$myrow_title[country]'",$db);
		$myrow_country = mysql_fetch_array($result_country);
		$title = "- ".$myrow_country['title'].", ".$myrow_title['title'];
	}
if (isset($_GET['qwe'])) // Country, this country's hotels
	{
		$qwe = $_GET['qwe'];
		$result_title = mysql_query("SELECT title FROM countries WHERE id='$qwe'",$db);
		$myrow_title = mysql_fetch_array($result_title);
		$title = "- ".$myrow_title['title'];
	}
if (isset($_GET['h'])) // Hotel
	{
		$h = $_GET['h'];
		$result_title = mysql_query("SELECT title FROM hotels WHERE id='$h'",$db);
		$myrow_title = mysql_fetch_array($result_title);
		$title = "- ".$myrow_title['title'];
	}
if (isset($_GET['about'])) // About company
	{
		$about = $_GET['about'];
		$title = "- Î êîìïàíèè";
		$about_link = " style='text-decoration:none;background-color:#dadaee;color:#6ec6cd;border-right:5px solid #cbcbff;cursor:default;'";
	}
if (isset($_GET['new'])) // New hotels
	{
		$new = $_GET['new'];
		$title = "- Íîâûå ïðåäëîæåíèÿ";
		$new_link = " style='text-decoration:none;background-color:#dadaee;color:#6ec6cd;border-right:5px solid #cbcbff;cursor:default;'";
	}
if (isset($_GET['getmail']))
	{
		$getmail = $_GET['getmail'];
	}
if (!isset($h) && !isset($r) && !isset($qwe) && !isset($about) && !isset($new) && !isset($demand)) // Main page
	{
		$main = true;
		$main_link = " style='text-decoration:none;background-color:#dadaee;color:#6ec6cd;border-right:5px solid #cbcbff; cursor:default;'";
	}
if (isset($_GET['page'])) {
	$page = $_GET['page']; // number of page
	$start = $x * $page - $x; // from this hotel we start
	$next_page = $page + 1; // number of next page
	$next_2page = $page + 2; // number of next 2nd page
	$prev_page = $page - 1; // number of previous page
	$prev_2page = $page - 2; // number of previous 2nd page
} else {
	$page = 1; // number of page
	$start = 0; // from this hotel we start
	$next_page = 2; // number of next page
	$next_2page = 3; // number of next 2nd page
	$prev_page = 0; // number of previous page
	$prev_2page = -1; // number of previous 2nd page
}

$s = "ORDER BY h.forward DESC, h.id DESC"; // Default sorting
$sort_by_town = ""; // Style
$sort_by_price = ""; // Style
if (isset($_GET['s']))  // Sorting
	{
		$s = $_GET['s'];
		if ($s == "town") {$s = "ORDER BY town" ;}
		if ($s == "price") {$s = "ORDER BY price_s";}
		$s == "ORDER BY town" ? $sort_by_town = "style='background:#dadaee; text-decoration:none;'" : $sort_by_price = "style='background:#dadaee; text-decoration:none;'";
	}
	
$result = mysql_query("SELECT visible,main FROM about",$db); // Viewing "about" and "main" on page?
$myrow = mysql_fetch_array($result);
if ($myrow['visible'] == 1) // "about" is visible
	{
		$vis = 1;
	}
else // "about" is invisible
	{
		$vis = 0;
	}
if ($myrow['main'] == 1) // "main" is visible
	{
	    $mai = 1;
	}
else // "main" is invisible
	{
		$mai = 0;
	}
if (isset($_GET['form'])) {$form = $_GET['form'];}
if (isset($_GET['page_name'])) {$page_name = $_GET['page_name'];}
if (isset($_GET['slug'])) { $slug = $_GET['slug']; }
if (isset($_GET['adv'])) { $adv = $_GET['adv']; }
if (isset($_GET['text_name'])) { $text_name = $_GET['text_name']; }
if (isset($_GET['sitemap'])) { $sitemap = $_GET['sitemap']; }

if (isset($_GET['action'])) { $action = $_GET['action']; }

?>