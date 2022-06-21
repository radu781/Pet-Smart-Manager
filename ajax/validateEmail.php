<?php
    function say_error(string $msg) {
        echo '<div class="hazi-ajax-error">' . $msg . '</div>';
    }

    function say_ok(string $msg) {
        echo '<div class="hazi-ajax-ok">' . $msg . '</div>';
    }

    $query = $_REQUEST["q"];

    if (!empty($query)) {
        if (!filter_var($query, FILTER_VALIDATE_EMAIL)) {
            say_error("Email: Invalid format <br>");
        }
        else {
            say_ok("Email: PASS <br>");
        }
    }
?>