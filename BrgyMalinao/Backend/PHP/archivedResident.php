
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

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Resident Information</title>
    
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" type="text/css" href="http://localhost/BrgyMalinao/Backend/CSS/Resident.css">
        <link rel="stylesheet" type="text/css" href="http://localhost/BrgyMalinao/Backend/CSS/SideBar.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    </head>

    <body>
        <header>
            <button class="hamburger1" id="hamburger">
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
                    <li><a href="#">
                        <i class="fa-solid fa-right-from-bracket"></i>                
                        <span class="nav-item">Log out</span>
                    </a></li>
                </ul>
            </nav>

            <div class="First-container">
                <div class="Title">
                    <i class="fa-solid fa-users"></i>
                    <span>Resident Information</span>
                </div>
                <br>
                <div class="col">
                    <div class="row">
                        <a href="Resident.php" class="nav-link " id="resident-info">
                            <p>Resident Information</p>
                        </a>
                    </div>
                    <div class="row">
                        <a href="archivedResident.php" class="nav-link active" id="archived">
                            <p>Archived</p>
                        </a>
                    
                    </div>
                </div>
                <hr class="line-break">
            </div>
            <div class="col1">
                <div class="search-container">
                    <form id="searchForm" method="POST" action="">
                        <div class="input-container">
                            <input type="text" id="searchInput" placeholder="Search" name="search" onkeyup="searchResidents()">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </div>
                    </form>
                    <div>
                        <input type="button" id="IncDec" value="▲▼" onclick="toggleTableRows()">
                    </div>
                    <div>
                        <input type="button" id="SearchButton" value="Reset" onclick="resetSearch()"/>
                    </div>
                    <div>
                        <select id="streetSelect" class="styled-select">
                            <option value="">Select Street</option>
                            <?php
                                $sql = "SELECT `Street_ID`, `streetHOA` FROM `street_name`";
                                $result = $con->query($sql);
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='{$row['Street_ID']}'>{$row['streetHOA']}</option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>
            </div>



            <div class="col2">
                <div class="Table-container">
                    <div class="Scrollable-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Archive ID</th>
                                    <th>Firstname</th>
                                    <th>Middlename</th>
                                    <th>Surname</th>
                                    <th>Suffix</th>
                                    <th>BirthDate</th>
                                    <th>Age</th>
                                    <th>Gender</th>
                                    <th>Years in Barangay</th>
                                    <th>HouseNo</th>
                                    <th>Street</th>
                                    <th>Contact Number</th>
                                    <th>Email</th>
                                    <th>Voter Status</th>
                                    <th>PWD</th>
                                    <th>Date Rejected</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="searchResults">
                            <?php
                                    include 'archiveResSearch.php';
                                    ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
        <script src="http://localhost/BrgyMalinao/Backend/JS/Resident.js"></script>
        <script src="http://localhost/BrgyMalinao/Backend/JS/SideBar.js"></script>
        <script src="http://localhost/BrgyMalinao/Backend/JS/IncDec.js"></script>
        <script>
            document.getElementById("streetSelect").addEventListener("change", function() {
                    var selectedStreet = this.value;
                    var xhr = new XMLHttpRequest();
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === XMLHttpRequest.DONE) {
                            if (xhr.status === 200) {
                                document.getElementById("searchResults").innerHTML = xhr.responseText;
                            } else {
                                console.error("Error: " + xhr.status);
                            }
                        }
                    };
                    xhr.open("POST", "archiveResSearch.php", true);
                    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xhr.send("street=" + selectedStreet);
                });

                document.getElementById("searchInput").addEventListener("keypress", function(event) {
                    if (event.key === "Enter") {
                        event.preventDefault();
                        var searchForm = document.getElementById("searchForm");
                        var formData = new FormData(searchForm);
                        var xhr = new XMLHttpRequest();
                        xhr.onreadystatechange = function() {
                            if (xhr.readyState === XMLHttpRequest.DONE) {
                                if (xhr.status === 200) {
                                    document.getElementById("searchResults").innerHTML = xhr.responseText;
                                } else {
                                    console.error("Error: " + xhr.status);
                                }
                            }
                        };
                        xhr.open("POST", "archiveResSearch.php", true);
                        xhr.send(formData);
                    }
                });

                function resetSearch() {
                    document.getElementById("searchInput").value = '';
                    document.getElementById("searchForm").submit();
                }
                function archiveResident(archive_id) {
                    var confirmation = confirm("Are you sure you want to retrieve this resident?");
                    if (confirmation) {
                        var xhr = new XMLHttpRequest();
                        xhr.onreadystatechange = function() {
                            if (xhr.readyState === XMLHttpRequest.DONE) {
                                if (xhr.status === 200) {
                                    alert(xhr.responseText);
                                    document.getElementById("searchForm").submit();
                                    location.reload();
                                } else {
                                    console.error("Error: " + xhr.status);
                                }
                            }
                        };
                        xhr.open("POST", "archiveResSearch.php", true);
                        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                        xhr.send("action=retrieve&archive_id=" + archive_id);
                    }
                }

                function deleteResident(archive_id) {
                    var confirmation = confirm("Are you sure you want to delete this resident?");
                    if (confirmation) {
                        var xhr = new XMLHttpRequest();
                        xhr.onreadystatechange = function() {
                            if (xhr.readyState === XMLHttpRequest.DONE) {
                                if (xhr.status === 200) {
                                    alert(xhr.responseText);
                                    document.getElementById("searchForm").submit();
                                    location.reload();
                                } else {
                                    console.error("Error: " + xhr.status);
                                }
                            }
                        };
                        xhr.open("POST", "archiveResSearch.php", true);
                        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                        xhr.send("action=delete&archive_id=" + archive_id);
                    }
                }
        </script>
    </body>
</html>
