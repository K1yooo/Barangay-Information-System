<?php
include 'database.php';
include 'blotterAddModal.php';
include 'blotterUpdateModal.php';
include 'insert_blotter.php';

$querylogo = "SELECT Logo FROM logo WHERE logo_id = 1";
    $resultlogo = mysqli_query($con, $querylogo);

    if ($resultlogo) {
        $row = mysqli_fetch_assoc($resultlogo);
        $logo = base64_encode($row['Logo']);
    } else {
        echo "Error: " . mysqli_error($con);
    }

$search_value = isset($_POST["search"]) ? $_POST["search"] : '';
$status = isset($_POST["status"]) ? $_POST["status"] : '';

$sql = "SELECT blotter_id, complainant, respondent, victims, type, location, date, time, status, date_reported FROM blotter WHERE 1=1";

if (!empty($search_value)) {
    if (is_numeric($search_value)) {
        $sql .= " AND blotter_id = '$search_value'";
    } else {
        $sql .= " AND complainant LIKE '%$search_value%'";
    }
}

if (!empty($status)) {
    $sql .= " AND status = '$status'";
}

$sql .= " ORDER BY blotter_id ASC";

$result = $con->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="http://localhost/BrgyMalinao/Backend/CSS/Blotter.css">
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
                <li><a href="Dashboard.php"><i class="fa-solid fa-house"></i><span class="nav-item">Dashboard</span></a></li>
                <li><a href="Pending.php"><i class="fa-solid fa-hourglass-half"></i><span class="nav-item">Pending Registrations</span></a></li>
                <li><a href="Resident.php"><i class="fa-solid fa-users"></i><span class="nav-item">Resident List</span></a></li>
                <li><a href="BarangayForms.php"><i class="fa-solid fa-layer-group"></i><span class="nav-item">Barangay Forms</span></a></li>
                <li><a href="Blotter.php"><i class="fa-solid fa-book"></i><span class="nav-item">Blotter Report</span></a></li>
                <li><a href="Settings.php"><i class="fa-solid fa-gears"></i><span class="nav-item">System Settings</span></a></li>
            </ul>
            <ul class="bottom-links">
                <li><a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i><span class="nav-item">Log out</span></a></li>
            </ul>
        </nav>

        <div class="First-container">
            <div class="Title">
                <i class="fa-solid fa-book"></i>
                <span>Blotter Report</span>
                <button class="add-button" onclick="openModal10('BlotterAddModal')">Add</button>
            </div>
            <br>
            <div class="col">
                <div class="row"><a href="Blotter.php" class="nav-link active" id="blotter"><p>Blotter Status</p></a></div>
            </div>
            <hr class="line-break">
        </div>
        <div class="col1">
            <div class="search-container">
                <form id="searchForm" method="POST" action="">
                    <div class="input-container">
                        <input type="text" id="searchInput" placeholder="Search" name="search" onkeyup="submitForm()">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <div class="button-container">
                            <input type="button" id="IncDec" value="▲▼" onclick="toggleTableRows()">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="col2">
            <div class="Table-container">
                <div class="Scrollable-table">
                    <table>
                        <thead>
                            <tr>
                                <th>Blotter ID</th>
                                <th>Complainant</th>
                                <th>Respondent</th>
                                <th>Victims</th>
                                <th>Type</th>
                                <th>Location</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Status</th>
                                <th>Date Reported</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="searchResults">
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['blotter_id'] . "</td>";
            echo "<td>" . $row['complainant'] . "</td>";
            echo "<td>" . $row['respondent'] . "</td>";
            echo "<td>" . $row['victims'] . "</td>";
            echo "<td>" . $row['type'] . "</td>";
            echo "<td>" . $row['location'] . "</td>";
            echo "<td>" . $row['date'] . "</td>";
            echo "<td>" . $row['time'] . "</td>";
            echo "<td>" . $row['status'] . "</td>";
            echo "<td>" . $row['date_reported'] . "</td>";
            echo "<td><button  class='Blue' onclick='viewReport(" . $row['blotter_id'] . ")'>View/Edit</button> <button class='Red' onclick='deleteRecord(" . $row['blotter_id'] . ")'>Delete</button></td>";
            
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='12'>No results found</td></tr>";
    }
                            ?>
                        </tbody>
                    </table>    
                </div>
            </div>
        </div>
    </main>
    <script src="http://localhost/BrgyMalinao/Backend/JS/SideBar.js"></script>
    <script src="http://localhost/BrgyMalinao/Backend/JS/IncDec.js"></script>
    <script>
        function resetSearch() {
            document.getElementById('searchForm').reset();
            document.getElementById('searchForm').submit();
        }

        function openModal10(modalId) {
            document.getElementById(modalId).style.display = 'block';
        }

        function viewReport(reportId) {
           
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'fetch_report.php?id=' + reportId, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var data = JSON.parse(xhr.responseText);

                    document.getElementById('upblotter_id').value = data.blotter_id;
                    document.getElementById('upname').value = data.complainant;
                    document.getElementById('upnesp').value = data.respondent;
                    document.getElementById('upvic').value = data.victims;
                    document.getElementById('uptype').value = data.type;
                    document.getElementById('uploc').value = data.location;
                    document.getElementById('update').value = data.date;
                    document.getElementById('uptime').value = data.time;
                    document.getElementById('upStat').value = data.status;
                    document.getElementById('upresizable-textarea').value = data.blotter_details;

               
                    document.getElementById('BlotterUpModal').style.display = 'block';
                }
            };
            xhr.send();
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

       
        window.onclick = function(event) {
            var modal = document.getElementById('BlotterUpModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
        function deleteRecord(id) {
    if (confirm("Are you sure you want to delete this record?")) {
       
        var xhttp = new XMLHttpRequest();
        
      
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                alert(this.responseText);
                location.reload(); 
            }
        };

        
        xhttp.open("POST", "delete_record.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        
        
        xhttp.send("blotter_id=" + id);
    }
};
    </script>
</body>
</html>
