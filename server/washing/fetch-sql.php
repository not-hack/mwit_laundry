<?php
    session_start();
    include("../connection/connectionDB.php");

    $dormitory = $_SESSION['dormitory'];

    $query = "SELECT * FROM `washing-machine` WHERE `DOM` = ? ORDER BY `ID` ASC";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $dormitory);
    $stmt->execute();
    
    $result = $stmt->get_result();

    $data = $result->fetch_all(MYSQLI_ASSOC);

    echo json_encode($data, JSON_PRETTY_PRINT);

    $stmt->close();
?>