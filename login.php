<?php
$passErr = $emailErr ="";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
if (empty($_POST['aemail'])) {  
  $emailErr = "email is required";  
}
else {  
$email = $_POST['aemail']; 
}
if (empty($_POST['apass'])) {  
  $passErr = "password is required";  
}
else {  
$pass = $_POST['apass']; 
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

    <div class="container w-50 mt-5 d-flex flex-column align-items-center">
    <h1 class="text-danger mb-3 fw-bold">Fill Out The Login Form</h1>
  <form action="" method="POST" class="border-2 bg-info p-4">
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Email address</label>
    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="aemail">
    <span class="error">* <?php echo $emailErr; ?> </span>
    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Password</label>
    <input type="password" class="form-control" id="exampleInputPassword1" name="apass">
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
    if( $_POST['aemail']=="admin@gmail.com" && $_POST['apass']=="admin" ){
      header("Location:display.php");
    }
    else{
      echo"Please enter a valid password and email address";
    }
  }
  else{
    echo"modify";
  }
  
}

?>
