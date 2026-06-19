<?php
include 'database.php';

$update_successful = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["update"])) {
        $rs_id = $_POST['RS_ID'];
        $firstname = $_POST['Firstname'];
        $middlename = $_POST['Middlename'];
        $surname = $_POST['Surname'];
        $suffix = $_POST['Suffix'];
        $birthdate = $_POST['Birthdate'];
        $gender = $_POST['Gender'];
        $birthplace = $_POST['Birthplace'];
        $civil_status = $_POST['Civil_Status'];
        $years_in_barangay = $_POST['Years_In_Barangay'];
        $house_type = $_POST['HouseType'];
        $household_no = $_POST['Household_No'];
        $street = $_POST['Street'];
        $voter_status = $_POST['Voter_Status'];
        $voters_precinct_no = $_POST['Voters_Precinct_No'];
        $ifpwd = $_POST['IfPWD'];
        $contact_number = $_POST['Contact_Number'];
        $email = $_POST['Email'];

        $stmt = $con->prepare("UPDATE residents SET Firstname=?, Middlename=?, Surname=?, Suffix=?, Birthdate=?, Gender=?, Birthplace=?, Civil_Status=?, Years_In_Barangay=?, HouseType=?, Household_No=?, Street=?, Voter_Status=?, Voters_Precinct_No=?, IfPWD=?, Contact_Number=?, Email=? WHERE RS_ID=?");
        $stmt->bind_param("ssssssssississsssi", $firstname, $middlename, $surname, $suffix, $birthdate, $gender, $birthplace, $civil_status, $years_in_barangay, $house_type, $household_no, $street, $voter_status, $voters_precinct_no, $ifpwd, $contact_number, $email, $rs_id);
        
        if ($stmt->execute()) {
            $update_successful = true;
        } else {
            echo "Error updating record: " . $stmt->error;
        }
        $stmt->close();
    }
}

$id = isset($_GET["rs_id"]) ? $_GET["rs_id"] : '';
$sql = "SELECT r.RS_ID, r.Firstname, r.Middlename, r.Surname, r.Suffix, r.Birthdate, r.Gender, r.Birthplace, r.Civil_Status, r.Years_In_Barangay, r.HouseType, r.Household_No, sn.streetHOA AS Street, r.Contact_Number, r.Email, r.Voter_Status, r.Voters_Precinct_No, r.IfPWD, r.Date_Created 
        FROM residents r
        INNER JOIN street_name sn ON r.Street = sn.Street_ID
        WHERE r.RS_ID = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$stmt->close();

