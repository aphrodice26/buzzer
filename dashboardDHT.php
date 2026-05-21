<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Potentiometer Control</title>
    <style>
        *{margin:0;padding:0;box-sizing:border-box;}
        body{font-family:'Segoe UI',Arial,sans-serif;background:#f4f4f4;padding:22px;}
        table{width:60%;margin:auto;border-collapse:collapse;background:white;border-radius:10px;overflow:hidden;box-shadow:0px 4px 10px rgba(18,17,15,0.38);}
        th{background:green;color:white;padding:12px;}
        td{border:1px solid #ddd;padding:12px;text-align:center;}
        tr:hover{background:#f1f1f1;}
        .potentiometer-space{width:40%;margin:20px auto 0 auto;background:white;border-radius:20px;box-shadow:0px 8px 20px rgba(0,0,0,0.1);padding:28px 32px;text-align:center;}
        .slider-wrapper{margin:10px 0;padding:0 15px;}
        .slider-label{font-size:0.85rem;font-weight:600;color:#2c6e2c;margin-bottom:12px;}
        input[type="range"]{width:100%;height:8px;-webkit-appearance:none;background:linear-gradient(90deg,#2e7d32,#9ccc65);border-radius:10px;outline:none;}
        input[type="range"]::-webkit-slider-thumb{-webkit-appearance:none;width:22px;height:22px;background:#2b6e2b;border-radius:50%;cursor:pointer;border:2px solid white;box-shadow:0 1px 4px rgba(0,0,0,0.2);}
        .value-display{margin-top:15px;font-size:1.1rem;color:#1f4f1f;font-weight:600;}
        @media (max-width:800px){table,.potentiometer-space{width:95%;}}
    </style>
</head>
<body id='body'>
<table>
    <tr><th>ID</th><th>Distance</th><th>Data</th><th>Time</th></tr>
    <?php
    $conn=mysqli_connect("localhost","root","","student_db");
    if(!$conn) die("Connection failed: ".mysqli_connect_error());
    $query=mysqli_query($conn,"SELECT * FROM student_data");
    while($row=mysqli_fetch_assoc($query)) echo "<tr><td>{$row['ID']}</td><td>{$row['distance']}</td><td>{$row['data']}</td><td>{$row['time']}</td></tr>";
    ?>
</table>
<div class="potentiometer-space">
    <div class="slider-wrapper">
        <div class="slider-label">Potentiometer Control</div>
        <input type="range" id="potSlider" min="0" max="1023" value="512" step="1">
        <div class="value-display">Distance: <span id="potValue"></span> cm (<span id="percentValue">50.0</span>%)</div>
    </div>
    <button id="btn">My Button</button>
</div>
<script>
document.getElementById('btn').onclick=()=>document.getElementById('body').style.backgroundColor="black";
(function(){
    let v=512;
    const s=document.getElementById('potSlider'), ps=document.getElementById('potValue'), pct=document.getElementById('percentValue');
    s.oninput=e=>{let n=Math.min(1023,Math.max(0,parseInt(e.target.value,10)));if(n===v)return;v=n;s.value=v;ps.innerText=v;pct.innerText=((v/1023)*100).toFixed(1);};
    s.oninput({target:{value:512}});
})();
</script>
</body>
</html>
