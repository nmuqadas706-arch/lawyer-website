<?php
include_once 'includes/connection.php';
include_once 'includes/header.php';

if(!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<div class='container mt-5 py-5 text-center text-white'><h3>Lawyer ID not provided.</h3><a href='search.php' class='btn-gold mt-3'>Back to Search</a></div>";
    include_once 'includes/footer.php';
    exit;
}

$lawyer_id = mysqli_real_escape_string($conn, $_GET['id']);
$query = mysqli_query($conn, "SELECT * FROM lawyers WHERE lawyer_id='$lawyer_id' AND status='Approved'");
if(mysqli_num_rows($query) == 0) {
    echo "<div class='container mt-5 py-5 text-center text-white'><h3>Lawyer not found or not approved.</h3><a href='search.php' class='btn-gold mt-3'>Back to Search</a></div>";
    include_once 'includes/footer.php';
    exit;
}

$lawyer = mysqli_fetch_assoc($query);
$img = !empty($lawyer['profile_image']) ? "uploads/".$lawyer['profile_image'] : "https://ui-avatars.com/api/?name=".urlencode($lawyer['full_name']);
?>
<!-- ===================== PROFILE HERO ===================== -->
<section class="profile-hero">
  <div class="hero-bg-pattern"></div>
  <div class="hero-glow"></div>
  <div class="container position-relative" style="z-index:2; padding-top:1rem;">

    <!-- Breadcrumb -->
    <div class="breadcrumb-nav mb-3" data-aos="fade-down">
      <a href="index.php">Home</a><span class="sep">/</span>
      <a href="search.php">Find Lawyers</a><span class="sep">/</span>
      <span class="current" id="bcName">Attorney Profile</span>
    </div>

    <!-- Profile Header -->
    <div class="row align-items-end gy-4" data-aos="fade-up">
      <div class="col-lg-8">
        <div class="d-flex gap-4 align-items-start flex-wrap">

          <!-- Photo -->
          <div class="profile-photo-wrapper">
            <div class="profile-photo" id="profilePhoto" style="background-image: url('<?php echo $img; ?>'); background-size: cover; background-position: center;">
            </div>
            <div class="profile-verified-badge" title="Verified Attorney"><i class="fas fa-check"></i></div>
            <div class="profile-online-dot" id="onlineDot" title="Available Today"></div>
          </div>

          <!-- Info -->
          <div class="flex-grow-1" style="min-width:200px;">
            <span class="profile-hero-spec" id="pSpec"><?php echo htmlspecialchars($lawyer['specialization']); ?></span>
            <h1 class="profile-hero-name" id="pName"><?php echo htmlspecialchars($lawyer['full_name']); ?></h1>
            <p class="profile-hero-qual" id="pQual"><?php echo htmlspecialchars($lawyer['qualification']); ?></p>

            <!-- Stars + rating -->
            <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
              <span class="hero-stars" id="pStars">★★★★★</span>
              <span style="font-size:1rem;font-weight:700;color:var(--white);" id="pRating">5.0</span>
              <span style="font-size:.8rem;color:var(--text-muted);" id="pReviews">(120 Reviews)</span>
              <span style="font-size:.75rem;font-weight:600;color:#4ade80;background:rgba(74,222,128,.1);border:1px solid rgba(74,222,128,.25);padding:3px 10px;border-radius:50px;" id="pAvailable"></span>
            </div>

            <div class="profile-hero-meta" id="pMeta">
               <span style="margin-right:15px;"><i class="fas fa-map-marker-alt text-gold me-1"></i> <?php echo htmlspecialchars($lawyer['city']); ?></span>
               <span><i class="fas fa-briefcase text-gold me-1"></i> <?php echo htmlspecialchars($lawyer['experience']); ?> Years Experience</span>
            </div>

            <!-- KPI -->
            <div class="profile-kpi" id="pKpi">
               <div class="kpi-box"><div class="kpi-val">98%</div><div class="kpi-lbl">Success Rate</div></div>
               <div class="kpi-box"><div class="kpi-val">150+</div><div class="kpi-lbl">Cases Won</div></div>
            </div>

            <!-- CTA buttons -->
            <div class="d-flex flex-wrap gap-3">
              <a href="book_appointment.php?id=<?php echo $lawyer['lawyer_id']; ?>" class="btn-gold" style="text-decoration:none;">
                <i class="fas fa-calendar-check"></i> Book Appointment
              </a>
              <button class="btn-outline-gold" id="contactBtn">
                <i class="fas fa-phone"></i> Contact Now
              </button>
              <button class="btn-navy" onclick="shareLawyer()" style="padding:13px 20px;font-size:.78rem;">
                <i class="fas fa-share-alt"></i> Share
              </button>
            </div>
          </div>

        </div>
      </div>

      <!-- Desktop fee preview -->
      <div class="col-lg-4 d-none d-lg-block text-end" data-aos="fade-left" data-aos-delay="200">
        <div style="background:rgba(255,255,255,.04);border:1px solid rgba(201,168,76,.2);border-radius:16px;padding:1.5rem;display:inline-block;min-width:200px;">
          <div style="font-size:.68rem;text-transform:uppercase;letter-spacing:.15em;color:var(--text-muted);margin-bottom:.4rem;">Consultation Fee</div>
          <div style="font-family:var(--font-serif);font-size:2.5rem;font-weight:800;color:var(--gold);line-height:1;" id="pFeeHero">PKR <?php echo htmlspecialchars($lawyer['consultation_fee']); ?></div>
          <div style="font-size:.72rem;color:var(--text-muted);">per hour</div>
          <div style="margin-top:.8rem;" id="pFreeLabel"></div>
        </div>
      </div>
    </div>

    <!-- Tab Strip -->
    <div class="profile-tab-strip mt-4">
      <button class="ptab-link active" data-panel="bio" onclick="switchTab(this)"><i class="fas fa-user-tie"></i> About & Bio</button>
      <button class="ptab-link" data-panel="practice" onclick="switchTab(this)"><i class="fas fa-gavel"></i> Practice Areas</button>
      <button class="ptab-link" data-panel="schedule" onclick="switchTab(this)"><i class="fas fa-calendar-week"></i> Schedule</button>
      <button class="ptab-link" data-panel="reviews" onclick="switchTab(this)"><i class="fas fa-star"></i> Reviews</button>
      <button class="ptab-link" data-panel="details" onclick="switchTab(this)"><i class="fas fa-id-card"></i> Details</button>
    </div>
  </div>
