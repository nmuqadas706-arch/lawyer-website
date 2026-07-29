<?php
include_once 'includes/connection.php';
include_once 'includes/header.php';

$contact_success = false;
$contact_error = '';

if (isset($_POST['submit_contact'])) {
    $name    = isset($_POST['name']) ? mysqli_real_escape_string($conn, trim($_POST['name'])) : '';
    $email   = isset($_POST['email']) ? mysqli_real_escape_string($conn, trim($_POST['email'])) : '';
    $subject = isset($_POST['subject']) ? mysqli_real_escape_string($conn, trim($_POST['subject'])) : '';
    $message = isset($_POST['message']) ? mysqli_real_escape_string($conn, trim($_POST['message'])) : '';

    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $contact_error = "All fields are required.";
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $contact_error = "Please enter a valid email address.";
    } elseif (strlen(trim($_POST['name'])) < 2) {
        $contact_error = "Full Name must be at least 2 characters.";
    } elseif (strlen(trim($_POST['subject'])) < 3) {
        $contact_error = "Subject must be at least 3 characters.";
    } elseif (strlen(trim($_POST['message'])) < 5) {
        $contact_error = "Message must be at least 5 characters.";
    } else {
        $q = "INSERT INTO contact_messages (name, email, subject, message) VALUES ('$name', '$email', '$subject', '$message')";
        if (mysqli_query($conn, $q)) {
            $contact_success = true;
        } else {
            $contact_error = "Error sending message. Please try again.";
        }
    }
}

