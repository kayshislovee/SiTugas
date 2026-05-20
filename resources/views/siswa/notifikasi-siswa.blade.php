<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SITUGAS — Notifikasi</title>
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
    .logo-icon {
      width: 38px;
      height: 35px;
      flex-shrink: 0;
    }
    .brand {
      
      font-size: 15px;
      font-weight: 800;
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
    .nav-item.active svg { stroke: var(--blue); }

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

    /* ── Topbar ── */
    .topbar {
      height: 60px;
      background: #fff;
      border-bottom: 1px solid #e8edf5;
      display: flex;
      align-items: center;
      padding: 0 28px;
      gap: 14px;
      position: sticky;
      top: 0;
      z-index: 50;
    }

    .topbar-title {
      font-size: 24px;
      font-weight: 800;
      color: #0f1740;
      
      letter-spacing: -0.2px;
      margin-right: auto;
    }

    .search-wrap {
      position: relative;
    }
    .search-wrap svg {
      position: absolute;
      left: 12px; top: 50%;
      transform: translateY(-50%);
      width: 15px; height: 15px;
      stroke: #9aa5c4;
      fill: none;
      stroke-width: 2;
      stroke-linecap: round;
      stroke-linejoin: round;
    }
    .search-input {
      padding: 8px 14px 8px 36px;
      border: 1.5px solid #e4eaf5;
      border-radius: 9px;
      font-size: 13px;
      font-family: 'Plus Jakarta Sans', sans-serif;
      color: #1a2060;
      background: #f8faff;
      outline: none;
      width: 220px;
      transition: border-color 0.2s, box-shadow 0.2s;
    }
    .search-input::placeholder { color: #bcc5dd; }
    .search-input:focus {
      border-color: var(--blue);
      box-shadow: 0 0 0 3px rgba(36,81,209,0.09);
      background: #fff;
    }

    .icon-btn { display: none; }
    .user-chip { display: none; }

    /* ══════════════════════════
       CONTENT
    ══════════════════════════ */
    .content {
      flex: 1;
      padding: 24px 28px 40px;
    }

    /* ── Tabs ── */
    .tabs {
      display: flex;
      align-items: center;
      gap: 2px;
      margin-bottom: 18px;
      border-bottom: 1.5px solid #e8edf5;
      position: relative;
    }

    .tab {
      padding: 10px 18px 11px;
      font-size: 13.5px;
      font-weight: 600;
      color: #8896b8;
      cursor: pointer;
      border-bottom: 2.5px solid transparent;
      margin-bottom: -1.5px;
      transition: color 0.18s, border-color 0.18s;
      white-space: nowrap;
      user-select: none;
    }
    .tab:hover { color: #2451d1; }
    .tab.active {
      color: #2451d1;
      border-bottom-color: #2451d1;
      font-weight: 700;
    }

    .tab-mark-all {
      margin-left: auto;
      font-size: 12.5px;
      font-weight: 600;
      color: #2451d1;
      cursor: pointer;
      padding: 6px 0 10px;
      display: flex;
      align-items: center;
      gap: 5px;
      opacity: 0.85;
      transition: opacity 0.18s;
    }
    .tab-mark-all:hover { opacity: 1; }
    .tab-mark-all svg {
      width: 14px; height: 14px;
      stroke: currentColor;
      fill: none;
      stroke-width: 2.2;
      stroke-linecap: round;
      stroke-linejoin: round;
    }

    /* ── Notification List ── */
    .notif-list {
      background: #fff;
      border-radius: 14px;
      border: 1px solid #e4eaf5;
      overflow: hidden;
      box-shadow: 0 2px 12px rgba(36,81,209,0.05);
    }

    .notif-item {
      display: flex;
      align-items: flex-start;
      gap: 14px;
      padding: 16px 22px;
      border-bottom: 1px solid #f0f3fa;
      position: relative;
      transition: background 0.15s;
      cursor: pointer;
    }
    .notif-item:last-child { border-bottom: none; }
    .notif-item:hover { background: #f8faff; }
    .notif-item.unread { background: #f5f8ff; }
    .notif-item.unread:hover { background: #eff3ff; }

    /* Unread dot */
    .notif-dot {
      width: 8px; height: 8px;
      border-radius: 50%;
      background: #2451d1;
      flex-shrink: 0;
      margin-top: 6px;
    }
    .notif-dot.invisible { background: transparent; }

    /* Icon */
    .notif-icon {
      width: 38px; height: 38px;
      border-radius: 10px;
      display: grid; place-items: center;
      flex-shrink: 0;
    }
    .notif-icon svg {
      width: 18px; height: 18px;
      fill: none;
      stroke-width: 2;
      stroke-linecap: round;
      stroke-linejoin: round;
    }
    .notif-icon.blue   { background: #e8eeff; }
    .notif-icon.blue svg { stroke: #2451d1; }
    .notif-icon.orange { background: #fff3e8; }
    .notif-icon.orange svg { stroke: #e07b2a; }
    .notif-icon.green  { background: #e8faf0; }
    .notif-icon.green svg  { stroke: #1a9c54; }
    .notif-icon.gray   { background: #f0f3fa; }
    .notif-icon.gray svg   { stroke: #7a87aa; }

    /* Body */
    .notif-body { flex: 1; min-width: 0; }
    .notif-title {
      font-size: 13.5px;
      font-weight: 700;
      color: #0f1740;
      margin-bottom: 3px;
      line-height: 1.35;
    }
    .notif-item:not(.unread) .notif-title { font-weight: 600; color: #3a4468; }
    .notif-desc {
      font-size: 12.5px;
      color: #7a87aa;
      line-height: 1.55;
      margin-bottom: 7px;
    }
    .notif-meta {
      display: flex;
      align-items: center;
      gap: 6px;
    }
    .notif-tag {
      display: inline-flex;
      align-items: center;
      gap: 4px;
      font-size: 10.5px;
      font-weight: 700;
      letter-spacing: 0.6px;
      text-transform: uppercase;
      color: #8896b8;
    }
    .notif-tag svg {
      width: 11px; height: 11px;
      stroke: currentColor;
      fill: none;
      stroke-width: 2.2;
      stroke-linecap: round;
      stroke-linejoin: round;
    }
    .notif-tag-dot {
      width: 3px; height: 3px;
      border-radius: 50%;
      background: #c5d0e8;
    }

    /* Right side */
    .notif-right {
      display: flex;
      flex-direction: column;
      align-items: flex-end;
      gap: 8px;
      flex-shrink: 0;
      padding-top: 2px;
    }
    .notif-time {
      font-size: 11.5px;
      color: #aab4cc;
      font-weight: 500;
      white-space: nowrap;
    }
    .notif-item.unread .notif-time { color: #8896b8; }
    .notif-action {
      font-size: 11.5px;
      font-weight: 700;
      color: #2451d1;
      cursor: pointer;
      opacity: 0.8;
      transition: opacity 0.15s;
      white-space: nowrap;
    }
    .notif-action:hover { opacity: 1; }
    .notif-action.muted {
      color: #9aa5c4;
      font-weight: 600;
      font-size: 10.5px;
      letter-spacing: 0.3px;
      text-transform: uppercase;
    }

    /* ── Load more ── */
    .load-more {
      text-align: center;
      padding: 18px;
      font-size: 13px;
      font-weight: 600;
      color: #7a87aa;
      cursor: pointer;
      border-top: 1px solid #f0f3fa;
      transition: color 0.15s, background 0.15s;
    }
    .load-more:hover { color: #2451d1; background: #f8faff; }
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
      <a href="/siswa/dashboard" class="nav-item">
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

      <a href="/siswa/notifikasi" class="nav-item active">
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

      <!-- Tabs -->
      <div class="tabs">
        <div class="tab active" data-tab="semua">Semua</div>
        <div class="tab" data-tab="belum">Belum Dibaca</div>
        <div class="tab" data-tab="tersimpan">Tersimpan</div>
        <div class="tab-mark-all" id="markAllBtn">
          <svg viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/><path d="M20 12L9 23l-5-5" opacity="0.4"/></svg>
          Tandai semua sudah dibaca
        </div>
      </div>

      <!-- Notification List -->
      <div class="notif-list" id="notifList">

        <!-- Item 1 — unread -->
        <div class="notif-item unread" data-id="1" data-category="semua belum">
          <div class="notif-dot"></div>
          <div class="notif-icon blue">
            <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
          </div>
          <div class="notif-body">
            <div class="notif-title">Tugas baru: Sejarah Indonesia – Perang Diponegoro</div>
            <div class="notif-desc">Guru Anda baru saja mempublikasikan tugas baru untuk modul Perlawanan Bangsa Indonesia.</div>
            <div class="notif-meta">
              <span class="notif-tag">
                <svg viewBox="0 0 24 24"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                Sejarah
              </span>
              <span class="notif-tag-dot"></span>
              <span class="notif-tag">2 JAM YANG LALU</span>
            </div>
          </div>
          <div class="notif-right">
            <span class="notif-time">Baru saja</span>
            <span class="notif-action" onclick="markRead(this)">Tandai sudah dibaca</span>
          </div>
        </div>

        <!-- Item 2 — unread -->
        <div class="notif-item unread" data-id="2" data-category="semua belum">
          <div class="notif-dot"></div>
          <div class="notif-icon orange">
            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
          </div>
          <div class="notif-body">
            <div class="notif-title">Peringatan: Batas Waktu Tugas Matematika</div>
            <div class="notif-desc">Tugas "Kalkulus Lanjut" akan segera berakhir dalam 24 jam ke depan.</div>
            <div class="notif-meta">
              <span class="notif-tag">
                <svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18"/></svg>
                Matematika
              </span>
              <span class="notif-tag-dot"></span>
              <span class="notif-tag">5 JAM YANG LALU</span>
            </div>
          </div>
          <div class="notif-right">
            <span class="notif-time">5 jam yang lalu</span>
            <span class="notif-action" onclick="markRead(this)">Tandai sudah dibaca</span>
          </div>
        </div>

        <!-- Item 3 — read -->
        <div class="notif-item" data-id="3" data-category="semua">
          <div class="notif-dot invisible"></div>
          <div class="notif-icon gray">
            <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
          </div>
          <div class="notif-body">
            <div class="notif-title">Tugas diperbarui: Fisika – Hukum Newton</div>
            <div class="notif-desc">Lampiran materi tambahan telah ditambahkan oleh Pak Horu pada tugas Hukum Newton.</div>
            <div class="notif-meta">
              <span class="notif-tag">
                <svg viewBox="0 0 24 24"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"/></svg>
                Fisika
              </span>
              <span class="notif-tag-dot"></span>
              <span class="notif-tag">Kemarin, 14.20</span>
            </div>
          </div>
          <div class="notif-right">
            <span class="notif-time">Kemarin</span>
            <span class="notif-action muted">Sudah dibaca</span>
          </div>
        </div>

        <!-- Item 4 — read -->
        <div class="notif-item" data-id="4" data-category="semua">
          <div class="notif-dot invisible"></div>
          <div class="notif-icon green">
            <svg viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
          </div>
          <div class="notif-body">
            <div class="notif-title">Nilai diumumkan: Bahasa Inggris – Essay Writing</div>
            <div class="notif-desc">Nilai akhir untuk tugas "My Holiday Experience" telah keluar. Silakan cek di Dashboard.</div>
            <div class="notif-meta">
              <span class="notif-tag">
                <svg viewBox="0 0 24 24"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/></svg>
                Bahasa Inggris
              </span>
              <span class="notif-tag-dot"></span>
              <span class="notif-tag">2 hari yang lalu</span>
            </div>
          </div>
          <div class="notif-right">
            <span class="notif-time">2 hari lalu</span>
            <span class="notif-action muted">Sudah dibaca</span>
          </div>
        </div>

        <!-- Load more -->
        <div class="load-more" id="loadMore">Tampilkan lebih banyak</div>

      </div>
    </div>
  </div>

  <script>
    // ── State
    let currentTab = 'semua';

    // ── Tab switching
    document.querySelectorAll('.tab').forEach(tab => {
      tab.addEventListener('click', () => {
        document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
        tab.classList.add('active');
        currentTab = tab.dataset.tab;
        applyFilters();
      });
    });

    // ── Mark single as read
    function markRead(btn) {
      const item = btn.closest('.notif-item');
      item.classList.remove('unread');
      item.dataset.category = 'semua'; // remove 'belum'
      item.querySelector('.notif-dot').classList.add('invisible');
      btn.classList.add('muted');
      btn.textContent = 'Sudah dibaca';
      btn.onclick = null;
      applyFilters();
    }

    // ── Mark all as read
    document.getElementById('markAllBtn').addEventListener('click', () => {
      document.querySelectorAll('.notif-item.unread').forEach(item => {
        item.classList.remove('unread');
        item.dataset.category = 'semua';
        item.querySelector('.notif-dot').classList.add('invisible');
        const btn = item.querySelector('.notif-action');
        if (btn) {
          btn.classList.add('muted');
          btn.textContent = 'Sudah dibaca';
          btn.onclick = null;
        }
      });
      applyFilters();
    });

    // ── Search filter
    document.getElementById('searchInput').addEventListener('input', function() {
      applyFilters();
    });

    // ── Apply both tab + search filters
    function applyFilters() {
      const query = document.getElementById('searchInput').value.toLowerCase().trim();
      const items = document.querySelectorAll('.notif-item');
      let visibleCount = 0;

      items.forEach(item => {
        const cats = item.dataset.category || '';
        const title = item.querySelector('.notif-title')?.textContent.toLowerCase() || '';
        const desc  = item.querySelector('.notif-desc')?.textContent.toLowerCase() || '';

        const tabMatch = currentTab === 'semua'
          ? true
          : currentTab === 'belum'
          ? cats.includes('belum')
          : currentTab === 'tersimpan'
          ? cats.includes('tersimpan')
          : true;

        const searchMatch = query === '' || title.includes(query) || desc.includes(query);

        if (tabMatch && searchMatch) {
          item.style.display = '';
          visibleCount++;
        } else {
          item.style.display = 'none';
        }
      });

      // Show empty state if nothing visible
      let empty = document.getElementById('emptyState');
      if (visibleCount === 0) {
        if (!empty) {
          empty = document.createElement('div');
          empty.id = 'emptyState';
          empty.style.cssText = 'text-align:center;padding:48px 24px;color:#9aa5c4;font-size:13.5px;font-weight:600;';
          empty.innerHTML = '<div style="font-size:28px;margin-bottom:10px;">🔔</div>Tidak ada notifikasi ditemukan.';
          document.getElementById('notifList').insertBefore(empty, document.getElementById('loadMore'));
        }
        empty.style.display = '';
      } else if (empty) {
        empty.style.display = 'none';
      }
    }

    // ── Load more (simulate adding items)
    let loadCount = 0;
    document.getElementById('loadMore').addEventListener('click', function() {
      if (loadCount >= 2) {
        this.textContent = 'Tidak ada lagi notifikasi';
        this.style.cursor = 'default';
        this.style.color = '#bcc5dd';
        return;
      }
      loadCount++;
      const extras = [
        { icon: 'gray', type: 'edit', title: 'Pengingat: Tugas PKN – Pancasila', desc: 'Jangan lupa kumpulkan tugas PKN sebelum besok pagi.', tag: 'PKN', time: '3 hari lalu' },
        { icon: 'blue', type: 'file', title: 'Tugas baru: Biologi – Sistem Pencernaan', desc: 'Guru menambahkan tugas baru tentang sistem pencernaan manusia.', tag: 'Biologi', time: '4 hari lalu' },
      ];
      const data = extras[loadCount - 1];
      const el = document.createElement('div');
      el.className = 'notif-item';
      el.dataset.category = 'semua';
      el.innerHTML = `
        <div class="notif-dot invisible"></div>
        <div class="notif-icon ${data.icon}">
          <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/>
          </svg>
        </div>
        <div class="notif-body">
          <div class="notif-title">${data.title}</div>
          <div class="notif-desc">${data.desc}</div>
          <div class="notif-meta">
            <span class="notif-tag">${data.tag}</span>
            <span class="notif-tag-dot"></span>
            <span class="notif-tag">${data.time.toUpperCase()}</span>
          </div>
        </div>
        <div class="notif-right">
          <span class="notif-time">${data.time}</span>
          <span class="notif-action muted">Sudah dibaca</span>
        </div>`;
      const loadMoreEl = document.getElementById('loadMore');
      loadMoreEl.parentNode.insertBefore(el, loadMoreEl);
      applyFilters();
    });
  </script>
</body>
</html>