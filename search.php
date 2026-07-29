<?php
include_once 'includes/connection.php';
include_once 'includes/header.php';

// 1. Fetch distinct dropdown options
$q_specs = mysqli_query($conn, "SELECT DISTINCT specialization FROM lawyers WHERE status = 'Approved' AND specialization IS NOT NULL");
$specs = [];
while($r = mysqli_fetch_assoc($q_specs)) { if(!empty(trim($r['specialization']))) $specs[] = $r['specialization']; }

$q_cities = mysqli_query($conn, "SELECT DISTINCT city FROM lawyers WHERE status = 'Approved' AND city IS NOT NULL");
$cities = [];
while($r = mysqli_fetch_assoc($q_cities)) { if(!empty(trim($r['city']))) $cities[] = $r['city']; }

$q_stats = mysqli_query($conn, "SELECT MAX(consultation_fee) as max_fee, MAX(experience) as max_exp FROM lawyers WHERE status = 'Approved'");
$stats = mysqli_fetch_assoc($q_stats);
$max_fee_db = !empty($stats['max_fee']) ? (int)$stats['max_fee'] : 10000;
$max_exp_db = !empty($stats['max_exp']) ? (int)$stats['max_exp'] : 30;

// 2. Build PHP Dynamic Search Query
$search_query = "";
$search_param = isset($_GET['search']) ? trim($_GET['search']) : '';
$city_param   = isset($_GET['city']) && !empty($_GET['city']) ? trim($_GET['city']) : (isset($_GET['loc']) ? trim($_GET['loc']) : '');
$spec_param   = isset($_GET['spec']) && !empty($_GET['spec']) ? trim($_GET['spec']) : (isset($_GET['area']) ? trim($_GET['area']) : '');

if (!empty($search_param)) {
    $search_esc = mysqli_real_escape_string($conn, $search_param);
    // Search by Lawyer Name using LIKE for partial match
    $search_query .= " AND full_name LIKE '%$search_esc%'";
}
if (!empty($city_param)) {
    $city_esc = mysqli_real_escape_string($conn, $city_param);
    // Search by City using LIKE
    $search_query .= " AND city LIKE '%$city_esc%'";
}
if (!empty($spec_param)) {
    $spec_esc = mysqli_real_escape_string($conn, $spec_param);
    // Search by Practice Area / Specialization using LIKE
    $search_query .= " AND specialization LIKE '%$spec_esc%'";
}

// 3. Fetch Lawyers
$q_lawyers = mysqli_query($conn, "SELECT * FROM lawyers WHERE status = 'Approved' $search_query");
$lawyers_data = [];
while($row = mysqli_fetch_assoc($q_lawyers)) {
    $img = !empty($row['profile_image']) ? htmlspecialchars($row['profile_image']) : '';
    $lawyers_data[] = [
        'id' => (int)$row['lawyer_id'],
        'name' => htmlspecialchars($row['full_name']),
        'qual' => htmlspecialchars($row['qualification'] ?? 'J.D. Law'),
        'spec' => htmlspecialchars($row['specialization'] ?? 'General Practice'),
        'exp' => (int)($row['experience'] ?? 0),
        'city' => htmlspecialchars($row['city'] ?? 'Unknown City'),
        'fee' => (int)($row['consultation_fee'] ?? 0),
        'bio' => htmlspecialchars($row['bio'] ?? 'Experienced legal professional dedicated to achieving the best outcomes.'),
        'status' => htmlspecialchars($row['status'] ?? 'Approved'),
        'image' => $img,
        // UI Defaults
        'rating' => 4.8,
        'reviews' => rand(20, 250),
        'langs' => ['English'],
        'freeConsult' => true,
        'available' => true,
        'topRated' => true,
        'color1' => '#0D1B3E',
        'color2' => '#1A2F60',
        'tags' => []
    ];
}
?>

