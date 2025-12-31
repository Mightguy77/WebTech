<?php
    echo "Hello <br>";
    echo 'Hello <br>';
    $x = "John";
    echo "Hello $x <br>"; // Returns Hello John

    $x = "John";
    echo 'Hello $x <br>'; // Returns Hello $x 


// Using double quotes
$x = "John";
echo "Hello $x\n";
echo "\tHow are you?\n";
echo "<br>";
// Using single quotes
$x = 'John';
echo 'Hello $x\n';
echo '\tHow are you?\n <br>';

echo strlen("Hello world!");
echo "<br>";
echo str_word_count("Hello world!");
echo "<br>";

$txt = "I really love PHP!";
echo (str_contains($txt, "love"));
echo "<br>";
var_dump(str_contains($txt, "love"));
echo "<br>";
print(str_contains($txt, "love"));
echo "<br>";

echo strpos("Helgglo world!", "world");
echo "<br>";

$x = "Hello World!";
echo str_replace("World", "Dolly", $x);
echo "<br>";

$x = "Hello World!";
echo strrev($x);
echo "<br>";

$x = "    Hello World! ";
echo trim($x);
echo "<br>";

$x = "Hello lovely World! g";
$y = explode(" ", $x);
//Use print_r() to display the result
print_r($y);
echo "<br>";

$x = "Hello";
$y = "World";
$z = $x . $y;
echo $z;
echo "<br>";

$x = "Hello";
$y = "World";
$z = $x . " " . $y;
echo $z;
echo "<br>";


$x = 5;
$y = 10;
$z = "$x . $y";
echo $z;
echo "<br>";

$z = $x . $y;
echo $z;
echo "<br>";

$x = "Hello Worldfff!";
echo substr($x, 6, 5);
echo "<br>";
echo substr($x, 6);
echo "<br>";
echo substr($x, -5,3);
echo "<br>";
echo substr($x, -5,-1);
echo "<br>";

$x = "We are the so-called \t Vikings\" from the north.";
echo $x;
echo "<br>";

$x = "John";
echo "Hello $x"; // Returns Hello John
echo "<br>";

$txt = "I really love PHP!";
var_dump(str_contains($txt, "love"));
echo "<br>";
















?>