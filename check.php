<?php
include 'includes/config.php';
$nameErr = $emailErr ="";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['fname'])) {  
        $nameErr = "Username is required";  
    }
    else {  
    $fname = $_POST['fname'];   
    }
    if (empty($_POST['email'])) {  
        $emailErr = "Email is required";  
    }
    else {  
    $email = $_POST['email'];   
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
        <h1 class="text-danger mb-3 fw-bold">Fill Out The Checking Form</h1>
        <span class = "error">* marked fields required</span>  
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="border-1 bg-info p-4">
        <div class="row">
            <div class="row">
                <div class="col">
                    <div class="mb-3">
                        <label for="" class="form-label">Name</label>
                        <input type="text" class="form-control"  name="fname"  id=""value="<?= isset($_POST['fname']) ? htmlspecialchars($_POST['fname']) : '' ?>">
                        <span class="error">* <?php echo $nameErr; ?> </span> 
                    </div>
                    
                </div>
                <div class="col">
                    <div class="mb-3">
                        <label for="mailcheck" class="form-label">Email</label>
                        <input type="email" class="form-control"  name="email"  id="mailcheck"
                        value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
                        <span class="error">* <?php echo $emailErr; ?> </span>  
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
    if($emailErr=="" && $nameErr==""){
        $query="SELECT * FROM employees WHERE employee_name='$fname' AND employee_email='$email' AND status='1';";
        $res=pg_query($dbconn,$query);
        $total=pg_num_rows($res);
        $row=pg_fetch_assoc($res);
        if($total==1){
            echo"You are approved user<br><br>";
            $id=$row['employee_id'];
            $query2="SELECT * FROM users WHERE employee_id='$id';";
            $res=pg_query($dbconn,$query2);
            $rows=pg_fetch_assoc($res);
            $val_pass=$rows['password'];
            $val_user=$rows['username'];
            echo"Your username is".$val_user."<br><br>";
            echo"your password is".$val_pass."<br><br>";
            echo"Do you want to change your password?<br><br>";?>
            <div class="row">
                <div class="col"><a href="change.php?id=<?php echo $id;?>"><button type='button' class='btn btn-success'>Change Password</button></a></div>
                <div class="col"><a href="#"><button type='button' class='btn btn-primary'>No</button></a></div>
            </div>

       <?php }
       else{
        echo"You are not approved";
       }

    }

}

?>