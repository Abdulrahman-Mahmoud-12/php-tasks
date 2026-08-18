<?php
session_start();

if (!isset($_SESSION["isLoggedIn"]) || $_SESSION["isLoggedIn"] !== true) {
    header("location: login.php");
    exit;
}

$id = $_GET["id"] ?? null;
if ($id === null || !isset($_SESSION["usersData"][$id])) {
    header("location: allUsers.php");
    exit;
}

$user = $_SESSION["usersData"][$id];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php require "./home.php"; ?>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Edit User</h2>
        <form action="server.php" method="post" class="border border-warning rounded p-4 w-50 m-auto">
            <input type="hidden" name="userIndex" value="<?= $id ?>">
            <div class="mb-3">
                <label for="userName" class="form-label">Full Name</label>
                <input class="form-control" type="text" name="userName" id="userName" value="<?= $user['userName'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="userEmail" class="form-label">Email Address</label>
                <input class="form-control" type="email" name="userEmail" id="userEmail" value="<?= $user['userEmail'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="userPhone" class="form-label">Phone Number</label>
                <input class="form-control" type="text" name="userPhone" id="userPhone" value="<?= $user['userPhone'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="userPassword" class="form-label">Password</label>
                <input class="form-control" type="password" name="userPassword" id="userPassword" value="<?= $user['userPassword'] ?>" required>
            </div>
            <input class="btn btn-warning w-100 mt-2" type="submit" value="Update User" name="btn-update">
        </form>
    </div>
</body>
</html>