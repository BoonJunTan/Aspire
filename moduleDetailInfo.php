<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
    "http://www.w3.org/TR/html4/strict.dtd">

<html>
    <head>
        <meta charset="UTF-8">
        <title>NUSPlan - Plan to be efficient ;)</title> 
    </head>
    <body>
        NUSPlan - Module Information<br>
    Navigation Bar -> <a href="../index.php">Home </a> | <a href="../aboutus.php">About us</a> | <a href="../moduleInfo.php"><font color='red'>Module Information</font></a> | <a href="../stepsToGit.php">GIT Steps</a> | <br>
    <br>
    
    <?php
    $parts = explode('/', $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']);
    $last = end($parts);
    
    $finalpath1 = getcwd() . "/assets/json/201415moduleList.json";
    $string1 = file_get_contents($finalpath1);
    $json_a = json_decode($string1, true);

    $finalpath2 = getcwd() . "/assets/json/201415moduleInformation.json";
    $string2 = file_get_contents($finalpath2);
    $json_b = json_decode($string2, true);
    
    //print_r($json_a);
    //print_r($json_b);
    // To verify that there is something -> var_dump($json_a);
    echo "You selected " .  $last . " : ";
    
    $currentObject1 = 0;
    $currentObject2 = 0;

    for ($i = 0; $i < count($json_a); $i++) {
        if ($json_a[$i]["ModuleCode"] == $last) {
            $currentObject = $i;
            echo $json_a[$i]["ModuleTitle"] . "<br><br>";
        }
    }
    
    for ($i = 0; $i < count($json_b); $i++) {
        if ($json_b[$i]["ModuleCode"] == $last) {
            $currentObject2 = $i;
            echo $json_b[$i]["ModuleDescription"] . "<br><br>";
        }
    }
        
    ?>
</body>
</html>