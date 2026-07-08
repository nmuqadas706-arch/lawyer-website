 <?php
include_once 'includes/connection.php';
include_once 'includes/header.php';



?>
<!-- ===================== PROFILE HERO ===================== -->
<section class="profile-hero">
  <div class="hero-bg-pattern"></div>
  <div class="hero-glow"></div>
  <div class="container position-relative" style="z-index:2; padding-top:1rem;">

    <!-- Breadcrumb -->
    <div class="breadcrumb-nav mb-3" data-aos="fade-down">
      <a href="index.html">Home</a><span class="sep">/</span>
      <a href="search.html">Find Lawyers</a><span class="sep">/</span>
      <span class="current" id="bcName">Attorney Profile</span>
    </div>

    <!-- Profile Header -->
    <div class="row align-items-end gy-4" data-aos="fade-up">
      <div class="col-lg-8">
        <div class="d-flex gap-4 align-items-start flex-wrap">

          <!-- Photo -->
          <div class="profile-photo-wrapper">
            <div class="profile-photo" id="profilePhoto">
              <i class="fas fa-user-tie" id="profileIcon"></i>
            </div>
            <div class="profile-verified-badge" title="Verified Attorney"><i class="fas fa-check"></i></div>
            <div class="profile-online-dot" id="onlineDot" title="Available Today"></div>
          </div>

          <!-- Info -->
          <div class="flex-grow-1" style="min-width:200px;">
            <span class="profile-hero-spec" id="pSpec">—</span>
            <h1 class="profile-hero-name" id="pName">Loading…</h1>
            <p class="profile-hero-qual" id="pQual"></p>

            <!-- Stars + rating -->
            <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
              <span class="hero-stars" id="pStars">★★★★★</span>
              <span style="font-size:1rem;font-weight:700;color:var(--white);" id="pRating">—</span>
              <span style="font-size:.8rem;color:var(--text-muted);" id="pReviews"></span>
              <span style="font-size:.75rem;font-weight:600;color:#4ade80;background:rgba(74,222,128,.1);border:1px solid rgba(74,222,128,.25);padding:3px 10px;border-radius:50px;" id="pAvailable"></span>
            </div>

            <div class="profile-hero-meta" id="pMeta"></div>

            <!-- KPI -->
            <div class="profile-kpi" id="pKpi"></div>

            <!-- CTA buttons -->
            <div class="d-flex flex-wrap gap-3">
              <button class="btn-gold" onclick="scrollToBooking()">
                <i class="fas fa-calendar-check"></i> Book Appointment
              </button>
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
          <div style="font-family:var(--font-serif);font-size:2.5rem;font-weight:800;color:var(--gold);line-height:1;" id="pFeeHero">—</div>
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
            <p class="bio-text" id="pBio"></p>
          </div>

          <!-- Education + Bar License -->
          <div class="info-panel" data-aos="fade-up">
            <div class="info-panel-title"><i class="fas fa-graduation-cap"></i> Education & Credentials</div>
            <div id="pEdBox"></div>
          </div>

          <!-- Featured Stats -->
          <div class="row g-3 mb-4" data-aos="fade-up">
            <div class="col-6 col-md-3">
              <div style="text-align:center;padding:1.2rem;background:rgba(255,255,255,.02);border:1px solid rgba(255,255,255,.06);border-radius:12px;">
                <div style="font-family:var(--font-serif);font-size:2rem;font-weight:800;color:var(--gold);line-height:1;" id="statWins">—</div>
                <div style="font-size:.68rem;text-transform:uppercase;letter-spacing:.1em;color:var(--text-muted);margin-top:4px;">Cases Won</div>
              </div>
            </div>
            <div class="col-6 col-md-3">
              <div style="text-align:center;padding:1.2rem;background:rgba(255,255,255,.02);border:1px solid rgba(255,255,255,.06);border-radius:12px;">
                <div style="font-family:var(--font-serif);font-size:2rem;font-weight:800;color:var(--gold);line-height:1;" id="statCases">—</div>
                <div style="font-size:.68rem;text-transform:uppercase;letter-spacing:.1em;color:var(--text-muted);margin-top:4px;">Total Cases</div>
              </div>
            </div>
            <div class="col-6 col-md-3">
              <div style="text-align:center;padding:1.2rem;background:rgba(255,255,255,.02);border:1px solid rgba(255,255,255,.06);border-radius:12px;">
                <div style="font-family:var(--font-serif);font-size:2rem;font-weight:800;color:var(--gold);line-height:1;" id="statExp">—</div>
                <div style="font-size:.68rem;text-transform:uppercase;letter-spacing:.1em;color:var(--text-muted);margin-top:4px;">Years Exp.</div>
              </div>
            </div>
            <div class="col-6 col-md-3">
              <div style="text-align:center;padding:1.2rem;background:rgba(255,255,255,.02);border:1px solid rgba(255,255,255,.06);border-radius:12px;">
                <div style="font-family:var(--font-serif);font-size:2rem;font-weight:800;color:var(--gold);line-height:1;" id="statRating">—</div>
                <div style="font-size:.68rem;text-transform:uppercase;letter-spacing:.1em;color:var(--text-muted);margin-top:4px;">Avg. Rating</div>
              </div>
            </div>
          </div>
        </div>

        <!-- TAB: PRACTICE AREAS -->
        <div class="tab-panel" id="panel-practice">
          <div class="info-panel" data-aos="fade-up">
            <div class="info-panel-title"><i class="fas fa-gavel"></i> Practice Areas</div>
            <div class="practice-pills mb-4" id="pPracticeAreas"></div>
          </div>
          <div class="info-panel" data-aos="fade-up">
            <div class="info-panel-title"><i class="fas fa-language"></i> Languages Spoken</div>
            <div id="pLangsBox"></div>
          </div>
          <div class="info-panel" data-aos="fade-up">
            <div class="info-panel-title"><i class="fas fa-map-marker-alt"></i> Office Address</div>
            <div id="pAddressBox"></div>
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
            <a href="search.html" class="btn-outline-gold w-100 mt-2" style="justify-content:center;font-size:.78rem;">
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

