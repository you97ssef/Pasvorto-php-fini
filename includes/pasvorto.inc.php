<?php


session_start();

if(isset($_POST["delete"])){
    require 'dbh.inc.php';

    $idP = $_GET['id'];

    $sql = "DELETE FROM passwords WHERE idPassword=?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: ../pasvorto.php?error=SqlError");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "i", $idP);
        mysqli_stmt_execute($stmt);
        header("Location: ../pasvorto.php?Remove=success");
        exit();
    }
}

if(isset($_POST["confirmp"])){
    require 'dbh.inc.php';

    $mode = $_GET['mode'];
    $provider = $_POST['provider'];
    $username = $_POST['user'];
    $password = $_POST['password'];
    if($mode == 'add'){
        $sql = "INSERT INTO passwords (`idUser`, `provider`, `user`, `passwordUser`) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("Location: ../pasvorto.php?error=SqlError");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "isss", $_SESSION['userId'], $provider, $username, $password);//s => string , i => int , b => blob, d => double
            mysqli_stmt_execute($stmt);
            header("Location: ../pasvorto.php?Add=success");
            exit();
        }
    } else {
        $idP = $_GET['id'];
        $sql = "UPDATE passwords SET `provider`=?, `user`=?, `passwordUser`=? WHERE idPassword=?";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("Location: ../pasvorto.php?error=SqlError");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "sssi", $provider, $username, $password, $idP);//s => string , i => int , b => blob, d => double
            mysqli_stmt_execute($stmt);
            header("Location: ../pasvorto.php?Modify=success");
            exit();
        }
    }
}