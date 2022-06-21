<?php
    function say_error(string $msg) {
        echo '<div class="hazi-ajax-error">' . $msg . '</div>';
    }

    function say_ok(string $msg) {
        echo '<div class="hazi-ajax-ok">' . $msg . '</div>';
    }

    $query = $_REQUEST["q"];

    if (!empty($query)) {
        if (strlen($query) <= 8) {
            say_error("Password Length: Too short <br>");
        } else if (strlen($query) >= 64) {
            say_error("Password Length: Too long <br>");
        }
        else {
            say_ok("Password Length: PASS<br>");
        }

        if(!preg_match("#[0-9]+#", $query)) {
            say_error("At least one Number: Fail <br>");
        } else {
            say_ok("At least one Number: PASS <br>");
        }

        if(!preg_match("#[A-Z]+#", $query)) {
            say_error("At least one Capital letter: Fail <br>");
        } else {
            say_ok("At least one Capital letter: PASS <br>");
        }

        if(!preg_match("#[a-z]+#", $query)) {
            say_error("At least one lower letter: Fail <br>");
        } else {
            say_ok("At least one lower letter: PASS <br>");
        }
    }
?>