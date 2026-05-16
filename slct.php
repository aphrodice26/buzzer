<?php
include('insert.php');

$sel = mysqli_query($conn, "SELECT * FROM motion_data");

if(mysqli_num_rows($sel) > 0){
?>

<table border="1" cellpadding="10">
    
    <tr>
        <th>ID</th>
        <th>Motion Detected</th>
        <th>Timestamp</th>
    </tr>

<?php
while($row = mysqli_fetch_assoc($sel)){
?>

    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['motion_detected']; ?></td>
        <td><?php echo $row['timestamp']; ?></td>
    </tr>

<?php
}
?>

</table>

<?php
}else{
    echo "No data found";
}
?>