<!-- ===================== SEARCH HERO ===================== -->
<section class="search-hero">
  <div class="hero-bg-pattern"></div>
  <div class="container position-relative" style="z-index:2;">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="text-center mb-4" data-aos="fade-down">
          <div class="breadcrumb-nav justify-content-center">
            <a href="index.php">Home</a><span class="sep">/</span>
            <span class="current">Find Lawyers</span>
          </div>
          <span class="section-badge">Smart Search</span>
          <h1 class="page-hero-title">Find Your <span style="background:var(--gold-gradient);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">Perfect Attorney</span></h1>
          <p style="color:rgba(255,255,255,.68);font-size:1rem;max-width:540px;margin:0 auto .5rem;line-height:1.8;">
            Search from 2,400+ verified, top-rated attorneys by name, city, specialization, or experience level.
          </p>
        </div>

        <!-- 4-Field Search Bar (PHP Driven Form) -->
        <form class="quad-search" data-aos="fade-up" data-aos-delay="100" id="mainSearchBar" action="" method="GET" onsubmit="return validateSearchForm()">
          <div class="qs-field">
            <i class="fas fa-search"></i>
            <input type="text" name="search" id="searchName" placeholder="Search by name or keyword…" autocomplete="off" maxlength="100" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"/>
          </div>
          <div class="qs-field">
            <i class="fas fa-map-marker-alt"></i>
            <select name="city" id="searchCity">
              <option value="">All Cities</option>
              <?php foreach($cities as $c): ?>
                <option value="<?php echo htmlspecialchars($c); ?>" <?php if(isset($_GET['city']) && $_GET['city'] === $c) echo 'selected'; ?>><?php echo htmlspecialchars($c); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="qs-field">
            <i class="fas fa-gavel"></i>
            <select name="spec" id="searchSpec">
              <option value="">Specialization</option>
              <?php foreach($specs as $s): ?>
                <option value="<?php echo htmlspecialchars($s); ?>" <?php if(isset($_GET['spec']) && $_GET['spec'] === $s) echo 'selected'; ?>><?php echo htmlspecialchars($s); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="qs-field">
            <i class="fas fa-briefcase"></i>
            <select name="exp" id="searchExp">
              <option value="">Experience Level</option>
              <option value="0-5" <?php if(isset($_GET['exp']) && $_GET['exp'] == '0-5') echo 'selected'; ?>>0–5 Years (Junior)</option>
              <option value="5-10" <?php if(isset($_GET['exp']) && $_GET['exp'] == '5-10') echo 'selected'; ?>>5–10 Years (Mid-Level)</option>
              <option value="10-20" <?php if(isset($_GET['exp']) && $_GET['exp'] == '10-20') echo 'selected'; ?>>10–20 Years (Senior)</option>
              <option value="20+" <?php if(isset($_GET['exp']) && $_GET['exp'] == '20+') echo 'selected'; ?>>20+ Years (Expert)</option>
            </select>
          </div>
          <button type="submit" class="qs-btn" id="searchBtn">
            <i class="fas fa-search"></i> Search
          </button>
        </form>

        <!-- Active search tags -->
        <div id="searchTags" class="mt-3 d-flex flex-wrap gap-2" data-aos="fade-up" data-aos-delay="150"></div>

        <!-- Quick Filters -->
        <div class="mt-3 d-flex flex-wrap gap-2 justify-content-center" data-aos="fade-up" data-aos-delay="200">
          <span style="font-size:.75rem;color:var(--text-muted);align-self:center;">Quick Pick:</span>
          <span class="search-tag" onclick="quickFilter('Criminal Law')"><i class="fas fa-gavel"></i> Criminal</span>
          <span class="search-tag" onclick="quickFilter('Family Law')"><i class="fas fa-heart"></i> Family</span>
          <span class="search-tag" onclick="quickFilter('Divorce Law')"><i class="fas fa-ring"></i> Divorce</span>
          <span class="search-tag" onclick="quickFilter('Corporate Law')"><i class="fas fa-building"></i> Corporate</span>
          <span class="search-tag" onclick="quickFilter('Property Law')"><i class="fas fa-house"></i> Property</span>
          <span class="search-tag" onclick="quickFilter('Immigration Law')"><i class="fas fa-globe"></i> Immigration</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Mobile filter overlay -->
<div class="filter-overlay" id="filterOverlay" onclick="closeDrawer()"></div>
<div class="filter-drawer" id="filterDrawer">
  <button class="drawer-close" onclick="closeDrawer()"><i class="fas fa-times"></i></button>
  <div id="drawerContent"><!-- filled by JS --></div>
</div>

