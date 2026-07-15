<?php
include_once 'includes/connection.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php");
    exit();
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("<div style='background:#111118; color:white; padding:50px; text-align:center; font-family:sans-serif;'><h2>Error: Customer ID not provided.</h2><a href='admin.php' style='color:#C9A84C;'>Return to Dashboard</a></div>");
}

$id = mysqli_real_escape_string($conn, $_GET['id']);
$query = mysqli_query($conn, "SELECT * FROM customers WHERE customer_id='$id'");

if (mysqli_num_rows($query) == 0) {
    die("<div style='background:#111118; color:white; padding:50px; text-align:center; font-family:sans-serif;'><h2>Error: Customer not found.</h2><a href='admin.php' style='color:#C9A84C;'>Return to Dashboard</a></div>");
}

$row = mysqli_fetch_assoc($query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>View Client Profile — LexElite</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --gold: #C9A84C;
            --gold-light: #E8C97B;
            --gold-dark: #A8872E;
            --gold-gradient: linear-gradient(135deg, #C9A84C 0%, #E8C97B 50%, #A8872E 100%);
            --navy: #0D1B3E;
            --navy-light: #142450;
            --black: #0A0A0A;
            --dark: #111118;
            --dark-card: #16161F;
            --white: #FFFFFF;
            --text-muted: #8A8A9A;
            --font-serif: 'Playfair Display', Georgia, serif;
            --font-sans: 'Inter', system-ui, sans-serif;
        }

        body {
            font-family: var(--font-sans);
            background-color: var(--dark);
            color: var(--white);
            min-height: 100vh;
            padding-bottom: 3rem;
        }

        /* Top Bar */
        .top-bar {
            background: rgba(13, 27, 62, 0.9);
            backdrop-filter: blur(15px);
            border-bottom: 1px solid rgba(201, 168, 76, 0.15);
            padding: 15px 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .brand-logo {
            font-family: var(--font-serif);
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--white);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .brand-logo i {
            color: var(--gold);
        }

        .btn-back {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
            border: 1px solid rgba(255,255,255,0.1);
            padding: 8px 16px;
            border-radius: 8px;
        }

        .btn-back:hover {
            color: var(--gold);
            border-color: var(--gold);
            background: rgba(201, 168, 76, 0.1);
        }

        /* Profile Layout */
        .profile-container {
            max-width: 1000px;
            margin: 3rem auto;
            padding: 0 1rem;
        }

        .premium-card {
            background: var(--dark-card);
            border: 1px solid rgba(201, 168, 76, 0.15);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.4), 0 0 20px rgba(201,168,76,0.05);
            overflow: hidden;
            position: relative;
        }

        /* Profile Header */
        .profile-header {
            background: linear-gradient(135deg, var(--navy) 0%, var(--navy-light) 100%);
            padding: 3rem 2rem;
            text-align: center;
            border-bottom: 2px solid rgba(201, 168, 76, 0.2);
            position: relative;
        }

        .profile-image-wrap {
            width: 150px;
            height: 150px;
            margin: 0 auto 1.5rem;
            border-radius: 50%;
            padding: 5px;
            background: var(--gold-gradient);
            box-shadow: 0 10px 25px rgba(0,0,0,0.5);
        }

        .profile-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid var(--navy-light);
        }

        .lawyer-name {
            font-family: var(--font-serif);
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: var(--white);
        }

        .lawyer-spec {
            font-size: 1rem;
            color: var(--gold);
            font-weight: 500;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 1rem;
        }

        /* Info Sections */
        .info-body {
            padding: 3rem 2.5rem;
        }

        .section-title {
            font-family: var(--font-serif);
            font-size: 1.3rem;
            color: var(--gold);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding-bottom: 10px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }

        .info-item {
            background: rgba(255,255,255,0.02);
            border: 1px solid rgba(255,255,255,0.05);
            padding: 1.2rem;
            border-radius: 12px;
            transition: all 0.3s;
        }

        .info-item:hover {
            background: rgba(201, 168, 76, 0.05);
            border-color: rgba(201, 168, 76, 0.2);
            transform: translateY(-2px);
        }

        .info-label {
            font-size: 0.75rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
            display: block;
        }

        .info-value {
            font-size: 1.05rem;
            color: var(--white);
            font-weight: 500;
        }

        .info-value i {
            color: var(--gold);
            margin-right: 8px;
            width: 16px;
            text-align: center;
        }

        /* Action Buttons */
        .action-bar {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(255,255,255,0.1);
        }

        .btn-luxury {
            padding: 12px 28px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.95rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
        }

        .btn-edit {
            background: rgba(201, 168, 76, 0.1);
            color: var(--gold);
            border: 1px solid var(--gold);
        }

        .btn-edit:hover {
            background: var(--gold);
            color: var(--dark);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(201, 168, 76, 0.3);
        }

        .btn-delete {
            background: rgba(220, 53, 69, 0.1);
            color: #ff6b6b;
            border: 1px solid #ff6b6b;
        }

        .btn-delete:hover {
            background: #dc3545;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
        }

    </style>
</head>
<body>

    <!-- Top Navigation -->
    <nav class="top-bar">
        <a href="admin.php" class="brand-logo">
            <i class="fas fa-balance-scale"></i> LexElite
        </a>
        <a href="admin.php" class="btn-back">
            <i class="fas fa-arrow-left"></i> Manage Clients
        </a>
    </nav>

    <div class="profile-container">
        <div class="premium-card">
            
            <!-- Header -->
            <div class="profile-header">
                <div class="profile-image-wrap">
                    <img src="uploads/<?php echo htmlspecialchars($row['profile_image']); ?>" 
                         alt="Client Profile" 
                         class="profile-image"
                         onerror="this.src='https://ui-avatars.com/api/?name=<?php echo urlencode($row['full_name']); ?>&background=0D1B3E&color=C9A84C&size=150'">
                </div>
                <h1 class="lawyer-name"><?php echo htmlspecialchars($row['full_name']); ?></h1>
                <div class="lawyer-spec">
                    <i class="fas fa-user-circle me-2"></i>Registered Client
                </div>
            </div>

            <!-- Body -->
            <div class="info-body">
                
                <!-- Personal Information -->
                <h3 class="section-title"><i class="fas fa-user"></i> Personal Details</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Email Address</span>
                        <div class="info-value"><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($row['email']); ?></div>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Phone Number</span>
                        <div class="info-value"><i class="fas fa-phone"></i> <?php echo htmlspecialchars($row['phone']); ?></div>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Gender</span>
                        <div class="info-value"><i class="fas fa-venus-mars"></i> <?php echo htmlspecialchars($row['gender']); ?></div>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Registration Date</span>
                        <div class="info-value"><i class="fas fa-calendar-alt"></i> <?php echo date('d M, Y', strtotime($row['created_at'])); ?></div>
                    </div>
                    <div class="info-item" style="grid-column: 1 / -1;">
                        <span class="info-label">Address</span>
                        <div class="info-value"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($row['address']); ?></div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="action-bar">
                    <a href="customer_update.php?id=<?php echo $row['customer_id']; ?>" class="btn-luxury btn-edit">
                        <i class="fas fa-edit"></i> Edit Profile
                    </a>
                    <a href="customer_delete.php?id=<?php echo $row['customer_id']; ?>" class="btn-luxury btn-delete" onclick="return confirm('Are you sure you want to permanently delete this client?');">
                        <i class="fas fa-trash"></i> Delete Client
                    </a>
                </div>

            </div>
        </div>
    </div>

    <!-- Bootstrap Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
