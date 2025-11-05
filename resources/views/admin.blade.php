@extends('layout')

@section('content')
@php
  // Rendezés / irány / aktuális oldal
  $sort = $sort ?? request('sort', 'id');
  $dir  = $dir  ?? request('dir',  'asc');
  $page = request('page', isset($users) ? $users->currentPage() : 1);

  // URL frissítés rendezés váltáskor
  $toggle = function($col) use ($sort, $dir, $page) {
      return request()->fullUrlWithQuery([
          'sort' => $col,
          'dir'  => ($sort === $col && $dir === 'asc') ? 'desc' : 'asc',
          'page' => $page,
      ]);
  };

  // Fejléc melletti kis nyíl (CRUD-minta)
  $arrow = function($col) use ($sort, $dir) {
      if ($sort !== $col) return '';
      return $dir === 'asc' ? '▲' : '▼';
  };
@endphp

<div class="cover">
  <h1>Admin vezérlőpult</h1>
  <p class="muted">Csak adminoknak – felhasználók és szerepkörök kezelése (inline szerkesztéssel).</p>

  @if (session('success'))
    <div class="alert success">{{ session('success') }}</div>
  @endif
  @if (session('error'))
    <div class="alert error">{{ session('error') }}</div>
  @endif
  @if ($errors->any())
    <div class="alert error">
      @foreach ($errors->all() as $e)
        <div>{{ $e }}</div>
      @endforeach
    </div>
  @endif

  <div class="hr"></div>

  {{-- Gyors statisztikák --}}
  <div class="form-card">
    <h2>Gyors statisztikák</h2>
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:14px">
      <div class="badge red">Összes felhasználó: <strong>{{ $totalUsers }}</strong></div>
      <div class="badge">Adminok: <strong>{{ $admins }}</strong></div>
      <div class="badge">Regisztrált látogatók: <strong>{{ $registered }}</strong></div>
    </div>
  </div>

  {{-- Felhasználók táblázat – rendezhető fejlécek, CRUD-nyilak --}}
  <div class="table-wrap">
    <table class="table">
      <caption>Felhasználók</caption>
      <thead>
        <tr>
          <th>
            <a href="{{ $toggle('id') }}">
              ID <span class="arrow">{!! $arrow('id') !!}</span>
            </a>
          </th>
          <th>
            <a href="{{ $toggle('name') }}">
              Név <span class="arrow">{!! $arrow('name') !!}</span>
            </a>
          </th>
          <th>
            <a href="{{ $toggle('email') }}">
              Email <span class="arrow">{!! $arrow('email') !!}</span>
            </a>
          </th>
          <th>
            <a href="{{ $toggle('role') }}">
              Szerep <span class="arrow">{!! $arrow('role') !!}</span>
            </a>
          </th>
          <th>
            <a href="{{ $toggle('created_at') }}">
              Regisztrált <span class="arrow">{!! $arrow('created_at') !!}</span>
            </a>
          </th>
          <th>Műveletek</th>
        </tr>
      </thead>

      <tbody>
      @foreach ($users as $u)
        {{-- MEGJELENÍTŐ SOR --}}
        <tr id="row-show-{{ $u->id }}">
          <td class="num">{{ $u->id }}</td>
          <td>{{ $u->name }}</td>
          <td class="muted">{{ $u->email }}</td>
          <td>
            @if($u->role === 'admin')
              <span class="badge red">admin</span>
            @elseif($u->role === 'user')
              <span class="badge">user</span>
            @else
              <span class="badge">visitor</span>
            @endif
          </td>
          <td class="muted">{{ $u->created_at?->format('Y-m-d H:i') }}</td>
          <td>
            <button class="btn primary" style="padding:.45rem .7rem"
                    onclick="toggleEdit({{ $u->id }}, true)">Szerkesztés</button>

            <form action="{{ route('admin.users.destroy', $u) }}?page={{ $page }}&sort={{ $sort }}&dir={{ $dir }}"
                  method="POST" style="display:inline"
                  onsubmit="return confirm('Biztosan törlöd: {{ $u->name }}?');">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn ghost" style="padding:.45rem .7rem">Törlés</button>
            </form>
          </td>
        </tr>

        {{-- SZERKESZTŐ SOR (INLINE) – CRUD-stílus: stackelt mezők + középre gombok --}}
        <tr id="row-edit-{{ $u->id }}" style="display:none;">
          <td class="num">{{ $u->id }}</td>
          <td colspan="4">
            <form method="POST"
                  action="{{ route('admin.users.update', $u) }}?page={{ $page }}&sort={{ $sort }}&dir={{ $dir }}"
                  id="form-{{ $u->id }}" class="form">
              @csrf
              @method('PUT')

              <div class="form-row">
                <label for="name-{{ $u->id }}">Név *</label>
                <input id="name-{{ $u->id }}" type="text" name="name" value="{{ old('name', $u->name) }}" required>
              </div>

              <div class="form-row">
                <label for="email-{{ $u->id }}">E-mail *</label>
                <input id="email-{{ $u->id }}" type="email" name="email" value="{{ old('email', $u->email) }}" required>
              </div>

              <div class="form-row">
                <label for="role-{{ $u->id }}">Szerepkör *</label>
                <select id="role-{{ $u->id }}" name="role" required>
                  <option value="visitor" {{ old('role',$u->role)==='visitor'?'selected':'' }}>visitor</option>
                  <option value="user"    {{ old('role',$u->role)==='user'?'selected':'' }}>user</option>
                  <option value="admin"   {{ old('role',$u->role)==='admin'?'selected':'' }}>admin</option>
                </select>
              </div>

              <div class="form-row">
                <label for="pwd-{{ $u->id }}">Új jelszó (opcionális)</label>
                <input id="pwd-{{ $u->id }}" type="password" name="password" placeholder="Ha üres, marad a régi">
              </div>

              <div class="form-actions">
                <button type="submit" class="btn primary">Mentés</button>
                <button type="button" class="btn ghost" onclick="toggleEdit({{ $u->id }}, false)">Mégse</button>
              </div>
            </form>
          </td>
          <td></td>
        </tr>
      @endforeach
      </tbody>
    </table>
  </div>

  <div class="pagination-wrap">
    {{ $users->appends(['sort'=>$sort,'dir'=>$dir])->links() }}
  </div>
</div>

{{-- Inline szerkesztés – egyszerre csak egy sor legyen nyitva --}}
<script>
  function closeAllEditors() {
    document.querySelectorAll('[id^="row-edit-"]').forEach(function(row){
      row.style.display = 'none';
    });
    document.querySelectorAll('[id^="row-show-"]').forEach(function(row){
      row.style.display = '';
    });
  }
  function toggleEdit(id, toEdit) {
    const showRow = document.getElementById('row-show-' + id);
    const editRow = document.getElementById('row-edit-' + id);
    if (!showRow || !editRow) return;

    if (toEdit) {
      closeAllEditors(); // CRUD-minta: mindig csak egy nyitott szerkesztő
      showRow.style.display = 'none';
      editRow.style.display = '';
      const firstInput = editRow.querySelector('input, select, textarea');
      if (firstInput) setTimeout(() => firstInput.focus(), 0);
    } else {
      editRow.style.display = 'none';
      showRow.style.display = '';
    }
  }
</script>
@endsection
