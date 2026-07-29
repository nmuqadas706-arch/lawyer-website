<?php
include_once 'includes/connection.php';
session_start();


if (!isset($_SESSION['admin_id'])) {
  header("Location: admin-login.php");
  exit();
}

$admin_name = isset($_SESSION['admin_name']) ? $_SESSION['admin_name'] : 'Admin';
$admin_initials = strtoupper(substr($admin_name, 0, 2));

// ===================== ACTION HANDLERS ===================== //

if (isset($_GET['delete_message'])) {
    $msg_id = (int)$_GET['delete_message'];
    mysqli_query($conn, "DELETE FROM contact_messages WHERE message_id=$msg_id");
    header("Location: admin.php?tab=contact");
    exit();
}

/* ===== ADD SERVICE ===== */
if (isset($_POST['submit_service'])) {
    $service_name   = isset($_POST['service_name']) ? mysqli_real_escape_string($conn, trim($_POST['service_name'])) : '';
    $description    = isset($_POST['description']) ? mysqli_real_escape_string($conn, trim($_POST['description'])) : '';
    $fee            = isset($_POST['fee']) ? (float)$_POST['fee'] : 0;
    $service_number = isset($_POST['service_number']) ? (int)$_POST['service_number'] : 1;

    if (!empty($service_name) && !empty($description) && $fee > 0) {
        if (strlen($service_name) < 3) {
            echo "<script>alert('Service Name must be at least 3 characters long.'); window.history.back();</script>";
            exit();
        }
        if (strlen($description) < 10) {
            echo "<script>alert('Description must be at least 10 characters long.'); window.history.back();</script>";
            exit();
        }
        if ($fee <= 0) {
            echo "<script>alert('Fee must be greater than 0.'); window.history.back();</script>";
            exit();
        }
        $insert_query = "INSERT INTO services (service_name, description, fee, service_number) VALUES ('$service_name', '$description', '$fee', '$service_number')";
        mysqli_query($conn, $insert_query);
    } else {
        echo "<script>alert('Please fill all required fields correctly (Fee must be greater than 0).'); window.history.back();</script>";
        exit();
    }
    header("Location: admin.php");
    exit();
}

/* ===== UPDATE SERVICE ===== */
if (isset($_POST['update_service'])) {
    $service_id     = (int) $_POST['edit_service_id'];
    $service_name   = isset($_POST['edit_service_name']) ? mysqli_real_escape_string($conn, trim($_POST['edit_service_name'])) : '';
    $description    = isset($_POST['edit_description']) ? mysqli_real_escape_string($conn, trim($_POST['edit_description'])) : '';
    $fee            = isset($_POST['edit_fee']) ? (float)$_POST['edit_fee'] : 0;
    $service_number = isset($_POST['edit_service_number']) ? (int)$_POST['edit_service_number'] : 1;

    if ($service_id > 0 && !empty($service_name) && !empty($description) && $fee > 0) {
        if (strlen($service_name) < 3) {
            echo "<script>alert('Service Name must be at least 3 characters long.'); window.history.back();</script>";
            exit();
        }
        if (strlen($description) < 10) {
            echo "<script>alert('Description must be at least 10 characters long.'); window.history.back();</script>";
            exit();
        }
        if ($fee <= 0) {
            echo "<script>alert('Fee must be greater than 0.'); window.history.back();</script>";
            exit();
        }
        $update_query = "UPDATE services SET service_name='$service_name', description='$description', fee='$fee', service_number='$service_number' WHERE service_id=$service_id";
        mysqli_query($conn, $update_query);
    } else {
        echo "<script>alert('Please fill all required fields correctly.'); window.history.back();</script>";
        exit();
    }
    header("Location: admin.php");
    exit();
}

/* ===== DELETE SERVICE (with full cascade) ===== */
if (isset($_POST['delete_service'])) {
    $service_id = (int) $_POST['delete_service_id'];

    if ($service_id > 0) {

        // Step 1: Get the service name (used to match lawyers by specialization)
        $svc_row = mysqli_fetch_assoc(
            mysqli_query($conn, "SELECT service_name FROM services WHERE service_id=$service_id")
        );
        $service_name = $svc_row ? mysqli_real_escape_string($conn, $svc_row['service_name']) : '';

        // Step 2: Find all lawyers whose specialization matches this service name
        if (!empty($service_name)) {
            $lawyers_q = mysqli_query($conn, "SELECT lawyer_id, profile_image FROM lawyers WHERE specialization='$service_name'");

            while ($lawyer = mysqli_fetch_assoc($lawyers_q)) {
                $lid = (int) $lawyer['lawyer_id'];

                // Step 2a: Delete reviews left for this lawyer
                mysqli_query($conn, "DELETE FROM reviews WHERE lawyer_id=$lid");

                // Step 2b: Delete schedules of this lawyer
                mysqli_query($conn, "DELETE FROM schedules WHERE lawyer_id=$lid");

                // Step 2c: Delete appointments of this lawyer
                mysqli_query($conn, "DELETE FROM appointments WHERE lawyer_id=$lid");

                // Step 2d: Delete lawyer's uploaded profile image file from server
                if (!empty($lawyer['profile_image'])) {
                    $img_path = 'uploads/' . $lawyer['profile_image'];
                    if (file_exists($img_path)) {
                        unlink($img_path);
                    }
                }

                // Step 2e: Delete the lawyer record itself
                mysqli_query($conn, "DELETE FROM lawyers WHERE lawyer_id=$lid");
            }
        }

        // Step 3: Delete any remaining appointments linked to this service_id
        mysqli_query($conn, "DELETE FROM appointments WHERE service_id=$service_id");

        // Step 4: Finally delete the service itself
        mysqli_query($conn, "DELETE FROM services WHERE service_id=$service_id");
    }

    header("Location: admin.php");
    exit();
}


/* ===== UPDATE APPOINTMENT ===== */
if (isset($_POST['update_appointment'])) {
    $appointment_id   = (int) $_POST['appt_id'];
    $appointment_date = isset($_POST['appt_date']) ? mysqli_real_escape_string($conn, trim($_POST['appt_date'])) : '';
    $appointment_time = isset($_POST['appt_time']) ? mysqli_real_escape_string($conn, trim($_POST['appt_time'])) : '';
    $status           = isset($_POST['appt_status']) ? mysqli_real_escape_string($conn, trim($_POST['appt_status'])) : 'pending';
    $message          = isset($_POST['appt_message']) ? mysqli_real_escape_string($conn, trim($_POST['appt_message'])) : '';

    if ($appointment_id > 0 && !empty($appointment_date) && !empty($appointment_time)) {
        $upd_appt = "UPDATE appointments SET appointment_date='$appointment_date', appointment_time='$appointment_time', status='$status', message='$message' WHERE appointment_id=$appointment_id";
        mysqli_query($conn, $upd_appt);
    }
    header("Location: admin.php");
    exit();
}

