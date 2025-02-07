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
$query="SELECT * FROM employees WHERE status IS NULL;";
$res=pg_query($dbconn,$query);
$total=pg_num_rows($res);
if($total>0){
    ?>
    <h2 class="text-danger text-center mb-2">All The Records Are Following</h2>
    <table class="table table-bordered table-primary table-hover  border-primary">
      <tr><th>Employee Name</th>
        <th>Employee Email</th>
        <th>Employee Phone NUmber</th>
        <th>Employee Date of Birth</th>
        <th>Action</th></tr>
        <?php
    while($rows=pg_fetch_assoc($res)){
        echo"<tr><td>".$rows['employee_name']."</td>
        <td>".$rows['employee_email']."</td>
        <td>".$rows['employee_phone']."</td>
        <td>".$rows['dob']."</td>
        <td>
                <a href='modification.php?id=" . $rows['employee_id'] . "'>
                    <button type='button' class='btn btn-success'>Approve</button>
                </a>
                <a href='delete.php?id=" . $rows['employee_id'] . "'>
                    <button type='button' class='btn btn-danger'>Delete</button>
                </a>
                <a href='details.php?id=" . $rows['employee_id'] . "'>
                    <button type='button' class='btn btn-primary'>Details</button>
                </a>
            </td>
          </tr>";
     }
     ?></table>
     <?php
}
else{
    echo"No data to show";
}
//chaged condition
?>