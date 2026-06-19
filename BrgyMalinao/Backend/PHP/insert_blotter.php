<?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $complainant = $_POST['complainant'];
    $respondent = $_POST['respondent'];
    $victims = $_POST['victims'];
    $type = $_POST['type'];
    $location = $_POST['location'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $status = $_POST['status'];
    $blotter_details = $_POST['blotter_details'];

    $sql = "INSERT INTO blotter (complainant, respondent, victims, type, location, date, time, status, blotter_details)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $con->prepare($sql);
    $stmt->bind_param("sssssssss", $complainant, $respondent, $victims, $type, $location, $date, $time, $status, $blotter_details);

    if ($stmt->execute()) {
        $message = "Blotter Report Has Been Added";
    } else {
        $message = "Error: " . $sql . "<br>" . $con->error;
    }

    $stmt->close();
    $con->close();

    header("Location: Blotter.php?message=" . urlencode($message));
    exit();
} else {
    echo "Invalid request method.";
}
?>