// ── Top Rated Attorneys for Hero Card ──
$hero_lawyers_q = mysqli_query($conn, "
    SELECT lawyer_id, full_name, specialization, profile_image
    FROM lawyers
    WHERE status = 'Approved'
    ORDER BY lawyer_id ASC
    LIMIT 3
");
$hero_lawyers = [];
while ($hl = mysqli_fetch_assoc($hero_lawyers_q)) {
    $hero_lawyers[] = $hl;
}
?>

<!-- ===================== HERO SECTION ===================== -->
<section class="hero-section" id="home">
  <div class="hero-bg-pattern"></div>
  <div class="hero-glow"></div>
  <div class="hero-glow-2"></div>

  <div class="container hero-content">
    <div class="row align-items-center gy-5">

      <!-- Left Content -->
      <div class="col-lg-6" data-aos="fade-right" data-aos-duration="900">
        <div class="hero-eyebrow">
          <span></span> Trusted Legal Excellence <span></span>
        </div>

        <h1 class="hero-title">
          Justice is <span class="italic-word">Within</span><br>
          Your <span class="gold-word">Reach</span> Now
        </h1>

        <p class="hero-description">
          Connect with elite, verified attorneys across all practice areas. Get the legal representation you deserve — smart, swift, and supremely professional.
        </p>

        <div class="d-flex flex-wrap gap-3">
          <a href="#search" class="btn-gold">
            <i class="fas fa-search"></i> Find Your Lawyer
          </a>
          <a href="about.php" class="btn-outline-gold">
            <i class="fas fa-play-circle"></i> Our Story
          </a>
        </div>

        <div class="hero-stats">
          <div class="text-center">
            <div class="hero-stat-number" data-target="2400">0</div>
            <div class="hero-stat-label">Expert Lawyers</div>
          </div>
          <div class="text-center">
            <div class="hero-stat-number" data-target="15000">0</div>
            <div class="hero-stat-label">Cases Won</div>
          </div>
          <div class="text-center">
            <div class="hero-stat-number" data-target="98">0</div>
            <div class="hero-stat-label">% Success Rate</div>
          </div>
        </div>
      </div>

      <!-- Right Visual Card -->
      <div class="col-lg-6" data-aos="fade-left" data-aos-duration="900" data-aos-delay="200">
        <div class="hero-visual">
          <div class="hero-card-glass">
            <div class="hero-scales-icon">⚖️</div>
            <h3 class="hero-card-title">Top Rated Attorneys</h3>
            <p class="hero-card-subtitle">Available 24/7 · Verified Credentials</p>

            <div class="hero-lawyer-list">
              <?php
              if (!empty($hero_lawyers)):
                foreach ($hero_lawyers as $hl):
                  $hl_name = htmlspecialchars($hl['full_name']);
                  $hl_spec = htmlspecialchars($hl['specialization']);
                  $hl_initials = strtoupper(substr($hl['full_name'], 0, 1) . (strpos($hl['full_name'], ' ') !== false ? substr($hl['full_name'], strpos($hl['full_name'], ' ') + 1, 1) : ''));
                  if (!empty($hl['profile_image'])):
              ?>
                <div class="hero-lawyer-item">
                  <div class="lawyer-avatar" style="padding:0; overflow:hidden;">
                    <img src="uploads/<?php echo htmlspecialchars($hl['profile_image']); ?>" alt="<?php echo $hl_name; ?>" style="width:100%; height:100%; object-fit:cover; border-radius:50%;">
                  </div>
                  <div>
                    <div class="lawyer-info-name"><?php echo $hl_name; ?></div>
                    <div class="lawyer-info-spec"><?php echo $hl_spec; ?></div>
                  </div>
                  <div class="lawyer-rating">★ 5.0</div>
                </div>
              <?php else: ?>
                <div class="hero-lawyer-item">
                  <div class="lawyer-avatar"><?php echo $hl_initials; ?></div>
                  <div>
                    <div class="lawyer-info-name"><?php echo $hl_name; ?></div>
                    <div class="lawyer-info-spec"><?php echo $hl_spec; ?></div>
                  </div>
                  <div class="lawyer-rating">★ 5.0</div>
                </div>
              <?php
                  endif;
                endforeach;
              endif;
              ?>
            </div>
          </div>

          <!-- Floating Badges -->
          <div class="floating-badge badge-1">
            <i class="fas fa-shield-halved"></i> 100% Verified
          </div>
          <div class="floating-badge badge-2">
            <i class="fas fa-clock"></i> 24/7 Support
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ===================== SEARCH SECTION ===================== -->
<section class="search-section" id="search">
  <div class="container">
    <div class="row justify-content-center mb-4" data-aos="fade-up">
      <div class="col-lg-8 text-center">
        <span class="section-badge">Smart Search</span>
        <h2 class="section-title">Find the <span class="text-gold">Perfect Lawyer</span></h2>
        <p class="section-subtitle mx-auto">Search from thousands of verified attorneys by practice area, location, or name.</p>
      </div>
    </div>

    <div class="row justify-content-center" data-aos="fade-up" data-aos-delay="100">
      <div class="col-lg-10">
        <div class="search-wrapper">
          <div class="search-form-group">
            <select class="search-select form-select" id="practiceArea">
              <option value="" disabled selected>Practice Area</option>
              <option>Criminal Law</option>
              <option>Civil Law</option>
              <option>Divorce Law</option>
              <option>Family Law</option>
              <option>Property Law</option>
              <option>Corporate Law</option>
              <option>Affidavit</option>
            </select>
            <input type="text" class="search-input form-control flex-grow-1" id="locationInput" placeholder="City, State or ZIP Code"/>
            <div class="search-divider d-none d-md-block"></div>
            <input type="text" class="search-input form-control d-none d-md-block" id="nameInput" placeholder="Lawyer Name (optional)"/>
            <button class="search-btn" id="searchBtn" onclick="performSearch()">
              <i class="fas fa-search me-2"></i>Search
            </button>
          </div>

          <div class="search-filters">
            <span style="font-size:0.78rem; color:var(--text-muted); margin-right:4px;">Popular:</span>
            <span class="filter-chip active" onclick="toggleFilter(this)"><i class="fas fa-gavel"></i> Criminal</span>
            <span class="filter-chip" onclick="toggleFilter(this)"><i class="fas fa-heart"></i> Family</span>
            <span class="filter-chip" onclick="toggleFilter(this)"><i class="fas fa-home"></i> Property</span>
            <span class="filter-chip" onclick="toggleFilter(this)"><i class="fas fa-ring"></i> Divorce</span>
            <span class="filter-chip" onclick="toggleFilter(this)"><i class="fas fa-building"></i> Corporate</span>
            <span class="filter-chip" onclick="toggleFilter(this)"><i class="fas fa-file-signature"></i> Affidavit</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ===================== FEATURED LAWYERS ===================== -->
<style>
.flip-card-custom {
    position: relative;
    width: 100%;
    height: 420px;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.5);
    background-color: var(--dark-card);
}
.flip-card-custom img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: top;
    transition: transform 0.6s ease;
}
.flip-card-custom:hover img {
    transform: scale(1.08);
}
.flip-card-overlay {
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: linear-gradient(to top, rgba(13, 27, 42, 1) 0%, rgba(13, 27, 42, 0.9) 30%, rgba(13, 27, 42, 0.2) 100%);
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    padding: 20px;
    transition: all 0.5s ease;
    text-align: center;
}
.flip-card-content {
    opacity: 0;
    visibility: hidden;
    transform: translateY(20px);
    transition: all 0.4s ease;
    max-height: 0;
}
.flip-card-custom:hover .flip-card-content {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
    max-height: 500px; /* enough space */
    margin-top: 15px;
}
.flip-card-custom:hover .flip-card-overlay {
    background: rgba(13, 27, 42, 0.95);
    justify-content: center;
}
.flip-card-name {
    font-family: var(--font-serif);
    font-size: 1.5rem;
    color: var(--gold);
    margin-bottom: 5px;
    transition: all 0.4s ease;
}
.view-details-btn-static {
    opacity: 1;
    visibility: visible;
    transition: all 0.3s ease;
}
.flip-card-custom:hover .view-details-btn-static {
    opacity: 0;
    visibility: hidden;
    height: 0;
    margin: 0 !important;
    padding: 0 !important;
}
</style>
<section class="section-darker" id="lawyers">
  <div class="container">
    <div class="row justify-content-center mb-5" data-aos="fade-up">
      <div class="col-lg-6 text-center">
        <span class="section-badge">Elite Attorneys</span>
        <h2 class="section-title">Featured <span class="text-gold">Lawyers</span></h2>
        <div class="gold-line center"></div>
        <p class="section-subtitle mx-auto">Handpicked top-rated attorneys with proven track records and exceptional client satisfaction.</p>
      </div>
    </div>

    <div class="row g-4" id="featuredLawyersGrid">
      <?php
      $q_featured = mysqli_query($conn, "SELECT * FROM lawyers WHERE status = 'Approved' ORDER BY lawyer_id DESC LIMIT 6");
      if (mysqli_num_rows($q_featured) > 0) {
          $delay = 0;
          while ($row = mysqli_fetch_assoc($q_featured)) {
              $l_id = (int)$row['lawyer_id'];
              $name = htmlspecialchars($row['full_name']);
              $spec = htmlspecialchars($row['specialization'] ?? 'General Practice');
              $city = htmlspecialchars($row['city'] ?? 'Unknown City');
              $exp  = (int)($row['experience'] ?? 0);
              
              $bio_full = trim($row['bio'] ?? 'Experienced legal professional dedicated to achieving the best outcomes.');
              $bio = (strlen($bio_full) > 100) ? htmlspecialchars(substr($bio_full, 0, 97)) . '...' : htmlspecialchars($bio_full);
              
              if (!empty($row['profile_image'])) {
                  $img_url = "uploads/" . htmlspecialchars($row['profile_image']);
                  $img_html = "<div class='lawyer-card-img-placeholder' style=\"background:url('$img_url') center top/cover no-repeat;\"></div>";
              } else {
                  $img_url = "https://ui-avatars.com/api/?name=".urlencode($name)."&background=1A2F60&color=C9A84C&size=200";
                  $img_html = "<div class='lawyer-card-img-placeholder' style=\"background:url('$img_url') center/cover no-repeat;\"></div>";
              }
              
              $rating = 4.8;
              $reviews = rand(50, 300);

              echo "<div class='col-lg-4 col-md-6' data-aos='fade-up' data-aos-delay='$delay'>";
              echo "  <div class='flip-card-custom'>";
              echo "    <img src='$img_url' alt='$name' />";
              
              // Overlay container
              echo "    <div class='flip-card-overlay'>";
              echo "      <h3 class='flip-card-name'>$name</h3>";
              echo "      <div class='flip-card-spec' style='color:var(--white); font-size:0.85rem; text-transform:uppercase; letter-spacing:1px; margin-bottom:10px;'>$spec</div>";
              
              // The "View Details" hint button (visible by default, hides on hover)
              echo "      <div class='view-details-btn-static btn-outline-gold' style='padding:6px 15px; font-size:0.75rem; display:inline-block; margin-top:10px;'>View Details</div>";
              
              // The hidden content that appears on hover
              echo "      <div class='flip-card-content'>";
              echo "        <p class='lawyer-card-bio' style='color:rgba(255,255,255,0.8); font-size:0.85rem; line-height:1.5; margin-bottom:15px;'>$bio</p>";
              
              echo "        <div class='d-flex justify-content-center gap-3 mb-3' style='font-size:0.8rem; color:var(--gold);'>";
              echo "          <span><i class='fas fa-map-marker-alt'></i> $city</span>";
              echo "          <span><i class='fas fa-briefcase'></i> $exp yrs exp</span>";
              echo "        </div>";
              
              echo "        <div class='mb-4'>";
              echo "          <span style='color:#F59E0B; font-size:1.1rem;'>★★★★★</span>";
              echo "          <span style='color:var(--white); font-weight:600; margin-left:5px;'>$rating</span>";
              echo "          <span style='color:var(--text-muted); font-size:0.8rem;'>($reviews)</span>";
              echo "        </div>";
              
              echo "        <div class='d-flex gap-2 w-100'>";
              echo "          <a href='lawyer_profile.php?id=$l_id' class='btn-outline-gold flex-fill d-inline-flex justify-content-center align-items-center' style='padding:10px 0; font-size:0.8rem;'>Profile</a>";
              echo "          <a href='book_appointment.php?id=$l_id' class='btn-gold flex-fill d-inline-flex justify-content-center align-items-center' style='padding:10px 0; font-size:0.8rem;'>Book Slot</a>";
              echo "        </div>";
              echo "      </div>"; // end flip-card-content
              echo "    </div>"; // end flip-card-overlay
              echo "  </div>"; // end flip-card-custom
              echo "</div>";
              
              $delay += 100;
              if($delay > 200) $delay = 0;
          }
      } else {
          echo "<div class='col-12 text-center py-5' style='color:var(--text-muted);'>";
          echo "  <h4>No featured lawyers available.</h4>";
          echo "</div>";
      }
      ?>
    </div>

    <div class="text-center mt-5" data-aos="fade-up">
      <a href="search.php" class="btn-outline-gold">
        <i class="fas fa-th-large"></i> View All Lawyers
      </a>
    </div>
  </div>
