<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Website</title>
    <link rel="stylesheet" type="text/css" href="http://localhost/BrgyMalinao/Frontend/CSS/register.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
</head>
<?php
include 'C:\XAMPP\htdocs\BrgyMalinao\Backend\PHP\database.php';
$query = "SELECT Logo FROM logo";
$result = mysqli_query($con, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $logo = base64_encode($row['Logo']);
} else {
    echo "Error: " . mysqli_error($con);
}

?>
<body>
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
    <body>
    <div class="form-container">
        <div class="form-header">
            <div class="step active" id="step1-header">Step 1</div>
            <div class="step" id="step2-header">Step 2</div>
            <div class="step" id="step3-header">Step 3</div>
        </div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <div class="form-step active" id="step1">
                <h2>Register Here</h2>
                <br> <br>
                <div class="input-row names">
                    <div>
                        <label for="firstname">First Name</label>
                        <input type="text" id="firstname" name="firstname">
                    </div>
                    <div>
                        <label for="middlename">Middle Name</label>
                        <input type="text" id="middlename" name="middlename">
                    </div>
                    <div>
                        <label for="surname">Last Name</label>
                        <input type="text" id="surname" name="surname">
                    </div>
                    <div>
                        <label for="suffix">Suffix</label>
                        <input type="text" id="suffix" name="suffix">
                    </div>
                </div>
                <div class="input-row">
                    <div>
                        <label for="gender">Gender:</label>
                        <select id="gender" name="gender">
                        <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="LGTBQIA+">LGTBQIA+</option>
                        </select>
                    </div>
                    <div>
                        <label for="birthdate">Birthdate:</label>
                        <input type="date" id="birthdate" name="birthdate">
                    </div>
                    <div>
                        <label for="birthplace">Birthplace:</label>
                        <input type="text" id="birthplace" name="birthplace">
                    </div>
                </div>
                <div class="input-row">
                    <div>
                        <label for="civil_status">Civil Status:</label>
                        <select id="civil_status" name="civil_status">
                            <option value="single">Single</option>
                            <option value="married">Married</option>
                            <option value="widowed">Widowed</option>
                            <option value="separated">Separated</option>
                        </select>
                    </div>
                    <div>
                        <label for="years_in_barangay">Years in Barangay:</label>
                        <input type="number" id="years_in_barangay" name="years_in_barangay" required>
                    </div>
                </div>
                <button type="button" onclick="nextStep(2)">Next</button>
            </div>
            
            <div class="form-step" id="step2" style="display:none;">
            <div class="input-row">
    <div>
        <label for="house_type">House Type:</label>
        <select id="house_type" name="house_type" required>
        <option value="">Select house type</option>
        <option value="Owned">Owned</option>
        <option value="Rented">Rented</option>
        </select>
    </div>
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
<br>
<div class="input-row">
        <div>
            <label for="voter_status">Voter Status (Y/N):</label><br>
            <select id="voter_status" name="voter_status" onchange="toggleVoterFields()" required>
                <option value="">Select Voter Status</option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select><br><br>
        </div>
        
        <div id="voters_precinct_no_field" class="hidden">
            <label for="voters_precinct_no">Voters Precinct No:</label><br>
            <input type="text" id="voters_precinct_no" name="voters_precinct_no"><br><br>
        </div>

        <div id="voters_id_field" class="hidden">
            <label for="voters_id">Voters ID:</label><br>
            <input type="file" id="voters_id" name="voters_id"><br>
        </div>
</div>

    <div class="input-row">
        <div>
            <label for="ifpwd">PWD (Y/N):</label><br>
                <select id="ifpwd" name="ifpwd" onchange="togglePWDIDSection()" required>
                    <option value="">Select PWD Status</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
        </div>

        <div id="pwd_id_section" class="hidden">
            <label for="PWD_id">PWD ID:</label><br>
            <input type="file" id="PWD_id" name="PWD_id"><br>
        </div>
    </div>


<div id="pwd_id_section" class="hidden">
    <div class="input-row">
        <div>
            <label for="pwd_id">PWD ID:</label>
            <input type="file" id="pwd_id" name="pwd_id">
        </div>
    </div>
