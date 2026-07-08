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
<a href="index.html" style="position:fixed; top:24px; left:24px; z-index:1000; display:inline-flex; align-items:center; gap:8px; color:rgba(255,255,255,0.7); font-size:0.8rem; text-transform:uppercase; letter-spacing:0.1em; font-weight:600; text-decoration:none; transition:var(--transition);" onmouseover="this.style.color='var(--gold)'" onmouseout="this.style.color='rgba(255,255,255,0.7)'">
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

      <form id="lawyerRegisterForm" onsubmit="handleRegister(event)">
        
        <!-- Profile Picture Upload Zone -->
        <div class="col-12 mb-3">
          <label style="font-size:0.72rem; font-weight:700; text-transform:uppercase; letter-spacing:0.15em; color:var(--text-muted); margin-bottom:8px; display:block;">Profile Headshot</label>
          <div class="photo-upload-zone" onclick="$('#photoInput').click()">
            <div class="photo-preview-wrap" id="previewWrap">
              <img id="photoPreview" src="" alt="Preview">
            </div>
            <div id="uploadInstructions">
              <i class="fas fa-camera" style="font-size:1.5rem; color:var(--gold); display:block; margin-bottom:8px;"></i>
              <span style="font-size:0.8rem; color:var(--white); font-weight:600; display:block;">Upload Profile Picture</span>
              <span style="font-size:0.7rem; color:var(--text-muted);">PNG, JPG up to 5MB</span>
            </div>
          </div>
          <input type="file" id="photoInput" accept="image/*" style="display:none;" onchange="previewImage(this)">
        </div>

        <div class="row g-3">
          <!-- Full Name -->
          <div class="col-md-6">
            <div class="form-field-luxury">
              <label for="fullName">Full Name</label>
              <input type="text" class="luxury-input form-control" id="fullName" placeholder="Dr. Marcus Chen" required autocomplete="name">
            </div>
          </div>

          <!-- Email -->
          <div class="col-md-6">
            <div class="form-field-luxury">
              <label for="email">Email Address</label>
              <input type="email" class="luxury-input form-control" id="email" placeholder="attorney@lawfirm.com" required autocomplete="email">
            </div>
          </div>

          <!-- Phone -->
          <div class="col-md-6">
            <div class="form-field-luxury">
              <label for="phone">Phone Number</label>
              <input type="tel" class="luxury-input form-control" id="phone" placeholder="+1 (555) 000-0000" required autocomplete="tel">
            </div>
          </div>

          <!-- Password -->
          <div class="col-md-6">
            <div class="form-field-luxury">
              <label for="password">Password</label>
              <input type="password" class="luxury-input form-control" id="password" placeholder="Create safe password" required autocomplete="new-password">
            </div>
          </div>

          <!-- Qualification -->
          <div class="col-md-6">
            <div class="form-field-luxury">
              <label for="qualification">Qualification / Law Degree</label>
              <input type="text" class="luxury-input form-control" id="qualification" placeholder="e.g. J.D., Harvard Law School" required>
            </div>
          </div>

          <!-- Experience -->
          <div class="col-md-6">
            <div class="form-field-luxury">
              <label for="experience">Years of Experience</label>
              <input type="number" class="luxury-input form-control" id="experience" placeholder="e.g. 15" min="1" required>
            </div>
          </div>

          <!-- Bar Council Number -->
          <div class="col-md-6">
            <div class="form-field-luxury">
              <label for="barCouncil">Bar Council Number</label>
              <input type="text" class="luxury-input form-control" id="barCouncil" placeholder="e.g. NY-2010-4829" required>
            </div>
          </div>

          <!-- Specialization -->
          <div class="col-md-6">
            <div class="form-field-luxury">
              <label for="specialization">Specialization</label>
              <select class="luxury-input form-control" id="specialization" required style="background-color:var(--dark-card);">
                <option value="">Select practice area...</option>
                <option>Criminal Law</option>
                <option>Civil Law</option>
                <option>Divorce Law</option>
                <option>Family Law</option>
                <option>Property Law</option>
                <option>Corporate Law</option>
                <option>Affidavit</option>
                <option>Immigration Law</option>
                <option>Estate Planning</option>
              </select>
            </div>
          </div>

          <!-- Consultation Fee -->
          <div class="col-md-6">
            <div class="form-field-luxury">
              <label for="consultationFee">Consultation Fee (USD/hr)</label>
              <input type="number" class="luxury-input form-control" id="consultationFee" placeholder="e.g. 350" min="50" required>
            </div>
          </div>

          <!-- City -->
          <div class="col-md-6">
            <div class="form-field-luxury">
              <label for="city">City / State</label>
              <input type="text" class="luxury-input form-control" id="city" placeholder="e.g. New York, NY" required>
            </div>
          </div>

          <!-- Office Address -->
          <div class="col-12">
            <div class="form-field-luxury">
              <label for="officeAddress">Office Address</label>
              <input type="text" class="luxury-input form-control" id="officeAddress" placeholder="e.g. 350 Fifth Avenue, Suite 4100" required>
            </div>
          </div>

          <!-- Agreement Checkbox -->
          <div class="col-12 mb-3">
            <div class="d-flex align-items-start gap-2">
              <input type="checkbox" id="agreeTerms" style="margin-top:4px; accent-color:var(--gold);" required>
              <label for="agreeTerms" style="font-size:0.75rem; color:var(--text-muted); cursor:pointer;">
                I certify that all credentials, bar certificates, and educational records are completely true. I agree to the <a href="#" style="color:var(--gold); text-decoration:none;">Attorney Agreement</a> and authorize LexElite to verify my status with the Bar Council.
              </label>
            </div>
          </div>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn-gold w-100" style="justify-content:center; padding:14px;">
          <i class="fas fa-paper-plane me-2"></i>Submit Application
        </button>
      </form>

      <!-- Switch Screen Link -->
      <div style="font-size:0.85rem; color:var(--text-muted); text-align:center; margin-top:2rem;">
        Already registered? <a href="lawyer-login.html" style="color:var(--gold); font-weight:600; text-decoration:none;">Sign In here</a>
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

  function handleRegister(e) {
    e.preventDefault();
    showToast('Application submitted successfully! Redirecting…');
    setTimeout(() => {
      window.location.href = 'lawyerdashboard.html';
    }, 1800);
  }
</script>
</body>
</html>
