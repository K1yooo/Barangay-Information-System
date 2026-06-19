<?php
include 'database.php';



$search_value = isset($_POST["search"]) ? $_POST["search"] : '';
$street_id = isset($_POST["street"]) ? $_POST["street"] : '';

if (isset($_POST["action"])) {
    $archive_id = isset($_POST["archive_id"]) ? $_POST["archive_id"] : '';
    if ($_POST["action"] == "retrieve") {
        echo retrieveResident($con, $archive_id);
    } elseif ($_POST["action"] == "delete") {
        echo deleteResident($con, $archive_id);
    }
    exit();  
}

$sql = "SELECT ra.Archive_ID, ra.Firstname, ra.Middlename, ra.Surname, ra.Suffix, ra.Birthdate, ra.Gender, ra.Years_In_Barangay, ra.Household_No, sn.streetHOA AS Street, ra.Contact_Number, ra.Email, ra.Voter_Status, ra.IfPWD, ra.Date_Archived 
        FROM residents_archive ra
        INNER JOIN street_name sn ON ra.Street_ID = sn.Street_ID
        WHERE 1=1";

if (!empty($search_value)) {
    if (is_numeric($search_value)) {
        $sql .= " AND ra.Archive_ID = '$search_value'";
    } else {
        $sql .= " AND (ra.Firstname LIKE '%$search_value%' OR ra.Surname LIKE '%$search_value%')";
    }
}

if (!empty($street_id)) {
    $sql .= " AND ra.Street_ID = $street_id";
}

function retrieveResident($con, $archive_id) {
    $sql = "
    INSERT INTO residents (
        Firstname, Middlename, Surname, Suffix, Birthdate, Gender, Birthplace, Civil_Status, Years_In_Barangay,
        HouseType, Household_No, Street, Voter_Status, Voters_Precinct_No, IfPWD, Contact_Number, 
        Email
    )
    SELECT 
        Firstname, Middlename, Surname, Suffix, Birthdate, Gender, Birthplace, Civil_Status, Years_In_Barangay,
        HouseType, Household_No, Street_ID, Voter_Status, Voters_Precinct_No, IfPWD, Contact_Number, 
        Email
    FROM 
        residents_archive
    WHERE 
        Archive_ID = ?";
        
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $archive_id);
    
    if ($stmt->execute()) {
   
        $rowsAffected = $stmt->affected_rows;
        if ($rowsAffected > 0) {
            
            $deleteStmt = $con->prepare("DELETE FROM residents_archive WHERE Archive_ID = ?");
            $deleteStmt->bind_param("i", $archive_id);
            if ($deleteStmt->execute()) {
                return "Resident retrieved and archive record deleted successfully.";
            } else {
                return "Error deleting archive record: " . $deleteStmt->error;
            }
        } else {
            return "No resident found in the archive with the given ID.";
        }
    } else {
        return "Error retrieving resident: " . $stmt->error;
    }
}
function deleteResident($con, $archive_id) {
    $stmt = $con->prepare("DELETE FROM residents_archive WHERE Archive_ID = ?");
    $stmt->bind_param("i", $archive_id);
    if ($stmt->execute()) {
        return "Resident deleted successfully.";
    } else {
        return "Error deleting resident: " . $stmt->error;
    }
}
$result = $con->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        
        $birthdate = new DateTime($row['Birthdate']);
        $now = new DateTime();
        $age = $birthdate->diff($now)->y;

        echo "<tr>
                <td>{$row['Archive_ID']}</td>
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
                <td>{$row['Date_Archived']}</td>
                <td>
                    <button class='Blue' onclick='archiveResident({$row['Archive_ID']})'>Retrieve</button>
                    <button class='Red' onclick='deleteResident({$row['Archive_ID']})'>Delete</button>
                </td>
            </tr>";
    }
} else {
    echo "<tr><td colspan='17'>No results found</td></tr>";
}

$con->close();
?>
