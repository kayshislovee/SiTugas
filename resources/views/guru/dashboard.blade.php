<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SITUGAS - Dashboard Guru</title>

  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
<style>
/* ===========================
   RESET & BASE
=========================== */
*, *::before, *::after {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

:root {
  --blue-dark:  #1a3faa;
  --blue-mid:   #2451d1;
  --blue-light: #3b6ef8;
  --blue-pale:  #eef2ff;
  --accent:     #f59e0b;
  --red:        #ef4444;
  --red-pale:   #fef2f2;
  --orange:     #f97316;
  --orange-pale:#fff7ed;
  --green:      #22c55e;
  --green-pale: #f0fdf4;
  --gray-50:    #f8fafc;
  --gray-100:   #f1f5f9;
  --gray-200:   #e2e8f0;
  --gray-400:   #94a3b8;
  --gray-600:   #475569;
  --gray-800:   #1e293b;
  --white:      #ffffff;
  --sidebar-w:  220px;
  --radius:     14px;
  --shadow-sm:  0 1px 4px rgba(0,0,0,.06);
  --shadow-md:  0 4px 16px rgba(0,0,0,.08);
}

body {
  font-family: 'Plus Jakarta Sans', sans-serif;
  background-color: var(--gray-50);
  display: flex;
  min-height: 100vh;
  color: var(--gray-800);
  overflow-x: hidden;
}

/* ===========================
   SIDEBAR
=========================== */
.sidebar {
  width: var(--sidebar-w);
  min-height: 100vh;
  background-image: url('/assets/sidebarbg.jpg');
  background-size: cover;
  background-position: center;
  background-attachment: fixed;
  display: flex;
  flex-direction: column;
  padding: 28px 16px 24px;
  flex-shrink: 0;
  position: fixed;
  top: 0;
  left: 0;
  bottom: 0;
  z-index: 100;
}

.sidebar-logo {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  margin-bottom: 18px;
  padding: 0 6px;
}

.logo-icon {
  width: 38px;
  height: 35px;
  flex-shrink: 0;
}

.brand {
  font-family: 'Syne', sans-serif;
  font-size: 15px;
  font-weight: 900;
  color: #fff;
  letter-spacing: 1px;
}

.sidebar-divider {
  width: 100%;
  height: 1px;
  background: rgba(255,255,255,0.28);
  margin-bottom: 28px;
}

.nav-menu {
  display: flex;
  flex-direction: column;
  gap: 4px;
  width: 100%;
  flex: 1;
}

.nav-item {
  display: flex;
  align-items: center;
  gap: 11px;
  padding: 11px 16px;
  border-radius: 10px;
  cursor: pointer;
  color: rgba(255,255,255,0.75);
  font-size: 14px;
  font-weight: 600;
  text-decoration: none;
  transition: all 0.2s;
  white-space: nowrap;
}

.nav-item svg {
  width: 19px; height: 19px;
  flex-shrink: 0;
  stroke: rgba(255,255,255,0.75);
  fill: none;
  transition: stroke 0.2s;
}

.nav-item:hover {
  background: rgba(255,255,255,0.13);
  color: #fff;
}

.nav-item:hover svg {
  stroke: #fff;
}

.nav-item.active {
  background: #fff;
  color: var(--blue-mid);
  font-weight: 700;
}

.nav-item.active svg {
  stroke: var(--blue-mid);
}

.sidebar-footer {
  padding: 14px 10px 6px 10px;
  border-top: 1px solid rgba(255,255,255,0.28);
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.user-profile {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 8px 10px;
  border-radius: 10px;
  background: rgba(255,255,255,0.08);
}

.user-avatar {
  width: 36px;
  height: 36px;
  border-radius: 50%;
  background: rgba(255,255,255,0.2);
  display: flex;
  align-items: center;
  justify-content: center;
  color: rgba(255,255,255,0.9);
  font-size: 18px;
  flex-shrink: 0;
}

.user-info {
  flex: 1;
  min-width: 0;
}

.user-name {
  font-size: 13px;
  font-weight: 600;
  color: rgba(255,255,255,0.95);
  line-height: 1.2;
}

.user-role {
  font-size: 11px;
  color: rgba(255,255,255,0.7);
  line-height: 1.2;
}

.logout-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  padding: 8px 12px;
  border-radius: 8px;
  text-decoration: none;
  color: rgba(255,255,255,0.8);
  font-size: 13px;
  font-weight: 600;
  transition: all 0.2s;
  background: rgba(255,255,255,0.08);
}

.logout-btn:hover {
  background: rgba(255,255,255,0.15);
  color: #fff;
}

/* ===========================
   MAIN CONTENT
=========================== */
main {
  margin-left: var(--sidebar-w);
  flex: 1;
  padding: 28px 32px;
  animation: fadeUp .45s ease both;
}

@keyframes fadeUp {
  from { opacity: 0; transform: translateY(12px); }
  to   { opacity: 1; transform: translateY(0); }
}

/* ===========================
   TOP BAR
=========================== */
.topbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 22px;
}

