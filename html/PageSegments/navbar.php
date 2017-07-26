<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#mainNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>                        
            </button>
            <a class="navbar-brand" href="/">TheDogAPI</a>
        </div>
        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="nav navbar-nav">

                <?php

                    // Generate the nav items array
                    $navItems = array(
                        array('Index', '/'),
                        array('Dogumentation', 'http://docs.dogapi1.apiary.io/'),
                        array('Dog Picture', '/ui/v1/dog'),
                        array('Submit', '/ui/v1/submit'),
                        array('Set Cookies', '/cookies')
                    );

                    $arrayLength = sizeof($navItems);

                    for ($i = 0; $i < $arrayLength; $i++) {
                        if ($navItems[$i][0] == $activePage) {
                            echo '<li class="active"><a href="'.$navItems[$i][1].'">'.$navItems[$i][0].'</a></li>';
                        }
                        else {
                            echo '<li><a href="'.$navItems[$i][1].'">'.$navItems[$i][0].'</a></li>';
                        }
                    }

                ?>

            </ul>
        </div>
    </div>
</nav>