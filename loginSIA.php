<?php


session_start();

echo "Test <br>";

$_SESSION['test'] = $_POST;
$_SESSION['test2'] = $_GET;

echo $_SESSION['test'] . "LAME";
echo $_SESSION['test2'];

?>