<!-- ===================== MAIN CONTENT ===================== -->
<section style="padding:3rem 0 5rem; background:var(--dark);">
  <div class="container">
    <div class="row g-4">

      <!-- ── LEFT SIDEBAR ── -->
      <div class="col-lg-3 d-none d-lg-block">
        <div class="filter-sidebar">
          <div class="d-flex align-items-center justify-content-between mb-2">
            <span class="filter-heading" style="margin:0;"><i class="fas fa-sliders-h me-2"></i>Filters</span>
            <button onclick="clearAllFilters()" style="background:none;border:none;color:var(--gold);font-size:.72rem;cursor:pointer;font-weight:600;">Clear All</button>
          </div>
          <hr class="filter-divider"/>

          <!-- Rating -->
          <div class="filter-group">
            <div class="filter-label-title"><i class="fas fa-star"></i> Minimum Rating</div>
            <label class="custom-check"><input type="radio" name="fRating" value="0" checked><span class="radio-box"></span><span class="check-label">Any Rating</span></label>
            <label class="custom-check"><input type="radio" name="fRating" value="4"><span class="radio-box"></span><span class="check-label" style="color:#F59E0B;">★ 4.0+ Stars</span></label>
            <label class="custom-check"><input type="radio" name="fRating" value="4.5"><span class="radio-box"></span><span class="check-label" style="color:#F59E0B;">★ 4.5+ Stars</span></label>
            <label class="custom-check"><input type="radio" name="fRating" value="4.8"><span class="radio-box"></span><span class="check-label" style="color:#F59E0B;">★ 4.8+ Stars</span></label>
          </div>
          <hr class="filter-divider"/>

          <!-- Practice Area -->
          <div class="filter-group">
            <div class="filter-label-title"><i class="fas fa-gavel"></i> Practice Area</div>
            <?php foreach($specs as $s): ?>
              <label class="custom-check"><input type="checkbox" class="fArea" value="<?php echo htmlspecialchars($s); ?>"><span class="check-box"></span><span class="check-label"><?php echo htmlspecialchars($s); ?></span></label>
            <?php endforeach; ?>
          </div>
          <hr class="filter-divider"/>

          <!-- Experience -->
          <div class="filter-group">
            <div class="filter-label-title"><i class="fas fa-briefcase"></i> Min. Experience</div>
            <div class="d-flex justify-content-between mb-1">
              <span class="range-display" id="expDisplay">Any</span>
            </div>
            <input type="range" class="luxury-range" id="expRange" min="0" max="<?php echo $max_exp_db; ?>" value="0" step="1" oninput="updateRange(this,'expDisplay','expVal',v=>v==0?'Any':v+' yrs')">
            <input type="hidden" id="expVal" value="0">
            <div class="d-flex justify-content-between mt-1" style="font-size:.7rem;color:var(--text-muted);">
              <span>0 yrs</span><span><?php echo $max_exp_db; ?> yrs</span>
            </div>
          </div>
          <hr class="filter-divider"/>

          <!-- Max Fee -->
          <div class="filter-group">
            <div class="filter-label-title"><i class="fas fa-dollar-sign"></i> Max Consultation Fee</div>
            <div class="d-flex justify-content-between mb-1">
              <span class="range-display" id="feeDisplay">Rs <?php echo $max_fee_db; ?></span>
            </div>
            <input type="range" class="luxury-range" id="feeRange" min="0" max="<?php echo $max_fee_db; ?>" value="<?php echo $max_fee_db; ?>" step="500" oninput="updateRange(this,'feeDisplay','feeVal',v=>'Rs '+v+(v==<?php echo $max_fee_db; ?>?'+':''))">
            <input type="hidden" id="feeVal" value="<?php echo $max_fee_db; ?>">
            <div class="d-flex justify-content-between mt-1" style="font-size:.7rem;color:var(--text-muted);">
              <span>Rs 0</span><span>Rs <?php echo $max_fee_db; ?>+</span>
            </div>
          </div>
          <hr class="filter-divider"/>

          <!-- Language -->
          <div class="filter-group">
            <div class="filter-label-title"><i class="fas fa-language"></i> Language</div>
            <label class="custom-check"><input type="checkbox" class="fLang" value="English"><span class="check-box"></span><span class="check-label">English</span></label>
            <label class="custom-check"><input type="checkbox" class="fLang" value="Spanish"><span class="check-box"></span><span class="check-label">Spanish</span></label>
            <label class="custom-check"><input type="checkbox" class="fLang" value="French"><span class="check-box"></span><span class="check-label">French</span></label>
            <label class="custom-check"><input type="checkbox" class="fLang" value="Mandarin"><span class="check-box"></span><span class="check-label">Mandarin</span></label>
            <label class="custom-check"><input type="checkbox" class="fLang" value="Arabic"><span class="check-box"></span><span class="check-label">Arabic</span></label>
          </div>
          <hr class="filter-divider"/>

          <!-- Free Consultation -->
          <div class="filter-group">
            <div class="filter-label-title"><i class="fas fa-gift"></i> Extras</div>
            <label class="custom-check"><input type="checkbox" id="fFreeConsult"><span class="check-box"></span><span class="check-label">Free Consultation</span></label>
            <label class="custom-check"><input type="checkbox" id="fAvailableNow"><span class="check-box"></span><span class="check-label">Available Today</span></label>
            <label class="custom-check"><input type="checkbox" id="fTopRated"><span class="check-box"></span><span class="check-label">Top Rated Only</span></label>
          </div>

          <button class="btn-gold w-100 mt-2" onclick="applyFilters()" style="justify-content:center;">
            <i class="fas fa-filter"></i> Apply Filters
          </button>
        </div>
      </div>

      <!-- ── RESULTS ── -->
      <div class="col-lg-9">

        <!-- Sort Bar -->
        <div class="sort-bar">
          <span class="results-count" id="resultsCount">Showing <strong id="countNum">12</strong> attorneys</span>
          <div class="d-flex align-items-center gap-3 flex-wrap">
            <div class="d-flex align-items-center gap-2">
              <span style="font-size:.78rem;color:var(--text-muted);">Sort:</span>
              <select class="sort-select-luxury" id="sortSelect" onchange="sortAndRender()">
                <option value="rating">Highest Rated</option>
                <option value="exp-desc">Most Experienced</option>
                <option value="fee-asc">Fee: Low → High</option>
                <option value="fee-desc">Fee: High → Low</option>
                <option value="name">Name: A → Z</option>
              </select>
            </div>
            <div class="view-toggle">
              <button class="view-btn active" id="viewList" onclick="setView('list')" title="List view"><i class="fas fa-list"></i></button>
              <button class="view-btn" id="viewGrid" onclick="setView('grid')" title="Grid view"><i class="fas fa-th-large"></i></button>
            </div>
            <!-- Mobile filter btn -->
            <button class="btn-outline-gold d-lg-none" style="padding:8px 16px;font-size:.78rem;" onclick="openDrawer()">
              <i class="fas fa-sliders-h"></i> Filters
            </button>
          </div>
        </div>

        <!-- Cards Container -->
        <div id="cardsContainer"></div>

        <!-- Pagination -->
        <div class="pagination-wrap" id="paginationWrap"></div>

      </div>
    </div>
  </div>
