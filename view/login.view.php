<?php 

// Include the necessary files 
include 'theme/head.php'; 

//Check if user is already logged in, then redirect
if (isset($_SESSION['id'])) {
    header('Location: /');
    exit();
}

?>

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
                        <a href="/signin" class="btn btn-md btn-custom">Create Account</a>
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
                        $_SESSION['admin_id'] = $row->admin_id;
                        // Redirect to dashboard after login

                        header('Location: /');
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
