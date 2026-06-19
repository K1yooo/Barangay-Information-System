<?php
include 'database.php';

if (isset($_GET['ID'])) {
    $reg_id = $_GET['ID'];

    if ($reg_id) {
      
        $stmt = $con->prepare("CALL approve_registration(?)");
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($con->error));
        }

        $stmt->bind_param("i", $reg_id);

        if ($stmt->execute()) {
            echo "Applicant approved successfully";
        } else {
            echo "Error executing statement: " . htmlspecialchars($stmt->error);
        }

        $stmt->close();
    }
}

$con->close();
?>
