<?php

$path = "/assets/json/201415moduleList.json";

//$finalpath = set_include_path(get_include_path() . PATH_SEPARATOR . $path);

echo get_include_path();

echo "<br>";

echo $finalpath;

echo "<br>";

$finalpath = $_SERVER['REQUEST_URI'] . "/assets/json/201415moduleList.json";

echo $finalpath;

echo "<br>";

$string = file_get_contents($finalpath);

//echo file_get_contents("../assets/json/201415moduleInformation.json");

//echo $string;

echo ini_get('include_path');

$json_a = json_decode($string, true);

var_dump($json_a);

foreach ($json_a as $key => $value){
    echo  $key . ':' . $value;
    
}

?>