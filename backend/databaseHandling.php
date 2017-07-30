<?php

    function runSQL($statement) {
        $hostDetails = parse_ini_file('./mysqlPassword.ini');
        $hostname = $hostDetails[0];
        $username = $hostDetails[1];
        $password = $hostDetails[2];

        $connection = mysql_connect($hostname, $username, $password);

        if(! $connection ) {
            die('Could not connect: ' . mysql_error());
        }

        mysql_select_db('DogPictures');
        $values = mysql_query($statement, $connection);

        if(!$values) {
            die('Could not get data: ' . mysql_error());
        }

        mysql_close($connection);
        mysql_free_result($values);

        return $values
    }

?>