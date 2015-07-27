<?php

session_start();

$course = $_SESSION["course"];
$cohort = $_SESSION["cohort"];
$specialization = $_SESSION["specialization"];

if (isset($_GET["poly"])) {
    if ($_GET["poly"] == 'yes') {
        $exemption = $_GET["poly"];
        $_SESSION["poly"] = $exemption;
    } else if ($_GET["poly"] == 'no') {
        $_SESSION["poly"] = "";
    }
    $_SESSION['whereAmI'] = 'poly';
} else if (isset($_SESSION["poly"])) {
    $exemption = $_SESSION["poly"];
    $_SESSION['whereAmI'] = "";
}

if ($_SESSION['whereAmI'] == 'poly') {
    header('Location: planCurriculumView.php');
}

$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);

$conn = new mysqli($server, $username, $password, $db);

// Check connection
/*
  if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
  } else {
  echo "Connected successfully";
  }
 */

$gemCompleted = [];
$breadthCompleted = [];
$singaporeCompleted = [];
$ueCompleted = [];
$programElectivesCompleted = [];

for ($i = 0; $i < count($_SESSION['totalModuleTaken']); $i++) {
    if ($_SESSION['totalModuleTaken'][$i]["requirement"] == "Breadth") {
        array_push($breadthCompleted, $_SESSION['totalModuleTaken'][$i]);
    } else if ($_SESSION['totalModuleTaken'][$i]["requirement"] == "Singapore Studies") {
        array_push($singaporeCompleted, $_SESSION['totalModuleTaken'][$i]);
    } else if ($_SESSION['totalModuleTaken'][$i]["requirement"] == "Unrestricted Electives") {
        array_push($ueCompleted, $_SESSION['totalModuleTaken'][$i]);
    } else if ($_SESSION['totalModuleTaken'][$i]["requirement"] == "General Education") {
        array_push($gemCompleted, $_SESSION['totalModuleTaken'][$i]);
    } else if ($_SESSION['totalModuleTaken'][$i]["requirement"] == "Electives") {
        array_push($programElectivesCompleted, $_SESSION['totalModuleTaken'][$i]);
    }
}

echo "<div class='panel panel-primary'>";
echo "<div class='panel-heading'>";
echo "<h3 class='panel-title'>" . $course . " - Batch " . $cohort . " - " . $specialization . "</h3>";
echo "</div>";

echo "<div class='panel-body'>";

$tablePrinting = "<table width='100%' border=1 cellspacing=5 cellpadding=5><tr><td width='20%'>&nbsp;&nbsp;Module Code</td><td>&nbsp;&nbsp;Module Name</td><td align><center>Module Credits</center></td></tr>";
$totalCreditNow = 0;

// Finding GEM
// For ClearDB

  $sql = "SELECT modules.module_id AS 'Module Code', modules.module_name AS 'Modules Name', modules.module_credit AS 'Modules Credit'
  FROM curriculum, requirements, modules, module_types
  WHERE requirements.cohort = '" . $cohort . "'
  AND requirements.major = '" . $course . "'
  AND curriculum.type_id = '5'
  AND curriculum.requirement_id = requirements.requirement_id
  AND curriculum.module_id = modules.module_id
  AND curriculum.type_id = module_types.type_id";


// For Localhost MySQL
//$sql = "SELECT test.modules.module_id AS 'Module Code', test.modules.module_name AS 'Modules Name', test.modules.module_credit AS 'Modules Credit'
//            FROM test.curriculum, test.requirements, test.modules, test.module_types
//            WHERE test.requirements.cohort = '" . $cohort . "'
//                AND test.requirements.major = '" . $course . "'
//                AND test.curriculum.type_id = '5'
//                AND test.curriculum.requirement_id = test.requirements.requirement_id
//                AND test.curriculum.module_id = test.modules.module_id
//                AND test.curriculum.type_id = test.module_types.type_id";

$result = $conn->query($sql);

$gemList;
$ssAmount = 1;
$gemAmount = 2;
$breadthAmount = 2;

