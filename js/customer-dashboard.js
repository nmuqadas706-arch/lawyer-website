/**
 * customer-dashboard.js
 * JavaScript logic for LexElite Client Portal
 * Completely frontend-driven using localStorage for state management.
 * Defensive coding for localStorage schema safety
 */

// ─── LOCAL STORAGE KEYS ───
const APPOINTMENTS_KEY = 'lexelite_appointments';
const PROFILE_KEY = 'lexelite_user_profile';
const LAWYERS_KEY = 'lexelite_lawyers';

// ─── INITIAL SYSTEM SEEDING ───
function seedInitialData() {
  // 1. Initial User Profile
  if (!localStorage.getItem(PROFILE_KEY)) {
    const defaultProfile = {
      name: 'Eleanor Vance',
      email: 'eleanor.vance@luxury.com',
      phone: '+1 (555) 789-2424',
      avatar: '',
      tier: 'Premium Client',
      language: 'English',
      preference: 'Video Call'
    };
    localStorage.setItem(PROFILE_KEY, JSON.stringify(defaultProfile));
  }

  // 2. Initial Client Appointments
  if (!localStorage.getItem(APPOINTMENTS_KEY)) {
    const defaultAppointments = [
      {
        id: 'APT-9041',
        lawyerId: 2,
        lawyerName: 'Dr. Marcus Chen',
        specialization: 'Corporate Law',
        date: '2026-07-08',
        time: '10:00 AM',
        fee: 500,
        status: 'confirmed',
        brief: 'Consultation for Series-A investment documentation and IP licensing clauses.',
        paymentMethod: 'Visa ending in 9012'
      },
      {
        id: 'APT-9042',
        lawyerId: 5,
        lawyerName: 'Elena Vasquez',
        specialization: 'Immigration',
        date: '2026-07-07',
        time: '01:00 PM',
        fee: 250,
        status: 'pending',
        brief: 'Spousal visa application process and document checklists for permanent residency.',
        paymentMethod: 'Mastercard ending in 4118'
      },
      {
        id: 'APT-9043',
        lawyerId: 1,
        lawyerName: 'Alexandra Harrington',
        specialization: 'Criminal Law',
        date: '2026-06-25',
        time: '02:00 PM',
        fee: 350,
        status: 'completed',
        brief: 'Advisory on a business compliance regulatory concern and minor municipal citation.',
        paymentMethod: 'Visa ending in 9012'
      },
      {
        id: 'APT-9044',
        lawyerId: 7,
        lawyerName: 'Zara Okonkwo',
        specialization: 'Affidavit',
        date: '2026-06-12',
        time: '11:00 AM',
        fee: 180,
        status: 'cancelled',
        brief: 'Urgent drafting and remote notarization of residential tenancy affidavit.',
        paymentMethod: 'Amex ending in 0005'
      }
    ];
    localStorage.setItem(APPOINTMENTS_KEY, JSON.stringify(defaultAppointments));
  }

  // 3. Initial Lawyers Database (if not present)
  if (!localStorage.getItem(LAWYERS_KEY)) {
    localStorage.setItem(LAWYERS_KEY, JSON.stringify(LAWYERS));
  }
}

// ─── STATE LOADERS ───
function getProfile() {
  return JSON.parse(localStorage.getItem(PROFILE_KEY));
}

// Save profile details
function saveProfile(profile) {
  localStorage.setItem(PROFILE_KEY, JSON.stringify(profile));
}

function getAppointments() {
  return JSON.parse(localStorage.getItem(APPOINTMENTS_KEY)) || [];
}

function saveAppointments(appts) {
  localStorage.setItem(APPOINTMENTS_KEY, JSON.stringify(appts));
}

function getLawyers() {
  // In case the admin suspended some lawyers, read them from localStorage
  const localL = localStorage.getItem(LAWYERS_KEY);
  return localL ? JSON.parse(localL) : LAWYERS;
}