// ──────────────── DATA ────────────────
const LAWYERS = [
  { id:1,  name:'Michael Kingston, Esq.',   qual:'J.D., Harvard Law School · LL.M., Criminal Justice',  spec:'Criminal Law',    exp:18, city:'New York, NY',      fee:450, rating:4.9, reviews:234, langs:['English','Spanish'], freeConsult:true, available:true, initials:'MK', c1:'#0D1B3E', c2:'#1A2F60',
    bio:'Michael Kingston is one of New York\'s most formidable criminal defense attorneys, with 18 years of courtroom experience handling everything from misdemeanor charges to high-profile federal cases. A Harvard Law graduate, Michael brings a meticulous analytical approach and an aggressive advocacy style that has earned him a reputation as a tenacious defender of his clients\' constitutional rights. He has successfully argued before the U.S. Court of Appeals and the New York Court of Appeals, achieving landmark acquittals and sentence reductions that set legal precedents. Michael is known not only for his legal brilliance but also for his unwavering commitment to every client\'s dignity and wellbeing.',
    education:'J.D., Harvard Law School (2006) · LL.M. Criminal Justice, Georgetown University (2007)',
    barNum:'NY-2006-4412', won:140, total:163,
    areas:['Criminal Defense','Federal Cases','DUI & DWI','Drug Charges','White-Collar Crime','Appeals & Post-Conviction','Assault & Battery','Juvenile Defense'],
    address:'350 Fifth Avenue, Suite 4100, New York, NY 10118',
    awards:['Super Lawyers® 2018–2024','AV Preeminent® Rated – Martindale-Hubbell','Best Criminal Defense Attorney – New York Magazine 2022','National Trial Lawyers – Top 100'],
    schedule:{ Mon:'9am–6pm', Tue:'9am–6pm', Wed:'9am–6pm', Thu:'10am–7pm', Fri:'9am–5pm', Sat:'10am–2pm', Sun:'Closed' } },

  { id:2,  name:'Sarah Reynolds, Esq.',     qual:'J.D., Yale Law School · Family Law Specialist',       spec:'Divorce Law',     exp:14, city:'Los Angeles, CA',   fee:380, rating:4.8, reviews:189, langs:['English','French'],  freeConsult:true, available:true, initials:'SR', c1:'#1A2F60', c2:'#142450',
    bio:'Sarah Reynolds is a compassionate yet formidably effective family and divorce attorney based in Los Angeles. With 14 years of dedicated practice in domestic relations law, Sarah has guided hundreds of families through divorce, child custody, and asset division proceedings with sensitivity and strategic brilliance. A Yale Law graduate, she combines deep legal knowledge with an empathetic approach that helps clients navigate emotionally difficult situations while achieving the best possible outcomes. Sarah is particularly recognized for her expertise in high-net-worth divorce cases and complex custody arrangements. She is a certified family law specialist and trained mediator.',
    education:'J.D., Yale Law School (2010) · Certified Family Law Specialist – CBLS',
    barNum:'CA-2010-8837', won:156, total:174,
    areas:['Contested Divorce','Uncontested Divorce','Child Custody & Visitation','Spousal Support','Asset Division','Prenuptial Agreements','Domestic Violence','Collaborative Divorce'],
    address:'1888 Century Park East, Suite 1900, Los Angeles, CA 90067',
    awards:['Super Lawyers® Southern California 2019–2024','Southern California Family Law Specialist of the Year 2023','Certified Family Law Specialist – CBLS'],
    schedule:{ Mon:'9am–5pm', Tue:'9am–5pm', Wed:'10am–6pm', Thu:'9am–5pm', Fri:'9am–4pm', Sat:'Closed', Sun:'Closed' } },

  { id:3,  name:'James Crawford, Esq.',     qual:'J.D., Columbia Law School · M.B.A., Wharton School', spec:'Corporate Law',   exp:22, city:'Chicago, IL',       fee:580, rating:5.0, reviews:302, langs:['English'],            freeConsult:false, available:true, initials:'JC', c1:'#2a1a00', c2:'#1a1000',
    bio:'James Crawford is a preeminent corporate attorney with over 22 years of experience advising Fortune 500 companies, private equity firms, and startups on their most complex and consequential transactions. A Columbia Law graduate with an M.B.A. from Wharton, James brings a unique blend of deep legal expertise and sophisticated business acumen to every engagement. He has led hundreds of mergers, acquisitions, and strategic transactions across industries ranging from technology and healthcare to finance and real estate. James is widely regarded as one of the premier dealmakers in Chicago\'s legal community and is consistently ranked among the best corporate lawyers in the nation.',
    education:'J.D., Columbia Law School (2002) · M.B.A., Wharton School of Business (2003)',
    barNum:'IL-2002-3391', won:285, total:302,
    areas:['Mergers & Acquisitions','Corporate Governance','Commercial Contracts','Securities Law','Private Equity','Joint Ventures','Corporate Compliance','Board Advisory'],
    address:'175 W. Jackson Blvd., Suite 1600, Chicago, IL 60604',
    awards:['Chambers USA Band 1 – Corporate/M&A','Legal 500 – Corporate Transactions','Best Lawyers® in America 2015–2024','Chicago Lawyer Attorney of the Year 2023'],
    schedule:{ Mon:'8am–7pm', Tue:'8am–7pm', Wed:'8am–7pm', Thu:'8am–7pm', Fri:'8am–6pm', Sat:'By Appt.', Sun:'Closed' } },

  { id:5,  name:'Elena Vasquez, Esq.',      qual:'J.D., Stanford Law School · Civil Litigation Expert', spec:'Civil Law',       exp:16, city:'Miami, FL',         fee:420, rating:4.9, reviews:267, langs:['English','Spanish','Portuguese'], freeConsult:true, available:true, initials:'EV', c1:'#1a1a2e', c2:'#16213e',
    bio:'Elena Vasquez is a dynamic civil litigator whose relentless preparation and persuasive courtroom presence have resulted in exceptional outcomes for her clients over 16 years of practice. A Stanford Law graduate, Elena specializes in personal injury, employment discrimination, and civil rights litigation. She is equally effective at negotiating multi-million dollar settlements and trying complex cases to verdict before juries. Fluent in English, Spanish, and Portuguese, Elena serves a diverse client base and is known for her accessibility, thoroughness, and genuine passion for justice.',
    education:'J.D., Stanford Law School (2008) · B.A. Political Science, UCLA (2005)',
    barNum:'FL-2008-7723', won:198, total:221,
    areas:['Personal Injury','Employment Discrimination','Civil Rights','Contract Disputes','Defamation & Libel','Medical Malpractice','Class Actions','Wrongful Termination'],
    address:'1450 Brickell Avenue, Suite 2200, Miami, FL 33131',
    awards:['Florida Super Lawyers® 2017–2024','Verdicts & Settlements Top 50 – Florida 2022','National Trial Lawyers Top 100','Best Lawyers® in America 2020–2024'],
    schedule:{ Mon:'9am–6pm', Tue:'9am–6pm', Wed:'9am–6pm', Thu:'9am–6pm', Fri:'9am–5pm', Sat:'10am–1pm', Sun:'Closed' } },

  { id:7,  name:'Priya Nair, Esq.',         qual:'J.D., Georgetown University · Immigration Law Expert', spec:'Immigration Law', exp:13, city:'San Francisco, CA', fee:350, rating:4.8, reviews:211, langs:['English','Hindi','Tamil'], freeConsult:true, available:true, initials:'PN', c1:'#1a0d2a', c2:'#12071a',
    bio:'Priya Nair is a highly respected immigration attorney with 13 years of experience navigating the complexities of U.S. immigration law for individuals, families, and corporations. A Georgetown Law graduate, Priya has successfully handled thousands of visa applications, green card petitions, naturalization cases, and deportation defense matters. She is particularly known for her expertise in employment-based immigration for technology companies in Silicon Valley, as well as complex asylum cases and DACA matters. Priya approaches each case with exceptional attention to detail and a deep commitment to her clients\' futures in the United States.',
    education:'J.D., Georgetown University Law Center (2011) · B.S. International Relations, UC Davis (2008)',
    barNum:'CA-2011-6621', won:178, total:196,
    areas:['Visa Applications','Green Card Petitions','Citizenship & Naturalization','Deportation Defense','Asylum Applications','DACA & TPS','Employment-Based Immigration','Family Petitions'],
    address:'101 Second Street, Suite 1800, San Francisco, CA 94105',
    awards:['Bay Area Best Lawyers® 2019–2024','AILA Outstanding Immigration Lawyer 2022','Super Lawyers® Northern California 2020–2024'],
    schedule:{ Mon:'9am–5pm', Tue:'9am–5pm', Wed:'9am–5pm', Thu:'9am–5pm', Fri:'9am–4pm', Sat:'10am–12pm', Sun:'Closed' } },
];

