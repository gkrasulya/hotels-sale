<?php
$login = "arbuzz"; // Логин для доступа к базе данных
$password = "gosha123"; // Пароль для доступа к базе данных
$host = "localhost"; // Хост базы данных 
$table = "zveroboi_euro"; // Нужная нам таблица

$db = mysql_connect($host,$login,$password);
mysql_select_db($table);

$result = mysql_query("SELECT * FROM hotels WHERE id=518 LIMIT 2");

while ($row = mysql_fetch_array($result)) {
	echo $row['text'];
}
?>