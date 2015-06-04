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
    $parts = explode('/', $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
    $last = end($parts);

    $finalpath1 = getcwd() . "/assets/json/201415moduleList.json";
    $string1 = file_get_contents($finalpath1);
    $json_a = json_decode($string1, true);

    $finalpath2 = getcwd() . "/assets/json/201415moduleInformation.json";
    $string2 = file_get_contents($finalpath2);
    $json_b = json_decode($string2, true);

    $finalpath3 = "http://api.nusmods.com/2014-2015/modules/" . $last . ".json";
    $string3 = file_get_contents($finalpath3);
    $json_c = json_decode($string3, true);

    //print_r($json_a);
    //print_r($json_b);
    // To verify that there is something -> var_dump($json_a);
    echo $last . " : ";

    $currentObject1 = 0;
    $currentObject2 = 0;

    // Module's Code
    for ($i = 0; $i < count($json_a); $i++) {
        if ($json_a[$i]["ModuleCode"] == $last) {
            $currentObject1 = $json_a[$i];
            echo $json_a[$i]["ModuleTitle"] . "<br><br>";
        }
    }

    // Module's Title
    for ($i = 0; $i < count($json_b); $i++) {
        if ($json_b[$i]["ModuleCode"] == $last) {
            $currentObject2 = $json_b[$i];
            echo "Description: <br>" . $json_b[$i]["ModuleDescription"] . "<br><br>";
        }
    }

    // Module's Semesters Offered
    echo "Semesters offered: ";
    for ($i = 0; $i < count($currentObject1["Semesters"]); $i++) {
        echo $currentObject1["Semesters"][$i] . " ";
    }
    echo "<br><br>";

    // Module's Module Credits
    echo "Module Credits (MCs) : " . $currentObject2["ModuleCredit"] . "<br><br>";

    // Module's Prerequisite
    echo "Prerequisite(s): ";
    if ($currentObject2["Prerequisite"] == null) {
        echo "-Nil-";
    } else {
        echo $currentObject2["Prerequisite"];
    }
    echo "<br><br>";

    // Module's Preconclusion
    echo "Preconclusion(s): ";
    if ($currentObject2["Preclusion"] == null) {
        echo "-Nil-";
    } else {
        echo $currentObject2["Preclusion"];
    }
    echo "<br><br>";

    // Module's Department
    echo "Department : " . $currentObject2["Department"] . "<br><br>";

    // Module's Workload
    $workLoadCode = array("Lecture: ", "Tutorial: ", "Laboratory: ", "Project: ", "Preparation: ");
    $currentModuleWorkLoad = split('[-]', $currentObject2["Workload"]);
    if (!count($currentModuleWorkLoad) == 0) {
        echo "Weekly Workload: <br>";
        for ($i = 0; $i < count($currentModuleWorkLoad); $i++) {
            echo $workLoadCode[$i] . " " . $currentModuleWorkLoad[$i] . " hrs<br>";
        }
        echo "<br>";
    }

    // Module's Exam Date and Time
    for ($i = 0; $i < count($currentObject2["History"]); $i++) {
        echo "Semester " . $currentObject2["History"][$i]["Semester"] . " Exam Date: ";
        if ($currentObject2["History"][$i]["ExamDate"] == null) {
            echo "No exam <br><br>";
        } else {
            $dt = new DateTime($currentObject2["History"][$i]["ExamDate"]);
            echo $dt->format("d-m-Y, g:i A");
            echo "<br><br>";
        }
    }

    // Module's Prerequisites Tree
    echo "Prerequisites Tree: <br>";
    echo "On Top: ";
    // Find LockedModules (Above)
    // Find ModmavenTrees then find children -> children and so on
    //echo count($json_c["LockedModules"]);

    if ($json_c["LockedModules"] == null) {
        echo "-Nil-";
    } else {
        for ($i = 0; $i < count($json_c["LockedModules"]); $i++) {
            echo $json_c["LockedModules"][$i] . " ";
        }
    }

    echo "<br>";
    $currentModuleChildren = $json_c["ModmavenTree"]["children"];
    echo "Below: ";
    if ($currentModuleChildren == null) {
        echo "No Child";
    } else {
        /*
        $i = 0;
        while (!empty($currentModuleChildren)) {
            $current = $currentModuleChildren[$i]["name"];
            echo $current;
            if ($currentModuleChildren[$i]["name"] == "or" || $currentModuleChildren[$i]["name"] == "and") {
                for ($x = 0; $x < count($currentModuleChildren[$i]["children"]); $x++) {
                    echo $currentModuleChildren[$i]["children"][$x]["name"];
                }
            }
            $currentModuleChildren = $currentModuleChildren[0]["children"];
            $i++;
            echo " ";
        }
         * */
        echo "<br><br>";
        echo $currentModuleChildren[0]["name"] . " "; //or
        echo $currentModuleChildren[0]["children"][0]["name"] . " "; //CS2250
        echo $currentModuleChildren[0]["children"][1]["name"] . " "; //and
        echo $currentModuleChildren[0]["children"][1]["children"][0]["name"] . " "; //IS1103
        echo $currentModuleChildren[0]["children"][1]["children"][1]["name"] . " "; //IS1105
       
    }
    
    echo "<br><br>";

    //echo "CORS Bidding History (Needed?) " . $currentObject2["ModuleCredit"] . "<br><br>";
    //echo "Lesson Schedule (WIP) " . $currentObject2["ModuleCredit"] . "<br><br>";
    ?>
</body>
</html>