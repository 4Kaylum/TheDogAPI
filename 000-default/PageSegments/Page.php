<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/../backend/databaseLogins.php';

class Page {

    public $subheader;
    public $pageText;
    public $pageName;
    public $rawPage = false;
    public $pageDescription = 'A set of API endpoints for pictures of dogs';

    function __construct ($pageName, $subheader, $pageText=array()) {
        $this->pageName = $pageName;
        $this->subheader = $subheader;
        $this->pageText = $pageText;
    }

    function output() {
        // Header
        echo '<!DOCTYPE html>
<html lang="en">
<head>
    <title>' . $this->pageName . ' | TheDogAPI.co.uk</title>
    <link rel="shortcut icon" type="image/png" href="/favicon.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="' . $this->pageDescription . ' />
    
    <meta property="og:title" content="' . $this->pageName . ' | TheDogAPI.co.uk" />
    <meta property="og:type" content="website" />
    <!-- <meta property="og:image" content="http://ia.media-imdb.com/images/rock.jpg" /> -->
    
    <link rel="stylesheet" type="text/css" href="/css/main.css" />
    <script type="text/javascript" src="/js/navbar.js"></script>
    <!-- <script type="text/javascript" src="/js/cookies.js"></script> -->
    <script>
        (function(i,s,o,g,r,a,m){i["GoogleAnalyticsObject"]=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,"script","https://www.google-analytics.com/analytics.js","ga");

        ga("create", "UA-105606394-1", "auto");
        ga("send", "pageview");

    </script>
</head>
<body>';

        // Page title
        echo '<h1 style="text-align: center;">' . $this->subheader . ' &middot; The Dog API</h1>' . PHP_EOL;

        // Navbar
        // echo '<table width="100%" style="margin-bottom:30px;"><tr>';
        echo '<div class="navbar" id="navbar">' . PHP_EOL;

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
            echo '<a href="'.$navItems[$i][1].'">'.$navItems[$i][0].'</a>' . PHP_EOL;
        }

        // Close off the navbar
        // echo '</tr></table>';
        echo '<a href="javascript:void(0);" class="icon" onclick="navbarJavascript()">&#9776;</a>' . PHP_EOL;
        echo '</div>' . PHP_EOL;

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
