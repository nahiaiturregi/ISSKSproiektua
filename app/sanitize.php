<?php

include_once('config.php'); 

//GET eta POST emaitza saneatzeko funtzioa
function sanitize_array($data) {
    $sanitized_data = [];
    foreach ($data as $key => $value) {
        if (is_string($value)) {
            $sanitized_data[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        } else {
            $sanitized_data[$key] = $value;
        }
    }
    return $sanitized_data;
}
