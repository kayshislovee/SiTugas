<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/><meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SITUGAS – Semua Tugas</title>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
  <style>
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
    :root{
      --blue-mid:#2451d1;--blue-pale:#eef2ff;
      --purple-mid:#6d28d9;--purple-pale:#f5f3ff;
      --gray-50:#f8fafc;--gray-100:#f1f5f9;--gray-200:#e2e8f0;
      --gray-400:#94a3b8;--gray-600:#475569;--gray-800:#1e293b;
      --white:#fff;--red:#ef4444;--red-pale:#fef2f2;
      --orange:#f97316;--green:#22c55e;--green-pale:#f0fdf4;
      --sidebar-w:230px;--radius:14px;
      --shadow-sm:0 1px 4px rgba(0,0,0,.06);--shadow-md:0 4px 16px rgba(0,0,0,.08)
    }
    body{font-family:'Plus Jakarta Sans',sans-serif;background:var(--gray-50);display:flex;min-height:100vh;color:var(--gray-800)}

    /* ── SIDEBAR (sama seperti halaman lain) ── */
    .sidebar{width:var(--sidebar-w);min-height:100vh;background-image:url('/assets/sidebarbg.jpg');background-size:cover;background-position:center;background-attachment:fixed;display:flex;flex-direction:column;padding:28px 16px 24px;flex-shrink:0;position:fixed;top:0;left:0;bottom:0;z-index:100}
    .sidebar::before{content:'';position:absolute;inset:0;background:linear-gradient(160deg,rgba(76,29,149,0.6),rgba(36,81,209,0.4));pointer-events:none}
    .sidebar>*{position:relative;z-index:1}
    .sidebar-logo{display:flex;align-items:center;justify-content:center;gap:10px;margin-bottom:6px}
    .logo-icon{width:38px;height:35px}
    .brand{font-size:15px;font-weight:900;color:#fff;letter-spacing:1px}
    .admin-chip{background:rgba(255,255,255,0.15);border:1px solid rgba(255,255,255,0.25);border-radius:999px;padding:3px 12px;font-size:10px;font-weight:700;color:rgba(255,255,255,0.9);text-transform:uppercase;display:block;text-align:center;margin-bottom:22px}
    .sidebar-divider{width:100%;height:1px;background:rgba(255,255,255,0.2);margin-bottom:16px}
    .nav-section-label{font-size:10px;font-weight:700;color:rgba(255,255,255,0.45);letter-spacing:.1em;text-transform:uppercase;padding:0 16px;margin-bottom:6px;margin-top:12px}
    .nav-menu{display:flex;flex-direction:column;gap:3px;width:100%;flex:1}
    .nav-item{display:flex;align-items:center;gap:11px;padding:10px 16px;border-radius:10px;color:rgba(255,255,255,0.75);font-size:13.5px;font-weight:600;text-decoration:none;transition:all 0.2s}
    .nav-item svg{width:17px;height:17px;flex-shrink:0;stroke:rgba(255,255,255,0.75);fill:none}
    .nav-item:hover{background:rgba(255,255,255,0.13);color:#fff}
    .nav-item:hover svg{stroke:#fff}
    .nav-item.active{background:#fff;color:var(--purple-mid);font-weight:700}
    .nav-item.active svg{stroke:var(--purple-mid)}
    .sidebar-footer{padding:14px 10px 6px;border-top:1px solid rgba(255,255,255,0.2);display:flex;flex-direction:column;gap:8px}
    .user-profile{display:flex;align-items:center;gap:8px;padding:8px 10px;border-radius:10px;background:rgba(255,255,255,0.08)}
    .user-avatar{width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,var(--purple-mid),var(--blue-mid));display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0}
    .user-name{font-size:13px;font-weight:600;color:rgba(255,255,255,0.95)}
    .user-role{font-size:11px;color:rgba(255,255,255,0.6)}
    .logout-btn{display:flex;align-items:center;justify-content:center;gap:8px;padding:8px 12px;border-radius:8px;color:rgba(255,255,255,0.8);font-size:13px;font-weight:600;background:rgba(255,255,255,0.08);border:none;cursor:pointer;width:100%;font-family:inherit}
    .logout-btn:hover{background:rgba(255,255,255,0.15);color:#fff}

    /* ── MAIN ── */
    main{margin-left:var(--sidebar-w);flex:1;padding:28px 32px;animation:fadeUp .45s ease both}
    @keyframes fadeUp{from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:translateY(0)}}

    /* ── TOPBAR ── */
    .topbar{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:22px;gap:12px;flex-wrap:wrap}
    .page-title{font-size:20px;font-weight:700}
    .page-subtitle{font-size:13px;color:var(--gray-400);margin-top:2px}

    /* ── MINI STAT STRIP ── */
    .stat-strip{display:flex;gap:12px;margin-bottom:20px;flex-wrap:wrap}
    .stat-pill{background:var(--white);border:1px solid var(--gray-200);border-radius:12px;padding:12px 18px;display:flex;align-items:center;gap:10px;box-shadow:var(--shadow-sm);min-width:130px}
    .stat-pill-icon{width:34px;height:34px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .stat-pill-icon svg{width:17px;height:17px;stroke:currentColor;fill:none;stroke-width:2}
    .stat-pill-icon.purple{background:var(--purple-pale);color:var(--purple-mid)}
    .stat-pill-icon.blue{background:var(--blue-pale);color:var(--blue-mid)}
    .stat-pill-icon.green{background:var(--green-pale);color:#16a34a}
    .stat-pill-icon.orange{background:#fff7ed;color:#ea580c}
    .stat-pill-label{font-size:10.5px;font-weight:700;color:var(--gray-400);text-transform:uppercase;letter-spacing:.06em}
    .stat-pill-value{font-size:20px;font-weight:800;color:var(--gray-800);line-height:1.1}

    /* ── FILTER BAR ── */
    .filter-bar{background:var(--white);border:1px solid var(--gray-200);border-radius:var(--radius);padding:16px 20px;margin-bottom:20px;box-shadow:var(--shadow-sm)}
    .filter-bar-title{font-size:12px;font-weight:700;color:var(--gray-400);text-transform:uppercase;letter-spacing:.07em;margin-bottom:12px}
    .filter-row{display:flex;gap:10px;flex-wrap:wrap;align-items:flex-end}
    .filter-group{display:flex;flex-direction:column;gap:5px}
    .filter-group label{font-size:11px;font-weight:700;color:var(--gray-600);text-transform:uppercase;letter-spacing:.05em}
    .filter-group select,.filter-group input{padding:8px 14px;border:1.5px solid var(--gray-200);border-radius:9px;font-size:13px;font-family:inherit;background:var(--gray-50);color:var(--gray-800);outline:none;transition:border-color .2s;min-width:170px}
    .filter-group select:focus,.filter-group input:focus{border-color:var(--purple-mid)}
    .filter-actions{display:flex;gap:8px;align-items:flex-end}
    .btn-filter{padding:9px 20px;background:linear-gradient(135deg,var(--purple-mid),var(--blue-mid));color:#fff;border:none;border-radius:9px;font-size:13px;font-weight:700;cursor:pointer;font-family:inherit;display:inline-flex;align-items:center;gap:6px}
    .btn-filter svg{width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2.5}
    .btn-reset{padding:9px 16px;background:var(--gray-100);color:var(--gray-600);border:1.5px solid var(--gray-200);border-radius:9px;font-size:13px;font-weight:600;cursor:pointer;font-family:inherit;text-decoration:none;display:inline-flex;align-items:center}

    /* ── ACTIVE FILTERS ── */
    .active-filters{display:flex;flex-wrap:wrap;gap:8px;margin-bottom:14px}
    .filter-tag{display:inline-flex;align-items:center;gap:6px;padding:5px 12px;background:var(--purple-pale);border:1.5px solid #ddd6fe;border-radius:999px;font-size:12px;font-weight:600;color:var(--purple-mid)}
    .filter-tag-x{font-size:14px;line-height:1;cursor:pointer;opacity:.7}
    .filter-tag-x:hover{opacity:1}

    /* ── TABLE CARD ── */
    .card{background:var(--white);border-radius:var(--radius);box-shadow:var(--shadow-sm);border:1px solid var(--gray-200);overflow:hidden}
    .card-header{padding:18px 24px;border-bottom:1px solid var(--gray-100);display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap}
    .card-title{font-size:15px;font-weight:800;display:flex;align-items:center;gap:8px}
    .count-badge{background:var(--purple-pale);color:var(--purple-mid);padding:3px 10px;border-radius:999px;font-size:12px;font-weight:700}

    table{width:100%;border-collapse:collapse}
    thead th{padding:11px 20px;text-align:left;font-size:10.5px;font-weight:700;letter-spacing:.09em;text-transform:uppercase;color:var(--gray-400);background:var(--gray-50);border-bottom:1px solid var(--gray-200);white-space:nowrap}
    thead th:first-child{padding-left:24px}
    thead th:last-child{padding-right:24px}
    tbody tr{border-bottom:1px solid var(--gray-100);transition:background .14s}
    tbody tr:last-child{border-bottom:none}
    tbody tr:hover{background:var(--gray-50)}
    tbody td{padding:13px 20px;font-size:13.5px;vertical-align:middle}
    tbody td:first-child{padding-left:24px}
    tbody td:last-child{padding-right:24px}

    .task-name{font-weight:700;color:var(--gray-800);margin-bottom:2px}
    .task-sub{font-size:11px;color:var(--gray-400)}
    .guru-name{font-size:12px;color:var(--gray-600);font-weight:600}
    .guru-nip{font-size:10.5px;color:var(--gray-400);font-family:'DM Mono',monospace;margin-top:2px}

    /* BADGES */
    .badge{display:inline-flex;align-items:center;padding:4px 10px;border-radius:999px;font-size:11px;font-weight:700;white-space:nowrap}
    .badge-purple{background:var(--purple-pale);color:var(--purple-mid)}
    .badge-blue{background:var(--blue-pale);color:var(--blue-mid)}
    .badge-green{background:var(--green-pale);color:#166534}
    .badge-red{background:var(--red-pale);color:#dc2626}
    .badge-orange{background:#fff7ed;color:#c2410c}
    .badge-gray{background:var(--gray-100);color:var(--gray-600)}

    /* PROGRESS */
    .progress-wrap{min-width:90px}
    .progress-label{font-size:11px;font-weight:700;color:var(--gray-800);margin-bottom:4px}
    .progress-bar{width:100%;height:6px;background:var(--gray-200);border-radius:999px;overflow:hidden}
    .progress-fill{height:100%;border-radius:999px;background:linear-gradient(90deg,var(--purple-mid),var(--blue-mid))}
    .progress-fill.green{background:linear-gradient(90deg,#22c55e,#16a34a)}
    .progress-fill.red{background:linear-gradient(90deg,#f97316,#ef4444)}

    /* DEADLINE */
    .deadline-soon{color:#c2410c;font-weight:700}
    .deadline-past{color:#dc2626;font-weight:700}
    .deadline-ok{color:var(--gray-800)}

    /* ACTION */
    .btn-view{display:inline-flex;align-items:center;gap:5px;padding:6px 14px;background:var(--purple-pale);color:var(--purple-mid);border:none;border-radius:7px;font-size:12px;font-weight:700;cursor:pointer;text-decoration:none;transition:background .15s}
    .btn-view:hover{background:#ede9fe}
    .btn-view svg{width:13px;height:13px;stroke:currentColor;fill:none;stroke-width:2.5}

    /* PAGINATION */
    .pagination-wrap{padding:16px 24px;display:flex;justify-content:space-between;align-items:center;border-top:1px solid var(--gray-100)}
    .pagination-info{font-size:12px;color:var(--gray-400)}

    /* EMPTY */
    .empty-state{text-align:center;padding:60px 20px}
    .empty-icon{width:64px;height:64px;background:var(--purple-pale);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px}
    .empty-icon svg{width:32px;height:32px;stroke:var(--purple-mid);fill:none;stroke-width:1.5}
    .empty-title{font-size:16px;font-weight:700;margin-bottom:6px}
    .empty-sub{font-size:13px;color:var(--gray-400)}

    /* RESPONSIVE */
    @media(max-width:1200px){thead th.hide-md,tbody td.hide-md{display:none}}
    @media(max-width:900px){
      .sidebar{width:70px;padding:20px 8px}
      main{margin-left:70px;padding:20px 16px}
      .nav-item span,.brand,.admin-chip,.nav-section-label,.user-name,.user-role{display:none}
      .nav-item{justify-content:center;padding:10px 8px}
      .stat-strip{gap:8px}
      .stat-pill{min-width:110px;padding:10px 14px}
      thead th.hide-sm,tbody td.hide-sm{display:none}
    }
  </style>
</head>
<body>

<!-- ===== SIDEBAR ===== -->
<aside class="sidebar">
  <div class="sidebar-logo">
    <img src="{{ asset('assets/logo.png') }}" class="logo-icon" alt="Logo"/>
    <span class="brand">SITUGAS</span>
  </div>
  <span class="admin-chip">⚡ Super Admin</span>
  <div class="sidebar-divider"></div>
  <nav class="nav-menu">
    <div class="nav-section-label">Overview</div>
    <a href="{{ route('superadmin.dashboard') }}" class="nav-item">
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
    <a href="{{ route('superadmin.kelola-tugas') }}" class="nav-item active">
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
        <svg viewBox="0 0 24 24" style="width:16px;height:16px;stroke:currentColor;fill:none;stroke-width:2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
        <span>Keluar</span>
      </button>
    </form>
  </div>
</aside>

<!-- ===== MAIN ===== -->
<main>

  <!-- Topbar -->
  <div class="topbar">
    <div>
      <h2 class="page-title">Semua Tugas</h2>
      <p class="page-subtitle">Pantau seluruh tugas dari semua guru dan semua kelas</p>
    </div>
  </div>

  @if(session('success'))
    <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;padding:12px 16px;color:#166534;font-size:13px;font-weight:600;margin-bottom:16px">✅ {{ session('success') }}</div>
  @endif

  <!-- Stat Strip -->
  @php
    $totalTugas    = $tugas->total();
    $totalAktif    = \App\Models\Tugas::where('tgl_pengumpulan', '>=', now())->count();
    $totalSelesai  = \App\Models\Tugas::where('tgl_pengumpulan', '<', now())->count();
    $totalKelas    = $kelasList->count();
  @endphp
  <div class="stat-strip">
    <div class="stat-pill">
      <div class="stat-pill-icon purple">
        <svg viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
      </div>
      <div>
        <p class="stat-pill-label">Total Tugas</p>
        <p class="stat-pill-value">{{ \App\Models\Tugas::count() }}</p>
      </div>
    </div>
    <div class="stat-pill">
      <div class="stat-pill-icon blue">
        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
      </div>
      <div>
        <p class="stat-pill-label">Masih Aktif</p>
        <p class="stat-pill-value">{{ $totalAktif }}</p>
      </div>
    </div>
    <div class="stat-pill">
      <div class="stat-pill-icon green">
        <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
      </div>
      <div>
        <p class="stat-pill-label">Sudah Lewat</p>
        <p class="stat-pill-value">{{ $totalSelesai }}</p>
      </div>
    </div>
    <div class="stat-pill">
      <div class="stat-pill-icon orange">
        <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
      </div>
      <div>
        <p class="stat-pill-label">Total Kelas</p>
        <p class="stat-pill-value">{{ $totalKelas }}</p>
      </div>
    </div>
  </div>

  <!-- Filter Bar -->
  <div class="filter-bar">
    <p class="filter-bar-title">🔍 Filter Tugas</p>
    <form method="GET" action="{{ route('superadmin.kelola-tugas') }}">
      <div class="filter-row">
        <div class="filter-group">
          <label>Kelas</label>
          <select name="kelas">
            <option value="">Semua Kelas</option>
            @foreach($kelasList as $k)
              <option value="{{ $k }}" {{ request('kelas') === $k ? 'selected' : '' }}>{{ $k }}</option>
            @endforeach
          </select>
        </div>
        <div class="filter-group">
          <label>Guru</label>
          <select name="guru_id">
            <option value="">Semua Guru</option>
            @foreach($guruList as $g)
              <option value="{{ $g->id }}" {{ request('guru_id') == $g->id ? 'selected' : '' }}>{{ $g->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="filter-actions">
          <button type="submit" class="btn-filter">
            <svg viewBox="0 0 24 24"><polyline points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
            Terapkan
          </button>
          @if(request('kelas') || request('guru_id'))
            <a href="{{ route('superadmin.kelola-tugas') }}" class="btn-reset">Reset</a>
          @endif
        </div>
      </div>
    </form>
  </div>

  <!-- Active Filter Tags -->
  @if(request('kelas') || request('guru_id'))
    <div class="active-filters">
      <span style="font-size:12px;color:var(--gray-400);font-weight:600;align-self:center">Filter aktif:</span>
      @if(request('kelas'))
        <span class="filter-tag">
          📚 Kelas: {{ request('kelas') }}
          <a href="{{ route('superadmin.kelola-tugas', array_merge(request()->except('kelas'))) }}" class="filter-tag-x">×</a>
        </span>
      @endif
      @if(request('guru_id'))
        @php $namaGuru = $guruList->firstWhere('id', request('guru_id'))?->name ?? 'Unknown'; @endphp
        <span class="filter-tag">
          👤 Guru: {{ $namaGuru }}
          <a href="{{ route('superadmin.kelola-tugas', array_merge(request()->except('guru_id'))) }}" class="filter-tag-x">×</a>
        </span>
      @endif
    </div>
  @endif

  <!-- Table -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">
        Daftar Tugas
        <span class="count-badge">{{ $tugas->total() }} tugas</span>
      </h3>
    </div>

    <table>
      <thead>
        <tr>
          <th style="width:36px">#</th>
          <th>Judul Tugas</th>
          <th class="hide-sm">Guru Pengampu</th>
          <th>Kelas</th>
          <th class="hide-sm">Mapel</th>
          <th>Deadline</th>
          <th class="hide-md">Progress</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($tugas as $i => $t)
          @php
            $now         = \Carbon\Carbon::now();
            $deadline    = \Carbon\Carbon::parse($t->tgl_pengumpulan);
            $isLate      = $deadline->isPast();
            $isSoon      = !$isLate && $deadline->diffInDays($now) <= 3;
            $totalSiswa  = $t->pengumpulan->count();
            $sudah       = $t->pengumpulan->whereIn('status', ['sudah','proses'])->count();
            $pct         = $totalSiswa > 0 ? round($sudah / $totalSiswa * 100) : 0;
          @endphp
          <tr>
            <td style="color:var(--gray-400);font-size:12px;font-family:'DM Mono',monospace">
              {{ $tugas->firstItem() + $i }}
            </td>
            <td>
              <p class="task-name">{{ $t->judul }}</p>
              <p class="task-sub">Dibuat {{ \Carbon\Carbon::parse($t->created_at)->diffForHumans() }}</p>
            </td>
            <td class="hide-sm">
              <p class="guru-name">{{ optional($t->guru)->name ?? '—' }}</p>
              <p class="guru-nip">{{ optional($t->guru)->nip }}</p>
            </td>
            <td>
              <span class="badge badge-purple">{{ $t->kelas }}</span>
            </td>
            <td class="hide-sm" style="font-size:13px;color:var(--gray-600)">{{ $t->mapel }}</td>
            <td>
              <span class="{{ $isLate ? 'deadline-past' : ($isSoon ? 'deadline-soon' : 'deadline-ok') }}" style="font-size:13px">
                {{ $deadline->format('d M Y') }}
              </span>
              @if($isLate)
                <span class="badge badge-red" style="display:block;margin-top:3px;width:fit-content">Lewat</span>
              @elseif($isSoon)
                <span class="badge badge-orange" style="display:block;margin-top:3px;width:fit-content">
                  {{ $deadline->diffInDays($now) == 0 ? 'Hari ini' : $deadline->diffInDays($now) . ' hari lagi' }}
                </span>
              @else
                <span class="badge badge-green" style="display:block;margin-top:3px;width:fit-content">Aktif</span>
              @endif
            </td>
            <td class="hide-md">
              @if($totalSiswa > 0)
                <div class="progress-wrap">
                  <p class="progress-label">{{ $sudah }}/{{ $totalSiswa }} siswa</p>
                  <div class="progress-bar">
                    <div class="progress-fill {{ $pct >= 80 ? 'green' : ($pct < 30 && $isLate ? 'red' : '') }}"
                         style="width:{{ $pct }}%"></div>
                  </div>
                </div>
              @else
                <span style="font-size:12px;color:var(--gray-400)">—</span>
              @endif
            </td>
            <td>
              <a href="{{ route('superadmin.detail-tugas', $t) }}" class="btn-view">
                <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                Detail
              </a>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="8">
              <div class="empty-state">
                <div class="empty-icon">
                  <svg viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                </div>
                <p class="empty-title">Tidak ada tugas ditemukan</p>
                <p class="empty-sub">Coba ubah filter atau belum ada tugas yang dibuat</p>
              </div>
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>

    <div class="pagination-wrap">
      <p class="pagination-info">
        Menampilkan {{ $tugas->firstItem() }}–{{ $tugas->lastItem() }} dari {{ $tugas->total() }} tugas
      </p>
      {{ $tugas->withQueryString()->links() }}
    </div>
  </div>

</main>
</body>
</html>
