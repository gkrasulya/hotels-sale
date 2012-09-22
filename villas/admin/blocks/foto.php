<?php
global $type;
global $number;
global $name;
$title = strtolower($name);
$title_ = strtr($title,"абвгдежзийклмнопрстуфхцчшщъыьэюя .","abvgdezziiklmnoprstufhc4ssyyyeua__");
$title_ = $number."_".$title_;
	  
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

$allowed_filetypes = array('.jpg','.gif','.png','.JPG','.GIF','.PNG'); // Здесь мы перечисляем допустимые типы файлов
$max_filesize = 52428800; // Максимальный размер загружаемого файла в байтах (в данном случае он равен 50 Мб).
$upload_path = '../fotos/'; // Место, куда будут загружаться файлы (в данном случае это папка 'fotos').
$filename = $_FILES['foto']['name']; // В переменную $filename заносим точное имя файла (включая расширение).
$filename = strtolower($filename);
$filename = strtr($filename,"абвгдежзийклмнопрстуфхцчшщъыьэюя &quot;","abvgdezziiklmnoprstufhc4ssyyyeua__");
$ext = substr($filename, strpos($filename,'.'), strlen($filename)-1); // В переменную $ext заносим расширение загруженного файла.
// Сверяем полученное расширение со списком допутимых расширений, которые мы определили в самом начале. Если расширение загруженного файла не входит в список разрешенных, то прерываем выполнение программы и выдаем соответствующее сообщение.
if(!in_array($ext,$allowed_filetypes))
die('Данный тип файла не поддерживается.');
// Теперь проверим размер загруженного файла и если он больше максимально допустимого, то прерываем выполнение программы и выдаем сообщение.
if(filesize($_FILES['foto']['tmp_name']) > $max_filesize)
die('Фаил слишком большой.');
// Проверяем, доступна ли на запись папка, определенная нами под загрузку файлов (папка files). Если вдруг недоступна, то выдаем сообщение, что на папку нужно поставить права доступа 777.
if(!is_writable($upload_path))
die('Невозможно загрузить фаил в папку. Установите права доступа - 777.');
// Загружаем фаил в указанную папку.


  
if(move_uploaded_file($_FILES['foto']['tmp_name'],$upload_path.$title_.$ext))
  {
    $img_pre = "pre_".$title_.$ext;
	$img_big = $title_.$ext;
    
	$img = $upload_path.$title_.$ext;
	$img_wha = getimagesize($img);
	global $img_wha;
	if ($img_wha[0] > 200)
		  
	  {
	    global $type;
		global $img_wha;
		$y = $img_wha[1] / ($img_wha[0] / 200);
        img_resize('../fotos/pre_'.$title_.$ext,'../fotos/'.$title_.$ext,200,$y,60);
	  }
	$img_src = "../fotos/".$title_."_".$title_.$ext;
    $image_ = mysql_query("INSERT INTO fotos (img_pre,img_big) VALUES ('$img_pre','$img_big')",$db);
	$result = mysql_query("SELECT id FROM fotos ORDER BY id DESC",$db);
	$myrow = mysql_fetch_array($result);
	$foto_id = $myrow['id'];

  }
else
  {
	echo 'При загрузке возникли ошибки. Попробуйте ещё раз.';
  }

?>