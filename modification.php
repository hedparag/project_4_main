<?php
include 'includes/config.php';
session_start();
if(!isset($_SESSION['uid'])){
    header("Location:login.php");
}
function input_data($data)
{
    // trim() is used to remove any trailing whitespace
    $data = trim($data);
    // htmlspecialchars() is used to convert 
      // special characters into their HTML entities
    // Example - "&" -> "&amp"
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}
$passerr = "";
$salerr="";
//$id = $_GET['id'];
$id = $_SESSION['employee_id'];
$query = "SELECT * FROM employees WHERE employee_id = $1;";
$params=[$id];
$res = pg_query_params($dbconn, $query,$params);
$row = pg_fetch_assoc($res);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['sal'])) {  
        $salerr = "Salary is required";  
    }elseif (!is_numeric($_POST['sal']) || $_POST['sal'] <= 0) {
        $salerr = "Please enter a valid positive numeric salary";  
    }  
    else {  
        $sal = input_data($_POST['sal']);   
    }
    if (empty($_POST['pass'])) {  
        $passerr = "Password is required";  
    } 
    else {  
        $pass = $_POST['pass'];
        $hashedPassword = password_hash($pass, PASSWORD_BCRYPT);   
    }
}
?>
<?php
$alertMessage = '';
$alertType = '';
if(isset($_POST['btn'])){
    if($salerr=="" && $passerr==""){
        //$pass=$_POST['pass'];
        //$pass=bin2hex(random_bytes(6));
       // $hashedPassword = password_hash($pass, PASSWORD_BCRYPT);
        $fname=$row['employee_name'];
        $status=1;
        $user_type_id=$row['user_type_id'];
        $empid=$id;
        $salary=$_POST['sal'];
        $uname="iam_".$fname;
        $query="INSERT INTO users(
        user_type_id, full_name, username, password, status, employee_id,updated_at,created_at)
        VALUES ($1, $2, $3, $4, $5, $6,NOW(),NOW());";
        $params1=[$user_type_id,$fname,$uname,$hashedPassword,$status,$empid];
        $query2 = "UPDATE employees 
        SET status = $1, salary = $2 
        WHERE employee_id = $3;";
$params2 = [1, $salary, $id];
$res2 = pg_query_params($dbconn, $query2, $params2);

        $res=pg_query_params($dbconn,$query,$params1);
        //$res2=pg_query($dbconn,$query2,$params2);
        if ($res && $res2) {
            $alertMessage = "Record Updation Successful";
            $alertType = "success";
        } else {
            $alertMessage = "Error occurred during record update!";
            $alertType = "danger";
        }
    }
    else{
        echo"Try again";
    }
    
    }
    
//have to update the salary also then add login functionality from users side hve to provide file validation
?>
<!doctype html>
<html lang="en">
  <head>
  <style>  
.error {color: #FF0001;}  
</style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
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
          <a class="nav-link active" href="login.php">Login</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="dashboard.php">DashBoard</a>
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
  <div class="container d-flex flex-column align-items-center">
        <h1 class="text-danger mb-3 fw-bold">Fill Out The Approved Form</h1>
        <span class="error">* marked fields required</span> 
        <!-- Alert Box -->
        <?php if ($alertMessage): ?>
            <div class="alert alert-<?= $alertType ?> mt-2 alert-dismissible fade show" role="alert">
                <?= $alertMessage ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <form action="" method="POST" class="border-1 bg-info p-4">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="mb-3">
                        <label for="" class="form-label">Name</label>
                        <input type="text" class="form-control" name="fname" value="<?php echo $row['employee_name'];?>">
                    </div>
                </div>
                <div class="col">
                    <div class="mb-3">
                        <label for="mailcheck" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="mailcheck" value="<?php echo $row['employee_email']; ?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="mb-3">
                        <label for="" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" name="phone" value="<?php echo $row['employee_phone']; ?>">
                    </div>
                </div>
                <div class="col">
                    <div class="mb-3">
                        <label for="" class="form-label">Date Of Birth</label>
                        <input type="date" class="form-control" name="dob" value="<?php echo $row['dob']; ?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="mb-3">
                        <label for="" class="form-label">Enter Password</label>
                        <input type="password" class="form-control" name="pass" value="<?= isset($_POST['pass']) ? $_POST['pass'] : '' ?>">
                        <span class="error">* <?php echo $passerr; ?> </span> 
                    </div>
                </div>
                <div class="col">
                    <div class="mb-3">
                        <label for="" class="form-label">Enter Salary</label>
                        <input type="text" class="form-control" name="sal" value="<?= isset($_POST['sal']) ? htmlspecialchars(trim($_POST['sal']), ENT_QUOTES, 'UTF-8') : '' ?>">
                        <span class="error">* <?php echo $salerr; ?> </span> 
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary" name="btn">Submit</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>


