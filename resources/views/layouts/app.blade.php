<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SITUGAS</title>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
  @stack('styles')
</head>
<body>

  {{-- Sidebar otomatis pilih guru/siswa berdasarkan role --}}
  @if(auth()->user()->role === 'guru')
    @include('partials.sidebar-guru')
  @else
    @include('partials.sidebar-siswa')
  @endif

  <div class="main">
    @yield('content')
  </div>

  @stack('scripts')
</body>
</html>