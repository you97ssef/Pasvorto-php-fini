<?php

if(isset($_POST['login-submit'])){

    require 'dbh.inc.php';

    $uid = $_POST['un'];
    $pwd = $_POST['pwd'];

    if(empty($uid) || empty($pwd)){
        header("Location: ../index.php?error=emptyfields");
        exit();
    } else {
        $sql = "SELECT * FROM users WHERE userName=?;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../index.php?error=Sqlerror");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $uid);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if ($row = mysqli_fetch_assoc($result)) {
                $pwdcheck = password_verify($pwd, $row['passwordUser']);
                if($pwdcheck == false) {
                    header("Location: ../index.php?error=WrongPassword" .strlen($row['passwordUser']));
                    exit();
                } else if($pwdcheck == true) {
                    session_start();
                    $_SESSION['userName'] = $row['userName'];
                    $_SESSION['userId'] = $row['idUser'];
                    header("Location: ../pasvorto.php?succes=LoggedIn");
                    exit();
                } else {
                    header("Location: ../index.php?error=Error");
                    exit();
                }
            } else {
                header("Location: ../index.php?error=NoUserFound");
                exit();
            }
        }
    }

} else {
    header("Location: ../index.php");
    exit();
}