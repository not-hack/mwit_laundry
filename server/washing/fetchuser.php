<?php
    include("../connection/PDO_connectionDB.php");

    $data = array();

    $query = "SELECT * FROM `datauser` WHERE `userID` = :UID";
    $stmt = $DB_connect->prepare($query);
    $stmt->execute(array("UID" => $_POST['UID']));

    $result = $stmt->fetchAll();

    foreach($result as $row) {
        $data['userID'] = $row['userID'];
        $data['name'] = $row['firstname'] . " " . $row['lastname'];
        $data['email'] = $row['email'];
        $data['endTime'] = date("H:i:s", $_POST['endTime']);
    }

    echo json_encode($data, JSON_PRETTY_PRINT);
?>