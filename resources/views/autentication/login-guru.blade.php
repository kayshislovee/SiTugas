<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }

  body {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'Segoe UI', sans-serif;
    overflow: hidden;
    background: #1a5fdb;
  }

  /* ── BACKGROUND ── */
  .bg {
    position: fixed;
    inset: 0;
    z-index: 0;
    background-image: url('/assets/login2.png');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
  }

  /* Ornamen daun/logo di kiri bawah (dekorasi svg inline) */
  

  /* ── CARD ── */
  .card {
    position: relative;
    z-index: 10;
    background: linear-gradient(160deg, #285FFF 0%, #93AFFF 45%, #FFFFFF 100%);
    border-radius: 10px;
    padding: 32px 28px 28px;
    width: 280px;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0;
  }

  /* Avatar lingkaran */
  .avatar { 
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: rgba(40, 95, 255, 0.15);
    border: 2px solid #285FFF;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 12px;
  }
  .avatar svg {
    width: 32px;
    height: 32px;
    fill: #ffffff;
  }

  h1 {
    color: #ffffff;
    font-size: 22px;
    font-weight: 600;
    letter-spacing: 0.5px;
    margin-bottom: 20px;
  }

  /* Form */
  .field {
    width: 100%;
    margin-bottom: 12px;
  }
  .field label {
    display: block;
    color: #ffffff;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 0.6px;
    margin-bottom: 5px;
  }
  .field input {
    width: 100%;
    padding: 10px 12px;
    border-radius: 8px;
    border: none;
    outline: none;
    font-size: 13px;
    color: #291888;
    background: #fff;
    transition: box-shadow 0.2s;
  }
  .field input::placeholder {
    color: #000000;
  }
  .field input:focus {
    box-shadow: 0 0 0 3px rgba(7, 7, 153, 0.38);
  }

  /* Button Masuk */
  .btn-masuk {
    width: 100%;
    padding: 11px;
    margin-top: 8px;
    border-radius: 10px;
    border: none;
    background: #1a4fcf;
    color: #fff;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    letter-spacing: 0.5px;
    transition: background 0.2s, transform 0.1s;
  }
  .btn-masuk:hover { background: #153fb0; }
  .btn-masuk:active { transform: scale(0.98); }

  /* Link guru */
  .link-guru {
    margin-top: 10px;
    font-size: 12px;
    color: rgba(255,255,255,0.85);
    text-decoration: none;
    cursor: pointer;
    transition: color 0.2s;
  }
  .link-guru:hover { color: #fff; text-decoration: underline; }
</style>
</head>
<body>

<div class="bg"></div>

<!-- Card Login -->
<div class="card">
  <!-- Avatar -->
  <div class="avatar">
    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
      <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
    </svg>
  </div>

  <h1>Login</h1>

  <div class="field">
    <label>NIS</label>
    <input type="text" placeholder="Masukan Nis Anda" />
  </div>

  <div class="field">
    <label>KATA SANDI</label>
    <input type="password" placeholder="Masukan Kata Sandi" />
  </div>

  <button class="btn-masuk">Masuk</button>
  <a class="link-guru">Login Sebagai Murid</a>
</div>

</body>
</html>