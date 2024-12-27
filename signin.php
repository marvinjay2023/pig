<?php 
// Start session to store user data
session_start(); 

include 'setting/system.php';
include 'theme/head.php'; 
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

    .signup-box {
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .toggle-password {
        position: absolute;
        right: 10px;
        top: 71%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #888;
        font-size: 1.2em; /* Adjusts the icon size */
    }
</style>

<div class="container">
    <div class="row" style="margin-top: 10%">

        <h1 class="text-center">Sign Up</h1><br>
        <div class="col-md-4 col-md-offset-4">
            <div class="signup-box">
                <form method="post" autocomplete="off">

                    <div class="form-group">
                        <label class="control-label">Username</label>
                        <input type="text" name="username" class="form-control input-sm" required>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Email Address</label>
                        <input type="email" name="email" class="form-control input-sm" required>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Password</label>
                        <input type="password" name="password" class="form-control input-sm" required>
                    </div>

                    <div class="btn-container">
                        <button name="submit" type="submit" class="btn btn-md btn-custom">Sign Up</button>
                    </div>

                    <br>
                    <label class="control-label">Already have an account?<a href="index.php"> Login</a></label>

                </form>

                <?php
                if (isset($_POST['submit'])) {
                    $username = trim($_POST['username']);
                    $email = trim($_POST['email']);
                    $password = $_POST['password'];
                    $hash = sha1($password);

                    // Check if username or email already exists
                    $check = $db->query("SELECT * FROM admin WHERE username = '$username' OR email = '$email'");
                    if ($check->rowCount() > 0) {
                        $error = 'Username or Email already exists';
                    } else {
                        // Insert the new user into the database
                        $stmt = $db->prepare("INSERT INTO admin (username, email, password) VALUES (?, ?, ?)");
                        $stmt->execute([$username, $email, $hash]);

                        // After successful registration, redirect to dashboard
                        header('location:index.php');
                        exit();
                    }
                }

                if (isset($error)) { ?>
                    <br><br>
                    <div class="alert alert-danger alert-dismissable">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong><?php echo $error; ?>.</strong>
                    </div>
                <?php }
                ?>
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