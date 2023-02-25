<?php
ob_start();
include_once('header.php');
require './country/vendor/autoload.php';
use NguyenAry\VietnamAddressAPI\Address;
$province  = ((Address::getProvinces()));
$price = ((int) $_GET['sale_price'] )*(int)($_GET['qty']);
if(isset($_GET['province'])) {
  $addr =  $_GET['province'].'_'.$_GET['district']. '_'.$_GET['wards'];
  // var_dump($_GET);
  insertData('delivery',(time()+rand(1,10000)),$_GET['id_product'],$_GET['username'],$addr,$_GET['price'],'pending');
  header('location: ./tracking.php');
  die();

}
// var_dump(Address::getProvinces());
// var_dump(Address::getDistrictsByProvinceId('80'));
if(isset($_COOKIE['cart'])) {

  $user = getCustomData('SELECT * FROM customers INNER JOIN token_customer ON ctm_username = token_username')[0];
  // var_dump($user);
}
?>
<div style="max-height: 0px;">

 
      </div>
    <section class="banner_area">
      <div class="banner_inner d-flex align-items-center">
        <div class="container">
          <div
          class="banner_content d-md-flex justify-content-between align-items-center"
          >
          <div class="mb-3 mb-md-0">
              <h2>Product Checkout</h2>
              <p>Very us move be blessed multiply night</p>
            </div>
            <div class="page_link">
              <a href="index.html">Home</a>
              <a href="checkout.html">Product Checkout</a>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--================End Home Banner Area =================-->

    <!--================Checkout Area =================-->
    <section class="checkout_area section_gap">
      <div class="container">
        
        
        <div class="billing_details">
          <div class="row">
            <div class="col-lg-8">
              <h3>Address</h3>
              <form id="sub_form"
                class="row contact_form"
                novalidate="novalidate"
              >
                
               
                
               
                <div class="col-md-12 form-group p_star">
                  <select class="country_select" name="province" onchange="getDistrict(this.value)" >
                    <?php
                  $index = 0;
                  foreach ($province as $key => $value) {
                    $index++;
                    echo '<option value="'. $value['code'] .'"> '. $value['name']  .'</option>';
                  }
                  ?>
                  </select>
                </div>
                <div class="col-md-12 form-group p_star" id="district">
                  <select class="country_select">
                    <option value="1">District</option>
                    <option value="2">District</option>
                    <option value="4">District</option>
                  </select>
                </div>
                <div class="col-md-12 form-group p_star" id="wards">
                  <select class="country_select">
                    <option value="1">District</option>
                    <option value="2">District</option>
                    <option value="4">District</option>
                  </select>
                </div>
                <div class="col-md-12 form-group p_star">
                  <input type="hidden" name="id_product" value="<?= $_GET['id_product'] ?>" />
                  <input type="hidden" name="username" value="<?= $user[1] ?>" />
                  <input type="hidden" name="price" id="price" />
                </div>
               
               
                <div class="cupon_area">
        </div>  
              </form>
              
            </div>
            <div class="col-lg-4">
              <div class="order_box">
                <h2>Your Order</h2>
                <ul class="list">
                  <li>
                    <a href="#"
                      >Product
                      <span>Total</span>
                    </a>
                  </li>
                  <li>
                    <a href="#"
                      ><?= ($data = getCustomData('SELECT prod_name,prod_price FROM products WHERE prod_id = "' . $_GET['id_product'] .'"')[0])[0]  ?>
                      <span class="middle">x <?= $_GET['qty'] ?></span>
                      <span class="last">$<?=( $price  )?></span>
                    </a>
                
                </ul>
                <ul class="list list_2">
                  <li>
                    <a href="#"
                      >Sale code
                      <span><?= str_replace('k','',substr( $_GET['sale_price'],strpos($_GET['sale_price'],'-')+1)) ?></span>
                    </a>
                  </li>
                  <li>
                    <a href="#"
                      >Total
                      <span id="total">$0</span>
                    </a>
                  </li>
                </ul>
                <div class="payment_item">
                  <div class="radion_btn">
                    <input type="radio" id="f-option5" onclick="deli();buy()" name="selector" />
                    <label for="f-option5">Pay when delivery</label>
                    <div class="check"></div>
                  </div>
                  <p>
                    Please send a check to Store Name, Store Street, Store Town,
                    Store State / County, Store Postcode.
                  </p>
                </div>
                <div class="payment_item active">
                  <div class="radion_btn">
                    <input type="radio" id="f-option6" name="selector" onclick="vnpay();buy()" />
                    <label for="f-option6">VNPAY</label>
                    <img width="30px" src="https://play-lh.googleusercontent.com/DvCn_h3AdLNNDcv3ftqTqP83gw6h65GMEPg3x6u788wB3F3ENNFcHgrHcWJNOPy4epg" alt="" />
                    <div class="check"></div>
                  </div>
                  <p></p>
                </div>
                <button class="main_btn" form="sub_form" >Proceed to Paypal</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--================End Checkout Area =================-->

    <!--================ start footer Area  =================-->
    <footer class="footer-area section_gap">
      <div class="container">
        <div class="row">
          <div class="col-lg-2 col-md-6 single-footer-widget">
            <h4>Top Products</h4>
            <ul>
              <li><a href="#">Managed Website</a></li>
              <li><a href="#">Manage Reputation</a></li>
              <li><a href="#">Power Tools</a></li>
              <li><a href="#">Marketing Service</a></li>
            </ul>
          </div>
          <div class="col-lg-2 col-md-6 single-footer-widget">
            <h4>Quick Links</h4>
            <ul>
              <li><a href="#">Jobs</a></li>
              <li><a href="#">Brand Assets</a></li>
              <li><a href="#">Investor Relations</a></li>
              <li><a href="#">Terms of Service</a></li>
            </ul>
          </div>
          <div class="col-lg-2 col-md-6 single-footer-widget">
            <h4>Features</h4>
            <ul>
              <li><a href="#">Jobs</a></li>
              <li><a href="#">Brand Assets</a></li>
              <li><a href="#">Investor Relations</a></li>
              <li><a href="#">Terms of Service</a></li>
            </ul>
          </div>
          <div class="col-lg-2 col-md-6 single-footer-widget">
            <h4>Resources</h4>
            <ul>
              <li><a href="#">Guides</a></li>
              <li><a href="#">Research</a></li>
              <li><a href="#">Experts</a></li>
              <li><a href="#">Agencies</a></li>
            </ul>
          </div>
          <div class="col-lg-4 col-md-6 single-footer-widget">
            <h4>Newsletter</h4>
            <p>You can trust us. we only send promo offers,</p>
            <div class="form-wrap" id="mc_embed_signup">
              <form target="_blank" action="https://spondonit.us12.list-manage.com/subscribe/post?u=1462626880ade1ac87bd9c93a&amp;id=92a4423d01"
                method="get" class="form-inline">
                <input class="form-control" name="EMAIL" placeholder="Your Email Address" onfocus="this.placeholder = ''"
                  onblur="this.placeholder = 'Your Email Address '" required="" type="email">
                <button class="click-btn btn btn-default">Subscribe</button>
                <div style="position: absolute; left: -5000px;">
                  <input name="b_36c4fd991d266f23781ded980_aefe40901a" tabindex="-1" value="" type="text">
                </div>
  
                <div class="info"></div>
              </form>
            </div>
          </div>
        </div>
        <div class="footer-bottom row align-items-center">
          <p class="footer-text m-0 col-lg-8 col-md-12"><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
          <div class="col-lg-4 col-md-12 footer-social">
            <a href="#"><i class="fa fa-facebook"></i></a>
            <a href="#"><i class="fa fa-twitter"></i></a>
            <a href="#"><i class="fa fa-dribbble"></i></a>
            <a href="#"><i class="fa fa-behance"></i></a>
          </div>
        </div>
      </div>
    </footer>
    <!--================ End footer Area  =================-->
