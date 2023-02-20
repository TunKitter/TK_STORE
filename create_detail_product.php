<style>
	.table-row {
		transition-duration: 0.2s;
	}
</style>
  
<?php
require_once('./admin_header.php');
require_once('./execute/global.php');
session_start();

if(isset($_POST['edit_id'])) {
    $col = array('prod_name','prod_cate','prod_price','prod_desc','prod_quantity');
    $fields = array('name','category','price','description','quantity');
    for($i = 0 ; $i < count($col) ; $i++) {
        editData('products',$col[$i],$_POST[$fields[$i]],'prod_id',$_POST['edit_id']);
    }
    $infor = json_encode(array('width'=> $_POST['width'],'height'=> $_POST['height'],'material'=> $_POST['material'],'national'=> $_POST['national'],'gender'=> $_POST['gender']));
    editData('products','prod_info', base64_encode($infor),'prod_id',$_POST['edit_id']);
    // var_dump(($_FILES['image']['name'][0]) == '');
    if($_FILES['image']['name'][0] != '') {
        for($j = 0 ; $j < count($_FILES['image']['name']) ; $j++) {
            move_uploaded_file($_FILES['image']['tmp_name'][$j],'./img/product/__'. $j . $_POST['edit_id'] . '.'. explode('/',$_FILES['image']['type'][$j])[1] );
        }
    }   
    header('location: ./admin_product.php');
    die();
        }

if(!empty($_POST['name']) && !empty($_POST['category'])&& !empty($_FILES['image'])&&!empty($_POST['price'])&&!empty($_POST['description'])&&!empty($_POST['quantity'])&&!empty($_POST['brand'])  && !empty($_POST['width'])&&!empty($_POST['height'])&&!empty($_POST['gender']) && !empty($_POST['material']) && !empty($_POST['national'])) {
        if(!(isset($_SESSION['success_insert']))) {
        $infor = json_encode(array('width'=> $_POST['width'],'height'=> $_POST['height'],'gender'=>$_POST['gender'],'material'=> $_POST['material'],'national'=> $_POST['national']));
        $id = enc_product($_POST['color'],$_POST['brand']);
        $image_extend = array();
        for ($i=0; $i < count($_FILES['image']['name']); $i++) { 
            move_uploaded_file($_FILES['image']['tmp_name'][$i],'./img/product/'.'__'. $i  . $id . '.'. explode('/',$_FILES['image']['type'][$i])[1]);
            $image_extend[$i]  = explode('/',$_FILES['image']['type'][$i])[1];
        }
        insertData('products',$id ,$_POST['name'],$_POST['category'], base64_encode(json_encode($image_extend)),$_POST['price'],0,$_POST['description'],$_POST['quantity'],base64_encode($infor));
        $_SESSION['success_insert'] = $id;
        die();
    }
    else {
        alert_bt('success','Your product has created',1,'Go back now','./admin_product.php');
        unset($_SESSION['success_insert']);
    }
    }
    else if(!isset($_GET['cre']) && !(isset($_GET['edit_id']))) {
        alert_bt('danger','Please input the valid value or don\'t be empty');
}

