<?php
include 'includes/config.php';
session_start();

$passerr = "";
$salerr = "";
$alertMessage = '';
$alertType = '';
$row = []; // Initialize the row to avoid warnings

if (!isset($_SESSION['uid'])) {
    header("Location: login.php");
    exit;
}

function input_data($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if employee_id is provided
    if (!empty($_POST['employee_id'])) {
        $employee_id = input_data($_POST['employee_id']);

        // Validate salary
        if (empty($_POST['sal'])) {
            $salerr = "Salary is required";
        } else {
            $sal = input_data($_POST['sal']);
        }

        // Validate password
        if (empty($_POST['password'])) {
            $passerr = "Password is required";
        } else {
            $password = input_data($_POST['password']);
        }

        // Process the form if no errors
        if ($salerr == "" && $passerr == "") {
            // Check database for employee_id, salary, and password
            $query = "SELECT * FROM employees WHERE employee_id = '$employee_id'";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);

            if (!empty($row)) {
                // Success logic (e.g., authentication or data processing)
                echo "Form submitted successfully!";
            } else {
                echo "Employee not found.";
            }
        }
    } else {
        echo "Employee ID is required.";
    }
}

// Function to sanitize user input
/*function input_data($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}*/

if (isset($_POST['btn'])) {
    if ($salerr == "" && $passerr == "" && !empty($row)) {
        $fname = $row['employee_name'];
        $status = 1;
        $user_type_id = $row['user_type_id'];
        $empid = $row['employee_id'];
        $salary = $_POST['sal'];
        $uname = "iam_" . $fname;

        // Insert user and update employee data
        $query = "INSERT INTO users(
            user_type_id, full_name, username, password, status, employee_id, updated_at, created_at
        ) VALUES ($1, $2, $3, $4, $5, $6, NOW(), NOW());";
        $params1 = [$user_type_id, $fname, $uname, $hashedPassword, $status, $empid];

        $query2 = "UPDATE employees SET status = $1, salary = $2 WHERE employee_id = $3;";
        $params2 = [1, $salary, $empid];

        $res = pg_query_params($dbconn, $query, $params1);
        $res2 = pg_query_params($dbconn, $query2, $params2);

        if ($res && $res2) {
            $alertMessage = "Record Updation Successful";
            $alertType = "success";
        } else {
            $alertMessage = "Error occurred during record update!";
            $alertType = "danger";
        }
    } else {
        $alertMessage = "Please fix the errors and try again.";
        $alertType = "danger";
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <style>
    .error { color: #FF0001; }
  </style>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Employee Management System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-info p-2">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Employee Management System</a>
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
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="fname" value="<?= $row['employee_name'] ?? '' ?>">
                    </div>
                </div>
                <div class="col">
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" value="<?= $row['employee_email'] ?? '' ?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="text" class="form-control" name="phone" value="<?= $row['employee_phone'] ?? '' ?>">
                    </div>
                </div>
                <div class="col">
                    <div class="mb-3">
                        <label class="form-label">Date Of Birth</label>
                        <input type="date" class="form-control" name="dob" value="<?= $row['dob'] ?? '' ?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="mb-3">
                        <label class="form-label">Enter Password</label>
                        <input type="password" class="form-control" name="pass" value="<?= $_POST['pass'] ?? '' ?>">
                        <span class="error">* <?= $passerr ?></span>
                    </div>
                </div>
                <div class="col">
                    <div class="mb-3">
                        <label class="form-label">Enter Salary</label>
                        <input type="text" class="form-control" name="sal" value="<?= $_POST['sal'] ?? '' ?>">
                        <span class="error">* <?= $salerr ?></span>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary" name="btn">Submit</button>
        </div>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
