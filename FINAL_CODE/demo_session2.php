<?php
session_start();
// session_unset();
session_destroy();

?>

<!DOCTYPE html>
<html lang="en">
    <head>
    </head>
    <body>
    <?php
    echo "Favorite colir is ".$_SESSION["color"];
    echo "Favorite car is ".$_SESSION["car"];
    print_r($_SESSION);
    ?>


    </body>
</html> 