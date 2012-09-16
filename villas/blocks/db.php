<?php
$login = "zveroboi_vill"; // Логин для доступа к базе данных
$password = "sale"; // Пароль для доступа к базе данных
$host = "db32.valuehost.ru"; // Хост базы данных 
$table = "zveroboi_vill"; // Нужная нам таблица
$db = mysql_connect($host,$login,$password);
mysql_select_db($table);
?>