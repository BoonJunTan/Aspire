<?php

//get the q parameter from URL
$q = $_GET["q"];
$current = $_GET["item"];
$cohort = $_GET["cohort"];

if ($current == 'cohort') {
    echo "<option value=''></option>";
    echo "<option value='Business Analytics'>Business Analytics</option selected='selected'>";
    echo "<option value='Computer Engineering'>Computer Engineering</option>";
    echo "<option value='Computer Science'>Computer Science</option>";

    if ($q == "14/15") {
        echo "<option value='Electronic Commerce'>Electronic Commerce</option>";
    } else if ($q == "15/16") {
        echo "<option value='Computer Biology'>Computer Biology</option>";
        echo "<option value='Information Security'>Information Security</option>";
    }
    echo "<option value='Information System'>Information System</option>";
    
} else if ($current == 'course') {
    echo "<select>";
    echo "<option value=''></option>";
    if ($q == "Information System") {
        echo "<option value='No Specialization'>No Specialization</option>";
        if ($cohort == "14/15") {
            echo "<option value='Information Security (Information Systems)'>Information Security</option>";
            echo "<option value='Services Science, Management and Engineering'>Services Science, Management and Engineering</option>";
        } else if ($cohort == "15/16") {
            echo "<option value='Electronic Commerce'>Electronic Commerce</option>";
        }
    } else if ($q == "Business Analytics" || $q == "Electronic Commerce") {
        echo "<option value='No Specialization'>No Specialization</option>";
    } 
    echo "</select>";
}
?>