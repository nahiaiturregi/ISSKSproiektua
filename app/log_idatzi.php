<?php

include_once('config.php'); 

function logAction($action, $details = [], $status) {

    // "logs" direktorioa existitzen ez bada hau sortu
    if (!file_exists(__DIR__ . '/logs')) {
        mkdir(__DIR__ . '/logs', 0777, true);
    }

    $logFile = __DIR__ . "/logs/{$action}.log";;
    $timestamp = date("Y-m-d H:i:s");
    $ip = $_SERVER['REMOTE_ADDR']; // Erabiltzailearen IP helbidea
    $excludeFields = ['pasahitza', 'token_antiCSRF','nan','telefonoa','jaiotze_data','email'];
    
    if (is_bool($details)){
        $filteredData = array_diff_key($details, array_flip($excludeFields));
        $message = "[{$timestamp}] IP: {$ip} | Action: {$action} | Details: {$status} " . json_encode($filteredData) . PHP_EOL;
    }
    else{ //Kasu batzuetan bakarrik bidaltzen da erabiltzailea
        $message = "[{$timestamp}] IP: {$ip} | Action: {$action} | Details: {$status} " . json_encode($details) . PHP_EOL;
    }
    error_log($message, 3, $logFile);
}
