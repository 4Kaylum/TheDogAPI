<?php
    $pageName = 'Dog';
    include('PageSegments/pageHead.php');

    $activePage = 'Dog Picture';
    include('PageSegments/navbar.php');
?>


<div class="container bodytext">

    <?php 

        $dog = include('Utilities/getDog.php');
        $subheader = 'Dog ID: <a href="/ui/v1/dog/' . $dog[0] . '"><code>' . $dog[0] . '</code></a>';
        $pageText = '<img src="' . $dog[1] . '" style="width:100%;border-radius:30px">';

        include('PageSegments/fullPage.php');

    ?>

</div>


</body>
</html>
