<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Table</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-5">

<?php
$data = [
    ["name" => "basmala",
    "address" => "cairo"],
    ["name" => "habiba",
    "address" => "sadat"],
    ["name" => "mohammed",
    "address" => "menoufia"]
];
?>

<div class="container">
    <h2 class="mb-4">User Directory</h2>
    <table class="table table-bordered table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Address</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $id = 1;
            foreach ($data as $user) {
                echo "<tr>";
                echo "<td>" . $id++ . "</td>";
                echo "<td>" . ucfirst($user['name']) . "</td>";
                echo "<td>" . ucfirst($user['address']) . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>