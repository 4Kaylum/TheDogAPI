<?php 

class Page {

    public $subheader;
    public $pageText;
    public $pageName;
    public $rawPage = false;

    function __construct ($pageName, $subheader, $pageText) {
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

                    td {
                        text-align: center;
                    }

                    table {
                        table-layout: fixed;
                    }

                    a,
                    a:visited {
                        color:blue;
                    }
                </style>
            </head><body>
        ';

        // Page title
        echo '<h1 style="text-align: center;">' . $this->subheader . ' &middot; The Dog API</h1>';

        // Navbar
        echo '<table width="100%"><tr>';

        // Generate the nav items array
        $navItems = array(
            array('Index', '/'),
            array('Documentation', '/documentation.php'),
            array('Upload', '/upload.php'),
            array('Dog Picture', '/dog.php')
        );

        // Generate each item
        $arrayLength = sizeof($navItems);
        for ($i = 0; $i < $arrayLength; $i++) {
            echo '<td><a href="'.$navItems[$i][1].'">'.$navItems[$i][0].'</a></td>';
        }

        // Close off the navbar
        echo '</tr></table>';

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
