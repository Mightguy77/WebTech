<html>
    <body>
        <?php
            $sub=htmlspecialchars($_GET['subject']);
            $webpage=htmlspecialchars($_GET['web']);
            echo "study $sub at $webpage";
        ?>
    </body>
</html>