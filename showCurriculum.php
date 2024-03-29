<?php

$course = $_GET["course"];
$cohort = $_GET["cohort"];
$specialization = $_GET["specialization"];

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
echo "<br><div class='panel panel-primary'>";
echo "<div class='panel-heading'>";
echo "<h3 class='panel-title'>" . $course . " - Batch " . $cohort . " - " . $specialization . "</h3>";
echo "</div>";

echo "<div class='panel-body'>";


$tablePrinting = "<table width='100%' border=1 cellspacing=5 cellpadding=5><tr><td width='15%'>&nbsp;&nbsp;Module Code</td><td>&nbsp;&nbsp;Module Name</td><td align><center>Module Credits</center></td></tr>";
$totalCreditNow = 0;

// Finding GEM
$gemList;

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

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($cohort == "14/15" && $row["Module Code"] == "GEK1901") {
            $gek1549 = $result->fetch_assoc();
            $gemList .= "<tr><td>&nbsp;&nbsp;" . $row["Module Code"] . "<br>&nbsp;&nbsp;OR<br>&nbsp;&nbsp;" . $gek1549["Module Code"] . "</td>";
            $gemList .= "<td>&nbsp;&nbsp;" . $row["Modules Name"] . "<br>&nbsp;&nbsp;OR<br>&nbsp;&nbsp;" . $gek1549["Modules Name"] . "</td>";
            $gemList .= "<td><center>" . $row["Modules Credit"] . "</center></td></tr>";
        } else if ($cohort == "15/16" && $row["Module Code"] == "GET1006") {
            $get1021 = $result->fetch_assoc();
            $gemList .= "<tr><td>&nbsp;&nbsp;" . $row["Module Code"] . "<br>&nbsp;&nbsp;OR<br>&nbsp;&nbsp;" . $get1021["Module Code"] . "</td>";
            $gemList .= "<td>&nbsp;&nbsp;" . $row["Modules Name"] . "<br>&nbsp;&nbsp;OR<br>&nbsp;&nbsp;" . $get1021["Modules Name"] . "</td>";
            $gemList .= "<td><center>" . $row["Modules Credit"] . "</center></td></tr>";
        }
        $totalCreditNow += $row["Modules Credit"];
    }
}

$tablePrinting .= "<tr><th colspan='3'><font size='5'>&nbsp;&nbsp;University Level Requirements (ULR) (20 MCs)</font></th></tr>";
$tablePrinting .= $gemList;
$tablePrinting .= "<tr><td colspan='3' align='center'> Remaining ULR - " . (20 - count($gemList) * 4) . " MCs<br>";
$tablePrinting .= (2 - count($gemList)) . " General Education, 1 Singapore Studies & 2 Breadth";
$totalCreditNow += (20 - count($gemList) * 4);

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
                AND curriculum.type_id = module_types.type_id
            ORDER BY modules.module_id";

// For localhost
//$sql = "SELECT test.modules.module_id AS 'Module Code', test.modules.module_name AS 'Modules Name', test.modules.module_credit AS 'Modules Credit'
//            FROM test.curriculum, test.requirements, test.modules, test.module_types
//            WHERE test.requirements.cohort = '" . $cohort . "' 
//                AND test.requirements.major = '" . $course . "'
//                AND test.curriculum.type_id = '1'
//                AND test.curriculum.requirement_id = test.requirements.requirement_id
//                AND test.curriculum.module_id = test.modules.module_id
//                AND test.curriculum.type_id = test.module_types.type_id
//            ORDER BY test.modules.module_id";

$result = $conn->query($sql);

$test = 0;
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row['Module Code'] == "MA1521" || $row['Module Code'] == "MA1312") {
            $ma1521 = $result->fetch_assoc();
            $programCore .= "<tr><td>&nbsp;&nbsp;" . $row["Module Code"] . "<br>&nbsp;&nbsp;OR<br>&nbsp;&nbsp;" . $ma1521["Module Code"] . "</td><td>&nbsp;&nbsp;" . $row["Modules Name"] . "<br>&nbsp;&nbsp;OR<br>&nbsp;&nbsp;" . $ma1521["Modules Name"] . "</td><td align=center>" . $row["Modules Credit"] . "</td></tr>";
        } else if ($row['Module Code'] == "IS4010") {
            $programInternship .= "<tr><td>&nbsp;&nbsp;" . $row["Module Code"] . "</td><td>&nbsp;&nbsp;" . $row["Modules Name"] . "</td><td align=center>" . $row["Modules Credit"] . "</td></tr>";
        } else {
            $programCore .= "<tr><td>&nbsp;&nbsp;" . $row["Module Code"] . "</td><td>&nbsp;&nbsp;" . $row["Modules Name"] . "</td><td align=center>" . $row["Modules Credit"] . "</td></tr>";
        }
        $totalCreditNow += $row["Modules Credit"];
    }
}

