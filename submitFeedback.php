<head>
    <meta http-equiv="refresh" content="0; url=index.php" />
</head>

<?php
$name = $_POST['name'];
$email = $_POST['email'];
$subject = $_POST['subject'];
$message = $_POST['message'];
date_default_timezone_set( 'Asia/Singapore' ) ;
$date = date("o-m-d H:i:s" ) ;
echo $date;

$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);

$conn = new mysqli($server, $username, $password, $db);

// For ClearDB
$sql = "INSERT INTO feedback (name, email, subject, message, date) VALUES 
    ('" . $name . "' , '" . $email . "' , '" . $subject . "' , '" . $message . "' , '" . $date . "')";

// For Localhost
/*
$sql = "INSERT INTO test.feedback (name, email, subject, message, date) VALUES 
    ('" . $name . "' , '" . $email . "' , '" . $subject . "' , '" . $message . "' , '" . $date . "')";
*/

$result = $conn->query($sql);
?>