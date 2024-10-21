<?php
session_start();

unset($_SESSION['loggedin']);
unset($_SESSION['auth_user']);
$_SESSION['status'] = "You Logged Out Successfully";
header("Location: login.php");

session_destroy();

?>