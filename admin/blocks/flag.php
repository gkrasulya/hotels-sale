<?php

$allowed_filetypes = array('.jpg','.gif','.png','.JPG','.GIF','.PNG','.jpeg','.JPEG'); // Здесь мы перечисляем допустимые типы файлов
$max_filesize = 52428800; // Максимальный размер загружаемого файла в байтах (в данном случае он равен 50 Мб).
$upload_path = '../fotos/'; // Место, куда будут загружаться файлы (в данном случае это папка 'fotos').
$filename = $_FILES['flag']['name']; // В переменную $filename заносим точное имя файла (включая расширение).
$filename = strtolower($filename);
$filename = strtr($filename,"абвгдежзийклмнопрстуфхцчшщъыьэюя &quot;","abvgdezziiklmnoprstufhc4ssyyyeua__");
$ext = substr($filename, strpos($filename,'.'), strlen($filename)-1);
if(!in_array($ext,$allowed_filetypes))
die('Данный тип файла не поддерживается.'.$ext);
if(filesize($_FILES['flag']['tmp_name']) > $max_filesize)
die('Фаил слишком большой.');
if(!is_writable($upload_path))
die('Невозможно загрузить фаил в папку. Установите права доступа - 777.');


  
if(move_uploaded_file($_FILES['flag']['tmp_name'],'../new_images/flags/'.$filename))
  {
  }
else
  {
	echo 'При загрузке возникли ошибки. Попробуйте ещё раз.';
  }

?>