<?php
$src = $_GET['src'];

$ext_arr = explode('.', $src);
$ext = strtolower($ext_arr[count($ext_arr)-1]);

switch ($ext) {
	case 'jpg':
		$src_image = imagecreatefromjpeg($src);
		break;
	case 'jpeg':
		$src_image = imagecreatefromjpeg($src);
		break;
	case 'png':
		$src_image = imagecreatefrompng($src);
		break;
	case 'gif':
		$src_image = imagecreatefromgif($src);
		imagejpeg($src_image, 'tmp.jpg');
		$src_image = imagecreatefromjpeg('tmp.jpg');
		break;
}

$text = imagecreatefrompng('text3.png');


list ($width, $height, $type) = getimagesize($src);

imagecopy($src_image, $text, $width - 300, $height - 100, 0, 0, 291, 93);

header('Content-type: image/jpeg');
imagejpeg($src_image, null, 100);
?>