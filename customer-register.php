<?php
  include_once 'includes/connection.php';
  session_start();
  if(isset($_SESSION['customer_id'])){
    header("Location: customer-dashboard.php");
    exit();
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="description" content="Create a LexElite customer account to consult with top-rated verified lawyers."/>
  <title>Customer Registration — LexElite</title>

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
      max-width: 550px;
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
        <a href="index.php" class="auth-logo">
          <div class="brand-icon"><i class="fas fa-balance-scale"></i></div>
          <div style="text-align: left;">
            <span class="brand-text-main">LexElite</span>
            <span class="brand-text-sub">Law & Justice</span>
          </div>
        </a>
        <h2 style="font-family:var(--font-serif); font-size:1.6rem; font-weight:700; color:var(--white); margin-top:1rem;">Register Account</h2>
        <p style="font-size:0.85rem; color:var(--text-muted);">Consult with top verified attorneys</p>
      </div>

      <form id="customerRegisterForm" method="POST" enctype="multipart/form-data" onsubmit="return validateCustomerRegister();">
        <!-- Full Name -->
        <div class="form-field-luxury">
          <label for="fullName">Full Name</label>
          <input type="text" name="txt_name" class="luxury-input form-control" id="fullName" placeholder="Jane Smith" required minlength="3" maxlength="50" pattern="^[A-Za-z\s]+$" title="Name must contain only letters and spaces (3-50 characters)" autocomplete="name">
        </div>

        <!-- Email -->
        <div class="form-field-luxury">
          <label for="email">Email Address</label>
          <input type="email" name="txt_email" class="luxury-input form-control" id="email" placeholder="jane@example.com" required maxlength="100" autocomplete="email">
        </div>

        <!-- Phone -->
        <div class="form-field-luxury">
          <label for="phone">Phone Number</label>
          <input type="tel" name="txt_phone" class="luxury-input form-control" id="phone" placeholder="+1 (555) 000-0000" required pattern="^\+?[0-9\s\-\(\)]{10,20}$" title="Please enter a valid phone number (10-20 digits)" autocomplete="tel">
        </div>
        
        <!-- Password -->
        <div class="form-field-luxury">
          <label for="password">Password</label>
          <input type="password" name="txt_password" class="luxury-input form-control" id="password" placeholder="Choose a strong password" required minlength="6" maxlength="50" autocomplete="new-password">
        </div>

        <!-- gender -->
        <div class="form-field-luxury">
          <label for="gender">Gender</label>
          <select name="txt_gender" class="luxury-input form-control" id="gender" required>
            <option value="">Select Gender</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Other</option>
          </select>
        </div>
        <!-- address -->
        <div class="form-field-luxury">
          <label for="address">Address</label>
          <input type="text" name="txt_address" class="luxury-input form-control" id="address" placeholder="Enter your address" required minlength="5" maxlength="250" autocomplete="street-address">
        </div>
        <!-- profile-image -->
        <div class="form-field-luxury">
          <label for="profileImage">Profile Image</label>
          <input type="file" name="txt_profile_image" class="luxury-input form-control" id="profileImage" accept="image/*">
        </div>

        <!-- Agreement Checkbox -->
        <div class="d-flex align-items-start gap-2 mb-4">
          <input type="checkbox" name="txt_agree_terms" id="agreeTerms" style="margin-top:4px; accent-color:var(--gold);" required>
          <label for="agreeTerms" style="font-size:0.75rem; color:var(--text-muted); cursor:pointer;">
            I agree to the <a href="#" style="color:var(--gold); text-decoration:none;">Terms of Service</a> &amp; <a href="#" style="color:var(--gold); text-decoration:none;">Privacy Policy</a>. All client communications on LexElite are fully confidential and protected.
          </label>
        </div>

        <!-- Submit Button -->
        <button type="submit" name="register" class="btn-gold w-100" style="justify-content:center; padding:14px;">
          <i class="fas fa-user-plus me-2"></i>Create Free Account
        </button>
      </form>
    <?php

    include_once 'includes/connection.php';
    if(isset($_POST['register'])){
      $name = isset($_POST['txt_name']) ? trim($_POST['txt_name']) : '';
      $email = isset($_POST['txt_email']) ? trim($_POST['txt_email']) : '';
      $phone = isset($_POST['txt_phone']) ? trim($_POST['txt_phone']) : '';
      $password = isset($_POST['txt_password']) ? $_POST['txt_password'] : '';
      $gender = isset($_POST['txt_gender']) ? trim($_POST['txt_gender']) : '';
      $address = isset($_POST['txt_address']) ? trim($_POST['txt_address']) : '';
      $profile_image = isset($_FILES['txt_profile_image']['name']) ? $_FILES['txt_profile_image']['name'] : '';
      $profile_image_tmp = isset($_FILES['txt_profile_image']['tmp_name']) ? $_FILES['txt_profile_image']['tmp_name'] : '';

      $errors = array();

      if(empty($name) || empty($email) || empty($phone) || empty($password) || empty($gender) || empty($address)){
        $errors[] = "All required fields must be filled.";
      }
      if(!empty($name) && !preg_match("/^[A-Za-z\s]{3,50}$/", $name)){
        $errors[] = "Full Name must contain only letters and spaces (3-50 characters).";
      }
      if(!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors[] = "Invalid email address format.";
      }
      if(!empty($phone) && !preg_match("/^\+?[0-9\s\-\(\)]{10,20}$/", $phone)){
        $errors[] = "Invalid phone number format (10-20 digits).";
      }
      if(!empty($password) && strlen($password) < 6){
        $errors[] = "Password must be at least 6 characters long.";
      }
      if(!empty($address) && strlen($address) < 5){
        $errors[] = "Address must be at least 5 characters long.";
      }

      if(empty($errors)){
        $name_safe = mysqli_real_escape_string($conn, $name);
        $email_safe = mysqli_real_escape_string($conn, $email);
        $phone_safe = mysqli_real_escape_string($conn, $phone);
        $password_safe = mysqli_real_escape_string($conn, $password);
        $gender_safe = mysqli_real_escape_string($conn, $gender);
        $address_safe = mysqli_real_escape_string($conn, $address);
        $profile_image_safe = mysqli_real_escape_string($conn, $profile_image);

        if(!empty($profile_image)){
          move_uploaded_file($profile_image_tmp, "uploads/$profile_image");
        }

        $query = "INSERT INTO `customers`( `full_name`, `email`, `phone`, `password`, `gender`, `address`, `profile_image`, `created_at`) VALUES ('$name_safe','$email_safe','$phone_safe','$password_safe','$gender_safe','$address_safe','$profile_image_safe', NOW())";

        $result = mysqli_query($conn, $query);

        if($result){
           echo "<script>showToast('Registration successful! Redirecting…'); setTimeout(() => { window.location.href = 'customer-login.php'; }, 1500);</script>";
        } else {
           echo "<script>showToast('Registration failed. Please try again.');</script>";
        }
      } else {
        $err_msg = implode("\\n", $errors);
        echo "<script>alert('$err_msg');</script>";
      }
    }
    ?>

      <!-- Switch Screen Link -->
      <div style="font-size:0.85rem; color:var(--text-muted); text-align:center; margin-top:2rem;">
        Already registered? <a href="customer-login.php" style="color:var(--gold); font-weight:600; text-decoration:none;">Sign In here</a>
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

  function validateCustomerRegister() {
    var name = document.getElementById('fullName').value.trim();
    var email = document.getElementById('email').value.trim();
    var phone = document.getElementById('phone').value.trim();
    var password = document.getElementById('password').value;
    var gender = document.getElementById('gender').value;
    var address = document.getElementById('address').value.trim();
    var agreeTerms = document.getElementById('agreeTerms').checked;

    var namePattern = /^[A-Za-z\s]{3,50}$/;
    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    var phonePattern = /^\+?[0-9\s\-\(\)]{10,20}$/;

    if (name === "" || email === "" || phone === "" || password === "" || gender === "" || address === "") {
      alert("Please fill in all required fields.");
      return false;
    }
    if (!agreeTerms) {
      alert("You must agree to the Terms of Service & Privacy Policy.");
      return false;
    }
    if (!namePattern.test(name)) {
      alert("Full Name must contain only letters and spaces (3 to 50 characters).");
      return false;
    }
    if (!emailPattern.test(email)) {
      alert("Please enter a valid email address.");
      return false;
    }
    if (!phonePattern.test(phone)) {
      alert("Please enter a valid phone number (10 to 20 digits).");
      return false;
    }
    if (password.length < 6) {
      alert("Password must be at least 6 characters long.");
      return false;
    }
    if (address.length < 5) {
      alert("Address must be at least 5 characters long.");
      return false;
    }
    return true;
  }
</script>
</body>
</html>
