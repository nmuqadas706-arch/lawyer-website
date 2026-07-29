<?php
include_once 'includes/connection.php';
$services_query = mysqli_query($conn, "SELECT service_name, fee FROM services ORDER BY service_name ASC");
$services_options = "";
$services_js_map = [];
while ($row = mysqli_fetch_assoc($services_query)) {
    $s_name = htmlspecialchars($row['service_name']);
    $s_fee = (int)$row['fee'];
    $services_options .= "<option value=\"$s_name\" data-fee=\"$s_fee\">$s_name</option>";
    $services_js_map[$s_name] = $s_fee;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="description" content="Submit your professional registration to join the LexElite attorney network. All submissions undergo bar license verification."/>
  <title>Lawyer Registration — LexElite</title>

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
      max-width: 750px;
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
    .photo-upload-zone {
      border: 1.5px dashed rgba(201, 168, 76, 0.3);
      border-radius: 8px;
      padding: 1.5rem;
      text-align: center;
      cursor: pointer;
      transition: var(--transition);
      margin-bottom: 1rem;
      background: rgba(255, 255, 255, 0.01);
    }
    .photo-upload-zone:hover {
      border-color: var(--gold);
      background: rgba(201, 168, 76, 0.05);
    }
    .photo-preview-wrap {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      border: 2px solid var(--gold);
      margin: 0 auto 10px;
      overflow: hidden;
      display: none;
    }
    .photo-preview-wrap img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    
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
        <h2 style="font-family:var(--font-serif); font-size:1.6rem; font-weight:700; color:var(--white); margin-top:1rem;">Join the Network</h2>
        <p style="font-size:0.85rem; color:var(--text-muted);">Apply as an Attorney on LexElite</p>
      </div>

      <form id="lawyerRegisterForm" method="POST" enctype="multipart/form-data" onsubmit="return validateLawyerRegister();">
        
        <!-- Profile Picture Upload Zone -->
        <div class="photo-upload-zone" onclick="document.getElementById('photoInput').click()">

    <div class="photo-preview-wrap" id="previewWrap">
        <img id="photoPreview" src="" alt="Preview">
    </div>

    <div id="uploadInstructions">
        <i class="fas fa-camera" style="font-size:1.5rem;color:var(--gold);display:block;margin-bottom:8px;"></i>
        <span style="font-size:0.8rem;color:white;">Upload Profile Picture</span>
    </div>

</div>

<input
    type="file"
    id="photoInput"
    name="txt_profile_picture"
    accept="image/*"
    style="display:none;"
    onchange="previewImage(this)"
    required>

        <div class="row g-3">
          <!-- Full Name -->
          <div class="col-md-6">
            <div class="form-field-luxury">
              <label for="fullName">Full Name</label>
              <input type="text" class="luxury-input form-control" name="txt_name" id="fullName" placeholder="enter your full name" required minlength="3" maxlength="50" pattern="^[A-Za-z\s]+$" title="Name must contain only letters and spaces (3-50 characters)">
            </div>
          </div>

          <!-- Email -->
          <div class="col-md-6">
            <div class="form-field-luxury">
              <label for="email">Email Address</label>
              <input type="email" class="luxury-input form-control" name="txt_email" id="email" placeholder="enter your email" required maxlength="100" autocomplete="email">
            </div>
          </div>

          <!-- Phone -->
          <div class="col-md-6">
            <div class="form-field-luxury">
              <label for="phone">Phone Number</label>
              <input type="tel" class="luxury-input form-control" name="txt_phone" id="phone" placeholder="***********" required pattern="^\+?[0-9\s\-\(\)]{10,20}$" title="Please enter a valid phone number (10-20 digits)" autocomplete="tel">
            </div>
          </div>

          <!-- Password -->
          <div class="col-md-6">
            <div class="form-field-luxury">
              <label for="password">Password</label>
              <input type="password" class="luxury-input form-control" name="txt_password" id="password" placeholder="Create safe password" required minlength="6" maxlength="50" autocomplete="new-password">
            </div>
          </div>

          <!-- Qualification -->
          <div class="col-md-6">
            <div class="form-field-luxury">
              <label for="qualification">Qualification / Law Degree</label>
              <input type="text" class="luxury-input form-control" name="txt_qualification" id="qualification" placeholder="e.g. J.D., Harvard Law School" required minlength="2" maxlength="100">
            </div>
          </div>

          <!-- Experience -->
          <div class="col-md-6">
            <div class="form-field-luxury">
              <label for="experience">Years of Experience</label>
              <input type="number" class="luxury-input form-control" name="txt_experience" id="experience" placeholder="e.g. 15" min="1" max="60" required>
            </div>
          </div>

          <!-- CNIC Number -->
          <div class="col-md-6">
            <div class="form-field-luxury">
              <label for="cnic">CNIC Number</label>
              <input type="text" class="luxury-input form-control" id="cnic" placeholder="e.g. 12345-6789012-3" required name="txt_cnic" pattern="\d{5}-\d{7}-\d{1}" title="Format: 12345-6789012-3">
            </div>
          </div>
         

          <!-- Specialization -->
          <div class="col-md-6">
            <div class="form-field-luxury">
              <label for="specialization">Specialization</label>
              <select class="luxury-input form-control" name="txt_specialization" id="specialization" required style="background-color:var(--dark-card);" onchange="updateFee()">
                <option value="">Select practice area...</option>
                <?php echo $services_options; ?>
              </select>
            </div>
          </div>

          <!-- Consultation Fee -->
          <div class="col-md-6">
            <div class="form-field-luxury">
              <label for="consultationFee">Consultation Fee (PKR)</label>
              <input type="number" class="luxury-input form-control" name="txt_consultation_fee" id="consultationFee" placeholder="Auto-filled based on service" min="50" max="1000000" required style="background-color:rgba(255,255,255,0.05);">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-field-luxury">
              <label for="bio">BIO</label>
              <input type="text" class="luxury-input form-control" name="txt_bio" id="bio" placeholder="Brief professional summary" required minlength="10" maxlength="500">
            </div>
          </div>

          <!-- City -->
          <div class="col-md-12">
            <div class="form-field-luxury">
              <label for="city">City / State</label>
              <input type="text" class="luxury-input form-control" name="txt_city" id="city" placeholder="e.g. New York, NY" required minlength="2" maxlength="50">
            </div>
          </div>

          <!-- Office Address -->
          <div class="col-12">
            <div class="form-field-luxury">
              <label for="officeAddress">Office Address</label>
              <input type="text" class="luxury-input form-control" name="txt_office_address" id="officeAddress" placeholder="e.g. 350 Fifth Avenue, Suite 4100" required minlength="5" maxlength="250">
            </div>
            
          </div>

          <!-- Agreement Checkbox -->
          <div class="col-12 mb-3">
            <div class="d-flex align-items-start gap-2">
              <input type="checkbox" id="agreeTerms" style="margin-top:4px; accent-color:var(--gold);" required name="agree_terms">
              <label for="agreeTerms" style="font-size:0.75rem; color:var(--text-muted); cursor:pointer;">
                I certify that all credentials, bar certificates, and educational records are completely true. I agree to the <a href="#" style="color:var(--gold); text-decoration:none;">Attorney Agreement</a> and authorize LexElite to verify my status with the Bar Council.
              </label>
            </div>
          </div>
        </div>

        <!-- Submit Button -->
        <button type="submit" name="btn_register" class="btn-gold w-100" style="justify-content:center; padding:14px;">
          <i class="fas fa-paper-plane me-2"></i>Submit Application
        </button>
      </form>
      <!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg rounded-4" style="background:var(--navy-mid); border: 1px solid var(--gold) !important;">
      
      <div class="modal-header border-0" style="padding-bottom:0;">
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body text-center p-5 pt-2">
        <div class="mb-4">
          <div style="width:90px;height:90px;background:var(--gold-gradient);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:auto;">
            <i class="fas fa-check" style="font-size:40px;color:var(--dark);"></i>
          </div>
        </div>

        <h3 class="fw-bold mb-2" style="color:var(--white);">Application Submitted!</h3>

        <p style="color:var(--text-muted); font-size:0.9rem; margin-bottom:2rem;">
          Your lawyer registration has been submitted successfully.
          Please wait for admin approval before you can access the dashboard.
        </p>

        <button class="btn-gold px-4 rounded-pill" onclick="window.location='lawyer-login.php'">
          Go to Login
        </button>

      </div>
    </div>
  </div>
</div>
      <?php
      include_once 'includes/connection.php';

      if(isset($_POST['btn_register'])) {
         $name = isset($_POST['txt_name']) ? trim($_POST['txt_name']) : '';
         $email = isset($_POST['txt_email']) ? trim($_POST['txt_email']) : '';
         $phone = isset($_POST['txt_phone']) ? trim($_POST['txt_phone']) : '';
         $password = isset($_POST['txt_password']) ? $_POST['txt_password'] : '';
         $qualification = isset($_POST['txt_qualification']) ? trim($_POST['txt_qualification']) : '';
         $experience = isset($_POST['txt_experience']) ? trim($_POST['txt_experience']) : '';
         $cnic = isset($_POST['txt_cnic']) ? trim($_POST['txt_cnic']) : '';
         $bio = isset($_POST['txt_bio']) ? trim($_POST['txt_bio']) : '';
         $specialization = isset($_POST['txt_specialization']) ? trim($_POST['txt_specialization']) : '';
         $consultation_fee = isset($_POST['txt_consultation_fee']) ? trim($_POST['txt_consultation_fee']) : '';
         $city = isset($_POST['txt_city']) ? trim($_POST['txt_city']) : '';
         $office_address = isset($_POST['txt_office_address']) ? trim($_POST['txt_office_address']) : '';
         $profile_image = isset($_FILES['txt_profile_picture']['name']) ? $_FILES['txt_profile_picture']['name'] : '';
         $profile_image_tmp = isset($_FILES['txt_profile_picture']['tmp_name']) ? $_FILES['txt_profile_picture']['tmp_name'] : '';

         $errors = array();

         if(empty($name) || empty($email) || empty($phone) || empty($password) || empty($qualification) || empty($experience) || empty($cnic) || empty($bio) || empty($specialization) || empty($consultation_fee) || empty($city) || empty($office_address)){
           $errors[] = "All required fields must be filled.";
         }
         if(!empty($name) && !preg_match("/^[A-Za-z\s]{3,50}$/", $name)){
           $errors[] = "Full Name must contain only letters and spaces (3-50 characters).";
         }
         if(!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)){
           $errors[] = "Invalid email address format.";
         }
         if(!empty($phone) && !preg_match("/^\+?[0-9\s\-\(\)]{10,20}$/", $phone)){
           $errors[] = "Invalid phone number format.";
         }
         if(!empty($password) && strlen($password) < 6){
           $errors[] = "Password must be at least 6 characters long.";
         }
         if(!empty($cnic) && !preg_match("/^\d{5}-\d{7}-\d{1}$/", $cnic)){
           $errors[] = "CNIC must follow the pattern 12345-6789012-3.";
         }
         if(!empty($experience) && (!is_numeric($experience) || $experience < 1)){
           $errors[] = "Years of Experience must be a positive number.";
         }
         if(!empty($consultation_fee) && (!is_numeric($consultation_fee) || $consultation_fee < 50)){
           $errors[] = "Consultation Fee must be at least 50.";
         }
         if(!empty($bio) && strlen($bio) < 10){
           $errors[] = "BIO must be at least 10 characters long.";
         }

         if(empty($errors)){
           $name_safe = mysqli_real_escape_string($conn, $name);
           $email_safe = mysqli_real_escape_string($conn, $email);
           $phone_safe = mysqli_real_escape_string($conn, $phone);
           $password_safe = mysqli_real_escape_string($conn, $password);
           $qualification_safe = mysqli_real_escape_string($conn, $qualification);
           $experience_safe = mysqli_real_escape_string($conn, $experience);
           $cnic_safe = mysqli_real_escape_string($conn, $cnic);
           $bio_safe = mysqli_real_escape_string($conn, $bio);
           $specialization_safe = mysqli_real_escape_string($conn, $specialization);
           $consultation_fee_safe = mysqli_real_escape_string($conn, $consultation_fee);
           $city_safe = mysqli_real_escape_string($conn, $city);
           $office_address_safe = mysqli_real_escape_string($conn, $office_address);
           $profile_image_safe = mysqli_real_escape_string($conn, $profile_image);

           if(!empty($profile_image)){
             move_uploaded_file($profile_image_tmp, "uploads/$profile_image");
           }

           $data = "INSERT INTO `lawyers`(`full_name`, `email`, `phone`, `password`, `specialization`, `qualification`, `experience`, `city`, `address`, `cnic_no`, `bio`, `consultation_fee`, `profile_image`, `status`, `created_at`) VALUES ('$name_safe','$email_safe','$phone_safe','$password_safe','$specialization_safe','$qualification_safe','$experience_safe','$city_safe','$office_address_safe','$cnic_safe','$bio_safe','$consultation_fee_safe','$profile_image_safe','Pending',NOW())";

           $result = mysqli_query($conn, $data);

           if($result){
              echo "<script>
              window.onload=function(){
                  var myModal = new bootstrap.Modal(document.getElementById('successModal'));
                  myModal.show();
              }
              </script>";
           } else {
              echo "<script>alert('Something went wrong!');</script>";
           }
         } else {
           $err_msg = implode("\\n", $errors);
           echo "<script>alert('$err_msg');</script>";
         }
      }
      ?>

      <!-- Switch Screen Link -->
      <div style="font-size:0.85rem; color:var(--text-muted); text-align:center; margin-top:2rem;">
        Already registered? <a href="lawyer-login.php" style="color:var(--gold); font-weight:600; text-decoration:none;">Sign In here</a>
      </div>

    </div>
  </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>

  function previewImage(input) {
    if (input.files && input.files[0]) {
      const reader = new FileReader();
      reader.onload = function(e) {
        $('#photoPreview').attr('src', e.target.result);
        $('#previewWrap').show();
        $('#uploadInstructions').hide();
      }
      reader.readAsDataURL(input.files[0]);
    }
  }

  function updateFee() {
    var select = document.getElementById('specialization');
    var feeInput = document.getElementById('consultationFee');
    if (select.selectedIndex > 0) {
      var fee = select.options[select.selectedIndex].getAttribute('data-fee');
      feeInput.value = fee;
    } else {
      feeInput.value = '';
    }
  }

  function validateLawyerRegister() {
    var photoInput = document.getElementById('photoInput');
    var fullName = document.getElementById('fullName').value.trim();
    var email = document.getElementById('email').value.trim();
    var phone = document.getElementById('phone').value.trim();
    var password = document.getElementById('password').value;
    var qualification = document.getElementById('qualification').value.trim();
    var experience = document.getElementById('experience').value.trim();
    var cnic = document.getElementById('cnic').value.trim();
    var specialization = document.getElementById('specialization').value;
    var fee = document.getElementById('consultationFee').value.trim();
    var bio = document.getElementById('bio').value.trim();
    var city = document.getElementById('city').value.trim();
    var officeAddress = document.getElementById('officeAddress').value.trim();
    var agreeTerms = document.getElementById('agreeTerms').checked;

    var namePattern = /^[A-Za-z\s]{3,50}$/;
    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    var phonePattern = /^\+?[0-9\s\-\(\)]{10,20}$/;
    var cnicPattern = /^\d{5}-\d{7}-\d{1}$/;

    if (!photoInput.files || photoInput.files.length === 0) {
      alert("Please upload a profile picture.");
      return false;
    }
    if (fullName === "" || email === "" || phone === "" || password === "" || qualification === "" || experience === "" || cnic === "" || specialization === "" || fee === "" || bio === "" || city === "" || officeAddress === "") {
      alert("Please fill in all required fields.");
      return false;
    }
    if (!agreeTerms) {
      alert("You must agree to the Attorney Agreement terms.");
      return false;
    }
    if (!namePattern.test(fullName)) {
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
    if (qualification.length < 2) {
      alert("Qualification must be at least 2 characters.");
      return false;
    }
    if (isNaN(experience) || parseInt(experience) < 1) {
      alert("Please enter valid years of experience (at least 1 year).");
      return false;
    }
    if (!cnicPattern.test(cnic)) {
      alert("CNIC must follow the pattern 12345-6789012-3.");
      return false;
    }
    if (isNaN(fee) || parseFloat(fee) < 50) {
      alert("Consultation Fee must be at least 50.");
      return false;
    }
    if (bio.length < 10) {
      alert("BIO must be at least 10 characters long.");
      return false;
    }
    if (city.length < 2) {
      alert("City / State must be at least 2 characters.");
      return false;
    }
    if (officeAddress.length < 5) {
      alert("Office address must be at least 5 characters long.");
      return false;
    }
    return true;
  }
</script>


      





      <!-- Switch Screen Link -->
      <div style="font-size:0.85rem; color:var(--text-muted); text-align:center; margin-top:2rem;">
        Already registered? <a href="lawyer-login.php" style="color:var(--gold); font-weight:600; text-decoration:none;">Sign In here</a>
      </div>

    </div>
  </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>

  function previewImage(input) {
    if (input.files && input.files[0]) {
      const reader = new FileReader();
      reader.onload = function(e) {
        $('#photoPreview').attr('src', e.target.result);
        $('#previewWrap').show();
        $('#uploadInstructions').hide();
      }
      reader.readAsDataURL(input.files[0]);
    }
  }

  function updateFee() {
    var select = document.getElementById('specialization');
    var feeInput = document.getElementById('consultationFee');
    if (select.selectedIndex > 0) {
      var fee = select.options[select.selectedIndex].getAttribute('data-fee');
      feeInput.value = fee;
    } else {
      feeInput.value = '';
    }
  }
</script>
</body>
</html>
