<?php
    if (isset($_POST['signup-submit'])) {
        require 'dbh.inc.php';

        $user = $_POST['un'];
        $pwd = $_POST['pwd'];
        $cpwd = $_POST['cpwd'];

        if(empty($user) || empty($pwd) || empty($cpwd))
        {
            header("Location: ../signup.php?error=empty fields&uid=".$user);
            exit();// exit this php file without finishing the rest
        }
        else if(!preg_match("/^[a-zA-Z0-9]*$/", $user)) {//checking a correct username
            header("Location: ../signup.php?error=invalid Username");
            exit();// exit this php file without finishing the rest
        }
        else if($pwd !== $cpwd) {//checking a correct username
            header("Location: ../signup.php?error=Passwords dont match&uid=".$user);
            exit();// exit this php file without finishing the rest
        }
        else{

            $sql = "SELECT userName FROM users WHERE userName=?";
            $stmt = mysqli_stmt_init($conn);

            if(!mysqli_stmt_prepare($stmt, $sql)){
                header("Location: ../signup.php?error=SqlError");
                exit();
            } else {
                mysqli_stmt_bind_param($stmt, "s", $user);//s => string , i => int , b => blob, d => double
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                $resultCheck = mysqli_stmt_num_rows($stmt);
                if($resultCheck > 0)
                {
                    header("Location: ../signup.php?error=UserTaken");
                    exit();
                } else {
                    $sql = "INSERT INTO `users` (`userName`, `passwordUser`) VALUES (?, ?)";
                    $stmt = mysqli_stmt_init($conn);
                    if(!mysqli_stmt_prepare($stmt, $sql)){
                        header("Location: ../signup.php?error=SqlError");
                        exit();
                    } else {
                        $hashPwd = password_hash($pwd, PASSWORD_DEFAULT);
                        mysqli_stmt_bind_param($stmt, "ss", $user, $hashPwd);//s => string , i => int , b => blob, d => double
                        mysqli_stmt_execute($stmt);
                        header("Location: ../signup.php?success=Account Created Succesfully");
                        exit();
                    }
                }
            }
        }
        //to save ressources on page
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }
    else {
        header("Location: ../signup.php");
        exit();
    }