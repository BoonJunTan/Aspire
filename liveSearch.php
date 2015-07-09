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
    for ($i = 0; $i < count($json_a); $i++) {
        if ($counter < 10) {
            if (strstr($json_a[$i]["ModuleCode"], $q) or strstr(strtoupper($json_a[$i]["ModuleTitle"]), $q)) {
                if ($_SESSION['planCurriculum'] == 'True') {
                    $hint = $hint . "<button value='" . $json_a[$i]["ModuleCode"] . "' onclick='additionalMod(this.value)'>" . $json_a[$i]["ModuleCode"] . " - " . $json_a[$i]["ModuleTitle"] . "</button><br />";
                } else {
                    $hint = $hint . "<a href='moduleDetailInfoView.php?q=" . $json_a[$i]["ModuleCode"] . "'>" . $json_a[$i]["ModuleCode"] . " - " . $json_a[$i]["ModuleTitle"] . "</a><br />";
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
    $response = "No module of relevant search type.";
} else {
    $response = $hint;
}
//output the response
echo $response;
?>