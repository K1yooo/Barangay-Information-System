<?php
include 'database.php';

$search_value = isset($_POST["search"]) ? $_POST["search"] : '';
$street_id = isset($_POST["street"]) ? $_POST["street"] : '';

$sql = "SELECT ra.ID, ra.Firstname, ra.Middlename, ra.Surname, ra.Suffix, ra.Gender, ra.Birthdate, ra.Years_In_Barangay, ra.Household_No, sn.streetHOA AS Street, ra.Contact_Number, ra.Email, ra.created_at 
        FROM resident_applicants ra
        LEFT JOIN street_name sn ON ra.Street = sn.Street_ID
        WHERE 1=1"; 

if (!empty($search_value)) {
    if (is_numeric($search_value)) {
        $sql .= " AND ra.ID = '$search_value'";
    } else {
        $sql .= " AND (ra.Firstname LIKE '%$search_value%' OR ra.Surname LIKE '%$search_value%')";
    }
}

if (!empty($street_id)) {
    $sql .= " AND ra.Street = $street_id";
}

$result = $con->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['ID']}</td>
                <td>{$row['Firstname']}</td>
                <td>{$row['Middlename']}</td>
                <td>{$row['Surname']}</td>
                <td>{$row['Suffix']}</td>
                <td>{$row['Birthdate']}</td>
                <td>{$row['Gender']}</td>
                <td>{$row['Years_In_Barangay']}</td>
                <td>{$row['Household_No']}</td>
                <td>{$row['Street']}</td>
                <td>{$row['Contact_Number']}</td>
                <td>{$row['Email']}</td>
                <td>{$row['created_at']}</td>
                <td><button class='Blue' onclick='viewApplication({$row['ID']})'>View</button> <button class='Green' onclick='acceptApplication({$row['ID']})'>Accept</button> <button class='Red' onclick='rejectApplication(this)'>X</button></td>
            </tr>";
    }
} else {
    echo "<tr><td colspan='14'>No Registrations found</td></tr>";
}

$con->close();
?>
