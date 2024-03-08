<?php
    function verify_input($input) {
        $input = htmlentities($input);
        $input = htmlspecialchars($input);
        $input = trim($input);

        return $input;
    }
?>