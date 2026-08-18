<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php require "./home.php"; ?>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Register</h2>
        <form action="server.php" method="post" class="border border-primary rounded p-4 w-50 m-auto">
            <div class="mb-3">
                <label for="userName" class="form-label">Full Name</label>
                <input class="form-control" type="text" name="userName" id="userName" required>
            </div>
            <div class="mb-3">
                <label for="userEmail" class="form-label">Email Address</label>
                <input class="form-control" type="email" name="userEmail" id="userEmail" required>
            </div>
            <div class="mb-3">
                <label for="userPhone" class="form-label">Phone Number</label>
                <input class="form-control" type="text" name="userPhone" id="userPhone" required>
            </div>
            <div class="mb-3">
                <label for="userPassword" class="form-label">Password</label>
                <input class="form-control" type="password" name="userPassword" id="userPassword" required>
            </div>
            <input class="btn btn-primary w-100 mt-2" type="submit" value="Register" name="btn-register">
        </form>
    </div>
</body>
</html>