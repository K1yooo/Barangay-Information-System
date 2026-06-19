<?php
include 'database.php';


$query_male = "SELECT COUNT(*) as male_count FROM residents WHERE Gender = 'Male'";
$result_male = mysqli_query($con, $query_male);
$row_male = mysqli_fetch_assoc($result_male);
$male_count = $row_male['male_count'];


$query_female = "SELECT COUNT(*) as female_count FROM residents WHERE Gender = 'Female'";
$result_female = mysqli_query($con, $query_female);
$row_female = mysqli_fetch_assoc($result_female);
$female_count = $row_female['female_count'];


$query_lgbtq = "SELECT COUNT(*) as lgbtq_count FROM residents WHERE Gender = 'LGBTQ'";
$result_lgbtq = mysqli_query($con, $query_lgbtq);
$row_lgbtq = mysqli_fetch_assoc($result_lgbtq);
$lgbtq_count = $row_lgbtq['lgbtq_count'];


$query_senior = "SELECT COUNT(*) as senior_count FROM residents WHERE TIMESTAMPDIFF(YEAR, Birthdate, CURDATE()) >= 60";
$result_senior = mysqli_query($con, $query_senior);
$row_senior = mysqli_fetch_assoc($result_senior);
$senior_count = $row_senior['senior_count'];


$query_pwd = "SELECT COUNT(*) as pwd_count FROM residents WHERE IfPWD = 1";
$result_pwd = mysqli_query($con, $query_pwd);
$row_pwd = mysqli_fetch_assoc($result_pwd);
$pwd_count = $row_pwd['pwd_count'];


$query_voters = "SELECT COUNT(*) as voter_count FROM residents WHERE Voter_Status = 'Registered Voter'";
$result_voters = mysqli_query($con, $query_voters);
$row_voters = mysqli_fetch_assoc($result_voters);
$voter_count = $row_voters['voter_count'];


echo json_encode(array(
    'male_count' => $male_count,
    'female_count' => $female_count,
    'lgbtq_count' => $lgbtq_count,
    'senior_count' => $senior_count,
    'pwd_count' => $pwd_count,
    'voter_count' => $voter_count
));
?>
