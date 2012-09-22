<?php
error_reporting(0);
session_start();
unset($_SESSION['owner_status']);
session_destroy();
header("Location: ../index.php");
?>