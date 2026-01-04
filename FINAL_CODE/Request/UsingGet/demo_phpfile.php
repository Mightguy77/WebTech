<!DOCTYPE html>
<html lang="en">
    <head>
    </head>
    <body>

    <?php
    $subject = htmlspecialchars($_REQUEST['subject']);
    $web=htmlspecialchars($_GET['web']);
    echo "Study $subject at $web."
    ?>

    </body>
</html>