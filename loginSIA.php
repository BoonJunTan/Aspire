<?php


session_start();

echo "Test <br>";

print_r($_POST);

print_r($_GET);

$_SESSION['test'] = $_POST;
$_SESSION['test2'] = $_GET;

echo $_SESSION['test'] . "LAME";
echo $_SESSION['test2'];

?>