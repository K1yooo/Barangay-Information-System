<?php
session_start();
error_reporting(0);
include('database.php');
if(isset($_POST['login']))
{
  $password1=($_POST['password']); 
  $password2=($_POST['password1']); 

  if($password1 != $password2) {
    echo "<script>alert('Password and Confirm Password Field do not match  !!');</script>";
  }else
  {
    $email=$_POST['email'];
    $mobile=$_POST['phone'];
    $newpassword=($_POST['password']);
    $sql ="SELECT email FROM admin_signup WHERE email=:email";
    $query= $dbh -> prepare($sql);
    $query-> bindParam(':email', $email, PDO::PARAM_STR);
    $query-> execute();
    $results = $query -> fetchAll(PDO::FETCH_OBJ);
    if($query -> rowCount() > 0)
    {
      $con="update admin_signup set pword=:newpassword where email=:email";
      $chngpwd1 = $dbh->prepare($con);
      $chngpwd1-> bindParam(':email', $email, PDO::PARAM_STR);
      $chngpwd1-> bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
      $chngpwd1->execute();
      echo "<script>alert('Your Password succesfully changed');</script>";
      echo "<script>window.location.href = 'adminLogin.php'</script>";
    }
    else {
      echo "<script>alert('Email id or Mobile no is invalid');</script>"; 
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Reset Password</title>
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
            <form action="" method="post" class="ress">
                <h1 class="res">Reset Password</h1>
                <div class="input-group mb-3">
                    <input type="text" name="email" class="form-control" placeholder="Email" required >
                    <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-envelope envolop"></span>
                    </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control"  placeholder=" New Password" required>
                    <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password1" class="form-control"placeholder=" confirm Password" required>
                    <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock lock1"></span>
                    </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                    <button name="login" class="btn btn-primary btn-block" data-toggle="modal" data-taget="#modal-default">Reset</button>
                    </div>
                </div>
            </form>
        </div>
</div>
</body>
</html>