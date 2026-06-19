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

function fetch_officials($con, $position_ids) {
    $ids = implode(',', $position_ids);
    $sql = "SELECT o.Fullname, o.image, p.Position 
            FROM officials o 
            JOIN position p ON o.Position_ID = p.Position_ID 
            WHERE o.Position_ID IN ($ids)";
    $result = $con->query($sql);
    return $result;
}

$captain = fetch_officials($con, [1]);
$councilors = fetch_officials($con, [2, 3, 4, 5]);
$councilors2 = fetch_officials($con, [6, 7, 8]);
$councilors3 = fetch_officials($con, [10, 11]);


$sk_chairman = fetch_officials($con, [9]);
$sk_councilors = fetch_officials($con, [12]);

$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Malinao</title>
    <link rel="stylesheet" type="text/css" href="http://localhost/BrgyMalinao/Frontend/CSS/officialdesign.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
</head>
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
<div class="head">
    <br>
    <h1>Barangay Malinao</h1>
    <span>List of Officials</span>
    <main>
</div>

<div class="container_capt">
    <?php if ($captain->num_rows > 0): ?>
        <?php while($row = $captain->fetch_assoc()): ?>
            <div class="card">
                <div class="img-bx">
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($row['image']); ?>" alt="Barangay Captain Image" />
                </div>
                <div class="content">
                    <div class="detail">
                        <h3><?php echo $row['Fullname']; ?><br /><span><?php echo $row['Position']; ?></span></h3>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    <?php endif; ?>
</div>

<div class="container_capt">
    <?php if ($councilors->num_rows > 0): ?>
        <?php while($row = $councilors->fetch_assoc()): ?>
            <div class="card">
                <div class="img-bx">
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($row['image']); ?>" alt="Barangay Councilor Image" />
                </div>
                <div class="content">
                    <div class="detail">
                        <h3><?php echo $row['Fullname']; ?><br /><span><?php echo $row['Position']; ?></span></h3>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    <?php endif; ?>
</div>

<div class="container_capt">
    <?php if ($councilors2->num_rows > 0): ?>
        <?php while($row = $councilors2->fetch_assoc()): ?>
            <div class="card">
                <div class="img-bx">
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($row['image']); ?>" alt="Barangay Councilor Image" />
                </div>
                <div class="content">
                    <div class="detail">
                        <h3><?php echo $row['Fullname']; ?><br /><span><?php echo $row['Position']; ?></span></h3>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    <?php endif; ?>
</div>

<div class="container_capt">
    <?php if ($councilors3->num_rows > 0): ?>
        <?php while($row = $councilors3->fetch_assoc()): ?>
            <div class="card">
                <div class="img-bx">
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($row['image']); ?>" alt="Barangay Councilor Image" />
                </div>
                <div class="content">
                    <div class="detail">
                        <h3><?php echo $row['Fullname']; ?><br /><span><?php echo $row['Position']; ?></span></h3>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    <?php endif; ?>
</div>
<div class="sk_container">
    <h2>SK Officials</h2>
    <div class="sk_officials">

        <?php if ($sk_chairman->num_rows > 0): ?>
            <?php while($row = $sk_chairman->fetch_assoc()): ?>
                <div class="official">
                    <span class="position">SK Chairman:</span>
                    <span class="name"><?php echo $row['Fullname']; ?></span>
                </div>
        
            <?php endwhile; ?>
        <?php endif; ?>
      
    
    
        <?php if ($sk_councilors->num_rows > 0): ?>
            <?php while($row = $sk_councilors->fetch_assoc()): ?>
                <div class="official">
                    <span class="position">SK Councilor:</span>
                    <span class="name"><?php echo $row['Fullname']; ?></span>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</div>

<footer>
    <p>Copyright © Progresibong Barangay Malinao - 2024, All Rights Reserved</p>
</footer>
</main>
</body>
</html>