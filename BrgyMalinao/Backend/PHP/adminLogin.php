<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Sign In</title>
    <link rel="stylesheet" type="text/css" href="http://localhost/BrgyMalinao/Backend/CSS/adminLogin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<?php
        include 'database.php'; 

        $emailUsedDisplay = "  ";
        $emailAlreadyUsedDisplay = " ";
        $passwordIncorrectDisplay = " ";

       
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['action']) && $_POST['action'] == 'signin' && isset($_POST['email']) && isset($_POST['pword'])) {
                $email = $_POST['email'];
                $password = $_POST['pword'];

              
                $check_email_sql = "SELECT * FROM admin_signup WHERE email='$email'";
                $check_email_result = $con->query($check_email_sql);

                if ($check_email_result->num_rows > 0) {
                    
                    $sql = "SELECT * FROM admin_signup WHERE email='$email' AND pword='$password'";
                    $result = $con->query($sql);

                    if ($result->num_rows > 0) {
                        session_start();
                        $row = $result->fetch_assoc();
                        $_SESSION['id'] = $row['id']; 
                        $_SESSION['email'] = $email;
                        header("Location: Dashboard.php?id=" . $row['id']); 
                        exit(); 
                    } else {
                     
                        $passwordIncorrectDisplay = "block";
                    }
                } else {
                    
                    $emailAlreadyUsedDisplay = "block";
                }
            }

            if (isset($_POST['action']) && $_POST['action'] == 'signup' && isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['pword'])) {
                $fname = $_POST['firstname'];
                $lname = $_POST['lastname'];
                $email = $_POST['email'];
                $password = $_POST['pword'];

             
                $check_existing_email_sql = "SELECT * FROM admin_signup WHERE email='$email'";
                $check_existing_email_result = $con->query($check_existing_email_sql);

                if ($check_existing_email_result->num_rows > 0) {
                    echo "<script>alert('Email Already Used!');</script>";
                } else {
                    $sql = "INSERT INTO admin_signup (firstname, lastname, email, pword) VALUES ('$fname', '$lname', '$email', '$password')";

                    if (mysqli_query($con, $sql)) {
                      
                        echo "<script>alert('Sign Up successfully!');</script>";
                    } else {
                        echo "Error: " . $sql . "<br>" . mysqli_error($con);
                    }
                }
            }
        }
    ?>
    <header>
        <div class="header-content">
            <div class="logo-container">
                <img src="http://localhost/BrgyMalinao/Backend/images/BbrgyMalinaoLogo.png" alt="Logo of Malinao">
                <span>Barangay Malinao, Pasig City</span>
            </div>
        </div>
    </header>
    <!--SIGN UP-->
    <div class="container" id="container">
        <div class="form-container sign-up-container">
            <form method="post">
                <h1>Create Account</h1>
                <br>
                <div class="col">
                    <div class="one">
                        <input type="text" id="Firstname" placeholder="Firstname" name="firstname" required />
                    </div>
                    <div>
                        <input type="text" id="Lastname" placeholder="Lastname" name="lastname" required />
                    </div>
                </div>
                <input type="email" id="email" placeholder="Email" name="email" required />
                <div class="password-container">
                    <input type="password" id="password" placeholder="Password" name="pword" required />
                    <i class="fas fa-eye" id="togglePassword"></i>
                </div>
                <div class="password-container">
                    <input type="password" id="confirmPassword" placeholder="Confirm Password" required />
                    <i class="fas fa-eye" id="toggleConfirmPassword"></i>
                </div>
                <br>
                <div id="passwordMismatch" class="error-message" style="display: none;">Passwords do not match</div>                 
                <br>
                <button type="submit" name="action" value="signup">Sign Up</button>
            </form>
        </div>
        <!--SIGN IN-->
        <div class="form-container sign-in-container">
            <form method="post">
                <h1>Sign in</h1>
                <br>
                <input type="email" placeholder="Email" name="email" required/>
                <input type="password" placeholder="Password" name="pword" />
                <br>
                <!-- Display error messages -->
                <div id="passwordIncorrect" class="error-message" style="display: <?php echo $passwordIncorrectDisplay; ?>">Wrong password. Please try again.</div>
                <div id="emailAlreadyUsed" class="error-message" style="display: <?php echo $emailAlreadyUsedDisplay; ?>">Account not Found</div>
                <br>
                <a href="sendotp.php">Forgot your password?</a>
                <br>
                <button type="submit" name="action" value="signin">Sign In</button>
            </form>
        </div>

        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Admin Login</h1>
                    <br>
                    <p>To manage the system, please log in with your admin credentials</p>
                    <br>
                    <button class="ghost" id="signIn">Sign In</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Administrator Access</h1>
                    <br>
                    <p>Don't have an account yet? Sign up to access the admin portal.</p>
                    <br>
                    <button class="ghost" id="signUp">Sign Up</button>
                </div>
            </div>
        </div>
    </div>

    <script src="http://localhost/BrgyMalinao/Backend/JS/adminLogin.js"></script>
    <script src="http://localhost/BrgyMalinao/Backend/JS/adminpopup.js"></script>

    <script>
        function clearErrorMessages() {
            document.getElementById('passwordIncorrect').style.display = 'none';
            document.getElementById('emailAlreadyUsed').style.display = 'none';
            document.getElementById('passwordMismatch').style.display = 'none'; 

            document.getElementById('Firstname').value = '';
            document.getElementById('Lastname').value = '';
            document.getElementById('email').value = '';
            document.getElementById('password').value = '';
            document.getElementById('confirmPassword').value = '';
        }

        document.getElementById('signIn').addEventListener('click', clearErrorMessages);
        document.getElementById('signUp').addEventListener('click', clearErrorMessages);

        if (performance.navigation.type === 1) {
            clearErrorMessages();
        }

      
        document.getElementById('openpopup').addEventListener('click', function () {
            document.getElementById('passwordResetPopup').classList.add('active');
        });

        document.querySelectorAll('.close').forEach(function (closeButton) {
            closeButton.addEventListener('click', function () {
                closeButton.parentElement.parentElement.classList.remove('active');
            });
        });

   
        document.getElementById('resetPasswordForm').addEventListener('submit', function (event) {
            document.getElementById('passwordResetPopup').classList.remove('active');
            document.getElementById('OtpPopUp').classList.add('active');
        });

        document.getElementById('verifyOTPForm').addEventListener('submit', function (event) {
         
            document.getElementById('OtpPopUp').classList.remove('active');
            document.getElementById('newPasswordPopup').classList.add('active');
        });

        document.getElementById('setNewPasswordForm').addEventListener('submit', function (event) {
          
            document.getElementById('newPasswordPopup').classList.remove('active');
            alert('Password has been reset successfully');
        });
    </script>
</body>
</html>
