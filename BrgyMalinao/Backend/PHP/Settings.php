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
?>


<!doctype html>
<html lang="en">
<head>
    <title>System Settings</title>
   
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="/BrgyMalinao/Backend/CSS/Settings.css">
    <link rel="stylesheet" type="text/css" href="/BrgyMalinao/Backend/CSS/SideBar.css">
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

        <div class="container">
            <h2>System Settings</h2>
            <div class="row">
                <a href="#">
                    <div class="box-container" onclick="openModal1('barangayOfficialsModal')">
                        <div class="box">
                            <img src="/BrgyMalinao/Backend/images/homeOfficials.png" alt="Barangay Officials Icon">
                            <span>Barangay Officials</span>
                        </div>
                    </div>
                </a>
                <a href="#">
                    <div class="box-container" onclick="openModal2('streetSettingsModal')">
                        <div class="box">
                            <img src="/BrgyMalinao/Backend/images/homeStreet.png" alt="Street Settings Icon">
                            <span>Street Settings</span>
                        </div>
                    </div>
                </a>
                <a href="#">
                    <div class="box-container">
                        <div class="box" onclick="openModal3('logoSettingsModal')">
                            <img src="/BrgyMalinao/Backend/images/homeLogo.png" alt="Logo Settings Icon">
                            <span>Logo Settings</span>
                        </div>
                    </div>
                </a>
                <a href="#">
                    <div class="box-container">
                        <div class="box" onclick="openModal4('passwordSettingsModal')">
                            <img src="/BrgyMalinao/Backend/images/homePassword.png" alt="Password Settings Icon">
                            <span>Password Settings</span>
                        </div>
                    </div>
                </a>
            </div>

            <div class="row">
                <a href="#">
                    <div class="box-container1">
                        <div class="box" onclick="openModal5('contactSupportModal')">
                            <img src="/BrgyMalinao/Backend/images/homeSupport.png" alt="Support Icon">
                            <span>Contact Support</span>
                        </div>
                    </div>
                </a>
                <a href="#">
                    <div class="box-container1">
                        <div class="box" onclick="openModal6('archiveSettingsModal')">
                            <img src="/BrgyMalinao/Backend/images/homeArchive.png" alt="Database Settings Icon">
                            <span>Officials Archive</span>
                        </div>
                    </div>
                </a>
                <a href="#">
                    <div class="box-container1">
                        <div class="box" onclick="openModal7('newsSettingModal1')">
                            <img src="/BrgyMalinao/Backend/images/homeWeb.png" alt="Web Settings Icon">
                            <span>Web Settings</span>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </main>

    <?php
        include 'database.php'; 
        include 'passwordModal.php';
        include 'streetModal.php';
        include 'OfficialsModal.php'; 
        include 'logoModal.php';
        include 'contactModal.php';
        include 'archiveSettingsModal.php';
        include 'newsModal.php';
    ?>
    


    <script>
        function openModal1(barangayOfficialsModal) {
            document.getElementById(barangayOfficialsModal).style.display = 'block';
        }


        function openModal2(streetSettingsModal) {
            document.getElementById(streetSettingsModal).style.display = 'block';
        }

        function openModal3(logoSettingsModal) {
            document.getElementById(logoSettingsModal).style.display = 'block';
        }

        function openModal4(passwordSettingsModal) {
            document.getElementById(passwordSettingsModal).style.display = 'block';
        }

        function openModal5(contactSupportModal) {
            document.getElementById(contactSupportModal).style.display = 'block';
        }

        function openModal6(archiveSettingsModal) {
            document.getElementById(archiveSettingsModal).style.display = 'block';
        }

        function openModal7(newsSettingModal1) {
            document.getElementById(newsSettingModal1).style.display = 'block';
        }

    </script>
</body>
</html>