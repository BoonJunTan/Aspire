<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
    "http://www.w3.org/TR/html4/strict.dtd">

<html>
    <head>
        <meta charset="UTF-8">
        <title>NUSPlan - Plan to be efficient ;)</title> 
    </head>
    <script>
        function showResult(str) {
            if (str.length == 0) {
                document.getElementById("livesearch").innerHTML = "";
                document.getElementById("livesearch").style.border = "0px";
                return;
            }
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else {  // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("livesearch").innerHTML = xmlhttp.responseText;
                    document.getElementById("livesearch").style.border = "1px solid #A5ACB2";
                }
            }
            xmlhttp.open("GET", "liveSearch.php?q=" + str, true);
            xmlhttp.send();
        }
    </script>
    <body>
        <form>
            <input placeholder="Please key in module code or name ;)" type="text" size="35" onkeyup="showResult(this.value)">
            <div id="livesearch"></div>
        </form>
        <?php
        /*
        $finalpath = getcwd() . "/assets/json/201415moduleList.json";

        $string = file_get_contents($finalpath);

        $json_a = json_decode($string, true);

        //print_r($json_a);
        // To verify that there is something -> var_dump($json_a);

        echo "<table border=1>";
        echo "<tr><td>Module Code</td>";
        echo "<td>Module Title</td></tr>";

        $listOfItem = array("ModuleCode", "ModuleTitle", "Semesters");

        for ($i = 0; $i < count($json_a); $i++) {
            echo "<tr>";
            for ($x = 0; $x < count($json_a[$i]) - 1; $x++) {
                echo "<td>";
                if ($x == 0) {
                    echo "<a href='moduleDetailInfoView.php/" . $json_a[$i][$listOfItem[$x]] . "'>" . $json_a[$i][$listOfItem[$x]] . "</a>";
                } else {
                    echo $json_a[$i][$listOfItem[$x]];
                }
                echo "</td>";
            }
            echo "</tr>";
        }

        echo "</table>";*/
        ?>
    </body>
</html>