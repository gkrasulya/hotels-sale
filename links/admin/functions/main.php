<?php
// Last modified: 20-02-2006

// проверим вводимый URL
function Check_In_Url($url)
{
if(eregi("^(http://){1}.[^><[:space:]]*$", "$url")) {
return $url;
} else {
$url = "badly"; return $url;
}
}
// проверим вводимый E-MAIL
function Check_User_Mail($mail)
{
if(!eregi("^([_a-z0-9-])+(\.)*([_a-z0-9-])*@([_a-z0-9-])+(\.)*([_a-z0-9-])*\.([a-z]){2,4}$", "$mail")) { $mail = "badly"; }
return $mail;
}
// получение данных с удаленного сервера Curl
// используем только в submit.php и admin/add_lnk.php
function Get_Row_Urlink($urlink)
{
$ch = curl_init($urlink);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, 7);
$get_row_urlink = curl_exec($ch);
if(!$get_row_urlink) {$get_row_urlink = "badly";}
curl_close($ch);
return $get_row_urlink;
}

// проверка на наличие ответной ссылки
function Check_My_Link($urlink, $myhome)
{
$myhome = parse_url($myhome);
$myhome = "http://"."$myhome[host]";

$get_row_urlink = strtolower($urlink);
$cut_row_urlink = str_replace("\"", "", "$get_row_urlink");
$cut_row_urlink = str_replace("'", "", "$cut_row_urlink"); 
$cut_row_urlink = str_replace("'", "", "$cut_row_urlink");

$array_split_a = split("<a", $cut_row_urlink);

for($i=0;$i<count($array_split_a);$i++) {
if (ereg("(.){0,}[[:space:]]{1,}href[[:space:]]{0,}=[[:space:]]{0,}$myhome(.){0,}(</a>){1}(.){0,}", "$array_split_a[$i]")) {
if(!ereg("(.){0,}rel[[:space:]]{0,}=[[:space:]]{0,}nofollow(.){0,}(</a>){1}(.){0,}", "$array_split_a[$i]")) { $rel = "well"; } else { $rel = "badly"; }
if(!ereg("(.){0,}href[[:space:]]{0,}=[[:space:]]{0,}javascript(.){0,}(</a>){1}(.){0,}", "$array_split_a[$i]")) { $jav = "well"; } else { $jav = "badly"; }
if($rel=="well" AND $jav=="well") { $check_result = "well"; break; } else { $check_result = "badly"; }

} else {
$check_result = "badly";
}
 
}
return $check_result;
}
// проверка файла robots.txt
function Check_File_Robots($urlink)
{
$array_parse_urlink = parse_url($urlink);
$path_to_robots = "http://$array_parse_urlink[host]/robots.txt";
if(!$array_parse_urlink[path]||$array_parse_urlink[path] == "/") {
$check_robots[0] = "well";
} else {

$ch = curl_init($path_to_robots);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
$get_row_url = curl_exec($ch);
curl_close($ch);

if(!$get_row_url) {$check_robots[0] = "well"; } else {
$get_row_url_s = strtolower($get_row_url);
$array_split_row = split("disallow:", $get_row_url_s);
$count_folders = substr_count("$array_parse_urlink[path]", "/");
$path_to_folders = "$array_parse_urlink[path]";

for($k=0;$k<$count_folders;$k++) {
for($i=0;$i<count($array_split_row);$i++) {
if(eregi("^[[:space:]]{1,}($path_to_folders)[/]{0,}[[:space:]]{0,}$", "$array_split_row[$i]")) {$check_robots[0] = "badly"; $check_robots[1] = "$get_row_url"; return $check_robots; } else {$check_robots[0] = "well";}
}
$path_to_folders = strrpos("$path_to_folders", "/");
$path_to_folders = substr_replace("$array_parse_urlink[path]", "", "$path_to_folders");
}
}
}
return $check_robots;
}
// проверка метатэгов
function Check_Meta_Tag($urlink)
{
$tags = get_meta_tags($urlink);
$tags[robots] = strtolower($tags[robots]);
if (substr_count($tags[robots], "noindex")||substr_count($tags[robots], "none")||substr_count($tags[robots], "nofollow")) {
$check_meta = "badly";
} else {
$check_meta = "well";
}
return $check_meta;
}
// проверка тэгов noindex
function Check_Tag_Noindex($urlink, $myhome)
{
$myhome = parse_url($myhome);
$myhome = "http://"."$myhome[host]";
$get_row_urlink = strtolower($urlink);
$array_split_row = split("<noindex>", $get_row_urlink);
for($i=0;$i<count($array_split_row);$i++) {
if (eregi("(.)*($myhome)(.)*(</noindex>){1}(.)*", "$array_split_row[$i]")){$check_noindex = "badly"; break; } else {$check_noindex = "well";}
}
return $check_noindex;
}
// подсчет количества всех ссылок на странице
function Get_Out_Links($get_row_urlink)
{
$get_row_urlink = strtolower($get_row_urlink);
$cut_row_urlink = str_replace("\"", "", "$get_row_urlink");
$cut_row_urlink = str_replace("'", "", "$cut_row_urlink");
$cut_row_urlink = str_replace(" ", "", "$cut_row_urlink");
$cut_row_urlink = str_replace("href=mailto", "", "$cut_row_urlink");
$cut_row_urlink = str_replace("href=#", "", "$cut_row_urlink");
$cut_row_urlink = str_replace("href=javascript", "", "$cut_row_urlink");
$outlink_count = substr_count($cut_row_urlink, "href=");
return $outlink_count;
}

