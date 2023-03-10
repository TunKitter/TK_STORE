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


  <!--================Header Menu Area =================-->
  <header class="header_area">
    <div class="main_menu">
      <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light w-100">
          <!-- Brand and toggle get grouped for better mobile display -->
          <a class="navbar-brand logo_h" href="index.php">
            <img src="img/logo.png" />
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse offset w-100" id="navbarSupportedContent">
            <div class="row w-100 mr-0">
              <div class="col-lg-7 pr-0 w-100">
                <ul class="nav navbar-nav  justify-content-around ">
                  <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                  </li>
                  
                  <li class="nav-item submenu dropdown">
                    <a href="category.php" class="nav-link dropdown-toggle"  role="button" aria-haspopup="true"
                      aria-expanded="false">Shop</a>
                    
                  </li>
                  <li class="nav-item submenu dropdown">
                    <a href="./tracking.php" class="nav-link " role="button" aria-haspopup="true"
                      aria-expanded="false">Delivery</a>
                    
                  </li>
                  
                </ul>
              </div>

              <div class="col-lg-5 pr-0">
                <ul class="nav navbar-nav navbar-right right_nav pull-right">
                  <li class="nav-item">
                    <a href="#" class="icons">
                      <i class="ti-search" aria-hidden="true"></i>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="./customer_cart.php" class="icons">
                      <i class="ti-shopping-cart"></i>
                      <sup><?= count(json_decode($_COOKIE['cart'])) ?></sup>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="./login.php" class="icons">
                      <i class="ti-user" aria-hidden="true"></i>
                    </a>
                  </li>
<?php
if(isset($_COOKIE['token_id'])) {

  echo'
  <li class="nav-item">
  <a class="icons">
  <i class="ti-arrow-right" aria-hidden="true" onclick="logout()"></i>
  </a>
  </li>';
}
?>

</ul>
              </div>
            </div>
          </div>
        </nav>
      </div>
    </div>
  </header>
<script>
  function logout() {
    if(confirm('Do you really want to logout?')) {
      location.href = 'login.php?logout=1'
    }
  }
</script>
<?php
include_once('./execute/pdo.php');
include_once('./execute/global.php');

if(isset($_COOKIE['token_id'])) {
  if(!getCustomData('SELECT * FROM token_customer WHERE token_content = "'. $_COOKIE['token_id'] .'"')){
    alert_bt('danger','Something went wrong ! Please try again');
    die();
  }
  else {
    $token_time = getCustomData('SELECT token_time FROM token_customer WHERE token_content = "'. $_COOKIE['token_id'] .'"');
    if((int)date('Ymd') - str_replace('-','',$token_time[0][0]) ){
    deleteData('token_customer','token_time',$token_time[0][0])   ;
    }
  }
}
?>
