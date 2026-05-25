<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SITUGAS — Detail Tugas</title>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet"/>
  <style>
    *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

    :root {
      --blue:       #2d52ff;
      --blue-dark:  #1a38cc;
      --blue-mid:   #2451d1;
      --sidebar-w:  210px;
      --success:    #10b981;
      --warning:    #f59e0b;
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
      gap: 28px;
      max-width: 1400px;
    }

    /* ══════════════════════════ TASK DETAIL ══════════════════════════ */
    .task-detail {
      flex: 1;
      background: #fff;
      border-radius: 20px;
      padding: 36px;
      border: 1px solid #e8ecf8;
      box-shadow: 0 1px 2px rgba(45,82,255,0.04);
    }

    .detail-header {
      margin-bottom: 28px;
      padding-bottom: 20px;
      border-bottom: 1px solid #edf0f8;
    }

    .detail-subject {
      font-size: 11px;
      font-weight: 700;
      letter-spacing: 0.8px;
      text-transform: uppercase;
      color: #2d52ff;
      margin-bottom: 8px;
    }

    .detail-title {
      font-size: 24px;
      font-weight: 800;
      color: #0f1740;
      margin-bottom: 12px;
    }

    .detail-meta {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
      font-size: 13px;
      color: #6e7faa;
    }

    .detail-meta-item {
      display: flex;
      flex-direction: column;
      gap: 6px;
    }

    .detail-meta-label {
      font-weight: 600;
      text-transform: uppercase;
      font-size: 10px;
      letter-spacing: 0.8px;
      color: #9aa5c4;
    }

    .detail-desc {
      margin: 24px 0;
      line-height: 1.7;
      color: #3f4968;
    }

    .file-info {
      background: #f5f8ff;
      border: 1px solid #dce4ff;
      border-radius: 12px;
      padding: 16px;
      margin-bottom: 20px;
    }

    .file-info-label {
      font-size: 11px;
      font-weight: 700;
      letter-spacing: 0.8px;
      text-transform: uppercase;
      color: #6e7faa;
      margin-bottom: 8px;
    }

    .file-info-content {
      display: flex;
      align-items: center;
      gap: 12px;
      font-size: 14px;
      color: #2d52ff;
    }

    .file-icon {
      width: 32px;
      height: 32px;
      background: #e0e7ff;
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 16px;
    }

    .file-name {
      flex: 1;
      word-break: break-all;
      font-weight: 600;
    }

    .download-btn {
      padding: 8px 16px;
      background: #2d52ff;
      color: #fff;
      border: none;
      border-radius: 8px;
      font-size: 12px;
      font-weight: 600;
      cursor: pointer;
      text-decoration: none;
      display: inline-block;
      transition: all 0.2s;
    }

    .download-btn:hover {
      background: #1a38cc;
    }

    /* ══════════════════════════ SUBMISSION FORM ══════════════════════════ */
    .submit-form {
      width: 360px;
      background: #fff;
      border-radius: 20px;
      padding: 0;
      border: 1px solid #e8ecf8;
      box-shadow: 0 1px 2px rgba(45,82,255,0.04);
      overflow: hidden;
    }

    .form-accent {
      height: 4px;
      background: linear-gradient(90deg, #2d52ff 0%, #7b9cff 60%, #c4d1ff 100%);
    }

    .form-inner {
      padding: 32px 24px;
    }

    .form-header {
      margin-bottom: 24px;
    }

    .form-header h3 {
      font-size: 18px;
      font-weight: 800;
      color: #0f1740;
      margin-bottom: 6px;
    }

    .form-header p {
      font-size: 12px;
      color: #9aa5c4;
    }

    .form-divider {
      border: none;
      border-top: 1px solid #edf0f8;
      margin: 16px 0 20px;
    }

    .form-field {
      margin-bottom: 20px;
    }

    .form-label {
      display: block;
      font-size: 11px;
      font-weight: 600;
      letter-spacing: 0.8px;
      text-transform: uppercase;
      color: #6e7faa;
      margin-bottom: 8px;
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

    textarea {
      width: 100%;
      padding: 11px 15px;
      border: 1.5px solid #e8ecf8;
      border-radius: 10px;
      font-size: 13px;
      color: #1a2060;
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-weight: 500;
      background: #fafbff;
      outline: none;
      transition: border-color 0.2s, box-shadow 0.2s;
      resize: vertical;
      min-height: 80px;
    }

    textarea:focus {
      border-color: #2d52ff;
      background: #fff;
      box-shadow: 0 0 0 3px rgba(45,82,255,0.09);
    }

    textarea::placeholder {
      color: #bcc5dd;
    }

    .form-actions {
      display: flex;
      flex-direction: column;
      gap: 10px;
      margin-top: 24px;
    }

    .btn-submit {
      width: 100%;
      padding: 12px;
      background: linear-gradient(135deg, #2d52ff 0%, #1a38cc 100%);
      color: #fff;
      border: none;
      border-radius: 10px;
      font-size: 13px;
      font-weight: 700;
      cursor: pointer;
      font-family: 'Plus Jakarta Sans', sans-serif;
      transition: all 0.2s;
      box-shadow: 0 4px 14px rgba(45,82,255,0.3);
    }

    .btn-submit:hover {
      opacity: 0.92;
      box-shadow: 0 6px 20px rgba(45,82,255,0.38);
    }

    .btn-submit:active {
      transform: scale(0.97);
    }

    .btn-cancel {
      width: 100%;
      padding: 10px;
      background: transparent;
      color: #7a87aa;
      border: 1.5px solid #e2e8f5;
      border-radius: 10px;
      font-size: 13px;
      font-weight: 600;
      cursor: pointer;
      font-family: 'Plus Jakarta Sans', sans-serif;
      transition: all 0.2s;
    }

    .btn-cancel:hover {
      background: #f5f7ff;
      border-color: #c5d0f0;
    }

    .status-badge {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 6px 14px;
      border-radius: 20px;
      font-size: 12px;
      font-weight: 600;
      letter-spacing: 0.3px;
      margin-top: 8px;
    }

    .status-belum {
      background: rgba(241, 65, 108, 0.1);
      color: #f14170;
    }

    .status-proses {
      background: rgba(245, 158, 11, 0.1);
      color: #f59e0b;
    }

    .status-sudah {
      background: rgba(16, 185, 129, 0.1);
      color: #10b981;
    }

    .submitted-info {
      background: #f0fdf4;
      border: 1px solid #86efac;
      border-radius: 12px;
      padding: 16px;
      margin-bottom: 20px;
      font-size: 13px;
      color: #166534;
    }

    .edit-link {
      color: #2d52ff;
      text-decoration: none;
      font-weight: 600;
      margin-top: 10px;
      display: inline-block;
    }

    .edit-link:hover {
      text-decoration: underline;
    }

    @media (max-width: 1200px) {
      .content {
        flex-direction: column;
      }

      .submit-form {
        width: 100%;
      }
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

      <!-- Left: Task Detail -->
      <div class="task-detail">
        <div class="detail-header">
          <div class="detail-subject">{{ $tugas->mapel }}</div>
          <div class="detail-title">{{ $tugas->judul }}</div>
          <div class="detail-meta">
            <div class="detail-meta-item">
              <span class="detail-meta-label">Diberikan Tanggal</span>
              <span>{{ $tugas->tgl_pemberian->format('d M Y') }}</span>
            </div>
            <div class="detail-meta-item">
              <span class="detail-meta-label">Batas Pengumpulan</span>
              <span>{{ $tugas->tgl_pengumpulan->format('d M Y') }}</span>
            </div>
          </div>
        </div>

        @if($tugas->deskripsi)
          <div class="detail-desc">
            {{ $tugas->deskripsi }}
          </div>
        @endif

        @if($tugas->file_path)
          <div class="file-info">
            <div class="file-info-label">📎 File Tugas</div>
            <div class="file-info-content">
              <div class="file-icon">📄</div>
              <div class="file-name">{{ $tugas->file_original_name }}</div>
              <a href="{{ asset('storage/' . $tugas->file_path) }}" download class="download-btn">
                Download
              </a>
            </div>
          </div>
        @endif
      </div>

      <!-- Right: Submission Form -->
      <div class="submit-form">
        <div class="form-accent"></div>
        <div class="form-inner">

          <div class="form-header">
            <h3>Kumpulkan Tugas</h3>
            <p>Upload jawaban Anda di sini</p>
            <span class="status-badge status-{{ $pengumpulan->status }}">
              @if($pengumpulan->status === 'belum')
                🔴 Belum Dikumpulkan
              @elseif($pengumpulan->status === 'proses')
                🟡 Sudah Dikumpulkan
              @else
                ✅ Selesai
              @endif
            </span>
          </div>

          <hr class="form-divider"/>

          @if($pengumpulan->status !== 'belum')
            <div class="submitted-info">
              ✓ Jawaban Anda telah dikumpulkan pada {{ $pengumpulan->dikumpulkan_at->format('d M Y H:i') }}.
              <a href="{{ route('siswa.edit-pengumpulan', $tugas->id) }}" class="edit-link">
                Edit Jawaban →
              </a>
            </div>
          @else
            <form method="POST" action="{{ route('siswa.submit-tugas', $tugas->id) }}" enctype="multipart/form-data">
              @csrf

              <div class="form-field">
                <label class="form-label">File Jawaban</label>
                <label for="file_jawaban" class="file-upload-box" style="cursor: pointer;">
                  <div class="file-upload-icon">📤</div>
                  <div class="file-upload-text">Pilih file atau drag & drop</div>
                  <div class="file-upload-hint">PDF, Word, Excel, PowerPoint, gambar (max 10MB)</div>
                  <input 
                    type="file" 
                    id="file_jawaban" 
                    name="file_jawaban" 
                    required 
                    accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.zip,.jpg,.jpeg,.png"
                    onchange="updateFileName()"
                  />
                </label>
                <div id="file-selected" class="file-selected">
                  ✓ <span id="file-name"></span> dipilih
                </div>
                @error('file_jawaban')
                  <div style="color: #ef4444; font-size: 12px; margin-top: 6px;">
                    {{ $message }}
                  </div>
                @enderror
              </div>

              <div class="form-field">
                <label class="form-label">Catatan (Opsional)</label>
                <textarea 
                  name="catatan" 
                  placeholder="Tulis catatan atau penjelasan tentang jawaban Anda..."></textarea>
                @error('catatan')
                  <div style="color: #ef4444; font-size: 12px; margin-top: 6px;">
                    {{ $message }}
                  </div>
                @enderror
              </div>

              <div class="form-actions">
                <button type="submit" class="btn-submit">Kumpulkan Sekarang</button>
                <button type="button" class="btn-cancel" onclick="history.back()">Batal</button>
              </div>
            </form>
          @endif

        </div>
      </div>

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
