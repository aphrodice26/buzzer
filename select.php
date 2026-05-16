<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "motion_db";


$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    echo"Connection failed: "

}
else
  cho "Connected successfully";
$data=json_decode(file_get_contents)
(http:/input),true);
if($data)
  {$distance=$data["distance"];}
$insert=mysqli_query($conn,"INSERT INTO motion_table(distance) VALUES('$distance')");
if(insert)
  {echo"Data inserted successfully";}
else
  {echo"Error inserting data: " . mysqli_error($conn);}
else
  {echo"No data received";}
?>