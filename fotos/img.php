<?php
$src = $_GET['src'];
$ext = substr($src, strlen($src)-4, 4);
if ($ext == '.jpg') { header("Content-type: image/jpeg"); $qwe = imagecreatefromjpeg($src); }
if ($ext == '.gif') { header("Content-type: image/gif"); $qwe = imagecreatefromgif($src); }
if ($ext == '.png') { header("Content-type: image/png"); $qwe = imagecreatefrompng($src); }
$pidar = imagecreatefrompng('text2.png');
imagecopy($qwe,$pidar,5,0,0,0,163,159);
if ($ext == '.jpg') {imagejpeg($qwe,NULL,100);}
if ($ext == '.gif') {imagegif($qwe,NULL,100);}
if ($ext == '.png') {imagepng($qwe,NULL,100);}
?>