?>
      <div class="p-3">
            <h2 class="text-center">Create a new product</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            </button>
                        <form method="post" id="create_customer" action="./create_detail_product.php" enctype="multipart/form-data">
                              <div>
                                  <label>Product name</label>
                                  <input type='text' name='name'  placeholder="Enter your product name" class="form-control" />
                                </div>
                                <div>
                                    <label>Category</label>
                            <select class="form-select  border-secondary" name="category" style="outline: none;">
                                <?php
                                $category = getData('category_product');
                                for ($i=0; $i < count($category); $i++) {
                                    echo '<option value="'. $category[$i][0] .'">'. $category[$i][1] .'</option>';
                                }
                                   ?>
               </select>
                                </div>
                                <div>
                                    <label>Image</label>
                                    <input type='file' name='image[]' multiple class="d-block" />
                                </div>
                                <div>
                                    <label>Price</label>
                            <div class="input-group">
                                <input type='number' name='price' placeholder="Enter product's price" class="form-control" />
                                <div class="input-group-text bg-white rounded-0">VND</div>
                            </div>
                                </div>
                                <div>
                                    <label>Description</label>
                                    <br>
                                    <textarea name="description" class="form-control" rows="4"></textarea>
                            </div>
            
                                <div>
                                    <label>Quantity</label>;
                                    <br>
                                <input type='number' min="1" name='quantity' placeholder="Enter product's price" class="form-control" />
                                    
                            </div>
            
                                <div class="<?= isset($_GET['edit_id']) ? 'd-none' : '' ?>">
                                    <label>Color</label>
                                    <br>
                                <input type='text'  name='color' placeholder="Enter product's color" class="form-control" />
                                    
                            </div>
            
                                <div class="<?= isset($_GET['edit_id']) ? 'd-none' : '' ?>">
                                    <label>Brand name</label>
                                    <br>
                                <input type='text' name='brand' placeholder="Enter product's brand" class="form-control" />
                                    
                            </div>
            
                            <label>More info</label>
                                <div class="d-flex">
                                <input type='text'  name='width' placeholder="Enter width" class="form-control mr-2" />
                                <input type='text'  name='height' placeholder="Enter height" class="form-control mr-2" />
                                <select name='gender' class="form-select mr-2 border-0">
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="unisex">Unisex</option>
                                </select>
                                <input type='text'  name='material' placeholder="Enter product's material" class="form-control mr-2" />
                                <input type='text'  name='national' placeholder="Enter product's nation" class="form-control" />
                                    
                            </div>
                            <?php
                            if(isset($_GET['edit_id'])) {
                                echo '<input form="create_customer" type="hidden" name="edit_id" value="'. $_GET['edit_id'] .'"/>';
                            }   
                            ?>
            
                        <button type="submit" class="btn btn-info mt-5 w-50 mx-auto d-block">Save changes</button>
                            </form>
        </div>
        <script>
             document.getElementsByTagName('input')[0].value = 'Tunkit'
    document.getElementsByTagName('input')[2].value = "200"
    document.getElementsByTagName('textarea')[0].value = 'sdadadasad'
    document.getElementsByTagName('input')[3].value = '20'
    document.getElementsByTagName('input')[4].value = 'Red'
    document.getElementsByTagName('input')[5].value = 'Nekki'
    document.getElementsByTagName('input')[6].value = '300'
    document.getElementsByTagName('input')[7].value = '200'
    document.getElementsByTagName('input')[8].value = 'Vaii'
    document.getElementsByTagName('input')[9].value = 'Vietnam'
        </script>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>
</html>
<?php
if(isset($_GET['edit_id'])) {
    $data_edit = getCustomData('SELECT * FROM products WHERE prod_id = "'. $_GET['edit_id'] .'"');
    $infor_edit  = json_decode(base64_decode($data_edit[0][8]),true);
    echo "
    <script>
    document.getElementsByTagName('input')[0].value = '". $data_edit[0][1] ."'
    document.getElementsByTagName('input')[2].value = ". $data_edit[0][4] ."
    document.getElementsByTagName('textarea')[0].value = '" . $data_edit[0][6] ."'
    document.getElementsByTagName('input')[3].value = '" . $data_edit[0][7] ."'
    document.getElementsByTagName('input')[4].value = '" . dec_product($_GET['edit_id'])[1] ."'
    document.getElementsByTagName('input')[5].value = '" . dec_product($_GET['edit_id'])[2] ."'
    document.getElementsByTagName('input')[6].value = '" . $infor_edit['width'] ."'
    document.getElementsByTagName('input')[7].value = '" . $infor_edit['height'] ."'
    document.getElementsByTagName('input')[8].value = '" . $infor_edit['material'] ."'
    document.getElementsByTagName('input')[9].value = '" . $infor_edit['national'] ."'
</script>";
    
}
            
            ?>