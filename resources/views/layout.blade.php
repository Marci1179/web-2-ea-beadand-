<!DOCTYPE html>
<html lang="hu">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>F1 Weboldal</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

  {{-- Navigáció --}}
  @include('header')

  {{-- Tartalom --}}
  <main>
    @yield('content')
  </main>

</body>
</html>
