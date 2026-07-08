<?php
include_once 'includes/connection.php';
session_start();


if(!isset($_SESSION['admin_id'])){
    header("Location: admin-login.php");
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="description" content="LexElite Administrative Workspace — Platform management, verify lawyers, audit transactions, and view analytics reports."/>
  <title>Admin Dashboard — LexElite | System Center</title>
  <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>⚖️</text></svg>">

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome 6 -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;0,900;1,400&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <!-- Luxury Base CSS -->
  <link rel="stylesheet" href="css/luxury.css">
  <!-- Admin Specific CSS -->
  <link rel="stylesheet" href="css/admin.css">
</head>
<body>

<!-- Mobile Sidebar Drawer Overlay -->
<div class="sidebar-overlay" id="sidebarOverlay" onclick="$('#sidebar').removeClass('open'); $('#sidebarOverlay').removeClass('open');"></div>

<div class="dash-layout">

  <!-- ===================== SIDEBAR ===================== -->
  <aside class="dash-sidebar" id="sidebar">
    <!-- Brand Info -->
    <div class="sidebar-brand">
      <a class="navbar-brand-logo text-decoration-none" href="index.html" style="display:inline-flex;">
        <div class="brand-icon" style="width:36px; height:36px; font-size:1rem;"><i class="fas fa-balance-scale"></i></div>
        <div class="ms-2">
          <span class="brand-text-main" style="font-size:1.1rem;">LexElite</span>
          <span class="brand-text-sub" style="font-size:0.5rem; letter-spacing:0.2em;">Admin Panel</span>
        </div>
      </a>
    </div>

    <!-- Active Admin Headshot -->
    <div class="sidebar-user">
      <div style="width:46px; height:46px; border-radius:50%; background:var(--gold-gradient); display:flex; align-items:center; justify-content:center; color:var(--dark); font-weight:800; font-size:1.1rem; flex-shrink:0;">
        AD
      </div>
      <div>
        <div style="font-size:0.86rem; font-weight:700; color:var(--white);">Platform Admin</div>
        <div style="font-size:0.68rem; color:var(--gold); font-weight:600;">Super Administrator</div>
      </div>
    </div>

    <!-- Navigation Menu Items -->
    <div class="sidebar-menu">
      <div class="menu-title">Control Room</div>
      <div class="menu-item active" data-target="overview" onclick="switchPanel('overview', this)"><i class="fas fa-chart-line"></i> Dashboard Overview</div>
      <div class="menu-item" data-target="lawyers" onclick="switchPanel('lawyers', this)">
        <i class="fas fa-user-tie"></i> Manage Lawyers
        <span class="badge bg-danger ms-auto rounded-pill" style="font-size:0.65rem; display:none;" id="lawyerPendingBadge">0</span>
      </div>
      <div class="menu-item" data-target="clients" onclick="switchPanel('clients', this)"><i class="fas fa-users"></i> Manage Clients</div>
      <div class="menu-item" data-target="services" onclick="switchPanel('services', this)"><i class="fas fa-gavel"></i> Manage Services</div>
      <div class="menu-item" data-target="appointments" onclick="switchPanel('appointments', this)"><i class="fas fa-calendar-check"></i> Manage Appointments</div>

      <div class="menu-title">Business Analytics</div>
      <div class="menu-item" data-target="reports" onclick="switchPanel('reports', this)"><i class="fas fa-chart-bar"></i> Reports &amp; Charts</div>

      <div class="menu-title">Exit</div>
      <div class="menu-item" onclick="window.location.href='index.php'"><i class="fas fa-home"></i> Back to Homepage</div>
      <div class="menu-item" onclick="window.location.href='admin-logout.php'" style="color:#ef4444;"><i class="fas fa-sign-out-alt"></i> Log Out</div>
    </div>
  </aside>

  <!-- ===================== MAIN REGION ===================== -->
  <div class="dash-main">
    <!-- Top Header -->
    <header class="dash-header">
      <div class="d-flex align-items-center gap-3">
        <button class="topbar-btn d-lg-none" onclick="$('#sidebar').toggleClass('open'); $('#sidebarOverlay').toggleClass('open');" style="background:none; border:none; color:var(--white); font-size:1.2rem;"><i class="fas fa-bars"></i></button>
        <h2 style="font-family:var(--font-serif); font-size:1.3rem; font-weight:700; margin:0;" id="panelTitle">Dashboard Overview</h2>
      </div>
      <div class="d-flex align-items-center gap-3">
        <span style="font-size:0.8rem; color:var(--text-muted);"><i class="fas fa-circle text-success me-1"></i> System Online</span>
        <div style="width:36px; height:36px; border-radius:50%; background:var(--gold-gradient); display:flex; align-items:center; justify-content:center; color:var(--dark); font-weight:800; font-size:0.9rem;">
          AD
        </div>
      </div>
    </header>

    <!-- Content Workspace -->
    <div class="dash-content">

      <!-- ===================== PANEL: OVERVIEW ===================== -->
      <div class="panel-section active" id="sec-overview">
        <!-- Overview Stats Grid -->
        <div class="grid-stats">
          <div class="stat-box">
            <div class="stat-box-icon"><i class="fas fa-user-tie"></i></div>
            <div>
              <div class="stat-box-val" id="statTotalLawyers">0</div>
              <div class="stat-box-label">Attorneys</div>
            </div>
          </div>
          <div class="stat-box">
            <div class="stat-box-icon"><i class="fas fa-users"></i></div>
            <div>
              <div class="stat-box-val" id="statTotalClients">0</div>
              <div class="stat-box-label">Clients</div>
            </div>
          </div>
          <div class="stat-box">
            <div class="stat-box-icon"><i class="fas fa-calendar-check"></i></div>
            <div>
              <div class="stat-box-val" id="statTotalBookings">0</div>
              <div class="stat-box-label">Total Bookings</div>
            </div>
          </div>
          <div class="stat-box">
            <div class="stat-box-icon"><i class="fas fa-wallet"></i></div>
            <div>
              <div class="stat-box-val" id="statPlatformCommission">$0</div>
              <div class="stat-box-label">Plat. Commission</div>
            </div>
          </div>
        </div>

        <!-- Analytical Graphs Row -->
        <div class="row g-4 mb-4">
          <div class="col-lg-7">
            <div class="dash-card">
              <div class="dash-card-title">Consultations Revenue Growth</div>
              <div class="chart-box-wrap">
                <canvas id="chartRevenueTrend"></canvas>
              </div>
            </div>
          </div>
          <div class="col-lg-5">
            <div class="dash-card">
              <div class="dash-card-title">Consultations Shares by Specialization</div>
              <div class="chart-box-wrap">
                <canvas id="chartCategoryShare"></canvas>
              </div>
            </div>
          </div>
        </div>

        <!-- Recent Booking Table -->
        <div class="dash-card">
          <div class="dash-card-title">Recent Consultations Request Activity</div>
          <div style="overflow-x:auto;">
            <table class="lux-table">
              <thead>
                <tr>
                  <th>Appointment ID</th>
                  <th>Lawyer Name</th>
                  <th>Client Name</th>
                  <th>Scheduled Date</th>
                  <th>hourly Price</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody id="recentAppointmentsTable">
                <!-- Loaded dynamically -->
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- ===================== PANEL: MANAGE LAWYERS ===================== -->
      <div class="panel-section" id="sec-lawyers">
        <div class="dash-card">
          <div class="dash-card-title">Legal Practitioners Directory</div>
          
          <!-- Search & Filter Area -->
          <div class="row g-3 mb-4">
            <div class="col-md-6">
              <input type="text" class="luxury-input form-control" id="searchLawyerInput" placeholder="Search lawyer by name...">
            </div>
            <div class="col-md-6">
              <select class="luxury-input form-control" id="filterLawyerStatus" style="background-color: var(--dark-card);">
                <option value="all">All Verification Statuses</option>
                <option value="active">Active Verified</option>
                <option value="pending">Pending Review</option>
                <option value="suspended">Suspended</option>
              </select>
            </div>
          </div>

          <!-- Table -->
          <div style="overflow-x:auto;">
            <table class="lux-table table table-dark table-hover align-middle mb-0">
              <thead>
                <tr>
        <th>ID</th>
        <th>Full Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Password</th>
        <th>Specialization</th>
        <th>Qualification</th>
        <th>Experience</th>
        <th>City</th>
        <th>Address</th>
        <th>CNIC-NO</th>
        <th>profile_image</th>
        <th>Consultation Fee</th>
        <th>Status</th>
        <th>Registered Date</th>
        <th>Actions</th>
                </tr>
              </thead>
              <tbody >
               <?php
               
                $query = "SELECT * FROM lawyers";
                $result = mysqli_query($conn, $query);

                 foreach($result as $row) {
                  
                    echo "<tr>";
                    echo "<td>".$row['lawyer_id']."</td>";
                    echo "<td>".$row['full_name']."</td>";
                    echo "<td>".$row['email']."</td>";
                    echo "<td>".$row['phone']."</td>";
                    echo "<td>".$row['password']."</td>";
                    echo "<td>".$row['specialization']."</td>";
                    echo "<td>".$row['qualification']."</td>";
                    echo "<td>".$row['experience']."</td>";
                    echo "<td>".$row['city']."</td>";
                    echo "<td>".$row['address']."</td>";
                    echo "<td>".$row['cnic_no']."</td>";
                   echo "<td>
<img src='uploads/".$row['profile_image']."'
style='width:50px;height:50px;object-fit:cover;border-radius:50%;'>
</td>";
                    echo "<td>".$row['consultation_fee']."</td>";
                    echo "<td>".$row['status']."</td>";
                    echo "<td>".$row['created_at']."</td>";
                    echo "<td>
                            <button class='btn btn-sm btn-success me-1' onclick='verifyLawyer(".$row['lawyer_id'].")'>Verify</button>
                            <button class='btn btn-sm btn-danger' onclick='suspendLawyer(".$row['lawyer_id'].")'>Suspend</button>
                          </td>";
                    echo "</tr>";
                  }

                ?>
               
               
               
               
              
              </tbody>
            </table>
          </div>

          <!-- Pagination -->
          <nav class="d-flex justify-content-between align-items-center mt-4">
            <div style="font-size:0.8rem; color:var(--text-muted);">Showing 5 practitioners per page</div>
            <ul class="pagination pagination-luxury mb-0" id="lawyersPagination">
              <!-- Loaded dynamically -->
            </ul>
          </nav>
        </div>
      </div>

      <!-- ===================== PANEL: MANAGE CLIENTS ===================== -->
      <div class="panel-section" id="sec-clients">
        <div class="dash-card">
          <div class="dash-card-title">Registered Customers ledger</div>

          <!-- Search Bar -->
          <div class="row g-3 mb-4">
            <div class="col-md-6">
              <input type="text" class="luxury-input form-control" id="searchCustomerInput" placeholder="Search client by name or email address...">
            </div>
          </div>

          <!-- Table -->
          <div style="overflow-x:auto;">
            <table class="lux-table table table-dark table-hover align-middle mb-0">
              <thead>
                <tr>
                  <th>Customer ID</th>
                  <th>Client Name</th>
                  <th>Email Address</th>
                  <th>Registration Date</th>
                  <th>Bookings Count</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody id="customersTableBody">
                <!-- Loaded dynamically -->
              </tbody>
            </table>
          </div>

          <!-- Pagination -->
          <nav class="d-flex justify-content-between align-items-center mt-4">
            <div style="font-size:0.8rem; color:var(--text-muted);">Showing 5 clients per page</div>
            <ul class="pagination pagination-luxury mb-0" id="customersPagination">
              <!-- Loaded dynamically -->
            </ul>
          </nav>
        </div>
      </div>

      <!-- ===================== PANEL: MANAGE SERVICES ===================== -->
      <div class="panel-section" id="sec-services">
        <div class="dash-card">
          <div class="dash-card-title">
            <span>Retainers Service Categories (Practice Areas)</span>
            <button class="btn-gold" style="padding:8px 18px; font-size:0.8rem;" onclick="openAddServiceModal()">
              <i class="fas fa-plus me-2"></i>Configure Service
            </button>
          </div>

          <!-- Table -->
          <div style="overflow-x:auto;">
            <table class="lux-table table table-dark table-hover align-middle mb-0">
              <thead>
                <tr>
                  <th>Service ID</th>
                  <th>Icon visual</th>
                  <th>Category Title</th>
                  <th>System Slug</th>
                  <th>Primary Hex Color</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody id="servicesTableBody">
                <!-- Loaded dynamically -->
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- ===================== PANEL: MANAGE APPOINTMENTS ===================== -->
      <div class="panel-section" id="sec-appointments">
        <div class="dash-card">
          <div class="dash-card-title">Consultations Booking Logs</div>

          <!-- Search / Filters -->
          <div class="row g-3 mb-4">
            <div class="col-md-6">
              <input type="text" class="luxury-input form-control" id="searchApptInput" placeholder="Search by lawyer or client name...">
            </div>
            <div class="col-md-6">
              <select class="luxury-input form-control" id="filterApptStatus" style="background-color: var(--dark-card);">
                <option value="all">All Consultation Statuses</option>
                <option value="pending">Pending Approval</option>
                <option value="confirmed">Confirmed / Active</option>
                <option value="completed">Completed History</option>
                <option value="cancelled">Cancelled</option>
              </select>
            </div>
          </div>

          <!-- Table -->
          <div style="overflow-x:auto;">
            <table class="lux-table table table-dark table-hover align-middle mb-0">
              <thead>
                <tr>
                  <th>Booking ID</th>
                  <th>Assigned Lawyer</th>
                  <th>Client Customer</th>
                  <th>Scheduled Date &amp; Time</th>
                  <th>Total Fee</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody id="appointmentsTableBody">
                <!-- Loaded dynamically -->
              </tbody>
            </table>
          </div>

          <!-- Pagination -->
          <nav class="d-flex justify-content-between align-items-center mt-4">
            <div style="font-size:0.8rem; color:var(--text-muted);">Showing 5 logs per page</div>
            <ul class="pagination pagination-luxury mb-0" id="appointmentsPagination">
              <!-- Loaded dynamically -->
            </ul>
          </nav>
        </div>
      </div>

      <!-- ===================== PANEL: REPORTS ===================== -->
      <div class="panel-section" id="sec-reports">
        <div class="row g-4">
          <!-- Col 1: Graphic Analytics -->
          <div class="col-lg-8">
            <div class="dash-card">
              <div class="dash-card-title">Platform Practice-wise Generated Revenue</div>
              <div class="chart-box-wrap" style="height:320px;">
                <canvas id="chartReportsRevenue"></canvas>
              </div>
            </div>
          </div>
          <!-- Col 2: Top Lists -->
          <div class="col-lg-4">
            <div class="dash-card" style="height:100%;">
              <div class="dash-card-title">Top Consultation Performers</div>
              <div id="topPerformingAttorneys" class="pt-2">
                <!-- Loaded dynamically -->
              </div>
            </div>
          </div>

          <!-- Financial insights and triggers -->
          <div class="col-12">
            <div class="dash-card">
              <div class="dash-card-title">Export Audits &amp; Financial Sheets</div>
              <p style="font-size:0.84rem; color:var(--text-muted);">Compile global auditing records including verified lawyer payouts, platform commission retentions (15%), and cancelled booking transaction refunds.</p>
              
              <div class="d-flex gap-2 mt-4 flex-wrap">
                <button class="btn-gold" onclick="exportDataReport('csv')"><i class="fas fa-file-csv me-2"></i>Export Sheets (CSV)</button>
                <button class="btn-outline-gold" onclick="exportDataReport('pdf')"><i class="fas fa-file-pdf me-2"></i>Compile Auditor PDF Report</button>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<!-- ===================== MODAL: CONFIGURE SERVICE ===================== -->
<div class="modal fade modal-luxury" id="serviceModal" tabindex="-1" aria-labelledby="serviceModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalServiceTitle">Configure Legal Service</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="serviceForm" onsubmit="saveServiceDetails(event)">
        <div class="modal-body text-white">
          <div class="form-field-luxury mb-3">
            <label for="servLabel">Practice Category Title</label>
            <input type="text" class="luxury-input form-control" id="servLabel" placeholder="e.g. Criminal Law" required>
          </div>
          <div class="form-field-luxury mb-3">
            <label for="servId">System Slug Identifier</label>
            <input type="text" class="luxury-input form-control" id="servId" placeholder="e.g. criminal" required>
          </div>
          <div class="form-field-luxury mb-3">
            <label for="servIcon">FontAwesome Icon Class</label>
            <input type="text" class="luxury-input form-control" id="servIcon" placeholder="e.g. fas fa-gavel" required>
          </div>
          <div class="form-field-luxury mb-3">
            <label for="servColor">Primary Hex Theme Color</label>
            <input type="color" class="luxury-input form-control" id="servColor" style="height:44px;" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn-outline-gold" style="padding:8px 18px; font-size:0.8rem;" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn-gold" style="padding:8px 24px; font-size:0.8rem;"><i class="fas fa-save me-1"></i>Save Configuration</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- ===================== MODAL: RESCHEDULE ===================== -->
<div class="modal fade modal-luxury" id="rescheduleModal" tabindex="-1" aria-labelledby="rescheduleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="rescheduleModalLabel"><i class="fas fa-calendar-alt text-gold me-2"></i>Reschedule Consultation Slot</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="rescheduleForm" onsubmit="saveRescheduledDate(event)">
        <div class="modal-body text-white">
          <p style="font-size:0.82rem; color:var(--text-muted);">Rescheduling will immediately update schedules in both the client and lawyer workspaces.</p>
          <div class="form-field-luxury mb-3">
            <label for="reschDate">Consultation Date</label>
            <input type="date" class="luxury-input form-control" id="reschDate" required>
          </div>
          <div class="form-field-luxury mb-3">
            <label for="reschTime">Time Slot</label>
            <input type="text" class="luxury-input form-control" id="reschTime" placeholder="e.g. 10:00 AM" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn-outline-gold" style="padding:8px 18px; font-size:0.8rem;" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn-gold" style="padding:8px 24px; font-size:0.8rem;"><i class="fas fa-save me-1"></i>Update Schedule</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- ===================== TOASTS BOX ===================== -->
<div id="toastBox" style="position:fixed; bottom:30px; left:50%; transform:translateX(-50%); z-index:9999; display:none;">
  <div style="background:var(--gold-gradient); color:var(--dark); font-weight:700; padding:12px 24px; border-radius:50px; font-size:0.85rem; box-shadow:0 8px 24px rgba(201,168,76,0.4);">
    <i class="fas fa-check-circle me-2"></i><span id="toastMsg">Action complete!</span>
  </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Chart.js for Premium Graphs -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- Platform Static Databases -->
<script src="js/data.js"></script>
<!-- Admin Controls Logic -->
<script src="js/admin.js"></script>
</body>
</html>
