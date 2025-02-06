
<?php
include 'includes/config.php';
// define variables to empty values  
$nameErr = $emailErr = $mobilenoErr = $genderErr = $websiteErr = $agreeErr = "";  
$name = $email = $mobileno = $gender = $website = $agree =$dobErr=$typeErr=$detailsErr=$skillErr=$uploadErr=$deptErr=$posErr= "";  
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
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
    if (empty($_POST['dob'])) {  
        $dobErr = "DOB is required";  
   }
   else {  
    $dob = $_POST['dob'];   
}
if (empty($_POST['img'])) {  
    $uploadErr = "Upload the image";  
}
else {  
    $img=$_POST['img']; 
}
    if (empty($_POST['fname'])) {  
        $nameErr = "Name is required";  
   } else {  
       $name = input_data($_POST['fname']);  
           // check if name only contains letters and whitespace  
           if (!preg_match("/^[a-zA-Z ]*$/",$name)) {  
               $nameErr = "Only alphabets and white space are allowed";  
           }  
   }  
   if (empty($_POST['email'])) {  
    $emailErr = "Email is required";  
} else {  
    $email = input_data($_POST["email"]);  
    // check that the e-mail address is well-formed  
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {  
        $emailErr = "Invalid email format";  
    }  
}
if (empty($_POST['phone'])) {  
    $mobilenoErr = "Mobile no is required";  
} else {  
    $phone = input_data($_POST['phone']);  
    // check if mobile no is well-formed  
    if (!preg_match ("/^[0-9]*$/", $phone) ) {  
    $mobilenoErr = "Only numeric value is allowed.";  
    }  
//check mobile no length should not be less and greator than 10  
if (strlen ($phone) != 10) {  
    $mobilenoErr = "Mobile no must contain 10 digits.";  
    }  
} 
$user_type_id = $_POST['admin-type'];
/*if(isset($_POST['admin-type'])){
    $admin="SELECT user_type FROM users WHERE user_type_id=$user_type_id";
}
else{
    $admin='';
}*/
$department_id = $_POST['dept-type'];
$position_id = $_POST['pos-type'];
$img=$_POST['img'];
$skill=$_POST['skill-type'];
$details=$_POST['details'];
//$details = isset($_POST['details']) ? $_POST['details'] : '';

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
          <a class="nav-link" href="#">Admin</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">DashBoard</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
    <div class="container d-flex flex-column align-items-center">
        <h1 class="text-danger mb-3 fw-bold">Fill Out The Registration Form</h1>
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
                <div class="col">
                    <div class="mb-3">
                        <label for="" class="form-label">Phone Number</label>
                        <input type="phone" class="form-control"  name="phone"  id=""value="<?= isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : '' ?>">
                        <span class="error">* <?php echo $mobilenoErr; ?> </span>   
                    </div>
                    
                </div>
                <div class="col">
                    <div class="mb-3">
                        <label for="" class="form-label">Date Of Birth</label>
                        <input type="date" class="form-control"  name="dob"  id=""value="<?= isset($_POST['dob']) ? htmlspecialchars($_POST['dob']) : '' ?>">
                        <span class="error">* <?php echo $dobErr; ?> </span> 
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                    <div class="mb-3">
                        <label for="" class="form-label">Upload Image From Here</label>
                        <input type="file" class="form-control"  name="img"  id=""value="<?= isset($_POST['img']) ? htmlspecialchars($_POST['img']) : '' ?>">
                        <span class="error">* <?php echo $uploadErr; ?> </span> 
                    </div>
                    </div>
                <div class="col">
                    <div class="mb-3">
                        <div class="mb-3">
                            <label for="" class="form-label">User Type</label>
                            <select class="form-select" name="admin-type" id="" >
                            <option>-- Select admin type --</option>
                                <?php
                                $query = 'SELECT * FROM user_types';
                                $result = pg_query($dbconn, $query);
                                $data = array();
                                while ($row = pg_fetch_assoc($result)) {
                                    $selected = (isset($_POST['admin-type']) && $_POST['admin-type'] == $row['user_type_id']) ? 'selected' : '';
                                ?>
                                <option value="<?php echo $row['user_type_id'] ?>" <?= $selected ?>><?php echo $row['user_type'] ?></option>
                                <?php } ?>
                            </select>
                           
                        </div>
                        
                    </div>
                    
                </div>
                <div class="row">
                <div class="col">
                    <div class="mb-3">
                        <div class="mb-3">
                            <label for="" class="form-label">Department Type</label>
                            <select class="form-select" name="dept-type" id="" >
                            <option>-- Select department type --</option>
                                <?php
                                $query = 'SELECT * FROM departments';
                                $result = pg_query($dbconn, $query);
                                $data = array();
                                while ($row = pg_fetch_assoc($result)) {
                                    $selected = (isset($_POST['dept-type']) && $_POST['dept-type'] == $row['department_id']) ? 'selected' : '';
                                ?>
                                <option value="<?php echo $row['department_id'] ?>" <?= $selected ?>><?php echo $row['department_name'] ?></option>
                                <?php } ?>
                            </select>
                          
                        </div>
                        
                    </div>
                    
                </div>
                <div class="col">
                    <div class="mb-3">
                        <div class="mb-3">
                            <label for="" class="form-label">Position Type</label>
                            <select class="form-select" name="pos-type" id="" >
                            <option>-- Select Position type --</option>
                                <?php
                                $query = 'SELECT * FROM positions';
                                $result = pg_query($dbconn, $query);
                                $data = array();
                                while ($row = pg_fetch_assoc($result)) {
                                    $selected = (isset($_POST['pos-type']) && $_POST['pos-type'] == $row['position_id']) ? 'selected' : '';
                                ?>
                                <option value="<?php echo $row['position_id'] ?>" <?= $selected ?>><?php echo $row['position_name'] ?></option>
                                <?php } ?>
                            </select>
                            
                        </div>
                        
                    </div>
                    
                </div>
                <div class="col">
                    <div class="mb-3">
                        <div class="mb-3">
                            <label for="skill" class="form-label">Skill Type</label>
                            <select class="form-select" name="skill-type" id="skill" >
                            <option>-- Select your skill --</option>
                            <option value="Data Analysts" <?= (isset($_POST['skill-type']) && $_POST['skill-type'] == 'Data Analysts') ? 'selected' : '' ?>>Data Analysts</option>

                            <option value="Data Scientists" <?= (isset($_POST['skill-type']) && $_POST['skill-type'] == 'Data Scientists') ? 'selected' : '' ?>>Data Scientists</option>

                            <option value="Web Developer" <?= (isset($_POST['skill-type']) && $_POST['skill-type'] == 'Web Developer') ? 'selected' : '' ?>>Web Developer</option>
                            <option value="Game Developer" <?= (isset($_POST['skill-type']) && $_POST['skill-type'] == 'Game Developer') ? 'selected' : '' ?>>Game Developer</option>
                            </select>
                          
                        </div>
                        
                    </div>
                    
                </div>

                </div>
                </div>
            </div>
        </div>
        <div class="row">
        <div class="form-floating">
  <textarea class="form-control" placeholder="Enter your details from here..." id="floatingTextarea2" name="details" style="height: 100px"><?= isset($_POST['details']) ? htmlspecialchars($_POST['details']) : '' ?></textarea>
  <label for="floatingTextarea2">Enter your details</label>

