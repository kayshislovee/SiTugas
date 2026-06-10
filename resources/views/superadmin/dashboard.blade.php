<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SITUGAS – Dashboard Super Admin</title>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
      --blue-dark:#1a3faa; --blue-mid:#2451d1; --blue-light:#3b6ef8; --blue-pale:#eef2ff;
      --purple-dark:#4c1d95; --purple-mid:#6d28d9; --purple-light:#7c3aed; --purple-pale:#f5f3ff;
      --accent:#f59e0b; --red:#ef4444; --red-pale:#fef2f2;
      --orange:#f97316; --green:#22c55e; --green-pale:#f0fdf4;
      --gray-50:#f8fafc; --gray-100:#f1f5f9; --gray-200:#e2e8f0;
      --gray-400:#94a3b8; --gray-600:#475569; --gray-800:#1e293b; --white:#ffffff;
      --sidebar-w:230px; --radius:14px;
      --shadow-sm:0 1px 4px rgba(0,0,0,.06); --shadow-md:0 4px 16px rgba(0,0,0,.08);
    }
    body { font-family:'Plus Jakarta Sans',sans-serif; background:var(--gray-50); display:flex; min-height:100vh; color:var(--gray-800); overflow-x:hidden; }

    /* SIDEBAR */
    .sidebar { width:var(--sidebar-w); min-height:100vh; background-image:url('/assets/sidebarbg.jpg'); background-size:cover; background-position:center; background-attachment:fixed; display:flex; flex-direction:column; padding:28px 16px 24px; flex-shrink:0; position:fixed; top:0; left:0; bottom:0; z-index:100; }
    .sidebar::before { content:''; position:absolute; inset:0; background:linear-gradient(160deg,rgba(76,29,149,0.6),rgba(36,81,209,0.4)); pointer-events:none; }
    .sidebar > * { position:relative; z-index:1; }
    .sidebar-logo { display:flex; align-items:center; justify-content:center; gap:10px; margin-bottom:6px; }
    .logo-icon { width:38px; height:35px; flex-shrink:0; }
    .brand { font-size:15px; font-weight:900; color:#fff; letter-spacing:1px; }
    .admin-chip { background:rgba(255,255,255,0.15); border:1px solid rgba(255,255,255,0.25); border-radius:999px; padding:3px 12px; font-size:10px; font-weight:700; color:rgba(255,255,255,0.9); letter-spacing:0.08em; text-transform:uppercase; display:block; text-align:center; margin-bottom:22px; }
    .sidebar-divider { width:100%; height:1px; background:rgba(255,255,255,0.2); margin-bottom:16px; }
    .nav-section-label { font-size:10px; font-weight:700; color:rgba(255,255,255,0.45); letter-spacing:0.1em; text-transform:uppercase; padding:0 16px; margin-bottom:6px; margin-top:12px; }
    .nav-menu { display:flex; flex-direction:column; gap:3px; width:100%; flex:1; }
    .nav-item { display:flex; align-items:center; gap:11px; padding:10px 16px; border-radius:10px; cursor:pointer; color:rgba(255,255,255,0.75); font-size:13.5px; font-weight:600; text-decoration:none; transition:all 0.2s; white-space:nowrap; }
    .nav-item svg { width:17px; height:17px; flex-shrink:0; stroke:rgba(255,255,255,0.75); fill:none; transition:stroke 0.2s; }
    .nav-item:hover { background:rgba(255,255,255,0.13); color:#fff; }
    .nav-item:hover svg { stroke:#fff; }
    .nav-item.active { background:#fff; color:var(--purple-mid); font-weight:700; }
    .nav-item.active svg { stroke:var(--purple-mid); }
    .sidebar-footer { padding:14px 10px 6px; border-top:1px solid rgba(255,255,255,0.2); display:flex; flex-direction:column; gap:8px; }
    .user-profile { display:flex; align-items:center; gap:8px; padding:8px 10px; border-radius:10px; background:rgba(255,255,255,0.08); }
    .user-avatar { width:36px; height:36px; border-radius:50%; background:linear-gradient(135deg,var(--purple-mid),var(--blue-mid)); display:flex; align-items:center; justify-content:center; font-size:16px; flex-shrink:0; }
    .user-name { font-size:13px; font-weight:600; color:rgba(255,255,255,0.95); }
    .user-role { font-size:11px; color:rgba(255,255,255,0.6); }
    .logout-btn { display:flex; align-items:center; justify-content:center; gap:8px; padding:8px 12px; border-radius:8px; text-decoration:none; color:rgba(255,255,255,0.8); font-size:13px; font-weight:600; transition:all 0.2s; background:rgba(255,255,255,0.08); border:none; cursor:pointer; width:100%; font-family:inherit; }
    .logout-btn:hover { background:rgba(255,255,255,0.15); color:#fff; }

    /* MAIN */
    main { margin-left:var(--sidebar-w); flex:1; padding:28px 32px; animation:fadeUp .45s ease both; }
    @keyframes fadeUp { from { opacity:0; transform:translateY(12px); } to { opacity:1; transform:translateY(0); } }

    /* TOPBAR */
    .topbar { display:flex; justify-content:space-between; align-items:center; margin-bottom:22px; }
    .page-title { font-size:20px; font-weight:700; }
    .page-subtitle { font-size:13px; color:var(--gray-400); font-weight:500; margin-top:2px; }
    .btn-primary { background:linear-gradient(135deg,var(--purple-mid),var(--blue-mid)); color:#fff; border:none; border-radius:8px; padding:9px 18px; font-size:13px; font-weight:600; cursor:pointer; display:flex; align-items:center; gap:8px; text-decoration:none; transition:opacity 0.2s; font-family:inherit; }
    .btn-primary:hover { opacity:0.9; }
    .btn-primary svg { width:16px; height:16px; stroke:currentColor; fill:none; stroke-width:2.5; }

    /* STATS */
    .stats { display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:22px; }
    .stat-card { background:var(--white); border-radius:var(--radius); padding:20px 22px; box-shadow:var(--shadow-sm); border:1px solid var(--gray-200); transition:transform .18s,box-shadow .18s; }
    .stat-card:hover { transform:translateY(-2px); box-shadow:var(--shadow-md); }
    .stat-icon { width:40px; height:40px; border-radius:10px; display:flex; align-items:center; justify-content:center; margin-bottom:12px; }
    .stat-icon svg { width:20px; height:20px; stroke:currentColor; fill:none; stroke-width:2; }
    .stat-icon.purple { background:var(--purple-pale); color:var(--purple-mid); }
    .stat-icon.blue { background:var(--blue-pale); color:var(--blue-mid); }
    .stat-icon.green { background:var(--green-pale); color:#16a34a; }
    .stat-icon.orange { background:#fff7ed; color:#ea580c; }
    .stat-label { font-size:10.5px; font-weight:700; letter-spacing:.1em; text-transform:uppercase; color:var(--gray-400); margin-bottom:6px; }
    .stat-value { font-size:32px; font-weight:800; color:var(--gray-800); line-height:1; }

    /* CARD */
    .card { background:var(--white); border-radius:var(--radius); box-shadow:var(--shadow-sm); border:1px solid var(--gray-200); overflow:hidden; margin-bottom:20px; }
    .card-header { padding:18px 24px 14px; border-bottom:1px solid var(--gray-100); display:flex; align-items:center; justify-content:space-between; }
    .card-title { font-size:15px; font-weight:800; color:var(--gray-800); }
    .link-all { font-size:12px; color:var(--purple-mid); text-decoration:none; font-weight:600; }
    .link-all:hover { text-decoration:underline; }

    /* TABLE */
    table { width:100%; border-collapse:collapse; }
    thead th { padding:10px 24px; text-align:left; font-size:10.5px; font-weight:700; letter-spacing:.09em; text-transform:uppercase; color:var(--gray-400); background:var(--gray-50); border-bottom:1px solid var(--gray-200); }
    tbody tr { border-bottom:1px solid var(--gray-100); transition:background .14s; }
    tbody tr:last-child { border-bottom:none; }
    tbody tr:hover { background:var(--gray-50); }
    tbody td { padding:12px 24px; font-size:13.5px; color:var(--gray-800); vertical-align:middle; }

    /* BADGES */
    .badge { display:inline-flex; align-items:center; padding:4px 10px; border-radius:999px; font-size:11px; font-weight:700; white-space:nowrap; }
    .badge-purple { background:#ede9fe; color:#6d28d9; }
    .badge-blue   { background:#dbeafe; color:#1d4ed8; }
    .badge-green  { background:#dcfce7; color:#166534; }
    .badge-gray   { background:var(--gray-100); color:var(--gray-600); }

    /* TWO COL */
    .two-col { display:grid; grid-template-columns:1fr 1fr; gap:20px; }

    /* ALERT */
    .alert-success { background:#f0fdf4; border:1px solid #bbf7d0; border-radius:10px; padding:12px 16px; color:#166534; font-size:13px; font-weight:600; margin-bottom:16px; display:flex; align-items:center; gap:8px; }

    @media(max-width:1100px) { .stats { grid-template-columns:repeat(2,1fr); } .two-col { grid-template-columns:1fr; } }
    @media(max-width:900px) { .sidebar { width:70px; padding:20px 8px; } main { margin-left:70px; } .nav-item span,.brand,.admin-chip,.nav-section-label,.sidebar-footer .user-name,.sidebar-footer .user-role { display:none; } .nav-item { justify-content:center; padding:10px 8px; } }
  </style>
</head>
<body>

<aside class="sidebar">
  <div class="sidebar-logo">
    <img src="{{ asset('assets/logo.png') }}" class="logo-icon" alt="Logo"/>
    <span class="brand">SITUGAS</span>
  </div>
  <span class="admin-chip">⚡ Super Admin</span>
  <div class="sidebar-divider"></div>
  <nav class="nav-menu">
    <div class="nav-section-label">Overview</div>
    <a href="{{ route('superadmin.dashboard') }}" class="nav-item active">
      <svg viewBox="0 0 24 24" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1.2"/><rect x="14" y="3" width="7" height="7" rx="1.2"/><rect x="3" y="14" width="7" height="7" rx="1.2"/><rect x="14" y="14" width="7" height="7" rx="1.2"/></svg>
      <span>Dashboard</span>
    </a>
    <div class="nav-section-label">Manajemen</div>
    <a href="{{ route('superadmin.kelola-guru') }}" class="nav-item">
      <svg viewBox="0 0 24 24" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
      <span>Kelola Guru</span>
    </a>
    <a href="{{ route('superadmin.kelola-siswa') }}" class="nav-item">
      <svg viewBox="0 0 24 24" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
      <span>Kelola Siswa</span>
    </a>
    <a href="{{ route('superadmin.kelola-tugas') }}" class="nav-item">
      <svg viewBox="0 0 24 24" stroke-width="2"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
      <span>Semua Tugas</span>
    </a>
  </nav>
  <div class="sidebar-footer">
    <div class="user-profile">
      <div class="user-avatar">👑</div>
      <div>
        <p class="user-name">{{ auth()->user()->name }}</p>
        <p class="user-role">Super Admin</p>
      </div>
    </div>
    <form action="{{ route('logout') }}" method="POST">
      @csrf
      <button type="submit" class="logout-btn">
        <svg viewBox="0 0 24 24" style="width:16px;height:16px;stroke:currentColor;fill:none;stroke-width:2;"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
        <span>Keluar</span>
      </button>
    </form>
  </div>
</aside>

<main>
  <header class="topbar">
    <div>
      <h2 class="page-title">Dashboard Super Admin</h2>
      <p class="page-subtitle">Selamat datang, {{ auth()->user()->name }}. Kelola semua data sekolah di sini.</p>
    </div>
  </header>

  @if(session('success'))
    <div class="alert-success">✅ {{ session('success') }}</div>
  @endif

  <!-- STATS -->
  <section class="stats">
    <div class="stat-card">
      <div class="stat-icon purple">
        <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
      </div>
      <p class="stat-label">Total Guru</p>
      <p class="stat-value">{{ $totalGuru }}</p>
    </div>
    <div class="stat-card">
      <div class="stat-icon blue">
        <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
      </div>
      <p class="stat-label">Total Siswa</p>
      <p class="stat-value">{{ $totalSiswa }}</p>
    </div>
    <div class="stat-card">
      <div class="stat-icon green">
        <svg viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
      </div>
      <p class="stat-label">Total Tugas</p>
      <p class="stat-value">{{ $totalTugas }}</p>
    </div>
    <div class="stat-card">
      <div class="stat-icon orange">
        <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
      </div>
      <p class="stat-label">Total Kelas</p>
      <p class="stat-value">{{ $totalKelas }}</p>
    </div>
  </section>

  <!-- TWO COLUMN -->
  <div class="two-col">
    <!-- Guru Terbaru -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Guru Terdaftar</h3>
        <a href="{{ route('superadmin.kelola-guru') }}" class="link-all">Kelola Semua →</a>
      </div>
      <table>
        <thead><tr><th>Nama</th><th>NIP</th><th>Aksi</th></tr></thead>
        <tbody>
          @forelse($guruTerbaru as $guru)
          <tr>
            <td><strong>{{ $guru->name }}</strong></td>
            <td style="font-family:'DM Mono',monospace;font-size:12px;color:var(--gray-400);">{{ $guru->nip }}</td>
            <td>
              <a href="{{ route('superadmin.edit-guru', $guru) }}" style="color:var(--purple-mid);font-size:12px;font-weight:600;text-decoration:none;">Edit</a>
            </td>
          </tr>
          @empty
          <tr><td colspan="3" style="text-align:center;color:var(--gray-400);padding:20px;">Belum ada guru</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Siswa Terbaru -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Siswa Terbaru</h3>
        <a href="{{ route('superadmin.kelola-siswa') }}" class="link-all">Kelola Semua →</a>
      </div>
      <table>
        <thead><tr><th>Nama</th><th>Kelas</th><th>Aksi</th></tr></thead>
        <tbody>
          @forelse($siswaTerbaru as $siswa)
          <tr>
            <td><strong>{{ $siswa->name }}</strong><br><span style="font-size:11px;color:var(--gray-400);">NIS: {{ $siswa->nis }}</span></td>
            <td><span class="badge badge-blue">{{ $siswa->kelas }}</span></td>
            <td>
              <a href="{{ route('superadmin.edit-siswa', $siswa) }}" style="color:var(--purple-mid);font-size:12px;font-weight:600;text-decoration:none;">Edit</a>
            </td>
          </tr>
          @empty
          <tr><td colspan="3" style="text-align:center;color:var(--gray-400);padding:20px;">Belum ada siswa</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <!-- Tugas Terbaru -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Tugas Terbaru (Semua Kelas)</h3>
      <a href="{{ route('superadmin.kelola-tugas') }}" class="link-all">Lihat Semua →</a>
    </div>
    <table>
      <thead><tr><th>Judul</th><th>Guru</th><th>Kelas</th><th>Mapel</th><th>Deadline</th><th>Detail</th></tr></thead>
      <tbody>
        @forelse($tugasTerbaru as $tugas)
        <tr>
          <td><strong>{{ $tugas->judul }}</strong></td>
          <td style="font-size:12px;color:var(--gray-600);">{{ optional($tugas->guru)->name }}</td>
          <td><span class="badge badge-purple">{{ $tugas->kelas }}</span></td>
          <td style="font-size:12px;">{{ $tugas->mapel }}</td>
          <td style="font-size:12px;">{{ \Carbon\Carbon::parse($tugas->tgl_pengumpulan)->format('d M Y') }}</td>
          <td>
            <a href="{{ route('superadmin.detail-tugas', $tugas) }}" style="color:var(--purple-mid);font-size:12px;font-weight:600;text-decoration:none;">Lihat</a>
          </td>
        </tr>
        @empty
        <tr><td colspan="6" style="text-align:center;color:var(--gray-400);padding:20px;">Belum ada tugas</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</main>

</body>
</html>
