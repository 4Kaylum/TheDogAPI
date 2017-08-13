<?php

    require $_SERVER['DOCUMENT_ROOT'] . '/PageSegments/Page.php';
    require $_SERVER['DOCUMENT_ROOT'] . '/../backend/databaseLogins.php';

    $loginData = checkLoggedIn();
    if ($loginData !== false) {
        header('Location: /loggedin.php');
        die('You have been redirected.');
    }

    $page = new Page(
        'Login',
        'Login',
        array()
    );
    $page->rawPage = '
        <div>
            <a href="https://discordapp.com/oauth2/authorize?client_id=346385073135681536&scope=identify&response_type=code">
                <input type="button" value="Login with Discord" name="discordLogin" style="width:100%;margin-top:20px;height:50px;"></input>
            </a>
        </div>
    ';
    $message = $_GET['message'];
    if ($message != null) {
        $page->rawPage = $page->rawPage . '
            <p>' . $message . '</p>
        ';
    }
    $page->output();

?>
