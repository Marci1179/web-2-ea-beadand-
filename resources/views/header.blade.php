<div class="cover">
  <img src="{{ asset('img/formaauto.png') }}" alt="formaauto" height="200">
</div>
<div class="navigation">
  <a href="/mainpage/fooldal">🏁 Főoldal</a>
  <a href="/mainpage/adatb">📊 Adatbázis</a>
  <a href="/mainpage/kapcsolat">📩 Kapcsolat</a>
  <a href="/mainpage/diagram">📈 Diagram</a>
  <a href="/mainpage/crud">⚙️ CRUD</a>

  @auth
    <a href="/mainpage/uzenet">💬 Üzenetek</a>
    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
      @csrf
      <button type="submit" class="btn ghost">Kijelentkezés ({{ auth()->user()->name }})</button>
    </form>
  @else
    <a href="{{ route('login') }}">🔑 Bejelentkezés</a>
    <a href="{{ route('register') }}">🆕 Regisztráció</a>
  @endauth
</div>
