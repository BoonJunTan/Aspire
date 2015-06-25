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



echo $course . " - Batch " . $cohort . " - " . $specialization . "<br><br>";

// Just take note localhost need schema name, ClearDB don't need
/*
  $sql = "SELECT modules.module_id AS 'Module Code', modules.module_name AS 'Modules Name', modules.module_credit AS 'Modules Credit'
  FROM curriculum, requirements, modules, module_types
  WHERE requirements.cohort = '15/16'
  AND requirements.major = 'IS'
  AND curriculum.requirement_id = requirements.requirement_id
  AND curriculum.module_id = modules.module_id
  AND curriculum.type_id = module_types.type_id";
 */

$tablePrinting = "<table border=1 cellspacing=5 cellpadding=5><tr><td>Module Code</td><td>Module Name</td><td align>Module Credits</td></tr>";
$totalCreditNow = 0;

// Finding GEM
$gemList;

$sql = "SELECT test.modules.module_id AS 'Module Code', test.modules.module_name AS 'Modules Name', test.modules.module_credit AS 'Modules Credit'
            FROM test.curriculum, test.requirements, test.modules, test.module_types
            WHERE test.requirements.cohort = '" . $cohort . "' 
                    AND test.requirements.major = '" . $course ."'
                    AND test.curriculum.type_id = '5'
                    AND test.curriculum.requirement_id = test.requirements.requirement_id
                    AND test.curriculum.module_id = test.modules.module_id
                    AND test.curriculum.type_id = test.module_types.type_id";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $gemList .= "<tr><td>" . $row["Module Code"] . "</td><td>" . $row["Modules Name"] . "</td><td align=center>" . $row["Modules Credit"] . "</td>";
        $totalCreditNow += $row["Modules Credit"];
    }
}

$tablePrinting .= "<tr><th colspan='3'>University Level Requirements (ULR) (20 MCs)</th></tr>";
$tablePrinting .= $gemList;
$tablePrinting .= "<tr><td colspan='3' align='center'> Remaining ULR - " . (20 - count($gemList) * 4) . " MCs<br>";
$tablePrinting .= (2 - count($gemList)) . " General Education, 1 Singapore Studies & 2 Breadth";
$totalCreditNow += (20 - count($gemList) * 4);

// Finding Program Requirement - Core and Internship
$programCore;
$programInternship;

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

$sql = "SELECT test.modules.module_id AS 'Module Code', test.modules.module_name AS 'Modules Name', test.modules.module_credit AS 'Modules Credit'
            FROM test.curriculum, test.requirements, test.modules, test.module_types, test.specialization
            WHERE test.requirements.cohort = '" . $cohort . "' 
                    AND test.requirements.major = '" . $course . "'
                    AND test.curriculum.type_id = '6'
                    AND test.curriculum.requirement_id = test.requirements.requirement_id
                    AND test.curriculum.module_id = test.modules.module_id
                    AND test.curriculum.type_id = test.module_types.type_id
                    AND test.curriculum.specialization_id = test.specialization.specialization_id
                    AND test.specialization.specialization_name = '" . $specialization . "'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $programElectives .= "<tr><td>" . $row["Module Code"] . "</td><td>" . $row["Modules Name"] . "</td><td align=center>" . $row["Modules Credit"] . "</td>";
    }
}

// BUG -> 6 and 7 out of 8 LOGIC
$tablePrinting .= "<tr><th colspan='3'>Programme Requirements - Core Electives (28 MCs)</th></tr>";
$tablePrinting .= "<tr><td colspan='3' align='center'>Requirement: Choose 7 modules to make up 28 MCs from the list of Programme Electives below. <br>3 of the 7 modules must be at level-4000</td></tr>";
$tablePrinting .= "<tr><td colspan='3' align='center'>Option 1: Information Security Specialisation - Choose 7 of the 8 Modules listed (28MCs)</td></tr>";
$tablePrinting .= "<tr><td colspan='3' align='center'>Option 2: Information Security Specialisation - Choose 6 of the 8 Modules listed (24MCs)<br>And one from the list</td></tr>";

//$tablePrinting .= "<tr><td colspan='3'>Option 1:<br>Choose 7 modules to make up 28 MCs from the list of Programme Electives below. 3 of the 7 modules must be at level-4000.</td><tr>";
//$tablePrinting .= "<tr><td colspan='3' align='center'> asd</td></tr>";
$tablePrinting .= $programElectives;
$totalCreditNow += 28;
$tablePrinting .= "<tr><th colspan='3'>Programme Internship</th></tr>";
$tablePrinting .= $programInternship;
$tablePrinting .= "<tr><th colspan='3'>Unrestricted Electives (20 MCs)</th></tr>";
$tablePrinting .= "<tr><td colspan='3' align='center'>5 Modules from outside of home faculty</td></tr>";
$totalCreditNow += 20;
$tablePrinting .= "<tr><td colspan='2' align='right'>Total <td align='center'>" . $totalCreditNow . "</td></tr>";
$tablePrint .= "</table>";
echo $tablePrinting;

$conn->close();
?>