$birthdate = new DateTime($row['Birthdate']);
$now = new DateTime();
$age = $birthdate->diff($now)->y;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Resident</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="http://localhost/BrgyMalinao/Backend/CSS/EditResident.css">
    <link rel="stylesheet" type="text/css" href="http://localhost/BrgyMalinao/Backend/CSS/SideBar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <header>
        <button class="hamburger" id="hamburger">
            <i class="fas fa-bars"></i>
        </button>
        <div class="header-content">
            <div class="logo-container">
                <img src="http://localhost/BrgyMalinao/Backend/images/BbrgyMalinaoLogo.png" alt="Logo of Malinao">
                <span>Barangay Malinao, Pasig City</span>
            </div>
        </div>
    </header>

    <main>
        <nav id="sidebar">
            <ul class="top-links">
                <li><a href="Dashboard.php">
                    <i class="fa-solid fa-house"></i>
                    <span class="nav-item">Dashboard</span>
                </a></li>
                <li><a href="Pending.php">
                    <i class="fa-solid fa-hourglass-half"></i>
                    <span class="nav-item">Pending Registrations</span>
                </a></li>
                <li><a href="Resident.php">
                    <i class="fa-solid fa-users"></i>
                    <span class="nav-item">Resident List</span>
                </a></li>
                <li><a href="BarangayForms.php">
                    <i class="fa-solid fa-layer-group"></i>
                    <span class="nav-item">Barangay Forms</span>
                </a></li>
                <li><a href="Blotter.php">
                    <i class="fa-solid fa-book"></i>
                    <span class="nav-item">Blotter Report</span>
                </a></li>
                <li><a href="Settings.php">
                    <i class="fa-solid fa-gears"></i>
                    <span class="nav-item">System Settings</span>
                </a></li>
            </ul>
            <ul class="bottom-links">
                <li><a href="logout.php">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span class="nav-item">Log out</span>
                </a></li>
            </ul>
        </nav>

        <div class="First-container">
            <div class="Title">
                <span>Edit Resident Information</span>
                <button class="back-button" onclick="window.location.href='Resident.php'">Back</button>
            </div>
            <hr class="line-break">
        </div>

        <div class="InfoDes-Container">
            <div class="InfoDes">
                <form id="updateResidentForm" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <input type="hidden" name="RS_ID" value="<?php echo htmlspecialchars($id); ?>">
                    <div class="row1">
                        <div>
                            <label>Firstname:</label> <br>
                            <input type="text" value="<?php echo htmlspecialchars($row['Firstname'] ?? ''); ?>" name="Firstname" class="readonly-input">
                        </div>
                        <div>
                            <label>Middlename:</label><br>
                            <input type="text" value="<?php echo htmlspecialchars($row['Middlename'] ?? ''); ?>" name="Middlename" class="readonly-input">
                        </div>
                        <div>
                            <label>Surname:</label><br>
                            <input type="text" value="<?php echo htmlspecialchars($row['Surname'] ?? ''); ?>" name="Surname" class="readonly-input">
                        </div>
                        <div>
                            <label>Suffix:</label><br>
                            <input type="text" value="<?php echo htmlspecialchars($row['Suffix'] ?? ''); ?>" name="Suffix" class="readonly-input">
                        </div>
                    </div>
                    <div class="row1">
                        <div>
                            <label>Birthdate:</label><br>
                            <input type="date" value="<?php echo htmlspecialchars($row['Birthdate'] ?? ''); ?>" name="Birthdate" class="readonly-input" id="moveDate">
                        </div>
                        <div>
                            <label>Age:</label><br>
                            <input type="text" value="<?php echo htmlspecialchars($age ?? ''); ?>" readonly class="readonly-input">
                        </div>
                        <div>
                            <label>Gender:</label><br>
                            <input type="text" value="<?php echo htmlspecialchars($row['Gender'] ?? ''); ?>" name="Gender" class="readonly-input">
                        </div>
                        <div>
                            <label>Birthplace:</label><br>
                            <input type="text" value="<?php echo htmlspecialchars($row['Birthplace'] ?? ''); ?>" name="Birthplace" class="readonly-input">
                        </div>
                    </div>
                    <div class="row1">
                        <div>
                            <label>Civil Status:</label><br>
                            <input type="text" value="<?php echo htmlspecialchars($row['Civil_Status'] ?? ''); ?>" name="Civil_Status" class="readonly-input">
                        </div>
                        <div>
                            <label>Years in Barangay:</label><br>
                            <input type="number" value="<?php echo htmlspecialchars($row['Years_In_Barangay'] ?? ''); ?>" name="Years_In_Barangay" class="readonly-input">
                        </div>
                        <div>
                            <label>House Type:</label><br>
                            <input type="text" value="<?php echo htmlspecialchars($row['HouseType'] ?? ''); ?>" name="HouseType" class="readonly-input">
                        </div>
                        <div>
                            <label>Household No:</label><br>
                            <input type="text" value="<?php echo htmlspecialchars($row['Household_No'] ?? ''); ?>" name="Household_No" class="readonly-input">
                        </div>
                    </div>

                    <div class="row1">
                        <div>
                            <label>Street:</label><br>
                            <input type="text" value="<?php echo htmlspecialchars($row['Street'] ?? ''); ?>" name="Street" class="readonly-input">
                        </div>
                        <div>
                            <label>Voter Status:</label><br>
                            <input type="text" value="<?php echo htmlspecialchars($row['Voter_Status'] ?? ''); ?>" name="Voter_Status" class="readonly-input">
                        </div>
                        <div>
                            <label>Voters Precinct No:</label><br>
                            <input type="text" value="<?php echo htmlspecialchars($row['Voters_Precinct_No'] ?? ''); ?>" name="Voters_Precinct_No" class="readonly-input">
                        </div>
                        <div>
                            <label>PWD:</label><br>
                            <input type="text" value="<?php echo htmlspecialchars($row['IfPWD'] ?? ''); ?>" name="IfPWD" class="readonly-input">
                        </div>
                    </div>

                    <div class="row1">
                        <div>
                            <label>Contact Number:</label><br>
                            <input type="text" value="<?php echo htmlspecialchars($row['Contact_Number'] ?? ''); ?>" name="Contact_Number" class="readonly-input">
                        </div>
                        <div>
                            <label>Email:</label><br>
                            <input type="email" value="<?php echo htmlspecialchars($row['Email'] ?? ''); ?>" name="Email" class="readonly-input">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main> 
    <script src="http://localhost/BrgyMalinao/Backend/JS/SideBar.js"></script>
    <script>
        <?php if ($update_successful): ?>
        alert('Resident information updated successfully.');
        <?php endif; ?>
    </script>
</body>
</html>