<x-mainpage>
  <div class="lead">
    <h1>🏁 Adatbázis menü 🏁</h1>
    <p>Itt láthatók a három tábla (Pilots, Grand Prix, Results) adatai ORM-en keresztül.</p>
  </div>

  <div class="table-wrap">
    <table border="1" cellspacing="0" cellpadding="6" style="border-collapse: collapse; width: 100%;">
      <thead style="background-color: #f2f2f2;">
        <tr>
          <th>Dátum</th>
          <th>Futam neve</th>
          <th>Helyszín</th>
          <th>Pilóta</th>
          <th>Nemzetiség</th>
          <th>Csapat</th>
          <th>Motor</th>
          <th>Helyezés</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($rows as $r)
          <tr>
            <td>{{ optional($r->grandPrix)->date }}</td>
            <td>{{ optional($r->grandPrix)->name }}</td>
            <td>{{ optional($r->grandPrix)->location }}</td>
            <td>{{ optional($r->pilot)->name }}</td>
            <td>{{ optional($r->pilot)->nationality }}</td>
            <td>{{ $r->team }}</td>
            <td>{{ $r->engine }}</td>
            <td>{{ $r->place ?? '—' }}</td>
          </tr>
        @empty
          <tr>
            <td colspan="8" style="text-align:center; color: gray;">Nincs megjeleníthető adat az adatbázisban.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>


</x-mainpage>