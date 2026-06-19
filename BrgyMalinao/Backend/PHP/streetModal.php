<?php
include 'database.php';


function fetchStreets($con) {
    $streets = [];
    $stmt = $con->prepare("SELECT * FROM street_name");
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $streets[] = $row;
    }
    return $streets;
}


function deleteStreet($con, $streetID) {
    $sql = "DELETE FROM street_name WHERE Street_ID = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $streetID);
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['streetHOA']) && isset($_POST['ifHOA'])) {
    $streetHOA = $_POST['streetHOA'];
    $ifHOA = $_POST['ifHOA'];
    
    
    if (isset($_POST['addStreet'])) {
        $sql = "INSERT INTO street_name (StreetHOA, ifHOA) VALUES (?, ?)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ss", $streetHOA, $ifHOA);
        if ($stmt->execute()) {
            echo "<script>alert('Street added successfully'); window.location.href = 'http://localhost/brgymalinao/Backend/PHP/Settings.php#';</script>";
        } else {
            echo "<script>alert('Error: " . $stmt->error . "'); window.location.href = 'http://localhost/brgymalinao/Backend/PHP/Settings.php#';</script>";
        }
    }

    if (isset($_POST['updateStreet'])) {
        $id = $_POST['id'];
        $sql = "UPDATE street_name SET StreetHOA=?, ifHOA=? WHERE Street_ID=?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ssi", $streetHOA, $ifHOA, $id);
        if ($stmt->execute()) {
            echo "<script>alert('Street updated successfully'); window.location.href = 'http://localhost/brgymalinao/Backend/PHP/Settings.php';</script>";
        } else {
            echo "<script>alert('Error: " . $stmt->error . "'); window.location.href = 'http://localhost/brgymalinao/Backend/PHP/Settings.php';</script>";
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteStreet'])) {
    $streetID = $_POST['deleteStreet'];
    $success = deleteStreet($con, $streetID);
    if ($success) {
        echo "<script>alert('Street deleted successfully'); window.location.href = 'http://localhost/brgymalinao/Backend/PHP/Settings.php#';</script>";
    } else {
        echo "<script>alert('Error: Failed to delete street'); window.location.href = 'http://localhost/brgymalinao/Backend/PHP/Settings.php#';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Streets and HOAs</title>
    <link rel="stylesheet" type="text/css" href="http://localhost/BrgyMalinao/Backend/CSS/streetModal.css">
    <link rel="stylesheet" type="text/css" href="http://localhost/BrgyMalinao/Backend/CSS/SideBar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>
<body>

    <!-- Barangay Streets Modal -->
    <div id="streetSettingsModal" class="modal4" style="display: none";>
        <div class="modal-content4">
            <div class="col4">
                <div class="bg4">
                    <span class="txt4">Barangay <br> Streets and HOAs</span>
                </div>
            </div>
            <div class="col4">
                <span class="close-btn4" onclick="closeModal('streetSettingsModal')">&times;</span>
                <button class="button4" onclick="showAddForm()">Add</button>
                <?php if ($message): ?>
                    <p><?php echo $message; ?></p>
                <?php endif; ?>
                <div class="table-container4">
                    <div class="Scrollable-table4">
                        <table>
                            <thead>
                                <tr>
                                    <th>streetHOA Name</th>
                                    <th>If HOA</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="streetsTableBody4">
                                <?php foreach (fetchStreets($con) as $street): ?>
                                    <tr>
                                        <td><?php echo $street['StreetHOA']; ?></td>
                                        <td><?php echo $street['ifHOA']; ?></td>
                                        <td>
                                            <button class="button-blue" onclick="openUpdateModal('<?php echo $street['Street_ID']; ?>', '<?php echo $street['StreetHOA']; ?>', '<?php echo $street['ifHOA']; ?>')">Update</button>
                                            <form method="post" style="display: inline;">
                                                <input type="hidden" name="deleteStreet" value="<?php echo $street['Street_ID']; ?>">
                                                <button type="submit" class="button-red" onclick="return confirmDelete()">X</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add streetHOA Form -->
    <div id="addForm" class="modal5" style="display: none";>
        <div class="modal-content5">
            <div class="col4">
                <div class="bg4">
                    <span class="txt4">Street HOA <br><br> Add </span>
                </div>
            </div>
            <div class="col4">
                <span class="close-btn4" onclick="hideAddForm()">&times;</span>
                <div class="align">
                    <form id="addStreetForm" method="post">
                        <div class="form-group">
                            <label for="streetHOA" class="lbl4">Street HOA Name:</label> <br><br>
                            <input type="text" id="add-streetHOA" name="streetHOA" required>
                        </div><br><br>
                        <div class="form-group">
                            <label for="ifHOA" class="lbl4">If HOA:</label><br><br>
                            <input type="text" id="add-ifHOA" name="ifHOA">
                        </div>
                </div>
                        <div class="action-buttons">
                            <button type="button" class="cancel-button4" onclick="hideAddForm()">Cancel</button>
                            <input type="submit" name="addStreet" value="Add" class="submit-button4">
                            <input type="reset" value="Clear" class="reset-button4">
                        </div>
                    </form>
                
            </div>
        </div>
    </div>

    <!-- Update streetHOA Form -->
    <div id="updateForm" class="modal5" style="display: none";>
        <div class="modal-content5">
            <div class="col4">
                <div class="bg4">
                    <span class="txt4">Street HOA <br><br> Update </span>
                </div>
            </div>
            <div class="col4">
                <span class="close-btn4" onclick="hideUpdateForm()">&times;</span>
                <div class="align">
                    <form id="updateStreetForm" method="post">
                        <input type="hidden" id="updateId" name="id">
                        <div class="form-group">
                            <label for="update-streetHOA">Street HOA Name:</label> <br><br>
                            <input type="text" id="update-streetHOA" name="streetHOA" required>
                        </div><br><br>
                        <div class="form-group">
                            <label for="update-ifHOA">If HOA:</label> <br><br>
                            <input type="text" id="update-ifHOA" name="ifHOA">
                        </div>
                </div>
                        <div class="action-buttons">
                            <button type="button" class="cancel-button5" onclick="hideUpdateForm()">Cancel</button>
                            <input type="submit" name="updateStreet" value="Update" class="update-button5">
                            <input type="reset" value="Clear" class="reset-button5">
                        </div>
                    </form>
                
            </div>
        </div>
    </div>

    <script>
        function showAddForm() {
            document.getElementById('addForm').style.display = 'flex';
        }

        function hideAddForm() {
            document.getElementById('addForm').style.display = 'none';
        }

        function openUpdateModal(id, streetHOA, ifHOA) {
            document.getElementById('updateId').value = id;
            document.getElementById('update-streetHOA').value = streetHOA;
            document.getElementById('update-ifHOA').value = ifHOA;
            document.getElementById('updateForm').style.display = 'flex';
            window.location.href = 'http://localhost/brgymalinao/Backend/PHP/Settings.php#';
        }

        function hideUpdateForm() {
            document.getElementById('updateForm').style.display = 'none';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }
        
        function confirmDelete() {
            return confirm("Are you sure you want to delete this street?");
        }
    </script>

</body>
</html>

