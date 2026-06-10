<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Siswa — SITUGAS</title>
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body {
    min-height: 100vh; display: flex; align-items: center;
    justify-content: center; font-family: 'Segoe UI', sans-serif;
    overflow: hidden; background: #1a5fdb;
  }
  .bg {
    position: fixed; inset: 0; z-index: 0;
    background-image: url('/assets/loginbg.png');
    background-size: cover; background-position: center; background-repeat: no-repeat;
  }
  .card {
    position: relative; z-index: 10;
    background: linear-gradient(160deg, #285FFF 0%, #93AFFF 45%, #FFFFFF 100%);
    border-radius: 10px; padding: 32px 28px 28px; width: 300px;
    display: flex; flex-direction: column; align-items: center; gap: 0;
  }
  .avatar {
    width: 60px; height: 60px; border-radius: 50%;
    background: rgba(40,95,255,0.15); border: 2px solid #285FFF;
    display: flex; align-items: center; justify-content: center; margin-bottom: 12px;
  }
  .avatar svg { width: 32px; height: 32px; fill: #ffffff; }
  h1 { color: #ffffff; font-size: 22px; font-weight: 600; letter-spacing: 0.5px; margin-bottom: 16px; }

  /* Alert error */
  .alert-error {
    width: 100%; background: rgba(255,80,80,0.15); border: 1px solid rgba(255,100,100,0.4);
    border-radius: 8px; padding: 10px 12px; margin-bottom: 12px;
    color: #fff; font-size: 12px; font-weight: 500; text-align: center;
  }

  .field { width: 100%; margin-bottom: 12px; }
  .field label { display: block; color: #ffffff; font-size: 12px; font-weight: 600; letter-spacing: 0.6px; margin-bottom: 5px; }
  .field input {
    width: 100%; padding: 10px 12px; border-radius: 8px; border: none; outline: none;
    font-size: 13px; color: #291888; background: #fff; transition: box-shadow 0.2s;
  }
  .field input.error { box-shadow: 0 0 0 2px rgba(255,80,80,0.6); }
  .field input::placeholder { color: #aaa; }
  .field input:focus { box-shadow: 0 0 0 3px rgba(7,7,153,0.38); }
  .field .field-error { color: rgba(255,220,220,0.9); font-size: 11px; margin-top: 4px; }

  .btn-masuk {
    width: 100%; padding: 11px; margin-top: 8px; border-radius: 10px; border: none;
    background: #1a4fcf; color: #fff; font-size: 14px; font-weight: 600;
    cursor: pointer; letter-spacing: 0.5px; transition: background 0.2s, transform 0.1s;
  }
  .btn-masuk:hover { background: #153fb0; }
  .btn-masuk:active { transform: scale(0.98); }
  .link-guru {
    margin-top: 10px; font-size: 12px; color: rgba(255,255,255,0.85);
    text-decoration: none; cursor: pointer; transition: color 0.2s;
  }
  .link-guru:hover { color: #fff; text-decoration: underline; }
</style>
</head>
<body>

<div class="bg"></div>

<div class="card">
  <div class="avatar">
    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
      <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
    </svg>
  </div>

  <h1>Login Siswa</h1>

  {{-- Tampilkan error global --}}
  @if ($errors->any())
    <div class="alert-error">
      {{ $errors->first() }}
    </div>
  @endif

  <form method="POST" action="{{ route('login.post') }}" style="width:100%">
    @csrf

    <div class="field">
      <label>NIS</label>
      <input
        type="text"
        name="nis"
        placeholder="Masukkan NIS Anda"
        value="{{ old('nis') }}"
        class="{{ $errors->has('nis') ? 'error' : '' }}"
        autocomplete="username"
      />
      @error('nis')
        <div class="field-error">{{ $message }}</div>
      @enderror
    </div>

    <div class="field">
      <label>KATA SANDI</label>
      <input
        type="password"
        name="password"
        placeholder="Masukkan Kata Sandi"
        class="{{ $errors->has('password') ? 'error' : '' }}"
        autocomplete="current-password"
      />
      @error('password')
        <div class="field-error">{{ $message }}</div>
      @enderror
    </div>

    <button type="submit" class="btn-masuk">Masuk</button>
  </form>

  <a href="{{ route('login.guru') }}" class="link-guru">Login Sebagai Guru</a>
  <a href="{{ route('login.superadmin') }}" class="link-guru">Login Sebagai Admin</a>
</div>

</body>
</html>
