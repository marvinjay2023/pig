<?php 
session_start(); // Start session to store user data

// Include the necessary files
include 'setting/system.php'; 
include 'theme/head.php'; 

// Check if user is already logged in, then redirect
if (isset($_SESSION['id'])) {
    header('Location: dashboard.php');
    exit();
}

?>

<!-- Include Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
    body {
        background-image: url('img/baboy.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }

    .btn-container {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
    }

    .btn-custom {
        background-color: blue;
        color: white;
        width: 48%;
    }

    .login-box {
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .password-container {
        position: relative;
    }

    .password-container input[type="password"], 
    .password-container input[type="text"] {
        padding-right: 30px;
    }

    .toggle-password {
        position: absolute;
        right: 10px;
        top: 71%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #888;
        font-size: 1.2em;
    }

    .header-box {
        background-color: rgba(255, 255, 255, 0.8);
        padding: 20px;
        border-radius: 15px;
        text-align: center;
        margin-bottom: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .header-box h2 {
        font-size: 1.8em;
        font-weight: bold;
        margin: 0;
        color: #333;
    }
</style>

<div class="container">
    <div class="row" style="margin-top: 10%">
        <div class="col-md-2 col-md-offset-2"></div>
        <div class="col-md-4">
            <!-- Add a header box with text -->
            <div class="header-box">
                <h2>Pig Farming</h2>
            </div>
            
            <div class="login-box">
                <form method="post" autocomplete="off">
                    <div class="form-group">
                        <label class="control-label">Username</label>
                        <input type="text" name="username" class="form-control input-sm" required>
                    </div>
                    <div class="form-group password-container">
                        <label class="control-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control input-sm" required>
                        <span class="toggle-password" onclick="togglePassword()">
                            <i class="fas fa-eye" id="eye-icon"></i>
                        </span>
                    </div>
                    <div class="btn-container">
                        <button name="submit" type="submit" class="btn btn-md btn-custom">Log in</button>
                        <a href="signin.php" class="btn btn-md btn-custom">Create Account</a>
                    </div>
                    <br>
                </form>

                <?php
                if (isset($_POST['submit'])) {
                    // Fetching form data
                    $username = trim($_POST['username']);
                    $password = $_POST['password'];
                    $hash = sha1($password);

                    // SQL query to check for the user
                    $q = $db->query("SELECT * FROM admin WHERE username = '$username' AND password = '$hash' LIMIT 1");
                    $count = $q->rowCount();
                    $rows = $q->fetchAll(PDO::FETCH_OBJ);

                    if ($count > 0) {
                        $row = $rows[0]; // Get the first result
                        // Store user data in session
                        $_SESSION['id'] = $row->id;
                        $_SESSION['user'] = $row->username;

                        // Redirect to dashboard after login
                        header('Location: dashboard.php');
                        exit(); // Ensure no further code executes after the redirect
                    } else {
                        $error = 'Incorrect login details';
                    }
                }

                if (isset($error)) { ?>
                    <br><br>
                    <div class="alert alert-danger alert-dismissable">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong><?php echo $error; ?>.</strong>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword() {
    var passwordInput = document.getElementById("password");
    var eyeIcon = document.getElementById("eye-icon");
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        eyeIcon.classList.add("fa-eye");
        eyeIcon.classList.remove("fa-eye-slash");
    } else {
        passwordInput.type = "password";
        eyeIcon.classList.add("fa-eye-slash");
        eyeIcon.classList.remove("fa-eye");
    }
}
</script>

<?php include 'theme/foot.php'; ?>