</section>

<!-- ===================== POPULAR SERVICES ===================== -->
<section class="section-dark" id="services">
  <div class="container">
    <div class="row justify-content-center mb-5" data-aos="fade-up">
      <div class="col-lg-6 text-center">
        <span class="section-badge">Legal Practice Areas</span>
        <h2 class="section-title">Popular Legal <span class="text-gold">Services</span></h2>
        <div class="gold-line center"></div>
        <p class="section-subtitle mx-auto">Comprehensive legal expertise across all major practice areas, delivered with precision and integrity.</p>
      </div>
    </div>

    <div class="row g-4">
      <?php
      $q_services = mysqli_query($conn, "SELECT * FROM services LIMIT 6");
      if (mysqli_num_rows($q_services) > 0) {
          $delay = 0;
          while ($row = mysqli_fetch_assoc($q_services)) {
              $name = htmlspecialchars($row['service_name']);
              $desc = htmlspecialchars($row['description']);
              $raw_icon = trim($row['icon'] ?? '');
              if (empty($raw_icon)) {
                  $s_lower = strtolower($name);
                  if (strpos($s_lower, 'family') !== false || strpos($s_lower, 'divorce') !== false) $icon = 'fas fa-heart';
                  elseif (strpos($s_lower, 'property') !== false || strpos($s_lower, 'real estate') !== false) $icon = 'fas fa-home';
                  elseif (strpos($s_lower, 'corporate') !== false || strpos($s_lower, 'business') !== false) $icon = 'fas fa-building';
                  elseif (strpos($s_lower, 'criminal') !== false) $icon = 'fas fa-gavel';
                  elseif (strpos($s_lower, 'civil') !== false) $icon = 'fas fa-users';
                  elseif (strpos($s_lower, 'tax') !== false || strpos($s_lower, 'finance') !== false) $icon = 'fas fa-file-invoice-dollar';
                  elseif (strpos($s_lower, 'labor') !== false || strpos($s_lower, 'employment') !== false) $icon = 'fas fa-user-tie';
                  elseif (strpos($s_lower, 'immigration') !== false) $icon = 'fas fa-passport';
                  elseif (strpos($s_lower, 'intellectual') !== false || strpos($s_lower, 'copyright') !== false) $icon = 'fas fa-lightbulb';
                  elseif (strpos($s_lower, 'injury') !== false || strpos($s_lower, 'accident') !== false) $icon = 'fas fa-ambulance';
                  else $icon = 'fas fa-balance-scale';
              } else {
                  if (strpos($raw_icon, 'fas ') === false && strpos($raw_icon, 'fab ') === false && strpos($raw_icon, 'far ') === false) {
                      if (strpos($raw_icon, 'fa-') !== 0) { $raw_icon = 'fa-' . $raw_icon; }
                      $raw_icon = 'fas ' . $raw_icon;
                  }
                  $icon = htmlspecialchars($raw_icon);
              }
              $desc_short = (strlen($desc) > 100) ? substr($desc, 0, 97) . '...' : $desc;
              $search_link = "search.php?spec=" . urlencode($name);

              echo "<div class='col-lg-4 col-md-6' data-aos='fade-up' data-aos-delay='$delay'>";
              echo "  <div class='service-card'>";
              echo "    <div class='service-icon-wrapper'><i class='$icon'></i></div>";
              echo "    <h4 class='service-title'>$name</h4>";
              echo "    <p class='service-desc'>$desc_short</p>";
              echo "    <a href='$search_link' class='service-link'>Explore Lawyers <i class='fas fa-arrow-right'></i></a>";
              echo "  </div>";
              echo "</div>";
              
              $delay += 100;
              if ($delay > 200) $delay = 0;
          }
      } else {
          echo "<div class='col-12 text-center text-white py-5'><h4>No services available.</h4></div>";
      }
      ?>
    </div>

    <div class="text-center mt-5" data-aos="fade-up">
      <a href="services.php" class="btn-gold">
        <i class="fas fa-layer-group"></i> View All Services
      </a>
    </div>
  </div>
