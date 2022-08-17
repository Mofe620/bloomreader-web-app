<?php
// conection file to connect web portal to database 

// define() is used to create constants
// define("DB_HOST", "localhost");// your host
// define("DB_USER", "root");// database username
// define("DB_PASS", "");// database password
// define("DB_NAME", "bloomreader");// database name

// Create connection NOTE: Always in this order
// $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Because of ClearDB with Heroku
$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"], 1);

$conn = new mysqli($server, $username, $password, $db);

// Check connection or produce error
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
//else {echo "Connected successfully";}
?>