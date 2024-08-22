<?php
$server = "localhost";
$username = "root";
$password = "";
$dbname = "kio";
$conn =new mysqli($server, $username, $password, $dbname);


//check connection code
// if($conn -> connect_error){
//     die("connection failed" . $conn->error);
// }
// else{
//     echo "connection successfully done";
// }
?>