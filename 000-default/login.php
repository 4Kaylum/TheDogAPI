<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/PageSegments/Page.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/../backend/databaseLogins.php';

    $loginData = checkLoggedIn();
    if ($loginData !== false) {
        header('Location: /loggedin.php');
        die('You have been redirected.');
    }

    $page = new Page(
        'Login',
        'Login'
    );
    $page->rawPage = '
        <p>This page is for site admins only. If you\'re looking here to see if you can make an account, you can\'t.</p>
        <span>
            <a href="https://discordapp.com/oauth2/authorize?client_id=346385073135681536&scope=identify&response_type=code">
                <input type="button" value="Login with Discord" name="discordLogin" style="width:100%;margin-top:20px;height:50px;"></input>
            </a>
        </span>
    ';
    $message = (isset($_GET['message']) ? $_GET['message'] : '');
    if ($message != '') {
        $page->rawPage = $page->rawPage . '
            <script>alert("' . $message . '");</script>
        ';
    }
    $page->output();

?>
