<?php
    $PageName = 'Index';
    include('PageSegments/pageHead.php');

    $ActivePage = 'Index';
    include('PageSegments/navbar.php');
?>


<div class="container bodytext">

    <div class="page-header">
        <h1>The Dog API</h1>
        <p>Random Doggo Pictures</p>
    </div>

    <?php 

        $PageText = "<h3>Welcome!</h3>
        <p>Welcome to The Dog API, home of, well, an API for dogs. Although being mostly just an endpoint for retrieving pictures (see the documentation page), there is a UI page on here for you to use if you're at all interested in using it. All it does is call the endpoint itself and display the image on the page.</p>
        <p>The submit page is for you to submit your own images to the API's database. We don't host any images here, so if you want to submit your own, personal images, I would recommend a site like <a href='https://imgur.com/'>Imgur</a> for storing your own. Remember to use a direct link to the image rather than a link to the page it's stored on.</p>
        <p>With that all said, there's not much more going on. Hit me up with any suggestions over at <a href='mailto:caleb@thedogapi.co.uk'>my email</a> if you want to, and if you're at all interested, I have my own <a href='https://patreon.com/CallumBartlett'>Patreon page</a> if you wanna throw some spare cash at me. There's a one-time donation option if you want to set me up for a coffee or anything.</p>
        <p>So yeah, that's about it! Have fun!</p>";

        include ('PageSegments/fullPage.php');

    ?>

</div>


</body>
</html>
