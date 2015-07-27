<?php

session_start();

$finalpath1 = getcwd() . "/assets/json/201415moduleInformation.json";
$string1 = file_get_contents($finalpath1);
$json_a = json_decode($string1, true);

if (!empty($_SESSION['modulesExempted'])) {
    echo "List of Exemption:<br>";
    echo "<table border = '1' width = '100%'>";
    echo "<tr><td width='10%'><center>No.</center></td><td width='20%'>&nbsp;&nbsp;Module Code</td><td width='50%'>&nbsp;&nbsp;Module Name</td><td width='10%'><center>Module Credits</center></td><td width='10%'><center>Applicable</center></td></tr>";

    $url = parse_url(getenv("CLEARDB_DATABASE_URL"));

    $server = $url["host"];
    $username = $url["user"];
    $password = $url["pass"];
    $db = substr($url["path"], 1);

    $conn = new mysqli($server, $username, $password, $db);

    // For Heroku
    $sql = "SELECT DISTINCT modules.module_id AS 'Module Code', modules.module_name AS 'Modules Name', modules.module_credit AS 'Modules Credit'
        FROM curriculum, requirements, modules, module_types
        WHERE curriculum.requirement_id = requirements.requirement_id
        AND curriculum.module_id = modules.module_id
        AND curriculum.type_id = module_types.type_id";
    
    // Localhost
//    $sql = "SELECT DISTINCT test.modules.module_id AS 'Module Code', test.modules.module_name AS 'Modules Name', test.modules.module_credit AS 'Modules Credit'
//        FROM test.curriculum, test.requirements, test.modules, test.module_types
//        WHERE test.curriculum.requirement_id = test.requirements.requirement_id
//        AND test.curriculum.module_id = test.modules.module_id
//        AND test.curriculum.type_id = test.module_types.type_id";
    
    $result = $conn->query($sql);

    $allModules = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($allModules, $row);
        }
    }
    
    for ($i = 1; $i <= count($_SESSION['modulesExempted']); $i++) {
        $verified = false;
        for ($a = 0; $a < count($allModules); $a++) {
            if ($_SESSION['modulesExempted'][$i-1] == $allModules[$a]["Module Code"]) {
                $verified = true;
                break;
            }
        }
        
        if ($verified == true) {
            echo "<tr><td><center>" . $i . "</center></td><td>&nbsp;&nbsp;" . $_SESSION['modulesExempted'][$i-1] . "</td><td>&nbsp;&nbsp;" . $allModules[$a]['Modules Name'] . "</td><td align=center>" . $allModules[$a]['Modules Credit'] . "</td><td><center>Yes</center></td></tr>";
        } else {
            for ($a = 0; $a < count($json_a); $a++) {
                if ($_SESSION['modulesExempted'][$i-1] == $json_a[$a]["ModuleCode"]) {
                    echo "<tr><td><center>" . $i . "</center></td><td>&nbsp;&nbsp;" . $_SESSION['modulesExempted'][$i-1] . "</td><td>&nbsp;&nbsp;" . $json_a[$a]['ModuleTitle'] . "</td><td align=center>" . $json_a[$a]['ModuleCredit'] . "</td><td><center>No</center></td></tr>";
                }
            }
        }
    }
    echo "</table>";
}
?>