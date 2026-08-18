<?php
session_start();

if (!isset($_SESSION["usersData"])) {
    $_SESSION["usersData"] = [];
}

// ? 1. REGISTER
if (isset($_POST["btn-register"])) {
    $user = [
        "userName" => $_POST["userName"],
        "userEmail" => $_POST["userEmail"],
        "userPhone" => $_POST["userPhone"],
        "userPassword" => $_POST["userPassword"]
    ];

    array_push($_SESSION["usersData"], $user);
    header("location: login.php?message=Registered successfully! Please login.");
    exit;
}

// ? 2. LOGIN
if (isset($_POST["btn-login"])) {
    $userEmail = $_POST["userEmail"];
    $userPassword = $_POST["userPassword"];
    $found = false;

    foreach ($_SESSION["usersData"] as $user) {
        if ($user['userEmail'] == $userEmail && $user['userPassword'] == $userPassword) {
            $found = true;
            $_SESSION["isLoggedIn"] = true;
            $_SESSION["loggedUser"] = $user['userName'];
            header("location: allUsers.php");
            exit;
        }
    }

    if (!$found) {
        header("location: login.php?error_message=Invalid email or password!");
        exit;
    }
}

// ? 3. LOGOUT
if (isset($_GET["action"]) && $_GET["action"] == "logout") {
    unset($_SESSION["isLoggedIn"]);
    unset($_SESSION["loggedUser"]);
    header("location: login.php");
    exit;
}

// ? 4. DELETE USER
if (isset($_GET["action"]) && $_GET["action"] == "delete") {
    $index = $_GET["id"];
    if (isset($_SESSION["usersData"][$index])) {
        array_splice($_SESSION["usersData"], $index, 1);
    }
    header("location: allUsers.php?message=User deleted successfully");
    exit;
}

// ? 5. UPDATE USER
if (isset($_POST["btn-update"])) {
    $index = $_POST["userIndex"];
    if (isset($_SESSION["usersData"][$index])) {
        $_SESSION["usersData"][$index]["userName"] = $_POST["userName"];
        $_SESSION["usersData"][$index]["userEmail"] = $_POST["userEmail"];
        $_SESSION["usersData"][$index]["userPhone"] = $_POST["userPhone"];
        $_SESSION["usersData"][$index]["userPassword"] = $_POST["userPassword"];
    }
    header("location: allUsers.php?message=User updated successfully");
    exit;
}