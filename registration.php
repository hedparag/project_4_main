
<?php
include 'includes/config.php';


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
    
    <div class="container d-flex flex-column align-items-center">
        <h1 class="text-danger mb-3 fw-bold">Fill Out The Registration Form</h1>
        <form action="" method="POST" class="border-1 bg-info p-4">
        <div class="row">
            <div class="row">
                <div class="col">
                    <div class="mb-3">
                        <label for="" class="form-label">Name</label>
                        <input type="text" class="form-control"  name="fname"  id="" required>
                    </div>
                    
                </div>
                <div class="col">
                    <div class="mb-3">
                        <label for="mailcheck" class="form-label">Email</label>
                        <input type="email" class="form-control"  name="email"  id="mailcheck" required>
                    </div>
                    
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="mb-3">
                        <label for="" class="form-label">Phone Number</label>
                        <input type="phone" class="form-control"  name="phone"  id="" required>
                    </div>
                    
                </div>
                <div class="col">
                    <div class="mb-3">
                        <label for="" class="form-label">Date Of Birth</label>
                        <input type="date" class="form-control"  name="dob"  id="" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                    <div class="mb-3">
                        <label for="" class="form-label">Upload Image From Here</label>
                        <input type="file" class="form-control"  name="img"  id="" required>
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
                                ?>
                                <option value="<?php echo $row['user_type_id'] ?>"><?php echo $row['user_type'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        
                    </div>
                    
                </div>
                <div class="row">
                <div class="col">
                    <div class="mb-3">
                        <div class="mb-3">
                            <label for="" class="form-label">User Type</label>
                            <select class="form-select" name="dept-type" id="" >
                            <option>-- Select department type --</option>
                                <?php
                                $query = 'SELECT * FROM departments';
                                $result = pg_query($dbconn, $query);
                                $data = array();
                                while ($row = pg_fetch_assoc($result)) {
                                ?>
                                <option value="<?php echo $row['department_id'] ?>"><?php echo $row['department_name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        
                    </div>
                    
                </div>
                <div class="col">
                    <div class="mb-3">
                        <div class="mb-3">
                            <label for="" class="form-label">User Type</label>
                            <select class="form-select" name="pos-type" id="" >
                            <option>-- Select Position type --</option>
                                <?php
                                $query = 'SELECT * FROM positions';
                                $result = pg_query($dbconn, $query);
                                $data = array();
                                while ($row = pg_fetch_assoc($result)) {
                                ?>
                                <option value="<?php echo $row['position_id'] ?>"><?php echo $row['position_name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        
                    </div>
                    
                </div>
                <div class="col">
                    <div class="mb-3">
                        <div class="mb-3">
                            <label for="skill" class="form-label">User Type</label>
                            <select class="form-select" name="skill-type" id="skill" >
                            <option>-- Select your skill --</option>
                                <option value="Data Analysts">Data Analysts</option>
                                <option value="Data Scientist">Data Scientist</option>
                                <option value="Web developer">Web developer</option>
                                <option value="Game Developer">Game Developer</option>
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
  <textarea class="form-control" placeholder="Enter your details from here..." id="floatingTextarea2" name="details" style="height: 100px"></textarea>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="jquery/reg.js"></script>  
</body>
</html>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn'])) {
    // Retrieve form data
    $name = $_POST['fname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $dob = $_POST['dob'];
    $user_type_id = $_POST['admin-type'];
    $department_id = $_POST['dept-type'];
    $position_id = $_POST['pos-type'];
    $img=$_POST['img'];
    $skill=$_POST['skill-type'];
   $details=$_POST['details'];
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

?>