<?php
require "./connection.php";

$table = $_GET['table'] ?? 'employees';
$id = $_GET['id'] ?? null;
$record = null;

if ($id) {
    $record = $db->show($table, $id);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $id ? 'Edit' : 'Add' ?> <?= ucfirst($table) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">
    <div class="col-md-6 offset-md-3">
        <h2 class="mb-4 text-center"><?= $id ? 'Edit' : 'Add New' ?> <?= ucfirst($table) ?></h2>
        
        <form action="server.php?action=save&table=<?= $table ?>" method="POST" class="border p-4 shadow-sm rounded">
            <?php if ($id): ?>
                <input type="hidden" name="id" value="<?= $record['id'] ?>">
            <?php endif; ?>

            <!-- Field 1: Name -->
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($record['name'] ?? $record['title'] ?? '') ?>" required>
            </div>

            <!-- Field 2: Email (For Employees only) -->
            <?php if ($table === 'employees'): ?>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($record['email'] ?? '') ?>" required>
                </div>
            <?php endif; ?>

            <button type="submit" class="btn btn-success w-100">Save Data</button>
            <a href="index.php" class="btn btn-secondary w-100 mt-2">Cancel</a>
        </form>
    </div>
</body>
</html>