</section>

<!-- ===================== FOOTER ===================== -->
<footer class="footer">
  <div class="container">
    <div class="row g-5">
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
        <p class="footer-about">LexElite — America's most trusted legal marketplace. Find verified, elite attorneys across all practice areas.</p>
        <div class="footer-social">
          <a href="#" class="social-btn"><i class="fab fa-facebook-f"></i></a>
          <a href="#" class="social-btn"><i class="fab fa-x-twitter"></i></a>
          <a href="#" class="social-btn"><i class="fab fa-linkedin-in"></i></a>
          <a href="#" class="social-btn"><i class="fab fa-instagram"></i></a>
        </div>
      </div>
      <div class="col-lg-2 col-md-6 col-6">
        <h6 class="footer-heading">Quick Links</h6>
        <ul class="footer-links">
          <li><a href="index.php"><i class="fas fa-chevron-right"></i> Home</a></li>
          <li><a href="about.php"><i class="fas fa-chevron-right"></i> About Us</a></li>
          <li><a href="services.php"><i class="fas fa-chevron-right"></i> Services</a></li>
          <li><a href="search.php"><i class="fas fa-chevron-right"></i> Find Lawyer</a></li>
        </ul>
      </div>
      <div class="col-lg-2 col-md-6 col-6">
        <h6 class="footer-heading">Practice Areas</h6>
        <ul class="footer-links">
          <li><a href="services.php#criminal"><i class="fas fa-chevron-right"></i> Criminal</a></li>
          <li><a href="services.php#civil"><i class="fas fa-chevron-right"></i> Civil</a></li>
          <li><a href="services.php#divorce"><i class="fas fa-chevron-right"></i> Divorce</a></li>
          <li><a href="services.php#family"><i class="fas fa-chevron-right"></i> Family</a></li>
          <li><a href="services.php#corporate"><i class="fas fa-chevron-right"></i> Corporate</a></li>
        </ul>
      </div>
      <div class="col-lg-4 col-md-6">
        <h6 class="footer-heading">Contact Us</h6>
        <div class="footer-contact-item">
          <div class="footer-contact-icon"><i class="fas fa-phone"></i></div>
          <div class="footer-contact-text">+1 (800) LEX-ELITE</div>
        </div>
        <div class="footer-contact-item">
          <div class="footer-contact-icon"><i class="fas fa-envelope"></i></div>
          <div class="footer-contact-text">contact@lexelite.com</div>
        </div>
        <div class="footer-contact-item">
          <div class="footer-contact-icon"><i class="fas fa-clock"></i></div>
          <div class="footer-contact-text">24/7 Emergency Access</div>
        </div>
      </div>
    </div>
  </div>
  <div class="footer-bottom">
    <div class="container d-flex justify-content-between align-items-center flex-wrap gap-2">
      <p class="footer-bottom-text mb-0">© 2024 <a href="index.php">LexElite</a>. All rights reserved.</p>
      <div class="d-flex gap-3">
        <a href="#" style="font-size:.78rem;color:var(--text-muted);">Privacy Policy</a>
        <a href="#" style="font-size:.78rem;color:var(--text-muted);">Terms of Service</a>
      </div>
    </div>
  </div>
