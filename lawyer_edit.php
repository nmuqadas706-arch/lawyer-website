<?php
include_once 'includes/connection.php';

$id = $_GET['id'];

$query = mysqli_query($conn, "SELECT * FROM lawyers WHERE lawyer_id='$id'");

$row = mysqli_fetch_assoc($query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Edit Lawyer Profile — LexElite Legal Management System" />
  <title>Edit Lawyer Profile — LexElite</title>
  <link rel="icon" type="image/svg+xml"
    href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>⚖️</text></svg>">

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome 6 -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
  <!-- Google Fonts -->
  <link
    href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;0,900;1,400&family=Inter:wght@300;400;500;600;700&display=swap"
    rel="stylesheet">

  <style>
    /* =========================================================
       LEXELITE — EDIT LAWYER PROFILE PAGE
       Premium Dark Navy & Gold Theme
       ========================================================= */

    :root {
      --gold: #C9A84C;
      --gold-light: #E8C97B;
      --gold-dark: #A8872E;
      --gold-gradient: linear-gradient(135deg, #C9A84C 0%, #E8C97B 50%, #A8872E 100%);
      --navy: #0D1B3E;
      --navy-light: #142450;
      --navy-mid: #1A2F60;
      --black: #0A0A0A;
      --dark: #111118;
      --dark-card: #16161F;
      --white: #FFFFFF;
      --off-white: #F8F6F0;
      --text-muted: #8A8A9A;
      --font-serif: 'Playfair Display', Georgia, serif;
      --font-sans: 'Inter', system-ui, sans-serif;
      --transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
      --radius-md: 16px;
      --radius-lg: 24px;
      --shadow-deep: 0 20px 60px rgba(0, 0, 0, 0.4);
      --shadow-gold: 0 0 30px rgba(201, 168, 76, 0.15);
    }

    *,
    *::before,
    *::after {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    html {
      scroll-behavior: smooth;
    }

    body {
      font-family: var(--font-sans);
      background: var(--dark);
      color: var(--white);
      min-height: 100vh;
      line-height: 1.7;
      overflow-x: hidden;
    }

    ::selection {
      background: var(--gold);
      color: var(--dark);
    }

    ::-webkit-scrollbar {
      width: 6px;
    }

    ::-webkit-scrollbar-track {
      background: var(--dark);
    }

    ::-webkit-scrollbar-thumb {
      background: var(--gold);
      border-radius: 3px;
    }

    /* ---- Background Pattern ---- */
    .page-bg {
      position: fixed;
      inset: 0;
      z-index: 0;
      pointer-events: none;
      overflow: hidden;
    }

    .page-bg::before {
      content: '';
      position: absolute;
      top: -40%;
      right: -20%;
      width: 700px;
      height: 700px;
      background: radial-gradient(circle, rgba(201, 168, 76, 0.06) 0%, transparent 70%);
      border-radius: 50%;
      animation: floatOrb 18s ease-in-out infinite alternate;
    }

    .page-bg::after {
      content: '';
      position: absolute;
      bottom: -30%;
      left: -15%;
      width: 600px;
      height: 600px;
      background: radial-gradient(circle, rgba(13, 27, 62, 0.4) 0%, transparent 70%);
      border-radius: 50%;
      animation: floatOrb 22s ease-in-out infinite alternate-reverse;
    }

    @keyframes floatOrb {
      0% {
        transform: translate(0, 0) scale(1);
      }

      100% {
        transform: translate(40px, -30px) scale(1.1);
      }
    }

    /* ---- Top Navigation Bar ---- */
    .top-bar {
      background: rgba(13, 27, 62, 0.7);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border-bottom: 1px solid rgba(201, 168, 76, 0.12);
      padding: 0 2rem;
      height: 70px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      position: sticky;
      top: 0;
      z-index: 100;
    }

    .brand-link {
      display: inline-flex;
      align-items: center;
      gap: 12px;
      text-decoration: none;
    }

    .brand-icon {
      width: 40px;
      height: 40px;
      background: var(--gold-gradient);
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--dark);
      font-size: 1.1rem;
      font-weight: 800;
    }

    .brand-name {
      font-family: var(--font-serif);
      font-size: 1.25rem;
      font-weight: 700;
      color: var(--white);
    }

    .brand-name span {
      color: var(--gold);
    }

    .brand-sub {
      display: block;
      font-family: var(--font-sans);
      font-size: 0.6rem;
      color: var(--gold);
      letter-spacing: 0.2em;
      text-transform: uppercase;
      margin-top: -2px;
    }

    .back-btn {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      color: rgba(255, 255, 255, 0.6);
      font-size: 0.82rem;
      font-weight: 600;
      text-decoration: none;
      padding: 8px 16px;
      border: 1px solid rgba(255, 255, 255, 0.1);
      border-radius: 8px;
      transition: var(--transition);
    }

    .back-btn:hover {
      color: var(--gold);
      border-color: var(--gold);
      background: rgba(201, 168, 76, 0.06);
    }

    /* ---- Page Container ---- */
    .page-wrapper {
      position: relative;
      z-index: 1;
      padding: 2.5rem 1rem 4rem;
    }

    /* ---- Main Card ---- */
    .edit-card {
      background: rgba(22, 22, 31, 0.85);
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
      border: 1px solid rgba(201, 168, 76, 0.15);
      border-radius: var(--radius-lg);
      box-shadow:
        var(--shadow-deep),
        var(--shadow-gold),
        inset 0 1px 0 rgba(255, 255, 255, 0.04);
      overflow: hidden;
      max-width: 960px;
      margin: 0 auto;
      animation: cardSlideUp 0.6s ease-out;
    }

    @keyframes cardSlideUp {
      from {
        opacity: 0;
        transform: translateY(20px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* ---- Card Header ---- */
    .card-header-premium {
      background: linear-gradient(135deg, var(--navy) 0%, var(--navy-mid) 50%, var(--navy-light) 100%);
      padding: 2rem 2.5rem;
      border-bottom: 1px solid rgba(201, 168, 76, 0.18);
      position: relative;
      overflow: hidden;
    }

    .card-header-premium::before {
      content: '';
      position: absolute;
      top: 0;
      right: 0;
      width: 250px;
      height: 100%;
      background: radial-gradient(circle at 100% 50%, rgba(201, 168, 76, 0.08) 0%, transparent 70%);
      pointer-events: none;
    }

    .header-badge {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      font-size: 0.68rem;
      font-weight: 700;
      letter-spacing: 0.18em;
      text-transform: uppercase;
      color: var(--gold);
      background: rgba(201, 168, 76, 0.1);
      border: 1px solid rgba(201, 168, 76, 0.3);
      padding: 5px 14px;
      border-radius: 50px;
      margin-bottom: 0.8rem;
    }

    .header-title {
      font-family: var(--font-serif);
      font-size: 1.7rem;
      font-weight: 700;
      color: var(--white);
      margin-bottom: 0.3rem;
      position: relative;
    }

    .header-title i {
      color: var(--gold);
      margin-right: 10px;
      font-size: 1.4rem;
    }

    .header-subtitle {
      font-size: 0.84rem;
      color: var(--text-muted);
      font-weight: 400;
      margin: 0;
    }

    /* ---- Card Body ---- */
    .card-body-premium {
      padding: 2.5rem;
    }

    /* ---- Profile Image Section ---- */
    .profile-section {
      text-align: center;
      margin-bottom: 2.5rem;
      padding-bottom: 2.5rem;
      border-bottom: 1px solid rgba(255, 255, 255, 0.06);
    }

    .profile-avatar-wrapper {
      position: relative;
      width: 140px;
      height: 140px;
      margin: 0 auto 1.2rem;
    }

    .profile-avatar {
      width: 140px;
      height: 140px;
      border-radius: 50%;
      object-fit: cover;
      border: 3px solid rgba(201, 168, 76, 0.4);
      box-shadow: 0 0 0 6px rgba(201, 168, 76, 0.08), 0 8px 30px rgba(0, 0, 0, 0.4);
      transition: var(--transition);
      background: rgba(255, 255, 255, 0.03);
    }

    .profile-avatar-wrapper:hover .profile-avatar {
      border-color: var(--gold);
      box-shadow: 0 0 0 6px rgba(201, 168, 76, 0.15), 0 8px 40px rgba(201, 168, 76, 0.2);
    }

    .camera-overlay {
      position: absolute;
      bottom: 4px;
      right: 4px;
      width: 42px;
      height: 42px;
      background: var(--gold-gradient);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--dark);
      font-size: 1rem;
      cursor: pointer;
      transition: var(--transition);
      box-shadow: 0 4px 14px rgba(201, 168, 76, 0.4);
      border: 3px solid var(--dark-card);
    }

    .camera-overlay:hover {
      transform: scale(1.12);
      box-shadow: 0 6px 20px rgba(201, 168, 76, 0.55);
    }

    .profile-upload-btn {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: rgba(201, 168, 76, 0.08);
      border: 1px dashed rgba(201, 168, 76, 0.35);
      color: var(--gold);
      font-size: 0.78rem;
      font-weight: 600;
      letter-spacing: 0.04em;
      padding: 10px 24px;
      border-radius: 50px;
      cursor: pointer;
      transition: var(--transition);
    }

    .profile-upload-btn:hover {
      background: rgba(201, 168, 76, 0.14);
      border-color: var(--gold);
      color: var(--gold-light);
    }

    .profile-upload-hint {
      font-size: 0.72rem;
      color: var(--text-muted);
      margin-top: 0.6rem;
    }

    .file-input-hidden {
      display: none;
    }

    /* ---- Section Dividers ---- */
    .section-divider {
      display: flex;
      align-items: center;
      gap: 14px;
      margin-bottom: 1.8rem;
      margin-top: 0.5rem;
    }

    .section-divider-icon {
      width: 36px;
      height: 36px;
      background: rgba(201, 168, 76, 0.1);
      border: 1px solid rgba(201, 168, 76, 0.25);
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--gold);
      font-size: 0.9rem;
      flex-shrink: 0;
    }

    .section-divider-text {
      font-family: var(--font-serif);
      font-size: 1rem;
      font-weight: 700;
      color: var(--white);
    }

    .section-divider-line {
      flex: 1;
      height: 1px;
      background: linear-gradient(90deg, rgba(201, 168, 76, 0.25), transparent);
    }

    /* ---- Form Fields ---- */
    .form-field-luxury {
      margin-bottom: 1.5rem;
      position: relative;
    }

    .form-field-luxury label {
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 0.78rem;
      font-weight: 600;
      color: rgba(255, 255, 255, 0.7);
      text-transform: uppercase;
      letter-spacing: 0.08em;
      margin-bottom: 8px;
    }

    .form-field-luxury label i {
      color: var(--gold);
      font-size: 0.82rem;
      width: 16px;
      text-align: center;
    }

    .luxury-input {
      width: 100%;
      background: rgba(255, 255, 255, 0.04) !important;
      border: 1.5px solid rgba(201, 168, 76, 0.18) !important;
      border-radius: 10px !important;
      color: var(--white) !important;
      font-family: var(--font-sans);
      font-size: 0.9rem;
      padding: 14px 18px !important;
      transition: var(--transition);
    }

    .luxury-input:focus {
      border-color: var(--gold) !important;
      box-shadow: 0 0 0 4px rgba(201, 168, 76, 0.1), 0 0 20px rgba(201, 168, 76, 0.06) !important;
      background: rgba(255, 255, 255, 0.06) !important;
      outline: none;
    }

    .luxury-input::placeholder {
      color: var(--text-muted) !important;
    }

    /* Select dropdown styling */
    select.luxury-input {
      appearance: none;
      -webkit-appearance: none;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' fill='%23C9A84C'%3E%3Cpath d='M6 8L0 0h12z'/%3E%3C/svg%3E") !important;
      background-repeat: no-repeat !important;
      background-position: right 16px center !important;
      padding-right: 40px !important;
    }

    select.luxury-input option {
      background: var(--dark-card);
      color: var(--white);
      padding: 10px;
    }

    /* Textarea styling */
    textarea.luxury-input {
      resize: vertical;
      min-height: 100px;
    }

    /* ---- Update Button ---- */
    .btn-update-profile {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      width: 100%;
      background: var(--gold-gradient);
      color: var(--dark) !important;
      font-family: var(--font-sans);
      font-size: 0.92rem;
      font-weight: 700;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      padding: 16px 32px;
      border-radius: 12px;
      border: none;
      cursor: pointer;
      transition: var(--transition);
      box-shadow: 0 4px 20px rgba(201, 168, 76, 0.3);
      position: relative;
      overflow: hidden;
      margin-top: 1rem;
    }

    .btn-update-profile::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
      transition: left 0.6s ease;
    }

    .btn-update-profile:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 35px rgba(201, 168, 76, 0.5);
    }

    .btn-update-profile:hover::before {
      left: 100%;
    }

    .btn-update-profile:active {
      transform: translateY(-1px);
    }

    /* ---- Footer Note ---- */
    .form-footer-note {
      text-align: center;
      margin-top: 1.5rem;
      padding-top: 1.5rem;
      border-top: 1px solid rgba(255, 255, 255, 0.05);
    }

    .form-footer-note p {
      font-size: 0.75rem;
      color: var(--text-muted);
      margin: 0;
    }

    .form-footer-note i {
      color: var(--gold);
      margin-right: 5px;
    }

    /* ---- Animations ---- */
    .fade-in-field {
      opacity: 0;
      transform: translateY(12px);
      animation: fieldFadeIn 0.5s ease-out forwards;
    }

    @keyframes fieldFadeIn {
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Stagger animation delays */
    .fade-in-field:nth-child(1) { animation-delay: 0.05s; }
    .fade-in-field:nth-child(2) { animation-delay: 0.1s; }
    .fade-in-field:nth-child(3) { animation-delay: 0.15s; }
    .fade-in-field:nth-child(4) { animation-delay: 0.2s; }
    .fade-in-field:nth-child(5) { animation-delay: 0.25s; }
    .fade-in-field:nth-child(6) { animation-delay: 0.3s; }
    .fade-in-field:nth-child(7) { animation-delay: 0.35s; }
    .fade-in-field:nth-child(8) { animation-delay: 0.4s; }
    .fade-in-field:nth-child(9) { animation-delay: 0.45s; }
    .fade-in-field:nth-child(10) { animation-delay: 0.5s; }
    .fade-in-field:nth-child(11) { animation-delay: 0.55s; }
    .fade-in-field:nth-child(12) { animation-delay: 0.6s; }

    /* ---- Responsive ---- */
    @media (max-width: 768px) {
      .top-bar {
        padding: 0 1rem;
      }

      .card-header-premium {
        padding: 1.5rem;
        text-align: center;
      }

      .header-title {
        font-size: 1.35rem;
      }

      .card-body-premium {
        padding: 1.5rem;
      }

      .profile-avatar-wrapper {
        width: 120px;
        height: 120px;
      }

      .profile-avatar {
        width: 120px;
        height: 120px;
      }

      .camera-overlay {
        width: 36px;
        height: 36px;
        font-size: 0.85rem;
      }

      .page-wrapper {
        padding: 1.5rem 0.5rem 3rem;
      }
    }

    @media (max-width: 576px) {
      .brand-name {
        font-size: 1rem;
      }

      .back-btn span {
        display: none;
      }

      .header-title {
        font-size: 1.15rem;
      }

      .header-subtitle {
        font-size: 0.78rem;
      }
    }
  </style>
</head>

<body>

  <!-- Background Orbs -->
  <div class="page-bg"></div>

  <!-- Top Navigation Bar -->
  <nav class="top-bar">
    <a href="admin.php" class="brand-link">
      <div class="brand-icon">
        <i class="fas fa-balance-scale"></i>
      </div>
      <div>
        <div class="brand-name">Lex<span>Elite</span></div>
        <span class="brand-sub">Legal Management</span>
      </div>
    </a>
    <a href="admin.php" class="back-btn">
      <i class="fas fa-arrow-left"></i>
      <span>Back to Dashboard</span>
    </a>
  </nav>

  <!-- Page Content -->
  <div class="page-wrapper">
    <div class="container">
      <div class="edit-card">

        <!-- Card Header -->
        <div class="card-header-premium">
          <div class="header-badge">
            <i class="fas fa-shield-halved"></i>
            Admin Panel
          </div>
          <h1 class="header-title">
            <i class="fas fa-user-pen"></i>Edit Lawyer Profile
          </h1>
          <p class="header-subtitle">Update lawyer information and professional details</p>
        </div>

        <!-- Card Body -->
        <div class="card-body-premium">

          <form id="lawyerRegisterForm" method="POST" enctype="multipart/form-data">

            <!-- Hidden Lawyer ID -->
            <input type="hidden" name="lawyer_id" value="<?php echo $row['lawyer_id']; ?>">

            <!-- ===== Profile Image Section ===== -->
            <div class="profile-section">
              <div class="profile-avatar-wrapper">
                <img id="photoPreview"
                  src="uploads/<?php echo $row['profile_image']; ?>"
                  alt="Lawyer Profile Photo "
                  class="profile-avatar"
                
                  onerror="this.src='https://ui-avatars.com/api/?name=<?php echo urlencode($row['full_name']); ?>&background=0D1B3E&color=C9A84C&size=140&font-size=0.4&bold=true'">
                <label for="photoInput" class="camera-overlay" title="Change Photo">
                  <i class="fas fa-camera"></i>
                </label>
              </div>
              <label for="photoInput" class="profile-upload-btn">
                <i class="fas fa-cloud-arrow-up"></i>
                Change Profile Picture
              </label>
              <input type="file" id="photoInput" name="txt_profile_picture" class="file-input-hidden"
                accept="image/*" onchange="previewImage(this)">
              <p class="profile-upload-hint">
                <i class="fas fa-info-circle"></i>
                JPG, PNG or WebP — Max 2MB recommended
              </p>
            </div>

            <!-- ===== Personal Information ===== -->
            <div class="section-divider">
              <div class="section-divider-icon">
                <i class="fas fa-user"></i>
              </div>
              <span class="section-divider-text">Personal Information</span>
              <div class="section-divider-line"></div>
            </div>

            <div class="row g-3 g-lg-4">
              <!-- Full Name -->
              <div class="col-md-6 fade-in-field">
                <div class="form-field-luxury">
                  <label for="fullName">
                    <i class="fas fa-user-tie"></i> Full Name
                  </label>
                  <input type="text"
                    id="fullName"
                    name="txt_name"
                    value="<?php echo $row['full_name']; ?>"
                    class="luxury-input form-control"
                    placeholder="Enter full name">
                </div>
              </div>

              <!-- Email -->
              <div class="col-md-6 fade-in-field">
                <div class="form-field-luxury">
                  <label for="email">
                    <i class="fas fa-envelope"></i> Email Address
                  </label>
                  <input type="email"
                    id="email"
                    name="txt_email"
                    value="<?php echo $row['email']; ?>"
                    class="luxury-input form-control"
                    placeholder="lawyer@example.com">
                </div>
              </div>

              <!-- Phone -->
              <div class="col-md-6 fade-in-field">
                <div class="form-field-luxury">
                  <label for="phone">
                    <i class="fas fa-phone"></i> Phone Number
                  </label>
                  <input type="tel"
                    id="phone"
                    name="txt_phone"
                    value="<?php echo $row['phone']; ?>"
                    class="luxury-input form-control"
                    placeholder="+92 300 1234567">
                </div>
              </div>

              <!-- CNIC -->
              <div class="col-md-6 fade-in-field">
                <div class="form-field-luxury">
                  <label for="cnic">
                    <i class="fas fa-id-card"></i> CNIC Number
                  </label>
                  <input type="text"
                    id="cnic"
                    name="txt_cnic"
                    value="<?php echo $row['cnic_no']; ?>"
                    class="luxury-input form-control"
                    placeholder="XXXXX-XXXXXXX-X">
                </div>
              </div>
            </div>

            <!-- ===== Professional Details ===== -->
            <div class="section-divider" style="margin-top: 2.2rem;">
              <div class="section-divider-icon">
                <i class="fas fa-briefcase"></i>
              </div>
              <span class="section-divider-text">Professional Details</span>
              <div class="section-divider-line"></div>
            </div>

            <div class="row g-3 g-lg-4">
              <!-- Qualification -->
              <div class="col-md-6 fade-in-field">
                <div class="form-field-luxury">
                  <label>
                    <i class="fas fa-graduation-cap"></i> Qualification / Law Degree
                  </label>
                  <input type="text"
                    class="luxury-input form-control"
                    name="txt_qualification"
                    value="<?php echo $row['qualification']; ?>"
                    placeholder="e.g. LLB, LLM"
                    required>
                </div>
              </div>

              <!-- Experience -->
              <div class="col-md-6 fade-in-field">
                <div class="form-field-luxury">
                  <label>
                    <i class="fas fa-clock"></i> Years of Experience
                  </label>
                  <input type="number"
                    class="luxury-input form-control"
                    name="txt_experience"
                    value="<?php echo $row['experience']; ?>"
                    placeholder="e.g. 5"
                    required>
                </div>
              </div>

              <!-- Specialization -->
              <div class="col-md-6 fade-in-field">
                <div class="form-field-luxury">
                  <label>
                    <i class="fas fa-gavel"></i> Specialization
                  </label>
                  <select class="luxury-input form-control" name="txt_specialization" required>
                    <option <?php if($row['specialization']=="Criminal Law") echo "selected"; ?>>
                      Criminal Law
                    </option>
                    <option <?php if($row['specialization']=="Civil Law") echo "selected"; ?>>
                      Civil Law
                    </option>
                    <option <?php if($row['specialization']=="Family Law") echo "selected"; ?>>
                      Family Law
                    </option>
                    <option <?php if($row['specialization']=="Property Law") echo "selected"; ?>>
                      Property Law
                    </option>
                    <option <?php if($row['specialization']=="Corporate Law") echo "selected"; ?>>
                      Corporate Law
                    </option>
                  </select>
                </div>
              </div>

              <!-- Consultation Fee -->
              <div class="col-md-6 fade-in-field">
                <div class="form-field-luxury">
                  <label>
                    <i class="fas fa-coins"></i> Consultation Fee (PKR)
                  </label>
                  <input type="number"
                    class="luxury-input form-control"
                    name="txt_consultation_fee"
                    value="<?php echo $row['consultation_fee']; ?>"
                    placeholder="e.g. 5000"
                    required>
                </div>
              </div>

              <!-- Professional Bio -->
              <div class="col-12 fade-in-field">
                <div class="form-field-luxury">
                  <label>
                    <i class="fas fa-quote-left"></i> Professional Bio
                  </label>
                  <textarea class="luxury-input form-control"
                    name="txt_bio"
                    rows="4"
                    placeholder="Brief professional biography..."
                    required><?php echo $row['bio']; ?></textarea>
                </div>
              </div>
            </div>

            <!-- ===== Location Details ===== -->
            <div class="section-divider" style="margin-top: 2.2rem;">
              <div class="section-divider-icon">
                <i class="fas fa-location-dot"></i>
              </div>
              <span class="section-divider-text">Location & Office</span>
              <div class="section-divider-line"></div>
            </div>

            <div class="row g-3 g-lg-4">
              <!-- City -->
              <div class="col-md-6 fade-in-field">
                <div class="form-field-luxury">
                  <label>
                    <i class="fas fa-city"></i> City
                  </label>
                  <input type="text"
                    class="luxury-input form-control"
                    name="txt_city"
                    value="<?php echo $row['city']; ?>"
                    placeholder="e.g. Lahore"
                    required>
                </div>
              </div>

              <!-- Office Address -->
              <div class="col-md-6 fade-in-field">
                <div class="form-field-luxury">
                  <label>
                    <i class="fas fa-building"></i> Office Address
                  </label>
                  <input type="text"
                    class="luxury-input form-control"
                    name="txt_office_address"
                    value="<?php echo $row['address']; ?>"
                    placeholder="Full office address"
                    required>
                </div>
              </div>
            </div>

            <!-- ===== Submit Button ===== -->
            <button type="submit" name="btn_update" class="btn-update-profile">
              <i class="fas fa-save"></i>
              Update Lawyer Profile
            </button>

            <!-- Footer Note -->
            <div class="form-footer-note">
              <p>
                <i class="fas fa-lock"></i>
                All changes are securely saved and take effect immediately
              </p>
            </div>

          </form>

        </div>
        <!-- /Card Body -->

      </div>
      <!-- /Edit Card -->
    </div>
  </div>

  <!-- Bootstrap 5 JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Image Preview Script -->
  <script>
    function previewImage(input) {
      if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
          document.getElementById('photoPreview').src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
      }
    }
  </script>

</body>

</html>

<?php
include_once 'includes/connection.php';

if(isset($_POST['btn_update'])){

    $id = $_POST['lawyer_id'];

    $name = $_POST['txt_name'];
    $email = $_POST['txt_email'];
    $phone = $_POST['txt_phone'];
    $qualification = $_POST['txt_qualification'];
    $experience = $_POST['txt_experience'];
    $cnic = $_POST['txt_cnic'];
    $specialization = $_POST['txt_specialization'];
    $fee = $_POST['txt_consultation_fee'];
    $bio = $_POST['txt_bio'];
    $city = $_POST['txt_city'];
    $address = $_POST['txt_office_address'];
    
    // Default query without image update
    $query = "UPDATE lawyers SET
        full_name='$name',
        email='$email',
        phone='$phone',
        qualification='$qualification',
        experience='$experience',
        cnic_no='$cnic',
        specialization='$specialization',
        consultation_fee='$fee',
        bio='$bio',
        city='$city',
        address='$address'";

    // Handle image upload if a new file is provided
    if(isset($_FILES['txt_profile_picture']) && $_FILES['txt_profile_picture']['name'] != ""){
        $image_name = $_FILES['txt_profile_picture']['name'];
        $tmp_name = $_FILES['txt_profile_picture']['tmp_name'];
        $profile_image = time().'_'.$image_name;
        
        // Ensure destination folder is "uploads/" 
        move_uploaded_file($tmp_name, "uploads/".$profile_image);
        
        // Append image update to query
        $query .= ", profile_image='$profile_image'";
    }

    $query .= " WHERE lawyer_id='$id'";
        
    $result = mysqli_query($conn,$query);


    if($result){
        echo "
        <script>
        alert('Lawyer Updated Successfully');
        window.location='admin.php';
        </script>";
    }
    else{
        echo "Error: ".mysqli_error($conn);
    }

}

?>