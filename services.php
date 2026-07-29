 <?php
include_once 'includes/connection.php';
include_once 'includes/header.php';



?>

<!-- ===================== SERVICES HERO ===================== -->
<section class="about-hero position-relative" style="padding-top:9rem; padding-bottom:5rem;">
  <div class="hero-bg-pattern"></div>
  <div class="hero-glow"></div>
  <div class="container position-relative" style="z-index:2;">
    <div class="row justify-content-center text-center">
      <div class="col-lg-8" data-aos="fade-up">
        <div class="breadcrumb-nav justify-content-center">
          <a href="index.php">Home</a>
          <span class="sep">/</span>
          <span class="current">Services</span>
        </div>
        <span class="section-badge">Practice Areas</span>
        <h1 class="page-hero-title">Comprehensive <span style="background:var(--gold-gradient);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">Legal Services</span></h1>
        <div class="gold-line center"></div>
        <p style="font-size:1.05rem; color:rgba(255,255,255,0.72); line-height:1.8; max-width:600px; margin:0 auto 2rem;">
          From criminal defense to corporate transactions — LexElite offers expert legal representation across every practice area, delivered by verified, elite attorneys.
        </p>
        <div class="d-flex justify-content-center flex-wrap gap-3">
          <a href="search.php" class="btn-gold"><i class="fas fa-search"></i> Find an Attorney</a>
          <a href="index.php#contact" class="btn-outline-gold"><i class="fas fa-phone"></i> Free Consultation</a>
        </div>
      </div>
    </div>
  </div>
  <div class="hero-accent-shape"></div>
</section>

<!-- ===================== FILTER TABS ===================== -->
<section class="section-dark" style="padding-top:3rem; padding-bottom:1rem;">
  <div class="container">
    <div class="service-tabs" data-aos="fade-up">
      <button class="service-tab-btn active" data-filter="all" onclick="filterServices('all', this)">
        <i class="fas fa-th-large"></i> All Services
      </button>
      <button class="service-tab-btn" data-filter="criminal" onclick="filterServices('criminal', this)">
        <i class="fas fa-gavel"></i> Criminal
      </button>
      <button class="service-tab-btn" data-filter="civil" onclick="filterServices('civil', this)">
        <i class="fas fa-scale-balanced"></i> Civil
      </button>
      <button class="service-tab-btn" data-filter="family" onclick="filterServices('family', this)">
        <i class="fas fa-heart"></i> Family
      </button>
      <button class="service-tab-btn" data-filter="property" onclick="filterServices('property', this)">
        <i class="fas fa-house"></i> Property
      </button>
      <button class="service-tab-btn" data-filter="corporate" onclick="filterServices('corporate', this)">
        <i class="fas fa-building"></i> Corporate
      </button>
    </div>
  </div>
</section>

