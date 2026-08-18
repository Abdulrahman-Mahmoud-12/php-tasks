<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php require "./home.php"; ?>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Login</h2>

        <?php if (isset($_GET["message"])): ?>
            <div class="alert alert-success w-50 m-auto text-center mb-3"><?= $_GET["message"] ?></div>
        <?php endif; ?>

        <?php if (isset($_GET["error_message"])): ?>
            <div class="alert alert-danger w-50 m-auto text-center mb-3"><?= $_GET["error_message"] ?></div>
        <?php endif; ?>

        <form action="server.php" method="post" class="border border-primary rounded p-4 w-50 m-auto">
            <div class="mb-3">
                <label for="userEmail" class="form-label">Email Address</label>
                <input class="form-control" type="email" name="userEmail" id="userEmail" required>
            </div>
            <div class="mb-3">
                <label for="userPassword" class="form-label">Password</label>
                <input class="form-control" type="password" name="userPassword" id="userPassword" required>
            </div>
            <input class="btn btn-primary w-100 mt-2" type="submit" value="Login" name="btn-login">
        </form>
    </div>
</body>
</html>