// ─── GLOBAL UTILITIES ───
let selectedBookingLawyer = null;
let selectedBookingDate = null;
let selectedBookingTime = null;
let currentViewingAppointmentId = null;

function showToast(msg) {
  $('#toastMsg').text(msg);
  $('#toastBox').fadeIn(300);
  setTimeout(() => $('#toastBox').fadeOut(400), 2500);
}

// ─── PAGE ROUTING / TAB SWITCHER ───
function switchTab(tabId, menuItem) {
  $('.menu-item').removeClass('active');
  if (menuItem) {
    $(menuItem).addClass('active');
  } else {
    // Sync active state in sidebar menu if navigation was code-triggered
    $(`.sidebar-menu .menu-item[onclick*="'${tabId}'"]`).addClass('active');
  }

  // Show correct panel section
  $('.panel-section').removeClass('active');
  $(`#panel-${tabId}`).addClass('active');

  // Set Panel Title
  let title = 'Dashboard';
  switch (tabId) {
    case 'dashboard': title = 'Dashboard Overview'; break;
    case 'search-lawyers': title = 'Search Legal Consultants'; break;
    case 'appointments': title = 'My Consultations Tracker'; break;
    case 'appointment-details': title = 'Consultation Details Room'; break;
    case 'profile-settings': title = 'Account Settings'; break;
  }
  $('#panelHeaderTitle').text(title);

  // Close responsive sidebars
  $('#dashSidebar').removeClass('open');
  $('#sidebarOverlay').removeClass('open');

  // Trigger tab-specific loaders
  if (tabId === 'dashboard') loadDashboardOverview();
  if (tabId === 'search-lawyers') loadSearchLawyers();
  if (tabId === 'appointments') loadAppointmentsList();
}

function toggleSidebar() {
  $('#dashSidebar').toggleClass('open');
  $('#sidebarOverlay').toggleClass('open');
}

// ─── RENDERERS ───

// Sidebar & Header Profiles
function syncProfileHeader() {
  const profile = getProfile();
  if (!profile) return;

  $('#clientSideName').text(profile.name);
  $('#clientSideEmail').text(profile.email);
  $('#clientWelcomeName').text(`Welcome back, ${profile.name}`);

  // Avatar loaders
  const avatarHtml = profile.avatar
    ? `<img src="${profile.avatar}" style="width:100%; height:100%; object-fit:cover;">`
    : profile.name.split(' ').map(n => n[0]).join('').toUpperCase();

  $('#sideAvatarWrap').html(avatarHtml);
  $('#topAvatarWrap').html(avatarHtml);

  // Profile Settings form setup
  $('#profName').val(profile.name);
  $('#profEmail').val(profile.email);
  $('#profPhone').val(profile.phone);
  $('#profLang').val(profile.language);
  $('#profPref').val(profile.preference);
  $('#profileHeadshotPreview').attr('src', profile.avatar || 'https://via.placeholder.com/150');
}

