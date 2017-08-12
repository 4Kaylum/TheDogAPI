<?php 

function generateRandomString($length=11) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-_';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


class Dog {
    public $id;
    public $url;
    public $time;
    public $format;
    public $author_ip;
    public $verified;
    public $checked;

    public function newDog($url) {
        include('databaseHandling.php');
        $connection = dbConnection();
        $this->id = generateRandomString();
        $this->url = $url;
        $safeURL = mysql_real_escape_string($connection, $url);
        $this->format = explode('.', $url)[1];
        $safeFormat = mysql_real_escape_string($connection, $url);
        mysql_close($connection);
        // 2017-07-22T04:16:42.474949
        $this->time = date('Y-m-dTh:i:s');
        $this->author_ip = $_SERVER['REMOTE_ADDR'];
        $this->verified = 0;
        $this->checked = 0;
        return "INSERT INTO DogPictures (id, url, author_ip, checked, verified, time, format) 
                VALUES ('$this->id', '$safeURL', '$this->author_ip', 0, 0, '$this->time', '$this->format');";
    }

    public function fromDatabase($databaseOutput) {
        $this->id = $databaseOutput['id'];
        $this->url = $databaseOutput['url'];
        $this->time = $databaseOutput['time'];
        $this->format = $databaseOutput['format'];
        $this->author_ip = $databaseOutput['author_ip'];
        $this->verified = $databaseOutput['verified'];
        $this->checked = $databaseOutput['checked'];
    }
}

?>