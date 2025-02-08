<!doctype html>
<html lang="en">
  <head>
  <style>  
.error {color: #FF0001;}  
</style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body class="bg-info-subtle">
  <nav class="navbar navbar-expand-lg bg-info p-2">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Employee Management System</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 d-flex justify-content-center">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#" class="fw-bold ">Registration</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="login.php">Login</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="javascript:void(0);">DashBoard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="display.php">Admin Section</a>
        </li>
       <!-- <li class="nav-item">
          <a class="nav-link" href="check.php">User</a>
        </li>-->
       <!-- <li class="nav-item">
          <a class="nav-link" href="user-login.php">User login</a>
        </li>-->
        <li class="nav-item">
          <a class="nav-link" href="logout.php">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
<?php
include 'includes/config.php';
session_start();
if(isset($_SESSION['id'])){
    $id=$_SESSION['id'];
    $query="SELECT * FROM employees WHERE employee_id=$1;";
    $params=[$id];
    $res=pg_query_params($dbconn,$query,$params);
    $row=pg_fetch_assoc($res);
    //$user_id=$row['user_type_id'];

    $query_pos = "SELECT * FROM positions WHERE position_id=$1;";
    $params_pos=[$row['position_id']];
    $res_pos=pg_query_params($dbconn,$query_pos,$params_pos);
    //$res_pos=pg_query($dbconn,$query_pos);
    $result_pos=pg_fetch_assoc($res_pos);
    $position=$result_pos['position_name'];

    $query_dept = "SELECT * FROM departments WHERE department_id=$1;";
    $params_dept=[$row['department_id']];
$res_dept=pg_query_params($dbconn,$query_dept,$params_dept);
    $result_dept=pg_fetch_assoc($res_dept);
    $department=$result_dept['department_name'];

    $query_type = "SELECT * FROM user_types WHERE user_type_id=$1;";
    $params_type=[$row['user_type_id']];
$res_type=pg_query_params($dbconn,$query_type,$params_type);
    $result_type=pg_fetch_assoc($res_type);
    $type=$result_type['user_type'];
    $time = "SELECT * FROM users WHERE employee_id=$id;";
    $res_time=pg_query($dbconn,$time);
    $result_time=pg_fetch_assoc($res_time);
    $last=$result_time['last_login_time'];

    if($row['user_type_id']==1){
        echo"<center><b>Hello admin </b></center>";
    }
    if($row['user_type_id']==2){
        echo"<center><b>Hello user </b></center>";
    }?> <h2 class="text-danger text-center mb-2">All The details of <?php echo $row['employee_name']?> is Following</h2>
    <table class="table table-bordered table-primary table-hover  border-primary">
      <tr><th>Employee Name</th>
        <th>Employee Email</th>
        <th>Employee Phone Number</th>
        <th>Employee Date of Birth</th>
        <th>Employee Details</th>
        <th>Employee Salary</th>
        <th>Created At</th>
        <th>Updated At</th>
        <th>last login time</th>
        <th>Status</th>
        <th>Skill</th>
        <th>Position</th>
        <th>Department</th>
        <th>User Type</th></tr>
    
    <?php
      echo"<tr><td>".htmlspecialchars($row['employee_name'], ENT_QUOTES, 'UTF-8')."</td>
      <td>".htmlspecialchars($row['employee_email'], ENT_QUOTES, 'UTF-8')."</td>
      <td>".htmlspecialchars($row['employee_phone'], ENT_QUOTES, 'UTF-8')."</td>
      <td>".htmlspecialchars($row['dob'], ENT_QUOTES, 'UTF-8')."</td>
      <td>".htmlspecialchars($row['employee_details'], ENT_QUOTES, 'UTF-8')."</td>
        <td>".htmlspecialchars($row['salary'], ENT_QUOTES, 'UTF-8')."</td>
      <td>".htmlspecialchars($row['created_at'], ENT_QUOTES, 'UTF-8')."</td>
      <td>".htmlspecialchars($row['updated_at'], ENT_QUOTES, 'UTF-8')."</td>
       <td>".htmlspecialchars($last, ENT_QUOTES, 'UTF-8')."</td>
      <td>Approved</td>
      <td>".htmlspecialchars($row['skills'], ENT_QUOTES, 'UTF-8')."</td>
      <td>".htmlspecialchars($position, ENT_QUOTES, 'UTF-8')."</td>
      <td>".htmlspecialchars($department, ENT_QUOTES, 'UTF-8')."</td>
      <td>".htmlspecialchars($type, ENT_QUOTES, 'UTF-8')."</td>
        </tr>";
   
   ?></table>
   <?php
} 
else{
    header("Location:login.php");
}
?>