</div>

<div class="button-container">
    <button type="button" onclick="prevStep(1)">Previous</button>
    <button type="button" onclick="nextStep(3)">Next</button>
</div>

            </div>
            <div class="form-step" id="step3" style="display:none;">
                <label for="contact_number">Contact Number:</label>
                <input type="number" id="contact_number" name="contact_number" required><br><br>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required><br><br>

                <label for="valid_id">Valid ID:</label>
                <input type="file" id="valid_id" name="valid_id"><br>
                <div class="idlist"> 
                    <p>ACCEPTED ID</p> <BR>
                    <p>*National Identity Card</p>
                    <p>*Drivers License</p>
                    <p>*Student ID</p>
                    <p>*Passport</p>
                </div>
                <div class="button-container">
                <button type="button" onclick="prevStep(2)">Previous</button>
                <button type="submit">Submit</button>
                </div>
            </div>
            
        </form>
    </div>
    <script src="http://localhost/BrgyMalinao/Frontend/JS/registerFuntion.js"></script>
    <script src="http://localhost/BrgyMalinao/Frontend/JS/register.js"></script>
    </body>
    <footer>
        <p>Copyright © Progresibong Barangay Malinao - 2024, All Rights Reserved</p>
    </footer>


    <?php
        include 'C:\XAMPP\htdocs\BrgyMalinao\Backend\PHP\database.php';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            $firstname = $_POST['firstname'];
            $middlename = $_POST['middlename'];
            $surname = $_POST['surname'];
            $suffix = $_POST['suffix'];
            $gender = $_POST['gender'];
            $birthdate = $_POST['birthdate'];
            $birthplace = $_POST['birthplace'];
            $civil_status = $_POST['civil_status'];
            $house_no = $_POST['household_no'];
            $street = $_POST['street'];
            $years_in_barangay = $_POST['years_in_barangay'];
            $house_type = $_POST['house_type'];
            $voter_status = $_POST['voter_status'];
            $voters_precinct_no = isset($_POST['voters_precinct_no']) ? $_POST['voters_precinct_no'] : null;
            $ifpwd = $_POST['ifpwd'];
            $contact_number = $_POST['contact_number'];
            $email = $_POST['email'];

            $valid_id_path = null;
            $voters_id_path = null;
            $PWD_id_path = null;
            
            if (isset($_FILES['valid_id']) && $_FILES['valid_id']['error'] === UPLOAD_ERR_OK) {
                $valid_id_path = file_get_contents($_FILES['valid_id']['tmp_name']);
            }
            
            if (isset($_FILES['voters_id']) && $_FILES['voters_id']['error'] === UPLOAD_ERR_OK) {
                $voters_id_path = file_get_contents($_FILES['voters_id']['tmp_name']);
            }
            
            if (isset($_FILES['PWD_id']) && $_FILES['PWD_id']['error'] === UPLOAD_ERR_OK) {
                $PWD_id_path = file_get_contents($_FILES['PWD_id']['tmp_name']);
            }

            $stmt = $con->prepare("INSERT INTO resident_applicants (Firstname, Middlename, Surname, Suffix, Gender, Birthdate, Birthplace, Civil_Status, Household_No, Street, Years_In_Barangay, HouseType, Voter_Status, Voters_Precinct_No, IfPWD, Contact_Number, Email, Valid_ID, Voters_ID, PWD_ID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            if ($stmt === false) {
                die('Prepare failed: ' . htmlspecialchars($con->error));
            }
        
            $stmt->bind_param("ssssssssssssssssssss", $firstname, $middlename, $surname, $suffix, $gender, $birthdate, $birthplace, $civil_status, $house_no, $street, $years_in_barangay, $house_type, $voter_status, $voters_precinct_no, $ifpwd, $contact_number, $email, $valid_id_path, $voters_id_path, $PWD_id_path);

            if ($stmt->execute()) {
                echo "<script>alert('Application submitted successfully');</script>";
            } else {
                echo "<script>alert('Error: " . $stmt->error . "');</script>";
            }

            $stmt->close();
            $con->close();
        }
        ?>

    </body>
    </html>

