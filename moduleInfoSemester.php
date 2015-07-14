<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
    "http://www.w3.org/TR/html4/strict.dtd">

<html>
    <head>
        <meta charset="UTF-8">
        <title>NUSPlan - Plan to be efficient ;)</title> 
    </head>
    <script>
        function showResult2(str) {
            if (str.length == 0) {
                document.getElementById("liveupdate").innerHTML = "";
                document.getElementById("liveupdate").style.border = "0px";
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
                    document.getElementById("liveupdate").innerHTML = xmlhttp.responseText;
                    document.getElementById("liveupdate").style.border = "1px solid #A5ACB2";
                }
            }
            xmlhttp.open("GET", "liveSearch.php?q=" + str + "&semester=True", true);
            xmlhttp.send();
        }
        
        function addToCurriculum(str) {
            alert(str);
        }
    </script>
    <body>
        <form>
            <input placeholder="Please key in module code or name ;)" type="text" size="35" onkeyup="showResult2(this.value)">
            <div id="liveupdate"></div>
        </form>
    </body>
</html>