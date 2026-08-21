<?php
require "./connection.php";

// ? 1. REGISTER
if (isset($_POST['btn-register'])) {
    $name = $_POST['userName'];
    $email = $_POST['userEmail'];
    $password = password_hash($_POST['userPassword'], PASSWORD_DEFAULT);

    $db->create('users', [
        'name' => $name,
        'email' => $email,
        'password' => $password
    ]);

    header("location: index.php?msg=Registered Successfully");
    exit;
}

// ? 2. LOGIN
if (isset($_POST['btn-login'])) {
    $email = $_POST['userEmail'];
    $password = $_POST['userPassword'];

    $user = $db->findByEmail($email);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header("location: index.php?msg=Logged In Successfully");
    } else {
        header("location: index.php?error=Invalid Credentials");
    }
    exit;
}

// 3. GENERIC CRUD (CREATE / UPDATE / DELETE)
if (isset($_GET['action'])) {
    $table = $_GET['table'];
    
    // ! DELETE
    if ($_GET['action'] == 'delete') {
        $id = $_GET['id'];
        $db->delete($table, $id);
        header("location: index.php?msg=Deleted Successfully");
        exit;
    }

    // ! SAVE (CREATE or UPDATE)
    if ($_GET['action'] == 'save' && $_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = $_POST['id'] ?? null;
        unset($_POST['id']);

        if ($id) {
            $db->update($table, $id, $_POST);
            $msg = "Updated Successfully";
        } else {
            $db->create($table, $_POST);
            $msg = "Created Successfully";
        }

        header("location: index.php?msg=$msg");
        exit;
    }
}