if ($result->num_rows > 0) {
    $gemExemption = [];
    while ($row = $result->fetch_assoc()) {
        if (!in_array($row["Module Code"], array_column($_SESSION['totalModuleTaken'], "ModuleCode"))) {
            if ($row['Module Code'] == "GEK1901" || $row['Module Code'] == "GEK1549") {
                $gek1549 = $result->fetch_assoc();
                if (!in_array($gek1549['Module Code'], array_column($_SESSION['totalModuleTaken'], "ModuleCode"))) {
                    $gemList .= "<tr><td>&nbsp;&nbsp;" . $row["Module Code"] . "<br>&nbsp;&nbsp;OR<br>&nbsp;&nbsp;" . $gek1549["Module Code"] . "</td><td>&nbsp;&nbsp;" . $row["Modules Name"] . "<br>&nbsp;&nbsp;OR<br>&nbsp;&nbsp;" . $gek1549["Modules Name"] . "</td><td align=center>" . $row["Modules Credit"] . "</td></tr>";
                    $gemAmount -= 1;
                } else {
                    $gemList .= "<tr><td>&nbsp;&nbsp;<strike>" . $row["Module Code"] . "</strike><br>&nbsp;&nbsp;<strike>OR</strike><br>&nbsp;&nbsp;<strike>" . $gek1549["Module Code"] . "</strike></td><td>&nbsp;&nbsp;<strike>" . $row["Modules Name"] . "</strike><br>&nbsp;&nbsp;<strike>OR</strike><br>&nbsp;&nbsp;<strike>" . $gek1549["Modules Name"] . "</strike></td><td align=center><strike>" . $row["Modules Credit"] . "</strike></td></tr>";
                    //$totalCreditNow -= $row["Modules Credit"];
                }
            }
        } else {
            if ($row['Module Code'] == "GEK1901" || $row['Module Code'] == "GEK1549") {
                $gek1549 = $result->fetch_assoc();
                $gemList .= "<tr><td>&nbsp;&nbsp;<strike>" . $row["Module Code"] . "</strike><br>&nbsp;&nbsp;<strike>OR</strike><br>&nbsp;&nbsp;<strike>" . $gek1549["Module Code"] . "</strike></td><td>&nbsp;&nbsp;<strike>" . $row["Modules Name"] . "</strike><br>&nbsp;&nbsp;<strike>OR</strike><br>&nbsp;&nbsp;<strike>" . $gek1549["Modules Name"] . "</strike></td><td align=center><strike>" . $row["Modules Credit"] . "</strike></td></tr>";
                array_push($gemExemption, $row["Module Code"]);
            }
        }
    }
}

// From Poly or not
if ($exemption == "yes") {
    $gemAmount -= 1;
    $breadthAmount -= 1;
    $urlAmount = 3;
} else {
    $urlAmount = 5;
}

for ($i = 0; $i < count($gemCompleted); $i++) {
    if ($gemCompleted[$i]["ModuleCode"] != "GEK1901" || $gemCompleted[$i]["ModuleCode"] != "GEK1549") {
        $gemAmount -= 1;
    }
}

$ssAmount -= count($singaporeCompleted);
$breadthAmount -= count($breadthCompleted);
$urlAmount = $urlAmount - (count($singaporeCompleted) + count($breadthCompleted) + count($gemCompleted));

$totalCreditNow += ($urlAmount * 4);

if ($urlAmount == 5) {
    $tablePrinting .= "<tr><th colspan='3'><font size='3'>&nbsp;&nbsp;University Level Requirements (ULR) (20MCs)</font></th></tr>";
    $tablePrinting .= $gemList;
    $tablePrinting .= "<tr><td colspan='3' align='center'> Remaining ULR - 16 MCs <br> 1 General Education, 1 Singapore Studies & 2 Breadth";
} else {
    $tablePrinting .= "<tr><th colspan='3'><font size='3'>&nbsp;&nbsp;University Level Requirements (ULR) (<strike>20</strike> " . ($urlAmount * 4) . " MCs)</font></th></tr>";
    $tablePrinting .= $gemList;
    $totalMC += ((5 - (count($singaporeCompleted) + count($breadthCompleted) + count($gemCompleted))) * 4);
    if ((($gemAmount + $ssAmount + $breadthAmount) * 4) == 16) {
        $tablePrinting .= "<tr><td colspan='3' align='center'> Remaining ULR - 16 MCs <br> ";
    } else {
        $tablePrinting .= "<tr><td colspan='3' align='center'> Remaining ULR - <strike>16</strike> " . (($gemAmount + $ssAmount + $breadthAmount) * 4) . " MCs <br> ";
    }
    if ($gemAmount == 1) {
        $tablePrinting .= $gemAmount . " General Education, ";
    } else {
        $tablePrinting .= "<strike>1</strike> " . $gemAmount . " General Education, ";
    }
    if ($ssAmount == 1) {
        $tablePrinting .= $ssAmount . " Singapore Studies & ";
    } else {
        $tablePrinting .= "<strike>1</strike> " . $gemAmount . " Singapore Studies & ";
    }
    if ($breadthAmount == 2) {
        $tablePrinting .= $breadthAmount . " Breadth";
    } else {
        $tablePrinting .= "<strike>2</strike> " . $breadthAmount . " Breadth";
    }
    $tablePrinting .= "</td></tr>";
}

