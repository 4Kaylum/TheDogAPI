<?php

    include('PageSegments/Page.php');
    $page = new Page(
        'Documentation', 
        'Documentation', 
        ''
    );
    $page->rawPage = '<style>.borderbox {
        border: 1px solid black;
        padding: 0 20px;
        border-radius: 20px;
    }
    .borderbox:not(:last-of-type){
        margin-bottom: 20px;
    }</style>

    <div class="borderbox">
        <h3>GET &middot; <a href="http://api.thedogapi.co.uk/v2/dog.php">api.thedogapi.co.uk/v2/dog.php</a></h3>
        <p>Params:</p>
        <ul>
            <li>limit - How many dog objects you want to get</li>
            <li>id - If you want the data of a specific dog</li>
        <ul>
    </div>

    <div class="borderbox">
        <h3>Response Object</h3>
        <ul>
            <li>count - How many dog objects are in the response</li>
            <li>api_version - The version of the API you\'re using</li>
            <li>error - Should be null</li>
            <li>data - list of dog objects</li>
        </ul>
    </div>

    <div class="borderbox">
        <h3>Dog Object</h3>
        <ul>
            <li>id</li>
            <li>url</li>
            <li>time</li>
            <li>format</li>
            <li>verified</li>
            <li>checked</li>
        </ul>
    </div>';
    $page->output();

?>
