<?php

include('include/classes/Controller.php');
$Controller = new Controller();

if( $Controller->check($_POST['captcha']) ) {
    echo 'SUKSES';
}else{
    echo 'GAGAL';
}
?>
