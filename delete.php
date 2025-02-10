<?php
include 'includes/config.php';
session_start();
$id="";
if(isset($_GET['url-id'])){
  $id=$_GET['id'];
}
if(!isset($_SESSION['uid'])){
    header("Location:login.php");
}
//$id=$_GET['id'];
//$id = $_SESSION['employee_id'];
$query="DELETE FROM employees WHERE employee_id=$1;";
$params=[$id];
$row=pg_query_params($dbconn,$query,$params);
if($row){
    header("Location:display.php");
}
else{
    echo"Error Occured";
}
?>