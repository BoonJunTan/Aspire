<?php
session_start();

if (!empty($_SESSION['modulesExempted'])) {
    echo "List of Exemption:<br>";
    echo "<table border = '1' width = '100%'>";
    echo "<tr><td>Module Code</td><td>Module Name</td><td>Module Credits</td></tr >";

    $url = parse_url(getenv("CLEARDB_DATABASE_URL"));

    $server = $url["host"];
    $username = $url["user"];
    $password = $url["pass"];
    $db = substr($url["path"], 1);

    $conn = new mysqli($server, $username, $password, $db);

    $sql = "SELECT DISTINCT test.modules.module_id AS 'Module Code', test.modules.module_name AS 'Modules Name', test.modules.module_credit AS 'Modules Credit'
        FROM test.curriculum, test.requirements, test.modules, test.module_types
        WHERE test.curriculum.requirement_id = test.requirements.requirement_id
        AND test.curriculum.module_id = test.modules.module_id
        AND test.curriculum.type_id = test.module_types.type_id";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if (in_array($row["Module Code"], $_SESSION['modulesExempted'])) {
                echo "<tr><td>" . $row["Module Code"] . "</td><td>" . $row["Modules Name"] . "</td><td align=center>" . $row["Modules Credit"] . "</td>";
            }
        }
    }
    echo "</table>";
}
?>