</div>

</div>
<div class="row">
    <div class="col justify-content-center">
        <input type="submit" value="Register" name="btn" class="mt-4">
        </div>
        </div>
    </form>
    </div>
    <div class="w-100 foot-col  bg-info">
      <div class="container-fluid text-center mt-5">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-5">
            <div class="col text-dark">
                <div class="d-flex flex-column mb-3 footer-content justify-content-center">
                    <a href="javascript:void(0);" class="text-dark text-decoration-none">About</a>
                    <a href="javascript:void(0);" class="text-dark text-decoration-none">Contact Us</a>
                    <a href="javascript:void(0);"class="text-dark text-decoration-none">About us</a>
                    <a href="javascript:void(0);"class="text-dark text-decoration-none">Careers</a>
                    <a href="javascript:void(0);"class="text-dark text-decoration-none">Press</a>
                    <a href="javascript:void(0);"class="text-dark text-decoration-none">Corporate Information</a>
                </div>
            </div>
            <div class="col">
                <div class="d-flex flex-column mb-3 footer-content justify-content-center">
                    <a href="javascript:void(0);"class="text-dark text-decoration-none">Help</a>
                    <a href="javascript:void(0);"class="text-dark text-decoration-none">FAQ</a>
                    <a href="javascript:void(0);"class="text-dark text-decoration-none">Payments</a>
                    <a href="javascript:void(0);"class="text-dark text-decoration-none">Cancellation</a>
                </div>
            </div>
            <div class="col">
                <div class="d-flex flex-column mb-3 footer-content justify-content-center">
                    <a href="javascript:void(0);"class="text-dark text-decoration-none">Consumer Policy</a>
                    <a href="javascript:void(0);"class="text-dark text-decoration-none">Security</a>
                    <a href="javascript:void(0);"class="text-dark text-decoration-none">Privacy</a>
                    <a href="javascript:void(0);"class="text-dark text-decoration-none">Sitemap</a>
                    <a href="javascript:void(0);"class="text-dark text-decoration-none">EPR Compliance</a>
                </div>
            </div>
            <div class="col">
                <div class="d-flex flex-column mb-3 footer-content justify-content-center">
                    <a href="javascript:void(0);"class="text-dark text-decoration-none">Mail us</a>

                    <a href="javascript:void(0);"class="text-dark text-decoration-none">indrani002@gmail.com</a>
                    <p class="mt-5 text-dark text-decoration-none">Social links</p>
                    <div class="d-flex flex-row justify-content-between row-cols-3">
                        <a href="javascript:void(0);"><i class="fa-brands fa-facebook fa-beat fa-sm col"></i></a>
                        <a href="javascript:void(0);"><i class="fa-brands fa-x-twitter fa-beat fa-sm col"></i></a>
                        <a href="javascript:void(0);"><i class="fa-brands fa-instagram fa-beat fa-sm col"></i></a>
                    </div>

                </div>
            </div>
            <!-- <div class="col">
                <div class="d-flex flex-column mb-3 footer-content">
                    <div class="footer-content map">
                        <p>Find us</p>
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d20239.79039670119!2d88.39365077017764!3d22.62527190600183!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39f89e1a92f1acdf%3A0x23207b66790a5f2f!2sVIP%20(%20Dum%20Dum%20)!5e0!3m2!1sen!2sin!4v1737635816429!5m2!1sen!2sin"
                            width="100" height="100" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>-->
        </div>
    </div>
