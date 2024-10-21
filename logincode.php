<?php
session_start();
include('dbconnect.php');

if(isset($_POST['login_btn']))
{
    if(!empty(trim($_POST['username'])) && !empty(trim($_POST['email'])) && !empty(trim($_POST['password'])))
    {
        $username = mysqli_real_escape_string($connection,$_POST['username']);
        $email = mysqli_real_escape_string($connection,$_POST['email']);
        $password = mysqli_real_escape_string($connection,$_POST['password']);

        $login_query = "SELECT * FROM users WHERE email='$email' AND password='$password' LIMIT 1";
        $login_query_run = $connection->execute_query($login_query);

        if(mysqli_num_rows($login_query_run) > 0)
        {
            $row = mysqli_fetch_array($login_query_run);
            if($row['is_verified'] == 0)
            {
                $_SESSION['loginerror'] = "User not verified. Check your email and verify";
                header("Location: login.php");
                exit(0);
            }
            
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['auth_user'] = [
                'username' => $row['username'],
                'email' => $row['email'],
                'is_admin' => $row['is_admin']
            ];

            $_SESSION['status'] = "You are logged in Successfully";
            unset($_SESSION['loginerror']);
            header("Location: dashboard.php");
            exit(0);
        }
        else
        {
            $_SESSION['loginerror'] = "Invalid User Name, Email or Password";
            header("Location: login.php");
            exit(0);
        }
    }
    else
    {
        $_SESSION['loginerror'] = "All fields are required";
        header("Location: login.php");
        exit(0);
    }

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
}
?>