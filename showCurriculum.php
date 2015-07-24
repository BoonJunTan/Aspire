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


$tablePrinting = "<table width='100%' border=1 cellspacing=5 cellpadding=5><tr><td>&nbsp;&nbsp;Module Code</td><td>&nbsp;&nbsp;Module Name</td><td align><center>Module Credits</center></td></tr>";
$totalCreditNow = 0;

// Finding GEM
$gemList;

// For ClearDB
/*
  $sql = "SELECT modules.module_id AS 'Module Code', modules.module_name AS 'Modules Name', modules.module_credit AS 'Modules Credit'
  FROM curriculum, requirements, modules, module_types
  WHERE requirements.cohort = '" . $cohort . "'
  AND requirements.major = '" . $course . "'
  AND curriculum.type_id = '5'
  AND curriculum.requirement_id = requirements.requirement_id
  AND curriculum.module_id = modules.module_id
  AND curriculum.type_id = module_types.type_id";
 */

// For Localhost MySQL
$sql = "SELECT test.modules.module_id AS 'Module Code', test.modules.module_name AS 'Modules Name', test.modules.module_credit AS 'Modules Credit'
            FROM test.curriculum, test.requirements, test.modules, test.module_types
            WHERE test.requirements.cohort = '" . $cohort . "' 
                    AND test.requirements.major = '" . $course . "'
                    AND test.curriculum.type_id = '5'
                    AND test.curriculum.requirement_id = test.requirements.requirement_id
                    AND test.curriculum.module_id = test.modules.module_id
                    AND test.curriculum.type_id = test.module_types.type_id";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $gemList .= "<tr><td>&nbsp;&nbsp;" . $row["Module Code"] . "</td><td>&nbsp;&nbsp;" . $row["Modules Name"] . "</td><td align=center>" . $row["Modules Credit"] . "</td>";
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
/*
  $sql = "SELECT modules.module_id AS 'Module Code', modules.module_name AS 'Modules Name', modules.module_credit AS 'Modules Credit'
  FROM curriculum, requirements, modules, module_types
  WHERE requirements.cohort = '" . $cohort . "'
  AND requirements.major = '" . $course . "'
  AND curriculum.type_id = '1'
  AND curriculum.requirement_id = requirements.requirement_id
  AND curriculum.module_id = modules.module_id
  AND curriculum.type_id = module_types.type_id";
 */

// For localhost
$sql = "SELECT test.modules.module_id AS 'Module Code', test.modules.module_name AS 'Modules Name', test.modules.module_credit AS 'Modules Credit'
            FROM test.curriculum, test.requirements, test.modules, test.module_types
            WHERE test.requirements.cohort = '" . $cohort . "' 
                    AND test.requirements.major = '" . $course . "'
                    AND test.curriculum.type_id = '1'
                    AND test.curriculum.requirement_id = test.requirements.requirement_id
                    AND test.curriculum.module_id = test.modules.module_id
                    AND test.curriculum.type_id = test.module_types.type_id";

$result = $conn->query($sql);

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

$tablePrinting .= "<tr><th colspan='3'><font size='5'>&nbsp;&nbsp;Programme Requirements - Core Modules (80 MCs)</font></th></tr>";
$tablePrinting .= $programCore;

// Finding Program Electives
$programElectives;

// For ClearDB
/*
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
 */

// For Localhost
$sql = "SELECT test.modules.module_id AS 'Module Code', test.modules.module_name AS 'Modules Name', test.modules.module_credit AS 'Modules Credit', test.specialization.specialization_name AS 'Specialization'
            FROM test.curriculum, test.requirements, test.modules, test.module_types, test.specialization
            WHERE test.requirements.cohort = '" . $cohort . "' 
                    AND test.requirements.major = '" . $course . "'
                    AND test.curriculum.type_id = '6'
                    AND test.curriculum.requirement_id = test.requirements.requirement_id
                    AND test.curriculum.module_id = test.modules.module_id
                    AND test.curriculum.type_id = test.module_types.type_id
                    AND test.curriculum.specialization_id = test.specialization.specialization_id
                    ORDER BY test.modules.module_id";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row["Specialization"] == $specialization) {
            // Need take note now is Information Security (Information System) and Information Security (Computer Science)
            if ($specialization == 'Services Science, Management and Engineering' && ($row["Module Code"] == 'IS3220' || $row["Module Code"] == 'IS4224')) {
                $programCompulsory .= "<tr><td><font size='3'><b>&nbsp;&nbsp;" . $row["Module Code"] . "</b></td><td><b>&nbsp;&nbsp;" . $row["Modules Name"] . "</b></td><td align=center><b>" . $row["Modules Credit"] . "</b></font></td>";
            } else {
                $programElectives .= "<tr><td><font size='3'><b>&nbsp;&nbsp;" . $row["Module Code"] . "</b></td><td><b>&nbsp;&nbsp;" . $row["Modules Name"] . "</b></td><td align=center><b>" . $row["Modules Credit"] . "</b></font></td>";
            }
        } else {
            $programElectivesNon .= "<tr><td>&nbsp;&nbsp;" . $row["Module Code"] . "</td><td>&nbsp;&nbsp;" . $row["Modules Name"] . "</td><td align=center>" . $row["Modules Credit"] . "</td>";
        }
    }
}

