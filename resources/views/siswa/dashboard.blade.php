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
    --blue-mid: #2451d1; --blue-pale: #eef2ff;
    --accent: #f59e0b; --red: #ef4444; --red-pale: #fef2f2;
    --orange: #f97316; --orange-pale: #fff7ed;
    --green: #22c55e; --green-pale: #f0fdf4;
    --gray-50: #f8fafc; --gray-100: #f1f5f9; --gray-200: #e2e8f0;
    --gray-400: #94a3b8; --gray-600: #475569; --gray-800: #1e293b;
    --white: #fff; --sidebar-w: 220px; --radius: 14px;
    --shadow-sm: 0 1px 4px rgba(0,0,0,.06); --shadow-md: 0 4px 16px rgba(0,0,0,.08);
  }
  body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--gray-50); color: var(--gray-800); display: flex; min-height: 100vh; overflow-x: hidden; }

  .sidebar { width: var(--sidebar-w); min-height: 100vh; background-image: url('/assets/sidebarbg.jpg'); background-size: cover; background-position: center; background-attachment: fixed; display: flex; flex-direction: column; padding: 28px 16px 24px; flex-shrink: 0; position: fixed; top: 0; left: 0; bottom: 0; z-index: 100; }
  .sidebar-logo { display: flex; align-items: center; justify-content: center; gap: 10px; margin-bottom: 18px; }
  .logo-icon { width: 38px; height: 35px; }
  .brand { font-size: 15px; font-weight: 900; color: #fff; letter-spacing: 1px; }
  .sidebar-divider { width: 100%; height: 1px; background: rgba(255,255,255,0.28); margin-bottom: 24px; }
  .nav-menu { display: flex; flex-direction: column; gap: 4px; width: 100%; flex: 1; }
  .nav-item { display: flex; align-items: center; gap: 11px; padding: 11px 16px; border-radius: 10px; color: rgba(255,255,255,0.75); font-size: 14px; font-weight: 600; text-decoration: none; transition: all 0.2s; }
  .nav-item svg { width: 19px; height: 19px; flex-shrink: 0; stroke: rgba(255,255,255,0.75); fill: none; transition: stroke 0.2s; }
  .nav-item:hover { background: rgba(255,255,255,0.13); color: #fff; }
  .nav-item:hover svg { stroke: #fff; }
  .nav-item.active { background: #fff; color: var(--blue-mid); font-weight: 700; }
  .nav-item.active svg { stroke: var(--blue-mid); }
  .sidebar-footer { padding-top: 16px; border-top: 1px solid rgba(255,255,255,0.28); }
  .user-info { display: flex; align-items: center; gap: 11px; padding: 11px 16px; margin-bottom: 8px; }
  .user-avatar { width: 36px; height: 36px; border-radius: 50%; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; }
  .user-name { font-size: 13px; font-weight: 600; color: #fff; }
  .user-kelas { font-size: 11px; color: rgba(255,255,255,0.65); margin-top: 1px; }
  .logout-btn { width: 100%; display: flex; align-items: center; gap: 11px; padding: 11px 16px; border-radius: 10px; background: rgba(255,255,255,0.1); border: none; cursor: pointer; color: rgba(255,255,255,0.75); font-size: 14px; font-weight: 600; font-family: inherit; transition: all 0.2s; }
  .logout-btn:hover { background: rgba(255,255,255,0.15); color: #fff; }
  .logout-btn svg { width: 19px; height: 19px; stroke: currentColor; fill: none; }

  main { margin-left: var(--sidebar-w); flex: 1; padding: 28px 32px; animation: fadeUp .45s ease both; }
  @keyframes fadeUp { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }

  .page-title { font-size: 22px; font-weight: 800; margin-bottom: 4px; }
  .page-sub { font-size: 13px; color: var(--gray-400); margin-bottom: 24px; }

  .stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 22px; }
  .stat-card { background: var(--white); border-radius: var(--radius); padding: 20px 22px; box-shadow: var(--shadow-sm); border: 1px solid var(--gray-200); }
  .stat-label { font-size: 10.5px; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; color: var(--gray-400); margin-bottom: 10px; }
  .stat-value { font-size: 34px; font-weight: 800; color: var(--gray-800); line-height: 1; }
  .stat-value.red { color: var(--red); }
  .stat-value.orange { color: var(--orange); }
  .stat-value.green { color: var(--green); }

  .alert-banner { background: var(--blue-pale); border: 1.5px solid #c7d7fe; border-radius: var(--radius); padding: 14px 20px; display: flex; align-items: center; gap: 12px; margin-bottom: 24px; }
  .alert-icon { width: 28px; height: 28px; background: var(--blue-mid); color: white; border-radius: 8px; display: grid; place-items: center; font-size: 15px; font-weight: 800; flex-shrink: 0; }
  .alert-text { font-size: 14px; font-weight: 600; color: var(--blue-mid); }

  .table-card { background: var(--white); border-radius: var(--radius); box-shadow: var(--shadow-sm); border: 1px solid var(--gray-200); overflow: hidden; }
  .table-header { padding: 20px 24px 16px; border-bottom: 1px solid var(--gray-100); display: flex; align-items: center; justify-content: space-between; }
  .table-title { font-size: 16px; font-weight: 800; }
  .table-link { font-size: 13px; color: var(--blue-mid); font-weight: 600; text-decoration: none; }
  .table-link:hover { text-decoration: underline; }

  table { width: 100%; border-collapse: collapse; }
  thead th { padding: 11px 24px; text-align: left; font-size: 10.5px; font-weight: 700; letter-spacing: .09em; text-transform: uppercase; color: var(--gray-400); background: var(--gray-50); border-bottom: 1px solid var(--gray-200); }
  tbody tr { border-bottom: 1px solid var(--gray-100); transition: background .14s; }
  tbody tr:last-child { border-bottom: none; }
  tbody tr:hover { background: var(--gray-50); }
  tbody tr.row-late { background: var(--red-pale); }
  tbody tr.row-late:hover { background: #fde8e8; }
  tbody td { padding: 13px 24px; font-size: 13.5px; vertical-align: middle; }

  .task-name { font-weight: 600; }
  .task-link { text-decoration: none; color: var(--gray-800); font-weight: 600; }
  .task-link:hover { color: var(--blue-mid); }
  .task-link.late { color: var(--red); }

  .badge { display: inline-flex; align-items: center; padding: 4px 11px; border-radius: 999px; font-size: 11.5px; font-weight: 700; white-space: nowrap; }
  .badge-red    { background: #fee2e2; color: #dc2626; }
  .badge-orange { background: #ffedd5; color: #c2410c; }
  .badge-yellow { background: #fef9c3; color: #a16207; }
  .badge-blue   { background: #dbeafe; color: #1d4ed8; }
  .badge-green  { background: #dcfce7; color: #166534; }
  .badge-gray   { background: var(--gray-100); color: var(--gray-600); }

  .status-badge { display: inline-flex; align-items: center; padding: 4px 11px; border-radius: 7px; font-size: 11.5px; font-weight: 700; border: 1.5px solid transparent; }
  .status-belum { border-color: #d1d5db; color: var(--gray-600); background: var(--white); }
  .status-belum.late { border-color: #fca5a5; color: var(--red); background: #fef2f2; }
  .status-proses { border-color: #fdba74; color: #c2410c; background: #fff7ed; }
  .status-sudah { border-color: #86efac; color: #166534; background: #f0fdf4; }
  .status-terlambat { border-color: #fca5a5; color: var(--red); background: #fef2f2; }

  .empty { text-align: center; padding: 40px 24px; color: var(--gray-400); font-size: 14px; }
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
    <a href="{{ route('siswa.dashboard') }}" class="nav-item active">
      <svg viewBox="0 0 24 24" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1.2"/><rect x="14" y="3" width="7" height="7" rx="1.2"/><rect x="3" y="14" width="7" height="7" rx="1.2"/><rect x="14" y="14" width="7" height="7" rx="1.2"/></svg>
      Dashboard
    </a>
    <a href="{{ route('siswa.tugas') }}" class="nav-item">
      <svg viewBox="0 0 24 24" stroke-width="2"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
      Tugas
    </a>
    <a href="{{ route('siswa.notifikasi') }}" class="nav-item">
      <svg viewBox="0 0 24 24" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
      Notifikasi
      @if($notifikasiTerbaru > 0)
        <span style="margin-left:auto;background:#ef4444;color:#fff;font-size:10px;font-weight:800;padding:2px 7px;border-radius:999px;">{{ $notifikasiTerbaru }}</span>
      @endif
    </a>
  </nav>
  <div class="sidebar-footer">
    <div class="user-info">
      <div class="user-avatar">👨‍🎓</div>
      <div>
        <p class="user-name">{{ $siswa->name }}</p>
        <p class="user-kelas">{{ $siswa->kelas }} · NIS {{ $siswa->nis }}</p>
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
  <p class="page-title">Halo, {{ $siswa->name }} 👋</p>
  <p class="page-sub">Kelas {{ $siswa->kelas }} · Berikut ringkasan tugas kamu hari ini.</p>

  <div class="stats">
    <div class="stat-card">
      <div class="stat-label">Total Tugas</div>
      <div class="stat-value">{{ $tugasTotal }}</div>
    </div>
    <div class="stat-card">
      <div class="stat-label">Belum Dikerjakan</div>
      <div class="stat-value {{ $tugasBelumSelesai > 0 ? 'orange' : '' }}">{{ $tugasBelumSelesai }}</div>
    </div>
    <div class="stat-card">
      <div class="stat-label">Terlambat</div>
      <div class="stat-value {{ $tugasTerlambat > 0 ? 'red' : '' }}">{{ $tugasTerlambat }}</div>
    </div>
    <div class="stat-card">
      <div class="stat-label">Sudah Selesai</div>
      <div class="stat-value {{ $tugasSelesai > 0 ? 'green' : '' }}">{{ $tugasSelesai }}</div>
    </div>
  </div>

  @if($tugasSegera > 0)
  <div class="alert-banner">
    <div class="alert-icon">!</div>
    <span class="alert-text">Kamu punya {{ $tugasSegera }} tugas yang deadline-nya dalam 3 hari ke depan. Segera kumpulkan!</span>
  </div>
  @elseif($tugasTerlambat > 0)
  <div class="alert-banner" style="background:#fef2f2;border-color:#fecaca;">
    <div class="alert-icon" style="background:#ef4444;">!</div>
    <span class="alert-text" style="color:#dc2626;">Kamu punya {{ $tugasTerlambat }} tugas yang sudah melewati deadline dan belum dikumpulkan.</span>
  </div>
  @endif

  <div class="table-card">
    <div class="table-header">
      <div class="table-title">Tugas Mendatang (Deadline Terdekat)</div>
      <a href="{{ route('siswa.tugas') }}" class="table-link">Lihat semua →</a>
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
        @forelse($tugasRecentLimit as $p)
          @php
            $tugas = $p->tugas;
            $deadline = $tugas ? \Carbon\Carbon::parse($tugas->tgl_pengumpulan) : null;
            $isLate = $deadline && $deadline->isPast() && $p->status === 'belum';
            $diff = $deadline ? now()->diffInDays($deadline, false) : null;
          @endphp
          <tr class="{{ $isLate ? 'row-late' : '' }}">
            <td>
              <a href="{{ route('siswa.detail-tugas', $tugas->id) }}" class="task-link {{ $isLate ? 'late' : '' }}">
                {{ $tugas->judul ?? '-' }}
              </a>
            </td>
            <td>{{ $tugas->mapel ?? '-' }}</td>
            <td style="font-size:12px;color:var(--gray-600)">{{ $deadline ? $deadline->translatedFormat('d M Y') : '-' }}</td>
            <td>
              @if($isLate)
                <span class="badge badge-red">Terlambat</span>
              @elseif($diff !== null && $diff >= 0 && $diff <= 1)
                <span class="badge badge-orange">{{ $diff == 0 ? 'Hari ini' : '1 hari' }}</span>
              @elseif($diff !== null && $diff <= 3)
                <span class="badge badge-yellow">{{ $diff }} hari</span>
              @elseif($diff !== null && $diff > 3)
                <span class="badge badge-blue">{{ $diff }} hari</span>
              @else
                <span class="badge badge-gray">-</span>
              @endif
            </td>
            <td>
              @if($p->status === 'belum' && $isLate)
                <span class="status-badge status-belum late">Terlambat</span>
              @elseif($p->status === 'belum')
                <span class="status-badge status-belum">Belum</span>
              @elseif($p->status === 'proses')
                <span class="status-badge status-proses">Dikumpulkan</span>
              @elseif($p->status === 'sudah')
                <span class="status-badge status-sudah">Selesai</span>
              @else
                <span class="status-badge status-belum">{{ $p->status }}</span>
              @endif
            </td>
          </tr>
        @empty
          <tr><td colspan="5" class="empty">🎉 Tidak ada tugas saat ini. Enjoy!</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</main>
</body>
</html>