</section>

<!-- ===================== WHY CHOOSE US ===================== -->
<section class="section-darker" id="why">
  <div class="container">
    <div class="row align-items-center gy-5">

      <div class="col-lg-5" data-aos="fade-right">
        <span class="section-badge">Our Advantage</span>
        <h2 class="section-title">Why Thousands <span class="text-gold">Trust</span> LexElite</h2>
        <div class="gold-line"></div>
        <p class="section-subtitle mb-4">We combine cutting-edge technology with deep legal expertise to give you unmatched access to justice.</p>
        <a href="about.php" class="btn-gold">
          <i class="fas fa-info-circle"></i> Learn More About Us
        </a>
      </div>

      <div class="col-lg-7" data-aos="fade-left">
        <div class="row g-0">
          <div class="col-12">
            <div class="why-item animate-on-scroll">
              <div class="why-icon"><i class="fas fa-shield-halved"></i></div>
              <div>
                <div class="why-item-title">Verified & Vetted Attorneys</div>
                <div class="why-item-desc">Every lawyer undergoes rigorous background checks, bar verification, and credential validation before joining our platform.</div>
              </div>
            </div>
          </div>
          <div class="col-12">
            <div class="why-item animate-on-scroll delay-1">
              <div class="why-icon"><i class="fas fa-bolt"></i></div>
              <div>
                <div class="why-item-title">Instant Connection</div>
                <div class="why-item-desc">Connect with available attorneys within minutes. No waiting rooms, no unnecessary delays — just immediate expert help.</div>
              </div>
            </div>
          </div>
          <div class="col-12">
            <div class="why-item animate-on-scroll delay-2">
              <div class="why-icon"><i class="fas fa-lock"></i></div>
              <div>
                <div class="why-item-title">Confidential & Secure</div>
                <div class="why-item-desc">All consultations are fully encrypted and protected. Your privacy is our highest priority, always.</div>
              </div>
            </div>
          </div>
          <div class="col-12">
            <div class="why-item animate-on-scroll delay-3">
              <div class="why-icon"><i class="fas fa-star"></i></div>
              <div>
                <div class="why-item-title">Transparent Reviews & Ratings</div>
                <div class="why-item-desc">Real client reviews and verified ratings ensure you always choose the best attorney for your specific needs.</div>
              </div>
            </div>
          </div>
          <div class="col-12">
            <div class="why-item animate-on-scroll delay-4">
              <div class="why-icon"><i class="fas fa-wallet"></i></div>
              <div>
                <div class="why-item-title">Flexible Payment Options</div>
                <div class="why-item-desc">Transparent fees with multiple payment options including flat fees, hourly rates, and payment plans.</div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ===================== HOW IT WORKS ===================== -->
<section class="section-dark" id="how">
  <div class="container">
    <div class="row justify-content-center mb-5" data-aos="fade-up">
      <div class="col-lg-6 text-center">
        <span class="section-badge">Simple Process</span>
        <h2 class="section-title">How It <span class="text-gold">Works</span></h2>
        <div class="gold-line center"></div>
        <p class="section-subtitle mx-auto">Get legal help in four simple steps. From search to resolution, we make it effortless.</p>
      </div>
    </div>

    <div class="row g-5 justify-content-center position-relative">

      <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="0">
        <div class="step-card">
          <div class="step-number">1</div>
          <div class="step-icon"><i class="fas fa-search"></i></div>
          <h4 class="step-title">Search a Lawyer</h4>
          <p class="step-desc">Browse by practice area, location, or name to find the attorney that matches your legal needs.</p>
        </div>
      </div>

      <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="150">
        <div class="step-card">
          <div class="step-number">2</div>
          <div class="step-icon"><i class="fas fa-user-check"></i></div>
          <h4 class="step-title">Review Profiles</h4>
          <p class="step-desc">Compare credentials, reviews, case history and success rates to make the best informed decision.</p>
        </div>
      </div>

      <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
        <div class="step-card">
          <div class="step-number">3</div>
          <div class="step-icon"><i class="fas fa-calendar-check"></i></div>
          <h4 class="step-title">Book Consultation</h4>
          <p class="step-desc">Schedule a free initial consultation online at your preferred time — in-person or virtual.</p>
        </div>
      </div>

      <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="450">
        <div class="step-card">
          <div class="step-number">4</div>
          <div class="step-icon"><i class="fas fa-trophy"></i></div>
          <h4 class="step-title">Win Your Case</h4>
          <p class="step-desc">Your attorney takes it from there — building a powerful case strategy to achieve the best outcome.</p>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ===================== STATISTICS ===================== -->
<section class="stats-section">
  <div class="container position-relative" style="z-index:2;">
    <div class="row justify-content-center mb-4" data-aos="fade-up">
      <div class="col-12 text-center">
        <span class="section-badge">Numbers That Matter</span>
        <h2 class="section-title">Our Impact in <span class="text-gold">Numbers</span></h2>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="0">
        <div class="stat-card">
          <div class="stat-icon"><i class="fas fa-user-tie"></i></div>
          <div class="stat-number" data-target="2400" data-suffix="+">0</div>
          <div class="stat-label">Expert Lawyers</div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="100">
        <div class="stat-card">
          <div class="stat-icon"><i class="fas fa-briefcase"></i></div>
          <div class="stat-number" data-target="15000" data-suffix="+">0</div>
          <div class="stat-label">Cases Resolved</div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="200">
        <div class="stat-card">
          <div class="stat-icon"><i class="fas fa-smile"></i></div>
          <div class="stat-number" data-target="98" data-suffix="%">0</div>
          <div class="stat-label">Client Satisfaction</div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="300">
        <div class="stat-card">
          <div class="stat-icon"><i class="fas fa-globe"></i></div>
          <div class="stat-number" data-target="50" data-suffix="+">0</div>
          <div class="stat-label">States Covered</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ===================== TESTIMONIALS ===================== -->