/* ===== DELETE APPOINTMENT ===== */
if (isset($_POST['delete_appointment'])) {
    $appointment_id = (int) $_POST['del_appt_id'];
    mysqli_query($conn, "DELETE FROM appointments WHERE appointment_id=$appointment_id");
    header("Location: admin.php");
    exit();
}


// ===================== FETCH DYNAMIC DATA ===================== //
// 1. Dashboard Cards Data
$q_lawyers = mysqli_query($conn, "SELECT COUNT(*) as c FROM lawyers");
$tot_lawyers = mysqli_fetch_assoc($q_lawyers)['c'];

$q_customers = mysqli_query($conn, "SELECT COUNT(*) as c FROM customers");
$tot_customers = mysqli_fetch_assoc($q_customers)['c'];

$q_services = mysqli_query($conn, "SELECT COUNT(*) as c FROM services");
$tot_services = mysqli_fetch_assoc($q_services)['c'];

$q_appointments = mysqli_query($conn, "SELECT COUNT(*) as c FROM appointments");
$tot_appointments = mysqli_fetch_assoc($q_appointments)['c'];

$q_pend_app = mysqli_query($conn, "SELECT COUNT(*) as c FROM appointments WHERE status='pending'");
$pend_app = mysqli_fetch_assoc($q_pend_app)['c'];

$q_conf_app = mysqli_query($conn, "SELECT COUNT(*) as c FROM appointments WHERE status='confirmed'");
$conf_app = mysqli_fetch_assoc($q_conf_app)['c'];

$q_comp_app = mysqli_query($conn, "SELECT COUNT(*) as c FROM appointments WHERE status='completed'");
$comp_app = mysqli_fetch_assoc($q_comp_app)['c'];

$q_canc_app = mysqli_query($conn, "SELECT COUNT(*) as c FROM appointments WHERE status='cancelled'");
$canc_app = mysqli_fetch_assoc($q_canc_app)['c'];

$q_pend_law = mysqli_query($conn, "SELECT COUNT(*) as c FROM lawyers WHERE status='pending'");
$pend_law = mysqli_fetch_assoc($q_pend_law)['c'];

$q_rev = mysqli_query($conn, "SELECT SUM(s.fee) as r FROM appointments a JOIN services s ON a.service_id = s.service_id WHERE a.status='completed'");
$tot_rev = mysqli_fetch_assoc($q_rev)['r'];
$tot_rev = $tot_rev ? $tot_rev : 0;

// 2. Charts Data
// Monthly Appointments
$q_monthly_app = mysqli_query($conn, "SELECT DATE_FORMAT(appointment_date, '%M') as month, COUNT(*) as c FROM appointments GROUP BY MONTH(appointment_date) ORDER BY MONTH(appointment_date)");
$monthly_app_labels = [];
$monthly_app_data = [];
while($row = mysqli_fetch_assoc($q_monthly_app)) {
    $monthly_app_labels[] = $row['month'];
    $monthly_app_data[] = $row['c'];
}

// Monthly Revenue
$q_monthly_rev = mysqli_query($conn, "SELECT DATE_FORMAT(appointment_date, '%M') as month, SUM(s.fee) as r FROM appointments a JOIN services s ON a.service_id = s.service_id WHERE a.status='completed' GROUP BY MONTH(appointment_date) ORDER BY MONTH(appointment_date)");
$monthly_rev_labels = [];
$monthly_rev_data = [];
while($row = mysqli_fetch_assoc($q_monthly_rev)) {
    $monthly_rev_labels[] = $row['month'];
    $monthly_rev_data[] = $row['r'];
}

// Top 5 Services
$q_top_services = mysqli_query($conn, "SELECT s.service_name, COUNT(a.appointment_id) as c FROM services s LEFT JOIN appointments a ON s.service_id = a.service_id GROUP BY s.service_id ORDER BY c DESC LIMIT 5");
$top_srv_labels = [];
$top_srv_data = [];
$most_booked_service = "N/A";
while($row = mysqli_fetch_assoc($q_top_services)) {
    $top_srv_labels[] = $row['service_name'];
    $top_srv_data[] = $row['c'];
    if($most_booked_service === "N/A") $most_booked_service = $row['service_name'];
}

// Top 5 Lawyers
$q_top_lawyers = mysqli_query($conn, "SELECT l.full_name, COUNT(a.appointment_id) as c FROM lawyers l LEFT JOIN appointments a ON l.lawyer_id = a.lawyer_id GROUP BY l.lawyer_id ORDER BY c DESC LIMIT 5");
$top_law_labels = [];
$top_law_data = [];
$most_active_lawyer = "N/A";
while($row = mysqli_fetch_assoc($q_top_lawyers)) {
    $top_law_labels[] = $row['full_name'];
    $top_law_data[] = $row['c'];
    if($most_active_lawyer === "N/A") $most_active_lawyer = $row['full_name'];
}

