<?php
include 'database.php';

$search_value = isset($_POST["search"]) ? $_POST["search"] : '';
$street_id = isset($_POST["street"]) ? $_POST["street"] : '';

$sql = "SELECT br.resCert_ID, r.RS_ID, CONCAT(r.Firstname, ' ', r.Middlename, ' ', r.Surname, ' ', COALESCE(r.Suffix, '')) AS Fullname, 
                rv.Age, r.Years_In_Barangay, rv.Address, br.Purpose, br.Date_issued 
        FROM barangay_residency br
        JOIN residents r ON br.RS_ID = r.RS_ID
        JOIN residents_view rv ON r.RS_ID = rv.RS_ID
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

$sql .= " ORDER BY br.resCert_ID ASC";

$result = $con->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $fullname = htmlspecialchars($row['Fullname'], ENT_QUOTES);
        $yearsInBarangay = htmlspecialchars($row['Years_In_Barangay'], ENT_QUOTES);
        $address = htmlspecialchars($row['Address'], ENT_QUOTES);
        $purpose = htmlspecialchars($row['Purpose'], ENT_QUOTES);
        $dateIssued = htmlspecialchars($row['Date_issued'], ENT_QUOTES);
    
        echo "<tr>
                <td>{$row['resCert_ID']}</td>
                <td>{$row['RS_ID']}</td>
                <td>{$fullname}</td>
                <td>{$row['Age']}</td>
                <td>{$yearsInBarangay}</td>
                <td>{$address}</td>
                <td>{$purpose}</td>
                <td>{$dateIssued}</td>
                <td>
                    <button class='Green' onclick='generateCertificate(\"{$fullname}\", \"{$yearsInBarangay}\", \"{$address}\", \"{$purpose}\", \"{$dateIssued}\")'>Generate</button>
                </td>
            </tr>";
    }
} else {
    echo "<tr><td colspan='9'>No results found</td></tr>";
}

$con->close();
?>

<script>
function generateCertificate(fullname, yearsInBarangay, address, purpose, dateIssued) {
    const url = `residencyForm.php?fullname=${encodeURIComponent(fullname)}&years_in_barangay=${encodeURIComponent(yearsInBarangay)}&address=${encodeURIComponent(address)}&purpose=${encodeURIComponent(purpose)}&dateIssued=${encodeURIComponent(dateIssued)}`;
    window.location.href = url;
}
</script>
