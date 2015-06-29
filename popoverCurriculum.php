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

echo $course . " - Batch " . $cohort . " - " . $specialization . "<br><br>";

$tablePrinting = "<table width='100%' border=1 cellspacing=5 cellpadding=5><tr><td>Module Code</td><td>Module Name</td><td align>Module Credits</td></tr>";
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
/*
$sql = "SELECT test.modules.module_id AS 'Module Code', test.modules.module_name AS 'Modules Name', test.modules.module_credit AS 'Modules Credit'
            FROM test.curriculum, test.requirements, test.modules, test.module_types
            WHERE test.requirements.cohort = '" . $cohort . "' 
                    AND test.requirements.major = '" . $course . "'
                    AND test.curriculum.type_id = '5'
                    AND test.curriculum.requirement_id = test.requirements.requirement_id
                    AND test.curriculum.module_id = test.modules.module_id
                    AND test.curriculum.type_id = test.module_types.type_id";
*/

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $gemList .= "<tr><td>" . $row["Module Code"] . "</td><td>" . $row["Modules Name"] . "</td><td align=center>" . $row["Modules Credit"] . "</td>";
        $totalCreditNow += $row["Modules Credit"];
    }
}

if ($exemption == "yes") {
    $tablePrinting .= "<tr><th colspan='3'>University Level Requirements (ULR) (12 MCs)</th></tr>";
    $tablePrinting .= $gemList;
    $tablePrinting .= "<tr><td colspan='3' align='center'> Remaining ULR - 8 MCs<br>";
    $tablePrinting .= "1 Singapore Studies & 1 Breadth";
    $totalCreditNow += 8;
} else {
    $tablePrinting .= "<tr><th colspan='3'>University Level Requirements (ULR) (20 MCs)</th></tr>";
    $tablePrinting .= $gemList;
    $tablePrinting .= "<tr><td colspan='3' align='center'> Remaining ULR - " . (20 - count($gemList) * 4) . " MCs<br>";
    $tablePrinting .= (2 - count($gemList)) . " General Education, 1 Singapore Studies & 2 Breadth";
    $totalCreditNow += (20 - count($gemList) * 4);
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
/*
$sql = "SELECT test.modules.module_id AS 'Module Code', test.modules.module_name AS 'Modules Name', test.modules.module_credit AS 'Modules Credit'
            FROM test.curriculum, test.requirements, test.modules, test.module_types
            WHERE test.requirements.cohort = '" . $cohort . "' 
                    AND test.requirements.major = '" . $course . "'
                    AND test.curriculum.type_id = '1'
                    AND test.curriculum.requirement_id = test.requirements.requirement_id
                    AND test.curriculum.module_id = test.modules.module_id
                    AND test.curriculum.type_id = test.module_types.type_id";
*/

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row['Module Code'] == "MA1521" || $row['Module Code'] == "MA1312") {
            $ma1521 = $result->fetch_assoc();
            $programCore .= "<tr><td>" . $row["Module Code"] . "<br>OR<br>" . $ma1521["Module Code"] . "</td><td>" . $row["Modules Name"] . "<br>OR<br>" . $ma1521["Modules Name"] . "</td><td align=center>" . $row["Modules Credit"] . "</td></tr>";
        } else if ($row['Module Code'] == "IS4010") {
            $programInternship .= "<tr><td>" . $row["Module Code"] . "</td><td>" . $row["Modules Name"] . "</td><td align=center>" . $row["Modules Credit"] . "</td></tr>";
        } else {
            $programCore .= "<tr><td>" . $row["Module Code"] . "</td><td>" . $row["Modules Name"] . "</td><td align=center>" . $row["Modules Credit"] . "</td></tr>";
        }
        $totalCreditNow += $row["Modules Credit"];
    }
}

$tablePrinting .= "<tr><th colspan='3'>Programme Requirements - Core Modules (80 MCs)</th></tr>";
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
/*
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
*/

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row["Specialization"] == $specialization) {
            if ($specialization == 'Services Science, Management and Engineering' && ($row["Module Code"] == 'IS3220' || $row["Module Code"] == 'IS4224')) {
                $programCompulsory .= "<tr><td><b>" . $row["Module Code"] . "</b></td><td><b>" . $row["Modules Name"] . "</b></td><td align=center><b>" . $row["Modules Credit"] . "</b></td>";
            } else {
                $programElectives .= "<tr><td><b>" . $row["Module Code"] . "</b></td><td><b>" . $row["Modules Name"] . "</b></td><td align=center><b>" . $row["Modules Credit"] . "</b></td>";
            }
        } else {
            $programElectivesNon .= "<tr><td>" . $row["Module Code"] . "</td><td>" . $row["Modules Name"] . "</td><td align=center>" . $row["Modules Credit"] . "</td>";
        }
    }
}

// BUG -> 6 and 7 out of 8 LOGIC
$tablePrinting .= "<tr><th colspan='3'>Programme Requirements - Core Electives (28 MCs)</th></tr>";

if ($specialization == "Information Security") {
    $tablePrinting .= "<tr><td>Requirement 1: </td><td colspan='2'>Choose 7 modules to make up 28 MCs from the list of Programme Electives below. <br>3 of the 7 modules must be at level-4000</td></tr>";
    $tablePrinting .= "<tr><td>Requirement 2: </td><td colspan='2'>For " . $specialization . " Specialization - Choose at least 6 Modules from highlighted list and remaining on any module</td></tr>";
} else if ($specialization == "Services Science, Management and Engineering") {
    $tablePrinting .= "<tr><td>Requirement 1: </td><td colspan='2'>Choose 7 modules to make up 28 MCs from the list of Programme Electives below. <br>3 of the 7 modules must be at level-4000</td></tr>";
    $tablePrinting .= "<tr><td>Requirement 2: </td><td colspan='2'>For " . $specialization . " Specialization - Compulsory Modules</td></tr>";
    $tablePrinting .= $programCompulsory;
    $tablePrinting .= "<tr><td>Requirement 3: </td><td colspan='2'>For " . $specialization . " Specialization - Choose at least 4 from from highlighted list and remaining on any module</td></tr>";
} else {
    $tablePrinting .= "<tr><td><b>Option 1: </b></td><td colspan='2'>Choose 7 modules to make up 28 MCs from the list of Programme Electives below. <br>3 of the 7 modules must be at level-4000</td></tr>";
    $tablePrinting .= "<tr><td><b>Option 2: </b></td><td colspan='2'>Choose CP4101 and 4 modules to make up 28 MCs from the list of Programme Electives below.</td></tr>";
}

$tablePrinting .= $programElectives;
$tablePrinting .= $programElectivesNon;
$totalCreditNow += 28;
$tablePrinting .= "<tr><th colspan='3'>Programme Internship</th></tr>";
$tablePrinting .= $programInternship;
if ($exemption == "yes") {
    $tablePrinting .= "<tr><th colspan='3'>Unrestricted Electives (8 MCs)</th></tr>";
    $tablePrinting .= "<tr><td colspan='3' align='center'>2 Modules from outside of home faculty</td></tr>";
    $totalCreditNow += 8;
} else {
    $tablePrinting .= "<tr><th colspan='3'>Unrestricted Electives (20 MCs)</th></tr>";
    $tablePrinting .= "<tr><td colspan='3' align='center'>5 Modules from outside of home faculty</td></tr>";
    $totalCreditNow += 20;
}
$tablePrinting .= "<tr><td colspan='2' align='right'>Total Remaining <td align='center'>" . $totalCreditNow . "</td></tr>";

echo $tablePrinting;

$conn->close();
?>