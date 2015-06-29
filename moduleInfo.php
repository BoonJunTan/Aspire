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

        var modulesExemption = "";
        function additionalMod(str) {
            modulesExemption += " " + str;
            if (str.length == 0) {
                document.getElementById("liveUpdate").innerHTML = "";
                document.getElementById("liveUpdate").style.border = "0px";
                return;
            } else {
                document.getElementById("liveUpdate").innerHTML = modulesExemption;
                document.getElementById("liveUpdate").style.border = "0px";
                document.getElementById("livesearch").innerHTML = "";
                document.getElementById("livesearch").style.border = '0px';
            }
        }
    </script>
    <body>
        <?php if ($_SESSION['planCurriculum'] != 'True') { ?>
            <form>
                <input placeholder="Please key in module code or name ;)" type="text" size="35" onkeyup="showResult(this.value)">
                <div id="livesearch"></div>
            </form>
        <?php } else { ?>
            <div id="liveUpdate"></div><br>
            <input placeholder="Please key in module code or name ;)" type="text" size="35" onkeyup="showResult(this.value)">
            <div id="livesearch"></div>
        <?php } ?>
</body>
</html>