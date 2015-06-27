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
    </head>
    <body ng-controller="MainCtrl">
        Still in development phase. -> Planning to aim 2014/15 and 2015/16 batch only<br><br>
        <div>
            <button mypopover data-placement="right" class='btn btn-default btn-xl wow tada col-lg-4 col-md-4 '><span class='glyphicon glyphicon-hand-up' aria-hidden='true'></span> Click to see Curriculum List </button><br>
        </div><br><br>
        Step 1: Exemption -> Poly (20MCs) <br>
        Please indicate if you are from poly? <br>
        <br>
        Step 2: Exemption -> Additional Modules<br>
        Please indicate if you have any additional modules to be exempted from. <br>
        <br>
        Step 3: Given the choice to: <br>
        -------> 1: Add Semester<br>
        -------> 2: Search and Add Module<br>
        -------> 3: Insert/Edit/Remove Grades<br>
        <br>
        Disclaimer Notice: Whatever plan you have now is subjected to changes in the future. Enjoy yourself.<br>
        <br>
        Things to check: <br>
        1. Pre-requisite/conclusion when entering new module information<br>
        2. Auto Calculate GPA/CAP<br>
    </body>
</html>