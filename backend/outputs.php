<?php 

    function jsonOutputDog($dogList) {
        header('Content-Type: application/json');
        $o = new stdClass();
        $o->count = 1;
        $o->api_version = 'v1';
        $o->error = null;

        $arrayLength = sizeof($dogList);
        for ($i=0; $i < $arrayLength ; $i++) { 
            unset($dogList[$i]->author_ip);
        }

        $o->data = $dogList;
        $a = json_encode($o);
        return $a;
    }

?>