<!-- ===================== SERVICE CARDS GRID ===================== -->
<section class="section-dark" style="padding-top:2rem;" id="all-services">
  <div class="container">
    <div class="row g-4" id="servicesGrid">

      <?php
      $query = "SELECT * FROM services";
      $result = mysqli_query($conn, $query);
      $delay = 0;

      if(mysqli_num_rows($result) > 0) {
          while($row = mysqli_fetch_assoc($result)) {
              $service_name = htmlspecialchars($row['service_name'] ?? '');
              $description = htmlspecialchars($row['description'] ?? '');
              $fee = htmlspecialchars($row['fee'] ?? '');
              $raw_icon = trim($row['icon'] ?? '');
              if (empty($raw_icon)) {
                  $s_lower = strtolower($service_name);
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
                  // Prepend 'fas ' if the prefix is missing
                  if (strpos($raw_icon, 'fas ') === false && strpos($raw_icon, 'fab ') === false && strpos($raw_icon, 'far ') === false) {
                      // Ensure it has fa- prefix
                      if (strpos($raw_icon, 'fa-') !== 0) {
                          $raw_icon = 'fa-' . $raw_icon;
                      }
                      $raw_icon = 'fas ' . $raw_icon;
                  }
                  $icon = htmlspecialchars($raw_icon);
              }
              $button_text = htmlspecialchars($row['button_text'] ?? 'Find Lawyer');
              
              // Fallback to ID if service_number is not set
              $service_number = isset($row['service_number']) ? htmlspecialchars($row['service_number']) : str_pad($row['service_id'] ?? '0', 2, '0', STR_PAD_LEFT);
              
              // Derive a simple category for the filter tabs (using the first word)
              $category = strtolower(explode(' ', trim($service_name))[0]);
              ?>
              <div class="col-lg-4 col-md-6 service-grid-item" data-category="<?php echo $category; ?>" id="service-<?php echo $row['service_id'] ?? ''; ?>" data-aos="fade-up" data-aos-delay="<?php echo $delay; ?>">
                <div class="flip-card-custom" style="height: 380px;">
                  
                  <!-- Background Pattern or large faint icon -->
                  <div style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%); opacity: 0.05; transition: all 0.6s ease;" class="service-bg-icon">
                    <i class="<?php echo $icon; ?>" style="font-size: 14rem; color: var(--gold);"></i>
                  </div>
                  
                  <!-- Overlay container -->
                  <div class="flip-card-overlay" style="background: linear-gradient(to top, rgba(13, 27, 42, 1) 0%, rgba(13, 27, 42, 0.8) 50%, rgba(13, 27, 42, 0.4) 100%); padding: 30px 20px;">
                    
                    <div class="text-center transition-icon" style="transition: all 0.4s ease; margin-bottom:15px;">
                        <i class="<?php echo $icon; ?>" style="font-size:3rem; color:var(--gold); text-shadow: 0 4px 15px rgba(201,168,76,0.3);"></i>
                    </div>
                    <h3 class="flip-card-name" style="font-size:1.3rem;"><?php echo $service_name; ?></h3>
                    
                    <!-- The "View Details" hint button (visible by default, hides on hover) -->
                    <div class="view-details-btn-static btn-outline-gold" style="padding:6px 15px; font-size:0.75rem; display:inline-block; margin-top:15px;">View Details</div>
                    
                    <!-- The hidden content that appears on hover -->
                    <div class="flip-card-content">
                      <p style="color:rgba(255,255,255,0.8); font-size:0.85rem; line-height:1.5; margin-bottom:15px;"><?php echo $description; ?></p>
                      
                      <div class="mb-4 text-center" style="font-size:0.85rem; color:var(--gold); font-weight: 600;">
                         Consultation Fee: PKR <?php echo $fee; ?>
                      </div>

                      <div class="d-flex flex-column gap-2 w-100">
                        <a href="search.php?area=<?php echo urlencode($service_name); ?>" class="btn-gold flex-fill d-inline-flex justify-content-center align-items-center" style="padding:10px 0; font-size:0.8rem;">
                          <i class="fas fa-search me-2"></i> <?php echo $button_text; ?>
                        </a>
                        <a href="index.php#contact" class="btn-outline-gold flex-fill d-inline-flex justify-content-center align-items-center" style="padding:10px 0; font-size:0.8rem;">
                          <i class="fas fa-phone me-2"></i> Free Consultation
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <?php
              $delay += 100;
              if($delay > 200) $delay = 0;
          }
      } else {
          echo '<div class="col-12 text-center py-5"><h4 style="color:var(--white);">No services available.</h4></div>';
      }
      ?>

    </div>
  </div>
</section>

