<?php
    require './country/vendor/autoload.php';
    use NguyenAry\VietnamAddressAPI\Address;
if(isset($_GET['d'])) {
    $arr = Address::getDistrictsByProvinceId($_GET['d']);
    echo '<select class="district_data w-100 form-control" name="district" style="border-color:#dbdbdb;color:#797979" onchange="wards(this.value)">';
for ($i=0; $i < count($arr); $i++) { 
    if(!is_numeric($arr[array_keys($arr)[$i]]['name'])){
        echo '<option value="'. $arr[array_keys($arr)[$i]]['code'] .'">'. $arr[array_keys($arr)[$i]]['name'] .'</option>';
    }
}   
    echo '</select>';
}
else if(isset($_GET['w'])) {
    $arr = Address::getWardsByDistrictId($_GET['w']);
    echo '<select class="w-100 form-control" name="wards" style="border-color:#dbdbdb;color:#797979">';
    for ($i=0; $i < count($arr); $i++) { 
        if(!is_numeric($arr[array_keys($arr)[$i]]['name'])){
        echo '<option value="'. $arr[array_keys($arr)[$i]]['code'] .'">'. $arr[array_keys($arr)[$i]]['name'] .'</option>';
        }
    }   
        echo '</select><br>';
    // }

}
?>
