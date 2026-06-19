<?php
include 'database.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $official_id = mysqli_real_escape_string($con, $_POST['official_id']);
    $position = mysqli_real_escape_string($con, $_POST['position']);
    $firstname = mysqli_real_escape_string($con, $_POST['firstname']);
    $middlename = mysqli_real_escape_string($con, $_POST['middlename']);
    $lastname = mysqli_real_escape_string($con, $_POST['lastname']);
    $suffix = mysqli_real_escape_string($con, $_POST['suffix']);
    $gender = mysqli_real_escape_string($con, $_POST['gender']);
    $birthdate = mysqli_real_escape_string($con, $_POST['birthdate']);
    $contact = mysqli_real_escape_string($con, $_POST['contact']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
   
    $image = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = file_get_contents($_FILES['image']['tmp_name']);
    }
    
    $fullname = "$firstname $middlename $lastname $suffix";

    if ($image) {
        $stmt = $con->prepare("UPDATE officials SET Position_ID = ?, Firstname = ?, Middlename = ?, Lastname = ?, Suffix = ?, Gender = ?, Birthdate = ?, Contact_Number = ?, Email = ?, Fullname = ?, image = ? WHERE Official_ID = ?");
        $stmt->bind_param('issssssssssi', $position, $firstname, $middlename, $lastname, $suffix, $gender, $birthdate, $contact, $email, $fullname, $image, $official_id);
    } else {
        $stmt = $con->prepare("UPDATE officials SET Position_ID = ?, Firstname = ?, Middlename = ?, Lastname = ?, Suffix = ?, Gender = ?, Birthdate = ?, Contact_Number = ?, Email = ?, Fullname = ? WHERE Official_ID = ?");
        $stmt->bind_param('isssssssssi', $position, $firstname, $middlename, $lastname, $suffix, $gender, $birthdate, $contact, $email, $fullname, $official_id);
    }

    $stmt->execute();
 
    if ($stmt->affected_rows > 0) {
        header("Location: Settings.php?status=updated");
    } else {
        header("Location: Settings.php?status=error");
    }

    $stmt->close();
}
?>
