<?php

    include('dogObject.php');
    include('Configuration/config.php');

    function getRandomDog() {

        try {

            $dbh = new PDO("$DB_TYPE:host=$DB_HOST; dbname=$DB_NAME;", $DB_USER, $DB_PASS); 

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

                // Return it
                return $dog;

            }
        }
        catch (Exception $e) {
            echo '<p>', $e->getMessage(), '</p>';
        }
    }

    function getSpecificDog($dogID) {

        try {

            $dbh = new PDO("$DB_TYPE:host=$DB_HOST; dbname=$DB_NAME;", $DB_USER, $DB_PASS); 

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
        }
    }

?>
