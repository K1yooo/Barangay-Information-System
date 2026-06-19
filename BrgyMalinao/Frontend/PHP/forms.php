<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Malinao</title>
    <link rel="stylesheet" type="text/css" href="http://localhost/BrgyMalinao/Frontend/CSS/forms.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <script>
        function nextStep(step) {
            document.getElementById('step' + step).style.display = 'none';
            document.getElementById('step' + (step + 1)).style.display = 'block';
            document.getElementById('step' + step + '-header').classList.remove('active');
            document.getElementById('step' + (step + 1) + '-header').classList.add('active');
        }

        function prevStep(step) {
            document.getElementById('step' + (step + 1)).style.display = 'none';
            document.getElementById('step' + step).style.display = 'block';
            document.getElementById('step' + (step + 1) + '-header').classList.remove('active');
            document.getElementById('step' + step + '-header').classList.add('active');
        }

        function preventFormHeaderClick() {
            document.querySelectorAll('.form-header .step').forEach(function(step) {
                step.onclick = function() {
                    return false;
                };
            });
        }

        function toggleBarangayFormsSection() {
            var selectedForm = document.getElementById('barangay_forms').value;
            document.getElementById('barangay_clearance_section').style.display = 'none';
            document.getElementById('barangay_indigency_section').style.display = 'none';
            document.getElementById('barangay_residency_section').style.display = 'none';

            if (selectedForm === 'Barangay Clearance') {
                document.getElementById('barangay_clearance_section').style.display = 'block';
            } else if (selectedForm === 'Barangay Indigency') {
                document.getElementById('barangay_indigency_section').style.display = 'block';
            } else if (selectedForm === 'Barangay Residency') {
                document.getElementById('barangay_residency_section').style.display = 'block';
            }
        }

        window.onload = function() {
            preventFormHeaderClick();
            toggleBarangayFormsSection();
        };

        function toggleOtherPurpose(selectElement, sectionId) {
            var section = document.getElementById(sectionId);
            var otherInput = section.querySelector('.form-group.hidden');

            if (selectElement.value === 'other') {
                otherInput.style.display = 'block';
            } else {
                otherInput.style.display = 'none';
            }
        }
    </script>
</head>

<?php
include 'C:\xampp\htdocs\BrgyMalinao\Backend\PHP\database.php';

$query = "SELECT Logo FROM logo";
$result = mysqli_query($con, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $logo = base64_encode($row['Logo']);
} else {
    echo "Error: " . mysqli_error($con);
}

