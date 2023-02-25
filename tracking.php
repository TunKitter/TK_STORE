
<?php
ob_start();
include_once('./header.php');
$username = getCustomData('SELECT ctm_username FROM customers INNER JOIN token_customer ON ctm_username = token_username')[0][0];
$data_deli = getCustomData('SELECT * FROM delivery WHERE deli_customer = "' . $username .'"');
?>
    <!--================Home Banner Area =================-->
    <section class="banner_area">
      <div class="banner_inner d-flex align-items-center">
        <div class="container">
          <div
            class="banner_content d-md-flex justify-content-between align-items-center"
          >
            <div class="mb-3 mb-md-0">
              <h2>Delivery</h2>
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
                  <th scope="col">Status</th>
                </tr>
              </thead>
              <tbody>
                        
                        <?php
                        for($i = 0 ;$i < count($data_deli); $i++) {
                          $data = getCustomData('SELECT * FROM products WHERE prod_id  = "'. $data_deli[$i][1] .'"');
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
                              <h5>$<span class="price">'. $data_deli[$i][4] .'</span></h5>
                            </td>
                            <td>'. $data_deli[$i][5] .'</td>
                          </tr>';
                          
                        }
                        ?>
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