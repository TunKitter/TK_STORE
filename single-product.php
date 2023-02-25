<?php
ob_start();
session_start();
include_once('./header.php');

if(isset($_GET['cart'])) { 
  if(isset($_COOKIE['cart']))
  {
    $arr = (array) json_decode($_COOKIE['cart']);
  $arr[count($arr)] = $_GET['id_product'];
  setcookie('cart',json_encode($arr),time() + 60*60*24*7,'/');
}
else {
  setcookie('cart',json_encode(array($_GET['id_product'])),time() + 60*60*24*7,'/');
}
if(isset($_GET['cate'])) {
  header('location: ./category.php');
  die();
}

alert_bt('success','Added to your cart');
   echo '<script>
   setTimeout(() => {
     location.href = "./single-product.php?id_product='. $_GET['id_product'] .'"
   }, 1000);
   </script>';
}
$is_vip =0;
if(isset($_COOKIE['token_id'])) {
  $username = (getCustomData('SELECT ctm_username FROM customers INNER JOIN token_customer ON token_username = ctm_username'))[0][0];
  $is_vip = getCustomData('SELECT ctm_isvip FROM customers WHERE ctm_username = "'. $username .'"')[0][0];

}
if(isset($_GET['del_cmt']) && isset($_GET['id_product'])) {
    deleteData('comment','cmt_id',$_GET['del_cmt']);
    alert_bt('success','Delete Successfully');
    echo '<script>
    setTimeout(() => {
      location.href = "./single-product.php?id_product='. $_GET['id_product'] .'"
    }, 1000);
    </script>';
}
if(isset($_POST['content'])&& !empty($_POST['content']) && isset($_POST['star'])) {
  insertData('comment',substr(md5(($_POST['content'])),0,rand(0,strlen($_POST['content']))),getCustomData('SELECT token_username FROM token_customer WHERE token_content = "'. $_COOKIE['token_id'] .'" ')[0][0],$_GET['id_product'],$_POST['content'],$_POST['star']);
  header('location: ./single-product.php?id_product='. $_GET['id_product']);
}
$data = '';
// $_SESSION = array();
if(isset($_GET['id_product'])) {
$data = getCustomData('SELECT * FROM products WHERE prod_id  = "'. $_GET['id_product'] .'"')[0];
if(!isset($_SESSION[$_GET['id_product']])) {
  editData('products','prod_click',($data[5]+1),'prod_id',$_GET['id_product']);  
  $_SESSION[$_GET['id_product']] = '1';
}
}
else {
  $data = array('','','','','','','','');

}