</div>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
 <!--<script src="jquery/reg.js"></script>  -->
</body>
</html>
<?php
/*if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn'])) {
    // Retrieve form data
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
    if (empty($_POST['dob'])) {  
        $dobErr = "DOB is required";  
   }
   else {  
    $dob = $_POST['dob'];   
}
    if (empty($_POST['fname'])) {  
        $nameErr = "Name is required";  
   } else {  
       $name = input_data($_POST['fname']);  
           // check if name only contains letters and whitespace  
           if (!preg_match("/^[a-zA-Z ]*$/",$name)) {  
               $nameErr = "Only alphabets and white space are allowed";  
           }  
   }  
   if (empty($_POST['email'])) {  
    $emailErr = "Email is required";  
} else {  
    $email = input_data($_POST["email"]);  
    // check that the e-mail address is well-formed  
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {  
        $emailErr = "Invalid email format";  
    }  
}
if (empty($_POST['phone'])) {  
    $mobilenoErr = "Mobile no is required";  
} else {  
    $phone = input_data($_POST['phone']);  
    // check if mobile no is well-formed  
    if (!preg_match ("/^[0-9]*$/", $phone) ) {  
    $mobilenoErr = "Only numeric value is allowed.";  
    }  
//check mobile no length should not be less and greator than 10  
if (strlen ($phone) != 10) {  
    $mobilenoErr = "Mobile no must contain 10 digits.";  
    }  
}    
    //$name = $_POST['fname'];
    //$email = $_POST['email'];
    //$phone = $_POST['phone'];
    //$dob = $_POST['dob'];
    $user_type_id = $_POST['admin-type'];
    $department_id = $_POST['dept-type'];
    $position_id = $_POST['pos-type'];
    $img=$_POST['img'];
    $skill=$_POST['skill-type'];
   $details=$_POST['details'];*/
   if(isset($_POST['btn'])) { 
   if ($dobErr == "" && $nameErr == "" && 
   $emailErr == "" && $mobilenoErr == "") {
   $cond="SELECT * FROM employees WHERE employee_email='$email' OR employee_phone='$phone'";
   $res=pg_query($dbconn,$cond);
   $num=pg_num_rows($res);
    if($num==0){
        $query = "INSERT INTO employees(
            user_type_id, department_id, position_id, employee_name, employee_email, employee_phone,dob,profile_image,skills,employee_details)
            VALUES ( '$user_type_id', '$department_id', '$position_id', '$name', '$email', '$phone', '$dob','$img','$skill','$details')";
        
            $result = pg_query($dbconn, $query);
        
            if ($result) {
                echo "User registered successfully!";
            } else {
                echo "Error in registration: " . pg_last_error($dbconn);
            }
    }
    else{
        echo"record already exists";
    }
    
    
}
else{
    echo "<p class='msg'>You shared Invalid details
    <br/>Please provide correct data!</p>";
}
}
?>