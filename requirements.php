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
        $url = parse_url(getenv("mysql://b0461b17726fba:0b54e729@us-cdbr-iron-east-02.cleardb.net/heroku_aa20cd51843572e?reconnect=true"));
        
        print_r($url);
        
        $server = $url["us-cdbr-iron-east-02.cleardb.net"];
        $username = $url["b0461b17726fba"];
        $password = $url["0b54e729"];
        echo $server;
        echo "TEST" . $url["path"];
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

        echo $result;

        print_r($result);

        echo "Test";

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