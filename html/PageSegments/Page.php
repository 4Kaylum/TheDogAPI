<?php 

class Page {

    public $subheader;
    public $pageText;
    public $pageName;
    public $activePage;

    function __construct ($subheader, $pageName, $activePage, $pageText) {
        $this->subheader = $subheader;
        $this->pageText = $pageText;
        $this->pageName = $pageName;
        $this->activePage = $activePage;
    }

    function output() {
        // Header
        echo '<!DOCTYPE html><html lang="en"><head><title>' . $this->pageName . ' | TheDogAPI.co.uk</title><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><link rel="stylesheet" href="https://bootswatch.com/darkly/bootstrap.min.css"><script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script><script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script></head><body><style type="text/css">p {text-align:justify;}</style>';

        // Navbar
        echo '<nav class="navbar navbar-default"><div class="container"><div class="navbar-header"><button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#mainNavbar"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button><a class="navbar-brand" href="/">TheDogAPI</a></div><div class="collapse navbar-collapse" id="mainNavbar"><ul class="nav navbar-nav">';

        // Generate the nav items array
        $navItems = array(
            array('Index', '/'),
            array('Dogumentation', 'http://docs.dogapi1.apiary.io/'),
            array('Dog Picture', '/ui/v1/dog'),
            array('Set Cookies', '/cookies')
        );

        // Generate each item
        $arrayLength = sizeof($navItems);
        for ($i = 0; $i < $arrayLength; $i++) {
            if ($navItems[$i][0] == $activePage) {
                echo '<li class="active"><a href="'.$navItems[$i][1].'">'.$navItems[$i][0].'</a></li>';
            }
            else {
                echo '<li><a href="'.$navItems[$i][1].'">'.$navItems[$i][0].'</a></li>';
            }
        }

        // Close off the navbar
        echo '</ul></div></div></nav>';

        // Body text
        echo '<div class="page-header"><h1>The Dog API</h1><p>' . $this->subheader . '</p></div><div class="row"><div class="column col-sm-12">'. $this->pageText . '</div></div>';

        // Close off the page
        echo '</div></body></html>';
    }
}

?>
