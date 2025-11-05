<x-mainpage>
<div class="lead">
  <h1>🏁 Adatbázis menü 🏁</h1>
  <p>Az alábbi <strong>7 oszlop</strong> mindhárom táblából tartalmaz mezőt:
     <span class="badge red">grands_prix</span> (date, name, location),
     <span class="badge red">pilots</span> (name, nationality),
     <span class="badge red">results</span> (place, team).
  </p>
</div>

<div class="table-wrap">
  <table class="table">
    <thead>
      <tr>
        <th>GP dátum</th>   {{-- grands_prix.date --}}
        <th>GP neve</th>    {{-- grands_prix.name --}}
        <th>Helyszín</th>   {{-- grands_prix.location --}}
        <th>Pilóta</th>     {{-- pilots.name --}}
        <th>Nemzetiség</th> {{-- pilots.nationality --}}
        <th>Helyezés</th>   {{-- results.place --}}
        <th>Csapat</th>     {{-- results.team --}}
      </tr>
    </thead>
    <tbody>
      @foreach ($rows as $r)
        <tr>
          <td>
            @php
              // Biztonságos formázás: ha nem parse-olható, kiírjuk az eredetit
              try { echo \Illuminate\Support\Carbon::parse($r->gp_date)->format('Y.m.d'); }
              catch (\Throwable $e) { echo e($r->gp_date); }
            @endphp
          </td>
          <td>{{ $r->gp_name }}</td>
          <td>{{ $r->gp_location }}</td>
          <td>{{ $r->pilot_name }}</td>
          <td>{{ $r->pilot_nat ?? '—' }}</td>
          <td class="num">{{ $r->place ?? '—' }}</td>
          <td>{{ $r->team ?? '—' }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>

</x-mainpage>