.page-title {
  font-size: 20px;
  font-weight: 700;
  color: var(--gray-800);
}

.topbar-actions {
  display: flex;
  align-items: center;
  gap: 10px;
}

.icon-btn {
  background: none;
  border: 1.5px solid var(--gray-200);
  border-radius: 8px;
  width: 36px;
  height: 36px;
  cursor: pointer;
  color: var(--gray-600);
  font-size: 16px;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.2s;
  padding: 0;
}

.icon-btn:hover {
  background-color: var(--gray-100);
  border-color: var(--gray-300);
}

.icon-btn svg {
  width: 18px;
  height: 18px;
  stroke: currentColor;
  fill: none;
  stroke-width: 2;
  stroke-linecap: round;
  stroke-linejoin: round;
}

.btn-primary {
  background-color: var(--blue-mid);
  color: var(--white);
  border: none;
  border-radius: 8px;
  padding: 8px 16px;
  font-size: 13px;
  font-weight: 600;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 8px;
  transition: background-color 0.2s;
  font-family: 'Plus Jakarta Sans', sans-serif;
}

.btn-primary:hover {
  background-color: var(--blue-dark);
}

.btn-primary svg {
  width: 16px;
  height: 16px;
  stroke: currentColor;
  fill: none;
  stroke-width: 2.5;
  stroke-linecap: round;
  stroke-linejoin: round;
}

/* ===========================
   STAT CARDS
=========================== */
.stats {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 16px;
  margin-bottom: 22px;
}

.stat-card {
  background: var(--white);
  border-radius: var(--radius);
  padding: 20px 22px;
  box-shadow: var(--shadow-sm);
  border: 1px solid var(--gray-200);
  transition: transform .18s, box-shadow .18s;
}

.stat-card:hover {
  transform: translateY(-2px);
  box-shadow: var(--shadow-md);
}

.stat-label {
  font-size: 10.5px;
  font-weight: 700;
  letter-spacing: .1em;
  text-transform: uppercase;
  color: var(--gray-400);
  margin-bottom: 10px;
}

.stat-value {
  font-size: 34px;
  font-weight: 800;
  color: var(--gray-800);
  line-height: 1;
}

/* ===========================
   CARD (shared)
=========================== */
.card {
  background: var(--white);
  border-radius: var(--radius);
  box-shadow: var(--shadow-sm);
  border: 1px solid var(--gray-200);
  overflow: hidden;
  animation: fadeUp .5s .14s ease both;
}

.card-header {
  padding: 20px 24px 16px;
  border-bottom: 1px solid var(--gray-100);
}

.card-title {
  font-size: 16px;
  font-weight: 800;
  color: var(--gray-800);
}

.link-all {
  font-size: 12px;
  color: var(--blue-mid);
  text-decoration: none;
  font-weight: 600;
}

.link-all:hover {
  text-decoration: underline;
}

/* ===========================
   TABLE
=========================== */
table {
  width: 100%;
  border-collapse: collapse;
}

thead th {
  padding: 11px 24px;
  text-align: left;
  font-size: 10.5px;
  font-weight: 700;
  letter-spacing: .09em;
  text-transform: uppercase;
  color: var(--gray-400);
  background: var(--gray-50);
  border-bottom: 1px solid var(--gray-200);
}

tbody tr {
  border-bottom: 1px solid var(--gray-100);
  transition: background .14s;
}

tbody tr:last-child {
  border-bottom: none;
}

tbody tr:hover {
  background: var(--gray-50);
}

tbody tr.row-late {
  background: var(--red-pale);
}

tbody tr.row-late:hover {
  background: #fde8e8;
}

tbody td {
  padding: 13px 24px;
  font-size: 13.5px;
  color: var(--gray-800);
  vertical-align: middle;
}

