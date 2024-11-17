<?php
//Gakoa sortu
define('SECRET_KEY', 'gakoa12345678901');
define('SECRET_IV', 'iv12345678901234');
define('SECRET_METHOD', 'AES-256-CBC');

//Funtzioa enkriptatzeko
function encrypt($data) {
    return openssl_encrypt($data, SECRET_METHOD, SECRET_KEY, 0, SECRET_IV);
}

//Funtzioa dekriptatzeko
function decrypt($data) {
    return openssl_decrypt($data, SECRET_METHOD, SECRET_KEY, 0, SECRET_IV);
}

?>