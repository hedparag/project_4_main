<?php
include 'includes/config.php';
$emailErr = $mobilenoErr = $dobErr = "";
session_start();
$id = "";

if (!isset($_SESSION['id'])) {
    header("Location:login.php");
    exit();
} else {
    $id = $_SESSION['id'];
}

// Function to sanitize input data
function input_data($data) {
    $data = trim($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}
$query = "SELECT * FROM employees WHERE employee_id=$1;";
$param = [$id];
$res = pg_query_params($dbconn, $query, $param);
$row = pg_fetch_assoc($res);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $phone = $dob = $details = "";

    // Form validation and assignment
    if (empty($_POST['dob'])) {
        $dobErr = "DOB is required";
    } else {
        $dob = $_POST['dob'];
    }

    if (empty($_POST['email'])) {
        $emailErr = "Email is required";
    } else {
        $email = input_data($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }

    if (empty($_POST['phone'])) {
        $mobilenoErr = "Mobile no is required";
    } else {
        $phone = input_data($_POST['phone']);
        if (!preg_match("/^[0-9]*$/", $phone)) {
            $mobilenoErr = "Only numeric value is allowed.";
        } elseif (strlen($phone) != 10) {
            $mobilenoErr = "Mobile no must contain 10 digits.";
        }
    }

    $details = input_data($_POST['details']);

    if (empty($emailErr) && empty($mobilenoErr) && empty($dobErr)) {
        // Update query for employees
        $update = "UPDATE employees SET employee_email=$1, employee_phone=$2, dob=$3, updated_at=NOW(), employee_details=$4 WHERE employee_id=$5;";
        $param1 = [$email, $phone, $dob, $details, $id];
        $res = pg_query_params($dbconn, $update, $param1);

        // Update query for users
        $update1 = "UPDATE users SET updated_at=NOW() WHERE employee_id=$1;";
        $param2 = [$id];
        $res1 = pg_query_params($dbconn, $update1, $param2);

        if ($res && $res1) {
            //echo "Record Updated";
            // Reload form with updated values from the database
            ?>    <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div class="toast text-bg-success" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-body">
                   Updation Successful
                </div>
            </div>
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                var toastElement = document.querySelector(".toast");
                var toast = new bootstrap.Toast(toastElement);
                toast.show();
            });
        </script>
            <?php
            $query = "SELECT * FROM employees WHERE employee_id=$1;";
            $param = [$id];
            $res = pg_query_params($dbconn, $query, $param);
            $row = pg_fetch_assoc($res);
        } else {
           // echo "Error occurred while updating data.";
           ?>    <div class="toast-container position-fixed bottom-0 end-0 p-3">
           <div class="toast text-bg-success" role="alert" aria-live="assertive" aria-atomic="true">
               <div class="toast-body">
                   Error Occured
               </div>
           </div>
       </div>
       <script>
           document.addEventListener("DOMContentLoaded", function () {
               var toastElement = document.querySelector(".toast");
               var toast = new bootstrap.Toast(toastElement);
               toast.show();
           });
       </script>
       <?php
        }
    }
} 
/*else {
    // Load initial form data
    $query = "SELECT * FROM employees WHERE employee_id=$1;";
    $param = [$id];
    $res = pg_query_params($dbconn, $query, $param);
    $row = pg_fetch_assoc($res);
}*/
?>
<!doctype html>
<html lang="en">
<head>
  <style>
    .error {color: #FF0001;}
  </style>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Update Employee Details</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="bg-info-subtle">
<nav class="navbar navbar-expand-lg bg-info p-2">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Employee Management System</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 d-flex justify-content-center">
        <li class="nav-item">
          <a class="nav-link" href="registration.php">Registration</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="login.php">Login</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="display.php">Admin Section</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="modified-dashboard.php">DashBoard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="logout.php">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<div class="container d-flex flex-column align-items-center">
  <h1 class="text-danger mb-3 fw-bold">Fill Out The Update Form</h1>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="border-1 bg-info p-4">
    <div class="row">
      <div class="row">
        <div class="col">
          <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" class="form-control" name="fname" value="<?php echo $row['employee_name']; ?>" readonly>
          </div>
        </div>
        <div class="col">
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email" value="<?php echo $row['employee_email']; ?>">
            <span class="error">*<?php echo $emailErr; ?> </span>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <div class="mb-3">
            <label class="form-label">Phone Number</label>
            <input type="phone" class="form-control" name="phone" value="<?php echo $row['employee_phone']; ?>">
            <span class="error">*<?php echo $mobilenoErr; ?> </span>
          </div>
        </div>
        <div class="col">
          <div class="mb-3">
            <label class="form-label">Date Of Birth</label>
            <input type="date" class="form-control" name="dob" value="<?php echo $row['dob']; ?>">
            <span class="error">*<?php echo $dobErr; ?> </span>
          </div>
        </div>
      </div>
      
      <div class="row">
        <div class="form-floating">
          <textarea class="form-control" placeholder="Enter your details from here..." name="details" style="height: 100px"><?php echo $row['employee_details']; ?></textarea>
          <label>Enter your details</label>
        </div>
      </div>
      <div class="row">
        <div class="col justify-content-center">
          <input type="submit" value="Update" name="btn" class="mt-4">
        </div>
      </div>
    </div>
  </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
