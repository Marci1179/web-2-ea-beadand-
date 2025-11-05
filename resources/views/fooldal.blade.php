<x-mainpage>
  <section class="hero" style="text-align:center; padding:3rem 1rem;">
    <h1 style="font-size:2.25rem; margin-bottom:0.5rem;">🏎️ Üdvözlünk a cégünk főoldalán!</h1>
    <p style="max-width:900px; margin:0 auto; font-size:1.1rem; line-height:1.6;">
      Szenvedélyünk a technológia és a sport. A beadandónkhoz a <strong>Forma–1</strong>-es adatbázist választottuk,
      mert szeretjük ezt a sportot, és kiváló példát ad a nagy mennyiségű, valós idejű adatok kezelésére,
      vizualizációjára és elemzésére. Az oldalon bemutatjuk a cégünket, valamint a feladatokhoz készült megoldásainkat.
    </p>
  </section>

  <section class="about" style="max-width:1100px; margin:0 auto; padding:1rem;">
    <h2 style="margin-bottom:0.5rem;">Kik vagyunk?</h2>
    <p style="font-size:1rem; line-height:1.7; margin-bottom:1rem;">
      Csapatunk modern webes technológiákkal (például Laravel) épít megbízható, letisztult és gyors alkalmazásokat.
      Célunk, hogy az üzleti igényeket érthető funkciókká fordítsuk – mindezt átlátható kóddal és igényes felhasználói élménnyel.
    </p>
  </section>

  <section class="gallery" style="max-width:1200px; margin:0 auto; padding:1rem;">
    <h2 style="margin-bottom:0.5rem;">F1 pillanatok</h2>
    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(260px, 1fr)); gap:1rem;">
      <figure style="margin:0;">
        <img src="{{ asset('img/formakep1.jpg') }}" style="width:100%; height:220px; object-fit:cover; border-radius:12px;" loading="lazy">
      </figure>
      <figure style="margin:0;">
        <img src="{{ asset('img/formakep2.jpg') }}" style="width:100%; height:220px; object-fit:cover; border-radius:12px;" loading="lazy">
      </figure>
      <figure style="margin:0;">
        <img src="{{ asset('img/formakep3.jpg') }}" style="width:100%; height:220px; object-fit:cover; border-radius:12px;" loading="lazy">
      </figure>
    </div>
  </section>

  <section class="cta" style="text-align:center; padding:2rem 1rem;">
    <p style="font-size:1.05rem;">Nézd meg a menüben a megvalósított feladatokat és a hozzájuk tartozó oldalakat!</p>
  </section>
</x-mainpage>
