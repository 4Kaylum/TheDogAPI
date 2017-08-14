<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/../backend/databaseLogins.php';

class Page {

    public $subheader;
    public $pageText;
    public $pageName;
    public $rawPage = false;

    function __construct ($pageName, $subheader, $pageText=array()) {
        $this->pageName = $pageName;
        $this->subheader = $subheader;
        $this->pageText = $pageText;
    }

    function output() {
        // Header
        echo '
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <title>' . $this->pageName . ' | TheDogAPI.co.uk</title>
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" type="text/css" href="/css/main.css">
                <script type="text/javascript" src="/js/navbar.js"></script>
            </head>
            <body>
        ';

        // Page title
        echo '<h1 style="text-align: center;">' . $this->subheader . ' &middot; The Dog API</h1>';

        // Navbar
        // echo '<table width="100%" style="margin-bottom:30px;"><tr>';
        echo '<div class="navbar" id="navbar">';

        // Generate the nav items array
        $loginInfo = checkLoggedIn();
        $navItems = array(
            array('Index', '/'),
            array('Documentation', '/documentation.php'),
            array('Upload', '/upload.php'),
            array('Dog Picture', '/dog.php')
        );
        if ($loginInfo === false) {
            array_push($navItems, array('Login', '/login.php'));
        }
        else {
            array_push($navItems, array('Console', '/admin.php'));
        }

        // Generate each item
        $arrayLength = sizeof($navItems);
        for ($i = 0; $i < $arrayLength; $i++) {
            // echo '<td><a href="'.$navItems[$i][1].'">'.$navItems[$i][0].'</a></td>';
            echo '<a href="'.$navItems[$i][1].'">'.$navItems[$i][0].'</a>';
        }

        // Close off the navbar
        // echo '</tr></table>';
        echo '<a href="javascript:void(0);" class="icon" onclick="navbarJavascript()">&#9776;</a>';
        echo '</div>';

        // Body text
        if ($this->rawPage === false) {
            foreach ($this->pageText as $line) {
                echo '<p>' . $line . '</p>';
            }
        }
        else {
            echo $this->rawPage;
        }

        // Close off the page
        echo '</body></html>';
    }
}

?>