// подсчет количества только внешних ссылок на странице
function Get_Out_Links2($get_row_urlink, $urlink)
{
$get_row_urlink = strtolower($get_row_urlink);
$parse_url = parse_url($urlink);
if(substr_count("$parse_url[host]", "www.") != 0) {
$dmn1 = "href=http://"."$parse_url[host]";
$dmn2 = substr("$parse_url[host]", 4);
$dmn2 = "href=http://"."$dmn2";
} else {
$dmn1 = "href=http://www."."$parse_url[host]";
$dmn2 = "href=http://"."$parse_url[host]";
}
$cut_row_urlink = str_replace("\"", "", "$get_row_urlink");
$cut_row_urlink = str_replace("'", "", "$cut_row_urlink");
$cut_row_urlink = str_replace(" ", "", "$cut_row_urlink");
$cut_row_urlink = str_replace("href=mailto", "", "$cut_row_urlink");
$cut_row_urlink = str_replace("href=#", "", "$cut_row_urlink");
$cut_row_urlink = str_replace("href=javascript", "", "$cut_row_urlink");
$cut_row_urlink = str_replace("$dmn1", "", "$cut_row_urlink");
$cut_row_urlink = str_replace("$dmn2", "", "$cut_row_urlink");
$outlink_count = substr_count($cut_row_urlink, "href=http://");
return $outlink_count;
}

function Get_CY_Yandex($urlink, $old_cy) {
$array_urlink = parse_url($urlink);
$to_search = "http://bar-navig.yandex.ru/u?ver=2&lang=1049&url=http://"."$array_urlink[host]"."&target=_No__Name:5&show=1&thc=0";
$ch = curl_init($to_search);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
$curl_cy = curl_exec($ch);
curl_close($ch);
$curl_cy = str_replace("\"", "", "$curl_cy");
$curl_cy = str_replace(" ", "", "$curl_cy");
if(preg_match("/(tcyrang=)(\d{1})(value=)(\d{2,5})(\/)/is", $curl_cy, $arr_cy)) {
$cy = $arr_cy[4];
} else {
$cy = 0;
}
return $cy;
}

/*
// CY яндекса
function Get_CY_Yandex($urlink, $old_cy) {
$array_parse_urlink = parse_url($urlink);
if(substr_count("$array_parse_urlink[host]", "www.") != 0) {
$urlink = str_replace("www.", "", "$array_parse_urlink[host]");
} else {$urlink = $array_parse_urlink[host];}
$to_search = "http://search.yaca.yandex.ru/yca/cy/ch/$urlink/";
$ch = curl_init($to_search);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_TIMEOUT, 3);
$curl_cy = curl_exec($ch);
curl_close($ch);
$row_cy = "$urlink"."&"."numdoc=10"."&"."viddoc=full"."&"."sserver=0"."&"."ci=";
$result = stristr($curl_cy, "$row_cy");
if(!empty($result)) {
$len = strlen($row_cy);
$cy = substr("$result", $len, 6);
$position = strrpos("$cy", "\"");
$cy = substr("$cy", 0, $position);
} else {
if($old_cy!="-") {$cy = $old_cy;} else {$cy=0;}
}
return $cy;
}
*/
// PR GOOGLE
define('GOOGLE_MAGIC', 0xE6359A60);

