<?php
    session_start();
    if(!isset($_SESSION['userId'])){
        header("Location: ./index.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="./content/Images/data_encryption_48px.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pasvorto</title>
    <style>
        .td{
            word-wrap:break-word;
        }
        table {
            table-layout:fixed;
            width:100%;
        }
        
    </style>
    <!-- Bootstrap core CSS -->
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <!-- jQuery and JS bundle w/ Popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</head>
<body class="text-white bg-dark">
    <header>
        <nav class="navbar navbar-light" style="background-color: #e3f2fd;">
            <div class="navbar-brand mr-auto">Pasvorto by: <a href="#" class="badge badge-info">Youssef BAHI</a></div>
            <form class="form-inline" action="includes/logout.inc.php" method="post">
                <button class="btn btn-outline-danger my-2 my-sm-0" type="submit">Deconnect</button>
            </form>
        </nav>
    </header>
    <main class="p-2">
        <div class="container">
            <div class="row">
                <table class="table table-secondary table-bordered table-hover">
                    <thead class="thead-secondary">
                        <tr>
                            <th scope="col">Provider</th>
                            <th scope="col">User</th>
                            <th scope="col">Password</th>
                            <th scope="col"></th>
                            <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            require './includes/dbh.inc.php';

                            $sql = "SELECT * FROM passwords WHERE idUser=?;";

                            $stmt = mysqli_stmt_init($conn);
                            if (!mysqli_stmt_prepare($stmt, $sql)) {
                                header("Location: ../index.php?error=Sqlerror");
                                exit();
                            } else {
                                mysqli_stmt_bind_param($stmt, "s", $_SESSION['userId']);
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);
                                while($row = mysqli_fetch_array($result)){
                                    echo '<tr><th class="td" scope="row" id="prov'.$row['idPassword'].'">'.$row['provider'].'</th>
                                        <td class="td" id="use'.$row['idPassword'].'">'.$row['user'].'</td>
                                        <td class="td" id="passw'.$row['idPassword'].'">'.$row['passwordUser'].'</td>
                                        <td><button type="button" class="btn btn-sm btn-outline-primary" onclick="SelectP(true,'.$row['idPassword'].')">Select</button></td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-outline-danger" data-toggle="modal" data-target="#DeleteRow" onclick="Delete('.$row['idPassword'].',\''.$row['provider'].'\')">
                                                Delete
                                            </button>
                                        </td></tr>';
                                }
                            }
                        ?>
                    </tbody>
                </table>  
            </div>
        </div>
        <form method="post" action="./includes/pasvorto.inc.php?mode=add" id="frmconfirm">
        <div class="row m-3">
            <div class="col">
                <input class="form-control" type="text" name="provider" id="prv" placeholder="provider">
            </div>
        </div>
        <div class="row m-3">
            <div class="col">
                <div class="input-group">
                    <input class="form-control" type="text" id="u" name="user" placeholder="user">
                    <div class="input-group-append">
                        <button class="btn btn-secondary" type="button" onclick="CopyUser('user')">Copy</button>
                    </div> 
                </div>   
            </div>
            <div class="col">
                <div class="row">
                    <div class="col">
                        <div class="input-group">
                            <select class="custom-select" id="lus">
                            </select>
                            <div class="input-group-append">
                                <button type="button" class="btn btn-outline-light" onclick="GenerateUser()">Generate</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row m-3">
            <div class="col">
                <div class="input-group mb-3">
                    <input class="form-control" type="text" id="pwd" name="password" placeholder="password">
                    <div class="input-group-append">
                        <button class="btn btn-secondary" onclick="CopyUser('pwd')" type="button">Copy</button>
                    </div>    
                </div>
            </div>
            <div class="col">
                <div class="row">
                    <div class="col">
                        <div class="input-group">
                            <select class="custom-select" id="lp">
                            </select>
                            <div class="input-group-append">
                                <button type="button" class="btn btn-outline-light" onclick="GeneratePwd()">Generate</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row m-3" id="confirmdiv">
            <button class="btn btn-outline-primary m-auto" type="submit" name="confirmp" id="confirmbtn">Add Pasvorto</button>
        </div>
        </form>
    </main>

    <div class="modal fade bg-dark" id="DeleteRow" tabindex="-1" role="dialog" aria-labelledby="DeleteRowLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content text-dark">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Deletion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure want to delete this row
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <form id="frmDel" method="post">
                        <button class="btn btn-danger" name="delete" type="submit">Delete it</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        for(i = 1; i < 31; i++){
            var sel = document.getElementById('lus');
            var sel2 = document.getElementById('lp');
            var opt = document.createElement('option');
            var opt2 = document.createElement('option');
            opt.appendChild( document.createTextNode(i) );
            opt2.appendChild( document.createTextNode(i) );
            opt.value = i; 
            opt2.value = i; 
            sel.appendChild(opt); 
            sel2.appendChild(opt2); 
        }
        function Delete(id, prv) {
            document.getElementsByClassName("modal-body").item(0).innerHTML = "Are you sure want to delete " + prv;
            document.getElementById("frmDel").setAttribute("action","./includes/pasvorto.inc.php?id=" + id);
        }
        function CopyUser(txt) {
            var cpyText;
            if(txt == 'user'){
                cpyText = document.getElementById("u");
            }
            else if(txt == 'pwd'){
                cpyText = document.getElementById("pwd");
            }
            cpyText.select();
            cpyText.setSelectionRange(0, 99999);
            document.execCommand("copy");
        }
        function makeText(length) {
            var result           = '';
            var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                var charactersLength = characters.length;
            for ( var i = 0; i < length; i++ ) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }
            return result;
        }
        function GenerateUser(){
            document.getElementById("u").value = makeText(document.getElementById("lus").value);
        }
        function GeneratePwd(){
            document.getElementById("pwd").value = makeText(document.getElementById("lp").value);
        }

        function SelectP(mode, id){            
            if(mode == true && document.getElementById('confirmbtn').innerText != 'Modify Pasvorto'){
                document.getElementById("prv").value = document.getElementById("prov" + id).innerText;
                document.getElementById("u").value = document.getElementById("use" + id).innerText;
                document.getElementById("pwd").value = document.getElementById("passw" + id).innerText;
                document.getElementById('confirmbtn').innerText = 'Modify Pasvorto';
                document.getElementById('confirmdiv').innerHTML += '<button class="btn btn-outline-info m-auto" type="button" id="gbta" onclick="SelectP(false)">Go back to add</button>';
                document.getElementById("frmconfirm").setAttribute("action","./includes/pasvorto.inc.php?mode=Modify&id=" + id);
            } else{
                document.getElementById('confirmbtn').innerText = 'Add Pasvorto';
                document.getElementById('gbta').remove();
                document.getElementById("frmconfirm").setAttribute("action","./includes/pasvorto.inc.php?mode=add");
            }
        }
    </script>
</body>
</html>