$sale_price = (getCustomData('SELECT sale_discount,sale_vip FROM sale_off WHERE sale_apply = "'. $data[0] .'"')) ;
if(!count($sale_price)) {
  $sale_price = $data[4];
}
else {
  $is_vip = (getCustomData('SELECT ctm_isvip FROM customers INNER JOIN token_customer ON ctm_username = token_username')[0][0]);
  $sale_vip = $sale_price[0][1];
  $sale_price =  $sale_price[0][0];
  if(str_contains($sale_price,'k') ) {
    if(($sale_vip == 1 && $is_vip ==1) || ($sale_vip == 0)) {
      $sale_price = (int)($data[4]) - (int) rtrim($sale_price,'k') . '<sup>-'. $sale_price .'</sup>';
    }
    
  }
  else if(str_contains($sale_price,'%')) {
    if(($sale_vip == 1 && $is_vip ==1) || ($sale_vip == 0)) {
    $sale_price =(int) $data[4] - (int)(($data[4]/100)* rtrim($sale_price,'%')) . '<sup>-'. $sale_price .'</sup>' ;
  }
  else {

    $sale_price = $data[4];
  }
}
else {
  $sale_price = $data[4];
}
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
              <h2>Product Details</h2>
              <p>Very us move be blessed multiply night</p>
            </div>
            <div class="page_link">
              <a href="index.html">Home</a>
              <a href="single-product.html">Product Details</a>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--================End Home Banner Area =================-->

    <!--================Single Product Area =================-->
    <div class="product_image_area">
      <div class="container">
        <div class="row s_product_inner">
          <div class="col-lg-6">
            <div class="s_product_img">
              <div
                id="carouselExampleIndicators"
                class="carousel slide"
                data-ride="carousel"
              >
                <ol class="carousel-indicators">
                  <li
                    data-target="#carouselExampleIndicators"
                    data-slide-to="0"
                    class="active"
                  >
                    <img
                      src="img/product/__0<?= $data[0]  .'.'. json_decode(base64_decode($data[3]))[0] ?>" 
                      width="50px"
                    />
                  </li>
                <?php
                for ($i=1; $i < count(json_decode(base64_decode($data[3]))) ; $i++) { 
                  echo '  <li
                  data-target="#carouselExampleIndicators"
                  data-slide-to="'. $i .'"
                >
                  <img
                    src="img/product/__'. $i. $data[0]. '.'. json_decode(base64_decode($data[3]))[0] .'"
                    width="50px"
                  />
                </li>';
                }
                ?>
                </ol>
                <div class="carousel-inner">
                  <div class="carousel-item active">
                    <img
                      class="d-block w-100"
                      src="img/product/__0<?= $data[0] .'.'. json_decode(base64_decode($data[3]))[0] ?>"  
                      alt="First slide"
                    />
                  </div>
                  <?php
                  for ($i=1; $i < count(json_decode(base64_decode($data[3]))); $i++) { 
                    echo '<div class="carousel-item">
                    <img
                      class="d-block w-100"
                      src="img/product/__'.$i . $data[0].'.'. json_decode(base64_decode($data[3]))[0] .'"
                      alt="Second slide"
                    />
                  </div>';
                  }
                  ?>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-5 offset-lg-1">
            <div class="s_product_text">
              <h4 class="text-uppercase"><?= $data[1] ?></h4>
              <h2>$<?= $sale_price ?>
              <?php
              if($is_vip) {
                echo '<del class="ml-4">$'. $data[4] .'</del>
                <a class="icon_btn float-right">
                    <i class="lnr lnr lnr-diamond"></i>
                    
                  </a>
                ';
              }
              
              ?>
                </h2>
              <ul class="list">
                <li>
                  <a class="active" href="#">
                    <span>Category</span> : <?= getCustomData('SELECT cate_name FROM category_product WHERE cate_id = "'.$data[2] .'"')[0][0]  ?></a
                  >
                </li>
                <li>
                  <a href="#"> <span>Quantity</span> : <?= $data[7] ?></a>
                </li>
              </ul>
              <p>
             <?= $data[6]?>
              </p>
             <?php
              if(isset($_COOKIE['token_id'])) {
                echo '<div class="product_count">
                <label for="qty">Quantity:</label>
                <input
                  type="text"
                  name="qty"
                  id="sst"
                  maxlength="12"
                  value="1"
                  title="Quantity:"
                  class="input-text qty"
                />
                <button
                  onclick="var result = document.getElementById(\'sst\'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;"
                  class="increase items-count"
                  type="button"
                >
                  <i class="lnr lnr-chevron-up"></i>
                </button>
                <button
                  onclick="var result = document.getElementById(\'sst\'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 0 ) result.value--;return false;"
                  class="reduced items-count"
                  type="button">
                  <i class="lnr lnr-chevron-down"></i>
                </button>
              </div>';
              
              }
              else {
                echo '<p style="font-size: 1.4em">Want to buy ? <a href="./login.php?id_product='. $_GET['id_product'].'" style="text-decoration:underline; color:#71cd14">Login now</a></p>';
              }
             ?>
              <div class="card_area">
                <?php
                if(isset($_COOKIE['token_id'])) {
                  echo ' <p class="main_btn" onclick="buy()">Buy now</p>
                  
                  <a class="icon_btn" href="./single-product.php?id_product='. $_GET['id_product'] .'&cart=1">
                  <i class="ti-shopping-cart"></i> 
                  </a>';
                }
                ?>
                 
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--================End Single Product Area =================-->

    <!--================Product Description Area =================-->
    <section class="product_description_area">
      <div class="container">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item">
            
          <li class="nav-item">
            <a
              class="nav-link"
              id="profile-tab"
              data-toggle="tab"
              href="#profile"
              role="tab"
              aria-controls="profile"
              aria-selected="false"
              >Product Detail</a
            >
          </li>
          <li class="nav-item">
            <a 
              class="nav-link"
              id="contact-tab"
              data-toggle="tab"
              href="#contact"
              role="tab"
              aria-controls="contact"
              aria-selected="false"
              >You might interest in</a
            >
          </li>
          <li class="nav-item">
            <a
              class="nav-link active"
              id="review-tab"
              data-toggle="tab"
              href="#review"
              role="tab"
              aria-controls="review"
              aria-selected="false"
              >Comment</a
            >
          </li>
        </ul>
        <div class="tab-content" id="myTabContent">
          <div
            class="tab-pane fade"
            id="home"
            role="tabpanel"
            aria-labelledby="home-tab"
          >
            <p>
              Beryl Cook is one of Britain’s most talented and amusing artists
              .Beryl’s pictures feature women of all shapes and sizes enjoying
              themselves .Born between the two world wars, Beryl Cook eventually
              left Kendrick School in Reading at the age of 15, where she went
              to secretarial school and then into an insurance office. After
              moving to London and then Hampton, she eventually married her next
              door neighbour from Reading, John Cook. He was an officer in the
              Merchant Navy and after he left the sea in 1956, they bought a pub
              for a year before John took a job in Southern Rhodesia with a
              motor company. Beryl bought their young son a box of watercolours,
              and when showing him how to use it, she decided that she herself
              quite enjoyed painting. John subsequently bought her a child’s
              painting set for her birthday and it was with this that she
              produced her first significant work, a half-length portrait of a
              dark-skinned lady with a vacant expression and large drooping
              breasts. It was aptly named ‘Hangover’ by Beryl’s husband and
            </p>
            <p>
              It is often frustrating to attempt to plan meals that are designed
              for one. Despite this fact, we are seeing more and more recipe
              books and Internet websites that are dedicated to the act of
              cooking for one. Divorce and the death of spouses or grown
              children leaving for college are all reasons that someone
              accustomed to cooking for more than one would suddenly need to
              learn how to adjust all the cooking practices utilized before into
              a streamlined plan of cooking that is more efficient for one
              person creating less
            </p>
          </div>
          <div
            class="tab-pane fade"
            id="profile"
            role="tabpanel"
            aria-labelledby="profile-tab"
          >
            <div class="table-responsive">
              <table class="table">
                <tbody>
                    <?php
                    $inf_infor = (array) (json_decode(base64_decode($data[8])) );
                    foreach ($inf_infor as $key => $value) {
                      echo '<tr>
                      <td>
                        <h5 class="text-capitalize">'. $key .'</h5>
                      </td>
                      <td>
                        <h5 class="text-capitalize">'. $value .'</h5>
                      </td>
                    </tr>';
                    }
                    // var_dump(dec_product($data[0]));
                    ?>
                </tbody>
              </table>
            </div>
          </div>
          <div
            class="tab-pane fade"
            id="contact"
            role="tabpanel"
            aria-labelledby="contact-tab"
          >
            <div class="row">
              <div class="col-lg-6">
                <div class="comment_list">
                  <div class="review_item">
                    <div class="media">
                      <div class="d-flex">
                        <img
                          src="img/product/single-product/review-1.png"
                          alt=""
                        />
                      </div>
                      <div class="media-body">
                        <h4>Blake Ruiz</h4>
                        <h5>12th Feb, 2017 at 05:56 pm</h5>
                        <a class="reply_btn" href="#">Reply</a>
                      </div>
                    </div>
                    <p>
                      Lorem ipsum dolor sit amet, consectetur adipisicing elit,
                      sed do eiusmod tempor incididunt ut labore et dolore magna
                      aliqua. Ut enim ad minim veniam, quis nostrud exercitation
                      ullamco laboris nisi ut aliquip ex ea commodo
                    </p>
                  </div>
                  <div class="review_item reply">
                    <div class="media">
                      <div class="d-flex">
                        <img
                          src="img/product/single-product/review-2.png"
                          alt=""
                        />
                      </div>
                      <div class="media-body">
                        <h4>Blake Ruiz</h4>
                        <h5>12th Feb, 2017 at 05:56 pm</h5>
                        <a class="reply_btn" href="#">Reply</a>
                      </div>
                    </div>
                    <p>
                      Lorem ipsum dolor sit amet, consectetur adipisicing elit,
                      sed do eiusmod tempor incididunt ut labore et dolore magna
                      aliqua. Ut enim ad minim veniam, quis nostrud exercitation
                      ullamco laboris nisi ut aliquip ex ea commodo
                    </p>
                  </div>
                  <div class="review_item">
                    <div class="media">
                      <div class="d-flex">
                        <img
                          src="img/product/single-product/review-3.png"
                          alt=""
                        />
                      </div>
                      <div class="media-body">
                        <h4>Blake Ruiz</h4>
                        <h5>12th Feb, 2017 at 05:56 pm</h5>
                        <a class="reply_btn" href="#">Reply</a>
                      </div>
                    </div>
                    <p>
                      Lorem ipsum dolor sit amet, consectetur adipisicing elit,
                      sed do eiusmod tempor incididunt ut labore et dolore magna
                      aliqua. Ut enim ad minim veniam, quis nostrud exercitation
                      ullamco laboris nisi ut aliquip ex ea commodo
                    </p>
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="review_box">
                  <h4>Post a comment</h4>
                  <form
                    class="row contact_form"
                    action="contact_process.php"
                    method="post"
                    id="contactForm"
                    novalidate="novalidate"
                  >
                    <div class="col-md-12">
                      <div class="form-group">
                        <input
                          type="text"
                          class="form-control"
                          id="name"
                          name="name"
                          placeholder="Your Full name"
                        />
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <input
                          type="email"
                          class="form-control"
                          id="email"
                          name="email"
                          placeholder="Email Address"
                        />
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <input
                          type="text"
                          class="form-control"
                          id="number"
                          name="number"
                          placeholder="Phone Number"
                        />
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <textarea
                          class="form-control"
                          name="message"
                          id="message"
                          rows="1"
                          placeholder="Message"
                        ></textarea>
                      </div>
                    </div>
                    <div class="col-md-12 text-right">
                      <button
                        type="submit"
                        value="submit"
                        class="btn submit_btn"
                      >
                        Submit Now
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <div
            class="tab-pane fade show active"
            id="review"
            role="tabpanel"
            aria-labelledby="review-tab"
          >
            <div class="row">
              <div class="col-lg-6">
                <div class="row total_rate">
                  <div class="col-6">
                    <div class="box_total">
                      <h5>Overall</h5>
                      <h4 id="average_rate">4.0</h4>
                      <h6>(<?= getCustomData('SELECT COUNT(cmt_id) FROM comment WHERE cmt_product = "'. $_GET['id_product'] .'"')[0][0] ?> Reviews)</h6>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="rating_list">
                      <h3>Total Reviews Rate</h3>
                      <ul class="list">
                        <li>
                          <a href="#"
                            >5 Star
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i> <span class="rate"><?=getCustomData('SELECT COUNT(cmt_id) FROM comment WHERE cmt_product = "'. $_GET['id_product'] .'" AND cmt_rate = 5')[0][0] ?></span></a
                          >
                        </li>
                        <li>
                          <a href="#"
                            >4 Star
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i> <span class="rate"><?=getCustomData('SELECT COUNT(cmt_id) FROM comment WHERE cmt_product = "'. $_GET['id_product'] .'" AND cmt_rate = 4')[0][0] ?></span></a
                          >
                        </li>
                        <li>
                          <a href="#"
                            >3 Star
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i> <span class="rate"><?=getCustomData('SELECT COUNT(cmt_id) FROM comment WHERE cmt_product = "'. $_GET['id_product'] .'" AND cmt_rate = 3')[0][0] ?></span></a
                          >
                        </li>
                        <li>
                          <a href="#"
                            >2 Star
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i> <span class="rate"><?=getCustomData('SELECT COUNT(cmt_id) FROM comment WHERE cmt_product = "'. $_GET['id_product'] .'" AND cmt_rate = 2')[0][0] ?></span></a
                          >
                        </li>
                        <li>
                          <a href="#"
                            >1 Star
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i> <span class="rate"><?=getCustomData('SELECT COUNT(cmt_id) FROM comment WHERE cmt_product = "'. $_GET['id_product'] .'" AND cmt_rate = 1')[0][0] ?></span></a
                          >
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="review_list">
                <?php
                $comment_data = getCustomData('SELECT * FROM comment WHERE cmt_product = "'. $_GET['id_product'] .'"');
                if(!$comment_data) {
                  echo '<p>Nothing to show</p>';
                }
                else {

                
                for ($i=0; $i < count($comment_data); $i++) { 
                  $star_cmt = '';
                  $name_id = array(array('',''));
                  $vip_data = '';
                  if(isset($_COOKIE['token_id'] )) {
                  $username_token = getCustomData('SELECT token_username FROM token_customer WHERE token_content = "'. $_COOKIE['token_id'] .'"')[0][0];
                    $name_id = getCustomData('SELECT ctm_username,ctm_name,ctm_isvip FROM customers WHERE ctm_username = "'.  $username_token .'"');
                    $vip_data = getCustomData('SELECT ctm_isvip FROM customers WHERE ctm_username = "'. $comment_data[$i][1] . '"')[0][0];
                  }
                  
                  for ($j=0; $j < $comment_data[$i][4] ; $j++) { 
$star_cmt.='<i class="fa fa-star"></i>';
                  }
                  echo '  <div class="review_item">
                  <div class="media">
                    <div class="d-flex">
                      <p class="text-white rounded-circle p-3 '.  ($vip_data ? ' bg-warning' : ' bg-secondary') .'" style="font-weight:bold">'. $comment_data[$i][1]  .'</p>  
                    </div>
                    <div class="media-body">
                      <h4>'.  $name_id[0][1] . ($name_id[0][0] == $comment_data[$i][1] ? '<button class="btn" onclick="delete_cmt(`'. $comment_data[$i][0] .'`)" style="transform:scale(0.7)">X</button>' : '')   .' </h4>
                      '.  $star_cmt .'
                    </div>
                  </div>
                  <p> ' .  $comment_data[$i][3] .'
                  </p>
                </div>
               ';
                }
              }
                ?>
                </div>
              </div>
              <div class="col-lg-6">
                <?php
                if(isset($_COOKIE['token_id'])) {
                  echo '<div class="review_box">
                  <h4 id="demos">Add a Review</h4>
                  <p>Your Rating:</p>
                  <ul class="list">
                    <li>
                      <a onclick="star(1)" >
                        <i class="fa fa-star star-rate" style="color:gray"></i>
                      </a>
                    </li>
                    <li>
                      <a onclick="star(2)" >
                        <i class="fa fa-star star-rate" style="color:gray"></i>
                      </a>
                    </li>
                    <li>
                      <a onclick="star(3)" >
                        <i class="fa fa-star star-rate" style="color:gray"></i>
                      </a>
                    </li>
                    <li>
                      <a onclick="star(4)" >
                        <i class="fa fa-star star-rate" style="color:gray"></i>
                      </a>
                    </li>
                    <li>
                      <a onclick="star(5)" >
                        <i class="fa fa-star star-rate" style="color:gray"></i>
                      </a>
                    </li>
                  </ul>
                  <form
                    class="row contact_form"
                    method="post"
                    id="contactForm"
                    novalidate="novalidate"
                  > 
                  <input type="hidden" name="star" value="1" />
                    <div class="col-md-12">
                      <div class="form-group">
                        <textarea
                          class="form-control"
                          name="content"
                          id="message"
                          rows="7"
                          placeholder="Review"
                        ></textarea>
                      </div>
                    </div>
                    <div class="col-md-12 text-right">
                      <button
                        type="submit"
                        value="submit"
                        class="btn submit_btn"
                      >
                        Comment
                      </button>
                    </div>
                  </form>
                </div>';
                }
                else {
                  echo '<p class="text-center">Login if you desire to comment</p><button onclick="location.href = `./login.php?id_product='. $_GET['id_product'] .'`" class="d-block mx-auto btn btn-default">Login now</button>';
                }
                ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <script>
      function buy() {
        location.href = 'checkout.php?qty='+ (document.getElementsByName('qty')[0].value) + '&id_product=<?= $_GET['id_product']?>&sale_price=<?=$sale_price?>'
      }
 let rate_star_average = (document.getElementsByClassName('rate'))
 let average_rate_total = 0
 lv_rate = 5;
 count = 0
 for (let i = 0; i < rate_star_average.length; i++) {
    if(parseInt(rate_star_average[i].innerText) != 0)
    {
      average_rate_total+= parseInt(rate_star_average[i].innerText) * lv_rate
      count+= parseInt(rate_star_average[i].innerText)
    }
    lv_rate--
 }
  document.getElementById('average_rate').innerText = parseFloat(  average_rate_total / count).toFixed(2)
//  document.getElementById('average_rate').innerText =   average_rate_total
      function star(index) {
        document.getElementsByName('star')[0].value = index
        for (let i = 0; i < 5; i++) {
          document.getElementsByClassName('star-rate')[i].style.color = 'gray'
        }
        for(let i = 0 ; i < index ; i++) {
          document.getElementsByClassName('star-rate')[i].style.color = '#fbd600'
        }
      }

 function delete_cmt(text) {
  if(confirm('Bạn chắc chắn muốn xoá?')) {
    location.href = 'single-product.php?id_product=<?= $_GET['id_product'] ?>&del_cmt='+text
  }
 }   
    </script>
<?php
ob_flush();
include_once('footer.php');
?>