const REVIEWS_DATA = {
  1:[
    { name:'Alexander Thompson', init:'AT', c:'#C9A84C', date:'Nov 2024', rating:5, case:'Criminal Defense', text:'Michael is an absolute force in the courtroom. The charges against me were serious, and I was terrified. He dismantled the prosecution\'s case piece by piece and the jury returned a not-guilty verdict. Extraordinary legal mind.' },
    { name:'Christine Park',     init:'CP', c:'#1A2F60', date:'Oct 2024', rating:5, case:'DUI Defense',       text:'I was facing my second DUI and feared the worst. Michael negotiated a plea that avoided any jail time and protected my professional license. His calm, methodical approach gave me confidence throughout.' },
    { name:'Robert Davies',      init:'RD', c:'#0d2a1a', date:'Sep 2024', rating:5, case:'Federal Case',      text:'Michael handled my federal fraud case with exceptional skill. He anticipated every prosecution move and his closing argument was nothing short of masterful. The charges were dramatically reduced. Cannot recommend enough.' },
    { name:'Linda Morrison',     init:'LM', c:'#2a0d0d', date:'Aug 2024', rating:4, case:'Appeal',            text:'Michael successfully argued my appeal and had my conviction overturned on a constitutional violation he identified that previous counsel had missed. Brilliant attorney.' },
  ],
  2:[
    { name:'Patricia Monroe', init:'PM', c:'#1A2F60', date:'Oct 2024', rating:5, case:'Divorce',       text:'Sarah guided me through the most painful time of my life with extraordinary compassion. She protected my children\'s interests at every turn and secured a settlement far better than I had hoped. Truly outstanding.' },
    { name:'Thomas Ellison', init:'TE', c:'#C9A84C', date:'Sep 2024', rating:5, case:'Custody Battle', text:'Sarah fought relentlessly for my custody rights as a father in a highly contentious case. Her preparation was meticulous and she never wavered. I now have joint custody of my children. Forever grateful.' },
    { name:'Wendy Hale',     init:'WH', c:'#0d2a1a', date:'Aug 2024', rating:5, case:'Divorce',        text:'The divorce involved complex assets and a very difficult opposing attorney. Sarah handled everything brilliantly and I received a settlement that fully secured my financial future. Highly recommend.' },
  ],
  default:[
    { name:'Michael Carter',  init:'MC', c:'#C9A84C', date:'Nov 2024', rating:5, case:'General',    text:'Exceptional attorney with deep expertise and genuine dedication to clients. Highly professional throughout and delivered outstanding results. Would absolutely recommend to anyone seeking top legal representation.' },
    { name:'Jennifer Wells',  init:'JW', c:'#1A2F60', date:'Oct 2024', rating:5, case:'Consulting', text:'Clear communication, brilliant strategy, and a true commitment to winning. Every aspect of my case was handled with precision and care. This is what elite legal representation looks like.' },
    { name:'David Okafor',    init:'DO', c:'#0d2a1a', date:'Sep 2024', rating:4, case:'Litigation',  text:'Very knowledgeable and responsive attorney who took the time to explain every aspect of my case clearly. The outcome exceeded my expectations. Will definitely be back if I ever need legal help again.' },
  ]
};

