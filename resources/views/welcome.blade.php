<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SITUGAS — Pantau Tugasmu</title>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=Plus+Jakarta+Sans:wght@400;500;600&display=swap" rel="stylesheet"/>
  <style>
    *, *::before, *::after {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    :root {
      --blue:       #2d52ff;
      --blue-dark:  #1a38cc;
      --blue-mid:   #3b5fe8;
      --blue-light: #a8b8ff;
      --white:      #ffffff;
    }

    html, body {
      width: 100%;
      height: 100%;
      overflow: hidden;
    }

    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background: var(--blue);
      min-height: 100vh;
      position: relative;
    }

    /* ─── BACKGROUND GRADIENT ─── */
    .bg-gradient {
      position: fixed;
      inset: 0;
      z-index: 0;
      background:
        radial-gradient(ellipse 90% 65% at 50% 115%, #c8d4ff 0%, #7090ff 28%, #2d52ff 60%, #1a38cc 100%);
    }

    /* ─── BACKGROUND IMAGE ─── */
    .bg-image {
      position: fixed;
      inset: 0;
      z-index: 0;
      background-image: url('{{ asset("assets/homepage.png") }}');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
    }

    /* ─── WINGS ─── */
    /*
      Ganti <svg> di dalam .wing-left dan .wing-right
      dengan tag <img> yang mengarah ke asset kamu:
        <img src="assets/wing-left.png"  style="width:100%;height:100%;object-fit:contain;"/>
        <img src="assets/wing-right.png" style="width:100%;height:100%;object-fit:contain;"/>

      Atau gunakan CSS background-image:
        .wing-left  { background-image: url('assets/wing-left.png');  }
        .wing-right { background-image: url('assets/wing-right.png'); }
    */
    .wing-left,
    .wing-right {
      position: fixed;
      top: 50%;
      transform: translateY(-50%);
      width: 44%;
      height: 78%;
      z-index: 1;
      pointer-events: none;
      background-size: contain;
      background-repeat: no-repeat;
      background-position: center;
    }

    .wing-left  {
      left: -40px;
      animation: fadeSlideLeft 1s ease 0.1s forwards;
      opacity: 0;
    }
    .wing-right {
      right: -40px;
      animation: fadeSlideRight 1s ease 0.1s forwards;
      opacity: 0;
    }

    .wing-left  svg,
    .wing-right svg {
      width: 100%;
      height: 100%;
    }

    @keyframes fadeSlideLeft {
      from { opacity: 0; transform: translateY(-50%) translateX(-30px); }
      to   { opacity: 1; transform: translateY(-50%) translateX(0);     }
    }
    @keyframes fadeSlideRight {
      from { opacity: 0; transform: translateY(-50%) translateX(30px);  }
      to   { opacity: 1; transform: translateY(-50%) translateX(0);     }
    }

    /* ─── NAVBAR ─── */
    nav {
      position: relative;
      z-index: 20;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 16px 36px;
      margin: 20px 24px 0;
      background: rgba(255, 255, 255, 0.12);
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
      border: 1px solid rgba(255, 255, 255, 0.28);
      border-radius: 16px;
      animation: fadeDown 0.7s ease forwards;
      opacity: 0;
    }

    @keyframes fadeDown {
      from { opacity: 0; transform: translateY(-18px); }
      to   { opacity: 1; transform: translateY(0);     }
    }

    .nav-link {
      color: rgba(255, 255, 255, 0.88);
      text-decoration: none;
      font-size: 15px;
      font-weight: 500;
      letter-spacing: 0.2px;
      transition: color 0.2s;
    }
    .nav-link:hover { color: #fff; }

    /* ─── HERO ─── */
    .hero {
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      z-index: 10;
      text-align: center;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 14px;
      animation: fadeUp 0.9s 0.35s ease forwards;
      opacity: 0;
    }

    @keyframes fadeUp {
      from { opacity: 0; transform: translate(-50%, calc(-50% + 24px)); }
      to   { opacity: 1; transform: translate(-50%, -50%);              }
    }

    .hero h1 {
      font-family: 'Syne', sans-serif;
      font-size: clamp(40px, 5vw, 60px);
      font-weight: 800;
      color: var(--white);
      letter-spacing: -2px;
      line-height: 1;
      text-shadow: 0 6px 40px rgba(0, 0, 60, 0.2);
    }

    .hero p {
      font-size: clamp(12px, 1.2vw, 14px);
      color: rgba(255, 255, 255, 0.88);
      font-weight: 500;
      letter-spacing: 0.25px;
    }

    /* About button */
    .btn-about {
      margin-top: 4px;
      padding: 10px 32px;
      border-radius: 999px;
      border: 1.5px solid rgba(255, 255, 255, 0.7);
      background: transparent;
      color: var(--white);
      font-size: 15px;
      font-weight: 600;
      font-family: 'Plus Jakarta Sans', sans-serif;
      cursor: pointer;
      letter-spacing: 0.3px;
      transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
    }
    .btn-about:hover {
      background: rgba(255, 255, 255, 0.18);
      box-shadow: 0 4px 24px rgba(0, 0, 80, 0.15);
      transform: scale(1.04);
    }
    .btn-about:active { transform: scale(0.97); }
  </style>
</head>
<body>

  <!-- Background -->
  <div class="bg-gradient"></div>
  <div class="bg-image"></div>



  <!-- Navbar -->
  <nav>
    <a href="/" class="nav-link">Home</a>
    <a href="/login" class="nav-link">Login</a>
  </nav>

  <!-- Hero -->
  <div class="hero">
    <h1>SI   TUGAS</h1>
    <p>Pantau tugasmu, tuntaskan tepat waktu</p>
    <button class="btn-about" onclick="window.location.href='#about'">About</button>
  </div>

</body>
</html>