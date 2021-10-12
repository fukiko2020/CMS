<?php

function sanitize($posted_data) {
    foreach($posted_data as $key => $value) {
        $sanitized_data[$key] = htmlspecialchars($value, ENT_QUOTES, "UTF-8");
    }
    return $sanitized_data;
}

?>