</footer>

<!-- Back to Top -->
<button id="backToTop" onclick="$('html,body').animate({scrollTop:0},600)" style="position:fixed;bottom:30px;right:30px;width:50px;height:50px;background:var(--gold-gradient);border:none;border-radius:12px;color:var(--dark);font-size:1.1rem;cursor:pointer;z-index:999;box-shadow:0 6px 20px rgba(201,168,76,.4);display:none;align-items:center;justify-content:center;transition:all .3s ease;" aria-label="Back to top">
  <i class="fas fa-arrow-up"></i>
</button>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
AOS.init({ duration: 700, easing: 'ease-out-cubic', once: true, offset: 40 });

// ──────────────── LAWYER DATA ────────────────
const LAWYERS = <?php echo json_encode($lawyers_data); ?>;

// ──────────────── STATE ────────────────
let filtered = [...LAWYERS];
let currentView = 'list';
let currentPage = 1;
const PER_PAGE = 6;

// ──────────────── RENDER ────────────────
function starsHtml(r) {
  let h = '';
  for (let i = 1; i <= 5; i++) {
    if (i <= Math.floor(r)) h += '★';
    else if (i - r < 1 && r % 1 >= 0.5) h += '⯨';
    else h += '☆';
  }
  return h;
}

function renderListCard(l) {
  return `
  <div class="lawyer-search-card mb-3 animate-on-scroll" style="border-radius:14px;">
    <div class="lsc-photo" style="${l.image ? `background:url('${l.image}') center top/cover;` : `background:linear-gradient(135deg,${l.color1},${l.color2});`}">
      ${l.image ? '' : '<i class="fas fa-user-tie"></i>'}
      <div class="verified-badge"><i class="fas fa-check"></i></div>
    </div>
    <div class="lsc-body">
      <div class="lsc-specialty">${l.spec} <span class="badge bg-success ms-2" style="font-size:0.6rem;">${l.status}</span></div>
      <div class="lsc-name">${l.name}</div>
      <div class="lsc-qual"><i class="fas fa-graduation-cap me-1" style="color:var(--gold);font-size:.72rem;"></i>${l.qual}</div>
      <div class="lsc-meta">
        <span class="lsc-meta-item"><i class="fas fa-map-marker-alt"></i>${l.city}</span>
        <span class="lsc-meta-item"><i class="fas fa-briefcase"></i>${l.exp} yrs experience</span>
        <span class="lsc-meta-item"><i class="fas fa-comment-dots"></i>${l.reviews} reviews</span>
        ${l.freeConsult ? '<span class="lsc-meta-item"><i class="fas fa-gift"></i>Free Consultation</span>' : ''}
        ${l.available ? '<span class="lsc-meta-item" style="color:#4ade80;"><i class="fas fa-circle" style="font-size:.5rem;color:#4ade80;"></i>Available Today</span>' : ''}
      </div>
      <div class="lsc-tags">
        ${l.langs.map(lg=>`<span class="lsc-tag"><i class="fas fa-language me-1" style="font-size:.62rem;"></i>${lg}</span>`).join('')}
      </div>
      <div class="mt-2" style="font-size:0.8rem; color:var(--text-muted);">${l.bio}</div>
      <!-- Mobile CTA -->
      <div class="lsc-actions-inline d-lg-none mt-2">
        <a href="lawyer_profile.php?id=${l.id}" class="btn-gold" style="padding:9px 18px;font-size:.75rem;flex:1;justify-content:center;"><i class="fas fa-user"></i> View Profile</a>
        <a href="book_appointment.php?id=${l.id}" class="btn-outline-gold" style="padding:9px 14px;font-size:.75rem;"><i class="fas fa-calendar-check"></i></a>
      </div>
    </div>
    <div class="lsc-right d-none d-lg-flex">
      <div class="lsc-rating-wrap">
        <div class="lsc-rating-num">${l.rating}</div>
        <span class="lsc-stars">${starsHtml(l.rating)}</span>
        <div class="lsc-reviews">${l.reviews} reviews</div>
      </div>
      <div class="lsc-fee-wrap">
        <div class="lsc-fee-label">Consultation</div>
        <div class="lsc-fee">Rs ${l.fee}</div>
      </div>
      <div class="lsc-actions">
        <a href="lawyer_profile.php?id=${l.id}" class="btn-gold" style="padding:10px 16px;font-size:.75rem;justify-content:center;"><i class="fas fa-user"></i> View Profile</a>
        <a href="book_appointment.php?id=${l.id}" class="btn-outline-gold" style="padding:9px 14px;font-size:.75rem;justify-content:center;"><i class="fas fa-calendar-check me-1"></i> Book Appointment</a>
      </div>
    </div>
  </div>`;
}

