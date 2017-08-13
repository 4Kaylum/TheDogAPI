<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/../backend/databaseLogins.php';
    $loggedIn = setLogin();
    if ($loggedIn === true) {
        header("Location: /admin.php");
        die("You're now logged in.");
    }
    else {
        header("Location: /login.php?message=" . $loggedIn);
        die("Login failed.");
    }

?>
