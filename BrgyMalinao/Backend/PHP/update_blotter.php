<?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $blotter_id = $_POST['blotter_id'];
    $complainant = $_POST['complainant'];
    $respondent = $_POST['respondent'];
    $victims = $_POST['victims'];
    $type = $_POST['type'];
    $location = $_POST['location'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $status = $_POST['status'];
    $blotter_details = $_POST['blotter_details'];

    $sql = "UPDATE blotter SET complainant=?, respondent=?, victims=?, type=?, location=?, date=?, time=?, status=?, blotter_details=? WHERE blotter_id=?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("sssssssssi", $complainant, $respondent, $victims, $type, $location, $date, $time, $status, $blotter_details, $blotter_id);

    if ($stmt->execute()) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $con->error;
    }

    $stmt->close();
    $con->close();

    header("Location: Blotter.php");  
    exit();
}
?>
