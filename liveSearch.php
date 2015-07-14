<?php

session_start();
$finalpath1 = getcwd() . "/assets/json/201415moduleList.json";
$string1 = file_get_contents($finalpath1);
$json_a = json_decode($string1, true);

//get the q parameter from URL
$q = strtoupper($_GET["q"]);

//lookup all links from the xml file if length of q>0
if (strlen($q) > 0) {
    $hint = "";
    $counter = 0;
    $modulesExist;
    for ($i = 0; $i < count($json_a); $i++) {
        if ($counter < 10) {
            if (strstr($json_a[$i]["ModuleCode"], $q) or strstr(strtoupper($json_a[$i]["ModuleTitle"]), $q)) {
                if ($_GET["semester"] != 'True') {
                    if ($_SESSION['planCurriculum'] == 'True') {
                        if (count($_SESSION['modulesExempted']) != 0) {
                            $modulesExist = false;
                            for ($x = 0; $x < count($_SESSION['modulesExempted']); $x++) {
                                if ($_SESSION['modulesExempted'][$x] == $json_a[$i]["ModuleCode"]) {
                                    $modulesExist = true;
                                    break;
                                }
                            }
                            if ($modulesExist == false) {
                                $hint = $hint . "<button value='" . $json_a[$i]["ModuleCode"] . "' onclick='additionalMod(this.value)'>" . $json_a[$i]["ModuleCode"] . " - " . $json_a[$i]["ModuleTitle"] . "</button><br />";
                            }
                        } else {
                            $hint = $hint . "<button value='" . $json_a[$i]["ModuleCode"] . "' onclick='additionalMod(this.value)'>" . $json_a[$i]["ModuleCode"] . " - " . $json_a[$i]["ModuleTitle"] . "</button><br />";
                        }
                    } else {
                        $hint = $hint . "<a href='moduleDetailInfoView.php?q=" . $json_a[$i]["ModuleCode"] . "'>" . $json_a[$i]["ModuleCode"] . " - " . $json_a[$i]["ModuleTitle"] . "</a><br />";
                    }
                } else if ($_GET["semester"] == 'True') {
                    // Check exempted modules not in $hint when user type
                    $hint = $hint . "<button value='" . $json_a[$i]["ModuleCode"] . "' onclick='addToCurriculum(this.value)'>" . $json_a[$i]["ModuleCode"] . " - " . $json_a[$i]["ModuleTitle"] . "</button><br />";   
                }
                $counter++;
            }
        } else {
            break;
        }
    }
}

// Set output to "no suggestion" if no hint was found
// or to the correct values
if ($hint == "") {
    $response = "(1) No module of relevant search type, or <br> (2) Already exempted";
} else {
    $response = $hint;
}
//output the response
echo $response;
?>