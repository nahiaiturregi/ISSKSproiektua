<?php
//Funtzioa enkriptatzeko
function encrypt($data) {
    $method = getenv('SECRET_METHOD');
    $key = getenv('SECRET_KEY');
    $iv = getenv('SECRET_IV');
    return openssl_encrypt($data, $method, $key, 0, $iv);
}

//Funtzioa dekriptatzeko
function decrypt($data) {
    $method = getenv('SECRET_METHOD');
    $key = getenv('SECRET_KEY');
    $iv = getenv('SECRET_IV');
    return openssl_decrypt($data, $method, $key, 0, $iv);
}

?>