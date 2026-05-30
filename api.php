<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "iot_security";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    echo "Connection failed";
} else {
    echo "Connection successful<br>";
}

$distance = 45.7;
$status = "Intruder Detected";
$time = date("Y-m-d H:i:s");

$sql = "INSERT INTO security_data (distance, status, created_at)
        VALUES ('$distance', '$status', '$time')";

if ($conn->query($sql) === TRUE) {
    echo "Data inserted successfully";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();

?>