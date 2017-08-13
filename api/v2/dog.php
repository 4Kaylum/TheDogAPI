<?php

    include('/../backend/outputObject.php');
    include('/../backend/getDog.php');

    try {

        // They want a dog by it's ID
        $id = $_GET['id'];
        $dog = getSpecificDog($id);
        $dogArray = array($dog);
    }
    catch (Exception $e) {

        // They want a random dog - check limits
        $dogArray = array();

        try {

            // They specified a limit
            $limitStr = $_GET['limit'];
            $limit = intval($limitStr);

            // Make sure it's between 20 and 1
            if ($limit > 20) {
                $limit = 20;
            }
            else if ($limit < 1) {
                $limit = 1;
            }
        }
        catch (Exception $e) {

            // No limit specified - set default
            $limit = 1;
        }

        // For each i before limit, add to array.
        for ($i = 0; $i <= $limit; $i++) {
            $dog = getRandomDog();
            array_push($dogArray, $dog);
        }
    }

    $output = new JsonOutput();
    $output->fromDogList($dogArray);

?>
