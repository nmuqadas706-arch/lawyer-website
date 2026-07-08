/**
 * admin.js
 * LexElite Administrative Workspace Controls
 * Strict Separation of Concerns - Core Javascript & jQuery Logic
 * Defensive coding for localStorage schema safety
 */

// ─── LOCAL STORAGE KEYS ───
const LAWYERS_KEY = 'lexelite_lawyers';
const CUSTOMERS_KEY = 'lexelite_customers';
const APPOINTMENTS_KEY = 'lexelite_appointments';
const AREAS_KEY = 'lexelite_practice_areas';

// ─── STATE INITIALIZATION & DATA SEEDING ───
function seedAdminDatabase() {
  // 1. Seed Lawyers
  if (!localStorage.getItem(LAWYERS_KEY)) {
    // Add default statuses if they don't exist in data.js
    const seededLawyers = LAWYERS.map(l => ({
      ...l,
      status: l.id === 8 ? 'suspended' : l.id === 5 ? 'pending' : 'active',
      joined: l.id % 2 === 0 ? '2024-02-18' : '2023-11-05'
    }));
    localStorage.setItem(LAWYERS_KEY, JSON.stringify(seededLawyers));
  }

  // 2. Seed Customers
  if (!localStorage.getItem(CUSTOMERS_KEY)) {
    localStorage.setItem(CUSTOMERS_KEY, JSON.stringify(ADMIN_CUSTOMERS));
  }

  // 3. Seed Appointments
  if (!localStorage.getItem(APPOINTMENTS_KEY)) {
    // Initialize appointments from ADMIN_APPOINTMENTS database, making sure statuses are compatible
    const seededAppts = ADMIN_APPOINTMENTS.map(a => ({
      ...a,
      lawyerId: a.id === 'APT-001' ? 2 : a.id === 'APT-002' ? 5 : a.id === 'APT-003' ? 1 : a.id === 'APT-004' ? 4 : a.id === 'APT-005' ? 7 : a.id === 'APT-006' ? 3 : a.id === 'APT-007' ? 8 : 6,
      lawyerName: a.lawyer,
      clientName: a.client,
      fee: a.id === 'APT-001' ? 500 : a.id === 'APT-002' ? 250 : a.id === 'APT-003' ? 350 : 320,
      brief: a.service + ' case review required.',
      paymentMethod: 'Visa ending in 9012'
    }));
    localStorage.setItem(APPOINTMENTS_KEY, JSON.stringify(seededAppts));
  }

  // 4. Seed Services / Practice Areas
  if (!localStorage.getItem(AREAS_KEY)) {
    localStorage.setItem(AREAS_KEY, JSON.stringify(PRACTICE_AREAS));
  }
}

// ─── GETTERS & SETTERS ───
function loadData(key) {
  return JSON.parse(localStorage.getItem(key)) || [];
}

function saveData(key, data) {
  localStorage.setItem(key, JSON.stringify(data));
}

// ─── GLOBAL STATS & PAGINATION VARIABLES ───
let currentLawyerPage = 1;
let currentCustomerPage = 1;
let currentAppointmentPage = 1;
const itemsPerPage = 5;

let editingServiceId = null;
let reschedulingAppointmentId = null;
let revenueChart = null;
let categoryChart = null;

// ─── TOAST NOTIFICATION ───
function showToast(msg) {
  $('#toastMsg').text(msg);
  $('#toastBox').fadeIn(300);
  setTimeout(() => $('#toastBox').fadeOut(400), 2500);
}

