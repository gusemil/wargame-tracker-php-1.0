<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

session_start();
include('dbconnect.php');


if(isset($_POST['registration_btn']))
{
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $password_verify = htmlspecialchars($_POST['password_verify']);
    $verify_token = md5(rand());

    //UserName exists or not
    $check_username_query = "SELECT username FROM users WHERE username='$username' LIMIT 1";
    $check_username_query_run = $connection->execute_query( $check_username_query);

  //Email exists or not
  $check_email_query = "SELECT email FROM users WHERE email='$email' LIMIT 1";
  $check_email_query_run = $connection->execute_query( $check_email_query);

  if($password != $password_verify){
    $_SESSION['registererror'] = "Password does not match password verification";
    header("Location: registration.php");
    exit(0);
  }

  if(mysqli_num_rows($check_username_query_run) > 0)
  {
      $_SESSION['registererror'] = "User id already exists";
      header("Location: registration.php");
      exit(0);
  }
  
  if(mysqli_num_rows($check_email_query_run) > 0)
  {
      $_SESSION['registererror'] = "Email id already exists";
      header("Location: registration.php");
      exit(0);
  }
  else
  {
      //id is autoincrement
      $insert_query = "INSERT INTO users (username,email,password,verify_token) VALUES ('$username','$email','$password','$verify_token')";
      $query_run = $connection->execute_query($insert_query);
      if($query_run)
      {
          $_SESSION['status'] = "Registration was a success";
          unset($_SESSION['registererror']);

          //PHPMAILER START

            //Create an instance; passing `true` enables exceptions
            $mail = new PHPMailer(true);

            try {
                //Server settings
                //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'INSERT YOUR OWN STMP PROVIDER';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'INSERT YOUR OWN EMAIL/USERNAME';                     //SMTP username
                $mail->Password   = 'INSERT YOUR OWN PASSWORD';                               //SMTP password
                $mail->SMTPSecure = 'ssl';            //Enable implicit TLS encryption
                $mail->Port = 465;                                   //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                //Recipients
                $mail->setFrom('INSERT YOUR OWN SENDER', 'WarGameTracker');
                $mail->addAddress($email, $username);     //Add a recipient
                //$mail->addAddress('ellen@example.com');               //Name is optional
                //$mail->addReplyTo('info@example.com', 'Information');
                //$mail->addCC('cc@example.com');
                //$mail->addBCC('bcc@example.com');

                //Attachments
                //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
                //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Your verification email to WarGameTracker';
                $mail->Body    = "Here is your verification token to active your account: {$verify_token}";
                //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                $mail->send();
                $_SESSION['verificationerror'] = "Message has been sent. Check your email";
                header("Location: verification.php");
                exit(0);
            } catch (Exception $e) {
                $_SESSION['registererror'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                header("Location: registration.php");
                exit(0);
            }
            //PHP Mailer END
      }
      else
      {
          $_SESSION['registererror'] = "Registration failed.";
          header("Location: register.php");
          exit(0);
      }
  }
}

?>