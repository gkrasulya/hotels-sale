<?php
$login = "zveroboi_vill"; // ����� ��� ������� � ���� ������
$password = "sale"; // ������ ��� ������� � ���� ������
$host = "db32.valuehost.ru"; // ���� ���� ������ 
$table = "zveroboi_vill"; // ������ ��� �������
$db = mysql_connect($host,$login,$password);
mysql_select_db($table);
?>