// Finding Program Requirement - Core and Internship
$programCore;
$programInternship;

// For ClearDB

  $sql = "SELECT modules.module_id AS 'Module Code', modules.module_name AS 'Modules Name', modules.module_credit AS 'Modules Credit'
  FROM curriculum, requirements, modules, module_types
  WHERE requirements.cohort = '" . $cohort . "'
  AND requirements.major = '" . $course . "'
  AND curriculum.type_id = '1'
  AND curriculum.requirement_id = requirements.requirement_id
  AND curriculum.module_id = modules.module_id
  AND curriculum.type_id = module_types.type_id";


// For localhost
//$sql = "SELECT test.modules.module_id AS 'Module Code', test.modules.module_name AS 'Modules Name', test.modules.module_credit AS 'Modules Credit'
//            FROM test.curriculum, test.requirements, test.modules, test.module_types
//            WHERE test.requirements.cohort = '" . $cohort . "'
//                AND test.requirements.major = '" . $course . "'
//                AND test.curriculum.type_id = '1'
//                AND test.curriculum.requirement_id = test.requirements.requirement_id
//                AND test.curriculum.module_id = test.modules.module_id
//                AND test.curriculum.type_id = test.module_types.type_id";


$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if (!in_array($row["Module Code"], array_column($_SESSION['totalModuleTaken'], "ModuleCode"))) {
            if ($row['Module Code'] == "MA1521" || $row['Module Code'] == "MA1312") {
                $ma1521 = $result->fetch_assoc();
                if (!in_array($ma1521['Module Code'], array_column($_SESSION['totalModuleTaken'], "ModuleCode"))) {
                    $programCore .= "<tr><td>&nbsp;&nbsp;" . $row["Module Code"] . "<br>&nbsp;&nbsp;OR<br>&nbsp;&nbsp;" . $ma1521["Module Code"] . "</td><td>&nbsp;&nbsp;" . $row["Modules Name"] . "<br>&nbsp;&nbsp;OR<br>&nbsp;&nbsp;" . $ma1521["Modules Name"] . "</td><td align=center>" . $row["Modules Credit"] . "</td></tr>";
                } else {
                    $programCore .= "<tr><td>&nbsp;&nbsp;<strike>" . $row["Module Code"] . "</strike><br>&nbsp;&nbsp;<strike>OR</strike><br>&nbsp;&nbsp;<strike>" . $ma1521["Module Code"] . "</strike></td><td>&nbsp;&nbsp;<strike>" . $row["Modules Name"] . "</strike><br>&nbsp;&nbsp;<strike>OR</strike><br>&nbsp;&nbsp;<strike>" . $ma1521["Modules Name"] . "</strike></td><td align=center><strike>" . $row["Modules Credit"] . "</strike></td></tr>";
                    $totalCreditNow -= $row["Modules Credit"];
                }
            } else if ($row['Module Code'] == "IS4010") {
                $programInternship .= "<tr><td>&nbsp;&nbsp;" . $row["Module Code"] . "</td><td>&nbsp;&nbsp;" . $row["Modules Name"] . "</td><td align=center>" . $row["Modules Credit"] . "</td></tr>";
            } else {
                $programCore .= "<tr><td>&nbsp;&nbsp;" . $row["Module Code"] . "</td><td>&nbsp;&nbsp;" . $row["Modules Name"] . "</td><td align=center>" . $row["Modules Credit"] . "</td></tr>";
            }
            $totalCreditNow += $row["Modules Credit"];
        } else {
            if ($row['Module Code'] == "MA1521" || $row['Module Code'] == "MA1312") {
                $ma1521 = $result->fetch_assoc();
                $programCore .= "<tr><td>&nbsp;&nbsp;<strike>" . $row["Module Code"] . "</strike><br>&nbsp;&nbsp;<strike>OR</strike><br>&nbsp;&nbsp;<strike>" . $ma1521["Module Code"] . "</strike></td><td>&nbsp;&nbsp;<strike>" . $row["Modules Name"] . "</strike><br>&nbsp;&nbsp;<strike>OR</strike><br>&nbsp;&nbsp;<strike>" . $ma1521["Modules Name"] . "</strike></td><td align=center><strike>" . $row["Modules Credit"] . "</strike></td></tr>";
            } else if ($row['Module Code'] == "IS4010") {
                $programInternship .= "<tr><td>&nbsp;&nbsp;<strike>" . $row["Module Code"] . "</strike></td><td>&nbsp;&nbsp;<strike>" . $row["Modules Name"] . "</strike></td><td align=center><strike>" . $row["Modules Credit"] . "</strike></td></tr>";
            } else {
                $programCore .= "<tr><td>&nbsp;&nbsp;<strike>" . $row["Module Code"] . "</strike></td><td>&nbsp;&nbsp;<strike>" . $row["Modules Name"] . "</strike></td><td align=center><strike>" . $row["Modules Credit"] . "</strike></td></tr>";
            }
        }
    }
}

