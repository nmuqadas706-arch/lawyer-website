<?php
  include_once 'includes/connection.php';
  session_start();
  
  if(isset($_SESSION['customer_id'])){
    header("Location: customer-dashboard.php");
    exit();
  }

  if(isset($_POST['login'])) {
      $email = $_POST['txt_email'];
      $password = $_POST['txt_password'];

      $query = "SELECT * FROM customers WHERE email='$email' AND password='$password'";
      $result = mysqli_query($conn, $query);

      if(mysqli_num_rows($result) > 0) {
          $row = mysqli_fetch_assoc($result);
          $_SESSION['customer_id'] = $row['customer_id'];
          $_SESSION['customer_name'] = $row['full_name'];
          header("Location: customer-dashboard.php");
          exit();
      } else {
          $login_error = "Invalid email or password.";
      }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="description" content="Sign in to your LexElite customer account to manage your consultations, messages, and case details."/>
  <title>Customer Login — LexElite</title>

  <!-- Bootstrap 5 CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"/>
  <!-- Font Awesome 6 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
  <!-- AOS – Animate on Scroll -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css"/>
  <!-- Luxury CSS -->
  <link rel="stylesheet" href="css/luxury.css"/>

  <style>
    body {
      background: linear-gradient(135deg, var(--black) 0%, var(--navy) 50%, var(--navy-mid) 100%);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      position: relative;
    }
    .auth-container {
      padding: 4rem 0;
      position: relative;
      z-index: 2;
    }
    .auth-card-luxury {
      background: rgba(255, 255, 255, 0.03);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border: 1px solid rgba(201, 168, 76, 0.2);
      border-radius: var(--radius-lg);
      overflow: hidden;
      box-shadow: var(--glass-shadow), var(--shadow-gold);
      max-width: 500px;
      margin: 0 auto;
      padding: 3rem;
    }
    .auth-header {
      text-align: center;
      margin-bottom: 2rem;
    }
    .auth-logo {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 1.5rem;
      text-decoration: none;
    }
    .auth-logo .brand-icon {
      width: 40px;
      height: 40px;
      background: var(--gold-gradient);
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.1rem;
      color: var(--dark);
    }
    .auth-logo .brand-text-main {
      font-family: var(--font-serif);
      font-size: 1.5rem;
      font-weight: 700;
      color: var(--white);
      line-height: 1;
    }
    .auth-logo .brand-text-sub {
      font-family: var(--font-sans);
      font-size: 0.6rem;
      font-weight: 500;
      letter-spacing: 0.3em;
      text-transform: uppercase;
      color: var(--gold);
      display: block;
    }
    .social-login-btn {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      padding: 12px;
      background: rgba(255, 255, 255, 0.04);
      border: 1.5px solid rgba(201, 168, 76, 0.2);
      border-radius: 6px;
      color: var(--white);
      font-size: 0.85rem;
      font-weight: 600;
      transition: var(--transition);
      cursor: pointer;
    }
    .social-login-btn:hover {
      background: rgba(201, 168, 76, 0.1);
      border-color: var(--gold);
    }
  </style>
</head>
<body>

<!-- Back to Home Link -->
<a href="index.php" style="position:fixed; top:24px; left:24px; z-index:1000; display:inline-flex; align-items:center; gap:8px; color:rgba(255,255,255,0.7); font-size:0.8rem; text-transform:uppercase; letter-spacing:0.1em; font-weight:600; text-decoration:none; transition:var(--transition);" onmouseover="this.style.color='var(--gold)'" onmouseout="this.style.color='rgba(255,255,255,0.7)'">
  <i class="fas fa-arrow-left"></i> Back to Home
</a>

<div class="auth-container">
  <div class="hero-bg-pattern"></div>
  <div class="container">
    <div class="auth-card-luxury" data-reveal="fade">
      
      <!-- Brand Logo -->
      <div class="auth-header">
        <a href="index.html" class="auth-logo">
          <div class="brand-icon"><i class="fas fa-balance-scale"></i></div>
          <div style="text-align: left;">
            <span class="brand-text-main">LexElite</span>
            <span class="brand-text-sub">Law & Justice</span>
          </div>
        </a>
        <h2 style="font-family:var(--font-serif); font-size:1.6rem; font-weight:700; color:var(--white); margin-top:1rem;">Welcome Back</h2>
        <p style="font-size:0.85rem; color:var(--text-muted);">Sign in to your client account</p>
      </div>

      <form method="POST" action="">
        <!-- Email -->
        <div class="form-field-luxury">
          <label for="email">Email Address</label>
          <input type="email" name="txt_email" class="luxury-input form-control" id="email" placeholder="your@email.com" required autocomplete="email">
        </div>
        
        <!-- Password -->
        <div class="form-field-luxury">
          <div class="d-flex justify-content-between align-items-center mb-1">
            <label for="password" style="margin-bottom:0;">Password</label>
            <a href="#" class="text-decoration-none" style="font-size:0.72rem; color:var(--gold); font-weight:600;" onclick="showToast('Password reset link sent to your email.'); return false;">Forgot Password?</a>
          </div>
          <input type="password" name="txt_password" class="luxury-input form-control" id="password" placeholder="Enter your password" required autocomplete="current-password">
        </div>

        <!-- Remember Me -->
        <div class="d-flex align-items-center gap-2 mb-4">
          <input type="checkbox" id="rememberMe" style="accent-color:var(--gold);">
          <label for="rememberMe" style="font-size:0.8rem; color:var(--text-muted); cursor:pointer;">Remember me on this device</label>
        </div>

        <!-- Submit Button -->
        <button type="submit" name="login" class="btn-gold w-100" style="justify-content:center; padding:14px;">
          <i class="fas fa-sign-in-alt me-2"></i>Sign In
        </button>
        <?php
        if(isset($login_error)) {
            echo "<div class='alert alert-danger mt-3'>$login_error</div>";
        }
        ?>

        <!-- Divider -->
        <div style="text-align:center; margin:1.5rem 0; font-size:0.7rem; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.1em;">
          <span>or sign in with</span>
        </div>

        <!-- Social logins -->
        <div class="row g-2">
          <div class="col-6">
            <button type="button" class="social-login-btn w-100">
              <i class="fab fa-google" style="color:#EA4335;"></i> Google
            </button>
          </div>
          <div class="col-6">
            <button type="button" class="social-login-btn w-100">
              <i class="fab fa-apple"></i> Apple ID
            </button>
          </div>
        </div>
      </form>

      <!-- Switch Screen Link -->
      <div style="font-size:0.85rem; color:var(--text-muted); text-align:center; margin-top:2rem;">
        New to LexElite? <a href="customer-register.php" style="color:var(--gold); font-weight:600; text-decoration:none;">Create an account</a>
      </div>
      <div style="text-align:center; margin-top:1rem; font-size:0.8rem;">
        Are you an attorney? <a href="lawyer-login.php" style="color:var(--white); font-weight:700; text-decoration:none;">Attorney Portal <i class="fas fa-arrow-right"></i></a>
      </div>

    </div>
  </div>
</div>

<!-- Toast notification -->
<div id="toastBox" style="position:fixed; bottom:30px; left:50%; transform:translateX(-50%); z-index:9999; display:none;">
  <div style="background:var(--gold-gradient); color:var(--dark); font-weight:700; padding:12px 24px; border-radius:50px; font-size:0.85rem; box-shadow:0 8px 24px rgba(201,168,76,0.4);">
    <i class="fas fa-check-circle me-2"></i><span id="toastMsg">Action complete!</span>
  </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  function showToast(msg) {
    $('#toastMsg').text(msg);
    $('#toastBox').fadeIn(300);
    setTimeout(() => $('#toastBox').fadeOut(400), 2500);
  }

  function handleLogin(e) {
    e.preventDefault();
    showToast('Signed in successfully! Redirecting…');
    setTimeout(() => {
      window.location.href = 'customer-dashboard.php';
    }, 1500);
  }
</script>
</body>
</html>
