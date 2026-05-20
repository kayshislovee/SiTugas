<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SITUGAS – Dashboard</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

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
    background: var(--gray-50);
    color: var(--gray-800);
    display: flex;
    min-height: 100vh;
    overflow-x: hidden;
  }

  /* ── SIDEBAR ── */
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
      top: 0; left: 0; bottom: 0;
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
    .nav-item:hover svg { stroke: #fff; }

  .nav-item.active {
  background: #fff;
  color: #2451d1;
  font-weight: 700;
}
.nav-item.active svg { stroke: #2451d1; }
  /* ── MAIN ── */
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

  /* ── STAT CARDS ── */
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

  .stat-card:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); }

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

  /* ── ALERT BANNER ── */
  .alert-banner {
    background: var(--blue-pale);
    border: 1.5px solid #c7d7fe;
    border-radius: var(--radius);
    padding: 14px 20px;
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 24px;
    animation: fadeUp .5s .08s ease both;
  }

  .alert-icon {
    width: 28px; height: 28px;
    background: var(--blue-mid);
    color: white;
    border-radius: 8px;
    display: grid; place-items: center;
    font-size: 15px;
    font-weight: 800;
    flex-shrink: 0;
  }

  .alert-text {
    font-size: 14px;
    font-weight: 600;
    color: var(--blue-mid);
  }

  /* ── TABLE CARD ── */
  .table-card {
    background: var(--white);
    border-radius: var(--radius);
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--gray-200);
    overflow: hidden;
    animation: fadeUp .5s .14s ease both;
  }

  .table-header {
    padding: 20px 24px 16px;
    border-bottom: 1px solid var(--gray-100);
  }

  .table-title {
    font-size: 16px;
    font-weight: 800;
    color: var(--gray-800);
  }

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

  tbody tr:last-child { border-bottom: none; }
  tbody tr:hover { background: var(--gray-50); }
  tbody tr.row-late { background: var(--red-pale); }
  tbody tr.row-late:hover { background: #fde8e8; }

  tbody td {
    padding: 13px 24px;
    font-size: 13.5px;
    color: var(--gray-800);
    vertical-align: middle;
  }

  .task-name { font-weight: 600; }
  .task-name.late { color: var(--red); }

  /* ── BADGES ── */
  .badge {
    display: inline-flex;
    align-items: center;
    padding: 4px 11px;
    border-radius: 999px;
    font-size: 11.5px;
    font-weight: 700;
    white-space: nowrap;
  }

  .badge-red    { background:#fee2e2; color:#dc2626; }
  .badge-orange { background:#ffedd5; color:#c2410c; }
  .badge-yellow { background:#fef9c3; color:#a16207; }
  .badge-blue   { background:#dbeafe; color:#1d4ed8; }
  .badge-green  { background:#dcfce7; color:#166534; }
  .badge-gray   { background:var(--gray-100); color:var(--gray-600); }

  .status-badge {
    display: inline-flex;
    align-items: center;
    padding: 4px 11px;
    border-radius: 7px;
    font-size: 11.5px;
    font-weight: 700;
    border: 1.5px solid transparent;
  }

  .status-belum   { border-color:var(--gray-300,#d1d5db); color:var(--gray-600); background:var(--white); }
  .status-belum.late { border-color:#fca5a5; color:var(--red); background:#fef2f2; }
  .status-proses  { border-color:#fdba74; color:#c2410c; background:#fff7ed; }
  .status-selesai { border-color:#86efac; color:#166534; background:#f0fdf4; }
</style>
</head>
<body>

<!-- SIDEBAR -->
<aside class="sidebar">
    <div class="sidebar-logo">
      <img src="{{ asset('assets/logo.png') }}" class="logo-icon" alt="Logo"/>
      <span class="brand">SITUGAS</span>
    </div>

    <div class="sidebar-divider"></div>

    <nav class="nav-menu">
      <a href="/siswa/dashboard" class="nav-item active">
        <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <rect x="3" y="3" width="7" height="7" rx="1.2"/>
          <rect x="14" y="3" width="7" height="7" rx="1.2"/>
          <rect x="3" y="14" width="7" height="7" rx="1.2"/>
          <rect x="14" y="14" width="7" height="7" rx="1.2"/>
        </svg>
        Dashboard
      </a>

      <a href="/siswa/tugas" class="nav-item">
        <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M9 11l3 3L22 4"/>
          <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
        </svg>
        Tugas
      </a>

      <a href="/siswa/notifikasi" class="nav-item">
        <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
          <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
        </svg>
        Notifikasi
      </a>
    </nav>
  </aside>

<!-- MAIN -->
<main>

  <!-- STAT CARDS -->
  <div class="stats">
    <div class="stat-card">
      <div class="stat-label">Total Tugas</div>
      <div class="stat-value">2</div>
    </div>
    <div class="stat-card">
      <div class="stat-label">Segera Berakhir</div>
      <div class="stat-value">2</div>
    </div>
    <div class="stat-card">
      <div class="stat-label">Sudah Lewat</div>
      <div class="stat-value">1</div>
    </div>
    <div class="stat-card">
      <div class="stat-label">Belum Dikerjakan</div>
      <div class="stat-value">5</div>
    </div>
  </div>

  <!-- ALERT BANNER -->
  <div class="alert-banner">
    <div class="alert-icon">!</div>
    <span class="alert-text">Kamu memiliki tugas yang harus segera dikumpulkan.</span>
  </div>

  <!-- TABLE -->
  <div class="table-card">
    <div class="table-header">
      <div class="table-title">Daftar Tugas Terbaru</div>
    </div>
    <table>
      <thead>
        <tr>
          <th>Judul Tugas</th>
          <th>Mata Pelajaran</th>
          <th>Deadline</th>
          <th>Sisa Waktu</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <tr class="row-late">
          <td><span class="task-name late">Analisisi Data Network</span></td>
          <td>Matematika</td>
          <td>Kemarin 23.00</td>
          <td><span class="badge badge-red">Terlambat</span></td>
          <td><span class="status-badge status-belum late">Belum</span></td>
        </tr>
        <tr>
          <td><span class="task-name">Analisisi Data Network</span></td>
          <td>Matematika</td>
          <td>Besok, 9.00</td>
          <td><span class="badge badge-orange">3 Jam</span></td>
          <td><span class="status-badge status-proses">Proses</span></td>
        </tr>
        <tr>
          <td><span class="task-name">Analisisi Data Network</span></td>
          <td>Matematika</td>
          <td>Hari ini, 7.00</td>
          <td><span class="badge badge-yellow">10 Jam</span></td>
          <td><span class="status-badge status-belum">Belum</span></td>
        </tr>
        <tr>
          <td><span class="task-name">Analisisi Data Network</span></td>
          <td>Matematika</td>
          <td>22 Mei 2026, 23.00</td>
          <td><span class="badge badge-blue">15 Hari</span></td>
          <td><span class="status-badge status-belum">Belum</span></td>
        </tr>
        <tr>
          <td><span class="task-name">Analisisi Data Network</span></td>
          <td>Matematika</td>
          <td>22 Mei 2026, 23.00</td>
          <td><span class="badge badge-blue">15 Hari</span></td>
          <td><span class="status-badge status-belum">Belum</span></td>
        </tr>
      </tbody>
    </table>
  </div>

</main>

</body>
</html>