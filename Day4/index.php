<?php
require "./connection.php";

$users = $db->index('users');
$employees = $db->index('employees');
$departments = $db->index('departments');
$projects = $db->index('projects');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">

    <?php if (isset($_GET['msg'])): ?>
        <div class="alert alert-success text-center"><?= htmlspecialchars($_GET['msg']) ?></div>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Dashboard</h1>
        <div>
            <a href="register.php" class="btn btn-outline-primary">Register User</a>
            <a href="login.php" class="btn btn-outline-success">Login</a>
        </div>
    </div>

    <!-- EMPLOYEES TABLE -->
    <div class="d-flex justify-content-between align-items-center mt-4 mb-2">
        <h3>Employees</h3>
        <a href="form.php?table=employees" class="btn btn-primary btn-sm">+ Add Employee</a>
    </div>
    <table class="table table-striped border">
        <thead class="table-dark">
            <tr><th>ID</th><th>Name</th><th>Email</th><th>Actions</th></tr>
        </thead>
        <tbody>
            <?php foreach ($employees as $emp): ?>
                <tr>
                    <td><?= $emp['id'] ?></td>
                    <td><?= htmlspecialchars($emp['name'] ?? '') ?></td>
                    <td><?= htmlspecialchars($emp['email'] ?? '') ?></td>
                    <td>
                        <a href="form.php?table=employees&id=<?= $emp['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="server.php?action=delete&table=employees&id=<?= $emp['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this record?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- DEPARTMENTS TABLE -->
    <div class="d-flex justify-content-between align-items-center mt-5 mb-2">
        <h3>Departments</h3>
        <a href="form.php?table=departments" class="btn btn-primary btn-sm">+ Add Department</a>
    </div>
    <table class="table table-striped border">
        <thead class="table-dark">
            <tr><th>ID</th><th>Department Name</th><th>Actions</th></tr>
        </thead>
        <tbody>
            <?php foreach ($departments as $dept): ?>
                <tr>
                    <td><?= $dept['id'] ?></td>
                    <td><?= htmlspecialchars($dept['name'] ?? '') ?></td>
                    <td>
                        <a href="form.php?table=departments&id=<?= $dept['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="server.php?action=delete&table=departments&id=<?= $dept['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this record?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- PROJECTS TABLE -->
    <div class="d-flex justify-content-between align-items-center mt-5 mb-2">
        <h3>Projects</h3>
        <a href="form.php?table=projects" class="btn btn-primary btn-sm">+ Add Project</a>
    </div>
    <table class="table table-striped border">
        <thead class="table-dark">
            <tr><th>ID</th><th>Project Name</th><th>Actions</th></tr>
        </thead>
        <tbody>
            <?php foreach ($projects as $proj): ?>
                <tr>
                    <td><?= $proj['id'] ?></td>
                    <td><?= htmlspecialchars($proj['name'] ?? $proj['title'] ?? '') ?></td>
                    <td>
                        <a href="form.php?table=projects&id=<?= $proj['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="server.php?action=delete&table=projects&id=<?= $proj['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this record?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!--  USERS LIST -->
    <h3 class="mt-5 mb-2">Registered Users</h3>
    <table class="table table-striped border">
        <thead class="table-secondary">
            <tr><th>ID</th><th>Name</th><th>Email</th></tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user['id'] ?></td>
                    <td><?= htmlspecialchars($user['name'] ?? '') ?></td>
                    <td><?= htmlspecialchars($user['email'] ?? '') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>