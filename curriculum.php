<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>NUSPlan - Curriculum List</title>
        <script>
            cohort = ""
            course = ""
            function showItem(str, current) {
                if (current == "cohort") {
                    cohort = str;
                    if (str == "") {
                        document.getElementById("courseHint").innerHTML = "";
                        return;
                    }
                    if (window.XMLHttpRequest) {
                        // code for IE7+, Firefox, Chrome, Opera, Safari
                        xmlhttp = new XMLHttpRequest();
                    } else { // code for IE6, IE5
                        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    xmlhttp.onreadystatechange = function () {
                        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                            document.getElementById("courseHint").innerHTML = xmlhttp.responseText;
                        }
                    }
                } else if (current == "course") {
                    course = str;
                    if (str == "") {
                        document.getElementById("specializationHint").innerHTML = "";
                        return;
                    }
                    if (window.XMLHttpRequest) {
                        // code for IE7+, Firefox, Chrome, Opera, Safari
                        xmlhttp = new XMLHttpRequest();
                    } else { // code for IE6, IE5
                        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    xmlhttp.onreadystatechange = function () {
                        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                            document.getElementById("specializationHint").innerHTML = xmlhttp.responseText;
                        }
                    }

                    xmlhttp.open("GET", "showItem.php?q=" + str, true);
                }
                xmlhttp.open("GET", "showItem.php?q=" + str + "&item=" + current + "&cohort=" + cohort, true);
                xmlhttp.send();
            }
            function generateCurriculum(str) {
                if (str == "") {
                    document.getElementById("curriculumHint").innerHTML = "";
                    return;
                }
                if (window.XMLHttpRequest) {
                    // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                } else { // code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function () {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        document.getElementById("curriculumHint").innerHTML = xmlhttp.responseText;
                    }
                }
                xmlhttp.open("GET", "showCurriculum.php?cohort=" + cohort + "&course=" + course + "&specialization=" + str, true);
                xmlhttp.send();
            }
        </script>
    </head>
    <body>
        Still in development phase. -> Planning to aim 2014/15 and 2015/16 batch only<br><br>
        <table cellspacing="10">
            <tr>
                <td>
                    Please select Cohort: 
                </td>
                <td>
                    <select name="cohort" onchange="showItem(this.value, 'cohort')">
                        <option value = ""></option>
                        <option value = "14/15">2014/2015</option>
                        <option value = "15/16">2015/2016</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    Please select Course: 
                </td>
                <td>
                    <select id="courseHint" onchange="showItem(this.value, 'course')"></select>
                </td>
            </tr>
            <tr>
                <td>
                    Please select specialization:
                </td>
                <td>
                    <select id="specializationHint" onchange="generateCurriculum(this.value)"></div>
                </td>
            </tr>
        </table>
        <br>
        <div id="curriculumHint" onchange="generateCurriculum(this.value)"></div>
        
    </body>
</html>