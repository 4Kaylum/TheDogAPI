<?php

    include('/../../backend/getDog.php');
    include('/../../backend/outputs.php');
    $dogObject = getRandomDog();
    echo jsonOutputDog(Array($dogObject));

?>
