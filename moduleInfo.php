<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
    "http://www.w3.org/TR/html4/strict.dtd">

<html>
    <head>
        <meta charset="UTF-8">
        <title>NUSPlan - Plan to be efficient ;)</title> 
    </head>
    <body>
        NUSPlan - Module Information<br>
    Navigation Bar -> <a href="index.php">Home </a> | <a href="aboutus.php">About us</a> | <a href="#"><font color='red'>Module Information</font></a> | <a href="stepsToGit.php">GIT Steps</a> | <br>
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
</body>
</html>