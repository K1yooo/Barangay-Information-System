<?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['contact_id'])) {
    $contact_id = mysqli_real_escape_string($con, $_POST['contact_id']);

    $stmt = $con->prepare("DELETE FROM contact_us WHERE Con_ID = ?");
    $stmt->bind_param("i", $contact_id);

    if ($stmt->execute()) {
        echo "Message deleted successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $con->close();
    exit; 
}

$sql = "SELECT Con_ID, Firstname, Lastname, Email, Contact_Number, Message FROM contact_us";
$result = $con->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="http://localhost/BrgyMalinao/Backend/CSS/contactModal.css">

    <script>
        function openModal(id) {
            document.getElementById(id).style.display = "block";
        }

        function closeModal(id) {
            document.getElementById(id).style.display = "none";
        }

        function deleteMessage(contactId) {
            if (confirm('Are you done with this message? It will be deleted.')) {
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        alert(this.responseText); 
                        location.reload(); 
                    }
                };
                xhttp.open('POST', 'contactModal.php', true); 
                xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhttp.send('contact_id=' + contactId);
            }
        }
    </script>
</head>
<body>

<!-- Contact Form Modal -->
<div id="contactSupportModal" class="modal8">
    <div class="modal-content8">
        <div class="col8">
            <div class="bg8">
                <span class="txt8">Contact <br> Us</span>
            </div>
        </div>
        <div class="col8">
            <span class="close-btn8" onclick="closeModal('contactSupportModal')">&times;</span>
            <div class="align8">
                <div class="Scrollable-table8">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Firstname</th>
                                <th>Lastname</th>
                                <th>Email</th>
                                <th>Contact Number</th>
                                <th>Message</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="contactTableBody">
                            <?php
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                            <td>" . $row["Con_ID"] . "</td>
                                            <td>" . $row["Firstname"] . "</td>
                                            <td>" . $row["Lastname"] . "</td>
                                            <td>" . $row["Email"] . "</td>
                                            <td>" . $row["Contact_Number"] . "</td>
                                            <td>" . $row["Message"] . "</td>
                                            <td><button class='button-green' onclick=\"deleteMessage(" . $row["Con_ID"] . ")\">Done</button></td>
                                          </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='7'>No records found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>

<?php
$con->close();
?>
