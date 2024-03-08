<?php
require_once "../connection/config.php";

date_default_timezone_set("Asia/Bangkok");


$conn = new mysqli($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

if ($conn->connect_error) {
    die('Connect to database fail');
}

$response = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $postData = file_get_contents('php://input');
    $jsonData = json_decode($postData);
    $machineID = $jsonData->machineID;
    $stdID = $jsonData->stdID;
    $status = "working";
    $end_usetime = strtotime("+1 minute", $_SERVER['REQUEST_TIME']) * 1000;

    if ($machineID != "" && $stdID != "") {
        $check_stdID = "SELECT `firstname`, `lastname` FROM `datauser` WHERE `userID` = ? LIMIT 1";
        $stmt = $conn->prepare($check_stdID);
        $stmt->bind_param('i', $stdID);
        $stmt->execute();
        $stmt->bind_result($firstname, $lastname);
        $result = $stmt->fetch();
        $stmt->close();

        if ($result) {

            $check_status = "SELECT `status` FROM `washing-machine` WHERE `ID` = ? LIMIT 1";
            $stmt = $conn->prepare($check_status);
            $stmt->bind_param('i', $machineID);
            $stmt->execute();
            $stmt->bind_result($check_status);
            $result = $stmt->fetch();
            $stmt->close();

            if ($check_status != "working") {

                $sql = "UPDATE `washing-machine` SET `status` = ?, `end_usetime` = ?, `current_user` = ? WHERE `ID` = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('sisi', $status, $end_usetime, $stdID, $machineID);
                $stmt->execute();
                $stmt->close();

                if ($stmt) {
                    $response = "Hello, $firstname";
                    echo $response;
                    exit;
                } else {
                    $response = "Fail update to SQL.";
                    echo $response;
                    exit;
                }
            } else {
                $response = "This machine is working";
                echo $response;
                exit;
            }
        } else {
            $response = "Not found stdID.";
            echo $response;
            exit;
        }
    } else {
        $response = "Empty JSON";
        echo $response;
        exit;
    }
} else {
    $response = "Cannot\POST";
    echo $response;
    exit;
}
?>