<?php


// Grab the requirements
require_once $_SERVER['DOCUMENT_ROOT'] . '/../backend/outputObject.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/../backend/databaseOptions.php';
// require_once $_SERVER['DOCUMENT_ROOT'] . '/../backend/databaseOptions.php';


// Setup the output variable
$out = new JsonOutput('v2');


// Iterate through all the files - if none, then it'll jump to the bottom
foreach($_FILES as $key => $value) {

    // Check it's a file
    // $value["tmp_name"] = '/tmp/44.jpg';
    $check = getimagesize($value["tmp_name"]);
    // die(json_encode($check));
    if($check !== false) {

        // Insert and output
        $dog = insertIntoDatabase($_FILES[$key]);
        $out->fromDogList(array($dog));
        $out->response_code = 201;
        echo $out->jsonify();
        die();

    } else {

        // Not an image output message
        $out->error = 'File specified wasn\'t an image.';
        $out->response_code = 400;
        echo $out->jsonify();
        die();

    }
}


// Zero file specified error output
$out->error = 'Zero files specified.';
$out->response_code = 400;
echo $out->jsonify();
die();


?>
