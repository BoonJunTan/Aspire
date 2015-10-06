<?php


session_start();

echo "Test <br>";

$_SESSION['test'] = $_POST;
$_SESSION['test2'] = $_GET;

print_r($_SESSION['test']) . "LAME";
print_r($_SESSION['test2']);

?>