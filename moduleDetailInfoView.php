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
        $parts = explode('/', $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
        $last = end($parts);
        $page_content = "";
        $content = "";
        $header = 'Searching for Module ' . $last;
        $getActive = "Search for Module";
        include('master.php');
        ?>
    </body>
</html>