<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
    "http://www.w3.org/TR/html4/strict.dtd">
    <?php
    session_start();
    ?>
<html ng-app="plunker">
    <head>
        <meta charset="UTF-8">
        <title>NUSPlan - Plan to be efficient ;)</title>
        <!-- Bootstrap Core CSS -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>

        <!-- Custom CSS -->
        <link href="assets/css/sb-admin.css" rel="stylesheet" type="text/css"/>

        <!-- jQuery -->
        <script src="assets/js/jquery.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="assets/js/bootstrap.min.js"></script>

        <script src="assets/js/angular.min.js"></script>

        <style type="text/css">
            .popover{
                max-width:600px;
            }
        </style>
        <script src='assets/js/app.js'></script>
        <script>
        <?php
        if ($_SESSION["cohort"] == "") {
            ?>
            alert("As you are new user, please choose curriculum first. Thank you ;)");
            window.location.replace("curriculumView.php");
            <?php
        }
        ?>
        </script>
        <script src='assets/js/script.js'></script>
        <script>
            function reloadFunction() {
                alert("Updated successfully");
                window.location.reload();
            }
        </script>
    </head>
    <body ng-controller="MainCtrl">
        Still in development phase. -> Planning to aim 2014/15 and 2015/16 batch only<br><br>
        <div>
            <button mypopover data-placement="right" class='btn btn-info btn-xl wow tada col-lg-4 col-md-4 '><span class='glyphicon glyphicon-hand-up' aria-hidden='true'></span> Click to see Updated Curriculum </button><br>
        </div>
        <br><br>
        <b>Step 1: </b>Exemption -> Additional Modules<br>
        Please indicate if you have any additional modules to be exempted from. <br>
        <b>* CP3200 is only applicable to Computer Science student.</b><br><br>
        <?php include("exemptedModules.php"); ?>
        <br>
        <?php $_SESSION['planCurriculum'] = 'True'; include('moduleInfo.php');  ?> <br><br>
            
        <form action="popoverCurriculum.php?" method="Get">
            <b>Step 2: </b>Exemption -> Poly (20MCs) <br>
            Please indicate if you are from poly? <br>
            <input type="radio" name="poly" value="yes" <?php if ($_SESSION["poly"] == "yes") { echo "checked"; } ?>>    Yes  
            <input type="radio" name="poly" value="no" <?php if ($_SESSION["poly"] == "") { echo "checked"; } ?>>    No
            <br><br>
            <button data-placement="right" class='btn btn-primary btn-xl wow tada col-lg-4 col-md-4 '><span class='glyphicon glyphicon-hand-up' aria-hidden='true'></span> Update List for Step 1 & 2</button>
        </form><br><br><br>
        
        <b>Step 3: </b><br>
        <b>* SOC requires students to take at least 16 MCs per semester except for IS4010 Industry Internship Programme</b><br><br>
        
        <button popoverplan data-placement="right" class='btn btn-info btn-xl wow tada col-lg-4 col-md-4 '><span class='glyphicon glyphicon-hand-up' aria-hidden='true'></span> Click to see Planned Curriculum </button><br>
        <br><br>
        <?php
            include('planTable.php');
        ?>
        <br><br>
        * Click onto me when you are done editing<br>
        <button onclick="reloadFunction()" data-placement="right" class='btn btn-primary btn-xl wow tada col-lg-4 col-md-4 '><span class='glyphicon glyphicon-hand-up' aria-hidden='true'></span> Update Curriculum and Plan</button><br>
        <br><br>
        <?php print_r($_SESSION['totalModuleTaken']); ?>
    </body>
</html>