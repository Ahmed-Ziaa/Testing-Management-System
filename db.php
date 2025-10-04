<?php
$host = "localhost";   
$user = "root";        
$pass = "ahmedzia";            
$dbname = "testingsystem";  

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
