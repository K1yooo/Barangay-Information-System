    <?php
    include 'database.php';

    $querylogo = "SELECT Logo FROM logo WHERE logo_id = 1";
    $resultlogo = mysqli_query($con, $querylogo);

    if ($resultlogo) {
        $row = mysqli_fetch_assoc($resultlogo);
        $logo = base64_encode($row['Logo']);
    } else {
        echo "Error: " . mysqli_error($con);
    }

    $id = isset($_GET['id']) ? $_GET['id'] : null;
    $query = "SELECT ra.*, sn.`streetHOA` AS Street_Name 
            FROM resident_applicants ra
            LEFT JOIN street_name sn ON ra.Street = sn.Street_ID
            WHERE ra.ID = $id";

    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        $birthdate = new DateTime($row['Birthdate']);
        $today = new DateTime('today');
        $age = $birthdate->diff($today)->y; 
    } else {
        echo "No data found.";
        exit;
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <title>View</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" type="text/css" href="http://localhost/BrgyMalinao/Backend/CSS/View.css">
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
                    <img src="data:image/png;base64,<?php echo $logo; ?>" alt="Logo of Malinao">
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
                    <span>Pending Registration Information</span>
                    <button class="back-button" onclick="window.location.href='Pending.php'">Back</button>
                </div>
                <hr class="line-break">
            </div>

            <div class="InfoDes-Container">
                <div class="InfoDes">
                    <div class="row1">
                        <div>
                            <label>Firstname:</label> <br>
                            <input type="text" value="<?php echo $row['Firstname']; ?>" readonly class="readonly-input">
                        </div>
                        <div>
                            <label>Middlename:</label><br>
                            <input type="text" value="<?php echo $row['Middlename']; ?>" readonly class="readonly-input">
                        </div>
                        <div>
                            <label>Surname:</label><br>
                            <input type="text" value="<?php echo $row['Surname']; ?>" readonly class="readonly-input">
                        </div>
                        <div>
                            <label>Suffix:</label><br>
                            <input type="text" value="<?php echo $row['Suffix']; ?>" readonly class="readonly-input">
                        </div>
                    </div>
                    <div class="row1">
                        <div>
                            <label>Birthdate:</label><br>
                            <input type="text" value="<?php echo $row['Birthdate']; ?>" readonly class="readonly-input">
                        </div>
                        <div>
                            <label>Age:</label><br>
                            <input type="text" value="<?php echo $age; ?>" readonly class="readonly-input">
                        </div>
                        <div>
                            <label>Gender:</label><br>
                            <input type="text" value="<?php echo $row['Gender']; ?>" readonly class="readonly-input">
                        </div>
                        <div>
                            <label>Birthplace:</label><br>
                            <input type="text" value="<?php echo $row['Birthplace']; ?>" readonly class="readonly-input">
                        </div>
                    </div>

                    <div class="row1">
                        <div>
                            <label>Civil Status:</label><br>
                            <input type="text" value="<?php echo $row['Civil_Status']; ?>" readonly class="readonly-input">
                        </div>
                        <div>
                            <label>Years in Barangay:</label><br>
                            <input type="text" value="<?php echo $row['Years_In_Barangay']; ?>" readonly class="readonly-input">
                        </div>
                        <div>
                            <label>House Type:</label><br>
                            <input type="text" value="<?php echo $row['HouseType']; ?>" readonly class="readonly-input">
                        </div>
                        <div>
                            <label>Household No:</label><br>
                            <input type="text" value="<?php echo $row['Household_No']; ?>" readonly class="readonly-input">
                        </div>
                    </div>

                    <div class="row1">
                        <div>
                            <label>Street:</label><br>
                            <input type="text" value="<?php echo $row['Street_Name']; ?>" readonly class="readonly-input">
                        </div>
                        <div>
                            <label>Voter Status:</label><br>
                            <input type="text" value="<?php echo $row['Voter_Status']; ?>" readonly class="readonly-input">
                        </div>
                        <div>
                            <label>Voters Precinct No:</label><br>
                            <input type="text" value="<?php echo $row['Voters_Precinct_No']; ?>" readonly class="readonly-input">
                        </div>
                        
                        <div>
                            <label>PWD:</label><br>
                            <input type="text" value="<?php echo $row['IfPWD']; ?>" readonly class="readonly-input">
                        </div>
                    </div>

                    <div class="row1">
                        
                        <div>
                            <label>Contact Number:</label><br>
                            <input type="text" value="<?php echo $row['Contact_Number']; ?>" readonly class="readonly-input">
                        </div>
                        <div>
                            <label>Email:</label><br>
                            <input type="text" value="<?php echo $row['Email']; ?>" readonly class="readonly-input">
                        </div>
                    </div>

                </div>

                <div class="InfoDes2">
                    <div class="row2">
                        <div class="image-container">
                            <?php if (!empty($row['Voters_ID'])): ?>
                                <div class="image-item">
                                    <label>Voters ID:</label><br>
                                    <img src='data:image/png;base64,<?php echo base64_encode($row['Voters_ID']); ?>' alt='Voters ID'>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($row['PWD_ID'])): ?>
                                <div class="image-item">
                                    <label>PWD ID:</label><br>
                                    <img src='data:image/png;base64,<?php echo base64_encode($row['PWD_ID']); ?>' alt='PWD ID'>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($row['Valid_ID'])): ?>
                                <div class="image-item">
                                    <label>Valid ID:</label><br>
                                    <img src='data:image/png;base64,<?php echo base64_encode($row['Valid_ID']); ?>' alt='Valid ID'>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>                                
        </main> 
        <script src="http://localhost/BrgyMalinao/Backend/JS/SideBar.js"></script>
    </body>
    </html>
