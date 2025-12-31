<?php 
include "../Model/DatabaseConnection.php";

session_start();

$email = $_REQUEST["email"];
$password = $_REQUEST["password"];

$errors = [];
$values = [];

if(!$email){
    $errors["email"] = "This is a required field";
}
if(!$password){
    $errors["password"] = "Password field is required";
}

if(count($errors) > 0){
    if($errors["email"] != ""){
        $_SESSION["emailErr"] = $errors["email"];
    }else{
        unset($_SESSION["emailErr"]);
    }
    if($errors["password"] != ""){
        $_SESSION["passwordErr"] = $errors["password"];
    }else{
        unset($_SESSION["passwordErr"]);
    }
$values["email"] = $email;

$_SESSION["previousValues"] = $values;

Header("Location: ..\View\login.php");

}else{
    $db = new DatabaseConnection();
    $connection = $db->openConnection();
    $result = $db->signin($connection, "users", $email, $password);
    if($result->num_rows > 0){
        Header("Location: ..\View\dashboard.php");
        $_SESSION["email"] = $email;
        $_SESSION["isLoggedIn"] = true;
    }else{
        $_SESSION["loginErr"] = "Email or password is invalid";
        Header("Location: ..\View\login.php");
    }
    
}




?>