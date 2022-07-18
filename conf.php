<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "test";
$conn = mysqli_connect($host,$username,$password,$dbname);

if(!$conn){
    die("<h1 style='color:red;background:#4a47ff;padding:10px;text-align:center'></ h1>".mysqli_connect_error());
}