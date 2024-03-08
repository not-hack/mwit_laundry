<?php
    require_once "key.secret.php";
    require_once "service.php";

    $range = 'USERDATA!USERID';
    $response = $service->spreadsheets_values->get($GOOGLE_SHEET_ID, $range);
    $rows = $response->getValues();

    $header = array_shift($rows);

    foreach ($rows as $row) {
        $data[] = array_combine($header, $row);
    }

    $USERID = json_encode($data, JSON_PRETTY_PRINT);
?>