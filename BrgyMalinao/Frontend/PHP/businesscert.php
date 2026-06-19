<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Website</title>
    <link rel="stylesheet" type="text/css" href="http://localhost/BrgyMalinao/Frontend/CSS/businesscert.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <style>
        .form-step {
            display: none;
        }
        .form-step.active {
            display: block;
        }
    </style>
</head>
<?php
include 'C:\xampp\htdocs\BrgyMalinao\Backend\PHP\database.php';

// Fetch logo
$query = "SELECT Logo FROM logo";
$result = mysqli_query($con, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $logo = base64_encode($row['Logo']);
} else {
    echo "Error: " . mysqli_error($con);
}

// Fetch street names and IDs
$street_query = "SELECT street_id, streethoa FROM street_name";
$street_result = mysqli_query($con, $street_query);

$streets = [];
if ($street_result) {
    while ($row = mysqli_fetch_assoc($street_result)) {
        $streets[$row['street_id']] = $row['streethoa'];
    }
} else {
    echo "Error: " . mysqli_error($con);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $businessowner = $_POST['businessowner'];
    $businessname = $_POST['businessname'];
    $location = $_POST['location'];
    $purpose = $_POST['purpose'];

    $stmt = $con->prepare("INSERT INTO business_certification (Business_owner, Businessname, Location, Purpose) VALUES (?, ?, ?, ?)");
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($con->error));
    }

    $stmt->bind_param("ssss", $businessowner, $businessname, $location, $purpose);

    if ($stmt->execute()) {
        echo "<script>alert('Request submitted successfully');</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }

    $stmt->close();
    $con->close();
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
    <main>
        <section class="business-section">
            <div class="business-bg">
                <h3>Business Certificate</h3>
            </div>
        </section>

        <div class="business-container">
            <div class="business-header">
                <div class="step active" id="step1-header">Step 1</div>
                <div class="step" id="step2-header">Step 2</div>
            </div>

            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
                <div class="form-step active" id="step1">
                    <h2 style="text-align: center">Business Certificate Request</h2>
                    <br><br>
                    <div class="input-row names">
                        <div>
                            <label for="businessowner">Business Owner</label>
                            <input type="text" id="businessowner" name="businessowner" required>
                        </div>
                        <div>
                            <label for="businessname">Business Name</label>
                            <input type="text" id="businessname" name="businessname" required>
                        </div>
                        <div class="input-row names double">
                            <div>
                                <label for="location">Location</label>
                                <select id="location" name="location" required>
                                    <option value="">Select a street</option>
                                    <?php foreach ($streets as $street_id => $street_name) : ?>
                                        <option value="<?php echo $street_id; ?>"><?php echo $street_name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div>
                                <label for="purpose">Purpose</label>
                                <input type="text" id="purpose" name="purpose" required>
                            </div>
                        </div>
                    </div>
                    <button type="button" onclick="nextStep(1)">Next</button>
                </div>

                <div class="form-step" id="step2">
                    <h2 style="text-align: center">Check Your Information</h2>
                    <p>Please check the information you provided before submitting:</p> <br>
                    <center>
                        <div>
                            <label>Business Owner:</label>
                            <p id="displayBusinessOwner"></p>
                        </div>
                        <div>
                            <label>Business Name:</label>
                            <p id="displayBusinessName"></p>
                        </div>
                        <div>
                            <label>Location:</label>
                            <p id="displayLocation"></p>
                        </div>
                        <div>
                            <label>Purpose:</label>
                            <p id="displayPurpose"></p>
                        </div>
                     </center>
                    <input type="hidden" id="hiddenBusinessOwner" name="businessowner">
                    <input type="hidden" id="hiddenBusinessName" name="businessname">
                    <input type="hidden" id="hiddenLocation" name="location">
                    <input type="hidden" id="hiddenPurpose" name="purpose">
                    <div class="button-row">
                        <button type="button" onclick="prevStep(1)">Previous</button>
                        <button type="submit" name="submit">Submit</button>
                    </div>
                </div>
            </form>
        </div>

        <script>
            const streets = <?php echo json_encode($streets); ?>;

            function nextStep(step) {
                const inputs = document.querySelectorAll(`#step${step} input[required], #step${step} select[required]`);
                let allFilled = true;

                inputs.forEach(input => {
                    if (!input.value) {
                        allFilled = false;
                    }
                });

                if (allFilled) {
                    if (step === 1) {
                        document.getElementById('hiddenBusinessOwner').value = document.getElementById('businessowner').value;
                        document.getElementById('hiddenBusinessName').value = document.getElementById('businessname').value;
                        document.getElementById('hiddenLocation').value = document.getElementById('location').value;
                        document.getElementById('hiddenPurpose').value = document.getElementById('purpose').value;

                        document.getElementById('displayBusinessOwner').innerText = document.getElementById('businessowner').value;
                        document.getElementById('displayBusinessName').innerText = document.getElementById('businessname').value;
                        document.getElementById('displayLocation').innerText = streets[document.getElementById('location').value];
                        document.getElementById('displayPurpose').innerText = document.getElementById('purpose').value;
                    }

                    document.getElementById('step' + step).classList.remove('active');
                    document.getElementById('step' + (step + 1)).classList.add('active');
                    document.getElementById('step' + step + '-header').classList.remove('active');
                    document.getElementById('step' + (step + 1) + '-header').classList.add('active');
                } else {
                    alert("Please fill out all fields.");
                }
            }

            function prevStep(step) {
                document.getElementById('step' + (step + 1)).classList.remove('active');
                document.getElementById('step' + step).classList.add('active');
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

            preventFormHeaderClick();
        </script>
    </main>
    <footer>
        <p>Copyright © Progresibong Barangay Malinao - 2024, All Rights Reserved</p>
        <div class="locate"><a href="https://maps.app.goo.gl/KNeP8XHX3zvHVV2J6" target="_blank"> Malinao Barangay Hall, 33 Interior E. Jacinto St., Malinao, Pasig City</a></div>  
    </footer>
</body>
</html>
