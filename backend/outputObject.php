<?php

    class JsonOutput {
        public $count;
        public $api_version;
        public $error = null;
        public $data;

        public function fromDogList($dogList, $apiVersion) {
            $this->api_version = $apiVersion;
            $arrayLength = sizeof($dogList);
            for ($i=0; $i < $arrayLength ; $i++) { 
                unset($dogList[$i]->author_ip);
            }
            $this->count = $arrayLength;
            $this->data = $dogList;

            header('Content-Type: application/json');
            return json_encode($this);
        }
    }

?>