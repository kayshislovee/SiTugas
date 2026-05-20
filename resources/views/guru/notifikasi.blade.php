<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SITUGAS — Notifikasi Guru</title>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
  <style>
    *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

    :root {
      --blue:      #2451d1;
      --blue-dark: #1a38cc;
      --sidebar-w: 220px;
    }

    html, body {
      height: 100%;
      font-family: 'Plus Jakarta Sans', sans-serif;
      background: #f4f7ff;
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

    .sidebar-logo {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      margin-bottom: 18px;
      padding: 0 6px;
    }
    .logo-icon { width: 38px; height: 35px; flex-shrink: 0; }
    .brand {
      font-family: 'Syne', sans-serif;
      font-size: 15px;
      font-weight: 800;
      color: #fff;
      letter-spacing: 1px;
    }
    .sidebar-divider {
      width: 100%; height: 1px;
      background: rgba(255,255,255,0.28);
      margin-bottom: 28px;
    }
    .nav-menu { display: flex; flex-direction: column; gap: 4px; width: 100%; }
    .nav-item {
      display: flex; align-items: center; gap: 11px;
      padding: 11px 16px; border-radius: 10px; cursor: pointer;
      color: rgba(255,255,255,0.75); font-size: 14px; font-weight: 600;
      text-decoration: none; transition: all 0.2s; white-space: nowrap;
    }
    .nav-item svg {
      width: 19px; height: 19px; flex-shrink: 0;
      stroke: rgba(255,255,255,0.75); fill: none; transition: stroke 0.2s;
    }
    .nav-item:hover { background: rgba(255,255,255,0.13); color: #fff; }
    .nav-item:hover svg { stroke: #fff; }
    .nav-item.active { background: #fff; color: var(--blue); font-weight: 700; }
    .nav-item.active svg { stroke: var(--blue); }

    /* ══════════════════════════
       MAIN
    ══════════════════════════ */
    .main {
      margin-left: var(--sidebar-w);
      flex: 1; display: flex; flex-direction: column; min-height: 100vh;
    }

    /* ── Topbar ── */
    .topbar {
      height: 60px; background: #fff;
      border-bottom: 1px solid #e8edf5;
      display: flex; align-items: center;
      padding: 0 28px; gap: 14px;
      position: sticky; top: 0; z-index: 50;
    }
    .topbar-title {
      font-size: 17px; font-weight: 800; color: #0f1740;
      font-family: 'Syne', sans-serif; letter-spacing: -0.2px; margin-right: auto;
    }
    .search-wrap { position: relative; }
    .search-wrap svg {
      position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
      width: 15px; height: 15px; stroke: #9aa5c4; fill: none;
      stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;
    }
    .search-input {
      padding: 8px 14px 8px 36px; border: 1.5px solid #e4eaf5; border-radius: 9px;
      font-size: 13px; font-family: 'Plus Jakarta Sans', sans-serif;
      color: #1a2060; background: #f8faff; outline: none; width: 230px;
      transition: border-color 0.2s, box-shadow 0.2s;
    }
    .search-input::placeholder { color: #bcc5dd; }
    .search-input:focus {
      border-color: var(--blue); box-shadow: 0 0 0 3px rgba(36,81,209,0.09); background: #fff;
    }

    /* ══════════════════════════
       CONTENT
    ══════════════════════════ */
    .content { flex: 1; padding: 24px 28px 40px; }

    /* ── Summary cards ── */
    .summary-row {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 14px;
      margin-bottom: 22px;
    }
    .summary-card {
      background: #fff;
      border-radius: 13px;
      border: 1px solid #e4eaf5;
      padding: 16px 18px;
      display: flex;
      align-items: center;
      gap: 13px;
      box-shadow: 0 1px 6px rgba(36,81,209,0.04);
      transition: transform 0.18s, box-shadow 0.18s;
      cursor: default;
    }
    .summary-card:hover { transform: translateY(-2px); box-shadow: 0 4px 16px rgba(36,81,209,0.09); }
    .summary-icon {
      width: 40px; height: 40px; border-radius: 11px;
      display: grid; place-items: center; flex-shrink: 0;
    }
    .summary-icon svg { width: 19px; height: 19px; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
    .summary-icon.blue   { background: #e8eeff; }
    .summary-icon.blue svg { stroke: #2451d1; }
    .summary-icon.orange { background: #fff3e8; }
    .summary-icon.orange svg { stroke: #e07b2a; }
    .summary-icon.green  { background: #e8faf0; }
    .summary-icon.green svg  { stroke: #1a9c54; }
    .summary-icon.red    { background: #fef0f0; }
    .summary-icon.red svg    { stroke: #d94040; }
    .summary-text-val {
      font-size: 22px; font-weight: 800; color: #0f1740;
      line-height: 1; margin-bottom: 2px;
    }
    .summary-text-lbl {
      font-size: 11px; font-weight: 600; color: #9aa5c4; letter-spacing: 0.2px;
    }

    /* ── Tabs ── */
    .tabs {
      display: flex; align-items: center; gap: 2px;
      margin-bottom: 16px; border-bottom: 1.5px solid #e8edf5;
    }
    .tab {
      padding: 10px 18px 11px; font-size: 13.5px; font-weight: 600;
      color: #8896b8; cursor: pointer; border-bottom: 2.5px solid transparent;
      margin-bottom: -1.5px; transition: color 0.18s, border-color 0.18s; white-space: nowrap;
    }
    .tab:hover { color: #2451d1; }
    .tab.active { color: #2451d1; border-bottom-color: #2451d1; font-weight: 700; }
    .tab-badge {
      display: inline-flex; align-items: center; justify-content: center;
      min-width: 18px; height: 18px; padding: 0 5px;
      background: #e8eeff; color: #2451d1; border-radius: 999px;
      font-size: 10px; font-weight: 800; margin-left: 5px;
    }
    .tab-mark-all {
      margin-left: auto; font-size: 12.5px; font-weight: 600;
      color: #2451d1; cursor: pointer; padding: 6px 0 10px;
      display: flex; align-items: center; gap: 5px; opacity: 0.85; transition: opacity 0.18s;
    }
    .tab-mark-all:hover { opacity: 1; }
    .tab-mark-all svg {
      width: 14px; height: 14px; stroke: currentColor; fill: none;
      stroke-width: 2.2; stroke-linecap: round; stroke-linejoin: round;
    }

    /* ── Notif list ── */
    .notif-list {
      background: #fff; border-radius: 14px;
      border: 1px solid #e4eaf5; overflow: hidden;
      box-shadow: 0 2px 12px rgba(36,81,209,0.05);
    }

    /* ── Group header ── */
    .notif-group-header {
      padding: 10px 22px 8px;
      font-size: 10.5px; font-weight: 700; letter-spacing: 1px;
      text-transform: uppercase; color: #9aa5c4;
      background: #f8faff; border-bottom: 1px solid #f0f3fa;
    }

    .notif-item {
      display: flex; align-items: flex-start; gap: 13px;
      padding: 15px 22px; border-bottom: 1px solid #f0f3fa;
      position: relative; transition: background 0.15s; cursor: pointer;
    }
    .notif-item:last-child { border-bottom: none; }
    .notif-item:hover { background: #f8faff; }
    .notif-item.unread { background: #f5f8ff; }
    .notif-item.unread:hover { background: #eff3ff; }

    .notif-dot {
      width: 7px; height: 7px; border-radius: 50%;
      background: #2451d1; flex-shrink: 0; margin-top: 7px;
    }
    .notif-dot.invisible { background: transparent; }

    .notif-icon {
      width: 38px; height: 38px; border-radius: 10px;
      display: grid; place-items: center; flex-shrink: 0;
    }
    .notif-icon svg {
      width: 17px; height: 17px; fill: none;
      stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;
    }
    .notif-icon.blue   { background: #e8eeff; }
    .notif-icon.blue svg { stroke: #2451d1; }
    .notif-icon.orange { background: #fff3e8; }
    .notif-icon.orange svg { stroke: #e07b2a; }
    .notif-icon.green  { background: #e8faf0; }
    .notif-icon.green svg  { stroke: #1a9c54; }
    .notif-icon.red    { background: #fef0f0; }
    .notif-icon.red svg    { stroke: #d94040; }
    .notif-icon.purple { background: #f3eeff; }
    .notif-icon.purple svg { stroke: #7c4dcc; }
    .notif-icon.gray   { background: #f0f3fa; }
    .notif-icon.gray svg   { stroke: #7a87aa; }

    .notif-body { flex: 1; min-width: 0; }
    .notif-title {
      font-size: 13.5px; font-weight: 700; color: #0f1740;
      margin-bottom: 3px; line-height: 1.35;
    }
    .notif-item:not(.unread) .notif-title { font-weight: 600; color: #3a4468; }
    .notif-desc {
      font-size: 12.5px; color: #7a87aa; line-height: 1.55; margin-bottom: 7px;
    }

    /* Student avatar inline */
    .notif-student {
      display: inline-flex; align-items: center; gap: 5px;
      font-size: 11px; font-weight: 700; color: #5a6890;
      background: #f0f3fa; border-radius: 6px; padding: 2px 8px 2px 4px;
      margin-bottom: 6px;
    }
    .student-avatar-sm {
      width: 18px; height: 18px; border-radius: 5px;
      background: linear-gradient(135deg, #4e7fff, #2451d1);
      display: grid; place-items: center;
      font-size: 8px; font-weight: 800; color: #fff;
    }

    .notif-meta {
      display: flex; align-items: center; gap: 6px; flex-wrap: wrap;
    }
    .notif-tag {
      display: inline-flex; align-items: center; gap: 4px;
      font-size: 10.5px; font-weight: 700; letter-spacing: 0.5px;
      text-transform: uppercase; color: #8896b8;
    }
    .notif-tag svg {
      width: 11px; height: 11px; stroke: currentColor; fill: none;
      stroke-width: 2.2; stroke-linecap: round; stroke-linejoin: round;
    }
    .notif-tag-dot { width: 3px; height: 3px; border-radius: 50%; background: #c5d0e8; }

    /* Kelas badge */
    .kelas-badge {
      display: inline-flex; align-items: center;
      font-size: 10px; font-weight: 700; letter-spacing: 0.4px;
      background: #eef2ff; color: #2451d1; border-radius: 5px; padding: 2px 7px;
    }

    .notif-right {
      display: flex; flex-direction: column; align-items: flex-end;
      gap: 8px; flex-shrink: 0; padding-top: 2px;
    }
    .notif-time {
      font-size: 11.5px; color: #aab4cc; font-weight: 500; white-space: nowrap;
    }
    .notif-item.unread .notif-time { color: #8896b8; }
    .notif-action {
      font-size: 11.5px; font-weight: 700; color: #2451d1;
      cursor: pointer; opacity: 0.8; transition: opacity 0.15s; white-space: nowrap;
    }
    .notif-action:hover { opacity: 1; }
    .notif-action.muted {
      color: #9aa5c4; font-weight: 600; font-size: 10.5px;
      letter-spacing: 0.3px; text-transform: uppercase;
    }

    /* ── Load more ── */
    .load-more {
      text-align: center; padding: 17px;
      font-size: 13px; font-weight: 600; color: #7a87aa;
      cursor: pointer; border-top: 1px solid #f0f3fa;
      transition: color 0.15s, background 0.15s;
    }
    .load-more:hover { color: #2451d1; background: #f8faff; }

    /* ── Empty state ── */
    #emptyState {
      text-align: center; padding: 48px 24px;
      color: #9aa5c4; font-size: 13.5px; font-weight: 600;
    }
  </style>
</head>
<body>

  <!-- ══ SIDEBAR ══ -->
  <aside class="sidebar">
    <div class="sidebar-logo">
      <img src="{{ asset('assets/logo.png') }}" class="logo-icon" alt="Logo"/>
      <span class="brand">SITUGAS</span>
    </div>
    <div class="sidebar-divider"></div>
    <nav class="nav-menu">

      <a href="/guru/dashboard" class="nav-item">
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

      <a href="/guru/notifikasi" class="nav-item active">
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
      <span class="topbar-title">Notifikasi</span>
      <div class="search-wrap">
        <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input class="search-input" id="searchInput" type="text" placeholder="Cari notifikasi..."/>
      </div>
    </header>

    <!-- Content -->
    <div class="content">

      <!-- Summary cards -->
      <div class="summary-row">
        <div class="summary-card">
          <div class="summary-icon blue">
            <svg viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
          </div>
          <div>
            <div class="summary-text-val" id="totalCount">5</div>
            <div class="summary-text-lbl">Total Notifikasi</div>
          </div>
        </div>
        <div class="summary-card">
          <div class="summary-icon orange">
            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
          </div>
          <div>
            <div class="summary-text-val" id="unreadCount">3</div>
            <div class="summary-text-lbl">Belum Dibaca</div>
          </div>
        </div>
        <div class="summary-card">
          <div class="summary-icon green">
            <svg viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
          </div>
          <div>
            <div class="summary-text-val">8</div>
            <div class="summary-text-lbl">Tugas Dikumpulkan</div>
          </div>
        </div>
        <div class="summary-card">
          <div class="summary-icon red">
            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
          </div>
          <div>
            <div class="summary-text-val">3</div>
            <div class="summary-text-lbl">Tugas Terlambat</div>
          </div>
        </div>
      </div>

      <!-- Tabs -->
      <div class="tabs">
        <div class="tab active" data-tab="semua">Semua <span class="tab-badge" id="badgeAll">5</span></div>
        <div class="tab" data-tab="belum">Belum Dibaca <span class="tab-badge" id="badgeUnread">3</span></div>
        <div class="tab" data-tab="pengumpulan">Pengumpulan</div>
        <div class="tab" data-tab="sistem">Sistem</div>
        <div class="tab-mark-all" id="markAllBtn">
          <svg viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
          Tandai semua sudah dibaca
        </div>
      </div>

      <!-- Notification List -->
      <div class="notif-list" id="notifList">

        <!-- Group: Hari ini -->
        <div class="notif-group-header">Hari Ini</div>

        <!-- Item 1 — Siswa mengumpulkan tugas (unread) -->
        <div class="notif-item unread" data-id="1" data-category="semua belum pengumpulan">
          <div class="notif-dot"></div>
          <div class="notif-icon green">
            <svg viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
          </div>
          <div class="notif-body">
            <div class="notif-title">Tugas dikumpulkan: Sejarah Indonesia – Perang Diponegoro</div>
            <div class="notif-student">
              <div class="student-avatar-sm">AS</div>
              Andi Saputra
            </div>
            <div class="notif-desc">Siswa telah mengumpulkan tugas tepat waktu. Silakan periksa dan berikan penilaian.</div>
            <div class="notif-meta">
              <span class="kelas-badge">XI IPA 1</span>
              <span class="notif-tag-dot"></span>
              <span class="notif-tag">Sejarah</span>
              <span class="notif-tag-dot"></span>
              <span class="notif-tag">30 menit yang lalu</span>
            </div>
          </div>
          <div class="notif-right">
            <span class="notif-time">30 mnt lalu</span>
            <span class="notif-action" onclick="markRead(this)">Tandai dibaca</span>
          </div>
        </div>

        <!-- Item 2 — Tugas terlambat (unread) -->
        <div class="notif-item unread" data-id="2" data-category="semua belum pengumpulan">
          <div class="notif-dot"></div>
          <div class="notif-icon red">
            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
          </div>
          <div class="notif-body">
            <div class="notif-title">Tugas terlambat: Matematika – Kalkulus Lanjut</div>
            <div class="notif-student">
              <div class="student-avatar-sm">RP</div>
              Rina Putri
            </div>
            <div class="notif-desc">Siswa belum mengumpulkan tugas hingga batas waktu yang ditentukan kemarin pukul 23.00.</div>
            <div class="notif-meta">
              <span class="kelas-badge">XI IPA 2</span>
              <span class="notif-tag-dot"></span>
              <span class="notif-tag">Matematika</span>
              <span class="notif-tag-dot"></span>
              <span class="notif-tag">2 JAM YANG LALU</span>
            </div>
          </div>
          <div class="notif-right">
            <span class="notif-time">2 jam lalu</span>
            <span class="notif-action" onclick="markRead(this)">Tandai dibaca</span>
          </div>
        </div>

        <!-- Item 3 — Sistem: Tugas dipublikasikan berhasil (unread) -->
        <div class="notif-item unread" data-id="3" data-category="semua belum sistem">
          <div class="notif-dot"></div>
          <div class="notif-icon blue">
            <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
          </div>
          <div class="notif-body">
            <div class="notif-title">Tugas berhasil dipublikasikan: Fisika – Hukum Newton</div>
            <div class="notif-desc">Tugas Anda telah berhasil dipublikasikan dan dapat diakses oleh 32 siswa di kelas XI IPA 1 & 2.</div>
            <div class="notif-meta">
              <span class="kelas-badge">XI IPA 1</span>
              <span class="kelas-badge" style="margin-left:3px;">XI IPA 2</span>
              <span class="notif-tag-dot"></span>
              <span class="notif-tag">Fisika</span>
              <span class="notif-tag-dot"></span>
              <span class="notif-tag">4 JAM YANG LALU</span>
            </div>
          </div>
          <div class="notif-right">
            <span class="notif-time">4 jam lalu</span>
            <span class="notif-action" onclick="markRead(this)">Tandai dibaca</span>
          </div>
        </div>

        <!-- Group: Kemarin -->
        <div class="notif-group-header">Kemarin</div>

        <!-- Item 4 — Banyak siswa mengumpulkan (read) -->
        <div class="notif-item" data-id="4" data-category="semua pengumpulan">
          <div class="notif-dot invisible"></div>
          <div class="notif-icon green">
            <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
          </div>
          <div class="notif-body">
            <div class="notif-title">8 siswa mengumpulkan tugas: Bahasa Indonesia – Cerpen</div>
            <div class="notif-desc">Delapan siswa dari kelas X-A telah mengumpulkan tugas Cerpen. Masih ada 14 siswa yang belum mengumpulkan.</div>
            <div class="notif-meta">
              <span class="kelas-badge">X-A</span>
              <span class="notif-tag-dot"></span>
              <span class="notif-tag">Bahasa Indonesia</span>
              <span class="notif-tag-dot"></span>
              <span class="notif-tag">KEMARIN, 15.30</span>
            </div>
          </div>
          <div class="notif-right">
            <span class="notif-time">Kemarin</span>
            <span class="notif-action muted">Sudah dibaca</span>
          </div>
        </div>

        <!-- Item 5 — Pengingat deadline (read) -->
        <div class="notif-item" data-id="5" data-category="semua sistem">
          <div class="notif-dot invisible"></div>
          <div class="notif-icon orange">
            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
          </div>
          <div class="notif-body">
            <div class="notif-title">Pengingat: Deadline tugas Kimia – Reaksi Redoks besok</div>
            <div class="notif-desc">Tugas Kimia untuk kelas XII IPA 1 akan berakhir besok pukul 23.00. Saat ini 20 dari 30 siswa belum mengumpulkan.</div>
            <div class="notif-meta">
              <span class="kelas-badge">XII IPA 1</span>
              <span class="notif-tag-dot"></span>
              <span class="notif-tag">Kimia</span>
              <span class="notif-tag-dot"></span>
              <span class="notif-tag">KEMARIN, 08.00</span>
            </div>
          </div>
          <div class="notif-right">
            <span class="notif-time">Kemarin</span>
            <span class="notif-action muted">Sudah dibaca</span>
          </div>
        </div>

        <!-- Load more -->
        <div class="load-more" id="loadMore">Tampilkan lebih banyak</div>

      </div>
    </div>
  </div>

  <script>
    let currentTab = 'semua';

    // ── Update summary counts
    function updateCounts() {
      const unread = document.querySelectorAll('.notif-item.unread').length;
      const total  = document.querySelectorAll('.notif-item').length;
      document.getElementById('unreadCount').textContent = unread;
      document.getElementById('totalCount').textContent  = total;
      document.getElementById('badgeUnread').textContent = unread;
      document.getElementById('badgeAll').textContent    = total;
    }

    // ── Tabs
    document.querySelectorAll('.tab').forEach(tab => {
      tab.addEventListener('click', () => {
        document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
        tab.classList.add('active');
        currentTab = tab.dataset.tab;
        applyFilters();
      });
    });

    // ── Mark single read
    function markRead(btn) {
      const item = btn.closest('.notif-item');
      item.classList.remove('unread');
      item.dataset.category = item.dataset.category.replace('belum', '').trim();
      item.querySelector('.notif-dot').classList.add('invisible');
      btn.classList.add('muted');
      btn.textContent = 'Sudah dibaca';
      btn.onclick = null;
      updateCounts();
      applyFilters();
    }

    // ── Mark all read
    document.getElementById('markAllBtn').addEventListener('click', () => {
      document.querySelectorAll('.notif-item.unread').forEach(item => {
        item.classList.remove('unread');
        item.dataset.category = item.dataset.category.replace('belum', '').trim();
        item.querySelector('.notif-dot').classList.add('invisible');
        const btn = item.querySelector('.notif-action');
        if (btn) { btn.classList.add('muted'); btn.textContent = 'Sudah dibaca'; btn.onclick = null; }
      });
      updateCounts();
      applyFilters();
    });

    // ── Search
    document.getElementById('searchInput').addEventListener('input', applyFilters);

    // ── Filter logic
    function applyFilters() {
      const query = document.getElementById('searchInput').value.toLowerCase().trim();
      const items = document.querySelectorAll('.notif-item');
      let visibleCount = 0;

      // Hide/show group headers dynamically
      document.querySelectorAll('.notif-group-header').forEach(h => h.style.display = '');

      items.forEach(item => {
        const cats  = item.dataset.category || '';
        const title = item.querySelector('.notif-title')?.textContent.toLowerCase() || '';
        const desc  = item.querySelector('.notif-desc')?.textContent.toLowerCase() || '';

        const tabMatch = currentTab === 'semua' ? true : cats.includes(currentTab);
        const searchMatch = query === '' || title.includes(query) || desc.includes(query);

        if (tabMatch && searchMatch) { item.style.display = ''; visibleCount++; }
        else { item.style.display = 'none'; }
      });

      // Hide group headers with no visible children
      document.querySelectorAll('.notif-group-header').forEach(header => {
        let sib = header.nextElementSibling;
        let hasVisible = false;
        while (sib && !sib.classList.contains('notif-group-header') && !sib.classList.contains('load-more')) {
          if (sib.style.display !== 'none') { hasVisible = true; break; }
          sib = sib.nextElementSibling;
        }
        header.style.display = hasVisible ? '' : 'none';
      });

      // Empty state
      let empty = document.getElementById('emptyState');
      if (visibleCount === 0) {
        if (!empty) {
          empty = document.createElement('div');
          empty.id = 'emptyState';
          empty.innerHTML = '<div style="font-size:28px;margin-bottom:10px">🔔</div>Tidak ada notifikasi ditemukan.';
          document.getElementById('notifList').insertBefore(empty, document.getElementById('loadMore'));
        }
        empty.style.display = '';
      } else if (empty) { empty.style.display = 'none'; }
    }

    // ── Load more
    let loadCount = 0;
    const extras = [
      {
        icon: 'purple', unread: false,
        title: 'Komentar pada tugas: Biologi – Sel & Jaringan',
        student: { init: 'DW', name: 'Dewi Wulandari' },
        desc: 'Siswa menambahkan komentar pada tugas dan meminta klarifikasi tentang format pengumpulan.',
        kelas: 'X-B', mapel: 'Biologi', time: '2 hari lalu', cat: 'semua pengumpulan'
      },
      {
        icon: 'gray', unread: false,
        title: 'Sistem: Backup data tugas berhasil dilakukan',
        student: null,
        desc: 'Semua data tugas dan penilaian berhasil dicadangkan secara otomatis oleh sistem SITUGAS.',
        kelas: null, mapel: 'Sistem', time: '3 hari lalu', cat: 'semua sistem'
      },
    ];

    document.getElementById('loadMore').addEventListener('click', function() {
      if (loadCount >= extras.length) {
        this.textContent = 'Tidak ada lagi notifikasi';
        this.style.cursor = 'default'; this.style.color = '#bcc5dd'; return;
      }
      const d = extras[loadCount++];
      const el = document.createElement('div');
      el.className = 'notif-item' + (d.unread ? ' unread' : '');
      el.dataset.category = d.cat;
      el.innerHTML = `
        <div class="notif-dot${d.unread ? '' : ' invisible'}"></div>
        <div class="notif-icon ${d.icon}">
          <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/>
          </svg>
        </div>
        <div class="notif-body">
          <div class="notif-title">${d.title}</div>
          ${d.student ? `<div class="notif-student"><div class="student-avatar-sm">${d.student.init}</div>${d.student.name}</div>` : ''}
          <div class="notif-desc">${d.desc}</div>
          <div class="notif-meta">
            ${d.kelas ? `<span class="kelas-badge">${d.kelas}</span><span class="notif-tag-dot"></span>` : ''}
            <span class="notif-tag">${d.mapel}</span>
            <span class="notif-tag-dot"></span>
            <span class="notif-tag">${d.time.toUpperCase()}</span>
          </div>
        </div>
        <div class="notif-right">
          <span class="notif-time">${d.time}</span>
          <span class="notif-action muted">Sudah dibaca</span>
        </div>`;
      document.getElementById('loadMore').before(el);
      updateCounts();
      applyFilters();
    });

    updateCounts();
  </script>
</body>
</html>