<?php


session_start();

echo "Test <br>";

print_r($_POST);

print_r($_GET);

$_SESSION['test'] = $data;

echo $_SESSION['test'];

?>