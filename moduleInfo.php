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
    <br>
    <?php
    $finalpath = getcwd() . "/assets/json/201415moduleList.json";

    $string = file_get_contents($finalpath);

    $json_a = json_decode($string, true);

    //print_r($json_a);
    // To verify that there is something -> var_dump($json_a);

    echo "<table border=1>";
    echo "<tr><td>Module Code</td>";
    echo "<td>Module Title</td></tr>";

    $listOfItem = array("ModuleCode", "ModuleTitle", "Semesters");

    for ($i = 0; $i < count($json_a); $i++) {
        echo "<tr>";
        for ($x = 0; $x < count($json_a[$i]) - 1; $x++) {
            echo "<td>";
            if ($x == 0) {
                echo "<a href='moduleDetailInfo.php/" . $json_a[$i][$listOfItem[$x]] . "'>" .$json_a[$i][$listOfItem[$x]]."</a>";
            }
            else {
                echo $json_a[$i][$listOfItem[$x]];
            }
            echo "</td>";
        }
        echo "</tr>";
    }

    echo "</table>";
    ?>
</body>
</html>