<!-- ===================== HOW OUR SERVICES WORK ===================== -->
<section class="section-darker">
  <div class="container">
    <div class="row align-items-center gy-5">

      <div class="col-lg-5" data-aos="fade-right">
        <span class="section-badge">Our Process</span>
        <h2 class="section-title">How Our Legal <span class="text-gold">Services Work</span></h2>
        <div class="gold-line"></div>
        <p class="section-subtitle mb-4">A streamlined, transparent process from first contact to case resolution. No confusion, no surprises.</p>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-top:2rem;">
          <div style="text-align:center; padding:1.5rem; background:rgba(201,168,76,0.06); border:1px solid rgba(201,168,76,0.15); border-radius:12px;">
            <div style="font-family:var(--font-serif); font-size:2rem; font-weight:800; color:var(--gold);">15 min</div>
            <div style="font-size:0.72rem; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.1em;">Avg. Match Time</div>
          </div>
          <div style="text-align:center; padding:1.5rem; background:rgba(201,168,76,0.06); border:1px solid rgba(201,168,76,0.15); border-radius:12px;">
            <div style="font-family:var(--font-serif); font-size:2rem; font-weight:800; color:var(--gold);">100%</div>
            <div style="font-size:0.72rem; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.1em;">Verified Attorneys</div>
          </div>
          <div style="text-align:center; padding:1.5rem; background:rgba(201,168,76,0.06); border:1px solid rgba(201,168,76,0.15); border-radius:12px;">
            <div style="font-family:var(--font-serif); font-size:2rem; font-weight:800; color:var(--gold);">Free</div>
            <div style="font-size:0.72rem; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.1em;">First Consultation</div>
          </div>
          <div style="text-align:center; padding:1.5rem; background:rgba(201,168,76,0.06); border:1px solid rgba(201,168,76,0.15); border-radius:12px;">
            <div style="font-family:var(--font-serif); font-size:2rem; font-weight:800; color:var(--gold);">24/7</div>
            <div style="font-size:0.72rem; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.1em;">Emergency Access</div>
          </div>
        </div>
      </div>

      <div class="col-lg-7" data-aos="fade-left">
        <div class="service-process">
          <div class="process-step">
            <div class="process-num">1</div>
            <div>
              <div class="process-label">Tell Us Your Legal Issue</div>
              <div class="process-desc">Use our intelligent search system to describe your legal situation. Select your practice area, location, and urgency level so we can match you with the right specialist.</div>
            </div>
          </div>
          <div class="process-step">
            <div class="process-num">2</div>
            <div>
              <div class="process-label">Review Matched Attorneys</div>
              <div class="process-desc">Our AI surfaces the top 3-5 attorneys perfectly suited for your case. Review their credentials, success rates, client reviews, and fees to make an informed choice.</div>
            </div>
          </div>
          <div class="process-step">
            <div class="process-num">3</div>
            <div>
              <div class="process-label">Schedule Your Free Consultation</div>
              <div class="process-desc">Book a free 30-minute consultation at your convenience — video call, phone, or in-person. Discuss your case, ask questions, and evaluate the attorney's approach.</div>
            </div>
          </div>
          <div class="process-step">
            <div class="process-num">4</div>
            <div>
              <div class="process-label">Engage & Sign Securely</div>
              <div class="process-desc">Once you select your attorney, sign your engagement agreement digitally through our secure platform. All fees and terms are fully transparent before you commit.</div>
            </div>
          </div>
          <div class="process-step">
            <div class="process-num">5</div>
            <div>
              <div class="process-label">Your Attorney Goes to Work</div>
              <div class="process-desc">Your attorney builds your case strategy, keeps you informed with regular updates, and fights for the best possible outcome — every step of the way.</div>
            </div>
          </div>
          <div class="mt-3">
            <a href="search.php" class="btn-gold"><i class="fas fa-play-circle"></i> Start Your Journey</a>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ===================== INDUSTRY EXPERTISE ===================== -->
