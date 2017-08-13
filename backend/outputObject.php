<?php

    class JsonOutput {
        public $count = 0;
        public $api_version = '';
        public $error = null;
        public $data = array();

        public function __construct($apiVersion) {
            $this->api_version = $apiVersion;
        }

        public function fromDogList($dogList) {
            $arrayLength = sizeof($dogList);
            for ($i=0; $i < $arrayLength ; $i++) { 
                unset($dogList[$i]->author_ip);
            }
            $this->data = $dogList;
        }

        public function jsonify() {
            $this->count = sizeof($this->data);
            header('Content-Type: application/json');
            return json_encode($this);
        }
    }

?>