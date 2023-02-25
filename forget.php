
<!DOCTYPE html>


<head>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <link rel="icon" href="img/favicon.png" type="image/png" />
  <title>TK Shop</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="css/bootstrap.css" />
  <link rel="stylesheet" href="vendors/linericon/style.css" />
  <link rel="stylesheet" href="css/font-awesome.min.css" />
  <link rel="stylesheet" href="css/themify-icons.css" />
  <link rel="stylesheet" href="css/flaticon.css" />
  <link rel="stylesheet" href="vendors/owl-carousel/owl.carousel.min.css" />
  <link rel="stylesheet" href="vendors/lightbox/simpleLightbox.css" />
  <link rel="stylesheet" href="vendors/nice-select/css/nice-select.css" />
  <link rel="stylesheet" href="vendors/animate-css/animate.css" />
  <link rel="stylesheet" href="vendors/jquery-ui/jquery-ui.css" />
  <!-- main css -->
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/responsive.css" />
  <style>
    .otp_input  {
        display: flex;
        gap: 1em;
        justify-content: center;
    }
    .otp_input input {
        outline: none;
        border: none;
        border-radius: 7px;
        text-align: center;
        font-size: 1.5em;
        font-weight: bold;

        padding: 10px;
        width: 70px;
    }
  </style>
</head>



<?php

require_once('./PHPMailer/src/PHPMailer.php');
require_once('./PHPMailer/src/SMTP.php');
require_once('./PHPMailer/src/Exception.php');
use PHPMailer\PHPMailer\PHPMailer;
include_once('./execute/global.php');
include_once('./execute/pdo.php');
session_start();
// $_SESSION['otp_times'] = 3;
// $_SESSION = array();
// var_dump($_SESSION);
// var_dump($_GET);

// die();
if($_GET['task'] == 'code') {
  if(isset($_GET['email_pwd'])) {

    $res= (getCustomData('SELECT * FROM customers WHERE ctm_email = "'. $_GET['email_pwd']  .'"'));
    if($_GET['email_pwd'] != '') {
      $_SESSION['email_pwd_ss'] = $_GET['email_pwd'];
    }
  }
  elseif(isset($_SESSION['email_pwd_ss'])) {
    $res= (getCustomData('SELECT * FROM customers WHERE ctm_email = "'. $_SESSION['email_pwd_ss']  .'"'));
  }
  if(count($res) == 0 && !isset($_SESSION['otp'])) {
    $_SESSION['times_try'] = isset($_SESSION['times_try']) ? $_SESSION['times_try']-1 : '3' ;
    header('location: ./forget.php?task=email');
    die();  
  }
  
}
elseif($_GET['task'] == 'new_pwd') {
  if(isset($_GET['new_password']) && isset($_GET['repeat_password'])) {
    if($_GET['new_password'] == $_GET['repeat_password']) {
      editData('customers','ctm_password',$_GET['new_password'],'ctm_email',$_SESSION['email_pwd_ss']);
      alert_bt('success','Change password completely.',1,'Login now','./login.php');

      die();
    }

  }
  $code =  $_GET['code1'].$_GET['code2'].$_GET['code3'].$_GET['code4'].$_GET['code5'].$_GET['code6'];
  if($code == $_SESSION['otp']) {
  }
  else {
    header('location: ./forget.php?task=code&email_pwd='.$_GET['email_pwd']);
    $_SESSION['otp_times']--;
  }
}

?>



