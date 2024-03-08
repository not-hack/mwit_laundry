<?php
    require_once "config.php";

    $conn = new mysqli($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME, $DB_PORT);

    if ($conn->connect_error) {
        echo 'Connect to database fail';
    }
    // echo "Connect success";
?>