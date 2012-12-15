<?php
global $hotel_id;
$title = strtolower($_FILES['foto']['name']);
$title_ = mktime();
	  
	  	function img_resize($new,$from,$width,$height,$quality)
	
		  {
		    global $img_wha;
			
			if ($img_wha[2] == 2) {$img = imagecreatefromjpeg($from);}
			if ($img_wha[2] == 1) {$img = imagecreatefromgif($from);}
			if ($img_wha[2] == 3) {$img = imagecreatefrompng($from);}
			$img_new = imagecreatetruecolor($width,$height);
			imagecopyresampled($img_new,$img,0,0,0,0,$width,$height,imagesx($img),imagesy($img));
			
			if ($img_wha[2] == 1) {imagegif($img_new,$new);}
			if ($img_wha[2] == 2) {imagejpeg($img_new,$new,$quality);}
			if ($img_wha[2] == 3) {imagepng($img_new,$new,$quality);}
			
			imagedestroy($img);
			imagedestroy($img_new);
		  }

$allowed_filetypes = array('.jpg','.gif','.png','.JPG','.GIF','.PNG','.jpeg','.JPEG'); // Здесь мы перечисляем допустимые типы файлов
$max_filesize = 52428800; // Максимальный размер загружаемого файла в байтах (в данном случае он равен 50 Мб).
$upload_path = '../add_fotos/'.$hotel_id.'/'; // Место, куда будут загружаться файлы (в данном случае это папка 'fotos').
if (! is_dir($upload_path)) { mkdir($upload_path); }
$filename = $_FILES['foto']['name']; // В переменную $filename заносим точное имя файла (включая расширение).
$filename = strtolower($filename);
$filename = strtr($filename,"абвгдежзийклмнопрстуфхцчшщъыьэюя &quot;\"","abvgdezziiklmnoprstufhc4ssyyyeua___");
$ext = substr($filename, strpos($filename,'.'), strlen($filename)-1);
if(!in_array($ext,$allowed_filetypes))
die('Данный тип файла не поддерживается.'.$ext);
if(filesize($_FILES['foto']['tmp_name']) > $max_filesize)
die('Фаил слишком большой.');
if(!is_writable($upload_path))
die('Невозможно загрузить фаил в папку. Установите права доступа - 777.');


  
if(move_uploaded_file($_FILES['foto']['tmp_name'],$upload_path.$title_.$ext))
  {
    $img_pre = "pre_".$title_.$ext;
	$img_big = $title_.$ext;
    
	$img = $upload_path.$title_.$ext;
	$img_wha = getimagesize($img);
	global $img_wha;
	if ($img_wha[0] > 150)
		  
	  {
	    global $type;
		global $img_wha;
		$y = $img_wha[1] / ($img_wha[0] / 150);
        img_resize('../add_fotos/'.$hotel_id.'/pre_'.$title_.$ext,'../add_fotos/'.$hotel_id.'/'.$title_.$ext,150,$y,50);
	  }
	$img_src = "../add_fotos/".$hotel_id.'/'.$title_."_".$title_;
    $image_ = mysql_query("INSERT INTO add_fotos (small,big,hotel_id) VALUES ('$img_pre','$img_big','$hotel_id')",$db);
	$result = mysql_query("SELECT id FROM add_fotos ORDER BY id DESC",$db);
	$myrow = mysql_fetch_array($result);
	$foto_id = $myrow['id'];

  }
else
  {
	echo 'При загрузке возникли ошибки. Попробуйте ещё раз.';
  }

?>
