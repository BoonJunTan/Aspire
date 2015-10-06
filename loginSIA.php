<?php


session_start();

echo "Test <br>";

print_r($_POST['params']);

$data = $_GET['params'];

$_SESSION['test'] = $data;

echo $_SESSION['test'];

?>