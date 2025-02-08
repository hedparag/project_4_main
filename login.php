<?php
//admin 1234 user 12345
// admin anita 6789 ishita pass-ishita user
include 'includes/config.php';
session_start();
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
$passErr = $emailErr ="";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
if (empty($_POST['aemail'])) {  
  $emailErr = "email is required";  
}
else {  
$email = input_data($_POST['aemail']); 
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {  
  $emailErr = "Invalid email format";  
} 
}
if (empty($_POST['apass'])) {  
  $passErr = "Password is required";  
}
else {  
$pass =$_POST['apass']; 

}
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
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
          <a class="nav-link" aria-current="page" href="registration.php" class="fw-bold ">Registration</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="javascript:void(0);">Login</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="display.php">Admin Section</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="dashboard.php">DashBoard</a>
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
    <div class="container w-50 mt-5 d-flex flex-column align-items-center">
    <h1 class="text-danger mb-3 fw-bold">Fill Out The Login Form</h1>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="border-2 bg-info p-4">
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Email address</label>
    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="aemail" value="<?= isset($_POST['aemail']) ? htmlspecialchars(trim($_POST['aemail']), ENT_QUOTES, 'UTF-8') : '' ?>">
    <span class="error">* <?php echo $emailErr; ?> </span>
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Password</label>
    <input type="password" class="form-control" id="exampleInputPassword1" name="apass" value="<?= isset($_POST['apass']) ? $_POST['apass'] : '' ?>">
    <span class="error">* <?php echo $passErr; ?> </span>
  </div>
  <button type="submit" class="btn btn-primary" name="btn">Submit</button>
</form>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
<?php
if(isset($_POST['btn'])){
  if($passErr == "" && $emailErr == ""){
    $query = "SELECT * FROM employees WHERE employee_email = $1  AND status = $2 AND user_type_id = $3;";
    $params = [$email, '1', 1];
    $result = pg_query_params($dbconn, $query, $params);
 $total=pg_num_rows($result);
 if($total>0)  { //valid admin
     $row=pg_fetch_assoc($result);  
     $id1=$row['employee_id'];
  $query2 = "SELECT * FROM users WHERE employee_id = $1  AND  user_type_id = $2;";
    $params2 = [$id1, 1];
    $result2 = pg_query_params($dbconn, $query2, $params2);
    $total2=pg_num_rows($result2);
    if($total2==1){
      $row1=pg_fetch_assoc($result2);
      $storedpass=$row1['password'];
      if (password_verify($pass, $storedpass)) {
        $_SESSION["id"] = "$id1";
        $_SESSION["uid"] = "$id1";
        $time = "UPDATE users SET last_login_time = NOW() WHERE employee_id = $1";
        pg_query_params($dbconn, $time, [$id1]);
        
        header("Location:display.php");
    }
    else{
      echo"You enter wrong password";
    }
      
    }
 
 } 
 else{//user login
  $query3 = "SELECT * FROM employees WHERE employee_email = $1  AND status = $2 AND user_type_id = $3;";
    $params3 = [$email, '1', 2];
    $result3 = pg_query_params($dbconn, $query3, $params3);
 $total3=pg_num_rows($result3);
 if($total3>0)  { //valid user
  
  $row3=pg_fetch_assoc($result3);
  $id2=$row3['employee_id'];  
  $query4 = "SELECT * FROM users WHERE employee_id = $1  AND user_type_id = $2;";
    $params4 = [$id2, 2];
    $result4 = pg_query_params($dbconn, $query4, $params4);
    $total4=pg_num_rows($result4);
    if($total4==1){

    $row2=pg_fetch_assoc($result4);
      $storedpass=$row2['password'];
      if (password_verify($pass, $storedpass)) {
        $_SESSION["id"] = "$id2";
        $time = "UPDATE users SET last_login_time = NOW() WHERE employee_id = $1";
        pg_query_params($dbconn, $time, [$id2]);
        
        header("Location:dashboard.php");//user dashboard
    }
    else{
      echo"You enter wrong password";
    }
 }


 
}
else{
  echo"You are not valid user and admin";
 }


   /* if( $_POST['aemail']=="admin@gmail.com" && $_POST['apass']=="admin" ){
      header("Location:display.php");
    }
    else{
      echo"Please enter a valid password and email address";
    }*/
 
  
  
}

}
else{
  echo"modify";
}
}
?>
