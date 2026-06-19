<?php
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['email']) && isset($_POST['current_password']) && isset($_POST['pword']) && isset($_POST['confirm_password'])) {
        $email = $_POST['email'];
        $current_password = $_POST['current_password'];
        $new_password = $_POST['pword'];
        $confirm_password = $_POST['confirm_password'];

    
        if ($new_password !== $confirm_password) {
         
            echo "<script>alert('Passwords do not match');</script>";
        } else {
       
            $query = "SELECT * FROM admin_signup WHERE email='$email' AND pword='$current_password'";
            $result = mysqli_query($con, $query); 

            if (mysqli_num_rows($result) == 1) {
             
                $update_query = "UPDATE admin_signup SET pword='$new_password' WHERE email='$email'";
                $update_result = mysqli_query($con, $update_query); 

                if ($update_result) {
               
                    echo "<script>alert('Password updated successfully');</script>";
                } else {
                  
                    echo "<script>alert('Failed to update password');</script>";
                }
            } else {
               
                echo "<script>alert('Incorrect current password');</script>";
            }
        }
    } else {
      
        echo "<script>alert('All fields are required');</script>";
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <title>System Settings</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="http://localhost/BrgyMalinao/Backend/CSS/passwordModal.css">
    <link rel="stylesheet" type="text/css" href="http://localhost/BrgyMalinao/Backend/CSS/SideBar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div id="passwordSettingsModal" class="modal7">
        <div class="modal-content7">
            <div class="col7">
                <div class="bg7">
                    <span class="txt7">Password <br> Settings</span>
                </div>
            </div>
            <div class="col7">
                <span class="close-btn7" onclick="closeModal('passwordSettingsModal')">&times;</span>
                <div class="align7">
                <form id="passwordSettingsForm" method="post">
                    <div class="form-group">
                        <label for="email">Email:</label> <br>
                        <input type="email" id="Settings-email" name="email" value="" required >
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="current-password">Current Password:</label> <br>
                        <input type="password" id="current-password7" name="current_password" required>
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="new-password">New Password:</label> <br>
                        <input type="password" id="new-password7" name="pword" required>
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="confirm-password">Confirm Password:</label> <br>
                        <input type="password" id="confirm-password7" name="confirm_password" required>
                    </div>
                    <br>
                    <div id="error-message" class="error-message" style="display: none;">Passwords do not match</div>
                    <div class="action-buttons">
                        <button type="submit" id="update-button7" class="button7">Update</button>
                        <button type="button" id="cancel-button7" class="button7" onclick="closeModal('passwordSettingsModal')">Cancel</button>
                    </div>
                </form>
                </div>
                <?php if (isset($_POST['email']) && isset($_POST['pword'])): ?>
                <div>
                    <span>Email: </span>
                    <span><?php echo htmlspecialchars($_POST['email']); ?></span>
                </div>

                <div>
                    <span>New Password: </span>
                    <span><?php echo htmlspecialchars($_POST['pword']); ?></span>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>

    </script>
</body>
</html>
