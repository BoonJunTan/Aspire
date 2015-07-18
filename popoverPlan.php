<?php

session_start();
$finalpath1 = getcwd() . "/assets/json/201415moduleInformation.json";
$string1 = file_get_contents($finalpath1);
$json_a = json_decode($string1, true);

$minYear = 0;
$maxYear = 0;

$totalGrade = 0;
$totalMC = 0;

for ($i = 1; $i <= 5; $i++) {
    for ($a = 1; $a <= 2; $a++) {
        ${'year' . $i . 'sem' . $a} = [];
        ${'year' . $i . 'sem' . $a . 'grade'} = 0;
        ${'year' . $i . 'sem' . $a . 'totalMC'} = 0;
    }
}

for ($i = 0; $i < count($_SESSION['test']); $i++) {

    // Calculate min/max year
    if ($_SESSION['test'][$i]['year'] <= 1) {
        $minYear = 1;
    }

    if ($_SESSION['test'][$i]['year'] >= $maxYear) {
        $maxYear = $_SESSION['test'][$i]['year'];
    }

    // Make all modules into specific year and sem
    for ($x = 1; $x <= 5; $x++) {
        for ($a = 1; $a <= 2; $a++) {
            if ($_SESSION['test'][$i]['year'] == $x && $_SESSION['test'][$i]['semester'] == $a) {
                array_push(${'year' . $x . 'sem' . $a}, $_SESSION['test'][$i]);
            }
        }
    }
}

echo "<table width='100%' border='1'>";

for ($i = 1; $i <= $maxYear; $i++) {
    echo "<tr><th colspan='3'><center><font size='5'>Year " . $i . "</font></center></th></tr>";
    for ($a = 1; $a <= 2; $a++) {
        echo "<tr><th colspan='3'><center><font size='3'>Semester " . $a . "</font></center></th></tr>";
        echo "<tr><td width='15%'><center>No</center></td><td width='60%'>Module</td><td width='25%'><center>Estimated GPA</center></td></tr>";
        if (count(${'year' . $i . 'sem' . $a}) > 0) {
            for ($x = 1; $x <= count(${'year' . $i . 'sem' . $a}); $x++) {
                for ($b = 0; $b < count($json_a); $b++) {
                    if ($json_a[$b]['ModuleCode'] == ${'year' . $i . 'sem' . $a}[$x - 1]['moduleCode']) {
                        echo "<tr>";
                        echo "<td><center>" . $x . "</center></td>";
                        echo "<td>" . ${'year' . $i . 'sem' . $a}[$x - 1]['moduleCode'] . " - " . $json_a[$b]['ModuleTitle'] . " </td>";
                        echo "<td><center>" . ${'year' . $i . 'sem' . $a}[$x - 1]['gpa'] . "</center></td>";
                        echo "</tr>";
                        ${'year' . $i . 'sem' . $a . 'grade'} += substr(${'year' . $i . 'sem' . $a}[$x - 1]['gpa'], strpos(${'year' . $i . 'sem' . $a}[$x - 1]['gpa'], ":") + 1) * $json_a[$b]['ModuleCredit'];
                        ${'year' . $i . 'sem' . $a . 'totalMC'} += $json_a[$b]['ModuleCredit'];
                        $totalGrade += substr(${'year' . $i . 'sem' . $a}[$x - 1]['gpa'], strpos(${'year' . $i . 'sem' . $a}[$x - 1]['gpa'], ":") + 1) * $json_a[$b]['ModuleCredit'];
                        $totalMC += $json_a[$b]['ModuleCredit'];
                        break;
                    }
                }
            }
            echo "<tr><td colspan='2' align='right'><font size='3'>Total GPA&nbsp;&nbsp;</font></td><td><center>" . round((${'year' . $i . 'sem' . $a . 'grade'} / ${'year' . $i . 'sem' . $a . 'totalMC'}), 2) . "</center></td></tr>";
        } else {
            echo "<tr><td colspan='3'><center>No Modules Planned Yet</center></td></tr>";
        }
    }
}
echo "<tr><td colspan='2' align='right'><font size='3'>Total CAP of&nbsp;&nbsp;</td><td><center>" . round(($totalGrade / $totalMC) , 2) . "</font></center></td></tr>";
echo "</table>";
?>