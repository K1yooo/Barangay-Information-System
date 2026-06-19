<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Website</title>
    <link rel="stylesheet" type="text/css" href="http://localhost/BrgyMalinao/Frontend/CSS/homedesign.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>

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

    $query_gallery = "SELECT image, description FROM gallery";
    $result_gallery = mysqli_query($con, $query_gallery);

    $gallery_items = [];
    if ($result_gallery) {
        while ($row_gallery = mysqli_fetch_assoc($result_gallery)) {
            $gallery_items[] = [
                'image' => base64_encode($row_gallery['image']),
                'description' => $row_gallery['description']
            ];
        }
    } else {
        echo "Error: " . mysqli_error($con);
    }


    $query_news = "SELECT title, content, newsimage, link FROM news";
    $result_news = mysqli_query($con, $query_news);

    $news_items = [];
    if ($result_news) {
        while ($row_news = mysqli_fetch_assoc($result_news)) {
            $news_items[] = [
                'title' => $row_news['title'],
                'content' => $row_news['content'],
                'image' => base64_encode($row_news['newsimage']),
                'link' => $row_news['link']
            ];
        }
    } else {
        echo "Error: " . mysqli_error($con);
    }
    ?>
</head>
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
    <div class="overlay">
        <img src="data:image/png;base64,<?php echo $logo; ?>" alt="Logo of Malinao">
        <h1>WELCOME TO BARANGAY MALINAO</h1>
        <p>Progresibong Barangay Malinao</p>
    </div>

    <div class="slider">
        <img src="http://localhost/BrgyMalinao/Frontend/images/homepic1.png" alt="Slide 1">
        <img src="http://localhost/BrgyMalinao/Frontend/images/homepic2.png" alt="Slide 2">
        <img src="http://localhost/BrgyMalinao/Frontend/images/homepic3.png" alt="Slide 3">
        <img src="http://localhost/BrgyMalinao/Frontend/images/homepic4.png" alt="Slide 4">
    </div>
    <h1>BARANGAY E-FORMS</h1>
    <br><br>
    <div class="buttons">
        <a href="http://localhost/BrgyMalinao/Frontend/PHP/register.php" class="neumorphic active">
            <img src="http://localhost/BrgyMalinao/Frontend/images/register2.png" alt="Register Now" class="button-img">
            <span>Register Now</span>
        </a>
        <a href="forms.php" class="neumorphic">
            <img src="http://localhost/BrgyMalinao/Frontend/images/custom-clearance.png" alt="Barangay Clearance" class="button-img">
            <span>Barangay E-Forms</span>
        </a>
        <a href="businesscert.php" class="neumorphic">
            <img src="http://localhost/BrgyMalinao/Frontend/images/business.png" alt="Business certificate" class="button-img">
            <span>Business Certificate</span>
        </a>
    </div>
    <br><br><br><br><br>
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
        <button class="btn">
            <a href="http://localhost/BrgyMalinao/Frontend/PHP/Aboutus.php">
                <span class="circle">
                    <span class="icon arrow"></span>
                </span>
                <span class="textarrow">LEARN MORE</span>
            </a>
        </button>
    </section>
    <!-- Gallery -->
    <div class="container-fluid portfolio-container-holder content-section" id="portfolio">
        <div class="portfolio-container container">
            <h1 class="text-center">GALLERY</h1>
            <hr class="star-portfolio">
            <div class="portfolio-container-holder row">
                <?php foreach ($gallery_items as $item): ?>
                    <div class="col-md-6 col-xs-12 col-sm-6 portfolio-card-holder">
                        <div class="portfolio-card">
                            <img src="data:image/png;base64,<?php echo $item['image']; ?>" alt="Portfolio" class="img-responsive portfolio-img">
                            <span class="portfolio-caption">
                                <p class="portfolio-caption-content"><?php echo $item['description']; ?></p>
                            </span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <!-- Latest News Section -->
    <div class="text-above-cards">
        <h2>Latest News</h2>
        <p>Stay updated with the latest happenings in Barangay Malinao!</p>
    </div>
    <div class="card-container">
        <?php foreach ($news_items as $news): ?>
            <div class="card">
                <img src="data:image/png;base64,<?php echo $news['image']; ?>" alt="<?php echo $news['title']; ?>">
                <div class="card-content">
                    <h3><?php echo $news['title']; ?></h3>
                    <p><?php echo $news['content']; ?></p>
                    <a href="<?php echo $news['link']; ?>" class="btn">Read More</a>
                </div>
            </div>
        <?php endforeach; ?>
        </div>
 <footer>
    <p>Copyright © Progresibong Barangay Malinao - 2024, All Rights Reserved</p>
    <div class="locate"><a href="https://maps.app.goo.gl/KNeP8XHX3zvHVV2J6" target="_blank"> Malinao Barangay Hall, 33 Interior E. Jacinto St., Malinao, Pasig City</a></div>  
    </footer>
    <script src="http://localhost/BrgyMalinao/Frontend/JS/homescript.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="js/jquery-2.2.4.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>
