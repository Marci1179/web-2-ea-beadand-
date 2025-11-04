@extends('layout')

@section('content')
<div class="cover">
  <h1>Regisztráció</h1>

  @if ($errors->any())
    <div class="alert error">
      @foreach ($errors->all() as $error)
        <div>{{ $error }}</div>
      @endforeach
    </div>
  @endif

  <div class="form-wrapper">
    <form method="POST" action="{{ route('register.post') }}" class="form">
      @csrf

      <div class="form-row">
        <label for="name">Név</label>
        <input type="text" id="name" name="name" value="{{ old('name') }}" required>
      </div>

      <div class="form-row">
        <label for="email">E-mail cím</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required>
      </div>

      <div class="form-row">
        <label for="password">Jelszó</label>
        <input type="password" id="password" name="password" required>
      </div>

      <div class="form-row">
        <label for="password_confirmation">Jelszó megerősítése</label>
        <input type="password" id="password_confirmation" name="password_confirmation" required>
      </div>

      <div class="form-actions">
        <button type="submit" class="btn primary">Regisztrálok</button>
        <a href="{{ route('login') }}" class="btn ghost">Már van fiókom</a>
      </div>
    </form>
  </div>
</div>
@endsection