$tablePrinting .= "<tr><th colspan='3'><font size='3'>&nbsp;&nbsp;Programme Requirements - Core Modules (80 MCs)</font></th></tr>";
$tablePrinting .= $programCore;

// Finding Program Electives
$programElectives;

// For ClearDB
  $sql = "SELECT modules.module_id AS 'Module Code', modules.module_name AS 'Modules Name', modules.module_credit AS 'Modules Credit', specialization.specialization_name AS 'Specialization'
  FROM curriculum, requirements, modules, module_types, specialization
  WHERE requirements.cohort = '" . $cohort . "'
  AND requirements.major = '" . $course . "'
  AND curriculum.type_id = '6'
  AND curriculum.requirement_id = requirements.requirement_id
  AND curriculum.module_id = modules.module_id
  AND curriculum.type_id = module_types.type_id
  AND curriculum.specialization_id = specialization.specialization_id
  ORDER BY modules.module_id";

// For Localhost
//$sql = "SELECT test.modules.module_id AS 'Module Code', test.modules.module_name AS 'Modules Name', test.modules.module_credit AS 'Modules Credit', test.specialization.specialization_name AS 'Specialization'
//            FROM test.curriculum, test.requirements, test.modules, test.module_types, test.specialization
//            WHERE test.requirements.cohort = '" . $cohort . "'
//                AND test.requirements.major = '" . $course . "'
//                AND test.curriculum.type_id = '6'
//                AND test.curriculum.requirement_id = test.requirements.requirement_id
//                AND test.curriculum.module_id = test.modules.module_id
//                AND test.curriculum.type_id = test.module_types.type_id
//                AND test.curriculum.specialization_id = test.specialization.specialization_id
//            ORDER BY test.modules.module_id";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if (!in_array($row["Module Code"], array_column($_SESSION['totalModuleTaken'], "ModuleCode")) || !in_array("IS4010", array_column($_SESSION['totalModuleTaken'], "ModuleCode"))) {
            // Need take note now is Information Security (Information System) and Information Security (Computer Science)
            if ($row["Specialization"] == $specialization) {
                if ($specialization == 'Services Science, Management and Engineering' && ($row["Module Code"] == 'IS3220' || $row["Module Code"] == 'IS4224')) {
                    $programCompulsory .= "<tr><td><b>&nbsp;&nbsp;" . $row["Module Code"] . "</b></td><td><b>&nbsp;&nbsp;" . $row["Modules Name"] . "</b></td><td align=center><b>" . $row["Modules Credit"] . "</b></td>";
                } else {
                    $programElectives .= "<tr><td><b>&nbsp;&nbsp;" . $row["Module Code"] . "</b></td><td><b>&nbsp;&nbsp;" . $row["Modules Name"] . "</b></td><td align=center><b>" . $row["Modules Credit"] . "</b></td>";
                }
            } else {
                $programElectivesNon .= "<tr><td>&nbsp;&nbsp;" . $row["Module Code"] . "</td><td>&nbsp;&nbsp;" . $row["Modules Name"] . "</td><td align=center>" . $row["Modules Credit"] . "</td>";
            }
        } else {
            if ($row["Specialization"] == $specialization) {
                if ($specialization == 'Services Science, Management and Engineering' && ($row["Module Code"] == 'IS3220' || $row["Module Code"] == 'IS4224')) {
                    $programCompulsory .= "<tr><td><b>&nbsp;&nbsp;<strike>" . $row["Module Code"] . "</strike></b></td><td><b>&nbsp;&nbsp;<strike>" . $row["Modules Name"] . "</strike></b></td><td align=center><b><strike>" . $row["Modules Credit"] . "</strike></b></td>";
                } else {
                    $programElectives .= "<tr><td><b>&nbsp;&nbsp;<strike>" . $row["Module Code"] . "</strike></b></td><td><b>&nbsp;&nbsp;<strike>" . $row["Modules Name"] . "</strike></b></td><td align=center><b><strike>" . $row["Modules Credit"] . "</strike></b></td>";
                }
            } else {
                $programElectivesNon .= "<tr><td>&nbsp;&nbsp;<strike>" . $row["Module Code"] . "</strike></td><td>&nbsp;&nbsp;<strike>" . $row["Modules Name"] . "</strike></td><td align=center><strike>" . $row["Modules Credit"] . "</strike></td>";
            }
        }
    }
}

