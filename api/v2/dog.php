<?php

    include('/../backend/outputObject.php');

    // if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
    //     include('/../../backend/dogObject.php');
    //     $postBody = file_get_contents('php://input');
    //     $obj = json_decode($postBody);

    //     if (isset($obj->url)) {

    //         // Filter the URL
    //         $re = '/http[s]*:\/\/.*\..*\/.*\.(png|jpg|jpeg|gif|gifv)/i';
    //         preg_match_all($re, $obj->url, $matches, PREG_SET_ORDER, 0);
    //         $url = $matches[0][0];

    //         // Generate the object
    //         $dogObject = new Dog();
    //         $x = $dogObject->newDog($url);

    //         // Post to database
    //         include('/../../backend/databaseHandling.php');
    //         $y = runSQL($x);

    //         // Output to user
    //         $jsonObject = new JsonOutput();
    //         echo $jsonObject->fromDogList(Array($dogObject), 'v2');
    //     }
    //     else {

    //         // Make new object and set error
    //         $jsonObject = new JsonOutput();
    //         $jsonObject->error = 'Invalid URL';
    //         echo $jsonObject->fromDogList(Array(), 'v2');
    //     }

    // }
    // else {

        // Get a random dog, echo JSON output
        include('/../../backend/getDog.php');
        $dogObject = getRandomDog();
        echo $dogObject->url;
        // $jsonObject = new JsonOutput();
        // echo $jsonObject->fromDogList(Array($dogObject), 'v2');
        // return;

    // }

?>
