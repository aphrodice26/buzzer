<?php

$conn = mysqli_connect("localhost","root","","Motion_db");

?>

<!DOCTYPE html>
<html>
<head>

<title>Motion Detection Dashboard</title>

<style>

body{
    font-family: Arial;
    background:#f4f4f4;
    padding:20px;
}

table{
    width:100%;
    border-collapse: collapse;
    background:white;
}

table th, table td{
    border:1px solid #000;
    padding:10px;
    text-align:center;
}

th{
    background:blue;
    color:white;
}

h1{
    text-align:center;
}

</style>

</head>

<body>

<h1>Motion Detection Dashboard</h1>

<table>

<tr>
    <th>ID</th>
    <th>Motion Detected</th>
    <th>Timestamp</th>
</tr>

<?php

$query = mysqli_query($conn,
"SELECT * FROM Motion_data ORDER BY Id DESC");

while($row = mysqli_fetch_assoc($query)){

?>

<tr>
    <td><?php echo $row['Id']; ?></td>
    <td><?php echo $row['Motion_Detected']; ?></td>
    <td><?php echo $row['timestamp']; ?></td>
</tr>

<?php } ?>

</table>

</body>
</html>