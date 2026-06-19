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

    $demographic_query = "
    SELECT 
        SUM(CASE WHEN Gender = 'Male' THEN 1 ELSE 0 END) AS MaleCount,
        SUM(CASE WHEN Gender = 'Female' THEN 1 ELSE 0 END) AS FemaleCount,
        SUM(CASE WHEN Gender = 'LGBTQIA+' THEN 1 ELSE 0 END) AS LGBTQIACount,
        SUM(CASE WHEN YEAR(CURRENT_DATE) - YEAR(Birthdate) >= 60 THEN 1 ELSE 0 END) AS SeniorCount,
        SUM(CASE WHEN IfPWD = 'Yes' THEN 1 ELSE 0 END) AS PWDCount,
        SUM(CASE WHEN Voter_Status = 'Yes' THEN 1 ELSE 0 END) AS VotersCount
    FROM residents";

    $demographic_result = mysqli_query($con, $demographic_query);

    if ($demographic_result) {
        $row = mysqli_fetch_assoc($demographic_result);
        $male_count = $row['MaleCount'];
        $female_count = $row['FemaleCount'];
        $lgbtqia_count = $row['LGBTQIACount'];
        $senior_count = $row['SeniorCount'];
        $pwd_count = $row['PWDCount'];
        $voters_count = $row['VotersCount'];
    } else {
        $male_count = 0;
        $female_count = 0;
        $lgbtqia_count = 0;
        $senior_count = 0;
        $pwd_count = 0;
        $voters_count = 0;
    }

    $officials_query = "
    SELECT 
        o.Fullname, 
        p.Position 
    FROM 
        officials o 
    JOIN 
        position p 
    ON 
        o.Position_ID = p.Position_ID
    ORDER BY 
        CASE 
            WHEN p.Position = 'Barangay Captain' THEN 1
            WHEN p.Position LIKE 'Barangay Councilor%' THEN 2
            WHEN p.Position = 'Barangay Secretary' THEN 3
            WHEN p.Position = 'Barangay Treasurer' THEN 4
            WHEN p.Position = 'Barangay SK Chairman' THEN 5
            WHEN p.Position = 'SK Councilor' THEN 6
            ELSE 7
        END, 
        p.Position ASC
    ";
    $officials_result = mysqli_query($con, $officials_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="http://localhost/BrgyMalinao/Backend/CSS/Dashboard.css">
    <link rel="stylesheet" type="text/css" href="http://localhost/BrgyMalinao/Backend/CSS/SideBar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <style>
        .box-container2 {
            position: absolute;
            top: 435px; 
            left: 120px;
            right: 0;
            padding: 20px;
            z-index: -500;
        }
        .boxgraph {
            align-content: center;
            background-color: #ffffff;
            width: 46.5%;
            height: 250px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3); 
            border-radius: 10px;
            padding: 15px;
        }

        .boxgraph p {
            text-align: center;
            margin-bottom: 50px;
        }
    </style>
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
                <li><a href="#">
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
            <div class="row">
                <div class="col-lg-6">
                    <div class="sec">
                            <div class="Title">
                                <span>Demographic Overview</span>
                            </div>
                        <div class="box-container">
                            <div class="box">
                                <div class="boxx">
                                    <div class="little-box">
                                        <i class="fa-regular fa-user"></i>
                                        <a href="AllMale.php"><i class="fa-solid fa-caret-right"></i></a>
                                    </div>
                                    
                                    <div class="info-line">
                                        <p class="label">Male</p>
                                        <p class="value"><?php echo $male_count; ?></p>
                                    </div>
                                </div>
                            </div>
            
                            <div class="box">
                                <div class="boxx">
                                    <div class="little-box">
                                        <i class="fa-regular fa-user"></i>
                                        <a href="AllFemale.php"><i class="fa-solid fa-caret-right"></i></a>
                                    </div>
                                    
                                    <div class="info-line">
                                        <p class="label">Female</p>
                                        <p class="value"><?php echo $female_count; ?></p>
                                    </div>
                                </div>
                            </div>
            
                            <div class="box">
                                <div class="boxx">
                                    <div class="little-box">
                                        <i class="fa-regular fa-user"></i>
                                        <a href="AllLgbt.php"><i class="fa-solid fa-caret-right"></i></a>
                                    </div>
                                    
                                    <div class="info-line">
                                        <p class="label">LGBTQIA+</p>
                                        <p class="value"><?php echo $lgbtqia_count; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="box-container1">
                            <div class="box1">
                                <div class="boxx">
                                    <div class="little-box">
                                        <i class="fa-regular fa-user"></i>
                                        <a href="AllSenior.php"><i class="fa-solid fa-caret-right"></i></a>
                                    </div>
                                    
                                    <div class="info-line">
                                        <p class="label">Senior</p>
                                        <p class="value"><?php echo $senior_count; ?></p>
                                    </div>
                                </div>
                            </div>
            
                            <div class="box1">
                                <div class="boxx">
                                    <div class="little-box">
                                        <i class="fa-regular fa-user"></i>
                                        <a href="AllPwd.php"><i class="fa-solid fa-caret-right"></i></a>
                                    </div>
                                    
                                    <div class="info-line">
                                        <p class="label">PWD</p>
                                        <p class="value"><?php echo $pwd_count; ?></p>
                                    </div>
                                </div>        
                            </div>
            
                            <div class="box1">
                                <div class="boxx">
                                    <div class="little-box">
                                        <i class="fa-regular fa-user"></i>
                                        <a href="AllVoter.php"><i class="fa-solid fa-caret-right"></i></a>
                                    </div>
                                    
                                    <div class="info-line">
                                        <p class="label">Voters</p>
                                        <p class="value"><?php echo $voters_count; ?></p>
                                    </div>
                                </div>        
                            </div>
                        </div>
            
                        <div class="box-container2">
                            <div class="boxgraph">
                                <p>Demographic Overview</p>
                                <canvas id="lineChart" width="400" height="50"></canvas>
                            </div>  
                        </div>
                        
                    </div> 
                </div>   
                <div class="col-lg-6">
                    <div class="Tabs">
                        <div class="Title2">
                                    <span>Officials</span>
                                </div>
                        <div class="scrollable-table">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Position</th>
                                        <th>Fullname</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while($row = mysqli_fetch_assoc($officials_result)): ?>
                                        <tr>
                                            <td><?php echo $row['Position']; ?></td>
                                            <td><?php echo $row['Fullname']; ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>      
            </div>   
        </div>  
    </main>

    Katrina Aro
