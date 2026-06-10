<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SITUGAS — Notifikasi</title>
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
    .nav-item{display:flex;align-items:center;gap:11px;padding:11px 16px;border-radius:10px;cursor:pointer;color:rgba(255,255,255,0.75);font-size:14px;font-weight:600;text-decoration:none;transition:all 0.2s;white-space:nowrap}
    .nav-item svg{width:19px;height:19px;flex-shrink:0;stroke:rgba(255,255,255,0.75);fill:none;transition:stroke 0.2s}
    .nav-item:hover{background:rgba(255,255,255,0.13);color:#fff}
    .nav-item:hover svg{stroke:#fff}
    .nav-item.active{background:#fff;color:var(--blue);font-weight:700}
    .nav-item.active svg{stroke:var(--blue)}
    .notif-badge{margin-left:auto;background:#ef4444;color:#fff;font-size:10px;font-weight:800;min-width:20px;height:20px;padding:0 5px;border-radius:999px;display:inline-flex;align-items:center;justify-content:center}
    .sidebar-footer{padding-top:14px;border-top:1px solid rgba(255,255,255,0.28);display:flex;flex-direction:column;gap:8px}
    .user-info{display:flex;align-items:center;gap:10px;padding:8px 10px}
    .user-avatar{width:34px;height:34px;border-radius:50%;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0}
    .user-name{font-size:13px;font-weight:600;color:#fff}
    .user-kelas{font-size:11px;color:rgba(255,255,255,0.6)}
    .logout-btn{width:100%;display:flex;align-items:center;gap:10px;padding:10px 16px;border-radius:10px;background:rgba(255,255,255,0.1);border:none;cursor:pointer;color:rgba(255,255,255,0.75);font-size:14px;font-weight:600;font-family:inherit;transition:all 0.2s}
    .logout-btn:hover{background:rgba(255,255,255,0.15);color:#fff}
    .logout-btn svg{width:18px;height:18px;stroke:currentColor;fill:none}

    /* ═══════════ MAIN ═══════════ */
    .main{margin-left:var(--sidebar-w);flex:1;display:flex;flex-direction:column;min-height:100vh}

    /* Topbar */
    .topbar{height:60px;background:#fff;border-bottom:1px solid #e8edf5;display:flex;align-items:center;padding:0 28px;gap:14px;position:sticky;top:0;z-index:50}
    .topbar-title{font-size:18px;font-weight:800;color:#0f1740;margin-right:auto}
    .topbar-count{font-size:13px;color:#94a3b8;font-weight:500}

    /* Content */
    .content{flex:1;padding:24px 28px 40px}

    /* Tabs */
    .tabs{display:flex;align-items:center;gap:2px;margin-bottom:18px;border-bottom:1.5px solid #e8edf5}
    .tab{padding:10px 18px 11px;font-size:13.5px;font-weight:600;color:#8896b8;cursor:pointer;border-bottom:2.5px solid transparent;margin-bottom:-1.5px;transition:color .18s,border-color .18s;white-space:nowrap;user-select:none}
    .tab:hover{color:#2451d1}
    .tab.active{color:#2451d1;border-bottom-color:#2451d1;font-weight:700}
    .tab-badge{display:inline-flex;align-items:center;justify-content:center;min-width:18px;height:18px;padding:0 5px;background:#e8eeff;color:#2451d1;border-radius:999px;font-size:10px;font-weight:800;margin-left:5px}
    .tab-mark-all{margin-left:auto;font-size:12.5px;font-weight:600;color:#2451d1;cursor:pointer;padding:6px 0 10px;display:flex;align-items:center;gap:5px;opacity:.85;transition:opacity .18s;border:none;background:none;font-family:inherit}
    .tab-mark-all:hover{opacity:1}
    .tab-mark-all svg{width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2.2}

    /* Notif List */
    .notif-list{background:#fff;border-radius:var(--radius);border:1px solid #e4eaf5;overflow:hidden;box-shadow:0 2px 12px rgba(36,81,209,.05)}

    .notif-item{display:flex;align-items:flex-start;gap:13px;padding:15px 20px;border-bottom:1px solid #f0f3fa;position:relative;transition:background .15s}
    .notif-item:last-child{border-bottom:none}
    .notif-item:hover{background:#f8faff}
    .notif-item.unread{background:#f5f8ff}
    .notif-item.unread:hover{background:#eff3ff}

    .notif-dot{width:8px;height:8px;border-radius:50%;background:#2451d1;flex-shrink:0;margin-top:5px;transition:background .2s}
    .notif-dot.read{background:transparent}

    .notif-icon{width:38px;height:38px;border-radius:10px;display:grid;place-items:center;flex-shrink:0}
    .notif-icon svg{width:18px;height:18px;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}
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
    .notif-meta{display:flex;align-items:center;gap:6px;flex-wrap:wrap}
    .notif-tag{display:inline-flex;align-items:center;gap:4px;font-size:10.5px;font-weight:700;letter-spacing:.6px;text-transform:uppercase;color:#8896b8}
    .notif-tag svg{width:11px;height:11px;stroke:currentColor;fill:none;stroke-width:2.2}
    .notif-tag-dot{width:3px;height:3px;border-radius:50%;background:#c5d0e8}

    .notif-right{display:flex;flex-direction:column;align-items:flex-end;gap:8px;flex-shrink:0;padding-top:2px}
    .notif-time{font-size:11.5px;color:#aab4cc;font-weight:500;white-space:nowrap}
    .notif-item.unread .notif-time{color:#8896b8}

    /* Action buttons */
    .notif-actions{display:flex;gap:6px;align-items:center}
    .btn-read{font-size:11.5px;font-weight:700;color:#2451d1;cursor:pointer;opacity:.8;transition:opacity .15s;white-space:nowrap;background:none;border:none;font-family:inherit;padding:0}
    .btn-read:hover{opacity:1}
    .btn-read.muted{color:#9aa5c4;font-weight:600;font-size:10.5px;letter-spacing:.3px;text-transform:uppercase}
    .btn-hapus{font-size:11px;font-weight:600;color:#ef4444;cursor:pointer;opacity:.65;transition:opacity .15s;background:none;border:none;font-family:inherit;padding:0}
    .btn-hapus:hover{opacity:1}

    /* Link ke tugas */
    .notif-tugas-link{display:inline-flex;align-items:center;gap:5px;font-size:11.5px;font-weight:700;color:#2451d1;text-decoration:none;margin-top:5px;opacity:.8}
    .notif-tugas-link:hover{opacity:1;text-decoration:underline}
    .notif-tugas-link svg{width:12px;height:12px;stroke:currentColor;fill:none;stroke-width:2}

    /* Empty state */
    .empty-state{text-align:center;padding:60px 24px;color:#9aa5c4;font-size:14px;font-weight:600}
    .empty-state .emoji{font-size:40px;margin-bottom:14px}

    /* Pagination */
    .pagination-wrap{padding:16px 20px;border-top:1px solid #f0f3fa;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:8px}
    .pagination-info{font-size:12px;color:#9aa5c4}

    /* Success alert */
    .alert-ok{background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;padding:11px 16px;color:#166534;font-size:13px;font-weight:600;margin-bottom:16px;display:flex;align-items:center;gap:8px}
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
    <a href="{{ route('siswa.dashboard') }}" class="nav-item">
      <svg viewBox="0 0 24 24" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1.2"/><rect x="14" y="3" width="7" height="7" rx="1.2"/><rect x="3" y="14" width="7" height="7" rx="1.2"/><rect x="14" y="14" width="7" height="7" rx="1.2"/></svg>
      Dashboard
    </a>
    <a href="{{ route('siswa.tugas') }}" class="nav-item">
      <svg viewBox="0 0 24 24" stroke-width="2"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
      Tugas
    </a>
    <a href="{{ route('siswa.notifikasi') }}" class="nav-item active">
      <svg viewBox="0 0 24 24" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
      Notifikasi
      @if($totalBelumDibaca > 0)
        <span class="notif-badge">{{ $totalBelumDibaca > 99 ? '99+' : $totalBelumDibaca }}</span>
      @endif
    </a>
  </nav>
  <div class="sidebar-footer">
    <div class="user-info">
      <div class="user-avatar">👨‍🎓</div>
      <div>
        <p class="user-name">{{ auth()->user()->name }}</p>
        <p class="user-kelas">{{ auth()->user()->kelas }}</p>
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

    <!-- Tabs + Mark All -->
    <div class="tabs">
      <div class="tab active" data-tab="semua">
        Semua
        <span class="tab-badge" id="badge-semua">{{ $notifikasi->total() }}</span>
      </div>
      <div class="tab" data-tab="belum">
        Belum Dibaca
        @if($totalBelumDibaca > 0)
          <span class="tab-badge" id="badge-belum">{{ $totalBelumDibaca }}</span>
        @endif
      </div>
      <div class="tab" data-tab="tugas_baru">Tugas Baru</div>
      <div class="tab" data-tab="deadline">Deadline</div>

      @if($totalBelumDibaca > 0)
        <form action="{{ route('siswa.notifikasi.readAll') }}" method="POST" style="margin-left:auto">
          @csrf
          <button type="submit" class="tab-mark-all">
            <svg viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
            Tandai semua dibaca
          </button>
        </form>
      @endif
    </div>

    <!-- Notification List -->
    <div class="notif-list" id="notifList">

      @forelse($notifikasi as $n)
        @php
          $warna = $n->icon_color;
          $icon  = $n->tipe_icon;
          $isUnread = !$n->dibaca;
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
            <div class="notif-desc">{{ $n->pesan }}</div>
            <div class="notif-meta">
              @if($n->tugas)
                <span class="notif-tag">
                  <svg viewBox="0 0 24 24"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                  {{ $n->tugas->mapel }}
                </span>
                <span class="notif-tag-dot"></span>
                <span class="notif-tag">Kelas {{ $n->tugas->kelas }}</span>
                <span class="notif-tag-dot"></span>
              @endif
              <span class="notif-tag">{{ $n->created_at->diffForHumans() }}</span>
            </div>
            @if($n->tugas)
              <a href="{{ route('siswa.detail-tugas', $n->tugas->id) }}" class="notif-tugas-link">
                <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                Lihat Tugas
              </a>
            @endif
          </div>

          <div class="notif-right">
            <span class="notif-time">{{ $n->created_at->format('d M, H:i') }}</span>
            <div class="notif-actions">
              @if(!$n->dibaca)
                <form action="{{ route('siswa.notifikasi.read', $n->id) }}" method="POST">
                  @csrf
                  <button type="submit" class="btn-read">Tandai dibaca</button>
                </form>
              @else
                <span class="btn-read muted">Sudah dibaca</span>
              @endif
              <form action="{{ route('siswa.notifikasi.destroy', $n->id) }}" method="POST"
                    onsubmit="return confirm('Hapus notifikasi ini?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-hapus">✕</button>
              </form>
            </div>
          </div>

        </div>
      @empty
        <div class="empty-state">
          <div class="emoji">🔔</div>
          Belum ada notifikasi.
        </div>
      @endforelse

    </div><!-- /notif-list -->

    <!-- Pagination -->
    @if($notifikasi->hasPages())
      <div class="pagination-wrap">
        <span class="pagination-info">
          Menampilkan {{ $notifikasi->firstItem() }}–{{ $notifikasi->lastItem() }} dari {{ $notifikasi->total() }}
        </span>
        {{ $notifikasi->links() }}
      </div>
    @endif

  </div><!-- /content -->
</div><!-- /main -->

<script>
  // ── Tab filtering (client side)
  const tabs = document.querySelectorAll('.tab');
  tabs.forEach(tab => {
    tab.addEventListener('click', () => {
      tabs.forEach(t => t.classList.remove('active'));
      tab.classList.add('active');
      const filter = tab.dataset.tab;
      document.querySelectorAll('.notif-item').forEach(item => {
        if (filter === 'semua') {
          item.style.display = '';
        } else if (filter === 'belum') {
          item.style.display = item.dataset.read === '0' ? '' : 'none';
        } else {
          item.style.display = item.dataset.tipe === filter ? '' : 'none';
        }
      });
    });
  });
</script>
</body>
</html>
