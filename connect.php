 <?php
// conection file to connect web portal to database 

$db_server = "localhost"; // your host
$db_user = "root";// database username
$db_password = ""; // database password
$db_name ="bloomreader"; // database name

// Create connection
$conn = new mysqli($db_server, $db_user, $db_password, $db_name);

// Check connection or produce error
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
//echo "Connected successfully";
?>