<section class="section-darker" id="testimonials">
  <div class="container">
    <div class="row justify-content-center mb-5" data-aos="fade-up">
      <div class="col-lg-6 text-center">
        <span class="section-badge">Client Stories</span>
        <h2 class="section-title">What Clients <span class="text-gold">Say</span></h2>
        <div class="gold-line center"></div>
      </div>
    </div>

    <div class="row g-4">
      <?php
      $q_reviews = mysqli_query($conn, "
          SELECT r.review, r.rating, r.created_at, 
                 c.full_name AS customer_name, c.profile_image AS customer_image,
                 l.full_name AS lawyer_name, l.specialization
          FROM reviews r
          JOIN customers c ON r.customer_id = c.customer_id
          JOIN lawyers l ON r.lawyer_id = l.lawyer_id
          ORDER BY r.created_at DESC
          LIMIT 4
      ");

      if ($q_reviews && mysqli_num_rows($q_reviews) > 0) {
          $delay = 0;
          while ($rev = mysqli_fetch_assoc($q_reviews)) {
              $stars = str_repeat('★', (int)$rev['rating']) . str_repeat('☆', 5 - (int)$rev['rating']);
              $review_text = htmlspecialchars($rev['review']);
              $cust_name = htmlspecialchars($rev['customer_name']);
              $lawyer_spec = htmlspecialchars($rev['specialization']);
              
              $initials = strtoupper(substr($cust_name, 0, 2));
              
              echo "<div class='col-lg-6 col-md-6' data-aos='fade-up' data-aos-delay='$delay'>";
              echo "  <div class='testimonial-card'>";
              echo "    <div class='testimonial-stars mb-2'>$stars</div>";
              echo "    <div class='testimonial-quote'>\"</div>";
              echo "    <p class='testimonial-text'>$review_text</p>";
              echo "    <div class='testimonial-author'>";
              if (!empty($rev['customer_image'])) {
                  $img = "uploads/" . htmlspecialchars($rev['customer_image']);
                  echo "      <div class='author-avatar' style='background:url(\"$img\") center/cover;color:transparent;'></div>";
              } else {
                  echo "      <div class='author-avatar' style='background:linear-gradient(135deg,#1A2F60,#0D1B3E);color:var(--gold);'>$initials</div>";
              }
              echo "      <div>";
              echo "        <div class='author-name'>$cust_name</div>";
              echo "        <div class='author-role'>$lawyer_spec Client</div>";
              echo "      </div>";
              echo "    </div>";
              echo "  </div>";
              echo "</div>";
              
              $delay += 100;
          }
      } else {
      ?>
      <!-- Fallback static testimonials if no reviews exist -->
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="0">
        <div class="testimonial-card">
          <div class="testimonial-stars mb-2">★★★★★</div>
          <div class="testimonial-quote">"</div>
          <p class="testimonial-text">LexElite connected me with the perfect criminal defense attorney within hours. Michael fought fearlessly for me and the charges were dismissed. I cannot recommend this platform enough.</p>
          <div class="testimonial-author">
            <div class="author-avatar">AT</div>
            <div>
              <div class="author-name">Alexander Thompson</div>
              <div class="author-role">Criminal Defense Client</div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
        <div class="testimonial-card">
          <div class="testimonial-stars mb-2">★★★★★</div>
          <div class="testimonial-quote">"</div>
          <p class="testimonial-text">Going through a divorce was devastating, but Sarah Reynolds made the process smooth and dignified. She fought for my children's best interests at every step. Worth every penny.</p>
          <div class="testimonial-author">
            <div class="author-avatar" style="background:linear-gradient(135deg,#1A2F60,#0D1B3E);color:var(--gold);">PM</div>
            <div>
              <div class="author-name">Patricia Monroe</div>
              <div class="author-role">Divorce Law Client</div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
        <div class="testimonial-card">
          <div class="testimonial-stars mb-2">★★★★★</div>
          <div class="testimonial-quote">"</div>
          <p class="testimonial-text">James Crawford handled our company's acquisition with extraordinary skill. His attention to detail and strategic thinking saved us millions. LexElite is the only platform we trust.</p>
          <div class="testimonial-author">
            <div class="author-avatar" style="background:linear-gradient(135deg,#A8872E,#C9A84C);color:var(--dark);">RH</div>
            <div>
              <div class="author-name">Richard Hawkins</div>
              <div class="author-role">Corporate Law Client</div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-6 col-md-6" data-aos="fade-up" data-aos-delay="0">
        <div class="testimonial-card">
          <div class="testimonial-stars mb-2">★★★★★</div>
          <div class="testimonial-quote">"</div>
          <p class="testimonial-text">I was in a complex property dispute that seemed hopeless. David Winters not only understood every nuance of my case but delivered a stunning victory in court. LexElite delivered excellence.</p>
          <div class="testimonial-author">
            <div class="author-avatar" style="background:linear-gradient(135deg,#0d2a1a,#051a0d);color:var(--gold);">LM</div>
            <div>
              <div class="author-name">Laura Mitchell</div>
              <div class="author-role">Property Law Client</div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-6 col-md-6" data-aos="fade-up" data-aos-delay="100">
        <div class="testimonial-card">
          <div class="testimonial-stars mb-2">★★★★★</div>
          <div class="testimonial-quote">"</div>
          <p class="testimonial-text">The search experience on LexElite is incredibly intuitive. I found a family law specialist in under two minutes, booked a consultation the same day, and had a resolution in three weeks. Truly remarkable platform.</p>
          <div class="testimonial-author">
            <div class="author-avatar" style="background:linear-gradient(135deg,#2a0d0d,#1a0505);color:var(--gold);">DK</div>
            <div>
              <div class="author-name">Daniel Kim</div>
              <div class="author-role">Family Law Client</div>
            </div>
          </div>
        </div>
      </div>
      <?php } ?>

    </div>
  </div>
</section>

<!-- ===================== FAQ ===================== -->
<section class="section-dark" id="faq">
  <div class="container">
    <div class="row justify-content-center mb-5" data-aos="fade-up">
      <div class="col-lg-6 text-center">
        <span class="section-badge">Common Questions</span>
        <h2 class="section-title">Frequently Asked <span class="text-gold">Questions</span></h2>
        <div class="gold-line center"></div>
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-lg-8" data-aos="fade-up">

        <div class="faq-item active">
          <div class="faq-question" onclick="toggleFaq(this)">
            <span class="faq-q-text">How are lawyers on LexElite verified?</span>
            <div class="faq-toggle"><i class="fas fa-plus"></i></div>
          </div>
          <div class="faq-answer">Every attorney on our platform undergoes a rigorous 3-step verification: bar license validation, background check, and credential review. We partner with state bar associations to ensure every lawyer is in good standing and legally authorized to practice.</div>
        </div>

        <div class="faq-item">
          <div class="faq-question" onclick="toggleFaq(this)">
            <span class="faq-q-text">Is the initial consultation free?</span>
            <div class="faq-toggle"><i class="fas fa-plus"></i></div>
          </div>
          <div class="faq-answer">Many of our attorneys offer a free 30-minute initial consultation. Each attorney's profile clearly indicates whether they offer complimentary consultations. You can filter your search to show only lawyers offering free consultations.</div>
        </div>

        <div class="faq-item">
          <div class="faq-question" onclick="toggleFaq(this)">
            <span class="faq-q-text">Can I communicate with my lawyer securely?</span>
            <div class="faq-toggle"><i class="fas fa-plus"></i></div>
          </div>
          <div class="faq-answer">Absolutely. All communications on LexElite are end-to-end encrypted and fully attorney-client privileged. Your conversations, documents, and case details are completely private and protected under strict confidentiality protocols.</div>
        </div>

        <div class="faq-item">
          <div class="faq-question" onclick="toggleFaq(this)">
            <span class="faq-q-text">What if I'm not satisfied with my attorney?</span>
            <div class="faq-toggle"><i class="fas fa-plus"></i></div>
          </div>
          <div class="faq-answer">We offer a satisfaction guarantee. If you're not happy with your attorney within the first 48 hours, we'll help you find a replacement at no additional cost. Your satisfaction and legal success are our top priorities.</div>
        </div>

        <div class="faq-item">
          <div class="faq-question" onclick="toggleFaq(this)">
            <span class="faq-q-text">How quickly can I get connected to a lawyer?</span>
            <div class="faq-toggle"><i class="fas fa-plus"></i></div>
          </div>
          <div class="faq-answer">In most cases, you can be connected to an available attorney within 15–30 minutes. For urgent legal matters, we have emergency access to lawyers available around the clock, 24 hours a day, 7 days a week.</div>
        </div>

        <div class="faq-item">
          <div class="faq-question" onclick="toggleFaq(this)">
            <span class="faq-q-text">What payment methods are accepted?</span>
            <div class="faq-toggle"><i class="fas fa-plus"></i></div>
          </div>
          <div class="faq-answer">We accept all major credit/debit cards, bank transfers, PayPal, and digital wallets. Many attorneys also offer flexible payment plans, contingency fees for eligible cases, and installment options to make legal help affordable.</div>
        </div>

      </div>
    </div>
  </div>
</section>

<!-- ===================== CTA SECTION ===================== -->
<section class="cta-section" >
  <div class="container">
    <div class="row justify-content-center" data-aos="zoom-in">
      <div class="col-lg-7">
        <span class="section-badge">Get Started Today</span>
        <h2 class="cta-title">Ready for <span style="background:var(--gold-gradient);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">Expert</span> Legal Help?</h2>
        <p class="cta-subtitle">Join over 50,000 clients who found their ideal attorney on LexElite. Justice is just one click away.</p>
        <div class="d-flex flex-wrap justify-content-center gap-3">
          <a href="search.php" class="btn-gold">
            <i class="fas fa-search"></i> Find Your Lawyer
          </a>
          <a href="lawyer-login.php" class="btn-outline-gold">
            <i class="fas fa-user-tie"></i> Join as Attorney
          </a>
        </div>
        <div class="mt-4 d-flex justify-content-center flex-wrap gap-4" style="color:rgba(255,255,255,0.5); font-size:0.78rem; letter-spacing:0.08em;">
          <span><i class="fas fa-check-circle" style="color:var(--gold);"></i> No hidden fees</span>
          <span><i class="fas fa-check-circle" style="color:var(--gold);"></i> Free first consultation</span>
          <span><i class="fas fa-check-circle" style="color:var(--gold);"></i> Satisfaction guarantee</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ===================== CONTACT US ===================== -->
<section class="section-dark" id="contact">
  <div class="container">
    <div class="row justify-content-center mb-5" data-aos="fade-up">
      <div class="col-lg-6 text-center">
        <span class="section-badge">Get In Touch</span>
        <h2 class="section-title">Contact <span class="text-gold">Us</span></h2>
        <div class="gold-line center"></div>
        <p class="section-subtitle mx-auto">Have any questions? We'd love to hear from you. Send us a message and we'll respond as soon as possible.</p>
      </div>
    </div>

    <div class="row justify-content-center" data-aos="fade-up" data-aos-delay="100">
      <div class="col-lg-8">
        <div style="background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.08); border-radius:16px; padding:2.5rem;">
          
          <?php if (isset($contact_success) && $contact_success): ?>
            <div style="background:rgba(74,222,128,0.1); border:1px solid rgba(74,222,128,0.3); border-radius:10px; padding:15px; color:#4ade80; text-align:center; margin-bottom:20px;">
              <i class="fas fa-check-circle me-2"></i> Your message has been sent successfully. We will get back to you soon!
            </div>
          <?php elseif (isset($contact_error) && !empty($contact_error)): ?>
            <div style="background:rgba(220,53,69,0.1); border:1px solid rgba(220,53,69,0.3); border-radius:10px; padding:15px; color:#ff6b6b; text-align:center; margin-bottom:20px;">
              <i class="fas fa-exclamation-triangle me-2"></i> <?php echo $contact_error; ?>
            </div>
          <?php endif; ?>

          <form action="index.php#contact" method="POST" onsubmit="return validateContactForm()">
            <div class="row g-4">
              <div class="col-md-6">
                <label style="font-size:0.75rem; text-transform:uppercase; color:var(--gold); font-weight:700; margin-bottom:8px;">Full Name *</label>
                <input type="text" name="name" id="contact_name" class="form-control" required minlength="2" maxlength="100" placeholder="John Doe" style="background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); color:var(--white); padding:12px; border-radius:10px;">
              </div>
              <div class="col-md-6">
                <label style="font-size:0.75rem; text-transform:uppercase; color:var(--gold); font-weight:700; margin-bottom:8px;">Email Address *</label>
                <input type="email" name="email" id="contact_email" class="form-control" required maxlength="150" placeholder="john@example.com" style="background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); color:var(--white); padding:12px; border-radius:10px;">
              </div>
              <div class="col-12">
                <label style="font-size:0.75rem; text-transform:uppercase; color:var(--gold); font-weight:700; margin-bottom:8px;">Subject *</label>
                <input type="text" name="subject" id="contact_subject" class="form-control" required minlength="3" maxlength="200" placeholder="How can we help?" style="background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); color:var(--white); padding:12px; border-radius:10px;">
              </div>
              <div class="col-12">
                <label style="font-size:0.75rem; text-transform:uppercase; color:var(--gold); font-weight:700; margin-bottom:8px;">Message *</label>
                <textarea name="message" id="contact_message" class="form-control" rows="5" required minlength="5" maxlength="1000" placeholder="Write your message here..." style="background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); color:var(--white); padding:12px; border-radius:10px;"></textarea>
              </div>
              <div class="col-12 text-center mt-4">
                <button type="submit" name="submit_contact" class="btn-gold" style="padding:14px 40px; font-size:1rem; border:none; border-radius:10px; cursor:pointer;">
                  <i class="fas fa-paper-plane me-2"></i> Send Message
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ===================== FOOTER ===================== -->
<footer class="footer" id="footer">
  <div class="container">
    <div class="row g-5">

      <!-- Brand -->
      <div class="col-lg-4 col-md-6">
        <div class="footer-brand">
          <a class="navbar-brand-logo text-decoration-none" href="index.php" style="display:inline-flex;">
            <div class="brand-icon"><i class="fas fa-balance-scale"></i></div>
            <div class="ms-2">
              <span class="brand-text-main">LexElite</span>
              <span class="brand-text-sub">Law & Justice</span>
            </div>
          </a>
        </div>
        <p class="footer-about">LexElite is a premier legal marketplace connecting clients with the nation's most experienced and trusted attorneys across all practice areas.</p>
        <div class="footer-social">
          <a href="#" class="social-btn" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
          <a href="#" class="social-btn" aria-label="Twitter/X"><i class="fab fa-x-twitter"></i></a>
          <a href="#" class="social-btn" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
          <a href="#" class="social-btn" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
          <a href="#" class="social-btn" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
        </div>
      </div>

      <!-- Quick Links -->
      <div class="col-lg-2 col-md-6 col-6">
        <h6 class="footer-heading">Quick Links</h6>
        <ul class="footer-links">
          <li><a href="index.php"><i class="fas fa-chevron-right"></i> Home</a></li>
          <li><a href="about.php"><i class="fas fa-chevron-right"></i> About Us</a></li>
          <li><a href="services.php"><i class="fas fa-chevron-right"></i> Services</a></li>
          <li><a href="search.php"><i class="fas fa-chevron-right"></i> Find Lawyer</a></li>
          <li><a href="#faq"><i class="fas fa-chevron-right"></i> FAQs</a></li>
          <li><a href="#contact"><i class="fas fa-chevron-right"></i> Contact</a></li>
        </ul>
      </div>

      <!-- Practice Areas -->
      <div class="col-lg-2 col-md-6 col-6">
        <h6 class="footer-heading">Practice Areas</h6>
        <ul class="footer-links">
          <li><a href="services.php#criminal"><i class="fas fa-chevron-right"></i> Criminal Law</a></li>
          <li><a href="services.php#civil"><i class="fas fa-chevron-right"></i> Civil Law</a></li>
          <li><a href="services.php#divorce"><i class="fas fa-chevron-right"></i> Divorce Law</a></li>
          <li><a href="services.php#family"><i class="fas fa-chevron-right"></i> Family Law</a></li>
          <li><a href="services.php#property"><i class="fas fa-chevron-right"></i> Property Law</a></li>
          <li><a href="services.php#corporate"><i class="fas fa-chevron-right"></i> Corporate Law</a></li>
        </ul>
      </div>

      <!-- Contact -->
      <div class="col-lg-4 col-md-6">
        <h6 class="footer-heading">Contact Us</h6>
        <div class="footer-contact-item">
          <div class="footer-contact-icon"><i class="fas fa-map-marker-alt"></i></div>
          <div class="footer-contact-text">350 Fifth Avenue, Suite 4100<br>New York, NY 10118, USA</div>
        </div>
        <div class="footer-contact-item">
          <div class="footer-contact-icon"><i class="fas fa-phone"></i></div>
          <div class="footer-contact-text">+1 (800) LEX-ELITE<br>+1 (212) 555-0199</div>
        </div>
        <div class="footer-contact-item">
          <div class="footer-contact-icon"><i class="fas fa-envelope"></i></div>
          <div class="footer-contact-text">contact@lexelite.com<br>legal@lexelite.com</div>
        </div>
        <div class="footer-contact-item">
          <div class="footer-contact-icon"><i class="fas fa-clock"></i></div>
          <div class="footer-contact-text">Mon – Fri: 8am – 10pm EST<br>Emergency: 24/7</div>
        </div>
      </div>

    </div>
  </div>

  <div class="footer-bottom">
    <div class="container d-flex justify-content-between align-items-center flex-wrap gap-2">
      <p class="footer-bottom-text mb-0">© 2024 <a href="index.php">LexElite</a>. All rights reserved. Connecting clients with excellence.</p>
      <div class="d-flex gap-3">
        <a href="#" style="font-size:0.78rem; color:var(--text-muted);">Privacy Policy</a>
        <a href="#" style="font-size:0.78rem; color:var(--text-muted);">Terms of Service</a>
        <a href="#" style="font-size:0.78rem; color:var(--text-muted);">Cookie Policy</a>
      </div>
    </div>
  </div>
</footer>

<!-- Back to Top -->
<button id="backToTop" onclick="scrollToTop()" style="
  position:fixed; bottom:30px; right:30px;
  width:50px; height:50px;
  background:var(--gold-gradient);
  border:none; border-radius:12px;
  color:var(--dark); font-size:1.1rem;
  cursor:pointer; z-index:999;
  box-shadow:0 6px 20px rgba(201,168,76,0.4);
  display:none; align-items:center; justify-content:center;
  transition:all 0.3s ease;
" aria-label="Back to top">
  <i class="fas fa-arrow-up"></i>
</button>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>

  // ----- AOS INIT -----
  AOS.init({ duration: 800, easing: 'ease-out-cubic', once: true, offset: 60 });

  // ----- NAVBAR SCROLL -----
  $(window).on('scroll', function () {
    if ($(this).scrollTop() > 80) {
      $('#mainNavbar').addClass('scrolled');
      $('#backToTop').css('display','flex');
    } else {
      $('#mainNavbar').removeClass('scrolled');
      $('#backToTop').css('display','none');
    }
  });

  // ----- BACK TO TOP -----
  function scrollToTop() {
    $('html, body').animate({ scrollTop: 0 }, 600, 'swing');
  }

  // ----- COUNTER ANIMATION -----
  function animateCounters() {
    $('.stat-number, .hero-stat-number').each(function () {
      const $el = $(this);
      const target = parseInt($el.data('target'));
      const suffix = $el.data('suffix') || '';
      if (!target) return;
      $({ count: 0 }).animate({ count: target }, {
        duration: 2200,
        easing: 'swing',
        step: function () {
          $el.text(Math.floor(this.count).toLocaleString() + suffix);
        },
        complete: function () {
          $el.text(target.toLocaleString() + suffix);
        }
      });
    });
  }

  // Run counters when stats section enters view
  let countersRun = false;
  $(window).on('scroll', function () {
    const statsTop = $('.stats-section').offset()?.top;
    if (!countersRun && statsTop && $(window).scrollTop() + $(window).height() > statsTop) {
      countersRun = true;
      animateCounters();
    }
  });

  // Also run hero counters
  setTimeout(() => {
    $('.hero-stat-number').each(function () {
      const $el = $(this);
      const target = parseInt($el.data('target'));
      if (!target) return;
      $({ count: 0 }).animate({ count: target }, {
        duration: 2000,
        easing: 'swing',
        step: function () { $el.text(Math.floor(this.count).toLocaleString()); },
        complete: function () { $el.text(target.toLocaleString()); }
      });
    });
  }, 600);

  // ----- FAQ TOGGLE -----
  function toggleFaq(el) {
    const item = $(el).closest('.faq-item');
    const isActive = item.hasClass('active');
    $('.faq-item').removeClass('active').find('.faq-answer').slideUp(250);
    if (!isActive) {
      item.addClass('active').find('.faq-answer').slideDown(280);
    }
  }

  // ----- FILTER CHIPS -----
  function toggleFilter(el) {
    $(el).toggleClass('active');
  }

  // ----- SEARCH VALIDATION -----
  function performSearch() {
    const area = $('#practiceArea').val();
    const location = $('#locationInput').val() ? $('#locationInput').val().trim() : '';
    const name = $('#nameInput').val() ? $('#nameInput').val().trim() : '';

    if (!area && !location && !name) {
      alert('Please select a practice area or enter a location or lawyer name.');
      $('#practiceArea').css('border-color','var(--gold)');
      setTimeout(() => $('#practiceArea').css('border-color',''), 1500);
      return false;
    }
    window.location.href = `search.php?area=${encodeURIComponent(area || '')}&loc=${encodeURIComponent(location || '')}&search=${encodeURIComponent(name || '')}`;
  }

  // ----- CONTACT FORM VALIDATION -----
  function validateContactForm() {
    const name = $('#contact_name').val() ? $('#contact_name').val().trim() : '';
    const email = $('#contact_email').val() ? $('#contact_email').val().trim() : '';
    const subject = $('#contact_subject').val() ? $('#contact_subject').val().trim() : '';
    const message = $('#contact_message').val() ? $('#contact_message').val().trim() : '';
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!name || name.length < 2) {
      alert('Please enter your full name (at least 2 characters).');
      $('#contact_name').focus();
      return false;
    }
    if (!email || !emailRegex.test(email)) {
      alert('Please enter a valid email address.');
      $('#contact_email').focus();
      return false;
    }
    if (!subject || subject.length < 3) {
      alert('Please enter a subject (at least 3 characters).');
      $('#contact_subject').focus();
      return false;
    }
    if (!message || message.length < 5) {
      alert('Please enter your message (at least 5 characters).');
      $('#contact_message').focus();
      return false;
    }
    return true;
  }

  $('#searchBtn').on('keypress', function(e) {
    if (e.which === 13) performSearch();
  });

  // ----- SCROLL ANIMATIONS -----
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(e => {
      if (e.isIntersecting) e.target.classList.add('visible');
    });
  }, { threshold: 0.15 });

  document.querySelectorAll('.animate-on-scroll').forEach(el => observer.observe(el));

  // ----- SMOOTH ANCHOR SCROLL -----
  $('a[href^="#"]').on('click', function (e) {
    const target = $(this.getAttribute('href'));
    if (target.length) {
      e.preventDefault();
      $('html, body').animate({ scrollTop: target.offset().top - 80 }, 700);
    }
  });

</script>
</body>
</html>