// 1. Dashboard Overview
function loadDashboardOverview() {
  const appointments = getAppointments();
  const activeCount = appointments.filter(a => (a.status || 'pending').toLowerCase() === 'confirmed').length;
  const pendingCount = appointments.filter(a => (a.status || 'pending').toLowerCase() === 'pending').length;
  
  // Update UI Stats
  $('#statTotalAppts').text(appointments.length);
  $('#statActiveAppts').text(activeCount);
  $('#statPendingAppts').text(pendingCount);

  // Find Next Appointment (closest upcoming confirmed or pending appointment)
  const now = new Date();
  let nextAppt = null;
  let minDiff = Infinity;

  appointments.forEach(a => {
    const status = (a.status || 'pending').toLowerCase();
    if (status === 'confirmed' || status === 'pending') {
      const apptDate = new Date(`${a.date} ${a.time}`);
      const diff = apptDate - now;
      if (diff > 0 && diff < minDiff) {
        minDiff = diff;
        nextAppt = a;
      }
    }
  });

  // Render Next Appointment Spotlight
  if (nextAppt) {
    const lawyers = getLawyers();
    const lawyerObj = lawyers.find(l => l.id === nextAppt.lawyerId) || {};
    const imgUrl = lawyerObj.image || 'https://via.placeholder.com/150';
    
    $('#nextConsultationTime').text(`${nextAppt.date} at ${nextAppt.time}`);

    const status = (nextAppt.status || 'pending').toLowerCase();
    let statusLabel = status === 'confirmed'
      ? `<span class="badge-status badge-Confirmed"><i class="fas fa-check-circle me-1"></i>Confirmed</span>`
      : `<span class="badge-status badge-Pending"><i class="fas fa-clock me-1"></i>Awaiting Approval</span>`;

    let buttonAction = status === 'confirmed'
      ? `<button class="btn-gold" style="padding:10px 22px; font-size:0.8rem;" onclick="joinVideoMeeting('${nextAppt.id}')">
           <i class="fas fa-video me-2"></i>Join Consultation Lobby
         </button>`
      : `<button class="btn-outline-gold" style="padding:10px 22px; font-size:0.8rem;" onclick="viewAppointment('${nextAppt.id}')">
           <i class="fas fa-search me-2"></i>Review Booking Details
         </button>`;

    let spotlightHtml = `
      <div class="row align-items-center g-3">
        <div class="col-sm-3 col-md-2 text-center text-sm-start">
          <img src="${imgUrl}" class="rounded-circle border border-gold border-2" style="width: 80px; height: 80px; object-fit: cover;">
        </div>
        <div class="col-sm-9 col-md-7">
          <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
            <h5 style="margin:0; font-size:1.15rem; font-family:var(--font-serif);">${nextAppt.lawyerName}</h5>
            ${statusLabel}
          </div>
          <p style="font-size:0.75rem; color:var(--gold); font-weight:700; margin-bottom:4px; text-transform:uppercase; letter-spacing:0.05em;">
            ${nextAppt.specialization} Specialization
          </p>
          <p style="font-size:0.84rem; color:rgba(255,255,255,0.7); margin-bottom:0; font-family:var(--font-sans);">
            <strong>Scheduled:</strong> ${nextAppt.date} @ ${nextAppt.time}
          </p>
        </div>
        <div class="col-md-3 text-center text-md-end">
          ${buttonAction}
        </div>
      </div>`;
    $('#nextApptSpotlightCard').html(spotlightHtml).parent().show();
  } else {
    // No upcoming
    $('#nextApptSpotlightCard').parent().hide();
    $('#nextConsultationTime').text('None Scheduled');
  }

  // Render recent 3 appointments inside Bootstrap Table
  const recentList = [...appointments].slice(0, 3);
  let tblHtml = '';

  recentList.forEach(a => {
    const status = a.status || 'pending';
    let statusClass = `badge-${status.charAt(0).toUpperCase() + status.slice(1)}`;
    tblHtml += `
      <tr>
        <td><strong>${a.id}</strong></td>
        <td><strong>${a.lawyerName}</strong></td>
        <td><span style="font-size:0.75rem; color:var(--gold); font-weight:600; text-transform:uppercase;">${a.specialization}</span></td>
        <td>${a.date} · ${a.time}</td>
        <td>$${a.fee}</td>
        <td><span class="badge-status ${statusClass}">${status}</span></td>
        <td>
          <button class="action-btn" onclick="viewAppointment('${a.id}')" title="View details"><i class="fas fa-eye"></i></button>
        </td>
      </tr>`;
  });

  if (!recentList.length) {
    tblHtml = '<tr><td colspan="7" class="text-center text-muted py-3">No recent appointments recorded.</td></tr>';
  }
  $('#recentApptsTableBody').html(tblHtml);
}

