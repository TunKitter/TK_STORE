<?php
include_once('./execute/pdo.php');
include_once('./execute/global.php');
if(isset($_GET['logout'])) {
  deleteData('token_customer','token_content',$_COOKIE['token_id']);
  setcookie('token_id',$token,0,'/');
  header('location: login.php');
}
else if(isset($_COOKIE['token_id'])) {
  header('location: index.php');
}
if(isset($_POST['username']) && isset($_POST['password'])){
    if($_POST) {

        insertData('customers',$_POST['name'],$_POST['username'],$_POST['password'],$_POST['email'],$_POST['phone'],0);
        alert_bt('success','Created Successfully ');
        echo '<script>
        setTimeout(() => {
            location.href= "./login.php";
        }, 1000);
        </script>';
    }
    else {
        alert_bt('danger','Created Failed! Please Try again');

    }
}
?>
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
</head>
<body class="d-flex justify-content-center align-items-center flex-column" style="height: 100vh;">
  <h1>Signup Form</h1>
  <form method="post" class="container d-flex flex-column align-items-center justify-content-center">
    <div class="mt-10 w-50">
      <input type="text" name="name" placeholder="Name" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Name'"
      required class="single-input">
    </div>
    <div class="mt-10 w-50">
      <input type="text" name="username" placeholder="Username" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Username'"
      required class="single-input">
    </div>
    <div class="mt-10 w-50">
      <input type="password" name="password" placeholder="Password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Password'"
      required class="single-input">
    </div>
    <div class="mt-10 w-50">
      <input type="email" name="email" placeholder="Email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email'"
      required class="single-input">
    </div>
    <div class="mt-10 w-50">
      <input type="text" name="phone" placeholder="Phone number" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Phone number'"
      required class="single-input">
    </div>
    <div class="mt-10 w-50">
      <button class="btn text-white btn-block " style="background-color: #71cd14">Login</button>
    </div>
    <div class="mt-10 w-50">
      
      <a href="./login.php" style="color:currentColor" class="text-center d-block">Already an Account?</a>
    </div>
  </form>
</body>