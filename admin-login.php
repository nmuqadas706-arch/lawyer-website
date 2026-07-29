<?php
session_start();
include 'includes/connection.php';

$error = "";

if(isset($_POST['login'])){

    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if(empty($email) || empty($password)){
        $error = "Please fill in all required fields.";
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error = "Please enter a valid email address.";
    } elseif(strlen($password) < 6){
        $error = "Password must be at least 6 characters long.";
    } else {
        $email_safe = mysqli_real_escape_string($conn, $email);
        $password_safe = mysqli_real_escape_string($conn, $password);

        $query = mysqli_query($conn, "SELECT * FROM admins WHERE email='$email_safe' AND password='$password_safe'");

        if($query && mysqli_num_rows($query) > 0){
            $row = mysqli_fetch_assoc($query);

            $_SESSION['admin_id'] = $row['admin_id'];
            $_SESSION['admin_name'] = $row['name'];

            header("Location: admin.php");
            exit();
        } else {
            $error = "Invalid Email or Password!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Font Awesome 6 -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
<style>
body{
    background:linear-gradient(135deg,#050816,#0d1b3e,#122b5c);
    font-family:'Poppins',sans-serif;
}

.auth-card{

    width:430px;

    background:rgba(255,255,255,.05);

    backdrop-filter:blur(20px);

    border:1px solid rgba(212,175,55,.25);

    border-radius:20px;

    padding:40px;

    box-shadow:0 20px 50px rgba(0,0,0,.5);

}

.admin-icon{

    width:90px;

    height:90px;

    margin:auto;

    border-radius:50%;

    background:linear-gradient(135deg,#d4af37,#f4d03f);

    display:flex;

    justify-content:center;

    align-items:center;

    font-size:35px;

    color:#0d1b3e;

    margin-bottom:20px;

}

.login-title{

    color:#fff;

    font-weight:700;

    margin-bottom:8px;

}

.login-subtitle{

    color:#cfcfcf;

    font-size:14px;

}

.form-label{

    color:#d4af37;

    font-weight:600;

}

.luxury-input{

    border:1px solid rgba(212,175,55,.3);

    border-radius:12px;

    overflow:hidden;

}

.luxury-input .input-group-text{

    background:transparent;

    color:#d4af37;

    border:none;

}

.luxury-input .form-control{

    background:transparent;

    color:#fff;

    border:none;

    box-shadow:none;

}

.luxury-input .form-control::placeholder{

    color:#999;

}

.login-btn{

    background:linear-gradient(135deg,#d4af37,#f4d03f);

    color:#0d1b3e;

    font-weight:700;

    padding:13px;

    border:none;

    border-radius:12px;

    transition:.4s;

}

.login-btn:hover{

    transform:translateY(-3px);

    box-shadow:0 10px 25px rgba(212,175,55,.4);

}


</style>
</head>

<body>

<div class="login-box">

<div class="container d-flex justify-content-center align-items-center min-vh-100">

    <div class="auth-card">

        <div class="text-center mb-4">

            <div class="admin-icon">
                <i class="fas fa-user-shield"></i>
            </div>

            <h2 class="login-title">Admin Portal</h2>

            <p class="login-subtitle">
                Secure Administrator Login
            </p>

        </div>

        <?php
        if(!empty($error)){
            echo "<div class='alert alert-danger'>$error</div>";
        }
        ?>

        <form id="adminLoginForm" method="POST" onsubmit="return validateAdminLogin();">

            <div class="mb-4">

                <label class="form-label">Email Address</label>

                <div class="input-group luxury-input">

                    <span class="input-group-text">
                        <i class="fas fa-envelope"></i>
                    </span>

                    <input
                        type="email"
                        name="email"
                        id="adminEmail"
                        class="form-control"
                        placeholder="Enter your email"
                        required
                        maxlength="100"
                        autocomplete="email">

                </div>

            </div>

            <div class="mb-4">

                <label class="form-label">Password</label>

                <div class="input-group luxury-input">

                    <span class="input-group-text">
                        <i class="fas fa-lock"></i>
                    </span>

                    <input
                        type="password"
                        name="password"
                        id="adminPassword"
                        class="form-control"
                        placeholder="Enter password"
                        required
                        minlength="6"
                        maxlength="50"
                        autocomplete="current-password">

                </div>

            </div>

            <button class="btn login-btn w-100" name="login">

                <i class="fas fa-sign-in-alt me-2"></i>

                Admin Login

            </button>

        </form>

    </div>

</div>
</div>

<script>
function validateAdminLogin() {
    var email = document.getElementById('adminEmail').value.trim();
    var password = document.getElementById('adminPassword').value;
    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (email === "" || password === "") {
        alert("Please fill in both Email and Password fields.");
        return false;
    }
    if (!emailPattern.test(email)) {
        alert("Please enter a valid email address.");
        return false;
    }
    if (password.length < 6) {
        alert("Password must be at least 6 characters long.");
        return false;
    }
    return true;
}
</script>
</body>
</html>
