<?php

// Database connection parameters
$host = 'localhost';  // Change as needed
$port = '5432';       // Default PostgreSQL port
$dbname = 'testdb';  // Change to your database name
$user = 'postgres';    // Change to your database username
$password = 'padmin'; // Change to your database password

$conn_string = "host=$host port=$port dbname=$dbname user=$user password=$password";
$dbconn = pg_connect($conn_string);



$query = 'SELECT * FROM my_table';
$result = pg_query($dbconn, $query);

if (!$result) {
    echo "An error occurred while querying the database.";
    exit;
} else {
    echo "Query executed successfully.<br>";
}

print_r(pg_fetch_assoc($result));

pg_close($dbconn);