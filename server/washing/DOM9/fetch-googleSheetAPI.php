<?php
require '../../../googleSheets-API/vendor/autoload.php';
require '../../../googleSheets-API/key.secret.php';

$credentials_path = '../../../googleSheets-API/credentials.json';
require "../../../googleSheets-API/service.php";

$range = 'WASHING_DOM9';
$response = $service->spreadsheets_values->get($GOOGLE_SHEET_ID, $range);
$rows = $response->getValues();

$header = array_shift($rows);

$data = [];

foreach ($rows as $row) {
    $data[] = array_combine($header, $row);
}

echo json_encode($data, JSON_PRETTY_PRINT);

?>