if ($course == "Information System") {
    $tablePrinting .= "<tr><th colspan='3'><font size='5'>&nbsp;&nbsp;Programme Requirements - Core Modules (80 MCs)</font></th></tr>";
} else if ($course == "Electronic Commerce") {
    $tablePrinting .= "<tr><th colspan='3'><font size='5'>&nbsp;&nbsp;Programme Requirements - Core Modules (60 MCs)</font></th></tr>";
}
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

$list1; 
$list2;
            
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row["Specialization"] == $specialization && $specialization != "No Specialization") {
            // Need take note now is Information Security (Information System) and Information Security (Computer Science)
            if ($specialization == 'Services Science, Management and Engineering' && ($row["Module Code"] == 'IS3220' || $row["Module Code"] == 'IS4224')) {
                $programCompulsory .= "<tr><td><font size='3'><b>&nbsp;&nbsp;" . $row["Module Code"] . "</b></td><td><b>&nbsp;&nbsp;" . $row["Modules Name"] . "</b></td><td align=center><b>" . $row["Modules Credit"] . "</b></font></td>";
            } else if ($specialization == 'Electronic Commerce' && ($row["Module Code"] == 'IS3150' || $row["Module Code"] == 'IS4150' || $row["Module Code"] == 'IS4260')) {
                $programCompulsory .= "<tr><td><font size='3'><b>&nbsp;&nbsp;" . $row["Module Code"] . "</b></td><td><b>&nbsp;&nbsp;" . $row["Modules Name"] . "</b></td><td align=center><b>" . $row["Modules Credit"] . "</b></font></td>";
            }
            else {
                $programElectives .= "<tr><td><font size='3'><b>&nbsp;&nbsp;" . $row["Module Code"] . "</b></td><td><b>&nbsp;&nbsp;" . $row["Modules Name"] . "</b></td><td align=center><b>" . $row["Modules Credit"] . "</b></font></td>";
            } 
        } else {
            if ($course == "Electronic Commerce") {
                if ($row["Module Code"] == "ACC1002X" || $row["Module Code"] == "ACC2002" || $row["Module Code"] == "BSP1004X" || $row["Module Code"] == "BSP1005" || $row["Module Code"] == "DSC2006" || $row["Module Code"] == "DSC3201" || $row["Module Code"] == "FIN2004" || $row["Module Code"] == "MNO1001X" || $row["Module Code"] == "MKT1003X" || $row["Module Code"] == "MKT2412" || $row["Module Code"] == "TR2201" || $row["Module Code"] == "TR2202" || $row["Module Code"] == "TR3001") {
                    $list2 .= "<tr><td><font size='3'><b>&nbsp;&nbsp;" . $row["Module Code"] . "</td><td>&nbsp;&nbsp;" . $row["Modules Name"] . "</td><td align=center>" . $row["Modules Credit"] . "</font></b></td>";
                } else if ($row["Module Code"] == "IS3220" || $row["Module Code"] == "IS3240" || $row["Module Code"] == "IS3241" || $row["Module Code"] == "CS4880") {
                    $list1 .= "<tr><td><font size='3'><b>&nbsp;&nbsp;" . $row["Module Code"] . "</td><td>&nbsp;&nbsp;" . $row["Modules Name"] . "</td><td align=center>" . $row["Modules Credit"] . "</font></b></td>";
                } else {
                    $programElectivesNon .= "<tr><td>&nbsp;&nbsp;" . $row["Module Code"] . "</td><td>&nbsp;&nbsp;" . $row["Modules Name"] . "</td><td align=center>" . $row["Modules Credit"] . "</td>";
                }
            } else {
                $programElectivesNon .= "<tr><td>&nbsp;&nbsp;" . $row["Module Code"] . "</td><td>&nbsp;&nbsp;" . $row["Modules Name"] . "</td><td align=center>" . $row["Modules Credit"] . "</td>";
            }
        }
    }
}

if ($course == "Information System") {
    $tablePrinting .= "<tr><th colspan='3'><font size='5'>&nbsp;&nbsp;Programme Requirements - Core Electives (28 MCs)</font></th></tr>";
} else if ($course == "Electronic Commerce") {
    $tablePrinting .= "<tr><th colspan='3'><font size='5'>&nbsp;&nbsp;Programme Requirements - Programme Electives (48 MCs)</font></th></tr>";
}

