<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SITUGAS - Dashboard Guru</title>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
    :root{
      --blue-dark:#1a3faa;--blue-mid:#2451d1;--blue-light:#3b6ef8;--blue-pale:#eef2ff;
      --accent:#f59e0b;--red:#ef4444;--red-pale:#fef2f2;
      --orange:#f97316;--orange-pale:#fff7ed;
      --green:#22c55e;--green-pale:#f0fdf4;
      --gray-50:#f8fafc;--gray-100:#f1f5f9;--gray-200:#e2e8f0;
      --gray-400:#94a3b8;--gray-600:#475569;--gray-800:#1e293b;
      --white:#fff;--sidebar-w:220px;--radius:14px;
      --shadow-sm:0 1px 4px rgba(0,0,0,.06);--shadow-md:0 4px 16px rgba(0,0,0,.08);
    }
    body{font-family:'Plus Jakarta Sans',sans-serif;background:var(--gray-50);display:flex;min-height:100vh;color:var(--gray-800);overflow-x:hidden}

    /* SIDEBAR */
    .sidebar{width:var(--sidebar-w);min-height:100vh;background-image:url('/assets/sidebarbg.jpg');background-size:cover;background-position:center;background-attachment:fixed;display:flex;flex-direction:column;padding:28px 16px 24px;flex-shrink:0;position:fixed;top:0;left:0;bottom:0;z-index:100}
    .sidebar-logo{display:flex;align-items:center;justify-content:center;gap:10px;margin-bottom:18px}
    .logo-icon{width:38px;height:35px}
    .brand{font-size:15px;font-weight:900;color:#fff;letter-spacing:1px}
    .sidebar-divider{width:100%;height:1px;background:rgba(255,255,255,0.28);margin-bottom:24px}
    .nav-menu{display:flex;flex-direction:column;gap:4px;width:100%;flex:1}
    .nav-item{display:flex;align-items:center;gap:11px;padding:11px 16px;border-radius:10px;color:rgba(255,255,255,0.75);font-size:14px;font-weight:600;text-decoration:none;transition:all 0.2s;white-space:nowrap}
    .nav-item svg{width:19px;height:19px;flex-shrink:0;stroke:rgba(255,255,255,0.75);fill:none}
    .nav-item:hover{background:rgba(255,255,255,0.13);color:#fff}
    .nav-item:hover svg{stroke:#fff}
    .nav-item.active{background:#fff;color:var(--blue-mid);font-weight:700}
    .nav-item.active svg{stroke:var(--blue-mid)}
    .sidebar-footer{padding:14px 10px 6px;border-top:1px solid rgba(255,255,255,0.28);display:flex;flex-direction:column;gap:8px}
    .user-profile{display:flex;align-items:center;gap:8px;padding:8px 10px;border-radius:10px;background:rgba(255,255,255,0.08)}
    .user-avatar{width:36px;height:36px;border-radius:50%;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0}
    .user-name{font-size:13px;font-weight:600;color:rgba(255,255,255,0.95)}
    .user-role{font-size:11px;color:rgba(255,255,255,0.6)}
    .logout-btn{display:flex;align-items:center;justify-content:center;gap:8px;padding:8px 12px;border-radius:8px;color:rgba(255,255,255,0.8);font-size:13px;font-weight:600;background:rgba(255,255,255,0.08);border:none;cursor:pointer;width:100%;font-family:inherit;transition:all 0.2s}
    .logout-btn:hover{background:rgba(255,255,255,0.15);color:#fff}

    /* MAIN */
    main{margin-left:var(--sidebar-w);flex:1;padding:28px 32px;animation:fadeUp .45s ease both}
    @keyframes fadeUp{from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:translateY(0)}}

    .topbar{display:flex;justify-content:space-between;align-items:center;margin-bottom:24px}
    .page-title{font-size:20px;font-weight:800;color:var(--gray-800)}
    .page-sub{font-size:13px;color:var(--gray-400);margin-top:2px}
    .topbar-actions{display:flex;align-items:center;gap:10px}
    .btn-primary{background:var(--blue-mid);color:#fff;border:none;border-radius:8px;padding:10px 18px;font-size:13px;font-weight:700;cursor:pointer;display:inline-flex;align-items:center;gap:8px;text-decoration:none;font-family:inherit;transition:background 0.2s}
    .btn-primary:hover{background:var(--blue-dark)}
    .btn-primary svg{width:16px;height:16px;stroke:#fff;fill:none;stroke-width:2.5}
    .notif-btn{position:relative;background:none;border:1.5px solid var(--gray-200);border-radius:8px;width:36px;height:36px;cursor:pointer;display:flex;align-items:center;justify-content:center;text-decoration:none;transition:all 0.2s}
    .notif-btn:hover{background:var(--gray-100)}
    .notif-btn svg{width:18px;height:18px;stroke:var(--gray-600);fill:none}
    .notif-dot{position:absolute;top:-3px;right:-3px;width:10px;height:10px;background:#ef4444;border-radius:50%;border:2px solid var(--gray-50)}

    /* STAT CARDS */
    .stats{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:22px}
    .stat-card{background:var(--white);border-radius:var(--radius);padding:20px 22px;box-shadow:var(--shadow-sm);border:1px solid var(--gray-200);transition:transform .18s,box-shadow .18s}
    .stat-card:hover{transform:translateY(-2px);box-shadow:var(--shadow-md)}
    .stat-label{font-size:10.5px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--gray-400);margin-bottom:10px}
    .stat-value{font-size:34px;font-weight:800;color:var(--gray-800);line-height:1}
    .stat-value.green{color:var(--green)}
    .stat-value.orange{color:var(--orange)}

    /* TABLE CARD */
    .card{background:var(--white);border-radius:var(--radius);box-shadow:var(--shadow-sm);border:1px solid var(--gray-200);overflow:hidden;animation:fadeUp .5s .14s ease both}
    .card-header{padding:20px 24px 16px;border-bottom:1px solid var(--gray-100);display:flex;align-items:center;justify-content:space-between}
    .card-title{font-size:16px;font-weight:800}
    .link-all{font-size:12px;color:var(--blue-mid);text-decoration:none;font-weight:600}
    .link-all:hover{text-decoration:underline}

    table{width:100%;border-collapse:collapse}
    thead th{padding:11px 24px;text-align:left;font-size:10.5px;font-weight:700;letter-spacing:.09em;text-transform:uppercase;color:var(--gray-400);background:var(--gray-50);border-bottom:1px solid var(--gray-200)}
    tbody tr{border-bottom:1px solid var(--gray-100);transition:background .14s}
    tbody tr:last-child{border-bottom:none}
    tbody tr:hover{background:var(--gray-50)}
    tbody td{padding:13px 24px;font-size:13.5px;vertical-align:middle}
    .task-name{font-weight:600}
    .task-name a{text-decoration:none;color:var(--gray-800)}
    .task-name a:hover{color:var(--blue-mid)}
    .task-sub{font-size:11px;color:var(--gray-400);margin-top:2px}

    .badge{display:inline-flex;align-items:center;padding:4px 11px;border-radius:999px;font-size:11.5px;font-weight:700;white-space:nowrap}
    .badge-red{background:#fee2e2;color:#dc2626}
    .badge-orange{background:#ffedd5;color:#c2410c}
    .badge-yellow{background:#fef9c3;color:#a16207}
    .badge-blue{background:#dbeafe;color:#1d4ed8}
    .badge-green{background:#dcfce7;color:#166534}
    .badge-gray{background:var(--gray-100);color:var(--gray-600)}

    .progress-wrap{display:flex;flex-direction:column;gap:4px;min-width:100px}
    .progress-label{font-size:11px;font-weight:600;color:var(--gray-800)}
    .progress-bar{width:100%;height:6px;background:var(--gray-200);border-radius:999px;overflow:hidden}
    .progress-fill{height:100%;background:var(--blue-mid);border-radius:999px}

    .icon-btn{background:none;border:1.5px solid var(--gray-200);border-radius:8px;width:34px;height:34px;cursor:pointer;color:var(--gray-600);display:flex;align-items:center;justify-content:center;transition:all 0.2s;padding:0;text-decoration:none}
    .icon-btn:hover{background:var(--gray-100)}
    .icon-btn svg{width:16px;height:16px;stroke:currentColor;fill:none;stroke-width:2}

    .empty{text-align:center;padding:48px 24px;color:var(--gray-400)}
    .empty-text{font-size:15px;font-weight:600;margin-bottom:12px}

    /* NEW SUBMISSIONS BANNER */
    .new-submissions{background:linear-gradient(135deg,#1a3faa,#2451d1);border-radius:var(--radius);padding:20px 24px;color:#fff;margin-bottom:22px;display:flex;align-items:center;justify-content:space-between;gap:16px}
    .new-sub-text h3{font-size:15px;font-weight:700;margin-bottom:4px}
    .new-sub-text p{font-size:12px;opacity:0.8}
    .btn-white{background:#fff;color:var(--blue-mid);border:none;border-radius:8px;padding:9px 18px;font-size:12px;font-weight:700;cursor:pointer;text-decoration:none;white-space:nowrap;font-family:inherit}
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
    <a href="{{ route('guru.dashboard') }}" class="nav-item active">
      <svg viewBox="0 0 24 24" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1.2"/><rect x="14" y="3" width="7" height="7" rx="1.2"/><rect x="3" y="14" width="7" height="7" rx="1.2"/><rect x="14" y="14" width="7" height="7" rx="1.2"/></svg>
      Dashboard
    </a>
    <a href="{{ route('guru.kelola-tugas') }}" class="nav-item">
      <svg viewBox="0 0 24 24" stroke-width="2"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
      Tugas
    </a>
    
    <a href="{{ route('guru.notifikasi') }}" class="nav-item">
      <svg viewBox="0 0 24 24" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
      Notifikasi
      @php $unread = \App\Models\Notifikasi::where('user_id', auth()->id())->where('dibaca', false)->count(); @endphp
      @if($unread > 0)
        <span style="margin-left:auto;background:#ef4444;color:#fff;font-size:10px;font-weight:800;padding:2px 7px;border-radius:999px;">{{ $unread }}</span>
      @endif
    </a>
  </nav>
  <div class="sidebar-footer">
    <div class="user-profile">
      <div class="user-avatar">👨‍🏫</div>
      <div>
        <p class="user-name">{{ $guru->name }}</p>
        <p class="user-role">NIP: {{ $guru->nip }}</p>
      </div>
    </div>
    <form action="{{ route('logout') }}" method="POST">@csrf
      <button type="submit" class="logout-btn">
        <svg viewBox="0 0 24 24" style="width:16px;height:16px;stroke:currentColor;fill:none;stroke-width:2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
        Keluar
      </button>
    </form>
  </div>
</aside>

<main>
  <div class="topbar">
    <div>
      <h2 class="page-title">Dashboard Guru 👋</h2>
      <p class="page-sub">Selamat datang, {{ $guru->name }}. Pantau aktivitas tugas kelasmu.</p>
    </div>
    <div class="topbar-actions">
      @if($unread > 0)
        <a href="{{ route('guru.notifikasi') }}" class="notif-btn">
          <svg viewBox="0 0 24 24" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
          <span class="notif-dot"></span>
        </a>
      @endif
      <a href="{{ route('guru.buat-tugas') }}" class="btn-primary">
        <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Buat Tugas
      </a>
    </div>
  </div>

  {{-- Banner notifikasi pengumpulan baru --}}
  @php
    $pengumpulanBaru = \App\Models\Notifikasi::where('user_id', $guru->id)
      ->where('tipe', 'pengumpulan_siswa')
      ->where('dibaca', false)
      ->count();
  @endphp
  @if($pengumpulanBaru > 0)
    <div class="new-submissions">
      <div class="new-sub-text">
        <h3>📥 Ada {{ $pengumpulanBaru }} pengumpulan tugas baru!</h3>
        <p>Siswa baru saja mengumpulkan jawaban. Cek dan nilai sekarang.</p>
      </div>
      <a href="{{ route('guru.notifikasi') }}" class="btn-white">Lihat Notifikasi</a>
    </div>
  @endif

  <!-- STAT CARDS -->
  <div class="stats">
    <div class="stat-card">
      <p class="stat-label">TOTAL TUGAS</p>
      <p class="stat-value">{{ $totalTugas }}</p>
    </div>
    <div class="stat-card">
      <p class="stat-label">TUGAS AKTIF</p>
      <p class="stat-value {{ $tugasMendatang > 0 ? 'green' : '' }}">{{ $tugasMendatang }}</p>
    </div>
    <div class="stat-card">
      <p class="stat-label">TOTAL MURID</p>
      <p class="stat-value">{{ $totalSiswa }}</p>
    </div>
    <div class="stat-card">
      <p class="stat-label">TUGAS SELESAI</p>
      <p class="stat-value">{{ $totalTugas - $tugasMendatang }}</p>
    </div>
  </div>

  <!-- TABLE TUGAS TERKINI -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Tugas Terkini</h3>
      <a href="{{ route('guru.kelola-tugas') }}" class="link-all">Lihat Semua →</a>
    </div>
    <table>
      <thead>
        <tr>
          <th>Judul Tugas</th>
          <th>Kelas</th>
          <th>Deadline</th>
          <th>Status Waktu</th>
          <th>Pengumpulan</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($tugasRecentLimit as $t)
          @php
            $deadline = \Carbon\Carbon::parse($t->tgl_pengumpulan);
            $diff = now()->diffInDays($deadline, false);
            $total = $t->pengumpulan()->count();
            $sudah = $t->pengumpulan()->whereIn('status', ['proses','sudah'])->count();
            $pct = $total > 0 ? round($sudah / $total * 100) : 0;
          @endphp
          <tr>
            <td>
              <p class="task-name">
                <a href="{{ route('guru.show-tugas', $t->id) }}">{{ $t->judul }}</a>
              </p>
              <p class="task-sub">{{ $t->mapel }}</p>
            </td>
            <td><span class="badge badge-blue">{{ $t->kelas }}</span></td>
            <td style="font-size:12px;color:var(--gray-600)">{{ $deadline->translatedFormat('d M Y') }}</td>
            <td>
              @if($diff < 0)
                <span class="badge badge-gray">Selesai</span>
              @elseif($diff == 0)
                <span class="badge badge-red">Hari ini!</span>
              @elseif($diff <= 2)
                <span class="badge badge-orange">{{ $diff }} hari</span>
              @elseif($diff <= 7)
                <span class="badge badge-yellow">{{ $diff }} hari</span>
              @else
                <span class="badge badge-blue">{{ $diff }} hari</span>
              @endif
            </td>
            <td>
              <div class="progress-wrap">
                <span class="progress-label">{{ $sudah }}/{{ $total }}</span>
                <div class="progress-bar"><div class="progress-fill" style="width:{{ $pct }}%"></div></div>
              </div>
            </td>
            <td>
              <a href="{{ route('guru.show-tugas', $t->id) }}" class="icon-btn" title="Lihat detail & pengumpulan">
                <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
              </a>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="6">
              <div class="empty">
                <p class="empty-text">Belum ada tugas. Yuk buat tugas pertama!</p>
                <a href="{{ route('guru.buat-tugas') }}" class="btn-primary" style="display:inline-flex">+ Buat Tugas</a>
              </div>
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</main>
</body>
</html>