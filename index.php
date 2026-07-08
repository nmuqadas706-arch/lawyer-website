<?php
include_once 'includes/connection.php';
include_once 'includes/header.php';



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
          <a href="about.html" class="btn-outline-gold">
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
              <div class="hero-lawyer-item">
                <div class="lawyer-avatar">MK</div>
                <div>
                  <div class="lawyer-info-name">Michael Kingston</div>
                  <div class="lawyer-info-spec">Criminal Defense</div>
                </div>
                <div class="lawyer-rating">★ 4.9</div>
              </div>
              <div class="hero-lawyer-item">
                <div class="lawyer-avatar" style="background:linear-gradient(135deg,#1A2F60,#0D1B3E); color:var(--gold);">SR</div>
                <div>
                  <div class="lawyer-info-name">Sarah Reynolds</div>
                  <div class="lawyer-info-spec">Family & Divorce Law</div>
                </div>
                <div class="lawyer-rating">★ 4.8</div>
              </div>
              <div class="hero-lawyer-item">
                <div class="lawyer-avatar" style="background:linear-gradient(135deg,#A8872E,#C9A84C); color:var(--dark);">JC</div>
                <div>
                  <div class="lawyer-info-name">James Crawford</div>
                  <div class="lawyer-info-spec">Corporate Law</div>
                </div>
                <div class="lawyer-rating">★ 5.0</div>
              </div>
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

      <!-- Lawyer 1 -->
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="0">
        <div class="lawyer-card">
          <div class="lawyer-card-img-placeholder"><i class="fas fa-user-tie"></i></div>
          <div class="lawyer-card-body">
            <div class="lawyer-card-specialty">Criminal Defense</div>
            <h3 class="lawyer-card-name">Michael Kingston, Esq.</h3>
            <p class="lawyer-card-bio">Over 18 years defending clients in high-profile criminal cases with an exceptional acquittal record.</p>
            <div class="lawyer-card-rating">
              <span class="stars">★★★★★</span>
              <span style="font-size:0.82rem; font-weight:600; color:var(--white);">4.9</span>
              <span style="font-size:0.78rem; color:var(--text-muted);">(234 reviews)</span>
            </div>
            <div class="lawyer-card-meta">
              <span class="meta-item"><i class="fas fa-map-marker-alt"></i> New York, NY</span>
              <span class="meta-item"><i class="fas fa-briefcase"></i> 18 yrs exp</span>
            </div>
            <div class="mt-3 d-flex gap-2">
              <a href="profile.html" class="btn-gold" style="padding:10px 20px; font-size:0.78rem; flex:1; justify-content:center;">View Profile</a>
              <a href="#" class="btn-outline-gold" style="padding:10px 16px; font-size:0.78rem;"><i class="fas fa-phone"></i></a>
            </div>
          </div>
        </div>
      </div>

      <!-- Lawyer 2 -->
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
        <div class="lawyer-card">
          <div class="lawyer-card-img-placeholder" style="background:linear-gradient(135deg,#1A2F60,#0D1B3E);"><i class="fas fa-user-tie" style="opacity:0.8;"></i></div>
          <div class="lawyer-card-body">
            <div class="lawyer-card-specialty">Family & Divorce Law</div>
            <h3 class="lawyer-card-name">Sarah Reynolds, Esq.</h3>
            <p class="lawyer-card-bio">Compassionate advocate specializing in complex divorce and custody cases, protecting family rights.</p>
            <div class="lawyer-card-rating">
              <span class="stars">★★★★★</span>
              <span style="font-size:0.82rem; font-weight:600; color:var(--white);">4.8</span>
              <span style="font-size:0.78rem; color:var(--text-muted);">(189 reviews)</span>
            </div>
            <div class="lawyer-card-meta">
              <span class="meta-item"><i class="fas fa-map-marker-alt"></i> Los Angeles, CA</span>
              <span class="meta-item"><i class="fas fa-briefcase"></i> 14 yrs exp</span>
            </div>
            <div class="mt-3 d-flex gap-2">
              <a href="profile.html" class="btn-gold" style="padding:10px 20px; font-size:0.78rem; flex:1; justify-content:center;">View Profile</a>
              <a href="#" class="btn-outline-gold" style="padding:10px 16px; font-size:0.78rem;"><i class="fas fa-phone"></i></a>
            </div>
          </div>
        </div>
      </div>

      <!-- Lawyer 3 -->
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
        <div class="lawyer-card">
          <div class="lawyer-card-img-placeholder" style="background:linear-gradient(135deg,#2a1a00,#1a1000);"><i class="fas fa-user-tie" style="opacity:0.8;"></i></div>
          <div class="lawyer-card-body">
            <div class="lawyer-card-specialty">Corporate Law</div>
            <h3 class="lawyer-card-name">James Crawford, Esq.</h3>
            <p class="lawyer-card-bio">Strategic corporate attorney advising Fortune 500 companies on mergers, acquisitions, and compliance.</p>
            <div class="lawyer-card-rating">
              <span class="stars">★★★★★</span>
              <span style="font-size:0.82rem; font-weight:600; color:var(--white);">5.0</span>
              <span style="font-size:0.78rem; color:var(--text-muted);">(302 reviews)</span>
            </div>
            <div class="lawyer-card-meta">
              <span class="meta-item"><i class="fas fa-map-marker-alt"></i> Chicago, IL</span>
              <span class="meta-item"><i class="fas fa-briefcase"></i> 22 yrs exp</span>
            </div>
            <div class="mt-3 d-flex gap-2">
              <a href="profile.html" class="btn-gold" style="padding:10px 20px; font-size:0.78rem; flex:1; justify-content:center;">View Profile</a>
              <a href="#" class="btn-outline-gold" style="padding:10px 16px; font-size:0.78rem;"><i class="fas fa-phone"></i></a>
            </div>
          </div>
        </div>
      </div>

      <!-- Lawyer 4 -->
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="0">
        <div class="lawyer-card">
          <div class="lawyer-card-img-placeholder" style="background:linear-gradient(135deg,#0d2a1a,#051a0d);"><i class="fas fa-user-tie" style="opacity:0.8;"></i></div>
          <div class="lawyer-card-body">
            <div class="lawyer-card-specialty">Property Law</div>
            <h3 class="lawyer-card-name">David Winters, Esq.</h3>
            <p class="lawyer-card-bio">Expert in real estate disputes, property transfers, and landlord-tenant litigation across 12 states.</p>
            <div class="lawyer-card-rating">
              <span class="stars">★★★★<i class="fas fa-star-half-alt" style="color:var(--gold);"></i></span>
              <span style="font-size:0.82rem; font-weight:600; color:var(--white);">4.7</span>
              <span style="font-size:0.78rem; color:var(--text-muted);">(145 reviews)</span>
            </div>
            <div class="lawyer-card-meta">
              <span class="meta-item"><i class="fas fa-map-marker-alt"></i> Houston, TX</span>
              <span class="meta-item"><i class="fas fa-briefcase"></i> 11 yrs exp</span>
            </div>
            <div class="mt-3 d-flex gap-2">
              <a href="profile.html" class="btn-gold" style="padding:10px 20px; font-size:0.78rem; flex:1; justify-content:center;">View Profile</a>
              <a href="#" class="btn-outline-gold" style="padding:10px 16px; font-size:0.78rem;"><i class="fas fa-phone"></i></a>
            </div>
          </div>
        </div>
      </div>

      <!-- Lawyer 5 -->
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
        <div class="lawyer-card">
          <div class="lawyer-card-img-placeholder" style="background:linear-gradient(135deg,#1a1a2e,#16213e);"><i class="fas fa-user-tie" style="opacity:0.8;"></i></div>
          <div class="lawyer-card-body">
            <div class="lawyer-card-specialty">Civil Litigation</div>
            <h3 class="lawyer-card-name">Elena Vasquez, Esq.</h3>
            <p class="lawyer-card-bio">Dynamic litigator resolving complex civil disputes with precision strategy and courtroom expertise.</p>
            <div class="lawyer-card-rating">
              <span class="stars">★★★★★</span>
              <span style="font-size:0.82rem; font-weight:600; color:var(--white);">4.9</span>
              <span style="font-size:0.78rem; color:var(--text-muted);">(267 reviews)</span>
            </div>
            <div class="lawyer-card-meta">
              <span class="meta-item"><i class="fas fa-map-marker-alt"></i> Miami, FL</span>
              <span class="meta-item"><i class="fas fa-briefcase"></i> 16 yrs exp</span>
            </div>
            <div class="mt-3 d-flex gap-2">
              <a href="profile.html" class="btn-gold" style="padding:10px 20px; font-size:0.78rem; flex:1; justify-content:center;">View Profile</a>
              <a href="#" class="btn-outline-gold" style="padding:10px 16px; font-size:0.78rem;"><i class="fas fa-phone"></i></a>
            </div>
          </div>
        </div>
      </div>

      <!-- Lawyer 6 -->
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
        <div class="lawyer-card">
          <div class="lawyer-card-img-placeholder" style="background:linear-gradient(135deg,#2a0d0d,#1a0505);"><i class="fas fa-user-tie" style="opacity:0.8;"></i></div>
          <div class="lawyer-card-body">
            <div class="lawyer-card-specialty">Affidavit & Notary</div>
            <h3 class="lawyer-card-name">Robert Chambers, Esq.</h3>
            <p class="lawyer-card-bio">Swift and accurate affidavit drafting and notarization services for all legal document needs.</p>
            <div class="lawyer-card-rating">
              <span class="stars">★★★★<i class="fas fa-star-half-alt" style="color:var(--gold);"></i></span>
              <span style="font-size:0.82rem; font-weight:600; color:var(--white);">4.6</span>
              <span style="font-size:0.78rem; color:var(--text-muted);">(98 reviews)</span>
            </div>
            <div class="lawyer-card-meta">
              <span class="meta-item"><i class="fas fa-map-marker-alt"></i> Phoenix, AZ</span>
              <span class="meta-item"><i class="fas fa-briefcase"></i> 9 yrs exp</span>
            </div>
            <div class="mt-3 d-flex gap-2">
              <a href="profile.html" class="btn-gold" style="padding:10px 20px; font-size:0.78rem; flex:1; justify-content:center;">View Profile</a>
              <a href="#" class="btn-outline-gold" style="padding:10px 16px; font-size:0.78rem;"><i class="fas fa-phone"></i></a>
            </div>
          </div>
        </div>
      </div>

    </div>

    <div class="text-center mt-5" data-aos="fade-up">
      <a href="search.html" class="btn-outline-gold">
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

      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="0">
        <div class="service-card">
          <div class="service-icon-wrapper"><i class="fas fa-gavel"></i></div>
          <h4 class="service-title">Criminal Law</h4>
          <p class="service-desc">Expert criminal defense attorneys who protect your rights and fight aggressively for your freedom in court.</p>
          <a href="services.html#criminal" class="service-link">Explore Service <i class="fas fa-arrow-right"></i></a>
        </div>
      </div>

      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
        <div class="service-card">
          <div class="service-icon-wrapper"><i class="fas fa-scale-balanced"></i></div>
          <h4 class="service-title">Civil Law</h4>
          <p class="service-desc">Skilled civil litigators handling disputes, contracts, and torts with strategic legal solutions.</p>
          <a href="services.html#civil" class="service-link">Explore Service <i class="fas fa-arrow-right"></i></a>
        </div>
      </div>

      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
        <div class="service-card">
          <div class="service-icon-wrapper"><i class="fas fa-ring"></i></div>
          <h4 class="service-title">Divorce Law</h4>
          <p class="service-desc">Compassionate divorce attorneys guiding you through separation, asset division, and custody agreements.</p>
          <a href="services.html#divorce" class="service-link">Explore Service <i class="fas fa-arrow-right"></i></a>
        </div>
      </div>

      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="0">
        <div class="service-card">
          <div class="service-icon-wrapper"><i class="fas fa-heart"></i></div>
          <h4 class="service-title">Family Law</h4>
          <p class="service-desc">Protecting family bonds through adoption, guardianship, custody, and domestic relations expertise.</p>
          <a href="services.html#family" class="service-link">Explore Service <i class="fas fa-arrow-right"></i></a>
        </div>
      </div>

      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
        <div class="service-card">
          <div class="service-icon-wrapper"><i class="fas fa-house"></i></div>
          <h4 class="service-title">Property Law</h4>
          <p class="service-desc">Real estate attorneys handling purchases, disputes, title issues, and landlord-tenant conflicts.</p>
          <a href="services.html#property" class="service-link">Explore Service <i class="fas fa-arrow-right"></i></a>
        </div>
      </div>

      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
        <div class="service-card">
          <div class="service-icon-wrapper"><i class="fas fa-building"></i></div>
          <h4 class="service-title">Corporate Law</h4>
          <p class="service-desc">Top-tier corporate counsel for startups and enterprises — contracts, M&amp;A, and compliance solutions.</p>
          <a href="services.html#corporate" class="service-link">Explore Service <i class="fas fa-arrow-right"></i></a>
        </div>
      </div>

    </div>

    <div class="text-center mt-5" data-aos="fade-up">
      <a href="services.html" class="btn-gold">
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
        <a href="about.html" class="btn-gold">
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
<section class="cta-section" id="contact">
  <div class="container">
    <div class="row justify-content-center" data-aos="zoom-in">
      <div class="col-lg-7">
        <span class="section-badge">Get Started Today</span>
        <h2 class="cta-title">Ready for <span style="background:var(--gold-gradient);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">Expert</span> Legal Help?</h2>
        <p class="cta-subtitle">Join over 50,000 clients who found their ideal attorney on LexElite. Justice is just one click away.</p>
        <div class="d-flex flex-wrap justify-content-center gap-3">
          <a href="search.html" class="btn-gold">
            <i class="fas fa-search"></i> Find Your Lawyer
          </a>
          <a href="lawyer-login.html" class="btn-outline-gold">
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

