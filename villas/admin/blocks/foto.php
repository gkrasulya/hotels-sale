<?php
global $type;
global $number;
global $name;
$title = strtolower($name);
$title_ = strtr($title,"�������������������������������� .","abvgdezziiklmnoprstufhc4ssyyyeua__");
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

$allowed_filetypes = array('.jpg','.gif','.png','.JPG','.GIF','.PNG'); // ����� �� ����������� ���������� ���� ������
$max_filesize = 52428800; // ������������ ������ ������������ ����� � ������ (� ������ ������ �� ����� 50 ��).
$upload_path = '../fotos/'; // �����, ���� ����� ����������� ����� (� ������ ������ ��� ����� 'fotos').
$filename = $_FILES['foto']['name']; // � ���������� $filename ������� ������ ��� ����� (������� ����������).
$filename = strtolower($filename);
$filename = strtr($filename,"�������������������������������� &quot;","abvgdezziiklmnoprstufhc4ssyyyeua__");
$ext = substr($filename, strpos($filename,'.'), strlen($filename)-1); // � ���������� $ext ������� ���������� ������������ �����.
// ������� ���������� ���������� �� ������� ��������� ����������, ������� �� ���������� � ����� ������. ���� ���������� ������������ ����� �� ������ � ������ �����������, �� ��������� ���������� ��������� � ������ ��������������� ���������.
if(!in_array($ext,$allowed_filetypes))
die('������ ��� ����� �� ��������������.');
// ������ �������� ������ ������������ ����� � ���� �� ������ ����������� �����������, �� ��������� ���������� ��������� � ������ ���������.
if(filesize($_FILES['foto']['tmp_name']) > $max_filesize)
die('���� ������� �������.');
// ���������, �������� �� �� ������ �����, ������������ ���� ��� �������� ������ (����� files). ���� ����� ����������, �� ������ ���������, ��� �� ����� ����� ��������� ����� ������� 777.
if(!is_writable($upload_path))
die('���������� ��������� ���� � �����. ���������� ����� ������� - 777.');
// ��������� ���� � ��������� �����.


  
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
	echo '��� �������� �������� ������. ���������� ��� ���.';
  }

?>