<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Malinao</title>
    <link rel="stylesheet" type="text/css" href="http://localhost/BrgyMalinao/Frontend/CSS/aboutus.css">
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


$query_official = "SELECT Fullname, Image FROM officials WHERE position_id = 1";
$result_official = mysqli_query($con, $query_official);

if ($result_official) {
    $row_official = mysqli_fetch_assoc($result_official);
    $official_name = $row_official['Fullname'];
    $official_image = base64_encode($row_official['Image']);
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
    <div class="banner_image">
    <div class="banner_content">
			<h1>ABOUT US</h1>
		</div>
	</div>
    <section class="capt">
        <div class="containercapt">
            <div class="row no-gutters align-items-center">
                <div class="col-lg-6 col-md-12">
                    <div class="portfolio portfolio-02">
                        <div class="white-bg d-none d-md-block">
                        <img src="data:image/png;base64,<?php echo $official_image; ?>" alt="captain">
                        </div>
                    </div>
                </div>
                <div class="col-xl-5 col-lg-6 col-md-12">
                    <div class="portfolio-wrapper-02">
                        <div class="portfolio">
                            <div class="section-title mb-15">
                                <h6 class="left_line">Barangay Captain</h6>
                                <h2><?php echo $official_name; ?></h2>
                            </div>
                            <div class="portfolio__content">
                                <h6 class="mb-35">"A true leader does not create separation, A true leader brings people together." - Tendai Ruben Mbofana</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br> <br> <br>
<div class="mission" id="mission">
        <div class="MissionContainer">
            <div class="mission-content">
                <h2>Mission</h2>
                <div class="mission-display">
                    We envision the Progresibong Barangay Malinao to be more, progressive, 
                    discipline, law-abiding, productive and healthy individuals; a drug-free community, clean, 
                    environmentally aware, safe, and peaceful place to live in where people and residents enjoy 
                    harmonious way of life, business, at work and at home, and most especially for a more directed 
                    progressive Barangay Governance.
                </div>
            </div>
            <img src="http://localhost/BrgyMalinao/Frontend/images/mission.png" alt="Mission Icon" class="mission-icon">
        </div>
    </div>
    <div class="vision" id="vision">
        <div class="VisionContainer">
            <div class="vision-content">
                <h2>Vision</h2>
                <div class="vision-display">
                    To impose Transparent Plans, Programs, and Regulations for the protection 
                    of the interest of the community with regards to Environment, Education, Infrastructure, Health, 
                    Social Services, Moral, Financial, Peace and Order.
                </div>
            </div>
            <img src="http://localhost/BrgyMalinao/Frontend/images/vision.png" alt="Vision Icon" class="vision-icon">
        </div>
    </div>
    <section class="intro">
  <div class="container">
    <h1>BARANGAY MALINAO&darr;</h1>
  </div>
</section>
<section class="timeline">
  <ul>
    <li>
      <div>
        <time>12th Century</time> 
Barangay Malinao, dating to the 12th century, was initially settled by Pasig River dwellers. Malay traders introduced Islam in the 14th century. Under Sultana Kalangitan, it was part of Pasig's sultanate. Its name possibly stems from clear creeks. Legends attribute it to clearing bamboo groves or discovering clear water from wells during Spanish times, attracting neighboring residents.
      </div>
    </li>
    <li>
      <div>
        <time>Spanish Period</time>
Malinao, one of Pasig City's oldest barangays, expanded from a sitio to a bustling barrio during the Spanish era. Today, it's a vital thoroughfare, connecting to the Public Market and City Hall. Spanning 25 hectares with around 8,500 residents, Malinao boasts key landmarks like churches, schools, markets, and recreational spots. Known as an educational hub, it houses institutions like Pasig Catholic College and Colegio del Buen Consejo.
      </div>
    </li>
    <li>
      <div>
        <time>Old Barangay</time> The former Barangay Hall, situated on Antonio Luna Street (now Justice Ramon R. Jabson Street), was built in November 1990 and inaugurated in April 1991. It occupies the top floor of a three-story building, with the day care center on the second floor and the Health Center on the ground level.
      </div>
    </li>
    <li>
      <div>
        <time>current site</time>The Barangay Hall now stands where former Mayor Vicente "Enteng" Eusebio's nipa house once stood. Nearby were the residence and apartments of Don Mariano Melendres, represented by the Zapanta-Albea Family, along with several other families like Umali, Saquitan, Fuentes, and Raymundo.
      </div>
    </li>
</section>
<br>
<footer>
        <p>Copyright © Progresibong Barangay Malinao - 2024, All Rights Reserved</p>
        <div class="locate"><a href="https://maps.app.goo.gl/KNeP8XHX3zvHVV2J6" target="_blank"> Malinao Barangay Hall, 33 Interior E. Jacinto St., Malinao, Pasig City</a></div>  
	</div>
    </footer>
    <script src="http://localhost/BrgyMalinao/Frontend/JS/aboutus.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>