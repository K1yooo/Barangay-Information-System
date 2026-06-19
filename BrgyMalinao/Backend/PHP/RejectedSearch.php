<?php
include 'database.php';

$search_value = isset($_POST["search"]) ? $_POST["search"] : '';
$street_id = isset($_POST["street"]) ? $_POST["street"] : '';

$sql = "SELECT ra.ID, ra.Firstname, ra.Middlename, ra.Surname, ra.Suffix, ra.Birthdate, ra.Gender, ra.Years_In_Barangay, ra.Household_No, sn.`streetHOA` AS
        Street, ra.Contact_Number, ra.Email, ra.Status, ra.Date_Rejected
        FROM rejected_applicants ra
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
                <td>{$row['Status']}</td>
                <td>{$row['Date_Rejected']}</td>
                
            </tr>";
    }
} else {
    echo "<tr><td colspan='15'>No results found</td></tr>";
}

$con->close();
?>
