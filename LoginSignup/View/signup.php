<?php
session_start();
$isLoggedIn=false;
$isLoggedIn=$_SESSION["isLoggedIn"] ??false;
if($isLoggedIn){
    Header("location: ./dashboard.php");
}

?>



<html>
    <head>

    </head>
    <body>
        <form method="post" action="..\Controler\signupvalidation.php"></form>
        <table>
            <tr>
                <td>
                    Email
                </td>
                <td>
                <td><input type="text" id="email" name="email" value="<?php echo $previousValues['email'] ?? ''; ?>" onkeyup="findExistingEmail()"/> </td>
                <td id=erroremail></td>
                <td><?php echo $errors["email"] ?? ''; ?></td>
            </tr>
            <tr>
                <td>Password</td>
                <td><input type="password" id="password" name="password"></td>
                <td><?php echo $errors["password"]?? ''; ?></td>
            </tr>

            <tr>
                <td>Upload File</td>
                <td><input type="file" id="uploadFile" name="uploadFile"/> </td>
            </tr>
            <tr>
                <td><input type="submit" name="signup" value="Sign Up"></td>
            </tr>
        </table>
    </body>
</html>

