<?php
$login = "arbuzz"; // Логин для доступа к базе данных
$password = "gosha123"; // Пароль для доступа к базе данных
$host = "localhost"; // Хост базы данных 
$table = "villas"; // Нужная нам таблица
$db = mysql_connect($host,$login,$password);
mysql_select_db($table);
?>