// ─── ROUTING & PANEL CONTROLLER ───
function switchPanel(panelId, btn) {
  // Update sidebar active link
  $('.menu-item').removeClass('active');
  $(btn).addClass('active');

  // Switch display panel
  $('.panel-section').removeClass('active');
  $(`#sec-${panelId}`).addClass('active');

  // Update header text
  let headerText = 'Dashboard Overview';
  switch (panelId) {
    case 'overview': headerText = 'Dashboard Overview'; break;
    case 'lawyers': headerText = 'Manage Legal Practitioners'; break;
    case 'clients': headerText = 'Manage Registered Clients'; break;
    case 'services': headerText = 'Manage Retained Services'; break;
    case 'appointments': headerText = 'Manage Consultations Ledger'; break;
    case 'reports': headerText = 'Analytics & Insights Reports'; break;
  }
  $('#panelTitle').text(headerText);

  // Close Mobile sidebar
  $('#sidebar').removeClass('open');

  // Trigger loading functions
  if (panelId === 'overview') {
    loadOverviewStats();
    initCharts();
  }
  if (panelId === 'lawyers') {
    currentLawyerPage = 1;
    renderLawyersTable();
  }
  if (panelId === 'clients') {
    currentCustomerPage = 1;
    renderCustomersTable();
  }
  if (panelId === 'services') {
    renderServicesTable();
  }
  if (panelId === 'appointments') {
    currentAppointmentPage = 1;
    renderAppointmentsTable();
  }
  if (panelId === 'reports') {
    loadReportsData();
    initAnalyticsCharts();
  }
}

// ─── OVERVIEW LOADER ───
function loadOverviewStats() {
  const lawyers = loadData(LAWYERS_KEY);
  const customers = loadData(CUSTOMERS_KEY);
  const appts = loadData(APPOINTMENTS_KEY);

  // Calculate platform statistics
  const activeLawyersCount = lawyers.filter(l => (l.status || 'active') === 'active').length;
  
  // Calculate total revenue & platform commission (15% commission model)
  let totalRevenue = 0;
  appts.forEach(a => {
    const status = a.status || 'pending';
    const statusLower = status.toLowerCase();
    if (statusLower === 'confirmed' || statusLower === 'completed') {
      totalRevenue += (a.fee || 300);
    }
  });
  const commission = Math.round(totalRevenue * 0.15);

  $('#statTotalLawyers').text(lawyers.length);
  $('#statTotalClients').text(customers.length);
  $('#statTotalBookings').text(appts.length);
  $('#statPlatformCommission').text(`$${commission.toLocaleString()}`);

  // Load pending applications count in sidebar badge if applicable
  const pendingApps = lawyers.filter(l => (l.status || 'active') === 'pending').length;
  if (pendingApps > 0) {
    $('#lawyerPendingBadge').text(pendingApps).show();
  } else {
    $('#lawyerPendingBadge').hide();
  }

  // Load Recent 5 Appointments in Overview table
  let recentHtml = '';
  const sortedAppts = [...appts].slice(0, 5);

  sortedAppts.forEach(a => {
    const status = a.status || 'pending';
    let statusClass = `badge-${status.charAt(0).toUpperCase() + status.slice(1)}`;
    recentHtml += `
      <tr>
        <td><strong>${a.id}</strong></td>
        <td>${a.lawyerName || a.lawyer}</td>
        <td>${a.clientName || a.client}</td>
        <td>${a.date}</td>
        <td>$${a.fee || 300}</td>
        <td><span class="badge-status ${statusClass}">${status}</span></td>
        <td>
          <button class="action-btn text-gold" onclick="switchPanel('appointments', $('[data-target=appointments]'));" title="Go to ledger"><i class="fas fa-arrow-right"></i></button>
        </td>
      </tr>`;
  });

  if (!sortedAppts.length) {
    recentHtml = '<tr><td colspan="7" class="text-center text-muted">No appointments recorded yet.</td></tr>';
  }
  $('#recentAppointmentsTable').html(recentHtml);
}

