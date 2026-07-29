<?php
include_once 'includes/connection.php';
session_start();

if (!isset($_SESSION['customer_id'])) {
    header("Location: customer-login.php");
    exit();
}

$customer_id = (int)$_SESSION['customer_id'];

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("<div style='background:#111118; color:white; padding:50px; text-align:center; font-family:sans-serif;'><h2>Error: Appointment ID not provided.</h2><br><a href='customer-dashboard.php' style='color:#C9A84C;'>Return to Dashboard</a></div>");
}

$appt_id = (int)mysqli_real_escape_string($conn, str_replace('APT-', '', $_GET['id']));

$query = mysqli_query($conn, "
    SELECT a.*, 
           c.full_name AS customer_name, c.email AS customer_email, c.phone AS customer_phone,
           l.full_name AS lawyer_name, l.specialization, l.qualification, l.experience, 
           l.phone AS lawyer_phone, l.email AS lawyer_email, l.address AS office_address, l.city, l.profile_image,
           s.service_name, s.description AS service_description, s.fee
    FROM appointments a
    INNER JOIN customers c ON a.customer_id = c.customer_id
    INNER JOIN lawyers l ON a.lawyer_id = l.lawyer_id
    INNER JOIN services s ON a.service_id = s.service_id
    WHERE a.appointment_id = '$appt_id'
");

if (mysqli_num_rows($query) == 0) {
    die("<div style='background:#111118; color:white; padding:50px; text-align:center; font-family:sans-serif;'><h2>Error: Appointment Not Found.</h2><br><a href='customer-dashboard.php' style='color:#C9A84C;'>Return to Dashboard</a></div>");
}

$appt = mysqli_fetch_assoc($query);

// Security check: Only the logged-in customer should view their own appointment
if ($appt['customer_id'] != $customer_id) {
    die("<div style='background:#111118; color:white; padding:50px; text-align:center; font-family:sans-serif;'><h2>Error: Access Denied.</h2><br><a href='customer-dashboard.php' style='color:#C9A84C;'>Return to Dashboard</a></div>");
}

$l_img = !empty($appt['profile_image']) ? 'uploads/' . htmlspecialchars($appt['profile_image']) : 'https://ui-avatars.com/api/?name=' . urlencode($appt['lawyer_name']) . '&background=1A2F60&color=C9A84C&size=200';
$statusClass = 'bg-secondary';
if($appt['status'] == 'active' || $appt['status'] == 'confirmed') $statusClass = 'bg-success';
elseif($appt['status'] == 'pending') $statusClass = 'bg-warning text-dark';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>View Appointment — LexElite</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
  <link rel="stylesheet" href="css/luxury.css"/>
  <link rel="stylesheet" href="css/admin.css"/>
  <style>
    body { background: var(--dark); color: var(--white); }
    .dash-layout { display: flex; flex-direction: column; min-height: 100vh; padding: 20px; align-items: center; }
    .panel-section { max-width: 1000px; width: 100%; display: block !important; margin-top: 20px; }
    .dash-card { background: var(--dark-card); border-radius: 12px; padding: 25px; border: 1px solid rgba(255,255,255,0.05); }
    .dash-card-title { font-family: var(--font-serif); font-size: 1.25rem; font-weight: 700; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: 15px; }
  </style>
</head>
<body>

<div class="dash-layout">
    <div class="panel-section" id="panel-appointment-details">
        <div class="mb-3">
          <a href="customer-dashboard.php" class="btn-outline-gold" style="padding:6px 16px; font-size:0.75rem; text-decoration:none;">
            <i class="fas fa-arrow-left me-2"></i>Back to My Appointments
          </a>
        </div>

        <div class="row g-4">
          <!-- Column 1: Attorney Profile Spotlight -->
          <div class="col-lg-5">
            <div class="dash-card text-center">
              <div class="dash-card-title" style="justify-content:center;">Assigned Counsel</div>
              <div class="round-headshot-preview mx-auto mb-3" style="width:110px; height:110px; border-radius:50%; overflow:hidden; border:2px solid var(--gold);">
                <img src="<?php echo $l_img; ?>" alt="Lawyer photo" style="width:100%; height:100%; object-fit:cover;">
              </div>
              <h4 style="font-family:var(--font-serif); font-size:1.3rem; margin-bottom:4px;"><?php echo htmlspecialchars($appt['lawyer_name']); ?></h4>
              <p style="color:var(--gold); font-size:0.78rem; text-transform:uppercase; font-weight:700; letter-spacing:0.08em;"><?php echo htmlspecialchars($appt['specialization']); ?></p>
              
              <div class="text-start mt-4 pt-3 border-top border-secondary" style="font-size:0.82rem; line-height:1.8;">
                <div class="mb-2"><i class="fas fa-graduation-cap text-gold me-2" style="width:18px;"></i> <?php echo htmlspecialchars($appt['qualification'] ?? 'N/A'); ?></div>
                <div class="mb-2"><i class="fas fa-briefcase text-gold me-2" style="width:18px;"></i> <?php echo htmlspecialchars($appt['experience'] ?? '0'); ?> Years Experience</div>
                <div class="mb-2"><i class="fas fa-map-marker-alt text-gold me-2" style="width:18px;"></i> <?php echo htmlspecialchars(($appt['city'] ? $appt['city'] . ' — ' : '') . ($appt['office_address'] ?? 'N/A')); ?></div>
                <div class="mb-2"><i class="fas fa-phone text-gold me-2" style="width:18px;"></i> <?php echo htmlspecialchars($appt['lawyer_phone'] ?? 'N/A'); ?></div>
                <div class="mb-2"><i class="fas fa-envelope text-gold me-2" style="width:18px;"></i> <?php echo htmlspecialchars($appt['lawyer_email'] ?? 'N/A'); ?></div>
              </div>
            </div>

            <div class="dash-card text-center mt-4">
              <div class="dash-card-title" style="justify-content:center;">Client Information</div>
              <div class="text-start" style="font-size:0.82rem; line-height:1.8;">
                <div class="mb-2"><i class="fas fa-user text-gold me-2" style="width:18px;"></i> <?php echo htmlspecialchars($appt['customer_name']); ?></div>
                <div class="mb-2"><i class="fas fa-envelope text-gold me-2" style="width:18px;"></i> <?php echo htmlspecialchars($appt['customer_email']); ?></div>
                <div class="mb-2"><i class="fas fa-phone text-gold me-2" style="width:18px;"></i> <?php echo htmlspecialchars($appt['customer_phone']); ?></div>
              </div>
            </div>
          </div>

          <!-- Column 2: Appointment Details -->
          <div class="col-lg-7">
            <div class="dash-card h-100 d-flex flex-column">
              <div class="dash-card-title">
                <span>Appointment Summary</span>
                <span class="badge <?php echo $statusClass; ?> text-uppercase" style="font-size:0.75rem;"><?php echo htmlspecialchars($appt['status']); ?></span>
              </div>

              <div class="row g-3 mb-4" style="font-size:0.85rem;">
                <div class="col-6 col-sm-3">
                  <div style="color:var(--text-muted); font-size:0.7rem; text-transform:uppercase;">Appt ID</div>
                  <strong style="color:var(--white);">APT-<?php echo $appt['appointment_id']; ?></strong>
                </div>
                <div class="col-6 col-sm-3">
                  <div style="color:var(--text-muted); font-size:0.7rem; text-transform:uppercase;">Date</div>
                  <strong style="color:var(--white);"><?php echo $appt['appointment_date']; ?></strong>
                </div>
                <div class="col-6 col-sm-3">
                  <div style="color:var(--text-muted); font-size:0.7rem; text-transform:uppercase;">Time Slot</div>
                  <strong style="color:var(--white);"><?php echo date('h:i A', strtotime($appt['appointment_time'])); ?></strong>
                </div>
                <div class="col-6 col-sm-3">
                  <div style="color:var(--text-muted); font-size:0.7rem; text-transform:uppercase;">Booking Date</div>
                  <strong style="color:var(--white);"><?php echo date('Y-m-d', strtotime($appt['created_at'] ?? 'now')); ?></strong>
                </div>
              </div>

              <div class="mb-4">
                <div style="color:var(--text-muted); font-size:0.7rem; text-transform:uppercase; margin-bottom:4px;">Service Information</div>
                <div style="font-size:0.85rem; color:var(--white);">
                  <strong><?php echo htmlspecialchars($appt['service_name']); ?></strong><br>
                  <span style="color:var(--text-muted);"><?php echo htmlspecialchars($appt['service_description'] ?? 'No description available.'); ?></span><br>
                  <span style="color:var(--gold); font-weight:bold;">PKR <?php echo number_format($appt['fee'], 2); ?></span>
                </div>
              </div>

              <div class="mb-4">
                <div style="color:var(--text-muted); font-size:0.7rem; text-transform:uppercase; margin-bottom:4px;">Case Description Brief / Notes</div>
                <div style="font-size:0.85rem; color:rgba(255,255,255,0.85); background:rgba(255,255,255,0.02); border:1px solid rgba(255,255,255,0.05); padding:1rem; border-radius:8px; min-height:80px;">
                  <?php echo !empty($appt['message']) ? nl2br(htmlspecialchars($appt['message'])) : '<em>No additional notes provided.</em>'; ?>
                </div>
              </div>

              <?php if(strtolower($appt['status']) !== 'cancelled'): ?>
              <div class="d-flex gap-2 flex-wrap pt-3 border-top border-secondary mt-auto">
                <form method="POST" action="customer-dashboard.php" style="display:inline;">
                  <input type="hidden" name="appt_id" value="<?php echo $appt['appointment_id']; ?>">
                  <button type="submit" name="cancel_appointment" class="btn-gold bg-danger text-white border-0" style="padding:10px 22px; font-size:0.8rem; box-shadow:none;" onclick="return confirm('Are you sure you want to cancel this appointment?');">
                    <i class="fas fa-ban me-2"></i>Cancel Appointment
                  </button>
                </form>
              </div>
              <?php endif; ?>

            </div>
          </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