// ──────────────── STATE ────────────────
let lawyer = null;
let selectedDate = null;
let selectedTime = null;
let selectedMode = 'Video';

// ──────────────── INIT ────────────────
function starsHtml(r, size='') {
  const full = Math.floor(r), half = (r % 1) >= 0.5;
  let h = '';
  for (let i = 1; i <= 5; i++) {
    if (i <= full) h += `<i class="fas fa-star${size}"></i>`;
    else if (i === full+1 && half) h += `<i class="fas fa-star-half-alt${size}"></i>`;
    else h += `<i class="far fa-star${size}"></i>`;
  }
  return h;
}

function loadLawyer() {
  const params = new URLSearchParams(window.location.search);
  const id = parseInt(params.get('id')) || 1;
  lawyer = LAWYERS.find(l=>l.id===id) || LAWYERS[0];

  // Breadcrumb
  $('#bcName').text(lawyer.name);
  document.title = `${lawyer.name} — LexElite`;

  // Photo
  $('#profilePhoto').html(`
    <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,${lawyer.c1},${lawyer.c2});font-size:4.5rem;color:rgba(201,168,76,.6);">
      <i class="fas fa-user-tie"></i>
    </div>
    <div class="profile-verified-badge" title="Verified"><i class="fas fa-check"></i></div>
    ${lawyer.available ? '<div class="profile-online-dot"></div>' : ''}
  `);

  // Hero info
  $('#pSpec').text(lawyer.spec);
  $('#pName').text(lawyer.name);
  $('#pQual').html(`<i class="fas fa-graduation-cap me-2" style="color:var(--gold);font-size:.75rem;"></i>${lawyer.qual}`);
  $('#pStars').html(starsHtml(lawyer.rating));
  $('#pRating').text(lawyer.rating);
  $('#pReviews').text(`(${lawyer.reviews} reviews)`);
  $('#pAvailable').html(lawyer.available ? '<i class="fas fa-circle" style="font-size:.5rem;margin-right:4px;"></i>Available Today' : '');
  if (!lawyer.available) $('#pAvailable').hide();

  $('#pMeta').html(`
    <span class="ph-meta-item"><i class="fas fa-map-marker-alt"></i>${lawyer.city}</span>
    <span class="ph-meta-item"><i class="fas fa-briefcase"></i>${lawyer.exp} Years Experience</span>
    <span class="ph-meta-item"><i class="fas fa-dollar-sign"></i>$${lawyer.fee}/hr</span>
    <span class="ph-meta-item"><i class="fas fa-language"></i>${lawyer.langs.join(', ')}</span>
    ${lawyer.freeConsult ? '<span class="ph-meta-item" style="color:#4ade80;"><i class="fas fa-gift"></i>Free Initial Consultation</span>' : ''}
  `);

  $('#pKpi').html(`
    <div class="profile-kpi-item"><div class="kpi-val">${lawyer.won}</div><div class="kpi-label">Cases Won</div></div>
    <div class="profile-kpi-item"><div class="kpi-val">${lawyer.total}</div><div class="kpi-label">Total Cases</div></div>
    <div class="profile-kpi-item"><div class="kpi-val">${lawyer.rating}</div><div class="kpi-label">Rating</div></div>
    <div class="profile-kpi-item"><div class="kpi-val">${lawyer.exp}yr</div><div class="kpi-label">Experience</div></div>
  `);

  // Fee hero
  $('#pFeeHero').text(`$${lawyer.fee}`);
  if (lawyer.freeConsult) {
    $('#pFreeLabel').html('<span style="font-size:.72rem;font-weight:700;color:#4ade80;background:rgba(74,222,128,.1);border:1px solid rgba(74,222,128,.25);padding:4px 12px;border-radius:50px;display:inline-block;"><i class="fas fa-gift me-1"></i>Free Initial Consult</span>');
  }

  // BIO tab
  $('#pBio').text(lawyer.bio);
  $('#pEdBox').html(`
    <div class="detail-row">
      <div class="detail-icon"><i class="fas fa-graduation-cap"></i></div>
      <div><div class="detail-label">Education</div><div class="detail-value">${lawyer.education}</div></div>
    </div>
    <div class="detail-row">
      <div class="detail-icon"><i class="fas fa-id-badge"></i></div>
      <div><div class="detail-label">Bar License</div><div class="detail-value">${lawyer.barNum}</div></div>
    </div>
    <div class="detail-row">
      <div class="detail-icon"><i class="fas fa-shield-halved"></i></div>
      <div><div class="detail-label">Verification</div><div class="detail-value" style="color:#4ade80;"><i class="fas fa-check-circle me-1"></i>Verified & Active</div></div>
    </div>
  `);

  // Stat boxes
  $('#statWins').text(lawyer.won);
  $('#statCases').text(lawyer.total);
  $('#statExp').text(lawyer.exp+'yr');
  $('#statRating').text(lawyer.rating);

  // PRACTICE tab
  const iconMap = { 'Criminal':' fa-gavel','Civil':' fa-scale-balanced','Divorce':'fa-ring','Family':'fa-heart','Property':'fa-house','Corporate':'fa-building','Immigration':'fa-globe','Affidavit':'fa-file-signature','Estate':'fa-scroll','Default':'fa-check' };
  const getIcon = area => { const k = Object.keys(iconMap).find(k=>area.includes(k)); return `fas fa-${iconMap[k]||iconMap.Default}`; };
  $('#pPracticeAreas').html(lawyer.areas.map(a=>`<span class="practice-pill"><i class="${getIcon(a)}"></i>${a}</span>`).join(''));
  $('#pLangsBox').html(`<div style="display:flex;flex-wrap:wrap;">${lawyer.langs.map(l=>`<span class="lang-badge"><i class="fas fa-language"></i>${l}</span>`).join('')}</div>`);
  $('#pAddressBox').html(`
    <div class="detail-row" style="border:none;padding:0;">
      <div class="detail-icon"><i class="fas fa-map-marker-alt"></i></div>
      <div><div class="detail-label">Office</div><div class="detail-value">${lawyer.address}</div></div>
    </div>
  `);

  // SCHEDULE tab
  const todayIdx = new Date().getDay(); // 0=Sun
  const dayKeys = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];
  const dayOrder = ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'];
  const todayDay = dayKeys[todayIdx];
  let sch = '';
  dayOrder.forEach(day => {
    const val = lawyer.schedule[day] || 'Closed';
    const cls = day===todayDay ? 'today' : (val==='Closed' ? 'closed' : 'open');
    sch += `<div class="day-col"><div class="day-name">${day}</div><div class="day-cell ${cls}">${val==='Closed'?'—':''}<span class="day-time">${val}</span></div></div>`;
  });
  $('#scheduleGrid').html(sch);

  // REVIEWS tab
  const revData = REVIEWS_DATA[lawyer.id] || REVIEWS_DATA.default;
  $('#bigRating').text(lawyer.rating);
  $('#bigStars').html(starsHtml(lawyer.rating));
  $('#bigReviews').text(`Based on ${lawyer.reviews} reviews`);

  // Rating bars
  const dist = [40, 30, 18, 8, 4];
  let bars = '';
  [5,4,3,2,1].forEach((star,i) => {
    const pct = Math.round(dist[i] * (1 + (lawyer.rating-4.5)));
    const capped = Math.min(Math.max(pct,2),98);
    bars += `<div class="rating-bar-row"><span class="rating-bar-num">${star}★</span><div class="rating-bar-track"><div class="rating-bar-fill" style="width:${capped}%"></div></div><span class="rating-bar-num" style="text-align:right;">${dist[i]}%</span></div>`;
  });
  $('#ratingBars').html(bars);

  let reviewsHtml = '';
  revData.forEach(r => {
    const stars = '★'.repeat(r.rating) + '☆'.repeat(5-r.rating);
    reviewsHtml += `
    <div class="review-card" data-aos="fade-up">
      <div class="d-flex align-items-start gap-3">
        <div class="reviewer-avatar" style="background:linear-gradient(135deg,${r.c},${r.c}99);">${r.init}</div>
        <div style="flex:1;">
          <div class="d-flex justify-content-between flex-wrap gap-1">
            <div><div class="reviewer-name">${r.name}</div><div class="reviewer-date">${r.date}</div></div>
            <div class="review-stars">${stars}</div>
          </div>
          <p class="review-text">${r.text}</p>
          <span class="review-tag"><i class="fas fa-gavel" style="font-size:.6rem;color:var(--gold);"></i>${r.case}</span>
          <span class="review-tag"><i class="fas fa-check-circle" style="font-size:.6rem;color:#4ade80;"></i>Verified Client</span>
        </div>
      </div>
    </div>`;
  });
  $('#reviewsList').html(reviewsHtml);

  // DETAILS tab
  $('#detailsBox').html(`
    <div class="detail-row">
      <div class="detail-icon"><i class="fas fa-graduation-cap"></i></div>
      <div><div class="detail-label">Education</div><div class="detail-value">${lawyer.education}</div></div>
    </div>
    <div class="detail-row">
      <div class="detail-icon"><i class="fas fa-id-badge"></i></div>
      <div><div class="detail-label">Bar License Number</div><div class="detail-value">${lawyer.barNum}</div></div>
    </div>
    <div class="detail-row">
      <div class="detail-icon"><i class="fas fa-language"></i></div>
      <div><div class="detail-label">Languages</div><div class="detail-value">${lawyer.langs.join(' · ')}</div></div>
    </div>
    <div class="detail-row">
      <div class="detail-icon"><i class="fas fa-map-marker-alt"></i></div>
      <div><div class="detail-label">Office Address</div><div class="detail-value">${lawyer.address}</div></div>
    </div>
    <div class="detail-row">
      <div class="detail-icon"><i class="fas fa-dollar-sign"></i></div>
      <div><div class="detail-label">Consultation Fee</div><div class="detail-value" style="color:var(--gold);">$${lawyer.fee}/hr ${lawyer.freeConsult?'· Free Initial Consult':''}</div></div>
    </div>
    <div class="detail-row">
      <div class="detail-icon"><i class="fas fa-shield-halved"></i></div>
      <div><div class="detail-label">Verification</div><div class="detail-value" style="color:#4ade80;"><i class="fas fa-check-circle me-1"></i>Verified & Active · ABA Approved</div></div>
    </div>
  `);
  $('#awardsBox').html(lawyer.awards.map(a=>`
    <div style="display:flex;align-items:center;gap:12px;padding:.8rem 0;border-bottom:1px solid rgba(255,255,255,.04);">
      <div style="width:34px;height:34px;border-radius:8px;background:rgba(201,168,76,.1);border:1px solid rgba(201,168,76,.2);display:flex;align-items:center;justify-content:center;flex-shrink:0;color:var(--gold);font-size:.8rem;"><i class="fas fa-award"></i></div>
      <span style="font-size:.85rem;color:rgba(255,255,255,.85);">${a}</span>
    </div>
  `).join(''));

  // Booking sidebar
  $('#sumName').text(lawyer.name);
  $('#bookFee').text(`$${lawyer.fee}`);
  buildDates();
  buildSimilar();
}

