<?php

    include('/../backend/getDog.php');
    $dog = getRandomDog();

    include('PageSegments/Page.php');
    $page = new Page(
        'Dog ID: <a href="/ui/v1/dog/' . $dog->id . '"><code>' . $dog->id . '</code></a>',
        'Dog', 
        'Dog Picture',
        '<img src="' . $dog->url . '" style="width:100%;border-radius:30px">'
    );

?>