</section>

<!-- ===================== PROFILE CONTENT ===================== -->
<section class="profile-content">
  <div class="container">
    <div class="row g-4">

      <!-- ── LEFT COLUMN ── -->
      <div class="col-lg-8">

        <!-- TAB: BIO -->
        <div class="tab-panel active" id="panel-bio">
          <div class="info-panel" data-aos="fade-up">
            <div class="info-panel-title"><i class="fas fa-quote-left"></i> Biography</div>
            <p class="bio-text" id="pBio"><?php echo nl2br(htmlspecialchars($lawyer['bio'])); ?></p>
          </div>

          <!-- Education + Bar License -->
          <div class="info-panel" data-aos="fade-up">
            <div class="info-panel-title"><i class="fas fa-graduation-cap"></i> Education & Credentials</div>
            <div id="pEdBox">
                <div style="display:flex;gap:15px;margin-bottom:1rem;padding-bottom:1rem;border-bottom:1px solid rgba(255,255,255,0.05);">
                    <div style="width:40px;height:40px;border-radius:8px;background:var(--gold-gradient);display:flex;align-items:center;justify-content:center;flex-shrink:0;color:var(--dark);"><i class="fas fa-university"></i></div>
                    <div>
                        <div style="font-weight:700;color:var(--white);margin-bottom:4px;"><?php echo htmlspecialchars($lawyer['qualification']); ?></div>
                        <div style="font-size:0.85rem;color:var(--text-muted);">Verified Credential</div>
                    </div>
                </div>
            </div>
          </div>

          <!-- Featured Stats -->
          <div class="row g-3 mb-4" data-aos="fade-up">
            <div class="col-6 col-md-3">
              <div style="text-align:center;padding:1.2rem;background:rgba(255,255,255,.02);border:1px solid rgba(255,255,255,.06);border-radius:12px;">
                <div style="font-family:var(--font-serif);font-size:2rem;font-weight:800;color:var(--gold);line-height:1;" id="statWins">150+</div>
                <div style="font-size:.68rem;text-transform:uppercase;letter-spacing:.1em;color:var(--text-muted);margin-top:4px;">Cases Won</div>
              </div>
            </div>
            <div class="col-6 col-md-3">
              <div style="text-align:center;padding:1.2rem;background:rgba(255,255,255,.02);border:1px solid rgba(255,255,255,.06);border-radius:12px;">
                <div style="font-family:var(--font-serif);font-size:2rem;font-weight:800;color:var(--gold);line-height:1;" id="statCases">180+</div>
                <div style="font-size:.68rem;text-transform:uppercase;letter-spacing:.1em;color:var(--text-muted);margin-top:4px;">Total Cases</div>
              </div>
            </div>
            <div class="col-6 col-md-3">
              <div style="text-align:center;padding:1.2rem;background:rgba(255,255,255,.02);border:1px solid rgba(255,255,255,.06);border-radius:12px;">
                <div style="font-family:var(--font-serif);font-size:2rem;font-weight:800;color:var(--gold);line-height:1;" id="statExp"><?php echo htmlspecialchars($lawyer['experience']); ?></div>
                <div style="font-size:.68rem;text-transform:uppercase;letter-spacing:.1em;color:var(--text-muted);margin-top:4px;">Years Exp.</div>
              </div>
            </div>
            <div class="col-6 col-md-3">
              <div style="text-align:center;padding:1.2rem;background:rgba(255,255,255,.02);border:1px solid rgba(255,255,255,.06);border-radius:12px;">
                <div style="font-family:var(--font-serif);font-size:2rem;font-weight:800;color:var(--gold);line-height:1;" id="statRating">5.0</div>
                <div style="font-size:.68rem;text-transform:uppercase;letter-spacing:.1em;color:var(--text-muted);margin-top:4px;">Avg. Rating</div>
              </div>
            </div>
          </div>
        </div>

        <!-- TAB: PRACTICE AREAS -->
        <div class="tab-panel" id="panel-practice">
          <div class="info-panel" data-aos="fade-up">
            <div class="info-panel-title"><i class="fas fa-gavel"></i> Practice Areas</div>
            <div class="practice-pills mb-4" id="pPracticeAreas">
                <span class="practice-pill"><?php echo htmlspecialchars($lawyer['specialization']); ?></span>
            </div>
          </div>
          <div class="info-panel" data-aos="fade-up">
            <div class="info-panel-title"><i class="fas fa-language"></i> Languages Spoken</div>
            <div id="pLangsBox">
                <div style="display:inline-flex;align-items:center;gap:8px;padding:6px 14px;border:1px solid rgba(255,255,255,.1);border-radius:50px;font-size:.85rem;color:var(--white);margin-right:10px;margin-bottom:10px;"><i class="fas fa-globe text-gold"></i> English</div>
                <div style="display:inline-flex;align-items:center;gap:8px;padding:6px 14px;border:1px solid rgba(255,255,255,.1);border-radius:50px;font-size:.85rem;color:var(--white);margin-right:10px;margin-bottom:10px;"><i class="fas fa-globe text-gold"></i> Urdu</div>
            </div>
          </div>
          <div class="info-panel" data-aos="fade-up">
            <div class="info-panel-title"><i class="fas fa-map-marker-alt"></i> Office Address</div>
            <div id="pAddressBox">
                <div style="font-size:0.95rem;color:rgba(255,255,255,0.8);margin-bottom:10px;"><i class="fas fa-building text-gold me-2"></i> <?php echo htmlspecialchars($lawyer['address']); ?>, <?php echo htmlspecialchars($lawyer['city']); ?></div>
            </div>
            <div style="background:rgba(255,255,255,.02);border:1px solid rgba(255,255,255,.05);border-radius:10px;padding:1.5rem;text-align:center;margin-top:1rem;">
              <i class="fas fa-map" style="font-size:2.5rem;color:rgba(201,168,76,.25);display:block;margin-bottom:.8rem;"></i>
              <p style="font-size:.82rem;color:var(--text-muted);margin:0;">Interactive map available after booking confirmation.</p>
            </div>
          </div>
        </div>

        <!-- TAB: SCHEDULE -->
        <div class="tab-panel" id="panel-schedule">
          <div class="info-panel" data-aos="fade-up">
            <div class="info-panel-title"><i class="fas fa-calendar-week"></i> Weekly Availability</div>
            <div class="schedule-grid mb-4" id="scheduleGrid"></div>
            <div class="d-flex flex-wrap gap-3 mt-2">
              <span style="display:flex;align-items:center;gap:6px;font-size:.75rem;color:var(--text-muted);">
                <span style="width:14px;height:14px;border-radius:4px;background:var(--gold-gradient);display:inline-block;"></span> Today
              </span>
              <span style="display:flex;align-items:center;gap:6px;font-size:.75rem;color:var(--text-muted);">
                <span style="width:14px;height:14px;border-radius:4px;background:rgba(201,168,76,.15);border:1px solid rgba(201,168,76,.3);display:inline-block;"></span> Open
              </span>
              <span style="display:flex;align-items:center;gap:6px;font-size:.75rem;color:var(--text-muted);">
                <span style="width:14px;height:14px;border-radius:4px;background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.08);display:inline-block;"></span> Closed
              </span>
            </div>
          </div>
          <div class="info-panel" data-aos="fade-up">
            <div class="info-panel-title"><i class="fas fa-clock"></i> Consultation Modes</div>
            <div class="d-flex flex-wrap gap-3">
              <div style="flex:1;min-width:140px;padding:1rem;background:rgba(201,168,76,.06);border:1px solid rgba(201,168,76,.2);border-radius:10px;text-align:center;">
                <i class="fas fa-video" style="font-size:1.5rem;color:var(--gold);display:block;margin-bottom:.5rem;"></i>
                <div style="font-size:.82rem;font-weight:700;color:var(--white);">Video Call</div>
                <div style="font-size:.72rem;color:var(--text-muted);">Available</div>
              </div>
              <div style="flex:1;min-width:140px;padding:1rem;background:rgba(201,168,76,.06);border:1px solid rgba(201,168,76,.2);border-radius:10px;text-align:center;">
                <i class="fas fa-phone" style="font-size:1.5rem;color:var(--gold);display:block;margin-bottom:.5rem;"></i>
                <div style="font-size:.82rem;font-weight:700;color:var(--white);">Phone Call</div>
                <div style="font-size:.72rem;color:var(--text-muted);">Available</div>
              </div>
              <div id="inPersonMode" style="flex:1;min-width:140px;padding:1rem;background:rgba(201,168,76,.06);border:1px solid rgba(201,168,76,.2);border-radius:10px;text-align:center;">
                <i class="fas fa-building" style="font-size:1.5rem;color:var(--gold);display:block;margin-bottom:.5rem;"></i>
                <div style="font-size:.82rem;font-weight:700;color:var(--white);">In-Person</div>
                <div style="font-size:.72rem;color:var(--text-muted);">At Office</div>
              </div>
            </div>
          </div>
        </div>

        <!-- TAB: REVIEWS -->
        <div class="tab-panel" id="panel-reviews">
          <!-- Rating breakdown -->
          <div class="info-panel" data-aos="fade-up">
            <div class="info-panel-title"><i class="fas fa-chart-bar"></i> Rating Breakdown</div>
            <div class="d-flex align-items-center gap-4 flex-wrap mb-3">
              <div style="text-align:center;min-width:90px;">
                <div style="font-family:var(--font-serif);font-size:4rem;font-weight:900;color:var(--gold);line-height:1;" id="bigRating">—</div>
                <div class="hero-stars" id="bigStars" style="font-size:1.1rem;"></div>
                <div style="font-size:.75rem;color:var(--text-muted);margin-top:3px;" id="bigReviews"></div>
              </div>
              <div style="flex:1;" id="ratingBars"></div>
            </div>
          </div>

          <!-- Review cards -->
          <div id="reviewsList"></div>

          <!-- Write review -->
          <div class="info-panel" data-aos="fade-up">
            <div class="info-panel-title"><i class="fas fa-pen-to-square"></i> Write a Review</div>
            <div style="margin-bottom:1rem;">
              <div style="font-size:.78rem;color:var(--text-muted);margin-bottom:.5rem;">Your Rating</div>
              <div class="star-input" id="starInput">
                <input type="radio" name="rev" id="r5" value="5"><label for="r5"><i class="fas fa-star"></i></label>
                <input type="radio" name="rev" id="r4" value="4"><label for="r4"><i class="fas fa-star"></i></label>
                <input type="radio" name="rev" id="r3" value="3"><label for="r3"><i class="fas fa-star"></i></label>
                <input type="radio" name="rev" id="r2" value="2"><label for="r2"><i class="fas fa-star"></i></label>
                <input type="radio" name="rev" id="r1" value="1"><label for="r1"><i class="fas fa-star"></i></label>
              </div>
            </div>
            <div class="row g-3 mb-3">
              <div class="col-md-6">
                <div class="form-field-luxury">
                  <label>Your Name</label>
                  <input type="text" class="luxury-input form-control" id="revName" placeholder="John Smith">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-field-luxury">
                  <label>Case Type</label>
                  <input type="text" class="luxury-input form-control" id="revCase" placeholder="e.g. Criminal Defense">
                </div>
              </div>
              <div class="col-12">
                <div class="form-field-luxury">
                  <label>Your Review</label>
                  <textarea class="luxury-input form-control" rows="4" id="revText" placeholder="Share your experience with this attorney…" style="resize:vertical;"></textarea>
                </div>
              </div>
            </div>
            <button class="btn-gold" onclick="submitReview()"><i class="fas fa-paper-plane"></i> Submit Review</button>
          </div>
        </div>

        <!-- TAB: DETAILS -->
        <div class="tab-panel" id="panel-details">
          <div class="info-panel" data-aos="fade-up">
            <div class="info-panel-title"><i class="fas fa-id-card"></i> Professional Details</div>
            <div id="detailsBox"></div>
          </div>
          <div class="info-panel" data-aos="fade-up">
            <div class="info-panel-title"><i class="fas fa-certificate"></i> Certifications & Awards</div>
            <div id="awardsBox"></div>
          </div>
        </div>

      </div><!-- /col-lg-8 -->

      <!-- ── RIGHT SIDEBAR ── -->
      <div class="col-lg-4">
        <div class="booking-sidebar" id="bookingAnchor">

          <!-- Booking Card -->
          <div class="booking-card-luxury" data-aos="fade-left">
            <div class="booking-card-header">
              <h5><i class="fas fa-calendar-check me-2" style="color:var(--gold);"></i>Book Consultation</h5>
            </div>
            <div class="booking-card-body">

              <!-- Fee display -->
              <div class="fee-display">
                <div class="fee-amount" id="bookFee">—</div>
                <div class="fee-note">per hour · All fees transparent</div>
              </div>

              <!-- Consultation type -->
              <div style="font-size:.72rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--text-muted);margin-bottom:.6rem;">Consultation Mode</div>
              <div class="consult-types">
                <button class="consult-type-btn active" data-mode="Video" onclick="selectMode(this)">
                  <i class="fas fa-video"></i> Video
                </button>
                <button class="consult-type-btn" data-mode="Phone" onclick="selectMode(this)">
                  <i class="fas fa-phone"></i> Phone
                </button>
                <button class="consult-type-btn" data-mode="In-Person" onclick="selectMode(this)">
                  <i class="fas fa-building"></i> Office
                </button>
              </div>

              <!-- Date selector -->
              <div style="font-size:.72rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--text-muted);margin-bottom:.6rem;">Select Date</div>
              <div class="date-strip" id="dateStrip"></div>

              <!-- Time slots -->
              <div style="font-size:.72rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--text-muted);margin-bottom:.6rem;">Available Times</div>
              <div class="time-grid" id="timeGrid"></div>

              <!-- Summary -->
              <div class="booking-summary-lux">
                <div class="bsum-row"><span class="bsum-label">Attorney</span><span class="bsum-value" id="sumName" style="font-size:.8rem;">—</span></div>
                <div class="bsum-row"><span class="bsum-label">Date</span><span class="bsum-value" id="sumDate">—</span></div>
                <div class="bsum-row"><span class="bsum-label">Time</span><span class="bsum-value" id="sumTime">—</span></div>
                <div class="bsum-row"><span class="bsum-label">Mode</span><span class="bsum-value" id="sumMode">Video</span></div>
                <div class="bsum-row"><span class="bsum-label">Fee</span><span class="bsum-value gold" id="sumFee">—</span></div>
              </div>

              <button class="btn-gold w-100" style="justify-content:center;" id="bookBtn" onclick="openBookingModal()">
                <i class="fas fa-calendar-check"></i> Confirm Appointment
              </button>
              <p style="text-align:center;font-size:.7rem;color:var(--text-muted);margin-top:.8rem;margin-bottom:0;">
                <i class="fas fa-lock me-1"></i>Secure · Confidential · No hidden fees
              </p>
            </div>
          </div>

          <!-- Similar Lawyers -->
          <div class="info-panel mt-3" data-aos="fade-up">
            <div class="info-panel-title" style="margin-bottom:1rem;"><i class="fas fa-users"></i> Similar Attorneys</div>
            <div id="similarBox"></div>
            <a href="search.php" class="btn-outline-gold w-100 mt-2" style="justify-content:center;font-size:.78rem;">
              <i class="fas fa-search me-2"></i>View All Attorneys
            </a>
          </div>

        </div>
      </div><!-- /col-lg-4 -->

    </div>
  </div>
