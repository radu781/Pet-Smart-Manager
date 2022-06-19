<?php

class ValidateInput {
    public static function work(string $param) {
        $param = trim($param);                // Strip whitespace (or other characters) from the beginning and end of a string
        $param = stripslashes($param);        // Un-quotes a quoted string
        $param = htmlspecialchars($param);    // htmlspecialchars — Convert special characters to HTML entities

        return $param;
    }
}
?>