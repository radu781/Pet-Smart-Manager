<?php

class ValidateInput {
    public static function work(string $param): string {
        $param = trim($param);                // Strip whitespace (or other characters) from the beginning and end of a string
        $param = stripslashes($param);        // Un-quotes a quoted string
        $param = htmlspecialchars($param);    // htmlspecialchars — Convert special characters to HTML entities

        return $param;
    }

    public static function work_arr(array $param): array {
        foreach($param as $curr_element) {
            $curr_element = trim($curr_element);                // Strip whitespace (or other characters) from the beginning and end of a string
            $curr_element = stripslashes($curr_element);        // Un-quotes a quoted string
            $curr_element = htmlspecialchars($curr_element);    // htmlspecialchars — Convert special characters to HTML entities
        }

        return $param;
    }
}
?>
