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
        
        // Just take note localhost need schema name, ClearDB don't need
        $sql = "SELECT modules.module_id AS 'Module Code', modules.module_name AS 'Modules Name', modules.module_credit AS 'Modules Credit'
            FROM curriculum, requirements, modules, module_types 
            WHERE requirements.cohort = '15/16' 
                    AND requirements.major = 'IS'
                    AND curriculum.requirement_id = requirements.requirement_id
                    AND curriculum.module_id = modules.module_id
                    AND curriculum.type_id = module_types.type_id";
        
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