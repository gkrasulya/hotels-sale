<?php
global $hotel_id;
$title = strtolower($_FILES['foto']['name']);
$title_ = strtr($title,"�������������������������������� ","abvgdezziiklmnoprstufhc4ssyyyeua_");
	  
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
$upload_path = '../add_fotos/'.$hotel_id.'/'; // �����, ���� ����� ����������� ����� (� ������ ������ ��� ����� 'fotos').
mkdir($upload_path);
$filename = $_FILES['foto']['name']; // � ���������� $filename ������� ������ ��� ����� (������� ����������).
$filename = strtolower($filename);
$filename = strtr($filename,"�������������������������������� &quot;\"","abvgdezziiklmnoprstufhc4ssyyyeua___");
$ext = substr($filename, strpos($filename,'.'), strlen($filename)-1);
if(!in_array($ext,$allowed_filetypes))
die('������ ��� ����� �� ��������������.'.$ext);
if(filesize($_FILES['foto']['tmp_name']) > $max_filesize)
die('���� ������� �������.');
if(!is_writable($upload_path))
die('���������� ��������� ���� � �����. ���������� ����� ������� - 777.');


  
if(move_uploaded_file($_FILES['foto']['tmp_name'],$upload_path.$title_))
  {
    $img_pre = "pre_".$title_;
	$img_big = $title_;
    
	$img = $upload_path.$title_;
	$img_wha = getimagesize($img);
	global $img_wha;
	if ($img_wha[0] > 150)
		  
	  {
	    global $type;
		global $img_wha;
		$y = $img_wha[1] / ($img_wha[0] / 150);
        img_resize('../add_fotos/'.$hotel_id.'/pre_'.$title_,'../add_fotos/'.$hotel_id.'/'.$title_,150,$y,50);
	  }
	$img_src = "../add_fotos/".$hotel_id.'/'.$title_."_".$title_;
    $image_ = mysql_query("INSERT INTO add_fotos (small,big,hotel_id) VALUES ('$img_pre','$img_big','$hotel_id')",$db);
	$result = mysql_query("SELECT id FROM add_fotos ORDER BY id DESC",$db);
	$myrow = mysql_fetch_array($result);
	$foto_id = $myrow['id'];

  }
else
  {
	echo '��� �������� �������� ������. ���������� ��� ���.';
  }

?>