// ──────────────── DATES & TIMES ────────────────
function buildDates() {
  const days = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];
  const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
  let html = '';
  const now = new Date();
  for (let i = 0; i < 7; i++) {
    const d = new Date(now); d.setDate(now.getDate() + i);
    const label = i===0?'Today':i===1?'Tomorrow':days[d.getDay()];
    const active = i===0 ? 'active' : '';
    html += `<div class="date-tab ${active}" onclick="selectDate(this,'${label}, ${months[d.getMonth()]} ${d.getDate()}')">
      <span class="date-day">${label}</span>
      <span class="date-num">${d.getDate()}</span>
    </div>`;
  }
  $('#dateStrip').html(html);
  selectedDate = `Today, ${months[now.getMonth()]} ${now.getDate()}`;
  $('#sumDate').text(selectedDate);
  buildTimes();
}

const ALL_TIMES = ['8:00 AM','9:00 AM','10:00 AM','11:00 AM','12:00 PM','1:00 PM','2:00 PM','3:00 PM','4:00 PM','5:00 PM','6:00 PM'];
const BOOKED   = [2, 5, 8]; // indexes of booked slots

function buildTimes() {
  let html = '';
  ALL_TIMES.forEach((t,i) => {
    const booked = BOOKED.includes(i);
    html += `<div class="time-slot ${booked?'booked':''}" onclick="${booked?'':'selectTime(this,\''+t+'\')'}">
      ${t}${booked?'<br><span style="font-size:.6rem;opacity:.5;">Booked</span>':''}
    </div>`;
  });
  $('#timeGrid').html(html);
}

