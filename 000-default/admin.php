<?php 

    require_once $_SERVER['DOCUMENT_ROOT'] . '/PageSegments/Page.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/../backend/databaseLogins.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/../backend/databaseOptions.php';

    $loginData = checkLoggedIn();
    if ($loginData == false) {
        header('Location: /login.php?message=You need to login to access that page');
        die('You have been redirected.');
    }

    $setVerifiedTo = ($_POST['action'] == 'Allow') ? 1 : 0;
    $dogToChange = $_POST['dogID'];
    if ($dogToChange != null) {
        checkDogByID($dogToChange, $setVerifiedTo);
    }

    $page = new Page(
        'Console',
        'Welcome, ' . $loginData['username']
    );

    $dogArray = getAllUnchecked();
    if (sizeof($dogArray) > 0) {
        $page->rawPage = '
            <style> 
            input[type="submit"] {
                border: 0;
                background: none;
                box-shadow:none;
                border-radius: 0px;
            }
            tr, th {
                text-align: center;
            }
            .notHeader {
                table-layout: initial;
                width: 100%;
            }</style>
            <table class="notHeader">
                <tr>
                    <th>ID</th>
                    <th>URL</th>
                    <th>Checked</th>
                    <th>Verified</th>
                    <th>IP</th>
                    <th>Actions</th>
                </tr>
        ';
        foreach ($dogArray as $dog) {
            $page->rawPage .= '
                <form method="POST">
                    <tr>
                        <td>' . $dog->id . '</td>
                        <td><a href="' . $dog->url . '">/' . end(explode('/', $dog->url)) . '</a></td>
                        <td>' . $dog->checked . '</td>
                        <td>' . $dog->verified . '</td>
                        <td>' . $dog->author_ip . '</td>
                        <td>
                            <input style="background-color:green;color:white;font-weight:bold;" type="submit" name="action" value="Allow">
                            <input style="background-color:red;color:white;font-weight:bold;" type="submit" name="action" value="Deny">
                            <input type="hidden" name="dogID" value="' . $dog->id . '">
                        </td>
                    </tr>
                </form>
            ';
        }
        $page->rawPage .= '</table>';
    }
    else {
        $page->pageText = array('<p>Oh it looks like there\'s nothing here.</p>');
    }

    $page->output();


?>
