<?php

require_once "config.php";

// Define variables and initialize with empty values
$username = $password = $confirm_password = $email = "";
$username_err = $password_err = $confirm_password_err = $email_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Validate username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Username cannot be blank";
    } else {
        $sql = "SELECT id FROM user WHERE username = ?";
        $stmt = mysqli_prepare($con, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = trim($_POST["username"]);

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $username_err = "This username is already taken";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($stmt);
        }
    }

    // Validate password
    if (empty($_POST["password"])) {
        $password_err = "Password cannot be blank";
    } elseif (strlen(trim($_POST["password"])) < 8) {
        $password_err = "Password cannot be less than 8 characters";
    } elseif (!preg_match("/[a-z]/", $_POST["password"]) || !preg_match("/[A-Z]/", $_POST["password"]) || !preg_match("/[0-9]/", $_POST["password"]) || !preg_match("/[!@#$%^&*(),.?\":{}|<>]/", $_POST["password"])) {
        $password_err = "Password must include at least one lowercase letter, one uppercase letter, one digit, and one special character";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if ($_POST["password"] != $_POST["confirm_password"]) {
        $confirm_password_err = "Passwords should match";
    }

    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Email cannot be blank";
    } else {
        $email = trim($_POST["email"]);
    }

    // Check for errors before inserting into the database
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($email_err)) {
        $sql = "INSERT INTO user (username, email, password) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($con, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_email, $param_password);
            $param_username = $username;
            $param_email = $email;
            $param_password = $password;

            if (mysqli_stmt_execute($stmt)) {
                header("location: login.php");
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }

    mysqli_close($con);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Login and Signup Forms</title>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .form-container {
            max-width: 400px;
            margin: auto;
            margin-top: 50px;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="card">
        <!-- Signup Form -->
        <div class="col-md-6 form-container p-4">
            <h2 class="text-center mb-4">Signup</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <!-- Adjust the input fields according to your needs -->
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" class="form-control" name="username" placeholder="Enter your username" value="<?php echo $username; ?>">
                    <span style="color: red;"><?php echo $username_err; ?></span>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email" placeholder="Enter your email" value="<?php echo $email; ?>">
                    <span style="color: red;"><?php echo $email_err; ?></span>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" name="password" placeholder="Choose a password">
                    <span style="color: red;"><?php echo $password_err; ?></span>
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" name="confirm_password" class="form-control" placeholder="Re-enter your password">
                    <span style="color: red;"><?php echo $confirm_password_err; ?></span>
                </div>

                <button type="submit" class="btn btn-success btn-block">Signup</button>
            </form>
            <p class="text-center mt-3">Already a user? <a href="login.php">Login here</a></p>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