$tablePrinting .= "<tr><th colspan='3'><font size='3'>&nbsp;&nbsp;Programme Requirements - Core Electives (28 MCs)</font></th></tr>";

if ($specialization == "Information Security") {
    $tablePrinting .= "<tr><td>&nbsp;&nbsp;Requirement 1</td><td colspan='2'>&nbsp;&nbsp;Choose 7 modules to make up 28 MCs from the list of Programme Electives below. <br>&nbsp;&nbsp;3 of the 7 modules must be at level-4000</td></tr>";
    $tablePrinting .= "<tr><td>&nbsp;&nbsp;Requirement 2</td><td colspan='2'>&nbsp;&nbsp;For " . $specialization . " Specialization - Choose at least 6 Modules from highlighted list and remaining on any module</td></tr>";
} else if ($specialization == "Services Science, Management and Engineering") {
    $tablePrinting .= "<tr><td>&nbsp;&nbsp;Requirement 1</td><td colspan='2'>&nbsp;&nbsp;Choose 7 modules to make up 28 MCs from the list of Programme Electives below. <br>&nbsp;&nbsp;3 of the 7 modules must be at level-4000</td></tr>";
    $tablePrinting .= "<tr><td>&nbsp;&nbsp;Requirement 2</td><td colspan='2'>&nbsp;&nbsp;For " . $specialization . " Specialization - Compulsory Modules</td></tr>";
    $tablePrinting .= $programCompulsory;
    $tablePrinting .= "<tr><td>&nbsp;&nbsp;Requirement 3</td><td colspan='2'>&nbsp;&nbsp;For " . $specialization . " Specialization - Choose at least 4 from from highlighted list and remaining on any module</td></tr>";
} else {
    $tablePrinting .= "<tr><td><b>&nbsp;&nbsp;Option 1</b></td><td colspan='2'>&nbsp;&nbsp;Choose 7 modules to make up 28 MCs from the list of Programme Electives below. <br>&nbsp;&nbsp;3 of the 7 modules must be at level-4000</td></tr>";
    $tablePrinting .= "<tr><td><b>&nbsp;&nbsp;Option 2</b></td><td colspan='2'>&nbsp;&nbsp;Choose CP4101 and 4 modules to make up 28 MCs from the list of Programme Electives below.</td></tr>";
}

$tablePrinting .= $programElectives;
$tablePrinting .= $programElectivesNon;
$totalCreditNow += 28 - (count($programElectivesCompleted) * 4);
$tablePrinting .= "<tr><th colspan='3'><font size='3'>&nbsp;&nbsp;Programme Internship</font></th></tr>";
$tablePrinting .= $programInternship;

if ($exemption == "yes") {
    $ueAmount = 2;
} else {
    $ueAmount = 5;
}

$ueAmount -= count($ueCompleted);
$totalCreditNow += $ueAmount * 4;

$tablePrinting .= "<tr><th colspan='3'><font size='3'>&nbsp;&nbsp;Unrestricted Electives (";
if ($ueAmount == 5) {
    $tablePrinting .= ($ueAmount * 4) . " MCs)</font></th></tr>";
} else {
    $tablePrinting .= "<strike>20</strike> " . ($ueAmount * 4) . " MCs)</font></th></tr>";
}
if ($ueAmount == 5) {
    $tablePrinting .= "<tr><td colspan='3' align='center'>" . $ueAmount . " Modules from outside of home faculty</td></tr>";
} else {
    $tablePrinting .= "<tr><td colspan='3' align='center'><strike>5</strike> " . $ueAmount . " Modules from outside of home faculty</td></tr>";
}

$tablePrinting .= "<tr><td colspan='2' align='right'>Total Remaining&nbsp;&nbsp;<td align='center'>" . $totalCreditNow . "</td></tr>";

echo $tablePrinting;

echo "</div>";
echo "</div>";
$conn->close();
?>