// BUG -> 6 and 7 out of 8 LOGIC
$tablePrinting .= "<tr><th colspan='3'><font size='5'>&nbsp;&nbsp;Programme Requirements - Core Electives (28 MCs)</font></th></tr>";

if ($specialization == "Information Security") {
    $tablePrinting .= "<tr><td>&nbsp;&nbsp;Requirement 1: </td><td colspan='2'>&nbsp;&nbsp;Choose 7 modules to make up 28 MCs from the list of Programme Electives below. <br>&nbsp;&nbsp;3 of the 7 modules must be at level-4000</td></tr>";
    $tablePrinting .= "<tr><td>&nbsp;&nbsp;Requirement 2: </td><td colspan='2'>&nbsp;&nbsp;For " . $specialization . " Specialization - Choose at least 6 Modules from highlighted list and remaining on any module</td></tr>";
} else if ($specialization == "Services Science, Management and Engineering") {
    $tablePrinting .= "<tr><td>&nbsp;&nbsp;Requirement 1: </td><td colspan='2'>&nbsp;&nbsp;Choose 7 modules to make up 28 MCs from the list of Programme Electives below. <br>&nbsp;&nbsp;3 of the 7 modules must be at level-4000</td></tr>";
    $tablePrinting .= "<tr><td>&nbsp;&nbsp;Requirement 2: </td><td colspan='2'>&nbsp;&nbsp;For " . $specialization . " Specialization - Compulsory Modules</td></tr>";
    $tablePrinting .= $programCompulsory;
    $tablePrinting .= "<tr><td>&nbsp;&nbsp;Requirement 3: </td><td colspan='2'>&nbsp;&nbsp;For " . $specialization . " Specialization - Choose at least 4 from from highlighted list and remaining on any module</td></tr>";
} else {
    $tablePrinting .= "<tr><td><b>&nbsp;&nbsp;Option 1: </b></td><td colspan='2'>&nbsp;&nbsp;Choose 7 modules to make up 28 MCs from the list of Programme Electives below. <br>&nbsp;&nbsp;3 of the 7 modules must be at level-4000</td></tr>";
    $tablePrinting .= "<tr><td><b>&nbsp;&nbsp;Option 2: </b></td><td colspan='2'>&nbsp;&nbsp;Choose CP4101 and 4 modules to make up 28 MCs from the list of Programme Electives below.</td></tr>";
}

$tablePrinting .= $programElectives;
$tablePrinting .= $programElectivesNon;
$totalCreditNow += 28;
$tablePrinting .= "<tr><th colspan='3'><font size='5'>&nbsp;&nbsp;Programme Internship</font></th></tr>";
$tablePrinting .= $programInternship;
$tablePrinting .= "<tr><th colspan='3'><font size='5'>&nbsp;&nbsp;Unrestricted Electives (20 MCs)</font></th></tr>";
$tablePrinting .= "<tr><td colspan='3' align='center'>5 Modules from outside of home faculty</td></tr>";
$totalCreditNow += 20;
$tablePrinting .= "<tr><td colspan='2' align='right'>Total <td align='center'>" . $totalCreditNow . "</td></tr>";

if ($_GET['plan'] == false) {
    $tablePrinting .= "<tr><td colspan='3'><button type='submit' class='btn btn-primary btn-xl wow tada col-lg-4 col-md-4 col-md-offset-4'>"
            . "<span class='glyphicon glyphicon-hand-up' aria-hidden='true'></span> Select current curriculum</button></td></tr></table><br>";
}

echo $tablePrinting;
echo "</div>";
echo "</div>";
$conn->close();
?>