<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SITUGAS — Edit Tugas</title>
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
    .logo-icon { width: 38px; height: 35px; flex-shrink: 0; }
    .brand {
     
      font-size: 15px;
      font-weight: 800;
      color: #fff;
      letter-spacing: 1px;
    }
    .sidebar-divider {
      width: 100%; height: 1px;
      background: rgba(255,255,255,0.28);
      margin-bottom: 28px;
    }
    .nav-menu { display: flex; flex-direction: column; gap: 4px; width: 100%; }
    .nav-item {
      display: flex; align-items: center; gap: 11px;
      padding: 11px 16px; border-radius: 10px; cursor: pointer;
      color: rgba(255,255,255,0.75); font-size: 14px; font-weight: 600;
      text-decoration: none; transition: all 0.2s; white-space: nowrap;
    }
    .nav-item svg {
      width: 19px; height: 19px; flex-shrink: 0;
      stroke: rgba(255,255,255,0.75); fill: none; transition: stroke 0.2s;
    }
    .nav-item:hover { background: rgba(255,255,255,0.13); color: #fff; }
    .nav-item:hover svg { stroke: #fff; }
    .nav-item.active { background: #fff; color: #2451d1; font-weight: 700; }
    .nav-item.active svg { stroke: #2451d1; }

    /* ══════════════════════════
       MAIN
    ══════════════════════════ */
    .main {
      margin-left: var(--sidebar-w);
      flex: 1; display: flex; flex-direction: column; min-height: 100vh;
    }

    /* Topbar */
    .topbar {
      height: 64px; background: #fff;
      display: flex; align-items: center; justify-content: space-between;
      padding: 0 36px;
      border-bottom: 1px solid #e4eaf5;
      position: sticky; top: 0; z-index: 50;
    }

    /* Breadcrumb */
    .breadcrumb {
      display: flex; align-items: center; gap: 7px;
      font-size: 13px; color: #9aa5c4; font-weight: 500;
    }
    .breadcrumb a {
      color: #9aa5c4; text-decoration: none;
      transition: color 0.15s;
    }
    .breadcrumb a:hover { color: var(--blue); }
    .breadcrumb svg {
      width: 14px; height: 14px; stroke: #c5d0e8;
      fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;
    }
    .breadcrumb-current { color: #1a2060; font-weight: 700; }

    .topbar-right { display: flex; align-items: center; gap: 10px; }

    /* Tombol hapus */
    .btn-hapus {
      display: flex; align-items: center; gap: 6px;
      padding: 9px 18px;
      border: 1.5px solid #fca5a5;
      border-radius: 10px;
      background: #fff;
      color: #dc2626;
      font-size: 13.5px; font-weight: 600;
      font-family: 'Plus Jakarta Sans', sans-serif;
      cursor: pointer;
      transition: background 0.2s, border-color 0.2s;
    }
    .btn-hapus svg {
      width: 15px; height: 15px; stroke: #dc2626; fill: none;
      stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;
    }
    .btn-hapus:hover { background: #fef2f2; border-color: #f87171; }

    /* Content */
    .content {
      flex: 1; padding: 32px 36px;
      display: flex; flex-direction: column;
      align-items: center; justify-content: center; gap: 20px;
    }

    /* ══════════════════════════
       FORM CARD
    ══════════════════════════ */
    .form-card {
      background: #fff;
      border-radius: 20px;
      padding: 0;
      width: 100%; max-width: 660px;
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

    /* Accent bar — warna berbeda untuk mode edit */
    .form-card-accent {
      height: 4px;
      background: linear-gradient(90deg, #f59e0b 0%, #fbbf24 60%, #fde68a 100%);
    }

    .form-card-inner { padding: 40px 48px 36px; }

    .form-card-header { margin-bottom: 28px; }

    .form-card-header-eyebrow {
      font-size: 10px; font-weight: 700;
      letter-spacing: 2.5px; text-transform: uppercase;
      color: #f59e0b; margin-bottom: 8px; opacity: 0.9;
      text-align: center;
    }

    .form-card-header h2 {
      
      font-size: 28px; font-weight: 800; color: #0f1740;
      margin-bottom: 5px; letter-spacing: -0.3px;
      line-height: 1.2; text-align: center;
    }
    .form-card-header p {
      font-size: 13px; color: #9aa5c4;
      font-weight: 400; letter-spacing: 0.1px; text-align: center;
    }

    /* Badge status di bawah deskripsi header */
    .form-card-status {
      display: flex; align-items: center; justify-content: center;
      gap: 6px; margin-top: 10px;
    }
    .status-pill {
      display: inline-flex; align-items: center; gap: 5px;
      padding: 4px 12px; border-radius: 999px;
      font-size: 11.5px; font-weight: 700;
    }
    .status-pill.aktif { background: #dcfce7; color: #166534; }
    .status-pill.aktif::before {
      content: ''; width: 6px; height: 6px;
      border-radius: 50%; background: #22c55e;
    }
    .status-pill.terlambat { background: #fee2e2; color: #991b1b; }
    .status-pill.terlambat::before {
      content: ''; width: 6px; height: 6px;
      border-radius: 50%; background: #ef4444;
    }
    .last-edited {
      font-size: 11px; color: #b0bbcc; font-weight: 500;
    }

    .form-divider {
      border: none; border-top: 1px solid #edf0f8; margin: 0 0 24px;
    }

    /* Fields */
    .field { margin-bottom: 16px; }
    .field label {
      display: block; font-size: 11px; font-weight: 600;
      letter-spacing: 0.8px; text-transform: uppercase;
      color: #6e7faa; margin-bottom: 7px;
    }

    .field input,
    .field textarea,
    .field select {
      width: 100%; padding: 11px 15px;
      border: 1.5px solid #e8ecf8; border-radius: 10px;
      font-size: 13.5px; color: #1a2060;
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-weight: 500; background: #fafbff; outline: none;
      transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
      appearance: none; -webkit-appearance: none;
    }
    .field input:focus,
    .field textarea:focus,
    .field select:focus {
      border-color: #2d52ff; background: #fff;
      box-shadow: 0 0 0 3px rgba(45,82,255,0.09);
    }
    .field input:hover:not(:focus),
    .field textarea:hover:not(:focus),
    .field select:hover:not(:focus) { border-color: #c5d0f0; }
    .field input::placeholder,
    .field textarea::placeholder { color: #bcc5dd; font-weight: 400; }
    .field textarea { resize: vertical; min-height: 96px; line-height: 1.65; }
    .field input[type="date"] { color: #1a2060; }
    .field input[type="date"]::-webkit-calendar-picker-indicator { opacity: 0.4; cursor: pointer; }

    /* Select custom arrow */
    .select-wrap { position: relative; }
    .select-wrap select { padding-right: 38px; cursor: pointer; }
    .select-wrap::after {
      content: ''; position: absolute; right: 14px; top: 50%;
      transform: translateY(-50%); width: 0; height: 0;
      border-left: 4.5px solid transparent; border-right: 4.5px solid transparent;
      border-top: 5.5px solid #9aa5c4; pointer-events: none;
    }

    .row-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }

    /* Actions */
    .form-actions {
      display: flex; justify-content: flex-end; align-items: center;
      gap: 10px; margin-top: 24px; padding-top: 20px;
      border-top: 1px solid #edf0f8;
    }

    .btn-batal {
      padding: 10px 24px; border: 1.5px solid #e2e8f5;
      border-radius: 10px; background: transparent; color: #7a87aa;
      font-size: 13.5px; font-weight: 600;
      font-family: 'Plus Jakarta Sans', sans-serif; cursor: pointer;
      transition: background 0.2s, border-color 0.2s, color 0.2s; letter-spacing: 0.1px;
    }
    .btn-batal:hover { background: #f5f7ff; border-color: #c5d0f0; color: #4a5880; }

    .btn-simpan {
      display: flex; align-items: center; gap: 7px;
      padding: 10px 28px; border: none; border-radius: 10px;
      background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
      color: #fff; font-size: 13.5px; font-weight: 700;
      font-family: 'Plus Jakarta Sans', sans-serif; cursor: pointer;
      letter-spacing: 0.2px;
      transition: opacity 0.2s, transform 0.15s, box-shadow 0.2s;
      box-shadow: 0 4px 14px rgba(245,158,11,0.35);
    }
    .btn-simpan svg {
      width: 15px; height: 15px; stroke: #fff; fill: none;
      stroke-width: 2.2; stroke-linecap: round; stroke-linejoin: round;
    }
    .btn-simpan:hover { opacity: 0.92; box-shadow: 0 6px 20px rgba(245,158,11,0.42); }
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
      <a href="/guru/kelola-tugas" class="nav-item active">
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

    <header class="topbar">
      <!-- Breadcrumb -->
      <div class="breadcrumb">
        <a href="/guru/kelola-tugas">Tugas</a>
        <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
        <span class="breadcrumb-current">Edit Tugas</span>
      </div>

      <div class="topbar-right">
        <button class="btn-hapus" onclick="if(confirm('Yakin ingin menghapus tugas ini?')) { document.getElementById('deleteForm').submit(); }">
          <svg viewBox="0 0 24 24">
            <polyline points="3 6 5 6 21 6"/>
            <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
            <path d="M10 11v6M14 11v6"/>
            <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
          </svg>
          Hapus Tugas
        </button>
      </div>
    </header>

    <!-- Hidden form untuk delete -->
    <form id="deleteForm" method="POST" action="{{ route('guru.destroy-tugas', $tugas->id) }}" style="display: none;">
      @csrf
      @method('DELETE')
    </form>

    <div class="content">
      <div class="form-card">

        <!-- Accent bar kuning untuk mode edit -->
        <div class="form-card-accent"></div>

        <div class="form-card-inner">

          <div class="form-card-header">
            <div class="form-card-header-eyebrow">Edit Tugas</div>
            <h2>Ubah Informasi Tugas</h2>
            <p>Perbarui detail tugas sesuai kebutuhan</p>
           
          </div>

          <hr class="form-divider"/>

          <form method="POST" action="{{ route('guru.update-tugas', $tugas->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="field">
              <label>Judul Tugas</label>
              <input type="text" name="judul" value="{{ $tugas->judul }}" placeholder="Masukkan judul tugas..." required/>
            </div>

            <div class="field">
              <label>Deskripsi Tugas</label>
              <textarea name="deskripsi" placeholder="Masukkan deskripsi tugas...">{{ $tugas->deskripsi }}</textarea>
            </div>

            <div class="field">
              <label>File Tugas (Opsional - kosongkan jika tidak ingin mengubah)</label>
              <div style="position: relative; border: 2px dashed #dce4ff; border-radius: 12px; padding: 24px 16px; text-align: center; cursor: pointer; background: #fafbff; transition: all 0.2s;" class="file-upload-box">
                <div style="font-size: 28px; margin-bottom: 8px;">📤</div>
                <div style="font-size: 13px; font-weight: 600; color: #2d52ff; margin-bottom: 4px;">Pilih file atau drag & drop</div>
                <div style="font-size: 11px; color: #9aa5c4;">PDF, Word, Excel, PowerPoint, TXT, ZIP (max 10MB)</div>
                <input type="file" id="file_tugas" name="file_tugas" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.zip" style="display: none;" onchange="updateFileName()"/>
              </div>
              <div id="file-selected" style="margin-top: 8px; padding: 8px 12px; background: #d1fae5; border-radius: 8px; color: #065f46; font-size: 12px; display: none;">
                ✓ <span id="file-name"></span> dipilih
              </div>

              @if($tugas->file_path)
                <div style="margin-top: 12px; padding: 12px; background: #f0f9ff; border: 1px solid #bfdbfe; border-radius: 10px; font-size: 12px; color: #1e40af;">
                  <div style="font-weight: 700; margin-bottom: 6px;">📄 File saat ini:</div>
                  <div style="margin-bottom: 6px;">{{ $tugas->file_original_name }}</div>
                  <a href="{{ asset('storage/' . $tugas->file_path) }}" download style="color: #2d52ff; text-decoration: none; font-weight: 600;">Download</a>
                </div>
              @endif
            </div>

            <div class="row-2">
              <div class="field">
                <label>Mata Pelajaran</label>
                <div class="select-wrap">
                  <select name="mapel" required>
                    <option value="" disabled>Pilih Mapel</option>
                    <option value="Matematika" {{ $tugas->mapel === 'Matematika' ? 'selected' : '' }}>Matematika</option>
                    <option value="Bahasa Indonesia" {{ $tugas->mapel === 'Bahasa Indonesia' ? 'selected' : '' }}>Bahasa Indonesia</option>
                    <option value="Fisika" {{ $tugas->mapel === 'Fisika' ? 'selected' : '' }}>Fisika</option>
                    <option value="Kimia" {{ $tugas->mapel === 'Kimia' ? 'selected' : '' }}>Kimia</option>
                    <option value="Biologi" {{ $tugas->mapel === 'Biologi' ? 'selected' : '' }}>Biologi</option>
                    <option value="Bahasa Inggris" {{ $tugas->mapel === 'Bahasa Inggris' ? 'selected' : '' }}>Bahasa Inggris</option>
                  </select>
                </div>
              </div>
              <div class="field">
                <label>Kelas</label>
                <div class="select-wrap">
                  <select name="kelas" required>
                    <option value="" disabled>Pilih Kelas</option>
                    <option value="X-A" {{ $tugas->kelas === 'X-A' ? 'selected' : '' }}>X-A</option>
                    <option value="X-B" {{ $tugas->kelas === 'X-B' ? 'selected' : '' }}>X-B</option>
                    <option value="XI-A" {{ $tugas->kelas === 'XI-A' ? 'selected' : '' }}>XI-A</option>
                    <option value="XI-B" {{ $tugas->kelas === 'XI-B' ? 'selected' : '' }}>XI-B</option>
                    <option value="XII-A" {{ $tugas->kelas === 'XII-A' ? 'selected' : '' }}>XII-A</option>
                    <option value="XII-B" {{ $tugas->kelas === 'XII-B' ? 'selected' : '' }}>XII-B</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="row-2">
              <div class="field">
                <label>Tanggal Pemberian</label>
                <input type="date" name="tgl_pemberian" value="{{ \App\Helpers\DateHelper::safeFormat($tugas->tgl_pemberian, 'Y-m-d') }}" required/>
              </div>
              <div class="field">
                <label>Tanggal Pengumpulan</label>
                <input type="date" name="tgl_pengumpulan" value="{{ \App\Helpers\DateHelper::safeFormat($tugas->tgl_pengumpulan, 'Y-m-d') }}" required/>
              </div>
            </div>

            <div class="form-actions">
              <button type="button" class="btn-batal" onclick="history.back()">Batal</button>
              <button type="submit" class="btn-simpan">Simpan Perubahan</button>
            </div>
          </form>

        </div><!-- /.form-card-inner -->
      </div><!-- /.form-card -->
    </div>
  </div>

  <script>
    function updateFileName() {
      const fileInput = document.getElementById('file_tugas');
      const fileSelected = document.getElementById('file-selected');
      const fileName = document.getElementById('file-name');

      if (fileInput.files && fileInput.files[0]) {
        fileName.textContent = fileInput.files[0].name;
        fileSelected.style.display = 'block';
      } else {
        fileSelected.style.display = 'none';
      }
    }

    // Hover effect untuk file upload box
    const fileUploadBox = document.querySelector('.file-upload-box');
    if (fileUploadBox) {
      fileUploadBox.addEventListener('click', function() {
        document.getElementById('file_tugas').click();
      });

      fileUploadBox.addEventListener('mouseover', function() {
        this.style.borderColor = '#2d52ff';
        this.style.background = '#f0f4ff';
      });

      fileUploadBox.addEventListener('mouseout', function() {
        this.style.borderColor = '#dce4ff';
        this.style.background = '#fafbff';
      });
    }
  </script>

</body>
</html>