<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SITUGAS — {{ $tugas->judul }}</title>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet"/>
  <style>
    *,*::before,*::after{margin:0;padding:0;box-sizing:border-box}
    :root{
      --blue:#2451d1;--blue-dark:#1a38cc;--blue-pale:#eef2ff;
      --green:#16a34a;--green-pale:#f0fdf4;
      --red:#dc2626;--red-pale:#fef2f2;
      --orange:#ea580c;--orange-pale:#fff7ed;
      --yellow-pale:#fef9c3;
      --gray-50:#f8fafc;--gray-100:#f1f5f9;--gray-200:#e2e8f0;
      --gray-400:#94a3b8;--gray-600:#475569;--gray-800:#1e293b;
      --white:#fff;--sidebar-w:220px;--radius:14px;
      --shadow-sm:0 1px 4px rgba(0,0,0,.06);--shadow-md:0 4px 20px rgba(0,0,0,.1)
    }
    body{font-family:'Plus Jakarta Sans',sans-serif;background:#f0f4ff;display:flex;min-height:100vh;color:var(--gray-800)}

    /* ═══ SIDEBAR ═══ */
    .sidebar{width:var(--sidebar-w);min-height:100vh;background-image:url('/assets/sidebarbg.jpg');background-size:cover;background-position:center;background-attachment:fixed;display:flex;flex-direction:column;padding:28px 16px 24px;flex-shrink:0;position:fixed;top:0;left:0;bottom:0;z-index:100}
    .sidebar-logo{display:flex;align-items:center;justify-content:center;gap:10px;margin-bottom:18px}
    .logo-icon{width:38px;height:35px}
    .brand{font-size:15px;font-weight:900;color:#fff;letter-spacing:1px}
    .sidebar-divider{width:100%;height:1px;background:rgba(255,255,255,.28);margin-bottom:24px}
    .nav-menu{display:flex;flex-direction:column;gap:4px;width:100%;flex:1}
    .nav-item{display:flex;align-items:center;gap:11px;padding:11px 16px;border-radius:10px;color:rgba(255,255,255,.75);font-size:14px;font-weight:600;text-decoration:none;transition:all .2s;white-space:nowrap}
    .nav-item svg{width:19px;height:19px;flex-shrink:0;stroke:rgba(255,255,255,.75);fill:none}
    .nav-item:hover{background:rgba(255,255,255,.13);color:#fff}
    .nav-item:hover svg{stroke:#fff}
    .nav-item.active{background:#fff;color:var(--blue);font-weight:700}
    .nav-item.active svg{stroke:var(--blue)}
    .notif-badge{margin-left:auto;background:#ef4444;color:#fff;font-size:10px;font-weight:800;min-width:20px;height:20px;padding:0 5px;border-radius:999px;display:inline-flex;align-items:center;justify-content:center}
    .sidebar-footer{padding-top:16px;border-top:1px solid rgba(255,255,255,.28);display:flex;flex-direction:column;gap:8px}
    .user-info-wrap{display:flex;align-items:center;gap:8px;padding:8px 10px;border-radius:10px;background:rgba(255,255,255,.08)}
    .user-avatar{width:36px;height:36px;border-radius:50%;background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0}
    .user-name{font-size:13px;font-weight:600;color:rgba(255,255,255,.95)}
    .user-role{font-size:11px;color:rgba(255,255,255,.6)}
    .logout-btn{display:flex;align-items:center;justify-content:center;gap:8px;padding:8px 12px;border-radius:8px;color:rgba(255,255,255,.8);font-size:13px;font-weight:600;background:rgba(255,255,255,.08);border:none;cursor:pointer;width:100%;font-family:inherit;transition:all .2s}
    .logout-btn:hover{background:rgba(255,255,255,.15);color:#fff}

    /* ═══ MAIN ═══ */
    .main{margin-left:var(--sidebar-w);flex:1;display:flex;flex-direction:column;min-height:100vh}
    .topbar{height:60px;background:#fff;display:flex;align-items:center;padding:0 32px;border-bottom:1px solid #e4eaf5;position:sticky;top:0;z-index:50;gap:12px}
    .btn-back{display:inline-flex;align-items:center;gap:6px;padding:8px 14px;background:var(--gray-100);border:none;border-radius:8px;color:var(--gray-600);font-size:13px;font-weight:600;cursor:pointer;font-family:inherit;text-decoration:none;transition:all .2s}
    .btn-back:hover{background:var(--gray-200)}
    .topbar-title{font-size:14px;font-weight:700;flex:1;color:var(--gray-800);overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
    .topbar-actions{display:flex;gap:8px}
    .btn-edit{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border:1.5px solid var(--gray-200);border-radius:8px;background:#fff;color:var(--gray-800);font-size:13px;font-weight:600;text-decoration:none;cursor:pointer;transition:all .2s}
    .btn-edit:hover{background:var(--gray-50);border-color:var(--gray-400)}
    .btn-danger{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border:1.5px solid #fecaca;border-radius:8px;background:#fff;color:var(--red);font-size:13px;font-weight:600;cursor:pointer;font-family:inherit;transition:all .2s}
    .btn-danger:hover{background:var(--red-pale)}

    .content{flex:1;padding:24px 32px;display:flex;flex-direction:column;gap:18px;animation:fadeUp .4s ease both}
    @keyframes fadeUp{from{opacity:0;transform:translateY(10px)}to{opacity:1;transform:translateY(0)}}

    /* ═══ CARDS ═══ */
    .card{background:#fff;border-radius:var(--radius);box-shadow:var(--shadow-sm);border:1px solid #e8ecf8;overflow:hidden}
    .card-header{padding:20px 28px 16px;border-bottom:1px solid #f0f2f8;display:flex;align-items:flex-start;justify-content:space-between;gap:12px;flex-wrap:wrap}
    .card-header-left h2{font-size:20px;font-weight:800;color:#0f1740;margin-bottom:10px}
    .card-header-left h3{font-size:15px;font-weight:700;color:#0f1740}
    .meta-row{display:flex;align-items:center;gap:8px;flex-wrap:wrap}
    .badge{display:inline-flex;align-items:center;padding:3px 12px;border-radius:999px;font-size:12px;font-weight:600;white-space:nowrap}
    .badge-blue{background:#e0e8ff;color:#2451d1}
    .badge-red{background:var(--red-pale);color:var(--red)}
    .badge-green{background:#dcfce7;color:var(--green)}
    .badge-yellow{background:var(--yellow-pale);color:#92400e}
    .badge-gray{background:var(--gray-100);color:var(--gray-600)}
    .badge-orange{background:var(--orange-pale);color:var(--orange)}
    .card-body{padding:20px 28px;font-size:13.5px;color:var(--gray-600);line-height:1.8}

    /* File soal box */
    .file-soal{display:flex;align-items:center;gap:14px;background:#f5f8ff;border:1.5px solid #dce4ff;border-radius:12px;padding:14px 20px;margin-top:14px}
    .file-soal-icon{width:40px;height:40px;background:#e0e7ff;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:20px}
    .file-soal-name{flex:1;font-size:13px;font-weight:600;color:#2d52ff;word-break:break-all}
    .btn-download{padding:8px 16px;background:var(--blue);color:#fff;border:none;border-radius:8px;font-size:12px;font-weight:700;cursor:pointer;text-decoration:none;transition:background .2s}
    .btn-download:hover{background:var(--blue-dark)}

    /* Stats row */
    .stats-row{display:grid;grid-template-columns:repeat(5,1fr);gap:0;background:#f8faff;border-bottom:1px solid #f0f2f8}
    .mini-stat{text-align:center;padding:18px 12px;position:relative}
    .mini-stat:not(:last-child)::after{content:'';position:absolute;right:0;top:20%;height:60%;width:1px;background:#e8ecf8}
    .mini-stat-val{font-size:26px;font-weight:800;color:var(--gray-800);line-height:1;margin-bottom:4px}
    .mini-stat-val.green{color:var(--green)}
    .mini-stat-val.orange{color:var(--orange)}
    .mini-stat-val.red{color:var(--red)}
    .mini-stat-val.blue{color:var(--blue)}
    .mini-stat-label{font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:var(--gray-400)}

    /* Progress bar */
    .progress-wrap{padding:14px 28px;background:#f8faff;border-bottom:1px solid #f0f2f8}
    .progress-label{font-size:12px;font-weight:700;color:var(--gray-600);margin-bottom:6px;display:flex;justify-content:space-between}
    .progress-bar{width:100%;height:7px;background:var(--gray-200);border-radius:999px;overflow:hidden}
    .progress-fill{height:100%;background:linear-gradient(90deg,var(--blue),#4f8ef7);border-radius:999px;transition:width .6s ease}

    /* Filter tabs */
    .filter-bar{display:flex;gap:6px;padding:14px 28px 0;flex-wrap:wrap}
    .filter-btn{padding:6px 14px;border-radius:999px;font-size:12px;font-weight:700;cursor:pointer;border:1.5px solid var(--gray-200);background:#fff;color:var(--gray-600);font-family:inherit;transition:all .15s}
    .filter-btn:hover{border-color:var(--blue);color:var(--blue)}
    .filter-btn.active{background:var(--blue);color:#fff;border-color:var(--blue)}
    .filter-count{background:rgba(255,255,255,.25);border-radius:999px;padding:1px 7px;font-size:10px;margin-left:4px}
    .filter-btn:not(.active) .filter-count{background:var(--gray-100);color:var(--gray-600)}

    /* ═══ TABLE ═══ */
    .table-wrap{overflow-x:auto}
    table{width:100%;border-collapse:collapse;min-width:750px}
    thead tr{background:#f5f7ff}
    thead th{padding:12px 20px;font-size:10.5px;font-weight:700;letter-spacing:.07em;text-transform:uppercase;color:var(--gray-400);text-align:left;white-space:nowrap}
    tbody tr{border-top:1px solid #f0f2f8;transition:background .14s}
    tbody tr:hover{background:#f8faff}
    tbody td{padding:13px 20px;font-size:13px;color:var(--gray-800);vertical-align:middle}

    /* Status pills */
    .status-pill{display:inline-flex;align-items:center;gap:5px;padding:5px 12px;border-radius:999px;font-size:11.5px;font-weight:700;border:1.5px solid transparent;white-space:nowrap}
    .pill-belum{border-color:#d1d5db;color:#6b7280;background:#fff}
    .pill-proses{border-color:#fdba74;color:var(--orange);background:var(--orange-pale)}
    .pill-sudah{border-color:#86efac;color:var(--green);background:var(--green-pale)}
    .pill-terlambat{border-color:#fca5a5;color:var(--red);background:var(--red-pale)}

    /* File jawaban actions */
    .file-actions{display:flex;gap:6px;flex-wrap:wrap}
    .btn-preview{display:inline-flex;align-items:center;gap:5px;padding:6px 12px;background:var(--blue-pale);color:var(--blue);border:none;border-radius:7px;font-size:12px;font-weight:700;cursor:pointer;font-family:inherit;transition:background .15s;white-space:nowrap}
    .btn-preview:hover{background:#dce6ff}
    .btn-preview svg{width:13px;height:13px;stroke:currentColor;fill:none;stroke-width:2}
    .btn-dl-jawaban{display:inline-flex;align-items:center;gap:5px;padding:6px 12px;background:var(--green-pale);color:var(--green);border:none;border-radius:7px;font-size:12px;font-weight:700;cursor:pointer;text-decoration:none;transition:background .15s;white-space:nowrap}
    .btn-dl-jawaban:hover{background:#dcfce7}
    .btn-dl-jawaban svg{width:13px;height:13px;stroke:currentColor;fill:none;stroke-width:2}
    .no-file{color:var(--gray-400);font-size:12px}

    /* Nilai form */
    .nilai-wrap{display:flex;flex-direction:column;gap:5px}
    .nilai-display{font-size:22px;font-weight:900;color:var(--green);line-height:1}
    .nilai-sub{font-size:10.5px;color:var(--gray-400);font-weight:600}
    .nilai-form{display:flex;align-items:center;gap:6px}
    .nilai-input{width:65px;padding:7px 8px;border:1.5px solid var(--gray-200);border-radius:8px;font-size:13px;font-weight:700;text-align:center;font-family:'DM Mono',monospace;outline:none;transition:border-color .2s}
    .nilai-input:focus{border-color:var(--blue)}
    .btn-nilai{padding:7px 12px;background:var(--blue);color:#fff;border:none;border-radius:8px;font-size:12px;font-weight:700;cursor:pointer;font-family:inherit;transition:background .2s;white-space:nowrap}
    .btn-nilai:hover{background:var(--blue-dark)}
    .feedback-wrap{margin-top:4px}
    .feedback-input{width:150px;padding:5px 8px;border:1.5px solid var(--gray-200);border-radius:7px;font-size:11.5px;font-family:inherit;resize:none;height:38px;outline:none}
    .feedback-input:focus{border-color:var(--blue)}

    /* Feedback display */
    .feedback-display{font-size:11.5px;color:var(--gray-600);background:var(--gray-50);border-radius:7px;padding:5px 9px;max-width:180px;border:1px solid var(--gray-200)}

    .catatan-cell{font-size:12px;color:var(--gray-600);max-width:140px;word-break:break-word}

    .empty-row td{text-align:center;padding:48px;color:var(--gray-400);font-size:14px}

    .flash-ok{background:#d1fae5;border:1px solid #6ee7b7;color:#065f46;padding:12px 20px;border-radius:10px;font-size:13px;font-weight:600;display:flex;align-items:center;gap:8px}
    .flash-err{background:var(--red-pale);border:1px solid #fca5a5;color:#b91c1c;padding:12px 20px;border-radius:10px;font-size:13px;font-weight:600}

    /* ═══ FILE PREVIEW MODAL ═══ */
    .modal-overlay{position:fixed;inset:0;background:rgba(0,0,0,.65);z-index:999;display:none;align-items:center;justify-content:center;padding:20px;backdrop-filter:blur(3px)}
    .modal-overlay.open{display:flex}
    .modal-box{background:#fff;border-radius:16px;width:100%;max-width:860px;max-height:90vh;display:flex;flex-direction:column;box-shadow:0 20px 60px rgba(0,0,0,.35);overflow:hidden}
    .modal-header{padding:16px 22px;border-bottom:1px solid var(--gray-200);display:flex;align-items:center;gap:12px}
    .modal-file-icon{width:36px;height:36px;background:var(--blue-pale);border-radius:9px;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0}
    .modal-title{flex:1;font-size:14px;font-weight:700;color:var(--gray-800);overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
    .modal-subtitle{font-size:11.5px;color:var(--gray-400);margin-top:2px}
    .modal-close{width:32px;height:32px;border:none;background:var(--gray-100);border-radius:8px;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:18px;color:var(--gray-600);flex-shrink:0;transition:background .2s}
    .modal-close:hover{background:var(--gray-200)}
    .modal-body{flex:1;overflow:auto;background:#f0f4ff;display:flex;align-items:center;justify-content:center;min-height:400px}
    .modal-body iframe{width:100%;height:500px;border:none}
    .modal-body img{max-width:100%;max-height:70vh;border-radius:8px;box-shadow:var(--shadow-md)}
    .modal-unsupported{text-align:center;padding:48px;color:var(--gray-400)}
    .modal-unsupported .icon{font-size:48px;margin-bottom:16px}
    .modal-unsupported p{font-size:14px;font-weight:600;margin-bottom:14px}
    .modal-footer{padding:14px 22px;border-top:1px solid var(--gray-200);display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap}
    .modal-info{font-size:12px;color:var(--gray-400)}
    .modal-actions{display:flex;gap:8px}
    .modal-btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:8px;font-size:13px;font-weight:700;cursor:pointer;border:none;font-family:inherit;transition:all .2s;text-decoration:none}
    .modal-btn.primary{background:var(--blue);color:#fff}
    .modal-btn.primary:hover{background:var(--blue-dark)}
    .modal-btn.secondary{background:var(--gray-100);color:var(--gray-800)}
    .modal-btn.secondary:hover{background:var(--gray-200)}
    .modal-btn svg{width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2.5}

    @media(max-width:900px){
      .sidebar{width:70px;padding:20px 8px}
      .main{margin-left:70px}
      .nav-item span,.brand,.sidebar-divider+.nav-menu~.sidebar-footer .user-name,.user-role{display:none}
      .nav-item{justify-content:center;padding:10px 8px}
      .stats-row{grid-template-columns:repeat(3,1fr)}
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
    <a href="{{ route('guru.dashboard') }}" class="nav-item">
      <svg viewBox="0 0 24 24" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1.2"/><rect x="14" y="3" width="7" height="7" rx="1.2"/><rect x="3" y="14" width="7" height="7" rx="1.2"/><rect x="14" y="14" width="7" height="7" rx="1.2"/></svg>
      <span>Dashboard</span>
    </a>
    <a href="{{ route('guru.kelola-tugas') }}" class="nav-item active">
      <svg viewBox="0 0 24 24" stroke-width="2"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
      <span>Tugas</span>
    </a>
    
    <a href="{{ route('guru.notifikasi') }}" class="nav-item">
      <svg viewBox="0 0 24 24" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
      <span>Notifikasi</span>
      @php $unread = \App\Models\Notifikasi::where('user_id', auth()->id())->where('dibaca', false)->count(); @endphp
      @if($unread > 0)
        <span class="notif-badge">{{ $unread > 99 ? '99+' : $unread }}</span>
      @endif
    </a>
  </nav>
  <div class="sidebar-footer">
    <div class="user-info-wrap">
      <div class="user-avatar">👨‍🏫</div>
      <div>
        <p class="user-name">{{ auth()->user()->name }}</p>
        <p class="user-role">Guru</p>
      </div>
    </div>
    <form action="{{ route('logout') }}" method="POST">@csrf
      <button type="submit" class="logout-btn">
        <svg viewBox="0 0 24 24" style="width:16px;height:16px;stroke:currentColor;fill:none;stroke-width:2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
        <span>Keluar</span>
      </button>
    </form>
  </div>
</aside>

<!-- ══ MAIN ══ -->
<div class="main">
  <div class="topbar">
    <a href="{{ route('guru.kelola-tugas') }}" class="btn-back">
      <svg viewBox="0 0 24 24" style="width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2.5"><polyline points="15 18 9 12 15 6"/></svg>
      Kembali
    </a>
    <span class="topbar-title">{{ $tugas->judul }}</span>
    <div class="topbar-actions">
      <a href="{{ route('guru.edit-tugas', $tugas->id) }}" class="btn-edit">✏️ Edit</a>
      <form method="POST" action="{{ route('guru.destroy-tugas', $tugas->id) }}"
            onsubmit="return confirm('Hapus tugas ini? Semua data pengumpulan ikut terhapus.')">
        @csrf @method('DELETE')
        <button type="submit" class="btn-danger">🗑 Hapus</button>
      </form>
    </div>
  </div>

  <div class="content">

    @if(session('success'))
      <div class="flash-ok">✅ {{ session('success') }}</div>
    @endif
    @if(session('error'))
      <div class="flash-err">⚠️ {{ session('error') }}</div>
    @endif

    <!-- INFO TUGAS -->
    <div class="card">
      <div class="card-header">
        <div class="card-header-left">
          <h2>{{ $tugas->judul }}</h2>
          <div class="meta-row">
            <span class="badge badge-blue">{{ $tugas->mapel }}</span>
            <span class="badge badge-blue">Kelas {{ $tugas->kelas }}</span>
            <span class="badge badge-yellow">
              📅 Diberikan: {{ \Carbon\Carbon::parse($tugas->tgl_pemberian)->format('d M Y') }}
            </span>
            <span class="badge {{ \Carbon\Carbon::parse($tugas->tgl_pengumpulan)->isPast() ? 'badge-red' : 'badge-orange' }}">
              ⏰ Deadline: {{ \Carbon\Carbon::parse($tugas->tgl_pengumpulan)->format('d M Y') }}
            </span>
            @if(\Carbon\Carbon::parse($tugas->tgl_pengumpulan)->isPast())
              <span class="badge badge-gray">Sudah lewat deadline</span>
            @else
              <span class="badge badge-green">{{ \Carbon\Carbon::parse($tugas->tgl_pengumpulan)->diffForHumans() }}</span>
            @endif
          </div>
        </div>
      </div>

      @if($tugas->deskripsi)
        <div class="card-body">{{ $tugas->deskripsi }}</div>
      @endif

      @if($tugas->file_path)
        <div class="card-body" style="padding-top:0">
          <div class="file-soal">
            <div class="file-soal-icon">📄</div>
            <div class="file-soal-name">{{ $tugas->file_original_name }}</div>
            <a href="{{ asset('storage/' . $tugas->file_path) }}" download class="btn-download">
              ⬇ Download Soal
            </a>
          </div>
        </div>
      @endif
    </div>

    <!-- DAFTAR PENGUMPULAN -->
    <div class="card">
      @php
        $total   = $daftarPengumpulan->count();
        $sudah   = $daftarPengumpulan->whereIn('status', ['proses','sudah'])->count();
        $belum   = $daftarPengumpulan->where('status', 'belum')->count();
        $dinilai = $daftarPengumpulan->whereNotNull('nilai')->count();
        $terlambat = $daftarPengumpulan->where('status', 'terlambat')->count();
        $pct     = $total > 0 ? round($sudah / $total * 100) : 0;
      @endphp

      <!-- Stats -->
      <div class="stats-row">
        <div class="mini-stat">
          <div class="mini-stat-val">{{ $total }}</div>
          <div class="mini-stat-label">Total Siswa</div>
        </div>
        <div class="mini-stat">
          <div class="mini-stat-val green">{{ $sudah }}</div>
          <div class="mini-stat-label">Sudah Kumpul</div>
        </div>
        <div class="mini-stat">
          <div class="mini-stat-val {{ $belum > 0 ? 'orange' : '' }}">{{ $belum }}</div>
          <div class="mini-stat-label">Belum Kumpul</div>
        </div>
        <div class="mini-stat">
          <div class="mini-stat-val blue">{{ $dinilai }}</div>
          <div class="mini-stat-label">Sudah Dinilai</div>
        </div>
        <div class="mini-stat">
          <div class="mini-stat-val {{ $terlambat > 0 ? 'red' : '' }}">{{ $terlambat }}</div>
          <div class="mini-stat-label">Terlambat</div>
        </div>
      </div>

      <!-- Progress -->
      <div class="progress-wrap">
        <div class="progress-label">
          <span>Progress Pengumpulan</span>
          <span>{{ $sudah }}/{{ $total }} siswa ({{ $pct }}%)</span>
        </div>
        <div class="progress-bar">
          <div class="progress-fill" style="width:{{ $pct }}%"></div>
        </div>
      </div>

      <!-- Filter -->
      <div class="filter-bar">
        <button class="filter-btn active" data-filter="all" onclick="filterTable(this,'all')">
          Semua <span class="filter-count">{{ $total }}</span>
        </button>
        <button class="filter-btn" data-filter="sudah" onclick="filterTable(this,'sudah')">
          ✅ Sudah Kumpul <span class="filter-count">{{ $sudah }}</span>
        </button>
        <button class="filter-btn" data-filter="belum" onclick="filterTable(this,'belum')">
          ⏳ Belum <span class="filter-count">{{ $belum }}</span>
        </button>
        <button class="filter-btn" data-filter="dinilai" onclick="filterTable(this,'dinilai')">
          🎯 Sudah Dinilai <span class="filter-count">{{ $dinilai }}</span>
        </button>
      </div>

      <!-- Tabel -->
      <div class="table-wrap" style="padding:0 0 4px">
        <table id="mainTable">
          <thead>
            <tr>
              <th style="width:40px">#</th>
              <th>Nama Siswa</th>
              <th>NIS</th>
              <th>Status</th>
              <th>Waktu Kumpul</th>
              <th>File Jawaban</th>
              <th>Catatan Siswa</th>
              <th>Nilai & Feedback</th>
            </tr>
          </thead>
          <tbody>
            @forelse($daftarPengumpulan as $i => $p)
              @php
                $siswa = $p->siswa ?? $p->user;
                $isLate = $p->dikumpulkan_at
                  && \Carbon\Carbon::parse($tugas->tgl_pengumpulan)->endOfDay()->lt($p->dikumpulkan_at);
                $hasFile = (bool) $p->file_path;
                $hasnilai = $p->nilai !== null;
                // Data filter
                $statusFilter = $hasnilai ? 'sudah dinilai' : ($hasFile ? 'sudah' : 'belum');
              @endphp
              <tr data-filter="{{ $statusFilter }}">
                <td style="color:var(--gray-400);font-size:12px;font-family:'DM Mono',monospace">{{ $i + 1 }}</td>
                <td>
                  <div style="font-weight:700;color:var(--gray-800)">{{ optional($siswa)->name ?? '—' }}</div>
                </td>
                <td style="font-family:'DM Mono',monospace;font-size:12px;color:var(--gray-400)">
                  {{ optional($siswa)->nis ?? '—' }}
                </td>
                <td>
                  @if($p->status === 'belum')
                    <span class="status-pill pill-belum">Belum</span>
                  @elseif($p->status === 'proses')
                    <span class="status-pill {{ $isLate ? 'pill-terlambat' : 'pill-proses' }}">
                      {{ $isLate ? '⚠️ Terlambat' : '📤 Dikumpulkan' }}
                    </span>
                  @elseif($p->status === 'sudah')
                    <span class="status-pill pill-sudah">✅ Dinilai</span>
                  @elseif($p->status === 'terlambat')
                    <span class="status-pill pill-terlambat">⚠️ Terlambat</span>
                  @endif
                </td>
                <td style="font-size:12px;color:var(--gray-600)">
                  {{ $p->dikumpulkan_at ? $p->dikumpulkan_at->format('d M Y H:i') : '—' }}
                </td>
                <td>
                  @if($hasFile)
                    <div class="file-actions">
                      {{-- Tombol Preview --}}
                      <button type="button" class="btn-preview"
                              onclick="openPreview(
                                '{{ route('guru.preview-jawaban', $p->id) }}',
                                '{{ addslashes($p->file_original_name ?? 'File') }}',
                                '{{ optional($siswa)->name }}',
                                '{{ $p->dikumpulkan_at ? $p->dikumpulkan_at->format('d M Y H:i') : '' }}'
                              )">
                        <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        Lihat
                      </button>
                      {{-- Tombol Download --}}
                      <a href="{{ asset('storage/' . $p->file_path) }}" download
                         class="btn-dl-jawaban">
                        <svg viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                        Unduh
                      </a>
                    </div>
                    <div style="font-size:10.5px;color:var(--gray-400);margin-top:4px;font-family:'DM Mono',monospace">
                      {{ \Illuminate\Support\Str::limit($p->file_original_name ?? '', 22) }}
                    </div>
                  @else
                    <span class="no-file">— Belum ada file</span>
                  @endif
                </td>
                <td>
                  @if($p->catatan)
                    <div class="catatan-cell">{{ \Illuminate\Support\Str::limit($p->catatan, 60) }}</div>
                  @else
                    <span style="color:var(--gray-400);font-size:12px">—</span>
                  @endif
                </td>
                <td>
                  @if($hasnilai)
                    {{-- Sudah ada nilai --}}
                    <div class="nilai-wrap">
                      <div class="nilai-display">{{ $p->nilai }}<span style="font-size:13px;color:var(--gray-400);font-weight:600">/100</span></div>
                      @if($p->feedback_guru)
                        <div class="feedback-display">{{ \Illuminate\Support\Str::limit($p->feedback_guru, 50) }}</div>
                      @endif
                      {{-- Edit nilai --}}
                      <details style="margin-top:6px">
                        <summary style="font-size:11px;color:var(--blue);cursor:pointer;font-weight:600">Edit nilai</summary>
                        <form method="POST" action="{{ route('guru.beri-nilai', $p->id) }}" style="margin-top:6px">
                          @csrf
                          <div class="nilai-form">
                            <input type="number" name="nilai" class="nilai-input" min="0" max="100"
                                   value="{{ $p->nilai }}" required>
                            <button type="submit" class="btn-nilai">Simpan</button>
                          </div>
                          <div class="feedback-wrap">
                            <textarea name="feedback_guru" class="feedback-input"
                                      placeholder="Feedback...">{{ $p->feedback_guru }}</textarea>
                          </div>
                        </form>
                      </details>
                    </div>
                  @elseif($hasFile)
                    {{-- Belum dinilai tapi ada file --}}
                    <form method="POST" action="{{ route('guru.beri-nilai', $p->id) }}">
                      @csrf
                      <div class="nilai-form">
                        <input type="number" name="nilai" class="nilai-input"
                               min="0" max="100" placeholder="0–100" required>
                        <button type="submit" class="btn-nilai">Nilai</button>
                      </div>
                      <div class="feedback-wrap" style="margin-top:5px">
                        <textarea name="feedback_guru" class="feedback-input"
                                  placeholder="Feedback (opsional)"></textarea>
                      </div>
                    </form>
                  @else
                    <span style="color:var(--gray-400);font-size:12px">—</span>
                  @endif
                </td>
              </tr>
            @empty
              <tr class="empty-row"><td colspan="8">Belum ada siswa terdaftar untuk tugas ini.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div><!-- /card pengumpulan -->

  </div><!-- /content -->
</div><!-- /main -->

<!-- ═══ FILE PREVIEW MODAL ═══ -->
<div class="modal-overlay" id="previewModal">
  <div class="modal-box">
    <div class="modal-header">
      <div class="modal-file-icon" id="modalFileIcon">📄</div>
      <div>
        <div class="modal-title" id="modalFileName">Nama File</div>
        <div class="modal-subtitle" id="modalSubtitle">Loading...</div>
      </div>
      <button class="modal-close" onclick="closePreview()">×</button>
    </div>
    <div class="modal-body" id="modalBody">
      <div style="color:var(--gray-400);font-size:14px">Memuat file...</div>
    </div>
    <div class="modal-footer">
      <span class="modal-info" id="modalInfo"></span>
      <div class="modal-actions">
        <a href="#" id="modalDownload" class="modal-btn primary" download>
          <svg viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
          Download
        </a>
        <button class="modal-btn secondary" onclick="closePreview()">Tutup</button>
      </div>
    </div>
  </div>
</div>

<script>
  // ── Filter table
  function filterTable(btn, filter) {
    document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    document.querySelectorAll('#mainTable tbody tr[data-filter]').forEach(row => {
      if (filter === 'all') {
        row.style.display = '';
      } else if (filter === 'dinilai') {
        row.style.display = row.dataset.filter.includes('dinilai') ? '' : 'none';
      } else if (filter === 'sudah') {
        row.style.display = row.dataset.filter.includes('sudah') ? '' : 'none';
      } else {
        row.style.display = row.dataset.filter === filter ? '' : 'none';
      }
    });
  }

  // ── Preview modal
  let currentPreviewUrl = '';

  function openPreview(url, fileName, siswaName, waktu) {
    currentPreviewUrl = url;
    const modal   = document.getElementById('previewModal');
    const body    = document.getElementById('modalBody');
    const title   = document.getElementById('modalFileName');
    const sub     = document.getElementById('modalSubtitle');
    const info    = document.getElementById('modalInfo');
    const dlBtn   = document.getElementById('modalDownload');
    const icon    = document.getElementById('modalFileIcon');

    title.textContent = fileName;
    sub.textContent   = siswaName + (waktu ? ' · ' + waktu : '');
    info.textContent  = fileName;
    dlBtn.href        = url + '?download=1';
    body.innerHTML    = '<div style="color:var(--gray-400);font-size:14px;padding:20px">Memuat file...</div>';

    // Deteksi tipe dari ekstensi
    const ext = fileName.split('.').pop().toLowerCase();
    const imgTypes  = ['jpg','jpeg','png','gif','webp','bmp'];
    const pdfTypes  = ['pdf'];
    const docTypes  = ['doc','docx','xls','xlsx','ppt','pptx','txt','zip'];

    icon.textContent = imgTypes.includes(ext) ? '🖼️' : pdfTypes.includes(ext) ? '📑' : '📄';

    modal.classList.add('open');
    document.body.style.overflow = 'hidden';

    if (imgTypes.includes(ext)) {
      // Gambar → langsung load via storage
      const img = document.createElement('img');
      img.src = url;
      img.style.cssText = 'max-width:100%;max-height:70vh;border-radius:8px;padding:16px';
      img.onerror = () => { body.innerHTML = unsupported(fileName); };
      body.innerHTML = '';
      body.appendChild(img);
    } else if (pdfTypes.includes(ext)) {
      body.innerHTML = `<iframe src="${url}" style="width:100%;height:500px;border:none"></iframe>`;
    } else {
      // File lain: tidak bisa di-preview, tampilkan info + tombol download
      body.innerHTML = unsupported(fileName, ext);
    }

    dlBtn.onclick = function(e) {
      e.preventDefault();
      window.location.href = url + '?download=1';
    };
  }

  function unsupported(fileName, ext) {
    return `
      <div class="modal-unsupported">
        <div class="icon">📦</div>
        <p>File <strong>.${ext||''}</strong> tidak dapat ditampilkan di browser.</p>
        <a href="${currentPreviewUrl}?download=1" class="modal-btn primary" style="display:inline-flex;margin:0 auto">
          <svg viewBox="0 0 24 24" style="width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
          Download & Buka Manual
        </a>
      </div>`;
  }

  function closePreview() {
    document.getElementById('previewModal').classList.remove('open');
    document.body.style.overflow = '';
    document.getElementById('modalBody').innerHTML = '';
  }

  // Tutup modal klik di luar
  document.getElementById('previewModal').addEventListener('click', function(e) {
    if (e.target === this) closePreview();
  });

  // ESC tutup modal
  document.addEventListener('keydown', e => { if (e.key === 'Escape') closePreview(); });
</script>
</body>
</html>
