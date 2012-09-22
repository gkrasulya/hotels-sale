<?php
// Last modified: 20-02-2006
function Cut_Tags_U($text_codes) {
$search = array("'<u[^>]*?>'si","'</u>'si");
$replace = array("","");
$text_codes = preg_replace ($search, $replace, $text_codes);
return $text_codes;
}
function Cut_Tags_Strong($text_codes) {
$search = array("'<strong[^>]*?>'si","'</strong>'si");
$replace = array("","");
$text_codes = preg_replace ($search, $replace, $text_codes);
return $text_codes;
}
function Cut_Tags_P($text_codes) {
$search = array("'<p[^>]*?>'si","'</p>'si");
$replace = array("","");
$text_codes = preg_replace ($search, $replace, $text_codes);
return $text_codes;
}
function Cut_Tags_Img($text_codes) {
$search = array("'<img[^>]*?>'si");
$replace = array("");
$text_codes = preg_replace ($search, $replace, $text_codes);
return $text_codes;
}
function Cut_Tags_I($text_codes) {
$search = array("'<i[^>mg]*?>'si","'</i>'si");
$replace = array("","");
$text_codes = preg_replace ($search, $replace, $text_codes);
return $text_codes;
}
function Cut_Tags_Font($text_codes) {
$search = array("'<font[^>]*?>'si","'</font>'si");
$replace = array("","");
$text_codes = preg_replace ($search, $replace, $text_codes);
return $text_codes;
}
function Cut_Tags_Flash($text_codes) {
$search = array("'<object[^>]*?>.*?</object>'si",
"'<object[^>]*?>'si",
"'<codebase[^>]*?>'si",
"'<param[^>]*?>'si",
"'<embed[^>]*?>.*?</embed>'si",
"'<noembed[^>]*?>.*?</noembed>'si");
$replace = array("","","","","","");
$text_codes = preg_replace ($search, $replace, $text_codes);
return $text_codes;
}
function Cut_Tags_Br($text_codes) {
$search = array("'<br[^>]*?>'si");
$replace = array(" ");
$text_codes = preg_replace ($search, $replace, $text_codes);
return $text_codes;
}
function Cut_Tags_B($text_codes) {
$search = array("'<b[^>r]*?>'si","'</b>'si");
$replace = array("","");
$text_codes = preg_replace ($search, $replace, $text_codes);
return $text_codes;
}
function Cut_Tags_A($text_codes) {
$search = array("'<a[^>]*?>'si","'</a>'si");
$replace = array("","");
$text_codes = preg_replace ($search, $replace, $text_codes);
return $text_codes;
}
function Cut_All_Exc($text_codes) {
$search = array(
"'<html[^>]*?>.*?</html>'si",
"'<html[^>]*?>'si",
"'<head[^>]*?>.*?</head>'si",
"'<head[^>]*?>'si",
"'<meta[^>]*?>'si",
"'<!--[^>]*?-->'si",
"'<style[^>]*?>'si",
"'</style>'si",
"'<script[^>]*?>.*?</script>'si",
"'<script[^>]*?>'si",
"'<map[^>]*?>.*?</map>'si",
"'<map[^>]*?>'si",
"'<area[^>]*?>'si",
"'<body[^>]*?>'si",
"'</body>'si",
"'<h1[^>]*?>'si",
"'</h1>'si",
"'<h2[^>]*?>'si",
"'</h2>'si",
"'<h3[^>]*?>'si",
"'</h3>'si",
"'<h4[^>]*?>'si",
"'</h4>'si",
"'<h5[^>]*?>'si",
"'</h5>'si",
"'<h6[^>]*?>'si",
"'</h6>'si",
"'<div[^>]*?>'si",
"'</div>'si",
"'<address[^>]*?>'si",
"'</address>'si",
"'<blockquote[^>]*?>'si",
"'</blockquote>'si",
"'<hr[^>]*?>'si",
"'<pre[^>]*?>'si",
"'</pre>'si",
"'<basefont[^>]*?>'si",
"'<strike[^>]*?>'si",
"'</strike>'si",
"'<big[^>]*?>'si",
"'</big>'si",
"'<small[^>]*?>'si",
"'</small>'si",
"'<sup[^>]*?>'si",
"'</sup>'si",
"'<sub[^>]*?>'si",
"'</sub>'si",
"'<tt[^>]*?>'si",
"'</tt>'si",
"'<var[^>]*?>'si",
"'</var>'si",
"'<cite[^>]*?>'si",
"'</cite>'si",
"'<ol[^>]*?>'si",
"'</ol>'si",
"'<ul[^>]*?>'si",
"'</ul>'si",
"'<li[^>]*?>'si",
"'</li>'si",
"'<dl[^>]*?>'si",
"'</dl>'si",
"'<dt[^>]*?>'si",
"'<dd[^>]*?>'si",
"'<applet[^>]*?>.*?</applet>'si",
"'<applet[^>]*?>'si",
"'<table[^>]*?>'si",
"'</table>'si",
"'<caption[^>]*?>'si",
"'</caption>'si",
"'<tr[^>]*?>'si",
"'</tr>'si",
"'<td[^>]*?>'si",
"'</td>'si",
"'<th[^>]*?>'si",
"'</th>'si",
"'<form[^>]*?>.*?</form>'si",
"'<form[^>]*?>'si",
"'<textarea[^>]*?>.*?</textarea>'si",
"'<textarea[^>]*?>'si",
"'<select[^>]*?>'si",
"'</select>'si",
"'<option[^>]*?>'si",
"'</option>'si",
"'<input[^>]*?>'si",
"'<span[^>]*?>'si",
"'</span>'si",
"'([\r\n])[\s]+'",
"'&#(\d+);'e"
);
$replace = array(
"","","","","","","","","","",
"","","","","","","","","","",
"","","","","","","","","","",
"","","","","","","","","","",
"","","","","","","","","","",
"","","","","","","","","","",
"","","","","","","","","","",
"","","","","","","","","","",
"","","","","",""," ","chr(\\1)"
);
$text_codes = preg_replace ($search, $replace, $text_codes);
$text_codes = str_replace ("|", " ", $text_codes);
$text_codes = str_replace ("\\", "", $text_codes);
$text_codes = str_replace ("'", "\"", $text_codes);
$text_codes = str_replace ("`", "\"", $text_codes);
$text_codes = trim(stripslashes($text_codes));
$text_codes = ereg_replace( "\x0D", " ", $text_codes);
$text_codes = ereg_replace( "\x0A", " ", $text_codes);
return $text_codes;
}
function Cut_All_All($text_codes) {
$search = array(
"'<html[^>]*?>.*?</html>'si",
"'<html[^>]*?>'si",
"'<head[^>]*?>.*?</head>'si",
"'<head[^>]*?>'si",
"'<meta[^>]*?>'si",
"'<!--[^>]*?-->'si",
"'<style[^>]*?>'si",
"'</style>'si",
"'<script[^>]*?>.*?</script>'si",
"'<script[^>]*?>'si",
"'<map[^>]*?>.*?</map>'si",
"'<map[^>]*?>'si",
"'<area[^>]*?>'si",
"'<body[^>]*?>'si",
"'</body>'si",
"'<a[^>]*?>'si",
"'</a>'si",
"'<h1[^>]*?>'si",
"'</h1>'si",
"'<h2[^>]*?>'si",
"'</h2>'si",
"'<h3[^>]*?>'si",
"'</h3>'si",
"'<h4[^>]*?>'si",
"'</h4>'si",
"'<h5[^>]*?>'si",
"'</h5>'si",
"'<h6[^>]*?>'si",
"'</h6>'si",
"'<p[^>]*?>'si",
"'</p>'si",
"'<div[^>]*?>'si",
"'</div>'si",
"'<address[^>]*?>'si",
"'</address>'si",
"'<blockquote[^>]*?>'si",
"'</blockquote>'si",
"'<br[^>]*?>'si",
"'<hr[^>]*?>'si",
"'<pre[^>]*?>'si",
"'</pre>'si",
"'<basefont[^>]*?>'si",
"'<font[^>]*?>'si",
"'</font>'si",
"'<i[^>]*?>'si",
"'</i>'si",
"'<b[^>]*?>'si",
"'</b>'si",
"'<u[^>]*?>'si",
"'</u>'si",
"'<strong[^>]*?>'si",
"'</strong>'si",
"'<em[^>]*?>'si",
"'</em>'si",
"'<s[^>]*?>'si",
"'</s>'si",
"'<strike[^>]*?>'si",
"'</strike>'si",
"'<big[^>]*?>'si",
"'</big>'si",
"'<small[^>]*?>'si",
"'</small>'si",
"'<sup[^>]*?>'si",
"'</sup>'si",
"'<sub[^>]*?>'si",
"'</sub>'si",
"'<tt[^>]*?>'si",
"'</tt>'si",
"'<var[^>]*?>'si",
"'</var>'si",
"'<cite[^>]*?>'si",
"'</cite>'si",
"'<ol[^>]*?>'si",
"'</ol>'si",
"'<ul[^>]*?>'si",
"'</ul>'si",
"'<li[^>]*?>'si",
"'</li>'si",
"'<dl[^>]*?>'si",
"'</dl>'si",
"'<dt[^>]*?>'si",
"'<dd[^>]*?>'si",
"'<img[^>]*?>'si",
"'<codebase[^>]*?>'si",
"'<param[^>]*?>'si",
"'<embed[^>]*?>'si",
"'</embed>'si",
"'<noembed[^>]*?>'si",
"'</noembed>'si",
"'<applet[^>]*?>.*?</applet>'si",
"'<applet[^>]*?>'si",
"'<table[^>]*?>'si",
"'</table>'si",
"'<caption[^>]*?>'si",
"'</caption>'si",
"'<tr[^>]*?>'si",
"'</tr>'si",
"'<td[^>]*?>'si",
"'</td>'si",
"'<th[^>]*?>'si",
"'</th>'si",
"'<object[^>]*?>.*?</object>'si",
"'<object[^>]*?>'si",
"'<form[^>]*?>.*?</form>'si",
"'<form[^>]*?>'si",
"'<textarea[^>]*?>.*?</textarea>'si",
"'<textarea[^>]*?>'si",
"'<select[^>]*?>'si",
"'</select>'si",
"'<option[^>]*?>'si",
"'</option>'si",
"'<input[^>]*?>'si",
"'<span[^>]*?>'si",
"'</span>'si",
"'([\r\n])[\s]+'",
"'&#(\d+);'e"
);
$replace = array(
"","","","","","","","","","",
"","","","","","","","","","",
"","","","","","","","","","",
"","","","","","","","","","",
"","","","","","","","","","",
"","","","","","","","","","",
"","","","","","","","","","",
"","","","","","","","","","",
"","","","","","","","","","",
"","","","","","","","","","",
"","","","","","","","","","",
"",""," ",""," ","chr(\\1)"
);
$text_codes = preg_replace ($search, $replace, $text_codes);
$text_codes = str_replace ("|", " ", $text_codes);
$text_codes = str_replace ("\\", "", $text_codes);
$text_codes = str_replace ("'", "\"", $text_codes);
$text_codes = str_replace ("`", "\"", $text_codes);
$text_codes = trim(stripslashes($text_codes));
$text_codes = ereg_replace( "\x0D", " ", $text_codes);
$text_codes = ereg_replace( "\x0A", " ", $text_codes);
return $text_codes;
}
// функция спец. для писем
function Cut_Letter($text_codes) {
$search = array(
"'<html[^>]*?>.*?</html>'si",
"'<html[^>]*?>'si",
"'<head[^>]*?>.*?</head>'si",
"'<head[^>]*?>'si",
"'<meta[^>]*?>'si",
"'<!--[^>]*?-->'si",
"'<style[^>]*?>'si",
"'</style>'si",
"'<script[^>]*?>.*?</script>'si",
"'<script[^>]*?>'si",
"'<map[^>]*?>.*?</map>'si",
"'<map[^>]*?>'si",
"'<area[^>]*?>'si",
"'<body[^>]*?>'si",
"'</body>'si",
"'<h1[^>]*?>'si",
"'</h1>'si",
"'<h2[^>]*?>'si",
"'</h2>'si",
"'<h3[^>]*?>'si",
"'</h3>'si",
"'<h4[^>]*?>'si",
"'</h4>'si",
"'<h5[^>]*?>'si",
"'</h5>'si",
"'<h6[^>]*?>'si",
"'</h6>'si",
"'<p[^>]*?>'si",
"'</p>'si",
"'<div[^>]*?>'si",
"'</div>'si",
"'<address[^>]*?>'si",
"'</address>'si",
"'<blockquote[^>]*?>'si",
"'</blockquote>'si",
"'<br[^>]*?>'si",
"'<hr[^>]*?>'si",
"'<pre[^>]*?>'si",
"'</pre>'si",
"'<basefont[^>]*?>'si",
"'<font[^>]*?>'si",
"'</font>'si",
"'<strong[^>]*?>'si",
"'</strong>'si",
"'<em[^>]*?>'si",
"'</em>'si",
"'<s[^>]*?>'si",
"'</s>'si",
"'<strike[^>]*?>'si",
"'</strike>'si",
"'<big[^>]*?>'si",
"'</big>'si",
"'<small[^>]*?>'si",
"'</small>'si",
"'<sup[^>]*?>'si",
"'</sup>'si",
"'<sub[^>]*?>'si",
"'</sub>'si",
"'<tt[^>]*?>'si",
"'</tt>'si",
"'<var[^>]*?>'si",
"'</var>'si",
"'<cite[^>]*?>'si",
"'</cite>'si",
"'<ol[^>]*?>'si",
"'</ol>'si",
"'<ul[^>]*?>'si",
"'</ul>'si",
"'<li[^>]*?>'si",
"'</li>'si",
"'<dl[^>]*?>'si",
"'</dl>'si",
"'<dt[^>]*?>'si",
"'<dd[^>]*?>'si",
"'<codebase[^>]*?>'si",
"'<param[^>]*?>'si",
"'<embed[^>]*?>'si",
"'</embed>'si",
"'<noembed[^>]*?>'si",
"'</noembed>'si",
"'<applet[^>]*?>.*?</applet>'si",
"'<applet[^>]*?>'si",
"'<table[^>]*?>'si",
"'</table>'si",
"'<caption[^>]*?>'si",
"'</caption>'si",
"'<tr[^>]*?>'si",
"'</tr>'si",
"'<td[^>]*?>'si",
"'</td>'si",
"'<th[^>]*?>'si",
"'</th>'si",
"'<object[^>]*?>.*?</object>'si",
"'<object[^>]*?>'si",
"'<form[^>]*?>.*?</form>'si",
"'<form[^>]*?>'si",
"'<textarea[^>]*?>.*?</textarea>'si",
"'<textarea[^>]*?>'si",
"'<select[^>]*?>'si",
"'</select>'si",
"'<option[^>]*?>'si",
"'</option>'si",
"'<input[^>]*?>'si",
"'<span[^>]*?>'si",
"'</span>'si",
"'([\r\n])[\s]+'",
"'&#(\d+);'e"
);
$replace = array(
"","","","","","","","","","",
"","","","","","","","","","",
"","","","","","","","","","",
"","","","","","","","","","",
"","","","","","","","","","",
"","","","","","","","","","",
"","","","","","","","","","",
"","","","","","","","","","",
"","","","","","","","","","",
"","","","","","","","","","",
"","","","",""," ","chr(\\1)"
);
$text_codes = preg_replace ($search, $replace, $text_codes);
$text_codes = str_replace ("|", " ", $text_codes);
$text_codes = str_replace ("'", "\"", $text_codes);
$text_codes = str_replace ("`", "\"", $text_codes);
$text_codes = trim($text_codes);
$text_codes = ereg_replace( "\x0D", " ", $text_codes);
$text_codes = ereg_replace( "\x0A", " ", $text_codes);
return $text_codes;
}
// если есть IMG - не должно быть текста
function Cut_Img_Notext($text_codes) {
$temp = strtolower($text_codes);
$count_img = substr_count($temp, "<img");
if($count_img > 0) {
$text_codes = preg_replace ("'(.*?)(<a[^>]*?>)(.*?)(<img[^>]*?>)(.*?)(</a>)(.*)'si", "\${2}\${4}\${6}", $text_codes);
$text_codes = preg_replace ("'(.*?)((<a[^>]*?>)*<img[^>]*?>(</a>)*)(.*)'si", "\${2}", $text_codes);
}
return $text_codes;
}

