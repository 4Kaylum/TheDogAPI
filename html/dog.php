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

    require $_SERVER['DOCUMENT_ROOT'] . '/PageSegments/Page.php';
    
    $page = new Page(
        'Dog', 
        '<a href="/dog.php?id=' . $dog->id . '">' . $dog->id . '</a>',
        array('<img src="' . $dog->url . '" style="width:100%;border-radius:30px">')
    );
    $page->output();


?>
