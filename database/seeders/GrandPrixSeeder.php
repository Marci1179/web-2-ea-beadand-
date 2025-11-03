<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GrandPrix;

class GrandPrixSeeder extends Seeder
{
    public function run(): void
    {
        $lines = $this->readLines('data/gp.txt', header: true);
        if (empty($lines)) {
            $this->command->warn('GrandPrixSeeder: nincs betölthető sor.');
            return;
        }

        $count = 0;
        foreach ($lines as $cols) {
            // oszlopok: datum, nev, helyszin
            if (count($cols) < 2) continue;

            [$datum, $nev, $helyszin] = array_pad($cols, 3, null);

            GrandPrix::updateOrCreate(
                ['date' => $this->toDate($datum), 'name' => $this->nullIfEmpty($nev)],
                ['location' => $this->nullIfEmpty($helyszin)]
            );
            $count++;
        }

        $this->command->info("GrandPrixSeeder: {$count} sor feldolgozva.");
    }

    /* ---------- Segédfüggvények (ugyanazok) ---------- */

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
        $content = preg_replace('/^\xEF\xBB\xBF/', '', $content);

        $rows = preg_split('/\r\n|\r|\n/', trim($content));
        if ($header && $rows) array_shift($rows);

        return array_map(
            fn($r) => preg_split('/\t+/', $r),
            array_filter($rows, fn($r) => trim($r) !== '')
        );
    }

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
        return $content;
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
}
