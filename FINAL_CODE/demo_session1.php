<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>

    <?php
    $_SESSION["color"]="green";
    $_SESSION["car"]="bmw";
    echo "Session variable are set";
    
    ?>

</body>
</html>