<section class="section-dark">
  <div class="container">
    <div class="row justify-content-center mb-5" data-aos="fade-up">
      <div class="col-lg-6 text-center">
        <span class="section-badge">Industry Expertise</span>
        <h2 class="section-title">Specialized Legal Help for <span class="text-gold">Every Industry</span></h2>
        <div class="gold-line center"></div>
      </div>
    </div>

    <div class="row g-3">
      <div class="col-lg-3 col-md-4 col-6" data-aos="fade-up" data-aos-delay="0">
        <div class="service-card" style="padding:1.5rem; text-align:center;">
          <div class="service-icon-wrapper" style="margin:0 auto 1rem;"><i class="fas fa-hospital"></i></div>
          <h6 class="service-title" style="font-size:0.9rem;">Healthcare</h6>
        </div>
      </div>
      <div class="col-lg-3 col-md-4 col-6" data-aos="fade-up" data-aos-delay="50">
        <div class="service-card" style="padding:1.5rem; text-align:center;">
          <div class="service-icon-wrapper" style="margin:0 auto 1rem;"><i class="fas fa-microchip"></i></div>
          <h6 class="service-title" style="font-size:0.9rem;">Technology</h6>
        </div>
      </div>
      <div class="col-lg-3 col-md-4 col-6" data-aos="fade-up" data-aos-delay="100">
        <div class="service-card" style="padding:1.5rem; text-align:center;">
          <div class="service-icon-wrapper" style="margin:0 auto 1rem;"><i class="fas fa-coins"></i></div>
          <h6 class="service-title" style="font-size:0.9rem;">Finance</h6>
        </div>
      </div>
      <div class="col-lg-3 col-md-4 col-6" data-aos="fade-up" data-aos-delay="150">
        <div class="service-card" style="padding:1.5rem; text-align:center;">
          <div class="service-icon-wrapper" style="margin:0 auto 1rem;"><i class="fas fa-city"></i></div>
          <h6 class="service-title" style="font-size:0.9rem;">Real Estate</h6>
        </div>
      </div>
      <div class="col-lg-3 col-md-4 col-6" data-aos="fade-up" data-aos-delay="0">
        <div class="service-card" style="padding:1.5rem; text-align:center;">
          <div class="service-icon-wrapper" style="margin:0 auto 1rem;"><i class="fas fa-truck"></i></div>
          <h6 class="service-title" style="font-size:0.9rem;">Logistics</h6>
        </div>
      </div>
      <div class="col-lg-3 col-md-4 col-6" data-aos="fade-up" data-aos-delay="50">
        <div class="service-card" style="padding:1.5rem; text-align:center;">
          <div class="service-icon-wrapper" style="margin:0 auto 1rem;"><i class="fas fa-graduation-cap"></i></div>
          <h6 class="service-title" style="font-size:0.9rem;">Education</h6>
        </div>
      </div>
      <div class="col-lg-3 col-md-4 col-6" data-aos="fade-up" data-aos-delay="100">
        <div class="service-card" style="padding:1.5rem; text-align:center;">
          <div class="service-icon-wrapper" style="margin:0 auto 1rem;"><i class="fas fa-leaf"></i></div>
          <h6 class="service-title" style="font-size:0.9rem;">Environment</h6>
        </div>
      </div>
      <div class="col-lg-3 col-md-4 col-6" data-aos="fade-up" data-aos-delay="150">
        <div class="service-card" style="padding:1.5rem; text-align:center;">
          <div class="service-icon-wrapper" style="margin:0 auto 1rem;"><i class="fas fa-store"></i></div>
          <h6 class="service-title" style="font-size:0.9rem;">Retail & SME</h6>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ===================== SERVICES FAQ ===================== -->
