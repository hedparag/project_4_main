<?php

// Database connection parameters
$host = 'localhost';  // Change as needed
$port = '5432';       // Default PostgreSQL port
$dbname = 'project';  // Change to your database name
$user = 'postgres';    // Change to your database username
$password = 'admin'; // Change to your database password

$conn_string = "host=$host port=$port dbname=$dbname user=$user password=$password";
$dbconn = pg_connect($conn_string);

?>