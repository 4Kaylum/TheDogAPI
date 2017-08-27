<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/../backend/databaseLogins.php';
    setLogout();
    header("Location: /login.php?message=Logout sucessful");
    die("Logout suceeded.");
    
?>
