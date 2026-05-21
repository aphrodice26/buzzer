<?php
$conn = mysqli_connect("localhost","root","","student_db");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$query = mysqli_query($conn,"SELECT * FROM student_data");
?>

<!DOCTYPE html>
<html>
<head>
<style>
body{
    font-family: Arial;
    background: #f4f4f4;
    padding: 22px;
}

/* table */
table{
    width: 60%;
    margin: auto;
    border-collapse: collapse;
    background: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0px 4px 10px rgba(18, 15, 15, 0.384);
}

th{
    background: green;
    color: white;
    padding: 12px;
}

td{
    border: 1px solid #ddd;
    padding: 12px;
    text-align: center;
}

tr:hover{
    background: #f1f1f1;
}
</style>
</head>

<body>

<table>
<tr>
    <th>ID</th>
    <th>Distance</th>
    <th>Data</th>
    <th>Time</th>   
</tr>

<?php while($row = mysqli_fetch_assoc($query)) { ?>
<tr>
    <td><?php echo $row['ID']; ?></td>
    <td><?php echo $row['distance']; ?></td>
    <td><?php echo $row['data']; ?></td>
    <td><?php echo $row['time']; ?></td>
</tr>
<?php } ?>

</table>

</body>
</html>