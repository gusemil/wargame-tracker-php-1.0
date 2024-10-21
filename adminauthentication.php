<?php
include('authentication.php');

if(!$_SESSION['auth_user']['is_admin'] == 1)
{
    $_SESSION['status'] = "Please Login as Admin to Access This Page";
    header('Location: dashboard.php');
    exit(0);
}
?>