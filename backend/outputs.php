<?php 

    function jsonOutput($data) {
        header('Content-Type: application/json');
        return $data;
    }

?>