<body class="d-flex justify-content-center align-items-center flex-column" style="height: 100vh;">
  <h1>Forgot password</h1>
  <?php
  if(isset($_SESSION['times_try'])) {
    if($_SESSION['times_try'] == '0') {
      die('<p>Your 3 times is you are used.Please try again</p>');
    }
  }
  if(isset($_GET['task'])){
    if(isset($_SESSION['times_try'])|| isset($_SESSION['otp_times'])) {
      if($_GET['task'] == 'email') {
        echo('You have '. $_SESSION['times_try'] . ' times to try');  
      }
      elseif($_GET['task'] == 'code' && isset($_SESSION['otp_times'])) {
        echo('You have '. $_SESSION['otp_times'] . ' times to enter code');  
      }
    }
    if($_GET['task'] == 'email') {
      echo ' <form class="container d-flex flex-column align-items-center justify-content-center">
      <div class="mt-10 w-50">
      <input type="text" name="email_pwd" placeholder="Enter your email" onfocus="this.placeholder = \'Email\'" onblur="this.placeholder = \'Enter your email\'"
      required class="single-input">
      <input type="hidden" name="task" value="code">
    </div>
    <div class="mt-10 w-50">
      <button class="btn text-white btn-block " style="background-color: #71cd14">Continue</button>
    </div>
    <div class="mt-10 w-50">
 
</div>     
    
  </form>
      ';
    }
    elseif($_GET['task'] == 'code') {

      if(!isset($_SESSION['otp_times'])) {

      
      $mail = new PHPMailer(true);
      try {
          //Server settings
          $mail->isSMTP();                                            //Send using SMTP
          $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
          $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
          $mail->Username   = 'tunkitjava@gmail.com';                     //SMTP username
          $mail->Password   = 'isqhyakwwlecstss';                               //SMTP password
          $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
          $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
      
          //Recipients
          $mail->setFrom('tkstore@admin.com', 'TK STORE SECURITY');
          $mail->addAddress('deptraicogisai191@gmail.com', 'Tunkit');     //Add a recipient
          // $mail->addAddress('ellen@example.com');               //Name is optional
          // $mail->addReplyTo('info@example.com', 'Information');
          // $mail->addCC('cc@example.com');
          // $mail->addBCC('bcc@example.com');
      
          //Attachments
          // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
          // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
      $_SESSION['otp'] = rand(100000,999999);
          //Content
          $mail->isHTML(true);                                  //Set email format to HTML
          $mail->Subject = 'Password Recovery';
          $mail->Body    = '<div>
          <h2 style="color: lightslategray;">Yêu cầu mật khẩu mới</h2>
          <p>Bạn đã gửi yêu cầu đổi mật khẩu. Vì vậy, chúng tôi đã gửi cho bạn một mã xác minh để xác nhận bạn là chủ tài khoản. Vui lòng không cung cấp mã này cho ai </p>
          <div style="font-weight: bold;text-align:center; font-size : 2.5em;letter-spacing: 10px">'.$_SESSION['otp'] .'</div>
      </div>';
          // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
      
          $mail->send();
          $_SESSION['otp_times'] = 3;
          echo 'Message has been sent . Please check in your mail and get the code';
      } catch (Exception $e) {
          echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
      }

    }
if(isset($_SESSION['otp_times'])) {
  if($_SESSION['otp_times'] <= 0) {
    die('<p>Your 3 times is you are used.Please try again</p>');

  }
}
       {
        echo '<form>
        <div class="otp_input">
        <input type="text" name="code1" class="single-input" onblur="checkPaste(this)">
        <input type="text" name="code2" class="single-input" maxlength="1">
        <input type="text" name="code3" class="single-input" maxlength="1">
        <input type="text" name="code4" class="single-input" maxlength="1">
        <input type="text" name="code5" class="single-input" maxlength="1">
        <input type="text" name="code6" class="single-input" maxlength="1">
        </div>
        <div class="mt-4 w-100">
        <input type="hidden" name="task" value="new_pwd">
        <button class="btn text-white btn-block " style="background-color: #71cd14">Continue</button>
        </div>
        </form>';
      }
      
    }   
    
    elseif($_GET['task'] == 'new_pwd') {
      echo '<form class="container d-flex justify-content-between flex-column align-items-center">
      <div class="mt-10 w-50">
          <input type="text" name="new_password" placeholder="Enter new password" onfocus="this.placeholder = \'Password\'" onblur="this.placeholder = \'Enter your new password\'"
          required class="single-input">
      </div>
      <div class="mt-10 w-50">
          <input type="hidden" name="task" value="new_pwd"/>
          <input type="hidden" name="username" value="'. (isset($_GET['username'])? $_GET['username'] : $_SESSION['email_pwd_ss']) .'"/>
          <input type="text" name="repeat_password" placeholder="Repeat the password" onfocus="this.placeholder = \'Repeat Password\'" onblur="this.placeholder = \'Repeat the password\'" class="single-input" />
      </div>
      <div class="mt-10 w-50">
          <button class="btn text-white btn-block " style="background-color: #71cd14">Change password</button>
      </div>
        
        <div class="mt-10 w-50">
    </div>       
    </form>';
    }
  
  }
  else {
    die('Something went wrong ! Please try again later');
  }

  ?> 
  
  <br><br>

  <script>
      var inp = document.querySelectorAll('.otp_input>input')
    function checkPaste(obj) {
        if(obj.value.length > 1 &&  Number.isInteger(parseInt(obj.value)) && obj.value.length < 7) {
            let otp = obj.value
            for (let i = 0; i < 7; i++) {
                inp[i].value = otp[i]
            }
        }
        else if(!Number.isInteger(parseInt(obj.value))) {
            obj.value = '' 
            obj.focus()
        }
    }
     
    for (let i = 0; i < inp.length; i++) {
        inp[i].oninput = function() {
            if(i != 5) {    
                inp[i+1].focus()

            }
            
        }
        
    }
    
  </script>
  
  
</body>