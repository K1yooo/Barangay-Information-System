<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Website</title>
    <link rel="stylesheet" href="http://localhost/BrgyMalinao/Frontend/CSS/contact.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];


    $stmt = $con->prepare("INSERT INTO contact_us (Firstname, Lastname, Email, Contact_Number, Message) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $firstname, $lastname, $email, $phone, $message);


    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    
    $stmt->close();
    $con->close();
} else {
    echo "Invalid request";
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
    <body>
    <main>
    <section class = "contact-section">
      <div class = "contact-bg">
        <h3>Get in Touch with Us</h3>
        <h2>contact us</h2>
        <div class = "line">
          <div></div>
          <div></div>
          <div></div>
        </div>
        <p class = "text">Thank you for visiting Barangay Malinao's official website! We value your inquiries and feedback. Our team is committed to providing excellent service and ensuring a seamless experience for you.</p>
      </div>


      <div class = "contact-body">
        <div class = "contact-info">
          <div>
            <span><i class = "fas fa-mobile-alt"></i></span>
            <span>Phone No.</span>
            <span class = "text">0966 380 7015</span>
          </div>
          <div>
            <span><i class = "fas fa-envelope-open"></i></span>
            <span>E-mail</span>
            <span class = "text">malinaopasig@gmail.com</span>
          </div>
          <div>
            <span><i class = "fas fa-map-marker-alt"></i></span>
            <span>Address</span>
            <span class = "text">Malinao Barangay Hall, 33 Interior E. Jacinto St., Malinao, Pasig City</span>
          </div>
          <div>
            <span><i class = "fas fa-clock"></i></span>
            <span>Opening Hours</span>
            <span class = "text">Monday - Friday (9:00 AM to 5:00 PM)</span>
          </div>
        </div>

        <div class = "contact-form">
          <form method="post">
            <div>
              <input type = "text" class = "form-control" name ="firstname" placeholder="First Name">
              <input type = "text" class = "form-control" name ="lastname" placeholder="Last Name">
            </div>
            <div>
              <input type = "email" class = "form-control" name ="email" placeholder="E-mail">
              <input type = "text" class = "form-control" name ="phone" placeholder="Phone">
            </div>
            <textarea rows = "5" placeholder="Message" name ="message" class = "form-control"></textarea>
            <input type = "submit" class = "send-btn">
          </form>

          <div>
            <img src = "http://localhost/BrgyMalinao/Frontend/images/contactperson.png" alt = "image">
          </div>
        </div>
      </div>

      <div class = "map">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3861.711231068752!2d121.07737857522964!3d14.558498935922895!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397c7d58a1630ab%3A0xb4b99ab17f7a01c7!2sMalinao%2C%20Pasig%2C%20Metro%20Manila!5e0!3m2!1sen!2sph!4v1715935740209!5m2!1sen!2sph" width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
      </div>

      <div class = "contact-footer">
        <h3>Follow Us</h3>
        <div class = "social-links">
          <a href = "https://web.facebook.com/ProgresibongBarangayMalinao" class = "fab fa-facebook-f"></a>
          <a href = "https://twitter.com/progresibong" class = "fab fa-twitter"></a>
        </div>
      </div>
    </section>

    

  </body>
</html>