if ($specialization == "Information Security (Information Systems)") {
    $tablePrinting .= "<tr><td><center>&nbsp;&nbsp;Requirement 1:</center></td><td colspan='2'>&nbsp;&nbsp;Choose 7 modules to make up 28 MCs from the list of Programme Electives below. <br>&nbsp;&nbsp;3 of the 7 modules must be at level-4000</td></tr>";
    $tablePrinting .= "<tr><td><center>&nbsp;&nbsp;Requirement 2:</center></td><td colspan='2'>&nbsp;&nbsp;For " . $specialization . " Specialization - Choose at least 6 Modules from highlighted list and remaining on any module</td></tr>";
} else if ($specialization == "Services Science, Management and Engineering") {
    $tablePrinting .= "<tr><td><center>&nbsp;&nbsp;Requirement 1: </td><td colspan='2'>&nbsp;&nbsp;Choose 7 modules to make up 28 MCs from the list of Programme Electives below. <br>&nbsp;&nbsp;3 of the 7 modules must be at level-4000</td></tr>";
    $tablePrinting .= "<tr><td><center>&nbsp;&nbsp;Requirement 2: </td><td colspan='2'>&nbsp;&nbsp;For " . $specialization . " Specialization - Compulsory Modules</td></tr>";
    $tablePrinting .= $programCompulsory;
    $tablePrinting .= "<tr><td><center>&nbsp;&nbsp;Requirement 3: </td><td colspan='2'>&nbsp;&nbsp;For " . $specialization . " Specialization - Choose at least 4 from from highlighted list and remaining on any module</td></tr>";
} else if ($specialization == "Electronic Commerce") {
    $tablePrinting .= "<tr><td><center>&nbsp;&nbsp;Requirement 1: </td><td colspan='2'>&nbsp;&nbsp;Choose 7 modules to make up 28 MCs from the list of Programme Electives below. <br>&nbsp;&nbsp;3 of the 7 modules must be at level-4000</td></tr>";
    $tablePrinting .= "<tr><td><center>&nbsp;&nbsp;Requirement 2: </td><td colspan='2'>&nbsp;&nbsp;For " . $specialization . " Specialization - Compulsory Modules</td></tr>";
    $tablePrinting .= $programCompulsory;
    $tablePrinting .= "<tr><td><center>&nbsp;&nbsp;Requirement 3: </td><td colspan='2'>&nbsp;&nbsp;For " . $specialization . " Specialization - Choose at least 3 from from highlighted list and remaining on any module</td></tr>";
} else if ($course == "Electronic Commerce") {
    $tablePrinting .= "<tr><td><center>&nbsp;&nbsp;Requirement 1: </td><td colspan='2'>&nbsp;&nbsp;Students are required to choose 2 out of the 4 modules in this list:</td></tr>";
    $tablePrinting .= $list1;
    $tablePrinting .= "<tr><td><center>&nbsp;&nbsp;Requirement 2: </td><td colspan='2'>&nbsp;&nbsp;Students are required to choose 3 modules from this list of School of Business modules:</td></tr>";
    $tablePrinting .= $list2;
    $tablePrinting .= "<tr><td><center>&nbsp;&nbsp;Requirement 3: </td><td colspan='2'>&nbsp;&nbsp;Choose either Option 1 or 2:</td></tr>";
    $tablePrinting .= "<tr><td><b><center>&nbsp;&nbsp;Option 1: </center></b></td><td colspan='2'>&nbsp;&nbsp;Choose 7 modules to make up 28 MCs from the list of Programme Electives below. <br>&nbsp;&nbsp;3 of the 7 modules must be at level-4000</b></td></tr>";
    $tablePrinting .= "<tr><td><b><center>&nbsp;&nbsp;Option 2: </center></b></td><td colspan='2'>&nbsp;&nbsp;Choose CP4101 and 4 modules to make up 28 MCs from the list of Programme Electives below.</b></td></tr>";
} else {
    $tablePrinting .= "<tr><td><b><center>&nbsp;&nbsp;Option 1: </center></b></td><td colspan='2'>&nbsp;&nbsp;Choose 7 modules to make up 28 MCs from the list of Programme Electives below. <br>&nbsp;&nbsp;3 of the 7 modules must be at level-4000</td></tr>";
    $tablePrinting .= "<tr><td><b><center>&nbsp;&nbsp;Option 2: </center></b></td><td colspan='2'>&nbsp;&nbsp;Choose CP4101 and 4 modules to make up 28 MCs from the list of Programme Electives below.</td></tr>";
}

$tablePrinting .= $programElectives;
$tablePrinting .= $programElectivesNon;
if ($course == "Electronic Commerce") {
    $totalCreditNow += 48;
} else {
    $totalCreditNow += 28;
}
$tablePrinting .= "<tr><th colspan='3'><font size='5'>&nbsp;&nbsp;Programme Internship</font></th></tr>";
$tablePrinting .= $programInternship;
$tablePrinting .= "<tr><th colspan='3'><font size='5'>&nbsp;&nbsp;Unrestricted Electives (20 MCs)</font></th></tr>";
$tablePrinting .= "<tr><td colspan='3' align='center'>5 Modules from outside of home faculty</td></tr>";
$totalCreditNow += 20;
$tablePrinting .= "<tr><td colspan='2' align='right'>Total&nbsp;&nbsp;<td align='center'>" . $totalCreditNow . "</td></tr>";

if ($_GET['plan'] == false) {
    $tablePrinting .= "<tr><td colspan='3'><button type='submit' class='btn btn-primary btn-xl wow tada col-lg-4 col-md-4 col-md-offset-4'>"
            . "<span class='glyphicon glyphicon-hand-up' aria-hidden='true'></span> Select current curriculum</button></td></tr></table><br>";
}

echo $tablePrinting;
echo "</div>";
echo "</div>";
$conn->close();
?>