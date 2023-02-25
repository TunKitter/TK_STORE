<?php
require_once('./admin_header.php');
require_once('./execute/global.php');
// Haven't check form name and the other
$new_customer = 0;
session_start();
if(isset($_SESSION['success_del']))
 {
	echo '<div id="al_sc" class="alert alert-success">You have removed your selected customers</div>';
	unset($_SESSION['success_del']);
}
else if(isset($_SESSION['success_insert'])) {
	echo '<div id="al_sc" class="alert alert-success">Added a new customer</div>';
	$new_customer= getCustomData('SELECT * FROM category_product WHERE cate_id = "'. $_SESSION['success_insert'] .'"');
 }
 
else if(isset($_SESSION['success_edit'])) {
	echo '<div id="al_sc" class="alert alert-success">The customer: <strong>'. $_SESSION['success_edit'] .'</strong> has been edited </div>';
 }

if(isset($_POST['name'])){
    $product_id = date('S').substr($_POST['name'],0,rand(0,strlen($_POST['name']))-1) ;
    insertData('category_product', $product_id,$_POST['name']);
	$_SESSION['success_insert'] = $product_id;
	header_page();
}
else if(isset($_POST['name_edit']))
 {
	  editData('category_product','cate_name',$_POST['name_edit'],'cate_id',$_POST['id_edit']);
	$_SESSION['success_edit'] = $_POST['id_edit'];
	header_page();
	die();
 }
if(isset($_GET['del']))
 {
		for ($i=0; $i < count(explode(';',$_GET['del'])); $i++) { 
			deleteData('category_product','cate_id',explode(';',$_GET['del'])[$i]);
		}
		$_SESSION['success_del'] = '1';
		header_page();
 }


?>
<style>
	.table-row {
		transition-duration: 0.2s;
	}
</style>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create a category product</h5>
      </div>
      <div class="modal-body">
      		<form method="post" id="create_customer">
				  <div>
					  <label>Product name</label>
					  <input type='text' name='name'  placeholder="Enter your product name" class="form-control" />
					</div>
				</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" form="create_customer" class="btn btn-info">Save changes</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">More info customer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      		<form method="post" id="edit_customer" onsubmit="return save_edit()">
				  <div>
					  <label>ID</label>
					  <input type='text' readonly name='id_edit'  placeholder="Enter your name product" class="form-control" />
					</div>
                    <div>
					  <label>Product name</label>
					  <input type='text' name='name_edit'  placeholder="Enter your name product" class="form-control" />
					</div>
				</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" form="edit_customer" class="btn btn-success">Save changes</button>
      </div>
    </div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>
