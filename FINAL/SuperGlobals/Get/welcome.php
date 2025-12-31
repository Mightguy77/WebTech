<html>
    <body>
       hello : <?php
       echo htmlspecialchars($_GET['name']);
       ?>
       Email: <?php
       echo htmlspecialchars($_GET('email'));
       ?>
    </body>
</html>