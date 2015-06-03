<?php
$string = file_get_contents("/Applications/MAMP/htdocs/nusplan/assets/json/201415moduleList.json");

echo file_get_contents("../assets/json/201415moduleInformation.json");

echo $string;

$json_a = json_decode($string, true);

var_dump($json_a);

foreach ($json_a as $key => $value){
    echo  $key . ':' . $value;
    
}

?>


echo <?php echo $_SERVER['HTTP_HOST']; ?>