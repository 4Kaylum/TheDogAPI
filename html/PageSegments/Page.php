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

                <style type="text/css">
                    * {
                        font-family: Helvetica;
                    }

                    body {
                        margin:40px auto;
                        max-width:650px;
                        line-height:1.6;
                        font-size:18px;
                        color:#444;
                        padding:0 10px;
                        background-color: #EEE;
                        text-align: justify;
                    }

                    h1,
                    h2,
                    h3 {
                        line-height:1.2
                    }

                    a,
                    a:visited {
                        color:blue;
                    }

                    .navbar {
                        overflow: hidden;
                    }

                    @media screen and (min-width: 600px) {
                        .navbar {
                            display: flex;
                            justify-content: space-between;
                        }
                    }

                    .navbar a {
                        float: left;
                        display: block;
                        text-align: center;
                        padding: 14px 16px;
                        text-decoration: none;
                        font-size: 17px;
                    }

                    .navbar .icon {
                        display: none;
                    }

                    @media screen and (max-width: 600px) {
                        .navbar a:not(:first-child) {display: none;}
                        .navbar a.icon {
                            float: right;
                            display: block;
                        }
                    }

                    @media screen and (max-width: 600px) {
                        .navbar.responsive {position: relative;}
                        .navbar.responsive a.icon {
                            position: absolute;
                            right: 0;
                            top: 0;
                        }
                        .navbar.responsive a {
                            float: none;
                            display: block;
                            text-align: left;
                        }
                    }                    

                </style>

                <script type="text/javascript">
                    function navbarJavascript() {
                        var x = document.getElementById("navbar");
                        if (x.className === "navbar") {
                            x.className += " responsive";
                        } else {
                            x.className = "navbar";
                        }
                    }
                </script>

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