.task-name {
  font-weight: 600;
}

.task-name.late {
  color: var(--red);
}

.task-sub {
  font-size: 11px;
  color: var(--gray-400);
  margin-top: 2px;
}

/* ===========================
   BADGES
=========================== */
.badge {
  display: inline-flex;
  align-items: center;
  padding: 4px 11px;
  border-radius: 999px;
  font-size: 11.5px;
  font-weight: 700;
  white-space: nowrap;
}

.badge-red {
  background: #fee2e2;
  color: #dc2626;
}

.badge-orange {
  background: #ffedd5;
  color: #c2410c;
}

.badge-yellow {
  background: #fef9c3;
  color: #a16207;
}

.badge-blue {
  background: #dbeafe;
  color: #1d4ed8;
}

.badge-green {
  background: #dcfce7;
  color: #166534;
}

.badge-gray {
  background: var(--gray-100);
  color: var(--gray-600);
}

.status-badge {
  display: inline-flex;
  align-items: center;
  padding: 4px 11px;
  border-radius: 7px;
  font-size: 11.5px;
  font-weight: 700;
  border: 1.5px solid transparent;
}

.status-belum {
  border-color: var(--gray-300, #d1d5db);
  color: var(--gray-600);
  background: var(--white);
}

.status-belum.late {
  border-color: #fca5a5;
  color: var(--red);
  background: #fef2f2;
}

.status-proses {
  border-color: #fdba74;
  color: #c2410c;
  background: #fff7ed;
}

.status-selesai {
  border-color: #86efac;
  color: #166534;
  background: #f0fdf4;
}

/* ===========================
   PROGRESS BAR
=========================== */
.progress-wrap {
  display: flex;
  flex-direction: column;
  gap: 4px;
  min-width: 100px;
}

.progress-label {
  font-size: 11px;
  font-weight: 600;
  color: var(--gray-800);
}

.progress-bar {
  width: 100%;
  height: 6px;
  background-color: var(--gray-200);
  border-radius: 999px;
  overflow: hidden;
}

.progress-fill {
  height: 100%;
  background-color: var(--blue-mid);
  border-radius: 999px;
}

/* ===========================
   TABLE FOOTER
=========================== */
.table-footer {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-top: 14px;
  padding-top: 12px;
  border-top: 1px solid var(--gray-100);
}

.table-info {
  font-size: 11px;
  color: var(--gray-400);
}

.pagination {
  display: flex;
  gap: 6px;
}

.page-btn {
  background: none;
  border: 1.5px solid var(--gray-200);
  border-radius: 6px;
  width: 30px;
  height: 30px;
  font-size: 12px;
  cursor: pointer;
  color: var(--gray-600);
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.2s;
  padding: 0;
}

.page-btn:hover {
  background-color: var(--gray-100);
  border-color: var(--gray-300);
}

.page-btn svg {
  width: 16px;
  height: 16px;
  stroke: currentColor;
  fill: none;
  stroke-width: 2;
  stroke-linecap: round;
  stroke-linejoin: round;
}

/* ===========================
   RESPONSIVE
=========================== */

/* ===========================
   BOTTOM ROW
=========================== */
.bottom-row {
  display: grid;
  grid-template-columns: 1fr 300px;
  gap: 20px;
  align-items: start;
  margin-top: 22px;
}

.chart-card {
  min-height: 200px;
}

.chart-area {
  padding: 12px 0;
}

.bar-chart {
  display: flex;
  align-items: flex-end;
  gap: 12px;
  height: 140px;
  padding: 0 8px;
}

.bar-group {
  flex: 1;
  display: flex;
  align-items: flex-end;
  height: 100%;
}

.bar {
  width: 100%;
  background-color: #bfdbfe;
  border-radius: 4px 4px 0 0;
  transition: opacity .2s;
}

.bar.bar-dark {
  background-color: var(--blue-mid);
}

.bar:hover {
  opacity: .8;
}

/* ===========================
   NOTIFICATION CARD
=========================== */
.notif-card {
  background: linear-gradient(135deg, var(--blue-dark), var(--blue-mid));
  border-radius: var(--radius);
  padding: 22px 20px;
  color: var(--white);
  display: flex;
  flex-direction: column;
  gap: 12px;
  box-shadow: var(--shadow-md);
  height: 20%;
}

.notif-tag {
  font-size: 10px;
  font-weight: 700;
  letter-spacing: .08em;
  text-transform: uppercase;
  color: rgba(255, 255, 255, .75);
}

.notif-text {
  font-size: 14px;
  font-weight: 600;
  line-height: 1.5;
  color: var(--white);
}

.btn-notif {
  display: inline-block;
  background-color: var(--white);
  color: var(--blue-mid);
  text-decoration: none;
  font-size: 12px;
  font-weight: 700;
  padding: 8px 8px;
  border-radius: 6px;
  width: fit-content;
  transition: background-color .2s;
}

.btn-notif:hover {
  background-color: rgba(255, 255, 255, .95);
}

@media (max-width: 1200px) {
  .stats {
    grid-template-columns: repeat(2, 1fr);
  }

  .bottom-row {
    grid-template-columns: 1fr;
  }

  .notif-card {
    height: auto;
  }
}

@media (max-width: 900px) {
  .stats {
    grid-template-columns: repeat(2, 1fr);
  }

  .bottom-row {
    grid-template-columns: 1fr;
  }

  .sidebar {
    width: 70px;
    padding: 20px 8px;
  }

  main {
    margin-left: 70px;
  }

  .nav-item {
    padding: 10px 8px;
    justify-content: center;
  }

  .nav-item span {
    display: none;
  }

  .brand {
    display: none;
  }

  .sidebar-logo {
    justify-content: center;
  }
}
</style>
</html>head>
<body>

  <!-- ===== SIDEBAR ===== -->
  <aside class="sidebar">
    <div class="sidebar-logo">
      <img src="{{ asset('assets/logo.png') }}" class="logo-icon" alt="Logo"/>
      <span class="brand">SITUGAS</span>
    </div>

    <div class="sidebar-divider"></div>

    <nav class="nav-menu">
      <a href="/guru/dashboard" class="nav-item active">
        <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <rect x="3" y="3" width="7" height="7" rx="1.2"/>
          <rect x="14" y="3" width="7" height="7" rx="1.2"/>
          <rect x="3" y="14" width="7" height="7" rx="1.2"/>
          <rect x="14" y="14" width="7" height="7" rx="1.2"/>
        </svg>
        Dashboard
      </a>

      <a href="/guru/kelola-tugas" class="nav-item">
        <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M9 11l3 3L22 4"/>
          <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
        </svg>
        Tugas
      </a>

      <a href="/guru/notifikasi" class="nav-item">
        <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
          <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
        </svg>
        Notifikasi
      </a>
    </nav>

    <div class="sidebar-footer">
      <div class="user-profile">
        <div class="user-avatar">👨‍🏫</div>
        <div class="user-info">
          <p class="user-name">Budi Santoso, S.P</p>
          <p class="user-role">Guru</p>
        </div>
      </div>
      <a href="/login-guru" class="logout-btn">
        <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px; stroke: currentColor; fill: none;">
          <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
          <polyline points="16 17 21 12 16 7"/>
          <line x1="21" y1="12" x2="9" y2="12"/>
        </svg>
        Keluar
      </a>
    </div>
  </aside>

  <!-- ===== MAIN CONTENT ===== -->
  <main>

    <!-- TOP BAR -->
    <header class="topbar">
      <h2 class="page-title">Dashboard Guru</h2>
      <div class="topbar-actions">
        <button class="icon-btn">
          <svg viewBox="0 0 24 24">
            <circle cx="11" cy="11" r="8"/>
            <path d="m21 21-4.35-4.35"/>
          </svg>
        </button>
        <button class="icon-btn">
          <svg viewBox="0 0 24 24">
            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
            <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
          </svg>
        </button>
        <a href="/guru/buat-tugas" class="btn-primary" style="text-decoration:none;">
          <svg viewBox="0 0 24 24">
            <line x1="12" y1="5" x2="12" y2="19"/>
            <line x1="5" y1="12" x2="19" y2="12"/>
          </svg>
          Buat Tugas
        </a>
      </div>
    </header>

    <!-- STAT CARDS -->
    <section class="stats">
      <div class="stat-card">
        <p class="stat-label">TOTAL TUGAS</p>
        <p class="stat-value">12</p>
      </div>
      <div class="stat-card">
        <p class="stat-label">BELUM AKTIF</p>
        <p class="stat-value">5</p>
      </div>
      <div class="stat-card">
        <p class="stat-label">TOTAL MURID</p>
        <p class="stat-value">156</p>
      </div>
      <div class="stat-card">
        <p class="stat-label">AKTIF TUGAS</p>
        <p class="stat-value">3</p>
      </div>
    </section>

    <!-- TUGAS TERKINI -->
    <section class="card">
      <div class="card-header">
        <h3 class="card-title">Tugas Terkini</h3>
        <a href="/guru/kelola-tugas" class="link-all">Lihat Semua</a>
      </div>

      <table>
        <thead>
          <tr>
            <th>JUDUL</th>
            <th>KELAS</th>
            <th>DEADLINE</th>
            <th>STATUS WAKTU</th>
            <th>SELESAI</th>
            <th>AKSI</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              <p class="task-name">Trigonometri Lengkap</p>
              <p class="task-sub">Kelas 1 - Kuis 1</p>
            </td>
            <td><span class="badge badge-blue">IX KIMIA 1</span></td>
            <td>24 Okt 2023</td>
            <td><span class="badge badge-orange">2 Hari</span></td>
            <td>
              <div class="progress-wrap">
                <span class="progress-label">26/32</span>
                <div class="progress-bar"><div class="progress-fill" style="width: 81%"></div></div>
              </div>
            </td>
            <td><button class="icon-btn">
              <svg viewBox="0 0 24 24">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                <circle cx="12" cy="12" r="3"/>
              </svg>
            </button></td>
          </tr>
          <tr>
            <td>
              <p class="task-name">Integral Sejatinya</p>
              <p class="task-sub">Ulangan Harian</p>
            </td>
            <td><span class="badge badge-green">IX MIPA 1</span></td>
            <td>22 Okt 2023</td>
            <td><span class="badge badge-green">Selesai</span></td>
            <td>
              <div class="progress-wrap">
                <span class="progress-label">30/32</span>
                <div class="progress-bar"><div class="progress-fill" style="width: 94%"></div></div>
              </div>
            </td>
            <td><button class="icon-btn">
              <svg viewBox="0 0 24 24">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                <circle cx="12" cy="12" r="3"/>
              </svg>
            </button></td>
          </tr>
          <tr>
            <td>
              <p class="task-name">Statistika Inferensial</p>
              <p class="task-sub">Ulangan Harian</p>
            </td>
            <td><span class="badge badge-blue">IX KIMIA 1</span></td>
            <td>20 Okt 2023</td>
            <td><span class="badge badge-orange">2 Hari</span></td>
            <td>
              <div class="progress-wrap">
                <span class="progress-label">18/30</span>
                <div class="progress-bar"><div class="progress-fill" style="width: 60%"></div></div>
              </div>
            </td>
            <td><button class="icon-btn">
              <svg viewBox="0 0 24 24">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                <circle cx="12" cy="12" r="3"/>
              </svg>
            </button></td>
          </tr>
          <tr>
            <td>
              <p class="task-name">Vektor Ruang 3D</p>
              <p class="task-sub">Ulangan Akhir</p>
            </td>
            <td><span class="badge badge-blue">IX MIPA 2</span></td>
            <td>25 Okt 2023</td>
            <td><span class="badge badge-red">3 Jam</span></td>
            <td>
              <div class="progress-wrap">
                <span class="progress-label">20/30</span>
                <div class="progress-bar"><div class="progress-fill" style="width: 67%"></div></div>
              </div>
            </td>
            <td><button class="icon-btn">
              <svg viewBox="0 0 24 24">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                <circle cx="12" cy="12" r="3"/>
              </svg>
            </button></td>
          </tr>
        </tbody>
      </table>

      <div class="table-footer">
        <p class="table-info">Menampilkan 4 dari 12 tugas aktif</p>
        <div class="pagination">
          <button class="page-btn">
            <svg viewBox="0 0 24 24">
              <polyline points="15 18 9 12 15 6"></polyline>
            </svg>
          </button>
          <button class="page-btn">
            <svg viewBox="0 0 24 24">
              <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
          </button>
        </div>
      </div>
    </section>

    <!-- BOTTOM ROW: Aktivitas Kelas + Notifikasi -->
    

      <!-- Notifikasi -->
      <section class="notif-card">
        <p class="notif-tag">PENGUMUMAN TERBARU</p>
        <p class="notif-text">Input Nilai UTS Semester Ganjil ditutup dalam 2 hari.</p>
        <a href="/guru/notifikasi" class="btn-notif">Baca Selengkapnya</a>
      </section>

    </div>
  </main>

</body>
</html>