$showStep2 = false;
$rs_id = "";
$fullname = "";
$age = "";
$voters_status = "";
$address = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) {
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $surname = $_POST['surname'];
    $gender = $_POST['gender'];
    $birthdate = $_POST['birthdate'];

    $query = "SELECT r.RS_ID, 
                 CONCAT(r.Firstname, ' ', r.Middlename, ' ', r.Surname) AS Fullname, 
                 TIMESTAMPDIFF(YEAR, r.Birthdate, CURDATE()) AS Age, 
                 r.Voter_Status, 
                 CONCAT(r.Household_No, ', ', sn.`StreetHOA`) AS Address 
          FROM residents r 
          JOIN street_name sn ON r.Street = sn.Street_ID 
          WHERE r.Firstname = '$firstname' 
            AND r.Middlename = '$middlename' 
            AND r.Surname = '$surname' 
            AND r.Gender = '$gender' 
            AND r.Birthdate = '$birthdate'";


    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $rs_id = $row['RS_ID'];
        $fullname = $row['Fullname'];
        $age = $row['Age'];
        $voters_status = $row['Voter_Status'];
        $address = $row['Address'];
        $showStep2 = true;
    } else {
        echo "<div class='warning'>
                <p>No matching resident found. Please register.</p>
                <button onclick=\"window.location.href='register.php'\">Register Now</button>
              </div>";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $rs_id = $_POST['rs_id'];
    $selectedForm = $_POST['barangay_forms'];
  
    $query = ""; 
  
    if ($selectedForm === 'Barangay Clearance') {
        $bc_purpose = $_POST['clearance_purpose'] ?: $_POST['barangay_clearance_form'];
        $stmt = $con->prepare("INSERT INTO barangay_clearance (RS_ID, Purpose) VALUES (?, ?)");
        $stmt->bind_param("ss", $rs_id, $bc_purpose);
    } elseif ($selectedForm === 'Barangay Residency') {
        $br_purpose = $_POST['residency_purpose'] ?: $_POST['barangay_residency_form'];
        $stmt = $con->prepare("INSERT INTO barangay_residency (RS_ID, Purpose) VALUES (?, ?)");
        $stmt->bind_param("ss", $rs_id, $br_purpose);
    } elseif ($selectedForm === 'Barangay Indigency') {
    $bi_patient = $_POST['indigency_patient'];
    $bi_age = !empty($_POST['patient_age']) ? intval($_POST['patient_age']) : null;  
    $bi_purpose = $_POST['indigency_purpose'] ?: $_POST['barangay_indigency_form'];

    if ($bi_age !== null) {
        $stmt = $con->prepare("INSERT INTO barangay_indigency (RS_ID, Fullname, Age, Purpose) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssis", $rs_id, $bi_patient, $bi_age, $bi_purpose);  
    } else {
        $stmt = $con->prepare("INSERT INTO barangay_indigency (RS_ID, Fullname, Age, Purpose) VALUES (?, ?, NULL, ?)");
        $stmt->bind_param("sss", $rs_id, $bi_patient, $bi_purpose); 
    }

    if ($stmt->execute()) {
        echo "<script>alert('Form submitted successfully!');</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}
    $con->close();

}
?> 

<body>
    <main>
<header>
        <div class="logo-container">
            <img src="data:image/png;base64,<?php echo $logo; ?>" alt="Logo of Malinao">
            <span>Barangay Malinao, Pasig City</span>
        </div>
        <nav>
      <input type="checkbox" id="check">
      <label for="check" class="checkbtn">
        <i class="fas fa-bars"></i>
      </label>
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="Aboutus.php">About Us</a></li>
                <li><a href="officials.php">Barangay Officials</a></li>
                <li><a href="contact.php">Contact Us</a></li>
            </ul>
        </nav>
    </header> 

<div class="form-container">
    <div class="form-header">
        <div class="step <?php echo !$showStep2 ? 'active' : ''; ?>" id="step1-header">Step 1</div>
        <div class="step <?php echo $showStep2 ? 'active' : ''; ?>" id="step2-header">Step 2</div>
    </div>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
        <div class="form-step <?php echo !$showStep2 ? 'active' : ''; ?>" id="step1" style="display:<?php echo !$showStep2 ? 'block' : 'none'; ?>;">
            <h2 style="text-align: center">Barangay Form</h2>
            <span style="text-align: center">Only for registered residents of Barangay Malinao</span>
            <br><br>
            <div class="input-row names">
                <div>
                    <label for="firstname">First Name</label>
                    <input type="text" id="firstname" name="firstname" required>
                </div>
                <div>
                    <label for="middlename">Middle Name</label>
                    <input type="text" id="middlename" name="middlename" required>
                </div>
                <div>
                    <label for="surname">Last Name</label>
                    <input type="text" id="surname" name="surname" required>
                </div>
            </div>
            <div class="input-row">
                <div>
                    <label for="gender">Gender:</label>
                    <select id="gender" name="gender" required>
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div>
                    <label for="birthdate">Birthdate:</label>
                    <input type="date" id="birthdate" name="birthdate" required>
                </div>
            </div>
            <div class="input-row">
                <div>
                    <label for="household_no">Household No:</label>
                    <input type="number" id="household_no" name="household_no" required>
                </div>
                <div>
                    <label for="street">Street:</label>
                    <select id="street" name="street" required>
                        <option value="">Select a street</option>
                        <option value="3001">Magdalena Subdivision</option>
                        <option value="3002">Dona Binday Subdivision</option>
                        <option value="3003">Callejon 45</option>
                        <option value="3004">Farmers Avenue</option>
                        <option value="3005">Divine Mercy</option>
                        <option value="3006">M. Bukid</option>
                        <option value="3007">Vicper</option>
                        <option value="3008">Green Palm</option>
                        <option value="3009">Red Palm</option>
                        <option value="3010">A. Luna</option>
                        <option value="3011">G. Raymundo</option>
                        <option value="3012">E. Jacinto</option>
                        <option value="3013">F. Manalo</option>
                        <option value="3014">Caruncho Avenue</option>
                        <option value="3015">M.Santos</option>
                    </select>
                </div>
            </div>
        <div>
                <button type="submit" name="search">Search</button>
            </div>
            <?php
           if (isset($_POST["search"])) {
            $result = mysqli_query($con, $query);

            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $rs_id = $row['RS_ID'];
                $fullname = $row['Fullname'];
                $age = $row['Age'];
                $voters_status = $row['Voter_Status'];
                $address = $row['Address'];
                $showStep2 = true;
            } else {
                echo "<div class='warning'>
                        <p>No matching resident found. Please register.</p>
                        <button onclick=\"window.location.href='register.php'\">Register Now</button>
                    </div>";
            }
        }
        ?>
        </div>
    </form>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">


        <div class="form-step <?php echo $showStep2 ? 'active' : ''; ?>" id="step2" style="display:<?php echo $showStep2 ? 'block' : 'none'; ?>;">
            <input type="hidden" name="rs_id" value="<?php echo $rs_id; ?>">
            <h2 style="text-align: center">Barangay Forms</h2>
            <br><br>

            <div class="input-row">
                <div>
                    <label for="fullname">Full Name</label>
                    <input type="text" id="fullname" name="fullname" value="<?php echo $fullname; ?>" readonly>
                </div>
                <div>
                    <label for="age">Age</label>
                    <input type="text" id="age" name="age" value="<?php echo $age; ?>" readonly>
                </div>
                <div>
                    <label for="voters_status">Voter Status</label>
                    <input type="text" id="voters_status" name="voters_status" value="<?php echo $voters_status; ?>" readonly>
                </div>
                <div>
                    <label for="address">Address</label>
                    <input type="text" id="address" name="address" value="<?php echo $address; ?>" readonly><br>
                </div>
            </div>
            
    <form method="POST">
    <div>
        <label for="barangay_forms">Select Barangay Forms</label>
        <select id="barangay_forms" name="barangay_forms" onchange="toggleBarangayFormsSection()">
            <option value="">----</option>
            <option value="Barangay Clearance">Barangay Clearance</option>
            <option value="Barangay Indigency">Barangay Indigency</option>
            <option value="Barangay Residency">Barangay Residency</option>
        </select><br>
    </div>

<!-- Barangay Clearance Section -->
<div id="barangay_clearance_section" class="hidden">
    <div class="form-group">
        <label for="barangay_clearance_form">Purpose:</label><br>
        <select id="barangay_clearance_form" name="barangay_clearance_form" onchange="toggleOtherPurpose(this, 'barangay_clearance_section')">
            <option value="Senior Citizen Landbank">Senior Citizen Landbank</option>
            <option value="Business Permit">Business Permit</option>
            <option value="Employment Requirements">Employment Requirements</option>
            <option value="other">Other</option>
        </select>
    </div>
    <div class="form-group hidden">
        <label for="clearance_purpose">Please specify:</label><br>
        <input type="text" id="clearance_purpose" name="clearance_purpose">
    </div>
</div>

<!-- Barangay Indigency Section -->
<div id="barangay_indigency_section" class="hidden">
    <div class="form-group">
        <label for="indigency_patient">Patient Name:</label><br>
        <input type="text" id="indigency_patient" name="indigency_patient"><br>
        <label for="patient_age">Age:</label><br>
        <input type="text" id="patient_age" name="patient_age"><br>
        <label for="barangay_indigency_form">Purpose:</label><br>
        <select id="barangay_indigency_form" name="barangay_indigency_form" onchange="toggleOtherPurpose(this, 'barangay_indigency_section')">
            <option value="Access to Healthcare">Access to Healthcare</option>
            <option value="Housing Assistance">Housing Assistance</option>
            <option value="Legal Aid">Legal Aid</option>
            <option value="Social Welfare Program">Social Welfare Program</option>
            <option value="other">Other</option>
        </select>
    </div>
    <div class="form-group hidden">
        <label for="indigency_purpose">Please specify:</label><br>
        <input type="text" id="indigency_purpose" name="indigency_purpose">
    </div>
</div>

<!-- Barangay Residency Section -->
<div id="barangay_residency_section" class="hidden">
    <div class="form-group">
        <label for="barangay_residency_form">Purpose:</label><br>
        <select id="barangay_residency_form" name="barangay_residency_form" onchange="toggleOtherPurpose(this, 'barangay_residency_section')">
            <option value="Voter Registration">Voter Registration</option>
            <option value="School Requirements">School Requirements</option>
            <option value="Local Employment">Local Employment</option>
            <option value="other">Other</option>
        </select>
    </div>
    <div class="form-group hidden">
        <label for="residency_purpose">Please specify:</label><br>
        <input type="text" id="residency_purpose" name="residency_purpose">
    </div>
</div>

    <br>
    <div class="button-container">
        <button type="button" onclick="prevStep(1)">Previous</button>
        <button type="submit" name="submit">Submit</button>
    </div>
</form>
 </main>
<footer>
        <p>Copyright © Progresibong Barangay Malinao - 2024, All Rights Reserved</p>

    </footer>
</body>
</html>

