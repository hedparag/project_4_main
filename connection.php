<?php
$host='localhost';
$username='postgres';
$password='admin';
$dbname='project';
$conn=pg_connect("host=localhost dbname=project user=postgres password=admin");
if($conn){
    echo"connection established";
}
else{
    echo"connection failed";
}
?>