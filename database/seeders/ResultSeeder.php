<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pilot;
use App\Models\GrandPrix;
use App\Models\Result;

class ResultSeeder extends Seeder
{
    public function run(): void
    {
        $lines = $this->readLines('data/eredmeny.txt', header: true);
        if (empty($lines)) {
            $this->command->warn('ResultSeeder: nincs betölthető sor.');
            return;
        }

        $count = 0;

        foreach ($lines as $rawCols) {
            // Oszlopok: datum, pilotaaz, helyezes, hiba, csapat, tipus, motor
            // - takarítás: NBSP -> space, trim, üresek nullra
            $cols = array_map(fn($c) => $this->clean($c), $rawCols);

            if (count($cols) < 2) continue;

            [$datum, $pilotaAz, $helyezes, $hiba, $csapat, $tipus, $motor] = array_pad($cols, 7, null);

            $date = $this->toDate($datum);
            if (!$date || $this->isEmpty($pilotaAz)) continue;

            // ha a 7. (motor) üres, vedd a sor utolsó nem üres mezőjét
            if ($this->isEmpty($motor)) {
                for ($i = count($cols) - 1; $i >= 0; $i--) {
                    if (!$this->isEmpty($cols[$i])) { $motor = $cols[$i]; break; }
                }
            }

            // Futam létrehozása / keresése (dátum alapján)
            $gp = GrandPrix::firstOrCreate(
                ['date' => $date],
                ['name' => 'Ismeretlen GP', 'location' => null]
            );

            // Pilóta létrehozása / keresése (legacy_id alapján)
            $pilot = Pilot::firstOrCreate(
                ['legacy_id' => (int)$pilotaAz],
                ['name' => 'Ismeretlen pilóta #'.$pilotaAz]
            );

            // Eredmény mentése
            Result::updateOrCreate(
                ['pilot_id' => $pilot->id, 'grand_prix_id' => $gp->id],
                [
                    'place'   => is_numeric($helyezes) ? (int)$helyezes : null,
                    'issue'   => $this->nullIfEmpty($hiba),
                    'team'    => $this->nullIfEmpty($csapat),
                    'chassis' => $this->nullIfEmpty($tipus),
                    'engine'  => $this->nullIfEmpty($motor),
                ]
            );

            $count++;
        }

        $this->command->info("ResultSeeder: {$count} sor feldolgozva.");
    }

    // Stabil fájlolvasás storage/app alól + automatikus UTF-8-ra konvertálás
    private function readLines(string $relative, bool $header = false): array
    {
        $path = storage_path('app/' . $relative);
        if (!file_exists($path)) {
            $this->command->error("Nincs meg a fájl: $path");
            return [];
        }

        $content = file_get_contents($path);
        if ($content === false || $content === '') {
            $this->command->warn("Üres a fájl: $path");
            return [];
        }

        $content = $this->toUtf8($content);

        // BOM eltávolítás
        $content = preg_replace('/^\xEF\xBB\xBF/', '', $content);

        // Sorokra bontás (Windows/Unix)
        $rows = preg_split('/\r\n|\r|\n/', trim($content));
        if ($header && $rows) array_shift($rows);

        // Tabulátor alapú oszlopokra bontás
        return array_map(
            fn($r) => preg_split('/\t+/', $r),
            array_filter($rows, fn($r) => trim($r) !== '')
        );
    }

    // Ha nem érvényes UTF-8, próbáljuk CP1250/ISO-8859-2/CP1252 kódolásból konvertálni
    private function toUtf8(string $content): string
    {
        if (function_exists('mb_check_encoding') && mb_check_encoding($content, 'UTF-8')) {
            return $content;
        }
        foreach (['CP1250','Windows-1250','ISO-8859-2','CP1252','Windows-1252','ISO-8859-1'] as $enc) {
            $converted = @iconv($enc, 'UTF-8//IGNORE', $content);
            if ($converted !== false && ($converted === '' || @mb_check_encoding($converted, 'UTF-8'))) {
                return $converted;
            }
        }
        return $content; // utolsó esély
    }

    private function toDate($s): ?string
    {
        $s = trim((string)$s);
        if ($s === '') return null;
        $s = str_replace('.', '-', $s);
        $s = rtrim($s, '-');
        $p = array_map('intval', explode('-', $s));
        return count($p) === 3 ? sprintf('%04d-%02d-%02d', $p[0], $p[1], $p[2]) : null;
    }

    private function nullIfEmpty($v): ?string
    {
        $v = trim((string)$v);
        return $v === '' ? null : $v;
    }

    private function clean(?string $v): ?string
    {
        if ($v === null) return null;
        // NBSP → space, többszörös whitespace összevonás, trim
        $v = str_replace("\xC2\xA0", ' ', $v);
        $v = preg_replace('/[ \t]+/u', ' ', $v);
        $v = trim($v);
        return $v === '' ? null : $v;
    }

    private function isEmpty($v): bool
    {
        return $v === null || trim((string)$v) === '';
    }
}
