<?php
$login = "zveroboi_euro"; // ����� ��� ������� � ���� ������
$password = "igmate"; // ������ ��� ������� � ���� ������
$host = "db32.valuehost.ru"; // ���� ���� ������ 
$table = "zveroboi_euro"; // ������ ��� �������
$db = mysql_connect($host,$login,$password);
mysql_select_db($table);
?>