// 2. Search Lawyers Page
function loadSearchLawyers() {
  const query = $('#searchLawyerInput').val().toLowerCase();
  const spec = $('#filterSpecialization').val();
  const sort = $('#sortLawyers').val();
  
  const rawLawyers = getLawyers();
  // Filter active lawyers only (in case admin suspended some)
  let lawyersList = rawLawyers.filter(l => (l.status || 'active') === 'active');

  // Search by name
  if (query) {
    lawyersList = lawyersList.filter(l => l.name.toLowerCase().includes(query));
  }

  // Filter by Specialization
  if (spec && spec !== 'all') {
    lawyersList = lawyersList.filter(l => l.specialization === spec);
  }

  // Sort
  if (sort === 'price-asc') {
    lawyersList.sort((a, b) => a.price - b.price);
  } else if (sort === 'price-desc') {
    lawyersList.sort((a, b) => b.price - a.price);
  } else if (sort === 'rating') {
    lawyersList.sort((a, b) => b.rating - a.rating);
  }

  // Render cards
  let cardsHtml = '';
  lawyersList.forEach(l => {
    const starStr = '★ '.repeat(Math.round(l.rating)) + '☆ '.repeat(5 - Math.round(l.rating));
    const isFeatured = l.featured ? `<div class="lawyer-card-featured-badge">Featured</div>` : '';
    
    cardsHtml += `
      <div class="col-md-6 col-xxl-4">
        <div class="lawyer-card-luxury">
          <div class="lawyer-card-img-wrap">
            <img src="${l.image}" alt="${l.name}">
            ${isFeatured}
          </div>
          <div class="lawyer-card-body">
            <span class="lawyer-card-spec-tag">${l.specializationLabel || l.specialization}</span>
            <h4 class="lawyer-card-title">${l.name}</h4>
            <div class="lawyer-card-meta">
              <span style="color:var(--gold);"><i class="fas fa-star me-1"></i>${l.rating} (${l.reviews} reviews)</span>
              <span><i class="fas fa-map-marker-alt me-1"></i>${l.location}</span>
            </div>
            <p class="lawyer-card-bio">${l.bio}</p>
            <div class="lawyer-card-stats">
              <div class="lawyer-card-stat-item">
                <div class="lawyer-card-stat-label">Win Rate</div>
                <div class="lawyer-card-stat-val">${Math.round((l.wins / l.totalCases) * 100)}%</div>
              </div>
              <div class="lawyer-card-stat-item">
                <div class="lawyer-card-stat-label">Experience</div>
                <div class="lawyer-card-stat-val">${l.experience} Yrs</div>
              </div>
            </div>
            <div class="lawyer-card-footer">
              <div>
                <span class="lawyer-card-price">$${l.price}</span>
                <span style="font-size:0.72rem; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.05em; display:block;">per hour</span>
              </div>
              <button class="btn-gold" style="padding:10px 20px; font-size:0.75rem;" onclick="openBookingModal(${l.id})">
                <i class="fas fa-calendar-alt me-2"></i>Book Consultation
              </button>
            </div>
          </div>
        </div>
      </div>`;
  });

  if (!lawyersList.length) {
    cardsHtml = `
      <div class="col-12 text-center text-muted py-5">
        <i class="fas fa-gavel mb-3" style="font-size:2.5rem; color:var(--gold); opacity:0.5;"></i>
        <h5>No Attorneys Found</h5>
        <p>Try refining your name query or selecting a different practice area filter.</p>
      </div>`;
  }

  $('#lawyersGridRow').html(cardsHtml);
}

