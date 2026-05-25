<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SITUGAS — Detail Tugas</title>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
  <style>
    *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
    :root { --blue: #2d52ff; --blue-dark: #1a38cc; --sidebar-w: 210px; }
    html, body { height: 100%; font-family: 'Plus Jakarta Sans', sans-serif; background: #f0f4ff; }
    body { display: flex; min-height: 100vh; }

    .sidebar {
      width: var(--sidebar-w); min-height: 100vh;
      background-image: url('/assets/sidebarbg.jpg');
      background-size: cover; background-position: center;
      display: flex; flex-direction: column; padding: 28px 16px 24px;
      flex-shrink: 0; position: fixed; top: 0; left: 0; bottom: 0; z-index: 100;
    }
    .sidebar-logo { display: flex; align-items: center; justify-content: center; gap: 10px; margin-bottom: 18px; }
    .logo-icon { width: 38px; height: 35px; }
    .brand { font-size: 15px; font-weight: 800; color: #fff; letter-spacing: 1px; }
    .sidebar-divider { width: 100%; height: 1px; background: rgba(255,255,255,0.28); margin-bottom: 28px; }
    .nav-menu { display: flex; flex-direction: column; gap: 4px; width: 100%; }
    .nav-item {
      display: flex; align-items: center; gap: 11px; padding: 11px 16px;
      border-radius: 10px; color: rgba(255,255,255,0.75); font-size: 14px;
      font-weight: 600; text-decoration: none; transition: all 0.2s;
    }
    .nav-item svg { width: 19px; height: 19px; stroke: rgba(255,255,255,0.75); fill: none; }
    .nav-item:hover { background: rgba(255,255,255,0.13); color: #fff; }
    .nav-item.active { background: #fff; color: #2451d1; font-weight: 700; }
    .nav-item.active svg { stroke: #2451d1; }

    .main { margin-left: var(--sidebar-w); flex: 1; display: flex; flex-direction: column; min-height: 100vh; }
    .topbar {
      height: 64px; background: #fff; display: flex; align-items: center;
      justify-content: space-between; padding: 0 36px;
      border-bottom: 1px solid #e4eaf5; position: sticky; top: 0; z-index: 50;
    }
    .breadcrumb { display: flex; align-items: center; gap: 7px; font-size: 13px; color: #9aa5c4; font-weight: 500; }
    .breadcrumb a { color: #9aa5c4; text-decoration: none; }
    .breadcrumb a:hover { color: var(--blue); }
    .breadcrumb svg { width: 14px; height: 14px; stroke: #c5d0e8; fill: none; stroke-width: 2; }
    .breadcrumb-current { color: #1a2060; font-weight: 700; }

    .content { flex: 1; padding: 32px 36px; display: flex; flex-direction: column; gap: 20px; }

    .card { background: #fff; border-radius: 16px; box-shadow: 0 2px 16px rgba(45,82,255,0.06); overflow: hidden; }
    .card-header { padding: 24px 28px 20px; border-bottom: 1px solid #f0f2f8; }
    .card-header h2 { font-size: 20px; font-weight: 800; color: #0f1740; margin-bottom: 10px; }
    .meta-row { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
    .badge { display: inline-block; padding: 3px 12px; border-radius: 999px; font-size: 12px; font-weight: 600; }
    .badge-blue { background: #e0e8ff; color: #2d52ff; }
    .badge-red  { background: #ffe5e5; color: #e05252; }
    .badge-green { background: #dcfce7; color: #166534; }
    .meta-plain { font-size: 13px; color: #555; font-weight: 500; }

    .card-body { padding: 20px 28px; font-size: 13.5px; color: #555; line-height: 1.8; }

    .card-actions { padding: 0 28px 20px; display: flex; gap: 10px; }
    .btn-edit {
      padding: 9px 22px; border: 1.5px solid #dde3f0; border-radius: 8px;
      background: #fff; color: #333; font-size: 13px; font-weight: 600;
      font-family: 'Plus Jakarta Sans', sans-serif; cursor: pointer;
      text-decoration: none; transition: background 0.2s;
    }
    .btn-edit:hover { background: #f5f7ff; }

    /* Table */
    .table-header { display: flex; align-items: center; justify-content: space-between; padding: 18px 24px 14px; border-bottom: 1px solid #f0f2f8; }
    .table-header h3 { font-size: 15px; font-weight: 700; color: #1a2060; }
    table { width: 100%; border-collapse: collapse; }
    thead tr { background: #f5f7ff; }
    thead th { padding: 12px 20px; font-size: 11px; font-weight: 700; letter-spacing: 0.8px; text-transform: uppercase; color: #8899bb; text-align: left; }
    tbody tr { border-top: 1px solid #f0f2f8; transition: background 0.15s; }
    tbody tr:hover { background: #f8faff; }
    tbody td { padding: 14px 20px; font-size: 13px; color: #333; font-weight: 500; }

    .status-sudah { display: inline-block; padding: 5px 14px; border-radius: 999px; font-size: 12px; font-weight: 600; background: transparent; border: 1.5px solid #22c08a; color: #22c08a; }
    .status-belum { display: inline-block; padding: 5px 14px; border-radius: 999px; font-size: 12px; font-weight: 600; background: transparent; border: 1.5px solid #ccd0dd; color: #555; }

    .btn-toggle {
      padding: 7px 18px; border-radius: 8px; font-size: 12px; font-weight: 700;
      font-family: 'Plus Jakarta Sans', sans-serif; cursor: pointer; transition: background 0.2s; border: none;
    }
    .btn-toggle-sudah { background: var(--blue); color: #fff; }
    .btn-toggle-sudah:hover { background: var(--blue-dark); }
    .btn-toggle-belum { background: #fff; color: var(--blue); border: 1.5px solid var(--blue); }
    .btn-toggle-belum:hover { background: #eef1ff; }

    .flash-success { background: #d1fae5; border: 1px solid #6ee7b7; color: #065f46; padding: 12px 20px; border-radius: 10px; font-size: 13.5px; font-weight: 600; }
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
      <a href="/guru/dashboard" class="nav-item">
        <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <rect x="3" y="3" width="7" height="7" rx="1.2"/><rect x="14" y="3" width="7" height="7" rx="1.2"/>
          <rect x="3" y="14" width="7" height="7" rx="1.2"/><rect x="14" y="14" width="7" height="7" rx="1.2"/>
        </svg>
        Dashboard
      </a>
      <a href="/guru/kelola-tugas" class="nav-item active">
        <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
        </svg>
        Tugas
      </a>
      <a href="/guru/notifikasi" class="nav-item">
        <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/>
        </svg>
        Notifikasi
      </a>
    </nav>
  </aside>

  <div class="main">
    <header class="topbar">
      <div class="breadcrumb">
        <a href="{{ route('guru.kelola-tugas') }}">Kelola Tugas</a>
        <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
        <span class="breadcrumb-current">{{ $tugas->judul }}</span>
      </div>
      <a href="{{ route('guru.edit-tugas', $tugas->id) }}" class="btn-edit">✏ Edit Tugas</a>
    </header>

    <div class="content">

      @if(session('success'))
        <div class="flash-success">✓ {{ session('success') }}</div>
      @endif

      <!-- Info tugas -->
      <div class="card">
        <div class="card-header">
          <h2>{{ $tugas->judul }}</h2>
          <div class="meta-row">
            <span class="meta-plain">{{ $tugas->mapel }}</span>
            <span class="badge badge-blue">{{ $tugas->kelas }}</span>
            <span class="badge badge-red">Deadline: {{ $tugas->tgl_pengumpulan->format('d M Y') }}</span>
            <span class="badge" style="background:#e0e8ff;color:#2d52ff;">
              Pemberian: {{ $tugas->tgl_pemberian->format('d M Y') }}
            </span>
          </div>
        </div>
        <div class="card-body">
          {{ $tugas->deskripsi ?? '(Tidak ada deskripsi)' }}
        </div>
      </div>

      <!-- Daftar pengumpulan -->
      <div class="card">
        <div class="table-header">
          <h3>Daftar Pengumpulan ({{ $daftarPengumpulan->count() }} siswa)</h3>
          <span class="badge badge-green">
            {{ $daftarPengumpulan->where('status', 'sudah')->count() }} sudah dikumpulkan
          </span>
        </div>

        @if($daftarPengumpulan->isEmpty())
          <div style="padding:32px;text-align:center;color:#9aa5c4;font-size:13.5px;">
            Belum ada siswa di kelas ini yang terdaftar.
          </div>
        @else
        <table>
          <thead>
            <tr>
              <th>#</th>
              <th>Nama Siswa</th>
              <th>NIS</th>
              <th>Status</th>
              <th>Dikumpulkan</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($daftarPengumpulan as $i => $p)
            <tr>
              <td>{{ $i + 1 }}</td>
              <td>{{ $p->siswa->name }}</td>
              <td>{{ $p->siswa->nis ?? '-' }}</td>
              <td>
                @if($p->status === 'sudah')
                  <span class="status-sudah">Sudah</span>
                @else
                  <span class="status-belum">Belum</span>
                @endif
              </td>
              <td>{{ $p->dikumpulkan_at ? $p->dikumpulkan_at->format('d M Y H:i') : '-' }}</td>
              <td>
                <form method="POST" action="{{ route('guru.toggle-status', $p->id) }}" style="display:inline;">
                  @csrf
                  @if($p->status === 'sudah')
                    <button type="submit" class="btn-toggle btn-toggle-belum">Tandai Belum</button>
                  @else
                    <button type="submit" class="btn-toggle btn-toggle-sudah">Tandai Sudah</button>
                  @endif
                </form>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        @endif
      </div>

    </div>
  </div>

</body>
</html>
