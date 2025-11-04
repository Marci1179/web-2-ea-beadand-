@extends('layout')

@section('content')
<div class="cover">
  <h1>Bejelentkezés</h1>

  @if ($errors->any())
    <div class="alert error">
      @foreach ($errors->all() as $error)
        <div>{{ $error }}</div>
      @endforeach
    </div>
  @endif

  @if (session('success'))
    <div class="alert success">{{ session('success') }}</div>
  @endif

  <div class="form-wrapper">
    <form method="POST" action="{{ route('login.post') }}" class="form">
      @csrf

      <div class="form-row">
        <label for="email">E-mail cím</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required>
      </div>

      <div class="form-row">
        <label for="password">Jelszó</label>
        <input type="password" id="password" name="password" required>
      </div>

      <div class="form-row">
        <label>
          <input type="checkbox" name="remember"> Emlékezz rám
        </label>
      </div>

      <div class="form-actions">
        <button type="submit" class="btn primary">Belépek</button>
        <a href="{{ route('register') }}" class="btn ghost">Regisztráció</a>
      </div>
    </form>
  </div>
</div>
@endsection
