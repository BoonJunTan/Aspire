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
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } else {
            echo "Connected successfully";
        }
        
        $sql = "SELECT * FROM requirements";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "id: " . $row["requirement_id"] . " - Cohort: " . $row["cohort"] . "<br>";
            }
        } else {
            echo "0 results";
        }

        $conn->close();
        ?>
    </body>
</html>