<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Display</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
  <nav class="navbar navbar-expand-lg bg-info p-2">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Employee Management System</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 d-flex justify-content-center">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="registration.php" class="fw-bold ">Registration</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="login.php">Admin</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="dashboard.php">DashBoard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="check.php">User</a>
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
$id=$_GET['id'];
$query="SELECT * FROM employees WHERE employee_id='$id';";
$res=pg_query($dbconn,$query);
$row=pg_fetch_assoc($res);

$query_pos = "SELECT * FROM positions WHERE position_id='" . $row['position_id'] . "';";
$res_pos=pg_query($dbconn,$query_pos);
$result_pos=pg_fetch_assoc($res_pos);
$position=$result_pos['position_name'];

$query_dept = "SELECT * FROM departments WHERE department_id='" . $row['department_id'] . "';";

$res_dept=pg_query($dbconn,$query_dept);
$result_dept=pg_fetch_assoc($res_dept);
$department=$result_dept['department_name'];

$query_type = "SELECT * FROM user_types WHERE user_type_id='" . $row['user_type_id'] . "';";

$res_type=pg_query($dbconn,$query_type);
$result_type=pg_fetch_assoc($res_type);
$type=$result_type['user_type'];

//$total=pg_num_rows($res);
//if($total>0){
    ?>

    <h2 class="text-danger text-center mb-2">All The Records Are Following</h2>
    <table class="table table-bordered table-primary table-hover  border-primary">
      <tr><th>Employee Name</th>
        <th>Employee Email</th>
        <th>Employee Phone Number</th>
        <th>Employee Date of Birth</th>
        <th>Employee Details</th>
        <th>Created At</th>
        <th>Updated At</th>
        <th>Status</th>
        <th>Skill</th>
        <th>Position</th>
        <th>Department</th>
        <th>User Type</th></tr>
        <?php
        echo"<tr><td>".$row['employee_name']."</td>
        <td>".$row['employee_email']."</td>
        <td>".$row['employee_phone']."</td>
        <td>".$row['dob']."</td>
        <td>".$row['employee_details']."</td>
        <td>".$row['created_at']."</td>
        <td>".$row['updated_at']."</td>
        <td> Not Approved</td>
        <td>".$row['skills']."</td>
        <td>".$position."</td>
        <td>".$department."</td>
        <td>".$type."</td>
          </tr>";
     
     ?></table>
     <?php

//chaged condition

?>