</html>
<div class="section-top-border">
				<h3 class="mb-30 title_color">Sale Off Management <button class="btn btn-info float-right mr-5" data-toggle="modal" data-target="#myModal">Add Product Category</button><button style="background-color: #f67590;" class="btn float-right mr-5 text-white btn-delete" disabled data-toggle="modal" data-target="#myModal" onclick="delete_customer()">Delete</button></h3>
				<div class="progress-table-wrap">
					<div class="progress-table">
						<div class="table-head">
							<div class="serial flex-grow-1">#</div>
							<div class="serial flex-grow-1">id</div>
							<div class="serial flex-grow-1">Name</div>
							<div class="serial flex-grow-1">Quantity</div>
							<div class="serial flex-grow-1">More</div>
						</div>
	<?php
	$index_col = isset($_GET['index_col']) ? $_GET['index_col'] : 0;
	if($new_customer != 0 || isset($_SESSION['success_edit'])) {
		if(isset($_SESSION['success_edit'])) {
			$new_customer = getCustomData('SELECT * FROM category_product WHERE cate_id = "'. $_SESSION['success_edit'] .'"');
			$data = getCustomData('SELECT * FROM category_product WHERE NOT cate_id = "'. $_SESSION['success_edit'] .'"  LIMIT ' . $index_col . ',' . $index_col+11);
	unset($_SESSION['success_edit']);

		}
		else {
			$data = getCustomData('SELECT * FROM category_product WHERE NOT cate_id = "'. $_SESSION['success_insert'] .'"  LIMIT ' . $index_col . ',' . $index_col+11);
		}
		echo '	<div class="table-row text-success">
				<div class="serial flex-grow-1  d-flex flex-row-reverse justify-content-end align-items-center "><label for="chk"  >New</label><input class="d-none" type="checkbox" id="chk"  class="form-check" /></div>
				<div class="serial flex-grow-1 name">'. $new_customer[0][0] .'</div>
				<div class="serial flex-grow-1 name">'. $new_customer[0][1] .'</div>
				<div class="serial flex-grow-1  username"></div>
				<div class="serial flex-grow-1  username"></div>
			</div>';
	unset($_SESSION['success_insert']);
			}
	
	else {
		$data = getCustomData('SELECT * FROM category_product LIMIT ' . $index_col . ',' . $index_col+11);
	}
		if(!empty($data)) {
			for($i = 0 ; $i < count($data) ; $i++) {
				echo '	<div class="table-row">
				<div class="serial flex-grow-1 d-flex flex-row-reverse justify-content-end align-items-center "><label for="chk_'. $i .'"  >'. $i .'</label><input class="d-none" type="checkbox" id="chk_'. $i .'"  class="form-check" /></div>
				<div class="serial flex-grow-1 name">'.$data[$i][0].'</div>
				<div class="serial flex-grow-1 username">'. $data[$i][1].'</div>
				<div class="serial flex-grow-1 username">1000</div>
				<div class="serial flex-grow-1"><a href="#"><span class="lnr lnr-arrow-right float-right" data-toggle="modal" data-target="#edit" onclick="edit_customer('. $i .')"></span></a></div>

			</div>';
			}
		}
		else {
			echo '<div class="text-center p-2">Nothing here</div>';
			die();
		}
	?>
						
						
				</div>
			</div>
				<a href="admin_customer.php?index_col=<?=isset($_GET['index_col']) ? $_GET['index_col']+11:11?>" class="genric-btn btn-info float-right mr-4" style="border-radius: 15px;">Next <span class="lnr ml-2 lnr-arrow-right"></span></a>
				<a href="admin_customer.php?index_col=<?=isset($_GET['index_col']) && $_GET['index_col'] >=11 ? $_GET['index_col']-11: 0 ?>" class="genric-btn btn-info float-right mr-4" style="border-radius: 15px;"><span class="lnr mr-2 lnr-arrow-left"></span> Previous</a>
				<script>
					var select_del = document.querySelectorAll('label[for^=chk]')
					var inp_del = document.querySelectorAll('input[id^=chk]')
					var data_del = []
					var count = 0;
					for (let i = 0; i < select_del.length; i++) {
						select_del[i].onclick = function() {
								if((inp_del[i].checked)) {
							document.getElementsByClassName('table-row')[i].style.backgroundColor = 'white'
							document.getElementsByClassName('table-row')[i].style.color = '#797979'
							count-- 
							if(count <= 0) {
								document.getElementsByClassName('btn-delete')[0].setAttribute('disabled','true')
							}
								}

									else {
										document.getElementsByClassName('table-row')[i].style.backgroundColor = '#17a2b8'
										count++
										if(count > 0) {

											document.getElementsByClassName('table-row')[i].style.color = 'white'	
											document.getElementsByClassName('btn-delete')[0].removeAttribute('disabled')
										}
									
									}
									
								}
								  
						}
	function delete_customer() {
		let text = ''
	for (let i = 0; i < inp_del.length; i++) {
			if(inp_del[i].checked) {
				text+= document.getElementsByClassName('name')[i].innerHTML + ';'
			}

	}
	if(confirm('Are you sure to continue delete?')) {
		location.href = 'admin_category.php?del='+text.substring(0,text.length-1)
	}
	}					
	var fields = ['name','username','password','email','phone']
	var inp_edit = []
	function edit_customer(index) {
		inp_edit = document.querySelectorAll('input[name$=_edit]')
                inp_edit[0].value = document.getElementsByClassName('name')[index].innerHTML
				inp_edit[1].value = document.getElementsByClassName('username')[index].innerHTML
	}
	   function save_edit() {
		if(confirm('Are you sure to continue?')) {
			return true		
		}
		else {
			return false
		}
	   }
				</script>