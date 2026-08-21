<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">
    <div class="col-md-6 offset-md-3">
        <h2 class="text-center mb-4">Register User</h2>
        <form action="server.php" method="POST" class="border p-4 shadow-sm rounded">
            <div class="mb-3">
                <input type="text" name="userName" class="form-control" placeholder="User Name" required>
            </div>
            <div class="mb-3">
                <input type="email" name="userEmail" class="form-control" placeholder="Email Address" required>
            </div>
            <div class="mb-3">
                <input type="password" name="userPassword" class="form-control" placeholder="Password" required>
            </div>
            <button type="submit" name="btn-register" class="btn btn-primary w-100">Register</button>
            <a href="index.php" class="btn btn-link w-100 text-center mt-2">Back to Dashboard</a>
        </form>
    </div>
</body>
</html>