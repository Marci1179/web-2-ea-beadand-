<?php

namespace App\Http\Controllers;

use App\Models\Result;

class AdatbController extends Controller
{
    public function index()
    {
        // 3 tábla: results + pilots + grands_prix — 7 oszlop a view-nak
        $rows = Result::query()
            ->join('pilots as p', 'p.id', '=', 'results.pilot_id')
            ->join('grands_prix as gp', 'gp.id', '=', 'results.grand_prix_id')
            ->select([
                'gp.date       as gp_date',      // grands_prix
                'gp.name       as gp_name',      // grands_prix
                'gp.location   as gp_location',  // grands_prix
                'p.name        as pilot_name',   // pilots
                'p.nationality as pilot_nat',    // pilots
                'results.place as place',        // results
                'results.team  as team',         // results
            ])
            ->orderByDesc('gp.date')
            ->limit(100)
            ->get();

        return view('adatb', compact('rows'));
    }
}
