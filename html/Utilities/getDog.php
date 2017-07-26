<?php

   $hostDetails = parse_ini_file('./mysqlPassword.ini');
   $hostname = $hostDetails[0];
   $username = $hostDetails[1];
   $password = $hostDetails[2];

   $connection = mysql_connect($hostname, $username, $password);

   if(! $connection ) {
      die('Could not connect: ' . mysql_error());
   }

   $sql = 'SELECT (id, url) FROM DogPictures WHERE verified=1 ORDER BY RAND() LIMIT 1;';
   mysql_select_db('DogPictures');
   $values = mysql_query($sql, $connection);

   if(!$values) {
      die('Could not get data: ' . mysql_error());
   }

   mysql_close($connection);
   mysql_free_result($values);

   return $values;

?>