// 3. Book Consultation Modal logic
function openBookingModal(lawyerId) {
  const lawyers = getLawyers();
  const lawyer = lawyers.find(l => l.id === lawyerId);
  if (!lawyer) return;

  selectedBookingLawyer = lawyer;
  selectedBookingDate = null;
  selectedBookingTime = null;

  $('#modalLawyerName').text(lawyer.name);
  $('#modalLawyerSpec').text(lawyer.specializationLabel);
  $('#modalLawyerImg').attr('src', lawyer.image);
  $('#modalLawyerPrice').text(`$${lawyer.price}/hr`);

  // Render Date Slots (e.g. Next 3 available days from lawyer.slots)
  let datesHtml = '';
  const slots = lawyer.slots || [];
  slots.forEach((s, idx) => {
    datesHtml += `
      <div class="col-4">
        <div class="slot-date-btn" id="slot-date-${idx}" onclick="selectBookingDate('${s.date}', ${idx})">
          ${s.date}
        </div>
      </div>`;
  });

  if (!slots.length) {
    datesHtml = '<div class="col-12 text-center text-danger font-weight-bold">No slots currently available.</div>';
  }

  $('#bookingModalDateRow').html(datesHtml);
  $('#bookingModalTimeRow').html('<div class="col-12 text-center text-muted" style="font-size:0.8rem;">Please select a date first...</div>');
  $('#caseDescriptionInput').val('');

  // Open modal
  const bookingModal = new bootstrap.Modal(document.getElementById('bookingModal'));
  bookingModal.show();
}

function selectBookingDate(dateStr, idx) {
  selectedBookingDate = dateStr;
  $('.slot-date-btn').removeClass('active');
  $(`#slot-date-${idx}`).addClass('active');

  // Render times
  const slotObj = selectedBookingLawyer.slots.find(s => s.date === dateStr);
  let timesHtml = '';
  if (slotObj && slotObj.times) {
    slotObj.times.forEach((t, tIdx) => {
      timesHtml += `
        <div class="col-4 col-sm-3 mb-2">
          <div class="slot-time-chip" id="slot-time-${tIdx}" onclick="selectBookingTime('${t}', ${tIdx})">
            ${t}
          </div>
        </div>`;
    });
  }
  $('#bookingModalTimeRow').html(timesHtml);
}

function selectBookingTime(timeStr, tIdx) {
  selectedBookingTime = timeStr;
  $('.slot-time-chip').removeClass('active');
  $(`#slot-time-${tIdx}`).addClass('active');
}

function confirmConsultationBooking() {
  if (!selectedBookingDate || !selectedBookingTime) {
    showToast('Please select both a Date and Time slot.');
    return;
  }

  const brief = $('#caseDescriptionInput').val().trim() || 'No case brief provided.';
  const appts = getAppointments();
  
  const newApptId = 'APT-' + Math.floor(1000 + Math.random() * 9000);
  const newAppt = {
    id: newApptId,
    lawyerId: selectedBookingLawyer.id,
    lawyerName: selectedBookingLawyer.name,
    specialization: selectedBookingLawyer.specializationLabel,
    date: selectedBookingDate,
    time: selectedBookingTime,
    fee: selectedBookingLawyer.price,
    status: 'pending',
    brief: brief,
    paymentMethod: 'Visa ending in 9012'
  };

  appts.unshift(newAppt);
  saveAppointments(appts);

  // Close Modal
  const modalEl = document.getElementById('bookingModal');
  const modalInst = bootstrap.Modal.getInstance(modalEl);
  if (modalInst) modalInst.hide();

  showToast('Booking Request submitted successfully!');
  
  // Transition to My Appointments tab
  setTimeout(() => {
    switchTab('appointments');
  }, 500);
}

// 4. My Appointments Page
function loadAppointmentsList() {
  const appts = getAppointments();
  const filter = $('.tab-filter-btn.active').data('filter') || 'all';

  let filteredAppts = appts;
  if (filter !== 'all') {
    filteredAppts = appts.filter(a => (a.status || 'pending').toLowerCase() === filter.toLowerCase());
  }

  let tableHtml = '';
  filteredAppts.forEach(a => {
    const status = a.status || 'pending';
    let statusClass = `badge-${status.charAt(0).toUpperCase() + status.slice(1)}`;
    tableHtml += `
      <tr>
        <td><strong>${a.id}</strong></td>
        <td><strong>${a.lawyerName}</strong></td>
        <td><span style="font-size:0.75rem; color:var(--gold); font-weight:600; text-transform:uppercase;">${a.specialization}</span></td>
        <td>${a.date} · ${a.time}</td>
        <td>$${a.fee}</td>
        <td><span class="badge-status ${statusClass}">${status}</span></td>
        <td>
          <button class="action-btn text-gold" onclick="viewAppointment('${a.id}')" title="Review room"><i class="fas fa-eye"></i></button>
        </td>
      </tr>`;
  });

  if (!filteredAppts.length) {
    tableHtml = `
      <tr>
        <td colspan="7" class="text-center text-muted py-4">
          No appointments found matching this status filter.
        </td>
      </tr>`;
  }
  $('#appointmentsTableBody').html(tableHtml);
}

