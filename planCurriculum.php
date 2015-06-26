<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
    "http://www.w3.org/TR/html4/strict.dtd">
    <?php
    session_start();
    ?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>NUSPlan - Plan to be efficient ;)</title>
        <script>
<?php
if ($_SESSION["cohort"] == "") {
    ?>
                alert("Please choose curriculum first");
                window.location.replace("curriculumView.php");
    <?php
}
?>
        </script>
    </head>
    <body>
        Still in development phase. -> Planning to aim 2014/15 and 2015/16 batch only<br><br>
    <table cellspacing="10">
        <tr>
            <?php
            echo "<td>Cohort selected: " . $_SESSION["cohort"] . "</td>";
            ?>
        </tr>
        <tr>
            <?php
            echo "<td>Course selected: " . $_SESSION["course"] . "</td>";
            ?>
        </tr>
        <tr>
            <?php
            echo "<td>Specialization selected: " . $_SESSION["specialization"] . "</td>";
            ?>
        </tr>
    </table>
    <?php
    $_GET["course"] = $_SESSION["course"];
    $_GET["cohort"] = $_SESSION["cohort"];
    $_GET["specialization"] = $_SESSION["specialization"];
    $_GET["plan"] = true;
    include('showCurriculum.php');
    ?>
    <br>
</body>
</html>