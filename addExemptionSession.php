<?php

//get the q parameter from URL
session_start();

$finalpath1 = getcwd() . "/assets/json/201415moduleInformation.json";
$string1 = file_get_contents($finalpath1);
$json_a = json_decode($string1, true);

$q = strtoupper($_GET["q"]);

array_push($_SESSION['modulesExempted'], $q);

for ($a = 0; $a < count($json_a); $a++) {
    if ($json_a[$a]["ModuleCode"] == $q) {
        array_push($_SESSION['totalModuleTaken'], $json_a[$a]);
        
        //$_SESSION['totalModuleTaken'][$_SESSION['totalModuleID']] = $json_a[$a];
        //$_SESSION['totalModuleID'] += 1;
        break;
    }
}
?>