<section class="section-darker" id="services-faq">
  <div class="container">
    <div class="row justify-content-center mb-5" data-aos="fade-up">
      <div class="col-lg-6 text-center">
        <span class="section-badge">Common Questions</span>
        <h2 class="section-title">Service <span class="text-gold">FAQs</span></h2>
        <div class="gold-line center"></div>
      </div>
    </div>

    <div class="services-faq" data-aos="fade-up">

      <div class="faq-item active">
        <div class="faq-question" onclick="toggleFaq(this)">
          <span class="faq-q-text">How much do legal services on LexElite cost?</span>
          <div class="faq-toggle"><i class="fas fa-plus"></i></div>
        </div>
        <div class="faq-answer">Costs vary by attorney, practice area, and case complexity. Each attorney's profile clearly lists their fee structure — whether hourly, flat-fee, or contingency. The initial consultation is free for most of our attorneys. We ensure full fee transparency before you commit.</div>
      </div>

      <div class="faq-item">
        <div class="faq-question" onclick="toggleFaq(this)">
          <span class="faq-q-text">Can I switch attorneys if my case needs change?</span>
          <div class="faq-toggle"><i class="fas fa-plus"></i></div>
        </div>
        <div class="faq-answer">Absolutely. You have full flexibility to work with different attorneys for different legal matters. If your needs evolve during a case, we can help you find additional specialists or transition to a more appropriate attorney with minimal disruption.</div>
      </div>

      <div class="faq-item">
        <div class="faq-question" onclick="toggleFaq(this)">
          <span class="faq-q-text">Are LexElite attorneys licensed in my state?</span>
          <div class="faq-toggle"><i class="fas fa-plus"></i></div>
        </div>
        <div class="faq-answer">Yes. Every attorney on our platform is verified to be licensed and in good standing in the state(s) where they practice. Our search system automatically filters attorneys who are authorized to practice law in your jurisdiction.</div>
      </div>

      <div class="faq-item">
        <div class="faq-question" onclick="toggleFaq(this)">
          <span class="faq-q-text">What happens if I have an urgent legal emergency?</span>
          <div class="faq-toggle"><i class="fas fa-plus"></i></div>
        </div>
        <div class="faq-answer">We maintain a 24/7 emergency legal hotline with attorneys available around the clock for urgent matters. Use the emergency flag when searching to be connected with an available attorney within 15 minutes, day or night.</div>
      </div>

      <div class="faq-item">
        <div class="faq-question" onclick="toggleFaq(this)">
          <span class="faq-q-text">Do you offer services for businesses and corporations?</span>
          <div class="faq-toggle"><i class="fas fa-plus"></i></div>
        </div>
        <div class="faq-answer">Yes! LexElite serves both individuals and organizations. We offer a dedicated Business Plan with access to corporate lawyers, bulk consultation packages, priority matching, and dedicated account management for businesses of all sizes.</div>
      </div>

    </div>
  </div>
</section>

