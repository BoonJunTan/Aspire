<?php

session_start();


$data = $_GET['params'];

$_SESSION['test'] = $data;

echo $_SESSION['test'];

?>