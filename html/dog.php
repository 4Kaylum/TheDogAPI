<?php

    require $_SERVER['DOCUMENT_ROOT'] . '/../backend/getDog.php';

    $id = $_GET['id'];
    if ($id != '') {
        $dog = getSpecificDog($id);
    }
    else {
        $dog = getRandomDog();
    }

    // $dog = getRandomDog();

    include('PageSegments/Page.php');
    $page = new Page(
        'Dog ID: <a href="/ui/v1/dog/' . $dog->id . '"><code>' . $dog->id . '</code></a>',
        'Dog', 
        'Dog Picture',
        '<img src="' . $dog->url . '" style="width:100%;border-radius:30px">'
    );
    $page->output();


?>