function handleAppointmentFilter(btn) {
  $('.tab-filter-btn').removeClass('active');
  $(btn).addClass('active');
  loadAppointmentsList();
}

// 5. Appointment Details Page
function viewAppointment(apptId) {
  const appts = getAppointments();
  const appt = appts.find(a => a.id === apptId);
  if (!appt) return;

  currentViewingAppointmentId = apptId;
  
  // Load attorney stats
  const lawyers = getLawyers();
  const lawyer = lawyers.find(l => l.id === appt.lawyerId) || {};

  $('#detApptId').text(appt.id);
  $('#detLawyerImg').attr('src', lawyer.image || 'https://via.placeholder.com/150');
  $('#detLawyerName').text(appt.lawyerName);
  $('#detLawyerSpec').text(appt.specialization);
  $('#detLawyerLoc').text(lawyer.location || 'N/A');
  $('#detLawyerMail').text(lawyer.email || 'attorney@lexelite.com');

  $('#detDate').text(appt.date);
  $('#detTime').text(appt.time);
  $('#detFee').text(`$${appt.fee}.00`);
  $('#detPayMethod').text(appt.paymentMethod || 'Visa ending in 9012');
  $('#detBrief').text(appt.brief);

  // Status badge update
  const status = appt.status || 'pending';
  let statusClass = `badge-${status.charAt(0).toUpperCase() + status.slice(1)}`;
  $('#detStatusBadge').attr('class', `badge-status ${statusClass}`).text(status);

  // Join Room Block details
  const statusLower = status.toLowerCase();
  if (statusLower === 'confirmed') {
    $('#detailsVideoRoomBlock').html(`
      <div style="background:rgba(74,222,128,0.06); border:1px solid rgba(74,222,128,0.3); border-radius:10px; padding:1.5rem; text-align:center;">
        <i class="fas fa-video text-success mb-2" style="font-size:1.8rem; animation: pulse 2s infinite;"></i>
        <h6 style="color:var(--white); font-weight:700; margin-bottom:4px;">Consultation Lobby Open</h6>
        <p style="font-size:0.78rem; color:var(--text-muted); margin-bottom:12px;">Your video conference lobby is ready. Please launch meeting to begin consultations.</p>
        <button class="btn-gold" onclick="joinVideoMeeting('${appt.id}')">
          <i class="fas fa-external-link-alt me-2"></i>Launch Video consultation
        </button>
      </div>`).show();
    $('#detailsCancelBtn').show();
  } else if (statusLower === 'pending') {
    $('#detailsVideoRoomBlock').html(`
      <div style="background:rgba(245,158,11,0.04); border:1px solid rgba(245,158,11,0.25); border-radius:10px; padding:1.5rem; text-align:center;">
        <i class="fas fa-lock text-warning mb-2" style="font-size:1.8rem;"></i>
        <h6 style="color:var(--white); font-weight:700; margin-bottom:4px;">Lobby Locked</h6>
        <p style="font-size:0.78rem; color:var(--text-muted); margin-bottom:0;">Meeting room links become available automatically once the attorney confirms your booking slot.</p>
      </div>`).show();
    $('#detailsCancelBtn').show();
  } else if (statusLower === 'completed') {
    $('#detailsVideoRoomBlock').html(`
      <div style="background:rgba(13,110,253,0.04); border:1px solid rgba(13,110,253,0.25); border-radius:10px; padding:1.5rem; text-align:center;">
        <i class="fas fa-clipboard-check text-primary mb-2" style="font-size:1.8rem;"></i>
        <h6 style="color:var(--white); font-weight:700; margin-bottom:4px;">Session Completed</h6>
        <p style="font-size:0.78rem; color:var(--text-muted); margin-bottom:12px;">This consultation has ended. Retainer services are marked complete.</p>
        <div style="color:var(--gold); font-size:0.95rem; font-style:italic;">"Masterful legal advisory" · Rating: ★ 5.0</div>
      </div>`).show();
    $('#detailsCancelBtn').hide();
  } else {
    // Cancelled
    $('#detailsVideoRoomBlock').html(`
      <div style="background:rgba(239,68,68,0.04); border:1px solid rgba(239,68,68,0.25); border-radius:10px; padding:1.5rem; text-align:center;">
        <i class="fas fa-times-circle text-danger mb-2" style="font-size:1.8rem;"></i>
        <h6 style="color:var(--white); font-weight:700; margin-bottom:4px;">Booking Cancelled</h6>
        <p style="font-size:0.78rem; color:var(--text-muted); margin-bottom:0;">This consultation request has been cancelled by you or the attorney.</p>
      </div>`).show();
    $('#detailsCancelBtn').hide();
  }

  // Open Appointment Details View
  switchTab('appointment-details');
}

