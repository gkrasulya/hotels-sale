<?php

$allowed_filetypes = array('.jpg','.gif','.png','.JPG','.GIF','.PNG','.jpeg','.JPEG'); // ����� �� ����������� ���������� ���� ������
$max_filesize = 52428800; // ������������ ������ ������������ ����� � ������ (� ������ ������ �� ����� 50 ��).
$upload_path = '../fotos/'; // �����, ���� ����� ����������� ����� (� ������ ������ ��� ����� 'fotos').
$filename = $_FILES['flag']['name']; // � ���������� $filename ������� ������ ��� ����� (������� ����������).
$filename = strtolower($filename);
$filename = strtr($filename,"�������������������������������� &quot;","abvgdezziiklmnoprstufhc4ssyyyeua__");
$ext = substr($filename, strpos($filename,'.'), strlen($filename)-1);
if(!in_array($ext,$allowed_filetypes))
die('������ ��� ����� �� ��������������.'.$ext);
if(filesize($_FILES['flag']['tmp_name']) > $max_filesize)
die('���� ������� �������.');
if(!is_writable($upload_path))
die('���������� ��������� ���� � �����. ���������� ����� ������� - 777.');


  
if(move_uploaded_file($_FILES['flag']['tmp_name'],'../new_images/flags/'.$filename))
  {
  }
else
  {
	echo '��� �������� �������� ������. ���������� ��� ���.';
  }

?>