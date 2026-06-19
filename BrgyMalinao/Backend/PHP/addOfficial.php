<?php
include 'database.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
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


    $stmt = $con->prepare("INSERT INTO officials (Position_ID, Firstname, Middlename, Lastname, Suffix, Gender, Birthdate, Contact_Number, Email, Fullname, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('issssssssss', $position, $firstname, $middlename, $lastname, $suffix, $gender, $birthdate, $contact, $email, $fullname, $image);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        header("Location: Settings.php?status=added");
    } else {
        header("Location: Settings.php?status=error");
    }
    
    $stmt->close();
}
?>
