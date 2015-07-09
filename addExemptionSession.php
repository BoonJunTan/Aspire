<?php

//get the q parameter from URL
session_start();

$q = strtoupper($_GET["q"]);

array_push($_SESSION['modulesExempted'], $q);
?>