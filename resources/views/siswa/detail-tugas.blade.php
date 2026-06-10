<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SITUGAS — {{ $tugas->judul ?? 'Detail Tugas' }}</title>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
  <style>
    *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
    :root { --blue: #2d52ff; --blue-mid: #2451d1; --sidebar-w: 220px; --success: #10b981; --warning: #f59e0b; --red: #ef4444; }
    body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f0f4ff; display: flex; min-height: 100vh; }

    .sidebar { width: var(--sidebar-w); min-height: 100vh; background-image: url('/assets/sidebarbg.jpg'); background-size: cover; background-position: center; background-attachment: fixed; display: flex; flex-direction: column; padding: 28px 16px 24px; flex-shrink: 0; position: fixed; top: 0; left: 0; bottom: 0; z-index: 100; }
    .sidebar-logo { display: flex; align-items: center; justify-content: center; gap: 10px; margin-bottom: 18px; }
    .logo-icon { width: 38px; height: 35px; }
    .brand { font-size: 15px; font-weight: 900; color: #fff; letter-spacing: 1px; }
    .sidebar-divider { width: 100%; height: 1px; background: rgba(255,255,255,0.28); margin-bottom: 24px; }
    .nav-menu { display: flex; flex-direction: column; gap: 4px; width: 100%; flex: 1; }
    .nav-item { display: flex; align-items: center; gap: 11px; padding: 11px 16px; border-radius: 10px; color: rgba(255,255,255,0.75); font-size: 14px; font-weight: 600; text-decoration: none; transition: all 0.2s; }
    .nav-item svg { width: 19px; height: 19px; flex-shrink: 0; stroke: rgba(255,255,255,0.75); fill: none; }
    .nav-item:hover { background: rgba(255,255,255,0.13); color: #fff; }
    .nav-item:hover svg { stroke: #fff; }
    .nav-item.active { background: #fff; color: var(--blue-mid); font-weight: 700; }
    .nav-item.active svg { stroke: var(--blue-mid); }
    .sidebar-footer { padding-top: 16px; border-top: 1px solid rgba(255,255,255,0.28); }
    .user-info { display: flex; align-items: center; gap: 11px; padding: 11px 16px; margin-bottom: 8px; }
    .user-avatar { width: 36px; height: 36px; border-radius: 50%; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; }
    .user-name { font-size: 13px; font-weight: 600; color: #fff; }
    .user-kelas { font-size: 11px; color: rgba(255,255,255,0.65); margin-top: 1px; }
    .logout-btn { width: 100%; display: flex; align-items: center; gap: 11px; padding: 11px 16px; border-radius: 10px; background: rgba(255,255,255,0.1); border: none; cursor: pointer; color: rgba(255,255,255,0.75); font-size: 14px; font-weight: 600; font-family: inherit; transition: all 0.2s; }
    .logout-btn:hover { background: rgba(255,255,255,0.15); color: #fff; }
    .logout-btn svg { width: 19px; height: 19px; stroke: currentColor; fill: none; }

    .main { margin-left: var(--sidebar-w); flex: 1; display: flex; flex-direction: column; min-height: 100vh; }
    .topbar { height: 60px; background: #fff; display: flex; align-items: center; padding: 0 36px; border-bottom: 1px solid #e4eaf5; position: sticky; top: 0; z-index: 50; gap: 16px; }
    .btn-back { display: inline-flex; align-items: center; gap: 6px; padding: 8px 14px; background: #f1f5f9; border: none; border-radius: 8px; color: #475569; font-size: 13px; font-weight: 600; cursor: pointer; font-family: inherit; text-decoration: none; transition: all 0.2s; }
    .btn-back:hover { background: #e2e8f0; }
    .topbar-title { font-size: 14px; font-weight: 700; color: #0f1740; }

    .content { flex: 1; padding: 32px 36px; display: flex; gap: 28px; align-items: flex-start; }

    /* TASK DETAIL */
    .task-detail { flex: 1; background: #fff; border-radius: 20px; padding: 36px; border: 1px solid #e8ecf8; box-shadow: 0 1px 4px rgba(0,0,0,.06); }
    .detail-header { margin-bottom: 24px; padding-bottom: 20px; border-bottom: 1px solid #edf0f8; }
    .detail-subject { font-size: 11px; font-weight: 700; letter-spacing: 0.8px; text-transform: uppercase; color: var(--blue); margin-bottom: 8px; }
    .detail-title { font-size: 24px; font-weight: 800; color: #0f1740; margin-bottom: 14px; }
    .meta-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .meta-item { }
    .meta-label { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: #9aa5c4; margin-bottom: 4px; }
    .meta-value { font-size: 14px; font-weight: 600; color: #3f4968; }
    .detail-desc { margin: 24px 0; line-height: 1.75; color: #3f4968; font-size: 14.5px; }
    .file-box { background: #f5f8ff; border: 1px solid #dce4ff; border-radius: 12px; padding: 16px 20px; display: flex; align-items: center; gap: 14px; margin-top: 20px; }
    .file-icon { width: 40px; height: 40px; background: #e0e7ff; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0; }
    .file-name-text { flex: 1; font-size: 14px; font-weight: 600; color: var(--blue); word-break: break-all; }
    .file-hint { font-size: 11px; color: #9aa5c4; margin-top: 2px; }
    .download-btn { padding: 8px 18px; background: var(--blue); color: #fff; border: none; border-radius: 8px; font-size: 12px; font-weight: 700; cursor: pointer; text-decoration: none; white-space: nowrap; }
    .download-btn:hover { background: #1a38cc; }

    /* Nilai section */
    .nilai-box { background: #f0fdf4; border: 1px solid #86efac; border-radius: 12px; padding: 16px 20px; margin-top: 20px; display: flex; align-items: center; gap: 16px; }
    .nilai-number { font-size: 36px; font-weight: 900; color: #15803d; }
    .nilai-label { font-size: 12px; color: #166534; font-weight: 600; }
    .feedback-box { background: #fffbeb; border: 1px solid #fde68a; border-radius: 12px; padding: 16px 20px; margin-top: 16px; font-size: 13.5px; color: #92400e; line-height: 1.6; }

    /* SUBMIT FORM */
    .submit-form { width: 370px; background: #fff; border-radius: 20px; border: 1px solid #e8ecf8; box-shadow: 0 1px 4px rgba(0,0,0,.06); overflow: hidden; flex-shrink: 0; }
    .form-accent { height: 4px; background: linear-gradient(90deg, #2d52ff 0%, #7b9cff 60%, #c4d1ff 100%); }
    .form-inner { padding: 28px 24px; }
    .form-header h3 { font-size: 18px; font-weight: 800; color: #0f1740; margin-bottom: 6px; }
    .form-header p { font-size: 12px; color: #9aa5c4; }
    .form-divider { border: none; border-top: 1px solid #edf0f8; margin: 16px 0 20px; }
    .form-label { display: block; font-size: 11px; font-weight: 700; letter-spacing: 0.8px; text-transform: uppercase; color: #6e7faa; margin-bottom: 8px; }
    .form-field { margin-bottom: 20px; }

    .file-upload-box { border: 2px dashed #dce4ff; border-radius: 12px; padding: 24px 16px; text-align: center; cursor: pointer; transition: all 0.2s; background: #fafbff; }
    .file-upload-box:hover { border-color: var(--blue); background: #f0f4ff; }
    .file-upload-box input[type="file"] { display: none; }
    .file-upload-icon { font-size: 32px; margin-bottom: 8px; }
    .file-upload-text { font-size: 13px; font-weight: 600; color: var(--blue); margin-bottom: 4px; }
    .file-upload-hint { font-size: 11px; color: #9aa5c4; }
    .file-selected-info { margin-top: 8px; padding: 8px 12px; background: #d1fae5; border-radius: 8px; color: #065f46; font-size: 12px; display: none; }

    textarea { width: 100%; padding: 11px 15px; border: 1.5px solid #e8ecf8; border-radius: 10px; font-size: 13px; color: #1a2060; font-family: 'Plus Jakarta Sans', sans-serif; background: #fafbff; outline: none; transition: border-color 0.2s; resize: vertical; min-height: 80px; }
    textarea:focus { border-color: var(--blue); background: #fff; box-shadow: 0 0 0 3px rgba(45,82,255,0.09); }
    textarea::placeholder { color: #bcc5dd; }

    .btn-submit { width: 100%; padding: 12px; background: linear-gradient(135deg, #2d52ff 0%, #1a38cc 100%); color: #fff; border: none; border-radius: 10px; font-size: 13px; font-weight: 700; cursor: pointer; font-family: 'Plus Jakarta Sans', sans-serif; box-shadow: 0 4px 14px rgba(45,82,255,0.3); transition: all 0.2s; }
    .btn-submit:hover { opacity: 0.9; }
    .btn-cancel { width: 100%; padding: 10px; background: transparent; color: #7a87aa; border: 1.5px solid #e2e8f5; border-radius: 10px; font-size: 13px; font-weight: 600; cursor: pointer; font-family: 'Plus Jakarta Sans', sans-serif; margin-top: 10px; transition: all 0.2s; }
    .btn-cancel:hover { background: #f5f7ff; }

    .status-badge { display: inline-flex; align-items: center; gap: 6px; padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 700; margin-top: 8px; }
    .status-belum { background: rgba(241,65,108,0.1); color: #f14170; }
    .status-proses { background: rgba(245,158,11,0.1); color: #f59e0b; }
    .status-sudah { background: rgba(16,185,129,0.1); color: #10b981; }

    .submitted-info { background: #f0fdf4; border: 1px solid #86efac; border-radius: 12px; padding: 16px; margin-bottom: 20px; font-size: 13px; color: #166534; }
    .submitted-file { display: flex; align-items: center; gap: 10px; background: #ecfdf5; border: 1px solid #6ee7b7; border-radius: 8px; padding: 10px 14px; margin-top: 10px; }
    .edit-link { display: inline-block; margin-top: 10px; color: var(--blue); text-decoration: none; font-weight: 600; font-size: 13px; }
    .edit-link:hover { text-decoration: underline; }

    .alert { padding: 12px 16px; border-radius: 10px; font-size: 13px; font-weight: 600; margin-bottom: 16px; }
    .alert-success { background: #dcfce7; border: 1px solid #86efac; color: #166534; }
    .alert-error { background: #fee2e2; border: 1px solid #fecaca; color: #991b1b; }

    .deadline-warning { background: #fff7ed; border: 1px solid #fed7aa; border-radius: 10px; padding: 10px 14px; font-size: 12px; color: #9a3412; font-weight: 600; margin-bottom: 16px; }
    .deadline-passed { background: #fef2f2; border: 1px solid #fecaca; border-radius: 10px; padding: 10px 14px; font-size: 12px; color: #991b1b; font-weight: 600; margin-bottom: 16px; }

    @media (max-width: 1100px) { .content { flex-direction: column; } .submit-form { width: 100%; } }
  </style>
</head>
<body>

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
    <a href="{{ route('siswa.tugas') }}" class="nav-item active">
      <svg viewBox="0 0 24 24" stroke-width="2"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
      Tugas
    </a>
    <a href="{{ route('siswa.notifikasi') }}" class="nav-item">
      <svg viewBox="0 0 24 24" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
      Notifikasi
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

<div class="main">
  <div class="topbar">
    <a href="{{ route('siswa.tugas') }}" class="btn-back">
      <svg viewBox="0 0 24 24" stroke-width="2" style="width:14px;height:14px;stroke:currentColor;fill:none"><polyline points="15 18 9 12 15 6"/></svg>
      Kembali
    </a>
    <span class="topbar-title">{{ $tugas->judul ?? 'Detail Tugas' }}</span>
  </div>

  <div class="content">

    {{-- KIRI: DETAIL TUGAS --}}
    <div class="task-detail">
      @if(!$tugas)
        <div class="alert alert-error">
          <p style="font-weight:700;">⚠️ Tugas tidak ditemukan</p>
          <p style="font-weight:400;margin-top:4px;">Tugas ini mungkin telah dihapus.</p>
          <a href="{{ route('siswa.tugas') }}" style="color:#2d52ff;font-weight:600;margin-top:8px;display:inline-block;">← Kembali ke daftar tugas</a>
        </div>
      @else
        <div class="detail-header">
          <div class="detail-subject">{{ $tugas->mapel }}</div>
          <div class="detail-title">{{ $tugas->judul }}</div>
          <div class="meta-grid">
            <div class="meta-item">
              <div class="meta-label">Diberikan Tanggal</div>
              <div class="meta-value">{{ \Carbon\Carbon::parse($tugas->tgl_pemberian)->translatedFormat('d F Y') }}</div>
            </div>
            <div class="meta-item">
              <div class="meta-label">Batas Pengumpulan</div>
              <div class="meta-value" style="{{ \Carbon\Carbon::parse($tugas->tgl_pengumpulan)->isPast() ? 'color:#dc2626' : '' }}">
                {{ \Carbon\Carbon::parse($tugas->tgl_pengumpulan)->translatedFormat('d F Y') }}
                @if(\Carbon\Carbon::parse($tugas->tgl_pengumpulan)->isPast())
                  <span style="font-size:11px;font-weight:700;"> · Sudah lewat</span>
                @else
                  <span style="font-size:11px;color:#9aa5c4;"> · {{ \Carbon\Carbon::parse($tugas->tgl_pengumpulan)->diffForHumans() }}</span>
                @endif
              </div>
            </div>
            <div class="meta-item">
              <div class="meta-label">Mata Pelajaran</div>
              <div class="meta-value">{{ $tugas->mapel }}</div>
            </div>
            <div class="meta-item">
              <div class="meta-label">Guru</div>
              <div class="meta-value">{{ optional($tugas->guru)->name ?? '-' }}</div>
            </div>
          </div>
        </div>

        @if($tugas->deskripsi)
          <div class="detail-desc">{{ $tugas->deskripsi }}</div>
        @endif

        @if($tugas->file_path)
          <div class="file-box">
            <div class="file-icon">📄</div>
            <div style="flex:1">
              <div class="file-name-text">{{ $tugas->file_original_name }}</div>
              <div class="file-hint">File tugas dari guru</div>
            </div>
            <a href="{{ asset('storage/' . $tugas->file_path) }}" download class="download-btn">⬇ Download</a>
          </div>
        @endif

        {{-- Nilai & Feedback (jika sudah dinilai) --}}
        @if($pengumpulan->nilai !== null)
          <div class="nilai-box">
            <div class="nilai-number">{{ $pengumpulan->nilai }}</div>
            <div>
              <div class="nilai-label" style="font-size:14px;font-weight:700;color:#166534;">Nilai Kamu</div>
              <div class="nilai-label">Diberikan oleh {{ optional($tugas->guru)->name }}</div>
            </div>
          </div>
          @if($pengumpulan->feedback_guru)
            <div class="feedback-box">
              <strong>💬 Feedback Guru:</strong><br>{{ $pengumpulan->feedback_guru }}
            </div>
          @endif
        @endif

      @endif
    </div>

    {{-- KANAN: FORM KUMPUL --}}
    <div class="submit-form">
      <div class="form-accent"></div>
      <div class="form-inner">
        <div class="form-header">
          <h3>Kumpulkan Tugas</h3>
          <p>Upload jawaban kamu di sini</p>
          <span class="status-badge status-{{ $pengumpulan->status }}">
            @if($pengumpulan->status === 'belum') 🔴 Belum Dikumpulkan
            @elseif($pengumpulan->status === 'proses') 🟡 Sudah Dikumpulkan
            @elseif($pengumpulan->status === 'sudah') ✅ Dinilai
            @else {{ $pengumpulan->status }}
            @endif
          </span>
        </div>

        <hr class="form-divider"/>

        @if(session('success'))
          <div class="alert alert-success">✅ {{ session('success') }}</div>
        @endif
        @if(session('error'))
          <div class="alert alert-error">⚠️ {{ session('error') }}</div>
        @endif
        @if($errors->any())
          <div class="alert alert-error">
            <strong>⚠️ Error:</strong>
            <ul style="margin:8px 0 0 20px">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
          </div>
        @endif

        @php $deadlinePast = \Carbon\Carbon::parse($tugas->tgl_pengumpulan)->isPast(); @endphp

        @if($pengumpulan->status !== 'belum')
          {{-- Sudah dikumpulkan --}}
          <div class="submitted-info">
            ✅ Kamu sudah mengumpulkan tugas ini pada<br>
            <strong>{{ optional($pengumpulan->dikumpulkan_at)->translatedFormat('d F Y, H:i') ?? '-' }}</strong>
            @if($pengumpulan->file_original_name)
              <div class="submitted-file">
                <span>📄</span>
                <span style="flex:1;font-size:12px;font-weight:600;word-break:break-all">{{ $pengumpulan->file_original_name }}</span>
                <a href="{{ asset('storage/' . $pengumpulan->file_path) }}" download style="font-size:12px;color:#2d52ff;font-weight:700;text-decoration:none;">⬇</a>
              </div>
            @endif
            @if($pengumpulan->catatan)
              <div style="margin-top:10px;font-size:12px;color:#374151;"><strong>Catatan:</strong> {{ $pengumpulan->catatan }}</div>
            @endif
          </div>
          @if($pengumpulan->status !== 'sudah')
            <a href="{{ route('siswa.edit-pengumpulan', $tugas->id) }}" class="edit-link">✏️ Edit / Ganti Jawaban →</a>
          @endif
        @else
          {{-- Belum dikumpulkan --}}
          @if($deadlinePast)
            <div class="deadline-passed">⏰ Deadline sudah lewat. Kamu tetap bisa mengumpulkan, namun akan tercatat sebagai terlambat.</div>
          @elseif(\Carbon\Carbon::parse($tugas->tgl_pengumpulan)->diffInDays(now()) <= 1 && \Carbon\Carbon::parse($tugas->tgl_pengumpulan)->isFuture())
            <div class="deadline-warning">⚠️ Deadline besok! Segera kumpulkan tugasmu.</div>
          @endif

          <form method="POST" action="{{ route('siswa.submit-tugas', $tugas->id) }}" enctype="multipart/form-data">
            @csrf
            <div class="form-field">
              <label class="form-label">File Jawaban *</label>
              <label for="file_jawaban" class="file-upload-box">
                <div class="file-upload-icon">📤</div>
                <div class="file-upload-text">Klik atau drag file ke sini</div>
                <div class="file-upload-hint">PDF, Word, Excel, PPT, gambar · maks 10MB</div>
                <input type="file" id="file_jawaban" name="file_jawaban" required
                  accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.zip,.jpg,.jpeg,.png"
                  onchange="updateFileName()"/>
              </label>
              <div id="file-selected-info" class="file-selected-info">
                ✓ <span id="file-name-display"></span> dipilih
              </div>
              @error('file_jawaban')<div style="color:#ef4444;font-size:12px;margin-top:6px;">{{ $message }}</div>@enderror
            </div>
            <div class="form-field">
              <label class="form-label">Catatan untuk Guru (Opsional)</label>
              <textarea name="catatan" placeholder="Tulis keterangan atau catatan untuk guru...">{{ old('catatan') }}</textarea>
              @error('catatan')<div style="color:#ef4444;font-size:12px;margin-top:6px;">{{ $message }}</div>@enderror
            </div>
            <button type="submit" class="btn-submit">🚀 Kumpulkan Sekarang</button>
            <button type="button" class="btn-cancel" onclick="history.back()">Batal</button>
          </form>
        @endif

      </div>
    </div>

  </div>
</div>

<script>
  function updateFileName() {
    const input = document.getElementById('file_jawaban');
    const info = document.getElementById('file-selected-info');
    const name = document.getElementById('file-name-display');
    if (input.files && input.files[0]) {
      name.textContent = input.files[0].name;
      info.style.display = 'block';
    } else {
      info.style.display = 'none';
    }
  }
</script>
</body>
</html>
