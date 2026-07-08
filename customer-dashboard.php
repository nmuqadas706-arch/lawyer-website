<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="description" content="LexElite Client Hub — Manage consultations, search verified legal representatives, schedule appointments, and review case briefs."/>
  <title>Client Portal — LexElite | Legal Hub</title>

  <!-- Bootstrap 5 CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"/>
  <!-- Font Awesome 6 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
  <!-- AOS – Animate on Scroll -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css"/>
  <!-- Luxury Base CSS -->
  <link rel="stylesheet" href="css/luxury.css"/>
  <!-- Customer Dashboard-Specific CSS -->
  <link rel="stylesheet" href="css/customer-dashboard.css"/>
</head>
<body>

<!-- Mobile Sidebar Drawer Overlay -->
<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

<div class="dash-layout">

  <!-- ===================== SIDEBAR ===================== -->
  <aside class="dash-sidebar" id="dashSidebar">
    <!-- Brand Logo -->
    <div class="sidebar-brand">
      <a class="navbar-brand-logo text-decoration-none" href="index.html" style="display:inline-flex;">
        <div class="brand-icon" style="width:36px; height:36px; font-size:1rem;"><i class="fas fa-balance-scale"></i></div>
        <div class="ms-2">
          <span class="brand-text-main" style="font-size:1.1rem;">LexElite</span>
          <span class="brand-text-sub" style="font-size:0.5rem; letter-spacing:0.2em;">Client Hub</span>
        </div>
      </a>
    </div>

    <!-- Active User Card -->
    <div class="sidebar-user">
      <div id="sideAvatarWrap" style="width:44px; height:44px; border-radius:50%; background:var(--gold-gradient); display:flex; align-items:center; justify-content:center; color:var(--dark); font-weight:800; font-size:1rem; flex-shrink:0; overflow:hidden;">
        EV
      </div>
      <div>
        <div style="font-size:0.85rem; font-weight:700; color:var(--white);" id="clientSideName">Eleanor Vance</div>
        <div style="font-size:0.68rem; color:var(--gold); font-weight:600;" id="clientSideTier">Premium Client</div>
      </div>
    </div>

    <!-- Sidebar Menu Options -->
    <div class="sidebar-menu">
      <div class="menu-title">Account Workspace</div>
      <div class="menu-item active" onclick="switchTab('dashboard', this)"><i class="fas fa-th-large"></i> Dashboard</div>
      <div class="menu-item" onclick="switchTab('search-lawyers', this)"><i class="fas fa-search"></i> Search Lawyers</div>
      <div class="menu-item" onclick="switchTab('appointments', this)"><i class="fas fa-calendar-check"></i> My Appointments</div>
      <div class="menu-item" onclick="switchTab('profile-settings', this)"><i class="fas fa-sliders-h"></i> Profile Settings</div>

      <div class="menu-title">Exit Portal</div>
      <div class="menu-item" onclick="window.location.href='index.html'"><i class="fas fa-home"></i> Back to Homepage</div>
      <div class="menu-item" onclick="window.location.href='customer-login.html'" style="color:#ef4444;"><i class="fas fa-sign-out-alt"></i> Log Out</div>
    </div>
  </aside>

  <!-- ===================== MAIN SECTION ===================== -->
  <div class="dash-main">
    <!-- Top Header / Navbar -->
    <header class="dash-header">
      <div class="d-flex align-items-center gap-3">
        <!-- Sidebar Toggle Trigger -->
        <button class="topbar-btn d-lg-none" onclick="toggleSidebar()" style="background:none; border:none; color:var(--white); font-size:1.2rem;">
          <i class="fas fa-bars"></i>
        </button>
        <h2 style="font-family:var(--font-serif); font-size:1.3rem; font-weight:700; margin:0;" id="panelHeaderTitle">Dashboard Overview</h2>
      </div>

      <!-- Quick Actions / Alerts -->
      <div class="d-flex align-items-center gap-3">
        <div class="dropdown">
          <button class="action-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="position:relative;">
            <i class="fas fa-bell"></i>
            <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle" style="width: 8px; height: 8px;"></span>
          </button>
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark bg-dark-card border border-gold border-1 shadow-lg" style="width: 280px; font-size:0.8rem; padding: 8px 0;">
            <li class="px-3 py-2 border-bottom border-secondary"><strong class="text-gold">Notifications</strong></li>
            <li><a class="dropdown-menu-item dropdown-item py-2" href="#" onclick="switchTab('appointments'); return false;" style="white-space:normal; font-size:0.75rem; color:var(--white);">Consultation with Dr. Marcus Chen confirmed for July 8.</a></li>
            <li><a class="dropdown-menu-item dropdown-item py-2" href="#" onclick="switchTab('appointments'); return false;" style="white-space:normal; font-size:0.75rem; color:var(--white);">Welcome to the new LexElite premium client workspace!</a></li>
          </ul>
        </div>

        <div id="topAvatarWrap" style="width:36px; height:36px; border-radius:50%; background:var(--gold-gradient); display:flex; align-items:center; justify-content:center; color:var(--dark); font-weight:800; font-size:0.85rem; overflow:hidden;" onclick="switchTab('profile-settings')">
          EV
        </div>
      </div>
    </header>

    <!-- Main Content Area -->
    <div class="dash-content">

      <!-- ===================== PANEL: OVERVIEW ===================== -->
      <div class="panel-section active" id="panel-dashboard">
        
        <!-- Welcome Hero Banner -->
        <div style="background:linear-gradient(135deg, var(--navy) 0%, var(--navy-mid) 100%); border:1px solid rgba(201, 168, 76, 0.2); border-radius:12px; padding:2rem; margin-bottom:2rem;">
          <h3 style="font-family:var(--font-serif); font-size:1.4rem; font-weight:700; color:var(--white); margin-bottom:0.4rem;" id="clientWelcomeName">Welcome back, Eleanor Vance</h3>
          <p style="font-size:0.85rem; color:rgba(255, 255, 255, 0.7); margin:0;">
            You have <strong style="color:var(--gold)">1 confirmed consultation</strong> this week. Find attorneys, manage schedules, and launch video counseling directly from this portal.
          </p>
        </div>

        <!-- Dashboard Cards -->
        <div class="grid-stats">
          <div class="stat-box">
            <div class="stat-box-icon"><i class="fas fa-calendar-check"></i></div>
            <div>
              <div class="stat-box-val" id="statTotalAppts">4</div>
              <div class="stat-box-label">Total Bookings</div>
            </div>
          </div>
          <div class="stat-box">
            <div class="stat-box-icon"><i class="fas fa-check-circle"></i></div>
            <div>
              <div class="stat-box-val" id="statActiveAppts">1</div>
              <div class="stat-box-label">Active Rooms</div>
            </div>
          </div>
          <div class="stat-box">
            <div class="stat-box-icon"><i class="fas fa-clock"></i></div>
            <div>
              <div class="stat-box-val" id="statPendingAppts">1</div>
              <div class="stat-box-label">Pending Requests</div>
            </div>
          </div>
          <div class="stat-box">
            <div class="stat-box-icon"><i class="fas fa-gem"></i></div>
            <div>
              <div class="stat-box-val" style="font-size:1.2rem; font-weight:800; padding:4px 0;" id="clientSideEmail">Premium Member</div>
              <div class="stat-box-label">Account Level</div>
            </div>
          </div>
        </div>

        <!-- Next Consultation spotlight card -->
        <div class="dash-card mb-4" style="border-color: rgba(201, 168, 76, 0.35); background: rgba(201, 168, 76, 0.02);">
          <div class="dash-card-title text-gold" style="font-size:0.9rem; font-weight:700; letter-spacing:0.08em; text-transform:uppercase; margin-bottom:1rem;">
            <span><i class="fas fa-bolt me-2"></i>Next Scheduled consultation</span>
            <span style="font-size:0.8rem; color:var(--white);" id="nextConsultationTime">2026-07-08 at 10:00 AM</span>
          </div>
          <div id="nextApptSpotlightCard">
            <!-- Populated dynamically -->
          </div>
        </div>

        <!-- Recent Booking Table -->
        <div class="dash-card">
          <div class="dash-card-title">
            <span>Recent Appointment Requests</span>
            <button class="btn-gold" style="padding:6px 14px; font-size:0.7rem;" onclick="switchTab('search-lawyers')">
              <i class="fas fa-plus me-1"></i> Book New Case
            </button>
          </div>
          <div style="overflow-x:auto;">
            <table class="lux-table">
              <thead>
                <tr>
                  <th>Appointment ID</th>
                  <th>Lawyer Name</th>
                  <th>Practice Area</th>
                  <th>Scheduled Date &amp; Time</th>
                  <th>Hourly rate</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody id="recentApptsTableBody">
                <!-- Populated dynamically -->
              </tbody>
            </table>
          </div>
        </div>

      </div>

      <!-- ===================== PANEL: SEARCH LAWYERS ===================== -->
      <div class="panel-section" id="panel-search-lawyers">
        
        <!-- Interactive Quad-Search Bar -->
        <div class="lawyer-search-bar">
          <div class="row g-3">
            <div class="col-md-5">
              <label class="form-label" style="font-size:0.75rem; font-weight:700; text-transform:uppercase; color:var(--gold); letter-spacing:0.05em;">Attorney Name</label>
              <div class="input-group">
                <span class="input-group-text bg-transparent text-gold border-secondary"><i class="fas fa-search"></i></span>
                <input type="text" class="form-control bg-transparent text-white border-secondary" id="searchLawyerInput" placeholder="e.g. Marcus Chen...">
              </div>
            </div>
            <div class="col-sm-6 col-md-4">
              <label class="form-label" style="font-size:0.75rem; font-weight:700; text-transform:uppercase; color:var(--gold); letter-spacing:0.05em;">Practice Area</label>
              <select class="form-select bg-dark text-white border-secondary" id="filterSpecialization" style="background-color: var(--dark-card) !important;">
                <option value="all">All Specializations</option>
                <option value="criminal">Criminal Law</option>
                <option value="corporate">Corporate Law</option>
                <option value="divorce">Divorce &amp; Family</option>
                <option value="property">Property Law</option>
                <option value="immigration">Immigration</option>
                <option value="civil">Civil Law</option>
                <option value="affidavit">Affidavit</option>
                <option value="tax">Tax Law</option>
              </select>
            </div>
            <div class="col-sm-6 col-md-3">
              <label class="form-label" style="font-size:0.75rem; font-weight:700; text-transform:uppercase; color:var(--gold); letter-spacing:0.05em;">Sort By</label>
              <select class="form-select bg-dark text-white border-secondary" id="sortLawyers" style="background-color: var(--dark-card) !important;">
                <option value="rating">Top Rated (Default)</option>
                <option value="price-asc">Price: Low to High</option>
                <option value="price-desc">Price: High to Low</option>
              </select>
            </div>
          </div>
        </div>

        <!-- Lawyer Cards Grid -->
        <div class="row g-4" id="lawyersGridRow">
          <!-- Dynamically filled by JS -->
        </div>

      </div>

      <!-- ===================== PANEL: APPOINTMENTS ===================== -->
      <div class="panel-section" id="panel-appointments">
        
        <!-- Tab status Filters -->
        <div class="tab-filter-container">
          <div class="tab-filter-btn active" data-filter="all" onclick="handleAppointmentFilter(this)">All Bookings</div>
          <div class="tab-filter-btn" data-filter="pending" onclick="handleAppointmentFilter(this)">Awaiting Approval</div>
          <div class="tab-filter-btn" data-filter="confirmed" onclick="handleAppointmentFilter(this)">Confirmed</div>
          <div class="tab-filter-btn" data-filter="completed" onclick="handleAppointmentFilter(this)">Completed</div>
          <div class="tab-filter-btn" data-filter="cancelled" onclick="handleAppointmentFilter(this)">Cancelled</div>
        </div>

        <!-- Table Card -->
        <div class="dash-card">
          <div class="dash-card-title">Consultations Ledger</div>
          <div style="overflow-x:auto;">
            <table class="lux-table table table-dark table-hover align-middle mb-0">
              <thead>
                <tr>
                  <th>Appointment ID</th>
                  <th>Lawyer Name</th>
                  <th>Practice Area</th>
                  <th>Scheduled Date &amp; Time</th>
                  <th>Total retainer fee</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody id="appointmentsTableBody">
                <!-- Populated dynamically -->
              </tbody>
            </table>
          </div>
        </div>

      </div>

      <!-- ===================== PANEL: APPOINTMENT DETAILS ===================== -->
      <div class="panel-section" id="panel-appointment-details">
        
        <div class="mb-3">
          <button class="btn-outline-gold" style="padding:6px 16px; font-size:0.75rem;" onclick="switchTab('appointments')">
            <i class="fas fa-arrow-left me-2"></i>Back to My Appointments
          </button>
        </div>

        <div class="row g-4">
          
          <!-- Column 1: Attorney Profile Spotlight -->
          <div class="col-lg-5">
            <div class="dash-card text-center">
              <div class="dash-card-title" style="justify-content:center;">Assigned Counsel</div>
              <div class="round-headshot-preview" style="width:110px; height:110px;">
                <img src="" alt="Lawyer photo" id="detLawyerImg">
              </div>
              <h4 style="font-family:var(--font-serif); font-size:1.3rem; margin-bottom:4px;" id="detLawyerName">Dr. Marcus Chen</h4>
              <p style="color:var(--gold); font-size:0.78rem; text-transform:uppercase; font-weight:700; letter-spacing:0.08em;" id="detLawyerSpec">Corporate Law Specialist</p>
              
              <div class="text-start mt-4 pt-3 border-top border-secondary" style="font-size:0.82rem; line-height:1.8;">
                <div class="mb-2"><i class="fas fa-map-marker-alt text-gold me-2" style="width:18px;"></i> <span id="detLawyerLoc">New York, NY</span></div>
                <div class="mb-2"><i class="fas fa-envelope text-gold me-2" style="width:18px;"></i> <span id="detLawyerMail">chen@lexelite.com</span></div>
                <div><i class="fas fa-shield-halved text-gold me-2" style="width:18px;"></i> Verified Legal Practitioner</div>
              </div>
            </div>
          </div>

          <!-- Column 2: Appointment Details -->
          <div class="col-lg-7">
            <div class="dash-card">
              <div class="dash-card-title">
                <span>Appointment Summary</span>
                <span class="badge-status badge-Confirmed" id="detStatusBadge">Confirmed</span>
              </div>

              <div class="row g-3 mb-4" style="font-size:0.85rem;">
                <div class="col-6 col-sm-3">
                  <div style="color:var(--text-muted); font-size:0.7rem; text-transform:uppercase;">Appt ID</div>
                  <strong style="color:var(--white);" id="detApptId">APT-9041</strong>
                </div>
                <div class="col-6 col-sm-3">
                  <div style="color:var(--text-muted); font-size:0.7rem; text-transform:uppercase;">Date</div>
                  <strong style="color:var(--white);" id="detDate">2026-07-08</strong>
                </div>
                <div class="col-6 col-sm-3">
                  <div style="color:var(--text-muted); font-size:0.7rem; text-transform:uppercase;">Time Slot</div>
                  <strong style="color:var(--white);" id="detTime">10:00 AM</strong>
                </div>
                <div class="col-6 col-sm-3">
                  <div style="color:var(--text-muted); font-size:0.7rem; text-transform:uppercase;">Total Charge</div>
                  <strong style="color:var(--gold);" id="detFee">$500.00</strong>
                </div>
              </div>

              <div class="mb-4">
                <div style="color:var(--text-muted); font-size:0.7rem; text-transform:uppercase; margin-bottom:4px;">Billing Payment Method</div>
                <div style="font-size:0.85rem; color:var(--white);"><i class="fas fa-credit-card me-2"></i> <span id="detPayMethod">Visa ending in 9012</span></div>
              </div>

              <div class="mb-4">
                <div style="color:var(--text-muted); font-size:0.7rem; text-transform:uppercase; margin-bottom:4px;">Case Description Brief</div>
                <div style="font-size:0.85rem; color:rgba(255,255,255,0.85); background:rgba(255,255,255,0.02); border:1px solid rgba(255,255,255,0.05); padding:1rem; border-radius:8px;" id="detBrief">
                  Consultation for Series-A investment documentation and IP licensing clauses.
                </div>
              </div>

              <!-- Launch Lobby Block -->
              <div class="mb-4" id="detailsVideoRoomBlock">
                <!-- Rendered dynamically -->
              </div>

              <div class="d-flex gap-2 flex-wrap pt-3 border-top border-secondary">
                <button class="btn-outline-gold" style="padding:10px 22px; font-size:0.8rem;" onclick="triggerReschedule()">
                  <i class="fas fa-redo me-2"></i>Reschedule Slot
                </button>
                <button class="btn-gold bg-danger text-white border-0" id="detailsCancelBtn" style="padding:10px 22px; font-size:0.8rem; box-shadow:none;" onclick="cancelCurrentAppointment()">
                  <i class="fas fa-ban me-2"></i>Cancel Appointment
                </button>
              </div>

            </div>
          </div>

        </div>

      </div>

      <!-- ===================== PANEL: PROFILE SETTINGS ===================== -->
      <div class="panel-section" id="panel-profile-settings">
        
        <div class="row g-4">
          <!-- Left Col: Photo edit -->
          <div class="col-lg-4">
            <div class="dash-card text-center">
              <div class="dash-card-title" style="justify-content:center;">Client Avatar Picture</div>
              
              <div class="round-headshot-preview">
                <img src="" alt="Client photo" id="profileHeadshotPreview">
              </div>
              
              <div class="photo-uploader-card" onclick="$('#avatarFileInput').click()">
                <i class="fas fa-cloud-upload-alt" style="font-size:1.6rem; color:var(--gold); display:block; margin-bottom:8px;"></i>
                <span style="font-size:0.8rem; color:var(--white); font-weight:600; display:block;">Change Photo</span>
                <span style="font-size:0.65rem; color:var(--text-muted);">JPG/PNG up to 2MB</span>
              </div>
              <input type="file" id="avatarFileInput" accept="image/*" style="display:none;" onchange="updateProfileHeadshot(this)">
            </div>
          </div>

          <!-- Right Col: Profile fields Form -->
          <div class="col-lg-8">
            <div class="dash-card mb-4">
              <div class="dash-card-title">Client Account Details</div>
              <form id="clientProfileForm" onsubmit="saveClientProfile(event)">
                <div class="row g-3">
                  <div class="col-md-6">
                    <div class="form-field-luxury">
                      <label for="profName">Full Name</label>
                      <input type="text" class="luxury-input form-control" id="profName" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-field-luxury">
                      <label for="profEmail">Email Address</label>
                      <input type="email" class="luxury-input form-control" id="profEmail" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-field-luxury">
                      <label for="profPhone">Phone Number</label>
                      <input type="tel" class="luxury-input form-control" id="profPhone" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-field-luxury">
                      <label for="profLang">Preferred Language</label>
                      <select class="luxury-input form-control" id="profLang" style="background-color:var(--dark-card);">
                        <option>English</option>
                        <option>Spanish</option>
                        <option>French</option>
                        <option>German</option>
                        <option>Mandarin</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-field-luxury">
                      <label for="profPref">Preferred Consultation Mode</label>
                      <select class="luxury-input form-control" id="profPref" style="background-color:var(--dark-card);">
                        <option>Video Call</option>
                        <option>Phone Call</option>
                        <option>In-Office Consultation</option>
                      </select>
                    </div>
                  </div>
                </div>
                <button type="submit" class="btn-gold mt-3" style="padding:12px 30px;"><i class="fas fa-save me-2"></i>Save Settings</button>
              </form>
            </div>

            <!-- Change Password Card -->
            <div class="dash-card">
              <div class="dash-card-title">Security &amp; Encryption</div>
              <form id="clientPasswordForm" onsubmit="saveSecurityPassword(event)">
                <div class="row g-3">
                  <div class="col-md-4">
                    <div class="form-field-luxury">
                      <label for="curPass">Current Password</label>
                      <input type="password" class="luxury-input form-control" id="curPass" placeholder="••••••••" required>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-field-luxury">
                      <label for="newPass">New Password</label>
                      <input type="password" class="luxury-input form-control" id="newPass" placeholder="••••••••" required>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-field-luxury">
                      <label for="confPass">Confirm New Password</label>
                      <input type="password" class="luxury-input form-control" id="confPass" placeholder="••••••••" required>
                    </div>
                  </div>
                </div>
                <button type="submit" class="btn-gold mt-3" style="padding:12px 30px;"><i class="fas fa-shield-alt me-2"></i>Update Password</button>
              </form>
            </div>
          </div>
        </div>

      </div>

    </div>
  </div>
