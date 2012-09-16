<?php
@$old_abort = ignore_user_abort(true);
session_start();
if($_GET['action']=="remove_certainly" AND $_GET['id'] AND $_SESSION['owner_status']=="this_admin") {

// Формируем строку URL куда вернуться
$backward="http://"."$_SERVER[HTTP_HOST]"."$_GET[back]"."?"."page="."$_GET[page]"."#"."$_GET[id]";

// Удаляем данные из корзины напрочь
$lock = fopen("data/base.lck","a");
if(flock($lock, LOCK_EX)) {
$base=file("data/trash.dat");
$fp=fopen("data/tmp.dat","w");
for ($i=0;$i<count($base);$i++) {
$record = explode("|", $base[$i]);
if ($record[0] == $_GET['id']) unset($base[$i]);
}
fputs($fp,implode("",$base));
fclose($fp);
unlink("data/trash.dat");
rename("data/tmp.dat", "data/trash.dat");
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
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=$backward'>
	  </HEAD></HTML>";
exit();
} // end if
@ignore_user_abort($old_abort);
?>