function zeroFill($a, $b)
{
   $z = hexdec(80000000);
       if ($z & $a)
       {
           $a = ($a>>1);
           $a &= (~$z);
           $a |= 0x40000000;
           $a = ($a>>($b-1));
       }
       else
       {
           $a = ($a>>$b);
       }
       return $a;
}

function mix($a,$b,$c) {
 $a -= $b; $a -= $c; $a ^= (zeroFill($c,13));
 $b -= $c; $b -= $a; $b ^= ($a<<8);
 $c -= $a; $c -= $b; $c ^= (zeroFill($b,13));
 $a -= $b; $a -= $c; $a ^= (zeroFill($c,12));
 $b -= $c; $b -= $a; $b ^= ($a<<16);
 $c -= $a; $c -= $b; $c ^= (zeroFill($b,5));
 $a -= $b; $a -= $c; $a ^= (zeroFill($c,3));
 $b -= $c; $b -= $a; $b ^= ($a<<10);
 $c -= $a; $c -= $b; $c ^= (zeroFill($b,15));
 return array($a,$b,$c);
}

function GoogleCH($url, $length=null, $init=GOOGLE_MAGIC) {
   if(is_null($length)) {
       $length = sizeof($url);
   }
   $a = $b = 0x9E3779B9;
   $c = $init;
   $k = 0;
   $len = $length;
   while($len >= 12) {
       $a += ($url[$k+0] +($url[$k+1]<<8) +($url[$k+2]<<16) +($url[$k+3]<<24));
       $b += ($url[$k+4] +($url[$k+5]<<8) +($url[$k+6]<<16) +($url[$k+7]<<24));
       $c += ($url[$k+8] +($url[$k+9]<<8) +($url[$k+10]<<16)+($url[$k+11]<<24));
       $mix = mix($a,$b,$c);
       $a = $mix[0]; $b = $mix[1]; $c = $mix[2];
       $k += 12;
       $len -= 12;
   }
   $c += $length;
   switch($len)
   {
       case 11: $c+=($url[$k+10]<<24);
       case 10: $c+=($url[$k+9]<<16);
       case 9 : $c+=($url[$k+8]<<8);
       case 8 : $b+=($url[$k+7]<<24);
       case 7 : $b+=($url[$k+6]<<16);
       case 6 : $b+=($url[$k+5]<<8);
       case 5 : $b+=($url[$k+4]);
       case 4 : $a+=($url[$k+3]<<24);
       case 3 : $a+=($url[$k+2]<<16);
       case 2 : $a+=($url[$k+1]<<8);
       case 1 : $a+=($url[$k+0]);
   }
   $mix = mix($a,$b,$c);
   return $mix[2];
}

function strord($string) {
   for($i=0;$i<strlen($string);$i++) {
       $result[$i] = ord($string{$i});
   }
   return $result;
}

function Get_PR_Google($urlink) {
        $url = 'info:'.$urlink;
        $ch = GoogleCH(strord($url));
        $ch = "6$ch";
        $page = @file("http://www.google.com/search?client=navclient-auto&ch=$ch&features=Rank&q=info:".urlencode($urlink));
        $page = implode("", $page);

        if (preg_match("/Rank_1:(.):(.+?)\n/is", $page, $res)) {
                return "$res[2]";
        }
        else return "0";
}
// PR GOOGLE

function Get_Pages_Scale($total_rows, $page, $build_link, $row_per_page)
{
$tmp_row_per_page = $row_per_page;
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
if($pages > 6) {
if($prev_page != 0) { $pages_scale = "[<a href=$build_link?page=1> &lt;&lt; </a>]"; }
if($prev_page) { $pages_scale .= "[<a href=$build_link?page=$prev_page> &lt; </a>]"; }
}
for($i=$start_page;$i<=$end_page;$i++) {
if($i != $page) { $pages_scale .= "[<a href=$build_link?page=$i>$i</a>]"; }
elseif($i != 1) { $pages_scale .= "<b> $i </b>"; }
elseif($page != $pages) { $pages_scale .= "<b> 1 </b>"; }
}
if($page != $pages&&$pages > 6) { $pages_scale .= "[<a href=$build_link?page=$next_page> &gt; </a>][<a href=$build_link?page=$pages> &gt;&gt; </a>]"; }
if(!isset($pages_scale)||$pages_scale == "") { $pages_scale = "<b> 1 </b>"; }
return $pages_scale;
}

function gettime()
{
$part_time = explode(' ', microtime());
$real_time = $part_time[1].substr($part_time[0],1);
return $real_time;
}
?>