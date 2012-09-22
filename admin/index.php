<?php
error_reporting(E_ALL);

require_once("../blocks/db.php");
require_once("../blocks/variables.php");
require_once("../blocks/functions.php");
if (isset($_POST['password'])) {$password = $_POST['password'];}
if (isset($_POST['login'])) {$login = $_POST['login'];}
if (isset($password) && isset($login))
	{
		$result = mysql_query("SELECT * FROM admin",$db);
		$myrow = mysql_fetch_array($result);
		if (!isset($_COOKIE['auth']))
			{
				if ($myrow['login'] == $login && $myrow['password'] == $password)
					{
						setcookie("auth","yes");
						setcookie("auth","yes");
					}
				else
					{
						$invalid = true;
					}
			}
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<title>Панель Администратора</title>
<link rel="stylesheet" href="styles.css" type="text/css" />

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<style type="text/css">
	.mt20 {
		margin-top: 20px !important;
	}

	ul, p, ol, table {
		margin-top: 20px;
	}

	ol, ul {
		margin-left: 20px;
	}

	table {
		border-collapse: collapse;
	}
	th {
		color: #666;
		font-weight: normal;
	}
	th, td {
		padding: 7px;
	}
	td {
		border-top: 1px solid #ccc;
	}
	tr:first-child td {
		border: none;
	}
	tr:nth-child(odd) td {
		background: #def;
	}
</style>

</head>

<body>
 
 <?
 
 	if (isset($_COOKIE['auth']))
		{
			require_once("blocks/content.php");	
		} 
	else
		{
			if ($invalid)
				{
					echo "<h3>Неправильный логин или пароль!</h3>";
				}
				
			echo "
				<form method='POST' id='auth'>
					<fieldset>
						<legend>Авторизация</legend>
						<label>Логин:</label><br>
						<input type='login' name='login'/><br>
						<label>Пароль:</label><br>
						<input type='password' name='password' /><br>
						<input type='submit' value='войти'>
					</fieldset>
				</form>
				";
		}
 ?>
 
</body>
</html>