// функция спец. для письма админу
function Cut_Submit_Admin_Letter($text_codes) {
$search = array(
"'<html[^>]*?>.*?</html>'si",
"'<html[^>]*?>'si",
"'<head[^>]*?>.*?</head>'si",
"'<head[^>]*?>'si",
"'<meta[^>]*?>'si",
"'<!--[^>]*?-->'si",
"'<style[^>]*?>'si",
"'</style>'si",
"'<script[^>]*?>.*?</script>'si",
"'<script[^>]*?>'si",
"'<map[^>]*?>.*?</map>'si",
"'<map[^>]*?>'si",
"'<area[^>]*?>'si",
"'<body[^>]*?>'si",
"'</body>'si",
"'<h1[^>]*?>'si",
"'</h1>'si",
"'<h2[^>]*?>'si",
"'</h2>'si",
"'<h3[^>]*?>'si",
"'</h3>'si",
"'<h4[^>]*?>'si",
"'</h4>'si",
"'<h5[^>]*?>'si",
"'</h5>'si",
"'<h6[^>]*?>'si",
"'</h6>'si",
"'<p[^>]*?>'si",
"'</p>'si",
"'<div[^>]*?>'si",
"'</div>'si",
"'<address[^>]*?>'si",
"'</address>'si",
"'<blockquote[^>]*?>'si",
"'</blockquote>'si",
"'<br[^>]*?>'si",
"'<hr[^>]*?>'si",
"'<pre[^>]*?>'si",
"'</pre>'si",
"'<basefont[^>]*?>'si",
"'<font[^>]*?>'si",
"'</font>'si",
"'<strong[^>]*?>'si",
"'</strong>'si",
"'<em[^>]*?>'si",
"'</em>'si",
"'<s[^>]*?>'si",
"'</s>'si",
"'<strike[^>]*?>'si",
"'</strike>'si",
"'<big[^>]*?>'si",
"'</big>'si",
"'<small[^>]*?>'si",
"'</small>'si",
"'<sup[^>]*?>'si",
"'</sup>'si",
"'<sub[^>]*?>'si",
"'</sub>'si",
"'<tt[^>]*?>'si",
"'</tt>'si",
"'<var[^>]*?>'si",
"'</var>'si",
"'<cite[^>]*?>'si",
"'</cite>'si",
"'<ol[^>]*?>'si",
"'</ol>'si",
"'<ul[^>]*?>'si",
"'</ul>'si",
"'<li[^>]*?>'si",
"'</li>'si",
"'<dl[^>]*?>'si",
"'</dl>'si",
"'<dt[^>]*?>'si",
"'<dd[^>]*?>'si",
"'<codebase[^>]*?>'si",
"'<param[^>]*?>'si",
"'<embed[^>]*?>'si",
"'</embed>'si",
"'<noembed[^>]*?>'si",
"'</noembed>'si",
"'<applet[^>]*?>.*?</applet>'si",
"'<applet[^>]*?>'si",
"'<table[^>]*?>'si",
"'</table>'si",
"'<caption[^>]*?>'si",
"'</caption>'si",
"'<tr[^>]*?>'si",
"'</tr>'si",
"'<td[^>]*?>'si",
"'</td>'si",
"'<th[^>]*?>'si",
"'</th>'si",
"'<object[^>]*?>.*?</object>'si",
"'<object[^>]*?>'si",
"'<form[^>]*?>.*?</form>'si",
"'<form[^>]*?>'si",
"'<textarea[^>]*?>.*?</textarea>'si",
"'<textarea[^>]*?>'si",
"'<select[^>]*?>'si",
"'</select>'si",
"'<option[^>]*?>'si",
"'</option>'si",
"'<input[^>]*?>'si",
"'<span[^>]*?>'si",
"'</span>'si",
"'&#(\d+);'e"
);
$replace = array(
"","","","","","","","","","",
"","","","","","","","","","",
"","","","","","","","","","",
"","","","","","","","","","",
"","","","","","","","","","",
"","","","","","","","","","",
"","","","","","","","","","",
"","","","","","","","","","",
"","","","","","","","","","",
"","","","","","","","","","",
"","","","","","chr(\\1)"
);
$text_codes = preg_replace ($search, $replace, $text_codes);
$text_codes = str_replace ("|", " ", $text_codes);
$text_codes = str_replace ("'", "\"", $text_codes);
$text_codes = str_replace ("`", "\"", $text_codes);
$text_codes = trim(stripslashes($text_codes));
return $text_codes;
}


?>