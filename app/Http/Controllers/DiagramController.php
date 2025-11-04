<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DiagramController extends Controller
{
   
    public function index()
    {
        return view('diagram'); 
    }


    public function apiData()
    {
    
        $rows = DB::table('results')
            ->join('pilots', 'results.pilot_id', '=', 'pilots.id')
            ->select('pilots.name as pilot', DB::raw('COUNT(*) as wins'))
            ->where('results.place', 1)            
            ->groupBy('pilots.id', 'pilots.name')
            ->orderByDesc('wins')
            ->limit(10)
            ->get();

        $labels = $rows->pluck('pilot');
        $values = $rows->pluck('wins');

        return response()->json([
            'title'  => 'Pilótánkénti győzelmek – Top 10',
            'type'   => 'bar',
            'labels' => $labels,
            'values' => $values,
        ]);
    }
}
