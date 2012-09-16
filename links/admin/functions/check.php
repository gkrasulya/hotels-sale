<?php
// Last modified: 20-02-2006

// открывающие и закрывающие А должны быть равны
function Check_A_Eqv($text_codes) {
$temp = strtolower($text_codes);
if(substr_count($temp, "<a ")!=substr_count($temp, "</a>")) {
$result = "Количество открывающих тэгов А не равно количеству закрывающих тэгов А или некорректная запись тэгов А!";
} else { $result = "OK"; }
return $result;
}
// проверим количество символов в коде
function Check_Symbol_Code($text_codes,$symbol_code) {
$len = strlen($text_codes);
if($len > $symbol_code) {
$result = "В предлагаемом коде $len символов! Установленный лимит - $symbol_code!";
} else { $result = "OK"; }
return $result;
}
// проверим количество ссылок в коде
function Check_Links_Code($text_codes,$links_code) {
$temp = strtolower($text_codes);
$temp = str_replace ("'", "", $temp);
$temp = str_replace ("\"", "", $temp);
$temp = str_replace (" ", "", $temp);
$count_href = substr_count($temp, "href=http://");
if($count_href > $links_code) {
$result = "В предлагаемом коде $count_href ссылок! Установленный лимит - $links_code!";
} else { $result = "OK"; }
return $result;
}
// проверим те ли домены в коде
function Check_Domen_Domen($text_codes,$links_code) {
$string = strtolower($text_codes);
$string = str_replace ("'", "", $string);
$string = str_replace ("\"", "", $string);
$array = split( "http://", $string, $links_code);
for($i=1;$i<count($array);$i++) {
$row = preg_replace ("'(.[^>/[:space:]]*)(.*)'si", "\${1}", $array[$i]);
if($i==1) {
$host = $row;
$result = "OK";
} else {
if($host!=$row) { $result = "Не все ссылки в коде указывают на один и тот же домен<br>или разные варианты обращения к домену!"; break; }
}
}
if(count($array)==1) { $result = "В коде не содержится ни одной ссылки!"; }
return $result;
}
// проверим тот ли домен ссылается на нас, который в коде
function Check_Myhome_Domen($text_codes,$domen) {
$temp = strtolower($text_codes);
$temp = str_replace ("'", "", $temp);
$temp = str_replace ("\"", "", $temp);
$temp = str_replace (" ", "", $temp);
$string = "href="."$domen";
$count_links = substr_count($temp, "$string");
$count_href = substr_count($temp, "href=http://");
if($count_href!=$count_links) {
$myhome_domen = $count_href - $count_links;
$result = "$myhome_domen ссылки(а) в предлагаемом коде не соответствует домену<br>или разные варианты обращения к домену!";
} else { $result = "OK"; }
return $result;
}
// проверим если флеш или картинка без ссылки
function Check_Img_Flash($text_codes,$domen) {
$temp = strtolower($text_codes);
$temp = str_replace ("'", "", $temp);
$temp = str_replace ("\"", "", $temp);
$temp = str_replace (" ", "", $temp);
$count_href = substr_count($temp, "href=http://");
$string = "src="."$domen";
$count_links = substr_count($temp, "$string");
if($count_href == 0 AND $count_links == 0) {
$result = "Введен текст, не содержащий ни одной ссылки, флеш-баннер или картинка,<br>которые находятся не на Вашем домене,<br>или разные варианты обращения к домену!";
} else { $result = "OK"; }
return $result;
}
// проверим тэг А если картинка с тэгом А
function Check_Img_A($text_codes,$domen) {
$temp = strtolower($text_codes);
$temp = str_replace ("'", "", $temp);
$temp = str_replace ("\"", "", $temp);
$temp = str_replace (" ", "", $temp);
$count_href = substr_count($temp, "href=http://");
$search = "href="."$domen";
if($count_href>0) {
if(substr_count($temp, "$search")==0||substr_count($temp, "$search")>1) {
$result = "Баннер ссылается не на тот домен, на котором стоит ответная ссылка,<br>или разные варианты обращения к домену!";
} else {
$result = "OK";
}
} else {
$result = "OK";
}
return $result;
}
// ширина, высота и рамка картинки
function Check_Img_Size($text_codes) {
$temp = strtolower($text_codes);
$temp = str_replace ("'", "", $temp);
$temp = str_replace ("\"", "", $temp);
$temp = str_replace (" ", "", $temp);
$count_img = substr_count($temp, "<img");
$count_object = substr_count($temp, "<object");
$count_embed = substr_count($temp, "<embed");
if($count_img>0) {
if(!preg_match ("'(<img){1}(.)*(width=88){1}(.)*(>){1}\D'si", $temp)) { $result = "В HTML-коде картинки должно быть явно указано width=88<br>"; }
if(!preg_match ("'(<img){1}(.)*(height=31){1}(.)*(>){1}\D'si", $temp)) { $result .= "В HTML-коде картинки должно быть явно указано height=31<br>"; }
if(!preg_match ("'(<img){1}(.)*(border=0){1}(.)*(>){1}\D'si", $temp)) { $result .= "В HTML-коде картинки должно быть явно указано border=0<br>"; }
}
if($count_object>0 OR $count_embed>0) {
if(!preg_match ("'width=88\D.*?width=88\D'si", $temp)) { $result = "В HTML-коде флеш-баннера должно быть явно указано width=88 "; }
if(!preg_match ("'height=31\D.*?height=31\D'si", $temp)) { $result .= "В HTML-коде флеш-баннера должно быть явно указано height=31 "; }
if(!preg_match ("'border=0\D.*?border=0\D'si", $temp)) { $result .= "В HTML-коде флеш-баннера должно быть явно указано border=0"; }
if(!empty($result)) { $result .= " Проверьте внимательно размеры флеш-баннера в тэгах OBJECT и EMBED!"; }
}
if(empty($result)) { $result = "OK"; }
return $result;
}
// приготовим вариант обращения к домену без www
function Short_Domen_Name($url) {
$parse_url = parse_url($url);
if(substr_count("$parse_url[host]", "www.") != 0) {
$result = str_replace("www.", "", "$parse_url[host]");
} else {
$result = $parse_url[host];
}
return $result;
}
?>