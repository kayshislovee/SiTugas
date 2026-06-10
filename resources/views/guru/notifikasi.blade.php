<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SITUGAS — Notifikasi Guru</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
  <style>
    *,*::before,*::after{margin:0;padding:0;box-sizing:border-box}
    :root{--blue:#2451d1;--blue-pale:#eef2ff;--sidebar-w:220px;--radius:13px}
    html,body{height:100%;font-family:'Plus Jakarta Sans',sans-serif;background:#f4f7ff}
    body{display:flex;min-height:100vh}

    /* ═══════════ SIDEBAR ═══════════ */
    .sidebar{width:var(--sidebar-w);min-height:100vh;background-image:url('/assets/sidebarbg.jpg');background-size:cover;background-position:center;background-attachment:fixed;display:flex;flex-direction:column;padding:28px 16px 24px;flex-shrink:0;position:fixed;top:0;left:0;bottom:0;z-index:100}
    .sidebar-logo{display:flex;align-items:center;justify-content:center;gap:10px;margin-bottom:18px}
    .logo-icon{width:38px;height:35px;flex-shrink:0}
    .brand{font-size:15px;font-weight:900;color:#fff;letter-spacing:1px}
    .sidebar-divider{width:100%;height:1px;background:rgba(255,255,255,0.28);margin-bottom:22px}
    .nav-menu{display:flex;flex-direction:column;gap:4px;width:100%;flex:1}
    .nav-item{display:flex;align-items:center;gap:11px;padding:11px 16px;border-radius:10px;color:rgba(255,255,255,0.75);font-size:14px;font-weight:600;text-decoration:none;transition:all 0.2s;white-space:nowrap}
    .nav-item svg{width:19px;height:19px;flex-shrink:0;stroke:rgba(255,255,255,0.75);fill:none;transition:stroke 0.2s}
    .nav-item:hover{background:rgba(255,255,255,0.13);color:#fff}
    .nav-item:hover svg{stroke:#fff}
    .nav-item.active{background:#fff;color:var(--blue);font-weight:700}
    .nav-item.active svg{stroke:var(--blue)}
    .notif-badge{margin-left:auto;background:#ef4444;color:#fff;font-size:10px;font-weight:800;min-width:20px;height:20px;padding:0 5px;border-radius:999px;display:inline-flex;align-items:center;justify-content:center}
    .sidebar-footer{padding-top:14px;border-top:1px solid rgba(255,255,255,0.28);display:flex;flex-direction:column;gap:8px}
    .user-profile{display:flex;align-items:center;gap:8px;padding:8px 10px;border-radius:10px;background:rgba(255,255,255,0.08)}
    .user-avatar{width:34px;height:34px;border-radius:50%;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0}
    .user-name{font-size:13px;font-weight:600;color:rgba(255,255,255,0.95)}
    .user-role{font-size:11px;color:rgba(255,255,255,0.6)}
    .logout-btn{width:100%;display:flex;align-items:center;gap:10px;padding:10px 16px;border-radius:10px;background:rgba(255,255,255,0.1);border:none;cursor:pointer;color:rgba(255,255,255,0.75);font-size:14px;font-weight:600;font-family:inherit;transition:all 0.2s}
    .logout-btn:hover{background:rgba(255,255,255,0.15);color:#fff}
    .logout-btn svg{width:18px;height:18px;stroke:currentColor;fill:none}

    /* ═══════════ MAIN ═══════════ */
    .main{margin-left:var(--sidebar-w);flex:1;display:flex;flex-direction:column;min-height:100vh}
    .topbar{height:60px;background:#fff;border-bottom:1px solid #e8edf5;display:flex;align-items:center;padding:0 28px;gap:14px;position:sticky;top:0;z-index:50}
    .topbar-title{font-size:18px;font-weight:800;color:#0f1740;margin-right:auto}
    .topbar-count{font-size:13px;color:#94a3b8}
    .content{flex:1;padding:24px 28px 40px}

    /* Summary cards */
    .summary-row{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:22px}
    .summary-card{background:#fff;border-radius:var(--radius);border:1px solid #e4eaf5;padding:16px 18px;display:flex;align-items:center;gap:13px;box-shadow:0 1px 6px rgba(36,81,209,.04)}
    .summary-icon{width:40px;height:40px;border-radius:11px;display:grid;place-items:center;flex-shrink:0}
    .summary-icon svg{width:19px;height:19px;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}
    .summary-icon.blue{background:#e8eeff}.summary-icon.blue svg{stroke:#2451d1}
    .summary-icon.orange{background:#fff3e8}.summary-icon.orange svg{stroke:#e07b2a}
    .summary-icon.green{background:#e8faf0}.summary-icon.green svg{stroke:#1a9c54}
    .summary-icon.red{background:#fef0f0}.summary-icon.red svg{stroke:#d94040}
    .summary-val{font-size:22px;font-weight:800;color:#0f1740;line-height:1;margin-bottom:2px}
    .summary-lbl{font-size:11px;font-weight:600;color:#9aa5c4}

    /* Tabs */
    .tabs{display:flex;align-items:center;gap:2px;margin-bottom:16px;border-bottom:1.5px solid #e8edf5}
    .tab{padding:10px 18px 11px;font-size:13.5px;font-weight:600;color:#8896b8;cursor:pointer;border-bottom:2.5px solid transparent;margin-bottom:-1.5px;transition:color .18s,border-color .18s;white-space:nowrap;user-select:none}
    .tab:hover{color:#2451d1}
    .tab.active{color:#2451d1;border-bottom-color:#2451d1;font-weight:700}
    .tab-badge{display:inline-flex;align-items:center;justify-content:center;min-width:18px;height:18px;padding:0 5px;background:#e8eeff;color:#2451d1;border-radius:999px;font-size:10px;font-weight:800;margin-left:5px}
    .tab-mark-all{margin-left:auto;font-size:12.5px;font-weight:600;color:#2451d1;cursor:pointer;padding:6px 0 10px;display:flex;align-items:center;gap:5px;opacity:.85;background:none;border:none;font-family:inherit}
    .tab-mark-all:hover{opacity:1}
    .tab-mark-all svg{width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2.2}

    /* Notif list */
    .notif-list{background:#fff;border-radius:var(--radius);border:1px solid #e4eaf5;overflow:hidden;box-shadow:0 2px 12px rgba(36,81,209,.05)}

    /* Group header */
    .notif-group{padding:9px 20px 7px;font-size:10.5px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:#9aa5c4;background:#f8faff;border-bottom:1px solid #f0f3fa}

    .notif-item{display:flex;align-items:flex-start;gap:13px;padding:15px 20px;border-bottom:1px solid #f0f3fa;transition:background .15s}
    .notif-item:last-child{border-bottom:none}
    .notif-item:hover{background:#f8faff}
    .notif-item.unread{background:#f5f8ff}
    .notif-item.unread:hover{background:#eff3ff}

    .notif-dot{width:7px;height:7px;border-radius:50%;background:#2451d1;flex-shrink:0;margin-top:6px}
    .notif-dot.read{background:transparent}

    .notif-icon{width:38px;height:38px;border-radius:10px;display:grid;place-items:center;flex-shrink:0}
    .notif-icon svg{width:17px;height:17px;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}
    .notif-icon.blue{background:#e8eeff}.notif-icon.blue svg{stroke:#2451d1}
    .notif-icon.orange{background:#fff3e8}.notif-icon.orange svg{stroke:#e07b2a}
    .notif-icon.green{background:#e8faf0}.notif-icon.green svg{stroke:#1a9c54}
    .notif-icon.red{background:#fef0f0}.notif-icon.red svg{stroke:#d94040}
    .notif-icon.purple{background:#f3eeff}.notif-icon.purple svg{stroke:#7c4dcc}
    .notif-icon.gray{background:#f0f3fa}.notif-icon.gray svg{stroke:#7a87aa}

    .notif-body{flex:1;min-width:0}
    .notif-title{font-size:13.5px;font-weight:700;color:#0f1740;margin-bottom:3px;line-height:1.35}
    .notif-item:not(.unread) .notif-title{font-weight:600;color:#3a4468}
    .notif-desc{font-size:12.5px;color:#7a87aa;line-height:1.55;margin-bottom:6px}

    /* Pengirim (siswa yg ngumpul) */
    .notif-sender{display:inline-flex;align-items:center;gap:5px;font-size:11px;font-weight:700;color:#5a6890;background:#f0f3fa;border-radius:6px;padding:2px 8px 2px 4px;margin-bottom:6px}
    .sender-avatar{width:18px;height:18px;border-radius:5px;background:linear-gradient(135deg,#4e7fff,#2451d1);display:grid;place-items:center;font-size:7px;font-weight:800;color:#fff;flex-shrink:0}

    .notif-meta{display:flex;align-items:center;gap:6px;flex-wrap:wrap}
    .notif-tag{display:inline-flex;align-items:center;gap:4px;font-size:10.5px;font-weight:700;letter-spacing:.5px;text-transform:uppercase;color:#8896b8}
    .notif-tag svg{width:11px;height:11px;stroke:currentColor;fill:none;stroke-width:2.2}
    .notif-tag-dot{width:3px;height:3px;border-radius:50%;background:#c5d0e8}
    .kelas-badge{display:inline-flex;align-items:center;font-size:10px;font-weight:700;background:#eef2ff;color:#2451d1;border-radius:5px;padding:2px 7px}

    .notif-tugas-link{display:inline-flex;align-items:center;gap:5px;font-size:11.5px;font-weight:700;color:#2451d1;text-decoration:none;margin-top:5px;opacity:.8}
    .notif-tugas-link:hover{opacity:1;text-decoration:underline}
    .notif-tugas-link svg{width:12px;height:12px;stroke:currentColor;fill:none;stroke-width:2}

    .notif-right{display:flex;flex-direction:column;align-items:flex-end;gap:8px;flex-shrink:0;padding-top:2px}
    .notif-time{font-size:11.5px;color:#aab4cc;font-weight:500;white-space:nowrap}
    .notif-item.unread .notif-time{color:#8896b8}
    .notif-actions{display:flex;gap:6px}
    .btn-read{font-size:11.5px;font-weight:700;color:#2451d1;cursor:pointer;opacity:.8;background:none;border:none;font-family:inherit;padding:0;white-space:nowrap}
    .btn-read:hover{opacity:1}
    .btn-read.muted{color:#9aa5c4;font-weight:600;font-size:10.5px;text-transform:uppercase;letter-spacing:.3px}
    .btn-hapus{font-size:11px;font-weight:600;color:#ef4444;cursor:pointer;opacity:.65;background:none;border:none;font-family:inherit;padding:0}
    .btn-hapus:hover{opacity:1}

    .empty-state{text-align:center;padding:60px 24px;color:#9aa5c4;font-size:14px;font-weight:600}
    .empty-state .emoji{font-size:40px;margin-bottom:14px}
    .pagination-wrap{padding:16px 20px;border-top:1px solid #f0f3fa;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:8px}
    .pagination-info{font-size:12px;color:#9aa5c4}
    .alert-ok{background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;padding:11px 16px;color:#166534;font-size:13px;font-weight:600;margin-bottom:16px;display:flex;align-items:center;gap:8px}

    @media(max-width:900px){.summary-row{grid-template-columns:repeat(2,1fr)}}
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
      Dashboard
    </a>
    <a href="{{ route('guru.kelola-tugas') }}" class="nav-item">
      <svg viewBox="0 0 24 24" stroke-width="2"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
      Tugas
    </a>
   
    <a href="{{ route('guru.notifikasi') }}" class="nav-item active">
      <svg viewBox="0 0 24 24" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
      Notifikasi
      @if($totalBelumDibaca > 0)
        <span class="notif-badge">{{ $totalBelumDibaca > 99 ? '99+' : $totalBelumDibaca }}</span>
      @endif
    </a>
  </nav>
  <div class="sidebar-footer">
    <div class="user-profile">
      <div class="user-avatar">👨‍🏫</div>
      <div>
        <p class="user-name">{{ auth()->user()->name }}</p>
        <p class="user-role">Guru</p>
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

<!-- ══ MAIN ══ -->
<div class="main">
  <header class="topbar">
    <span class="topbar-title">Notifikasi</span>
    <span class="topbar-count">
      {{ $totalBelumDibaca > 0 ? $totalBelumDibaca . ' belum dibaca' : 'Semua sudah dibaca' }}
    </span>
  </header>

  <div class="content">

    @if(session('success'))
      <div class="alert-ok">✅ {{ session('success') }}</div>
    @endif

    <!-- Summary Cards -->
    @php
      $totalTerlambat = \App\Models\Pengumpulan::whereHas('tugas', fn($q) => $q->where('guru_id', auth()->id()))
        ->where('status', 'terlambat')->count();
      $totalDikumpulkan = \App\Models\Pengumpulan::whereHas('tugas', fn($q) => $q->where('guru_id', auth()->id()))
        ->whereIn('status', ['sudah','proses'])->count();
    @endphp
    <div class="summary-row">
      <div class="summary-card">
        <div class="summary-icon blue">
          <svg viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
        </div>
        <div><div class="summary-val">{{ $totalNotif }}</div><div class="summary-lbl">Total Notifikasi</div></div>
      </div>
      <div class="summary-card">
        <div class="summary-icon orange">
          <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        </div>
        <div><div class="summary-val">{{ $totalBelumDibaca }}</div><div class="summary-lbl">Belum Dibaca</div></div>
      </div>
      <div class="summary-card">
        <div class="summary-icon green">
          <svg viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
        </div>
        <div><div class="summary-val">{{ $totalDikumpulkan }}</div><div class="summary-lbl">Tugas Dikumpulkan</div></div>
      </div>
      <div class="summary-card">
        <div class="summary-icon red">
          <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
        </div>
        <div><div class="summary-val">{{ $totalTerlambat }}</div><div class="summary-lbl">Siswa Terlambat</div></div>
      </div>
    </div>

    <!-- Tabs -->
    <div class="tabs">
      <div class="tab active" data-tab="semua">
        Semua <span class="tab-badge">{{ $notifikasi->total() }}</span>
      </div>
      <div class="tab" data-tab="belum">
        Belum Dibaca
        @if($totalBelumDibaca > 0)
          <span class="tab-badge">{{ $totalBelumDibaca }}</span>
        @endif
      </div>
      <div class="tab" data-tab="pengumpulan_siswa">Pengumpulan</div>
      <div class="tab" data-tab="deadline">Deadline</div>

      @if($totalBelumDibaca > 0)
        <form action="{{ route('guru.notifikasi.readAll') }}" method="POST" style="margin-left:auto">
          @csrf
          <button type="submit" class="tab-mark-all">
            <svg viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
            Tandai semua dibaca
          </button>
        </form>
      @endif
    </div>

    <!-- Notif List -->
    <div class="notif-list" id="notifList">

      @php
        // Group by hari
        $grouped = $notifikasi->getCollection()->groupBy(function($n) {
          if ($n->created_at->isToday())     return 'Hari Ini';
          if ($n->created_at->isYesterday()) return 'Kemarin';
          return $n->created_at->format('d M Y');
        });
      @endphp

      @forelse($grouped as $label => $items)
        <div class="notif-group">{{ $label }}</div>

        @foreach($items as $n)
          @php
            $warna   = $n->icon_color;
            $icon    = $n->tipe_icon;
            $isUnread = !$n->dibaca;
            // Cek apakah ini notif pengumpulan (ada info siswa di pesan)
            $isPengumpulan = in_array($n->tipe, ['pengumpulan_siswa','pengumpulan_update']);
          @endphp

          <div class="notif-item {{ $isUnread ? 'unread' : '' }}"
               data-tipe="{{ $n->tipe }}"
               data-read="{{ $n->dibaca ? '1' : '0' }}"
               id="notif-{{ $n->id }}">

            <div class="notif-dot {{ $n->dibaca ? 'read' : '' }}"></div>

            <div class="notif-icon {{ $warna }}">
              <svg viewBox="0 0 24 24">{!! $icon !!}</svg>
            </div>

            <div class="notif-body">
              <div class="notif-title">{{ $n->judul }}</div>

              {{-- Jika notif pengumpulan siswa, tampilkan avatar nama siswa --}}
              @if($isPengumpulan && $n->tugas)
                @php
                  // Ambil nama siswa dari pesan (format: "NamaSiswa telah mengumpulkan...")
                  preg_match('/^(.+?) telah/', $n->pesan, $m);
                  $namaSiswa = $m[1] ?? '';
                  $inisial = collect(explode(' ', $namaSiswa))->map(fn($w) => strtoupper(substr($w,0,1)))->take(2)->implode('');
                @endphp
                @if($namaSiswa)
                  <div class="notif-sender">
                    <div class="sender-avatar">{{ $inisial }}</div>
                    {{ $namaSiswa }}
                  </div>
                @endif
              @endif

              <div class="notif-desc">{{ $n->pesan }}</div>
              <div class="notif-meta">
                @if($n->tugas)
                  <span class="kelas-badge">{{ $n->tugas->kelas }}</span>
                  <span class="notif-tag-dot"></span>
                  <span class="notif-tag">{{ $n->tugas->mapel }}</span>
                  <span class="notif-tag-dot"></span>
                @endif
                <span class="notif-tag">{{ $n->created_at->diffForHumans() }}</span>
              </div>
              @if($n->tugas && $isPengumpulan)
                <a href="{{ route('guru.show-tugas', $n->tugas->id) }}" class="notif-tugas-link">
                  <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                  Lihat Pengumpulan
                </a>
              @endif
            </div>

            <div class="notif-right">
              <span class="notif-time">{{ $n->created_at->format('d M, H:i') }}</span>
              <div class="notif-actions">
                @if(!$n->dibaca)
                  <form action="{{ route('guru.notifikasi.read', $n->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-read">Tandai dibaca</button>
                  </form>
                @else
                  <span class="btn-read muted">Sudah dibaca</span>
                @endif
                <form action="{{ route('guru.notifikasi.destroy', $n->id) }}" method="POST"
                      onsubmit="return confirm('Hapus notifikasi ini?')">
                  @csrf @method('DELETE')
                  <button type="submit" class="btn-hapus">✕</button>
                </form>
              </div>
            </div>

          </div>
        @endforeach

      @empty
        <div class="empty-state">
          <div class="emoji">🔔</div>
          Belum ada notifikasi.
        </div>
      @endforelse

    </div><!-- /notif-list -->

    @if($notifikasi->hasPages())
      <div class="pagination-wrap">
        <span class="pagination-info">
          Menampilkan {{ $notifikasi->firstItem() }}–{{ $notifikasi->lastItem() }} dari {{ $notifikasi->total() }}
        </span>
        {{ $notifikasi->links() }}
      </div>
    @endif

  </div>
</div>

<script>
  // Tab filtering
  document.querySelectorAll('.tab').forEach(tab => {
    tab.addEventListener('click', () => {
      document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
      tab.classList.add('active');
      const filter = tab.dataset.tab;
      document.querySelectorAll('.notif-item').forEach(item => {
        if (filter === 'semua')         item.style.display = '';
        else if (filter === 'belum')    item.style.display = item.dataset.read === '0' ? '' : 'none';
        else if (filter === 'pengumpulan_siswa')
          item.style.display = ['pengumpulan_siswa','pengumpulan_update'].includes(item.dataset.tipe) ? '' : 'none';
        else item.style.display = item.dataset.tipe === filter ? '' : 'none';
      });
      // Sembunyikan group header kosong
      document.querySelectorAll('.notif-group').forEach(header => {
        let sib = header.nextElementSibling, hasVisible = false;
        while (sib && !sib.classList.contains('notif-group')) {
          if (sib.style.display !== 'none') { hasVisible = true; break; }
          sib = sib.nextElementSibling;
        }
        header.style.display = hasVisible ? '' : 'none';
      });
    });
  });
</script>
</body>
</html>