<!-- ===================== FOOTER ===================== -->
<footer class="footer" id="footer">
  <div class="container">
    <div class="row g-5">

      <!-- Brand -->
      <div class="col-lg-4 col-md-6">
        <div class="footer-brand">
          <a class="navbar-brand-logo text-decoration-none" href="index.html" style="display:inline-flex;">
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
          <li><a href="index.html"><i class="fas fa-chevron-right"></i> Home</a></li>
          <li><a href="about.html"><i class="fas fa-chevron-right"></i> About Us</a></li>
          <li><a href="services.html"><i class="fas fa-chevron-right"></i> Services</a></li>
          <li><a href="search.html"><i class="fas fa-chevron-right"></i> Find Lawyer</a></li>
          <li><a href="#faq"><i class="fas fa-chevron-right"></i> FAQs</a></li>
          <li><a href="#contact"><i class="fas fa-chevron-right"></i> Contact</a></li>
        </ul>
      </div>

      <!-- Practice Areas -->
      <div class="col-lg-2 col-md-6 col-6">
        <h6 class="footer-heading">Practice Areas</h6>
        <ul class="footer-links">
          <li><a href="services.html#criminal"><i class="fas fa-chevron-right"></i> Criminal Law</a></li>
          <li><a href="services.html#civil"><i class="fas fa-chevron-right"></i> Civil Law</a></li>
          <li><a href="services.html#divorce"><i class="fas fa-chevron-right"></i> Divorce Law</a></li>
          <li><a href="services.html#family"><i class="fas fa-chevron-right"></i> Family Law</a></li>
          <li><a href="services.html#property"><i class="fas fa-chevron-right"></i> Property Law</a></li>
          <li><a href="services.html#corporate"><i class="fas fa-chevron-right"></i> Corporate Law</a></li>
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
      <p class="footer-bottom-text mb-0">© 2024 <a href="index.html">LexElite</a>. All rights reserved. Connecting clients with excellence.</p>
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

  // ----- SEARCH -----
  function performSearch() {
    const area = $('#practiceArea').val();
    const location = $('#locationInput').val();
    if (!area && !location) {
      $('#practiceArea').css('border-color','var(--gold)');
      setTimeout(() => $('#practiceArea').css('border-color',''), 1500);
      return;
    }
    window.location.href = `search.html?area=${encodeURIComponent(area || '')}&loc=${encodeURIComponent(location || '')}`;
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
