<?php
session_start();

$_SESSION["cohort"] = $_POST['cohort'];
$_SESSION["course"] = $_POST['course'];
$_SESSION["specialization"] = $_POST['specialization'];
?>
<head>
    <meta http-equiv="refresh" content="0; url=planCurriculumView.php" />
</head>