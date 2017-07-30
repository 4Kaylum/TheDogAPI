<?php

    require('/../../backend/getDog.php');
    require('/../../backend/outputs.php');
    $dogObject = getRandomDog();
    $json = json_encode($dogObject);
    echo jsonOutput($json);

?>
