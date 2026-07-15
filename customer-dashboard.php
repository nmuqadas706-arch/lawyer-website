<?php
include_once 'includes/connection.php';
session_start();

if (!isset($_SESSION['customer_id'])) {
    header("Location: customer-login.php");
    exit();
}

$customer_id = (int)$_SESSION['customer_id'];

// Fetch current customer
$user_q = mysqli_query($conn, "SELECT * FROM customers WHERE customer_id='$customer_id'");
$customer = mysqli_fetch_assoc($user_q);

if (!$customer) {
    session_destroy();
    header("Location: index.php");
    exit();
}

$initials = strtoupper(substr($customer['full_name'], 0, 2));
$profile_img_url = !empty($customer['profile_image']) ? 'uploads/' . htmlspecialchars($customer['profile_image']) : '';

// ── Update Profile ──
if (isset($_POST['update_profile'])) {
    $full_name = mysqli_real_escape_string($conn, trim($_POST['full_name']));
    $phone     = mysqli_real_escape_string($conn, trim($_POST['phone']));
    $gender    = mysqli_real_escape_string($conn, trim($_POST['gender'] ?? ''));
    $address   = mysqli_real_escape_string($conn, trim($_POST['address'] ?? ''));

    $img_field = '';
    if (!empty($_FILES['profile_image']['name'])) {
        $ext       = strtolower(pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION));
        $allowed   = ['jpg','jpeg','png','gif','webp'];
        if (in_array($ext, $allowed) && $_FILES['profile_image']['size'] <= 2097152) {
            $new_name  = 'cust_' . $customer_id . '_' . time() . '.' . $ext;
            $dest      = 'uploads/' . $new_name;
            if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $dest)) {
                $img_field = ", profile_image='$new_name'";
            }
        }
    }

    mysqli_query($conn, "UPDATE customers SET full_name='$full_name', phone='$phone', gender='$gender', address='$address'$img_field WHERE customer_id='$customer_id'");
    header("Location: customer-dashboard.php?tab=profile-settings&saved=1");
    exit();
}

// ── Update Password ──
if (isset($_POST['update_password'])) {
    $curPass = mysqli_real_escape_string($conn, $_POST['cur_pass']);
    $newPass = mysqli_real_escape_string($conn, $_POST['new_pass']);
    if ($customer['password'] === $curPass) {
        mysqli_query($conn, "UPDATE customers SET password='$newPass' WHERE customer_id='$customer_id'");
        echo "<script>alert('Password updated successfully!');</script>";
        // Re-fetch customer
        $user_q  = mysqli_query($conn, "SELECT * FROM customers WHERE customer_id='$customer_id'");
        $customer = mysqli_fetch_assoc($user_q);
    } else {
        echo "<script>alert('Current password is incorrect.');</script>";
    }
}

// ── Cancel Appointment ──
if (isset($_POST['cancel_appointment'])) {
    $appt_id = (int)$_POST['appt_id'];
    mysqli_query($conn, "UPDATE appointments SET status='cancelled' WHERE appointment_id='$appt_id' AND customer_id='$customer_id'");
    header("Location: customer-dashboard.php?tab=appointments");
    exit();
}

