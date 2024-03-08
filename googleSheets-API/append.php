<?php
    require_once "service.php";
    require_once "key.secret.php";

    $valueRange = new \Google_Service_Sheets_ValueRange();
    $valueRange->setValues($rows);
    $range = 'USERDATA';
    $options = ['valueInputOption' => 'USER_ENTERED'];
    $check = $service->spreadsheets_values->append($GOOGLE_SHEET_ID, $range, $valueRange, $options);

?>