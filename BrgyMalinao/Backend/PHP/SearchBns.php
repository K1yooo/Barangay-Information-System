<?php
include 'database.php';

$search_value = isset($_POST["search"]) ? $_POST["search"] : '';
$street_id = isset($_POST["street"]) ? $_POST["street"] : '';

$sql = "SELECT bc.BusinessCert_ID, bc.Business_owner, bc.Businessname, sn.streetHOA as Location, bc.Purpose, bc.Date_issued 
        FROM business_certification bc
        JOIN street_name sn ON bc.Location = sn.Street_ID
        WHERE 1=1";

if (!empty($search_value)) {
    if (is_numeric($search_value)) {
        $sql .= " AND bc.BusinessCert_ID = '$search_value'";
    } else {
        $sql .= " AND (bc.Business_owner LIKE '%" . addslashes($search_value) . "%' OR bc.Businessname LIKE '%" . addslashes($search_value) . "%')";
    }
}

if (!empty($street_id)) {
    $sql .= " AND bc.Location = $street_id";
}

$sql .= " ORDER BY bc.BusinessCert_ID ASC";

$result = $con->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $purpose = htmlspecialchars($row['Purpose'], ENT_QUOTES);
        $purpose = str_replace("'", "&#39;", $purpose);
        $businessName = htmlspecialchars($row['Businessname'], ENT_QUOTES);
        $businessName = str_replace("'", "&#39;", $businessName);
        echo "<tr>
                <td>{$row['BusinessCert_ID']}</td>
                <td>{$row['Business_owner']}</td>
                <td>{$businessName}</td>
                <td>{$row['Location']}</td>
                <td>{$purpose}</td>
                <td>{$row['Date_issued']}</td>            
                <td> 
                    <button class='Green' onclick='redirectToBusinessForm(\"" . addslashes($row['Business_owner']) . "\", \"" . $businessName . "\", \"" . addslashes($row['Location']) . "\", \"" . $purpose . "\", \"" . addslashes($row['Date_issued']) . "\")'>Generate</button> 
                </td>
            </tr>"; 
    }
} else {
    echo "<tr><td colspan='7'>No results found</td></tr>";
}

$con->close();
?>


<script>
    function redirectToBusinessForm(owner, businessName, location, purpose, dateIssued) {
    console.log("Owner:", owner);
    console.log("businessName:", businessName);
    console.log("Location:", location);
    console.log("Purpose:", purpose);
    console.log("Date Issued:", dateIssued);

    window.location.href = `businessForm.php?owner=${encodeURIComponent(owner)}&businessName=${encodeURIComponent(businessName)}&location=${encodeURIComponent(location)}&purpose=${encodeURIComponent(purpose)}&dateIssued=${encodeURIComponent(dateIssued)}`;
}
</script>
