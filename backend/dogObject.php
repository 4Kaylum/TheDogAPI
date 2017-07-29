<?php 

class Dog {
    public $id;
    public $url;
    public $time;
    public $format;
    public $author_ip;
    public $verified;
    public $checked;

    public function __construct($databaseOutput) {
        $this->id = $databaseOutput[0];
        $this->url = $databaseOutput[1];
        $this->time = $databaseOutput[2];
        $this->format = $databaseOutput[3];
        $this->author_ip = $databaseOutput[4];
        $this->verified = $databaseOutput[5];
        $this->checked = $databaseOutput[6];
    }
}

?>