<?php
require_once("../blocks/db.php");
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
						echo "NO!";
					}
			}
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<title>Админская панель</title>
<link rel="stylesheet" href="styles.css" type="text/css" />
<script type="text/javascript" src="../scripts/jquery-1.2.6.min.js"></script>
<script type="text/javascript" src="../scripts/jquery.corner.js"></script>
<script type="text/javascript" src="../scripts/corners.js"></script>
<script language="javascript">
	<!-- hide from old browsers
	var name = navigator.appName;
	if (name == "Microsoft Internet Explorer")
	{
	var brow = true;
	var style = "stylesIE.css";
	}
	else
	{
	var brow = false;
	var style = "styles.css";
	}
	
	document.write("<link href='" + style + "' type='text/css' rel='stylesheet' />");
	// --> 
</script>
</head>

<body>
 
 <?php
 
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
