
<?php
ob_start();
include_once('./header.php');
$arr = array();
if(isset($_GET['del'])) {  
  $cookie =  json_decode($_COOKIE['cart']);
  for ($i=0; $i < count($cookie); $i++) { 
    if($i != (int)$_GET['del']) {
      $arr[count($arr)] = json_decode($_COOKIE['cart'])[$i];
    }
  }
  setcookie('cart',json_encode($arr),time() + 60*60*24*7,'/');
  header_page();
}
?>
    <!--================Home Banner Area =================-->
    <section class="banner_area">
      <div class="banner_inner d-flex align-items-center">
        <div class="container">
          <div
            class="banner_content d-md-flex justify-content-between align-items-center"
          >
            <div class="mb-3 mb-md-0">
              <h2>Cart</h2>
              <p>Very us move be blessed multiply night</p>
            </div>
            <div class="page_link">
              <a href="index.html">Home</a>
              <a href="cart.html">Cart</a>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--================End Home Banner Area =================-->

    <!--================Cart Area =================-->
    <section class="cart_area">
      <div class="container-fluid">
        <div class="cart_inner">
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">Product</th>
                  <th scope="col">Price</th>
                  <th scope="col">Delete</th>
                </tr>
              </thead>
              <tbody>
                        
                        <?php
                        $product_ck = json_decode($_COOKIE['cart']);
                        for($i = 0 ;$i < count($product_ck); $i++) {
                          $data = getCustomData('SELECT * FROM products WHERE prod_id  = "'. $product_ck[$i] .'"');
                            echo '<tr>
                            <td>
                              <div class="media">
                                <div class="d-flex">
                                  <img width="100px"
                                    src="img/product/__0'. $data[0][0]. '.' . json_decode(base64_decode($data[0][3]))[0] . '"
                                    alt=""
                                  />
                                </div>
                                <div class="media-body">
                                  <p>'. $data[0][1] .'</p>
                                </div>
                              </div>
                            </td>
                            <td>
                              <h5>$<span class="price">'. $data[0][4] .'</span></h5>
                            </td>
                            <td><button class="btn btn-danger" onclick="del('. $i .')">Delete</button></td>
                          </tr>';
                          
                        }
                        ?>
                <tr class="bottom_button">
                  <td>
                    <a class="gray_btn" href="#">Update Cart</a>
                  </td>
                  <td></td>
                  <td></td>
                  <td>
                    <div class="cupon_text">
                      <input type="text" placeholder="Coupon Code" />
                      <a class="main_btn" href="#">Apply</a>
                      <!-- <a class="gray_btn" href="#">Close Coupon</a> -->
                    </div>
                  </td>
                </tr>
                <tr>
                  <td></td>
                  <td></td>
                  <td>
                    <h5>Subtotal</h5>
                  </td>
                  <td>
                    <h5>$<span id="total">0</span></h5>
                  </td>
                </tr>
                <tr class="shipping_area">
                  <td></td>
                  <td></td>
                  <td>
                    <h5>Shipping</h5>
                  </td>
                  <td>
                    <div class="shipping_box">
                      <ul class="list">
                        <li>
                          <a href="#">Flat Rate: $5.00</a>
                        </li>
                        <li>
                          <a href="#">Free Shipping</a>
                        </li>
                        <li>
                          <a href="#">Flat Rate: $10.00</a>
                        </li>
                        <li class="active">
                          <a href="#">Local Delivery: $2.00</a>
                        </li>
                      </ul>
                      <h6>
                        Calculate Shipping
                        <i class="fa fa-caret-down" aria-hidden="true"></i>
                      </h6>
                      <select class="shipping_select">
                        <option value="1">Bangladesh</option>
                        <option value="2">India</option>
                        <option value="4">Pakistan</option>
                      </select>
                      <select class="shipping_select">
                        <option value="1">Select a State</option>
                        <option value="2">Select a State</option>
                        <option value="4">Select a State</option>
                      </select>
                      <input type="text" placeholder="Postcode/Zipcode" />
                      <a class="gray_btn" href="#">Update Details</a>
                    </div>
                  </td>
                </tr>
                <tr class="out_button_area">
                  <td></td>
                  <td></td>
                  <td></td>
                  <td>
                    <div class="checkout_btn_inner">
                      <a class="gray_btn" href="#">Continue Shopping</a>
                      <a class="main_btn" href="#">Proceed to checkout</a>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </section>
  <script>
    var price = document.getElementsByClassName('price')
    var total_price = 0
    for (let i = 0; i < price.length; i++) {
      total_price+= parseInt(price[i].innerHTML)
      
    }
    document.getElementById('total').innerHTML  = total_price
  function del(index) {
    location.href = '<?= $_SERVER['PHP_SELF'] ?>?del='+index
  }
  </script>
<?php
include_once('./footer.php');
?>