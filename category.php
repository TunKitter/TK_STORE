<?php

include_once('./header.php');
include_once('./execute/global.php');
include_once('./execute/pdo.php');
?>
<style>
  .col-lg-4.col-md-6 {
    transition-duration: 1s;
  }

</style>
    <!--================Home Banner Area =================-->
    <section class="banner_area">
      <div class="banner_inner d-flex align-items-center">
        <div class="container">
          <div class="banner_content d-md-flex justify-content-between align-items-center">
            <div class="mb-3 mb-md-0">
              <h2>Shop Category</h2>
              <p>Very us move be blessed multiply night</p>
            </div>
            <div class="page_link">
              <a href="index.html">Home</a>
              <a href="category.html">Shop</a>
              <a href="category.html">All</a>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--================End Home Banner Area =================-->

    <!--================Category Product Area =================-->
    <section class="cat_product_area section_gap">
      <div class="container">
        <div class="row flex-row-reverse">
          <div class="col-lg-9">
            <!-- <div class="product_top_bar">
              <div class="left_dorp">
                <select class="sorting">  
                  <option value="1">Default sorting</option>
                  <option value="2">Default sorting 01</option>
                  <option value="4">Default sorting 02</option>
                </select>
                <select class="show">
                  <option value="1">Show 12</option>
                  <option value="2">Show 14</option>
                  <option value="4">Show 16</option>
                </select>
              </div>
            </div> -->
            
            <div class="latest_product_inner">
              <div class="row">
                <?php

                // $data = getData('products');
                $data = getCustomData('SELECT * FROM products LIMIT 6');
                if(isset($_GET['index_col'])) {
                  $data = getCustomData('SELECT * FROM products LIMIT '. $_GET['index_col'] . ','. $_GET['index_col'] + 6);
                }
                if($data) {
                
                // var_dump(dec_product($data[0][0]));
                for ($i=0; $i < count($data); $i++) { 
                echo '<div class="col-lg-4 col-md-6 '. $data[$i][2] .'" brand="'.dec_product($data[$i][0])[2].'" color="'.dec_product($data[$i][0])[1].'">
                  <div class="single-product">
                    <div class="product-img">
                      <img
                        class="card-img" style="max-height:275px"
                        src="./img/product/__0'. $data[$i][0] . '.'. json_decode(base64_decode($data[$i][3]))[0]. '"
                      />
                      <div class="p_icon">
                        <a href="./single-product.php?id_product='. $data[$i][0] .'">
                          <i class="ti-eye"></i>
                        </a>
                        <a href="#">
                          <i class="ti-shopping-cart"></i>
                        </a>
                      </div>
                    </div>
                    <div class="product-btm">
                      <a href="#" class="d-block">
                        <h4>'. $data[$i][1] .'</h4>
                      </a>
                      <div class="mt-3">
                        <span class="mr-4">$'. $data[$i][4] .'</span>
                        <del>$'. $data[$i][4] .'</del>
                      </div>
                    </div>
                  </div>
                </div>';
                }
              } 
              else {
                echo 'Nothing to show';
              }
                ?>
                <div class="container" id="pagi">
                  <a href="category.php?index_col=<?=isset($_GET['index_col']) ? $_GET['index_col']+6:6?>" class="genric-btn btn-info float-right mr-4" style="border-radius: 15px;">Next <span class="lnr ml-2 lnr-arrow-right"></span></a>
                  <a href="admin_customer.php?index_col=<?=isset($_GET['index_col']) && $_GET['index_col'] >=11 ? $_GET['index_col']-6: 0 ?>" class="genric-btn btn-info float-right mr-4" style="border-radius: 15px;"><span class="lnr mr-2 lnr-arrow-left"></span> Previous</a>
                </div>
                <?php
                if(!$data) {

                  echo '<script>document.getElementById("pagi").style.display ="none"</script>';
                }
                
                ?>
              </div>
              
            </div>
          </div>

          <div class="col-lg-3">
            <div class="left_sidebar_area">
              <aside class="left_widgets p_filter_widgets">
                <div class="l_w_title">
                  <h3>Browse Categories</h3>
                </div>
                <div class="widgets_inner">
                  <ul class="list">
                  <li onclick="cate('.col-lg-4.col-md-6')">
                      <a>All</a>
                    </li>
                    <?php
                    $category= getData('category_product');
                    for ($i=0; $i < count($category); $i++) { 
                      echo '<li onclick="cate(\''. $category[$i][0] .'\')">
                      <a>'. $category[$i][1] .'</a>
                    </li>';
                      }
                    ?>
                  
                  </ul>
                </div>
              </aside>

              <aside class="left_widgets p_filter_widgets">
                <div class="l_w_title">
                  <h3>Product Brand</h3>
                </div>
                <div class="widgets_inner">
                  <ul class="list">
                    <li>
                      <a href="#">Apple</a>
                    </li>
                  </ul>
                </div>
              </aside>

              <aside class="left_widgets p_filter_widgets">
                <div class="l_w_title">
                  <h3>Color Filter</h3>
                </div>
                <div class="widgets_inner">
                  <ul class="list">
                    <li>
                      <a href="#">Black</a>
                    </li>
                  </ul>
                </div>
              </aside>
            </div>
          </div>
        </div>
      </div>
    </section>
    <script>
      var color = document.querySelectorAll('.col-lg-4.col-md-6[color]');
      var brand = document.querySelectorAll('.col-lg-4.col-md-6[brand]');
      const set = new Set()
      const set2 = new Set()
      for (let i = 0; i < brand.length; i++) {
        set.add(brand[i].getAttribute('brand'))
        set2.add(color[i].getAttribute('color'))
      }
      let brand_name = ''
      let color_name = ''
      for (let i = 0; i < set.size; i++) {
         brand_name+=' <li onclick="brand_type(`'+ Array.from(set)[i] +'`)"><a>'+ Array.from(set)[i] +'</a></li>'
        }
      for (let i = 0; i < set2.size; i++) {
        color_name+=' <li onclick="color_type(`'+ Array.from(set2)[i] +'`)"><a>'+ Array.from(set2)[i] +'</a></li>'
        }
      document.getElementsByClassName('list')[1].innerHTML = brand_name
      document.getElementsByClassName('list')[2].innerHTML = color_name
      function cate(type_cate) {
        restore_display()
        let cate = document.querySelectorAll('.col-lg-4.col-md-6:not(.'+type_cate+')');
        for(var i = 0 ; i < cate.length ; i++) {
          cate[i].style.display = 'none'
        }

        
      }
      function brand_type(text) {
        restore_display()
        let cate = document.querySelectorAll('.col-lg-4.col-md-6:not([brand='+ text +'])');
        for(var i = 0 ; i < cate.length ; i++) {
          cate[i].style.display = 'none'
        }

      }
      function color_type(text) {
        restore_display()
        let cate = document.querySelectorAll('.col-lg-4.col-md-6:not([color='+ text +'])');
        for(var i = 0 ; i < cate.length ; i++) {
          cate[i].style.display = 'none'
        }

      }
      function restore_display() {
        let all = document.querySelectorAll('.col-lg-4.col-md-6')
        for (let i = 0; i < all.length; i++) {
          all[i].style.display = 'block'
        }
      }
    </script>
    <!--================ start footer Area  =================-->
   <?php
   include_once('./footer.php');
   ?>
