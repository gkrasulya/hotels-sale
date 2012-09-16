<?php
session_start();
$code = rand(1000000,9999999);
$_SESSION['code'] = "$code";
$Image = imageCreateFromPng ("images/code.png");
$Color = imageColorAllocate($Image, 192, 192, 192);
settype ($code, "string");
imageString($Image, 16, 18, 3, $code, $Color);
Header("Content-type: image/png");
imagePng($Image);
imageDestroy($Image);
?>