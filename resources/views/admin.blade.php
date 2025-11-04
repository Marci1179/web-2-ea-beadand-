@extends('layout')

@section('content')
<div class="cover">
  <h1>Admin vezérlőpult</h1>
  <p class="muted">Csak adminoknak – felhasználók és szerepkörök áttekintése.</p>

  <div class="hr"></div>

  <div class="form-card">
    <h2>Gyors statisztikák</h2>
    <div class="form-card__grid" style="display:grid;grid-template-columns:repeat(3,1fr);gap:14px">
      <div class="badge red">Összes felhasználó: <strong>{{ $totalUsers }}</strong></div>
      <div class="badge">Adminok: <strong>{{ $admins }}</strong></div>
      <div class="badge">Regisztrált látogatók: <strong>{{ $registered }}</strong></div>
    </div>
  </div>

  <div class="table-wrap">
    <table class="table">
      <caption>Felhasználók</caption>
      <thead>
        <tr>
          <th>#</th>
          <th>Név</th>
          <th>Email</th>
          <th>Szerep</th>
          <th>Regisztrált</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($users as $u)
        <tr>
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
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <div class="pagination-wrap">
    {{ $users->links() }}
  </div>
</div>
@endsection
