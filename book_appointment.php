<?php
include_once 'includes/connection.php';
session_start();

// Must be logged in as customer
if (!isset($_SESSION['customer_id'])) {
    header("Location: customer-login.php");
    exit();
}

$customer_id = $_SESSION['customer_id'];

// Validate lawyer ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: customer-dashboard.php");
    exit();
}

$lawyer_id = mysqli_real_escape_string($conn, $_GET['id']);
$lawyer_q  = mysqli_query($conn, "SELECT * FROM lawyers WHERE lawyer_id='$lawyer_id' AND status='Approved'");

if (mysqli_num_rows($lawyer_q) == 0) {
    header("Location: customer-dashboard.php");
    exit();
}
$lawyer = mysqli_fetch_assoc($lawyer_q);
$img    = !empty($lawyer['profile_image'])
        ? "uploads/" . $lawyer['profile_image']
        : "https://ui-avatars.com/api/?name=" . urlencode($lawyer['full_name']) . "&background=1A2F60&color=C9A84C&size=200";

// Fetch customer details
$cust_q  = mysqli_query($conn, "SELECT * FROM customers WHERE customer_id='$customer_id'");
$customer = mysqli_fetch_assoc($cust_q);

// Handle form submission
$success = false;
$error   = '';

if (isset($_POST['book_now'])) {
    $appt_date  = mysqli_real_escape_string($conn, $_POST['appt_date']);
    $appt_time  = mysqli_real_escape_string($conn, $_POST['appt_time']);
    $case_brief = mysqli_real_escape_string($conn, $_POST['case_brief']);
    $mode       = mysqli_real_escape_string($conn, $_POST['consult_mode']);

    if (empty($appt_date) || empty($appt_time) || empty($case_brief)) {
        $error = "Please fill in all required fields.";
    } else {
        // Get a service_id (fallback to 1)
        $svc_q      = mysqli_query($conn, "SELECT service_id FROM services LIMIT 1");
        $service_id = 1;
        if ($srow = mysqli_fetch_assoc($svc_q)) {
            $service_id = $srow['service_id'];
        }

        $insert = "INSERT INTO appointments (customer_id, lawyer_id, service_id, appointment_date, appointment_time, status)
                   VALUES ('$customer_id', '$lawyer_id', '$service_id', '$appt_date', '$appt_time', 'pending')";
        if (mysqli_query($conn, $insert)) {
            $success = true;
        } else {
            $error = "Booking failed. Please try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="description" content="Book an appointment with your chosen attorney on LexElite."/>
  <title>Book Appointment — LexElite</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap"/>
  <link rel="stylesheet" href="css/luxury.css"/>

  <style>
    :root {
      --dark:       #080c14;
      --navy:       #0a1628;
      --navy-mid:   #0e1f3a;
      --dark-card:  #0f1923;
      --gold:       #C9A84C;
      --gold-light: #e0c070;
      --white:      #f5f0e8;
      --text-muted: rgba(245,240,232,0.45);
      --gold-gradient: linear-gradient(135deg, #C9A84C 0%, #e0c070 50%, #C9A84C 100%);
      --font-serif: 'Cormorant Garamond', serif;
      --font-sans:  'Inter', sans-serif;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      background: var(--dark);
      color: var(--white);
      font-family: var(--font-sans);
      min-height: 100vh;
    }

    /* ─── NAV ─── */
    .book-nav {
      background: rgba(8,12,20,0.95);
      backdrop-filter: blur(20px);
      border-bottom: 1px solid rgba(201,168,76,0.15);
      padding: 1rem 2rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
      position: sticky;
      top: 0;
      z-index: 100;
    }
    .book-nav .brand {
      font-family: var(--font-serif);
      font-size: 1.4rem;
      font-weight: 800;
      color: var(--gold);
      text-decoration: none;
    }
    .book-nav .back-link {
      color: rgba(245,240,232,0.6);
      font-size: 0.8rem;
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 6px;
      transition: color 0.2s;
    }
    .book-nav .back-link:hover { color: var(--gold); }

    /* ─── HERO ─── */
    .book-hero {
      background: linear-gradient(135deg, var(--navy) 0%, var(--navy-mid) 100%);
      border-bottom: 1px solid rgba(201,168,76,0.1);
      padding: 3rem 0;
    }
    .book-hero h1 {
      font-family: var(--font-serif);
      font-size: 2.5rem;
      font-weight: 800;
      color: var(--white);
      margin-bottom: 0.3rem;
    }
    .book-hero p { color: var(--text-muted); font-size: 0.9rem; }

    /* ─── LAWYER CARD ─── */
    .lawyer-summary-card {
      background: rgba(255,255,255,0.03);
      border: 1px solid rgba(201,168,76,0.25);
      border-radius: 16px;
      padding: 1.5rem;
      display: flex;
      align-items: center;
      gap: 1.2rem;
      margin-bottom: 2rem;
    }
    .lawyer-summary-card img {
      width: 72px;
      height: 72px;
      border-radius: 50%;
      border: 2px solid rgba(201,168,76,0.4);
      object-fit: cover;
    }
    .lawyer-summary-card .name {
      font-family: var(--font-serif);
      font-size: 1.25rem;
      font-weight: 700;
      color: var(--white);
    }
    .lawyer-summary-card .spec {
      font-size: 0.75rem;
      color: var(--gold);
      text-transform: uppercase;
      font-weight: 700;
      letter-spacing: 0.06em;
    }
    .lawyer-summary-card .meta {
      font-size: 0.8rem;
      color: var(--text-muted);
      margin-top: 4px;
    }

    /* ─── FORM CARD ─── */
    .book-card {
      background: var(--dark-card);
      border: 1px solid rgba(255,255,255,0.06);
      border-radius: 16px;
      padding: 2rem;
      margin-bottom: 1.5rem;
    }
    .book-card-title {
      font-family: var(--font-serif);
      font-size: 1.1rem;
      font-weight: 700;
      color: var(--white);
      margin-bottom: 1.5rem;
      padding-bottom: 0.8rem;
      border-bottom: 1px solid rgba(255,255,255,0.06);
      display: flex;
      align-items: center;
      gap: 0.6rem;
    }
    .book-card-title i { color: var(--gold); }

    .form-label-lux {
      font-size: 0.72rem;
      font-weight: 700;
      text-transform: uppercase;
      color: var(--gold);
      letter-spacing: 0.06em;
      margin-bottom: 6px;
      display: block;
    }
    .form-control-lux {
      background: rgba(255,255,255,0.04);
      border: 1px solid rgba(255,255,255,0.1);
      border-radius: 10px;
      color: var(--white);
      padding: 12px 16px;
      font-family: var(--font-sans);
      font-size: 0.88rem;
      width: 100%;
      transition: border-color 0.2s, background 0.2s;
    }
    .form-control-lux:focus {
      outline: none;
      border-color: rgba(201,168,76,0.5);
      background: rgba(201,168,76,0.04);
      box-shadow: 0 0 0 3px rgba(201,168,76,0.08);
    }
    .form-control-lux::placeholder { color: rgba(245,240,232,0.3); }
    select.form-control-lux option { background: var(--dark-card); color: var(--white); }

    /* Mode buttons */
    .mode-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; }
    .mode-btn {
      background: rgba(255,255,255,0.03);
      border: 1px solid rgba(255,255,255,0.08);
      border-radius: 10px;
      padding: 14px 10px;
      text-align: center;
      cursor: pointer;
      transition: all 0.2s;
      color: var(--text-muted);
    }
    .mode-btn:hover { border-color: rgba(201,168,76,0.3); color: var(--white); }
    .mode-btn.active {
      border-color: var(--gold);
      background: rgba(201,168,76,0.08);
      color: var(--gold);
    }
    .mode-btn i { display: block; font-size: 1.4rem; margin-bottom: 6px; }
    .mode-btn span { font-size: 0.75rem; font-weight: 600; }

    /* Summary sidebar */
    .summary-box {
      background: rgba(201,168,76,0.04);
      border: 1px solid rgba(201,168,76,0.2);
      border-radius: 16px;
      padding: 1.5rem;
      position: sticky;
      top: 80px;
    }
    .summary-box .sum-title {
      font-size: 0.65rem;
      text-transform: uppercase;
      letter-spacing: 0.12em;
      color: var(--text-muted);
      margin-bottom: 1rem;
      font-weight: 700;
    }
    .sum-row {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      gap: 10px;
      padding: 10px 0;
      border-bottom: 1px solid rgba(255,255,255,0.05);
      font-size: 0.82rem;
    }
    .sum-row:last-of-type { border-bottom: none; }
    .sum-row .label { color: var(--text-muted); flex-shrink: 0; }
    .sum-row .value { color: var(--white); font-weight: 600; text-align: right; }
    .sum-fee { font-family: var(--font-serif); font-size: 2rem; font-weight: 800; color: var(--gold); text-align: center; margin: 1rem 0; }

    /* Submit */
    .btn-book {
      background: var(--gold-gradient);
      border: none;
      border-radius: 12px;
      color: var(--dark);
      font-weight: 800;
      font-size: 0.9rem;
      padding: 15px 30px;
      width: 100%;
      cursor: pointer;
      letter-spacing: 0.05em;
      text-transform: uppercase;
      transition: transform 0.2s, box-shadow 0.2s;
      margin-top: 1rem;
    }
    .btn-book:hover { transform: translateY(-2px); box-shadow: 0 8px 28px rgba(201,168,76,0.35); }

    /* Success state */
    .success-screen {
      text-align: center;
      padding: 4rem 2rem;
    }
    .success-icon {
      width: 90px;
      height: 90px;
      border-radius: 50%;
      background: var(--gold-gradient);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 2.5rem;
      color: var(--dark);
      margin: 0 auto 1.5rem;
      animation: popIn 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    @keyframes popIn {
      from { transform: scale(0); opacity: 0; }
      to   { transform: scale(1); opacity: 1; }
    }

    /* Alert */
    .alert-lux {
      background: rgba(255,80,80,0.08);
      border: 1px solid rgba(255,80,80,0.3);
      border-radius: 10px;
      padding: 12px 16px;
      color: #ff9898;
      font-size: 0.85rem;
      margin-bottom: 1.5rem;
    }

    /* Back to top */
    #backToTop {
      position: fixed; bottom: 30px; right: 30px;
      width: 46px; height: 46px;
      background: var(--gold-gradient);
      border: none; border-radius: 10px;
      color: var(--dark); font-size: 1rem;
      cursor: pointer; z-index: 999;
      display: none; align-items: center; justify-content: center;
    }
  </style>
</head>
<body>

<!-- NAV -->
<nav class="book-nav">
  <a href="index.php" class="brand">⚖ LexElite</a>
  <a href="lawyer_profile.php?id=<?php echo $lawyer_id; ?>" class="back-link">
    <i class="fas fa-arrow-left"></i> Back to Profile
  </a>
</nav>

<?php if ($success): ?>
<!-- ═══════════════ SUCCESS SCREEN ═══════════════ -->
<div class="container py-5">
  <div class="success-screen">
    <div class="success-icon"><i class="fas fa-check"></i></div>
    <h2 style="font-family:var(--font-serif); font-size:2rem; font-weight:800; margin-bottom:0.5rem;">Appointment Requested!</h2>
    <p style="color:var(--text-muted); font-size:0.9rem; max-width:480px; margin:0 auto 2rem;">
      Your booking request has been submitted. The attorney's team will confirm your appointment shortly.
    </p>
    <div style="background:rgba(201,168,76,0.06); border:1px solid rgba(201,168,76,0.2); border-radius:12px; padding:1.5rem; max-width:400px; margin:0 auto 2rem;">
      <div class="sum-row"><span class="label">Attorney</span><span class="value"><?php echo htmlspecialchars($lawyer['full_name']); ?></span></div>
      <div class="sum-row"><span class="label">Specialization</span><span class="value"><?php echo htmlspecialchars($lawyer['specialization']); ?></span></div>
      <div class="sum-row"><span class="label">Date</span><span class="value"><?php echo htmlspecialchars($_POST['appt_date']); ?></span></div>
      <div class="sum-row"><span class="label">Time</span><span class="value"><?php echo htmlspecialchars($_POST['appt_time']); ?></span></div>
      <div class="sum-row"><span class="label">Status</span><span class="value" style="color:#4ade80;">⬤ Pending Review</span></div>
    </div>
    <div class="d-flex justify-content-center gap-3 flex-wrap">
      <a href="customer-dashboard.php" class="btn-book" style="width:auto; padding:12px 28px; text-decoration:none; display:inline-block;">
        <i class="fas fa-tachometer-alt me-2"></i>Go to Dashboard
      </a>
      <a href="lawyer_profile.php?id=<?php echo $lawyer_id; ?>" style="text-decoration:none; display:inline-flex; align-items:center; gap:8px; padding:12px 28px; border:1px solid rgba(201,168,76,0.4); border-radius:12px; color:var(--gold); font-size:0.9rem; font-weight:700;">
        <i class="fas fa-user-tie"></i>View Profile
      </a>
    </div>
  </div>
</div>

<?php else: ?>
<!-- ═══════════════ BOOKING FORM ═══════════════ -->
<div class="book-hero">
  <div class="container">
    <p style="font-size:0.75rem; color:var(--text-muted); margin-bottom:0.5rem;">
      <a href="customer-dashboard.php" style="color:var(--text-muted); text-decoration:none;">Dashboard</a>
      <span class="mx-2">›</span>
      <a href="lawyer_profile.php?id=<?php echo $lawyer_id; ?>" style="color:var(--text-muted); text-decoration:none;"><?php echo htmlspecialchars($lawyer['full_name']); ?></a>
      <span class="mx-2">›</span>
      <span style="color:var(--gold);">Book Appointment</span>
    </p>
    <h1>Book Appointment</h1>
    <p>Complete the form below to request a consultation.</p>
  </div>
</div>

<div class="container py-5">
  <form method="POST" action="">
    <input type="hidden" name="consult_mode" id="selectedMode" value="Video">

    <div class="row g-4">

      <!-- LEFT COLUMN: Form -->
      <div class="col-lg-8">

        <!-- Lawyer Preview -->
        <div class="lawyer-summary-card">
          <img src="<?php echo $img; ?>" alt="<?php echo htmlspecialchars($lawyer['full_name']); ?>">
          <div>
            <div class="spec"><?php echo htmlspecialchars($lawyer['specialization']); ?></div>
            <div class="name"><?php echo htmlspecialchars($lawyer['full_name']); ?></div>
            <div class="meta">
              <i class="fas fa-map-marker-alt me-1" style="color:var(--gold);"></i><?php echo htmlspecialchars($lawyer['city']); ?>
              &nbsp;&nbsp;
              <i class="fas fa-briefcase me-1" style="color:var(--gold);"></i><?php echo htmlspecialchars($lawyer['experience']); ?> Yrs Experience
            </div>
          </div>
        </div>

        <?php if ($error): ?>
        <div class="alert-lux"><i class="fas fa-exclamation-circle me-2"></i><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <!-- Date & Time -->
        <div class="book-card">
          <div class="book-card-title"><i class="fas fa-calendar-alt"></i> Date & Time</div>
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label-lux">Appointment Date *</label>
              <input type="date" name="appt_date" id="appt_date" class="form-control-lux"
                     min="<?php echo date('Y-m-d'); ?>"
                     value="<?php echo isset($_POST['appt_date']) ? htmlspecialchars($_POST['appt_date']) : ''; ?>"
                     onchange="updateSummary()" required>
            </div>
            <div class="col-md-6">
              <label class="form-label-lux">Preferred Time *</label>
              <select name="appt_time" id="appt_time" class="form-control-lux" onchange="updateSummary()" required>
                <option value="" disabled selected>Select time slot</option>
                <option value="08:00 AM">08:00 AM</option>
                <option value="09:00 AM">09:00 AM</option>
                <option value="10:00 AM">10:00 AM</option>
                <option value="11:00 AM">11:00 AM</option>
                <option value="12:00 PM">12:00 PM</option>
                <option value="01:00 PM">01:00 PM</option>
                <option value="02:00 PM">02:00 PM</option>
                <option value="03:00 PM">03:00 PM</option>
                <option value="04:00 PM">04:00 PM</option>
                <option value="05:00 PM">05:00 PM</option>
                <option value="06:00 PM">06:00 PM</option>
              </select>
            </div>
          </div>
        </div>

        <!-- Consultation Mode -->
        <div class="book-card">
          <div class="book-card-title"><i class="fas fa-video"></i> Consultation Mode</div>
          <div class="mode-grid">
            <div class="mode-btn active" data-mode="Video" onclick="selectMode(this)">
              <i class="fas fa-video"></i>
              <span>Video Call</span>
            </div>
            <div class="mode-btn" data-mode="Phone" onclick="selectMode(this)">
              <i class="fas fa-phone"></i>
              <span>Phone Call</span>
            </div>
            <div class="mode-btn" data-mode="In-Person" onclick="selectMode(this)">
              <i class="fas fa-building"></i>
              <span>In-Person</span>
            </div>
          </div>
        </div>

        <!-- Case Brief -->
        <div class="book-card">
          <div class="book-card-title"><i class="fas fa-file-alt"></i> Case Brief</div>
          <div class="mb-3">
            <label class="form-label-lux">Describe your legal matter *</label>
            <textarea name="case_brief" id="case_brief" rows="5" class="form-control-lux"
                      placeholder="Briefly describe your legal situation, the type of assistance you need, and any relevant details..."
                      required><?php echo isset($_POST['case_brief']) ? htmlspecialchars($_POST['case_brief']) : ''; ?></textarea>
          </div>
          
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label-lux">Your Full Name</label>
              <input type="text" class="form-control-lux" value="<?php echo htmlspecialchars($customer['full_name']); ?>" readonly>
            </div>
            <div class="col-md-6">
              <label class="form-label-lux">Your Email</label>
              <input type="text" class="form-control-lux" value="<?php echo htmlspecialchars($customer['email']); ?>" readonly>
            </div>
          </div>
        </div>
        

        <!-- Submit -->
        <button type="submit" name="book_now" class="btn-book">
          <i class="fas fa-calendar-check me-2"></i>Confirm Appointment Request
        </button>
        <p style="text-align:center; font-size:0.75rem; color:var(--text-muted); margin-top:0.8rem;">
          <i class="fas fa-shield-alt me-1" style="color:var(--gold);"></i>
          Your booking is secure. The attorney's team will confirm via email.
        </p>

      </div><!-- /col-lg-8 -->

      <!-- RIGHT COLUMN: Summary -->
      <div class="col-lg-4">
        <div class="summary-box">
          <div class="sum-title">Booking Summary</div>

          <div class="sum-fee">PKR <?php echo htmlspecialchars($lawyer['consultation_fee']); ?><span style="font-size:0.9rem; color:var(--text-muted);">/hr</span></div>

          <div class="sum-row">
            <span class="label">Attorney</span>
            <span class="value"><?php echo htmlspecialchars($lawyer['full_name']); ?></span>
          </div>
          <div class="sum-row">
            <span class="label">Practice Area</span>
            <span class="value"><?php echo htmlspecialchars($lawyer['specialization']); ?></span>
          </div>
          <div class="sum-row">
            <span class="label">Location</span>
            <span class="value"><?php echo htmlspecialchars($lawyer['city']); ?></span>
          </div>
          <div class="sum-row">
            <span class="label">Date</span>
            <span class="value" id="sumDate">—</span>
          </div>
          <div class="sum-row">
            <span class="label">Time</span>
            <span class="value" id="sumTime">—</span>
          </div>
          <div class="sum-row">
            <span class="label">Mode</span>
            <span class="value" id="sumMode">Video Call</span>
          </div>
          <div class="sum-row">
            <span class="label">Status</span>
            <span class="value" style="color:#facc15;">⬤ Pending</span>
          </div>

          <div style="margin-top:1.2rem; padding:12px; background:rgba(74,222,128,0.06); border:1px solid rgba(74,222,128,0.2); border-radius:10px; font-size:0.78rem; color:#4ade80; text-align:center;">
            <i class="fas fa-check-circle me-1"></i> Verified & Approved Attorney
          </div>
        </div>
      </div>

    </div><!-- /row -->
  </form>
</div>
<?php endif; ?>

<button id="backToTop" onclick="window.scrollTo({top:0,behavior:'smooth'})">
  <i class="fas fa-arrow-up"></i>
</button>

<script>
function selectMode(el) {
  document.querySelectorAll('.mode-btn').forEach(b => b.classList.remove('active'));
  el.classList.add('active');
  const mode = el.dataset.mode;
  document.getElementById('selectedMode').value = mode;
  document.getElementById('sumMode').textContent = mode === 'In-Person' ? 'In-Person' : mode + ' Call';
}

function updateSummary() {
  const d = document.getElementById('appt_date').value;
  const t = document.getElementById('appt_time').value;
  document.getElementById('sumDate').textContent = d ? new Date(d).toLocaleDateString('en-GB', {day:'numeric', month:'long', year:'numeric'}) : '—';
  document.getElementById('sumTime').textContent = t || '—';
}

window.addEventListener('scroll', () => {
  document.getElementById('backToTop').style.display = window.scrollY > 80 ? 'flex' : 'none';
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
