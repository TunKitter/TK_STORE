<?php

function showAlert($text) {
    echo '<script>alert("'. $text  .'")</script>';
}
function header_page() {
	header('location:'. $_SERVER['PHP_SELF']);

}
function alert_bt($type,$text,$has_link = 0 , $text_link = '',$link = '#') {
    if($has_link ==0) {
        echo '<div id="al_sc" class="alert alert-'. $type .'">'. $text .'</div>';
    }
    else {
        echo '<div id="al_sc" class="alert alert-'. $type .'">'. $text .' <a href="'. $link .'" class="alert-link">'. $text_link .'</a></div>';
    }
}
function enc_date() {
date_default_timezone_set('Asia/Ho_Chi_Minh');
    $characters = range('a', 'z');
    // return ( date('H') >= 10 ? $characters[date('H')]: $characters[date('H')[1]] ) .  date('d')  . date('m')>= 10 ? date('m') : date('m')[1]. date('y'); 
    return  $characters[date('H') >= 10 ? date('H') : date('H')[1]]. $characters[(date('d') >= 10 ? date('d') : date('d')[1])] . $characters[(date('m') >= 10 ? date('m') : date('m')[1])]. date('y');
}
function enc_product($color,$brand) {
    $color_brand = base64_encode($color.'_'.$brand);
    $a =  rand(2,9) . $color_brand;
     return substr_replace($a,enc_date(),$a[0],0);
}
function dec_product($text) {
    
    $characters = range('a', 'z');
    $date = substr($text,$text[0],5);
    $result = array();
     $result[0] = array_search($date[0],$characters) . '/' . array_search($date[1],$characters). '/'. substr($date,3);   
     $result[1] =  explode('_',base64_decode(substr(substr_replace($text,'',$text[0],5),1)))[0]; 
     $result[2] =   explode('_',base64_decode(substr(substr_replace($text,'',$text[0],5),1)))[1]; 
    return $result;
}

?>