<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SITUGAS — Buat Tugas</title>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
  <style>
    *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

    :root {
      --blue:       #2d52ff;
      --blue-dark:  #1a38cc;
      --blue-mid:   #2451d1;
      --sidebar-w:  220px;
      --radius:     14px;
    }

    html, body {
      height: 100%;
      font-family: 'Plus Jakarta Sans', sans-serif;
      background: #f0f4ff;
    }
    body { display: flex; min-height: 100vh; align-items: flex-start; }

    /* ══════════════════════════
       SIDEBAR
    ══════════════════════════ */
    .sidebar {
      width: var(--sidebar-w);
      min-height: 100vh;
      background-image: url('/assets/sidebarbg.jpg');
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
      display: flex;
      flex-direction: column;
      padding: 28px 16px 24px;
      flex-shrink: 0;
      position: fixed;
      top: 0; left: 0; bottom: 0;
      z-index: 100;
    }

    .sidebar-logo {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      margin-bottom: 18px;
      padding: 0 6px;
    }
    .logo-icon {
      width: 38px;
      height: 35px;
      flex-shrink: 0;
    }
    .brand {
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 15px;
      font-weight: 800;
      color: #fff;
      letter-spacing: 1px;
    }

    .sidebar-divider {
      width: 100%;
      height: 1px;
      background: rgba(255,255,255,0.28);
      margin-bottom: 28px;
    }

    .nav-menu {
      display: flex;
      flex-direction: column;
      gap: 4px;
      width: 100%;
    }

    .nav-item {
      display: flex;
      align-items: center;
      gap: 11px;
      padding: 11px 16px;
      border-radius: 10px;
      cursor: pointer;
      color: rgba(255,255,255,0.75);
      font-size: 14px;
      font-weight: 600;
      text-decoration: none;
      transition: all 0.2s;
      white-space: nowrap;
    }
    .nav-item svg {
      width: 19px; height: 19px;
      flex-shrink: 0;
      stroke: rgba(255,255,255,0.75);
      fill: none;
      transition: stroke 0.2s;
    }
    .nav-item:hover {
      background: rgba(255,255,255,0.13);
      color: #fff;
    }
    .nav-item:hover svg { stroke: #fff; }

    /* Bar putih — sama persis dengan dashboard */
    .nav-item.active {
      background: #fff;
      color: #2451d1;
      font-weight: 700;
    }
    .nav-item.active svg { stroke: #2451d1; }

    /* ══════════════════════════
       MAIN
    ══════════════════════════ */
    .main {
      margin-left: var(--sidebar-w);
      flex: 1;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    /* Topbar */
    .topbar {
      height: 64px;
      background: #fff;
      display: flex;
      align-items: center;
      justify-content: flex-end;
      padding: 0 36px;
      border-bottom: 1px solid #e4eaf5;
      position: sticky;
      top: 0;
      z-index: 50;
    }

    .btn-buat {
      padding: 11px 26px;
      background: var(--blue);
      color: #fff;
      font-size: 14px;
      font-weight: 700;
      font-family: 'Plus Jakarta Sans', sans-serif;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      letter-spacing: 0.3px;
      transition: background 0.2s, transform 0.15s;
    }
    .btn-buat:hover { background: var(--blue-dark); }
    .btn-buat:active { transform: scale(0.97); }

    /* Content */
    .content {
      flex: 1;
      padding: 32px 36px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: 20px;
    }

    /* ══════════════════════════
       FORM CARD
    ══════════════════════════ */
    .form-card {
      background: #fff;
      border-radius: 20px;
      padding: 0;
      width: 100%;
      max-width: 660px;
      box-shadow:
        0 1px 2px rgba(45,82,255,0.04),
        0 8px 32px rgba(45,82,255,0.08),
        0 32px 64px rgba(45,82,255,0.05);
      border: 1px solid rgba(220,228,255,0.8);
      overflow: hidden;
      animation: fadeUp .45s ease both;
    }

    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(16px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    /* Card top accent bar */
    .form-card-accent {
      height: 4px;
      background: linear-gradient(90deg, #2d52ff 0%, #7b9cff 60%, #c4d1ff 100%);
    }

    .form-card-inner {
      padding: 40px 48px 36px;
    }

    .form-card-header {
      margin-bottom: 28px;
    }

    .form-card-header-eyebrow {
      font-size: 10px;
      font-weight: 700;
      letter-spacing: 2.5px;
      text-transform: uppercase;
      color: #2d52ff;
      margin-bottom: 8px;
      opacity: 0.75;
      text-align: center;
    }

    .form-card-header h2 {
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 30px;
      font-weight: 800;
      color: #0f1740;
      margin-bottom: 5px;
      letter-spacing: -0.3px;
      line-height: 1.2;
      text-align: center;
    }
    .form-card-header p {
      font-size: 13px;
      color: #9aa5c4;
      font-weight: 400;
      letter-spacing: 0.1px;
      text-align: center;
    }

    .form-divider {
      border: none;
      border-top: 1px solid #edf0f8;
      margin: 0 0 24px;
    }

    /* Fields */
    .field { margin-bottom: 16px; }
    .field label {
      display: block;
      font-size: 11px;
      font-weight: 600;
      letter-spacing: 0.8px;
      text-transform: uppercase;
      color: #6e7faa;
      margin-bottom: 7px;
    }

    .field input,
    .field textarea,
    .field select {
      width: 100%;
      padding: 11px 15px;
      border: 1.5px solid #e8ecf8;
      border-radius: 10px;
      font-size: 13.5px;
      color: #1a2060;
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-weight: 500;
      background: #fafbff;
      outline: none;
      transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
      appearance: none;
      -webkit-appearance: none;
    }
    .field input:focus,
    .field textarea:focus,
    .field select:focus {
      border-color: #2d52ff;
      background: #fff;
      box-shadow: 0 0 0 3px rgba(45,82,255,0.09);
    }
    .field input:hover:not(:focus),
    .field textarea:hover:not(:focus),
    .field select:hover:not(:focus) {
      border-color: #c5d0f0;
    }
    .field input::placeholder,
    .field textarea::placeholder {
      color: #bcc5dd;
      font-weight: 400;
    }

    .field textarea {
      resize: vertical;
      min-height: 96px;
      line-height: 1.65;
    }

    /* Date input icon color fix */
    .field input[type="date"] { color: #1a2060; }
    .field input[type="date"]::-webkit-calendar-picker-indicator {
      opacity: 0.4;
      cursor: pointer;
    }

    /* Select custom arrow */
    .select-wrap { position: relative; }
    .select-wrap select { padding-right: 38px; cursor: pointer; }
    .select-wrap::after {
      content: '';
      position: absolute;
      right: 14px; top: 50%;
      transform: translateY(-50%);
      width: 0; height: 0;
      border-left: 4.5px solid transparent;
      border-right: 4.5px solid transparent;
      border-top: 5.5px solid #9aa5c4;
      pointer-events: none;
    }

    .row-2 {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 14px;
    }

    /* Actions */
    .form-actions {
      display: flex;
      justify-content: flex-end;
      align-items: center;
      gap: 10px;
      margin-top: 24px;
      padding-top: 20px;
      border-top: 1px solid #edf0f8;
    }

    .btn-batal {
      padding: 10px 24px;
      border: 1.5px solid #e2e8f5;
      border-radius: 10px;
      background: transparent;
      color: #7a87aa;
      font-size: 13.5px;
      font-weight: 600;
      font-family: 'Plus Jakarta Sans', sans-serif;
      cursor: pointer;
      transition: background 0.2s, border-color 0.2s, color 0.2s;
      letter-spacing: 0.1px;
    }
    .btn-batal:hover {
      background: #f5f7ff;
      border-color: #c5d0f0;
      color: #4a5880;
    }

    .btn-simpan {
      padding: 10px 28px;
      border: none;
      border-radius: 10px;
      background: linear-gradient(135deg, #2d52ff 0%, #1a38cc 100%);
      color: #fff;
      font-size: 13.5px;
      font-weight: 700;
      font-family: 'Plus Jakarta Sans', sans-serif;
      cursor: pointer;
      letter-spacing: 0.2px;
      transition: opacity 0.2s, transform 0.15s, box-shadow 0.2s;
      box-shadow: 0 4px 14px rgba(45,82,255,0.3);
    }
    .btn-simpan:hover {
      opacity: 0.92;
      box-shadow: 0 6px 20px rgba(45,82,255,0.38);
    }
    .btn-simpan:active { transform: scale(0.97); }
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
      <a href="/guru/dashboard" class="nav-item">
        <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <rect x="3" y="3" width="7" height="7" rx="1.2"/>
          <rect x="14" y="3" width="7" height="7" rx="1.2"/>
          <rect x="3" y="14" width="7" height="7" rx="1.2"/>
          <rect x="14" y="14" width="7" height="7" rx="1.2"/>
        </svg>
        Dashboard
      </a>

      <a href="/guru/buat-tugas" class="nav-item active">
        <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M9 11l3 3L22 4"/>
          <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
        </svg>
        Tugas
      </a>

      <a href="/guru/notifikasi" class="nav-item">
        <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
          <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
        </svg>
        Notifikasi
      </a>
    </nav>
  </aside>

  <!-- ══ MAIN ══ -->
  <div class="main">

    

    <div class="content">
      <div class="form-card">
        <div class="form-card-accent"></div>
        <div class="form-card-inner">

        <div class="form-card-header">
          <div class="form-card-header-eyebrow">Formulir Tugas</div>
          <h2>Informasi Tugas</h2>
          <p>Lengkapi detail tugas dengan informasi yang benar</p>
        </div>

        <hr class="form-divider"/>

        <div class="field">
          <label>Judul Tugas</label>
          <input type="text" name="judul" placeholder="Masukkan judul tugas..."/>
        </div>

        <div class="field">
          <label>Deskripsi Tugas</label>
          <textarea name="deskripsi" placeholder="Masukkan deskripsi tugas..."></textarea>
        </div>

        <div class="row-2">
          <div class="field">
            <label>Mata Pelajaran</label>
            <div class="select-wrap">
              <select name="mapel">
                <option value="" disabled selected>Pilih Mapel</option>
                <option>Matematika</option>
                <option>Bahasa Indonesia</option>
                <option>Fisika</option>
                <option>Kimia</option>
                <option>Biologi</option>
                <option>Bahasa Inggris</option>
              </select>
            </div>
          </div>
          <div class="field">
            <label>Kelas</label>
            <div class="select-wrap">
              <select name="kelas">
                <option value="" disabled selected>Pilih Kelas</option>
                <option>X-A</option>
                <option>X-B</option>
                <option>XI-A</option>
                <option>XI-B</option>
                <option>XII-A</option>
                <option>XII-B</option>
              </select>
            </div>
          </div>
        </div>

        <div class="row-2">
          <div class="field">
            <label>Tanggal Pemberian</label>
            <input type="date" name="tgl_pemberian"/>
          </div>
          <div class="field">
            <label>Tanggal Pengumpulan</label>
            <input type="date" name="tgl_pengumpulan"/>
          </div>
        </div>

        <div class="form-actions">
          <button type="button" class="btn-batal" onclick="history.back()">Batal</button>
          <button type="submit" class="btn-simpan">Simpan Tugas</button>
        </div><!-- /.form-actions -->
        </div><!-- /.form-card-inner -->
      </div><!-- /.form-card -->
    </div>
  </div>

</body>
</html>