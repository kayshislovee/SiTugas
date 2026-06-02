<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SITUGAS — Edit Pengumpulan</title>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet"/>
  <style>
    *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

    :root {
      --blue:       #2d52ff;
      --blue-dark:  #1a38cc;
      --sidebar-w:  210px;
    }

    html, body {
      height: 100%;
      font-family: 'Plus Jakarta Sans', sans-serif;
      background: #f0f4ff;
    }
    body { display: flex; min-height: 100vh; align-items: flex-start; }

    /* ══════════════════════════ SIDEBAR ══════════════════════════ */
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
      font-size: 15px;
      font-weight: 900;
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

    .nav-item.active {
      background: #fff;
      color: #2451d1;
      font-weight: 700;
    }

    .nav-item.active svg { stroke: #2451d1; }

    /* ══════════════════════════ MAIN ══════════════════════════ */
    .main {
      margin-left: var(--sidebar-w);
      flex: 1;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    .topbar {
      height: 64px;
      background: #fff;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 36px;
      border-bottom: 1px solid #e4eaf5;
      position: sticky;
      top: 0;
      z-index: 50;
    }

    .topbar-left {
      display: flex;
      align-items: center;
      gap: 16px;
    }

    .btn-back {
      background: transparent;
      border: none;
      color: #7a87aa;
      font-size: 16px;
      cursor: pointer;
      padding: 8px;
    }

    .content {
      flex: 1;
      padding: 32px 36px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: 20px;
    }

    /* ══════════════════════════ FORM CARD ══════════════════════════ */
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

    .file-upload-box {
      border: 2px dashed #dce4ff;
      border-radius: 12px;
      padding: 24px 16px;
      text-align: center;
      cursor: pointer;
      transition: all 0.2s;
      background: #fafbff;
      position: relative;
    }

    .file-upload-box:hover {
      border-color: #2d52ff;
      background: #f0f4ff;
    }

    .file-upload-box input[type="file"] {
      display: none;
    }

    .file-upload-icon {
      font-size: 32px;
      margin-bottom: 8px;
    }

    .file-upload-text {
      font-size: 13px;
      font-weight: 600;
      color: #2d52ff;
      margin-bottom: 4px;
    }

    .file-upload-hint {
      font-size: 11px;
      color: #9aa5c4;
    }

    .file-selected {
      margin-top: 8px;
      padding: 8px 12px;
      background: #d1fae5;
      border-radius: 8px;
      color: #065f46;
      font-size: 12px;
      display: none;
    }

    .current-file {
      margin-top: 12px;
      padding: 12px;
      background: #f0f9ff;
      border: 1px solid #bfdbfe;
      border-radius: 10px;
      font-size: 12px;
      color: #1e40af;
    }

    .current-file-label {
      font-weight: 700;
      margin-bottom: 6px;
    }

    .current-file-name {
      display: flex;
      align-items: center;
      gap: 8px;
      margin-bottom: 6px;
    }

    .current-file-actions {
      display: flex;
      gap: 8px;
      font-size: 11px;
    }

    .current-file-actions a {
      color: #2d52ff;
      text-decoration: none;
      font-weight: 600;
    }

    .current-file-actions a:hover {
      text-decoration: underline;
    }

    textarea {
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
      resize: vertical;
      min-height: 100px;
    }

    textarea:focus {
      border-color: #2d52ff;
      background: #fff;
      box-shadow: 0 0 0 3px rgba(45,82,255,0.09);
    }

    textarea::placeholder {
      color: #bcc5dd;
      font-weight: 400;
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

    .error-text {
      color: #ef4444;
      font-size: 12px;
      margin-top: 6px;
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
      <a href="/siswa/dashboard" class="nav-item">
        <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <rect x="3" y="3" width="7" height="7" rx="1.2"/>
          <rect x="14" y="3" width="7" height="7" rx="1.2"/>
          <rect x="3" y="14" width="7" height="7" rx="1.2"/>
          <rect x="14" y="14" width="7" height="7" rx="1.2"/>
        </svg>
        Dashboard
      </a>

      <a href="/siswa/tugas" class="nav-item active">
        <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M9 11l3 3L22 4"/>
          <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
        </svg>
        Tugas
      </a>

      <a href="/siswa/notifikasi" class="nav-item">
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

    <div class="topbar">
      <div class="topbar-left">
        <button class="btn-back" onclick="history.back()">← Kembali</button>
      </div>
    </div>

    <div class="content">
      <div class="form-card">
        <div class="form-card-accent"></div>
        <div class="form-card-inner">

          <div class="form-card-header">
            <div class="form-card-header-eyebrow">Edit Pengumpulan</div>
            <h2>Perbarui Jawaban</h2>
            <p>Ubah file atau catatan jawaban Anda</p>
          </div>

          <hr class="form-divider"/>

          @if($errors->any())
            <div style="background:#fee2e2; border:1px solid #fecaca; border-radius:10px; padding:16px; margin-bottom:20px; color:#991b1b; font-size:13px;">
              <strong>⚠️ Error:</strong>
              <ul style="margin:8px 0 0 20px;">
                @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          @if(session('error'))
            <div style="background:#fee2e2; border:1px solid #fecaca; border-radius:10px; padding:16px; margin-bottom:20px; color:#991b1b; font-size:13px;">
              <strong>⚠️ Error:</strong> {{ session('error') }}
            </div>
          @endif

          @if(session('success'))
            <div style="background:#dcfce7; border:1px solid #86efac; border-radius:10px; padding:16px; margin-bottom:20px; color:#166534; font-size:13px;">
              <strong>✓ Berhasil:</strong> {{ session('success') }}
            </div>
          @endif

          <form method="POST" action="{{ route('siswa.update-pengumpulan', $tugas->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="field">
              <label>File Jawaban (Opsional - kosongkan jika tidak ingin mengubah)</label>
              <label for="file_jawaban" class="file-upload-box" style="cursor: pointer;">
                <div class="file-upload-icon">📤</div>
                <div class="file-upload-text">Pilih file atau drag & drop</div>
                <div class="file-upload-hint">PDF, Word, Excel, PowerPoint, gambar (max 10MB)</div>
                <input 
                  type="file" 
                  id="file_jawaban" 
                  name="file_jawaban" 
                  accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.zip,.jpg,.jpeg,.png"
                  onchange="updateFileName()"
                />
              </label>
              <div id="file-selected" class="file-selected">
                ✓ <span id="file-name"></span> dipilih
              </div>

              @if($pengumpulan->file_path)
                <div class="current-file">
                  <div class="current-file-label">📄 File saat ini:</div>
                  <div class="current-file-name">
                    {{ $pengumpulan->file_original_name }}
                  </div>
                  <div class="current-file-actions">
                    <a href="{{ asset('storage/' . $pengumpulan->file_path) }}" download>Download</a>
                  </div>
                </div>
              @endif

              @error('file_jawaban')
                <div class="error-text">{{ $message }}</div>
              @enderror
            </div>

            <div class="field">
              <label>Catatan</label>
              <textarea 
                name="catatan" 
                placeholder="Tulis catatan atau penjelasan tentang jawaban Anda...">{{ $pengumpulan->catatan ?? '' }}</textarea>
              @error('catatan')
                <div class="error-text">{{ $message }}</div>
              @enderror
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
      const fileInput = document.getElementById('file_jawaban');
      const fileSelected = document.getElementById('file-selected');
      const fileName = document.getElementById('file-name');

      if (fileInput.files && fileInput.files[0]) {
        fileName.textContent = fileInput.files[0].name;
        fileSelected.style.display = 'block';
      } else {
        fileSelected.style.display = 'none';
      }
    }
  </script>

</body>
</html>
