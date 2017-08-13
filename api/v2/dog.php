<?php

    require $_SERVER['DOCUMENT_ROOT'] . '/../backend/outputObject.php';
    require $_SERVER['DOCUMENT_ROOT'] . '/../backend/getDog.php';

    
    $id = $_GET['id'];

    if ($id != '') {

        // Get dog by its ID
        $dog = getSpecificDog($id);
        $dogArray = array($dog);
    }
    else {

        // They want a random dog - check limits
        $dogArray = array();

        // They specified a limit
        $limitStr = $_GET['limit'];
        if ($limitStr != '') {
            $limit = intval($limitStr);

            // Make sure it's between 20 and 1
            if ($limit > 20) {
                $limit = 20;
            }
            else if ($limit < 1) {
                $limit = 1;
            }
        }
        else {

            // No limit specified - set default
            $limit = 1;
        }

        // For each i before limit, add to array.
        for ($i = 1; $i <= $limit; $i++) {
            $dog = getRandomDog();
            array_push($dogArray, $dog);
        }
    }

    $output = new JsonOutput();
    $data = $output->fromDogList($dogArray, 'v2');
    echo $data;

?>
