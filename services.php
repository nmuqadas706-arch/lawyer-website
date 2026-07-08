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

      <!-- 1. CRIMINAL LAW -->
      <div class="col-lg-4 col-md-6 service-grid-item" data-category="criminal" id="criminal" data-aos="fade-up" data-aos-delay="0">
        <div class="service-page-card">
          <div class="service-num-overlay">01</div>
          <div class="service-page-icon"><i class="fas fa-gavel"></i></div>
          <h3 class="service-page-title">Criminal Law</h3>
          <p class="service-page-desc">Our elite criminal defense attorneys bring unmatched courtroom experience to protect your freedom, rights, and future. From misdemeanor charges to complex federal cases, we fight with precision and tenacity.</p>
          <ul class="service-features">
            <li><i class="fas fa-check-circle"></i> DUI & DWI Defense</li>
            <li><i class="fas fa-check-circle"></i> Drug Charges & Trafficking</li>
            <li><i class="fas fa-check-circle"></i> Assault & Battery Defense</li>
            <li><i class="fas fa-check-circle"></i> White-Collar Crime</li>
            <li><i class="fas fa-check-circle"></i> Federal Criminal Defense</li>
            <li><i class="fas fa-check-circle"></i> Appeals & Post-Conviction</li>
          </ul>
          <a href="search.php?area=Criminal+Law" class="btn-gold" style="width:100%; justify-content:center; margin-bottom:12px;">
            <i class="fas fa-search"></i> Find Criminal Lawyer
          </a>
          <a href="index.php#contact" class="btn-outline-gold" style="width:100%; justify-content:center; font-size:0.78rem;">
            <i class="fas fa-phone"></i> Free Consultation
          </a>
        </div>
      </div>

      <!-- 2. CIVIL LAW -->
      <div class="col-lg-4 col-md-6 service-grid-item" data-category="civil" id="civil" data-aos="fade-up" data-aos-delay="100">
        <div class="service-page-card">
          <div class="service-num-overlay">02</div>
          <div class="service-page-icon"><i class="fas fa-scale-balanced"></i></div>
          <h3 class="service-page-title">Civil Law</h3>
          <p class="service-page-desc">Navigate complex civil disputes with our seasoned litigators who expertly handle contract breaches, personal injury claims, and employment disputes with strategic precision and winning results.</p>
          <ul class="service-features">
            <li><i class="fas fa-check-circle"></i> Contract Disputes & Breach</li>
            <li><i class="fas fa-check-circle"></i> Personal Injury Claims</li>
            <li><i class="fas fa-check-circle"></i> Employment Discrimination</li>
            <li><i class="fas fa-check-circle"></i> Defamation & Libel</li>
            <li><i class="fas fa-check-circle"></i> Medical Malpractice</li>
            <li><i class="fas fa-check-circle"></i> Civil Rights Violations</li>
          </ul>
          <a href="search.php?area=Civil+Law" class="btn-gold" style="width:100%; justify-content:center; margin-bottom:12px;">
            <i class="fas fa-search"></i> Find Civil Lawyer
          </a>
          <a href="index.php#contact" class="btn-outline-gold" style="width:100%; justify-content:center; font-size:0.78rem;">
            <i class="fas fa-phone"></i> Free Consultation
          </a>
        </div>
      </div>

      <!-- 3. DIVORCE LAW -->
      <div class="col-lg-4 col-md-6 service-grid-item" data-category="family" id="divorce" data-aos="fade-up" data-aos-delay="200">
        <div class="service-page-card">
          <div class="service-num-overlay">03</div>
          <div class="service-page-icon"><i class="fas fa-ring"></i></div>
          <h3 class="service-page-title">Divorce Law</h3>
          <p class="service-page-desc">Our compassionate divorce attorneys guide you through one of life's most challenging transitions with sensitivity and strength — protecting your assets, parental rights, and emotional well-being.</p>
          <ul class="service-features">
            <li><i class="fas fa-check-circle"></i> Contested & Uncontested Divorce</li>
            <li><i class="fas fa-check-circle"></i> Asset Division & Valuation</li>
            <li><i class="fas fa-check-circle"></i> Spousal Support / Alimony</li>
            <li><i class="fas fa-check-circle"></i> Child Custody & Visitation</li>
            <li><i class="fas fa-check-circle"></i> High-Net-Worth Divorce</li>
            <li><i class="fas fa-check-circle"></i> Collaborative Divorce</li>
          </ul>
          <a href="search.php?area=Divorce+Law" class="btn-gold" style="width:100%; justify-content:center; margin-bottom:12px;">
            <i class="fas fa-search"></i> Find Divorce Lawyer
          </a>
          <a href="index.php#contact" class="btn-outline-gold" style="width:100%; justify-content:center; font-size:0.78rem;">
            <i class="fas fa-phone"></i> Free Consultation
          </a>
        </div>
      </div>

      <!-- 4. FAMILY LAW -->
      <div class="col-lg-4 col-md-6 service-grid-item" data-category="family" id="family" data-aos="fade-up" data-aos-delay="0">
        <div class="service-page-card">
          <div class="service-num-overlay">04</div>
          <div class="service-page-icon"><i class="fas fa-heart"></i></div>
          <h3 class="service-page-title">Family Law</h3>
          <p class="service-page-desc">Protecting family bonds and resolving domestic matters with empathy and expertise. Our family law attorneys handle sensitive cases with discretion, ensuring the best outcomes for all family members, especially children.</p>
          <ul class="service-features">
            <li><i class="fas fa-check-circle"></i> Child Custody & Support</li>
            <li><i class="fas fa-check-circle"></i> Adoption & Guardianship</li>
            <li><i class="fas fa-check-circle"></i> Domestic Violence Protection</li>
            <li><i class="fas fa-check-circle"></i> Prenuptial Agreements</li>
            <li><i class="fas fa-check-circle"></i> Paternity Matters</li>
            <li><i class="fas fa-check-circle"></i> Grandparents' Rights</li>
          </ul>
          <a href="search.php?area=Family+Law" class="btn-gold" style="width:100%; justify-content:center; margin-bottom:12px;">
            <i class="fas fa-search"></i> Find Family Lawyer
          </a>
          <a href="index.php#contact" class="btn-outline-gold" style="width:100%; justify-content:center; font-size:0.78rem;">
            <i class="fas fa-phone"></i> Free Consultation
          </a>
        </div>
      </div>

      <!-- 5. PROPERTY LAW -->
      <div class="col-lg-4 col-md-6 service-grid-item" data-category="property" id="property" data-aos="fade-up" data-aos-delay="100">
        <div class="service-page-card">
          <div class="service-num-overlay">05</div>
          <div class="service-page-icon"><i class="fas fa-house"></i></div>
          <h3 class="service-page-title">Property Law</h3>
          <p class="service-page-desc">Your property rights are paramount. Our real estate attorneys handle every aspect of property law — from seamless transactions to complex title disputes — ensuring your real estate interests are fully protected.</p>
          <ul class="service-features">
            <li><i class="fas fa-check-circle"></i> Real Estate Transactions</li>
            <li><i class="fas fa-check-circle"></i> Title Search & Disputes</li>
            <li><i class="fas fa-check-circle"></i> Landlord-Tenant Disputes</li>
            <li><i class="fas fa-check-circle"></i> Property Boundary Conflicts</li>
            <li><i class="fas fa-check-circle"></i> Foreclosure Defense</li>
            <li><i class="fas fa-check-circle"></i> Easements & Rights-of-Way</li>
          </ul>
          <a href="search.php?area=Property+Law" class="btn-gold" style="width:100%; justify-content:center; margin-bottom:12px;">
            <i class="fas fa-search"></i> Find Property Lawyer
          </a>
          <a href="index.php#contact" class="btn-outline-gold" style="width:100%; justify-content:center; font-size:0.78rem;">
            <i class="fas fa-phone"></i> Free Consultation
          </a>
        </div>
      </div>

      <!-- 6. AFFIDAVIT -->
      <div class="col-lg-4 col-md-6 service-grid-item" data-category="civil" id="affidavit" data-aos="fade-up" data-aos-delay="200">
        <div class="service-page-card">
          <div class="service-num-overlay">06</div>
          <div class="service-page-icon"><i class="fas fa-file-signature"></i></div>
          <h3 class="service-page-title">Affidavit Services</h3>
          <p class="service-page-desc">Fast, accurate, and legally compliant affidavit drafting and notarization. Our attorneys ensure every sworn statement is properly prepared, witnessed, and filed — giving you complete legal protection and peace of mind.</p>
          <ul class="service-features">
            <li><i class="fas fa-check-circle"></i> General Affidavit Drafting</li>
            <li><i class="fas fa-check-circle"></i> Financial Affidavits</li>
            <li><i class="fas fa-check-circle"></i> Identity Affidavits</li>
            <li><i class="fas fa-check-circle"></i> Notary Services</li>
            <li><i class="fas fa-check-circle"></i> Affidavit of Support</li>
            <li><i class="fas fa-check-circle"></i> Court-Filing Assistance</li>
          </ul>
          <a href="search.php?area=Affidavit" class="btn-gold" style="width:100%; justify-content:center; margin-bottom:12px;">
            <i class="fas fa-search"></i> Find Affidavit Lawyer
          </a>
          <a href="index.php#contact" class="btn-outline-gold" style="width:100%; justify-content:center; font-size:0.78rem;">
            <i class="fas fa-phone"></i> Free Consultation
          </a>
        </div>
      </div>

      <!-- 7. CORPORATE LAW -->
      <div class="col-lg-4 col-md-6 service-grid-item" data-category="corporate" id="corporate" data-aos="fade-up" data-aos-delay="0">
        <div class="service-page-card">
          <div class="service-num-overlay">07</div>
          <div class="service-page-icon"><i class="fas fa-building"></i></div>
          <h3 class="service-page-title">Corporate Law</h3>
          <p class="service-page-desc">Power your business with world-class corporate legal counsel. Our attorneys advise leading companies on strategic transactions, regulatory compliance, and risk management — from startup to Fortune 500.</p>
          <ul class="service-features">
            <li><i class="fas fa-check-circle"></i> Business Formation & Structure</li>
            <li><i class="fas fa-check-circle"></i> Mergers & Acquisitions</li>
            <li><i class="fas fa-check-circle"></i> Corporate Governance</li>
            <li><i class="fas fa-check-circle"></i> Commercial Contracts</li>
            <li><i class="fas fa-check-circle"></i> Intellectual Property</li>
            <li><i class="fas fa-check-circle"></i> Securities & Compliance</li>
          </ul>
          <a href="search.php?area=Corporate+Law" class="btn-gold" style="width:100%; justify-content:center; margin-bottom:12px;">
            <i class="fas fa-search"></i> Find Corporate Lawyer
          </a>
          <a href="index.php#contact" class="btn-outline-gold" style="width:100%; justify-content:center; font-size:0.78rem;">
            <i class="fas fa-phone"></i> Free Consultation
          </a>
        </div>
      </div>

      <!-- 8. IMMIGRATION (BONUS) -->
      <div class="col-lg-4 col-md-6 service-grid-item" data-category="civil" data-aos="fade-up" data-aos-delay="100">
        <div class="service-page-card">
          <div class="service-num-overlay">08</div>
          <div class="service-page-icon"><i class="fas fa-globe-americas"></i></div>
          <h3 class="service-page-title">Immigration Law</h3>
          <p class="service-page-desc">Navigate the complexities of U.S. immigration with expert guidance. Our immigration attorneys handle visas, green cards, citizenship, deportation defense, and asylum claims with proven success rates.</p>
          <ul class="service-features">
            <li><i class="fas fa-check-circle"></i> Visa Applications & Extensions</li>
            <li><i class="fas fa-check-circle"></i> Green Card Petitions</li>
            <li><i class="fas fa-check-circle"></i> Citizenship & Naturalization</li>
            <li><i class="fas fa-check-circle"></i> Deportation Defense</li>
            <li><i class="fas fa-check-circle"></i> Asylum Applications</li>
            <li><i class="fas fa-check-circle"></i> DACA & TPS</li>
          </ul>
          <a href="search.php?area=Immigration+Law" class="btn-gold" style="width:100%; justify-content:center; margin-bottom:12px;">
            <i class="fas fa-search"></i> Find Immigration Lawyer
          </a>
          <a href="index.php#contact" class="btn-outline-gold" style="width:100%; justify-content:center; font-size:0.78rem;">
            <i class="fas fa-phone"></i> Free Consultation
          </a>
        </div>
      </div>

      <!-- 9. ESTATE PLANNING (BONUS) -->
      <div class="col-lg-4 col-md-6 service-grid-item" data-category="civil" data-aos="fade-up" data-aos-delay="200">
        <div class="service-page-card">
          <div class="service-num-overlay">09</div>
          <div class="service-page-icon"><i class="fas fa-scroll"></i></div>
          <h3 class="service-page-title">Estate Planning</h3>
          <p class="service-page-desc">Secure your legacy and protect your loved ones with comprehensive estate planning. Our attorneys craft ironclad wills, trusts, and powers of attorney tailored to your unique financial and family situation.</p>
          <ul class="service-features">
            <li><i class="fas fa-check-circle"></i> Wills & Testament Drafting</li>
            <li><i class="fas fa-check-circle"></i> Living Trusts & Revocable Trusts</li>
            <li><i class="fas fa-check-circle"></i> Power of Attorney</li>
            <li><i class="fas fa-check-circle"></i> Probate Administration</li>
            <li><i class="fas fa-check-circle"></i> Estate Tax Planning</li>
            <li><i class="fas fa-check-circle"></i> Healthcare Directives</li>
          </ul>
          <a href="search.php?area=Estate+Planning" class="btn-gold" style="width:100%; justify-content:center; margin-bottom:12px;">
            <i class="fas fa-search"></i> Find Estate Lawyer
          </a>
          <a href="index.php#contact" class="btn-outline-gold" style="width:100%; justify-content:center; font-size:0.78rem;">
            <i class="fas fa-phone"></i> Free Consultation
          </a>
        </div>
      </div>

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
