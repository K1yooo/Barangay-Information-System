<?php
include 'database.php';

$search_value = isset($_POST["search"]) ? $_POST["search"] : '';
$street_id = isset($_POST["street"]) ? $_POST["street"] : '';

$sql = "SELECT bc.brgyClr_ID, r.RS_ID, CONCAT(r.Firstname, ' ', r.Middlename, ' ', r.Surname, ' ', COALESCE(r.Suffix, '')) AS Fullname, 
                rv.Age, rv.Voter_Status, rv.Address, bc.Purpose, bc.Date_issued 
        FROM barangay_clearance bc 
        JOIN residents r ON bc.RS_ID = r.RS_ID
        JOIN residents_view rv ON r.RS_ID = rv.RS_ID
        WHERE 1=1";

if (!empty($search_value)) {
    if (is_numeric($search_value)) {
        $sql .= " AND r.RS_ID = '" . addslashes($search_value) . "'";
    } else {
        $sql .= " AND (r.Firstname LIKE '%" . addslashes($search_value) . "%' OR r.Surname LIKE '%" . addslashes($search_value) . "%')";
    }
}

if (!empty($street_id)) {
    $sql .= " AND r.Street = " . addslashes($street_id);
}

$sql .= " ORDER BY bc.brgyClr_ID ASC";

$result = $con->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $fullname = addslashes($row['Fullname']);
        $address = addslashes($row['Address']);
        $purpose = str_replace("'", "&#39;", $row['Purpose']);
        $dateissued = addslashes($row['Date_issued']);

        echo "<tr>
                <td>{$row['brgyClr_ID']}</td>
                <td>{$row['RS_ID']}</td>
                <td>{$fullname}</td>
                <td>{$row['Age']}</td>
                <td>{$row['Voter_Status']}</td>
                <td>{$address}</td>
                <td>{$purpose}</td>
                <td>{$dateissued}</td>
                <td>
                    <button class='Green' onclick='generateResidencyForm({$row['RS_ID']}, \"{$fullname}\", \"{$address}\", \"{$purpose}\", \"{$dateissued}\")'>Generate</button> 
                </td>
            </tr>";
    }   
} else {
    echo "<tr><td colspan='9'>No results found</td></tr>";
}

$con->close();
?>

<script>
    function generateResidencyForm(RS_ID, fullname, address, purpose, dateissued) {
        var url = "clearanceForm.php?";
        url += "RS_ID=" + encodeURIComponent(RS_ID);
        url += "&fullname=" + encodeURIComponent(fullname);
        url += "&address=" + encodeURIComponent(address);
        url += "&purpose=" + encodeURIComponent(purpose);
        url += "&dateissued=" + encodeURIComponent(dateissued);

        window.location.href = url;
    }
</script>
