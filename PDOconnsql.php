<?php

// Create connection

$host = "xxx";
$username = "xxx";
$password = "xxxx";
$dbname = "xxxx";

$dsn = 'mysql:dbname=xxxx;host=xxxx';

try {
    $dbh = new PDO($dsn, $username, $password);
    foreach ($dbh->query('SELECT * FROM xx') as $row) {
        print_r($row);
    }

    $dbh = null;
}   
    catch(PDOException $e){
        print "Error:" . $e->getMessage() . "<br />";
        die();
    }
    
?>