function renderGridCard(l) {
  let imgUrl = l.image ? l.image : `https://ui-avatars.com/api/?name=${encodeURIComponent(l.name)}&background=1A2F60&color=C9A84C&size=200`;
  let shortBio = l.bio ? (l.bio.length > 80 ? l.bio.substring(0,77)+'...' : l.bio) : 'Experienced legal professional dedicated to achieving the best outcomes.';
  let reviews = Math.floor(Math.random() * (300 - 50 + 1) + 50); // Simulate reviews count if not present

  return `
  <div class="col-md-6 col-lg-4 mb-4">
    <div class="flip-card-custom">
      <img src="${imgUrl}" alt="${l.name}" />
      
      <!-- Overlay container -->
      <div class="flip-card-overlay">
        <h3 class="flip-card-name">${l.name}</h3>
        <div class="flip-card-spec" style="color:var(--white); font-size:0.85rem; text-transform:uppercase; letter-spacing:1px; margin-bottom:10px;">${l.spec}</div>
        
        <!-- The "View Details" hint button (visible by default, hides on hover) -->
        <div class="view-details-btn-static btn-outline-gold" style="padding:6px 15px; font-size:0.75rem; display:inline-block; margin-top:10px;">View Details</div>
        
        <!-- The hidden content that appears on hover -->
        <div class="flip-card-content">
          <p class="lawyer-card-bio" style="color:rgba(255,255,255,0.8); font-size:0.85rem; line-height:1.5; margin-bottom:15px;">${shortBio}</p>
          
          <div class="d-flex justify-content-center gap-3 mb-3" style="font-size:0.8rem; color:var(--gold);">
            <span><i class="fas fa-map-marker-alt"></i> ${l.city}</span>
            <span><i class="fas fa-briefcase"></i> ${l.exp} yrs exp</span>
          </div>
          
          <div class="mb-3">
            <span style="color:#F59E0B; font-size:1.1rem;">★★★★★</span>
            <span style="color:var(--white); font-weight:600; margin-left:5px;">${l.rating}</span>
            <span style="color:var(--text-muted); font-size:0.8rem;">(${reviews} reviews)</span>
          </div>
          
          <div class="mb-3 text-start d-flex justify-content-between align-items-center w-100" style="padding: 0 10px;">
            <span style="font-size:0.7rem; color:var(--text-muted); text-transform:uppercase;">Retainer Fee</span>
            <strong style="color:var(--white);">PKR ${l.fee}</strong>
          </div>

          <div class="d-flex gap-2 w-100">
            <a href="lawyer_profile.php?id=${l.id}" class="btn-outline-gold flex-fill d-inline-flex justify-content-center align-items-center" style="padding:10px 0; font-size:0.8rem;">Profile</a>
            <a href="book_appointment.php?id=${l.id}" class="btn-gold flex-fill d-inline-flex justify-content-center align-items-center" style="padding:10px 0; font-size:0.8rem;">Book Slot</a>
          </div>
        </div>
      </div>
    </div>
  </div>`;
}

function renderPagination(total) {
  const pages = Math.ceil(total / PER_PAGE);
  if (pages <= 1) { $('#paginationWrap').html(''); return; }
  let html = '';
  if (currentPage > 1) html += `<button class="page-num" onclick="goPage(${currentPage-1})"><i class="fas fa-chevron-left"></i></button>`;
  for (let p = 1; p <= pages; p++) {
    if (p === 1 || p === pages || Math.abs(p - currentPage) <= 1) {
      html += `<button class="page-num ${p===currentPage?'active':''}" onclick="goPage(${p})">${p}</button>`;
    } else if (Math.abs(p - currentPage) === 2) {
      html += `<span class="page-num dots">…</span>`;
    }
  }
  if (currentPage < pages) html += `<button class="page-num" onclick="goPage(${currentPage+1})"><i class="fas fa-chevron-right"></i></button>`;
  $('#paginationWrap').html(html);
}

