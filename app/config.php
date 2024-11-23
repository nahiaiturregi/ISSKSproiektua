<?php
// config.php
set_error_handler("customErrorHandler");
set_exception_handler('exceptionHandler');
register_shutdown_function('shutdownHandler');

function customErrorHandler($errno, $errstr, $errfile, $errline) {
    // Mezu generikoa
    echo "Errore bat gertatu da sisteman. Mesedez, saiatu beranduago.";
    exit();  // Detener la ejecución del script
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