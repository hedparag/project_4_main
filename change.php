<?php
include 'includes/config.php';
$passErr="";
$nameErr="";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    
    die("Error: Missing required parameter.");
}
$query="SELECT * FROM users WHERE employee_id='$id';";
$res=pg_query($dbconn,$query);
$row=pg_fetch_assoc($res);
$full_name=$row['full_name'];
$user_name=$row['username'];
$password=$row['password'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['uname'])) {  
        $nameErr = "Change the user name";  
    } else {  
        $uname = $_POST['uname'];   
    }
    if (empty($_POST['pass'])) {  
        $passErr = "Change the password";  
    } else {  
        $upass = $_POST['pass'];   
    }
}
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
  <div class="container d-flex flex-column align-items-center">
        <h1 class="text-danger mb-3 fw-bold"><?php echo $full_name;?>fill Out The Changing Form </h1>
        <span class = "error">* marked fields required</span>  
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="border-1 bg-info p-4">
        <div class="row">
            <div class="row">
                <div class="col">
                    <div class="mb-3">
                        <label for="mailcheck" class="form-label">User Name</label>
                        <input type="text" class="form-control"  name="uname"  id="mailcheck"
                        value="<?php echo $user_name; ?>">
                        <span class="error">* <?php echo $nameErr; ?> </span>  
                    </div>
                    
                </div>
                <div class="col">
                    <div class="mb-3">
                        <label for="mailcheck" class="form-label">Password</label>
                        <input type="password" class="form-control"  name="pass"  id="mailcheck"
                        value="<?php echo $password; ?>">
                        <span class="error">* <?php echo $passErr; ?> </span>  
                    </div>
                </div>
            </div>
            <div class="row">
           <div class="col justify-content-center">
        <input type="submit" value="Change" name="btn" class="mt-4">
        </div>
        </div>
  </div>
   </form>
 </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
<?php  
if(isset($_POST['btn'])){
    if($passErr=="" && $nameErr==""){
        $sql="UPDATE users
        SET username='$uname', password='$upass'
        WHERE employee_id='$id';";
        $result=pg_query($dbconn,$sql);
        if($result){
            echo"Updated Successfully.<br>Your User Name is:".$uname."<br>Your Password is:".$upass;
            echo"<br>Please Remember your password";
        }
        else{
            echo"Updation Error";
        }
    }
    else{
        echo"Check the fields";
    }
}
?>