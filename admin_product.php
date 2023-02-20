<?php
require_once('./admin_header.php');
require_once('./execute/global.php');
$new_product = 0;
session_start();
if(isset($_SESSION['success_del']))
 {
	echo '<div id="al_sc" class="alert alert-success">You have removed your selected customers</div>';
	unset($_SESSION['success_del']);
}
else if(isset($_SESSION['success_insert'])) {
	echo '<div id="al_sc" class="alert alert-success">Added a new product</div>';
	$new_product= getCustomData('SELECT * FROM products WHERE prod_id = "'. $_SESSION['success_insert'] .'"');
 }
 
else if(isset($_SESSION['success_edit'])) {
	echo '<div id="al_sc" class="alert alert-success">The customer: <strong>'. $_SESSION['success_edit'] .'</strong> has been edited </div>';
 }

if(isset($_GET['del']))
 {
		for ($i=0; $i < count(explode(';',$_GET['del'])); $i++) { 
			$del_data = json_decode(base64_decode(getCustomData('SELECT prod_image FROM products WHERE prod_id = "'. explode(';',$_GET['del'])[$i] .'"')[0][0]));
			for($j = 0 ; $j < count(($del_data));$j++) {
				unlink('./img/product/__'. $j . explode(';',$_GET['del'])[$i] . '.' .$del_data[$j]);
			}
			deleteData('products','prod_id',explode(';',$_GET['del'])[$i]);

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
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>
</html>
<div class="section-top-border">
				<h3 class="mb-30 title_color">Products Management <button class="btn btn-info float-right mr-5" data-toggle="modal" data-target="#myModal" onclick="location.href='./create_detail_product.php?cre=1'">Add new product</button><button style="background-color: #f67590;" class="btn float-right mr-5 text-white btn-delete" disabled data-toggle="modal" data-target="#myModal" onclick="delete_customer()">Delete</button></h3>
				<div class="progress-table-wrap">
					<div class="progress-table">
						<div class="table-head">
							<div class="serial">#</div>
							<div class="serial flex-fill">ID</div>
							<div class="serial">Name</div>
							<div class="serial">Category</div>
							<div class="serial">Image</div>
							<div class="serial">Price</div>
							<div class="serial">More</div>
						</div>
	<?php
	$index_col = isset($_GET['index_col']) ? $_GET['index_col'] : 0;
	if($new_product != 0 ) {	
		$data = getCustomData('SELECT * FROM products WHERE NOT prod_id = "'. $_SESSION['success_insert'] .'"  LIMIT ' . $index_col . ',' . $index_col+11);
		
		echo '	<div class="table-row text-success">
				<div class="serial d-flex flex-row-reverse justify-content-end align-items-center "><label for="chk"  >New</label><input class="d-none" type="checkbox" id="chk"  class="form-check" /></div>
				<div class="serial name text-truncate flex-fill">'. $new_product[0][0] .'</div>
				<div class="serial text-capitalize username">'. $new_product[0][1] .'</div>
				<div class="serial password">'. $new_product[0][2] .'</div>
				<div class="serial email "><img src="./img/product/__0'. $new_product[0][0].'.'. json_decode(base64_decode($new_product[0][3]))[0] .'" style="max-width: 100px" /></div>
				<div class="serial phone">'. $new_product[0][4] .'</div>
				<div class="serial"><a href="#"><span class="lnr lnr-arrow-right float-right" data-toggle="modal" data-target="#edit"></span></a></div>
			</div>';
	unset($_SESSION['success_insert']);
			}
	
	else {
		$data = getCustomData('SELECT * FROM products LIMIT ' . $index_col . ',' . $index_col+11);
	}
		if(!empty($data)) {
			for($i = 0 ; $i < count($data) ; $i++) {
				echo '<div class="table-row">
				<div class="serial d-flex flex-row-reverse justify-content-end align-items-center "><label for="chk_'. $i .'"  >'. $i .'</label><input class="d-none" type="checkbox" id="chk_'. $i .'"  class="form-check" /></div>
				<div class="serial name text-truncate flex-fill">'.$data[$i][0].'</div>
				<div class="serial text-capitalize username">'. $data[$i][1].'</div>
				<div class="serial password">'. $data[$i][2].'</div>
				<div class="serial email "><img src="./img/product/__0'. $data[$i][0].'.'. json_decode(base64_decode($data[$i][3]))[0] .'" style="max-width: 100px" /></div>
				<div class="serial phone">'. $data[$i][4] .'</div>	
				<div class="serial"><a href="#"><span class="lnr lnr-arrow-right float-right" data-toggle="modal" data-target="#edit" onclick="edit_customer('. $i .')"></span></a></div>
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
		location.href = 'admin_product.php?del='+text.substring(0,text.length-1)
	}
	}					
	var fields = ['name','username','password','email','phone']
	var inp_edit = []
	function edit_customer(index) {
		location.href = './create_detail_product.php?edit_id='+ document.getElementsByClassName('name')[index].innerHTML
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