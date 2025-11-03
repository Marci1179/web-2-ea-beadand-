<div class="cover">
  <img src="{{ asset('img/formaauto.png') }}" alt="formaauto" height="200">
</div>
<div class="navigation">
<a class="{{ Request::is('mainpage/fooldal') ? 'active' : '' }}"
  href="/mainpage/fooldal">🏎️ Főoldal 🏎️</a>
<a class="{{ Request::is('mainpage/adatb') ? 'active' : '' }}"
  href="/mainpage/adatb">🏎️ Adatbázis menü 🏎️</a>
<a class="{{ Request::is('mainpage/kapcsolat') ? 'active' : '' }}"
  href="/mainpage/kapcsolat">🏎️ Kapcsolat menü 🏎️</a>
<a class="{{ Request::is('mainpage/uzenet') ? 'active' : '' }}"
  href="/mainpage/uzenet">🏎️ Üzenetek menü 🏎️</a>
<a class="{{ Request::is('mainpage/diagram') ? 'active' : '' }}"
  href="/mainpage/diagram">🏎️ Diagram menü 🏎️</a>
<a class="{{ Request::is('mainpage/crud') ? 'active' : '' }}"
  href="/mainpage/crud">🏎️ CRUD menü 🏎️</a>
</div>
