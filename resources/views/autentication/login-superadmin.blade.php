<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/><meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SITUGAS – Login Super Admin</title>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
    :root{--blue-mid:#2451d1;--purple-mid:#6d28d9;--gray-50:#f8fafc;--gray-100:#f1f5f9;--gray-200:#e2e8f0;--gray-400:#94a3b8;--gray-600:#475569;--gray-800:#1e293b;--white:#fff;--red:#ef4444}
    body{font-family:'Plus Jakarta Sans',sans-serif;background:var(--gray-50) url('/assets/loginbg.png') no-repeat center/cover;min-height:100vh;display:flex;align-items:center;justify-content:center}
    .login-wrap{display:flex;width:900px;max-width:95vw;min-height:520px;border-radius:20px;overflow:hidden;box-shadow:0 20px 60px rgba(0,0,0,0.12)}
    .login-left{flex:1;background:linear-gradient(160deg,#4c1d95,#2451d1);display:flex;flex-direction:column;align-items:center;justify-content:center;padding:48px 36px;color:#fff;text-align:center}
    .logo-wrap{width:72px;height:72px;background:rgba(255,255,255,0.15);border-radius:20px;display:flex;align-items:center;justify-content:center;margin-bottom:18px}
    .logo-icon{max-width:48px;max-height:48px;width:auto;height:auto}
    .login-left h1{font-size:26px;font-weight:800;margin-bottom:8px}
    .login-left p{font-size:13px;color:rgba(255,255,255,0.7);line-height:1.6}
    .badge{background:rgba(255,255,255,0.15);border:1px solid rgba(255,255,255,0.25);border-radius:999px;padding:4px 16px;font-size:11px;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;margin-top:16px;display:inline-block}
    .login-right{flex:1;background:#fff;padding:48px 44px;display:flex;flex-direction:column;justify-content:center}
    .login-right h2{font-size:22px;font-weight:800;margin-bottom:4px;color:var(--gray-800)}
    .login-right p{font-size:13px;color:var(--gray-400);margin-bottom:32px}
    .form-group{margin-bottom:20px}
    .form-group label{display:block;font-size:11px;font-weight:700;color:var(--gray-600);text-transform:uppercase;letter-spacing:0.05em;margin-bottom:7px}
    .form-group input{width:100%;padding:12px 14px;border:1.5px solid var(--gray-200);border-radius:10px;font-size:14px;font-family:inherit;color:var(--gray-800);background:var(--gray-50);outline:none;transition:border-color 0.2s}
    .form-group input:focus{border-color:var(--purple-mid);background:#fff;box-shadow:0 0 0 3px rgba(109,40,217,0.1)}
    .error-alert{background:#fef2f2;border:1px solid #fecaca;border-radius:8px;padding:10px 14px;color:var(--red);font-size:13px;font-weight:600;margin-bottom:20px}
    .btn-login{width:100%;padding:13px;background:linear-gradient(135deg,#6d28d9,#2451d1);color:#fff;border:none;border-radius:10px;font-size:15px;font-weight:700;cursor:pointer;font-family:inherit;margin-top:8px}
    .btn-login:hover{opacity:0.9}
    .back-link{display:block;text-align:center;margin-top:20px;font-size:13px;color:var(--gray-400);text-decoration:none}
    .back-link:hover{color:var(--purple-mid)}
    @media(max-width:640px){.login-left{display:none}.login-right{padding:36px 28px}}
  </style>
</head>
<body>
<div class="login-wrap">
  <div class="login-left">
    <div class="logo-wrap"> <img src="{{ asset('assets/logo.png') }}" class="logo-icon" alt="Logo"/></div>
    <h1>SITUGAS</h1>
    <p>Sistem Informasi Tugas<br>Sekolah Digital</p>
    <span class="badge">Super Admin Panel</span>
  </div>
  <div class="login-right">
    <h2>Login Super Admin</h2>
    <p>Masukkan kredensial admin untuk mengakses panel pengelolaan sistem</p>
    @if(session('error'))
      <div class="error-alert">{{ session('error') }}</div>
    @endif
    @if($errors->any())
      <div class="error-alert"><ul style="margin-left:16px">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
    @endif
    <form method="POST" action="{{ route('login.superadmin.post') }}">
      @csrf
      <div class="form-group">
        <label>NIP Admin</label>
        <input type="text" name="nip" value="{{ old('nip') }}" placeholder="Masukkan NIP Admin" required autofocus>
      </div>
      <div class="form-group">
        <label>Kata Sandi</label>
        <input type="password" name="password" placeholder="Masukkan kata sandi" required>
      </div>
      <button type="submit" class="btn-login">Masuk sebagai Admin</button>
    </form>
    <a href="{{ route('login') }}" class="back-link">← Kembali ke halaman login</a>
  </div>
</div>
</body>
</html>