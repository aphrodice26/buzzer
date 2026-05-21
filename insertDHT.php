<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "student_db";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    echo "Connection failed";
} else {
    echo "Connection successful<br>";
}

$id = 213;
$distance = 56787456876;
$time = date("2026-05-20 07:37:56");
$data = "student_data";
$sql = "INSERT INTO student_data (ID, distance,time,data) 
        VALUES ('$id', '$distance', '$time','$data')";

if ($conn->query($sql) === TRUE) {
    echo "Data inserted successfully";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();

?>