// Recent Appointments Data for Overview Table
$recent_appts_html = "";
$q_recent = mysqli_query($conn, "SELECT a.appointment_id, c.full_name AS customer_name, l.full_name AS lawyer_name, s.fee, a.appointment_date, a.status FROM appointments a INNER JOIN customers c ON a.customer_id = c.customer_id INNER JOIN lawyers l ON a.lawyer_id = l.lawyer_id INNER JOIN services s ON a.service_id = s.service_id ORDER BY a.appointment_id DESC LIMIT 5");
while($row = mysqli_fetch_assoc($q_recent)) {
    $badge_class = 'bg-warning text-dark';
    if ($row['status'] === 'confirmed')  $badge_class = 'bg-success';
    if ($row['status'] === 'completed')  $badge_class = 'bg-primary';
    if ($row['status'] === 'cancelled')  $badge_class = 'bg-danger';
    
    $recent_appts_html .= "<tr>
        <td>{$row['appointment_id']}</td>
        <td>{$row['lawyer_name']}</td>
        <td>{$row['customer_name']}</td>
        <td>{$row['appointment_date']}</td>
        <td>PKR {$row['fee']}</td>
        <td><span class='badge {$badge_class}'>{$row['status']}</span></td>
        <td><button class='btn btn-sm btn-info text-white' onclick=\"switchPanel('appointments', this)\">View</button></td>
    </tr>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="LexElite Administrative Workspace — Platform management, verify lawyers, audit transactions, and view analytics reports." />
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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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
          <?php echo $admin_initials; ?>
        </div>
        <div>
          <div style="font-size:0.86rem; font-weight:700; color:var(--white);"><?php echo htmlspecialchars($admin_name); ?></div>
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
        <div class="menu-item" data-target="schedules" onclick="switchPanel('schedules', this)"><i class="fas fa-clock"></i> Manage Schedules</div>
        <div class="menu-item" data-target="contact" onclick="switchPanel('contact', this)"><i class="fas fa-envelope"></i> Contact Messages</div>

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
            <?php echo $admin_initials; ?>
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
                <div class="stat-box-val" id="statTotalLawyers"><?php echo $tot_lawyers; ?></div>
                <div class="stat-box-label">Attorneys</div>
              </div>
            </div>
            <div class="stat-box">
              <div class="stat-box-icon"><i class="fas fa-users"></i></div>
              <div>
                <div class="stat-box-val" id="statTotalClients"><?php echo $tot_customers; ?></div>
                <div class="stat-box-label">Clients</div>
              </div>
            </div>
            <div class="stat-box">
              <div class="stat-box-icon"><i class="fas fa-gavel"></i></div>
              <div>
                <div class="stat-box-val" id="statTotalServices"><?php echo $tot_services; ?></div>
                <div class="stat-box-label">Services</div>
              </div>
            </div>
            <div class="stat-box">
              <div class="stat-box-icon"><i class="fas fa-calendar-check"></i></div>
              <div>
                <div class="stat-box-val" id="statTotalBookings"><?php echo $tot_appointments; ?></div>
                <div class="stat-box-label">Total Bookings</div>
              </div>
            </div>
            <div class="stat-box">
              <div class="stat-box-icon"><i class="fas fa-clock"></i></div>
              <div>
                <div class="stat-box-val" id="statPendingBookings"><?php echo $pend_app; ?></div>
                <div class="stat-box-label">Pending Bookings</div>
              </div>
            </div>
            <div class="stat-box">
              <div class="stat-box-icon"><i class="fas fa-check-circle"></i></div>
              <div>
                <div class="stat-box-val" id="statConfirmedBookings"><?php echo $conf_app; ?></div>
                <div class="stat-box-label">Confirmed Bookings</div>
              </div>
            </div>
            <div class="stat-box">
              <div class="stat-box-icon"><i class="fas fa-clipboard-check"></i></div>
              <div>
                <div class="stat-box-val" id="statCompletedBookings"><?php echo $comp_app; ?></div>
                <div class="stat-box-label">Completed Bookings</div>
              </div>
            </div>
            <div class="stat-box">
              <div class="stat-box-icon"><i class="fas fa-times-circle"></i></div>
              <div>
                <div class="stat-box-val" id="statCancelledBookings"><?php echo $canc_app; ?></div>
                <div class="stat-box-label">Cancelled Bookings</div>
              </div>
            </div>
            <div class="stat-box">
              <div class="stat-box-icon"><i class="fas fa-user-clock"></i></div>
              <div>
                <div class="stat-box-val" id="statPendingLawyers"><?php echo $pend_law; ?></div>
                <div class="stat-box-label">Pending Lawyers</div>
              </div>
            </div>
            <div class="stat-box">
              <div class="stat-box-icon"><i class="fas fa-wallet"></i></div>
              <div>
                <div class="stat-box-val" id="statPlatformCommission">PKR <?php echo number_format($tot_rev); ?></div>
                <div class="stat-box-label">Total Revenue</div>
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
                  <?php echo $recent_appts_html; ?>
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
                <input type="text" class="luxury-input form-control" id="phpSearchLawyer" placeholder="Search lawyer by name...">
              </div>
              <div class="col-md-6">
                <select class="luxury-input form-control" id="phpFilterLawyer" style="background-color: var(--dark-card);">
                  <option value="all">All Verification Statuses</option>
                  <option value="approved">Active Verified (Approved)</option>
                  <option value="pending">Pending Review</option>
                  <option value="rejected">Rejected / Suspended</option>
                </select>
              </div>
            </div>

            <!-- Table -->
            <div style="overflow-x:auto;">
              <table class="lux-table table table-dark table-hover align-middle mb-0">
                <thead>
                  <tr>

                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone</th>



                    <th>City</th>

                    <th>CNIC-NO</th>
                    <th>profile_image</th>

                    <th>Status</th>
                    <th>Registered Date</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody id="adminLawyersTbody">
                  <?php

                  $query = "SELECT * FROM lawyers";
                  $result = mysqli_query($conn, $query);

                  foreach ($result as $row) {

                    echo "<tr>";

                    echo "<td>" . $row['full_name'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . $row['phone'] . "</td>";



                    echo "<td>" . $row['city'] . "</td>";

                    echo "<td>" . $row['cnic_no'] . "</td>";
                    echo "<td>
<img src='uploads/" . $row['profile_image'] . "'
style='width:50px;height:50px;object-fit:cover;border-radius:50%;'>
</td>";

                    echo "<td>" . $row['status'] . "</td>";
                    echo "<td>" . $row['created_at'] . "</td>";
echo "
<td>
    <div class='d-flex gap-2 flex-wrap align-items-center'>

        <!-- Show Approve button ONLY if status is Pending -->
        " . (ucfirst($row['status']) === 'Pending' ? "
        <a href='lawyer_approve.php?id=" . $row['lawyer_id'] . "'
           class='btn btn-sm btn-success text-white'
           onclick=\"return confirm('Are you sure you want to approve this lawyer?');\"
           title='Approve Lawyer'>
            <i class='bi bi-check-circle'></i>
        </a>
        " : "") . "

        <!-- Show Reject button ONLY if status is Pending -->
        " . (ucfirst($row['status']) === 'Pending' ? "
        <a href='lawyer_reject.php?id=" . $row['lawyer_id'] . "'
           class='btn btn-sm btn-secondary text-white'
           onclick=\"return confirm('Are you sure you want to reject this lawyer?');\"
           title='Reject Lawyer'>
            <i class='bi bi-x-circle'></i>
        </a>
        " : "") . "

        <!-- Show Approved badge if already Approved -->
        " . (ucfirst($row['status']) === 'Approved' ? "
        <span class='badge bg-success px-2 py-1' title='Already Approved'>
            <i class='bi bi-check-circle me-1'></i>Approved
        </span>
        " : "") . "

        <!-- Show Rejected badge if already Rejected -->
        " . (ucfirst($row['status']) === 'Rejected' ? "
        <span class='badge bg-danger px-2 py-1' title='Already Rejected'>
            <i class='bi bi-x-circle me-1'></i>Rejected
        </span>
        " : "") . "

        <a href='lawyer_view.php?id=" . $row['lawyer_id'] . "'
           class='btn btn-sm btn-info text-white'
           title='View Lawyer'>
            <i class='bi bi-eye'></i>
        </a>

        <a href='lawyer_edit.php?id=" . $row['lawyer_id'] . "'
           class='btn btn-sm btn-warning text-white'
           title='Edit Lawyer'>
            <i class='bi bi-pencil-square'></i>
        </a>

        <a href='lawyer_delete.php?id=" . $row['lawyer_id'] . "'
           class='btn btn-sm btn-danger'
           onclick=\"return confirm('Are you sure you want to delete this lawyer?');\"
           title='Delete Lawyer'>
            <i class='bi bi-trash'></i>
        </a>

    </div>
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
                <input type="text" class="luxury-input form-control" id="phpSearchCustomer" placeholder="Search client by name or email address...">
              </div>
            </div>

            <!-- Table -->
            <div style="overflow-x:auto;">
              <table class="lux-table table table-dark table-hover align-middle mb-0">
                <thead>
                  <tr>
                    <th>#ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Gender</th>
                    <th>Address</th>
                    <th>Profile</th>
                    <th>Registered</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody id="adminCustomersTbody">
                  <?php

                  
                  $query = "SELECT * FROM customers ORDER BY customer_id DESC";
                  $result = mysqli_query($conn, $query);
                  if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                      $img_src = !empty($row['profile_image'])
                        ? "uploads/" . htmlspecialchars($row['profile_image'])
                        : "https://ui-avatars.com/api/?name=" . urlencode($row['full_name']) . "&background=1A2F60&color=C9A84C&size=80";

                      echo "<tr>";
                      echo "<td>" . (int)$row['customer_id'] . "</td>";
                      echo "<td>" . htmlspecialchars($row['full_name']) . "</td>";
                      echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                      echo "<td>" . htmlspecialchars($row['phone'] ?? 'N/A') . "</td>";
                      echo "<td>" . htmlspecialchars($row['gender'] ?? 'N/A') . "</td>";
                      echo "<td style='max-width:150px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;'>" . htmlspecialchars($row['address'] ?? 'N/A') . "</td>";
                      echo "<td><img src='$img_src' style='width:42px;height:42px;object-fit:cover;border-radius:50%;border:2px solid var(--gold);'></td>";
                      echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
                      echo "<td>
    <div class='d-flex gap-2'>
        <a href='customer_view.php?id=" . (int)$row['customer_id'] . "' class='btn btn-sm btn-info text-white' title='View Client'><i class='fas fa-eye'></i></a>
        <a href='customer_update.php?id=" . (int)$row['customer_id'] . "' class='btn btn-sm btn-warning text-white' title='Edit Client'><i class='fas fa-edit'></i></a>
        <a href='customer_delete.php?id=" . (int)$row['customer_id'] . "' class='btn btn-sm btn-danger text-white' title='Delete Client' onclick=\"return confirm('Delete this client?');\"><i class='fas fa-trash'></i></a>
    </div>
</td>";
                      echo "</tr>";
                    }
                  } else {
                    echo "<tr><td colspan='9' class='text-center text-muted py-4'>No customers registered yet.</td></tr>";
                  }
                  ?>
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

            <button class="btn-gold" style="padding:8px 18px;font-size:0.8rem;"
                onclick="openAddServiceModal()">
                <i class="fas fa-plus me-2"></i> Configure Service
            </button>
        </div>

        <div style="overflow-x:auto;">
            <table class="lux-table table table-dark table-hover align-middle mb-0">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Service Name</th>
                        <th>Description</th>
                        <th>Fee</th>
                        <th>Service No.</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>

                    <?php
                    $query = mysqli_query($conn, "SELECT * FROM services ORDER BY service_id ASC");

                    while($service = mysqli_fetch_assoc($query)){
                    ?>

                    <tr>
                        <td><?php echo $service['service_id']; ?></td>
                        <td><?php echo htmlspecialchars($service['service_name']); ?></td>
                        <td><?php echo htmlspecialchars($service['description']); ?></td>
                        <td>PKR <?php echo number_format($service['fee']); ?></td>
                        <td><?php echo $service['service_number']; ?></td>

                       <td class="text-center">
    <button class="action-btn edit-btn"
        onclick="openEditServiceModal(<?php echo $service['service_id']; ?>)">
        <i class="fas fa-edit"></i>
    </button>

    <button class="action-btn delete-btn"
        onclick="deleteService(<?php echo $service['service_id']; ?>)">
        <i class="fas fa-trash-alt"></i>
    </button>
</td>
                    <?php } ?>

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
                <input type="text" class="luxury-input form-control" id="phpSearchAppt" placeholder="Search by lawyer or client name...">
              </div>
              <div class="col-md-6">
                <select class="luxury-input form-control" id="phpFilterAppt" style="background-color: var(--dark-card);">
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
                    <th>ID</th>
                    <th>Customer</th>
                    <th>Lawyer</th>
                    <th>Service</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Fee</th>
                    <th>Status</th>
                    <th>Actions</th>
                  </tr>
                </thead>

                <tbody id="adminApptsTbody">
                  <?php

                  $query = mysqli_query($conn, "
SELECT
    a.appointment_id,
    a.customer_id,
    a.lawyer_id,
    a.service_id,
    a.appointment_date,
    a.appointment_time,
    a.message,
    a.status,
    c.full_name AS customer_name,
    l.full_name AS lawyer_name,
    s.service_name,
    s.fee
FROM appointments a
INNER JOIN customers c ON a.customer_id = c.customer_id
INNER JOIN lawyers l ON a.lawyer_id = l.lawyer_id
INNER JOIN services s ON a.service_id = s.service_id
ORDER BY a.appointment_id DESC
");

                  while ($row = mysqli_fetch_assoc($query)) {
                    /* Build a JS-safe data attribute string for the edit modal */
                    $appt_json = htmlspecialchars(json_encode([
                        'appointment_id'   => $row['appointment_id'],
                        'customer_name'    => $row['customer_name'],
                        'lawyer_name'      => $row['lawyer_name'],
                        'service_name'     => $row['service_name'],
                        'appointment_date' => $row['appointment_date'],
                        'appointment_time' => $row['appointment_time'],
                        'message'          => $row['message'],
                        'status'           => $row['status'],
                    ]), ENT_QUOTES, 'UTF-8');

                    /* Badge colour based on status */
                    $badge_class = 'bg-warning text-dark';
                    if ($row['status'] === 'confirmed')  $badge_class = 'bg-success';
                    if ($row['status'] === 'completed')  $badge_class = 'bg-primary';
                    if ($row['status'] === 'cancelled')  $badge_class = 'bg-danger';

                    echo "<tr>
        <td>{$row['appointment_id']}</td>
        <td>{$row['customer_name']}</td>
        <td>{$row['lawyer_name']}</td>
        <td>{$row['service_name']}</td>
        <td>{$row['appointment_date']}</td>
        <td>{$row['appointment_time']}</td>
        <td>PKR {$row['fee']}</td>

        <td>
            <span class='badge {$badge_class}'>{$row['status']}</span>
        </td>

        <td>
            <div class='d-flex gap-2'>
                <button class='btn btn-info btn-sm text-white'
                        title='Edit Appointment'
                        onclick=\"openEditApptModal('{$appt_json}')\">
                    <i class='fas fa-edit'></i>
                </button>

                <button class='btn btn-danger btn-sm'
                        title='Delete Appointment'
                        onclick=\"deleteAppointment({$row['appointment_id']})\">
                    <i class='fas fa-trash'></i>
                </button>
            </div>
        </td>
    </tr>";
                  }

                  ?>
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

        <!-- ===================== PANEL: MANAGE SCHEDULES ===================== -->
        <div class="panel-section" id="sec-schedules">
          <div class="dash-card">
            <div class="dash-card-title">Lawyer Schedules</div>
            <div style="overflow-x:auto;">
              <table class="lux-table table table-dark table-hover align-middle mb-0">
                <thead>
                  <tr>
                    <th>Schedule ID</th>
                    <th>Lawyer Name</th>
                    <th>Day</th>
                    <th>Time</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sq = mysqli_query($conn, "SELECT s.*, l.full_name FROM schedules s JOIN lawyers l ON s.lawyer_id = l.lawyer_id ORDER BY s.schedule_id DESC");
                  while($srow = mysqli_fetch_assoc($sq)) {
                      $status_badge = ($srow['status'] == 'Available') ? 'bg-success' : 'bg-danger';
                      echo "<tr>
                        <td>{$srow['schedule_id']}</td>
                        <td>{$srow['full_name']}</td>
                        <td>{$srow['day']}</td>
                        <td>" . date('h:i A', strtotime($srow['start_time'])) . "</td>
                        <td><span class='badge {$status_badge}'>{$srow['status']}</span></td>
                      </tr>";
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- ===================== PANEL: CONTACT MESSAGES ===================== -->
        <div class="panel-section" id="sec-contact">
          <div class="dash-card">
            <div class="dash-card-title">Contact Messages</div>
            <div style="overflow-x:auto;">
              <table class="lux-table table table-dark table-hover align-middle mb-0">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Date</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $q_msg = mysqli_query($conn, "SELECT * FROM contact_messages ORDER BY message_id DESC");
                  if(mysqli_num_rows($q_msg) > 0) {
                      while($msg = mysqli_fetch_assoc($q_msg)) {
                          echo "<tr>
                            <td>{$msg['message_id']}</td>
                            <td>" . htmlspecialchars($msg['name']) . "</td>
                            <td>" . htmlspecialchars($msg['email']) . "</td>
                            <td>" . htmlspecialchars($msg['subject']) . "</td>
                            <td><div style='max-width:300px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;' title='" . htmlspecialchars($msg['message']) . "'>" . htmlspecialchars($msg['message']) . "</div></td>
                            <td>" . date('M d, Y', strtotime($msg['created_at'])) . "</td>
                            <td>
                              <a href='admin.php?delete_message={$msg['message_id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this message?\")'>
                                <i class='fas fa-trash'></i>
                              </a>
                            </td>
                          </tr>";
                      }
                  } else {
                      echo "<tr><td colspan='7' class='text-center'>No messages found.</td></tr>";
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- ===================== PANEL: REPORTS ===================== -->
        <div class="panel-section" id="sec-reports">
          
          <!-- Text Reports Stats Grid -->
          <div class="grid-stats mb-4">
            <div class="stat-box">
              <div>
                <div class="stat-box-val"><?php echo $tot_lawyers; ?></div>
                <div class="stat-box-label">Total Registered Lawyers</div>
              </div>
            </div>
            <div class="stat-box">
              <div>
                <div class="stat-box-val"><?php echo $tot_customers; ?></div>
                <div class="stat-box-label">Total Registered Customers</div>
              </div>
            </div>
            <div class="stat-box">
              <div>
                <div class="stat-box-val"><?php echo $tot_services; ?></div>
                <div class="stat-box-label">Total Services</div>
              </div>
            </div>
            <div class="stat-box">
              <div>
                <div class="stat-box-val"><?php echo $tot_appointments; ?></div>
                <div class="stat-box-label">Total Bookings</div>
              </div>
            </div>
            <div class="stat-box">
              <div>
                <div class="stat-box-val"><?php echo $comp_app; ?></div>
                <div class="stat-box-label">Total Completed Appointments</div>
              </div>
            </div>
            <div class="stat-box">
              <div>
                <div class="stat-box-val"><?php echo $canc_app; ?></div>
                <div class="stat-box-label">Total Cancelled Appointments</div>
              </div>
            </div>
            <div class="stat-box">
              <div>
                <div class="stat-box-val"><?php echo $most_booked_service; ?></div>
                <div class="stat-box-label">Most Booked Service</div>
              </div>
            </div>
            <div class="stat-box">
              <div>
                <div class="stat-box-val"><?php echo $most_active_lawyer; ?></div>
                <div class="stat-box-label">Most Active Lawyer</div>
              </div>
            </div>
          </div>

          <div class="row g-4 mb-4">
            <!-- Monthly Revenue Report -->
            <div class="col-12">
              <div class="dash-card">
                <div class="dash-card-title">Monthly Revenue Report</div>
                <div class="chart-box-wrap" style="height:300px;">
                  <canvas id="chartMonthlyRevenue"></canvas>
                </div>
              </div>
            </div>
          </div>

          <div class="row g-4">
            <!-- Col 1: Graphic Analytics -->
            <div class="col-lg-8">
              <div class="dash-card">
                <div class="dash-card-title">Top 5 Most Booked Services</div>
                <div class="chart-box-wrap" style="height:320px;">
                  <canvas id="chartReportsRevenue"></canvas>
                </div>
              </div>
            </div>
            <!-- Col 2: Top Lists -->
            <div class="col-lg-4">
              <div class="dash-card" style="height:100%;">
                <div class="dash-card-title">Top 5 Lawyers by Appointments</div>
                <div id="topPerformingAttorneys" class="pt-2 chart-box-wrap" style="height:320px;">
                  <canvas id="chartTopLawyers"></canvas>
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
 <!-- Add Service Modal -->
<div class="modal fade modal-luxury" id="serviceModal" tabindex="-1" aria-labelledby="serviceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="serviceModalLabel">Configure Legal Service</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="serviceForm" method="POST" onsubmit="return validateServiceForm()">

                <div class="modal-body text-white">

                    <!-- Service Name -->
                    <div class="form-field-luxury mb-3">
                        <label>Service Name</label>
                        <input type="text" name="service_name" id="service_name_input" class="luxury-input form-control" placeholder="e.g. Criminal Law" required minlength="3" maxlength="100">
                    </div>

                    <!-- Description -->
                    <div class="form-field-luxury mb-3">
                        <label>Description</label>
                        <textarea name="description" id="service_desc_input" class="luxury-input form-control" rows="4" placeholder="Enter service description" required minlength="10" maxlength="1000"></textarea>
                    </div>

                    <!-- Fee -->
                    <div class="form-field-luxury mb-3">
                        <label>Fee (PKR)</label>
                        <input type="number" name="fee" id="service_fee_input" class="luxury-input form-control" placeholder="Enter fee" required min="1">
                    </div>


                    <div class="form-field-luxury mb-3">
                        <label>Service Number</label>
                        <input type="number" name="service_number" id="service_num_input" class="luxury-input form-control" placeholder="1" required min="1" max="100">
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-outline-gold" data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <button type="submit" name="submit_service" class="btn-gold">
                        <i class="fas fa-save me-1"></i> Save Configuration
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
  <!-- Actions handled at the top of the file -->

  <!-- ===================== MODAL: EDIT SERVICE ===================== -->
  <div class="modal fade modal-luxury" id="editServiceModal" tabindex="-1" aria-labelledby="editServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title" id="editServiceModalLabel">
            <i class="fas fa-edit me-2" style="color:var(--gold);"></i>Edit Legal Service
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <form id="editServiceForm" method="POST" onsubmit="return validateEditServiceForm()">
          <input type="hidden" name="edit_service_id" id="edit_service_id">

          <div class="modal-body text-white">

            <!-- Service Name -->
            <div class="form-field-luxury mb-3">
              <label>Service Name</label>
              <input type="text" name="edit_service_name" id="edit_service_name"
                     class="luxury-input form-control" placeholder="e.g. Criminal Law" required minlength="3" maxlength="100">
            </div>

            <!-- Description -->
            <div class="form-field-luxury mb-3">
              <label>Description</label>
              <textarea name="edit_description" id="edit_description"
                        class="luxury-input form-control" rows="4"
                        class="luxury-input form-control" rows="4"
                        placeholder="Enter service description" required minlength="10" maxlength="1000"></textarea>
            </div>

            <!-- Fee -->
            <div class="form-field-luxury mb-3">
              <label>Fee (PKR)</label>
              <input type="number" name="edit_fee" id="edit_fee"
                     class="luxury-input form-control" placeholder="Enter fee" required min="1">
            </div>

            <div class="form-field-luxury mb-3">
              <label>Service Number</label>
              <input type="number" name="edit_service_number" id="edit_service_number"
                     class="luxury-input form-control" placeholder="1" required min="1" max="100">
            </div>

          </div>

          <div class="modal-footer">
            <button type="button" class="btn-outline-gold" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" name="update_service" class="btn-gold">
              <i class="fas fa-save me-1"></i> Update Service
            </button>
          </div>

        </form>
      </div>
    </div>
  </div>

  <!-- ===================== HIDDEN FORM: DELETE SERVICE ===================== -->
  <form id="deleteServiceForm" method="POST" style="display:none;">
    <input type="hidden" name="delete_service_id" id="delete_service_id">
    <input type="hidden" name="delete_service" value="1">
  </form>

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

  <!-- ===================== DOM FILTERING FOR ADMIN TABLES ===================== -->
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      // 1. Lawyers Table Filter
      const searchLawyer = document.getElementById('phpSearchLawyer');
      const filterLawyer = document.getElementById('phpFilterLawyer');
      const lawyersTbody = document.getElementById('adminLawyersTbody');

      function filterLawyers() {
        if(!lawyersTbody) return;
        const sText = searchLawyer ? searchLawyer.value.toLowerCase() : '';
        const sStatus = filterLawyer ? filterLawyer.value.toLowerCase() : 'all';
        const rows = lawyersTbody.getElementsByTagName('tr');

        for(let i=0; i<rows.length; i++) {
          const nameCol = rows[i].getElementsByTagName('td')[0];
          const statusCol = rows[i].getElementsByTagName('td')[6];
          if(nameCol && statusCol) {
            const name = nameCol.textContent.toLowerCase();
            const status = statusCol.textContent.toLowerCase();
            const matchesText = name.includes(sText);
            const matchesStatus = (sStatus === 'all') || (status === sStatus);
            rows[i].style.display = (matchesText && matchesStatus) ? '' : 'none';
          }
        }
      }
      if(searchLawyer) searchLawyer.addEventListener('keyup', filterLawyers);
      if(filterLawyer) filterLawyer.addEventListener('change', filterLawyers);

      // 2. Customers Table Filter
      const searchCustomer = document.getElementById('phpSearchCustomer');
      const customersTbody = document.getElementById('adminCustomersTbody');
      
      function filterCustomers() {
        if(!customersTbody) return;
        const sText = searchCustomer ? searchCustomer.value.toLowerCase() : '';
        const rows = customersTbody.getElementsByTagName('tr');

        for(let i=0; i<rows.length; i++) {
          const nameCol = rows[i].getElementsByTagName('td')[1];
          const emailCol = rows[i].getElementsByTagName('td')[2];
          if(nameCol && emailCol) {
            const name = nameCol.textContent.toLowerCase();
            const email = emailCol.textContent.toLowerCase();
            rows[i].style.display = (name.includes(sText) || email.includes(sText)) ? '' : 'none';
          }
        }
      }
      if(searchCustomer) searchCustomer.addEventListener('keyup', filterCustomers);

      // 3. Appointments Table Filter
      const searchAppt = document.getElementById('phpSearchAppt');
      const filterAppt = document.getElementById('phpFilterAppt');
      const apptsTbody = document.getElementById('adminApptsTbody');

      function filterAppts() {
        if(!apptsTbody) return;
        const sText = searchAppt ? searchAppt.value.toLowerCase() : '';
        const sStatus = filterAppt ? filterAppt.value.toLowerCase() : 'all';
        const rows = apptsTbody.getElementsByTagName('tr');

        for(let i=0; i<rows.length; i++) {
          const custCol = rows[i].getElementsByTagName('td')[1];
          const lawyCol = rows[i].getElementsByTagName('td')[2];
          const statusCol = rows[i].getElementsByTagName('td')[7];
          
          if(custCol && lawyCol && statusCol) {
            const cust = custCol.textContent.toLowerCase();
            const lawy = lawyCol.textContent.toLowerCase();
            const status = statusCol.textContent.toLowerCase().trim();
            
            const matchesText = cust.includes(sText) || lawy.includes(sText);
            const matchesStatus = (sStatus === 'all') || (status === sStatus);
            rows[i].style.display = (matchesText && matchesStatus) ? '' : 'none';
          }
        }
      }
      if(searchAppt) searchAppt.addEventListener('keyup', filterAppts);
      if(filterAppt) filterAppt.addEventListener('change', filterAppts);
    });
  </script>

  <!-- ===================== SERVICE FORM JS VALIDATIONS ===================== -->
  <script>
    /* ---- Add Service Form Validation ---- */
    function validateServiceForm() {
      var name = document.getElementById('service_name_input').value.trim();
      var desc = document.getElementById('service_desc_input').value.trim();
      var fee  = parseFloat(document.getElementById('service_fee_input').value);
      var num  = parseInt(document.getElementById('service_num_input').value);

      if (!name || name.length < 3) {
        alert('Service Name must be at least 3 characters long.');
        return false;
      }
      if (!desc || desc.length < 10) {
        alert('Description must be at least 10 characters long.');
        return false;
      }
      if (isNaN(fee) || fee <= 0) {
        alert('Fee must be a number greater than 0.');
        return false;
      }
      if (isNaN(num) || num < 1) {
        alert('Service Number must be at least 1.');
        return false;
      }
      return true;
    }

    /* ---- Edit Service Form Validation ---- */
    function validateEditServiceForm() {
      var name = document.getElementById('edit_service_name').value.trim();
      var desc = document.getElementById('edit_description').value.trim();
      var fee  = parseFloat(document.getElementById('edit_fee').value);
      var num  = parseInt(document.getElementById('edit_service_number').value);

      if (!name || name.length < 3) {
        alert('Service Name must be at least 3 characters long.');
        return false;
      }
      if (!desc || desc.length < 10) {
        alert('Description must be at least 10 characters long.');
        return false;
      }
      if (isNaN(fee) || fee <= 0) {
        alert('Fee must be a number greater than 0.');
        return false;
      }
      if (isNaN(num) || num < 1) {
        alert('Service Number must be at least 1.');
        return false;
      }
      return true;
    }
  </script>

  <!-- ===================== SERVICE EDIT / DELETE HANDLERS ===================== -->
  <script>
    /* ---------- Services data map (PHP → JS) ---------- */
    var servicesData = {};
    <?php
      $svc_result = mysqli_query($conn, "SELECT * FROM services ORDER BY service_id ASC");
      while ($svc_row = mysqli_fetch_assoc($svc_result)) {
          echo "servicesData[" . $svc_row['service_id'] . "] = {";
          echo "service_name:"   . json_encode($svc_row['service_name'])   . ",";
          echo "description:"    . json_encode($svc_row['description'])    . ",";
          echo "fee:"            . json_encode($svc_row['fee'])            . ",";
          echo "service_number:" . json_encode($svc_row['service_number']) . "";
          echo "};\n";
      }
    ?>

    /* ---------- Open Edit Modal ---------- */
    function openEditServiceModal(serviceId) {
      var s = servicesData[serviceId];
      if (!s) {
        alert('Service data not found.');
        return;
      }

      document.getElementById('edit_service_id').value     = serviceId;
      document.getElementById('edit_service_name').value   = s.service_name;
      document.getElementById('edit_description').value    = s.description;
      document.getElementById('edit_fee').value            = s.fee;
      document.getElementById('edit_service_number').value = s.service_number;

      var modal = new bootstrap.Modal(document.getElementById('editServiceModal'));
      modal.show();
    }

    /* ---------- Delete Service ---------- */
    function deleteService(serviceId) {
      if (confirm('Are you sure you want to delete this service? This action cannot be undone.')) {
        document.getElementById('delete_service_id').value = serviceId;
        document.getElementById('deleteServiceForm').submit();
      }
    }
  </script>

  <!-- ===================== MODAL: EDIT APPOINTMENT ===================== -->
  <div class="modal fade modal-luxury" id="editApptModal" tabindex="-1" aria-labelledby="editApptModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title" id="editApptModalLabel">
            <i class="fas fa-calendar-edit me-2" style="color:var(--gold);"></i>Edit Consultation Appointment
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <form id="editApptForm" method="POST">
          <input type="hidden" name="appt_id" id="appt_id">

          <div class="modal-body text-white">

            <!-- Read-only info row -->
            <div class="row g-3 mb-3">
              <div class="col-md-4">
                <div class="form-field-luxury">
                  <label style="color:var(--text-muted); font-size:0.75rem;">Customer (read-only)</label>
                  <input type="text" id="appt_customer_name" class="luxury-input form-control"
                         readonly style="opacity:0.6; cursor:not-allowed;">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-field-luxury">
                  <label style="color:var(--text-muted); font-size:0.75rem;">Lawyer (read-only)</label>
                  <input type="text" id="appt_lawyer_name" class="luxury-input form-control"
                         readonly style="opacity:0.6; cursor:not-allowed;">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-field-luxury">
                  <label style="color:var(--text-muted); font-size:0.75rem;">Service (read-only)</label>
                  <input type="text" id="appt_service_name" class="luxury-input form-control"
                         readonly style="opacity:0.6; cursor:not-allowed;">
                </div>
              </div>
            </div>

            <hr style="border-color:rgba(255,255,255,0.1); margin:16px 0;">

            <!-- Editable fields -->
            <div class="row g-3">

              <!-- Appointment Date -->
              <div class="col-md-6">
                <div class="form-field-luxury">
                  <label for="appt_date">Appointment Date</label>
                  <input type="date" name="appt_date" id="appt_date"
                         class="luxury-input form-control" required>
                </div>
              </div>

              <!-- Appointment Time -->
              <div class="col-md-6">
                <div class="form-field-luxury">
                  <label for="appt_time">Appointment Time</label>
                  <input type="text" name="appt_time" id="appt_time"
                         class="luxury-input form-control" placeholder="e.g. 10:00 AM" required>
                </div>
              </div>

              <!-- Status -->
              <div class="col-md-6">
                <div class="form-field-luxury">
                  <label for="appt_status">Status</label>
                  <select name="appt_status" id="appt_status"
                          class="luxury-input form-control" style="background-color:var(--dark-card);" required>
                    <option value="pending">Pending</option>
                    <option value="confirmed">Confirmed</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Cancelled</option>
                  </select>
                </div>
              </div>

              <!-- Message -->
              <div class="col-12">
                <div class="form-field-luxury">
                  <label for="appt_message">Message / Notes</label>
                  <textarea name="appt_message" id="appt_message"
                            class="luxury-input form-control" rows="3"
                            placeholder="Optional notes or client message"></textarea>
                </div>
              </div>

            </div>
          </div><!-- /.modal-body -->

          <div class="modal-footer">
            <button type="button" class="btn-outline-gold" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" name="update_appointment" class="btn-gold">
              <i class="fas fa-save me-1"></i> Update Appointment
            </button>
          </div>

        </form>
      </div>
    </div>
  </div>

  <!-- ===================== HIDDEN FORM: DELETE APPOINTMENT ===================== -->
  <form id="deleteApptForm" method="POST" style="display:none;">
    <input type="hidden" name="del_appt_id" id="del_appt_id">
    <input type="hidden" name="delete_appointment" value="1">
  </form>

  <!-- ===================== APPOINTMENT EDIT / DELETE HANDLERS ===================== -->
  <script>
    /* ---------- Open Edit Appointment Modal ---------- */
    function openEditApptModal(jsonStr) {
      var a;
      try {
        a = (typeof jsonStr === 'string') ? JSON.parse(jsonStr) : jsonStr;
      } catch(e) {
        alert('Could not parse appointment data.');
        return;
      }

      document.getElementById('appt_id').value            = a.appointment_id;
      document.getElementById('appt_customer_name').value = a.customer_name;
      document.getElementById('appt_lawyer_name').value   = a.lawyer_name;
      document.getElementById('appt_service_name').value  = a.service_name;
      document.getElementById('appt_date').value          = a.appointment_date;
      document.getElementById('appt_time').value          = a.appointment_time;
      document.getElementById('appt_message').value       = a.message || '';

      /* Pre-select the current status */
      var sel = document.getElementById('appt_status');
      for (var i = 0; i < sel.options.length; i++) {
        if (sel.options[i].value === a.status) {
          sel.selectedIndex = i;
          break;
        }
      }

      var modal = new bootstrap.Modal(document.getElementById('editApptModal'));
      modal.show();
    }

    /* ---------- Delete Appointment ---------- */
    function deleteAppointment(apptId) {
      if (confirm('Are you sure you want to permanently delete this appointment? This action cannot be undone.')) {
        document.getElementById('del_appt_id').value = apptId;
        document.getElementById('deleteApptForm').submit();
      }
    }
  </script>

  <!-- ===================== DYNAMIC UI INJECTION ===================== -->
  <script>
    // Overriding admin.js functions to stop fake localStorage data from overwriting our dynamic PHP data

    window.loadOverviewStats = function() {
        $('#statTotalLawyers').text('<?php echo $tot_lawyers; ?>');
        $('#statTotalClients').text('<?php echo $tot_customers; ?>');
        $('#statTotalBookings').text('<?php echo $tot_appointments; ?>');
        $('#statPlatformCommission').text('PKR <?php echo number_format($tot_rev); ?>');
        
        let pend_law = <?php echo (int)$pend_law; ?>;
        $('#lawyerPendingBadge').text(pend_law).css('display', pend_law > 0 ? 'inline-block' : 'none');
        
        $('#recentAppointmentsTable').html(`<?php echo $recent_appts_html; ?>`);
    };

    window.loadReportsData = function() {
        // Handled directly by PHP HTML
    };

    window.initAnalyticsCharts = function() {
        // Handled by initCharts() now
    };

    window.initCharts = function() {
        // Destroy existing charts to prevent overlap
        if(window.revenueChart) window.revenueChart.destroy();
        if(window.shareChart) window.shareChart.destroy();
        if(window.reportsChartObj) window.reportsChartObj.destroy();
        for(let key in Chart.instances) {
            Chart.instances[key].destroy();
        }

        // 1. Bar Chart: Appointments per Month
        var ctx1 = document.getElementById('chartRevenueTrend');
        if(ctx1) {
            window.revenueChart = new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($monthly_app_labels); ?>,
                    datasets: [{
                        label: 'Appointments',
                        data: <?php echo json_encode($monthly_app_data); ?>,
                        backgroundColor: 'rgba(201, 168, 76, 0.7)',
                        borderColor: 'rgba(201, 168, 76, 1)',
                        borderWidth: 1
                    }]
                },
                options: { maintainAspectRatio: false }
            });
        }

        // 2. Pie Chart: Appointment Status
        var ctx2 = document.getElementById('chartCategoryShare');
        if(ctx2) {
            window.shareChart = new Chart(ctx2, {
                type: 'pie',
                data: {
                    labels: ['Pending', 'Confirmed', 'Completed', 'Cancelled'],
                    datasets: [{
                        data: [<?php echo $pend_app; ?>, <?php echo $conf_app; ?>, <?php echo $comp_app; ?>, <?php echo $canc_app; ?>],
                        backgroundColor: ['#ffc107', '#28a745', '#007bff', '#dc3545']
                    }]
                },
                options: { maintainAspectRatio: false }
            });
        }

        // 3. Bar Chart: Top 5 Most Booked Services
        var ctx3 = document.getElementById('chartReportsRevenue');
        if(ctx3) {
            window.reportsChartObj = new Chart(ctx3, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($top_srv_labels); ?>,
                    datasets: [{
                        label: 'Appointments Booked',
                        data: <?php echo json_encode($top_srv_data); ?>,
                        backgroundColor: 'rgba(54, 162, 235, 0.7)'
                    }]
                },
                options: { maintainAspectRatio: false }
            });
        }

        // 4. Bar Chart: Top 5 Lawyers by Number of Appointments
        var ctx4 = document.getElementById('chartTopLawyers');
        if(ctx4) {
            new Chart(ctx4, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($top_law_labels); ?>,
                    datasets: [{
                        label: 'Appointments Handled',
                        data: <?php echo json_encode($top_law_data); ?>,
                        backgroundColor: 'rgba(153, 102, 255, 0.7)'
                    }]
                },
                options: { maintainAspectRatio: false }
            });
        }

        // 5. Line Chart: Monthly Revenue Report
        var ctx5 = document.getElementById('chartMonthlyRevenue');
        if(ctx5) {
            new Chart(ctx5, {
                type: 'line',
                data: {
                    labels: <?php echo json_encode($monthly_rev_labels); ?>,
                    datasets: [{
                        label: 'Revenue (PKR)',
                        data: <?php echo json_encode($monthly_rev_data); ?>,
                        borderColor: 'rgba(40, 167, 69, 1)',
                        backgroundColor: 'rgba(40, 167, 69, 0.2)',
                        fill: true,
                        tension: 0.3
                    }]
                },
                options: { maintainAspectRatio: false }
            });
        }
    };

    $(document).ready(function() {
        // Enforce the PHP values immediately after jQuery loads and admin.js executes
        setTimeout(function() {
            window.loadOverviewStats();
            window.initCharts();
        }, 100);
    });

    function exportDataReport(type) {
        if (type === 'csv') {
            window.location.href = 'export_reports.php?type=csv';
        } else {
            alert("PDF export requires an external library. Please use CSV for now.");
        }
    }
  </script>

</body>

</html>