<?php
include 'includes/config.php';
session_start();
$passErr=$unameErr="";
function input_data($data)
{
    // trim() is used to remove any trailing whitespace
    $data = trim($data);
    // htmlspecialchars() is used to convert 
      // special characters into their HTML entities
    // Example - "&" -> "&amp"
    $data = htmlspecialchars($data);
    return $data;
}
if (empty($_POST['uname'])) {  
    $unameErr = "User name is required";  
} else {  
    $uname = $_POST["uname"];  
   
}
if (empty($_POST['upass'])) {  
    $passerr = "Password is required";  
}
else {  
$pass = $_POST['upass'];   
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
        <h1 class="text-danger mb-3 fw-bold">Fill Out The Login Form</h1>
        <span class = "error">* marked fields required</span>  
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="border-1 bg-info p-4">
        <div class="row">
            <div class="row">
                <div class="col">
                    <div class="mb-3">
                        <label for="" class="form-label">Password</label>
                        <input type="password" class="form-control"  name="upass"  id=""value="<?= isset($_POST['upass']) ? htmlspecialchars($_POST['upass']) : '' ?>">
                        <span class="error">* <?php echo $passErr; ?> </span> 
                    </div>
                    
                </div>
                <div class="col">
                    <div class="mb-3">
                        <label for="mailcheck" class="form-label">Username</label>
                        <input type="text" class="form-control"  name="uname"  id="mailcheck"
                        value="<?= isset($_POST['uname']) ? htmlspecialchars($_POST['uname']) : '' ?>">
                        <span class="error">* <?php echo $unameErr; ?> </span>  
                    </div>
                    
                </div>
            </div>
            <div class="row">
    <div class="col justify-content-center">
        <input type="submit" value="Check" name="btn" class="mt-4">
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
    $query="SELECT * FROM users WHERE password='$pass' AND username='$uname';";
    $res=pg_query($dbconn,$query);
    $total=pg_num_rows($res);
    if($total==1){
        $_SESSION["username"] = "$uname";
        header("Location:dashboard.php");
    }
    else{
       echo"invalid credentials";
    }
}

?>