<?php
    //GET eta POST emaitza saneatzeko funtzioa
    function sanitize_array($data) {
        $sanitized_data = [];
        foreach ($data as $key => $value) {
            $sanitized_data[$key] = is_string($value) ? htmlspecialchars($value, ENT_QUOTES, 'UTF-8') : $value;
        }
        return $sanitized_data;
    }