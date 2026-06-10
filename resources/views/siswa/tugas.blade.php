<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>SITUGAS – Daftar Tugas</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet"/>
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
  :root {
    --blue: #2563EB; --blue-mid: #2451d1; --blue-light: #eff6ff;
    --sidebar-w: 220px; --green: #16a34a; --green-bg: #dcfce7;
    --red: #dc2626; --red-bg: #fee2e2; --orange: #ea580c; --orange-bg: #ffedd5;
    --gray-50: #f9fafb; --gray-100: #f3f4f6; --gray-200: #e5e7eb;
    --gray-400: #9ca3af; --gray-600: #6b7280; --gray-800: #1e293b;
    --white: #fff; --radius: 14px;
    --shadow-sm: 0 1px 4px rgba(0,0,0,.06);
  }
  body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--gray-100); min-height: 100vh; display: flex; color: var(--gray-800); }

  .sidebar { width: var(--sidebar-w); min-height: 100vh; background-image: url('/assets/sidebarbg.jpg'); background-size: cover; background-position: center; background-attachment: fixed; display: flex; flex-direction: column; padding: 28px 16px 24px; flex-shrink: 0; position: fixed; top: 0; left: 0; bottom: 0; z-index: 100; }
  .sidebar-logo { display: flex; align-items: center; justify-content: center; gap: 10px; margin-bottom: 18px; }
  .logo-icon { width: 38px; height: 35px; }
  .brand { font-size: 15px; font-weight: 900; color: #fff; letter-spacing: 1px; }
  .sidebar-divider { width: 100%; height: 1px; background: rgba(255,255,255,0.28); margin-bottom: 24px; }
  .nav-menu { display: flex; flex-direction: column; gap: 4px; width: 100%; flex: 1; }
  .nav-item { display: flex; align-items: center; gap: 11px; padding: 11px 16px; border-radius: 10px; color: rgba(255,255,255,0.75); font-size: 14px; font-weight: 600; text-decoration: none; transition: all 0.2s; }
  .nav-item svg { width: 19px; height: 19px; flex-shrink: 0; stroke: rgba(255,255,255,0.75); fill: none; }
  .nav-item:hover { background: rgba(255,255,255,0.13); color: #fff; }
  .nav-item:hover svg { stroke: #fff; }
  .nav-item.active { background: #fff; color: var(--blue); font-weight: 700; }
  .nav-item.active svg { stroke: var(--blue); }
  .sidebar-footer { padding-top: 16px; border-top: 1px solid rgba(255,255,255,0.28); }
  .user-info { display: flex; align-items: center; gap: 11px; padding: 11px 16px; margin-bottom: 8px; }
  .user-avatar { width: 36px; height: 36px; border-radius: 50%; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; }
  .user-name { font-size: 13px; font-weight: 600; color: #fff; }
  .user-kelas { font-size: 11px; color: rgba(255,255,255,0.65); margin-top: 1px; }
  .logout-btn { width: 100%; display: flex; align-items: center; gap: 11px; padding: 11px 16px; border-radius: 10px; background: rgba(255,255,255,0.1); border: none; cursor: pointer; color: rgba(255,255,255,0.75); font-size: 14px; font-weight: 600; font-family: inherit; transition: all 0.2s; }
  .logout-btn:hover { background: rgba(255,255,255,0.15); color: #fff; }
  .logout-btn svg { width: 19px; height: 19px; stroke: currentColor; fill: none; }

  main { margin-left: var(--sidebar-w); flex: 1; padding: 32px 36px; }
  .page-header { margin-bottom: 24px; }
  .page-header h1 { font-size: 22px; font-weight: 800; margin-bottom: 4px; }
  .page-header p { font-size: 13px; color: var(--gray-400); }

  /* Filter tabs */
  .filter-tabs { display: flex; gap: 8px; margin-bottom: 20px; flex-wrap: wrap; }
  .filter-tab { padding: 7px 16px; border-radius: 999px; font-size: 12px; font-weight: 700; cursor: pointer; border: 1.5px solid var(--gray-200); background: var(--white); color: var(--gray-600); text-decoration: none; transition: all 0.2s; }
  .filter-tab:hover, .filter-tab.active { background: var(--blue); color: #fff; border-color: var(--blue); }
  .filter-tab.active.red { background: var(--red); border-color: var(--red); }
  .filter-tab.active.green { background: var(--green); border-color: var(--green); }

  .task-list { display: flex; flex-direction: column; gap: 12px; }
  .task-card { background: var(--white); border-radius: var(--radius); box-shadow: var(--shadow-sm); border: 1px solid var(--gray-200); padding: 20px 24px; display: flex; align-items: center; gap: 20px; transition: all 0.2s; text-decoration: none; color: inherit; }
  .task-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,.1); transform: translateY(-1px); }
  .task-card.late { border-left: 4px solid var(--red); }
  .task-card.selesai { border-left: 4px solid var(--green); opacity: 0.85; }

  .task-icon { width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0; }
  .task-icon.belum { background: #f1f5f9; }
  .task-icon.proses { background: var(--orange-bg); }
  .task-icon.sudah { background: var(--green-bg); }
  .task-icon.late-bg { background: var(--red-bg); }

  .task-body { flex: 1; }
  .task-title { font-size: 15px; font-weight: 700; margin-bottom: 4px; }
  .task-meta { display: flex; gap: 12px; align-items: center; font-size: 12px; color: var(--gray-400); flex-wrap: wrap; }
  .task-mapel { font-weight: 600; color: var(--blue); }
  .task-deadline { }

  .task-right { display: flex; flex-direction: column; align-items: flex-end; gap: 8px; }
  .sisa-waktu { font-size: 11px; font-weight: 700; }

  .badge { display: inline-flex; align-items: center; padding: 4px 11px; border-radius: 999px; font-size: 11px; font-weight: 700; }
  .badge-red { background: var(--red-bg); color: var(--red); }
  .badge-orange { background: var(--orange-bg); color: var(--orange); }
  .badge-yellow { background: #fef9c3; color: #a16207; }
  .badge-blue { background: #dbeafe; color: #1d4ed8; }
  .badge-green { background: var(--green-bg); color: var(--green); }
  .badge-gray { background: var(--gray-100); color: var(--gray-600); }

  .status-pill { display: inline-flex; align-items: center; gap: 5px; padding: 5px 12px; border-radius: 7px; font-size: 11.5px; font-weight: 700; border: 1.5px solid transparent; }
  .status-belum { border-color: #d1d5db; color: var(--gray-600); background: var(--white); }
  .status-proses { border-color: #fdba74; color: var(--orange); background: var(--orange-bg); }
  .status-sudah { border-color: #86efac; color: var(--green); background: var(--green-bg); }
  .status-terlambat { border-color: #fca5a5; color: var(--red); background: var(--red-bg); }

  .empty { text-align: center; padding: 60px 24px; color: var(--gray-400); }
  .empty-icon { font-size: 48px; margin-bottom: 12px; }
  .empty-text { font-size: 15px; font-weight: 600; }
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
    <a href="{{ route('siswa.dashboard') }}" class="nav-item">
      <svg viewBox="0 0 24 24" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1.2"/><rect x="14" y="3" width="7" height="7" rx="1.2"/><rect x="3" y="14" width="7" height="7" rx="1.2"/><rect x="14" y="14" width="7" height="7" rx="1.2"/></svg>
      Dashboard
    </a>
    <a href="{{ route('siswa.tugas') }}" class="nav-item active">
      <svg viewBox="0 0 24 24" stroke-width="2"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
      Tugas
    </a>
    <a href="{{ route('siswa.notifikasi') }}" class="nav-item">
      <svg viewBox="0 0 24 24" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
      Notifikasi
    </a>
  </nav>
  <div class="sidebar-footer">
    <div class="user-info">
      <div class="user-avatar">👨‍🎓</div>
      <div>
        <p class="user-name">{{ $siswa->name }}</p>
        <p class="user-kelas">{{ $siswa->kelas }}</p>
      </div>
    </div>
    <form action="{{ route('logout') }}" method="POST">@csrf
      <button type="submit" class="logout-btn">
        <svg viewBox="0 0 24 24" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
        Keluar
      </button>
    </form>
  </div>
</aside>

<main>
  <div class="page-header">
    <h1>Daftar Tugas 📋</h1>
    <p>Kelas {{ $siswa->kelas }} · Total {{ $pengumpulan->count() }} tugas</p>
  </div>

  @if(session('success'))
    <div style="background:#dcfce7;border:1px solid #86efac;border-radius:10px;padding:14px 18px;color:#166534;font-size:13px;font-weight:600;margin-bottom:20px;">
      ✅ {{ session('success') }}
    </div>
  @endif

  {{-- Filter tabs --}}
  @php
    $filter = request('filter', 'semua');
    $total = $pengumpulan->count();
    $belumCount = $pengumpulan->filter(fn($p) => $p->status === 'belum' && $p->tugas && !\Carbon\Carbon::parse($p->tugas->tgl_pengumpulan)->isPast())->count();
    $terlambatCount = $pengumpulan->filter(fn($p) => $p->status === 'belum' && $p->tugas && \Carbon\Carbon::parse($p->tugas->tgl_pengumpulan)->isPast())->count();
    $prosesCount = $pengumpulan->where('status', 'proses')->count();
    $selesaiCount = $pengumpulan->where('status', 'sudah')->count();
  @endphp

  <div class="filter-tabs">
    <a href="?filter=semua" class="filter-tab {{ $filter === 'semua' ? 'active' : '' }}">Semua ({{ $total }})</a>
    <a href="?filter=belum" class="filter-tab {{ $filter === 'belum' ? 'active' : '' }}">Belum ({{ $belumCount }})</a>
    <a href="?filter=terlambat" class="filter-tab {{ $filter === 'terlambat' ? 'active red' : '' }}">Terlambat ({{ $terlambatCount }})</a>
    <a href="?filter=proses" class="filter-tab {{ $filter === 'proses' ? 'active' : '' }}">Dikumpulkan ({{ $prosesCount }})</a>
    <a href="?filter=selesai" class="filter-tab {{ $filter === 'selesai' ? 'active green' : '' }}">Selesai ({{ $selesaiCount }})</a>
  </div>

  <div class="task-list">
    @php
      $filtered = $pengumpulan->filter(function($p) use ($filter) {
        if (!$p->tugas) return false;
        $isLate = $p->status === 'belum' && \Carbon\Carbon::parse($p->tugas->tgl_pengumpulan)->isPast();
        return match($filter) {
          'belum'     => $p->status === 'belum' && !$isLate,
          'terlambat' => $isLate,
          'proses'    => $p->status === 'proses',
          'selesai'   => $p->status === 'sudah',
          default     => true,
        };
      })->sortBy(fn($p) => optional($p->tugas)->tgl_pengumpulan);
    @endphp

    @forelse($filtered as $p)
      @php
        $tugas = $p->tugas;
        $deadline = \Carbon\Carbon::parse($tugas->tgl_pengumpulan);
        $isLate = $p->status === 'belum' && $deadline->isPast();
        $diffDays = (int) now()->diffInDays($deadline, false);
        $iconClass = $isLate ? 'late-bg' : $p->status;
        $icon = match(true) {
          $p->status === 'sudah' => '✅',
          $p->status === 'proses' => '📤',
          $isLate => '⚠️',
          default => '📝',
        };
      @endphp
      <a href="{{ route('siswa.detail-tugas', $tugas->id) }}" class="task-card {{ $isLate ? 'late' : ($p->status === 'sudah' ? 'selesai' : '') }}">
        <div class="task-icon {{ $iconClass }}">{{ $icon }}</div>
        <div class="task-body">
          <div class="task-title">{{ $tugas->judul }}</div>
          <div class="task-meta">
            <span class="task-mapel">{{ $tugas->mapel }}</span>
            <span>·</span>
            <span class="task-deadline">Deadline: {{ $deadline->translatedFormat('d M Y') }}</span>
            @if($tugas->guru)
              <span>·</span>
              <span>{{ $tugas->guru->name }}</span>
            @endif
          </div>
        </div>
        <div class="task-right">
          @if($isLate)
            <span class="badge badge-red">Terlambat</span>
          @elseif($diffDays >= 0 && $diffDays <= 0)
            <span class="badge badge-orange">Hari ini!</span>
          @elseif($diffDays > 0 && $diffDays <= 3)
            <span class="badge badge-yellow">{{ $diffDays }} hari lagi</span>
          @elseif($diffDays > 3)
            <span class="badge badge-blue">{{ $diffDays }} hari lagi</span>
          @else
            <span class="badge badge-green">Selesai</span>
          @endif

          @if($isLate)
            <span class="status-pill status-terlambat">⚠️ Terlambat</span>
          @elseif($p->status === 'belum')
            <span class="status-pill status-belum">Belum</span>
          @elseif($p->status === 'proses')
            <span class="status-pill status-proses">📤 Dikumpulkan</span>
          @elseif($p->status === 'sudah')
            <span class="status-pill status-sudah">✅ Selesai</span>
          @endif
        </div>
      </a>
    @empty
      <div class="empty">
        <div class="empty-icon">📭</div>
        <div class="empty-text">Tidak ada tugas di kategori ini.</div>
      </div>
    @endforelse
  </div>
</main>
</body>
</html>
