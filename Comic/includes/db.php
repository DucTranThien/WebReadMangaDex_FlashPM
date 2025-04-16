<?php
$host = "localhost";
$port = 3306; 
$user = "root";  
$pass = "";    
$dbname = "comic_db1";

$conn = new mysqli($host, $user, $pass, $dbname, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>