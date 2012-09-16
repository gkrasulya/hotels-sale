<?php
@$old_abort = ignore_user_abort(true);
session_start();
if($_POST['clear_trash'] AND $_SESSION['owner_status']=="this_admin") {

// Удаляем данные из корзины напрочь
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$fp=fopen("data/trash.dat","w");
fclose($fp);
flock($lock, LOCK_UN);
fclose($lock);
} else {
$_SESSION['error'] = "Не могу заблокировать служебный файл data/base.lck !!!";
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=error.php'>
	  </HEAD></HTML>";
exit();
}

echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=$_POST[back]'>
	  </HEAD></HTML>";
exit();
} // end if
@ignore_user_abort($old_abort);
?>