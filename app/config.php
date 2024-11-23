<?php

set_error_handler("customErrorHandler");
set_exception_handler('exceptionHandler');
register_shutdown_function('shutdownHandler');

function customErrorHandler($errno, $errstr, $errfile, $errline) {
    // Mezu generikoa
    if ($errno === E_NOTICE || $errno === E_WARNING) {
        return true; // Ignorar y continuar la ejecución
    }
    echo "Errore bat gertatu da sisteman. Mesedez, saiatu beranduago.";
    exit();  // Detener la ejecución del script
}

function exceptionHandler($exception) {
    error_log("Excepción no manejada: " . $exception->getMessage(), 3, "/var/www/html/logs/php_errors.log");
    // echo "Errore bat gertatu da sisteman. Mesedez, saiatu beranduago.";
    exit();
}

function shutdownHandler() {
    $error = error_get_last();
    if ($error) {
        error_log("Error fatal: " . $error['message'], 3, "/var/www/html/logs/php_errors.log");
        // echo "Errore bat gertatu da sisteman. Mesedez, saiatu beranduago.";
    }
}
