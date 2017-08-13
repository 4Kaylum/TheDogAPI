<?php 

// function generateRandomString($length=11) {
//     $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-_';
//     $charactersLength = strlen($characters);
//     $randomString = '';
//     for ($i = 0; $i < $length; $i++) {
//         $randomString .= $characters[rand(0, $charactersLength - 1)];
//     }
//     return $randomString;
// }


class Dog {
    public $id = 'null';
    public $url = 'null';
    public $time = 'null';
    public $format = 'null';
    public $author_ip = 'null';
    public $verified = 'null';
    public $checked = 'null';

    function fromDatabase($databaseOutput) {
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