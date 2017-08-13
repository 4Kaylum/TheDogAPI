<?php 

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