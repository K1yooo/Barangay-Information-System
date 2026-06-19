<?php
include 'database.php';

if (isset($_GET['ID'])) {
    $reg_id = $_GET['ID'];

    if (isset($reg_id)) {
       
        $stmt = $con->prepare("CALL reject_registration(?) ");
        $stmt->bind_param("i", $reg_id);

        if ($stmt->execute()) {
            echo "success";
        } else {
            echo "Error rejecting applicant: " . $stmt->error;
        }

        $stmt->close();
    }
}


$con->close();
?>
