<?php

$conn = new mysqli("localhost", "root", "", "iot_security");

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

$latest = $conn->query("
    SELECT *
    FROM security_data
    ORDER BY id DESC
    LIMIT 1
");

$data = $latest->fetch_assoc();

$totalRecords = $conn->query("
    SELECT COUNT(*) AS total
    FROM security_data
")->fetch_assoc()['total'];

$totalAlerts = $conn->query("
    SELECT COUNT(*) AS alerts
    FROM security_data
    WHERE status='Intruder Detected'
")->fetch_assoc()['alerts'];

?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ESP32 Security Dashboard</title>

```
<meta http-equiv="refresh" content="5">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
```

</head>

<body class="bg-light">

<div class="container mt-4">

```
<h1 class="text-center mb-4">
    ESP32 Security Dashboard
</h1>

<div class="row">

    <div class="col-md-4">
        <div class="card bg-primary text-white mb-3">
            <div class="card-body">
                <h5>Total Records</h5>
                <h2><?= $totalRecords ?></h2>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card bg-danger text-white mb-3">
            <div class="card-body">
                <h5>Total Alerts</h5>
                <h2><?= $totalAlerts ?></h2>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card bg-success text-white mb-3">
            <div class="card-body">
                <h5>Current Distance</h5>
                <h2>
                    <?= isset($data['distance']) ? $data['distance'] . ' cm' : 'N/A'; ?>
                </h2>
            </div>
        </div>
    </div>

</div>

<div class="card shadow">

    <div class="card-header bg-dark text-white">
        Latest Sensor Reading
    </div>

    <div class="card-body">

        <?php if ($data) : ?>

            <h4>
                Distance:
                <strong><?= $data['distance']; ?> cm</strong>
            </h4>

            <h4>
                Status:

                <?php if ($data['status'] == "Intruder Detected") : ?>
                    <span class="badge bg-danger">
                        <?= $data['status']; ?>
                    </span>
                <?php else : ?>
                    <span class="badge bg-success">
                        <?= $data['status']; ?>
                    </span>
                <?php endif; ?>

            </h4>

            <h5>
                Last Update:
                <?= $data['created_at']; ?>
            </h5>

        <?php else : ?>

            <p>No data available.</p>

        <?php endif; ?>

    </div>

</div>

<div class="card shadow mt-4">

    <div class="card-header bg-primary text-white">
        Sensor History
    </div>

    <div class="card-body">

        <table class="table table-bordered table-striped">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Distance (cm)</th>
                    <th>Status</th>
                    <th>Date & Time</th>
                </tr>
            </thead>

            <tbody>

            <?php

            $history = $conn->query("
                SELECT *
                FROM security_data
                ORDER BY id DESC
                LIMIT 20
            ");

            while ($row = $history->fetch_assoc()) :

            ?>

                <tr>
                    <td><?= $row['id']; ?></td>
                    <td><?= $row['distance']; ?></td>

                    <td>
                        <?php if ($row['status'] == "Intruder Detected") : ?>
                            <span class="badge bg-danger">
                                Intruder Detected
                            </span>
                        <?php else : ?>
                            <span class="badge bg-success">
                                Safe
                            </span>
                        <?php endif; ?>
                    </td>

                    <td><?= $row['created_at']; ?></td>
                </tr>

            <?php endwhile; ?>

            </tbody>

        </table>

    </div>

</div>
```

</div>

</body>
</html>

<?php
$conn->close();
?>
