<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        session_start();
        $_SESSION['planCurriculum'] = 'False';
        $page_content = 'moduleInfo.php';
        $content = "<br><b>Please kindly wait for a little while if nothing pop out ;)</b><br>";
        $header = 'Search for Module';
        $getActive = "Search Module";
        include('master.php');
        ?>
    </body>
</html>