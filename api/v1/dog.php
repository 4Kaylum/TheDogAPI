<?php

    include('/../../backend/getDog.php');
    include('/../../backend/outputObject.php');
    $dogObject = getRandomDog();
    $jsonObject = new JsonOutput();
    echo $jsonObject->fromDogList(Array($dogObject), 'v1');

?>
