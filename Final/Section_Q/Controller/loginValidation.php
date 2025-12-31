<?php
include "../Model/DatabaseConnection.php";

session_start();

$email = $_REQUEST["email"];
$password = $_REQUEST["password"];

$errors = [];
$values = [];

if(!$email){
$errors["email"] = "Email field is required";
}

if(!$password){
    $errors["password"] = "Password field is required";
}

if(count($errors) > 0){
    if($errors["email"]){
        $_SESSION["emailErr"] = $errors["email"];
    }
    else{
       if($_SESSION["emailErr"]){
         unset($_SESSION["emailErr"]);
       }
    }

    if($errors["password"]){
        $_SESSION["passwordErr"] = $errors["password"];
    }

$values["email"] = $email;
$_SESSION["previousValues"] = $values;

Header("Location: ..\View\login.php");

}else{
    $db = new DatabaseConnection();
    $connection = $db->openConnection();
    $result = $db->signin($connection, "users", $email, $password);


    if($result->num_rows  == 1){
        $_SESSION["email"] =$email;
        $_SESSION["isLoggedIn"] =true;
        Header("Location: ..\View\dashboard.php");
        while($row = $result->fetch_assoc())
        {
        echo "Name: " . $row["FullName"]. " - Email: " . $row["Email"]."Username : ".$row["UserName"]."<br>";
        $_SESSION["Email"]=$email;
        $_SESSION['Name']= $row["FullName"];
        $_SESSION["UserName"]=$row["UserName"];
        $_SESSION['file']=$row["File_Path"];
        }

        date_default_timezone_set("Asia/Dhaka");
        $formdata = array(
            'Name'=> $_SESSION["Name"],
            'Email'=> $_SESSION['Email'],
            'Time'=>date('h:i:s'),
            'Date'=>date("d.m.y"),
         );
        
        
         $existingdata = file_get_contents('../File/data.json');
         $tempJSONdata = json_decode($existingdata);
         $tempJSONdata[] =$formdata;
         $jsondata = json_encode($tempJSONdata, JSON_PRETTY_PRINT);
        }

    }else{
      $_SESSION["LoginErr"] = "Email or password is incorrect";  
      Header("Location: ..\View\login.php");
      unset($_SESSION["emailErr"]);
      unset($_SESSION["passwordErr"]);
    }


    
}

?>