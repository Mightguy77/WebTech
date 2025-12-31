<?php
    $x = 5;
    var_dump($x); // dumps int(5)

    $x = 'Hello world!';
var_dump($x);
echo "<br>";


$x = 5985;
var_dump($x);
echo "<br>";

$x = 10.365;
var_dump($x);
echo "<br>";


$x = true;
var_dump($x);
echo "<br>";


$cars = array("Volvo","BMW","Toyota");
var_dump($cars);
echo "<br>";

class Car {
  public $color;
  public $model;
  public function __construct($color, $model) {
    $this->color = $color;
    $this->model = $model;
  }
  public function message() {
    return "My car is a " . $this->color . " " . $this->model . "!";
  }
}

$myCar = new Car("red", "Volvo");
var_dump($myCar);
echo "<br>";
echo $myCar->message(); // correct call
echo "<br>";


$x = "Hello world!";
$x = null;
var_dump($x);
echo "<br>";

?>