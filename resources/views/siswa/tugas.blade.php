<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>SiTugas – Detail Tugas</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet"/>
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  :root {
    --blue: #2563EB;
    --blue-dark: #1d4ed8;
    --blue-light: #eff6ff;
    --sidebar-w: 210px;
    --green: #16a34a;
    --green-bg: #dcfce7;
    --red: #dc2626;
    --red-bg: #fee2e2;
    --gray-50: #f9fafb;
    --gray-100: #f3f4f6;
    --gray-200: #e5e7eb;
    --gray-400: #9ca3af;
    --gray-500: #6b7280;
    --gray-700: #374151;
    --gray-900: #111827;
    --radius: 14px;
  }

  body {
    font-family: 'Plus Jakarta Sans', sans-serif;
    background: var(--gray-100);
    min-height: 100vh;
    display: flex;
    color: var(--gray-900);
  }

  /* ─── SIDEBAR ─── */
  .sidebar {
    width: var(--sidebar-w);
    min-height: 100vh;
    background: linear-gradient(160deg, #1e3a8a 0%, #2563eb 55%, #3b82f6 100%);
    display: flex;
    flex-direction: column;
    padding: 28px 16px 24px;
    flex-shrink: 0;
    position: fixed;
    top: 0; left: 0; bottom: 0;
    z-index: 100;
    box-shadow: 4px 0 24px rgba(37,99,235,0.18);
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
    color: var(--blue);
    font-weight: 700;
  }
  .nav-item.active svg {
    stroke: var(--blue);
  }

  /* ─── MAIN CONTENT ─── */
  .main {
    margin-left: var(--sidebar-w);
    flex: 1;
    padding: 36px 36px 36px 36px;
    display: flex;
    flex-direction: column;
    gap: 24px;
    min-height: 100vh;
  }

  /* ─── CARD ─── */
  .card {
    background: #fff;
    border-radius: var(--radius);
    box-shadow: 0 1px 4px rgba(0,0,0,0.06), 0 4px 16px rgba(0,0,0,0.04);
    padding: 28px 32px;
  }

  /* ─── DETAIL TUGAS ─── */
  .tugas-title {
    font-size: 20px;
    font-weight: 800;
    color: var(--gray-900);
    margin-bottom: 6px;
  }

  .tugas-meta {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 20px;
  }

  .badge {
    display: inline-flex;
    align-items: center;
    padding: 3px 10px;
    border-radius: 6px;
    font-size: 11.5px;
    font-weight: 700;
    letter-spacing: 0.2px;
  }
  .badge-mapel {
    background: var(--gray-100);
    color: var(--gray-700);
  }
  .badge-kelas {
    background: #dbeafe;
    color: var(--blue);
  }
  .badge-deadline {
    background: #fef9c3;
    color: #a16207;
  }

  .divider {
    width: 100%;
    height: 1px;
    background: var(--gray-200);
    margin: 0 0 20px 0;
  }

  .tugas-desc {
    font-size: 14.5px;
    color: var(--gray-700);
    line-height: 1.7;
  }

  /* ─── DAFTAR PENGUMPULAN ─── */
  .table-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 16px;
  }

  .table-title {
    font-size: 15px;
    font-weight: 700;
    color: var(--gray-900);
  }

  .search-box {
    display: flex;
    align-items: center;
    gap: 8px;
    background: var(--gray-50);
    border: 1.5px solid var(--gray-200);
    border-radius: 8px;
    padding: 7px 14px;
    font-size: 13px;
    color: var(--gray-400);
    cursor: text;
    transition: border 0.2s;
  }
  .search-box:hover { border-color: var(--blue); }
  .search-box svg {
    width: 15px; height: 15px;
    stroke: var(--gray-400);
    flex-shrink: 0;
  }

  table {
    width: 100%;
    border-collapse: collapse;
  }

  thead tr {
    border-bottom: 2px solid var(--gray-100);
  }

  th {
    text-align: left;
    font-size: 12px;
    font-weight: 700;
    color: var(--gray-500);
    letter-spacing: 0.5px;
    text-transform: uppercase;
    padding: 10px 14px;
  }

  td {
    padding: 14px 14px;
    font-size: 13.5px;
    color: var(--gray-700);
    border-bottom: 1px solid var(--gray-100);
    font-weight: 500;
  }

  tbody tr:last-child td { border-bottom: none; }

  tbody tr:hover td { background: var(--gray-50); }

  .status-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 5px 12px;
    border-radius: 7px;
    font-size: 12.5px;
    font-weight: 700;
  }
  .status-done {
    background: var(--green-bg);
    color: var(--green);
  }
  .status-pending {
    background: var(--gray-100);
    color: var(--gray-500);
  }
  .status-dot {
    width: 7px; height: 7px;
    border-radius: 50%;
    flex-shrink: 0;
  }
  .status-done .status-dot { background: var(--green); }
  .status-pending .status-dot { background: var(--gray-400); }
</style>
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-logo">
      <img src="{{ asset('assets/logo.png') }}" class="logo-icon" alt="Logo"/>
      <span class="brand">SITUGAS</span>
    </div>

    <div class="sidebar-divider"></div>

    <nav class="nav-menu">
      <a href="/siswa/dashboard" class="nav-item">
        <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <rect x="3" y="3" width="7" height="7" rx="1.2"/>
          <rect x="14" y="3" width="7" height="7" rx="1.2"/>
          <rect x="3" y="14" width="7" height="7" rx="1.2"/>
          <rect x="14" y="14" width="7" height="7" rx="1.2"/>
        </svg>
        Dashboard
      </a>

      <a href="/siswa/tugas" class="nav-item active">
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
<main class="main">

  <!-- Card: Detail Tugas -->
  <div class="card">
    <h1 class="tugas-title">Trigonometri Lanjutan</h1>
    <div class="tugas-meta">
      <span class="badge badge-mapel">Matematika</span>
      <span class="badge badge-kelas">XI RPL 2</span>
      <span class="badge badge-deadline">26 Mei 2025</span>
    </div>
    <div class="divider"></div>
    <p class="tugas-desc">Kerjakan latihan soal halaman 120–125 di buku paket Matematika Peminatan.</p>
  </div>

  <!-- Card: Daftar Pengumpulan -->
  <div class="card">
    <div class="table-header">
      <span class="table-title">Daftar Pengumpulan</span>
      <div class="search-box">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="2.2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        Cari nama murid...
      </div>
    </div>

    <table>
      <thead>
        <tr>
          <th>Nama Siswa</th>
          <th>NIS</th>
          <th>Kelas</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Raden Mas Aris Munandar</td>
          <td>324577</td>
          <td>XII TKJ 2</td>
          <td>
            <span class="status-badge status-done">
              <span class="status-dot"></span>
              Sudah Dikerjakan
            </span>
          </td>
        </tr>
        <tr>
          <td>Raden Mas Aris Munandar</td>
          <td>324577</td>
          <td>XII TKJ 2</td>
          <td>
            <span class="status-badge status-pending">
              <span class="status-dot"></span>
              Belum Dikerjakan
            </span>
          </td>
        </tr>
      </tbody>
    </table>
  </div>

</main>
</body>
</html>