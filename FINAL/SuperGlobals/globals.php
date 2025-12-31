
<?php
$x = 75;

function myfunction() {
  echo $GLOBALS['x'];
  
}
 
myfunction();
echo "<br>";


$x = 10;
$y = 20;

function result() {
  $GLOBALS['z'] = $GLOBALS['x'] + $GLOBALS['y'];
}

result();
echo $z;
echo "<br>";
?>