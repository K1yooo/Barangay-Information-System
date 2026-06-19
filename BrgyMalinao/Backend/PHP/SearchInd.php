<?php
include 'database.php';

$search_value = isset($_POST["search"]) ? $_POST["search"] : '';
$street_id = isset($_POST["street"]) ? $_POST["street"] : '';

$sql = "SELECT barangay_indigency.indgCert_ID, residents_view.RS_ID, residents_view.Fullname AS Requester_Name, residents_view.Voter_Status, residents_view.Address, barangay_indigency.Fullname, barangay_indigency.Age, barangay_indigency.Purpose, barangay_indigency.Date_issued 
        FROM barangay_indigency 
        JOIN residents_view ON barangay_indigency.RS_ID = residents_view.RS_ID";

if (!empty($street_id)) {
    $sql .= " JOIN residents ON residents_view.RS_ID = residents.RS_ID
              WHERE residents.Street = $street_id";
} else {
    $sql .= " WHERE 1=1";
}

if (!empty($search_value)) {
    if (is_numeric($search_value)) {
        $sql .= " AND residents_view.RS_ID = '$search_value'";
    } else {
        $sql .= " AND (residents_view.Fullname LIKE '%$search_value%' OR residents_view.Voter_Status LIKE '%$search_value%')";
    }
}

$sql .= " ORDER BY barangay_indigency.indgCert_ID ASC";

$result = $con->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $indgCert_ID = $row['indgCert_ID'];
        $RS_ID = $row['RS_ID'];
        $requesterName = htmlspecialchars($row['Requester_Name'], ENT_QUOTES);
        $voterStatus = htmlspecialchars($row['Voter_Status'], ENT_QUOTES);
        $fullname = htmlspecialchars($row['Fullname'], ENT_QUOTES);
        $age = htmlspecialchars($row['Age'], ENT_QUOTES);
        $address = htmlspecialchars($row['Address'], ENT_QUOTES);
        $purpose = str_replace("'", "&#39;", $row['Purpose']); 
        $dateIssued = htmlspecialchars($row['Date_issued'], ENT_QUOTES);

        echo "<tr>
                <td>{$indgCert_ID}</td>
                <td>{$RS_ID}</td>
                <td>{$requesterName}</td>
                <td>{$voterStatus}</td>
                <td>{$fullname}</td>
                <td>{$age}</td>
                <td>{$address}</td>
                <td>{$purpose}</td>
                <td>{$dateIssued}</td>
                <td>
                    <button class='Green' onclick='generateCertificate({$row['RS_ID']}, \"{$requesterName}\", \"{$voterStatus}\", \"{$fullname}\", \"{$age}\", \"{$address}\", \"{$purpose}\", \"{$dateIssued}\")'>Generate</button>
                </td>
            </tr>";
    }
} else {
    echo "<tr><td colspan='10'>No results found</td></tr>";
}

$con->close();
?>

<script>
function generateCertificate(RS_ID, requesterName, voterStatus, fullname, age, address, purpose, dateIssued) {
    let url = '';
    if (fullname && fullname.trim() !== '') {
        url = `indigencyFormMinor.php?RS_ID=${encodeURIComponent(RS_ID)}&requesterName=${encodeURIComponent(requesterName)}&voterStatus=${encodeURIComponent(voterStatus)}&fullname=${encodeURIComponent(fullname)}&age=${encodeURIComponent(age)}&address=${encodeURIComponent(address)}&purpose=${encodeURIComponent(purpose)}&dateIssued=${encodeURIComponent(dateIssued)}`;
    } else {
        url = `indigencyForm.php?RS_ID=${encodeURIComponent(RS_ID)}&requesterName=${encodeURIComponent(requesterName)}&voterStatus=${encodeURIComponent(voterStatus)}&fullname=${encodeURIComponent(fullname)}&age=${encodeURIComponent(age)}&address=${encodeURIComponent(address)}&purpose=${encodeURIComponent(purpose)}&dateIssued=${encodeURIComponent(dateIssued)}`;
    }
    window.location.href = url;
}
</script>
