<x-mainpage>
    <div class="lead">
        <h1>🏁 Üzenetek menü 🏁</h1>
        <p>Ez itt az Üzenet menü, ahol a kapcsolat űrlapon elküldött üzenetek láthatók.</p>
    </div>

    @if($messages->count() === 0)
        <div class="alert info">Még nincs rögzített üzenet.</div>
    @else
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Dátum</th>
                        <th>Név</th>
                        <th>E-mail</th>
                        <th>Tárgy</th>
                        <th>Üzenet</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($messages as $m)
                        <tr>
                            <td class="nowrap">{{ $m->created_at->format('Y-m-d H:i') }}</td>
                            <td>{{ $m->name }}</td>
                            <td><a href="mailto:{{ $m->email }}">{{ $m->email }}</a></td>
                            <td>{{ $m->subject }}</td>
                            <td class="msg">{{ $m->message }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="pagination-wrap">
            {{ $messages->links() }}
        </div>
    @endif
</x-mainpage>