</div>

<!-- ===================== BOOKING MODAL ===================== -->
<div class="modal fade modal-luxury" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="bookingModalLabel"><i class="fas fa-calendar-check text-gold me-2"></i>Request Consultation Booking</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-white">
        <div class="row align-items-center mb-4">
          <div class="col-sm-3 text-center">
            <img src="" class="rounded-circle border border-gold" id="modalLawyerImg" style="width: 90px; height: 90px; object-fit: cover;">
          </div>
          <div class="col-sm-9 text-center text-sm-start mt-2 mt-sm-0">
            <h4 style="font-family:var(--font-serif); margin-bottom:4px;" id="modalLawyerName">Alexandra Harrington</h4>
            <p style="color:var(--gold); font-size:0.8rem; font-weight:700; text-transform:uppercase; margin-bottom:8px;" id="modalLawyerSpec">Criminal Law Specialist</p>
            <div style="font-size:0.85rem; color:var(--text-muted);">
              Hourly Retainer Rate: <strong class="text-white" id="modalLawyerPrice">$350/hr</strong>
            </div>
          </div>
        </div>

        <!-- Date selector -->
        <div class="mb-4">
          <div class="slot-selection-title">1. Select Available Date</div>
          <div class="row g-2" id="bookingModalDateRow">
            <!-- Dynamically populated dates -->
          </div>
        </div>

        <!-- Time selector -->
        <div class="mb-4">
          <div class="slot-selection-title">2. Select Hour Slot</div>
          <div class="row g-2" id="bookingModalTimeRow">
            <!-- Dynamically populated time chips -->
          </div>
        </div>

        <!-- Case details description -->
        <div class="mb-3">
          <div class="slot-selection-title">3. Enter Case Brief (Confidential)</div>
          <textarea class="luxury-input form-control" id="caseDescriptionInput" rows="3" placeholder="Briefly describe your legal concerns so the attorney can prepare..." style="font-size:0.85rem; resize:none;"></textarea>
        </div>

        <div class="text-muted" style="font-size:0.7rem;">
          <i class="fas fa-shield-halved text-gold me-1"></i> Under state law, all consultation details are fully covered by attorney-client privilege.
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-outline-gold" style="padding:10px 20px; font-size:0.8rem;" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn-gold" style="padding:10px 24px; font-size:0.8rem;" onclick="confirmConsultationBooking()">
          <i class="fas fa-check-circle me-1"></i>Confirm Booking Request
        </button>
      </div>
    </div>
  </div>
</div>

<!-- ===================== TOAST BOX ===================== -->
<div id="toastBox" style="position:fixed; bottom:30px; left:50%; transform:translateX(-50%); z-index:9999; display:none;">
  <div style="background:var(--gold-gradient); color:var(--dark); font-weight:700; padding:12px 24px; border-radius:50px; font-size:0.85rem; box-shadow:0 8px 24px rgba(201,168,76,0.4);">
    <i class="fas fa-check-circle me-2"></i><span id="toastMsg">Action complete!</span>
  </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Platform Static Databases -->
<script src="js/data.js"></script>
<!-- Customer Dashboard Control Logic -->
<script src="js/customer-dashboard.js"></script>
</body>
</html>
