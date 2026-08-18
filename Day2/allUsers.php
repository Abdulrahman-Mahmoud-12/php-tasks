<?php
session_start();

// Guard Clause: Redirect to login if not authenticated
if (!isset($_SESSION["isLoggedIn"]) || $_SESSION["isLoggedIn"] !== true) {
    header("location: login.php?error_message=Please login first to access this page!");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Users Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php require "./home.php"; ?>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>All Users Data</h2>
            <a href="server.php?action=logout" class="btn btn-danger">Logout</a>
        </div>

        <?php if (isset($_GET["message"])): ?>
            <div class="alert alert-info text-center mb-3"><?= $_GET["message"] ?></div>
        <?php endif; ?>

        <table class="table table-bordered table-striped text-center">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($_SESSION["usersData"])): ?>
                    <?php foreach ($_SESSION["usersData"] as $index => $user): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= $user["userName"] ?></td>
                            <td><?= $user["userEmail"] ?></td>
                            <td><?= $user["userPhone"] ?></td>
                            <td>
                                <a href="editUser.php?id=<?= $index ?>" class="btn btn-warning btn-sm">Update</a>
                                <a href="server.php?action=delete&id=<?= $index ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No users found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>