<!-- ===================== CTA ===================== -->
<section class="cta-section">
  <div class="container">
    <div class="row justify-content-center" data-aos="zoom-in">
      <div class="col-lg-7 text-center">
        <span class="section-badge">Your Legal Journey Starts Here</span>
        <h2 class="cta-title">Get <span style="background:var(--gold-gradient);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">Expert Legal Help</span> Today</h2>
        <p class="cta-subtitle">Don't face your legal challenges alone. Our elite attorneys are ready to fight for you — starting with a free consultation.</p>
        <div class="d-flex flex-wrap justify-content-center gap-3 mb-4">
          <a href="search.php" class="btn-gold"><i class="fas fa-search"></i> Find Your Lawyer</a>
          <a href="index.php#contact" class="btn-outline-gold"><i class="fas fa-phone"></i> Call Us Free</a>
        </div>
        <p style="font-size:0.78rem; color:rgba(255,255,255,0.45);">
          <i class="fas fa-lock" style="color:var(--gold); margin-right:5px;"></i>
          All consultations are fully confidential and protected by attorney-client privilege.
        </p>
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
        <p class="footer-about">LexElite is a premier legal marketplace connecting clients with the nation's most experienced and trusted attorneys across all practice areas.</p>
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
          <li><a href="index.php#faq"><i class="fas fa-chevron-right"></i> FAQs</a></li>
        </ul>
      </div>
      <div class="col-lg-2 col-md-6 col-6">
        <h6 class="footer-heading">Practice Areas</h6>
        <ul class="footer-links">
          <li><a href="#criminal"><i class="fas fa-chevron-right"></i> Criminal Law</a></li>
          <li><a href="#civil"><i class="fas fa-chevron-right"></i> Civil Law</a></li>
          <li><a href="#divorce"><i class="fas fa-chevron-right"></i> Divorce Law</a></li>
          <li><a href="#family"><i class="fas fa-chevron-right"></i> Family Law</a></li>
          <li><a href="#property"><i class="fas fa-chevron-right"></i> Property Law</a></li>
          <li><a href="#corporate"><i class="fas fa-chevron-right"></i> Corporate Law</a></li>
          <li><a href="#affidavit"><i class="fas fa-chevron-right"></i> Affidavit</a></li>
        </ul>
      </div>
      <div class="col-lg-4 col-md-6">
        <h6 class="footer-heading">Contact Us</h6>
        <div class="footer-contact-item">
          <div class="footer-contact-icon"><i class="fas fa-map-marker-alt"></i></div>
          <div class="footer-contact-text">350 Fifth Avenue, Suite 4100<br>New York, NY 10118, USA</div>
        </div>
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
          <div class="footer-contact-text">Emergency: 24/7</div>
        </div>
      </div>
    </div>
  </div>
  <div class="footer-bottom">
    <div class="container d-flex justify-content-between align-items-center flex-wrap gap-2">
      <p class="footer-bottom-text mb-0">© 2024 <a href="index.php">LexElite</a>. All rights reserved.</p>
      <div class="d-flex gap-3">
        <a href="#" style="font-size:0.78rem; color:var(--text-muted);">Privacy Policy</a>
        <a href="#" style="font-size:0.78rem; color:var(--text-muted);">Terms of Service</a>
      </div>
    </div>
  </div>
</footer>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>

  AOS.init({ duration: 800, easing: 'ease-out-cubic', once: true, offset: 60 });

  $(window).on('scroll', function () {
    if ($(this).scrollTop() > 80) $('#mainNavbar').addClass('scrolled');
  });

  // ----- SERVICE FILTER -----
  function filterServices(category, btn) {
    // Update active button
    $('.service-tab-btn').removeClass('active');
    $(btn).addClass('active');

    const $items = $('.service-grid-item');

    if (category === 'all') {
      $items.each(function(i) {
        const $el = $(this);
        setTimeout(function() {
          $el.fadeIn(300);
        }, i * 60);
      });
    } else {
      $items.each(function() {
        const $el = $(this);
        if ($el.data('category') === category) {
          $el.fadeIn(300);
        } else {
          $el.fadeOut(200);
        }
      });
    }
  }

  // ----- FAQ TOGGLE -----
  function toggleFaq(el) {
    const item = $(el).closest('.faq-item');
    const isActive = item.hasClass('active');
    $('.faq-item').removeClass('active').find('.faq-answer').slideUp(250);
    if (!isActive) {
      item.addClass('active').find('.faq-answer').slideDown(280);
    }
  }

  // ----- SMOOTH ANCHOR -----
  $('a[href^="#"]').on('click', function (e) {
    const target = $(this.getAttribute('href'));
    if (target.length) {
      e.preventDefault();
      $('html, body').animate({ scrollTop: target.offset().top - 80 }, 700);
    }
  });

  // ----- HASH NAVIGATION -----
  $(document).ready(function () {
    const hash = window.location.hash;
    if (hash) {
      setTimeout(function () {
        const target = $(hash);
        if (target.length) {
          $('html, body').animate({ scrollTop: target.offset().top - 90 }, 800);
          // Highlight the card briefly
          target.find('.service-page-card').css({
            'border-color': 'var(--gold)',
            'box-shadow': '0 0 30px rgba(201,168,76,0.3)'
          });
          setTimeout(() => {
            target.find('.service-page-card').css({
              'border-color': '',
              'box-shadow': ''
            });
          }, 2000);
        }
      }, 400);
    }
  });

</script>
</body>
</html>
