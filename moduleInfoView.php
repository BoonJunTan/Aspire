<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>NUSPlan - Search for Module</title>
    </head>
    <body>
        <?php
        session_start();
        $_SESSION['planCurriculum'] = 'False';
        $page_content = 'moduleInfo.php';
        $content = "";
        $header = 'Search for Module';
        $getActive = "Search Module";
        include('master.php');
        ?>
    </body>
</html>