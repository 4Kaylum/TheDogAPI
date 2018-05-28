<?php 

    require_once $_SERVER['DOCUMENT_ROOT'] . '/../backend/databaseOptions.php';

    // Check if a POST request is already being made
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {

            $mimetype = mime_content_type($_FILES["fileToUpload"]["tmp_name"]);
            if (substr($mimetype, 0, 5) != "image") {
                
                $alert = "That file isn't an image!";
            }
            else {

                // File is an image
                $dog = insertIntoDatabase($_FILES["fileToUpload"]);
                $alert = 'Upload successful! ID: ' . $dog->id;
            }

        } 
        else {

            // Not an image
            // Heck off
            $alert = 'That file isn\'t an image!';
        }
    }
    else {
        $alert = null;
    }

    require_once $_SERVER['DOCUMENT_ROOT'] . '/PageSegments/Page.php';

    $page = new Page(
        'Upload', 
        'Upload'
    );
    $page->rawPage = '
    <style>.borderbox {
        border: 1px solid black;
        padding: 0 20px;
        border-radius: 20px;
    }</style>
    <div class="borderbox"><form action="/upload.php" method="post" enctype="multipart/form-data" style="margin: 20px;">
        <p>Select file to upload</p>
        <input type="file" name="fileToUpload" id="fileToUpload" accept="image/*"></input><br />
        <input type="submit" value="Submit" name="submit"></input>
    </form></div>
    ';
    if ($alert != null) {
        $page->rawPage = $page->rawPage . '<script>alert("' . $alert . '");</script>';
    }
    $page->output();


?>
