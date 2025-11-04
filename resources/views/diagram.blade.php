<x-mainpage>
    <div class="lead">
        <h1>🏁 Diagram menü 🏁</h1>
        <p>Ez itt a diagram menü, ahol az adatbázis adatait felhasználva, győzelmek száma alapján a legjobb 10 versenyző jelenik meg.</p>
    </div>

    <div class="chart-wrap">
        <canvas id="f1Chart"></canvas>
    </div>

    {{-- Chart.js CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>

    <script>
      (async () => {
        const res = await fetch('{{ route('diagram.data') }}', { headers: { 'Accept': 'application/json' }});
        const data = await res.json();

        const ctx = document.getElementById('f1Chart').getContext('2d');

        new Chart(ctx, {
          type: data.type ?? 'bar',
          data: {
            labels: data.labels,
            datasets: [{
              label: data.title,
              data: data.values,
              borderWidth: 2,
              borderColor: 'rgba(225,6,0,1)',
              backgroundColor: 'rgba(225,6,0,0.35)',
              tension: .25,
              pointRadius: 3
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
              legend: { labels: { color: '#fff' } },
              title: { display: true, text: data.title, color: '#fff' }
            },
            scales: {
              x: { ticks: { color: '#ddd' }, grid: { color: 'rgba(255,255,255,.06)' } },
              y: { beginAtZero: true, ticks: { color: '#ddd' }, grid: { color: 'rgba(255,255,255,.06)' } }
            }
          }
        });
      })();
    </script>
</x-mainpage>