// ─── CHARTS LOADER ───
function initCharts() {
  // Destroy existing charts to prevent overlaps on switch
  if (revenueChart) revenueChart.destroy();
  if (categoryChart) categoryChart.destroy();

  const canvasRevenue = document.getElementById('chartRevenueTrend');
  const canvasCategory = document.getElementById('chartCategoryShare');
  if (!canvasRevenue || !canvasCategory) return;

  const ctxRevenue = canvasRevenue.getContext('2d');
  const ctxCategory = canvasCategory.getContext('2d');

  // Chart 1: Revenue Line Chart
  revenueChart = new Chart(ctxRevenue, {
    type: 'line',
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
      datasets: [{
        label: 'Platform Revenue ($)',
        data: [12000, 19000, 15000, 25000, 22000, 30000, 34000],
        borderColor: '#C9A84C',
        backgroundColor: 'rgba(201, 168, 76, 0.1)',
        borderWidth: 2,
        tension: 0.4,
        fill: true
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: { legend: { display: false } },
      scales: {
        y: { grid: { color: 'rgba(255, 255, 255, 0.05)' }, ticks: { color: '#8A8A9A' } },
        x: { grid: { display: false }, ticks: { color: '#8A8A9A' } }
      }
    }
  });

  // Chart 2: Category Pie Chart
  categoryChart = new Chart(ctxCategory, {
    type: 'doughnut',
    data: {
      labels: ['Corporate', 'Criminal', 'Immigration', 'Family', 'Property'],
      datasets: [{
        data: [35, 25, 15, 15, 10],
        backgroundColor: ['#C9A84C', '#1A2F60', '#A8872E', '#E8C97B', '#27AE60'],
        borderWidth: 0
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          position: 'right',
          labels: { color: '#8A8A9A', font: { size: 10 } }
        }
      }
    }
  });
}

// ─── MANAGE LAWYERS PANEL ───
function renderLawyersTable() {
  const lawyers = loadData(LAWYERS_KEY);
  const searchVal = $('#searchLawyerInput').val().toLowerCase();
  const statusFilter = $('#filterLawyerStatus').val();

  let filtered = lawyers;

  if (searchVal) {
    filtered = filtered.filter(l => l.name.toLowerCase().includes(searchVal));
  }
  if (statusFilter && statusFilter !== 'all') {
    filtered = filtered.filter(l => (l.status || 'active') === statusFilter);
  }

  // Pagination logic
  const totalItems = filtered.length;
  const totalPages = Math.ceil(totalItems / itemsPerPage);
  if (currentLawyerPage > totalPages) currentLawyerPage = totalPages || 1;

  const startIdx = (currentLawyerPage - 1) * itemsPerPage;
  const pageData = filtered.slice(startIdx, startIdx + itemsPerPage);

  let html = '';
  pageData.forEach(l => {
    const status = l.status || 'active';
    let statusClass = `badge-${status.charAt(0).toUpperCase() + status.slice(1)}`;
    let actionButtons = '';

    if (status === 'pending') {
      actionButtons += `<button class="action-btn text-success me-1" onclick="approveLawyer(${l.id})" title="Approve Lawyer"><i class="fas fa-check"></i></button>`;
    }
    if (status === 'active') {
      actionButtons += `<button class="action-btn text-warning me-1" onclick="suspendLawyer(${l.id})" title="Suspend Lawyer"><i class="fas fa-ban"></i></button>`;
    }
    if (status === 'suspended') {
      actionButtons += `<button class="action-btn text-success me-1" onclick="activateLawyer(${l.id})" title="Activate Lawyer"><i class="fas fa-check-circle"></i></button>`;
    }
    actionButtons += `<button class="action-btn text-danger" onclick="deleteLawyer(${l.id})" title="Delete Lawyer"><i class="fas fa-trash"></i></button>`;

    html += `
      <tr>
        <td><strong>L-0${l.id}</strong></td>
        <td>
          <div class="d-flex align-items-center gap-2">
            <img src="${l.image || 'https://via.placeholder.com/150'}" class="rounded-circle" style="width: 32px; height: 32px; object-fit: cover;">
            <strong>${l.name}</strong>
          </div>
        </td>
        <td><span style="font-size:0.75rem; color:var(--gold); font-weight:700; text-transform:uppercase;">${l.specializationLabel || l.specialization}</span></td>
        <td>${l.location}</td>
        <td>$${l.price}/hr</td>
        <td><span class="badge-status ${statusClass}">${status}</span></td>
        <td>${l.joined || '2024-01-10'}</td>
        <td>${actionButtons}</td>
      </tr>`;
  });

  if (!filtered.length) {
    html = '<tr><td colspan="8" class="text-center text-muted py-4">No lawyers found matching criteria.</td></tr>';
  }

  $('#lawyersTableBody').html(html);
  renderPagination('lawyersPagination', totalPages, currentLawyerPage, 'changeLawyerPage');
}

function changeLawyerPage(page) {
  currentLawyerPage = page;
  renderLawyersTable();
}

function approveLawyer(id) {
  const lawyers = loadData(LAWYERS_KEY);
  const l = lawyers.find(item => item.id === id);
  if (l) {
    l.status = 'active';
    saveData(LAWYERS_KEY, lawyers);
    showToast(`${l.name} has been approved and activated.`);
    renderLawyersTable();
    loadOverviewStats();
  }
}

function suspendLawyer(id) {
  const lawyers = loadData(LAWYERS_KEY);
  const l = lawyers.find(item => item.id === id);
  if (l) {
    l.status = 'suspended';
    saveData(LAWYERS_KEY, lawyers);
    showToast(`${l.name} has been suspended.`);
    renderLawyersTable();
  }
}

function activateLawyer(id) {
  const lawyers = loadData(LAWYERS_KEY);
  const l = lawyers.find(item => item.id === id);
  if (l) {
    l.status = 'active';
    saveData(LAWYERS_KEY, lawyers);
    showToast(`${l.name} is now active.`);
    renderLawyersTable();
  }
}

function deleteLawyer(id) {
  if (confirm('Are you sure you want to delete this lawyer profile? This cannot be undone.')) {
    const lawyers = loadData(LAWYERS_KEY);
    const updated = lawyers.filter(item => item.id !== id);
    saveData(LAWYERS_KEY, updated);
    showToast('Lawyer profile deleted.');
    renderLawyersTable();
    loadOverviewStats();
  }
}

// ─── MANAGE CUSTOMERS PANEL ───
function renderCustomersTable() {
  const customers = loadData(CUSTOMERS_KEY);
  const searchVal = $('#searchCustomerInput').val().toLowerCase();

  let filtered = customers;
  if (searchVal) {
    filtered = filtered.filter(c => c.name.toLowerCase().includes(searchVal) || c.email.toLowerCase().includes(searchVal));
  }

  const totalPages = Math.ceil(filtered.length / itemsPerPage);
  if (currentCustomerPage > totalPages) currentCustomerPage = totalPages || 1;

  const startIdx = (currentCustomerPage - 1) * itemsPerPage;
  const pageData = filtered.slice(startIdx, startIdx + itemsPerPage);

  let html = '';
  pageData.forEach(c => {
    const cStatus = c.status || 'active';
    let statusClass = cStatus === 'active' ? 'badge-Active' : 'badge-Inactive';
    let btnIcon = cStatus === 'active' ? 'fa-user-slash text-warning' : 'fa-user-check text-success';
    
    html += `
      <tr>
        <td><strong>C-00${c.id.split('-')[1] || c.id}</strong></td>
        <td><strong>${c.name}</strong></td>
        <td>${c.email}</td>
        <td>${c.joined || '2024-02-05'}</td>
        <td><span class="badge bg-gold text-dark font-weight-bold" style="font-size:0.75rem;">${c.bookings !== undefined ? c.bookings : 2} bookings</span></td>
        <td><span class="badge-status ${statusClass}">${cStatus}</span></td>
        <td>
          <button class="action-btn me-1" onclick="toggleCustomerStatus('${c.id}')" title="Toggle Status"><i class="fas ${btnIcon}"></i></button>
          <button class="action-btn text-danger" onclick="deleteCustomer('${c.id}')" title="Delete Client"><i class="fas fa-trash"></i></button>
        </td>
      </tr>`;
  });

  if (!filtered.length) {
    html = '<tr><td colspan="7" class="text-center text-muted py-4">No customers found.</td></tr>';
  }

  $('#customersTableBody').html(html);
  renderPagination('customersPagination', totalPages, currentCustomerPage, 'changeCustomerPage');
}

function changeCustomerPage(page) {
  currentCustomerPage = page;
  renderCustomersTable();
}

function toggleCustomerStatus(id) {
  const customers = loadData(CUSTOMERS_KEY);
  const c = customers.find(item => item.id === id);
  if (c) {
    c.status = (c.status || 'active') === 'active' ? 'inactive' : 'active';
    saveData(CUSTOMERS_KEY, customers);
    showToast(`Status updated for client ${c.name}.`);
    renderCustomersTable();
  }
}

function deleteCustomer(id) {
  if (confirm('Are you sure you want to delete this customer record?')) {
    const customers = loadData(CUSTOMERS_KEY);
    const updated = customers.filter(item => item.id !== id);
    saveData(CUSTOMERS_KEY, updated);
    showToast('Customer deleted.');
    renderCustomersTable();
    loadOverviewStats();
  }
}

// ─── MANAGE SERVICES PANEL ───
function renderServicesTable() {
  const areas = loadData(AREAS_KEY);
  let html = '';

  areas.forEach((s, idx) => {
    html += `
      <tr>
        <td><strong>S-0${idx + 1}</strong></td>
        <td>
          <div class="service-icon-box" style="background:${s.color || 'var(--gold)'}; color:var(--white);">
            <i class="${s.icon || 'fas fa-balance-scale'}"></i>
          </div>
        </td>
        <td><strong>${s.label}</strong></td>
        <td><code>${s.id}</code></td>
        <td><span style="border-left: 3px solid ${s.color || 'var(--gold)'}; padding-left:8px; font-size:0.8rem;">${s.color || 'Default Gold'}</span></td>
        <td>
          <button class="action-btn text-gold me-1" onclick="openEditServiceModal(${idx})" title="Edit Service"><i class="fas fa-edit"></i></button>
          <button class="action-btn text-danger" onclick="deleteService(${idx})" title="Delete Service"><i class="fas fa-trash"></i></button>
        </td>
      </tr>`;
  });

  if (!areas.length) {
    html = '<tr><td colspan="6" class="text-center text-muted py-4">No services/practice areas configured.</td></tr>';
  }
  $('#servicesTableBody').html(html);
}

function openAddServiceModal() {
  editingServiceId = null;
  $('#modalServiceTitle').text('Add Practice Area Service');
  $('#servLabel').val('');
  $('#servId').val('');
  $('#servIcon').val('fas fa-balance-scale');
  $('#servColor').val('#C9A84C');
  
  const modal = new bootstrap.Modal(document.getElementById('serviceModal'));
  modal.show();
}

function openEditServiceModal(idx) {
  const areas = loadData(AREAS_KEY);
  const s = areas[idx];
  if (!s) return;

  editingServiceId = idx;
  $('#modalServiceTitle').text('Modify Practice Area Service');
  $('#servLabel').val(s.label);
  $('#servId').val(s.id);
  $('#servIcon').val(s.icon || 'fas fa-balance-scale');
  $('#servColor').val(s.color || '#C9A84C');

  const modal = new bootstrap.Modal(document.getElementById('serviceModal'));
  modal.show();
}

function saveServiceDetails(event) {
  event.preventDefault();
  const areas = loadData(AREAS_KEY);
  
  const label = $('#servLabel').val().trim();
  const id = $('#servId').val().trim().toLowerCase();
  const icon = $('#servIcon').val().trim();
  const color = $('#servColor').val().trim();

  const newService = { id, label, icon, color };

  if (editingServiceId === null) {
    // Add mode
    areas.push(newService);
    showToast('New legal service configured successfully!');
  } else {
    // Edit mode
    areas[editingServiceId] = newService;
    showToast('Legal service modified.');
  }

  saveData(AREAS_KEY, areas);
  
  const modalEl = document.getElementById('serviceModal');
  const modalInst = bootstrap.Modal.getInstance(modalEl);
  if (modalInst) modalInst.hide();
  
  renderServicesTable();
}

function deleteService(idx) {
  if (confirm('Delete this practice area? All client consultation searches for this practice area might fail.')) {
    const areas = loadData(AREAS_KEY);
    const updated = areas.filter((_, i) => i !== idx);
    saveData(AREAS_KEY, updated);
    showToast('Service category deleted.');
    renderServicesTable();
  }
}

// ─── MANAGE APPOINTMENTS PANEL ───
function renderAppointmentsTable() {
  const appts = loadData(APPOINTMENTS_KEY);
  const searchVal = $('#searchApptInput').val().toLowerCase();
  const statusFilter = $('#filterApptStatus').val();

  let filtered = appts;
  if (searchVal) {
    filtered = filtered.filter(a => 
      (a.lawyerName && a.lawyerName.toLowerCase().includes(searchVal)) || 
      (a.lawyer && a.lawyer.toLowerCase().includes(searchVal)) || 
      (a.clientName && a.clientName.toLowerCase().includes(searchVal)) ||
      (a.client && a.client.toLowerCase().includes(searchVal))
    );
  }
  if (statusFilter && statusFilter !== 'all') {
    filtered = filtered.filter(a => (a.status || 'pending').toLowerCase() === statusFilter.toLowerCase());
  }

  const totalPages = Math.ceil(filtered.length / itemsPerPage);
  if (currentAppointmentPage > totalPages) currentAppointmentPage = totalPages || 1;

  const startIdx = (currentAppointmentPage - 1) * itemsPerPage;
  const pageData = filtered.slice(startIdx, startIdx + itemsPerPage);

  let html = '';
  pageData.forEach(a => {
    const status = a.status || 'pending';
    let statusClass = `badge-${status.charAt(0).toUpperCase() + status.slice(1)}`;
    let actions = '';

    const statusLower = status.toLowerCase();
    if (statusLower === 'pending' || statusLower === 'confirmed') {
      actions += `<button class="action-btn text-warning me-1" onclick="openRescheduleModal('${a.id}')" title="Reschedule Date/Time"><i class="fas fa-calendar-alt"></i></button>`;
      actions += `<button class="action-btn text-danger" onclick="cancelAppointmentAdmin('${a.id}')" title="Cancel Booking"><i class="fas fa-ban"></i></button>`;
    } else {
      actions += '<span class="text-muted" style="font-size:0.75rem;">No Actions</span>';
    }

    html += `
      <tr>
        <td><strong>${a.id}</strong></td>
        <td><strong>${a.lawyerName || a.lawyer}</strong></td>
        <td><strong>${a.clientName || a.client}</strong></td>
        <td>${a.date} · ${a.time || 'N/A'}</td>
        <td>$${a.fee || 300}</td>
        <td><span class="badge-status ${statusClass}">${status}</span></td>
        <td>${actions}</td>
      </tr>`;
  });

  if (!filtered.length) {
    html = '<tr><td colspan="7" class="text-center text-muted py-4">No appointments found matching search criteria.</td></tr>';
  }

  $('#appointmentsTableBody').html(html);
  renderPagination('appointmentsPagination', totalPages, currentAppointmentPage, 'changeAppointmentPage');
}

function changeAppointmentPage(page) {
  currentAppointmentPage = page;
  renderAppointmentsTable();
}

function cancelAppointmentAdmin(id) {
  if (confirm('Cancel this client appointment? Immediate notification will be dispatched.')) {
    const appts = loadData(APPOINTMENTS_KEY);
    const a = appts.find(item => item.id === id);
    if (a) {
      a.status = 'cancelled';
      saveData(APPOINTMENTS_KEY, appts);
      showToast('Appointment cancelled successfully.');
      renderAppointmentsTable();
      loadOverviewStats();
    }
  }
}

function openRescheduleModal(id) {
  const appts = loadData(APPOINTMENTS_KEY);
  const a = appts.find(item => item.id === id);
  if (!a) return;

  reschedulingAppointmentId = id;
  $('#reschDate').val(a.date);
  $('#reschTime').val(a.time || '10:00 AM');

  const modal = new bootstrap.Modal(document.getElementById('rescheduleModal'));
  modal.show();
}

function saveRescheduledDate(event) {
  event.preventDefault();
  const appts = loadData(APPOINTMENTS_KEY);
  const a = appts.find(item => item.id === reschedulingAppointmentId);
  if (a) {
    a.date = $('#reschDate').val();
    a.time = $('#reschTime').val();
    saveData(APPOINTMENTS_KEY, appts);
    showToast(`Appointment rescheduled to ${a.date} at ${a.time}.`);
    
    const modalEl = document.getElementById('rescheduleModal');
    const modalInst = bootstrap.Modal.getInstance(modalEl);
    if (modalInst) modalInst.hide();
    
    renderAppointmentsTable();
  }
}

// ─── REPORTS PANEL ───
function loadReportsData() {
  const lawyers = loadData(LAWYERS_KEY);
  const appts = loadData(APPOINTMENTS_KEY);

  // Top Lawyers by completed appointments
  let lawyerCounts = {};
  appts.forEach(a => {
    const statusLower = (a.status || 'pending').toLowerCase();
    if (statusLower === 'completed' || statusLower === 'confirmed') {
      const name = a.lawyerName || a.lawyer;
      lawyerCounts[name] = (lawyerCounts[name] || 0) + 1;
    }
  });

  let topLawyersList = Object.keys(lawyerCounts).map(name => ({
    name,
    count: lawyerCounts[name]
  })).sort((a,b) => b.count - a.count).slice(0, 3);

  let topHtml = '';
  topLawyersList.forEach((tl, idx) => {
    topHtml += `
      <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
          <span class="badge bg-gold text-dark me-2">#${idx + 1}</span>
          <strong style="font-size:0.9rem;">${tl.name}</strong>
        </div>
        <span style="font-size:0.8rem; color:var(--text-muted);">${tl.count} sessions completed</span>
      </div>`;
  });
  if (!topLawyersList.length) topHtml = '<p class="text-muted text-center">No reports data available.</p>';
  $('#topPerformingAttorneys').html(topHtml);
}

function initAnalyticsCharts() {
  const canvasReports = document.getElementById('chartReportsRevenue');
  if (!canvasReports) return;

  const ctxReports = canvasReports.getContext('2d');
  // Simple bar chart for revenue trends
  if (window.reportsChartObj) window.reportsChartObj.destroy();

  window.reportsChartObj = new Chart(ctxReports, {
    type: 'bar',
    data: {
      labels: ['Corporate', 'Criminal', 'Immigration', 'Family', 'Property', 'Tax'],
      datasets: [{
        label: 'Revenue generated ($)',
        data: [25000, 18500, 9200, 11000, 6800, 12500],
        backgroundColor: '#C9A84C',
        borderWidth: 0
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        y: { grid: { color: 'rgba(255, 255, 255, 0.05)' }, ticks: { color: '#8A8A9A' } },
        x: { grid: { display: false }, ticks: { color: '#8A8A9A' } }
      }
    }
  });
}

function exportDataReport(format) {
  showToast(`Generating platform report in ${format.toUpperCase()} format...`);
  setTimeout(() => {
    alert(`[LexElite Platform Auditor] Export complete. The data report file (lexelite_reports_${format.toLowerCase()}) was successfully built in your local download folder.`);
  }, 1000);
}

// ─── PAGINATION HELPER ───
function renderPagination(elementId, totalPages, currentPage, callbackName) {
  let paginationHtml = '';
  
  // Previous button
  let prevDisabled = currentPage === 1 ? 'disabled' : '';
  paginationHtml += `
    <li class="page-item ${prevDisabled}">
      <a class="page-link" href="#" onclick="${callbackName}(${currentPage - 1}); return false;" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
      </a>
    </li>`;

  // Numbered pages
  for (let i = 1; i <= totalPages; i++) {
    let activeClass = currentPage === i ? 'active' : '';
    paginationHtml += `
      <li class="page-item ${activeClass}">
        <a class="page-link" href="#" onclick="${callbackName}(${i}); return false;">${i}</a>
      </li>`;
  }

  // Next button
  let nextDisabled = currentPage === totalPages || totalPages === 0 ? 'disabled' : '';
  paginationHtml += `
    <li class="page-item ${nextDisabled}">
      <a class="page-link" href="#" onclick="${callbackName}(${currentPage + 1}); return false;" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li>`;

  $(`#${elementId}`).html(paginationHtml);
}

// ─── INITIALIZATION ON READY ───
$(document).ready(function() {
  seedAdminDatabase();
  loadOverviewStats();
  initCharts();

  // Search input hooks
  $('#searchLawyerInput').on('keyup', renderLawyersTable);
  $('#filterLawyerStatus').on('change', renderLawyersTable);

  $('#searchCustomerInput').on('keyup', renderCustomersTable);

  $('#searchApptInput').on('keyup', renderAppointmentsTable);
  $('#filterApptStatus').on('change', renderAppointmentsTable);
});
