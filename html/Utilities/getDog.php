<?php

   // $hostDetails = parse_ini_file('./mysqlPassword.ini');
   // $hostname = $hostDetails[0];
   // $username = $hostDetails[1];
   // $password = $hostDetails[2];

   // $connection = mysql_connect($hostname, $username, $password);

   // if(! $connection ) {
   //    die('Could not connect: ' . mysql_error());
   // }

   // $sql = 'SELECT * FROM DogPictures WHERE verified=1 ORDER BY RAND() LIMIT 1;';
   // mysql_select_db('DogPictures');
   // $values = mysql_query($sql, $connection);

   // if(!$values) {
   //    die('Could not get data: ' . mysql_error());
   // }

   // mysql_close($connection);
   // mysql_free_result($values);

   $values = Array('-2nGCLJMAN9', 'https://i.redd.it/kfm062pie0bz.jpg', '2017-07-22T04:16:42.474949', 'jpg', '0.0.0.0', 1, 1);

   require('dogObject.php');
   $dogItem = new Dog($values);

   return $dogItem;

?>
