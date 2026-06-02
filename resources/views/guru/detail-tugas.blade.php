<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SITUGAS — Detail Tugas Siswa</title>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
  <style>
    *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
    :root { --blue: #2d52ff; --blue-dark: #1a38cc; --sidebar-w: 210px; }
    html, body { height: 100%; font-family: 'Plus Jakarta Sans', sans-serif; background: #f0f4ff; }
    body { display: flex; min-height: 100vh; }

    /* Sidebar */
    .sidebar {
      width: var(--sidebar-w); min-height: 100vh;
      background-image: url('/assets/sidebarbg.jpg');
      background-size: cover; background-position: center;
      display: flex; flex-direction: column; padding: 28px 16px 24px;
      flex-shrink: 0; position: fixed; top: 0; left: 0; bottom: 0; z-index: 100;
    }
    .sidebar-logo { display: flex; align-items: center; justify-content: center; gap: 10px; margin-bottom: 18px; }
    .logo-icon { width: 38px; height: 35px; }
    .brand { font-size: 15px; font-weight: 800; color: #fff; letter-spacing: 1px; }
    .sidebar-divider { width: 100%; height: 1px; background: rgba(255,255,255,0.28); margin-bottom: 28px; }
    .nav-menu { display: flex; flex-direction: column; gap: 4px; width: 100%; }
    .nav-item {
      display: flex; align-items: center; gap: 11px; padding: 11px 16px;
      border-radius: 10px; color: rgba(255,255,255,0.75); font-size: 14px;
      font-weight: 600; text-decoration: none; transition: all 0.2s;
    }
    .nav-item svg { width: 19px; height: 19px; stroke: rgba(255,255,255,0.75); fill: none; }
    .nav-item:hover { background: rgba(255,255,255,0.13); color: #fff; }
    .nav-item.active { background: #fff; color: #2451d1; font-weight: 700; }
    .nav-item.active svg { stroke: #2451d1; }

    /* Main Content Layout */
    .main { margin-left: var(--sidebar-w); flex: 1; display: flex; flex-direction: column; min-height: 100vh; }
    .topbar {
      height: 64px; background: #fff; display: flex; align-items: center;
      justify-content: space-between; padding: 0 36px;
      border-bottom: 1px solid #e4eaf5; position: sticky; top: 0; z-index: 50;
    }
    .breadcrumb { display: flex; align-items: center; gap: 7px; font-size: 13px; color: #9aa5c4; font-weight: 500; }
    .breadcrumb a { color: #9aa5c4; text-decoration: none; }
    .breadcrumb a:hover { color: var(--blue); }
    .breadcrumb svg { width: 14px; height: 14px; stroke: #c5d0e8; fill: none; stroke-width: 2; }
    .breadcrumb-current { color: #1a2060; font-weight: 700; }

    .content { flex: 1; padding: 32px 36px; display: flex; flex-direction: column; gap: 20px; }

    /* Card Components */
    .card { background: #fff; border-radius: 16px; box-shadow: 0 2px 16px rgba(45,82,255,0.06); overflow: hidden; margin-bottom: 10px; }
    .card-header { padding: 24px 28px 20px; border-bottom: 1px solid #f0f2f8; }
    .card-header h2 { font-size: 20px; font-weight: 800; color: #0f1740; margin-bottom: 10px; }
    .card-header h3 { font-size: 16px; font-weight: 700; color: #1a2060; }
    
    .meta-row { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
    .badge { display: inline-block; padding: 3px 12px; border-radius: 999px; font-size: 12px; font-weight: 600; }
    .badge-blue { background: #e0e8ff; color: #2d52ff; }
    .badge-red  { background: #ffe5e5; color: #e05252; }
    .badge-green { background: #dcfce7; color: #166534; }
    .meta-plain { font-size: 13px; color: #555; font-weight: 500; }

    .card-body { padding: 20px 28px; font-size: 13.5px; color: #555; line-height: 1.8; }

    /* Form Elements */
    .form-group { margin-bottom: 18px; }
    .form-label { display: block; font-size: 13px; font-weight: 600; color: #1a2060; margin-bottom: 8px; }
    .form-control {
      width: 100%; padding: 11px 14px; border: 1.5px solid #dce4ff; border-radius: 8px;
      font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; color: #333; outline: none; transition: border-color 0.2s;
    }
    .form-control:focus { border-color: var(--blue); }
    
    /* Buttons */
    .btn-submit {
      padding: 11px 24px; background: var(--blue); color: #fff; border: none; border-radius: 8px;
      font-size: 13px; font-weight: 700; font-family: 'Plus Jakarta Sans', sans-serif; cursor: pointer; transition: background 0.2s;
    }
    .btn-submit:hover { background: var(--blue-dark); }
    
    .btn-danger-custom {
      padding: 11px 24px; background: #fff; color: #e05252; border: 1.5px solid #e05252; border-radius: 8px;
      font-size: 13px; font-weight: 700; font-family: 'Plus Jakarta Sans', sans-serif; cursor: pointer; transition: all 0.2s;
    }
    .btn-danger-custom:hover { background: #ffe5e5; }

    /* Flash Messages */
    .flash-success { background: #d1fae5; border: 1px solid #6ee7b7; color: #065f46; padding: 12px 20px; border-radius: 10px; font-size: 13.5px; font-weight: 600; margin-bottom: 5px; }
    .flash-error { background: #ffeeee; border: 1px solid #ffa3a3; color: #b91c1c; padding: 12px 20px; border-radius: 10px; font-size: 13.5px; font-weight: 600; margin-bottom: 5px; }
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
      <a href="/siswa/dashboard" class="nav-item">
        <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <rect x="3" y="3" width="7" height="7" rx="1.2"/><rect x="14" y="3" width="7" height="7" rx="1.2"/>
          <rect x="3" y="14" width="7" height="7" rx="1.2"/><rect x="14" y="14" width="7" height="7" rx="1.2"/>
        </svg>
        Dashboard
      </a>
      <a href="/siswa/tugas" class="nav-item active">
        <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
        </svg>
        Tugas Anda
      </a>
      <a href="/siswa/notifikasi" class="nav-item">
        <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/>
        </svg>
        Notifikasi
      </a>
    </nav>
  </aside>

  <div class="main">
    <header class="topbar">
      <div class="breadcrumb">
        <a href="{{ route('siswa.tugas') }}">Tugas</a>
        <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
        <span class="breadcrumb-current">{{ $tugas->judul }}</span>
      </div>
    </header>

    <div class="content">

      @if(session('success'))
        <div class="flash-success">✓ {{ session('success') }}</div>
      @endif
      @if(session('error'))
        <div class="flash-error">⚠ {{ session('error') }}</div>
      @endif

      <div class="card">
        <div class="card-header">
          <h2>{{ $tugas->judul }}</h2>
          <div class="meta-row">
            <span class="meta-plain">Mata Pelajaran: <b>{{ $tugas->mapel }}</b></span>
            <span class="badge badge-blue">Kelas {{ $tugas->kelas }}</span>
            <span class="badge badge-red">Deadline: {{ \App\Helpers\DateHelper::safeFormat($tugas->tgl_pengumpulan, 'd M Y') }}</span>
            <span class="badge" style="background:#e0e8ff;color:#2d52ff;">
              Diberikan: {{ \App\Helpers\DateHelper::safeFormat($tugas->tgl_pemberian, 'd M Y') }}
            </span>
          </div>
        </div>
        <div class="card-body">
          <p style="white-space: pre-line;">{{ $tugas->deskripsi ?? '(Tidak ada deskripsi tugas)' }}</p>
          
          @if($tugas->file_path)
            <div style="margin-top: 20px; padding: 16px; background: #f5f8ff; border: 1px solid #dce4ff; border-radius: 12px; display: flex; align-items: center; gap: 12px;">
              <div style="width: 32px; height: 32px; background: #e0e7ff; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 16px;">📄</div>
              <div style="flex: 1;">
                <div style="font-size: 13px; font-weight: 600; color: #2d52ff; word-break: break-all;">{{ $tugas->file_original_name ?? 'File_Materi_Tugas' }}</div>
              </div>
              <a href="{{ asset('storage/' . $tugas->file_path) }}" download style="padding: 8px 16px; background: #2d52ff; color: #fff; border: none; border-radius: 8px; font-size: 12px; font-weight: 600; cursor: pointer; text-decoration: none; display: inline-block;">
                Download Bahan
              </a>
            </div>
          @endif
        </div>
      </div>

      <div class="card">
        
        @if($pengumpulan)
          <div class="card-header">
            <h3>✓ Status: Sudah Dikumpulkan</h3>
          </div>
          <div class="card-body">
            <div style="background: #f0fdf4; border: 1px solid #bbf7d0; padding: 14px 20px; border-radius: 10px; margin-bottom: 20px; font-size: 13px; color: #166534;">
              Kamu telah mengumpulkan tugas ini pada: <b>{{ \Carbon\Carbon::parse($pengumpulan->waktu_pengumpulan)->format('d M Y H:i') }} WIB</b>
            </div>

            <div class="form-group">
              <label class="form-label">File yang Dikirim:</label>
              <div style="display: flex; align-items: center; gap: 10px;">
                <a href="{{ Storage::url($pengumpulan->file_path) }}" target="_blank" style="color: var(--blue); font-weight: 700; text-decoration: none; font-size: 13.5px;">
                   Lihat File Pengumpulan Anda
                </a>
              </div>
            </div>

            <div class="form-group">
              <label class="form-label">Keterangan Anda:</label>
              <p style="background: #f8f9fa; padding: 10px 14px; border-radius: 8px; border: 1px solid #eee; font-style: italic;">
                {{ $pengumpulan->keterangan ?? '(Tidak ada keterangan)' }}
              </p>
            </div>

            @if(!$tugas->isExpired())
              <hr style="border: 0; border-top: 1px solid #f0f2f8; margin: 24px 0;">
              
              <form action="{{ route('siswa.tugas.update', $pengumpulan->id) }}" method="POST" enctype="multipart/form-data" style="margin-bottom: 15px;">
                @csrf
                @method('PUT')
                <h4 style="font-size: 14px; color: #1a2060; margin-bottom: 12px;">Edit Pengumpulan Tugas</h4>
                
                <div class="form-group">
                  <label class="form-label">Ganti File (Kosongkan jika tidak ingin diubah)</label>
                  <input type="file" name="file_tugas" class="form-control">
                </div>

                <div class="form-group">
                  <label class="form-label">Ubah Keterangan Tambahan</label>
                  <textarea name="keterangan" class="form-control" rows="3">{{ $pengumpulan->keterangan }}</textarea>
                </div>

                <button type="submit" class="btn-submit">Simpan Perubahan</button>
              </form>

              <form action="{{ route('siswa.tugas.destroy', $pengumpulan->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pengiriman tugas ini? File lama akan dihapus.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-danger-custom"> Tarik & Batalkan Pengumpulan</button>
              </form>
            @else
              <div style="margin-top: 15px; font-size: 12.5px; color: #e05252; font-weight: 600;">
               Batas waktu pengumpulan sudah habis. Anda tidak dapat mengubah atau menarik tugas kembali.
              </div>
            @endif
          </div>

        @else
          <div class="card-header">
            <h3>Form Pengumpulan Tugas</h3>
          </div>
          <div class="card-body">
            
            @if(!$tugas->isExpired())
              <form action="{{ route('siswa.tugas.store', $tugas->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="form-group">
                  <label class="form-label">Pilih File Tugas <span style="color:red;">*</span></label>
                  <input type="file" name="file_tugas" class="form-control" required>
                  <small style="color: #9aa5c4; font-size: 11px; display:block; margin-top: 4px;">Format yang diperbolehkan: PDF, DOC, DOCX, ZIP, RAR (Max: 5MB)</small>
                </div>

                <div class="form-group">
                  <label class="form-label">Keterangan Tambahan (Opsional)</label>
                  <textarea name="keterangan" class="form-control" rows="3" placeholder="Tulis catatan atau pesan ke guru jika ada..."></textarea>
                </div>

                <button type="submit" class="btn-submit"> Kirim Tugas</button>
              </form>
            @else
              <div style="text-align: center; padding: 20px 0; color: #e05252; font-weight: 700; font-size: 14px;">
                 Waktu pengumpulan telah berakhir. Anda tidak dapat mengirimkan tugas ini lagi.
              </div>
            @endif

          </div>
        @endif

      </div>

    </div>
  </div>

</body>
</html>