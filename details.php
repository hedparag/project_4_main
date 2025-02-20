<?php
session_start();
if(!isset($_SESSION['uid'])){
    header("Location:login.php");
}
?>
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
          <a class="nav-link" href="login.php">Login</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="modified-dashboard.php">DashBoard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="display.php">Admin Section</a>
        </li>
        <li class="nav-item">
              <a class="nav-link" href="modify-user.php">Edit</a>
            </li>
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
$id="";
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if(!ctype_digit($id)){
        die("<h2>Invalid</h2>");
    }
} /*else {
    
}*/

// Query to check if the ID exists in the database
$query = "SELECT * FROM employees WHERE employee_id = $1;";
$params = [$id];
$res = pg_query_params($dbconn, $query, $params);

if (!$res || pg_num_rows($res) === 0) {
    die("<h2>Not Found</h2>");
}

$row = pg_fetch_assoc($res);
/*$id="";
if(isset($_GET['url-id'])){
  $id=$_GET['id'];
}
$query="SELECT * FROM employees WHERE employee_id=$1;";
$params=[$id];
$res=pg_query_params($dbconn,$query,$params);
$row=pg_fetch_assoc($res);*/

$query_pos = "SELECT * FROM positions WHERE position_id= $1;";
$params_pos=[$row['position_id']];
$res_pos=pg_query_params($dbconn,$query_pos,$params_pos);
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
?>

<h2 class="text-danger text-center mb-2">All The Records Are Following</h2>
<table class="table table-bordered table-primary table-hover border-primary">
    <tr>
        <th>Employee Name</th>
        <td><?php echo htmlspecialchars($row['employee_name'], ENT_QUOTES, 'UTF-8'); ?></td>
    </tr>
    <tr>
        <th>Employee Email</th>
        <td><?php echo htmlspecialchars($row['employee_email'], ENT_QUOTES, 'UTF-8'); ?></td>
    </tr>
    <tr>
        <th>Employee Phone Number</th>
        <td><?php echo htmlspecialchars($row['employee_phone'], ENT_QUOTES, 'UTF-8'); ?></td>
    </tr>
    <tr>
        <th>Employee Date of Birth</th>
        <td><?php echo htmlspecialchars($row['dob'], ENT_QUOTES, 'UTF-8'); ?></td>
    </tr>
    <tr>
        <th>Employee Details</th>
        <td><?php echo htmlspecialchars($row['employee_details'], ENT_QUOTES, 'UTF-8'); ?></td>
    </tr>
    <tr>
        <th>Created At</th>
        <td><?php echo htmlspecialchars($row['created_at'], ENT_QUOTES, 'UTF-8'); ?></td>
    </tr>
    <tr>
        <th>Updated At</th>
        <td><?php echo htmlspecialchars($row['updated_at'], ENT_QUOTES, 'UTF-8'); ?></td>
    </tr>
    <tr>
        <th>Status</th>
        <td>Not Approved</td>
    </tr>
    <tr>
        <th>Skill</th>
        <td><?php echo htmlspecialchars($row['skills'], ENT_QUOTES, 'UTF-8'); ?></td>
    </tr>
    <tr>
        <th>Position</th>
        <td><?php echo htmlspecialchars($position, ENT_QUOTES, 'UTF-8'); ?></td>
    </tr>
    <tr>
        <th>Department</th>
        <td><?php echo htmlspecialchars($department, ENT_QUOTES, 'UTF-8'); ?></td>
    </tr>
    <tr>
        <th>User Type</th>
        <td><?php echo htmlspecialchars($type, ENT_QUOTES, 'UTF-8'); ?></td>
    </tr>
</table>
