<?php
session_start();
error_reporting(0);
if(isset($_POST["recover"])){
    include('database.php');
    $email = $_POST["email"];

    $sql = mysqli_query($con, "SELECT * FROM admin_signup WHERE email='$email'");
    $query = mysqli_num_rows($sql);
    $fetch = mysqli_fetch_assoc($sql);

    if(mysqli_num_rows($sql) <= 0){
        ?>
        <script>
            alert("<?php  echo "Sorry, no emails exists "?>");
        </script>
        <?php
    }else if($fetch["status"] == 1){
        ?>
           <script>
               alert("Sorry, your account must verify first, before you recover your password!");
               window.location.replace("adminLogin.php");
           </script>
       <?php
    }else{

        $token = bin2hex(random_bytes(50));

        //session_start ();
        $_SESSION['token'] = $token;
        $_SESSION['email'] = $email;

        require "Mail/phpmailer/PHPMailerAutoload.php";
        $mail = new PHPMailer;

        $mail->isSMTP();
        $mail->Host='smtp.gmail.com';
        $mail->Port=587;
        $mail->SMTPAuth=true;
        $mail->SMTPSecure='tls';

        $mail->Username='garcia_reignalynjewel@plpasig.edu.ph';
        $mail->Password='tmucciwcpsgphlee';

        $mail->setFrom('garcia_reignalynjewel@plpasig.edu.ph', 'Password Reset');

        $mail->addAddress($_POST["email"]);

        $mail->isHTML(true);
        $mail->Subject="Recover your password";
        $mail->Body="<b>Dear User</b>
        <h3>We received a request to reset your password.</h3>
        <p>Kindly click the below link to reset your password</p>
        http://localhost/BrgyMalinao/Backend/PHP/forgotpass.php
        <br><br>
        <p>With regrads,</p>
        <b>Group#</b>";

        if(!$mail->send()){
            ?>
                <script>
                    alert("<?php echo " Invalid Email "?>");
                </script>
            <?php
        }else{
            ?>
                <script>
                        alert("<?php echo "Check your Email Inbox!"?>");
                </script>
            <?php
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Forgot Password</title>
        <link rel="stylesheet" type="text/css" href="http://localhost/BrgyMalinao/Backend/CSS/forgpass.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    </head>

    <header>
        <div class="header-content">
            <div class="logo-container">
                <img src="http://localhost/BrgyMalinao/Backend/images/BbrgyMalinaoLogo.png" alt="Logo of Malinao">
                <span>Barangay Malinao, Pasig City</span>
            </div>
        </div>
    </header>

    <body>
        <div class="container" id="container">
            <div class="form-container sign-in-container">
                <form action="#" method="POST" name="recover_psw">
                    <h1 class="forg">Forgot Password</h1>
                    <div class="input-group mb-3">
                        <input type="email" id="email" name="email" class="form-control" placeholder="Email" required >
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <button value="Recover" name="recover" class="btn btn-primary btn-block">Send OTP</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>