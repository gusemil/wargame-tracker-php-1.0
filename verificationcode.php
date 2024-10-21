<?php
session_start();
include('dbconnect.php');


if(isset($_POST['verification_btn']))
{
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $password_verify = htmlspecialchars($_POST['password_verify']);
    $verification = htmlspecialchars($_POST['verifytoken']);

    //UserName exists or not
    $check_username_query = "SELECT username FROM users WHERE username='$username' LIMIT 1";
    $check_username_query_run = $connection->execute_query( $check_username_query);

    //Email exists or not
    $check_email_query = "SELECT email FROM users WHERE email='$email' LIMIT 1";
    $check_email_query_run = $connection->execute_query( $check_email_query);

     //Check verify token
    $check_verify_query = "SELECT verify_token, is_verified FROM users WHERE username='$username' LIMIT 1";
    $check_verify_query_run = $connection->execute_query($check_verify_query);

    $verify_data_row = mysqli_fetch_assoc($check_verify_query_run);

    $verify_token_retrieved = $verify_data_row["verify_token"];
    $is_verified = $verify_data_row["is_verified"];

    if($is_verified > 0)
    {
        //User is already verified
        header("Location: login.php");
        exit(0);
    }
  

    if($verification == $verify_token_retrieved)
    {
        //Verification success
        $_SESSION['loginerror'] = "Email verification successful!";
        $update_is_verified_status = "UPDATE users SET is_verified=1 WHERE username='$username' LIMIT 1";
        $connection->execute_query($update_is_verified_status);
        unset($_SESSION['verificationerror'] );

        header("Location: login.php");
        exit(0);
    }
    else
    {
        //Invalid verification token
        $_SESSION['verificationerror'] = "Invalid verification token";
        header("Location: verification.php");
        exit(0);
    }

  if($password != $password_verify){
    $_SESSION['verificationerror'] = "Password does not match password verification";
    header("Location: verification.php");
    exit(0);
  }

  if(mysqli_num_rows($check_username_query_run) <= 0)
  {
      $_SESSION['verificationerror'] = "User id doesn't exist";
      header("Location: verification.php");
      exit(0);
  }
  
  if(mysqli_num_rows($check_email_query_run) <= 0)
  {
      $_SESSION['verificationerror'] = "Email id doesn't exist";
      header("Location: verification.php");
      exit(0);
  }
}

?>