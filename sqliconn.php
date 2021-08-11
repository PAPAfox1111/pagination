<?php

// for connection to sql database;
$servername = "xxx";
$username = "xxx";
$password = "xxx";
$dbname = "xxxx";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

echo "Done!";

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
