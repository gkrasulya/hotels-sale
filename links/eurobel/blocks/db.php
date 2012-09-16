<?php
$login = "zveroboi_euro"; // Логин для доступа к базе данных
$password = "igmate"; // Пароль для доступа к базе данных
$host = "db32.valuehost.ru"; // Хост базы данных 
$table = "zveroboi_euro"; // Нужная нам таблица
$db = mysql_connect($host,$login,$password);
mysql_select_db($table);
?>