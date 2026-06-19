<?php
include 'C:\XAMPP\htdocs\BrgyMalinao\Backend\PHP\database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['barangay_logo']) && $_FILES['barangay_logo']['error'] == UPLOAD_ERR_OK) {
        $image = file_get_contents($_FILES['barangay_logo']['tmp_name']);

        $updateQuery = "UPDATE logo SET Logo = ? WHERE logo_id = 1";
        $statement = mysqli_prepare($con, $updateQuery);
        mysqli_stmt_bind_param($statement, 's', $image);

        if (mysqli_stmt_execute($statement)) {
            echo "Logo updated successfully!";
        } else {
            echo "Error updating logo: " . mysqli_error($con);
        }

        mysqli_stmt_close($statement);
    } else {
        echo "Error uploading logo: " . $_FILES['barangay_logo']['error'];
    }
}
mysqli_close($con);
?>