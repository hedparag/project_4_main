<?php
include 'includes/config.php';
$id=$_GET['id'];
$query="DELETE FROM employees WHERE employee_id='$id';";
$row=pg_query($dbconn,$query);
if($row){
    header("Location:display.php");
}
else{
    echo"Error Occured";
}
?>