<?php
    echo "-----------global--------------<br>";
    $x=5;
    
    function Globals(){
        echo "Inside function ". $x;  //error
        echo "<br>";
    }
    Globals();
    echo "Outside function ".$x;
    echo "<br>";

    
    echo "-----------usingglobal--------------<br>";
    $x=5;
    
    function usingGlobals(){
        global $x;
        echo "Inside function ". $x;  
        echo "<br>";
    }
    usingGlobals();
    echo "Outside function ".$x;
    echo "<br>";





    echo "-----------local--------------";
    echo "<br>";
    function Locals(){
        $y=5;
        echo "Inside function ". $y;
        echo "<br>";

    }
    Locals();
    echo "Outside function ".$y;  //error
    echo "<br>";

    echo "-----------with statis--------------";
    echo "<br>";
    function withstatic(){
        static $z=5;
        echo "Inside function ". $z;
        $z++;
        echo "<br>";
     

    }
    withstatic();
    withstatic();
    withstatic();
    
    echo "-----------without statis--------------";
    echo "<br>";
    function withoutstatic(){
        $p=5;
        echo "Inside function ". $p;
        $p++;
        echo "<br>";
     

    }
    withoutstatic();
    withoutstatic();
    withoutstatic();


    echo "-----------supergloval--------------";
    echo "<br>";
    $q=5;
    $r=10;
    function superglobal(){
        $GLOBALS['q']=$GLOBALS['q']+$GLOBALS['r'];
        echo "inside function $q <br>"; //error
 
    }
    superglobal();
    echo "outside function $q <br>";
    

?>