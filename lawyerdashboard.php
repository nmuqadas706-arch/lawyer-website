<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="description" content="LexElite Lawyer Portal — Manage your calendar, review client requests, host video consultations, and track earnings."/>
  <title>Lawyer Dashboard — LexElite | Attorney Portal</title>

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
      background-color: var(--dark);
      color: var(--white);
      font-family: var(--font-sans);
    }
    .dash-layout {
      display: flex;
      min-height: 100vh;
      position: relative;
    }
    .dash-sidebar {
      width: 280px;
      background: linear-gradient(180deg, var(--navy) 0%, var(--black) 100%);
      border-right: 1px solid rgba(201, 168, 76, 0.15);
      display: flex;
      flex-direction: column;
      flex-shrink: 0;
      transition: var(--transition);
      z-index: 1040;
    }
    .dash-main {
      flex: 1;
      display: flex;
      flex-direction: column;
      min-width: 0;
    }
    .dash-header {
      height: 70px;
      background: rgba(255, 255, 255, 0.02);
      border-bottom: 1px solid rgba(255, 255, 255, 0.05);
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 2rem;
    }
    .dash-content {
      padding: 2rem;
      flex: 1;
      overflow-y: auto;
    }
    .sidebar-brand {
      padding: 24px;
      border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }
    .sidebar-user {
      padding: 20px;
      display: flex;
      align-items: center;
      gap: 12px;
      border-bottom: 1px solid rgba(255, 255, 255, 0.05);
      background: rgba(201, 168, 76, 0.02);
    }
    .sidebar-menu {
      padding: 15px;
      display: flex;
      flex-direction: column;
      gap: 5px;
    }
    .menu-item {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 12px 16px;
      border-radius: 8px;
      color: rgba(255, 255, 255, 0.7);
      font-size: 0.85rem;
      font-weight: 600;
      cursor: pointer;
      transition: var(--transition);
    }
    .menu-item:hover,
    .menu-item.active {
      color: var(--gold);
      background: rgba(201, 168, 76, 0.08);
      border-left: 3px solid var(--gold);
    }
    .menu-title {
      font-size: 0.65rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.15em;
      color: var(--gold);
      padding: 15px 16px 5px;
      opacity: 0.8;
    }
    
    /* Tables & Cards */
    .lux-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 1rem;
    }
    .lux-table th {
      text-align: left;
      font-size: 0.72rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.1em;
      color: var(--gold);
      padding: 14px 16px;
      border-bottom: 2px solid rgba(201, 168, 76, 0.2);
    }
    .lux-table td {
      padding: 14px 16px;
      font-size: 0.84rem;
      color: rgba(255, 255, 255, 0.8);
      border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }
    .lux-table tr:hover td {
      background: rgba(201, 168, 76, 0.02);
      color: var(--white);
    }

    .badge-status {
      padding: 4px 12px;
      border-radius: 50px;
      font-size: 0.7rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.05em;
      display: inline-block;
    }
    .badge-Pending   { background: rgba(245,158,11,0.1); color: #f59e0b; border: 1px solid rgba(245,158,11,0.3); }
    .badge-Confirmed { background: rgba(74,222,128,0.1); color: #4ade80; border: 1px solid rgba(74,222,128,0.3); }
    .badge-Completed { background: rgba(13,110,253,0.1); color: #0d6efd; border: 1px solid rgba(13,110,253,0.3); }
    .badge-Cancelled { background: rgba(239,68,68,0.1); color: #ef4444; border: 1px solid rgba(239,68,68,0.3); }

    .action-btn {
      width: 32px; height: 32px;
      border-radius: 6px;
      border: 1px solid rgba(255, 255, 255, 0.08);
      background: transparent;
      color: var(--text-muted);
      cursor: pointer;
      transition: var(--transition);
    }
    .action-btn:hover {
      border-color: var(--gold);
      color: var(--gold);
      background: rgba(201, 168, 76, 0.08);
    }

    .grid-stats {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 1.5rem;
      margin-bottom: 2rem;
    }
    .stat-box {
      background: rgba(255, 255, 255, 0.03);
      border: 1px solid rgba(255, 255, 255, 0.06);
      border-radius: var(--radius-md);
      padding: 1.5rem;
      display: flex;
      align-items: center;
      gap: 16px;
      position: relative;
      overflow: hidden;
    }
    .stat-box::before {
      content: '';
      position: absolute; bottom: 0; left: 0; right: 0; height: 3px;
      background: var(--gold-gradient);
    }
    .stat-box-icon {
      width: 52px; height: 52px;
      background: rgba(201, 168, 76, 0.08);
      border: 1px solid rgba(201, 168, 76, 0.2);
      border-radius: 12px;
      display: flex; align-items: center; justify-content: center;
      font-size: 1.4rem; color: var(--gold);
    }
    .stat-box-val {
      font-family: var(--font-serif);
      font-size: 1.8rem; font-weight: 800; color: var(--white);
      line-height: 1;
    }
    .stat-box-label {
      font-size: 0.72rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.1em; margin-top: 3px;
    }

    /* Panels setup */
    .panel-section { display: none; }
    .panel-section.active { display: block; animation: fadeInUp 0.4s ease-out; }

    /* Photo uploader */
    .photo-uploader-card {
      border: 1.5px dashed rgba(201, 168, 76, 0.3);
      border-radius: 8px;
      padding: 2rem;
      text-align: center;
      cursor: pointer;
      background: rgba(255,255,255,0.01);
      transition: var(--transition);
    }
    .photo-uploader-card:hover {
      border-color: var(--gold);
      background: rgba(201, 168, 76, 0.05);
    }
    .round-headshot-preview {
      width: 120px; height: 120px;
      border-radius: 50%;
      border: 3px solid var(--gold);
      overflow: hidden;
      margin: 0 auto 15px;
    }
    .round-headshot-preview img {
      width: 100%; height: 100%;
      object-fit: cover;
    }

    /* Schedule time grid */
    .schedule-editor-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
      gap: 10px;
    }
    .editor-time-chip {
      padding: 10px;
      text-align: center;
      border: 1px solid rgba(255,255,255,0.06);
      background: rgba(255,255,255,0.02);
      border-radius: 8px;
      font-size: 0.8rem;
      font-weight: 600;
      position: relative;
      transition: var(--transition);
    }
    .editor-time-chip:hover {
      border-color: var(--gold);
      color: var(--gold);
    }
    .chip-remove-btn {
      position: absolute;
      top: -6px; right: -6px;
      width: 18px; height: 18px;
      border-radius: 50%;
      background: #ef4444;
      color: var(--white);
      font-size: 0.6rem;
      border: none;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
    }

    /* Responsive overlay toggles */
    .sidebar-overlay {
      display: none;
      position: fixed; inset: 0;
      background: rgba(0,0,0,0.6);
      z-index: 1030;
    }
    @media (max-width: 991px) {
      .dash-sidebar { position: fixed; left: -280px; top: 0; bottom: 0; }
      .dash-sidebar.open { left: 0; }
      .sidebar-overlay.open { display: block; }
      .dash-header { padding: 0 1rem; }
    }
  </style>
</head>
<body>

<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

<div class="dash-layout">

  <!-- ===================== SIDEBAR ===================== -->
  <aside class="dash-sidebar" id="dashSidebar">
    <div class="sidebar-brand">
      <a class="navbar-brand-logo text-decoration-none" href="index.html" style="display:inline-flex;">
        <div class="brand-icon" style="width:36px; height:36px; font-size:1rem;"><i class="fas fa-balance-scale"></i></div>
        <div class="ms-2">
          <span class="brand-text-main" style="font-size:1.1rem;">LexElite</span>
          <span class="brand-text-sub" style="font-size:0.5rem; letter-spacing:0.2em;">Attorney Portal</span>
        </div>
      </a>
    </div>

    <!-- User Header Card -->
    <div class="sidebar-user">
      <div id="sideAvatarWrap" style="width:44px; height:44px; border-radius:50%; background:var(--gold-gradient); display:flex; align-items:center; justify-content:center; color:var(--dark); font-weight:800; font-size:1rem; flex-shrink:0; overflow:hidden;">
        MK
      </div>
      <div>
        <div style="font-size:0.85rem; font-weight:700; color:var(--white);" id="sideLawyerName">Michael Kingston, Esq.</div>
        <div style="font-size:0.68rem; color:var(--gold); font-weight:600;" id="sideLawyerSpec">Criminal Law Specialist</div>
      </div>
    </div>

    <!-- Menu Links -->
    <div class="sidebar-menu">
      <div class="menu-title">Main Portal</div>
      <div class="menu-item active" onclick="switchTab('dashboard', this)"><i class="fas fa-th-large"></i> Dashboard</div>
      <div class="menu-item" onclick="switchTab('profile', this)"><i class="fas fa-user-edit"></i> Profile Details</div>
      <div class="menu-item" onclick="switchTab('schedule', this)"><i class="fas fa-calendar-week"></i> Manage Schedule</div>
      
      <div class="menu-title">Appointments</div>
      <div class="menu-item" onclick="switchTab('requests', this)">
        <i class="fas fa-envelope-open-text"></i> Requests
        <span class="badge bg-danger ms-auto rounded-pill" style="font-size:0.65rem;" id="requestsBadgeCount">2</span>
      </div>
      <div class="menu-item" onclick="switchTab('upcoming', this)">
        <i class="fas fa-calendar-check"></i> Upcoming
        <span class="badge bg-success ms-auto rounded-pill" style="font-size:0.65rem;" id="upcomingBadgeCount">3</span>
      </div>
      <div class="menu-item" onclick="switchTab('completed', this)"><i class="fas fa-clipboard-check"></i> Completed</div>

      <div class="menu-title">Account</div>
      <div class="menu-item" onclick="window.location.href='index.html'"><i class="fas fa-home"></i> Back to Homepage</div>
      <div class="menu-item" onclick="window.location.href='lawyer-login.html'" style="color:#ef4444;"><i class="fas fa-sign-out-alt"></i> Log Out</div>
    </div>
  </aside>

  <!-- ===================== MAIN AREA ===================== -->
  <div class="dash-main">
    <header class="dash-header">
      <div class="d-flex align-items-center gap-3">
        <button class="topbar-btn d-lg-none" onclick="toggleSidebar()" style="background:none; border:none; color:var(--white); font-size:1.2rem;"><i class="fas fa-bars"></i></button>
        <h2 style="font-family:var(--font-serif); font-size:1.3rem; font-weight:700; margin:0;" id="panelHeaderTitle">Dashboard</h2>
      </div>
      <div class="d-flex align-items-center gap-3">
        <span style="font-size:0.8rem; color:var(--text-muted);"><i class="fas fa-circle text-success me-1"></i> Practice Online</span>
        <div id="topAvatarWrap" style="width:36px; height:36px; border-radius:50%; background:var(--gold-gradient); display:flex; align-items:center; justify-content:center; color:var(--dark); font-weight:800; font-size:0.85rem; overflow:hidden;">
          MK
        </div>
      </div>
    </header>

    <div class="dash-content">

      <!-- ===================== PANEL: DASHBOARD ===================== -->
      <div class="panel-section active" id="panel-dashboard">
        
        <!-- Welcome Jumbotron -->
        <div style="background:linear-gradient(135deg, var(--navy) 0%, var(--navy-mid) 100%); border:1px solid rgba(201, 168, 76, 0.2); border-radius:12px; padding:2rem; margin-bottom:2rem;">
          <h3 style="font-family:var(--font-serif); font-size:1.4rem; font-weight:700; color:var(--white); margin-bottom:0.4rem;" id="welcomeAttorneyName">Welcome, Attorney Michael Kingston</h3>
          <p style="font-size:0.85rem; color:rgba(255, 255, 255, 0.7); margin:0;">
            You have <strong style="color:var(--gold)">2 pending requests</strong> awaiting review and <strong style="color:var(--gold)">3 upcoming consultations</strong> scheduled for this week.
          </p>
        </div>

        <!-- Stats Grid -->
        <div class="grid-stats">
          <div class="stat-box">
            <div class="stat-box-icon"><i class="fas fa-calendar-check"></i></div>
            <div><div class="stat-box-val" id="statBookingsCount">234</div><div class="stat-box-label">Total Bookings</div></div>
          </div>
          <div class="stat-box">
            <div class="stat-box-icon"><i class="fas fa-award"></i></div>
            <div><div class="stat-box-val" id="statWinsCount">140</div><div class="stat-box-label">Cases Won</div></div>
          </div>
          <div class="stat-box">
            <div class="stat-box-icon"><i class="fas fa-star"></i></div>
            <div><div class="stat-box-val">4.9</div><div class="stat-box-label">Avg. Rating</div></div>
          </div>
          <div class="stat-box">
            <div class="stat-box-icon"><i class="fas fa-wallet"></i></div>
            <div><div class="stat-box-val" id="statRateDisplay">$450</div><div class="stat-box-label">Hourly Rate</div></div>
          </div>
        </div>

        <div class="row g-4">
          <!-- Recent Activity Cards -->
          <div class="col-lg-7">
            <div class="dash-card">
              <div class="dash-card-title">Recent Appointment Requests</div>
              <div style="overflow-x:auto;">
                <table class="lux-table">
                  <thead>
                    <tr>
                      <th>Client</th>
                      <th>Practice Area</th>
                      <th>Requested Date</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody id="dashboardRequestsTable">
                    <!-- Filled by JS -->
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          
          <div class="col-lg-5">
            <div class="dash-card">
              <div class="dash-card-title">Today's Availability</div>
              <div style="background:rgba(201,168,76,0.06); border:1px solid rgba(201,168,76,0.2); border-radius:10px; padding:1.2rem; margin-bottom:12px;">
                <div style="font-weight:700; color:var(--white); font-size:0.85rem; margin-bottom:6px;">Current Hours:</div>
                <div style="font-size:1.1rem; font-weight:700; color:var(--gold);" id="todayHoursVal">9:00 AM – 5:00 PM</div>
              </div>
              <div style="font-size:0.8rem; color:var(--text-muted); line-height:1.6;">
                Need to edit your slots? Head over to the <strong style="color:var(--gold); cursor:pointer;" onclick="$('[data-target=schedule]').click()">Manage Schedule</strong> tab to update your daily availability calendar.
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- ===================== PANEL: PROFILE ===================== -->
      <div class="panel-section" id="panel-profile">
        <div class="row g-4">
          
          <!-- Image upload and preview card -->
          <div class="col-lg-4">
            <div class="dash-card text-center">
              <div class="dash-card-title" style="justify-content:center;">Profile Image</div>
              
              <div class="round-headshot-preview">
                <img src="" alt="Profile Image" id="profileHeadshotPreview">
              </div>
              
              <div class="photo-uploader-card" onclick="$('#headshotFile').click()">
                <i class="fas fa-cloud-upload-alt" style="font-size:1.6rem; color:var(--gold); display:block; margin-bottom:8px;"></i>
                <span style="font-size:0.8rem; color:var(--white); font-weight:600; display:block;">Change Photo</span>
                <span style="font-size:0.65rem; color:var(--text-muted);">JPG/PNG up to 2MB</span>
              </div>
              <input type="file" id="headshotFile" accept="image/*" style="display:none;" onchange="updateProfileHeadshot(this)">
            </div>
          </div>

          <!-- Profile form card -->
          <div class="col-lg-8">
            <div class="dash-card">
              <div class="dash-card-title">Attorney Retainer Details</div>
              <form id="profileForm" onsubmit="saveProfileDetails(event)">
                <div class="row g-3">
                  <!-- Full Name -->
                  <div class="col-md-6">
                    <div class="form-field-luxury">
                      <label for="profName">Full Name</label>
                      <input type="text" class="luxury-input form-control" id="profName" required>
                    </div>
                  </div>
                  <!-- Specialization -->
                  <div class="col-md-6">
                    <div class="form-field-luxury">
                      <label for="profSpec">Specialization</label>
                      <select class="luxury-input form-control" id="profSpec" style="background-color:var(--dark-card);" required>
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
                  <!-- Qualification -->
                  <div class="col-md-6">
                    <div class="form-field-luxury">
                      <label for="profQual">Qualification</label>
                      <input type="text" class="luxury-input form-control" id="profQual" required>
                    </div>
                  </div>
                  <!-- Experience -->
                  <div class="col-md-6">
                    <div class="form-field-luxury">
                      <label for="profExp">Experience (Years)</label>
                      <input type="number" class="luxury-input form-control" id="profExp" required>
                    </div>
                  </div>
                  <!-- Bar Council Number -->
                  <div class="col-md-6">
                    <div class="form-field-luxury">
                      <label for="profBar">Bar Council Number</label>
                      <input type="text" class="luxury-input form-control" id="profBar" required>
                    </div>
                  </div>
                  <!-- Consultation Fee -->
                  <div class="col-md-6">
                    <div class="form-field-luxury">
                      <label for="profFee">Consultation Fee (USD/hr)</label>
                      <input type="number" class="luxury-input form-control" id="profFee" required>
                    </div>
                  </div>
                  <!-- City -->
                  <div class="col-md-6">
                    <div class="form-field-luxury">
                      <label for="profCity">City</label>
                      <input type="text" class="luxury-input form-control" id="profCity" required>
                    </div>
                  </div>
                  <!-- Office Address -->
                  <div class="col-md-6">
                    <div class="form-field-luxury">
                      <label for="profAddr">Office Address</label>
                      <input type="text" class="luxury-input form-control" id="profAddr" required>
                    </div>
                  </div>
                  <!-- Email -->
                  <div class="col-md-6">
                    <div class="form-field-luxury">
                      <label for="profEmail">Email Address</label>
                      <input type="email" class="luxury-input form-control" id="profEmail" required>
                    </div>
                  </div>
                  <!-- Phone -->
                  <div class="col-md-6">
                    <div class="form-field-luxury">
                      <label for="profPhone">Phone Number</label>
                      <input type="tel" class="luxury-input form-control" id="profPhone" required>
                    </div>
                  </div>
                  <!-- Bio -->
                  <div class="col-12">
                    <div class="form-field-luxury">
                      <label for="profBio">Professional Biography</label>
                      <textarea class="luxury-input form-control" id="profBio" rows="4" style="resize:vertical;" required></textarea>
                    </div>
                  </div>
                </div>
                <button type="submit" class="btn-gold mt-3" style="padding:12px 30px;"><i class="fas fa-save me-2"></i>Save Retainer Profile</button>
              </form>
            </div>
          </div>

        </div>
      </div>

      <!-- ===================== PANEL: MANAGE SCHEDULE ===================== -->
      <div class="panel-section" id="panel-schedule">
        <div class="dash-card">
          <div class="dash-card-title">Manage Weekly Availability</div>
          <p style="font-size:0.82rem; color:var(--text-muted); margin-bottom:1.5rem;">Configure your hours of availability for client instant bookings.</p>
          
          <div class="row g-3 mb-4">
            <div class="col-md-4">
              <div class="form-field-luxury">
                <label>Day of Week</label>
                <select class="luxury-input form-control" id="schedDay" style="background-color:var(--dark-card);">
                  <option>Monday</option>
                  <option>Tuesday</option>
                  <option>Wednesday</option>
                  <option>Thursday</option>
                  <option>Friday</option>
                  <option>Saturday</option>
                  <option>Sunday</option>
                </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-field-luxury">
                <label>Time Slot</label>
                <select class="luxury-input form-control" id="schedTime" style="background-color:var(--dark-card);">
                  <option>9:00 AM</option>
                  <option>10:00 AM</option>
                  <option>11:00 AM</option>
                  <option>12:00 PM</option>
                  <option>1:00 PM</option>
                  <option>2:00 PM</option>
                  <option>3:00 PM</option>
                  <option>4:00 PM</option>
                  <option>5:00 PM</option>
                  <option>6:00 PM</option>
                </select>
              </div>
            </div>
            <div class="col-md-4 d-flex align-items-end">
              <button class="btn-gold w-100" style="padding:14px; justify-content:center;" onclick="addScheduleSlot()">
                <i class="fas fa-plus me-2"></i>Add Availability Slot
              </button>
            </div>
          </div>

          <div class="row g-4">
            <!-- Monday to Sunday Schedule View -->
            <div class="col-12">
              <div style="background:rgba(255,255,255,0.01); border:1px solid rgba(255,255,255,0.05); border-radius:12px; padding:1.5rem;">
                <h5 style="font-family:var(--font-serif); font-size:1.05rem; color:var(--white); margin-bottom:1.2rem;"><i class="fas fa-calendar-alt text-gold me-2"></i>Weekly Schedule Calendar</h5>
                
                <div class="row g-3" id="weeklyScheduleViewer">
                  <!-- Filled by JS day column chips -->
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- ===================== PANEL: APPOINTMENT REQUESTS ===================== -->
      <div class="panel-section" id="panel-requests">
        <div class="dash-card">
          <div class="dash-card-title">Pending Appointment Requests</div>
          <p style="font-size:0.82rem; color:var(--text-muted); margin-bottom:1.5rem;">Review and action pending appointment requests from new clients.</p>
          
          <div style="overflow-x:auto;">
            <table class="lux-table">
              <thead>
                <tr>
                  <th>Client</th>
                  <th>Practice Area</th>
                  <th>Requested Date</th>
                  <th>Time Slot</th>
                  <th>Mode</th>
                  <th>Message</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody id="appointmentRequestsTable">
                <!-- Filled by JS -->
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- ===================== PANEL: UPCOMING APPOINTMENTS ===================== -->
      <div class="panel-section" id="panel-upcoming">
        <div class="dash-card">
          <div class="dash-card-title">Upcoming Confirmed Appointments</div>
          <p style="font-size:0.82rem; color:var(--text-muted); margin-bottom:1.5rem;">List of confirmed upcoming consultations. You can launch video sessions directly from here.</p>
          
          <div style="overflow-x:auto;">
            <table class="lux-table">
              <thead>
                <tr>
                  <th>Client</th>
                  <th>Practice Area</th>
                  <th>Date</th>
                  <th>Time</th>
                  <th>Mode</th>
                  <th>Consultation Fee</th>
                  <th>Launch Session</th>
                </tr>
              </thead>
              <tbody id="upcomingAppointmentsTable">
                <!-- Filled by JS -->
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- ===================== PANEL: COMPLETED APPOINTMENTS ===================== -->
      <div class="panel-section" id="panel-completed">
        <div class="dash-card">
          <div class="dash-card-title">Completed Consultations History</div>
          <p style="font-size:0.82rem; color:var(--text-muted); margin-bottom:1.5rem;">History of completed sessions with billing details and ratings feedback.</p>
          
          <div style="overflow-x:auto;">
            <table class="lux-table">
              <thead>
                <tr>
                  <th>Client</th>
                  <th>Practice Area</th>
                  <th>Completed Date</th>
                  <th>Consultation Mode</th>
                  <th>Billing Summary</th>
                  <th>Client Review</th>
                </tr>
              </thead>
              <tbody id="completedAppointmentsTable">
                <!-- Filled by JS -->
              </tbody>
            </table>
          </div>
        </div>
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
  
  // ──────────────── DATA STATE ────────────────
  const APPOINTMENTS_KEY = 'lexelite_appointments';
  const PROFILE_KEY = 'lexelite_lawyer_profile';
  const SCHEDULE_KEY = 'lexelite_lawyer_schedule';

  // Seed default lawyer profile
  let lawyerProfile = JSON.parse(localStorage.getItem(PROFILE_KEY));
  if (!lawyerProfile) {
    lawyerProfile = {
      name: 'Michael Kingston, Esq.',
      spec: 'Criminal Law',
      qual: 'J.D., Harvard Law School · LL.M., Criminal Justice',
      exp: 18,
      barNum: 'NY-2006-4412',
      fee: 450,
      city: 'New York, NY',
      office: '350 Fifth Avenue, Suite 4100, New York, NY 10118',
      email: 'm.kingston@lexelite.com',
      phone: '+1 (212) 555-0199',
      bio: 'Michael Kingston is one of New York\'s most formidable criminal defense attorneys, with 18 years of courtroom experience handling everything from misdemeanor charges to high-profile federal cases. A Harvard Law graduate, Michael brings a meticulous analytical approach and an aggressive advocacy style.',
      headshot: 'https://randomuser.me/api/portraits/men/32.jpg'
    };
    localStorage.setItem(PROFILE_KEY, JSON.stringify(lawyerProfile));
  }

  // Seed default weekly schedule
  let weeklySchedule = JSON.parse(localStorage.getItem(SCHEDULE_KEY));
  if (!weeklySchedule) {
    weeklySchedule = {
      Monday: ['9:00 AM', '10:00 AM', '11:00 AM', '2:00 PM', '3:00 PM'],
      Tuesday: ['10:00 AM', '1:00 PM', '2:00 PM', '4:00 PM'],
      Wednesday: ['9:00 AM', '10:00 AM', '11:00 AM', '3:00 PM', '5:00 PM'],
      Thursday: ['9:00 AM', '11:00 AM', '2:00 PM', '4:00 PM'],
      Friday: ['10:00 AM', '12:00 PM', '3:00 PM', '5:00 PM'],
      Saturday: ['10:00 AM', '11:00 AM'],
      Sunday: []
    };
    localStorage.setItem(SCHEDULE_KEY, JSON.stringify(weeklySchedule));
  }

  // Initialize appointments list
  let appointments = [];
  function loadAppointments() {
    let raw = localStorage.getItem(APPOINTMENTS_KEY);
    let list = [];
    if (raw) {
      list = JSON.parse(raw);
    } else {
      // Seed default merged list
      list = [
        { id: 'APT-0101', client: 'Richard Hawkins', spec: 'Assault & Battery', date: '2026-07-05', time: '11:00 AM', mode: 'In-Office', msg: 'Need counseling regarding a local municipal dispute.', status: 'pending', fee: 450, lawyerName: 'Michael Kingston, Esq.' },
        { id: 'APT-0102', client: 'Emma Lawson', spec: 'DUI Defense', date: '2026-07-06', time: '04:00 PM', mode: 'Video Call', msg: 'Arrested last weekend, court hearing set for next month.', status: 'pending', fee: 450, lawyerName: 'Michael Kingston, Esq.' },
        { id: 'APT-0201', client: 'Alexander Thompson', spec: 'Criminal Law', date: '2026-07-03', time: '10:00 AM', mode: 'Video Call', fee: 450, status: 'confirmed', lawyerName: 'Michael Kingston, Esq.' },
        { id: 'APT-0202', client: 'Patricia Monroe', spec: 'Divorce Law', date: '2026-07-04', time: '02:00 PM', mode: 'Phone Call', fee: 450, status: 'confirmed', lawyerName: 'Michael Kingston, Esq.' },
        { id: 'APT-0203', client: 'William Harrington', spec: 'Estate Planning', date: '2026-07-08', time: '09:00 AM', mode: 'Video Call', fee: 450, status: 'confirmed', lawyerName: 'Michael Kingston, Esq.' },
        { id: 'APT-0301', client: 'Daniel Kim', spec: 'Federal Trial', date: '2026-06-28', mode: 'Video Call', billing: '$450.00 (1 Hr Paid)', review: '★ 5.0 - Masterful legal advisory.', status: 'completed', fee: 450, lawyerName: 'Michael Kingston, Esq.' },
        { id: 'APT-0302', client: 'Lisa Fontaine', spec: 'Family Law', date: '2026-06-25', mode: 'Phone Call', billing: '$225.00 (0.5 Hr Paid)', review: '★ 4.8 - Very structured counsel.', status: 'completed', fee: 450, lawyerName: 'Michael Kingston, Esq.' }
      ];
      localStorage.setItem(APPOINTMENTS_KEY, JSON.stringify(list));
    }
    // Filter appointments for the current lawyer
    appointments = list.filter(a => a.lawyerName === lawyerProfile.name);
  }

  function saveAppointmentsToStorage(list) {
    // Merge lawyer's updated appointments back into the master list
    let raw = localStorage.getItem(APPOINTMENTS_KEY);
    let masterList = raw ? JSON.parse(raw) : [];

    list.forEach(updated => {
      let idx = masterList.findIndex(m => m.id === updated.id);
      if (idx !== -1) {
        masterList[idx] = updated;
      } else {
        masterList.push(updated);
      }
    });

    localStorage.setItem(APPOINTMENTS_KEY, JSON.stringify(masterList));
  }

  // ──────────────── RENDERING METHODS ────────────────
  function renderAll() {
    loadAppointments();

    // Header & User Card
    $('#sideLawyerName').text(lawyerProfile.name);
    $('#sideLawyerSpec').text(lawyerProfile.spec + ' Specialist');
    $('#welcomeAttorneyName').text('Welcome, Attorney ' + lawyerProfile.name);
    $('#statRateDisplay').text('$' + lawyerProfile.fee);
    
    // Avatars
    if (lawyerProfile.headshot) {
      $('#sideAvatarWrap').html(`<img src="${lawyerProfile.headshot}" style="width:100%; height:100%; object-fit:cover;">`);
      $('#topAvatarWrap').html(`<img src="${lawyerProfile.headshot}" style="width:100%; height:100%; object-fit:cover;">`);
      $('#profileHeadshotPreview').attr('src', lawyerProfile.headshot);
    } else {
      $('#sideAvatarWrap').html('MK');
      $('#topAvatarWrap').html('MK');
      $('#profileHeadshotPreview').attr('src', '');
    }

    // Load Profile Inputs
    $('#profName').val(lawyerProfile.name);
    $('#profSpec').val(lawyerProfile.spec);
    $('#profQual').val(lawyerProfile.qual);
    $('#profExp').val(lawyerProfile.exp);
    $('#profBar').val(lawyerProfile.barNum);
    $('#profFee').val(lawyerProfile.fee);
    $('#profCity').val(lawyerProfile.city);
    $('#profAddr').val(lawyerProfile.office);
    $('#profEmail').val(lawyerProfile.email);
    $('#profPhone').val(lawyerProfile.phone);
    $('#profBio').val(lawyerProfile.bio);

    // Dashboard Overview Requests List
    const reqs = appointments.filter(a => a.status && a.status.toLowerCase() === 'pending');
    let reqsHtml = '';
    reqs.forEach(r => {
      reqsHtml += `<tr>
        <td><strong>${r.client || 'Client'}</strong></td>
        <td>${r.spec}</td>
        <td>${r.date}</td>
        <td><span class="badge-status badge-Pending">Pending</span></td>
      </tr>`;
    });
    if(!reqs.length) reqsHtml = '<tr><td colspan="4" class="text-center text-muted">No pending requests</td></tr>';
    $('#dashboardRequestsTable').html(reqsHtml);

    // Dynamic badge counts
    $('#requestsBadgeCount').text(reqs.length);
    const upcoming = appointments.filter(a => a.status && a.status.toLowerCase() === 'confirmed');
    $('#upcomingBadgeCount').text(upcoming.length);

    // Render Appointment Requests
    let reqFullHtml = '';
    reqs.forEach(r => {
      reqFullHtml += `<tr id="req-row-${r.id}">
        <td><strong>${r.client || 'Client'}</strong></td>
        <td>${r.spec}</td>
        <td>${r.date}</td>
        <td>${r.time}</td>
        <td>${r.mode || 'Video Call'}</td>
        <td style="max-width:200px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;" title="${r.brief || r.msg || ''}">${r.brief || r.msg || 'No details'}</td>
        <td>
          <button class="action-btn text-success" onclick="approveRequest('${r.id}')" style="margin-right:4px;" title="Approve"><i class="fas fa-check"></i></button>
          <button class="action-btn text-danger" onclick="rejectRequest('${r.id}')" title="Reject"><i class="fas fa-times"></i></button>
        </td>
      </tr>`;
    });
    if(!reqs.length) reqFullHtml = '<tr><td colspan="7" class="text-center text-muted">No pending requests found</td></tr>';
    $('#appointmentRequestsTable').html(reqFullHtml);

    // Render Upcoming Appointments
    let upcHtml = '';
    upcoming.forEach(u => {
      upcHtml += `<tr>
        <td><strong>${u.client || 'Client'}</strong></td>
        <td>${u.spec}</td>
        <td>${u.date}</td>
        <td>${u.time}</td>
        <td>${u.mode || 'Video Call'}</td>
        <td>$${u.fee}.00</td>
        <td>
          <button class="btn-gold" style="padding:6px 12px; font-size:0.75rem;" onclick="showToast('Launching ${u.mode || 'Video'} Lobby with ${u.client || 'Client'}…')">
            <i class="fas fa-video me-1"></i> Start Room
          </button>
        </td>
      </tr>`;
    });
    if(!upcoming.length) upcHtml = '<tr><td colspan="7" class="text-center text-muted">No upcoming appointments</td></tr>';
    $('#upcomingAppointmentsTable').html(upcHtml);

    // Render Completed Appointments
    const completed = appointments.filter(a => a.status && (a.status.toLowerCase() === 'completed' || a.status.toLowerCase() === 'cancelled'));
    let compHtml = '';
    completed.forEach(c => {
      let billingInfo = c.billing || `$${c.fee}.00 (Completed)`;
      let reviewInfo = c.review || 'No rating feedback';
      if (c.status.toLowerCase() === 'cancelled') {
        billingInfo = '<span class="text-danger">Cancelled</span>';
        reviewInfo = '<span class="text-muted">N/A</span>';
      }
      compHtml += `<tr>
        <td><strong>${c.client || 'Client'}</strong></td>
        <td>${c.spec}</td>
        <td>${c.date}</td>
        <td>${c.mode || 'Video Call'}</td>
        <td><strong style="color:var(--gold);">${billingInfo}</strong></td>
        <td><span style="font-family:var(--font-elegant); font-style:italic; font-size:0.9rem;">${reviewInfo}</span></td>
      </tr>`;
    });
    if(!completed.length) compHtml = '<tr><td colspan="6" class="text-center text-muted">No consultations history found</td></tr>';
    $('#completedAppointmentsTable').html(compHtml);

    // Render Schedule
    renderScheduleChips();
  }

  function renderScheduleChips() {
    const days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    let html = '';
    days.forEach(day => {
      const slots = weeklySchedule[day] || [];
      let chipsHtml = '';
      slots.forEach(slot => {
        chipsHtml += `<div class="editor-time-chip mb-2">
          ${slot}
          <button class="chip-remove-btn" onclick="removeSlot('${day}', '${slot}')">×</button>
        </div>`;
      });
      if(!slots.length) chipsHtml = '<div style="font-size:0.75rem; color:var(--text-muted); font-style:italic;">No slots added</div>';
      
      html += `<div class="col-md-4 col-lg-3">
        <div style="background:rgba(255,255,255,0.02); border:1px solid rgba(255,255,255,0.06); border-radius:10px; padding:1.2rem;">
          <h6 style="color:var(--gold); font-size:0.85rem; font-weight:700; margin-bottom:1rem; border-bottom:1px solid rgba(255,255,255,0.04); padding-bottom:6px;">${day}</h6>
          <div class="d-flex flex-column">${chipsHtml}</div>
        </div>
      </div>`;
    });
    $('#weeklyScheduleViewer').html(html);
  }

  // ──────────────── CONTROLLER ACTIONS ────────────────
  function switchTab(target, btn) {
    $('.menu-item').removeClass('active');
    $(btn).addClass('active');
    $('.panel-section').removeClass('active');
    $('#panel-' + target).addClass('active');
    $('#panelHeaderTitle').text($(btn).text().trim());
    $('#dashSidebar').removeClass('open');
    $('#sidebarOverlay').removeClass('open');
  }

  function toggleSidebar() {
    $('#dashSidebar').toggleClass('open');
    $('#sidebarOverlay').toggleClass('open');
  }

  function showToast(msg) {
    $('#toastMsg').text(msg);
    $('#toastBox').fadeIn(300);
    setTimeout(() => $('#toastBox').fadeOut(400), 2500);
  }

  function approveRequest(id) {
    const raw = localStorage.getItem(APPOINTMENTS_KEY);
    const list = raw ? JSON.parse(raw) : [];
    const req = list.find(a => a.id === id);
    if (req) {
      req.status = 'confirmed';
      req.fee = lawyerProfile.fee; // bind current rate
      localStorage.setItem(APPOINTMENTS_KEY, JSON.stringify(list));
      showToast('Appointment Request Approved!');
      renderAll();
    }
  }

  function rejectRequest(id) {
    const raw = localStorage.getItem(APPOINTMENTS_KEY);
    const list = raw ? JSON.parse(raw) : [];
    const req = list.find(a => a.id === id);
    if (req) {
      req.status = 'cancelled';
      localStorage.setItem(APPOINTMENTS_KEY, JSON.stringify(list));
      showToast('Appointment Request Rejected.');
      renderAll();
    }
  }

  function addScheduleSlot() {
    const day = $('#schedDay').val();
    const time = $('#schedTime').val();
    if(!weeklySchedule[day]) weeklySchedule[day] = [];
    if(weeklySchedule[day].includes(time)) {
      showToast('Slot already exists.');
      return;
    }
    weeklySchedule[day].push(time);
    // Sort times
    weeklySchedule[day].sort((a,b) => {
      return new Date('1970/01/01 ' + a) - new Date('1970/01/01 ' + b);
    });
    localStorage.setItem(SCHEDULE_KEY, JSON.stringify(weeklySchedule));
    showToast(`Slot added for ${day} at ${time}.`);
    renderScheduleChips();
  }

  function removeSlot(day, slot) {
    if(weeklySchedule[day]) {
      weeklySchedule[day] = weeklySchedule[day].filter(s => s !== slot);
      localStorage.setItem(SCHEDULE_KEY, JSON.stringify(weeklySchedule));
      showToast(`Removed availability slot.`);
      renderScheduleChips();
    }
  }

  function updateProfileHeadshot(input) {
    if (input.files && input.files[0]) {
      const reader = new FileReader();
      reader.onload = function(e) {
        lawyerProfile.headshot = e.target.result;
        localStorage.setItem(PROFILE_KEY, JSON.stringify(lawyerProfile));
        renderAll();
        showToast('Profile image updated.');
      }
      reader.readAsDataURL(input.files[0]);
    }
  }

  function saveProfileDetails(e) {
    e.preventDefault();
    lawyerProfile.name = $('#profName').val();
    lawyerProfile.spec = $('#profSpec').val();
    lawyerProfile.qual = $('#profQual').val();
    lawyerProfile.exp = parseInt($('#profExp').val()) || 0;
    lawyerProfile.barNum = $('#profBar').val();
    lawyerProfile.fee = parseInt($('#profFee').val()) || 0;
    lawyerProfile.city = $('#profCity').val();
    lawyerProfile.office = $('#profAddr').val();
    lawyerProfile.email = $('#profEmail').val();
    lawyerProfile.phone = $('#profPhone').val();
    lawyerProfile.bio = $('#profBio').val();
    
    localStorage.setItem(PROFILE_KEY, JSON.stringify(lawyerProfile));
    showToast('Profile details saved successfully!');
    renderAll();
  }

  $(document).ready(function() {
    renderAll();
  });
</script>
</body>
</html>
