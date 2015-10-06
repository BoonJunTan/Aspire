<?php


session_start();

echo "Test <br>";

echo ($_POST['username']) . ($_POST['mobno']);

$data = $_GET['params'];

$_SESSION['test'] = $data;

echo $_SESSION['test'];

?>