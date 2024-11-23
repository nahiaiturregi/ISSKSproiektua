<?php
//Saioko cookiearen parametroak ezarri eta saioa hasi
if(session_status() == PHP_SESSION_NONE){
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'domain' => '',
        'secure' => true,
        'httponly' => true,
        'samesite' => 'Strict'
    ]);
}
session_start();
?>
