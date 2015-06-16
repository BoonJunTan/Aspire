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
        /*
          $page_content = "";
          $content = "";
          $header = '160 MCs Requirement';
          $getActive = "160 MCs Requirement";
          include('master.php');
         */
        $url = parse_url(getenv("CLEARDB_DATABASE_URL"));

        $server = $url["host"];
        $username = $url["user"];
        $password = $url["pass"];
        $db = substr($url["path"], 1);

        $conn = new mysqli($server, $username, $password, $db);

        // Check connection
        /*
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } else {
            echo "Connected successfully";
        }
        */
        
        echo "Information System - Batch 15/16 <br>";
        echo "Core Modules";
        
        $sql = "SELECT test.modules.module_code AS 'Module Code', test.modules.module_name AS 'Modules Name', test.modules.module_credit AS 'Modules Credit'
            FROM test.curriculum, test.requirements, test.modules, test.module_types 
            WHERE test.requirements.cohort = '15/16' 
                AND test.requirements.major = 'IS'
                AND test.curriculum.requirement_id = test.requirements.requirement_id
                AND test.curriculum.module_id = test.modules.module_id
                AND test.curriculum.type_id = test.module_types.type_id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "Module Codes: " . $row["Modules Code"] . "Modules Name: " . $row["Modules Name"] . " - Module Credits: " . $row["Modules Credit"] . "<br>";
            }
        } else {
            echo "0 results";
        }

        $conn->close();
        ?>
    </body>
</html>