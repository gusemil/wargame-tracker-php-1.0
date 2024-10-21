<?php
session_start();

if(!isset($_SESSION['loggedin']))
{
    $_SESSION['status'] = "Please Login to Access User Dashboard";
    header('Location: login.php');
    exit(0);
}
?>