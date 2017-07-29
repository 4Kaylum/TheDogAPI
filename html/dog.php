<?php

    $pageName = 'Dog';
    include('PageSegments/pageHead.php');

    $activePage = 'Dog Picture';
    include('PageSegments/navbar.php');

    echo '<div class="container bodytext">';

    include('/../backend/getDog.php');
    $dog = getRandomDog();

    $subheader = 'Dog ID: <a href="/ui/v1/dog/' . $dog->id . '"><code>' . $dog->id . '</code></a>';
    $pageText = '<img src="' . $dog->url . '" style="width:100%;border-radius:30px">';

    include('PageSegments/fullPage.php');

    echo '</div></body></html>';

?>
