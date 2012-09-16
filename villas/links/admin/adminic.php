<?php
putenv("TZ=Europe/Moscow");
// Если админа в сессии нет, выкидываем к ...
if(!isset($_SESSION['owner_status']) || $_SESSION['owner_status'] != "this_admin") { header("Location: http://samkov.msk.ru"); }
?>