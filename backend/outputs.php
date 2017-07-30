<?php 

    function jsonOutputDog($dogList) {
        header('Content-Type: application/json');
        $o->count = 1;
        $o->api_version = 'v1';
        $o->error;

        $arrayLength = sizeof($dogList);
        for ($i=0; $i < $arrayLength ; $i++) { 
            unset($dogList[$i]->author_ip);
        }

        $o->data = array($dogList);
        reutrn json_encode($o);
    }

?>