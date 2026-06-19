<?php
include 'database.php';

$search_value = isset($_POST['search']) ? $_POST['search'] : '';
$street_id = isset($_POST["street"]) ? $_POST["street"] : '';

if(isset($_GET["street"])) {
    $street_id = $_GET["street"];
    $sql = "SELECT r.RS_ID, r.Firstname, r.Middlename, r.Surname, r.Suffix, r.Birthdate, r.Gender, r.Years_In_Barangay, r.Household_No, sn.`streetHOA` AS Street, r.Contact_Number, r.Email, r.Voter_Status, r.IfPWD 
            FROM residents r
            INNER JOIN street_name sn ON r.Street = sn.Street_ID
            WHERE r.Voter_Status = 'Yes' AND r.Street = $street_id";
} else {
    $sql = "SELECT r.RS_ID, r.Firstname, r.Middlename, r.Surname, r.Suffix, r.Birthdate, r.Gender, r.Years_In_Barangay, r.Household_No, sn.`streetHOA` AS Street, r.Contact_Number, r.Email, r.Voter_Status, r.IfPWD
            FROM residents r
            INNER JOIN street_name sn ON r.Street = sn.Street_ID
            WHERE r.Voter_Status = 'Yes'";
}

if (!empty($street_id)) {
    $sql .= " AND r.Street = $street_id";
}

if (!empty($search_value)) {
    $search_condition = "(r.RS_ID LIKE '%$search_value%' OR r.Firstname LIKE '%$search_value%' OR r.Surname LIKE '%$search_value%')";
    $sql .= " AND $search_condition";
}

$result = $con->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $birthdate = new DateTime($row['Birthdate']);
        $now = new DateTime();
        $age = $birthdate->diff($now)->y;

        echo "<tr>
            <td>{$row['RS_ID']}</td>
            <td>{$row['Firstname']}</td>
            <td>{$row['Middlename']}</td>
            <td>{$row['Surname']}</td>
            <td>{$row['Suffix']}</td>
            <td>{$row['Birthdate']}</td>
            <td>{$age}</td>
            <td>{$row['Gender']}</td>
            <td>{$row['Years_In_Barangay']}</td>
            <td>{$row['Household_No']}</td>
            <td>{$row['Street']}</td>
            <td>{$row['Contact_Number']}</td>
            <td>{$row['Email']}</td>
            <td>{$row['Voter_Status']}</td>
            <td>{$row['IfPWD']}</td>
            <td><button class='Blue'>View/Edit</button> <button class='Red' onclick='rejectApplication(this)'>Archive</button></td>
        </tr>";
    }
} else {
    echo "<tr><td colspan='17'>No Resident Found</td></tr>";
}
?>
