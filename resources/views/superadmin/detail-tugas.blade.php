<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/><meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SITUGAS – Detail Tugas</title>
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
    .nav-item{display:flex;align-items:center;gap:11px;padding:10px 16px;border-radius:10px;color:rgba(255,255,255,0.75);font-size:13.5px;font-weight:600;text-decoration:none;transition:all .2s}
    .nav-item svg{width:17px;height:17px;flex-shrink:0;stroke:rgba(255,255,255,0.75);fill:none}
    .nav-item:hover{background:rgba(255,255,255,.13);color:#fff}
    .nav-item.active{background:#fff;color:var(--purple-mid);font-weight:700}
    .nav-item.active svg{stroke:var(--purple-mid)}
    .sidebar-footer{padding:14px 10px 6px;border-top:1px solid rgba(255,255,255,.2);display:flex;flex-direction:column;gap:8px}
    .user-profile{display:flex;align-items:center;gap:8px;padding:8px 10px;border-radius:10px;background:rgba(255,255,255,.08)}
    .user-avatar{width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,var(--purple-mid),var(--blue-mid));display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0}
    .user-name{font-size:13px;font-weight:600;color:rgba(255,255,255,.95)}
    .user-role{font-size:11px;color:rgba(255,255,255,.6)}
    .logout-btn{display:flex;align-items:center;justify-content:center;gap:8px;padding:8px 12px;border-radius:8px;color:rgba(255,255,255,.8);font-size:13px;font-weight:600;background:rgba(255,255,255,.08);border:none;cursor:pointer;width:100%;font-family:inherit}
    main{margin-left:var(--sidebar-w);flex:1;padding:28px 32px;animation:fadeUp .45s ease both}
    @keyframes fadeUp{from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:translateY(0)}}
    .back-link{display:inline-flex;align-items:center;gap:6px;color:var(--gray-600);font-size:13px;font-weight:600;text-decoration:none;margin-bottom:22px}
    .back-link svg{width:16px;height:16px;stroke:currentColor;fill:none;stroke-width:2}
    .back-link:hover{color:var(--purple-mid)}
    .two-col{display:grid;grid-template-columns:1fr 340px;gap:20px;align-items:start}
    .card{background:var(--white);border-radius:var(--radius);box-shadow:var(--shadow-sm);border:1px solid var(--gray-200);overflow:hidden;margin-bottom:20px}
    .card-header{padding:18px 24px;border-bottom:1px solid var(--gray-100);display:flex;align-items:center;justify-content:space-between}
    .card-title{font-size:15px;font-weight:800}
    .card-body{padding:20px 24px}

    /* TUGAS INFO */
    .tugas-title{font-size:22px;font-weight:800;margin-bottom:8px}
    .tugas-meta{display:flex;flex-wrap:wrap;gap:10px;margin-bottom:18px}
    .meta-tag{display:inline-flex;align-items:center;gap:6px;padding:5px 12px;border-radius:999px;font-size:12px;font-weight:600}
    .meta-tag svg{width:13px;height:13px;stroke:currentColor;fill:none;stroke-width:2}
    .meta-tag.purple{background:var(--purple-pale);color:var(--purple-mid)}
    .meta-tag.blue{background:var(--blue-pale);color:var(--blue-mid)}
    .meta-tag.green{background:var(--green-pale);color:#16a34a}
    .meta-tag.red{background:var(--red-pale);color:#dc2626}
    .meta-tag.orange{background:#fff7ed;color:#c2410c}
    .meta-tag.gray{background:var(--gray-100);color:var(--gray-600)}
    .deskripsi-box{background:var(--gray-50);border-radius:10px;padding:16px 18px;font-size:14px;line-height:1.7;color:var(--gray-600);border:1px solid var(--gray-200);white-space:pre-line}
    .file-link{display:inline-flex;align-items:center;gap:8px;padding:9px 16px;background:var(--purple-pale);border:1.5px solid #ddd6fe;border-radius:9px;color:var(--purple-mid);font-size:13px;font-weight:700;text-decoration:none;margin-top:14px;transition:background .15s}
    .file-link svg{width:15px;height:15px;stroke:currentColor;fill:none;stroke-width:2}
    .file-link:hover{background:#ede9fe}

    /* SIDEBAR STAT CARD */
    .stat-row{display:flex;align-items:center;justify-content:space-between;padding:13px 0;border-bottom:1px solid var(--gray-100)}
    .stat-row:last-child{border-bottom:none}
    .stat-row-label{font-size:13px;color:var(--gray-600);font-weight:500}
    .stat-row-val{font-size:15px;font-weight:800;color:var(--gray-800)}
    .big-pct{font-size:36px;font-weight:900;color:var(--purple-mid);text-align:center;padding:8px 0}
    .progress-bar{width:100%;height:8px;background:var(--gray-200);border-radius:999px;overflow:hidden;margin-bottom:20px}
    .progress-fill{height:100%;border-radius:999px;background:linear-gradient(90deg,var(--purple-mid),var(--blue-mid))}

    /* TABLE */
    table{width:100%;border-collapse:collapse}
    thead th{padding:10px 20px;text-align:left;font-size:10.5px;font-weight:700;letter-spacing:.09em;text-transform:uppercase;color:var(--gray-400);background:var(--gray-50);border-bottom:1px solid var(--gray-200)}
    tbody tr{border-bottom:1px solid var(--gray-100);transition:background .14s}
    tbody tr:last-child{border-bottom:none}
    tbody tr:hover{background:var(--gray-50)}
    tbody td{padding:12px 20px;font-size:13.5px;vertical-align:middle}
    .badge{display:inline-flex;align-items:center;padding:4px 10px;border-radius:999px;font-size:11px;font-weight:700}
    .badge-green{background:var(--green-pale);color:#166534}
    .badge-orange{background:#fff7ed;color:#c2410c}
    .badge-gray{background:var(--gray-100);color:var(--gray-600)}
    .badge-red{background:var(--red-pale);color:#dc2626}
    .download-link{display:inline-flex;align-items:center;gap:5px;color:var(--purple-mid);font-size:12px;font-weight:700;text-decoration:none}
    .download-link svg{width:13px;height:13px;stroke:currentColor;fill:none;stroke-width:2}
    .download-link:hover{text-decoration:underline}

    @media(max-width:1100px){.two-col{grid-template-columns:1fr}}
    @media(max-width:900px){.sidebar{width:70px;padding:20px 8px}main{margin-left:70px;padding:20px 16px}.nav-item span,.brand,.admin-chip,.nav-section-label,.user-name,.user-role{display:none}.nav-item{justify-content:center;padding:10px 8px}}
  </style>
</head>
<body>

<aside class="sidebar">
  <div class="sidebar-logo"><img src="{{ asset('assets/logo.png') }}" class="logo-icon" alt="Logo"/><span class="brand">SITUGAS</span></div>
  <span class="admin-chip">⚡ Super Admin</span>
  <div class="sidebar-divider"></div>
  <nav class="nav-menu">
    <div class="nav-section-label">Overview</div>
    <a href="{{ route('superadmin.dashboard') }}" class="nav-item"><svg viewBox="0 0 24 24" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1.2"/><rect x="14" y="3" width="7" height="7" rx="1.2"/><rect x="3" y="14" width="7" height="7" rx="1.2"/><rect x="14" y="14" width="7" height="7" rx="1.2"/></svg><span>Dashboard</span></a>
    <div class="nav-section-label">Manajemen</div>
    <a href="{{ route('superadmin.kelola-guru') }}" class="nav-item"><svg viewBox="0 0 24 24" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg><span>Kelola Guru</span></a>
    <a href="{{ route('superadmin.kelola-siswa') }}" class="nav-item"><svg viewBox="0 0 24 24" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg><span>Kelola Siswa</span></a>
    <a href="{{ route('superadmin.kelola-tugas') }}" class="nav-item active"><svg viewBox="0 0 24 24" stroke-width="2"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg><span>Semua Tugas</span></a>
  </nav>
  <div class="sidebar-footer">
    <div class="user-profile"><div class="user-avatar">👑</div><div><p class="user-name">{{ auth()->user()->name }}</p><p class="user-role">Super Admin</p></div></div>
    <form action="{{ route('logout') }}" method="POST">@csrf<button type="submit" class="logout-btn"><svg viewBox="0 0 24 24" style="width:16px;height:16px;stroke:currentColor;fill:none;stroke-width:2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg><span>Keluar</span></button></form>
  </div>
</aside>

<main>
  <a href="{{ route('superadmin.kelola-tugas') }}" class="back-link">
    <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
    Kembali ke Semua Tugas
  </a>

  @php
    $totalSiswa = $daftarPengumpulan->count();
    $sudah      = $daftarPengumpulan->whereIn('status', ['sudah','proses'])->count();
    $belum      = $daftarPengumpulan->where('status', 'belum')->count();
    $selesai    = $daftarPengumpulan->where('status', 'sudah')->count();
    $pct        = $totalSiswa > 0 ? round($sudah / $totalSiswa * 100) : 0;
    $isLate     = \Carbon\Carbon::parse($tugas->tgl_pengumpulan)->isPast();
  @endphp

  <div class="two-col">

    <!-- LEFT: Info Tugas + Tabel Pengumpulan -->
    <div>

      <!-- Info Tugas -->
      <div class="card">
        <div class="card-body">
          <p class="tugas-title">{{ $tugas->judul }}</p>
          <div class="tugas-meta">
            <span class="meta-tag purple">
              <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
              {{ optional($tugas->guru)->name ?? '—' }}
            </span>
            <span class="meta-tag blue">
              <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
              Kelas {{ $tugas->kelas }}
            </span>
            <span class="meta-tag gray">
              <svg viewBox="0 0 24 24"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
              {{ $tugas->mapel }}
            </span>
            <span class="meta-tag {{ $isLate ? 'red' : 'green' }}">
              <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
              Deadline: {{ \Carbon\Carbon::parse($tugas->tgl_pengumpulan)->format('d M Y') }}
              {{ $isLate ? '(Sudah Lewat)' : '' }}
            </span>
          </div>

          @if($tugas->deskripsi)
            <p style="font-size:12px;font-weight:700;color:var(--gray-400);text-transform:uppercase;letter-spacing:.06em;margin-bottom:8px">Deskripsi</p>
            <div class="deskripsi-box">{{ $tugas->deskripsi }}</div>
          @endif

          @if($tugas->file_path)
            <a href="{{ asset('storage/' . $tugas->file_path) }}" target="_blank" class="file-link">
              <svg viewBox="0 0 24 24"><path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"/></svg>
              {{ $tugas->file_original_name ?? 'Download File Tugas' }}
            </a>
          @endif
        </div>
      </div>

      <!-- Tabel Pengumpulan Siswa -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Daftar Pengumpulan Siswa</h3>
          <span style="font-size:12px;color:var(--gray-400)">{{ $sudah }}/{{ $totalSiswa }} sudah mengumpulkan</span>
        </div>
        <table>
          <thead>
            <tr>
              <th>#</th>
              <th>Nama Siswa</th>
              <th>Status</th>
              <th>Dikumpulkan</th>
              <th>File Jawaban</th>
            </tr>
          </thead>
          <tbody>
            @forelse($daftarPengumpulan as $idx => $p)
              <tr>
                <td style="color:var(--gray-400);font-size:12px">{{ $idx + 1 }}</td>
                <td>
                  <strong>{{ optional($p->siswa)->name }}</strong>
                  <br><span style="font-size:11px;color:var(--gray-400);font-family:'DM Mono',monospace">{{ optional($p->siswa)->nis }}</span>
                </td>
                <td>
                  @if($p->status === 'sudah')
                    <span class="badge badge-green">✓ Selesai</span>
                  @elseif($p->status === 'proses')
                    <span class="badge badge-orange">⏳ Dikumpulkan</span>
                  @else
                    @if($isLate)
                      <span class="badge badge-red">✗ Terlambat</span>
                    @else
                      <span class="badge badge-gray">Belum</span>
                    @endif
                  @endif
                </td>
                <td style="font-size:12px;color:var(--gray-600)">
                  {{ $p->dikumpulkan_at ? \Carbon\Carbon::parse($p->dikumpulkan_at)->format('d M Y, H:i') : '—' }}
                </td>
                <td>
                  @if($p->file_path)
                    <a href="{{ asset('storage/' . $p->file_path) }}" target="_blank" class="download-link">
                      <svg viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                      {{ Str::limit($p->file_original_name ?? 'Unduh', 22) }}
                    </a>
                  @else
                    <span style="font-size:12px;color:var(--gray-400)">—</span>
                  @endif
                </td>
              </tr>
            @empty
              <tr><td colspan="5" style="text-align:center;padding:30px;color:var(--gray-400)">Belum ada siswa terdaftar</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>

    </div>

    <!-- RIGHT: Progress Stats -->
    <div>
      <div class="card" style="position:sticky;top:24px">
        <div class="card-header"><h3 class="card-title">Progress Pengumpulan</h3></div>
        <div class="card-body">
          <div class="big-pct">{{ $pct }}%</div>
          <div class="progress-bar">
            <div class="progress-fill" style="width:{{ $pct }}%"></div>
          </div>
          <div class="stat-row">
            <span class="stat-row-label">Total Siswa</span>
            <span class="stat-row-val">{{ $totalSiswa }}</span>
          </div>
          <div class="stat-row">
            <span class="stat-row-label">Sudah Mengumpulkan</span>
            <span class="stat-row-val" style="color:#16a34a">{{ $sudah }}</span>
          </div>
          <div class="stat-row">
            <span class="stat-row-label">Belum Mengumpulkan</span>
            <span class="stat-row-val" style="color:#dc2626">{{ $belum }}</span>
          </div>
          <div class="stat-row">
            <span class="stat-row-label">Tanggal Pemberian</span>
            <span class="stat-row-val" style="font-size:13px">{{ \Carbon\Carbon::parse($tugas->tgl_pemberian)->format('d M Y') }}</span>
          </div>
          <div class="stat-row">
            <span class="stat-row-label">Batas Pengumpulan</span>
            <span class="stat-row-val" style="font-size:13px;color:{{ $isLate ? '#dc2626' : 'var(--gray-800)' }}">
              {{ \Carbon\Carbon::parse($tugas->tgl_pengumpulan)->format('d M Y') }}
            </span>
          </div>
        </div>
      </div>
    </div>

  </div><!-- /two-col -->
</main>
</body>
</html>
