<?php 

    require $_SERVER['DOCUMENT_ROOT'] . '/PageSegments/Page.php';
    require $_SERVER['DOCUMENT_ROOT'] . '/../backend/databaseLogins.php';

    $loginData = checkLoggedIn();
    if ($loginData == false) {
        header('Location: /login.php?message=You need to login to access that page');
        die('You have been redirected.');
    }


?>
