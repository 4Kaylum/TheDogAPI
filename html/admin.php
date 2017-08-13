<?php 

    require_once $_SERVER['DOCUMENT_ROOT'] . '/PageSegments/Page.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/../backend/databaseLogins.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/../backend/databaseOptions.php';

    $loginData = checkLoggedIn();
    if ($loginData == false) {
        header('Location: /login.php?message=You need to login to access that page');
        die('You have been redirected.');
    }

    $page = new Page(
        'Console',
        'Welcome, ' . $loginData['username']
    );

    $dogArray = getAllUnchecked();
    if (sizeof($dogArray) > 0) {
        $page->rawPage = '<table><th><td>ID</td><td>URL</td></th>';
        foreach ($dogArray as $dog) {
            $page->rawPage .= '<tr><td>' . $dog->id . '</td><td>' . $dog->url . '</td></tr>';
        }
        $page->rawPage .= '</table>';
    }
    else {
        $page->pageText = array('<p>Oh it looks like there\'s nothing here.</p>');
    }

    $page->output();


?>