function renderCards() {
  const start = (currentPage - 1) * PER_PAGE;
  const page = filtered.slice(start, start + PER_PAGE);
  $('#countNum').text(filtered.length);
  $('#resultsCount').html(`Showing <strong id="countNum">${filtered.length}</strong> attorney${filtered.length!==1?'s':''}`);

  if (!page.length) {
    $('#cardsContainer').html(`
      <div class="no-results">
        <i class="fas fa-search"></i>
        <h4 style="color:var(--white);margin-bottom:.5rem;">No attorneys found</h4>
        <p>Try adjusting your search or filters to find available attorneys.</p>
        <button class="btn-outline-gold mt-3" onclick="clearAllFilters()" style="margin:0 auto;">
          <i class="fas fa-times me-2"></i>Clear All Filters
        </button>
      </div>`);
    renderPagination(0);
    return;
  }

  if (currentView === 'list') {
    $('#cardsContainer').html(page.map(renderListCard).join(''));
  } else {
    $('#cardsContainer').html(`<div class="row g-3">${page.map(renderGridCard).join('')}</div>`);
  }

  renderPagination(filtered.length);

  // Trigger scroll animations
  setTimeout(() => {
    document.querySelectorAll('.animate-on-scroll').forEach(el => el.classList.add('visible'));
  }, 50);
}

// ──────────────── FILTER / SEARCH ────────────────
function applyFilters() {
  const name   = $('#searchName').val().toLowerCase().trim();
  const city   = $('#searchCity').val().toLowerCase().trim();
  const spec   = $('#searchSpec').val();
  const expRng = $('#searchExp').val();
  const minRat = parseFloat($('input[name=fRating]:checked').val()) || 0;
  const maxFee = parseInt($('#feeVal').val()) || <?php echo $max_fee_db; ?>;
  const minExp = parseInt($('#expVal').val()) || 0;
  const areas  = $('.fArea:checked').map((_,e)=>e.value).get();
  const langs  = $('.fLang:checked').map((_,e)=>e.value).get();
  const fFC    = $('#fFreeConsult').is(':checked');
  const fAv    = $('#fAvailableNow').is(':checked');
  const fTR    = $('#fTopRated').is(':checked');

  filtered = LAWYERS.filter(l => {
    if (name && !l.name.toLowerCase().includes(name)) return false;
    if (city && !l.city.toLowerCase().includes(city)) return false;
    if (spec && l.spec !== spec) return false;
    if (expRng) {
      if (expRng==='0-5'  && !(l.exp>=0  && l.exp<5))  return false;
      if (expRng==='5-10' && !(l.exp>=5  && l.exp<10)) return false;
      if (expRng==='10-20'&& !(l.exp>=10 && l.exp<20)) return false;
      if (expRng==='20+'  && l.exp<20) return false;
    }
    if (l.rating < minRat) return false;
    if (l.fee > maxFee && maxFee < <?php echo $max_fee_db; ?>) return false;
    if (l.exp < minExp) return false;
    if (areas.length && !areas.includes(l.spec)) return false;
    if (langs.length && !langs.some(lg=>l.langs.includes(lg))) return false;
    if (fFC && !l.freeConsult) return false;
    if (fAv && !l.available) return false;
    if (fTR && !l.topRated) return false;
    return true;
  });

  currentPage = 1;
  sortAndRender();
  updateSearchTags();
}

function runSearch() { applyFilters(); }

function validateSearchForm() {
  const search = $('#searchName').val() ? $('#searchName').val().trim() : '';
  const city   = $('#searchCity').val();
  const spec   = $('#searchSpec').val();
  const exp    = $('#searchExp').val();

  if (!search && !city && !spec && !exp) {
    alert('Please enter a keyword or select a filter to search.');
    return false;
  }
  return true;
}

function quickFilter(spec) {
  $('#searchSpec').val(spec);
  applyFilters();
  $('html,body').animate({scrollTop:$('#cardsContainer').offset().top - 100}, 500);
}

