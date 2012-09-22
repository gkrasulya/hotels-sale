<?php
header("Content-type: text/html; charset: utf-8");

$production = $_SERVER['HTTP_HOST'] != 'localhost';

if (! $production) {
	$login = "root"; // Логин для доступа к базе данных
	$password = ""; // Пароль для доступа к базе данных
	$host = "localhost"; // Хост базы данных 
	$table = "hotels"; // Нужная нам таблица

	define('SITE_ADDR', 'http://localhost/hotels_sale/');
} else {
	$login = "hotels-sale"; // Логин для доступа к базе данных
	$password = "hotels"; // Пароль для доступа к базе данных
	$host = "localhost"; // Хост базы данных 
	$table = "hotels_sale"; // Нужная нам таблица

	define('SITE_ADDR', 'http://hotels-sale.ru/');
}



$db = mysql_connect($host,$login,$password);
mysql_select_db($table);
mysql_query("set character_set_client='cp1251'");
mysql_query("set character_set_results='cp1251'");
mysql_query("set collation_connection='cp1251_general_ci'");
?>