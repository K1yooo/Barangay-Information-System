<?php
include 'database.php';

if (isset($_POST['archive_official_id'])) {
       
    $official_id = $_POST['archive_official_id'];

    $stmt = $con->prepare("CALL Archive_officials(?)");
    $stmt->bind_param("i", $official_id);

    if ($stmt->execute()) {
        echo "Official archived successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();

} 
$positions = [];
$result = mysqli_query($con, "SELECT * FROM position");
while ($row = mysqli_fetch_assoc($result)) {
    $positions[] = $row;
}

$officials = [];
$result = mysqli_query($con, "SELECT o.*, p.Position, CONCAT_WS(' ', o.Firstname, COALESCE(o.Middlename, ''), o.Lastname, COALESCE(o.Suffix, '')) AS Fullname FROM officials o JOIN position p ON o.Position_ID = p.Position_ID");
while ($row = mysqli_fetch_assoc($result)) {
    $officials[] = $row;
}

$position_order = [
    'Barangay Captain' => 1,
    'Barangay Councilor 1' => 2,
    'Barangay Councilor 2' => 3,
    'Barangay Councilor 3' => 4,
    'Barangay Councilor 4' => 5,
    'Barangay Councilor 5' => 6,
    'Barangay Councilor 6' => 7,
    'Barangay Councilor 7' => 8,
    'Barangay Secretary' => 9,
    'Barangay Treasurer' => 10,
    'Barangay SK Chairman' => 11,
    'SK Councilor' => 12
];

usort($officials, function ($a, $b) use ($position_order) {
    return $position_order[$a['Position']] <=> $position_order[$b['Position']];
});


?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Officials</title>
    <link rel="stylesheet" href="/BrgyMalinao/Backend/CSS/Official.css">
</head>
<body>

    <div id="barangayOfficialsModal" class="modal1">
        <div class="modal-content1">
            <div class="col">
                <div class="bg1">
                    <span class="txt1">Barangay <br> Officials</span>
                </div>
            </div>
            <div class="col">
                <span class="close-btn" onclick="closeModal('barangayOfficialsModal')">&times;</span>
                <button class="button1" onclick="openModal('addModal')">Add</button>
                <div class="Scrollable-table">
                    <table>
                        <thead>
                            <tr>
                                <th>Position</th>
                                <th>Full Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="officialsTableBody">
                            <?php foreach ($officials as $official): ?>
                                <tr>
                                    <td><?php echo $official['Position']; ?></td>
                                    <td><?php echo $official['Fullname']; ?></td>
                                    <td>
                                        <button class="button-blue" onclick="openUpdateModalForOfficials(
                                            '<?php echo addslashes($official['Official_ID']); ?>',
                                            '<?php echo addslashes($official['Position_ID']); ?>',
                                            '<?php echo addslashes($official['Firstname']); ?>',
                                            '<?php echo addslashes($official['Middlename']); ?>',
                                            '<?php echo addslashes($official['Lastname']); ?>',
                                            '<?php echo addslashes($official['Suffix']); ?>',
                                            '<?php echo addslashes($official['Gender']); ?>',
                                            '<?php echo addslashes($official['Birthdate']); ?>',
                                            '<?php echo addslashes($official['Contact_Number']); ?>',
                                            '<?php echo addslashes($official['Email']); ?>'
                                            )">Update</button>
                                        <button class="button-red" onclick="archiveOfficial(<?php echo $official['Official_ID']; ?>)">Archive</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

   
    <div id="addModal" class="modal2">
        <div class="modal-content2">
        <div class="col">
                <div class="bg1">
                    <span class="txt2">Barangay <br> Officials <br><br> Add</span>
                </div>
            </div>
            <div class="col">
                <span class="close-btn" onclick="closeModal('addModal')">&times;</span>
                <form id="addOfficialForm" action="addOfficial.php" method="post" enctype="multipart/form-data">
                    <div class="MoveAdd">
                        <div class="row1">
                            <div class="form-group">
                                <label for="add-position">Position:</label> <br>
                                <select  class="off-pos" id="add-position" name="position" required>
                                    <?php foreach ($positions as $position): ?>
                                        <option value="<?php echo $position['Position_ID']; ?>"><?php echo $position['Position']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="update-image">Official Image:</label><br>
                                <input type="file" id="official-image" name="image">
                            </div>
                        </div>

                        <div class="row1">              
                            <div class="form-group">
                                <label for="add-surname">Surname:</label> <br>
                                <input type="text" id="add-surname" name="lastname" required>
                            </div>
                            <div class="form-group">
                                <label for="add-firstname">Firstname:</label> <br>
                                <input type="text" id="add-firstname" name="firstname" required>
                            </div>
                            <div class="form-group">
                                <label for="add-middlename">Middlename:</label> <br>
                                <input type="text" id="add-middlename" name="middlename">
                            </div>
                        </div>

                        <div class="row1">
                            <div class="form-group">
                                <label for="add-suffix">Suffix:</label> <br>
                                <input type="text" id="add-suffix" name="suffix">
                            </div>
                            <div class="form-group">
                                <label for="add-birthdate">Birthdate:</label> <br>
                                <input type="date" id="add-birthdate" name="birthdate">
                            </div>
                            <div class="form-group">
                                <label for="update-gender">Gender:</label><br>
                                <select id="update-gender" name="gender">
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row1">
                            <div class="form-group">
                                <label for="add-contact">Contact Number:</label> <br>
                                <input type="number" id="add-contact" name="contact">
                            </div>
                            <div class="form-group">
                                <label for="add-email">Email:</label> <br>
                                <input type="email" id="add-email" name="email">
                            </div>
                        </div>

                        <div class="action-buttons1">
                            <button type="button" class="cancel-button" onclick="closeModal('addModal')">Cancel</button>
                            <input type="reset" value="Clear" class="button">
                            <input type="submit" value="Add" class="button">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

   
    <div id="updateModal1" class="modal3">
        <div class="modal-content3">
            <div class="col">
                <div class="bg1">
                    <span class="txt1">Barangay <br> Officials <br><br> Update</span>
                </div>
            </div>
            <div class="col">
                <span class="close-btn" onclick="closeModal('updateModal1')">&times;</span>
                <form id="updateOfficialForm1" action="updateOfficial.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" id="update-id" name="official_id">
                    <div class="MoveUpt">
                        <div class="row1">
                            <div class="form-group">
                                <label for="update-position">Position:</label><br>
                                <select class="off-pos" id="update-position" name="position" required>
                                    <?php foreach ($positions as $position): ?>
                                        <option value="<?php echo $position['Position_ID']; ?>"><?php echo $position['Position']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="update-image">Official Image:</label><br>
                                <input type="file" id="update-image" name="image">
                            </div>
                        </div>

                        <div class="row1">
                            <div class="form-group">
                                <label for="update-surname">Surname:</label><br>
                                <input type="text" id="update-surname" name="lastname" required>
                            </div>
                            <div class="form-group">
                                <label for="update-firstname">Firstname:</label><br>
                                <input type="text" id="update-firstname" name="firstname" required>
                            </div>
                            <div class="form-group">
                                <label for="update-middlename">Middlename:</label><br>
                                <input type="text" id="update-middlename" name="middlename">
                            </div>
                        </div>

                        <div class="row1">
                            <div class="form-group">
                                <label for="update-suffix">Suffix:</label><br>
                                <input type="text" id="update-suffix" name="suffix">
                            </div>
                            <div class="form-group">
                                <label for="update-birthdate">Birthdate:</label><br>
                                <input type="date" id="update-birthdate" name="birthdate">
                            </div>
                            <div class="form-group">
                                <label for="update-gender">Gender:</label><br>
                                <select id="update-gender" name="gender">
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row1">
                            <div class="form-group">
                                <label for="update-contact">Contact Number:</label><br>
                                <input type="number" id="update-contact" name="contact">
                            </div>
                            <div class="form-group">
                                <label for="update-email">Email:</label><br>
                                <input type="email" id="update-email" name="email">
                            </div>
                        </div>

                        <div class="action-buttons1">
                            <button type="button" class="cancel-button" onclick="closeModal('updateModal1')">Cancel</button>
                            <input type="reset" value="Clear" class="button">
                            <input type="submit" value="Update" class="button">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function showAlert() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('status')) {
                const status = urlParams.get('status');
                if (status === 'added') {
                    alert('Official added successfully.');
                } else if (status === 'updated') {
                    alert('Official updated successfully.');
                } else if (status === 'error') {
                    alert('There was an error processing your request.');
                }
            }
        }

        window.onload = showAlert;

        function openModal(modalId) {
            document.getElementById(modalId).style.display = 'block';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        function openUpdateModalForOfficials(id, position, firstname, middlename, lastname, suffix, gender, birthdate, contact, email) {
            document.getElementById('update-id').value = id;
            document.getElementById('update-position').value = position;
            document.getElementById('update-firstname').value = firstname;
            document.getElementById('update-middlename').value = middlename;
            document.getElementById('update-surname').value = lastname;
            document.getElementById('update-suffix').value = suffix;
            document.getElementById('update-gender').value = gender;
            document.getElementById('update-birthdate').value = birthdate;
            document.getElementById('update-contact').value = contact;
            document.getElementById('update-email').value = email;
            openModal('updateModal1');
        }

        function archiveOfficial(id) {
        if (confirm('Are you sure you want to archive this official?')) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    alert('Official archived successfully.');
                    location.reload(); 
                }
            };
            xhttp.open('POST', 'officialsModal.php', true);
            xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhttp.send('archive_official_id=' + id);
        }
    }

    </script>

</body>
</html>