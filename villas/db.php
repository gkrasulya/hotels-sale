<?php
$login = "arbuzz"; // ����� ��� ������� � ���� ������
$password = "gosha123"; // ������ ��� ������� � ���� ������
$host = "localhost"; // ���� ���� ������ 
$table = "villas"; // ������ ��� �������
$db = mysql_connect($host,$login,$password);
mysql_select_db($table);
?>