function selectDate(el, label) {
  $('.date-tab').removeClass('active');
  $(el).addClass('active');
  selectedDate = label;
  $('#sumDate').text(label);
  $('#mSumDateTime').text(`${selectedDate}${selectedTime?', '+selectedTime:''}`);
}

function selectTime(el, time) {
  $('.time-slot').removeClass('active');
  $(el).addClass('active');
  selectedTime = time;
  $('#sumTime').text(time);
  $('#mSumDateTime').text(`${selectedDate||'—'}, ${time}`);
}

function selectMode(el) {
  $('.consult-type-btn').removeClass('active');
  $(el).addClass('active');
  selectedMode = $(el).data('mode');
  $('#sumMode').text(selectedMode);
  $('#mSumMode').text(selectedMode);
}

// ──────────────── SIMILAR ────────────────
function buildSimilar() {
  const others = LAWYERS.filter(l=>l.id!==lawyer.id).slice(0,3);
  const colors = ['#C9A84C','#1A2F60','#0d2a1a'];
  $('#similarBox').html(others.map((l,i)=>`
    <a href="profile.html?id=${l.id}" class="text-decoration-none">
      <div class="similar-card">
        <div class="similar-avatar" style="background:linear-gradient(135deg,${l.c1},${l.c2});color:${i===0?'#0a0a0a':'var(--gold)'};">${l.initials}</div>
        <div>
          <div class="similar-name">${l.name}</div>
          <div class="similar-spec">${l.spec} · ${l.exp} yrs</div>
        </div>
        <div class="similar-rating">★ ${l.rating}</div>
      </div>
    </a>
  `).join(''));
}

