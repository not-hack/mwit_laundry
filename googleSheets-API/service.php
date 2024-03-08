<?php

$client = new \Google_Client();
$client->setApplicationName($GOOGLE_SHEET_NAME);
$client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
$client->setAccessType('offline');

$path = $credentials_path;
//https://localhost/MWIT-Laundry/googleSheets-API/credentials.json
$client->setAuthConfig($path);

$service = new \Google_Service_Sheets($client);

?>