<script>
    document.addEventListener("DOMContentLoaded", function() {
      
        const data = {
            labels: ['Male', 'Female', 'LGBTQIA+', 'Senior', 'PWD', 'Voters'],
            values: [<?php echo $male_count; ?>, <?php echo $female_count; ?>, <?php echo $lgbtqia_count; ?>, <?php echo $senior_count; ?>, <?php echo $pwd_count; ?>, <?php echo $voters_count; ?>]
        };

        const ctx = document.getElementById('lineChart').getContext('2d');

      
        function getStepSize(maxValue) {
            if (maxValue <= 50) {
                return 10;
            } else if (maxValue <= 100) {
                return 20;
            } else if (maxValue <= 500) {
                return 50;
            } else if (maxValue <= 1000) {
                return 100;
            } else if (maxValue <= 5000) {
                return 500;
            } else {
                return 1000;
            }
        }

        const maxValue = Math.max(...data.values);
        const stepSize = getStepSize(maxValue);

    
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: data.labels,
                datasets: [{
                    label: '',
                    data: data.values,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        min: 0,
                        ticks: {
                            stepSize: stepSize
                        }
                    }
                }
            }
        });
    });
</script>
    <script src="http://localhost/BrgyMalinao/Backend/JS/SideBar.js"></script>
</body>
</html>