// ──────────────── BOOKING MODAL ────────────────
function openBookingModal() {
  if (!selectedTime) { showToast('Please select a time slot first.'); return; }
  // Populate modal
  $('#mSumName').text(lawyer.name);
  $('#mSumSpec').text(lawyer.spec);
  $('#mSumDateTime').text(`${selectedDate||'—'}, ${selectedTime}`);
  $('#mSumMode').text(selectedMode);
  $('#mSumFee').text(`$${lawyer.fee}/hr`);
  $('#sumFee').text(`$${lawyer.fee}/hr`);
  // Reset modal state
  $('#modalBody').show(); $('#successBody').hide();
  $('#modalFooter').show();
  new bootstrap.Modal('#bookingModal').show();
}

function confirmBooking() {
  const name  = $('#mName').val().trim();
  const email = $('#mEmail').val().trim();
  if (!name) { $('#mName').focus(); showToast('Please enter your name.'); return; }
  if (!email || !email.includes('@')) { $('#mEmail').focus(); showToast('Please enter a valid email.'); return; }

  const ref = 'LE-' + Math.random().toString(36).substr(2,8).toUpperCase();
  $('#confNum').text(ref);
  $('#succName').text(lawyer.name);
  $('#succDT').text(`${selectedDate||'—'}, ${selectedTime}`);
  $('#modalBody').slideUp(250, function() {
    $('#successBody').slideDown(300);
  });
  $('#modalFooter').html('<button class="btn-gold" data-bs-dismiss="modal"><i class="fas fa-check me-2"></i>Done</button>');
}

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
  loadLawyer();
  AOS.refresh();
});
</script>
</body>
</html>