<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/stellar.js"></script>
    <script src="vendors/lightbox/simpleLightbox.min.js"></script>
    <script src="vendors/nice-select/js/jquery.nice-select.min.js"></script>
    <script src="vendors/isotope/imagesloaded.pkgd.min.js"></script>
    <script src="vendors/isotope/isotope-min.js"></script>
    <script src="vendors/owl-carousel/owl.carousel.min.js"></script>
    <script src="js/jquery.ajaxchimp.min.js"></script>
    <script src="js/mail-script.js"></script>
    <script src="vendors/jquery-ui/jquery-ui.js"></script>
    <script src="vendors/counter-up/jquery.waypoints.min.js"></script>
    <script src="vendors/counter-up/jquery.counterup.js"></script>
    <script src="js/theme.js"></script>
  </body>
</html>
<script>
  var method_pay = ''
  function deli() {
    method_pay = 'deli'
  }
  function vnpay() {
      document.getElementById('sub_form').setAttribute('action','./vnpay_php/index.php')

  }
  document.getElementById('total').innerHTML = '<?= $price ?>$'
  var district = document.getElementsByClassName('district_data')
  let index_show = 0;
  for (let i = 0; i < district.length; i++) {
      district[i].style.display  = 'none'
  }
  function getDistrict(value_district) {
    let rq = new XMLHttpRequest()
     rq.onreadystatechange = function() {
         if(this.readyState == 4 && this.status ==200) {
              document.getElementById('district').innerHTML = this.responseText
            }
        }
        rq.open('GET','district.php?d='+ value_district )
        rq.send()
  
  }
  function wards(value) {
    let rq = new XMLHttpRequest()
     rq.onreadystatechange = function() {
         if(this.readyState == 4 && this.status ==200) {
              document.getElementById('wards').innerHTML = this.responseText
            }
        }
        rq.open('GET','district.php?w='+ value )
        rq.send()
  }

function buy() {
    document.getElementById('price').value =  (parseInt(document.getElementById('total').innerHTML))
    // alert(document.getElementById('price').value)
  
}
</script>