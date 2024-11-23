<?php

set_error_handler("customErrorHandler");
set_exception_handler('exceptionHandler');
register_shutdown_function('shutdownHandler');

function customErrorHandler($errno, $errstr, $errfile, $errline) {
    if ($errno === E_NOTICE || $errno === E_WARNING) {
        return true; // Warning eta notice kontuan ez hartu
    }
    // Mezu generikoa
    echo "Errore bat gertatu da sisteman. Mesedez, saiatu beranduago.";
    exit();  
}

function exceptionHandler($exception) {
    echo "Errore bat gertatu da sisteman. Mesedez, saiatu beranduago.";
    exit();
}

function shutdownHandler() {
    $error = error_get_last();
    if ($error) {
        echo "Errore bat gertatu da sisteman. Mesedez, saiatu beranduago.";
    }
}
