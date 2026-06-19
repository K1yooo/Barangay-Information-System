<?php
session_start();

$_SESSION = [];

session_destroy();

header("Location: adminLogin.php"); 
exit;

?>
