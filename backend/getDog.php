<?php

   include('dogObject.php');
   include('databaseHandling.php');


   function getRandomDog() {

      // $sql = 'SELECT * FROM DogPictures WHERE verified=1 ORDER BY RAND() LIMIT 1;';
      // $values = runSQL($sql);

      $values = Array('-2nGCLJMAN9', 'https://i.redd.it/kfm062pie0bz.jpg', '2017-07-22T04:16:42.474949', 'jpg', '0.0.0.0', 1, 1);
      $dogItem = new Dog($values);

      return $dogItem;
   }

   function getSpecificDog($dogID) {

      // $escaped = mysql_real_escape_string($dogID);
      // $sql = 'SELECT * FROM DogPictures WHERE id=' . $escaped . ';';
      // $values = runSQL($sql);  

      $values = Array('-2nGCLJMAN9', 'https://i.redd.it/kfm062pie0bz.jpg', '2017-07-22T04:16:42.474949', 'jpg', '0.0.0.0', 1, 1);
      $dogItem = new Dog($values);

      return $dogItem;
   }

?>
