<x-mainpage>
  <div class="lead">
    <h1>🏁 Kapcsolat menü 🏁</h1>
    <p>Ez itt a Kapcsolat menü, amin keresztül üzenetet lehet küldeni az oldal tulajdonosa számára.</p>
  </div>


  @if(session('success'))
    <div class="alert success">{{ session('success') }}</div>
  @endif

  @if ($errors->any())
    <div class="alert error">
      <strong>Hoppá!</strong> Kérlek javítsd az alábbi hibákat:
      <ul>
        @foreach ($errors->all() as $e)
          <li>{{ $e }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="form-wrapper">
    <form method="POST" action="{{ route('kapcsolat.store') }}" class="form">
      @csrf

      <div class="form-row">
        <label for="name">Név *</label>
        <input type="text" id="name" name="name" value="{{ old('name') }}" maxlength="100" required>
        @error('name')<small class="field-error">{{ $message }}</small>@enderror
      </div>

      <div class="form-row">
        <label for="email">E-mail *</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" maxlength="150" required>
        @error('email')<small class="field-error">{{ $message }}</small>@enderror
      </div>

      <div class="form-row">
        <label for="subject">Tárgy</label>
        <input type="text" id="subject" name="subject" value="{{ old('subject') }}" maxlength="150"
          placeholder="(opcionális)">
        @error('subject')<small class="field-error">{{ $message }}</small>@enderror
      </div>

      <div class="form-row">
        <label for="message">Üzenet *</label>
        <textarea id="message" name="message" rows="6" required>{{ old('message') }}</textarea>
        @error('message')<small class="field-error">{{ $message }}</small>@enderror
      </div>

      <div class="form-actions">
        <button type="submit" class="btn primary">Küldés</button>
      </div>
    </form>
  </div>

</x-mainpage>