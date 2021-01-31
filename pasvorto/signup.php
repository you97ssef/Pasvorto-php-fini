<?php
    session_start();
    if(isset($_SESSION['userId'])){
        header('Location: ./pasvorto.php?nb=AlreadyLoggedIn');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="./content/Images/data_encryption_48px.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
    <link rel="stylesheet" href="./content/signin.css">
    <!-- Bootstrap core CSS -->
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <!-- jQuery and JS bundle w/ Popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</head>


<body class="text-center text-white bg-dark">
    
    <form class="form-signin" method="post" action="./includes/signup.inc.php">
    <?php 
        if (isset($_GET['success'])) {
            echo '<div class="alert alert-info" role="alert">
            ' . $_GET['success'] . '
          </div>';
        } else if (isset($_GET['error'])) {
            echo '<div class="alert alert-danger" role="alert">
            ' . $_GET['error'] . '
          </div>';
        }
    ?>
        <img class="mb-4" src="./content/Images/circled_user_male_skin_type_7_100px.png" alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">Create Account</h1>
        <label for="un" class="sr-only">Username</label>
        <input type="text" name="un" class="form-control" placeholder="Username..." required autofocus>
        <label for="pwd" class="sr-only">Password</label>
        <input type="password" id="pwd" name="pwd" class="form-control" placeholder="Password..." required>
        <label for="cpwd" class="sr-only">Confirm Password</label>
        <input type="password" id="cpwd" name="cpwd" class="form-control" placeholder="Confirm Password" required>
        <button class="btn btn-lg btn-success btn-block" type="submit" name="signup-submit" style="margin-bottom:10px;">Create Account</button>
        <a href="index.php" class="mt-2">Log in!</a>
    </form>
    <div class="footer text-dark">
        <div class="container">
            <div class="row align-items-center p-2">
                <div class="col-sm mt-2">
                    <h6>© 2020 Copyright: <a href="#">Youssef BAHI</a></h6>
                </div>
            </div>
        </div>
    </div>
</body>

</html>