// ── Book Appointment ──
if (isset($_POST['book_consultation'])) {
    $lawyer_id = (int)$_POST['lawyer_id'];
    $date      = mysqli_real_escape_string($conn, $_POST['appt_date']);
    $time      = mysqli_real_escape_string($conn, $_POST['appt_time']);
    $brief     = mysqli_real_escape_string($conn, $_POST['case_brief']);

    $svc_q     = mysqli_query($conn, "SELECT service_id FROM services LIMIT 1");
    $service_id = 1;
    if ($srow = mysqli_fetch_assoc($svc_q)) { $service_id = $srow['service_id']; }

    mysqli_query($conn, "INSERT INTO appointments (customer_id, lawyer_id, service_id, appointment_date, appointment_time, message, status)
                         VALUES ('$customer_id', '$lawyer_id', '$service_id', '$date', '$time', '$brief', 'pending')");
    header("Location: customer-dashboard.php?tab=appointments&booked=1");
    exit();
}

// ── Dashboard Stats ──
$r = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as t FROM appointments WHERE customer_id='$customer_id'"));
$total_appts = (int)$r['t'];

$r = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as t FROM appointments WHERE customer_id='$customer_id' AND status='pending'"));
$pending_appts = (int)$r['t'];

$r = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as t FROM appointments WHERE customer_id='$customer_id' AND status='confirmed'"));
$confirmed_appts = (int)$r['t'];

$r = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as t FROM appointments WHERE customer_id='$customer_id' AND status='completed'"));
$completed_appts = (int)$r['t'];

$r = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as t FROM appointments WHERE customer_id='$customer_id' AND status='cancelled'"));
$cancelled_appts = (int)$r['t'];

// ── Next Upcoming Appointment ──
$next_q = mysqli_query($conn, "
    SELECT a.*, l.full_name as lawyer_name, l.specialization, l.profile_image as l_img, l.email as l_email, l.city as l_city, s.fee
    FROM appointments a
    INNER JOIN lawyers l ON a.lawyer_id = l.lawyer_id
    INNER JOIN services s ON a.service_id = s.service_id
    WHERE a.customer_id='$customer_id'
      AND a.status IN ('pending','confirmed')
      AND a.appointment_date >= CURDATE()
    ORDER BY a.appointment_date ASC, a.appointment_time ASC
    LIMIT 1
");
$next_appt = mysqli_fetch_assoc($next_q);

// ── Build PHP appointments JSON for JS override ──
$all_appts_q = mysqli_query($conn, "
    SELECT a.*, l.full_name as lawyer_name, l.specialization, l.city as l_city, l.email as l_email, l.profile_image as l_img, s.service_name, s.fee
    FROM appointments a
    INNER JOIN lawyers l ON a.lawyer_id = l.lawyer_id
    INNER JOIN services s ON a.service_id = s.service_id
    WHERE a.customer_id='$customer_id'
    ORDER BY a.appointment_id DESC
");
$php_appointments = [];
while ($row = mysqli_fetch_assoc($all_appts_q)) {
    $l_img_url = !empty($row['l_img']) ? 'uploads/' . $row['l_img'] : 'https://ui-avatars.com/api/?name=' . urlencode($row['lawyer_name']) . '&background=1A2F60&color=C9A84C&size=200';
    $php_appointments[] = [
        'id'          => 'APT-' . $row['appointment_id'],
        'appt_id_raw' => (int)$row['appointment_id'],
        'lawyerName'  => $row['lawyer_name'],
        'specialization' => $row['specialization'],
        'lawyer_img'  => $l_img_url,
        'lawyer_city' => $row['l_city'],
        'lawyer_email'=> $row['l_email'],
        'service_name'=> $row['service_name'],
        'date'        => $row['appointment_date'],
        'time'        => $row['appointment_time'],
        'fee'         => $row['fee'],
        'status'      => $row['status'],
        'brief'       => $row['message'] ?? ''
    ];
}
$php_appointments_json = json_encode($php_appointments);
?>
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
      <a class="navbar-brand-logo text-decoration-none" href="index.php" style="display:inline-flex;">
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
        <?php if(!empty($customer['profile_image'])): ?>
            <img src="uploads/<?php echo $customer['profile_image']; ?>" style="width:100%; height:100%; object-fit:cover;">
        <?php else: ?>
            <?php echo $initials; ?>
        <?php endif; ?>
      </div>
      <div>
        <div style="font-size:0.85rem; font-weight:700; color:var(--white);" id="clientSideName"><?php echo htmlspecialchars($customer['full_name']); ?></div>
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
      <div class="menu-item" onclick="window.location.href='index.php'"><i class="fas fa-home"></i> Back to Homepage</div>
      <div class="menu-item" onclick="window.location.href='customer-logout.php'" style="color:#ef4444;"><i class="fas fa-sign-out-alt"></i> Log Out</div>
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

        <div id="topAvatarWrap" style="width:36px; height:36px; border-radius:50%; background:var(--gold-gradient); display:flex; align-items:center; justify-content:center; color:var(--dark); font-weight:800; font-size:0.85rem; overflow:hidden; cursor:pointer;" onclick="switchTab('profile-settings')">
          <?php if (!empty($customer['profile_image'])): ?>
            <img src="uploads/<?php echo htmlspecialchars($customer['profile_image']); ?>" style="width:100%; height:100%; object-fit:cover;">
          <?php else: ?>
            <?php echo $initials; ?>
          <?php endif; ?>
        </div>
      </div>
    </header>

    <!-- Main Content Area -->
    <div class="dash-content">

      <!-- ===================== PANEL: OVERVIEW ===================== -->
      <div class="panel-section active" id="panel-dashboard">
        
        <!-- Welcome Hero Banner -->
        <div style="background:linear-gradient(135deg, var(--navy) 0%, var(--navy-mid) 100%); border:1px solid rgba(201, 168, 76, 0.2); border-radius:12px; padding:2rem; margin-bottom:2rem;">
          <h3 style="font-family:var(--font-serif); font-size:1.4rem; font-weight:700; color:var(--white); margin-bottom:0.4rem;" id="clientWelcomeName">Welcome back, <?php echo htmlspecialchars($customer['full_name']); ?></h3>
          <p style="font-size:0.85rem; color:rgba(255, 255, 255, 0.7); margin:0;">
            You have <strong style="color:var(--gold)"><?php echo $confirmed_appts; ?> confirmed</strong> and <strong style="color:var(--gold)"><?php echo $pending_appts; ?> pending</strong> consultation(s). Find attorneys, manage schedules, and track your appointments directly from this portal.
          </p>
        </div>

        <!-- Dashboard Cards -->
        <div class="grid-stats">
          <div class="stat-box">
            <div class="stat-box-icon"><i class="fas fa-calendar-check"></i></div>
            <div>
              <div class="stat-box-val" id="statTotalAppts"><?php echo $total_appts; ?></div>
              <div class="stat-box-label">Total Bookings</div>
            </div>
          </div>
          <div class="stat-box">
            <div class="stat-box-icon"><i class="fas fa-check-circle"></i></div>
            <div>
              <div class="stat-box-val" id="statConfirmedAppts"><?php echo $confirmed_appts; ?></div>
              <div class="stat-box-label">Confirmed</div>
            </div>
          </div>
          <div class="stat-box">
            <div class="stat-box-icon"><i class="fas fa-clock"></i></div>
            <div>
              <div class="stat-box-val" id="statPendingAppts"><?php echo $pending_appts; ?></div>
              <div class="stat-box-label">Pending</div>
            </div>
          </div>
          <div class="stat-box">
            <div class="stat-box-icon"><i class="fas fa-flag-checkered"></i></div>
            <div>
              <div class="stat-box-val" id="statCompletedAppts"><?php echo $completed_appts; ?></div>
              <div class="stat-box-label">Completed</div>
            </div>
          </div>
        </div>

        <!-- Next Consultation spotlight card -->
        <div class="dash-card mb-4" style="border-color: rgba(201, 168, 76, 0.35); background: rgba(201, 168, 76, 0.02);">
          <div class="dash-card-title text-gold" style="font-size:0.9rem; font-weight:700; letter-spacing:0.08em; text-transform:uppercase; margin-bottom:1rem;">
            <span><i class="fas fa-bolt me-2"></i>Next Scheduled Consultation</span>
            <span style="font-size:0.8rem; color:var(--white);" id="nextConsultationTime">
              <?php echo $next_appt ? htmlspecialchars($next_appt['appointment_date']) . ' at ' . htmlspecialchars($next_appt['appointment_time']) : 'None Scheduled'; ?>
            </span>
          </div>
          <div id="nextApptSpotlightCard">
            <?php if ($next_appt):
              $n_img = !empty($next_appt['l_img']) ? 'uploads/' . htmlspecialchars($next_appt['l_img']) : 'https://ui-avatars.com/api/?name=' . urlencode($next_appt['lawyer_name']) . '&background=1A2F60&color=C9A84C&size=200';
              $n_status = htmlspecialchars($next_appt['status']);
              $n_badge = ($n_status === 'confirmed') ? 'badge-Confirmed' : 'badge-Pending';
              $n_badge_label = ($n_status === 'confirmed') ? '<i class="fas fa-check-circle me-1"></i>Confirmed' : '<i class="fas fa-clock me-1"></i>Awaiting Approval';
            ?>
            <div class="row align-items-center g-3">
              <div class="col-sm-3 col-md-2 text-center text-sm-start">
                <img src="<?php echo $n_img; ?>" class="rounded-circle border border-gold border-2" style="width:80px; height:80px; object-fit:cover;">
              </div>
              <div class="col-sm-9 col-md-7">
                <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                  <h5 style="margin:0; font-size:1.15rem; font-family:var(--font-serif);"><?php echo htmlspecialchars($next_appt['lawyer_name']); ?></h5>
                  <span class="badge-status <?php echo $n_badge; ?>"><?php echo $n_badge_label; ?></span>
                </div>
                <p style="font-size:0.75rem; color:var(--gold); font-weight:700; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.05em;">
                  <?php echo htmlspecialchars($next_appt['specialization']); ?> Specialization
                </p>
                <p style="font-size:0.84rem; color:rgba(255,255,255,0.7); margin-bottom:0;">
                  <strong>Scheduled:</strong> <?php echo htmlspecialchars($next_appt['appointment_date']); ?> @ <?php echo htmlspecialchars($next_appt['appointment_time']); ?>
                </p>
              </div>
              <div class="col-md-3 text-center text-md-end">
                <button class="btn-outline-gold" style="padding:10px 22px; font-size:0.8rem;" onclick="switchTab('appointments')">
                  <i class="fas fa-search me-2"></i>View Booking
                </button>
              </div>
            </div>
            <?php else: ?>
            <p style="color:var(--text-muted); font-size:0.85rem; margin:0;"><i class="fas fa-calendar-times me-2"></i>No upcoming appointments scheduled. <a href="#" onclick="switchTab('search-lawyers'); return false;" style="color:var(--gold);">Find a lawyer</a> to book a consultation.</p>
            <?php endif; ?>
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
                <?php
                $recent_q = mysqli_query($conn, "
                    SELECT a.*, l.full_name as lawyer_name, s.service_name, s.fee 
                    FROM appointments a 
                    INNER JOIN lawyers l ON a.lawyer_id = l.lawyer_id 
                    INNER JOIN services s ON a.service_id = s.service_id 
                    WHERE a.customer_id='$customer_id' 
                    ORDER BY a.appointment_id DESC LIMIT 5
                ");

                if(mysqli_num_rows($recent_q) > 0) {
                    while($r = mysqli_fetch_assoc($recent_q)) {
                        $badgeClass = 'bg-secondary';
                        if($r['status'] == 'active' || $r['status'] == 'confirmed') $badgeClass = 'bg-success';
                        elseif($r['status'] == 'pending') $badgeClass = 'bg-warning text-dark';
                        
                        echo "<tr>
                            <td>APT-{$r['appointment_id']}</td>
                            <td>{$r['lawyer_name']}</td>
                            <td>{$r['service_name']}</td>
                            <td>{$r['appointment_date']} at {$r['appointment_time']}</td>
                            <td>PKR {$r['fee']}</td>
                            <td><span class='badge {$badgeClass}'>{$r['status']}</span></td>
                            <td>
                                <button class='btn btn-sm btn-outline-info' onclick=\"switchTab('appointments')\">View</button>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7' class='text-center text-muted py-4'>No recent appointments found.</td></tr>";
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>

      </div>

      <!-- ===================== PANEL: SEARCH LAWYERS ===================== -->
      <div class="panel-section" id="panel-search-lawyers">
        
        <!-- Interactive Quad-Search Bar -->
        <div class="lawyer-search-bar">
          <form method="GET" action="">
            <div class="row g-3">
              <div class="col-md-9">
                <label class="form-label" style="font-size:0.75rem; font-weight:700; text-transform:uppercase; color:var(--gold); letter-spacing:0.05em;">Attorney Name, Specialization, or City</label>
                <div class="input-group">
                  <span class="input-group-text bg-transparent text-gold border-secondary"><i class="fas fa-search"></i></span>
                  <input type="text" name="search" class="form-control bg-transparent text-white border-secondary" placeholder="Search e.g. Criminal, Karachi, Ali..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                </div>
              </div>
              <div class="col-md-3">
                <label class="form-label">&nbsp;</label>
                <button type="submit" class="btn-gold w-100" style="padding:10px;"><i class="fas fa-search me-2"></i>Search Database</button>
              </div>
            </div>
          </form>
        </div>

        <!-- Lawyer Cards Grid -->
        <div class="row g-4" id="lawyersGridRow">
          <?php
          $search_query = "";
          if(isset($_GET['search']) && !empty(trim($_GET['search']))) {
              $search = mysqli_real_escape_string($conn, $_GET['search']);
              $search_query = " AND (full_name LIKE '%$search%' OR specialization LIKE '%$search%' OR city LIKE '%$search%')";
          }

          $lawyer_q = mysqli_query($conn, "SELECT * FROM lawyers WHERE status='Approved' $search_query");
          
          if(mysqli_num_rows($lawyer_q) > 0) {
              while($lawyer = mysqli_fetch_assoc($lawyer_q)) {
                  $img = !empty($lawyer['profile_image']) ? "uploads/".$lawyer['profile_image'] : "https://ui-avatars.com/api/?name=".urlencode($lawyer['full_name']);
                  
                  // Limit bio text to prevent breaking card layout
                  $bio = htmlspecialchars($lawyer['bio']);
                  if(strlen($bio) > 80) $bio = substr($bio, 0, 80) . '...';

                  echo "
                  <div class='col-md-6 col-lg-4 lawyer-item'>
                    <div class='dash-card text-center' style='padding:2rem 1.5rem; height:100%; display:flex; flex-direction:column;'>
                      <div class='round-headshot-preview mx-auto' style='width:90px; height:90px; margin-bottom:1rem;'>
                        <img src='{$img}' alt='Lawyer'>
                      </div>
                      <h4 style='font-family:var(--font-serif); font-size:1.2rem; margin-bottom:4px;'>{$lawyer['full_name']}</h4>
                      <p style='color:var(--gold); font-size:0.75rem; text-transform:uppercase; font-weight:700; margin-bottom:0.5rem;'>{$lawyer['specialization']}</p>
                      
                      <div class='d-flex justify-content-center gap-3 mb-2' style='font-size:0.75rem; color:var(--text-muted);'>
                        <span><i class='fas fa-map-marker-alt me-1 text-gold'></i> {$lawyer['city']}</span>
                        <span><i class='fas fa-briefcase me-1 text-gold'></i> {$lawyer['experience']} Yrs</span>
                      </div>
                      
                      <p style='font-size:0.8rem; color:rgba(255,255,255,0.7); line-height:1.4; margin-bottom:1rem; flex-grow:1;'>
                        {$bio}
                      </p>
                      
                      <div class='mt-auto pt-3 border-top border-secondary'>
                        <div class='mb-3 text-start d-flex justify-content-between align-items-center'>
                          <span style='font-size:0.7rem; color:var(--text-muted); text-transform:uppercase;'>Retainer Fee</span>
                          <strong style='color:var(--white);'>PKR {$lawyer['consultation_fee']}</strong>
                        </div>
                        <div class='d-flex justify-content-between gap-2'>
                          <a href='lawyer_profile.php?id={$lawyer['lawyer_id']}' class='btn-outline-gold w-50' style='padding:8px 0; font-size:0.75rem; text-align:center; text-decoration:none;'>
                            View Profile
                          </a>
                          <a href='book_appointment.php?id={$lawyer['lawyer_id']}' class='btn-gold w-50' style='padding:8px 0; font-size:0.75rem; text-align:center; text-decoration:none;'>
                            Book Slot
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>";
              }
          } else {
              echo "<div class='col-12 text-center text-muted py-5'>
                      <i class='fas fa-gavel fa-3x mb-3' style='color:var(--gold); opacity:0.5;'></i>
                      <h5 class='text-white'>No Approved Lawyers Found</h5>
                      <p>Try adjusting your search terms.</p>
                    </div>";
          }
          ?>
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
                <?php
                $appts_q = mysqli_query($conn, "
                    SELECT a.*, l.full_name as lawyer_name, s.service_name, s.fee, l.profile_image, l.specialization, l.city, l.email as lawyer_email
                    FROM appointments a 
                    INNER JOIN lawyers l ON a.lawyer_id = l.lawyer_id 
                    INNER JOIN services s ON a.service_id = s.service_id 
                    WHERE a.customer_id='$customer_id' 
                    ORDER BY a.appointment_id DESC
                ");

                if(mysqli_num_rows($appts_q) > 0) {
                    while($r = mysqli_fetch_assoc($appts_q)) {
                        $badgeClass = 'bg-secondary';
                        if($r['status'] == 'active' || $r['status'] == 'confirmed') $badgeClass = 'bg-success';
                        elseif($r['status'] == 'pending') $badgeClass = 'bg-warning text-dark';
                        
                        $img = !empty($r['profile_image']) ? "uploads/".$r['profile_image'] : "https://ui-avatars.com/api/?name=".urlencode($r['lawyer_name']);

                        // JSON encode row to pass to JS view function
                        $json_data = htmlspecialchars(json_encode([
                            'id' => 'APT-'.$r['appointment_id'],
                            'lawyer_name' => $r['lawyer_name'],
                            'lawyer_spec' => $r['specialization'],
                            'lawyer_city' => $r['city'],
                            'lawyer_email' => $r['lawyer_email'],
                            'lawyer_img' => $img,
                            'date' => $r['appointment_date'],
                            'time' => $r['appointment_time'],
                            'fee' => $r['fee'],
                            'status' => $r['status']
                        ]), ENT_QUOTES, 'UTF-8');

                        echo "<tr class='appt-row' data-status='".strtolower($r['status'])."'>
                            <td>APT-{$r['appointment_id']}</td>
                            <td>{$r['lawyer_name']}</td>
                            <td>{$r['service_name']}</td>
                            <td>{$r['appointment_date']} at {$r['appointment_time']}</td>
                            <td>PKR {$r['fee']}</td>
                            <td><span class='badge {$badgeClass}'>{$r['status']}</span></td>
                            <td>
                                <button class='btn btn-sm btn-outline-info' onclick='viewAppointmentDetails({$json_data})'>Details</button>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7' class='text-center text-muted py-4'>No appointments found.</td></tr>";
                }
                ?>
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
                <form method="POST" action="" id="cancelApptForm" style="display:inline;">
                  <input type="hidden" name="appt_id" id="cancelApptIdInput" value="">
                  <button type="submit" name="cancel_appointment" class="btn-gold bg-danger text-white border-0" id="detailsCancelBtn" style="padding:10px 22px; font-size:0.8rem; box-shadow:none;" onclick="return confirm('Are you sure you want to cancel this appointment?');">
                    <i class="fas fa-ban me-2"></i>Cancel Appointment
                  </button>
                </form>
              </div>

            </div>
          </div>

        </div>

      </div>

      <!-- ===================== PANEL: PROFILE SETTINGS ===================== -->
      <div class="panel-section" id="panel-profile-settings">
        
        <div class="row g-4">
          <!-- Left Col: Photo preview -->
          <div class="col-lg-4">
            <div class="dash-card text-center">
              <div class="dash-card-title" style="justify-content:center;">Client Avatar Picture</div>
              
              <div class="round-headshot-preview">
                <?php if (!empty($customer['profile_image'])): ?>
                  <img src="uploads/<?php echo htmlspecialchars($customer['profile_image']); ?>" alt="Profile Photo" id="profileHeadshotPreview" style="width:100%; height:100%; object-fit:cover; border-radius:50%;">
                <?php else: ?>
                  <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($customer['full_name']); ?>&background=1A2F60&color=C9A84C&size=200" alt="Profile Photo" id="profileHeadshotPreview" style="width:100%; height:100%; object-fit:cover; border-radius:50%;">
                <?php endif; ?>
              </div>

              <div style="margin-top:1rem; padding:1rem; background:rgba(255,255,255,0.03); border:1px dashed rgba(201,168,76,0.3); border-radius:10px;">
                <i class="fas fa-info-circle" style="font-size:1rem; color:var(--gold); display:block; margin-bottom:8px;"></i>
                <span style="font-size:0.8rem; color:var(--white); font-weight:600; display:block;">Update Photo</span>
                <span style="font-size:0.65rem; color:var(--text-muted);">Use the form on the right to upload a new photo</span>
              </div>
            </div>
          </div>

          <!-- Right Col: Profile fields Form -->
          <div class="col-lg-8">
            <?php if (isset($_GET['saved'])): ?>
            <div class="alert alert-success" style="background:rgba(74,222,128,0.1); border:1px solid rgba(74,222,128,0.4); color:#4ade80; border-radius:8px; padding:12px 16px; margin-bottom:1rem; font-size:0.85rem;">
              <i class="fas fa-check-circle me-2"></i>Profile updated successfully!
            </div>
            <?php endif; ?>
            <div class="dash-card mb-4">
              <div class="dash-card-title">Client Account Details</div>
              <form method="POST" action="" enctype="multipart/form-data">
                <div class="row g-3">
                  <div class="col-md-6">
                    <div class="form-field-luxury">
                      <label for="profName">Full Name</label>
                      <input type="text" name="full_name" class="luxury-input form-control" id="profName" value="<?php echo htmlspecialchars($customer['full_name']); ?>" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-field-luxury">
                      <label for="profEmail">Email Address (Read Only)</label>
                      <input type="email" class="luxury-input form-control" id="profEmail" value="<?php echo htmlspecialchars($customer['email']); ?>" readonly style="opacity:0.6; cursor:not-allowed;">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-field-luxury">
                      <label for="profPhone">Phone Number</label>
                      <input type="tel" name="phone" class="luxury-input form-control" id="profPhone" value="<?php echo htmlspecialchars($customer['phone'] ?? ''); ?>">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-field-luxury">
                      <label for="profGender">Gender</label>
                      <select name="gender" class="luxury-input form-control" id="profGender" style="background-color:var(--dark-card);">
                        <option value="" <?php echo empty($customer['gender']) ? 'selected' : ''; ?>>Select Gender</option>
                        <option value="Male" <?php echo ($customer['gender'] ?? '') === 'Male' ? 'selected' : ''; ?>>Male</option>
                        <option value="Female" <?php echo ($customer['gender'] ?? '') === 'Female' ? 'selected' : ''; ?>>Female</option>
                        <option value="Other" <?php echo ($customer['gender'] ?? '') === 'Other' ? 'selected' : ''; ?>>Other</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-field-luxury">
                      <label for="profAddress">Address</label>
                      <textarea name="address" class="luxury-input form-control" id="profAddress" rows="2" style="resize:none;"><?php echo htmlspecialchars($customer['address'] ?? ''); ?></textarea>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-field-luxury">
                      <label for="profImageUpload">Update Profile Photo (JPG/PNG, max 2MB)</label>
                      <input type="file" name="profile_image" class="luxury-input form-control" id="profImageUpload" accept="image/*">
                    </div>
                  </div>
                </div>
                <button type="submit" name="update_profile" class="btn-gold mt-3" style="padding:12px 30px;"><i class="fas fa-save me-2"></i>Save Settings</button>
              </form>
            </div>

            <!-- Change Password Card -->
            <div class="dash-card">
              <div class="dash-card-title">Security &amp; Encryption</div>
              <form method="POST" action="">
                <div class="row g-3">
                  <div class="col-md-4">
                    <div class="form-field-luxury">
                      <label for="curPass">Current Password</label>
                      <input type="password" name="cur_pass" class="luxury-input form-control" id="curPass" placeholder="••••••••" required>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-field-luxury">
                      <label for="newPass">New Password</label>
                      <input type="password" name="new_pass" class="luxury-input form-control" id="newPass" placeholder="••••••••" required>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-field-luxury">
                      <label for="confPass">Confirm New Password</label>
                      <input type="password" class="luxury-input form-control" id="confPass" placeholder="••••••••" required>
                    </div>
                  </div>
                </div>
                <button type="submit" name="update_password" class="btn-gold mt-3" style="padding:12px 30px;" onclick="if(document.getElementById('newPass').value != document.getElementById('confPass').value) { alert('Passwords do not match'); return false; }"><i class="fas fa-shield-alt me-2"></i>Update Password</button>
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
      <form method="POST" action="">
      <input type="hidden" name="lawyer_id" id="modalLawyerIdHidden">
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
          <input type="date" name="appt_date" class="luxury-input form-control" required style="max-width: 250px;">
        </div>

        <!-- Time selector -->
        <div class="mb-4">
          <div class="slot-selection-title">2. Select Hour Slot</div>
          <input type="time" name="appt_time" class="luxury-input form-control" required style="max-width: 250px;">
        </div>

        <!-- Case details description -->
        <div class="mb-3">
          <div class="slot-selection-title">3. Enter Case Brief (Confidential)</div>
          <textarea class="luxury-input form-control" name="case_brief" rows="3" placeholder="Briefly describe your legal concerns so the attorney can prepare..." style="font-size:0.85rem; resize:none;" required></textarea>
        </div>

        <div class="text-muted" style="font-size:0.7rem;">
          <i class="fas fa-shield-halved text-gold me-1"></i> Under state law, all consultation details are fully covered by attorney-client privilege.
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-outline-gold" style="padding:10px 20px; font-size:0.8rem;" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" name="book_consultation" class="btn-gold" style="padding:10px 24px; font-size:0.8rem;">
          <i class="fas fa-check-circle me-1"></i>Confirm Booking Request
        </button>
      </div>
      </form>
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

<!-- ── PHP→JS DATA BRIDGE: Kills all localStorage mocks, injects real DB data ── -->
<script>
// ══ STEP 1: Wipe stale localStorage mock data IMMEDIATELY (before any ready fires) ══
localStorage.removeItem('lexelite_user_profile');
localStorage.removeItem('lexelite_appointments');
localStorage.removeItem('lexelite_lawyers');

// ══ STEP 2: Inject real data from PHP/MySQL ══
var PHP_APPOINTMENTS = <?php echo $php_appointments_json; ?>;
var PHP_CUSTOMER = {
  name:   '<?php echo addslashes(htmlspecialchars($customer['full_name'], ENT_QUOTES)); ?>',
  email:  '<?php echo addslashes(htmlspecialchars($customer['email'], ENT_QUOTES)); ?>',
  phone:  '<?php echo addslashes(htmlspecialchars($customer['phone'] ?? '', ENT_QUOTES)); ?>',
  avatar: '<?php echo !empty($customer['profile_image']) ? addslashes('uploads/' . htmlspecialchars($customer['profile_image'], ENT_QUOTES)) : ''; ?>',
  tier:   'Premium Client'
};

// ══ STEP 3: Override ALL localStorage-dependent functions ══
function seedInitialData()   { /* disabled */ }
function getProfile()        { return PHP_CUSTOMER; }
function saveProfile(p)      { /* no-op */ }
function getLawyers()        { return (typeof LAWYERS !== 'undefined') ? LAWYERS : []; }
function getAppointments()   { return PHP_APPOINTMENTS; }
function saveAppointments(a) { /* no-op */ }

function syncProfileHeader() {
  var name   = PHP_CUSTOMER.name;
  var email  = PHP_CUSTOMER.email;
  var avatar = PHP_CUSTOMER.avatar;

  $('#clientSideName').text(name);
  $('#clientSideEmail').text(email);
  $('#clientWelcomeName').text('Welcome back, ' + name);

  var initials = name.split(' ').map(function(n){ return (n[0] || ''); }).join('').toUpperCase().slice(0, 2);
  var avatarHtml = avatar
    ? '<img src="' + avatar + '" style="width:100%;height:100%;object-fit:cover;">'
    : initials;
  $('#sideAvatarWrap').html(avatarHtml);
  $('#topAvatarWrap').html(avatarHtml);

  $('#profName').val(name);
  $('#profPhone').val(PHP_CUSTOMER.phone);
}

function loadDashboardOverview() {
  $('#statTotalAppts').text('<?php echo $total_appts; ?>');
  $('#statConfirmedAppts').text('<?php echo $confirmed_appts; ?>');
  $('#statPendingAppts').text('<?php echo $pending_appts; ?>');
  $('#statCompletedAppts').text('<?php echo $completed_appts; ?>');

  // Re-render recent appointments table with real data
  var recent = PHP_APPOINTMENTS.slice(0, 5);
  var html = '';
  recent.forEach(function(a) {
    var st = a.status || 'pending';
    var bc = st === 'confirmed' ? 'bg-success' : (st === 'pending' ? 'bg-warning text-dark' : (st === 'completed' ? 'bg-primary' : 'bg-secondary'));
    html += '<tr>'
          + '<td><strong>' + a.id + '</strong></td>'
          + '<td><strong>' + a.lawyerName + '</strong></td>'
          + '<td><span style="font-size:0.75rem;color:var(--gold);font-weight:600;text-transform:uppercase;">' + (a.service_name || a.specialization) + '</span></td>'
          + '<td>' + a.date + ' · ' + a.time + '</td>'
          + '<td>PKR ' + a.fee + '</td>'
          + '<td><span class="badge ' + bc + '">' + st + '</span></td>'
          + '<td><button class="btn btn-sm btn-outline-info" onclick=\'viewAppointmentDetails(' + JSON.stringify(a) + ')\'>View</button></td>'
          + '</tr>';
  });
  if (!html) html = '<tr><td colspan="7" class="text-center text-muted py-4">No recent appointments found.</td></tr>';
  $('#recentApptsTableBody').html(html);
}

function cancelCurrentAppointment() {
  if (!currentViewingAppointmentId) return;
  var apptIdRaw = String(currentViewingAppointmentId).replace('APT-', '');
  if (confirm('Are you sure you want to cancel this appointment?')) {
    $('#cancelApptIdInput').val(apptIdRaw);
    $('#cancelApptForm').submit();
  }
}

// ══ STEP 4: Run immediately (before ready) to update visible DOM right away ══
// Using a tiny timeout of 0 ensures DOM is painted but before user interacts
setTimeout(function() {
  if (typeof $ !== 'undefined') {
    syncProfileHeader();
  }
}, 0);

// ══ STEP 5: jQuery ready ══
$(document).ready(function () {
  // Immediately override profile (kills Eleanor)
  syncProfileHeader();
  loadDashboardOverview();

  // Auto-open correct tab
  var urlParams = new URLSearchParams(window.location.search);
  var tab = urlParams.get('tab');
  if (tab) { switchTab(tab); }

  if (urlParams.get('booked') === '1') {
    showToast('Booking Request submitted successfully!');
  }
  if (window.location.search.includes('search=')) {
    switchTab('search-lawyers');
  }
});
</script>
</body>
</html>
