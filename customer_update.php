<?php
include_once 'includes/connection.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php");
    exit();
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("<h3>Error: Customer ID missing.</h3><a href='admin.php'>Go Back</a>");
}

$id = mysqli_real_escape_string($conn, $_GET['id']);
$query = mysqli_query($conn, "SELECT * FROM customers WHERE customer_id='$id'");

if (mysqli_num_rows($query) == 0) {
    die("<h3>Error: Customer not found.</h3><a href='admin.php'>Go Back</a>");
}

$row = mysqli_fetch_assoc($query);

// Handle form submission
if (isset($_POST['btn_update'])) {
    $full_name = mysqli_real_escape_string($conn, $_POST['txt_name']);
    $email = mysqli_real_escape_string($conn, $_POST['txt_email']);
    $phone = mysqli_real_escape_string($conn, $_POST['txt_phone']);
    $gender = mysqli_real_escape_string($conn, $_POST['txt_gender']);
    $address = mysqli_real_escape_string($conn, $_POST['txt_address']);
    $password = mysqli_real_escape_string($conn, $_POST['txt_password']);

    // Default query without image update
    $update_sql = "UPDATE customers SET 
                   full_name='$full_name', 
                   email='$email', 
                   phone='$phone', 
                   gender='$gender', 
                   address='$address',
                   password='$password'";

    // Handle image upload if a new file is provided
    if(isset($_FILES['txt_profile_picture']) && $_FILES['txt_profile_picture']['name'] != ""){
        $image_name = $_FILES['txt_profile_picture']['name'];
        $tmp_name = $_FILES['txt_profile_picture']['tmp_name'];
        $profile_image = time().'_'.$image_name;
        
        move_uploaded_file($tmp_name, "uploads/".$profile_image);
        $update_sql .= ", profile_image='$profile_image'";
    }

    $update_sql .= " WHERE customer_id='$id'";

    if (mysqli_query($conn, $update_sql)) {
        echo "<script>alert('Client Details Updated Successfully!'); window.location.href='admin.php';</script>";
    } else {
        echo "<script>alert('Error Updating: " . mysqli_error($conn) . "');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Edit Client Profile — LexElite Legal Management System" />
  <title>Edit Client Profile — LexElite</title>
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
      --text-muted: #8A8A9A;
      --font-serif: 'Playfair Display', Georgia, serif;
      --font-sans: 'Inter', system-ui, sans-serif;
      --transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
      --radius-lg: 24px;
      --shadow-deep: 0 20px 60px rgba(0, 0, 0, 0.4);
      --shadow-gold: 0 0 30px rgba(201, 168, 76, 0.15);
    }

    body {
      font-family: var(--font-sans);
      background: var(--dark);
      color: var(--white);
      min-height: 100vh;
      line-height: 1.7;
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
    }

    /* ---- Top Navigation Bar ---- */
    .top-bar {
      background: rgba(13, 27, 62, 0.7);
      backdrop-filter: blur(20px);
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
    .brand-link { display: inline-flex; align-items: center; gap: 12px; text-decoration: none; }
    .brand-icon { width: 40px; height: 40px; background: var(--gold-gradient); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: var(--dark); font-size: 1.1rem; font-weight: 800; }
    .brand-name { font-family: var(--font-serif); font-size: 1.25rem; font-weight: 700; color: var(--white); }
    .brand-name span { color: var(--gold); }
    .back-btn { display: inline-flex; align-items: center; gap: 8px; color: rgba(255, 255, 255, 0.6); font-size: 0.82rem; font-weight: 600; text-decoration: none; padding: 8px 16px; border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 8px; }
    .back-btn:hover { color: var(--gold); border-color: var(--gold); background: rgba(201, 168, 76, 0.06); }

    /* ---- Page Container ---- */
    .page-wrapper { position: relative; z-index: 1; padding: 2.5rem 1rem 4rem; }

    /* ---- Main Card ---- */
    .edit-card { background: rgba(22, 22, 31, 0.85); backdrop-filter: blur(16px); border: 1px solid rgba(201, 168, 76, 0.15); border-radius: var(--radius-lg); box-shadow: var(--shadow-deep), var(--shadow-gold); max-width: 960px; margin: 0 auto; overflow: hidden; }

    /* ---- Card Header ---- */
    .card-header-premium { background: linear-gradient(135deg, var(--navy) 0%, var(--navy-mid) 50%, var(--navy-light) 100%); padding: 2rem 2.5rem; border-bottom: 1px solid rgba(201, 168, 76, 0.18); position: relative; overflow: hidden; }
    .header-badge { display: inline-flex; align-items: center; gap: 6px; font-size: 0.68rem; font-weight: 700; letter-spacing: 0.18em; text-transform: uppercase; color: var(--gold); background: rgba(201, 168, 76, 0.1); border: 1px solid rgba(201, 168, 76, 0.3); padding: 5px 14px; border-radius: 50px; margin-bottom: 0.8rem; }
    .header-title { font-family: var(--font-serif); font-size: 1.7rem; font-weight: 700; color: var(--white); margin-bottom: 0.3rem; }
    .header-title i { color: var(--gold); margin-right: 10px; font-size: 1.4rem; }
    .header-subtitle { font-size: 0.84rem; color: var(--text-muted); font-weight: 400; margin: 0; }

    /* ---- Card Body ---- */
    .card-body-premium { padding: 2.5rem; }

    /* ---- Profile Image Section ---- */
    .profile-section { text-align: center; margin-bottom: 2.5rem; padding-bottom: 2.5rem; border-bottom: 1px solid rgba(255, 255, 255, 0.06); }
    .profile-avatar-wrapper { position: relative; width: 140px; height: 140px; margin: 0 auto 1.2rem; }
    .profile-avatar { width: 140px; height: 140px; border-radius: 50%; object-fit: cover; border: 3px solid rgba(201, 168, 76, 0.4); box-shadow: 0 0 0 6px rgba(201, 168, 76, 0.08); background: rgba(255, 255, 255, 0.03); }
    .camera-overlay { position: absolute; bottom: 4px; right: 4px; width: 42px; height: 42px; background: var(--gold-gradient); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--dark); cursor: pointer; border: 3px solid var(--dark-card); }
    .profile-upload-btn { display: inline-flex; align-items: center; gap: 8px; background: rgba(201, 168, 76, 0.08); border: 1px dashed rgba(201, 168, 76, 0.35); color: var(--gold); font-size: 0.78rem; font-weight: 600; padding: 10px 24px; border-radius: 50px; cursor: pointer; }
    .file-input-hidden { display: none; }

    /* ---- Section Dividers ---- */
    .section-divider { display: flex; align-items: center; gap: 14px; margin-bottom: 1.8rem; margin-top: 0.5rem; }
    .section-divider-icon { width: 36px; height: 36px; background: rgba(201, 168, 76, 0.1); border: 1px solid rgba(201, 168, 76, 0.25); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: var(--gold); }
    .section-divider-text { font-family: var(--font-serif); font-size: 1rem; font-weight: 700; color: var(--white); }
    .section-divider-line { flex: 1; height: 1px; background: linear-gradient(90deg, rgba(201, 168, 76, 0.25), transparent); }

    /* ---- Form Fields ---- */
    .form-field-luxury { margin-bottom: 1.5rem; }
    .form-field-luxury label { display: flex; align-items: center; gap: 8px; font-size: 0.78rem; font-weight: 600; color: rgba(255, 255, 255, 0.7); text-transform: uppercase; margin-bottom: 8px; }
    .form-field-luxury label i { color: var(--gold); width: 16px; text-align: center; }
    .luxury-input { width: 100%; background: rgba(255, 255, 255, 0.04) !important; border: 1.5px solid rgba(201, 168, 76, 0.18) !important; border-radius: 10px !important; color: var(--white) !important; font-size: 0.9rem; padding: 14px 18px !important; }
    .luxury-input:focus { border-color: var(--gold) !important; box-shadow: 0 0 0 4px rgba(201, 168, 76, 0.1) !important; background: rgba(255, 255, 255, 0.06) !important; outline: none; }
    
    select.luxury-input { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' fill='%23C9A84C'%3E%3Cpath d='M6 8L0 0h12z'/%3E%3C/svg%3E") !important; background-repeat: no-repeat !important; background-position: right 16px center !important; }
    select.luxury-input option { background: var(--dark-card); color: var(--white); }

    /* ---- Update Button ---- */
    .btn-update-profile { display: flex; align-items: center; justify-content: center; gap: 10px; width: 100%; background: var(--gold-gradient); color: var(--dark) !important; font-weight: 700; text-transform: uppercase; padding: 16px 32px; border-radius: 12px; border: none; cursor: pointer; margin-top: 1rem; }
    
  </style>
</head>

<body>

  <div class="page-bg"></div>

  <!-- Top Navigation Bar -->
  <nav class="top-bar">
    <a href="admin.php" class="brand-link">
      <div class="brand-icon"><i class="fas fa-balance-scale"></i></div>
      <div>
        <div class="brand-name">Lex<span>Elite</span></div>
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
          <div class="header-badge"><i class="fas fa-shield-halved"></i> Admin Panel</div>
          <h1 class="header-title"><i class="fas fa-user-edit"></i>Edit Client Profile</h1>
          <p class="header-subtitle">Update customer information and details</p>
        </div>

        <!-- Card Body -->
        <div class="card-body-premium">

          <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="customer_id" value="<?php echo $row['customer_id']; ?>">

            <!-- Profile Image Section -->
            <div class="profile-section">
              <div class="profile-avatar-wrapper">
                <img id="photoPreview" src="uploads/<?php echo $row['profile_image']; ?>" class="profile-avatar" onerror="this.src='https://ui-avatars.com/api/?name=<?php echo urlencode($row['full_name']); ?>&background=0D1B3E&color=C9A84C&size=140&bold=true'">
                <label for="photoInput" class="camera-overlay"><i class="fas fa-camera"></i></label>
              </div>
              <label for="photoInput" class="profile-upload-btn"><i class="fas fa-cloud-arrow-up"></i> Change Profile Picture</label>
              <input type="file" id="photoInput" name="txt_profile_picture" class="file-input-hidden" accept="image/*" onchange="previewImage(this)">
            </div>

            <!-- Personal Information -->
            <div class="section-divider">
              <div class="section-divider-icon"><i class="fas fa-user"></i></div>
              <span class="section-divider-text">Personal Details</span>
              <div class="section-divider-line"></div>
            </div>

            <div class="row g-3 g-lg-4">
              <div class="col-md-6">
                <div class="form-field-luxury">
                  <label><i class="fas fa-user-tie"></i> Full Name</label>
                  <input type="text" name="txt_name" value="<?php echo $row['full_name']; ?>" class="luxury-input form-control" required>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-field-luxury">
                  <label><i class="fas fa-envelope"></i> Email Address</label>
                  <input type="email" name="txt_email" value="<?php echo $row['email']; ?>" class="luxury-input form-control" required>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-field-luxury">
                  <label><i class="fas fa-phone"></i> Phone Number</label>
                  <input type="text" name="txt_phone" value="<?php echo $row['phone']; ?>" class="luxury-input form-control" required>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-field-luxury">
                  <label><i class="fas fa-venus-mars"></i> Gender</label>
                  <select name="txt_gender" class="luxury-input form-control" required>
                    <option value="Male" <?php if($row['gender'] == 'Male') echo 'selected'; ?>>Male</option>
                    <option value="Female" <?php if($row['gender'] == 'Female') echo 'selected'; ?>>Female</option>
                    <option value="Other" <?php if($row['gender'] == 'Other') echo 'selected'; ?>>Other</option>
                  </select>
                </div>
              </div>

              <div class="col-md-12">
                <div class="form-field-luxury">
                  <label><i class="fas fa-map-marker-alt"></i> Address</label>
                  <input type="text" name="txt_address" value="<?php echo $row['address']; ?>" class="luxury-input form-control" required>
                </div>
              </div>

              <div class="col-md-12">
                <div class="form-field-luxury">
                  <label><i class="fas fa-lock"></i> Account Password</label>
                  <input type="text" name="txt_password" value="<?php echo $row['password']; ?>" class="luxury-input form-control" required>
                </div>
              </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" name="btn_update" class="btn-update-profile">
              <i class="fas fa-save"></i> Update Client Profile
            </button>

          </form>

        </div>
      </div>
    </div>
  </div>

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
