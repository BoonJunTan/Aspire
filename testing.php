This is a testing page

<?php

$path = "/assets/json/201415moduleList.json";

$finalpath = getcwd() . "/assets/json/201415moduleList.json";

$string = file_get_contents($finalpath);

$json_a = json_decode($string, true);

//print_r($json_a);
// To verify that there is something -> var_dump($json_a);

for ($i = 0; $i <= count($json_a); $i++) {
    echo $json_a[$i]["ModuleCode"];
    echo "<br>";
} 
?>