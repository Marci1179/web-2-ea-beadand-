<x-mainpage>
  <div class="lead">
    <h1>🏁 CRUD menü 🏁</h1>
    <p>Itt a CRUD menü, melyben a Pilóta táblán lehet végrehajtani a CRUD műveleteket.</p>
  </div>

  {{-- üzenetek --}}
  @if(session('success'))
    <div class="alert success">{{ session('success') }}</div>
  @endif
  @if ($errors->any())
    <div class="alert error">
      <ul>@foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach</ul>
    </div>
  @endif

  {{-- ÚJ PILÓTA FELVITELE --}}
  <section class="form-card">
    <h2>Új pilóta felvétele</h2>

    <form method="POST" action="{{ route('pilots.store') }}">
      @csrf

      <div class="form-row">
        <div class="field">
          <label for="name">Név <span class="req">*</span></label>
          <input id="name" type="text" name="name" value="{{ old('name') }}" placeholder="pl. Alain Prost" required>
          @error('name') <small class="error">{{ $message }}</small> @enderror
        </div>

        <div class="field">
          <label for="gender">Nem (F/N) <span class="req">*</span></label>
          <select id="gender" name="gender" required>
            <option value="">Válassz…</option>
            <option value="N" @selected(old('gender') === 'N')>N</option>
            <option value="F" @selected(old('gender') === 'F')>F</option>
          </select>
          @error('gender') <small class="error">{{ $message }}</small> @enderror
        </div>

        <div class="field">
          <label for="birth_date">Születési dátum <span class="req">*</span></label>
          <input id="birth_date" type="date" name="birth_date" value="{{ old('birth_date') }}" required>
          @error('birth_date') <small class="error">{{ $message }}</small> @enderror
        </div>

        <div class="field">
          <label for="nationality">Állampolgárság <span class="req">*</span></label>
          <input id="nationality" type="text" name="nationality" value="{{ old('nationality') }}"
            placeholder="pl. francia" required>
          @error('nationality') <small class="error">{{ $message }}</small> @enderror
        </div>

        <div class="field">
          <label for="legacy_id">legacy_id</label>
          <input id="legacy_id" type="number" name="legacy_id" value="{{ old('legacy_id') }}"
            placeholder="(opcionális)">
          @error('legacy_id') <small class="error">{{ $message }}</small> @enderror
        </div>
      </div>

      <div class="form-actions">
        <button class="btn primary" type="submit">Hozzáadás</button>
      </div>
    </form>
  </section>

  {{-- LISTA --}}
  <div class="table-wrap">
    <table class="table">
      <thead>
        <tr>
          <th>
            <a
              href="{{ route('pilots.index', ['sort' => 'id', 'direction' => $sort === 'id' && $direction === 'asc' ? 'desc' : 'asc']) }}">
              ID {!! $sort === 'id' ? ($direction === 'asc' ? '▲' : '▼') : '' !!}
            </a>
          </th>
          <th>
            <a
              href="{{ route('pilots.index', ['sort' => 'name', 'direction' => $sort === 'name' && $direction === 'asc' ? 'desc' : 'asc']) }}">
              Név {!! $sort === 'name' ? ($direction === 'asc' ? '▲' : '▼') : '' !!}
            </a>
          </th>
          <th>
            <a
              href="{{ route('pilots.index', ['sort' => 'gender', 'direction' => $sort === 'gender' && $direction === 'asc' ? 'desc' : 'asc']) }}">
              Nem {!! $sort === 'gender' ? ($direction === 'asc' ? '▲' : '▼') : '' !!}
            </a>
          </th>
          <th>
            <a
              href="{{ route('pilots.index', ['sort' => 'birth_date', 'direction' => $sort === 'birth_date' && $direction === 'asc' ? 'desc' : 'asc']) }}">
              Születési dátum {!! $sort === 'birth_date' ? ($direction === 'asc' ? '▲' : '▼') : '' !!}
            </a>
          </th>
          <th>
            <a
              href="{{ route('pilots.index', ['sort' => 'nationality', 'direction' => $sort === 'nationality' && $direction === 'asc' ? 'desc' : 'asc']) }}">
              Állampolgárság {!! $sort === 'nationality' ? ($direction === 'asc' ? '▲' : '▼') : '' !!}
            </a>
          </th>
          <th>
            <a
              href="{{ route('pilots.index', ['sort' => 'legacy_id', 'direction' => $sort === 'legacy_id' && $direction === 'asc' ? 'desc' : 'asc']) }}">
              legacy_id {!! $sort === 'legacy_id' ? ($direction === 'asc' ? '▲' : '▼') : '' !!}
            </a>
          </th>
          <th>Műveletek</th>
        </tr>
      </thead>
      <tbody>
        @forelse($pilots as $p)
          <tr>
            <td class="num">{{ $p->id }}</td>
            <td>{{ $p->name }}</td>
            <td>{{ $p->gender }}</td>
            <td class="nowrap">{{ $p->birth_date?->format('Y-m-d') }}</td>
            <td>{{ $p->nationality }}</td>
            <td class="num">{{ $p->legacy_id }}</td>
            <td class="nowrap">
              <a class="btn ghost" href="{{ route('pilots.index', ['edit' => $p->id]) }}">Szerkesztés</a>
              <form method="POST" action="{{ route('pilots.destroy', $p) }}" style="display:inline"
                onsubmit="return confirm('Biztosan törlöd: {{ $p->name }} ?')">
                @csrf @method('DELETE')
                <button class="btn primary" type="submit">Törlés</button>
              </form>
            </td>
          </tr>

          {{-- INLINE SZERKESZTÉS --}}
          @if(optional($editing)->id === $p->id)
            <tr>
              <td colspan="7">
                <form method="POST" action="{{ route('pilots.update', $p) }}">
                  @csrf @method('PUT')
                  <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:.75rem;">
                    <label> Név* <input type="text" name="name" value="{{ old('name', $p->name) }}" required> </label>
                    <label> Nem*
                      <select name="gender" required>
                        <option value="N" @selected(old('gender', $p->gender) === 'N')>N</option>
                        <option value="F" @selected(old('gender', $p->gender) === 'F')>F</option>
                      </select>
                    </label>
                    <label> Születési dátum*
                      <input type="date" name="birth_date"
                        value="{{ old('birth_date', optional($p->birth_date)->format('Y-m-d')) }}" required>
                    </label>
                    <label> Állampolgárság*
                      <input type="text" name="nationality" value="{{ old('nationality', $p->nationality) }}" required>
                    </label>
                    <label> legacy_id
                      <input type="number" name="legacy_id" value="{{ old('legacy_id', $p->legacy_id) }}">
                    </label>
                  </div>
                  <div class="form-actions">
                    <button class="btn primary">Mentés</button>
                    <a class="btn ghost" href="{{ route('pilots.index') }}">Mégse</a>
                  </div>
                </form>
              </td>
            </tr>
          @endif
        @empty
          <tr>
            <td colspan="7">Nincs adat.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="pagination-wrap">
    {{ $pilots->onEachSide(1)->links('vendor.pagination.f1') }}
  </div>
</x-mainpage>