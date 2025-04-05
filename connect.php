<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "student_rostebr_db"; 


// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql= "CREATE DATABASE student_roster_db";
if(mysqli_query($conn, $sql)){
    echo "database are created";
}
else{
    echo "database are failed". $conn->connect_error; 
}


?>