function cancelCurrentAppointment() {
  if (!currentViewingAppointmentId) return;

  const conf = confirm('Are you sure you want to cancel this consultation booking?');
  if (!conf) return;

  const appts = getAppointments();
  const appt = appts.find(a => a.id === currentViewingAppointmentId);
  if (appt) {
    appt.status = 'cancelled';
    saveAppointments(appts);
    showToast('Booking cancelled successfully.');
    viewAppointment(currentViewingAppointmentId); // Reload view
  }
}

function joinVideoMeeting(apptId) {
  showToast('Launching video consultation client lobby...');
  // Open mock popup
  setTimeout(() => {
    alert(`[LexElite Video Consult Room] Connected. Launching secure peer connection. Consult ID: ${apptId}`);
  }, 800);
}

function triggerReschedule() {
  showToast('Rescheduling available slots... loading calendar.');
  alert('To reschedule, please cancel this booking and select an alternative available slot on the lawyer\'s profile page.');
}

// 6. Profile Settings Page
function updateProfileHeadshot(input) {
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = function(e) {
      $('#profileHeadshotPreview').attr('src', e.target.result);
      // Save headshot base64
      const profile = getProfile();
      profile.avatar = e.target.result;
      saveProfile(profile);
      syncProfileHeader();
      showToast('Avatar photo updated successfully.');
    }
    reader.readAsDataURL(input.files[0]);
  }
}

function saveClientProfile(event) {
  event.preventDefault();
  const profile = getProfile();
  
  profile.name = $('#profName').val().trim();
  profile.email = $('#profEmail').val().trim();
  profile.phone = $('#profPhone').val().trim();
  profile.language = $('#profLang').val();
  profile.preference = $('#profPref').val();

  saveProfile(profile);
  syncProfileHeader();
  showToast('Client profile updated successfully!');
}

function saveSecurityPassword(event) {
  event.preventDefault();
  const curPass = $('#curPass').val();
  const newPass = $('#newPass').val();
  const confPass = $('#confPass').val();

  if (newPass !== confPass) {
    showToast('New passwords do not match.');
    return;
  }

  showToast('Account password updated successfully!');
  $('#curPass').val('');
  $('#newPass').val('');
  $('#confPass').val('');
}

// ─── INITIALIZATION ───
$(document).ready(function() {
  seedInitialData();
  syncProfileHeader();
  loadDashboardOverview();

  // Search filter event hooks
  $('#searchLawyerInput').on('keyup', loadSearchLawyers);
  $('#filterSpecialization').on('change', loadSearchLawyers);
  $('#sortLawyers').on('change', loadSearchLawyers);
});
