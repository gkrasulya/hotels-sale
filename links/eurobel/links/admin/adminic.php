<?php
putenv("TZ=Europe/Moscow");
// ���� ������ � ������ ���, ���������� � ...
if(!isset($_SESSION['owner_status']) || $_SESSION['owner_status'] != "this_admin") { header("Location: http://samkov.msk.ru"); }
?>