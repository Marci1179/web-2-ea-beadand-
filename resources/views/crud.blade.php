<x-mainpage>
    <div class="lead">
        <h1>🏁 CRUD MENÜ 🏁</h1>
        <p>Itt a Pilóta (pilots) táblán végezhetsz CRUD műveleteket.</p>
    </div>

    @if(session('success'))
        <div class="alert success">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert error">
            <ul>@foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach</ul>
        </div>
    @endif

    {{-- Új pilóta felvitele --}}
    <section class="form-card">
        <h2>Új pilóta felvitele</h2>
        <form method="POST" action="{{ route('pilots.store', request()->query()) }}">
            @csrf
            <div class="form-row">
                <div class="field">
                    <label>Név <span class="req">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" required>
                </div>
                <div class="field">
                    <label>Nem (F/N) <span class="req">*</span></label>
                    <select name="gender" required>
                        <option value="">Válassz…</option>
                        <option value="N" @selected(old('gender')==='N')>N</option>
                        <option value="F" @selected(old('gender')==='F')>F</option>
                    </select>
                </div>
                <div class="field">
                    <label>Születési dátum <span class="req">*</span></label>
                    <input type="date" name="birth_date" value="{{ old('birth_date') }}" required>
                </div>
                <div class="field">
                    <label>Állampolgárság <span class="req">*</span></label>
                    <input type="text" name="nationality" value="{{ old('nationality') }}" required>
                </div>
                <div class="field">
                    <label>legacy_id</label>
                    <input type="number" name="legacy_id" value="{{ old('legacy_id') }}" placeholder="(opcionális)">
                </div>
            </div>
            <div class="form-actions">
                <button class="btn primary" type="submit">Hozzáadás</button>
            </div>
        </form>
    </section>

    {{-- Pilóták táblázata --}}
    <div class="table-wrap">
        <table class="table">
            <thead>
                <tr>
                    @php
                        $cols = [
                            'id' => 'ID',
                            'name' => 'Név',
                            'gender' => 'Nem',
                            'birth_date' => 'Születési dátum',
                            'nationality' => 'Állampolgárság',
                            'legacy_id' => 'legacy_id'
                        ];
                    @endphp
                    @foreach ($cols as $col => $label)
                        <th>
                            <a href="{{ route('pilots.index', array_merge(request()->query(), [
                                'sort' => $col,
                                'direction' => ($sort === $col && $direction === 'asc') ? 'desc' : 'asc'
                            ])) }}">
                                {{ $label }}
                                {!! $sort === $col ? ($direction === 'asc' ? '▲' : '▼') : '' !!}
                            </a>
                        </th>
                    @endforeach
                    <th>Műveletek</th>
                </tr>
            </thead>

            <tbody>
                @forelse($pilots as $p)
                    <tr>
                        <td>{{ $p->id }}</td>
                        <td>{{ $p->name }}</td>
                        <td>{{ $p->gender }}</td>
                        <td class="nowrap">{{ $p->birth_date?->format('Y-m-d') }}</td>
                        <td>{{ $p->nationality }}</td>
                        <td class="num">{{ $p->legacy_id }}</td>
                        <td class="actions">
                            <a class="btn ghost btn-small"
                               href="{{ route('pilots.index', array_merge(request()->query(), ['edit' => $p->id])) }}">
                                Szerkesztés
                            </a>
                            <form method="POST"
                                  action="{{ route('pilots.destroy', array_merge(request()->query(), ['pilot' => $p->id])) }}"
                                  style="display:inline"
                                  onsubmit="return confirm('Biztosan törlöd: {{ $p->name }} ?')">
                                @csrf @method('DELETE')
                                <button class="btn primary btn-small" type="submit">Törlés</button>
                            </form>
                        </td>
                    </tr>

                    {{-- Inline szerkesztés --}}
                    @if(optional($editing)->id === $p->id)
                        <tr class="edit-row">
                            <td colspan="7">
                                <form method="POST"
                                      action="{{ route('pilots.update', array_merge(request()->query(), ['pilot' => $p->id])) }}">
                                    @csrf @method('PUT')
                                    <div class="form-row">
                                        <div class="field">
                                            <label>Név *</label>
                                            <input type="text" name="name" value="{{ old('name', $p->name) }}" required>
                                        </div>
                                        <div class="field">
                                            <label>Nem *</label>
                                            <select name="gender" required>
                                                <option value="N" @selected(old('gender',$p->gender)==='N')>N</option>
                                                <option value="F" @selected(old('gender',$p->gender)==='F')>F</option>
                                            </select>
                                        </div>
                                        <div class="field">
                                            <label>Születési dátum *</label>
                                            <input type="date" name="birth_date"
                                                   value="{{ old('birth_date', optional($p->birth_date)->format('Y-m-d')) }}" required>
                                        </div>
                                        <div class="field">
                                            <label>Állampolgárság *</label>
                                            <input type="text" name="nationality" value="{{ old('nationality',$p->nationality) }}" required>
                                        </div>
                                        <div class="field">
                                            <label>legacy_id</label>
                                            <input type="number" name="legacy_id" value="{{ old('legacy_id',$p->legacy_id) }}">
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <button class="btn primary" type="submit">Mentés</button>
                                        @php
                                            $query = request()->query();
                                            unset($query['edit']);
                                        @endphp
                                        <a class="btn ghost" href="{{ route('pilots.index', $query) }}">Mégse</a>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @endif
                @empty
                    <tr><td colspan="7">Nincs adat.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Lapozó --}}
    <div class="pagination-wrap">
        {{ $pilots->onEachSide(1)->appends(request()->query())->links('vendor.pagination.f1') }}
    </div>
</x-mainpage>