function clearAllFilters() {
  $('#searchName,#searchCity').val('');
  $('#searchSpec,#searchExp').val('');
  $('input[name=fRating][value=0]').prop('checked',true);
  $('.fArea,.fLang,#fFreeConsult,#fAvailableNow,#fTopRated').prop('checked',false);
  $('#expRange').val(0); updateRange($('#expRange')[0],'expDisplay','expVal',v=>v==0?'Any':v+' yrs');
  $('#feeRange').val(<?php echo $max_fee_db; ?>); updateRange($('#feeRange')[0],'feeDisplay','feeVal',v=>'Rs '+v+(v==<?php echo $max_fee_db; ?>?'+':''));
  filtered = [...LAWYERS];
  currentPage = 1;
  sortAndRender();
  $('#searchTags').html('');
}

function updateSearchTags() {
  const tags = [];
  const n=$('#searchName').val().trim(), c=$('#searchCity').val().trim(), s=$('#searchSpec').val(), e=$('#searchExp').val();
  if (n) tags.push({label:`Name: ${n}`, clear:()=>$('#searchName').val('')});
  if (c) tags.push({label:`City: ${c}`, clear:()=>$('#searchCity').val('')});
  if (s) tags.push({label:s, clear:()=>$('#searchSpec').val('')});
  if (e) tags.push({label:`Exp: ${e} yrs`, clear:()=>$('#searchExp').val('')});
  const minR=parseFloat($('input[name=fRating]:checked').val());
  if (minR>0) tags.push({label:`★ ${minR}+`, clear:()=>$('input[name=fRating][value=0]').prop('checked',true)});
  $('#searchTags').html(tags.map((t,i)=>`<span class="search-tag" onclick="clearTag(${i})">${t.label} <span class="remove">✕</span></span>`).join(''));
  window._tagClearFns = tags.map(t=>t.clear);
}
function clearTag(i) { window._tagClearFns[i](); applyFilters(); }

// ──────────────── SORT ────────────────
function sortAndRender() {
  const s = $('#sortSelect').val();
  if (s==='rating')    filtered.sort((a,b)=>b.rating-a.rating);
  if (s==='exp-desc')  filtered.sort((a,b)=>b.exp-a.exp);
  if (s==='fee-asc')   filtered.sort((a,b)=>a.fee-b.fee);
  if (s==='fee-desc')  filtered.sort((a,b)=>b.fee-a.fee);
  if (s==='name')      filtered.sort((a,b)=>a.name.localeCompare(b.name));
  renderCards();
}

function goPage(p) {
  currentPage = p;
  renderCards();
  $('html,body').animate({scrollTop:$('.sort-bar').offset().top - 100}, 400);
}

// ──────────────── VIEW TOGGLE ────────────────
function setView(v) {
  currentView = v;
  if (v==='list') { $('#viewList').addClass('active'); $('#viewGrid').removeClass('active'); }
  else            { $('#viewGrid').addClass('active'); $('#viewList').removeClass('active'); }
  renderCards();
}

// ──────────────── RANGE ────────────────
function updateRange(el, displayId, hiddenId, fmt) {
  const v = el.value;
  const pct = ((v - el.min)/(el.max - el.min)*100).toFixed(1);
  el.style.setProperty('--val', pct+'%');
  $('#'+displayId).text(fmt(+v));
  $('#'+hiddenId).val(v);
}

// ──────────────── MOBILE DRAWER ────────────────
function openDrawer() {
  $('#filterOverlay,#filterDrawer').addClass('open');
  $('body').css('overflow','hidden');
}
function closeDrawer() {
  $('#filterOverlay,#filterDrawer').removeClass('open');
  $('body').css('overflow','');
}

// ──────────────── NAVBAR SCROLL ────────────────
$(window).on('scroll', function() {
  $(this).scrollTop()>80 ? $('#backToTop').css('display','flex') : $('#backToTop').css('display','none');
});

// ──────────────── URL PARAMS ────────────────
$(document).ready(function() {
  const params = new URLSearchParams(window.location.search);
  if (params.get('area')) $('#searchSpec').val(params.get('area'));
  if (params.get('loc'))  $('#searchCity').val(params.get('loc'));
  applyFilters();

  // Live search inputs
  let debounce;
  $('#searchName,#searchCity').on('input', function() {
    clearTimeout(debounce);
    debounce = setTimeout(applyFilters, 350);
  });
  $('#searchSpec,#searchExp').on('change', applyFilters);
  $('input[name=fRating],.fArea,.fLang,#fFreeConsult,#fAvailableNow,#fTopRated').on('change', applyFilters);
  $('#expRange,#feeRange').on('input', function() { clearTimeout(debounce); debounce = setTimeout(applyFilters, 200); });
});
</script>
</body>
</html>
