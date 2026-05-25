<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SITUGAS — Tugas Guru</title>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet"/>
  <style>
    *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

    :root {
      --blue:       #2d52ff;
      --blue-dark:  #1a38cc;
      --sidebar-w:  210px;
    }

    html, body {
      height: 100%;
      font-family: 'Plus Jakarta Sans', sans-serif;
      background: #f0f4ff;
    }
    body { display: flex; min-height: 100vh; }

    /* ══════════════════════════
       SIDEBAR
    ══════════════════════════ */
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

    /* ── Logo ── */
    .sidebar-logo {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      margin-bottom: 18px;
      padding: 0 6px;
    }

    /*
      GANTI LOGO ANGSA:
      Hapus tag <svg class="logo-icon"> di bawah,
      lalu ganti dengan:
        <img src="assets/logo-angsa.png" class="logo-icon" style="width:38px;height:38px;object-fit:contain;"/>
    */
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

    /* Garis separator di bawah logo */
    .sidebar-divider {
      width: 100%;
      height: 1px;
      background: rgba(255,255,255,0.28);
      margin-bottom: 28px;
    }

    /* ── Nav items ── */
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

    /* Active: background putih, teks biru */
    .nav-item.active {
      background: #fff;
      color: var(--blue);
      font-weight: 700;
      border-left: none;
      padding-left: 16px;
    }
    .nav-item.active svg {
      stroke: var(--blue);
    }

    /* ══════════════════════════
       MAIN
    ══════════════════════════ */
    .main {
      margin-left: var(--sidebar-w);
      flex: 1;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    /* Topbar */
    .topbar {
      height: 64px;
      background: #fff;
      display: flex;
      align-items: center;
      justify-content: flex-end;
      padding: 0 36px;
      border-bottom: 1px solid #e4eaf5;
      position: sticky;
      top: 0;
      z-index: 50;
    }

    .btn-buat {
      padding: 11px 26px;
      background: var(--blue);
      color: #fff;
      font-size: 14px;
      font-weight: 700;
      font-family: 'Plus Jakarta Sans', sans-serif;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      letter-spacing: 0.3px;
      transition: background 0.2s, transform 0.15s;
    }
    .btn-buat:hover { background: var(--blue-dark); }
    .btn-buat:active { transform: scale(0.97); }

    /* Content */
    .content {
      flex: 1;
      padding: 32px 36px;
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    /* ══════════════════════════
       CARD UMUM
    ══════════════════════════ */
    .card {
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 2px 16px rgba(45,82,255,0.06);
      overflow: hidden;
    }

    /* ── Card Judul Tugas ── */
    .tugas-header {
      padding: 20px 28px 16px;
    }
    .tugas-header h2 {
      font-size: 18px;
      font-weight: 700;
      color: #1a2060;
      margin-bottom: 10px;
    }
    .tugas-meta {
      display: flex;
      align-items: center;
      gap: 8px;
      flex-wrap: wrap;
    }
    .tugas-meta .meta-plain {
      font-size: 13px;
      color: #555;
      font-weight: 500;
    }
    .badge {
      display: inline-block;
      padding: 3px 12px;
      border-radius: 999px;
      font-size: 12px;
      font-weight: 600;
    }
    .badge-blue  { background: #e0e8ff; color: #2d52ff; }
    .badge-red   { background: #ffe5e5; color: #e05252; }

    .tugas-header-row {
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
      padding: 20px 28px 0;
    }

    .btn-edit {
      padding: 9px 22px;
      border: 1.5px solid #dde3f0;
      border-radius: 8px;
      background: #fff;
      color: #333;
      font-size: 13px;
      font-weight: 600;
      font-family: 'Plus Jakarta Sans', sans-serif;
      cursor: pointer;
      transition: background 0.2s, border-color 0.2s;
      white-space: nowrap;
      flex-shrink: 0;
    }
    .btn-edit:hover { background: #f5f7ff; border-color: #aabbdd; }

    .tugas-divider {
      border: none;
      border-top: 1px solid #eef1f8;
      margin: 16px 28px 0;
    }

    .tugas-desc {
      padding: 18px 28px 28px;
      font-size: 13px;
      color: #667;
      line-height: 1.7;
      min-height: 90px;
    }

    /* ── Card Daftar Pengumpulan ── */
    .pengumpulan-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 18px 24px 14px;
      border-bottom: 1px solid #f0f2f8;
    }
    .pengumpulan-header h3 {
      font-size: 15px;
      font-weight: 700;
      color: #1a2060;
    }

    .search-box {
      padding: 8px 16px;
      border: 1.5px solid #e4eaf5;
      border-radius: 999px;
      font-size: 12px;
      color: #555;
      font-family: 'Plus Jakarta Sans', sans-serif;
      background: #f7f9ff;
      outline: none;
      width: 200px;
      transition: border-color 0.2s;
    }
    .search-box:focus { border-color: var(--blue); }
    .search-box::placeholder { color: #aaa; }

    /* Table */
    table {
      width: 100%;
      border-collapse: collapse;
    }
    thead tr {
      background: #f5f7ff;
    }
    thead th {
      padding: 12px 20px;
      font-size: 11px;
      font-weight: 700;
      letter-spacing: 0.8px;
      text-transform: uppercase;
      color: #8899bb;
      text-align: left;
    }
    tbody tr {
      border-top: 1px solid #f0f2f8;
      transition: background 0.15s;
    }
    tbody tr:hover { background: #f8faff; }
    tbody td {
      padding: 14px 20px;
      font-size: 13px;
      color: #333;
      font-weight: 500;
    }

    /* Status badges */
    .status-sudah {
      display: inline-block;
      padding: 5px 14px;
      border-radius: 999px;
      font-size: 12px;
      font-weight: 600;
      background: transparent;
      border: 1.5px solid #22c08a;
      color: #22c08a;
    }
    .status-belum {
      display: inline-block;
      padding: 5px 14px;
      border-radius: 999px;
      font-size: 12px;
      font-weight: 600;
      background: transparent;
      border: 1.5px solid #ccd0dd;
      color: #555;
    }

    /* Aksi buttons */
    .btn-tandai-belum {
      padding: 7px 18px;
      border: 1.5px solid var(--blue);
      border-radius: 8px;
      background: #fff;
      color: var(--blue);
      font-size: 12px;
      font-weight: 700;
      font-family: 'Plus Jakarta Sans', sans-serif;
      cursor: pointer;
      transition: background 0.2s;
    }
    .btn-tandai-belum:hover { background: #eef1ff; }

    .btn-tandai-sudah {
      padding: 7px 18px;
      border: none;
      border-radius: 8px;
      background: var(--blue);
      color: #fff;
      font-size: 12px;
      font-weight: 700;
      font-family: 'Plus Jakarta Sans', sans-serif;
      cursor: pointer;
      transition: background 0.2s;
    }
    .btn-tandai-sudah:hover { background: var(--blue-dark); }
  </style>
</head>
<body>

  <!-- ══ SIDEBAR ══ -->
  <aside class="sidebar">

    <div class="sidebar-logo">
      <img src="{{ asset('assets/logo.png') }}" class="logo-icon" alt="Logo"/>
      <span class="brand">SITUGAS</span>
    </div>

    <!-- Separator -->
    <div class="sidebar-divider"></div>

    <!-- Nav -->
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

  <!-- ══ MAIN ══ -->
  <div class="main">

    <!-- Topbar -->
    <header class="topbar">
      <span style="font-size:14px;font-weight:600;color:#6e7faa;">Daftar Tugas Saya</span>
    </header>

    <!-- Content -->
    <div class="content">

      @forelse($pengumpulan as $p)
      <!-- Card Info Tugas -->
      <div class="card">
        <div class="tugas-header-row">
          <div class="tugas-header" style="padding:0; flex:1;">
            <h2>{{ $p->tugas->judul }}</h2>
            <div class="tugas-meta">
              <span class="meta-plain">{{ $p->tugas->mapel }}</span>
              <span class="badge badge-blue">{{ $p->tugas->kelas }}</span>
              <span class="badge badge-red">Deadline: {{ $p->tugas->tgl_pengumpulan->format('d M Y') }}</span>
              @if($p->status === 'sudah')
                <span class="badge" style="background:#dcfce7;color:#166534;">✓ Sudah Dikumpulkan</span>
              @elseif($p->tugas->isExpired())
                <span class="badge" style="background:#fee2e2;color:#991b1b;">Terlambat</span>
              @else
                <span class="badge" style="background:#fef9c3;color:#854d0e;">Belum Dikumpulkan</span>
              @endif
            </div>
          </div>
        </div>

        <hr class="tugas-divider"/>

        <div class="tugas-desc">
          {{ $p->tugas->deskripsi ?? '(Tidak ada deskripsi)' }}
        </div>
      </div>
      @empty
      <div class="card" style="padding:40px;text-align:center;color:#9aa5c4;">
        <p style="font-size:15px;font-weight:600;">Belum ada tugas untukmu saat ini.</p>
        <p style="font-size:13px;margin-top:6px;">Tugas akan muncul di sini ketika gurumu menambahkan tugas untuk kelasmu.</p>
      </div>
      @endforelse

    </div>
  </div>

</body>
</html>