</section>

<!-- ===================== BOOKING MODAL ===================== -->
<div class="modal fade" id="bookingModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content modal-content-luxury">
      <div class="modal-header-luxury">
        <h5 class="modal-title-luxury"><i class="fas fa-calendar-check me-2" style="color:var(--gold);"></i>Confirm Your Appointment</h5>
        <button type="button" style="background:none;border:none;color:var(--text-muted);font-size:1.2rem;cursor:pointer;margin-left:auto;" data-bs-dismiss="modal">
          <i class="fas fa-times"></i>
        </button>
      </div>

      <div class="modal-body-luxury" id="modalBody">
        <!-- Booking details summary -->
        <div class="row g-3 mb-3">
          <div class="col-12">
            <div class="booking-summary-lux">
              <div class="bsum-row"><span class="bsum-label">Attorney</span><span class="bsum-value" id="mSumName">—</span></div>
              <div class="bsum-row"><span class="bsum-label">Specialization</span><span class="bsum-value" id="mSumSpec">—</span></div>
              <div class="bsum-row"><span class="bsum-label">Date & Time</span><span class="bsum-value" id="mSumDateTime">—</span></div>
              <div class="bsum-row"><span class="bsum-label">Mode</span><span class="bsum-value" id="mSumMode">—</span></div>
              <div class="bsum-row"><span class="bsum-label">Consultation Fee</span><span class="bsum-value gold" id="mSumFee">—</span></div>
            </div>
          </div>
        </div>
        <div class="row g-3">
          <div class="col-md-6">
            <div class="form-field-luxury">
              <label>Full Name *</label>
              <input type="text" class="luxury-input form-control" id="mName" placeholder="Your full name">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-field-luxury">
              <label>Email Address *</label>
              <input type="email" class="luxury-input form-control" id="mEmail" placeholder="your@email.com">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-field-luxury">
              <label>Phone Number</label>
              <input type="tel" class="luxury-input form-control" id="mPhone" placeholder="+1 (555) 000-0000">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-field-luxury">
              <label>Case Type</label>
              <input type="text" class="luxury-input form-control" id="mCaseType" placeholder="e.g. Criminal Defense">
            </div>
          </div>
          <div class="col-12">
            <div class="form-field-luxury">
              <label>Brief Description of Your Legal Matter</label>
              <textarea class="luxury-input form-control" rows="3" id="mDesc" placeholder="Describe your legal situation briefly…" style="resize:vertical;"></textarea>
            </div>
          </div>
        </div>
      </div>

      <!-- Success state -->
      <div id="successBody" style="display:none;">
        <div class="booking-success">
          <div class="success-ring"><i class="fas fa-check"></i></div>
          <h3 class="success-heading">Appointment Confirmed!</h3>
          <p class="success-sub">Your consultation has been scheduled. A confirmation will be sent to your email.</p>
          <div class="booking-summary-lux" style="max-width:380px;margin:0 auto;">
            <div class="bsum-row"><span class="bsum-label">Confirmation #</span><span class="conf-num" id="confNum">—</span></div>
            <div class="bsum-row"><span class="bsum-label">Attorney</span><span class="bsum-value" id="succName">—</span></div>
            <div class="bsum-row"><span class="bsum-label">Date & Time</span><span class="bsum-value" id="succDT">—</span></div>
            <div class="bsum-row"><span class="bsum-label">Status</span><span class="bsum-value" style="color:#4ade80;"><i class="fas fa-check-circle me-1"></i>Confirmed</span></div>
          </div>
        </div>
      </div>

      <div class="modal-footer-luxury" id="modalFooter">
        <button class="btn-outline-gold" data-bs-dismiss="modal" style="padding:10px 24px;font-size:.85rem;">Cancel</button>
        <button class="btn-gold" id="confirmBtn" onclick="confirmBooking()">
          <i class="fas fa-check me-2"></i>Confirm Booking
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Toast notification -->
<div id="toastBox" style="position:fixed;bottom:30px;left:50%;transform:translateX(-50%);z-index:9999;display:none;">
  <div style="background:var(--gold-gradient);color:var(--dark);font-weight:700;padding:12px 24px;border-radius:50px;font-size:.85rem;box-shadow:0 8px 24px rgba(201,168,76,.4);">
    <i class="fas fa-check-circle me-2"></i><span id="toastMsg">Done!</span>
  </div>
