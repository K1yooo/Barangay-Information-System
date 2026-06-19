<?php
include 'database.php';

$query = "SELECT Logo FROM logo WHERE logo_id = 1";
$result = mysqli_query($con, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);
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
            <i class="fa-solid fa-users"></i>
            <span>Resident Information</span>
        </div>
        <br>
        <div class="col">
            <div class="row">
                <a href="Resident.php" class="nav-link active" id="resident-info">
                    <p>Resident Information</p>
                </a>
            </div>
            <div class="row">
                <a href="archivedResident.php" class="nav-link" id="archived">
                    <p>Archived</p>
                </a>
            </div>
        </div>
        <hr class="line-break">
    </div>

    <div class="col1">
    </div>

    <div class="col2">
        <div class="Table-container">
            <div class="Scrollable-table">
                <table>
                    <thead>
                    <tr>
                        <th>Resident ID</th>
                        <th>Firstname</th>
                        <th>Action</th> 
                    </tr>
                    </thead>
                    <?php
                    $result = mysqli_query($con, "SELECT * FROM residents"); 
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['Resident_ID'] . "</td>";
                                echo "<td>" . $row['Firstname'] . "</td>";
                                echo "<td>" . $row['Middlename'] . "</td>";
                                echo "<td>" . $row['Surname'] . "</td>";
                                echo "<td>" . $row['Suffix'] . "</td>";
                                echo "<td>" . $row['BirthDate'] . "</td>";
                                echo "<td>" . $row['Age'] . "</td>";
                                echo "<td>" . $row['Gender'] . "</td>";
                                echo "<td>" . $row['Years_in_Barangay'] . "</td>";
                                echo "<td>" . $row['HouseNo'] . "</td>";
                                echo "<td>" . $row['Street'] . "</td>";
                                echo "<td>" . $row['Contact_Number'] . "</td>";
                                echo "<td>" . $row['Email'] . "</td>";
                                echo "<td>" . $row['Voter_Status'] . "</td>";
                                echo "<td>" . $row['PWD'] . "</td>";
                                echo "<td>" . $row['Date_Accepted'] . "</td>";
                                
                                echo "<td>";
                                echo "<button onclick='viewResident(" . $row['Resident_ID'] . ")'>View</button>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='17'>No results found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<script>
   
    function viewResident(residentId) {
        window.location.href = "viewResident.php?id=" + residentId;
    }
</script>

<script src="http://localhost/BrgyMalinao/Backend/JS/SideBar.js"></script>
</body>
</html>
