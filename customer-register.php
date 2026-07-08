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
        <h2 style="font-family:var(--font-serif); font-size:1.6rem; font-weight:700; color:var(--white); margin-top:1rem;">Register Account</h2>
        <p style="font-size:0.85rem; color:var(--text-muted);">Consult with top verified attorneys</p>
      </div>

      <form id="customerRegisterForm" onsubmit="handleRegister(event)">
        <!-- Full Name -->
        <div class="form-field-luxury">
          <label for="fullName">Full Name</label>
          <input type="text" class="luxury-input form-control" id="fullName" placeholder="Jane Smith" required autocomplete="name">
        </div>

        <!-- Email -->
        <div class="form-field-luxury">
          <label for="email">Email Address</label>
          <input type="email" class="luxury-input form-control" id="email" placeholder="jane@example.com" required autocomplete="email">
        </div>

        <!-- Phone -->
        <div class="form-field-luxury">
          <label for="phone">Phone Number</label>
          <input type="tel" class="luxury-input form-control" id="phone" placeholder="+1 (555) 000-0000" required autocomplete="tel">
        </div>
        
        <!-- Password -->
        <div class="form-field-luxury">
          <label for="password">Password</label>
          <input type="password" class="luxury-input form-control" id="password" placeholder="Choose a strong password" required autocomplete="new-password">
        </div>

        <!-- Confirm Password -->
        <div class="form-field-luxury">
          <label for="confirmPassword">Confirm Password</label>
          <input type="password" class="luxury-input form-control" id="confirmPassword" placeholder="Repeat your password" required autocomplete="new-password">
        </div>

        <!-- Agreement Checkbox -->
        <div class="d-flex align-items-start gap-2 mb-4">
          <input type="checkbox" id="agreeTerms" style="margin-top:4px; accent-color:var(--gold);" required>
          <label for="agreeTerms" style="font-size:0.75rem; color:var(--text-muted); cursor:pointer;">
            I agree to the <a href="#" style="color:var(--gold); text-decoration:none;">Terms of Service</a> &amp; <a href="#" style="color:var(--gold); text-decoration:none;">Privacy Policy</a>. All client communications on LexElite are fully confidential and protected.
          </label>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn-gold w-100" style="justify-content:center; padding:14px;">
          <i class="fas fa-user-plus me-2"></i>Create Free Account
        </button>
      </form>

      <!-- Switch Screen Link -->
      <div style="font-size:0.85rem; color:var(--text-muted); text-align:center; margin-top:2rem;">
        Already registered? <a href="customer-login.html" style="color:var(--gold); font-weight:600; text-decoration:none;">Sign In here</a>
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

  function handleRegister(e) {
    e.preventDefault();
    const pass = $('#password').val();
    const conf = $('#confirmPassword').val();
    if (pass !== conf) {
      showToast('Passwords do not match.');
      return;
    }
    showToast('Registration successful! Redirecting…');
    setTimeout(() => {
      window.location.href = 'customer-dashboard.html';
    }, 1500);
  }
</script>
</body>
</html>
