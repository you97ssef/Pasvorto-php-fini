<?php

$servername = "sql209.epizy.com";
$dBUsername = "epiz_27337430";
$dBPassword = "5iIUyuSi8jB";
$dBName = "epiz_27337430_pasvorto";

$conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);

if(!$conn){
    die("Connection failed : " . mysqli_connect_error());
}