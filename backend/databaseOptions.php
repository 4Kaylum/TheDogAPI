<?php

    require $_SERVER['DOCUMENT_ROOT'] . '/../backend/dogObject.php';
    require $_SERVER['DOCUMENT_ROOT'] . '/../backend/config.php';
    // $dbInfo = new DatabaseInfo();

    function getRandomDog() {

        try {

            $dbh = new PDO(
                $GLOBALS['DB_TYPE'] . ':host=' . $GLOBALS['DB_HOST'] . '; dbname=' . $GLOBALS['DB_NAME'] . ';', 
                $GLOBALS['DB_USER'], 
                $GLOBALS['DB_PASS']
            ); 

            // Get a dog from the database
            $stmt = $dbh->prepare('SELECT * FROM DogPictures WHERE verified=1 ORDER BY RAND() LIMIT 1;');
            $stmt->execute();

            // Grab the info from the row
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $iterator = new IteratorIterator($stmt);
            foreach ($iterator as $row) {

                // Turn it into an object
                $dog = new Dog();
                $dog->fromDatabase($row);
                return $dog;
            }
        }
        catch (Exception $e) {
            echo '<p>', $e->getMessage(), '</p>';
            $dog = new Dog();
            return $dog;
        }

        // return $dog;
    }

    function getSpecificDog($dogID) {

        try {

            $dbh = new PDO(
                $GLOBALS['DB_TYPE'] . ':host=' . $GLOBALS['DB_HOST'] . '; dbname=' . $GLOBALS['DB_NAME'] . ';', 
                $GLOBALS['DB_USER'], 
                $GLOBALS['DB_PASS']
            ); 

            // Get a dog from the database
            $stmt = $dbh->prepare('SELECT * FROM DogPictures WHERE id=:id ORDER BY RAND() LIMIT 1;');
            $stmt->bindParam(':id', $dogID, PDO::PARAM_STR);
            $stmt->execute();

            // See if that ID actually exists
            if ($stmt->rowCount() > 0) {

                // Grab the info from the row
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $iterator = new IteratorIterator($stmt);
                foreach ($iterator as $row) {

                    // Turn it into an object
                    $dog = new Dog();
                    $dog->fromDatabase($row);

                    // Return it
                    return $dog;

                }
            }
            else {
                return new Dog();
            }
        }
        catch (Exception $e) {
            echo '<p>', $e->getMessage(), '</p>';
            $dog = new Dog();
            return $dog;
        }
    }


    function generateRandomString($length=11) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-_';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    function insertIntoDatabase($fileData) {

        $targetDir = '/var/www/i/';
        while(1 == 1) {
            $newID = generateRandomString();
            $dogByID = getSpecificDog($newID);
            if ($dogByID->id == 'null') {
                break;
            }
        }
        // $fileExtention = end(explode(".", $fileData['tmp_name']));
        $fileExtention = end(explode('.', basename($fileData["name"])));
        $targetFile = $targetDir . $newID . '.' . $fileExtention;
        move_uploaded_file($fileData['tmp_name'], $targetFile);

        try {

            $dbh = new PDO(
                $GLOBALS['DB_TYPE'] . ':host=' . $GLOBALS['DB_HOST'] . '; dbname=' . $GLOBALS['DB_NAME'] . ';', 
                $GLOBALS['DB_USER'], 
                $GLOBALS['DB_PASS']
            ); 

            // Get a dog from the database
            $stmt = $dbh->prepare('INSERT INTO DogPictures (id, url, time, format, author_ip, verified, checked) VALUES (:id, :url, :time, :format, :author_ip, 0, 0);');
            $stmt->bindParam(':id', $newID, PDO::PARAM_STR);
            $url = 'http://i.thedogapi.co.uk/' . $newID . '.' . $fileExtention;
            $stmt->bindParam(':url', $url, PDO::PARAM_STR);
            $stmt->bindParam(':time', date('Y-m-d\TH:i:s.0'), PDO::PARAM_STR);
            $stmt->bindParam(':format', $fileExtention, PDO::PARAM_STR);
            $stmt->bindParam(':author_ip', $_SERVER['REMOTE_ADDR'], PDO::PARAM_STR);
            $stmt->execute();

            return getSpecificDog($newID);

        }
        catch (Exception $e) {
            echo '<p>', $e->getMessage(), '</p>';
            $dog = new Dog();
            return $dog;
        }
    }

?>

