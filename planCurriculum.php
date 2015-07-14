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
    </head>
    <body ng-controller="MainCtrl">
        Still in development phase. -> Planning to aim 2014/15 and 2015/16 batch only<br><br>
        <div>
            <button mypopover data-placement="right" class='btn btn-primary btn-xl wow tada col-lg-4 col-md-4 '><span class='glyphicon glyphicon-hand-up' aria-hidden='true'></span> Click to see Updated Curriculum </button><br>
        </div><br><br>
        
        <b>Step 1: </b>Exemption -> Additional Modules<br>
        Please indicate if you have any additional modules to be exempted from. <br>
        <b>* Only relevant modules to your curriculum list will be shown in the exempted list</b><br>
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
            <button data-placement="right" class='btn btn-primary btn-xl wow tada col-lg-4 col-md-4 '><span class='glyphicon glyphicon-hand-up' aria-hidden='true'></span> Update List </button><br>
        </form>
            <br><br>
            
        <b>Step 3: </b><br>
        <b>* SOC requires students to take at least 16 MCs per semester except for IS4010 Industry Internship Programme</b><br><br>
        <br><br>
        <button id="add_new" data-placement="right" class='btn btn-primary btn-xl wow tada col-lg-4 col-md-4 '><span class='glyphicon glyphicon-hand-up' aria-hidden='true'></span> Add Module </button><br>
        
        <br><br>
        <table border="1" width="100%">
            <tr><td colspan="4" align="center"><b>Year 1</b></td></tr>
            <tr>
                <td colspan="2" align="center">Semester 1</td>
                <td colspan="2" align="center">Semester 2</td>
            </tr>
            <tr>
                <td align="center">No.</td>
                <td align="center">Module Name</td>
                <td align="center">No.</td>
                <td align="center">Module Name</td>
            </tr>
        </table>
        <br>
        <div class="entry-form">
		<form name="userinfo" id="userinfo"> 
		<table width="100%" border="0" cellpadding="4" cellspacing="0">
			<tr>
				<td colspan="2" align="right"><a href="#" id="close">Close</a></td>
			</tr>
			<tr>
				<td>Input Year</td>
				<td><input type="text" name="fname"></td>
			</tr>
			<tr>
				<td>Input Semester (1-2)</td>
				<td><input type="text" name="lname"></td>
			</tr>
			<tr>
				<td>Enter Module</td>
				<td><input type="text" name="email"></td>
			</tr>
			<tr>
				<td align="right"></td>
				<td><input type="button" value="Save" id="save"><input type="button" value="cancel" id="cancel"></td>
			</tr>
		</table>
		</form>
	</div>
        <br>
        1. Allow user to press a button to add modules<br>
        2. Allow user to press a button to add semester or year
        <br><br>
        <br><br>
        
        Given the choice to: <br>
        -------> 1: Add Semester<br>
        -------> 2: Search and Add Module<br>
        -------> 3: Insert/Edit/Remove Grades<br>
        <br>
        Disclaimer Notice: Whatever plan you have now is subjected to changes in the future. Enjoy yourself.<br>
        <br>
        Things to check: <br>
        1. Pre-requisite/conclusion when entering new module information<br>
        2. Auto Calculate GPA/CAP<br>
        <br>
        
        
        
    </body>
</html>