<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>NUSPlan - Module Information for <?php echo $_GET["q"]; ?></title>
    </head>
    <body>
        <?php
        $moduleCode = $_GET["q"];
        $page_content = "moduleDetailInfo.php";
        $content = "";
        $header = 'Searching for Module - ' . $moduleCode;
        $getActive = "Search for Module";
        include('master.php');
        ?>
    </body>
</html>