</div>

<!-- Back to Top -->
<button id="backToTop" onclick="$('html,body').animate({scrollTop:0},600)" style="position:fixed;bottom:30px;right:30px;width:50px;height:50px;background:var(--gold-gradient);border:none;border-radius:12px;color:var(--dark);font-size:1.1rem;cursor:pointer;z-index:999;box-shadow:0 6px 20px rgba(201,168,76,.4);display:none;align-items:center;justify-content:center;">
  <i class="fas fa-arrow-up"></i>
</button>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
AOS.init({ duration: 700, easing: 'ease-out-cubic', once: true, offset: 40 });

// ──────────────── TABS ────────────────
function switchTab(btn) {
  const panel = $(btn).data('panel');
  $('.ptab-link').removeClass('active');
  $(btn).addClass('active');
  $('.tab-panel').removeClass('active');
  $(`#panel-${panel}`).addClass('active');
}

// ──────────────── UTILS ────────────────
function scrollToBooking() {
  window.location.href = "book_appointment.php?id=<?php echo $lawyer_id; ?>";
}

function switchTab(btn) {
  const panel = $(btn).data('panel');
  $('.ptab-link').removeClass('active');
  $(btn).addClass('active');
  $('.tab-panel').removeClass('active');
  $(`#panel-${panel}`).addClass('active');
}

// ──────────────── UTILS ────────────────
function scrollToBooking() {
  $('html,body').animate({scrollTop:$('#bookingAnchor').offset().top - 100}, 600);
}

function showToast(msg) {
  $('#toastMsg').text(msg);
  $('#toastBox').fadeIn(300);
  setTimeout(()=>$('#toastBox').fadeOut(400), 3000);
}

function submitReview() {
  const name = $('#revName').val().trim();
  const text = $('#revText').val().trim();
  const star = $('input[name=rev]:checked').val();
  if (!name || !text) { showToast('Please fill in your name and review.'); return; }
  showToast('Review submitted! Thank you for your feedback.');
  $('#revName,#revText').val('');
  $('input[name=rev]').prop('checked',false);
}

function shareLawyer() {
  if (navigator.share) { navigator.share({ title: lawyer.name, url: window.location.href }); }
  else { navigator.clipboard.writeText(window.location.href); showToast('Profile link copied to clipboard!'); }
}

$(window).on('scroll', function() {
  $(this).scrollTop()>80 ? $('#backToTop').css('display','flex') : $('#backToTop').css('display','none');
});

$(document).ready(function() {
  AOS.refresh();
});
</script>
</body>
</html>
