<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/><meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SITUGAS – Edit Guru</title>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
    :root{--blue-mid:#2451d1;--purple-mid:#6d28d9;--gray-50:#f8fafc;--gray-100:#f1f5f9;--gray-200:#e2e8f0;--gray-400:#94a3b8;--gray-600:#475569;--gray-800:#1e293b;--white:#fff;--red:#ef4444;--sidebar-w:230px;--radius:14px;--shadow-sm:0 1px 4px rgba(0,0,0,.06)}
    body{font-family:'Plus Jakarta Sans',sans-serif;background:var(--gray-50);display:flex;min-height:100vh}
    .sidebar{width:var(--sidebar-w);min-height:100vh;background-image:url('/assets/sidebarbg.jpg');background-size:cover;background-position:center;background-attachment:fixed;display:flex;flex-direction:column;padding:28px 16px 24px;flex-shrink:0;position:fixed;top:0;left:0;bottom:0;z-index:100}
    .sidebar::before{content:'';position:absolute;inset:0;background:linear-gradient(160deg,rgba(76,29,149,0.6),rgba(36,81,209,0.4));pointer-events:none}
    .sidebar>*{position:relative;z-index:1}
    .sidebar-logo{display:flex;align-items:center;justify-content:center;gap:10px;margin-bottom:6px}
    .logo-icon{width:38px;height:35px}
    .brand{font-size:15px;font-weight:900;color:#fff;letter-spacing:1px}
    .admin-chip{background:rgba(255,255,255,0.15);border:1px solid rgba(255,255,255,0.25);border-radius:999px;padding:3px 12px;font-size:10px;font-weight:700;color:rgba(255,255,255,0.9);letter-spacing:0.08em;text-transform:uppercase;display:block;text-align:center;margin-bottom:22px}
    .sidebar-divider{width:100%;height:1px;background:rgba(255,255,255,0.2);margin-bottom:16px}
    .nav-section-label{font-size:10px;font-weight:700;color:rgba(255,255,255,0.45);letter-spacing:0.1em;text-transform:uppercase;padding:0 16px;margin-bottom:6px;margin-top:12px}
    .nav-menu{display:flex;flex-direction:column;gap:3px;width:100%;flex:1}
    .nav-item{display:flex;align-items:center;gap:11px;padding:10px 16px;border-radius:10px;color:rgba(255,255,255,0.75);font-size:13.5px;font-weight:600;text-decoration:none;transition:all 0.2s}
    .nav-item svg{width:17px;height:17px;flex-shrink:0;stroke:rgba(255,255,255,0.75);fill:none}
    .nav-item:hover{background:rgba(255,255,255,0.13);color:#fff}
    .nav-item.active{background:#fff;color:var(--purple-mid);font-weight:700}
    .nav-item.active svg{stroke:var(--purple-mid)}
    .sidebar-footer{padding:14px 10px 6px;border-top:1px solid rgba(255,255,255,0.2);display:flex;flex-direction:column;gap:8px}
    .user-profile{display:flex;align-items:center;gap:8px;padding:8px 10px;border-radius:10px;background:rgba(255,255,255,0.08)}
    .user-avatar{width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,var(--purple-mid),var(--blue-mid));display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0}
    .user-name{font-size:13px;font-weight:600;color:rgba(255,255,255,0.95)}
    .user-role{font-size:11px;color:rgba(255,255,255,0.6)}
    .logout-btn{display:flex;align-items:center;justify-content:center;gap:8px;padding:8px 12px;border-radius:8px;color:rgba(255,255,255,0.8);font-size:13px;font-weight:600;background:rgba(255,255,255,0.08);border:none;cursor:pointer;width:100%;font-family:inherit}
    main{margin-left:var(--sidebar-w);flex:1;padding:28px 32px;animation:fadeUp .45s ease both}
    @keyframes fadeUp{from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:translateY(0)}}
    .back-link{display:inline-flex;align-items:center;gap:6px;color:var(--gray-600);font-size:13px;font-weight:600;text-decoration:none;margin-bottom:20px}
    .back-link:hover{color:var(--purple-mid)}
    .back-link svg{width:16px;height:16px;stroke:currentColor;fill:none;stroke-width:2}
    .form-card{background:var(--white);border-radius:var(--radius);box-shadow:var(--shadow-sm);border:1px solid var(--gray-200);padding:32px 36px;max-width:560px}
    .form-title{font-size:20px;font-weight:800;margin-bottom:4px}
    .form-subtitle{font-size:13px;color:var(--gray-400);margin-bottom:28px}
    .form-group{margin-bottom:20px}
    .form-group label{display:block;font-size:12px;font-weight:700;color:var(--gray-600);text-transform:uppercase;letter-spacing:0.05em;margin-bottom:7px}
    .form-group input{width:100%;padding:11px 14px;border:1.5px solid var(--gray-200);border-radius:10px;font-size:14px;font-family:inherit;color:var(--gray-800);background:var(--gray-50);outline:none;transition:border-color 0.2s}
    .form-group input:focus{border-color:var(--purple-mid);background:#fff}
    .form-hint{font-size:11px;color:var(--gray-400);margin-top:5px}
    .error-text{font-size:12px;color:var(--red);margin-top:5px}
    .form-actions{display:flex;gap:12px;margin-top:28px}
    .btn-submit{padding:11px 24px;background:linear-gradient(135deg,var(--purple-mid),var(--blue-mid));color:#fff;border:none;border-radius:10px;font-size:14px;font-weight:700;cursor:pointer;font-family:inherit}
    .btn-cancel{padding:11px 20px;background:var(--gray-100);color:var(--gray-600);border:1.5px solid var(--gray-200);border-radius:10px;font-size:14px;font-weight:600;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center}
    @media(max-width:900px){.sidebar{width:70px;padding:20px 8px}main{margin-left:70px}.nav-item span,.brand,.admin-chip,.nav-section-label,.user-name,.user-role{display:none}.nav-item{justify-content:center;padding:10px 8px}}
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
    <a href="{{ route('superadmin.kelola-guru') }}" class="nav-item active"><svg viewBox="0 0 24 24" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg><span>Kelola Guru</span></a>
    <a href="{{ route('superadmin.kelola-siswa') }}" class="nav-item"><svg viewBox="0 0 24 24" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg><span>Kelola Siswa</span></a>
    <a href="{{ route('superadmin.kelola-tugas') }}" class="nav-item"><svg viewBox="0 0 24 24" stroke-width="2"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg><span>Semua Tugas</span></a>
  </nav>
  <div class="sidebar-footer">
    <div class="user-profile"><div class="user-avatar">👑</div><div><p class="user-name">{{ auth()->user()->name }}</p><p class="user-role">Super Admin</p></div></div>
    <form action="{{ route('logout') }}" method="POST">@csrf<button type="submit" class="logout-btn"><svg viewBox="0 0 24 24" style="width:16px;height:16px;stroke:currentColor;fill:none;stroke-width:2;"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg><span>Keluar</span></button></form>
  </div>
</aside>

<main>
  <a href="{{ route('superadmin.kelola-guru') }}" class="back-link">
    <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
    Kembali ke Kelola Guru
  </a>
  <div class="form-card">
    <h2 class="form-title">Edit Data Guru</h2>
    <p class="form-subtitle">Perbarui informasi guru: {{ $user->name }}</p>

    @if($errors->any())
      <div style="background:#fef2f2;border:1px solid #fecaca;border-radius:8px;padding:12px 16px;color:#dc2626;font-size:13px;margin-bottom:20px;">
        <ul style="margin-left:16px">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
      </div>
    @endif

    <form method="POST" action="{{ route('superadmin.update-guru', $user) }}">
      @csrf @method('PUT')
      <div class="form-group">
        <label>Nama Lengkap</label>
        <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
        @error('name')<p class="error-text">{{ $message }}</p>@enderror
      </div>
      <div class="form-group">
        <label>NIP</label>
        <input type="text" name="nip" value="{{ old('nip', $user->nip) }}" required>
        @error('nip')<p class="error-text">{{ $message }}</p>@enderror
      </div>
      <div class="form-group">
        <label>Kata Sandi Baru</label>
        <input type="password" name="password" placeholder="Kosongkan jika tidak diubah">
        <p class="form-hint">Kosongkan jika tidak ingin mengubah kata sandi</p>
        @error('password')<p class="error-text">{{ $message }}</p>@enderror
      </div>
      <div class="form-actions">
        <button type="submit" class="btn-submit">Simpan Perubahan</button>
        <a href="{{ route('superadmin.kelola-guru') }}" class="btn-cancel">Batal</a>
      </div>
    </form>
  </div>
</main>
</body>
</html>
