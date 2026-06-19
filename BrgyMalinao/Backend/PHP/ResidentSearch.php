<?php
include 'database.php';

function archiveResident($con, $rs_id) {
    $stmt = $con->prepare("CALL Archive_residents(?)");
    $stmt->bind_param("i", $rs_id);
    if ($stmt->execute()) {
        return "Resident archived successfully.";
    } else {
        return "Error archiving resident: " . $stmt->error;
    }
}

$search_value = isset($_POST["search"]) ? $_POST["search"] : '';
$street_id = isset($_POST["street"]) ? $_POST["street"] : '';

if (isset($_POST["archive"]) && $_POST["archive"] == "true") {
    $rs_id = isset($_POST["rs_id"]) ? $_POST["rs_id"] : '';
    echo archiveResident($con, $rs_id);
    exit();
}

$sql = "SELECT r.RS_ID, r.Firstname, r.Middlename, r.Surname, r.Suffix, r.Birthdate, r.Gender, r.Years_In_Barangay, r.Household_No, sn.streetHOA AS Street, r.Contact_Number, r.Email, r.Voter_Status, r.IfPWD, r.Date_Created 
        FROM residents r
        INNER JOIN street_name sn ON r.Street = sn.Street_ID
        WHERE 1=1";

if (!empty($search_value)) {
    if (is_numeric($search_value)) {
        $sql .= " AND r.RS_ID = '$search_value'";
    } else {
        $sql .= " AND (r.Firstname LIKE '%$search_value%' OR r.Surname LIKE '%$search_value%')";
    }
}

if (!empty($street_id)) {
    $sql .= " AND r.Street = $street_id";
}

$result = $con->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        
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
                <td>{$row['Date_Created']}</td>
                <td>
                     <button class='Blue' onclick='viewEditResident({$row['RS_ID']})'>View</button> 
                    <button class='Red' onclick='archiveResident({$row['RS_ID']})'>Archive</button>
                </td>
            </tr>";
    }
} else {
    echo "<tr><td colspan='17'>No results found</td></tr>";
}

$con->close();
?>

<script>
function archiveResident(rs_id) {
    if (confirm('Are you sure you want to archive this resident?')) {
        var form = document.createElement('form');
        form.method = 'POST';
        form.style.display = 'none';
        form.innerHTML = '<input type="hidden" name="archive" value="true"><input type="hidden" name="rs_id" value="' + rs_id + '">';
        document.body.appendChild(form);
        form.submit();
    }
}

function viewEditResident(rs_id) {
    window.location.href = 'EditResident.php?rs_id=' + rs_id;
}
</script>