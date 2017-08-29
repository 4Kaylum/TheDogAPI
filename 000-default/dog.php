<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . '/../backend/databaseOptions.php';

    $id = $_GET['id'];
    if ($id != '') {
        $dog = getSpecificDog($id);
    }
    else {
        $dog = getRandomDog();
    }

    // $dog = getRandomDog();

    require_once $_SERVER['DOCUMENT_ROOT'] . '/PageSegments/Page.php';
    
    $page = new Page(
        'Dog', 
        '<a href="/dog.php?id=' . $dog->id . '">' . $dog->id . '</a>'
    );

    if ($id != '') {
        $addThisScript = '
            <!-- Go to www.addthis.com/dashboard to customize your tools -->
            <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-59a4877ab1ddea0c"></script>
        ';
    } else {
        $addThisScript = '';
    }
    $page->rawPage = '<img src="' . $dog->url . '" style="width:100%;border-radius:30px">' . $addThisScript;
    $page->output();


?>
