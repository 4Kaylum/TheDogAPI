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
        catch (Exception $e) {
            echo '<p>', $e->getMessage(), '</p>';
            $dog = new Dog();
            return $dog;
        }
    }

?>
